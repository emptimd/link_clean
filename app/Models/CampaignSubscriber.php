<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class CampaignSubscriber
 *
 * @package App
 * @version March 29, 2017, 12:22 pm EEST
 * @property int $id
 * @property int $campaign_id
 * @property string $email
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Campaign $campaign
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignSubscriber whereCampaignId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignSubscriber whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignSubscriber whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignSubscriber whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignSubscriber whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CampaignSubscriber extends Model
{

    public $table = 'campaign_subscribers';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'campaign_id',
        'email'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'campaign_id' => 'integer',
        'email' => 'string'
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
