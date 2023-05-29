<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class QittaGetAPI {

    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.qitta.token');
    }

    public function QittaGetAPI($keyword)
    {

        $url = 'https://qiita.com/api/v2/items';
        
        $param = 
        [
            'query' => $keyword,
            'per_page' => 10,
        ];

        try{
            $response = $this->client->get($url,[
                'header' => [
                    'Authorization' => 'Bearer ' . $this->apiKey
                ] ,
                'query' => $param
                ]);
            $qittaposts = json_decode($response->getbody()->getContents(), true);
            return $qittaposts;
        } catch (GuzzleException $e) {
            return [];
        }
    }

    public function QittaGetTrend()
    {

        $url = 'https://qiita.com/api/v2/items';
        
        $param = 
        [
            'query' => 'url:https://qiita.com/trend',
            'per_page' => 10,
        ];

        try{
            $response = $this->client->get($url,[
                'header' =>[
                    'Authorization' => 'Bearer ' . $this->apiKey
                ],'query' => $param]);
            $qittaposts = json_decode($response->getbody()->getContents(), true);
            return $qittaposts;
        } catch (GuzzleException $e) {
            return [];
        }
    }
}