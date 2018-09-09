<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Payments;
use App\Models\RefEvents;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;

class ReferralController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['refCookie']]);
    }

    public function refCookie($id)
    {
        if(\Auth::guest())
            return redirect('/')->withCookie(\Cookie::forever('referrer', $id));
        return redirect('/');
    }

    /**
     * Display a listing of the referrals.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var User $user */
        $user = \Auth::user();
        $user->generatePromocode();

        $events = RefEvents::whereIn('user_id', function($query) {
            $query->select(DB::raw('user_id'))
                ->from('referrals')
                ->where('referrer_id', \Auth::id());
        })->get();
        $data = [];
        foreach($events as $item) {
            $data[] = [$item->id, strtoupper($item->action), $item->user_id, $item->created_at->format('d M Y'), strtoupper($item->plan), $item->revenue ? $item->revenue: '-', $item->revenue_status ? $item->revenue_status: '-'];
        }

        // TOP BAR
        $count_active_referrals = \DB::select("SELECT count(*) as cnt FROM referrals t1 inner join subscriptions t2 on t2.user_id=t1.user_id where t1.referrer_id=? and t2.is_active=1", [\Auth::id()])[0]->cnt;

        /*UPD 2017-09-29 show */
        $new_sales = \DB::select("SELECT sum(t3.revenue) as sum FROM referrals t1 inner join ref_events t3 on t3.user_id = t1.user_id where t1.referrer_id = ? and t3.revenue_status='Hold' and t3.action='bill' and date_format(t3.created_at, '%y%m') = date_format(CURRENT_DATE, '%y%m')", [\Auth::id()])[0]->sum;

        $count_rebills = \DB::select("SELECT count(*) as cnt FROM referrals t1 inner join ref_events t3 on t3.user_id = t1.user_id inner join subscriptions t4 on t4.user_id = t1.user_id where t1.referrer_id = ? and t3.revenue_status='Hold' and t4.is_active=1 and t4.rebills <> 0 and date_format(t3.created_at, '%y%m') = date_format(CURRENT_DATE, '%y%m')", [\Auth::id()])[0]->cnt;
        $rec_evenue = \DB::select("SELECT sum(t3.revenue) as sum FROM referrals t1 inner join ref_events t3 on t3.user_id = t1.user_id where t1.referrer_id = ? and t3.revenue_status='Hold' and date_format(t3.created_at, '%y%m') = date_format(CURRENT_DATE, '%y%m')", [\Auth::id()])[0]->sum;

        // NEW sales for each day
        $new_sales_p = \DB::select("SELECT sum(t3.revenue) as sum, day(t3.created_at) as day FROM referrals t1 inner join ref_events t3 on t3.user_id = t1.user_id where t1.referrer_id = ? and t3.revenue_status='Hold' and t3.action='bill' and date_format(t3.created_at, '%y%m') = date_format(CURRENT_DATE, '%y%m') group by day", [\Auth::id()]);
        // New rebills for each day
        $rebills_p = \DB::select("SELECT sum(t3.revenue) as sum, day(t3.created_at) as day FROM referrals t1 inner join ref_events t3 on t3.user_id = t1.user_id where t1.referrer_id = ? and t3.revenue_status='Hold' and t3.action='rebill' and date_format(t3.created_at, '%y%m') = date_format(CURRENT_DATE, '%y%m') group by day", [\Auth::id()]);

        $rec_evenue_prev_month = \DB::select("SELECT sum(t3.revenue) as sum FROM referrals t1 inner join ref_events t3 on t3.user_id = t1.user_id where t1.referrer_id = ? and t3.revenue_status='Approved' and date_format(t3.created_at, '%y%m') = date_format(CURRENT_DATE - INTERVAL 1 MONTH, '%y%m')", [\Auth::id()])[0]->sum;

        $hold = \DB::table('referrals')
            ->where('referrer_id', '=', $user->id)
            ->sum('balance_hold');

        // chart
        $maxDays=date('t');
        $new_sales_chart = $rebills_chart = [];
        while($maxDays--) $new_sales_chart[] = $rebills_chart[] = 0;

        foreach($new_sales_p as $item) {
            $new_sales_chart[$item->day -1] = $item->sum;
        }

        foreach($rebills_p as $item) {
            $rebills_chart[$item->day -1] = $item->sum;
        }


        $percent = 0;
        if($rec_evenue_prev_month) {
            $percent = (($rec_evenue - $rec_evenue_prev_month) / $rec_evenue_prev_month)*100;
        }


        JavaScriptFacade::put([
            'events' => $data,
            'new_sales_chart' => $new_sales_chart,
            'rebills_chart' => $rebills_chart,
        ]);

        return view('referral.index', [
            'hold' => $hold,
            'count_active_referrals' => $count_active_referrals,
            'new_sales' => $new_sales,
            'count_rebills' => $count_rebills,
            'rec_evenue' => $rec_evenue,
            'percent' => number_format($percent)
        ]);
    }

    /**
     * Display a listing of the referrals.
     *
     * @return \Illuminate\Http\Response
     */
    public function payHistory()
    {
        $data = [];
        foreach(Payments::selectRaw("id,created_at,CONCAT(amount, ' $') as amount")->where('user_id', \Auth::id())->get() as $item) {
            $data[] = [$item->id, $item->created_at->format('d M Y'), $item->amount];
        }

        return response()->json(["aaData" => $data]);
    }

    /**
     * Display a listing of the referrals.
     *
     * @return \Illuminate\Http\Response
     */
    public function referrals()
    {

        $data = [];
        foreach(\DB::select("SELECT t1.user_id, t1.created_at, t2.plan, t2.rebills, t1.balance_hold, t1.balance_approved
        FROM referrals t1 inner join subscriptions t2 on t1.user_id=t2.user_id where t1.referrer_id=?", [\Auth::id()]) as $item) {
            $data[] = [$item->user_id, $item->created_at, $item->plan, $item->rebills, $item->balance_hold, $item->balance_approved];
        }

        return response()->json(["aaData" => $data]);
    }
}
