<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UrlanalyzerApiCalls
 *
 * @property int $id
 * @property \Carbon\Carbon $date
 * @property \Carbon\Carbon $date_callback
 * @property int $campaign_id
 * @property string $method
 * @property string $request
 * @property string $response
 * @property string $callback
 * @property int $api_call_id
 * @property bool $processed
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UrlanalyzerApiCalls whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UrlanalyzerApiCalls whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UrlanalyzerApiCalls whereDateCallback($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UrlanalyzerApiCalls whereCampaignId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UrlanalyzerApiCalls whereMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UrlanalyzerApiCalls whereRequest($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UrlanalyzerApiCalls whereResponse($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UrlanalyzerApiCalls whereCallback($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UrlanalyzerApiCalls whereApiCallId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UrlanalyzerApiCalls whereProcessed($value)
 * @mixin \Eloquent
 */
class UrlanalyzerApiCalls extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'urlanalyzer_api_calls';

	protected $dates = ['date', 'date_callback'];

	protected $fillable = ['date', 'date_callback', 'method', 'campaign_id', 'request', 'response', 'callback', 'api_call_id', 'processed'];

	public $timestamps = false;
}
