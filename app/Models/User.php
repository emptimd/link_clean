<?php

namespace App\Models;

use App\Classes\Fastspring;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @package App
 * @version November 1, 2016, 6:04 pm UTC
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property bool $is_admin
 * @property int $backlinks
 * @property int $ssb
 * @property int $backlinks_used
 * @property string $coupon
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereIsAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereBalance($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereBacklinks($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereBacklinksUsed($value)
 * @mixin \Eloquent
 * @property string $paypal_email
 * @property float $balance
 * @property string $promocode
 * @property bool $revenue_share
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePaypalEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePromocode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRevenueShare($value)
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property string $domain
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereDomain($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereSsb($value)
 * @property string|null $fastsprig_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFastsprigId($value)
 * @property int $domains
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDomains($value)
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'paypal_email', 'password', 'backlinks', 'backlinks_used', 'promocode', 'domain'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    // @TODO Ok test custom field total_backlinks
    public $total_backlinks = 0;

    public function getReferrals()
    {
        return $this->hasMany('App\Models\Referrals', 'referrer_id', 'id');
    }

    public function referrer()
    {
        $referrer = \Cookie::get('referrer');
        // set user referrer for new registered users.
        if($referrer)
        {
            $model = new Referrals();
            $model->referrer_id = $referrer;
            $model->user_id = $this->id;
            $model->save();
            \Cookie::queue(\Cookie::forget('referrer'));
        }

        $this->generatePromocode();
    }

    public function generatePromocode()
    {
        if(!$this->promocode) {
            $f = resolve('App\Classes\Fastspring');
            $this->promocode = $f->createCoupon('REF');
            $this->save();
        }
    }

    public function subscriptions()
    {
        return [
            /*Old ones, left here for rebills.*/
            'starter-plan-linkquidator'       => ['backlinks' => 1000,   'price' => '$1',    'name' => 'Starter'],
            'advanced-plan-linkquidator'      => ['backlinks' => 10000,  'price' => '$29',    'name' => 'Advanced', 'trial' => '1 Week'],
            'small-business-plan-linkquidator' => ['backlinks' => 100000,  'price' => '$57',   'name' => 'Small Business'],
            'webmaster-plan-linkquidator'     => ['backlinks' => 500000, 'price' => '$115',   'name' => 'Webmaster'],
            'seo-studio-plan-linkquidator-com'     => ['backlinks' => 1000000, 'price' => '$199',   'name' => 'Seo Studio'],
            /*new Ones*/

            'linkquidator-webmaster-plan' => ['backlinks' => 300000, 'domains' => 3, 'price' => 32, 'name' => 'Webmaster'],
            'linkquidator-corporate-plan' => ['backlinks' => 5000000, 'domains' => 10, 'price' => 179, 'name' => 'Corporate'],

            'linkquidator-s-plan' => ['backlinks' => 5000, 'price' => '9,99', 'name' => 'Starter'],
            'linkquidator-s-1-plan' => ['backlinks' => 50000, 'price' => '14,99', 'name' => 'Advanced'],
            'linkquidator-s-2-plan' => ['backlinks' => 100000, 'price' => '24,99', 'name' => 'Small Business'],
            'linkquidator-s-3-plan' => ['backlinks' => 200000, 'price' => '39,99', 'name' => 'Webmaster'],
            'linkquidator-s-4-plan' => ['backlinks' => 500000, 'price' => '59,99', 'name' => 'Webmaster'],
            'linkquidator-s-5-plan' => ['backlinks' => 1000000, 'price' => '99,99', 'name' => 'Webmaster'],
            'linkquidator-s-6-plan' => ['backlinks' => 2000000, 'price' => '179,99', 'name' => 'Seo Studio'],
            /*Anual*/
            'linkquidator-webmaster-plan-annual' => ['backlinks' => 300000, 'domains' => 3, 'price' => 320, 'name' => 'Webmaster', 'is_annual' => 1],
            'linkquidator-corporate-anual-plan' => ['backlinks' => 5000000, 'domains' => 10, 'price' => 1790, 'name' => 'Corporate', 'is_annual' => 1],

            'linkquidator-s-annual-plan' => ['backlinks' => 50000, 'price' => '99,99', 'name' => 'Starter'],
            'linkquidator-s-1-annual-plan' => ['backlinks' => 500000, 'price' => '149,99', 'name' => 'Advanced'],
            'linkquidator-s-2-annual-plan' => ['backlinks' => 1000000, 'price' => '249,99', 'name' => 'Small Business'],
            'linkquidator-s-3-annual-plan' => ['backlinks' => 2000000, 'price' => '399,99', 'name' => 'Webmaster'],
            'linkquidator-s-4-annual-plan' => ['backlinks' => 5000000, 'price' => '599,99', 'name' => 'Webmaster'],
            'linkquidator-s-5-annual-plan' => ['backlinks' => 10000000, 'price' => '999,99', 'name' => 'Webmaster'],
            'linkquidator-s-6-annual-plan' => ['backlinks' => 20000000, 'price' => '1799', 'name' => 'Seo Studio'],

        ];
    }

    public function subscription_details($sub)
    {
        $all_subs = $this->subscriptions();
        if(in_array($sub, array_keys($all_subs)))
        {
            return $all_subs[$sub];
        }
        return false;
    }


    public function activate_subscription($campaign_id, array $data)
    {
        $subscription_id = $data['id'];
        $plan = $data['product'];
        $f_id = $data['account'];
        $total = $data['subtotal'];

        $subscription_details = $this->subscription_details($plan);

        if($subscription_details) {
            //create new Subscription
            $model = new Subscriptions();
            $model->id = $subscription_id;
            $model->user_id = $this->id;
            $model->plan = $plan;
            $model->campaign_id = $campaign_id;
            $model->is_active = 1;
            $model->f_id = $f_id;
            $model->save();

            //create Events.
            RefEvents::create([
                'action' => 'activated',
                'plan' => $plan,
                'user_id' => $this->id
            ]);

            // @Note fullfill backlinks, campaigns limit only if it is a simple supscription (webmaster,webmaster-anual,corporate,corporate-anual)
            if(isset($data['tags']['scenario']) && $data['tags']['scenario'] == 'simple_subscription') {
                $this->backlinks_used = 0;
                $this->backlinks = $subscription_details['backlinks'];
                $this->domains = $subscription_details['domains'];
            }


            $this->save();

            /*ADD Refback*/
            // find referrer
            $referrer_id = Referrals::where('user_id', $this->id)->pluck('referrer_id')->first();
            // find share
            $ref_array = [];
            if($referrer_id) {
                $share = User::select('revenue_share')->where('id', $referrer_id)->pluck('revenue_share')->first();
                $revenue = ($share / 100) * $total;
                $ref_array = [
                    'revenue' => $revenue,
                    'revenue_status' => 'Hold'
                ];

                //add sum to referrals hold
                $referrals = Referrals::where(['user_id' => $this->id])->first();
                if($referrals) {
                    $referrals->balance_hold += $revenue;
                    $referrals->save();
                }
            }

            //crete Events
            RefEvents::create([
                    'action' => 'bill',
                    'plan' => $plan,
                    'user_id' => $this->id,
                    'cost' => $total,
                    'subscription_id' => $subscription_id
                ]+$ref_array);
        }
    }


    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }
}
