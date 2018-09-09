<?php

namespace App\Models;

use Eloquent as Model;


/**
 * App\Models\UserCheckBacklinks
 *
 * @property int $id
 * @property int $user_id
 * @property string $url
 * @property string $target_url
 * @property string $anchor_text
 * @property int $no_follow
 * @property int $DomainCitationFlow
 * @property int $DomainTrustFlow
 * @property int $DomainExtBackLinks
 * @property string $country
 * @property int $ip
 * @property float $domain_rank
 * @property float $social_rank
 * @property int $is_published
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Campaign $campaign
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCheckBacklinks whereAnchorText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCheckBacklinks whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCheckBacklinks whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCheckBacklinks whereDomainCitationFlow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCheckBacklinks whereDomainExtBackLinks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCheckBacklinks whereDomainRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCheckBacklinks whereDomainTrustFlow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCheckBacklinks whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCheckBacklinks whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCheckBacklinks whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCheckBacklinks whereNoFollow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCheckBacklinks whereSocialRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCheckBacklinks whereTargetUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCheckBacklinks whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCheckBacklinks whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCheckBacklinks whereUserId($value)
 * @mixin \Eloquent
 * @property float $referral_influence
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCheckBacklinks whereReferralInfluence($value)
 * @property float $total_rank
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCheckBacklinks whereTotalRank($value)
 */
class UserCheckBacklinks extends Model
{
    //@Note: if no_follow is 1 then the tag was mentioned as NoFollow.

    public $table = 'user_check_backlinks';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $guarded = [
        'id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'url' => 'string',
        'target_url' => 'string',
        'anchor_text' => 'string',
        'tags' => 'string',
        'no_follow' => 'integer',
        'is_published' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}