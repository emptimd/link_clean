<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CampaignPrecheck
 *
 * @property int $id
 * @property int $campaign_id
 * @property string $ResultCode
 * @property string $Status
 * @property int $ExtBackLinks
 * @property int $RefDomains
 * @property int $AnalysisResUnitsCost
 * @property int $ACRank
 * @property int $ItemType
 * @property int $IndexedURLs
 * @property int $GetTopBackLinksAnalysisResUnitsCost
 * @property int $DownloadBacklinksAnalysisResUnitsCost
 * @property int $RefIPs
 * @property int $RefDomainsEDU
 * @property int $ExtBackLinksEDU
 * @property int $RefDomainsGOV
 * @property int $ExtBackLinksGOV
 * @property int $RefDomainsEDU_Exact
 * @property int $ExtBackLinksEDU_Exact
 * @property int $RefDomainsGOV_Exact
 * @property int $ExtBackLinksGOV_Exact
 * @property bool $CrawledFlag
 * @property int $RefSubNets
 * @property string $LastCrawlDate
 * @property string $LastCrawlResult
 * @property bool $RedirectFlag
 * @property string $FinalRedirectResult
 * @property int $OutDomainsExternal
 * @property int $OutLinksExternal
 * @property int $OutLinksInternal
 * @property string $LastSeen
 * @property string $Title
 * @property string $RedirectTo
 * @property int $CitationFlow
 * @property int $TrustFlow
 * @property int $TrustMetric
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Campaign $campaign
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereCampaignId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereResultCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereExtBackLinks($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereRefDomains($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereAnalysisResUnitsCost($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereACRank($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereItemType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereIndexedURLs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereGetTopBackLinksAnalysisResUnitsCost($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereDownloadBacklinksAnalysisResUnitsCost($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereRefIPs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereRefDomainsEDU($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereExtBackLinksEDU($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereRefDomainsGOV($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereExtBackLinksGOV($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereRefDomainsEDUExact($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereExtBackLinksEDUExact($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereRefDomainsGOVExact($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereExtBackLinksGOVExact($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereCrawledFlag($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereRefSubNets($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereLastCrawlDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereLastCrawlResult($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereRedirectFlag($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereFinalRedirectResult($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereOutDomainsExternal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereOutLinksExternal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereOutLinksInternal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereLastSeen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereRedirectTo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereCitationFlow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereTrustFlow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereTrustMetric($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignPrecheck whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CampaignPrecheck extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'campaign_precheck';

	protected $fillable = ['campaign_id','ResultCode','Status','ExtBackLinks','RefDomains','AnalysisResUnitsCost','ACRank','ItemType','IndexedURLs','GetTopBackLinksAnalysisResUnitsCost','DownloadBacklinksAnalysisResUnitsCost','RefIPs','RefSubNets','RefDomainsEDU','ExtBackLinksEDU','RefDomainsGOV','ExtBackLinksGOV','RefDomainsEDU_Exact','ExtBackLinksEDU_Exact','RefDomainsGOV_Exact','ExtBackLinksGOV_Exact','CrawledFlag','LastCrawlDate','LastCrawlResult','RedirectFlag','FinalRedirectResult','OutDomainsExternal','OutLinksExternal','OutLinksInternal','LastSeen','Title','RedirectTo','CitationFlow','TrustFlow','TrustMetric'];

	public function campaign()
	{
		return $this->belongsTo('App\Models\Campaign', 'id', 'campaign_id');
	}

    /**
     * @param $campaign
     * @param $item
     */
    public static function store($campaign, $item)
    {
        self::whereCampaignId($campaign->id)->delete();
        self::insert([
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
            'FinalRedirectResult' => $item->FinalRedirectResult ?? '',
            'OutDomainsExternal' => (int)$item->OutDomainsExternal,
            'OutLinksExternal' => (int)$item->OutLinksExternal,
            'OutLinksInternal' => (int)$item->OutLinksInternal,
            'LastSeen' => $item->LastSeen?:null,
            'Title' => $item->Title ?? '',
            'RedirectTo' => $item->RedirectTo ?? '',
            'CitationFlow' => $item->CitationFlow,
            'TrustFlow' => $item->TrustFlow,
            'TrustMetric' => $item->TrustMetric
        ]);
    }
}
