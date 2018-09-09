<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CampaignBacklink
 *
 * @property int $id
 * @property int $campaign_id
 * @property string $SourceURL
 * @property int $ACRank
 * @property string $AnchorText
 * @property string $Date
 * @property int $FlagFrame
 * @property int $FlagNoFollow
 * @property int $FlagImages
 * @property int $FlagAltText
 * @property int $FlagMention
 * @property string $TargetURL
 * @property string $FirstIndexedDate
 * @property int $SourceCitationFlow
 * @property int $SourceTrustFlow
 * @property bool $unreachable
 * @property bool $malware
 * @property float $link_rank
 * @property float $referral_influence
 * @property float $total_rank
 * @property int $views
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereCampaignId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereSourceURL($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereACRank($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereAnchorText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereFlagFrame($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereFlagNoFollow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereFlagImages($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereFlagAltText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereFlagMention($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereTargetURL($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereFirstIndexedDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereSourceCitationFlow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereSourceTrustFlow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereUnreachable($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereMalware($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereLinkRank($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereReferralInfluence($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereTotalRank($value)
 * @mixin \Eloquent
 * @property int $recheck_nr
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereRecheckNr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereViews($value)
 * @property int $http_code
 * @property int $domain_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereDomainId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink whereHttpCode($value)
 * @property bool $paid
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklink wherePaid($value)
 * @property int $is_disabled
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CampaignBacklink whereIsDisabled($value)
 */
class CampaignBacklink extends Model
{
	protected $table = 'campaign_backlinks';

    protected $guarded = [];

    public $timestamps = false;

    public function getRankDif($rank, $rank_p)
    {
        $up = '';
        if($rank_p === false) return $up;
        $dif = $rank !== $rank_p ? true:false;

        if($this->total_rank > $this->total_rank_p && $dif)
            $up = '<i class="fa fa-arrow-circle-up arrows" aria-hidden="true"></i>';
        elseif($this->total_rank < $this->total_rank_p && $dif)
            $up = '<i class="fa fa-arrow-circle-down arrows" aria-hidden="true"></i>';
        return $up;
    }

    public function getLDRankDif()
    {
        $up = '';
        if(!isset($this->link_rank_p)) return $up;

        if($this->link_rank > $this->link_rank_p)
            $up = '<i class="fa fa-arrow-circle-up arrows" aria-hidden="true"></i>';
        elseif($this->link_rank < $this->link_rank_p)
            $up = '<i class="fa fa-arrow-circle-down arrows" aria-hidden="true"></i>';
        return $up;
    }

    public function getRefRankDif()
    {
        $up = '';
        if(!isset($this->referral_influence_p)) return $up;

        if($this->referral_influence > $this->referral_influence_p)
            $up = '<i class="fa fa-arrow-circle-up arrows" aria-hidden="true"></i>';
        elseif($this->referral_influence < $this->referral_influence_p)
            $up = '<i class="fa fa-arrow-circle-down arrows" aria-hidden="true"></i>';
        return $up;
    }

    public static function enable($id)
    {
        Campaign::where('id', $id)->update(['is_demo' => 0]);
        self::where('campaign_id', $id)->where('is_disabled', 1)->update(['is_disabled' => 0]);
    }


}
