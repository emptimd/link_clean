<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Clean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleaner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean';

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

        \Log::debug('inside clean');

        $this->callSilent('queue:flush');


        // Remove unfinished, finished demo and finished not demo campaigns data.
        $campaigns = Campaign::whereRaw('(is_demo=1 and stage<>10) or (stage=10 and stage_status=0 and is_demo=0)')
            ->where('updated_at', '<', Carbon::now()->subDay()->toDateTimeString())
//            ->where('updated_at', '>', Carbon::now()->subDays(2)->toDateTimeString()) // @TODO uncomment this after we clean first time
//            ->has('getMajestic')
            ->with(['getPrecheck' => function($q) {
                $q->select(['id', 'campaign_id']);
            },'getGoogleApiCalls' => function($q) {
                $q->select(['id', 'campaign_id']);
            }, 'getMajestic' => function($q) {
                $q->select(['id', 'campaign_id', 'method', 'callback', 'response']);
            }, 'getEngagedCount' => function($q) {
                $q->select(['id', 'campaign_id']);
            }, 'getUrlanalizer' => function($q) {
                $q->select(['id', 'campaign_id', 'callback']);
            }])
            ->get();

        $this->removeOneDayOldCampaigns($campaigns);

    }

    public function removeOneDayOldCampaigns($campaigns)
    {
        /** @var Campaign $campaign */
        foreach($campaigns as $campaign) {
            $campaign->clean();
        }

    }
}
