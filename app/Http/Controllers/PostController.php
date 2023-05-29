<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\Tag;
use Illuminate\Support\Facades\Http;

require_once('index.php');
require_once('YoutubeGetAPI.php');
require_once('StackExchangeGetAPI.php');
require_once('QittaGetAPI.php');
require_once('Pagenator.php');


class PostController extends Controller{
    public function index(Tag $tags)
    {
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
                    'limit' => 10
                ]
            ]
        );
    
        // API通信で取得したデータはjson形式なので
        // PHPファイルに対応した連想配列にデコードする
        $questions = json_decode($response->getBody(), true);

        //ページネイト処理
        /*$currentPage = request()->get('page', 1);
        $perPage = 10;
        $offset = ($currentPage - 1) * $perPage;
        $questions = new LengthAwarePaginator(
            array_slice($questions['questions'], $offset, $perPage),
            count($questions['questions']),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );*/

        $Pagenator = new Pagenator();
        $questions = $Pagenator->Pagenator($questions);

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
        //dd($questions);
        // index bladeに取得したデータを渡す
        
        $youtubeclient = new YoutubeGetAPI();
        $keyword = 'game';
        $data = $youtubeclient->YoutubeGetAPI($keyword);
        $data = $Pagenator->youtubePagenator($data);
        //dd($data);

        $qittaclient = new QittaGetAPI();
        $qittaposts = $qittaclient->QittaGetTrend();
        $qittaposts = $Pagenator->QittaPagenator($qittaposts);
        //$qittaposts = $Pagenator->youtubePagenator()

        // 使用者のユーザーID
        if(auth()->check()) {
            $userId = auth()->user()->id;
        } else {
            $userId = null;
        }
        

        return view('posts.index')->with([
            'questions' => $questions,
            'tags' => $tags['tags'],
            'datas' => $data,
            'qittaposts' => $qittaposts,
            'user_id' => $userId,
        ]);

         /*// index bladeに取得したデータを渡す
         return view('posts.index')->with([
            'questions' => $questions['questions'],
        ]);*/
    }    

    public function show($question_id)
        {
        // クライアントインスタンス生成
        $client = new \GuzzleHttp\Client();
    
        // GET通信するURL
        $url = "https://teratail.com/api/v1/questions/{$question_id}";
    
        // リクエスト送信と返却データの取得
        // Bearerトークンにアクセストークンを指定して認証を行う
        $response = $client->request(
            'GET',
            $url,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.teratail.token')
                ]
            ]
        );
    
        // API通信で取得したデータはjson形式なので
        // PHPファイルに対応した連想配列にデコードする
        $questioninfo = json_decode($response->getBody(), true);
        
        // index bladeに取得したデータを渡す
            return view('posts.show')->with([
                'questioninfo' => $questioninfo['question'],
            ]);
        }

    public function search(Request $request)
    {
        $search = $request->input("search");

        $client = new \GuzzleHttp\Client();

        $url = "https://teratail.com/api/v1/questions";

        $response = $client->request(
            'GET',
            $url,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.teratail.token')
                ],
                
                'query' => [
                    'query' => $search,
                    'limit' => 20,
                    'sort' => 'created',
                    'order' => 'desc'
                ]
            ]
        );

        $questions = json_decode($response->getBody(),true);

        return view("posts/search")->with([
            'questions' => $questions['questions'],
            'search' => $search
        ]);
    }

    public function tagsSearch(Request $request)
    {
        // 検索キーワード
        $searchKeyword = $request->input('search');

        // 選択されたタグID
        // チェックボックスの時のコード
        // $selectedTags = (array)$request->input('tag_name', []);

        $inputTags = trim($request->input('tags'));
        $inputTags = str_replace("　"," ",$inputTags);
        $selectedTags = explode(',', $inputTags);
        $selectedTags = array_map('urlencode', $selectedTags);
        $firstTag = reset($selectedTags);
        
        // 取得件数
        $limit = $request->input('limit');

        // ページ設定
        $page = 1;

        // クライアントインスタンス生成
        $client = new \GuzzleHttp\Client();

        // 質問格納用の配列
        $questions = [];

        
        
        //タグが選択されている場合のみ処理を行う
        if(!empty($selectedTags)) {
        // タグごとに質問を取得し結合する
        

            // teratailのAPIエンドポイント
            $apiUrl = "https://teratail.com/api/v1/tags/{$firstTag}/questions?limit=100&page={$page}";
            //dd($apiUrl);

                try {
                        // リクエスト送信と返却データの取得
                        $response = $client->request('GET', $apiUrl, [
                            'headers' => [
                                'Authorization' => 'Bearer ' . config('services.teratail.token')
                            ],
                        ]);
                    } catch (\Exception $e) {
                        
                        $message = $firstTag . 'タグはteratailにはありません。';
                        return view('posts.tagssearch')->with('message', $message);
                    }
                    
                    // API通信で取得したデータはJSON形式なのでデコードする
                    $data = json_decode($response->getBody(), true);
                    //dd($data);

                    // 取得した質問を結合し重複を削除する
                    // 取得した質問を結合し重複を削除する
                    if(isset($data['questions']))
                    {
                        // タグの出現回数をカウントする配列を初期化
                        $tagCounts = [];
                        $TagCountsid = 0;

                        // 一つ目のタグで取得した１００件の質問に
                        // ほかのタグがマッチしているかの確認
                        $questionKey = 0;
                        foreach($data['questions'] as $question)
                        {
                            $count = 0;
                            foreach($question['tags'] as $tag)
                            {
                                if(in_array(strtolower($tag), array_map('strtolower', $selectedTags)))
                                {
                                    //dd($tag,$selectedTags,in_array($tag,$selectedTags,true));
                                    $count = $count + 1;
                                }
                                //dd($count);
                            }
                            $tagCounts[$TagCountsid] = $count;
                            $TagCountsid++;
                        }

                        //$tagCounts[$TagCountsid] = $count;
                        //$TagCountsid++;
                        // すべてのタグがマッチしていない場合、質問を配列から削除する
                        //dd($tagCounts);
                        //$questionKey = 0;
                        foreach($tagCounts as $questionKey => $tagCount)
                        {
                            //dd($tagCount !== count($selectedTags),$tagCounts,$tagCount,count($selectedTags));   
                            if ($tagCount !== count($selectedTags))
                            {
                                //dd($data['questions']);
                                //dd($tagCount,count($selectedTags));
                                unset($data['questions'][$questionKey]);
                                //dd($data['questions']);
                                //$questionKey++;
                            }
                        }
                        
                        
                        //$data['questions'] = array_values($data['questions']);

                    } 

                    $questions = $data['questions'];
                    //dd($questions);
                    //$page++;

                    /*{
                        $questions = array_merge($questions, $data['questions']);
                        $questions = array_unique($questions, SORT_REGULAR);
                    }else{
                        $message = $tag . 'タグはteratailにはありません。';
                        return view('posts.tagssearch')->with('message', $message);
                    }
                    // 最大100件の質問を超えた場合はループを終了する
                    if (count($questions) >= 100) {
                        break;
                    }*/
                /* catch (\Exception $e) {
                    //エラーメッセージを取得
                    $errorMessage = $e->getMessage();
                    // エラーハンドリング
                    // エラーメッセージを表示したり、適切な処理を行う
                    return view('error', ['message' => $errorMessage]);
                }*/
            
        }
        
        //ページネイト処理
        $currentPage = request()->get('page', 1);
        $perPage = $request->input('perPage');
        $offset = ($currentPage - 1) * $perPage;
        $questions = new LengthAwarePaginator(
            array_slice($questions, $offset, $perPage),
            count($questions),
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

        
        return view('posts.tagssearch')->with([
        'questions' => $questions,
        'tags' => $tags['tags']
        ]);
    }

    public function test()
    {

        

// リクエストURLを構築
$baseUrl = 'https://teratail.com';
$tag = 'laravel';
$limit = 10;
//$url = "{$baseUrl}/tags/{$tag}/questions?limit={$limit}";
$url = "https://teratail.com/search?q=unreal%20engine%204";
// HTTPリクエストを送信してレスポンスを取得
$response = Http::get($url);

// レスポンスが成功した場合は質問情報を取得
if ($response->successful()) {
    // レスポンスのHTMLコンテンツから質問情報を抽出
    $html = $response->body();
    
    // 質問情報を解析して必要なデータを取得
    // ここでは例として、質問タイトルのリストを取得しています
    $questionTitles = [];
    $pattern = '/<a href="\/questions\/\d+"[^>]*>(.*?)<\/a>/';
    preg_match_all($pattern, $html, $matches);
    if (isset($matches[1])) {
        $questionTitles = $matches[1];
    }
    return view('test', ['questionTitles' => $questionTitles]);
} else {
    // リクエストが失敗した場合はエラーメッセージを表示
    echo "Request failed. Error: " . $response->status();
}

        
    }
}