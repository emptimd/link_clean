<?php

namespace App\Console\Commands;

use App\Models\CampaignPrecheck;
use App\Classes\MajesticAPI;
use App\Models\User;
use Illuminate\Console\Command;

class AutoSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:auto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto reassigning credits to users that have annual subscription + auto rechecks users campaigns.';

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
        \Log::info('im insde auto-subscribe+recheck');
        $subscriptions = \DB::select("SELECT s.plan,s.user_id
FROM subscriptions s
WHERE s.is_active=1 AND s.rebills = 0 AND campaign_id = 0 AND DATE_FORMAT(s.created_at, '%Y%m') < DATE_FORMAT(now(), '%Y%m') AND DAY(s.created_at)=?", [date('j')]);
        $campaigns=[];

        foreach($subscriptions as $subscription) {
            /** @var User $user */
            $user = User::find($subscription->user_id);

            $details = $user->subscription_details($subscription->plan);
            if(!$details) {
                $details = $user->subscription_detailsb($subscription->plan);
            }

            if(!$details) continue;

            if(isset($details['is_annual'])) { // then its annual subscription. And we recheck campaigns.
                // get campaigns to recheck
                $campaigns2 = \DB::select("SELECT c.id,c.url
                    FROM campaigns c
                    LEFT JOIN subscriptions s on s.campaign_id=c.id
                    WHERE c.user_id=? AND s.campaign_id is null limit ?", [$subscription->user_id, $details['domains']]);
                $campaigns = array_merge($campaigns, $campaigns2);

                // Add cretentials to user.
                $user->backlinks_used = 0;
                $user->backlinks = $details['backlinks'];
                if(count($campaigns2) < $details['domains']) {
                    $user->domains = $details['domains']-count($campaigns2);
                }
                $user->save();
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
