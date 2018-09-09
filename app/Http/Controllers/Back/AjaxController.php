<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignBacklink;
use App\Models\CampaignDomains;
use App\Models\Ticket;
use App\Models\TopicalTrustTarget;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class AjaxController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getClient', 'getSupport']]);
    }


    public function getClient(Request $request)
    {
        // iDisplayStart - Display start point in the current data set.
        // iDisplayLength - Number of records that the table can display in the current draw.
        // sSearch - Global search field
        // iSortCol_0:3
        // sSortDir_0:asc

        $columns = ['name', 'email', 'subscription', 'credits', 'domain', 'created_at'];

        $rows = [];

        $clients = User::selectRaw("users.id, name, email, s.plan as subscription, backlinks-backlinks_used as credits, users.created_at, users.domain")
            ->leftJoin('subscriptions as s', function($q)
            {
                $q->on('s.user_id', '=', 'users.id');
            })
            ->where('is_admin', 0);

        $total_count = $filtered_count = $clients->count();

        // search ?
        if($request->sSearch) {
            $clients = $clients->where('email', 'like', '%'.$request->sSearch.'%');
            $filtered_count = $clients->count();
        }

        // sort ?
        if($request->sSortDir_0) $clients = $clients->orderBy($columns[$request->iSortCol_0] , $request->sSortDir_0);
        else $clients = $clients->orderBy('users.created_at', 'DESC');


        $clients_data = $clients->skip($request->iDisplayStart)
                                ->take($request->iDisplayLength)
                                ->get();

        foreach($clients_data as $c)
            $rows[]= [
                $c->name,
                $c->email,
                $c->subscription,
                $c->credits,
                $c->domain,
                date('Y-m-d', strtotime($c->created_at)),
                '<a href="'.url('admin/client/'.$c->id).'" class="btn btn-xs btn-success add_credits" data-user="'.$c->id.'" data-name="'.$c->name.'">add credits</a>
                <a href="'.url('admin/client/'.$c->id).'" class="btn btn-xs btn-info">details</a>'
            ];

        $response = [
            "sEcho"                 => intval( $request->sEcho ),
            "iTotalRecords"         => intval( $total_count ),
            "iTotalDisplayRecords"  => intval( $filtered_count ),
            "aaData"                => $rows
        ];

        return response()->json($response);
    }

    /**
     * Returns all tickets for support datatable.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSupport()
    {
        $rows = [];
        $tickets = Ticket::with('author')->get();



        foreach($tickets as $t)
            $rows[]= [
                date('Y-m-d H:i', strtotime($t->date)),
                $t->status(),
                $t->subject,
                $t->author->domain,
                '<a href="'.url('admin/support/'.$t->id).'" class="btn btn-xs btn-info">details</a>'
            ];

//        if(\Auth::id() == 127) {
//            dd($rows);
//        }

        return response()->json(["aaData" => $rows]);
    }

    public function getBacklinks(Request $request)
    {
//        dd($request->all());
        // @TODO THIS IS ALSO SLOW ON BIG CAMPAIGNS mb do not show count/filtered count.
        $nf = $request->get('nofollow') === 'true' ? 1 : 0;
        $f404 = $request->get('404') === 'true' ? 1 : 0;
        $redirects = $request->get('redirects') === 'true' ? 1 : 0;

        /** @var Campaign $campaign */
        $campaign = Campaign::select('recheck_nr')->where('id', $request->campaign_id)->first();

        $columns = ['SourceURL', 'total_rank', 'FlagNoFollow', 'TrustFlow', 'CitationFlow', 'referral_influence', 'views', 'ip', 'social_rank', 'FirstIndexedDate'];

        $rows = [];

        if($campaign->recheck_nr) {
            $campaign_backlinks = CampaignBacklink::from('campaign_backlinks AS t1')
                ->select(['t1.id', 't1.SourceURL', 't1.total_rank', 't1.TargetURL', 't1.FlagNoFollow', 'cd.TrustFlow', 'cd.CitationFlow', 't1.referral_influence', 't1.views', 'cd.country', 'cd.ip', 't1.http_code', 'ds.social_rank', 't1.FirstIndexedDate', 't1.paid', 't1.is_disabled',
                    't2.total_rank as total_rank_p'/*, 't2.link_rank as link_rank_p'*//*, 't2.domain_rank as domain_rank_p'*/, 't2.referral_influence as referral_influence_p', 't2.SourceURL as SourceURL_p'])
                ->leftJoin('campaign_backlinks AS t2', function($q) use ($campaign)
                {
                    $q->on('t2.SourceURL', '=', 't1.SourceURL')
                        ->on('t2.TargetURL', '=', 't1.TargetURL')
                        ->on('t2.campaign_id', '=', 't1.campaign_id')
                        ->where('t2.recheck_nr', '=', $campaign->recheck_nr-1);
                })
                ->join('campaign_domains as cd', function($q) use ($campaign)
                {
                    $q->on('cd.id', '=', 't1.domain_id');
                })
                ->leftJoin('domain_social as ds', function($q) use ($campaign)
                {
                    $q->on('ds.id', '=', 't1.domain_id');
                })
                ->where('t1.campaign_id', '=', $request->campaign_id)
                ->where('t1.recheck_nr', $campaign->recheck_nr);
        }else {
            $campaign_backlinks = CampaignBacklink::from('campaign_backlinks AS t1')
                ->select(['t1.id', 't1.SourceURL', 't1.total_rank', 't1.TargetURL', 't1.FlagNoFollow', 'cd.TrustFlow', 'cd.CitationFlow', 't1.referral_influence', 't1.views', 'cd.country', 'cd.ip', 't1.http_code', 'ds.social_rank', 't1.FirstIndexedDate', 't1.paid', 't1.is_disabled'])
                ->leftJoin('campaign_domains as cd', function($q) use ($campaign)
                {
                    $q->on('cd.id', '=', 't1.domain_id');
                })
                ->leftJoin('domain_social as ds', function($q) use ($campaign)
                {
                    $q->on('ds.id', '=', 't1.domain_id');
                })
                ->where('t1.campaign_id', '=', $request->campaign_id);
                /*->where('t1.recheck_nr', $campaign->recheck_nr)*/;
        }


        // filter
        if(!$nf) $campaign_backlinks->where('t1.FlagNoFollow', 0);
        if(!$f404 && !$redirects) $campaign_backlinks->whereNotIn('t1.http_code', [301, 302, 303, 307, 308, 404]);
        elseif(!$f404) $campaign_backlinks->whereNotIn('t1.http_code', [301, 302, 303, 307, 308, 404]);
        elseif(!$redirects) $campaign_backlinks->where('t1.http_code', '<>', 404);
        if($request->get('url')) $campaign_backlinks->where('t1.SourceURL', 'like', '%'.$request->get('url').'%');
        if($request->get('ip')) $campaign_backlinks->where('cd.ip', $request->ip);
        if($request->get('anchor')) $campaign_backlinks->where('t1.AnchorText', $request->anchor);
        if($request->get('date')) $campaign_backlinks->where('t1.FirstIndexedDate', $request->date);

        if($request->dtf_from) $campaign_backlinks->where('cd.TrustFlow', '>=', $request->dtf_from);
        if($request->dtf_to && $request->dtf_to != 100) $campaign_backlinks->where('cd.TrustFlow', '<=', $request->dtf_to);

        if($request->dcf_from) $campaign_backlinks->where('cd.CitationFlow', '>=', $request->dcf_from);
        if($request->dcf_to && $request->dcf_to != 100) $campaign_backlinks->where('cd.CitationFlow', '<=', $request->dcf_to);

        if($request->ri_from) $campaign_backlinks->where('t1.referral_influence', '>=', (float)$request->ri_from);
        if($request->ri_to && $request->ri_to != 100) $campaign_backlinks->where('t1.referral_influence', '<=', (float)$request->ri_to);

        if($request->traffic_from) $campaign_backlinks->where('t1.views', '>=', $request->traffic_from);
        if($request->traffic_to) $campaign_backlinks->where('t1.views', '<=', $request->traffic_to);

        if($request->sr_from) $campaign_backlinks->where('ds.social_rank', '>=', (float)$request->sr_from);
        if($request->sr_to && $request->sr_to != 100) $campaign_backlinks->where('ds.social_rank', '<=', (float)$request->sr_to);

        // SUBQUERY FOR COUNT.
