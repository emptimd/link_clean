<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Front\DemoController;
use App\Models\Campaign;
use App\Models\CampaignAnchors;
use App\Models\CampaignBacklink;
use App\Models\CampaignBacklinkTag;
use App\Models\CampaignParticipants;
use App\Models\CampaignPrecheck;
use App\Classes\MajesticAPI;
use App\Models\GoogleAnalitycs;
use App\Models\Subscriptions;
use App\Models\TargetSocial;
use App\Models\TopicalTrustTarget;
use App\Models\User;
use App\Repositories\CampaignRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;
use SoapBox\Formatter\Formatter;

class CampaignController extends Controller
{
    /** @var  CampaignRepository*/
    private $campaignRepository;

    public function __construct(CampaignRepository $campaignRepo)
    {
        $this->campaignRepository = $campaignRepo;
        $this->middleware('auth', ['except' => ['downloadBacklinks', 'uploadDisavow']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $this->validate($request, ['url' => 'url']);
        $input['url'] = str_replace(['https://www.','http://www.','https://','http://'], '', $input['url']);
        $clean_url = rtrim($input['url'],"/");
        $request->replace($input);
        $this->validate($request, ['url' => 'required|unique:campaigns,url,NULL,id,user_id,'.Auth::user()->id]);

        // Launch Campaign PreCheck
        $api = (new MajesticAPI([
            'url'           => $clean_url,
            'method'        => 'GetIndexItemInfo'
        ]))->indexItemInfo();

        $item = $api->DataTables->Results->Data[0];

        // error - majestic insufficient funds
        if($api->Code == 'InsufficientIndexItemInfoUnits') {
            return redirect('admin')->with('error', 'Error occurred, please contact our support center.');
        }

//        $backlinks_count = $item->ExtBackLinks ?:0;
        if($item->Status != 'Found') {
            return redirect('admin')->with('error', "We could not find any backlinks for the url provided, can not create the campaign");
        }

        $campaign = new Campaign();
        $campaign->user_id = \Auth::user()->id;
        $campaign->url = $clean_url;
        $campaign->ip = $_SERVER['REMOTE_ADDR'];
        $campaign->stage_status = 2;
        $campaign->is_demo = 1;
        $campaign->trust_flow = $item->TrustFlow;
        $campaign->citation_flow = $item->CitationFlow;
        $campaign->save();

        CampaignPrecheck::store($campaign, $item);

        return redirect('admin')->with('status', 'Campaign successfully created!');
    }

    public function start(Request $request, $id, $view_id=0)
    {
        // @TODO check if campaign was created more then 14 days ago, then make new majestic precheck.
        /** @var User $user */
        $user = auth()->user();

        /** @var Campaign $campaign */
        $campaign = $this->campaignRepository->findWithAuthor($id);

        if($campaign->is_finished()) return back();

        if($campaign->stage != 0 && $campaign->stage_status != 2) {
            if($view_id) {
                if(!\Cookie::has('access_token')) return redirect('callback/oauth2callback/'.$id);
                $this->dispatch((new \App\Jobs\GoogleAnalitycs($id, \Cookie::get('access_token'), $view_id))->onQueue('high'));
            }
            return back()->with('show_ga', 10);
        }

        $backlinks_count = $campaign->getPrecheck ? $campaign->getPrecheck->ExtBackLinks : 0;

        // We have users with 2 types of subscriptions : old and new, the old ones do not have the domains count.
        // check witch type of subscription user was subscribed.
        $plan = Subscriptions::whereUserId(auth()->id())->where('campaign_id', 0)->orderBy('created_at', 'desc')->pluck('plan')->first();
        $details = $user->subscription_details($plan);
        if(isset($details['domains'])) {
            $check_domains = true;
        }else $check_domains = false;

        if($request->ajax()) {
            if($backlinks_count <= 1)
                return response()->json([
                    'error' => 'We could not find any backlinks for the url provided, can not start campaign',
                ], 422);
            if(!$user->is_admin && ($user->backlinks-($user->backlinks_used+$backlinks_count)) <= 0)
                return response()->json([
                    'error' => 'Sorry, can not start because you don\'t have enough backlinks on your balance',
                ], 422);
            if($check_domains)
                if(!$user->is_admin && !$user->domains)
                    return response()->json([
                        'error' => 'Sorry, can not start because you don\'t have enough domains on your balance',
                    ], 422);

            return 1;
        }

        if($campaign->status() != 'ready to start') return redirect('admin')->with('error', 'Error occurred, please contact our support center.');

        // Here if we got $view_id disptach job.
        if($view_id) {
            if(!\Cookie::has('access_token')) return redirect('callback/oauth2callback/'.$id);
            $this->dispatch((new \App\Jobs\GoogleAnalitycs($id, \Cookie::get('access_token'), $view_id))->onQueue('high'));
        }

        // if user dosent have enough resources
        // if hes no admin              // last stubscription was new but not has no domains         // not enough backlinks
        if(!$user->is_admin && ( ($check_domains && !$user->domains) || ($user->backlinks-($user->backlinks_used+$backlinks_count)) <= 0)) {
            // if it is first campaign and it is small, start it as a demo.
            $campaign_count = Campaign::where('user_id', auth()->id())->where('stage', '<>', 0)->where('stage_status', '<>', '2')->count();
            if(!$campaign_count && $backlinks_count < 50000) {
                $campaign->start();
                $this->dispatch(new \App\Jobs\CampaignBacklinksGet($id, 50000));
                return redirect('campaign/'.$id);
            }
        }else {
            $campaign->is_demo=0;
            // update balance
            $user->backlinks_used = $user->backlinks_used+$backlinks_count;
            if($check_domains && !$user->is_admin) {
                $user->domains--;
            }
            $user->save();
        }

        $campaign->start();
        $this->dispatch(new \App\Jobs\CampaignBacklinksGet($id));

        return redirect('admin')->with('status', 'Campaign successfully started, you will be notified on completion!');
    }

    public function restart(Request $request, $id, $view_id=0)
    {
        /** @var User $user */
        $user = Auth::user();

        /** @var Campaign $campaign */
        $campaign = $this->campaignRepository->findWithAuthor($id);

        if($request->ajax()) {
            // validate
            $error='';
            if(!$campaign->is_finished()) $error = 'Error occurred, please contact our support center.';

            if($error)
                return response()->json([
                    'error' => $error,
                ], 422);

            return 1;
        }else {
            if(!$campaign->is_finished()) return redirect('admin')->with('error', 'Error occurred, please contact our support center.');
        }

        // Launch Campaign PreCheck
        $api = (new MajesticAPI([
            'campaign_id'   => $campaign->id,
            'url'           => $campaign->url,
            'method'        => 'GetIndexItemInfo'
        ]))->indexItemInfo();

        $item = $api->DataTables->Results->Data[0];
        $backlinks_count = $item->ExtBackLinks ?:0;

        if($request->ajax()) {
            // validate
            $error='';
            if($api->Code == 'InsufficientIndexItemInfoUnits') $error = 'Error occurred, please contact our support center.';
            if($item->Status != 'Found' || !$backlinks_count) $error = 'We could not find any backlinks for the url provided, can not start campaign';
            if(!$user->is_admin && ($user->backlinks-($user->backlinks_used+$backlinks_count)) <= 0) $error = "Sorry, can not start because you don't have enough backlinks on your balance";

            if($error)
                return response()->json([
                    'error' => $error,
                ], 422);

            return 1;
        }

        // error - majestic insufficient funds
        if($api->Code == 'InsufficientIndexItemInfoUnits') return redirect('admin')->with('error', 'Error occurred, please contact our support center.');

        if($item->Status != 'Found' || !$backlinks_count) { // mostly never triggered
            return redirect('admin')->with('error', "We could not find any backlinks for the url provided, can not start campaign");
        }

        if(!$user->is_admin && ($user->backlinks-($user->backlinks_used+$backlinks_count)) <= 0) return redirect('admin')->with('error', "Sorry, can not start because you don't have enough backlinks on your balance");

        // Here if we got $view_id disptach job.
        if($view_id) {
            if(!\Cookie::has('access_token')) return redirect('callback/oauth2callback/'.$id);
            $this->dispatch((new \App\Jobs\GoogleAnalitycs($id, \Cookie::get('access_token'), $view_id))->onQueue('high'));
        }

        // update balance
        $user->backlinks_used = $user->backlinks_used+$backlinks_count;
        $user->save();

        $campaign->recheck_nr+=1;
        $campaign->start();

        CampaignPrecheck::store($campaign, $item);

        $this->dispatch(new \App\Jobs\CampaignBacklinksGet($id));

        return redirect('admin')->with('status', 'Campaign successfully restarted, you will be notified on completion!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /** @var Campaign $campaign*/
        $campaign = Campaign::campaignAuthor()->where('id', $id)->with(['author' => function($query) {
            $query->select(['id', 'name', 'email']);
        }])->first();

        if(!$campaign) return redirect('/admin');

        // only for the moment if is demo use DemoController.
        if($campaign->is_demo) return (new DemoController)->showNew($id);

        $totals = $campaign->totals_new_campaign_show();

        // so we must send google analytics data (if we have it)
        $analitycs = GoogleAnalitycs::where('campaign_id', $id)->orderBy('id', 'desc')->first();

        $anchors = CampaignAnchors::select(['anchor', 'ref_domains', 'total_links', 'deleted_links', 'nofollow_links', 'percent'])->where('campaign_id', $id)->orderBy('percent', 'desc')->limit(10)->get();

        $anjs = [];
        if($anchors->count()) {
            $cnt = (int)($anchors[0]->ref_domains*(100/$anchors[0]->percent)); //total count of ref domains
            $pr = 0;
            foreach($anchors as $anchor) {
                $anjs[] = [$anchor->anchor, (int)$anchor->ref_domains];
                $pr += $anchor->percent;
            }
            $anjs[] = ['Other Anchor Text', (int)($cnt*((100-$pr)/100))];
        }

        $participants = \DB::table('users')
            ->join('campaign_participants', 'users.id', '=', 'campaign_participants.user_id')
            ->select('users.id', 'users.email', 'users.name', 'campaign_participants.id as pid')
            ->where('campaign_id', $id)
            ->get();

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
            'anchors' => $anjs,
        ]);

        $topic = TopicalTrustTarget::where(function ($query) use($campaign) {
            $query->where('target_backlink_url', 'http://'.$campaign->url.'/')
                ->orWhere('target_backlink_url', 'http://'.$campaign->url);
        })
            ->where('campaign_id', $campaign->id)
            ->orderBy('topical_trust_flow', 'desc')
            ->orderBy('links', 'desc')
            ->orderBy('pages', 'desc')
            ->limit(4)
            ->get();

        $domain_social = TargetSocial::where('campaign_id', $campaign->id)
            ->where(function ($query) use($campaign) {
                $query->where('domain', 'like', '%'.$campaign->url.'/')
                    ->orWhere('domain', 'like', '%'.$campaign->url);
            })
            ->first();

        $top_referrers = \DB::select("select COUNT(cb.id) AS cnt, domain, AVG(total_rank) AS avg
from campaign_domains cd INNER JOIN campaign_backlinks cb on cb.domain_id=cd.id
where cd.campaign_id=? GROUP BY cd.id order by cnt desc limit 4;", [$id]);

        $target_pages = $campaign->getBacklinks()->selectRaw('count(id) as c, TargetURL')->orderBy('c', 'desc')->groupBy('TargetURL')->limit(4)->get();

        return view('user.campaign', [
            'campaign'	=> $campaign,
            'totals'	=> $totals,
            'domain_social' => $domain_social,
            'disavow_name'   => \Session::get('uploaded_disavow_'.$id)[0],
            'target_pages'    => $target_pages->toArray(),
            'referal'   => [
                'topic'         => $topic,
                'top'           => $top_referrers
            ],
            'analitycs' => $analitycs,
            'participants' => $participants,
            'anchors' => $anchors
        ]);
    }


    public function showTopicsSingle($id, $domain)
    {
        /** @var Campaign $campaign*/
        $campaign = $this->campaignRepository->findWithAuthor($id);

        return view('user.campaign_topics_single', [
            'campaign'  => $campaign,
            'domain'    => $domain,
        ]);
    }


    public function showUrl($id=0, $url_id=0)
    {
        /** @var Campaign $campaign */
        $campaign = $this->campaignRepository->findWithAuthor($id);

        /** @var CampaignBacklink $backlink */
        $backlink = CampaignBacklink::from('campaign_backlinks as cb')
            ->select(\DB::raw("cb.id, cb.SourceURL,cb.AnchorText,cb.FlagNoFollow,cb.TargetURL,cb.SourceCitationFlow,cb.SourceTrustFlow,cb.unreachable,cb.malware,cb.link_rank,cb.referral_influence,cb.total_rank,
            cd.domain_rank,cd.CitationFlow,cd.TrustFlow,cd.ExtBackLinks,
            ds.social_rank,
            ca.content_count,ca.text_html_ratio,ca.anchor_ratio,ca.outgoing_backlinks,ca.page_load_time
            "))
            ->join('campaign_domains as cd', function($q) use ($campaign)
            {
                $q->on('cb.domain_id', '=', 'cd.id');
            })
            ->join('domain_social as ds', function($q) use ($campaign)
            {
                $q->on('ds.id', '=', 'cd.id');
            })
            ->leftJoin('campaign_analyzer as ca', function($q) use ($campaign)
            {
                $q->on('ca.id', '=', 'cb.id');
            })
            ->where('cb.id', $url_id)->first();
        // SELECT Domain social rank for this backlink.
        $topics = TopicalTrustTarget::where('campaign_id', $id)->where('target_backlink_url', $backlink->SourceURL)->get();

        // get tags
        $tags = CampaignBacklinkTag::where('backlink_id', $url_id)->pluck('tag')->toArray();
        $tags = implode(',', $tags);

        return view('user.campaign_backlink', [
            'campaign'      => $campaign,
            'backlink'      => $backlink,
            'topics' => $topics,
            'tags' => $tags
        ]);
    }

    public function backlinksCampaign($id)
    {
        /** @var Campaign $campaign */
        $campaign = $this->campaignRepository->findWithAuthor($id);

        $totals = $campaign->totals_new_campaign_show();

        return view('campaign.backlinks', [
            'backlinks_total' => $totals->total,
            'campaign'	=> $campaign,
            'disavow_name'   => \Session::get('uploaded_disavow_'.$id)[0],
            'totals' => $totals
        ]);
    }

    public function downloadBacklinks($id=0, Request $request)
    {
        /** @var Campaign $campaign */
        $params = array_keys($request->all());

        $backlink_ranks = array_flip(Campaign::$backlink_ranks);
        $sql = '';
        if(count($params) < count($backlink_ranks)) {
            $ranges[] = Campaign::total_rank_from_name($params[0]);
            foreach($params as $key => $rank) {
                if(!$key) continue;

                // check if rank in order.
                if($backlink_ranks[$rank] == $backlink_ranks[$params[$key-1]]+1) {
                    $ranges[count($ranges)-1]['min'] = Campaign::total_rank_from_name($rank)['min'];
                }else {
                    $ranges[] = Campaign::total_rank_from_name($rank);
                }
            }

            foreach($ranges as $range) {
                if(!isset($range['max'])) {
                    $sql = 'total_rank >= '.$range['min']; // EX: total_rank >= 81|101
                }else if(!$range['min']) {
                    if(!$sql) {
                        $sql = 'total_rank <= '.$range['max']; // EX: total_rank < 21|41
                    }else {
                        $sql .= ' OR total_rank <= '.$range['max'];
                    }
                }else { // between
                    if(!$sql) $sql = 'total_rank BETWEEN '.$range['min'] . ' AND '.$range['max'];
                    else $sql .= ' OR total_rank BETWEEN '.$range['min'] . ' AND '.$range['max'];
                }
            }
        }

        $campaign = $this->campaignRepository->findWithAuthor($id);

        $csvData = $campaign->getBacklinksCsv();

        if($sql) $csvData->whereRaw("($sql)");

        $result = [];
        foreach($csvData->get() as $row)
        {
            $result[] = [
                'url' => htmlentities($row['url']),
                'no_follow' => $row['no_follow']? 'yes' : '',
                'total_rank' => $row['total_rank'],
                'link_rank' => $row['link_rank'],
                'target_url' => $row['target_url'],
                'result' => Campaign::rank_backlink($row['total_rank'])
            ];
        }

        $formatter = Formatter::make(array_values($result), Formatter::ARR);

        $csv = $formatter->toCsv();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="report-'.str_replace([':','/'], ['_','_'], $campaign->url).'.csv"'
        ];


        return response()->make($csv, 200, $headers);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function downloadDisavow($id=0)
    {
        /** @var Campaign $campaign */

        $campaign = $this->campaignRepository->findWithAuthor($id);

        //get all bad links(spammy, bad, critical)

        //for test new
        $data = \DB::select("SELECT cb.SourceURL, cd.domain
FROM campaign_backlinks cb INNER JOIN campaign_domains cd on cd.id=cb.domain_id where cb.campaign_id=? and recheck_nr=0 and total_rank >= 60 GROUP BY cb.SourceURL, cd.domain", [$id]);

        $domain = [];

        foreach($data as $backlink) {
            $domain[$backlink->domain][] = $backlink->SourceURL;
        }

        $str = '';
        foreach($domain as $key => $items) {
            if(count($items) >= 10) { // disavow whole domain
                $str .= "domain:$key".PHP_EOL;
            }else {
                foreach($items as $item) {
                    $str .= str_replace(" ","%20",$item).PHP_EOL;
                }
            }
        }
        //end test

        $headers = [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="disavow-'.str_replace([':','/'], ['_','_'], $campaign->url).'.txt"'
        ];

        return response()->make($str, 200, $headers);
    }


    /**
     * @param int $id
     * @param Request $request
     * @return mixed
     */
    public function downloadDisavowTarget($id=0, Request $request)
    {
        /** @var Campaign $campaign */

        $campaign = $this->campaignRepository->findWithAuthor($id);

        //get all bad links(spammy, bad, critical) for this Target
        $data = $campaign->getBacklinksBad()->distinct()->where('TargetURL', $request->target)->pluck('SourceURL');
        $str = '';
        $session = \Session::get('uploaded_disavow_'.$id);
        foreach ($data as $item) {
            if(!$session || !in_array($item, (array)$session) )
                $str .= $item.PHP_EOL;
        }

        $headers = [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="disavow-'.str_replace([':','/'], ['_','_'], $campaign->url).'.txt"'
        ];

        return response()->make($str, 200, $headers);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return mixed
     */
    public function uploadDisavow($id=0, Request $request)
    {
        if (!$request->file('disavow_file')->isValid() || $request->file('disavow_file')->getClientOriginalExtension() != 'txt') {
            exit;
        }

        $data = preg_split('/\n|\r\n?/', file_get_contents($request->file('disavow_file')));
        $data = array_filter($data, function($value) { return $value !== ''; });

        // here add tag
        $backlinks = CampaignBacklink::where('campaign_id', $id)->where('total_rank', '>', '50')->pluck('id', 'SourceURL');

        $values = '';
        foreach($data as $item) {
            if(!isset($backlinks[$item])) continue;

            $values .= "({$backlinks[$item]}, 'disavowed'),";
        }

        if(!$values) return back();

        \DB::statement( "INSERT INTO campaign_backlinks_tags (backlink_id, tag) VALUES ".rtrim($values, ',')." ON DUPLICATE KEY UPDATE
  tag=concat(tag, ',disavowed'), backlink_id=VALUES(backlink_id)" );

        array_unshift($data, $request->file('disavow_file')->getClientOriginalName());

        \Session::put('uploaded_disavow_'.$id, $data);

        return back();
    }

    /**
     * @param int $id
     * @param Request $request
     * @return mixed
     */
    public function monitor($id=0, Request $request)
    {
        /** @var Campaign $campaign */
        $campaign = $this->campaignRepository->findWithAuthor($id);

        $campaign->timestamps = false;
        $campaign->to_recheck = $request->input('to_recheck');
        $campaign->save();

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Campaign $campaign */
        $campaign = $this->campaignRepository->findWithAuthor($id);
        $campaign->delete();

        return redirect('admin')->with('status', 'Campaign successfully deleted!');
    }

    /**
     * Remove one ore many campaigns.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function removeMany(Request $request)
    {
        $ids = explode(',', $request->input('ids'));

        Campaign::whereIn('id', $ids)->delete();
        $text = count($ids)>1?'s':'';
        return redirect('admin')->with('status', 'Campaign'.$text.' successfully deleted!');
    }

    /**
     * Remove one ore many campaigns.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function restartMany(Request $request)
    {
        $user = Auth::user();
        if(($user->backlinks - $user->backlinks_used) === 0) return redirect('admin')->with('error', "Sorry, can not start because you don't have enough backlinks on your balance");
        $ids = explode(',', $request->input('ids'));

        $campaigns = Campaign::select(['id', 'url', 'recheck_nr'])->whereIn('id', $ids)->where(['stage' => 10, 'stage_status' => 0])->get();
        $i=0;
        foreach($campaigns as $campaign) {
            $i++;
            // Launch Campaign PreCheck
            $api = (new MajesticAPI([
                'campaign_id'   => $campaign->id,
                'url'           => $campaign->url,
                'method'        => 'GetIndexItemInfo'
            ]))->indexItemInfo();

            $item = $api->DataTables->Results->Data[0];
            $backlinks_count = $item->ExtBackLinks ?:0;

            // error - majestic insufficient funds
            if($api->Code == 'InsufficientIndexItemInfoUnits') return redirect('admin')->with('error', 'Error occurred, please contact our support center.');

            if($item->Status != 'Found' || !$backlinks_count) { // mostly never triggered
                return redirect('admin')->with('error', "We could not find any backlinks for the url provided, can not start campaign");
            }

            if(($user->backlinks-($user->backlinks_used+$backlinks_count)) <= 0) return redirect('admin')->with('error', "Sorry, can not start because you don't have enough backlinks on your balance");

            // update balance
            $user->backlinks_used = $user->backlinks_used+$backlinks_count;
            $user->save();

            $campaign->recheck_nr+=1;
            $campaign->start();

            CampaignPrecheck::store($campaign, $item);
        }

        $text = $i>1?'s':'';
        return redirect('admin')->with('status', 'Campaign'.$text.' successfully restarted, you will be notified on completion!');
    }


    public function addParticipant(Request $request)
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::campaignAuthor()->findOrFail($request->get('campaign_id'));

        $user = User::where('email', $request->get('email'))->first();
        if(!$user)
            return response()->json([
                'error' => 'We could not find any user with such an email.',
            ], 422);

        if(!CampaignParticipants::where(['user_id'=>$user->id, 'campaign_id' => $campaign->id])->exists()) {
            $participant = CampaignParticipants::create(['user_id' => $user->id, 'campaign_id' => $campaign->id]);
            $gravatar = \Gravatar::src($request->get('email'), 30);
//            return "<a href=\"#\"><img alt=\"image\" class=\"\" src=\"$gravatar\"></a>";
            return "<a title=\"$user->name\" class=\"p-item\" data-id=\"$participant->id\"><img alt=\"image\" class=\"\" src=\"$gravatar\"></a>";
        }

    }

    public function removeParticipant(Request $request)
    {
        return CampaignParticipants::destroy($request->get('id'));
    }

    public function getVisits(Request $request)
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::campaignAuthor()->findOrFail($request->get('campaign_id'));

        $data = GoogleAnalitycsBacklink::selectRaw('data, day(date) as d')->where('campaign_id', $campaign->id)->limit($request->get('months')+1)->orderBy('date', 'desc')->get();
        $new_array = [];
        $i = 0;
        foreach(array_reverse($data->toArray()) as $item) {
            if($i++ == 0 && $data[0]->d >= 10) continue;
            if(!$new_array) {
                $new_array["Search"] = $item['data']['Search'] ?? [];
                $new_array["Social"] = $item['data']['Social'] ?? [];
                $new_array["Referral"] = $item['data']['Referral'] ?? [];
                $new_array["newBacklinksBad"] = isset($item['data']['newBacklinksBad']) ? $item['data']['newBacklinksBad'] : [];
                $new_array["newBacklinksGood"] = isset($item['data']['newBacklinksGood']) ? $item['data']['newBacklinksGood'] : [];
            }
            else {
                $new_array["Search"] = array_merge($new_array["Search"], $item['data']['Search'] ?? []);
                $new_array["Social"] = array_merge($new_array["Social"], $item['data']['Social'] ?? []);
                $new_array["Referral"] = array_merge($new_array["Referral"], $item['data']['Referral'] ?? []);
                $new_array["newBacklinksBad"] = isset($item['data']['newBacklinksBad']) ? array_merge($new_array["newBacklinksBad"], $item['data']['newBacklinksBad']) : [];
                $new_array["newBacklinksGood"] = isset($item['data']['newBacklinksGood']) ? array_merge($new_array["newBacklinksGood"], $item['data']['newBacklinksGood']) : [];
            }
        }
        return $new_array;
    }

}