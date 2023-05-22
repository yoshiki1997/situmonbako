<?php
public function index(){
    // クライアントインスタンス生成
    $client = new \GuzzleHttp\Client();
    
    // GET通信するURL
    $url = 'https://teratail.com/api/v1/questions';

    // リクエスト送信と返却データの取得
    // Bearerトークンにアクセストークンを指定して認証を行う
    $response = $client->request(
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

    //ページネイト処理
    $currentPage = request()->get('page', 1);
    $perPage = 10;
    $offset = ($currentPage - 1) * $perPage;
    $questions = new LengthAwarePaginator(
        array_slice($questions['questions'], $offset, $perPage),
        count($questions['questions']),
        $perPage,
        $currentPage,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    //tag一覧の取得
    //まずタグ取得用のURLを追加
    $url_tags = 'https://teratail.com/api/v1/tags';

    //続いてトークン承認を記述
    $response_tags = $client->request(
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

    return [$questions,$tag];
}