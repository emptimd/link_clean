<?php

namespace App\Classes;


use App\Models\Campaign;
use App\Models\CampaignBacklink;
use App\Models\CampaignBacklinkStash;
use App\Models\CampaignBacklinkTag;
use App\Models\Market;
use App\Models\MarketBacklink;
use App\Models\UserAddBacklinks;
use App\Models\UserCheckBacklinks;

class UrlanalyzerAPINEW {

	protected $client;

	private $app_id, $app_key;

	private $secret  	= 'hiddend_test';
	private $endpoint 	= 'hiddend_test';

	private $request;
	public $response;

	public function __construct($data)
	{
        $this->client = new \GuzzleHttp\Client();
		$this->request    = (object)$data;

        $this->app_id = env('URLANALYZER_ID', false);
        $this->app_key = env('URLANALYZER_KEY', false);

        if(!$this->app_id || !$this->app_key) die('ERROR - NO URLANALYZER CREDENTIALS SET');
        // @TODO REMOVE log_before|after and db table urlanalyzer_api_calls
	}

    // save callback data only (processing in different thread)
    public static function callback($campaign_id, $data)
    {
        ini_set('max_execution_time', 600);
        // @TODO MB WE NEED TO DISABLE HERE GC, check speed for 9k and 11k backlinks.

        /** @var Campaign $campaign*/
        $campaign = Campaign::where('id', $campaign_id)->first();

        $domains = $insert = $isert_analyzer = $gas = [];
        // Take GA info from DB and merge with $backlinks array.
        foreach(\DB::table('google_analitycs_stash')->select('SourceUrl', 'TargetUrl', 'views')->where('campaign_id', $campaign->id)->get() as $ga) {
            // GA stores urls without protocol and www. So we need to check each combination.
            if(strlen($ga->TargetUrl) == 1) $gas[rtrim($ga->SourceUrl, '/')][$ga->TargetUrl] = $ga->views;
            else $gas[rtrim($ga->SourceUrl, '/')][rtrim($ga->TargetUrl, '/')] = $ga->views;
        }

        // @TODO mb ad join of the domain social to daget social_data
        //campaign_backlinks_stash
        foreach(\DB::select('SELECT SourceURL,ACRank,AnchorText,Date,FlagFrame,FlagNoFollow,FlagImages,FlagAltText,FlagMention,TargetURL,FirstIndexedDate,SourceCitationFlow,SourceTrustFlow,malware,domain_id,is_disabled,CitationFlow,TrustFlow,ExtBackLinks,country,ip,social_rank,domain from campaign_backlinks_stash cbs
         INNER JOIN campaign_domains cd on cd.id=cbs.domain_id
         INNER JOIN domain_social ds on cd.id=ds.id
         where cbs.campaign_id=? limit 100000 ', [$campaign_id]) as $item) {
            $changed = false;
            $url = $item->SourceURL;
            $prs = parse_url($url);
            $views = 0;
            if($gas) {
                if(isset($prs['path']))
                    $sa = $prs['host'].rtrim($prs['path'], '/');
                else
                    $sa = $prs['host'];

                $path = parse_url(rtrim($item->TargetURL, '/'), PHP_URL_PATH) ?? '/';

                if(isset($gas[$sa])) {
                    foreach($gas[$sa] as $key => $val) {
                        if($path == $key) {
                            $views = $val;break;
                        }
                    }
                }
            }

            $arr = explode('?', $url, 2);
            if(isset($arr[1])) {
                parse_str($arr[1], $output);
                foreach($output as $key => $i) {
                    if(strpos($key, 'utm_') === 0 || strpos($key, 'reply') !== false || strpos($key, 'login') === 0 || strpos($key, 'comment') === 0) {
                        $changed = true;
                        unset($output[$key]);
                    }
                }
                if($changed)
                    $url = $arr[0] . '?'. http_build_query($output);
            }

            // new

            $tlds = explode('.', $prs['host']); // @TODO insert tlds from majestic domains info and join them.

            $arr = [
                'campaign_id' => $campaign->id,
                'recheck_nr' => $campaign->recheck_nr,
                'SourceURL' => $item->SourceURL,
                'social_rank' => $item->social_rank,
                'FlagNoFollow'          => $item->FlagNoFollow,
                'SourceCitationFlow'    => $item->SourceCitationFlow,
                'SourceTrustFlow'       => $item->SourceTrustFlow,
                'content_count' => 0,
                'text_html_ratio' => 0.000,
                'anchor_ratio' => 0.000,
                'outgoing_backlinks' => 0,
                'page_load_time' => 0.00,
                'unreachable' => 0,
                'views' => $views,
                'malware' => $item->malware,
                'DomainCitationFlow' => $item->CitationFlow,
                'DomainTrustFlow' => $item->TrustFlow,
                'DomainExtBackLinks' => $item->ExtBackLinks,
            ];

            if(isset($domains[$item->domain]) && isset($domains[$item->domain][$url])) {

                $insert[] = [
                    'campaign_id' => $campaign->id,
                    'recheck_nr' => $campaign->recheck_nr,
                    'SourceURL' => $item->SourceURL,
                    'ACRank'                => $item->ACRank,
                    'AnchorText'            => $item->AnchorText,
                    'Date'                  => $item->Date,
                    'FlagFrame'             => $item->FlagFrame,
                    'FlagNoFollow'          => $item->FlagNoFollow,
                    'FlagImages'            => $item->FlagImages,
                    'FlagAltText'           => $item->FlagAltText,
                    'FlagMention'           => $item->FlagMention,
                    'TargetURL'             => $item->TargetURL,
                    'FirstIndexedDate'      => $item->FirstIndexedDate,
                    'SourceCitationFlow'    => $item->SourceCitationFlow,
                    'SourceTrustFlow'       => $item->SourceTrustFlow,
                    'domain_id' => $item->domain_id,
                    'views' => $views,
                    'malware' => $item->malware,
                    'unreachable' => $domains[$item->domain][$url]['unreachable'],
                    'link_rank' => $domains[$item->domain][$url]['link_rank'],
                    'total_rank' => $domains[$item->domain][$url]['total_rank'],
                    'referral_influence' => $domains[$item->domain][$url]['referral_influence'],
                    'http_code' => $domains[$item->domain][$url]['http_code'],
                    'is_disabled' => $item->is_disabled,
                ];

                $isert_analyzer[] = [
                    'content_count' => $domains[$item->domain][$url]['content_count'],
                    'text_html_ratio' => $domains[$item->domain][$url]['text_html_ratio'],
                    'anchor_ratio' => $domains[$item->domain][$url]['anchor_ratio'],
                    'outgoing_backlinks' => $domains[$item->domain][$url]['outgoing_backlinks'],
                    'page_load_time' => $domains[$item->domain][$url]['page_load_time'],
                    'unreachable' => $domains[$item->domain][$url]['unreachable'],
                ];

            }elseif(isset($data[$url])) {
                if($data[$url]['http_code'] != 200) { //unreacheble
                    $arr['unreachable'] = 1;
                    $arr['page_load_time'] = $data[$url]['page_load_time'];
                    $arr['http_code'] = $data[$url]['http_code'];

                    $redirect = in_array($arr['http_code'], [301, 302, 303, 307, 308]);

                    $arr['link_rank'] = $campaign->calculate_link_rank($arr);
                    $arr['total_rank'] = $campaign->calculate_link($arr, $tlds, (bool)$gas, $redirect);
                    $arr['referral_influence'] = $campaign->calculate_ref_influence($arr, $tlds, (bool)$gas, $redirect, $data[$url]['feed']);
                }else {
                    $arr['http_code'] = 200;
                    $arr['content_count'] = $data[$url]['content_count'];
                    $arr['text_html_ratio'] = $data[$url]['text_html_ratio'];
                    $arr['anchor_ratio'] = $data[$url]['anchor_ratio'];
                    $arr['outgoing_backlinks'] = $data[$url]['outgoing_backlinks'];
                    $arr['page_load_time'] = $data[$url]['page_load_time'];

                    $arr['link_rank'] = $campaign->calculate_link_rank($arr);
                    $arr['total_rank'] = $campaign->calculate_link($arr, $tlds, (bool)$gas);
                    $arr['referral_influence'] = $campaign->calculate_ref_influence($arr, $tlds, (bool)$gas, false, $data[$url]['feed']);
                }

                //add result into domains for 2 reasons.
                $domains[$item->domain][$url] = [
                    'http_code' => $arr['http_code'],
                    'content_count' => $arr['content_count'],
                    'text_html_ratio' => $arr['text_html_ratio'],
                    'anchor_ratio' => $arr['anchor_ratio'],
                    'outgoing_backlinks' => $arr['outgoing_backlinks'],
                    'page_load_time' => $arr['page_load_time'],
                    'unreachable' => $arr['unreachable'],
                    'link_rank' => $arr['link_rank'],
                    'total_rank' => $arr['total_rank'],
                    'referral_influence' => $arr['referral_influence'],
                ];

                $insert[] = [
                    'campaign_id' => $campaign->id,
                    'recheck_nr' => $campaign->recheck_nr,
                    'SourceURL' => $item->SourceURL,
                    'ACRank'                => $item->ACRank,
                    'AnchorText'            => $item->AnchorText,
                    'Date'                  => $item->Date,
                    'FlagFrame'             => $item->FlagFrame,
                    'FlagNoFollow'          => $item->FlagNoFollow,
                    'FlagImages'            => $item->FlagImages,
                    'FlagAltText'           => $item->FlagAltText,
                    'FlagMention'           => $item->FlagMention,
                    'TargetURL'             => $item->TargetURL,
                    'FirstIndexedDate'      => $item->FirstIndexedDate,
                    'SourceCitationFlow'    => $item->SourceCitationFlow,
                    'SourceTrustFlow'       => $item->SourceTrustFlow,
                    'domain_id' => $item->domain_id,
                    'views' => $views,
                    'malware' => $item->malware,
                    'unreachable' => $arr['unreachable'],
                    'link_rank' => $arr['link_rank'],
                    'total_rank' => $arr['total_rank'],
                    'referral_influence' => $arr['referral_influence'],
                    'http_code' => $arr['http_code'],
                    'is_disabled' => $item->is_disabled,
                ];
                $isert_analyzer[] = [
                    'content_count' => $arr['content_count'],
                    'text_html_ratio' => $arr['text_html_ratio'],
                    'anchor_ratio' => $arr['anchor_ratio'],
                    'outgoing_backlinks' => $arr['outgoing_backlinks'],
                    'page_load_time' => $arr['page_load_time'],
                    'unreachable' => $arr['unreachable'],
                ];


            }else { // here if we do not have current SourceURL in analyzer's response. (so we take a random calulated data from $domains)
                if(!isset($domains[$item->domain])) continue; // @TODO here we have o domain info because analyzer returns us 1k backlinks per domain in a random order, so here the first url canot be in analyzer response.
                $key = array_rand($domains[$item->domain], 1);

                $insert[] = [
                    'campaign_id' => $campaign->id,
                    'recheck_nr' => $campaign->recheck_nr,
                    'SourceURL' => $item->SourceURL,
                    'ACRank'                => $item->ACRank,
                    'AnchorText'            => $item->AnchorText,
                    'Date'                  => $item->Date,
                    'FlagFrame'             => $item->FlagFrame,
                    'FlagNoFollow'          => $item->FlagNoFollow,
                    'FlagImages'            => $item->FlagImages,
                    'FlagAltText'           => $item->FlagAltText,
                    'FlagMention'           => $item->FlagMention,
                    'TargetURL'             => $item->TargetURL,
                    'FirstIndexedDate'      => $item->FirstIndexedDate,
                    'SourceCitationFlow'    => $item->SourceCitationFlow,
                    'SourceTrustFlow'       => $item->SourceTrustFlow,
                    'domain_id' => $item->domain_id,
                    'views' => $views,
                    'malware' => $item->malware,
                    'unreachable' => $domains[$item->domain][$key]['unreachable'],
                    'link_rank' => $domains[$item->domain][$key]['link_rank'],
                    'total_rank' => $domains[$item->domain][$key]['total_rank'],
                    'referral_influence' => $domains[$item->domain][$key]['referral_influence'],
                    'http_code' => $domains[$item->domain][$key]['http_code'],
                    'is_disabled' => $item->is_disabled,
                ];
                $isert_analyzer[] = [
                    'content_count' => $domains[$item->domain][$key]['content_count'],
                    'text_html_ratio' => $domains[$item->domain][$key]['text_html_ratio'],
                    'anchor_ratio' => $domains[$item->domain][$key]['anchor_ratio'],
                    'outgoing_backlinks' => $domains[$item->domain][$key]['outgoing_backlinks'],
                    'page_load_time' => $domains[$item->domain][$key]['page_load_time'],
                    'unreachable' => $domains[$item->domain][$key]['unreachable'],
                ];
            }

        }

        // We processed all backliks, now insert them.
        foreach(array_chunk($insert, 1000) as $chunk) CampaignBacklink::insert($chunk);
        foreach(array_chunk($isert_analyzer, 1000) as $chunk2) \DB::table('campaign_analyzer')->insert($chunk2);

        CampaignBacklinkStash::where('campaign_id', $campaign->id)->limit(100000)->delete();

        // finalize
        if(!CampaignBacklinkStash::where('campaign_id', $campaign->id)->count()) {
            if($campaign->recheck_nr > 1)
                CampaignBacklink::where('campaign_id', $campaign->id)->where('recheck_nr', $campaign->recheck_nr-2)->delete();

            // Clear google_analitycs_stash table.
            \DB::table('google_analitycs_stash')->where('campaign_id', $campaign->id)->delete();

            $campaign->finalize();
            return ['status' => 'delete'];//delete
        }

        $campaign->finalize();
        dispatch(new \App\Jobs\CampaignBacklinksAnalyzer($campaign->id));
        return ['status' => 'success'];
    }

    public static function callbackMarket($campaign_id, $data)
    {
        ini_set('max_execution_time', 300); //test

        $campaign = Campaign::find($campaign_id);
        $market = Market::where('campaign_id', $campaign_id)->where('status', 2)->first();
        $market_backlinks = MarketBacklink::where('market_id', $market->id)->get();
        $campaign_domains = \DB::select("SELECT cd.id, cd.domain, cd.ExtBackLinks, cd.CitationFlow, cd.TrustFlow, ds.social_rank
FROM campaign_domains cd INNER JOIN domain_social ds on ds.id=cd.id WHERE cd.campaign_id=$campaign_id");

        $domains = $insert = $isert_analyzer = $gas = [];

        foreach($campaign_domains as $item) {
            $domains[$item->domain] = [
                'ExtBackLinks' => $item->ExtBackLinks,
                'CitationFlow' => $item->CitationFlow,
                'TrustFlow' => $item->TrustFlow,
                'social_rank' => $item->social_rank,
                'id' => $item->id,
            ];
        }

        foreach($market_backlinks as $backlink) {
            if(!isset($data[$backlink->url])) continue;

            $prs = parse_url($backlink->url);

            preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,8})$/i', $prs['host'], $regs);
            $tlds = explode('.', $prs['host']);

            $arr = [
                'FlagNoFollow'          => $backlink->follow,
                'TargetURL'             => $backlink->target_url,
                'social_rank' => $domains[$regs['domain']]['social_rank'],
                'SourceCitationFlow'    => 1,
                'SourceTrustFlow'       => 1,
                'unreachable' => 0,
                'views' => 0,
                'malware' => 0,
                'DomainCitationFlow' => $domains[$regs['domain']]['CitationFlow'],
                'DomainTrustFlow' => $domains[$regs['domain']]['TrustFlow'],
                'DomainExtBackLinks' => $domains[$regs['domain']]['ExtBackLinks'],
            ];

            $arr['http_code'] = 200;
            $arr['content_count'] = $data[$backlink->url]['content_count'];
            $arr['text_html_ratio'] = $data[$backlink->url]['text_html_ratio'];
            $arr['anchor_ratio'] = $data[$backlink->url]['anchor_ratio'];
            $arr['outgoing_backlinks'] = $data[$backlink->url]['outgoing_backlinks'];
            $arr['page_load_time'] = $data[$backlink->url]['page_load_time'];

            $arr['link_rank'] = $campaign->calculate_link_rank($arr);
            $arr['total_rank'] = $campaign->calculate_link($arr, $tlds, (bool)$gas);
            $arr['referral_influence'] = $campaign->calculate_ref_influence($arr, $tlds, (bool)$gas, false, 0);

            /*INSERTS*/

            $isert_analyzer[] = [
                'content_count' => $arr['content_count'],
                'text_html_ratio' => $arr['text_html_ratio'],
                'anchor_ratio' => $arr['anchor_ratio'],
                'outgoing_backlinks' => $arr['outgoing_backlinks'],
                'page_load_time' => $arr['page_load_time'],
                'unreachable' => $arr['unreachable'],
            ];

            $insert[] = [
                'campaign_id' => $campaign->id,
                'recheck_nr' => $campaign->recheck_nr,
                'SourceURL' => $backlink->url,
                'ACRank'                => 0,
                'AnchorText'            => $backlink->anchor_text,
                'Date'                  => date('Y-m-d'),
                'FlagFrame'             => 0,
                'FlagNoFollow'          => $backlink->follow,
                'FlagImages'            => 0,
                'FlagAltText'           => 0,
                'FlagMention'           => 0,
                'TargetURL'             => $backlink->target_url,
                'FirstIndexedDate'      => date('Y-m-d'),
                'SourceCitationFlow'    => 1,
                'SourceTrustFlow'       => 1,
                'domain_id' => $domains[$regs['domain']]['id'],
                'unreachable' => 0,
                'views' => 0,
                'malware' => 0,
                'link_rank' => $arr['link_rank'],
                'total_rank' => $arr['total_rank'],
                'referral_influence' => $arr['referral_influence'],
                'http_code' => $arr['http_code'],
                'paid' => 1
            ];

        }

        // We processed all backliks, now insert them.
        foreach(array_chunk($insert, 1000) as $chunk) CampaignBacklink::insert($chunk);
        foreach(array_chunk($isert_analyzer, 1000) as $chunk2) \DB::table('campaign_analyzer')->insert($chunk2);

        // now we also insert tags
        $tags = CampaignBacklink::where('campaign_id', $campaign->id)->limit(count($insert))->orderBy('id', 'desc')->pluck('id');
        $insert_tags = [];
        foreach($tags as $tag) {
            $insert_tags[] = [
                'backlink_id' => $tag,
                'tag' => 'paid'
            ];
        }

        CampaignBacklinkTag::insert($insert_tags);

        return ['status' => 'delete'];
    }

