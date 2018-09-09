<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class CampaignDomains
 *
 * @package App
 * @version July 27, 2017, 3:37 pm EEST
 * @property int $id
 * @property int $campaign_id
 * @property string $country
 * @property int $ip
 * @property float $domain_rank
 * @property-read \App\Models\Campaign $campaign
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignDomains whereCampaignId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignDomains whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignDomains whereDomainRank($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignDomains whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignDomains whereIp($value)
 * @mixin \Eloquent
 * @property string $domain
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignDomains whereDomain($value)
 * @property bool $CitationFlow
 * @property bool $TrustFlow
 * @property int $ExtBackLinks
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignDomains whereCitationFlow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignDomains whereExtBackLinks($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignDomains whereTrustFlow($value)
 */
class CampaignDomains extends Model
{

    public $table = 'campaign_domains';
    
    public $timestamps = false;

    public $guarded = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'campaign_id' => 'integer',
        'DomainCitationFlow' => 'boolean',
        'DomainTrustFlow' => 'boolean',
        'DomainExtBackLinks' => 'integer',
        'country' => 'string',
        'ip' => 'integer'
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
