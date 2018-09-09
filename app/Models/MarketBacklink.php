<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class MarketBacklink
 *
 * @package App
 * @version August 30, 2017, 4:17 pm EEST
 * @property int $id
 * @property int $market_id
 * @property string $url
 * @property string $target_url
 * @property string $anchor_text
 * @property bool $follow
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Market $market
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketBacklink whereAnchorText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketBacklink whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketBacklink whereFollow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketBacklink whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketBacklink whereMarketId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketBacklink whereTargetUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketBacklink whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketBacklink whereUrl($value)
 * @mixin \Eloquent
 * @property int $is_published
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MarketBacklink whereIsPublished($value)
 */
class MarketBacklink extends Model
{

    public $table = 'market_backlinks';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'market_id',
        'url',
        'target_url',
        'anchor_text',
        'follow'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'market_id' => 'integer',
        'url' => 'string',
        'target_url' => 'string',
        'anchor_text' => 'string',
        'follow' => 'boolean'
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
    public function market()
    {
        return $this->belongsTo(\App\Models\Market::class);
    }
}
