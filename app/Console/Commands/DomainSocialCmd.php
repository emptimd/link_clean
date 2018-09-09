<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Classes\EngagedcountAPI;
use Illuminate\Console\Command;

class DomainSocialCmd extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:domain_social {id : The ID of campaign}';

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
        $campaign = Campaign::find($this->argument('id'));

        if(!$campaign) {
            echo 'Campaign not found.';
            return;
        }

        /*
         * TIPS.
         * 1) We send domains with protocols because if we change them to http engagedcount will give diferent results.
         * */

        $conStr = sprintf("mysql:host=%s;dbname=%s;",
            env('DB_HOST'),
            env('DB_DATABASE')
        );
        $pdo = new \PDO($conStr, env('DB_USERNAME'), env('DB_PASSWORD'));

        if($campaign->is_demo) { //demo
            $backlinks = $pdo->query("SELECT concat(SUBSTRING_INDEX(any_value(SourceURL), '://', 1), '://', domain) as domain
            FROM campaign_domains c INNER JOIN campaign_backlinks_stash cb on cb.domain_id=c.id
            WHERE c.campaign_id=".$campaign->id." GROUP BY c.id")->fetchAll(\PDO::FETCH_COLUMN);

            (new EngagedcountAPI([
                'method' => 'bulk',
                'urls' => $backlinks,
                'campaign_id' => $campaign->id
            ]))->bulk();

            (new EngagedcountAPI([
                'method' => 'bulk',
                'urls' => ['http://'.$campaign->url.'/'],
                'campaign_id' => $campaign->id
            ]))->bulk();
        }else {
            $result = $pdo->query("SELECT concat(SUBSTRING_INDEX(any_value(SourceURL), '://', 1), '://', domain) as domain
            FROM campaign_domains c INNER JOIN campaign_backlinks_stash cb on cb.domain_id=c.id
            WHERE c.campaign_id=".$campaign->id." GROUP BY c.id")->fetchAll(\PDO::FETCH_COLUMN);
            $result2 = $pdo->query("SELECT distinct TargetURL FROM campaign_backlinks_stash WHERE campaign_id=".$campaign->id." limit 1000")->fetchAll(\PDO::FETCH_COLUMN);

            //mb this is faster then UNION
//            $backlinks = array_merge($result->fetchAll(\PDO::FETCH_COLUMN),$result2->fetchAll(\PDO::FETCH_COLUMN));
            (new EngagedcountAPI([
                'method' => 'bulk',
                'urls' => $result,
                'campaign_id' => $campaign->id
            ]))->bulk();

            (new EngagedcountAPI([
                'method' => 'bulk',
                'urls' => $result2,
                'campaign_id' => $campaign->id
            ]))->bulk();
        }

        // engagedcount is done, finish stage
        if($campaign->stage != 10) {
            $campaign->stage_status = 4;
            $campaign->save();
            dispatch(new \App\Jobs\CampaignTopics($campaign->id));
        }

        echo 1;
    }
}
