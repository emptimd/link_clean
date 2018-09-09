<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MajesticApiCalls
 *
 * @property int $id
 * @property \Carbon\Carbon $date
 * @property string $date_callback
 * @property int $campaign_id
 * @property string $method
 * @property string $request
 * @property string $response
 * @property string $callback
 * @property bool $processed
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MajesticApiCalls whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MajesticApiCalls whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MajesticApiCalls whereDateCallback($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MajesticApiCalls whereCampaignId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MajesticApiCalls whereMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MajesticApiCalls whereRequest($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MajesticApiCalls whereResponse($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MajesticApiCalls whereCallback($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MajesticApiCalls whereProcessed($value)
 * @mixin \Eloquent
 */
class MajesticApiCalls extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'majestic_api_calls';

	protected $dates = ['date'];

	protected $fillable = ['date', 'date_callback', 'method', 'campaign_id', 'request', 'response', 'callback', 'processed'];

	public $timestamps = false;
}
