<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\CampaignPrecheck;
use App\Models\Subscriptions;
use Auth;
use App\Classes\Fastspring;
use App\Models\User;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use SoapBox\Formatter\Formatter;

class UserController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth', ['except' => ['checkDomain', 'customSubscription', 'customEmail']]);
	}

	/**
	 * Show dashboard
	 *
	 * @return Response
	 */
	public function showDashboard()
	{
        $totals = [];
        if(Campaign::where('user_id', auth()->id())->count() > 0) $totals = Campaign::dashboard_totals();

		$show_info = true;
		if(Auth::user()->is_admin || Subscriptions::where('user_id', Auth::id())->where('is_active', 1)->count()) $show_info = false;

		return view('user.dashboard', ['totals' => $totals, 'show_info' => $show_info]);
	}

    /**
     * Show settings
     *
     * @param int $id
     * @return Response
     */
	public function showSettings($id=0)
	{
		return view('user.settings', ['user' => User::findOrFail($id ?: Auth::user()->id)]);
	}

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProfile()
	{
		return view('user.profile', ['user' => User::findOrFail(Auth::user()->id)]);
	}


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSubscription()
	{
        $plan = Subscriptions::where(['user_id' => Auth::id(), 'is_active' => 1])->pluck('id', 'plan')->toArray();

		return view('user.subscription', [
		    'user' => Auth::user(),
            'plan' => $plan
        ]);
	}

	public function doSubscription(Fastspring $fastspring, $plan='')
    {
        /** @var User $user */
        $user = User::findOrFail(Auth::user()->id);

        $url = $fastspring->createSubscription($plan, $user->id);

        return Response::make('', 302)->header('Location', $url);
    }

    public function changeSubscriptionPlan($plan)
    {
        // create new subscription. previous is canceled automatically.
        $this->doSubscription($plan);
    }

    public function cancelSubscription(Fastspring $fastspring, $plan)
    {
        $fastspring->cancelSubscriptionB($plan);

        $model = Subscriptions::find($plan);
        if($model) $model->deactivate_subscription();

        return back();
    }


	public function storeProfile(Request $request)
	{
		$user = User::findOrFail(Auth::user()->id);

		$this->validate($request, [
		    'name' => 'required|min:3',
            'paypal_email' => 'email'
        ]);

        $input = $request->all();
        $user->name = $input['name'];
        $user->paypal_email = $input['paypal_email'];
        $user->save();

        return redirect('profile')->with('status', 'Profile updated!');
	}

	public function storePassword(Request $request)
	{
		$user = User::findOrFail(Auth::user()->id);

		$this->validate($request, ['new_password' => 'required|confirmed|min:6']);

        $input = $request->all();
        $user->password = bcrypt($input['new_password']);
        $user->save();

        return redirect('profile')->with('status', 'Password updated!');
	}


    /**
     * Add backlinks for share
     */
    public function ssb()
    {
        /** @var User $user */
        $user = \Auth::user();
        if($user->ssb) return;
        $user->backlinks += 500;
        $user->ssb = 1;
        $user->save();
        return 1;
    }

    /**
     * Let user download csv for multiple camaigns
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function csvs(Request $request)
    {
        $campaigns = \DB::select("
        SELECT c.url,c.citation_flow,c.trust_flow,cp.IndexedURLs, count(cb.id) AS total,
          SUM(IF(total_rank > 60 AND total_rank < 86, 1, 0)) AS bad,
          SUM(IF(total_rank > 85, 1, 0)) AS critical,
          any_value(ts.social_rank) AS social_rank,
          avg(cb.link_rank) AS link_rank
        FROM campaigns c LEFT JOIN campaign_precheck cp on cp.campaign_id=c.id INNER JOIN campaign_backlinks cb on cb.campaign_id=c.id
          LEFT JOIN target_social ts on ts.campaign_id=c.id and (ts.domain like CONCAT('%', c.url) or ts.domain like CONCAT('%', c.url, '/'))
        WHERE c.id in (".$request->input('ids').") GROUP BY c.id, cp.IndexedURLs");

        $result = [];

        foreach($campaigns as $campaign) {
            if(!$campaign->IndexedURLs) $campaign->IndexedURLs = $campaign->total;

            $total              = (int)$campaign->total;
            $bad                = (int)$campaign->bad;
            $critical           = (int)$campaign->critical;
            $suspicios = $bad + $critical;

            $bad_percent        = $total ? (float)round(($bad / $total) * 100, 2) : 0;
            $critical_percent   = $total ? (float)round(($critical / $total) * 100, 2) : 0;
            $penalty_risk       = ($bad_percent + $critical_percent * 3);
            if($penalty_risk > 85) $penalty_risk = 85.00;

            $result[] = [
                'Domain' => $campaign->url,
                'TF' => $campaign->trust_flow,
                'CF' => $campaign->citation_flow,
                'Backlinks' => $total,
                'Spammy Backlinks' => $suspicios,
                'Social Engage' => $campaign->social_rank,
                'Average Link Infulence' => number_format($campaign->link_rank, 2),
                'Indexed URLs' => $campaign->IndexedURLs,
                'Penalty Risk' => "$penalty_risk%"
            ];
        }

        $formatter = Formatter::make(array_values($result), Formatter::ARR);

        $csv = $formatter->toCsv();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="report-campaigns.csv"'
        ];

        return response()->make($csv, 200, $headers);
    }


    public function checkDomain(Request $request)
    {
        //11/9/17 @Bogdan
        $input = $request->all();
        $domain = str_replace(['https://www.','http://www.','https://','http://'], '', rtrim($request->url,"/"));
        $input['url'] = 'http://'.$domain;
        $request->replace($input);
        $this->validate($request, ['url' => 'url']);

        // precheck
        $api = (new \App\Classes\MajesticAPI([
            'url'           => $domain,
            'method'        => 'GetIndexItemInfo'
        ]))->indexItemInfo();

        $item = $api->DataTables->Results->Data[0];
        $backlinks = $item->ExtBackLinks;

        // error - majestic insufficient funds
        if($api->Code == 'InsufficientIndexItemInfoUnits') {
            return response()->json([
                'error' => 'Demo function is not available at this moment.',
            ], 422);
        }
        if($item->Status != 'Found') {
            return response()->json([
                'error' => 'Wrong URL provided, please enter a valid URL.',
            ], 422);
        }
        if($backlinks <= 1) {
            return response()->json([
                'error' => 'We could not find any backlinks for the url provided, can not start campaign.',
            ], 422);
        }

        if($request->period == 'month') {
            $price = '9,99';
            $sub_text = '14 days trial';
            $product = 'linkquidator-s-plan';
            if($backlinks > 5000 && $backlinks <= 50000) {
                $price = '14,99';
                $product = 'linkquidator-s-1-plan';
            }
            elseif($backlinks > 50000 && $backlinks <= 100000) {
                $price = '24,99';
                $product = 'linkquidator-s-2-plan';
            }
            elseif($backlinks > 100000 && $backlinks <= 200000) {
                $price = '39,99';
                $product = 'linkquidator-s-3-plan';
            }
            elseif($backlinks > 200000 && $backlinks <= 500000) {
                $price = '59,99';
                $product = 'linkquidator-s-4-plan';
            }
            elseif($backlinks > 500000 && $backlinks <= 1000000) {
                $price = '99,99';
                $product = 'linkquidator-s-5-plan';
            }
            elseif($backlinks > 1000000) {
                $price = '179,99';
                $product = 'linkquidator-s-6-plan';
            }
        }else {
            $price = '99,99';
            $sub_text = '14 days trial';
            $product = 'linkquidator-s-annual-plan';
            if($backlinks > 5000 && $backlinks <= 50000) {
                $price = '149,99';
                $product = 'linkquidator-s-1-annual-plan';
            }
            elseif($backlinks > 50000 && $backlinks <= 100000) {
                $price = '249,99';
                $product = 'linkquidator-s-2-annual-plan';
            }
            elseif($backlinks > 100000 && $backlinks <= 200000) {
                $price = '399,99';
                $product = 'linkquidator-s-3-annual-plan';
            }
            elseif($backlinks > 200000 && $backlinks <= 500000) {
                $price = '599,99';
                $product = 'linkquidator-s-4-annual-plan';
            }
            elseif($backlinks > 500000 && $backlinks <= 1000000) {
                $price = '999,99';
                $product = 'linkquidator-s-5-annual-plan';
            }
            elseif($backlinks > 1000000) {
                $price = '1799,00';
                $product = 'linkquidator-s-6-annual-plan';
            }
        }

        if($backlinks > 10000 && $request->period == 'month') $sub_text = 'per month';
        elseif($backlinks > 10000 && $request->period == 'year') $sub_text = 'per year';


        return ['backlinks' => $backlinks, 'price' => $price, 'sub_text' => $sub_text, 'item' => $item, 'product' => $product, 'url' => $domain];
    }

    public function customSubscription(Request $request)
    {

        $item = (object)$request->get('precheck');
        $url = $item->Item;

        // check if user has a demo with same url.
        $campaign_id = Campaign::where('is_demo', 1)->where('user_id', auth()->id())->where('url', $url)->orderBy('id', 'desc')->pluck('id')->first();

        if($campaign_id) { // then we have the campaign_id, and we prepare that campaign for recheck.
            $campaign = Campaign::find($campaign_id);

            \DB::table('campaign_anchors')->where('campaign_id', $campaign_id)->delete();
            \DB::table('campaign_backlinks')->where('campaign_id', $campaign_id)->delete();
            \DB::table('campaign_domains')->where('campaign_id', $campaign_id)->delete();
            \DB::table('campaign_precheck')->where('campaign_id', $campaign_id)->delete();
            \DB::table('target_social')->where('campaign_id', $campaign_id)->delete();
            \DB::table('topical_trust_targets')->where('campaign_id', $campaign_id)->delete();
            \DB::table('domain_social')->where('campaign_id', $campaign_id)->delete();

            $campaign->is_demo=0;
            $campaign->start();

            CampaignPrecheck::store($campaign, $item);

            return ['campaign_id' => $campaign_id];
        }


        $campaign = new Campaign();
        $campaign->user_id = auth()->id();
        $campaign->url = $url;
        $campaign->is_demo = 0; // Chaged 10/11/17 because this should be an oppen campaign.
        $campaign->ip = $_SERVER['REMOTE_ADDR'];
        $campaign->stage_status = 2;
        $campaign->trust_flow = $item->TrustFlow;
        $campaign->citation_flow = $item->CitationFlow;
        $campaign->start();

        CampaignPrecheck::store($campaign, $item);

        return ['campaign_id' => $campaign->id];
    }


    /**
     * Sends email with custom subscription.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function customEmail(Request $request)
    {
        $date = date('m/d/Y');
        $user = auth()->user();
        \Mail::send('emails.custom_subscription', [
            'date'          => $date,
            'user_id'	    => $user->id,
            'user_email' => $user->email,
            'domains_count'			=> $request->domains_count,
            'backlinks_count'		=> $request->backlinks_count,
            'description'		=> $request->description,
        ], function ($m) use ($date) {
            $m->from(config('mail.from.address'));
            $m->to('info@backlinkcontrol.com');//info@backlinkcontrol.com
            $m->subject('Custom Subscription Linkquidator '.$date);
        });

        return back();
    }


    public function notifications()
    {
        return view('user.notifications', []);
    }

}