//        $sub = CampaignBacklink::select('t1.id')->from('campaign_backlinks AS t1')
//            ->leftJoin('campaign_backlinks AS t2', function($q) use ($campaign)
//            {
//                $q->on('t2.SourceURL', '=', 't1.SourceURL')
//                    ->where('t2.recheck_nr', '=', $campaign->recheck_nr-1);
//            })
//            ->where('t1.campaign_id', '=', $campaign->id)
//            ->where('t1.recheck_nr', $campaign->recheck_nr)
//            ->groupBy('t1.id');

        if($request->has('target')) $campaign_backlinks->where('t1.TargetURL', $request->target);

        $total_count = $filtered_count = \DB::table(\DB::raw("({$campaign_backlinks->toSql()}) as sub"))->mergeBindings($campaign_backlinks->getQuery())->count();

        // sort ?
        if($request->sSortDir_0) $campaign_backlinks = $campaign_backlinks->orderBy($columns[$request->iSortCol_0] , $request->sSortDir_0);

        if($request->tags) {
            $search_this = explode(',', $request->tags);
            $search_this_c = count($search_this);
            $campaign_backlinks->join('campaign_backlinks_tags as cbt', function($q)
            {
                $q->on('cbt.backlink_id', '=', 't1.id');
            })->addSelect('cbt.tag');
        }else {
            $campaign_backlinks->leftJoin('campaign_backlinks_tags as cbt', function($q)
            {
                $q->on('cbt.backlink_id', '=', 't1.id');
            })->addSelect('cbt.tag');
        }

        /** @var CampaignBacklink $campaign_backlinks_data */
        $campaign_backlinks_data = $campaign_backlinks
            ->take($request->iDisplayLength)
            ->skip($request->iDisplayStart)
            ->get();

        //Add class if we have uploaded_disavow cookie.
