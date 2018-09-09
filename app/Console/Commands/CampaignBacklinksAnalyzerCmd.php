<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\CampaignBacklinkStash;
use App\Classes\UrlanalyzerAPINEW;
use Illuminate\Console\Command;

class CampaignBacklinksAnalyzerCmd extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:backlinks_analyze {id : The ID of campaign}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Launches Campaign backlink data gathering through UrlAnalyzer.';

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
        $campaign = Campaign::find($this->argument('id'));

        if(!$campaign) {
            echo 'Campaign not found.';
            return;
        }

        $backlinks = $domains = [];
        foreach(CampaignBacklinkStash::where('campaign_id', $campaign->id)->limit(100000)->pluck('SourceURL') as $url) {
            $changed = false;
            $arr = explode('?', $url, 2);
            if(isset($arr[1])) {
                parse_str($arr[1], $output);
                foreach($output as $key => $item) {
                    if(strpos($key, 'utm_') === 0 || strpos($key, 'reply') !== false || strpos($key, 'login') === 0 || strpos($key, 'comment') === 0) { //bbp_reply_to, ?replytocom=9, login=Hinrichsen62McDougall
                        $changed = true;
                        unset($output[$key]);
                    }
                }
                if($changed)
                    $url = $arr[0] . '?'. http_build_query($output);
            }

            $backlinks[$url] = 1;
        }

        foreach($backlinks as $backlink => $a) { // @todo mb update using campaign_domains table.
            preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,8})$/i', parse_url($backlink, PHP_URL_HOST), $regs);
            if(!isset($regs['domain'])) continue;

            if(isset($domains[$regs['domain']]) && count($domains[$regs['domain']]) == 1000)  {
                unset($backlinks[$backlink]);
                continue;
            }
            $domains[$regs['domain']][] = 0;
        }

        if(!$backlinks) {
            echo 'No Backlinks found.';
            return;
        }

        (new UrlanalyzerAPINEW([
            'method'		=> 'analyze',
            'campaign_id'   => $campaign->id,
            'url'     		=> array_keys($backlinks) // mb even shuffle array (http://php.net/manual/en/function.shuffle.php)
        ]))->analyze();

        // urlanalyzer is done, finish stage
        if($campaign->stage != 10) {
            $campaign->stage = 2;
            $campaign->stage_status = 2;
            $campaign->save();
            dispatch(new \App\Jobs\DomainSocial($campaign->id));
        }else {
            dispatch(new \App\Jobs\CampaignGoogleMalware($campaign->id));
        }
        echo 1;
    }
}
