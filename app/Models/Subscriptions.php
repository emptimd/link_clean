<?php

namespace App\Models;

//use App\Classes\Fastspring;
use Eloquent as Model;

/**
 * Class Subscriptions
 *
 * @package App
 * @version February 10, 2017, 6:12 pm EET
 * @property string $id
 * @property int $user_id
 * @property string $plan
 * @property string $f_id // faststripng user id
 * @property int $rebills
 * @property bool $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscriptions whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscriptions whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscriptions whereIsActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscriptions wherePlan($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscriptions whereRebills($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscriptions whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscriptions whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscriptions whereFId($value)
 * @property string $campaign_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscriptions whereCampaignId($value)
 */
class Subscriptions extends Model
{

    public $table = 'subscriptions';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $incrementing = false;

    public $fillable = [
        'id',
        'user_id',
        'plan',
        'rebills',
        'f_id',
        'is_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'user_id' => 'integer',
        'plan' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function deactivate_subscription()
    {
        $this->is_active = 0;
        $this->save();

        //crete Events
        RefEvents::create([
            'action' => 'deactivated',
            'plan' => $this->plan,
            'user_id' => $this->user_id
        ]);

    }

    public function rebill_subscription(array $data)
    {
        $subscription_id = $data['subscription'];
        if($this->exists) {
            $this->rebills += 1;
            $this->save();
        }

        // find referrer
        $referrer_id = Referrals::where('user_id', $this->user_id)->pluck('referrer_id')->first();
        // find share
        $ref_array = [];
        if($referrer_id) {
            $share = User::select('revenue_share')->where('id', $referrer_id)->pluck('revenue_share')->first();
            $revenue = ($share / 100) * $data['total'];
            $ref_array = [
                'revenue' => $revenue,
                'revenue_status' => 'Hold'
            ];

            //add sum to referrals hold
            $referrals = Referrals::where(['user_id' => $this->user_id])->first();
            if($referrals) {
                $referrals->balance_hold += $revenue;
                $referrals->save();
            }
        }

        //crete Events
        RefEvents::create([
                'action' => 'rebill',
                'plan' => $this->plan,
                'user_id' => $this->user_id,
                'cost' => $data['total'],
                'subscription_id' => $subscription_id
            ]+$ref_array);

        // fullfill backlinks, campaigns limit
        /** @var User $user */
        $user = User::find($this->user_id);
        $subscription_details = $user->subscription_details($this->plan);
        if(!$subscription_details)
            $subscription_details = $user->subscription_detailsb($this->plan);

        $user->backlinks_used = 0;
        $user->backlinks = $subscription_details['backlinks'];
        if(isset($subscription_details['domains'])) { // because old subscriptions dont have domains.
            $count = \DB::select("SELECT count(*) as c
            FROM campaigns c
            LEFT JOIN subscriptions s on s.campaign_id=c.id
            WHERE c.user_id=? AND s.campaign_id is null", [$user->id])[0]->c;

            $user->domains = $subscription_details['domains']-$count;
        }
        $user->save();
    }

    public function rebill_subscriptionB(array $data)
    {
        $subscription_id = $data['subscription'];

        if($this->exists) {
            $this->rebills += 1;
            $this->save();
        }

        // find referrer
        $referrer_id = Referrals::where('user_id', $this->user_id)->pluck('referrer_id')->first();
        // find share
        $ref_array = [];
        if($referrer_id) {
            $share = User::select('revenue_share')->where('id', $referrer_id)->pluck('revenue_share')->first();
            $revenue = ($share / 100) * $data['total'];
            $ref_array = [
                'revenue' => $revenue,
                'revenue_status' => 'Hold'
            ];

            //add sum to referrals hold
            $referrals = Referrals::where(['user_id' => $this->user_id])->first();
            if($referrals) {
                $referrals->balance_hold += $revenue;
                $referrals->save();
            }
        }

        //crete Events
        RefEvents::create([
                'action' => 'rebill',
                'plan' => $this->plan,
                'user_id' => $this->user_id,
                'cost' => $data['total'],
                'subscription_id' => $subscription_id
            ]+$ref_array);

        // fullfill backlinks, campaigns limit
        /** @var User $user */
        $user = User::find($this->user_id);
        $subscription_details = $user->subscription_detailsb($this->plan);

        $user->backlinks_used = 0;
        $user->backlinks = $subscription_details['backlinks'];
        $user->save();
    }


    public function bill_productB(array $data)
    {
        $user_id = $data['tags']['referrer'];
        $subscription_id = $data['id'];
        $plan = $data['tags']['scenario'];
        $f_id = $data['account'];

        //create new Subscription
        $model = new Subscriptions();
        $model->id = $subscription_id;
        $model->user_id = $user_id;
        $model->plan = $plan;
        $model->campaign_id = 0;
        $model->is_active = 0;
        $model->f_id = $f_id;
        $model->save();

        // find referrer
        $referrer_id = Referrals::where('user_id', $user_id)->pluck('referrer_id')->first();
        // find share
        $ref_array = [];
        if($referrer_id) {
            $share = User::select('revenue_share')->where('id', $referrer_id)->pluck('revenue_share')->first();
            $revenue = ($share / 100) * $data['total'];
            $ref_array = [
                'revenue' => $revenue,
                'revenue_status' => 'Hold'
            ];

            //add sum to referrals hold
            $referrals = Referrals::where(['user_id' => $user_id])->first();
            if($referrals) {
                $referrals->balance_hold += $revenue;
                $referrals->save();
            }
        }

        //crete Events
        RefEvents::create([
                'action' => 'bill',
                'plan' => $plan,
                'user_id' => $user_id,
                'cost' => $data['total'],
                'subscription_id' => $subscription_id
            ]+$ref_array);
    }

    public function refund_subscription($is_order=false)
    {
        /*IF USER REFUND MONEY FOR SUBSCRIPTION*/

        $ref_event = RefEvents::where(['subscription_id' => $this->id, 'revenue_status' => 'Hold'])->first();
//        $ref_event = RefEvents::where(['user_id' => $this->user_id, 'plan' => $this->plan, 'revenue_status' => 'Hold'])->first();
        //update revenue_status for hold events
        if($ref_event) {
            $ref_event->revenue_status = 'Canceled';
            $ref_event->save();
            //remove sum
            $referrals = Referrals::where(['user_id' => $this->user_id])->first();
            if($referrals) {
                $referrals->balance_hold -= $ref_event->revenue;
                $referrals->save();
            }
        }

        if(!$is_order) {
            // if user refunds last month then we remove hes backlinks.
            $user = User::find($this->user_id);
            $user->backlinks_used = 0;
            $user->backlinks = 0;
            $user->domains = 0;
            $user->save();
        }
    }

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
