<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class GoogleAnalitycs
 *
 * @package App
 * @version March 24, 2017, 3:39 pm EET
 * @property int $id
 * @property int $campaign_id
 * @property int $users_organic
 * @property int $users_referral
 * @property int users_social
 * @property bool $date
 * @property-read \App\Models\Campaign $campaign
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleAnalitycs whereBacklinks($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleAnalitycs whereCampaignId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleAnalitycs whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleAnalitycs whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleAnalitycs whereViews($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleAnalitycs whereUsersOrganic($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleAnalitycs whereUsersReferral($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleAnalitycs whereUsersSocial($value)
 */
class GoogleAnalitycs extends Model
{

    public $table = 'google_analitycs';
    
    public $timestamps = false;


    public $fillable = [
        'campaign_id',
        'date',
        'users_organic',
        'users_referral',
        'users_social'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'campaign_id' => 'integer',
        'date' => 'string',
        'users_organic' => 'integer',
        'users_referral' => 'integer',
        'users_social' => 'integer'
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
