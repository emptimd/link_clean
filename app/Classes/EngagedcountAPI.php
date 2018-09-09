<?php

namespace App\Classes;

use Carbon\Carbon;
use App\Models\EngagedcountApiCalls;

class EngagedcountAPI {

	protected $client;

	private $api_url = 'https://engagedcount.com/';
    private $api_key;

    private $request;

	public function __construct($data)
	{
        $this->api_key = env('ENGAGED_COUNT_KEY', false);
        if(!$this->api_key) die('ERROR - NO ENGAGED_COUNT_KEY SET');
		$this->client = new \GuzzleHttp\Client();
		$this->request    = (object)$data;
	}

    /**
     * Queues bulk shares/likes for given list of urls
     * @return mixed
     * @internal param array $options
     */
	public function bulk()
	{
        $promises = $insert = [];
        $cn=$i=0;
        //make promises of 10 chuncks of 500 urls.
        foreach(array_chunk($this->request->urls, 500) as $chunk) {

            $promises[$i][] = $this->client->postAsync($this->api_url.$this->request->method, [
                'query' => ['apikey' => $this->api_key],
                'body' => implode(PHP_EOL, $chunk)
            ]);
            if(++$cn == 10) $i++;
        }

        foreach($promises as $promise) {
            $results = \GuzzleHttp\Promise\settle($promise)->wait();
            foreach($results as $r) {
                if(isset($r['state']) && $r['state'] == 'rejected') { // @todo at the moment if engaged count rejects our bulk request we delete it, but we should examine why this is happening.
                    continue;
                }//
                if(!isset($r['value'])) continue;
                $insert[] = [
                    'campaign_id' => $this->request->campaign_id,
                    'date' => Carbon::now(),
                    'bulk_id' => json_decode($r['value']->getBody()->getContents())->bulk_id,
                    'processed' => 0
                ];
            }
        }

        EngagedcountApiCalls::insert($insert);

	}

    /**
     * Used to bulk check domains for UserCheckBacklinks.
     */
    public function bulkCheck()
    {
        $promises = $insert = [];
        $cn=$i=0;
        //make promises of 10 chuncks of 500 urls.
        foreach(array_chunk($this->request->urls, 500) as $chunk) {

            $promises[$i][] = $this->client->postAsync($this->api_url.$this->request->method, [
                'query' => ['apikey' => $this->api_key],
                'body' => implode(PHP_EOL, $chunk)
            ]);
            if(++$cn == 10) $i++;
        }

        foreach($promises as $promise) {
            $results = \GuzzleHttp\Promise\settle($promise)->wait();
            foreach($results as $r) {
                if(isset($r['state']) && $r['state'] == 'rejected') { // @todo at the moment if engaged count rejects our bulk request we delete it, but we should examine why this is happening.
                    continue;
                }//
                if(!isset($r['value'])) continue;
                $insert[] = json_decode($r['value']->getBody()->getContents())->bulk_id;
            }
        }

        return $insert;

    }


}