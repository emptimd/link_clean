<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\EngagedcountApiCalls
 *
 * @property int $id
 * @property \Carbon\Carbon $date
 * @property string $last_update
 * @property string $bulk_id
 * @property bool $processed
 * @property bool $retries
 * @property bool $error
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EngagedcountApiCalls whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EngagedcountApiCalls whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EngagedcountApiCalls whereLastUpdate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EngagedcountApiCalls whereBulkId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EngagedcountApiCalls whereProcessed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EngagedcountApiCalls whereRetries($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EngagedcountApiCalls whereError($value)
 * @mixin \Eloquent
 * @property int $campaign_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EngagedcountApiCalls whereCampaignId($value)
 */
class EngagedcountApiCalls extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'engagedcount_api_calls';

	protected $dates = ['date'];

	protected $fillable = ['campaign_id', 'date', 'bulk_id', 'processed', 'retries', 'error'];

	public $timestamps = false;
}
