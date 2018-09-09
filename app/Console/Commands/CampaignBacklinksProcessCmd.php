<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\CampaignDomains;
use App\Models\MajesticApiCalls;
use App\Models\TopicalTrustTarget;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CampaignBacklinksProcessCmd extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:backlinks_process {id : The ID of campaign}';

    /**
     * Get all data from files and insert it in campaign_backlinks_stash, topical_trust_targets
     *
     * @var string
     */
    protected $description = 'Launches Campaign backlink data processing of domains and topics.';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        // @TODO esli campani9 > 100k vse proishodit dolgo. t.k on 4itaet vesi fail vse takoi + GA.
        /** @var Campaign $campaign*/
        $campaign = Campaign::where('id', $this->argument('id'))->first();

        if(!$campaign) {
            echo 'Campaign not found.';
            return;
        }

        $filename = MajesticApiCalls::where('campaign_id', $campaign->id)
                ->whereRaw("processed = 0 and (method='DownloadBackLinks' or method='GetBackLinkData' or method='GetDemo')")
                ->first();

        if(!$filename) {
            echo 'Nothing to process';
            return;
        }

        $domains = $topics = [];

        if($filename->method == 'DownloadBackLinks') {
            if(!Storage::disk('local')->exists($filename->callback)) {
                echo 'File not found';
                return;
            }

            foreach(json_decode(\Storage::disk('local')->get($campaign->getMajesticDomain->response), true)['DataTables']['Results']['Data'] as $domain) {
                $cf = $domain['CitationFlow'] ?: 1; // lowest value = 1
                $domains[] = [
                    'domain' => $domain['Domain'],
                    'CitationFlow' => $domain['CitationFlow'],
                    'TrustFlow' => $domain['TrustFlow'],
                    'ExtBackLinks' => $domain['ExtBackLinks'] < 2147483647 ? $domain['ExtBackLinks'] : 2147483647,
                    'country' => $domain['CountryCode'],
                    'ip' => ip2long($domain['IP']),
                    'campaign_id' => $campaign->id,
                    'domain_rank' => round( ($cf/100*2+$cf/$cf*2+$cf/100)/5*100 , 2)
                ];

                // here we create new array of topics, only on the create of the campaign.
                if($campaign->recheck_nr == 0) {
                    $i=3; // previously we were taken 10
                    while($i--) {
                        if($domain["TopicalTrustFlow_Value_$i"])
                            $topics[] = [
                                'campaign_id' => $campaign->id,
                                'target_backlink_url' => $domain['Domain'],
                                'topic' => $domain["TopicalTrustFlow_Topic_$i"],
                                'links' => 0,
                                'topical_trust_flow' => $domain["TopicalTrustFlow_Value_$i"],
                                'links_from_ref_domains' => 0,
                                'ref_domains' => 0,
                                'pages' => 0,
                            ];
                    }
                }
            }

        }else { // Here if GetBacklinksData or GetDemo
            if(!Storage::disk('local')->exists($filename->response)) {
                echo 'File not found';
                return;
            }

            $file = json_decode(\Storage::disk('local')->get($filename->response), true);

            if(isset($file['DataTables']['DomainsInfo']) && $file['DataTables']['DomainsInfo']) {
                foreach($file['DataTables']['DomainsInfo']['Data'] as $domain) {
                    $cf = $domain['CitationFlow'] ?: 1; // lowest value = 1
                    $domains[] = [
                        'domain' => $domain['Domain'],
                        'CitationFlow' => $domain['CitationFlow'],
                        'TrustFlow' => $domain['TrustFlow'],
                        'ExtBackLinks' => $domain['ExtBackLinks'] < 2147483647 ? $domain['ExtBackLinks'] : 2147483647,
                        'country' => $domain['CountryCode'],
                        'ip' => ip2long($domain['IP']),
                        'campaign_id' => $campaign->id,
                        'domain_rank' => round( ($cf/100*2+$cf/$cf*2+$cf/100)/5*100 , 2)
                    ];
                    // here we create new array of topics
                    if($campaign->recheck_nr == 0) {
                        $i=3;
                        while($i--) {
                            if($domain["TopicalTrustFlow_Value_$i"])
                                $topics[] = [
                                    'campaign_id' => $campaign->id,
                                    'target_backlink_url' => $domain['Domain'],
                                    'topic' => $domain["TopicalTrustFlow_Topic_$i"],
                                    'links' => 0,
                                    'topical_trust_flow' => $domain["TopicalTrustFlow_Value_$i"],
                                    'links_from_ref_domains' => 0,
                                    'ref_domains' => 0,
                                    'pages' => 0,
                                ];
                        }
                    }
                }
            }
        }
        // here we insert domains and get their ids
        foreach(array_chunk($domains, 1000) as $dchunk) CampaignDomains::insert($dchunk);
        // topics
        if($topics) foreach(array_chunk($topics, 1000) as $chunk) TopicalTrustTarget::insert($chunk);

        dispatch(new \App\Jobs\CampaignBacklinksProcessEnd($campaign->id));

        echo 1;
    }
}
