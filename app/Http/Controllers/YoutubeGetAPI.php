<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class YoutubeGetAPI {

    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.youtube.api_key');

    }

    public function YoutubeGetAPI($keyword)
    {

        $url = 'https://www.googleapis.com/youtube/v3/search';
        
        $param = 
        [
            'part' => 'snippet',
            'q' => $keyword,
            'key' => $this->apiKey,
            'type' => 'video',
            'maxResults' => 10,
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