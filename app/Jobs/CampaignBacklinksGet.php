<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Artisan;

class CampaignBacklinksGet extends Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaign_id;
    protected $count;

    /**
     * Create a new job instance.
     *
     * @param $campaign_id
     * @param $count
     */
    public function __construct($campaign_id, $count=0)
    {
        $this->campaign_id = $campaign_id;
        $this->count = $count;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::call('campaign:backlinks_get', ['id' => $this->campaign_id, 'count' => $this->count]);
    }
}
