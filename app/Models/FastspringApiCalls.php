<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FastspringApiCalls
 *
 * @property int $id
 * @property \Carbon\Carbon $date
 * @property string $method
 * @property int $campaign_id
 * @property string $subscription_id
 * @property string $callback
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FastspringApiCalls whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FastspringApiCalls whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FastspringApiCalls whereMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FastspringApiCalls whereCampaignId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FastspringApiCalls whereSubscriptionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FastspringApiCalls whereCallback($value)
 * @mixin \Eloquent
 */
class FastspringApiCalls extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'fastspring_api_calls';

	protected $dates = ['date'];

	protected $fillable = ['date', 'method', 'campaign_id', 'subscription_id', 'callback'];

	public $timestamps = false;
}
