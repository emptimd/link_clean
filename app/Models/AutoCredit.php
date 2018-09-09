<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class AutoCredit
 *
 * @package App
 * @version August 23, 2017, 10:24 am EEST
 * @property int $id
 * @property int $user_id
 * @property int $backlinks
 * @property \Carbon\Carbon $date
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AutoCredit whereBacklinks($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AutoCredit whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AutoCredit whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AutoCredit whereUserId($value)
 * @mixin \Eloquent
 */
class AutoCredit extends Model
{

    public $table = 'auto_credits';
    
    public $timestamps = false;


    public $fillable = [
        'user_id',
        'backlinks',
        'date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'backlinks' => 'integer',
        'date' => 'date'
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
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
