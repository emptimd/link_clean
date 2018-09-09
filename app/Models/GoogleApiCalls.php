<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\GoogleApiCalls
 *
 * @property int $id
 * @property \Carbon\Carbon $date
 * @property int $campaign_id
 * @property string $method
 * @property string $request
 * @property string $response
 * @property int $seconds
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleApiCalls whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleApiCalls whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleApiCalls whereCampaignId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleApiCalls whereMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleApiCalls whereRequest($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleApiCalls whereResponse($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleApiCalls whereSeconds($value)
 * @mixin \Eloquent
 */
class GoogleApiCalls extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'google_api_calls';

	protected $dates = ['date'];

	protected $fillable = ['date', 'method', 'campaign_id','request', 'response', 'seconds'];

	public $timestamps = false;
}
