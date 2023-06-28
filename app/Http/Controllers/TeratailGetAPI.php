<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class TeratailGetAPI {

    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.qitta.token');
    }

    public function TerataliGetAPI(){
    
        // GET通信するURL
        $url = 'https://teratail.com/api/v1/questions';
    
        // リクエスト送信と返却データの取得
        // Bearerトークンにアクセストークンを指定して認証を行う
        $response = $this->client->request(
            'GET',
            $url,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.teratail.token')
                ],

                'query' => [
                    'limit' => 100
                ]
            ]
        );
    
        // API通信で取得したデータはjson形式なので
        // PHPファイルに対応した連想配列にデコードする
        $questions = json_decode($response->getBody(), true);

        return $questions;
    }


    public function TeratailGetTags(){
    $url_tags = 'https://teratail.com/api/v1/tags';

    
        //続いてトークン承認を記述
        $response_tags = $this->client->request(
            'GET',
            $url_tags,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.teratail.token')
                ],
            ]
        );

        //タグのデコード
        $tags = json_decode($response_tags->getBody(), true);

        return $tags;
    }
}