//        $uploaded_disavow = \Session::get('uploaded_disavow_'.$request->campaign_id);
        foreach($campaign_backlinks_data as $b) {

            $all = explode(',', $b->tag);
            $paid = $disavowed = 0;
            /*FILTER TAGS*/
            if($request->tags) {
                if(count(array_intersect($search_this, $all)) != $search_this_c) continue;
            }

            foreach($all as $key => $tag) {
                if($tag == 'paid') {
                    unset($all[$key]);
                    $paid = 1;
                }

                if($tag == 'disavowed') {
                    unset($all[$key]);
                    $disavowed = 1;
                }
            }


//            if($uploaded_disavow && in_array($b->SourceURL, $uploaded_disavow)) $class = 'disavow_red';
//            else $class = '';

            $class = '';

            $rank = Campaign::rank_backlink($b->total_rank);
            if(!isset($b->total_rank_p)) {
                $rank_p = false;
            }else $rank_p = Campaign::rank_backlink($b->total_rank_p);
            $flag = $b->country?strtolower($b->country):"generic";

            if($b->is_disabled)
                $rows[] = [
                    '<div class="source-url">'.$b->SourceURL.'</div><span class="sourcer-url-span '.$class.'"></span>',
                    '<span class="' . Campaign::rank_backlink_badge_class('subscribe') . '">subscribe</span> ', // Quality
                    '#',
                    '#',
                    '#',
                    '#', // referral influence
                    '#',
                    '<i class="flag flag--exclusive flag-generic"></i>',
                    '#', // social rank
                    $b->FirstIndexedDate,
                    '<a href="' . '/campaign/' . $request->campaign_id . '/' . $b->id . '" class="btn btn-info btn-xs details">details</a>',
                    "DT_RowClass" => "tr-disabled-1"
                ];
            else
                $rows[] = [
                    '<div class="source-url disavowed-'.$disavowed.' paid-'.$paid.'" data-tags="'.implode(',', $all).'">'.$b->SourceURL.'</div><span class="sourcer-url-span '.$class.'"></span>',
                    '<span class="' . Campaign::rank_backlink_badge_class($rank) . '">' . $rank . '</span> ' .$b->getRankDif($rank, $rank_p), // Quality
                    $b->FlagNoFollow ? '<i class="fa fa-check"></i>' : '',
                    $b->TrustFlow,
                    $b->CitationFlow,
                    $b->referral_influence.$b->getRefRankDif(), // referral influence
                    $b->views,
                    '<i class="flag flag--exclusive flag-'.$flag.'" title="'.long2ip($b->ip).'"></i>',
                    $b->social_rank, // social rank
                    $b->FirstIndexedDate,
                    '<a href="' . '/campaign/' . $request->campaign_id . '/' . $b->id . '" class="btn btn-info btn-xs">details</a>',
                ];
        }


        $response = [
            "sEcho"                 => intval( $request->sEcho ),
            "iTotalRecords"         => intval( $total_count ),
            "iTotalDisplayRecords"  => intval( $filtered_count ),
            "aaData"                => $rows
        ];


        return response()->json($response);
    }


    public function getRefs(Request $request)
    {
        /** @var Campaign $campaign*/
        $columns = ['domain', 'cnt', 'domain_rank', 'social_rank', 'avg'];

        $rows = [];

        $campaign = Campaign::findOrFail($request->campaign_id);
//        $domains = $campaign->getRefs();

        $domains = CampaignDomains::from('campaign_domains as cd')
            ->select(\DB::raw("domain,domain_rank,count(cb.id) AS `cnt`,avg(cb.total_rank) AS `avg`,ds.social_rank"))
            ->join('campaign_backlinks as cb', function($q) use ($campaign)
            {
                $q->on('cb.domain_id', '=', 'cd.id')
                    ->where('recheck_nr', '=', $campaign->recheck_nr);
            })
            ->join('domain_social as ds', function($q) use ($campaign)
            {
                $q->on('ds.id', '=', 'cd.id');
            })
            ->where('cb.campaign_id', $request->campaign_id)
            ->groupBy('cd.id');

        $selc = CampaignDomains::whereCampaignId($request->campaign_id);
        $total_count = $filtered_count = $selc->count();

        // search ?
         if($request->sSearch) {
             $domains = $domains->where('domain', 'like', '%'.$request->sSearch.'%');
             $selc = $selc->where('domain', 'like', '%'.$request->sSearch.'%');
             $filtered_count = $selc->count();
         }

        if($request->sSortDir_0) $domains = $domains->orderBy($columns[$request->iSortCol_0] , $request->sSortDir_0);

        $refs_data = $domains->skip($request->iDisplayStart)
                            ->take($request->iDisplayLength)
                            ->get();

        foreach($refs_data as $d) {
            $rank = Campaign::rank_backlink($d->avg);
            $rows[] = [
                '<span class="nowrap" data-toggle="tooltip" data-placement="top" title="' . $d->domain . '">' . mb_substr($d->domain,0,70) . '</span>', // @TODO mb str_limit is not working check laravel5.4
                $d->cnt,
                $d->domain_rank, // Domain Trust
                $d->social_rank, // Social Trust For Domain from domain_social
                '<span class="' . Campaign::rank_backlink_badge_class($rank) . '">' . $rank . '</span>', // Avg Quality
                '<a href="' . url('campaign/' . $request->campaign_id . '/refs/' . $d->domain) . '" class="btn btn-info btn-xs">details</a>'
            ];
        }

        $response = [
            "sEcho"                 => intval( $request->sEcho ),
            "iTotalRecords"         => intval( $total_count ),
            "iTotalDisplayRecords"  => intval( $filtered_count ),
            "aaData"                => $rows
        ];

        return response()->json($response);
    }

    public function getRefSingle(Request $request)
    {
        /** @var Campaign $campaign*/
        $columns = ['SourceURL', 'TargetURL', 'total_rank', 'link_rank', 'social_rank'];

        $rows = [];

        $campaign = Campaign::findOrFail($request->campaign_id);

        $campaign_backlinks = CampaignDomains::from('campaign_domains as cd')
            ->select(\DB::raw("cb.id,SourceURL, TargetURL, total_rank, link_rank, cd.domain_rank, ds.social_rank"))
            ->join('campaign_backlinks as cb', function($q) use ($campaign)
            {
                $q->on('cb.domain_id', '=', 'cd.id')
                    ->where('recheck_nr', '=', $campaign->recheck_nr);
            })
            ->join('domain_social as ds', function($q) use ($campaign)
            {
                $q->on('ds.id', '=', 'cd.id');
            })
            ->where('cd.campaign_id', $request->campaign_id)
            ->where('cd.domain', $request->domain);


//        $campaign_backlinks = $campaign->getRefsingle($request->domain);
        $total_count = $campaign_backlinks->count();

        // search ?
        if($request->sSearch) $campaign_backlinks = $campaign_backlinks->where('SourceURL', 'like', '%'.$request->sSearch.'%');

        // sort ?
        if($request->sSortDir_0) $campaign_backlinks = $campaign_backlinks->orderBy($columns[$request->iSortCol_0] , $request->sSortDir_0);

        $filtered_count = $campaign_backlinks->count();

        $campaign_backlinks_data = $campaign_backlinks->skip($request->iDisplayStart)
            ->take($request->iDisplayLength)
            ->get();

        foreach($campaign_backlinks_data as $b) {
            $rank = Campaign::rank_backlink($b->total_rank);
            $rows[] = [
                '<span class="nowrap" data-toggle="tooltip" data-placement="top" title="' . $b->SourceURL . '">' . $b->SourceURL . '</span>', // SOURCE URL
                '<span class="nowrap" data-toggle="tooltip" data-placement="top" title="' . $b->TargetURL . '">' . mb_substr($b->TargetURL,0,70) . '</span>',
                '<span class="' . Campaign::rank_backlink_badge_class($rank) . '">' . $rank . '</span>', // Quality
                $b->link_rank . '/' . $b->domain_rank, // Link Rank / Domain Rank
                $b->social_rank, // social rank of the domain from domain_social
                '<a href="' . '/campaign/' . $request->campaign_id . '/' . $b->id . '" class="btn btn-info btn-xs">details</a>',
            ];
        }

        $response = [
            "sEcho"                 => intval( $request->sEcho ),
            "iTotalRecords"         => intval( $total_count ),
            "iTotalDisplayRecords"  => intval( $filtered_count ),
            "aaData"                => $rows
        ];

        return response()->json($response);
    }

    public function getTopicsSingle(Request $request)
    {
        /** @var Campaign $campaign*/
        $rows = [];
        $campaign_backlinks = TopicalTrustTarget::select(['topic', 'topical_trust_flow', 'pages', 'links', 'links_from_ref_domains'])->where('target_backlink_url', 'http://'.$request->domain.'/')->where('campaign_id', $request->campaign_id)->get();

        foreach($campaign_backlinks as $b)
            $rows[]= [
                '<span class="nowrap" >'.$b->topic.'</span>',
                $b->topical_trust_flow,
                $b->pages,
                $b->links, // social rank
                $b->links_from_ref_domains
            ];

        return response()->json(["aaData" => $rows]);
    }

    public function getCampaigns()
    {
//        dd(1);
        $rows = [];

        // Add to users campaigns those in witch he participates.
        $particip = \App\Models\CampaignParticipants::where('user_id', auth()->id())->pluck('campaign_id')->toArray();
        if($particip) {
            $where = "c.user_id=? OR c.id in(".implode(',', $particip).")";
        }else {
            $where = "c.user_id=?";
        }

        $campaigns = \DB::select("select COUNT(cb.id) AS total,
               SUM(IF(cb.total_rank > 60, 1, 0)) AS bad,
               cp.ExtBackLinks,
               c.id, c.user_id, c.updated_at, c.url, c.stage, c.stage_status, c.recheck_nr, c.to_recheck
               from campaigns c LEFT JOIN campaign_backlinks cb on cb.campaign_id=c.id and c.recheck_nr=cb.recheck_nr LEFT JOIN campaign_precheck cp on cp.campaign_id=c.id
               where ".$where." GROUP BY c.id,cp.id", [auth()->id()]);

        foreach($campaigns as $campaign) {
            $status = 'in progress';

            if($campaign->stage == 10) {
                $status = 'finished';
                $backlinks_count = $campaign->total;
                $backlinks_count_bad = $campaign->bad;
                if($campaign->bad) $backlinks_count .= ' ('.$backlinks_count_bad.' bad links)';
            }else if($campaign->ExtBackLinks) $backlinks_count = number_format($campaign->ExtBackLinks); // if campaign is not finished 100% it has precheck. (mb remove check)
            else $backlinks_count = 0;
            if($campaign->stage == 0 && $campaign->stage_status == 2) {
                $link_d = '';
                $status = 'ready to start';
            }else $link_d = 'href="'.url('campaign/'.$campaign->id).'"';
            $rows[]= [
                '<input class="with_selected-item" type="checkbox" name="selected[]" value="'.$campaign->id.'">', //$('.with_selected-item:checked')
                "<a $link_d>".$campaign->url.'</a>',  // URL
                $backlinks_count/*.$campaign->subscription_plan_recommended()*/,            // total backlinks
                $campaign->updated_at,                                                  // last update
                $status,                                                                // status
                view('partials._ajax_campaigns_buttons', ['campaign' => $campaign, 'backlinks_count'=> substr($backlinks_count, 0, strpos($backlinks_count, ' ')), 'status' => $status])->render(), //$buttons
                "DT_RowId" => 'campaign-'.$campaign->id,
                "DT_RowClass" => 'campaign-row'.($status == 'in progress' ? ' in-progress':'').($status == 'finished' ? ' finished':'')
            ];
        }

        return response()->json([ "aaData" => $rows]);
    }

    public function getCampaignsClient(Request $request)
    {
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin && $request->has('client_id')) $user_id = $request->client_id;
        $campaigns = Campaign::where('user_id', $user_id);
        $user = User::find($user_id);

        $columns = ['url', 'total_backlinks', 'updated_at'];

        $rows = [];

        $total_count = $campaigns->count();

        // search ?
        if($request->sSearch) $campaigns = $campaigns->where('url', 'like', '%'.$request->sSearch.'%');

        // sort ?
        if($request->sSortDir_0) $campaigns = $campaigns->orderBy($columns[$request->iSortCol_0] , $request->sSortDir_0);

        $filtered_count = $campaigns->count();

        $campaigns_data = $campaigns->skip($request->iDisplayStart)
                                    ->take($request->iDisplayLength)
                                    ->get();

        foreach($campaigns_data as $campaign)
        {
            $status = $campaign->status();
            $backlinks_count = $campaign->getBacklinksCount(); //number_format($campaign->getBacklinks->count());
            $backlinks_bad = $campaign->getBacklinksBadCount(); //$campaign->getBacklinksBad->count();
            if($backlinks_bad) $backlinks_count .= ' ('.number_format($backlinks_bad).' bad links)';

            $rows[]= [
                '<a href="'.url('campaign/'.$campaign->id).'">'.$campaign->url.'</a>',  // URL
                $backlinks_count,                                                       // total backlinks
                $campaign->updated_at,                                                  // last update
                $status,                                                                // status
                'linkquidator',
                "DT_RowId" => 'campaign-'.$campaign->id,
                "DT_RowClass" => 'campaign-row'.($status == 'in progress' ? ' in-progress':'')
            ];

        }

        $response = [
            "sEcho"                 => intval( $request->sEcho ),
            "iTotalRecords"         => intval( $total_count ),
            "iTotalDisplayRecords"  => intval( $filtered_count ),
            "aaData"                => $rows
        ];

        return response()->json($response);
    }

    // show campaign progress on dashboard
    public function getCampaignsProgress(Request $request)
    {
        $input = $request->all();
        $result = [];
        if($input['campaign_ids']) {
            $campaigns = Campaign::select(['id','stage','stage_status'])
                ->whereIn('id', $input['campaign_ids'])->where('user_id', Auth::id())
                ->with(['getPrecheck' => function($query) {
                    $query->select('id', 'campaign_id', 'Status', 'ExtBackLinks');
                }])
                ->get();
            foreach($campaigns as $c) {
                $buttons = '';
                $progress = $c->progress();
                $status = $c->status();

                if($progress == 100)
                {
                    $backlinks_count = $c->getPrecheck?$c->getPrecheck->ExtBackLinks:0;
                    $buttons = view('partials._ajax_campaigns_buttons', ['campaign' => $c, 'backlinks_count'=> $backlinks_count, 'status' => $status])->render();
                }

                $result [$c->id]= ['progress' => $progress, 'buttons' => $buttons];
            }
        }

        return response()->json($result);
    }


    // show not finished campaign progress inside campaign
    public function getNotFinishedCampaignProgress(Request $request)
    {
//        $result = [];

        $campaign = Campaign::where('id', $request->get('id'))/*->where('user_id', Auth::id())*/->first();
        if($campaign) {
            return $campaign->progress();
        }else {
            return 1;
        }
//
//        if(!$campaign) $result['error'] = 'Campaign not found.';
//        else {
//            $result['status'] = $campaign->progress();
//            if($result['status'] != 100) {
//                $progress_text = 'Initiating campaign';
//                if($result['status'] > 10) $progress_text = 'Determining backlinks';
//                if($result['status'] > 35) $progress_text = 'Evaluating backlinks donors';
//                if($result['status'] > 45) $progress_text = 'Tracking social signals';
//                if($result['status'] > 55) $progress_text = 'Defining spam signals';
//                if($result['status'] > 80) $progress_text = 'Risk assessment';
//                if($result['status'] > 90) $progress_text = 'Gathering the final report';
//                $result['progress'] =   '<div class="progress progress-striped active progress-sm">
//                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'.$result['status'].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$result['status'].'%">
//                                            <span class="sr-only">'.$campaign->progress().'% Complete</span>
//                                            </div>
//                                         </div><p class="progress-bottom-text">'.$progress_text.' ...</p>';
//            }
//        }
//
//        return response()->json($result);
    }

    public function getNotFinishedCampaignProgressBacklink(Request $request)
    {
        $campaign = Campaign::where('id', $request->get('id'))/*->where('user_id', Auth::id())*/->first();
        if($campaign) {
            return $campaign->progress();
        }else {
            return 1;
        }

    }


    public function getTrafficChart(Request $request)
    {
        /** @var Campaign $campaign */
        $ga = \App\GoogleAnalitycs::selectRaw("any_value(users_organic) a, any_value(users_referral) b, DATE_FORMAT(date, '%Y-%m') d")->where('campaign_id', $request->campaign_id)->groupBy('d')->orderBy('d', 'desc')->limit(12)->get();
        $summaries = \App\CampaignSummary::selectRaw("any_value(total_backlinks) a, any_value(backlinks_bad) b, DATE_FORMAT(updated_at, '%Y-%m') d")->where('campaign_id', $request->campaign_id)->groupBy('d')->orderBy('d', 'desc')->limit(12)->get();

        $data = $data1 = [];
        foreach($ga as $item) {
            $data[] = [
                'y' => $item->d,
                'a' => $item->a,
                'b' => $item->b,
                'c' => $item->a + $item->b,
            ];
        }

        foreach($summaries as $item) {
            $data1[] = [
                'y' => $item->d,
                'a' => $item->a,
                'b' => $item->b
            ];
        }

        return [$data, array_reverse($data1)];
    }

    public function addCredits(Request $request)
    {
        if($request->get('credits')) {
            \DB::table('users')->where('id', $request->get('user'))->increment('backlinks', $request->get('credits'));
        }

        return back();
    }


    public function userAddBacklinks(Request $request)
    {
        $campaigns = \App\Models\UserAddBacklinks::select(['id', 'url', 'target_url', 'anchor_text', 'tags', 'follow'])
            ->where('campaign_id', $request->campaign_id);

        $columns = ['url', 'name', 'status', 'created_at'];

        $rows = [];

        $total_count = $filtered_count = $campaigns->count();
//        dd($total_count);

        // search ?
//        if($request->sSearch) {
//            $campaigns = $campaigns->where('c.url', 'like', '%'.$request->sSearch.'%');
//            $filtered_count = $campaigns->count();
//        }

        // sort ?
        if($request->sSortDir_0) $campaigns = $campaigns->orderBy($columns[$request->iSortCol_0] , $request->sSortDir_0);


        $campaigns_data = $campaigns->skip($request->iDisplayStart)
            ->take(10)
            ->get();

        foreach($campaigns_data as $campaign)
        {
            $rows[]= [
                '<a href="'.url('campaign/'.$campaign->campaign_id).'">'.$campaign->url.'</a>',  // URL
                $campaign->target_url,
                $campaign->anchor_text,
                $campaign->tags,
                $campaign->follow?'No':'Yes',                                                  // last update
                '<a href="' . '/user/add_backlinks/' . $campaign->id . '" class="btn btn-danger btn-xs delete_campaign" data-id="'.$campaign->id.'" data-campaign_url="'.$campaign->url.'" title="Delete">
                    <i class="fa fa-trash-o"></i>
                </a>',
            ];

        }

        $response = [
            "sEcho"                 => intval( $request->sEcho ),
            "iTotalRecords"         => intval( $total_count ),
            "iTotalDisplayRecords"  => intval( $filtered_count ),
            "aaData"                => $rows
        ];

        return response()->json($response);
    }


    public function userCheckBacklinks(Request $request)
    {
        if(!$request->full) {
            $campaigns = \App\Models\UserCheckBacklinks::select(['id', 'url', 'target_url', 'anchor_text', 'no_follow'])
                ->where('user_id', auth()->id());
            $columns = ['url', 'target_url', 'anchor_text', 'no_follow'];
        }else {
            $campaigns = \App\Models\UserCheckBacklinks::select(['id', 'url', 'anchor_text', 'no_follow', 'DomainCitationFlow', 'DomainTrustFlow', 'social_rank', 'total_rank', 'referral_influence'])
                ->where('user_id', auth()->id());
            $columns = ['url', 'no_follow', 'DomainCitationFlow', 'DomainTrustFlow', 'social_rank', 'total_rank', 'referral_influence'];
        }

        $rows = [];

        $total_count = $filtered_count = $campaigns->count();
//        dd($total_count);

        // search ?
//        if($request->sSearch) {
//            $campaigns = $campaigns->where('c.url', 'like', '%'.$request->sSearch.'%');
//            $filtered_count = $campaigns->count();
//        }

        // sort ?
        if($request->sSortDir_0) $campaigns = $campaigns->orderBy($columns[$request->iSortCol_0] , $request->sSortDir_0);


        $campaigns_data = $campaigns->skip($request->iDisplayStart)
            ->take(10)
            ->get();

        foreach($campaigns_data as $campaign)
        {
            if(!$request->full)
                $rows[]= [
                    $campaign->url,  // URL
                    $campaign->target_url,
                    $campaign->anchor_text,
                    $campaign->no_follow?'Yes':'No',
                    '<a href="' . '/user/check_backlinks/' . $campaign->id . '" class="btn btn-danger btn-xs delete_campaign" data-id="'.$campaign->id.'" data-campaign_url="'.$campaign->url.'" title="Delete">
                        <i class="fa fa-trash-o"></i>
                    </a>',
                ];
            else {
                $rank = Campaign::rank_backlink($campaign->total_rank);
                $rows[] = [
                    $campaign->url,  // URL
                    $campaign->no_follow ? 'Yes' : 'No',
                    $campaign->DomainTrustFlow,
                    $campaign->DomainCitationFlow,
                    $campaign->social_rank,
                    $campaign->referral_influence,
                    '<span class="' . Campaign::rank_backlink_badge_class($rank) . '">' . $rank . '</span> ', // Quality
                ];
            }

        }

        $response = [
            "sEcho"                 => intval( $request->sEcho ),
            "iTotalRecords"         => intval( $total_count ),
            "iTotalDisplayRecords"  => intval( $filtered_count ),
            "aaData"                => $rows
        ];

        return response()->json($response);
    }

    public function notifications(Request $request)
    {
        $campaigns = \App\Notification::select(['id', 'type', 'msg', 'created_at', 'url'])
            ->where('user_id', auth()->id());
        $columns = ['type', 'msg', 'created_at'];

        $rows = [];

//        dd($request->iSortCol_0);

        $total_count = $filtered_count = $campaigns->count();

        // sort ?
        if($request->sSortDir_0) $campaigns = $campaigns->orderBy($columns[$request->iSortCol_0] , $request->sSortDir_0);

        $campaigns_data = $campaigns->skip($request->iDisplayStart)
            ->take(10)
            ->get();

        foreach($campaigns_data as $campaign)
        {
            $rows[]= [
                '<div class="notification-type type-'.$campaign->type.'"></div>',
                $campaign->msg,  // URL
                $campaign->created_at->toDateTimeString(),
                '<a href="' . $campaign->url . '" class="btn btn-info btn-xs">details</a>',
            ];

        }

        $response = [
            "sEcho"                 => intval( $request->sEcho ),
            "iTotalRecords"         => intval( $total_count ),
            "iTotalDisplayRecords"  => intval( $filtered_count ),
            "aaData"                => $rows
        ];

        return response()->json($response);
    }

}
