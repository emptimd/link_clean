<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;
use Mail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Campaign
 *
 * @property int $id
 * @property int $user_id
 * @property string $url
 * @property \Carbon\Carbon $created_at
 * @property string $updated_at
 * @property string $ip
 * @property bool $stage
 * @property bool $stage_status
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campaign whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campaign whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campaign whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campaign whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campaign whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campaign whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campaign whereStage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campaign whereStageStatus($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User $author
 * @property int $recheck_nr
 * @property int $citation_flow
 * @property int $trust_flow
 * @property bool $to_recheck
 * @property bool $is_backlinkcontrol
 * @property bool $is_demo
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campaign whereRecheckNr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campaign whereToRecheck($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campaign whereCitationFlow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campaign whereIsBacklinkcontrol($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campaign whereTrustFlow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campaign whereIsDemo($value)
 * @property int $test
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Campaign whereTest($value)
 */
class Campaign extends Model
{

	protected $table = 'campaigns';

	protected $fillable = ['user_id', 'url', 'stage', 'stage_status', 'ip', 'to_recheck', 'recheck_nr', 'is_backlinkcontrol', 'trust_flow', 'citation_flow', 'is_demo'];

    protected $casts = [
        'created_at' => 'string',
        'updated_at' => 'string',
    ];

	public static $backlink_params = [
		'SourceCitationFlow' => 'Citation Flow',
		'SourceTrustFlow'    => 'Trust Flow',
		'CitationFlow' => 'Domain Citation Flow',
		'TrustFlow'    => 'Domain Trust Flow',
		'ExtBackLinks' => 'Domain Ext Backlinks',
		'content_count'      => 'Content Count',
		'text_html_ratio'    => 'Text to HTML Ratio',
		'anchor_ratio'       => 'Anchor Ratio',
		'outgoing_backlinks' => 'Outgoing Backlinks',
		'unreachable'        => 'Unreachable',
		'malware'            => 'Malware',
		'TargetURL'          => 'Destination',
		'FlagNoFollow'       => 'NoFollow',
	];

	public static $backlink_ranks = ['critical', 'low', 'medium', 'high'];

    public function scopeCampaignAuthor($query)
    {
        return $query->where('user_id', Auth::id());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getPrecheck()
	{
		return $this->hasOne('App\Models\CampaignPrecheck', 'campaign_id', 'id');
	}

	public function author()
	{
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getUrlanalizer()
    {
        return $this->hasOne('App\Models\UrlanalyzerApiCalls', 'campaign_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getEngagedCount()
    {
        return $this->hasMany('App\Models\EngagedcountApiCalls', 'campaign_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getGoogleApiCalls()
    {
        return $this->hasMany('App\Models\GoogleApiCalls', 'campaign_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getMajestic()
    {
        return $this->hasMany('App\Models\MajesticApiCalls', 'campaign_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getMajesticDomain()
    {
        return $this->hasOne('App\Models\MajesticApiCalls', 'campaign_id', 'id')
            ->whereRaw("processed = 0 and method='GetRefDomains'")
            ->orderBy('id', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getBacklinks()
	{
		return $this->hasMany('App\Models\CampaignBacklink', 'campaign_id', 'id')->where('campaign_backlinks.recheck_nr', $this->recheck_nr);
	}
	public function getBacklinksCount()
	{
        return CampaignBacklink::where('campaign_id', $this->id)->where('recheck_nr', $this->recheck_nr)->count();
	}
	public function getSummary()
	{
		return $this->hasMany('App\Models\CampaignSummary', 'campaign_id', 'id');
	}

    /**
     * @return mixed
     */
    public function getBacklinksCsv()
	{
		return $this->getBacklinks()->select(
		    'SourceURL as url',
            'FlagNoFollow as no_follow',
            'total_rank',
            'link_rank',
            'TargetURL as target_url');
	}
	public function getBacklinksBad()
	{
		return $this->getBacklinks()->where('recheck_nr', $this->recheck_nr)->where('total_rank', '>', 60);
	}


	public function getBacklinksBadCount()
    {
        return CampaignBacklink::where('campaign_id', $this->id)->where('total_rank', '>', 60)->where('recheck_nr', $this->recheck_nr)->count();
    }

    public function getBacklinksCriticalCount()
    {
        return CampaignBacklink::where('campaign_id', $this->id)->where('total_rank', '>', 85)->where('recheck_nr', $this->recheck_nr)->count();
    }

	public function getRefsTop()
    {
        // @TODO CHANGE REFS TOP. SO we have new table campaign_domains with domains from majestic and we do not need this.
        return $this->getBacklinks()
            ->select(DB::raw("COUNT(`id`) AS `cnt`, SUBSTRING_INDEX((SUBSTRING_INDEX((SUBSTRING_INDEX(SourceURL, '://', -1)), '/', 1)), '.', -2) AS `domain`, AVG(`total_rank`) AS `avg`"))
            ->whereRaw("SUBSTRING_INDEX((SUBSTRING_INDEX((SUBSTRING_INDEX(SourceURL, '://', -1)), '/', 1)), '.', -2) <> ?", [$this->url])
            ->groupBy('domain')
            ->having('avg','<=','60')
            ->orderBy('cnt', 'DESC')
            ->limit(4)
            ->get();
    }

    public function getDestination()
    {
        $data = \DB::select("SELECT t1.`TargetURL`, COUNT(*) AS `count`, COUNT(t2.`id`) AS `bad`, COUNT(t4.`id`) AS `critical`, SUM(t1.`referral_influence`) AS `referral_volume`, t5.`social_rank`, SUM(t1.views) as views
                            FROM `campaign_backlinks` AS `t1`

                            LEFT JOIN `campaign_backlinks` AS `t2` ON `t1`.`id` = `t2`.`id` AND `t2`.`total_rank` > 60 AND t2.total_rank < 86
                            LEFT JOIN `campaign_backlinks` AS `t4` ON `t1`.`id` = `t4`.`id` AND `t4`.`total_rank` > 85
                            LEFT JOIN target_social t5 on t5.campaign_id = t1.campaign_id and t5.domain=t1.TargetURL
                            WHERE `t1`.`campaign_id` = ? GROUP BY `t1`.`TargetURL`, `t5`.`social_rank`", [$this->id]);

        foreach ($data as $key => $destination) {
            $bad_percent        = (float)round(($destination->bad / $destination->count) * 100, 2);
            $critical_percent   = (float)round(($destination->critical / $destination->count) * 100, 2);
            $data[$key]->penalty_risk = number_format(($bad_percent + $critical_percent * 5));
            if($data[$key]->penalty_risk > 85) $data[$key]->penalty_risk = 85.00;
        }

        return $data;
    }

    public function isDestinationTarget($target)
    {
        return $this->getBacklinks()
                    ->where('TargetURL', $target)
                    ->count();
    }

    public function getRefs()
    {
        return $this->getBacklinks()
            ->select(DB::raw("
                              SUBSTRING_INDEX((SUBSTRING_INDEX((SUBSTRING_INDEX(any_value(SourceURL), '://', -1)), '/', 1)), '.', -2) domain2
                            , COUNT(campaign_backlinks.id) AS `cnt`
                            , AVG(`total_rank`) AS `avg`
                            , any_value(t2.social_rank) as social_rank
                            , any_value(domain_rank) as domain_rank"))
            ->join('domain_social as t2', function($q)
            {
                $q->on(\DB::raw("SUBSTRING_INDEX((SUBSTRING_INDEX((SUBSTRING_INDEX(t2.domain, '://', -1)), '/', 1)), '.', -2)"), '=', \DB::raw("SUBSTRING_INDEX((SUBSTRING_INDEX((SUBSTRING_INDEX(SourceURL, '://', -1)), '/', 1)), '.', -2)"))
                    ->where('t2.recheck_nr', '=', $this->recheck_nr)
                    ->where('t2.campaign_id', '=', $this->id);
            })
            ->whereRaw("SUBSTRING_INDEX((SUBSTRING_INDEX((SUBSTRING_INDEX(any_value(SourceURL), '://', -1)), '/', 1)), '.', -2) <> '$this->url'")
            ->groupBy('domain2');
    }

    public function getRefsingle($domain)
    {
        return $this->getBacklinks()
            ->select(DB::raw("campaign_backlinks.id,SourceURL, TargetURL, total_rank, link_rank, domain_rank, t2.social_rank"))
            ->join('domain_social as t2', function($q) use ($domain)
            {
                $q->where(\DB::raw("SUBSTRING_INDEX((SUBSTRING_INDEX((SUBSTRING_INDEX(t2.domain, '://', -1)), '/', 1)), '.', -2)"), '=', $domain)
                    ->where('t2.recheck_nr', '=', $this->recheck_nr)
                    ->where('t2.campaign_id', '=', $this->id);
            })
            ->where('SourceURL', 'LIKE', '%'.$domain.'/%')
            ->distinct();
    }

    public function getRefsSuspicious()
    {
        // @TODO UPD here join cd talbe.
        return $this->getBacklinks()
            ->select(DB::raw("COUNT(`id`) AS `cnt`, SUBSTRING_INDEX((SUBSTRING_INDEX((SUBSTRING_INDEX(SourceURL, '://', -1)), '/', 1)), '.', -2) AS `domain`, AVG(`total_rank`) AS `avg`"))
            ->groupBy('domain')
            ->having('avg','>','60')
            ->orderBy('avg', 'DESC')
            ->limit(4)
            ->get();
    }

	public function progress()
	{
		if($this->stage == 0 && $this->stage_status == 3) return 3;
		if($this->stage == 1 && $this->stage_status == 1) return 5;
		if($this->stage == 1 && $this->stage_status == 2) return 7;
		if($this->stage == 1 && $this->stage_status == 3) return 15;
		if($this->stage == 1 && $this->stage_status == 4) return 25;
		if($this->stage == 2 && $this->stage_status == 1) return 30;
		if($this->stage == 2 && $this->stage_status == 2) return 35;
		if($this->stage == 2 && $this->stage_status == 3) return 40;
		if($this->stage == 2 && $this->stage_status == 4) return 45;
		if($this->stage == 3 && $this->stage_status == 0) return 50;
		if($this->stage == 3 && $this->stage_status == 1) return 55;
		if($this->stage == 3 && $this->stage_status == 2) return 60;
		if($this->stage == 3 && $this->stage_status == 3) return 70;
		if($this->stage == 3 && $this->stage_status == 4) return 90;
		if($this->stage == 10 && $this->stage_status == 0) return 100;
		return 1;
	}

	// start campaign
	public function start()
	{
		$this->stage = 0;
		$this->stage_status = 3;
		$this->save();
	}

	// finalize campaign
	public function finalize()
	{
		$this->stage = 10;
		$this->stage_status = 0;
		$this->save();

		// save summary data
		$this->summary();

		// send campaign summary email
        if(!$this->is_backlinkcontrol)
		    $this->send_summary_email();
	}

	public function is_finished()
	{
		return ($this->stage == 10 && $this->stage_status == 0);
	}

	public function status()
	{
		$status = 'in progress';

        if($this->is_finished()) {
            $status = 'Active';
        }

        if($this->stage == 0 && $this->stage_status == 2)	$status = 'ready to start';

		return $status;
	}

	function subscription_plan_recommended()
    {
        $user = Auth::user();
        $subscription_plan = '';

        if(!isset($this->getPrecheck) && !isset($this->getPrecheck->ExtBackLinks)) return '';

        $backlinks = $this->getPrecheck->ExtBackLinks;

        // check campaign/backlinks balance, don't recommend if enough resources
        if($user->backlinks-($user->backlinks_used+$backlinks) > 0) return '';

		if($backlinks > 200000)	$subscription_plan = "Custom";
        if($backlinks < 200001)	$subscription_plan = "Seo studio";
        if($backlinks < 100001)	$subscription_plan = "Webmaster";
        if($backlinks < 30001)	$subscription_plan = "Small Business";
        if($backlinks < 10001)	$subscription_plan = "Advanced";
        if($backlinks < 1001)	$subscription_plan = "Starter";

        return ' (Recommended plan "<a href="'.url('subscription').'" class="recomended_plan '.strtolower($subscription_plan).'">'.$subscription_plan.'</a>")';
    }

	public function send_summary_email()
	{
        $email='';
        if(!$this->user_id) {
            $email = CampaignSubscriber::where('campaign_id', $this->id)->pluck('email')->first();
        }

        $date = date('m/d/Y');
        $user = User::find($this->user_id);
        Mail::send('emails.campaign_results', [
            'date'          => $date,
            'campaign_id'	=> $this->id,
            'user_id'	    => $this->user_id,
            'url'			=> $this->url,
            'totals'		=> $this->totals()
        ], function ($m) use ($user, $date, $email) {
            $m->from(config('mail.from.address'));
            if(!$this->user_id) $m->to($email);
            else $m->to($user->email, $user->name);
            $m->subject('Backlinks Analysis Report '.$date);
        });
	}

    public static function dashboard_totals()
    {
        $totals = \DB::select("select COUNT(cb.id) AS total,
            SUM(IF(total_rank > 60, 1, 0)) AS bad,
            AVG(`total_rank`) AS average
            from campaigns c INNER JOIN campaign_backlinks cb on cb.campaign_id=c.id and c.recheck_nr=cb.recheck_nr where c.user_id=?", [auth()->id()])[0];

        return (array) $totals;
    }

	public function refsingle_totals($domain)
    {
        return $this->getBacklinks()
            ->select(DB::raw("COUNT(campaign_backlinks.id) AS `count`
                            , AVG(`total_rank`) AS `average`
                            , any_value(cd.domain_rank)"))
            ->join('campaign_domains as cd', function($q)
            {
                $q->on('cd.id', '=', 'campaign_backlinks.domain_id');
            })
            ->where('domain', $domain)
            ->first();
    }

	public function totals()
	{

	    $totals = self::selectRaw('SUM((SELECT COUNT(*) FROM `campaign_backlinks` WHERE `campaign_backlinks`.`campaign_id` = '.$this->id.' AND recheck_nr ='.($this->recheck_nr).')) AS total')
                      ->selectRaw('SUM((SELECT COUNT(*) FROM `campaign_backlinks` WHERE `campaign_backlinks`.`campaign_id` = '.$this->id.' AND recheck_nr ='.($this->recheck_nr).' AND `campaign_backlinks`.`total_rank` > 60 AND `campaign_backlinks`.`total_rank` < 86)) AS bad')
                      ->selectRaw('SUM((SELECT COUNT(*) FROM `campaign_backlinks` WHERE `campaign_backlinks`.`campaign_id` = '.$this->id.' AND recheck_nr ='.($this->recheck_nr).' AND `campaign_backlinks`.`total_rank` > 85)) AS critical')
                      ->selectRaw('SUM((SELECT COUNT(*) FROM `campaign_backlinks` WHERE `campaign_backlinks`.`campaign_id` = '.$this->id.' AND recheck_nr ='.($this->recheck_nr).' AND `campaign_backlinks`.`total_rank` <= 60)) AS good')
                      ->selectRaw('(SELECT AVG(`total_rank`) FROM `campaign_backlinks` WHERE `campaign_backlinks`.`campaign_id` = '.$this->id.' AND recheck_nr ='.($this->recheck_nr).') AS average')
                      ->selectRaw('(SELECT SUM(`referral_influence`) FROM `campaign_backlinks` WHERE `campaign_backlinks`.`campaign_id` = '.$this->id.' AND recheck_nr ='.($this->recheck_nr).') AS referral_volume')
                      ->where('id', $this->id)
                      ->first();

        $totals->total              = (int)$totals->total;
        $totals->average            = (float)round($totals->average, 2);
        $totals->good               = (int)$totals->good;
        $totals->bad                = (int)$totals->bad;
        $totals->critical           = (int)$totals->critical;
        $totals->good_percent       = (float)round(($totals->good / $totals->total) * 100, 2);
        $totals->bad_percent        = (float)round(($totals->bad / $totals->total) * 100, 2);
        $totals->critical_percent   = (float)round(($totals->critical / $totals->total) * 100, 2);
        $totals->referral_volume    = (float)round($totals->referral_volume, 2);
        //
//        $totals->penalty_risk       = ($totals->bad_percent + $totals->critical_percent) * 3;
        $totals->penalty_risk       = ($totals->bad_percent + $totals->critical_percent * 3);
        if($totals->penalty_risk > 85) $totals->penalty_risk = 85.00;

		return $totals;
	}

    public function totals_new()
    {

        /*UPD 08.08.2017 @Bogdan*/
        $totals = \DB::select("select COUNT(*) AS total,
           SUM(IF(total_rank < 21, 1, 0)) AS super,
           SUM(IF(total_rank > 60 AND total_rank < 86, 1, 0)) AS bad,
           SUM(IF(total_rank > 85, 1, 0)) AS critical,
           AVG(total_rank) as average,
           SUM(referral_influence) referral_volume
           
           from campaign_backlinks where campaign_id = ? AND recheck_nr=".$this->recheck_nr, [$this->id])[0];


        $totals->total              = (int)$totals->total;
        $totals->average            = (float)round($totals->average, 2);
        $totals->super              = (int)$totals->super;
        $totals->bad                = (int)$totals->bad;
        $totals->critical           = (int)$totals->critical;
        $totals->medium = $totals->total - ($totals->super + $totals->bad + $totals->critical);
        $totals->suspicios = $totals->bad + $totals->critical;

        $totals->bad_percent        = $totals->total ? (float)round(($totals->bad / $totals->total) * 100, 2) : 0;
        $totals->critical_percent   = $totals->total ? (float)round(($totals->critical / $totals->total) * 100, 2) : 0;
        $totals->referral_volume    = (float)round($totals->referral_volume, 2);
        $totals->penalty_risk       = ($totals->bad_percent + $totals->critical_percent * 3);
        if($totals->penalty_risk > 85) $totals->penalty_risk = 85.00;

        return $totals;
    }

    /**
     * Used only in CampaignController.show
     */
    public function totals_new_campaign_show()
    {
        $totals = \DB::select("select COUNT(*) AS total,
           SUM(IF(total_rank < 21, 1, 0)) AS super,
           SUM(IF(total_rank > 60 AND total_rank < 86, 1, 0)) AS bad,
           SUM(IF(total_rank > 85, 1, 0)) AS critical
           from campaign_backlinks where campaign_id = ? AND recheck_nr=".$this->recheck_nr, [$this->id])[0];


        if($this->recheck_nr) {
            $totalsp = \DB::select("select COUNT(*) AS total,
               SUM(IF(total_rank < 21, 1, 0)) AS super,
               SUM(IF(total_rank > 60 AND total_rank < 86, 1, 0)) AS bad,
               SUM(IF(total_rank > 85, 1, 0)) AS critical
               from `campaign_backlinks` where campaign_id = ? AND recheck_nr=?", [$this->id, $this->recheck_nr-1])[0];

            if($totalsp->total) {
                $totals->total_prev = (int)$totalsp->total;
                $totals->bad_prev = (int)$totalsp->bad;
                $totals->critical_prev = (int)$totalsp->critical;
            }
        }
        $totals->total              = (int)$totals->total;
        $totals->super              = (int)$totals->super;
        $totals->bad                = (int)$totals->bad;
        $totals->critical           = (int)$totals->critical;
        $totals->medium = $totals->total - ($totals->super + $totals->bad + $totals->critical);
        $totals->suspicios = $totals->bad + $totals->critical;

        $totals->bad_percent        = $totals->total ? (float)round(($totals->bad / $totals->total) * 100, 2) : 0;
        $totals->critical_percent   = $totals->total ? (float)round(($totals->critical / $totals->total) * 100, 2) : 0;
        $totals->penalty_risk       = ($totals->bad_percent + $totals->critical_percent * 3);
        if($totals->penalty_risk > 85) $totals->penalty_risk = 85.00;

        // DATA for comparations
        if($this->recheck_nr && $totals->total_prev) {
            $bad_percent_prev        = (float)round(($totals->bad_prev / $totals->total_prev) * 100, 2);
            $critical_percent_prev   = (float)round(($totals->critical_prev / $totals->total_prev) * 100, 2);
            $penalty_risk_prev       = ($bad_percent_prev + $critical_percent_prev * 3);
            if($penalty_risk_prev > 85) $penalty_risk_prev = 85.00;

            $totals->total_diff = $totals->total - $totals->total_prev;
            $totals->suspicios_diff = $totals->suspicios - ($totals->bad_prev + $totals->critical_prev);
            $totals->penalty_risk_diff = $totals->penalty_risk - $penalty_risk_prev;
        }else {
            $totals->total_diff = 0;
            $totals->suspicios_diff = 0;
            $totals->penalty_risk_diff = 0;
        }

        return $totals;
    }

    public function totals_target($target)
    {
        $totals = self::selectRaw('SUM((SELECT COUNT(*) FROM `campaign_backlinks` WHERE `campaign_backlinks`.`campaign_id` IN ('.$this->id.') AND `TargetURL` = "'.$target.'" )) AS total')
                      ->selectRaw('SUM((SELECT COUNT(*) FROM `campaign_backlinks` WHERE `campaign_backlinks`.`campaign_id` IN ('.$this->id.') AND `TargetURL` = "'.$target.'" AND `campaign_backlinks`.`total_rank` < 21)) AS super')
                      ->selectRaw('SUM((SELECT COUNT(*) FROM `campaign_backlinks` WHERE `campaign_backlinks`.`campaign_id` IN ('.$this->id.') AND `TargetURL` = "'.$target.'" AND `campaign_backlinks`.`total_rank` > 20 AND `campaign_backlinks`.`total_rank` < 61)) AS medium')
                      ->selectRaw('SUM((SELECT COUNT(*) FROM `campaign_backlinks` WHERE `campaign_backlinks`.`campaign_id` IN ('.$this->id.') AND `TargetURL` = "'.$target.'" AND `campaign_backlinks`.`total_rank` > 60 AND `campaign_backlinks`.`total_rank` < 86)) AS bad')
                      ->selectRaw('SUM((SELECT COUNT(*) FROM `campaign_backlinks` WHERE `campaign_backlinks`.`campaign_id` IN ('.$this->id.') AND `TargetURL` = "'.$target.'" AND `campaign_backlinks`.`total_rank` > 85)) AS critical')
                      ->selectRaw('(SELECT AVG(`total_rank`) FROM `campaign_backlinks` WHERE `campaign_backlinks`.`campaign_id` IN ('.$this->id.') AND `TargetURL` = "'.$target.'" ) AS average')
                      ->selectRaw('(SELECT SUM(`referral_influence`) FROM `campaign_backlinks` WHERE `campaign_backlinks`.`campaign_id` IN ('.$this->id.') AND `TargetURL` = "'.$target.'" ) AS referral_volume')
                      ->where('id', $this->id)
                      ->first();

        $totals->total              = (int)$totals->total;
        $totals->average            = (float)round($totals->average, 2);
        $totals->super              = (int)$totals->super;
        $totals->good               = (int)$totals->good;
        $totals->medium             = (int)$totals->medium;
        $totals->bad                = (int)$totals->bad;
        $totals->spammy             = (int)$totals->spammy;
        $totals->critical           = (int)$totals->critical;

        $totals->good_percent       = $totals->total ? (float)round((($totals->medium + $totals->super) / $totals->total) * 100, 2) : 0;
        $totals->bad_percent        = $totals->total ? (float)round(($totals->bad / $totals->total) * 100, 2) : 0;
        $totals->critical_percent   = $totals->total ? (float)round(($totals->critical / $totals->total) * 100, 2) : 0;
        $totals->referral_volume    = (float)round($totals->referral_volume, 2);
        $totals->penalty_risk       = ($totals->bad_percent + $totals->critical_percent * 3);
        if($totals->penalty_risk > 85) $totals->penalty_risk = 85.00;

        return $totals;
    }

	public function count_unreachable()
	{
		$unreachable = 0;
		foreach($this->getBacklinks as $b) if ($b->unreachable == 1) $unreachable++;

		return $unreachable;
	}


	public function calculate_domain_rank($backlink)
	{
		$CitationFlow = $backlink ?: 1; // lowest value = 1

		return round( ($CitationFlow/100*2+$CitationFlow/$CitationFlow*2+$CitationFlow/100)/5*100 , 2);
	}

	public function calculate_link_rank($backlink)
	{
		$CitationFlow = $backlink['SourceCitationFlow'] ?: 1; // lowest value = 1

		return round ((( ($backlink['DomainCitationFlow']*3/100+$backlink['SourceTrustFlow']*2/100+$backlink['SourceTrustFlow']/$CitationFlow+$CitationFlow/100) / 7 ) * 10), 2);
	}

	public function calculate_ref_influence($backlink, $tlds, $ga, $redirect, $feed)
    {
        $referral_influence = ($backlink['link_rank'] + $backlink['DomainCitationFlow']/100*5);
//        if($backlink->content_count < 400) $referral_influence = $referral_influence; //Commented by Bogdan

        if($redirect) $referral_influence /= 1.7;
        else {
            if($backlink['text_html_ratio'] > 0.25 && $backlink['text_html_ratio'] < 0.70) $referral_influence = $referral_influence * 1.1;

            if($backlink['anchor_ratio'] > 0.0075 && $backlink['anchor_ratio'] < 0.0125) $referral_influence = $referral_influence / 1.1;
            elseif($backlink['anchor_ratio'] >= 0.0125) $referral_influence = $referral_influence / 1.2;

            if($backlink['outgoing_backlinks'] >= 400 && $backlink['outgoing_backlinks'] < 1000) $referral_influence = $referral_influence / 1.1;
            elseif($backlink['outgoing_backlinks'] >= 1000) $referral_influence = $referral_influence / 1.3;
        }

        // TODO: add social rank
        //social rank >=  5		*1.05
        //social rank >= 10		*1.07
        //social rank >= 20		*1.10
        //social rank >= 30		*1.20
        //social rank >= 40		*1.25
        //social rank >= 50		*1.30
        //social rank >= 60		*1.35
        //social rank >= 70		*1.40
        //social rank >= 80		*1.45
        //social rank >= 90		*1.50
        //social rank >= 100	*1.55

        if($ga && $backlink['views']) {
            if($backlink['views'] > 300) $referral_influence *= 1.5;
            elseif($backlink['views'] > 100) $referral_influence *= 1.4;
            elseif($backlink['views'] > 50) $referral_influence *= 1.3;
            elseif($backlink['views'] > 20) $referral_influence *= 1.25;
            elseif($backlink['views'] > 10) $referral_influence *= 1.20;
            elseif($backlink['views'] > 5) $referral_influence *= 1.15;
            else $referral_influence *= 1.1;
        }

        // if subdomen
        if(count($tlds) > 2) {
            $referral_influence /= 1.4;
        }else {
            if($backlink['DomainExtBackLinks'] && $backlink['outgoing_backlinks'] && ($backlink['outgoing_backlinks'] < $backlink['DomainExtBackLinks'])) {
                $coif = $backlink['DomainExtBackLinks']/$backlink['outgoing_backlinks'];

                if((int)$coif >= 4) $referral_influence *= 1.6;
                elseif((int)$coif == 3) $referral_influence *= 1.55;
                elseif((int)$coif == 2) $referral_influence *= 1.5;
                elseif(number_format($coif, 1) >= 1.5) $referral_influence *= 1.4;
                else $referral_influence *= 1.3;
            }
        }

        if($feed) $referral_influence /= 5;

        if($backlink['FlagNoFollow']) $referral_influence /= 10;

        return $referral_influence;
    }


	public function calculate_link($backlink, $tlds, $ga, $redirect=false)
	{
		$total = 0;

		// test redirects
        if($redirect) {
            $total += 10;
        }else {
            if($backlink['unreachable']) $total += 20;

            if($backlink['text_html_ratio'] < 0.25 || $backlink['text_html_ratio'] > 0.70) $total += 10;
            if($backlink['anchor_ratio'] > 0.0075 && $backlink['anchor_ratio'] < 0.0125) $total += 5;
            elseif($backlink['anchor_ratio'] >= 0.0125) $total += 15;
        }


        if($backlink['DomainTrustFlow'] < 20) $total += 15;
        elseif($backlink['DomainTrustFlow'] < 30) $total += 10;
        elseif($backlink['DomainTrustFlow'] < 40) $total += 8;
        elseif($backlink['DomainTrustFlow'] < 50) $total += 5;
        elseif($backlink['DomainTrustFlow'] < 60) $total += 3;
        elseif($backlink['DomainTrustFlow'] < 70) $total += 1;
        elseif($backlink['DomainTrustFlow'] > 80) $total--;


        if($backlink['DomainCitationFlow'] < 20) $total += 5;
        elseif($backlink['DomainCitationFlow'] < 30) $total += 3;
        elseif($backlink['DomainCitationFlow'] < 40) $total += 1;
        elseif($backlink['DomainCitationFlow'] > 80) $total--;

        if($backlink['SourceTrustFlow'] < 20) $total += 7;
        elseif($backlink['SourceTrustFlow'] < 30) $total += 5;
        elseif($backlink['SourceTrustFlow'] < 40) $total += 3;
        elseif($backlink['SourceTrustFlow'] < 50) $total += 1;
        elseif($backlink['SourceTrustFlow'] > 60) $total--;


        if($backlink['social_rank'] == 0) $total += 5;
        elseif($backlink['social_rank'] < 10) $total += 1;
        elseif($backlink['social_rank'] > 20) $total--;

        if($ga) { // if user enabled GA
            if($backlink['views'] == 0) $total += 2;
            elseif($backlink['views'] <= 10) $total--;
            elseif($backlink['views'] <= 20) $total -=2;
            elseif($backlink['views'] <= 50) $total -= 4;
            elseif($backlink['views'] > 50) $total -= 10;
        }

        if($backlink['FlagNoFollow']) $total += 2;
        if($backlink['malware']) $total += 79;

        if($backlink['page_load_time'] > 30) $total += 15;
        elseif($backlink['page_load_time'] > 20) $total += 10;
        elseif($backlink['page_load_time'] > 10) $total += 5;

        if($backlink['DomainExtBackLinks'] < 10) $total += 5;
        elseif($backlink['DomainExtBackLinks'] < 50) $total += 3;
        elseif($backlink['DomainExtBackLinks'] < 100) $total += 2;
        elseif($backlink['DomainExtBackLinks'] < 200) $total += 1;


        if($backlink['DomainExtBackLinks'] && $backlink['outgoing_backlinks'] > $backlink['DomainExtBackLinks']) {
            $coif = $backlink['outgoing_backlinks']/$backlink['DomainExtBackLinks'];

            if((int)$coif >= 4) $total += 20; // bad
            elseif((int)$coif == 3) $total += 15; // bad
            elseif((int)$coif == 2) $total += 10; // bad
            elseif(number_format($coif, 1) >= 1.5) $total += 7; // bad
            else $total += 5; // bad
        }

//        Если с 1 IP > 3 ссылок + 4
//
//        Если с IP > 2 доменов + 5
//        Если с IP > 3 домена + 15
//        Если с IP > 4 доменов + 30

        // if subdomen
        if(count($tlds) > 2) $total+=15;

        switch($tlds[count($tlds)-1]) {
            case 'study' : $total +=15;break;
            case 'party' : $total +=8;break;
            case 'tk' :
            case 'xyz' :
            case 'gdn' :
            case 'click' : $total +=5;break;
            case 'accountant' : $total +=3;break;
            case 'biz' : $total +=1;
        }

        return $total;
	}


	// link summary
	public static function rank_backlink($x)
	{
		if($x < 21)				return 'high';		// 0-20		Super
		if($x > 20 && $x < 61) 	return 'medium';		// 21-50	Good
		if($x > 60 && $x < 86) 	return 'low';		// 61-80	Bad
		if($x > 85)			return 'critical';	// 100+		Critical

	}


    public static function total_rank_from_name($x)
    {
        $result=[];

        switch ($x) {
            case 'high' : $result = ['min' => 0, 'max' => 20];break;
            case 'medium' : $result = ['min' => 21, 'max' => 60];break;
            case 'low' : $result = ['min' => 61, 'max' => 85];break;
            case 'critical' : $result = ['min' => 86];break;
        }

        return $result;

    }


	public static function rank_backlink_badge_class($rank)
	{
		$common_button_properties = 'badge bg';
		$result = '';

		if ($rank == 'high') 		$result = '-primary';
		if ($rank == 'medium') 		$result = '-info';
		if ($rank == 'low') 		$result = '-warning';
		if ($rank == 'critical') 	$result = '-inverse';

		return $common_button_properties.$result;
	}

	public static function rank_backlink_label_class($rank)
	{
		$common_button_properties = 'label label';
        $result = '-default';

		if ($rank == 'high') 		$result = '-info';
		if ($rank == 'medium') 		$result = '-primary';
		if ($rank == 'low') 		$result = '-warning';
		if ($rank == 'critical') 	$result = '-inverse';

		return $common_button_properties.$result;
	}
	public static function rank_backlink_badge_class_text($rank)
	{
		$common_button_properties = 'badge bg';
		$result = [];

		if ($rank == 'high') 		$result = '-primary';
		if ($rank == 'medium') 		$result = '-info';
		if ($rank == 'low') 		$result = '-warning';
		if ($rank == 'critical') 	$result = '-inverse';

		return $common_button_properties.$result;
	}

	public static function backlink_param_value($param, $value)
	{
		if($param == 'TargetURL')                                       $result = $value;
		elseif(in_array($param,['unreachable','malware','FlagNoFollow']))	$result = $value ? 'Yes' : 'No';
        elseif(in_array($param,['text_html_ratio','anchor_ratio']))         $result = $value ? number_format($value, 3, '.', '') : '-';
		else 												                $result = $value ? number_format($value) : '-';

		return $result;
	}

	public function summary()
	{
		$total 			= $this->getBacklinks()->count();
		$bad 			= $this->getBacklinksBad()->count();
		$good 			= $total - $bad;
		$penalty_risk 	= $bad ? (round( ($bad/$total) * 5 ) * 5) : 0;
		$penalty_risk 	= ($penalty_risk < 85) ? $penalty_risk : 85;

		$summary = new CampaignSummary();
		$summary->created_at		= Carbon::now();
		$summary->updated_at		= Carbon::now();
		$summary->campaign_id		= $this->id;
		$summary->total_backlinks 	= $total;
		$summary->backlinks_good 	= $good;
		$summary->backlinks_bad 	= $bad;
		$summary->penalty_risk		= $penalty_risk;
		$summary->save();
	}

    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::deleting(function($model) { // before delete() method call this
            /** @var Campaign $model */
            $model->clean();
        });
    }

    public function clean()
    {
        if($this->getGoogleApiCalls) $this->getGoogleApiCalls()->delete(); //remove every google api call.
        if($this->getEngagedCount) $this->getEngagedCount()->delete(); //remove every engaged cout api call.
        if($this->getPrecheck) $this->getPrecheck->delete(); // remove precheck api call //9/21/17
        // remove Majestic file.
        foreach($this->getMajestic as $item) {
            if ($item->method == 'DownloadBackLinks' && \Storage::disk('local')->exists($item->callback)) {
                \Storage::disk('local')->delete($item->callback); //delete CSV file
            } elseif (in_array($item->method, ['GetDemo', 'GetBackLinkData', 'GetRefDomains']) && \Storage::disk('local')->exists($item->response)) {
                \Storage::disk('local')->delete($item->response); //delete JSON file
            }
            // remove Majesti api call
            $item->delete();
        }

        // remove Urlanalizer file.
        if($this->getUrlanalizer) {
            if (\Storage::disk('local')->exists($this->getUrlanalizer->callback)) \Storage::disk('local')->delete($this->getUrlanalizer->callback);
            $this->getUrlanalizer->delete();
        }
    }

    public static function createAndStart($user_id, $url)
    {
        // precheck
        $api = (new \App\Classes\MajesticAPI([
            'url'           => $url,
            'method'        => 'GetIndexItemInfo'
        ]))->indexItemInfo();

        $item = $api->DataTables->Results->Data[0];

        $campaign = new self();
        $campaign->user_id = $user_id;
        $campaign->url = $url;
        $campaign->ip = $_SERVER['REMOTE_ADDR'];
        $campaign->trust_flow = $item->TrustFlow;
        $campaign->citation_flow = $item->CitationFlow;
        $campaign->start();

        dispatch(new \App\Jobs\CampaignBacklinksGet($campaign->id, 50000));

        CampaignPrecheck::store($campaign, $item);

        return $campaign;
    }

}