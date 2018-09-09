<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\Notification;
use Illuminate\Console\Command;

class NotificationsCmd extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
        protected $signature = 'campaign:notifications {id : The ID of campaign}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates notifications for specific campaign';

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


        $notifications = [
            [
                'user_id' => $campaign->user_id,
                'campaign_id' => $campaign->id,
                'url' => "campaign/{$campaign->id}/backlinks",
                'msg' => 'Total Backlinks: '.$campaign->getBacklinksCount(),
                'type' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'user_id' => $campaign->user_id,
                'campaign_id' => $campaign->id,
                'url' => "campaign/{$campaign->id}/backlinks",
                'msg' => 'Low Quality Backlinks: '.$campaign->getBacklinksBadCount(),
                'type' => 2,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'user_id' => $campaign->user_id,
                'campaign_id' => $campaign->id,
                'url' => "campaign/{$campaign->id}/backlinks",
                'msg' => 'Critical Backlinks: '.$campaign->getBacklinksCriticalCount(),
                'type' => 3,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],

        ];

        Notification::insert($notifications);

        echo 1;
    }
}
