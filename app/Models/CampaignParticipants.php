<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class CampaignParticipants
 *
 * @package App
 * @version June 12, 2017, 11:19 am EEST
 * @property int $id
 * @property int $campaign_id
 * @property int $user_id
 * @property-read \App\Models\Campaign $campaign
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignParticipants whereCampaignId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignParticipants whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignParticipants whereUserId($value)
 * @mixin \Eloquent
 */
class CampaignParticipants extends Model
{

    public $table = 'campaign_participants';


    public $fillable = [
        'campaign_id',
        'user_id'
    ];

    public $timestamps = false;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'campaign_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'campaign_id' => 'required'
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
