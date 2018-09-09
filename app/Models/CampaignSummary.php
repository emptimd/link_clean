<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CampaignSummary
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $campaign_id
 * @property int $total_backlinks
 * @property int $backlinks_good
 * @property int $backlinks_bad
 * @property int $penalty_risk
 * @property-read \App\Models\Campaign $campaign
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignSummary whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignSummary whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignSummary whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignSummary whereCampaignId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignSummary whereTotalBacklinks($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignSummary whereBacklinksGood($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignSummary whereBacklinksBad($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CampaignSummary wherePenaltyRisk($value)
 * @mixin \Eloquent
 */
class CampaignSummary extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'campaign_summaries';

    protected $fillable = ['campaign_id','total_backlinks','backlinks_good','backlinks_bad','penalty_risk'];

    public function campaign()
    {
        return $this->belongsTo('App\Campaign', 'id', 'campaign_id');
    }
}
