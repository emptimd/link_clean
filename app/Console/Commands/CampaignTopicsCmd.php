<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\CampaignBacklinkStash;
use App\Classes\MajesticAPI;
use App\Models\TopicalTrustTarget;
use Illuminate\Console\Command;

class CampaignTopicsCmd extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
        protected $signature = 'campaign:topics {id : The ID of campaign}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Launches Domain Social data gathering for all new backlinks domains and backlinks targets.';

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
     */
    public function handle()
    {
        /** @var Campaign $campaign*/
        $campaign = Campaign::where('id', $this->argument('id'))->first();

        if(!$campaign) {
            echo 'Campaign not found.';
            return;
        }

        // DO NOT take topical info for rechecks
        //@ Bogdan 2017-09-29. Disable Topcis for Target Urls.
        if(/*$campaign->recheck_nr*/true) {
            $campaign->stage = 3;
            $campaign->stage_status = 1;
            $campaign->save();
            dispatch(new \App\Jobs\CampaignGoogleMalware($campaign->id));
            echo 1;
            return;
        }

        $backlinks = $insert_data = [];

        // HERE WE GET TOPICs FOR DEMO CAMPAIGN URL. @UPD commented because now demo must have all topics. @NewUpdt 2017-09-18
        if($campaign->is_demo) {
            $api = (new MajesticAPI([
                'url'           => 'http://'.$campaign->url,
                'method'        => 'GetTopics',
                'count'         => 4
            ]))->topics();

            if(isset($api->DataTables->Topics->Data) && $api->DataTables->Topics->Data) {
                foreach($api->DataTables->Topics->Data as $data) {
                    $insert_data[] = [
                        'campaign_id' => $campaign->id,
                        'target_backlink_url' => 'http://'.$campaign->url.'/',
                        'topic' => $data->Topic,
                        'links' => $data->Links,
                        'topical_trust_flow' => $data->TopicalTrustFlow,
                        'links_from_ref_domains' => $data->LinksFromRefDomains,
                        'ref_domains' => $data->RefDomains,
                        'pages' => $data->Pages,
                    ];
                }
            }

            TopicalTrustTarget::insert($insert_data);

            // engagedcount is done, finish stage
            if($campaign->stage != 10) {
                $campaign->stage = 3;
                $campaign->stage_status = 1;
                $campaign->save();
            }

            dispatch(new \App\Jobs\CampaignGoogleMalware($campaign->id));
            echo 1;return;
        }

        // @TODO if we are ok to have 3 topics for each target url as we do for Source Domains, then we mb dont even need to make requests, we may take those topics from GetBacklinksData(Download...)
        foreach(CampaignBacklinkStash::distinct()->where('campaign_id', $campaign->id)->limit(5000)->get(['TargetURL']) as $backlink) {
            $backlinks[str_replace(['https://','https://www.','http://','http://www.'],'http://', $backlink->TargetURL)] = 1;
        }

        if(!$backlinks) {
            echo 'No Backlinks found.';
            return;
        }

        (new MajesticAPI([
            'url'           => $backlinks,
            'method'        => 'GetTopics',
            'count'         => 4 // previously we had taken 10
        ]))->topics($campaign->id);


        // topics are done, finish stage
        if($campaign->stage != 10) {
            $campaign->stage = 3;
            $campaign->stage_status = 1;
            $campaign->save();
        }

        dispatch(new \App\Jobs\CampaignGoogleMalware($campaign->id));

        echo 1;
    }
}
