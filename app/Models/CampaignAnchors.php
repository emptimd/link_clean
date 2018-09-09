<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class CampaignAnchors
 *
 * @package App
 * @version June 15, 2017, 3:47 pm EEST
 * @property int $id
 * @property int $campaign_id
 * @property string $anchor
 * @property int $ref_domains
 * @property int $total_links
 * @property int $deleted_links
 * @property int $nofollow_links
 * @property-read \App\Models\Campaign $campaign
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignAnchors whereAnchor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignAnchors whereCampaignId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignAnchors whereDeletedLinks($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignAnchors whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignAnchors whereNofollowLinks($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignAnchors whereRefDomains($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignAnchors whereTotalLinks($value)
 * @mixin \Eloquent
 * @property float $percent
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignAnchors wherePercent($value)
 */
class CampaignAnchors extends Model
{

    public $table = 'campaign_anchors';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'campaign_id',
        'anchor',
        'ref_domains',
        'total_links',
        'deleted_links',
        'nofollow_links'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'campaign_id' => 'integer',
        'anchor' => 'string',
        'ref_domains' => 'integer',
        'total_links' => 'integer',
        'deleted_links' => 'integer',
        'nofollow_links' => 'integer'
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
        return $this->belongsTo(\App\Campaign::class);
    }
}