    public static function callbackUserAddedBacklinks($campaign_id, $data)
    {
        ini_set('max_execution_time', 300); //test

        $campaign = Campaign::find($campaign_id);
        $market_backlinks = UserAddBacklinks::where('campaign_id', $campaign_id)->get();
        $campaign_domains = \DB::select("SELECT cd.id, cd.domain, cd.ExtBackLinks, cd.CitationFlow, cd.TrustFlow, ds.social_rank
FROM campaign_domains cd INNER JOIN domain_social ds on ds.id=cd.id WHERE cd.campaign_id=$campaign_id");

        $domains = $insert = $isert_analyzer = $gas = $backlink_tags = [];

        foreach($campaign_domains as $item) {
            $domains[$item->domain] = [
                'ExtBackLinks' => $item->ExtBackLinks,
                'CitationFlow' => $item->CitationFlow,
                'TrustFlow' => $item->TrustFlow,
                'social_rank' => $item->social_rank,
                'id' => $item->id,
            ];
        }

        foreach($market_backlinks as $backlink) {
            if(!isset($data[$backlink->url])) continue;

            $prs = parse_url($backlink->url);

            preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,8})$/i', $prs['host'], $regs);
            $tlds = explode('.', $prs['host']);

            $arr = [
                'FlagNoFollow'          => $backlink->follow,
                'TargetURL'             => $backlink->target_url,
                'social_rank' => $domains[$regs['domain']]['social_rank'],
                'SourceCitationFlow'    => 1,
                'SourceTrustFlow'       => 1,
                'unreachable' => 0,
                'views' => 0,
                'malware' => 0,
                'DomainCitationFlow' => $domains[$regs['domain']]['CitationFlow'],
                'DomainTrustFlow' => $domains[$regs['domain']]['TrustFlow'],
                'DomainExtBackLinks' => $domains[$regs['domain']]['ExtBackLinks'],
            ];

            $arr['http_code'] = 200;
            $arr['content_count'] = $data[$backlink->url]['content_count'];
            $arr['text_html_ratio'] = $data[$backlink->url]['text_html_ratio'];
            $arr['anchor_ratio'] = $data[$backlink->url]['anchor_ratio'];
            $arr['outgoing_backlinks'] = $data[$backlink->url]['outgoing_backlinks'];
            $arr['page_load_time'] = $data[$backlink->url]['page_load_time'];

            $arr['link_rank'] = $campaign->calculate_link_rank($arr);
            $arr['total_rank'] = $campaign->calculate_link($arr, $tlds, (bool)$gas);
            $arr['referral_influence'] = $campaign->calculate_ref_influence($arr, $tlds, (bool)$gas, false, 0);

            /*INSERTS*/
            $isert_analyzer[] = [
                'content_count' => $arr['content_count'],
                'text_html_ratio' => $arr['text_html_ratio'],
                'anchor_ratio' => $arr['anchor_ratio'],
                'outgoing_backlinks' => $arr['outgoing_backlinks'],
                'page_load_time' => $arr['page_load_time'],
                'unreachable' => $arr['unreachable'],
            ];

            $insert[] = [
                'campaign_id' => $campaign->id,
                'recheck_nr' => $campaign->recheck_nr,
                'SourceURL' => $backlink->url,
                'ACRank'                => 0,
                'AnchorText'            => $backlink->anchor_text,
                'Date'                  => date('Y-m-d'),
                'FlagFrame'             => 0,
                'FlagNoFollow'          => $backlink->follow,
                'FlagImages'            => 0,
                'FlagAltText'           => 0,
                'FlagMention'           => 0,
                'TargetURL'             => $backlink->target_url,
                'FirstIndexedDate'      => date('Y-m-d'),
                'SourceCitationFlow'    => 1,
                'SourceTrustFlow'       => 1,
                'domain_id' => $domains[$regs['domain']]['id'],
                'unreachable' => 0,
                'views' => 0,
                'malware' => 0,
                'link_rank' => $arr['link_rank'],
                'total_rank' => $arr['total_rank'],
                'referral_influence' => $arr['referral_influence'],
                'http_code' => $arr['http_code'],
                'paid' => 0
            ];

            // NEW add backlink tags, from user_added_backlinks
            $backlink_tags[] = [
                'tag' => 'added,'.$backlink->tags
            ];
        }

