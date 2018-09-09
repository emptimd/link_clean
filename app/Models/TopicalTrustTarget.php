<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TopicalTrustTarget
 *
 * @property int $id
 * @property int $target_backlink_id
 * @property string $topic
 * @property string $target_backlink_url
 * @property int $links
 * @property bool $topical_trust_flow
 * @property int $links_from_ref_domains
 * @property int $ref_domains
 * @property int $pages
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TopicalTrustTarget whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TopicalTrustTarget whereTargetBacklinckId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TopicalTrustTarget whereTopic($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TopicalTrustTarget whereLinks($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TopicalTrustTarget whereTopicalTrustFlow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TopicalTrustTarget whereLinksFromRefDomains($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TopicalTrustTarget whereRefDomains($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TopicalTrustTarget wherePages($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TopicalTrustTarget whereTargetBacklinkId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TopicalTrustTarget whereTargetBacklinkUrl($value)
 * @property int $campaign_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TopicalTrustTarget whereCampaignId($value)
 */
class TopicalTrustTarget extends Model
{
    protected $table = 'topical_trust_targets';

    protected $fillable = ['target_backlink_id', 'target_backlink_url', 'topic', 'links',
        'topical_trust_flow', 'links_from_ref_domains',
        'ref_domains', 'pages'
    ];
}
