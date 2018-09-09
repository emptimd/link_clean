<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class CampaignBacklinkTag
 *
 * @package App
 * @version August 17, 2017, 2:35 pm EEST
 * @property int $id
 * @property int $backlink_id
 * @property string $tag
 * @property-read \App\Models\CampaignBacklink $campaignBacklink
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklinkTag whereBacklinkId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklinkTag whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignBacklinkTag whereTag($value)
 * @mixin \Eloquent
 */
class CampaignBacklinkTag extends Model
{

    public $table = 'campaign_backlinks_tags';

    public $timestamps = false;



    public $fillable = [
        'backlink_id',
        'tag'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'backlink_id' => 'integer',
        'tag' => 'string'
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
    public function campaignBacklink()
    {
        return $this->belongsTo(\App\Models\CampaignBacklink::class);
    }
}
