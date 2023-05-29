<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class StackExchangeGetAPI {

    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.stackexchange.token');
    }

    public function StackGetExchangeAPI($keyword)
    {

        $url = 'https://www.googleapis.com/youtube/v3/search';
        $url = 'https://api.stackexchange.com/2.3/search';
        
        $param = 
        [
            'site' => 'stackoverflow',
            'intitle' => $keyword,
            'key' => $this->apiKey,
            'pagesize' => 10,
        ];

        try{
            $response = $this->client->get($url,['query' => $param]);
            $data = json_decode($response->getbody()->getContents(), true);
            return $data['items'];
        } catch (GuzzleException $e) {
            return [];
        }
    }
}