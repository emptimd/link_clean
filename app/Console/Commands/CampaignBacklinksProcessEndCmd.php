<?php

namespace App\Console\Commands;

use App\Models\CampaignBacklinkStash;
use App\Models\Campaign;
use App\Models\CampaignDomains;
use App\Models\MajesticApiCalls;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CampaignBacklinksProcessEndCmd extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:backlinks_process_end {id : The ID of campaign}';

    /**
     * Get all data from files and insert it in campaign_backlinks_stash, topical_trust_targets
     *
     * @var string
     */
    protected $description = 'Launches Campaign backlink data processing.';

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

        $backlinks = $domains_t = [];
        $backlinks_count = 0;


        $domains = CampaignDomains::whereCampaignId($campaign->id)->pluck('id', 'domain');


        if($filename->method == 'DownloadBackLinks') {
            if(!Storage::disk('local')->exists($filename->callback)) {
                echo 'File not found';
                return;
            }

            foreach(explode(PHP_EOL, \Storage::disk('local')->get($filename->callback)) as $line) {
                if(!$backlinks_count++) continue;
                // @TODO for test only
                $b = str_getcsv($line);
                if(!isset($b[1])) break;


                preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,8})$/i', parse_url($b[1], PHP_URL_HOST), $regs);
                if(!isset($regs['domain'])) {
                    $domain = str_replace('www.', '', parse_url($b[1], PHP_URL_HOST));
                }else
                    $domain = str_replace('www.', '', $regs['domain']);


                if($domain) {
                    if(isset($domains[$domain]))
                        $did = $domains[$domain];
                    else { // UPD. so majestic didnt give us the domain for this url. We should get domain from url. and insert it in campaign_domains.
                        $did = CampaignDomains::insertGetId([
                            'domain' => $domain,
                            'CitationFlow' => 0,
                            'TrustFlow' => 0,
                            'ExtBackLinks' => 0,
                            'country' => '',
                            'ip' => 0,
                            'campaign_id' => $campaign->id,
                            'domain_rank' => 0
                        ]);
                        $domains[$domain] = $did;
                    }
                }else continue;


                if($b[4] == '+' || $b[4] == '')
                    $findxd = date('Y-m-d');
                else $findxd = $b[4];


                $backlinks[] = [
                        'campaign_id'           => $campaign->id,
                        'SourceURL'             => (mb_strlen($b[1]) > 1000) ? mb_substr($b[1],0,1000) : $b[1],
                        'ACRank'                => 0,
                        'AnchorText'            => (mb_strlen($b[2]) > 255) ? mb_substr($b[2],0,255) : $b[2],
                        'Date'                  => $b[3],
                        'FlagFrame'             => $b[8] ? 1 : 0,
                        'FlagNoFollow'          => $b[5] ? 1 : 0,
                        'FlagImages'            => $b[6] ? 1 : 0,
                        'FlagAltText'           => $b[10]? 1 : 0,
                        'FlagMention'           => $b[11]? 1 : 0,
                        'TargetURL'             => (mb_strlen($b[0]) > 255) ? mb_substr($b[0],0,255) : $b[0],
                        'FirstIndexedDate'      => $findxd,
                        'SourceCitationFlow'    => $b[12] ? $b[12]:0,
                        'SourceTrustFlow'       => $b[13] ? $b[13]:0,
                        'malware' => 0,
                        'domain_id' => $did
                    ];

                    if($backlinks_count %1000 == 0) {
                        CampaignBacklinkStash::insert($backlinks);
                        unset($backlinks);
                    }

            }


            if(isset($backlinks)) {
                CampaignBacklinkStash::insert($backlinks);
            }


        }else { // Here if GetBacklinksData or GetDemo
            if(!Storage::disk('local')->exists($filename->response)) {
                echo 'File not found';
                return;
            }

            $file = json_decode(\Storage::disk('local')->get($filename->response), true);


            if(isset($file['DataTables']['DomainsInfo']) && $file['DataTables']['DomainsInfo'])
                foreach($file['DataTables']['DomainsInfo']['Data'] as $domain)
                    $domains_t[$domain['DomainID']] = $domain['Domain'];

            foreach($file['DataTables']['BackLinks']['Data'] as $b) {
                $backlinks_count++;
                // insert data in backlinks array.
                $backlinks []= [
                        'campaign_id'           => $campaign->id,
                        'SourceURL'             => (mb_strlen($b['SourceURL']) > 1000) ? mb_substr($b['SourceURL'],0,1000) : $b['SourceURL'],
                        'ACRank'                => $b['ACRank'],
                        'AnchorText'            => (mb_strlen($b['AnchorText']) > 255) ? mb_substr($b['AnchorText'],0,255) : $b['AnchorText'],
                        'Date'                  => $b['Date'],
                        'FlagFrame'             => $b['FlagFrame'],
                        'FlagNoFollow'          => $b['FlagNoFollow'],
                        'FlagImages'            => $b['FlagImages'],
                        'FlagAltText'           => $b['FlagAltText'],
                        'FlagMention'           => $b['FlagMention'],
                        'TargetURL'             => (mb_strlen($b['TargetURL']) > 255) ? mb_substr($b['TargetURL'],0,255) : $b['TargetURL'],
                        'FirstIndexedDate'      => $b['FirstIndexedDate'] == '+' ? date('Y-m-d') : $b['FirstIndexedDate'],
                        'SourceCitationFlow'    => $b['SourceCitationFlow'],
                        'SourceTrustFlow'       => $b['SourceTrustFlow'],
                        'malware' => 0,
                        'domain_id' => $domains[$domains_t[$b['DomainID']]],
                    ];
                // if we have 1000 backlinks we insert them, and empty the array.
                if($backlinks_count %1000 == 0) {
                    CampaignBacklinkStash::insert($backlinks);
                    unset($backlinks);
                }
            }

            if(isset($backlinks)) {
                CampaignBacklinkStash::insert($backlinks);
            }

        }


        $filename->processed = 1;
        $filename->save();

        // processing is done, finish stage
        if($campaign->stage != 10) {
            $campaign->stage_status = 4;
            $campaign->save();
        }

        dispatch(new \App\Jobs\CampaignBacklinksAnalyzer($campaign->id));

        echo 1;
    }
}
