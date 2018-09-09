<?php

namespace App\Classes;

use Carbon\Carbon;
use App\Models\MajesticApiCalls;
use Illuminate\Support\Facades\Storage;

class MajesticAPI {

    private $api_url = 'http://api.majestic.com/api/';
	private $api_key;

	private $request, $log;
	public $response;

    const perpage = 50000;
    const max_domains = 100000;

	public function __construct($data, $sandbox = false)
	{
		$this->request = (object)$data;
        $this->api_key = env('MAJESTIC_KEY', false);
        if(!$this->api_key) die('ERROR - NO MAJESTIC KEY SET');

		if($sandbox) $this->api_url = 'http://developer.majestic.com/api/';

        if(!in_array($this->request->method, ['GetTopics', 'GetSubscriptionInfo', 'GetAnchorText'])) $this->log_before();

		// strip http://, https://, www from url
		if(isset($this->request->url)) $this->request->url = str_replace(['https://www.','http://www.','https://','http://'], '',$this->request->url);

	}

	private function log_before()
	{
		$this->log = MajesticApiCalls::create([
			'date'          => Carbon::now(),
			'method'        => $this->request->method,
			'api_url'		=> $this->api_url,
			'campaign_id'   => isset($this->request->campaign_id) ? $this->request->campaign_id : 0,
			'request'       => json_encode($this->request, JSON_UNESCAPED_SLASHES)
		]);
	}
	
	private function log_after($response)
	{
		if($this->request->method == 'GetDemo' || $this->request->method == 'GetBackLinkData' || $this->request->method == 'GetRefDomains')
		{
			$directory = 'majestic/'.date('Y/m/d');
			$store_response = $directory.'/'.$this->request->method.'-'.$this->request->campaign_id.'-'.date('H_i_s').'.json';

			Storage::disk('local')->makeDirectory($directory);
			Storage::disk('local')->put($store_response, json_encode(json_decode($response), JSON_PRETTY_PRINT ^ JSON_UNESCAPED_SLASHES));

		}else $store_response = json_encode(json_decode($response), JSON_PRETTY_PRINT ^ JSON_UNESCAPED_SLASHES);// @TODO WHY DO WE DO THIS?!

		$this->log->response = $store_response;
		$this->log->save();
	}