        // We processed all backliks, now insert them.
        foreach(array_chunk($insert, 1000) as $chunk) CampaignBacklink::insert($chunk);
        foreach(array_chunk($isert_analyzer, 1000) as $chunk2) \DB::table('campaign_analyzer')->insert($chunk2);

        // now we also insert tags
        $tags = CampaignBacklink::where('campaign_id', $campaign->id)->limit(count($insert))->orderBy('id', 'desc')->pluck('id')->toArray();
        $inversed_backlinks = array_reverse($tags);

        $insert_tags = [];
        $bic=0;
        foreach($backlink_tags as $tag) {
            $insert_tags[] = [
                'backlink_id' => $inversed_backlinks[$bic++],
                'tag' => $tag['tag']
            ];
        }

        CampaignBacklinkTag::insert($insert_tags);

        return ['status' => 'delete'];
    }


    public static function callbackUserCheckedBacklinks($campaign_id, $data)
    {
        ini_set('max_execution_time', 300); //test

        /** @var Campaign $campaign */
        $campaign = Campaign::find($campaign_id);

        /** @var UserCheckBacklinks $market_backlinks */
        $market_backlinks = UserCheckBacklinks::where('user_id', $campaign->user_id)->get();

        /** @var UserCheckBacklinks $backlink */
        foreach($market_backlinks as $backlink) {
            if(!isset($data[$backlink->url])) continue;

            $prs = parse_url($backlink->url);

            preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,8})$/i', $prs['host'], $regs);
            $tlds = explode('.', $prs['host']);

            $arr = [
                'FlagNoFollow'          => $backlink->no_follow,
                'TargetURL'             => $backlink->target_url,
                'social_rank' => $backlink->social_rank,
                'SourceCitationFlow'    => 1,
                'SourceTrustFlow'       => 1,
                'unreachable' => 0,
                'views' => 0,
                'malware' => 0,
                'DomainCitationFlow' => $backlink->DomainCitationFlow,
                'DomainTrustFlow' => $backlink->DomainTrustFlow,
                'DomainExtBackLinks' => $backlink->DomainExtBackLinks,
            ];

            $arr['http_code'] = 200;
            $arr['content_count'] = $data[$backlink->url]['content_count'];
            $arr['text_html_ratio'] = $data[$backlink->url]['text_html_ratio'];
            $arr['anchor_ratio'] = $data[$backlink->url]['anchor_ratio'];
            $arr['outgoing_backlinks'] = $data[$backlink->url]['outgoing_backlinks'];
            $arr['page_load_time'] = $data[$backlink->url]['page_load_time'];

            $arr['link_rank'] = $campaign->calculate_link_rank($arr);
            $arr['total_rank'] = $campaign->calculate_link($arr, $tlds, false);
            $arr['referral_influence'] = $campaign->calculate_ref_influence($arr, $tlds, false, false, 0);

            /*Update backlink*/
            $backlink->total_rank = $arr['total_rank'];
            $backlink->referral_influence = $arr['referral_influence'];
            $backlink->save();
        }

        return ['status' => 'delete'];
    }

	private function call($data = [])
	{
		if($this->request->method == 'register') $data['secret'] = $this->secret;
		else {
			$data['app_id']		= $this->app_id;
			$data['app_key']	= $this->app_key;
		}

        $response = $this->client->post($this->endpoint.$this->request->method, ['json' => $data]);

        $result = [
            'status' 	=> $response->getStatusCode(),
            'data'		=> json_decode($response->getBody()->getContents()),
        ];

        return $result;
    }

    /**
     * Register app with callback_url
     * @internal param array $options
     */
	public function register()
	{
		return $this->call([
			'callback_url' => $this->request->callback_url,
		]);
	}

	/**
	 * Analyze given url
	 */
	public function analyze()
	{
		return $this->call([
			'url' => $this->request->url,
            'campaign_id' => $this->request->campaign_id,
            'is_paid' => isset($this->request->is_paid) ? 1 : 0,
            'scenario' => isset($this->request->scenario) ? $this->request->scenario : null,
		]);
	}

    /**
     * Change campaign status
     * @internal param array $options
     */
    public function status()
    {
        return $this->call([
            'campaign_id' => $this->request->campaign_id,
        ]);
    }

}