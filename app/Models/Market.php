<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Market
 *
 * @package App
 * @version August 22, 2017, 5:14 pm EEST
 * @property int $id
 * @property int $user_id
 * @property int $campaign_id
 * @property string $url
 * @property bool $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Campaign $campaign
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MarketProduct[] $marketProducts
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Market whereCampaignId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Market whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Market whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Market whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Market whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Market whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Market whereUserId($value)
 * @mixin \Eloquent
 */
class Market extends Model
{

    public $table = 'market';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'user_id',
        'campaign_id',
        'url',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'campaign_id' => 'integer',
        'url' => 'string',
        'status' => 'boolean'
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function marketProducts()
    {
        return $this->hasMany(\App\Models\MarketProduct::class);
    }
}
