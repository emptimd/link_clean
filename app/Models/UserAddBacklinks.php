<?php

namespace App\Models;

use Eloquent as Model;

/**
 * App\Http\UserAddBacklinks
 *
 * @property int $id
 * @property int $campaign_id
 * @property string $url
 * @property string $target_url
 * @property string $anchor_text
 * @property string $tags
 * @property int $follow
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Campaign $campaign
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddBacklinks whereAnchorText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddBacklinks whereCampaignId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddBacklinks whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddBacklinks whereFollow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddBacklinks whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddBacklinks whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddBacklinks whereTargetUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddBacklinks whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddBacklinks whereUrl($value)
 * @mixin \Eloquent
 * @property int $is_published
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddBacklinks whereIsPublished($value)
 */
class UserAddBacklinks extends Model
{
    //@Note: if follow is 1 then the tag was mentioned as NoFollow.

    public $table = 'user_add_backlinks';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'id',
        'campaign_id',
        'url',
        'target_url',
        'anchor_text',
        'tags',
        'follow',
        'is_published'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'campaign_id' => 'integer',
        'url' => 'string',
        'target_url' => 'string',
        'anchor_text' => 'string',
        'tags' => 'string',
        'follow' => 'integer',
        'is_published' => 'integer',
    ];

    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign');
    }
}