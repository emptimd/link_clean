<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DomainSocial @info: Used to store Sharedcount social info for source domains. Now it stores Engagedcount social info for targets.
 *
 * @property int $id
 * @property int $facebook
 * @property int $facebook_comments
 * @property int $linkedin
 * @property int $pinterest
 * @property int $stumbleupon
 * @property int $googleplusone
 * @property float $social_rank
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DomainSocial whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DomainSocial whereFacebook($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DomainSocial whereFacebookComments($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DomainSocial whereLinkedin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DomainSocial wherePinterest($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DomainSocial whereStumbleupon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DomainSocial whereGoogleplusone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DomainSocial whereSocialRank($value)
 * @mixin \Eloquent
 * @property int $campaign_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DomainSocial whereCampaignId($value)
 */
class DomainSocial extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'domain_social';
    public $timestamps = false;

    protected $guarded = [];

    public $incrementing = false;

    public static function social_rank($data)
    {
        $social_rank = 0.00;

        if($data)
        {
            $values = [];

            $count_other = (int)$data['LinkedIn'] + (int)$data['Pinterest'] + (int)$data['StumbleUpon'];

            $TotalCountF = 1;
            if($data['Facebook']['total_count'] > 10)   $TotalCountF = 2;
            if($data['Facebook']['total_count'] > 50)   $TotalCountF = 3;
            if($data['Facebook']['total_count'] > 100)  $TotalCountF = 4;
            if($data['Facebook']['total_count'] > 200)  $TotalCountF = 5;
            if($data['Facebook']['total_count'] > 500)  $TotalCountF = 6;
            if($data['Facebook']['total_count'] > 1000) $TotalCountF = 7;
            if($data['Facebook']['total_count'] > 1500) $TotalCountF = 8;
            if($data['Facebook']['total_count'] > 2000) $TotalCountF = 9;
            if($data['Facebook']['total_count'] > 5000) $TotalCountF = 10;

            $TotalCountFC = 1; //commentsbox_count
            if(isset($data['Facebook']['comment_count'])) {
                if($data['Facebook']['comment_count'] > 10)   $TotalCountFC = 2;
                if($data['Facebook']['comment_count'] > 50)   $TotalCountFC = 3;
                if($data['Facebook']['comment_count'] > 100)  $TotalCountFC = 4;
                if($data['Facebook']['comment_count'] > 200)  $TotalCountFC = 5;
                if($data['Facebook']['comment_count'] > 500)  $TotalCountFC = 6;
                if($data['Facebook']['comment_count'] > 1000) $TotalCountFC = 7;
                if($data['Facebook']['comment_count'] > 1500) $TotalCountFC = 8;
                if($data['Facebook']['comment_count'] > 2000) $TotalCountFC = 9;
                if($data['Facebook']['comment_count'] > 5000) $TotalCountFC = 10;
            }

            $TotalCountG = 1;
            if($data['GooglePlusOne'] > 10)   $TotalCountG = 2;
            if($data['GooglePlusOne'] > 50)   $TotalCountG = 3;
            if($data['GooglePlusOne'] > 100)  $TotalCountG = 4;
            if($data['GooglePlusOne'] > 200)  $TotalCountG = 5;
            if($data['GooglePlusOne'] > 500)  $TotalCountG = 6;
            if($data['GooglePlusOne'] > 1000) $TotalCountG = 7;
            if($data['GooglePlusOne'] > 1500) $TotalCountG = 8;
            if($data['GooglePlusOne'] > 2000) $TotalCountG = 9;
            if($data['GooglePlusOne'] > 5000) $TotalCountG = 10;

            $TotalCountOther = 1;
            if($count_other > 10)   $TotalCountOther = 2;
            if($count_other > 50)   $TotalCountOther = 3;
            if($count_other > 100)  $TotalCountOther = 4;
            if($count_other > 200)  $TotalCountOther = 5;
            if($count_other > 500)  $TotalCountOther = 6;
            if($count_other > 1000) $TotalCountOther = 7;
            if($count_other > 1500) $TotalCountOther = 8;
            if($count_other > 2000) $TotalCountOther = 9;
            if($count_other > 5000) $TotalCountOther = 10;

            $values['f']    = ($TotalCountF * 0.5) / 10;
            $values['fc']   = ($TotalCountFC * 0.15) / 10;
            $values['g']    = ($TotalCountG * 0.15) / 10;
            $values['o']    = ($TotalCountOther * 0.05) / 10;

            $social_rank = ( $values['f'] + $values['fc'] + $values['g'] + $values['o'] ) * 100;
        }

        return $social_rank;
    }

}
