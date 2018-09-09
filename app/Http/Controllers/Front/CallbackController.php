<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignBacklink;
use App\Classes\UrlanalyzerAPINEW;
use App\Models\Subscriptions;
use App\Models\User;
use App\Models\FastspringApiCalls;
use App\Models\MajesticApiCalls;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CallbackController extends Controller
{
    /**
     * Urlanalyzer API callback
     * @param Request $request
     * @return array
     */
	public function urlanalyzer(Request $request)
	{
	    //LOG THAT UrlAnalyzer got here
        $id = $request->input('campaign_id');

        $data = [];
        // here we prapare our respose.
        foreach($request->input('data') as $item) { // @todo mb find a better way to insert keys.
            $data[$item['url']] = [
                'outgoing_backlinks' => $item['outgoing_backlinks'],
                'content_count' => $item['content_count'],
                'text_html_ratio' => $item['text_html_ratio'],
                'anchor_ratio' => $item['anchor_ratio'],
                'page_load_time' => $item['page_load_time'],
                'http_code' => $item['http_code'],
                'feed' => $item['feed'],
            ];
        }

        if($request->input('scenario') == 'added') {
            \Log::debug('Urlanalyzer called our url callback/urlanalyzer_added', ['campaign_id' => $id]);
            return $result = UrlanalyzerAPINEW::callbackUserAddedBacklinks($id, $data);
        }elseif($request->input('scenario') == 'checked') {
            \Log::debug('Urlanalyzer called our url callback/urlanalyzer_checked', ['campaign_id' => $id]);
            return $result = UrlanalyzerAPINEW::callbackUserCheckedBacklinks($id, $data);
        }

        if($request->input('is_paid')) {
            $result = UrlanalyzerAPINEW::callbackMarket($id, $data);
        }else {
            $result = UrlanalyzerAPINEW::callback($id, $data);
        }

		return $result;
	}

    // activate
    public function fastspring_activate(Request $request)
    {
        $callback	= $request->all();

        $campaign_id = 0;
        if(isset($callback['events'][0]['data']['tags']['scenario'])) {
            if ($callback['events'][0]['data']['tags']['scenario'] == 'subscribe_demo') {
                $campaign_id = $callback['events'][0]['data']['tags']['campaign_id'];
                CampaignBacklink::enable($campaign_id);

            }else if ($callback['events'][0]['data']['tags']['scenario'] == 'dashboard-start-campaign-subscription') {
                $campaign_id = $callback['events'][0]['data']['tags']['campaign_id'];

            }else if ($callback['events'][0]['data']['tags']['scenario'] == 'custom_campaign') {
                if(!isset($callback['events'][0]['data']['tags']['url'])) return;
                $campaign_id = Campaign::where('user_id', $callback['events'][0]['data']['tags']['referrer'])->where('url', $callback['events'][0]['data']['tags']['url'] )->orderBy('id', 'desc')->pluck('id')->first();
                if($campaign_id) {
                    dispatch(new \App\Jobs\CampaignBacklinksGet($campaign_id));
                }else return;
            }
        }


        $log = new FastspringApiCalls();
        $log->date = Carbon::now();
        $log->method = 'activate';
        $log->subscription_id 	= $callback['events'][0]['data']['id'];
        $log->callback 			= json_encode($callback, JSON_PRETTY_PRINT ^ JSON_UNESCAPED_SLASHES);

        /** @var User $user */
        $user = User::find($callback['events'][0]['data']['tags']['referrer']);
        if($user)
        {

            try {
                $user->activate_subscription($campaign_id, $callback['events'][0]['data']);
            }catch (\Exception $e) {
                \Log::error('we have an error in fastspring_activate_linkquidatornewFApi');
            }
            $log->campaign_id = $user->id;

        }

        $log->save();
    }

    // deactivate
    public function fastspring_deactivate(Request $request)
    {
        $callback	= $request->all();

        $log = new FastspringApiCalls();
        $log->date = Carbon::now();
        $log->method = 'deactivate';
        $log->subscription_id 	= $callback['events'][0]['data']['id'];
        $log->callback 			= json_encode($callback, JSON_PRETTY_PRINT ^ JSON_UNESCAPED_SLASHES);
        $log->campaign_id = 0;
        /** @var Subscriptions $model */
        $model = Subscriptions::where('id', $callback['events'][0]['data']['id'])->where('is_active', 1)->first();
        if($model) $model->deactivate_subscription();
        $log->save();
    }

    // rebill
    public function fastspring_bill()
    {
        \Log::info('fastspring_bill_linkquidatornewFApi');
    }

    // rebill
    public function fastspring_rebill(Request $request)
    {
        $callback	= $request->all();

        $log = new FastspringApiCalls();
        $log->date = Carbon::now();
        $log->method = 'rebill';

        $log->subscription_id 	= $callback['events'][0]['data']['order'];
        $log->callback 			= json_encode($callback, JSON_PRETTY_PRINT ^ JSON_UNESCAPED_SLASHES);

        $log->campaign_id = 0;
        // activate and rebill are called at same time by fastspring
        $model = Subscriptions::where(['id' => $callback['events'][0]['data']['subscription'], 'is_active' => 1])->first();

        if($model) $model->rebill_subscription($callback['events'][0]['data']);
        $log->save();
    }


    // rebill
    public function fastspring_refund(Request $request)
    {
        $callback	= $request->all();
        \Log::debug('fastspring_refund_linkquidatornewFApi', $callback);
        $log = new FastspringApiCalls();
        $log->date = Carbon::now();
        $log->method = 'refund';

        //if was a refund of a subscription
        /** @var Subscriptions $model */
        if(isset($callback['events'][0]['data']['items'][0]['subscription'])) {
            $is_order=false;
            $model = Subscriptions::find($callback['events'][0]['data']['items'][0]['subscription']);
        }else {
            $is_order = true;
            $model = Subscriptions::find($callback['events'][0]['data']['original']['id']);
        }
        if($model) {
            $log->subscription_id = $model->id;
            $log->campaign_id = $model->user_id;
            $model->refund_subscription($is_order);
        }

        $log->callback = json_encode($callback, JSON_PRETTY_PRINT ^ JSON_UNESCAPED_SLASHES);
        $log->save();

    }

    public function oauth2callback(Request $request, $campaign_id=0)
    {
        $client = (new \App\Classes\GA_Service())->getCliet();

        if(\Cookie::get('access_token')) {
            $request->session()->flash('oauth2callback_ci', $campaign_id);
            return back();
        } else if (!isset($_GET['code'])) {
            $request->session()->flash('back_url', $request->server('HTTP_REFERER'));
            $request->session()->flash('oauth2callback_ci', $campaign_id);

            $auth_url = $client->createAuthUrl();
            header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
        } else {
            $client->authenticate($_GET['code']);
            \Cookie::queue(cookie('access_token', $client->getAccessToken(), 30));
            $request->session()->keep(['oauth2callback_ci']);

            if($request->session()->exists('back_url')) {
                return redirect($request->session()->get('back_url'));
            }

            return redirect('dashboard');
        }

    }

    public function notify_download($id, $download_location)
    {
        \Log::info('majestic send notify_download: '.$id);
        $majestic = MajesticApiCalls::where('id', $id)->where('method', 'DownloadBackLinks')->first();
        if(!$majestic) return response('ERROR', 200)->header('Content-Type', 'text/plain');


        $directory = 'majestic/'.date('Y/m/d');
        $store_response = $directory.'/DownloadBackLinks-'.$majestic->campaign_id.'-'.date('H_i_s').'.csv';

        \Storage::disk('local')->makeDirectory($directory);

        // Raising this value may increase performance
        $buffer_size = 4096; // read 4kb at a time

        // sometimes (radom) majetic can return wrong url! like this :http://downloads.majesticseo.com/download_fresh_citationlabs_com_31_Jul_17_175CAD2753B8613D2A707168F9758EC2.csv.gzdownload_fresh_citationlabs_com_31_Jul_17_175CAD2753B8613D2A707168F9758EC2.csv.gz
        // we cut the url up to .csv.gz
        // @UPT 31.07.2017
        $download_location = substr($download_location,0,strpos($download_location, '.csv.gz')+7);

        // Open our files (in binary mode)
        try {
            $file = gzopen($download_location, 'rb');
            $out_file = fopen(storage_path('app/'.$store_response), 'wb');
        }catch (\Exception $e) {
            //sometimes (radom) majetic can return wrong url! like this :http://downloads.majesticseo.com/download_fresh_citationlabs_com_31_Jul_17_175CAD2753B8613D2A707168F9758EC2.csv.gzdownload_fresh_citationlabs_com_31_Jul_17_175CAD2753B8613D2A707168F9758EC2.csv.gz
            return response('ERROR', 200)->header('Content-Type', 'text/plain');
        }

        // Keep repeating until the end of the input file
        while (!gzeof($file)) {
            // Read buffer-size bytes
            // Both fwrite and gzread and binary-safe
            fwrite($out_file, gzread($file, $buffer_size));
        }

        // Files are done, close files
        fclose($out_file);
        gzclose($file);

        $majestic->update([
            'date_callback'	    => Carbon::now(),
            'callback'		    => $store_response,
        ]);

        dispatch(new \App\Jobs\CampaignBacklinksProcess($majestic->campaign_id));

        return response('OK', 200)->header('Content-Type', 'text/plain');
    }
}