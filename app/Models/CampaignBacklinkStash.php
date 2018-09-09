<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CampaignBacklinkStash
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
 * @property int $TargetCitationFlow
 * @property int $SourceTrustFlow
 * @property bool $malware
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklinkStash whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklinkStash whereCampaignId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklinkStash whereSourceURL($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklinkStash whereACRank($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklinkStash whereAnchorText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklinkStash whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklinkStash whereFlagFrame($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklinkStash whereFlagNoFollow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklinkStash whereFlagImages($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklinkStash whereFlagAltText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklinkStash whereFlagMention($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklinkStash whereTargetURL($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklinkStash whereFirstIndexedDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklinkStash whereSourceCitationFlow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklinkStash whereSourceTrustFlow($value)
 * @mixin \Eloquent
 * @property int $domain_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklinkStash whereDomainId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklinkStash whereMalware($value)
 * @property bool $SourceCitationFlow
 * @property int $is_disabled
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CampaignBacklinkStash whereIsDisabled($value)
 */
class CampaignBacklinkStash extends Model
{
	protected $table = 'campaign_backlinks_stash';

	public $timestamps = false;

    protected $guarded = [];

}
