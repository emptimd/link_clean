<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\CampaignDomains;
use App\Models\DomainSocial;
use App\Models\TargetSocial;
use Illuminate\Console\Command;

class CampaignEngagedCountCmd extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:engaged_count {id : The ID of campaign}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get finished Engagedcount api calls, and save data to db.';

    private $api_url = 'https://engagedcount.com/';
    private $api_key;

    protected $client;
    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        $this->api_key = env('ENGAGED_COUNT_KEY', false);
        if(!$this->api_key) die('ERROR - NO ENGAGED_COUNT_KEY SET');
        $this->client = new \GuzzleHttp\Client();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var Campaign $campaign*/
        $campaign = Campaign::find($this->argument('id'));

        if(!$campaign) {
            echo 'Campaign not found.';
            return;
        }

        $domains = CampaignDomains::whereCampaignId($campaign->id)->pluck('id', 'domain');

        $promises = $insert = $insert_target = $ids = [];
        $cn=$i=0;

        $bulks = \DB::table('engagedcount_api_calls')->select(['id', 'bulk_id'])
            ->where('campaign_id', $campaign->id)
            ->limit(50)
            ->get();

        foreach($bulks as $bulk) {
            $promises[$i][$bulk->id] = $this->client->getAsync($this->api_url.'bulk', [
                'query' => [
                    'apikey' => $this->api_key,
                    'bulk_id'=> $bulk->bulk_id
                ],

            ]);
            if(++$cn == 5) $i++;
        }

        foreach($promises as $promise) {
            $results = \GuzzleHttp\Promise\settle($promise)->wait();
            foreach($results as $key => $r) {
                if(isset($r['state']) && $r['state'] == 'rejected') { // @todo at the moment if engaged count rejects our bulk request we delete it, but we should examine why this is happening.
                    $ids[] = $key;
                    continue;
                }
                if(!isset($r['value'])) break 2;
                $data = json_decode($r['value']->getBody()->getContents(), true)['data'];
                if(!$data) break 2;

//                if($campaign->id == 9493) {
//                    \Log::info(print_r($data, true));
//                    dd($data);
//                }

                if(isset($domains[substr(key($data), strpos(key($data), '/')+2)])) {// then we have a domain
//                    if($campaign->id == 9305) {
//                        \Log::info(print_r($data, true));
//                        dd($data);
//                    }
                    foreach ($data as $domain => $item) {
                        $cc = isset($item['Facebook']['comment_count']) ? $item['Facebook']['comment_count'] : 0;
                        $insert[] = [
                            'id' => $domains[substr($domain, strpos($domain, '/') + 2)],
                            'campaign_id' => $campaign->id,
                            'facebook' => (int)$item['Facebook']['total_count'] < 16777215 ? (int)$item['Facebook']['total_count'] : 16777215,
                            'facebook_comments' => (int)$cc < 16777215 ? (int)$cc : 16777215,
                            'linkedin' => (int)$item['LinkedIn'] < 16777215 ? (int)$item['LinkedIn'] : 16777215,
                            'pinterest' => (int)$item['Pinterest'] < 16777215 ? (int)$item['Pinterest'] : 16777215,
                            'stumbleupon' => $item['StumbleUpon'],
                            'googleplusone' => (int)$item['GooglePlusOne'] < 16777215 ? (int)$item['GooglePlusOne'] : 16777215,
                            'social_rank' => \App\DomainSocial::social_rank($item)
                        ];
                    }
                }
                else { //else its a target url data.
                    foreach($data as $domain => $item) {
                        $cc = isset($item['Facebook']['comment_count']) ? $item['Facebook']['comment_count'] : 0;
                        $insert_target[] = [
                            'domain' => $domain,
                            'campaign_id' => $campaign->id,
                            'facebook' => (int)$item['Facebook']['total_count'] < 16777215 ? (int)$item['Facebook']['total_count'] : 16777215,
                            'facebook_comments' => (int)$cc < 16777215 ? (int)$cc : 16777215,
                            'linkedin' => (int)$item['LinkedIn'] < 16777215 ? (int)$item['LinkedIn'] : 16777215,
                            'pinterest' => (int)$item['Pinterest'] < 16777215 ? (int)$item['Pinterest'] : 16777215,
                            'stumbleupon' => $item['StumbleUpon'],
                            'googleplusone' => (int)$item['GooglePlusOne'] < 16777215 ? (int)$item['GooglePlusOne'] : 16777215,
                            'social_rank' => \App\DomainSocial::social_rank($item)
                        ];
                    }
                }
                // bulk ids to be removed.
                $ids[] = $key;
            }
        }

        \DB::table('engagedcount_api_calls')->whereIn('id', $ids)->delete();
        // if we have new data
        if($insert)
            foreach(array_chunk($insert, 1000) as $chunk) DomainSocial::insert($chunk);

        if($insert_target)
            foreach(array_chunk($insert_target, 1000) as $chunkt) TargetSocial::insert($chunkt);

        // if no more bulks left
        if(!\DB::table('engagedcount_api_calls')->where('campaign_id', $campaign->id)->count()) {
//            if($campaign->recheck_nr > 1) // remove old social data.
//                DomainSocial::where('campaign_id', $campaign->id)->where('recheck_nr', $campaign->recheck_nr-2)->delete();

            if($campaign->stage != 10) {
                $campaign->stage_status = 4;
                $campaign->save();
            }
            // send a req to urlanalyzer. that we are ready to get backlinks.
            (new \App\Classes\UrlanalyzerAPINEW([
                'campaign_id' => $campaign->id,
                'method' => 'status'
            ]))->status();

        }else {
            dispatch((new \App\Jobs\Engagedcount($campaign->id))->delay(\Carbon\Carbon::now()->addSeconds(60)));
        }

        echo 1;
    }
}
