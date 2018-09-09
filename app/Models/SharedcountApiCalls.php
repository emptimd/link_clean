<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SharedcountApiCalls
 *
 * @property int $id
 * @property \Carbon\Carbon $date
 * @property string $last_update
 * @property int $campaign_id
 * @property string $method
 * @property string $request
 * @property string $response
 * @property string $response_bulk
 * @property string $response_bulk_debug
 * @property int $seconds
 * @property int $seconds_response_bulk
 * @property bool $processed
 * @property bool $retries
 * @property bool $error
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SharedcountApiCalls whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SharedcountApiCalls whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SharedcountApiCalls whereLastUpdate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SharedcountApiCalls whereCampaignId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SharedcountApiCalls whereMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SharedcountApiCalls whereRequest($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SharedcountApiCalls whereResponse($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SharedcountApiCalls whereResponseBulk($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SharedcountApiCalls whereResponseBulkDebug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SharedcountApiCalls whereSeconds($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SharedcountApiCalls whereSecondsResponseBulk($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SharedcountApiCalls whereProcessed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SharedcountApiCalls whereRetries($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SharedcountApiCalls whereError($value)
 * @mixin \Eloquent
 */
class SharedcountApiCalls extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'sharedcount_api_calls';

	protected $dates = ['date'];

	protected $fillable = ['date', 'method', 'campaign_id','request', 'response', 'response_bulk', 'seconds', 'seconds_response_bulk', 'procesed', 'retries', 'error'];

	public $timestamps = false;
}
