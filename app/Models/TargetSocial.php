<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class TargetSocial
 *
 * @package App
 * @version July 27, 2017, 3:38 pm EEST
 * @property int $id
 * @property int $campaign_id
 * @property string $domain
 * @property int $facebook
 * @property int $facebook_comments
 * @property int $linkedin
 * @property int $pinterest
 * @property int $stumbleupon
 * @property int $googleplusone
 * @property-read \App\Models\Campaign $campaign
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TargetSocial whereCampaignId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TargetSocial whereDomain($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TargetSocial whereFacebook($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TargetSocial whereFacebookComments($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TargetSocial whereGoogleplusone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TargetSocial whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TargetSocial whereLinkedin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TargetSocial wherePinterest($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TargetSocial whereStumbleupon($value)
 * @mixin \Eloquent
 * @property float $social_rank
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TargetSocial whereSocialRank($value)
 */
class TargetSocial extends Model
{

    public $table = 'target_social';

    public $timestamps = false;

    protected $guarded = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'campaign_id' => 'integer',
        'domain' => 'string',
        'facebook' => 'integer',
        'facebook_comments' => 'integer',
        'linkedin' => 'integer',
        'pinterest' => 'integer',
        'stumbleupon' => 'integer',
        'googleplusone' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function campaign()
    {
        return $this->belongsTo(\App\Models\Campaign::class);
    }
}
