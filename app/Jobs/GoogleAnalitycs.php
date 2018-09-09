<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Artisan;

class GoogleAnalitycs extends Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaign_id;
    protected $access_token;
    protected $view_id;

    /**
     * Create a new job instance.
     *
     * @param $campaign_id
     * @param $access_token
     * @param $view_id
     */
    public function __construct($campaign_id, $access_token, $view_id)
    {
        $this->campaign_id = $campaign_id;
        $this->access_token = $access_token;
        $this->view_id = $view_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::call('google_analitycs', [
            'id' => $this->campaign_id,
            'access_token' => $this->access_token,
            'view_id' => $this->view_id
        ]);
    }
}
