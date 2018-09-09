<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class GoogleAnalitycsStash
 *
 * @package App
 * @version March 30, 2017, 5:33 pm EEST
 * @property int $id
 * @property int $campaign_id
 * @property string $SourceUrl
 * @property string $TargetUrl
 * @property int $views
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleAnalitycsStash whereCampaignId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleAnalitycsStash whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleAnalitycsStash whereSourceUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleAnalitycsStash whereTargetUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleAnalitycsStash whereViews($value)
 * @mixin \Eloquent
 */
class GoogleAnalitycsStash extends Model
{

    public $table = 'google_analitycs_stash';
    

    public $fillable = [
        'campaign_id',
        'SourceUrl',
        'TargetUrl',
        'views'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'campaign_id' => 'integer',
        'SourceUrl' => 'string',
        'TargetUrl' => 'string',
        'views' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
