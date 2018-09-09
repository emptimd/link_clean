<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Payments
 *
 * @property int $id
 * @property int $user_id
 * @property float $amount
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payments whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payments whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payments whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payments whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payments whereUserId($value)
 * @mixin \Eloquent
 */
class Payments extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';

    protected $fillable = ['user_id', 'amount'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
