<?php

namespace App\Console\Commands;

use App\Models\CampaignPrecheck;
use App\Classes\MajesticAPI;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Monitoring extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitoring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto rechecks campaigns once in a month';

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
        \Log::info('im insde monitoring');
        $date = Carbon::now()->subMonth()->toDateTimeString();
        $campaigns = \DB::select("SELECT c.id,c.url
FROM campaigns c
INNER JOIN subscriptions s on s.campaign_id=c.id
WHERE s.is_active=1 AND c.updated_at < ?", [$date]);


        $date = Carbon::now()->subDay()->toDateTimeString();
        $subscriptions = \DB::select("SELECT s.plan,s.user_id
FROM subscriptions s
WHERE s.is_active=1 AND s.rebills > 0 AND s.updated_at > ?", [$date]);

        foreach($subscriptions as $subscription) {
            $details = (new User())->subscription_details($subscription->plan);
            if(isset($details['domains'])) { // then its new type of subscription. And we recheck campaigns.
                $campaigns2 = \DB::select("SELECT c.id,c.url
                    FROM campaigns c
                    LEFT JOIN subscriptions s on s.campaign_id=c.id
                    WHERE c.user_id=? AND s.campaign_id is null limit ?", [$subscription->user_id, $details['domains']]);
                $campaigns = array_merge($campaigns, $campaigns2);
            }
        }


        // move money from referrals balance_hold to balance_approved
        foreach($campaigns as $campaign) {
            // Launch Campaign PreCheck
            $api = (new MajesticAPI([
                'campaign_id'   => $campaign->id,
                'url'           => $campaign->url,
                'method'        => 'GetIndexItemInfo'
            ]))->indexItemInfo();

            $item = $api->DataTables->Results->Data[0];
            $backlinks_count = $item->ExtBackLinks ?:0;

            // error - majestic insufficient funds
            if($api->Code == 'InsufficientIndexItemInfoUnits') return;
            if($item->Status != 'Found' || !$backlinks_count) continue;

            \DB::select("update campaigns SET recheck_nr=recheck_nr+1, stage=0 WHERE id=?", [$campaign->id]);

            CampaignPrecheck::store($campaign, $item);

            dispatch(new \App\Jobs\CampaignBacklinksGet($campaign->id));
        }

    }
}
