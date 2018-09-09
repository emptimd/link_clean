<?php

namespace App\Classes;

class GoogleAPI {

	protected $client;

	private $api_key	= 'hiddend_test';
	private $api_client	= 'hiddend_test';

	private $request, $log;
	public $response;

	public function __construct($data)
	{
		$this->client = new \GuzzleHttp\Client();
		$this->request = $data;

	}

	private function log_after($response)
	{
		$this->log->response = json_encode($response);
		$this->log->save();
	}

	private function error($err)
	{
		$this->log_after(['error' => $err]);

		return ['error' => $err];
	}

	public function safebrowsing()
	{

        $promises = $insert = $all_chunks = $bad_urls = [];
        $cn=$i=0;
        //make promises of 10 chuncks of 500 urls.
        foreach(array_chunk($this->request['urls'], 500) as $chunk) {
            $post_data = count($chunk).PHP_EOL.join(PHP_EOL, $chunk);

            if(strlen($post_data) > 35000) { // to prevent 413 error, we check if request is not too big, and if it is we chunk the request.
                foreach(array_chunk($chunk, 250) as $small_chunk) {
                    $post_data = count($small_chunk).PHP_EOL.join(PHP_EOL, $chunk);

                    // Well 250 also can be too big, so check once more.
                    if(strlen(count($small_chunk).PHP_EOL.join(PHP_EOL, $small_chunk)) > 35000) {
                        foreach(array_chunk($small_chunk, 125) as $tiny_chunk) {
                            $all_chunks[$i.$cn] = $tiny_chunk;
                            $promises[$i][$i.$cn] = $this->client->postAsync('https://sb-ssl.google.com/safebrowsing/api/lookup', [
                                'query' => [
                                    'client' 	=> $this->api_client,
                                    'key'		=> $this->api_key,
                                    'appver'	=> '1.0',
                                    'pver'		=> '3.0',
                                ],
                                'body' => count($tiny_chunk).PHP_EOL.join(PHP_EOL, $tiny_chunk)
                            ]);
                            if(++$cn == 10) $i++;
                        }
                    }else { // if 250 ok
                        $all_chunks[$i.$cn] = $small_chunk;
                        $promises[$i][$i.$cn] = $this->client->postAsync('https://sb-ssl.google.com/safebrowsing/api/lookup', [
                            'query' => [
                                'client' 	=> $this->api_client,
                                'key'		=> $this->api_key,
                                'appver'	=> '1.0',
                                'pver'		=> '3.0',
                            ],
                            'body' => $post_data
                        ]);
                        if(++$cn == 10) $i++;
                    }

                }
            }else { // if 500 ok.
                $all_chunks[$i.$cn] = $chunk;
                $promises[$i][$i.$cn] = $this->client->postAsync('https://sb-ssl.google.com/safebrowsing/api/lookup', [
                    'query' => [
                        'client' 	=> $this->api_client,
                        'key'		=> $this->api_key,
                        'appver'	=> '1.0',
                        'pver'		=> '3.0',
                    ],
                    'body' => $post_data
                ]);
                if(++$cn == 10) $i++;
            }

        }


        foreach($promises as $promise) {
            $results = \GuzzleHttp\Promise\settle($promise)->wait();
            foreach($results as $key => $r) {
                if(!isset($r['value'])) break;

                $result = [
                    'status' 	=> $r['value']->getStatusCode(),
                    'raw'		=> $r['value']->getBody()->getContents(),
                ];

                if($result['status'] == 200) {
                    foreach(explode(PHP_EOL, $result['raw']) as $pos => $status) if($status != 'ok') $bad_urls[] = $all_chunks[$key][$pos];
                }
            }
        }

        return $bad_urls;

	}

//    /**
//     * Fetches Mobile Data for given url from googleapis.com
//     * @return mixed
//     * @internal param array $options
//     */
//	private function method___mobiledata ()
//	{
//		$this->endpoint = $this->endpoint.'pagespeedonline/v3beta1/mobileReady';
//
//		return $this->call([
//			'screenshot' 					=> 'false',
//			'snapshots' 					=> 'false',
//			'locale' 						=> 'en_US',
//			'strategy' 						=> 'mobile',
//			'filter_third_party_resources' 	=> 'false',
//			'url'       					=> $this->request['urls']
//		]);
//	}
//
//
//    /**
//     * Fetches Page Speed data for given url
//     * @return mixed
//     * @internal param array $options
//     */
//	private function method___pagespeed ()
//	{
//		$this->endpoint = $this->endpoint.'pagespeedonline/v2/runPagespeed';
//
//		return $this->call([
//				'url' => $this->request['urls']
//				]);
//	}
}