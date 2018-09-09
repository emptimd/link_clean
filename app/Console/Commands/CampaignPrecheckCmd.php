<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\CampaignPrecheck;
use App\Classes\MajesticAPI;
use Illuminate\Console\Command;

class CampaignPrecheckCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:precheck {id : The ID of campaign}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Launches Campaign Pre-check after user have created new campaign.';

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
        /** @var Campaign $campaign */
        $campaign = Campaign::find($this->argument('id'));

        if(!$campaign) {
            echo 'Campaign not found.';
            return;
        }

		$api = (new MajesticAPI([
			'campaign_id'   => $campaign->id,
			'url'           => $campaign->url,
			'method'        => 'GetIndexItemInfo'
		]))->indexItemInfo();

        // error - majestic insufficient funds
        if($api->Code == 'InsufficientIndexItemInfoUnits')
        {
            $campaign->stage_status = -1;
            $campaign->save();
            echo 1;
            return;
        }


		$item = $api->DataTables->Results->Data[0];

        $result = [
            'campaign_id' => $campaign->id,
            'ResultCode' => $item->ResultCode,
            'Status' => $item->Status,
            'ExtBackLinks' => $item->ExtBackLinks,
            'RefDomains' => $item->RefDomains,
            'AnalysisResUnitsCost' => $item->AnalysisResUnitsCost,
            'ACRank' => $item->ACRank,
            'ItemType' => $item->ItemType,
            'IndexedURLs' => $item->IndexedURLs,
            'GetTopBackLinksAnalysisResUnitsCost' => $item->GetTopBackLinksAnalysisResUnitsCost,
            'DownloadBacklinksAnalysisResUnitsCost' => $item->DownloadBacklinksAnalysisResUnitsCost,
            'RefIPs' => $item->RefIPs,
            'CrawledFlag' => (int)$item->CrawledFlag,
            'RedirectFlag' => (int)$item->RedirectFlag,
            'FinalRedirectResult' => $item->FinalRedirectResult,
            'OutDomainsExternal' => $item->OutDomainsExternal,
            'OutLinksExternal' => $item->OutLinksExternal,
            'OutLinksInternal' => $item->OutLinksInternal,
            'LastSeen' => $item->LastSeen?:null,
            'Title' => $item->Title,
            'RedirectTo' => $item->RedirectTo,
            'CitationFlow' => $item->CitationFlow,
            'TrustFlow' => $item->TrustFlow,
            'TrustMetric' => $item->TrustMetric
        ];

        CampaignPrecheck::insert($result);

        echo 1;
    }
}
