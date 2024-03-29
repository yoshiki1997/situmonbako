<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Problem;
use App\Models\Problem_URL;
use App\Models\ProblemReply;
use App\Models\History;
use App\Models\Like;
use App\Models\User;
use App\Http\UrlThumbnail\UrlThumbnail;
use League\Csv\Reader;


//require_once('../UrlThumbnail/UrlThumbnail.php');


class KnowlegeController extends Controller{
    public function __construct()
    {
        $this->problem = new Problem();
        $this->problem_url = new Problem_URL();
        $this->user = new User();
        $this->urlthumbnail = new UrlThumbnail();
    }

    public function index(Problem $problem)
    {
        $problems = $this->problem->latestCreatedAtProblem();
        foreach($problems as $problem){
            foreach ($problem->problemUrl as $url) {
                $result = $this->urlthumbnail->getUrlThumbnail($url->url);
                $url->title = $result['title'];
                $url->image = $result['image'];
                $url->description = $result['description'];
            }
        }//dd($problems);

        /*$problem_urls = [];
        foreach($problems as $problem)
        {
            $problem_urls = Problem_URL::where('problem_id', $problem->id)->get();
        }*/

        if(auth()->check())
        {
            $userProblemLikes = auth()->user()->userProblemLikes()->pluck('problem_id')->toArray();
        } else {
            $userProblemLikes = null;
        }

        $replies = $problem->reply();

        // csv処理
        $csv = Reader::createFromPath(storage_path('app/amazon.csv'), 'r');
        $csv->setHeaderOffset(0); // ヘッダー行をスキップする場合はコメントアウト

        $records = $csv->getRecords();//dd($records);
        
        return view('posts.historia')->with([
            'problems' => $problems,
            //'problem_urls' => $problem_urls,
            'userProblemLikes' => $userProblemLikes,
            'records' => $records,
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'keyword' => 'required'
        ]);

        $keyword = $request->input('keyword');

        $category = $request->input('category');

        $query = Problem::query();

        $problems = null; // 変数を初期化

        if($keyword) {
             // 全角スペースを半角に変換
             $spaceConversion = mb_convert_kana($keyword, 's');

             // 単語を半角スペースで区切り、配列にする（例："山田 翔" → ["山田", "翔"]）
             $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
 
 
             // 単語をループで回し、ユーザーネームと部分一致するものがあれば、$queryとして保持される
             foreach($wordArraySearched as $value) {
                $query->where(function ($query) use ($value) {
                 $query->where('title', 'like', '%'.$value.'%')
                 ->orWhere('description', 'like', '%' . $value . '%');
                });
             }
             
 
            // 上記で取得した$queryをページネートにし、変数$usersに代入
             $problems = $query->with('problemUrl')->paginate(10);
        }

        if($category){
            $problems = Problem::with('categories')->where('category', $category)->orderBy('create_at', 'desc')->get();
        }

        /*$problems = Problem::where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%')
                    ->with('problemUrl')
                    ->latest()
                    ->paginate(10);*/

        if(auth()->check())
        {
            $userProblemLikes = auth()->user()->userProblemLikes()->pluck('problem_id')->toArray();
        } else {
            $userProblemLikes = null;
        }

        // csv処理
        $csv = Reader::createFromPath(storage_path('app/amazon.csv'), 'r');
        $csv->setHeaderOffset(0); // ヘッダー行をスキップする場合はコメントアウト

        $records = $csv->getRecords();//dd($records);
        
        return view('posts.historia')->with([
            'problems' => $problems,
            'userProblemLikes' => $userProblemLikes,
            'records' => $records,
        ]);
    }

    public function problemLikes(Request $request) {
        
        $problem_id = $request->input('problem_id');
        $problem = Problem::find($problem_id);
        $problemLike = $this->user->problemLike($problem);

        return redirect()->back();
    }

    public function pickup($id) {
        if(auth()->check())
        {
            $user_id = auth()->user()->id;
        } else 
        {
            return redirect()->route('login');
        }
            $historys = History::select('id', 'url', 'title', 'comment', 'user_id')->where('user_id', $user_id)->get();
        $likes = Like::select('id', 'url', 'title', 'comment', 'user_id')->where('user_id',$user_id)->get();
        $problems = Problem::where('user_id',$user_id)->with('problemUrl')->with('categories')->get();
        $updateproblem = Problem::with('problemUrl')->with('categories')->find($id);

        return view('dashboard')->with([
            'updateproblem' => $updateproblem,
            'problems' => $problems,
            'historys' => $historys,
            'likes' => $likes,
        ]);
    }

    public function updateReply(Request $request,$id)
    {
        $request->validate([
            'body' => 'required',
        ]);

        $reply = ProblemReply::find($id);
        
        $reply->fill([
            'body' => $request->input('body')
        ])->save();

        return redirect()->back()->with('success', 'リプライが更新されました。');
    }

    public function destory($id) {
        $deleteproblem = $this->problem->deleteProblemById($id);
        
        return redirect()->route('dashboard');
    }

    public function destroyReply($id)
    {
        $destory = ProblemReply::destroy($id);

        return redirect()->back();
    }
}
