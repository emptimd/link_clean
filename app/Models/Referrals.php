<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Ticket
 *
 * @property int $id
 * @property \Carbon\Carbon $date
 * @property string $status
 * @property int $user_id
 * @property string $subject
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ticket whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ticket whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ticket whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ticket whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ticket whereSubject($value)
 * @mixin \Eloquent
 * @property int $referrer_id
 * @property float $balance_hold
 * @property float $balance_approved
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $referrer
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Referrals whereBalanceApproved($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Referrals whereBalanceHold($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Referrals whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Referrals whereReferrerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Referrals whereUpdatedAt($value)
 */
class Referrals extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'referrals';

    protected $fillable = ['referrer_id', 'user_id', 'balance_hold', 'balance_approved'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function referrer()
    {
        return $this->belongsTo('App\Models\User', 'referrer_id', 'id');
    }

}
