<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Classes\MajesticAPI;
use App\Models\CampaignAnchors;
use Illuminate\Console\Command;

class CampaignBacklinksGetCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:backlinks_get {id : The ID of campaign} {count=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Launches Initital Campaign backlink data gathering through Majestic.';

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
     */
    public function handle()
    {
        /** @var Campaign $campaign*/
        $campaign = Campaign::find($this->argument('id'));
        \Log::info('im inside campaign:backlinks_get');

        if(!$campaign) {
            echo 'Campaign not found.';
            return;
        }

        $backlinks_count = $this->argument('count') ? $this->argument('count') : $campaign->getPrecheck['ExtBackLinks'];
        $do_dispatch = true; // we dispatch next job if campaign is small.

        if($campaign->is_demo) { //demo campaign
            (new MajesticAPI([
                'campaign_id'   => $campaign->id,
                'url'           => $campaign->url,
                'method'        => 'GetDemo',
                'count'         => $this->argument('count') ? $this->argument('count') : 100,
            ]))->backLinkData();
        }elseif($backlinks_count <= MajesticAPI::perpage) { // small campaign (< 50k)
            (new MajesticAPI([
                'campaign_id'   => $campaign->id,
                'url'           => $campaign->url,
                'method'        => 'GetBackLinkData',
                'count'         => $backlinks_count,
            ]))->backLinkData();
        }else { // big campaign
            $do_dispatch = false;
            (new MajesticAPI([
                'campaign_id'   => $campaign->id,
                'url'           => $campaign->url,
                'method'        => 'DownloadBackLinks'
            ]))->downloadBackLinks();

            // Make request for Domains info
            (new MajesticAPI([
                'campaign_id'   => $campaign->id,
                'url'           => $campaign->url,
                'method'        => 'GetRefDomains',
                'count'         => MajesticAPI::max_domains/*MajesticAPI::max_domains > $domains_count ? $domains_count : MajesticAPI::max_domains*/,
            ]))->refDomains();

        }

        if(!$campaign->recheck_nr) {
            $anchors = (new MajesticAPI([
                'campaign_id'   => $campaign->id,
                'url'           => $campaign->url,
                'method'        => 'GetAnchorText',
            ]))->anchorText();


            $insert = [];
            $total = $anchors->DataTables->AnchorText->Headers->TotalRefDomains;
            foreach($anchors->DataTables->AnchorText->Data as $anchor) {
                if (!$anchor->AnchorText) {
                    $total -= $anchor->RefDomains;
                    break;
                }
            }
            foreach($anchors->DataTables->AnchorText->Data as $anchor) {
                if(!$anchor->AnchorText) continue;
                $insert[] = [
                    'campaign_id' => $campaign->id,
                    'anchor' => $anchor->AnchorText,
                    'ref_domains' => $anchor->RefDomains,
                    'total_links' => $anchor->TotalLinks,
                    'deleted_links' => $anchor->DeletedLinks,
                    'nofollow_links' => $anchor->NoFollowLinks,
                    'percent' => $anchor->RefDomains/$total*100
                ];
            }

            CampaignAnchors::insert($insert);
        }


        // backlink gathering is done, finish stage
        if($campaign->stage != 10) {
            $campaign->stage = 1;
            $campaign->stage_status = 2;
            $campaign->save();
        }

        if($do_dispatch) dispatch(new \App\Jobs\CampaignBacklinksProcess($campaign->id));

        echo 1;
    }
}
