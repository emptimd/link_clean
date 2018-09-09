<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\RefEvents
 *
 * @property int $id
 * @property int $user_id
 * @property string $action
 * @property string $plan
 * @property float $cost
 * @property float $revenue
 * @property string $revenue_status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RefEvents whereAction($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RefEvents whereCost($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RefEvents whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RefEvents whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RefEvents wherePlan($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RefEvents whereRevenue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RefEvents whereRevenueStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RefEvents whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RefEvents whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Referrals $referral
 * @property string $subscription_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefEvents whereSubscriptionId($value)
 */
class RefEvents extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ref_events';

    protected $fillable = ['action', 'plan', 'user_id', 'revenue', 'revenue_status', 'cost', 'subscription_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function referral()
    {
        return $this->belongsTo('App\Models\Referrals', 'user_id', 'user_id');
    }

}