    private function call($data = [])
    {
        $data['app_api_key'] = $this->api_key;
        $data['cmd'] = $this->request->method == 'GetDemo' ? 'GetBackLinkData' : $this->request->method;

        if($this->request->method == 'DownloadBackLinks') $data['NotifyURL'] .= $this->log->id.'/%%DOWNLOAD_FILE_LOCATION%%';

        $api_url_string = $this->api_url.'json?'.http_build_query($data);

        $ch = curl_init();
        curl_setopt_array ( $ch, [
            CURLOPT_URL 			=> $api_url_string,
            CURLOPT_HTTPHEADER 		=> ['Content-Type: application/json'],
            CURLOPT_SSL_VERIFYHOST 	=> false,
            CURLOPT_SSL_VERIFYPEER 	=> false,
            CURLOPT_CONNECTTIMEOUT	=> 0,
            CURLOPT_TIMEOUT			=> 600,
            CURLOPT_RETURNTRANSFER 	=> true,
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        if(!in_array($this->request->method, ['GetTopics', 'GetSubscriptionInfo', 'GetAnchorText'])) $this->log_after($response);

        return json_decode($response);
    }


	public function indexItemInfo()
	{
		return $this->call([
				'items' 		=> 1,
				'item0'			=> $this->request->url,
				'datasource'	=> 'fresh'
			]);
	}

	public function backLinkData()
	{
		$this->call([
				'item' 		    	=> $this->request->url,
				'Count'         	=> $this->request->count,
				'From'         	    => 0,
				'Mode'				=> 1, // If set to 1 it will also remove deleted links
				'ShowDomainInfo' 	=> 1, // if set to 1 then additional data table with information on referring domains present in backlinks will be returned
                'datasource'		=> 'fresh',
                'MaxSameSourceURLs' => 1 // ADDED By Bogdan 10.07

			]);
	}

    public function topics($id=0)
    {
        if(!is_array($this->request->url))
            return $this->call([
                'item' 		    	=> $this->request->url,
                'Count'         	=> $this->request->count,
                'datasource'		=> 'fresh',
            ]);

        $client = new \GuzzleHttp\Client();

        $data = [
            'Count'         	=> $this->request->count,
            'datasource'		=> 'fresh',
            'app_api_key' => $this->api_key,
            'cmd' => 'GetTopics'
        ];

        $promises = $insert = [];
        $cn=$i=0;
        //make promises of 10 chuncks of 500 urls.
        foreach($this->request->url as $key => $item) {
            $data['item'] = $key;
            $promises[$i][$key] = $client->getAsync($this->api_url.'json', [
                'query' => $data,
            ]);
            if(++$cn == 10) $i++;/*$i++;*/ // @undo into $i++
        }

        foreach($promises as $promise) {
            $results = \GuzzleHttp\Promise\settle($promise)->wait();
            foreach($results as $key => $r) {

                // new from engaged count cuz here mb some errors.
                if(isset($r['state']) && $r['state'] == 'rejected') { // @todo at the moment if engaged count rejects our bulk request we delete it, but we should examine why this is happening.
                    continue;
                }
                if(!isset($r['value'])) break 2;

                $content = json_decode($r['value']->getBody()->getContents());
                if($content->Code != 'OK') continue;
                //end new

                foreach($content->DataTables->Topics->Data as $data) {
                    $insert[] = [
                        'campaign_id' => $id,
                        'target_backlink_url' => $key,
                        'topic' => $data->Topic,
                        'links' => $data->Links,
                        'topical_trust_flow' => $data->TopicalTrustFlow,
                        'links_from_ref_domains' => $data->LinksFromRefDomains,
                        'ref_domains' => $data->RefDomains,
                        'pages' => $data->Pages,
                    ];
                }
            }
        }

        if($insert) foreach(array_chunk($insert, 1000) as $chunk) \App\TopicalTrustTarget::insert($chunk);

    }


//	public function demo()
//	{
//		$this->call([
//                'item' 		    	        => $this->request->url,
//				'Count'         	        => 100,
//                'From'         	            =>  0,
////                'MaxSourceURLsPerRefDomain' => 10,
//                'Mode'				        => 1, // If set to 1 it will also remove deleted links
//                'ShowDomainInfo' 	        => 1, // if set to 1 then additional data table with information on referring domains present in backlinks will be returned
//                'datasource'		        => 'fresh'
//			]);
//	}


	public function downloadBackLinks()
	{
		$this->call([
                'Query' 		    	        => $this->request->url,
                'SkipIfAnalysisCostGreaterThan' => 10000000,
                'datasource'		            => 'fresh',
                'NotifyURL'                     => config('app.url').'/callback/notifydownload/'
        ]);
	}

	// Used to recive 0-100.000 Referring domains for a given url that has more then 50.000 backlinks.
	public function refDomains()
    {
        $this->call([
            'item0'		    	=> $this->request->url,
            'Count'         	=> $this->request->count,
            'datasource'		=> 'fresh',
        ]);
    }

    public function anchorText()
    {
        return $this->call([
            'item' 		    	=> $this->request->url,
//            'Count'         	=> $this->request->count,
            'datasource'		=> 'fresh',
        ]);
    }

    //GetRefDomainInfo
    public function domains()
    {
        $i=0;
        $array = [];
        foreach($this->request->urls as $item) {
            $array["item".$i++] = $item;
        }

        return $this->call(
            [
                'items' => count($this->request->urls),
                'datasource'		=> 'fresh',
            ]+$array
        );
    }

    // Used to get info about subscription.
    public function subscriptionInfo()
    {
        return $this->call([
            'datasource' => 'fresh'
        ]);
    }
}