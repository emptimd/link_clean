<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignBacklink;
use App\Models\CampaignPrecheck;
use App\Models\CampaignSubscriber;
use App\Classes\MajesticAPI;
use App\Models\GoogleAnalitycs;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;

class DemoController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, ['url' => 'url']);
        $url = str_replace(['https://www.','http://www.','https://','http://'], '', rtrim($request->url,"/"));
        $input = $request->all();

        $demo_count = Campaign::where('ip', $request->ip())
            ->where('created_at', '>', Carbon::now()->subDays(7)->toDateTimeString())
            ->count();

        if($demo_count > 3) return redirect('/')->with('error', "Sorry, you've exceeded Demo limit for the past 7 days. Try again later or register!");

        if (!Auth::guest()) return redirect('admin')->with('error', 'Unauthorized action.');

        // precheck
        $api = (new MajesticAPI([
            'url'           => $url,
            'method'        => 'GetIndexItemInfo'
        ]))->indexItemInfo();

        $item = $api->DataTables->Results->Data[0];

        // error - majestic insufficient funds
        if($api->Code == 'InsufficientIndexItemInfoUnits') return redirect('/')->with('error', 'Demo function is not available at this moment.');
        if($item->Status != 'Found') return redirect('/')->with('error', 'Wrong URL provided, please enter a valid URL.');
        if($item->ExtBackLinks <= 1) return redirect('/')->with('error', "We could not find any backlinks for the url provided, can not start campaign.");

        /** @var User $user */
        $user = User::whereEmail($input['email'])->first();

        if(!$user) {
            $user = User::create([
                'name' => $input['email'],
                'email' => $input['email'],
                'password' => bcrypt($input['password']),
            ]);

            Auth::login($user, true);
        }elseif(!Auth::attempt(['email' => $input['email'], 'password' => $input['password']], true))
            return redirect('/')->with('error', "Wrong password.");


        // Check if majestic returned ok, then we create the campaign.
        $campaign = new Campaign();
        $campaign->user_id = $user->id; // demo user
        $campaign->url = $url;
        $campaign->is_demo = 1;
        $campaign->ip = $_SERVER['REMOTE_ADDR'];
        $campaign->stage_status = 2;
        $campaign->trust_flow = $item->TrustFlow;
        $campaign->citation_flow = $item->CitationFlow;
        $campaign->start();

        CampaignPrecheck::store($campaign, $item);
        CampaignSubscriber::create([
            'campaign_id' => $campaign->id,
            'email' => $input['email']
        ]);

        if($item->ExtBackLinks > 50000)
            $this->dispatch(new \App\Jobs\CampaignBacklinksGet($campaign->id, 10000));
        else
            $this->dispatch(new \App\Jobs\CampaignBacklinksGet($campaign->id, 50000));

        return redirect('campaign/' . $campaign->id);
    }

    public function showNew($id=0)
    {
        /** @var Campaign $campaign*/
        $campaign = Campaign::where('id', $id)->with(['author' => function($query) {
            $query->select(['id', 'name', 'email']);
        }])->first();

        if(!$campaign) return redirect('/admin');

        $totals = $campaign->totals_new_campaign_show();
        // so we must send google analytics data (if we have it)
        $analitycs = GoogleAnalitycs::where('campaign_id', $id)->orderBy('id', 'desc')->first();

        JavaScriptFacade::put([
            'super' 	=> 50,
            'medium' 	=> 100,
            'bad'		=> 10,
            'critical'	=> 5,
            'is_finished' => $campaign->is_finished(),
            'pie'       => [
                ['High', $totals->super],
                ['Medium', $totals->medium],
                ['Low', $totals->bad],
                ['Critical', $totals->critical],
            ],
        ]);

        $target_pages = $campaign->getBacklinks()->selectRaw('count(id) as c, TargetURL')->orderBy('c', 'desc')->groupBy('TargetURL')->limit(4)->get();

        $precheck = $campaign->getPrecheck()->first(['ExtBackLinks']);
        $total_backlinks = $precheck ? $precheck->ExtBackLinks : '?';

        //11/14/17 show bad + critical backlinks (max 30.)
        $campaign_backlinks = CampaignBacklink::from('campaign_backlinks AS t1')
            ->select(['t1.id', 't1.SourceURL', 't1.total_rank', 't1.TargetURL', 't1.FlagNoFollow', 'cd.TrustFlow', 'cd.CitationFlow', 't1.referral_influence', 't1.views', 'cd.country', 'cd.ip', 't1.http_code', 'ds.social_rank', 't1.FirstIndexedDate', 't1.paid', 't1.is_disabled'])
            ->leftJoin('campaign_domains as cd', function($q)
            {
                $q->on('cd.id', '=', 't1.domain_id');
            })
            ->leftJoin('domain_social as ds', function($q)
            {
                $q->on('ds.id', '=', 't1.domain_id');
            })
            ->where('t1.campaign_id', '=', $id)
            ->where('t1.total_rank', '>', 60)
            ->take(30)
            ->get();

        $rows = [];

        foreach($campaign_backlinks as $b) {
            $rank = Campaign::rank_backlink($b->total_rank);
            $flag = $b->country?strtolower($b->country):"generic";

            $rows[] = [
                '<div class="source-url">'.$b->SourceURL.'</div><span class="sourcer-url-span"></span>',
                '<span class="' . Campaign::rank_backlink_badge_class($rank) . '">' . $rank . '</span> ', // Quality
                $b->FlagNoFollow ? '<i class="fa fa-check"></i>' : '',
                $b->TrustFlow,
                $b->CitationFlow,
                $b->referral_influence.$b->getRefRankDif(), // referral influence
                $b->views,
                '<i class="flag flag--exclusive flag-'.$flag.'" title="'.long2ip($b->ip).'"></i>',
                $b->social_rank, // social rank
                $b->FirstIndexedDate,
                '<a href="' . '/campaign/' . $id . '/' . $b->id . '" class="btn btn-info btn-xs">details</a>',
            ];
        }

        return view('demo.show_new', [
            'campaign'	=> $campaign,
            'totals'	=> $totals,
            'disavow_name'   => \Session::get('uploaded_disavow_'.$id)[0],
            'target_pages'    => $target_pages->toArray(),
            'analitycs' => $analitycs,
            'total_backlinks' => $total_backlinks,
            'campaign_backlinks' => $rows
        ]);
    }


    /**
     * Returns the current stats of a demo campaign. Used in js ajax calls.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function progress(Request $request)
    {
        $input = $request->all();
        $result = ['error' => '', 'status' => 0, 'data' => []];

        $campaign = Campaign::where('id', $input['campaign_id'])->where('user_id', 0)->first();
        if(!$campaign) $result['error'] = 'Campaign not found.';
        else {
            $result['status'] = $campaign->progress();
            if($result['status'] != 100)
            {
                $progress = $campaign->progress();
                $progress_text = 'Initiating campaign';
                if($progress > 10) $progress_text = 'Determining backlinks';
                if($progress > 35) $progress_text = 'Evaluating backlinks donors';
                if($progress > 45) $progress_text = 'Tracking social signals';
                if($progress > 55) $progress_text = 'Defining spam signals';
                if($progress > 80) $progress_text = 'Risk assessment';
                if($progress > 90) $progress_text = 'Gathering the final report';
                $result['progress'] =   '<div class="progress progress-striped active progress-sm">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'.$progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$progress.'%">
                                            <span class="sr-only">'.$campaign->progress().'% Complete</span>
                                            </div>
                                         </div><p class="progress-bottom-text">'.$progress_text.' ...</p>';
            }

        }

        return response()->json($result);
    }


    public function subscribe(Request $request, $id)
    {
        $this->validate($request, ['email' => 'email|max:255']);

        CampaignSubscriber::create([
            'campaign_id' => $id,
            'email' => $request->input('email')
        ]);

        return 1;
    }
}
