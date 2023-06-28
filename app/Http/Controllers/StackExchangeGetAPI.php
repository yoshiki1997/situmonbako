<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;


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

    public function fetchQuestionsStackExchange($search)
    {
        $client = new Client();
        $apiKey = $this->apiKey;

        //$page = $request->get('page', 1); // デフォルトは1ページ目
        $page = 1;
        $pageSize = 50; // 1ページあたりの項目数を50に設定
        $keyword = $search;

        $response = $client->request('GET', 'https://api.stackexchange.com/2.2/questions', [
            'query' => [
                'order' => 'desc',
                'sort' => 'activity',
                'site' => 'stackoverflow',
                'key' => $apiKey,
                'intitle' => $keyword,
                'page' => $page,
                'pagesize' => $pageSize
            ]
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getBody();

        $data = json_decode($content, true);//dd($data);

        return $data['items'];
    }
    
    public function fetchQuestionsStackExchangeGameDev($search)
    {
        $client = new Client();
        $apiKey = $this->apiKey;

        //$page = $request->get('page', 1); // デフォルトは1ページ目
        $page = 1;
        $pageSize = 50; // 1ページあたりの項目数を50に設定
        $keyword = $search;

        $response = $client->request('GET', 'https://api.stackexchange.com/2.2/questions', [
            'query' => [
                'order' => 'desc',
                'sort' => 'activity',
                'site' => 'gamedev',
                'key' => $apiKey,
                'intitle' => $keyword,
                'page' => $page,
                'pagesize' => $pageSize
            ]
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getBody();

        $data = json_decode($content, true);//dd($data);

        return $data['items'];
    }

    public function fetchQuestionsStackExchangeJA($search)
    {
        $client = new Client();
        $apiKey = $this->apiKey;

        //$page = $request->get('page', 1); // デフォルトは1ページ目
        $page = 1;
        $pageSize = 50; // 1ページあたりの項目数を50に設定
        $keyword = $search;

        $response = $client->request('GET', 'https://api.stackexchange.com/2.2/questions', [
            'query' => [
                'order' => 'desc',
                'sort' => 'activity',
                'site' => 'ja.stackoverflow',
                'key' => $apiKey,
                'intitle' => $keyword,
                'page' => $page,
                'pagesize' => $pageSize
            ]
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getBody();

        $data = json_decode($content, true);//dd($data);

        return $data['items'];
    }

    public function fetchNokeywordQuestionsGameDevStackExchange()
    {
        $client = new Client();
        $apiKey = $this->apiKey;

        //$page = $request->get('page', 1); // デフォルトは1ページ目
        $page = 1;
        $pageSize = 50; // 1ページあたりの項目数を50に設定

        $response = $client->request('GET', 'https://api.stackexchange.com/2.2/questions', [
            'query' => [
                'order' => 'desc',
                'sort' => 'activity',
                'site' => 'gamedev',
                'key' => $apiKey,
                'page' => $page,
                'pagesize' => $pageSize
            ]
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getBody();

        $data = json_decode($content, true);//dd($data);

        return $data['items'];
    }

    public function fetchNokeywordQuestionsStackExchange()
    {
        $client = new Client();
        $apiKey = $this->apiKey;

        //$page = $request->get('page', 1); // デフォルトは1ページ目
        $page = 1;
        $pageSize = 50; // 1ページあたりの項目数を50に設定

        $response = $client->request('GET', 'https://api.stackexchange.com/2.2/questions', [
            'query' => [
                'order' => 'desc',
                'sort' => 'activity',
                'site' => 'stackoverflow',
                'key' => $apiKey,
                'page' => $page,
                'pagesize' => $pageSize
            ]
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getBody();

        $data = json_decode($content, true);//dd($data);

        return $data['items'];
    }

    public function fetchNokeywordQuestionsJAStackExchange()
    {
        $client = new Client();
        $apiKey = $this->apiKey;

        //$page = $request->get('page', 1); // デフォルトは1ページ目
        $page = 1;
        $pageSize = 50; // 1ページあたりの項目数を50に設定

        $response = $client->request('GET', 'https://api.stackexchange.com/2.2/questions', [
            'query' => [
                'order' => 'desc',
                'sort' => 'activity',
                'site' => 'ja.stackoverflow',
                'key' => $apiKey,
                'page' => $page,
                'pagesize' => $pageSize
            ]
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getBody();

        $data = json_decode($content, true);//dd($data);

        return $data['items'];
    }

}