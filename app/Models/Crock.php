<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Crock
 *
 * @package App
 * @version August 9, 2017, 8:43 pm EEST
 * @property int $id
 * @property int $user_id
 * @property int $campaign_id
 * @property string $url
 * @property bool $sources
 * @property bool $find
 * @property bool $price
 * @property-read \App\Models\Campaign $campaign
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crock whereCampaignId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crock whereFind($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crock whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crock wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crock whereSources($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crock whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crock whereUserId($value)
 * @mixin \Eloquent
 * @property string $info
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crock whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crock whereInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crock whereUpdatedAt($value)
 */
class Crock extends Model
{

    public $table = 'crock';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'user_id',
        'campaign_id',
        'url',
        'sources',
        'find',
        'price'
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
        'sources' => 'boolean',
        'find' => 'boolean',
        'price' => 'boolean'
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
}
