<?php

namespace App\Http\Controllers;


use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\Tips;
use App\Models\History;
use App\Models\Problem;
use App\Models\Category;
use App\Models\Problem_URL;
use App\Models\UserImage;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{

    public function __construct()
    {
        $this->problem = new Problem();
        $this->problem_url = new Problem_URL();
        $this->history = new History();
        $this->Tips = new Tips();
        $this->like = new Like();
        $this->userimage = new UserImage();
        $this->user = new User();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $historys = History::select('id', 'url', 'title', 'comment', 'user_id')->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        $likes = Like::select('id', 'url', 'title', 'comment', 'user_id')->where('user_id',$user_id)->get();
        $problems = Problem::where('user_id',$user_id)->with('problemUrl')->with('categories')->with('reply')->orderBy('priority', 'desc')->orderBy('updated_at', 'desc')->get();
        $images = UserImage::where('user_id', $user_id)->get();
        //$problem_urls = Problem_URL::where('problem_id', $problems->id)->get();

        return view('dashboard')->with(['historys' => $historys,'likes' => $likes,'problems' => $problems, 'images' => $images,]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // URLとタイトルの取得
        $url = $request->input('url');
        $title = $request->input('title');
        $user_id = $request->input('user_id');

        // URLが既に格納されているかチェックする
        $existingHistory = History::where('url', $url)->first();

        if ($existingHistory) {
            // 既に同じURLが存在する場合、保存を行わずにリダイレクトする
            return redirect()->back();
        }

        // URLを保存する処理
        $history = new History();
        $history->url = $url;
        $history->title = $title;
        $history->user_id = $user_id;
        $history->save();

        // 適切なリダイレクト先にリダイレクトする
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function problemstore(Request $request)
    {  
        $request->validate([
            'title' => 'required'
        ]);

        DB::beginTransaction();

        try{
            $categories = explode(',', $request->categories);
            $categories = array_map('trim', $categories);
            // URLとタイトルの取得
            $urls = [];
            for($c = 0; $c <= 9; $c++)
            {
                if($c == 0)
                {
                    $urls[0] = $request->input('problem_url');
                }else 
                {
                    if($request->input('problem_url' . $c) == null)
                    {
                        break;   
                    }
                    $urls[$c] = $request->input('problem_url' . $c);
                }
            }
            $urls = $urls;
            $url = $request->input('problem_url'); 
            $title = $request->input('title');
            $user_id = auth()->user()->id;
            $status = $request->input('status');
            $description = $request->input('description');
            $priority = $request->input('priority');
            $categroy = $request->input('category');

            // URLを保存する処理
            /*$problem = new Problem();
            $problem->title = $title;
            $problem->user_id = $user_id;
            $problem->status = $status;
            $problem->description = $description;
            $problem->priority = $priority;
            $problem->category = $categroy;
            $problem->save();*/

            $problem = Problem::create([
                'title' => $title,
                'user_id' => auth()->user()->id,
                'status' => $status,
                'description' => $description,
                'priority' => $priority,
                'category' => $categroy,
            ]);

            $newProblemId = $problem->id;

            /*$problem_url = new Problem_URL();
            if(isset($url))
            {
                $problem_url->problem_id = $newProblemId;
                $problem_url->url = $url;
                $problem_url->save();
            }*/
            
                foreach($urls as $url){
                    if($url !== null){
                    Problem_URL::create([
                        'problem_id' => $newProblemId,
                        'url' => $url,
                    ]);
                }
                }

            foreach($categories as $category){
                $existCategory = Category::where('category', $category)->first();
                if($existCategory){
                    $newProblem = Problem::find($newProblemId);
                    $existPivot = $newProblem->categories()->where('category', $existCategory)->exists();
                    if($existPivot){
                        continue;
                    }else{
                        $newProblem->categories()->attach($existCategory->id);
                    }
                }else {
                    $newProblem = Problem::find($newProblemId);
                    $existPivot = $newProblem->categories()->where('category', $category)->exists();
                    if($existPivot){
                        continue;
                    }else{
                        $categoryId = Category::create([
                            'category' => $category,
                        ]);
                        $newProblem->categories()->attach($categoryId->id);
                    }
                }
            }

            // CSRFトークンを再生成して、二重送信対策
            $request->session()->regenerateToken(); // <- この一行を追加

            DB::commit();

            // 適切なリダイレクト先にリダイレクトする
            return redirect()->back();

        } catch (\Exception $e) {
            // CSRFトークンを再生成して、二重送信対策
            $request->session()->regenerateToken(); // <- この一行を追加
            DB::rollback();
            echo "エラーメッセージ: " . $e->getMessage() . "\n";
            echo "ファイル: " . $e->getFile() . "\n";
            echo "行番号: " . $e->getLine() . "\n";
            //return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function problemurlstore(Request $request)
    {
        $problem_url = new Problem_URL();
        $problem_url->problem_id = $request->input('problem_id');
        $problem_url->url = $request->input('problem_url');
        $problem_url->save();

        // CSRFトークンを再生成して、二重送信対策
        $request->session()->regenerateToken(); // <- この一行を追加

        // 適切なリダイレクト先にリダイレクトする
        return redirect()->back();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {       

        DB::beginTransaction();

        $problem = Problem::find($id);
        $update_problem = $this->problem->updateProblem($request, $problem);
        // $existCategory = Category::where('category', $request->category)->first();

        /*if($existCategory == null)
        {
            $category = Category::create([
                'category' => $request->category,
            ]);
            $result = $problem->categories()->attach($category);
        }else{
            $existkankei = $problem->categories();
            if($existkankei){
                return redirect()->route('dashboard');
            }else{
            $category = $existCategory;
            $result = $problem->categories()->attach($category);
            }
        }*/
        
        $categories = explode(',', $request->categories);
        $categories = array_map('trim', $categories);
        $update_problem = Problem::find($id);

        foreach($categories as $category){
            if($category===""){
                $existCategory = Category::where('category', $category)->first();
                if($existCategory){
                    $existPivot = $update_problem->categories()->where('category_id', $existCategory->id)->exists();
                    if($existPivot){
                        continue;
                    }else{
                        $update_problem->categories()->attach($existCategory->id);
                    }
                }else {
                    $existPivot = $update_problem->categories()->where('category', $category)->exists();
                    if($existPivot){
                        continue;
                    }else{
                        $category = Category::create([
                            'category' => $category,
                        ]);
                        $update_problem->categories()->attach($category->id);
                    }
                }
            }else{
                $existCategory = Category::where('category', $category)->first();
                $existPivot = $update_problem->categories()->where('category_id', $existCategory->id)->exists();
                if($existPivot){
                    $update_problem->categories()->dettach($existCategory->id);
                }
            }
        }

        // CSRFトークンを再生成して、二重送信対策
        $request->session()->regenerateToken(); // <- この一行を追加

        DB::commit();

        return redirect()->route('dashboard');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function descriptionupdate(Request $request, $id)
    {
        $problem = Problem::find($id);
        $update_problem = $this->problem->updatedescription($request, $problem);

        return redirect()->route('dashboard');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function inputHistoryComment(Request $request, $id)
    {
        $history = History::find($id);
        $history_comment = $this->history->updateComment($request, $history);

        return redirect()->route('dashboard');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function inputLikeComment(Request $request, $id)
    {
        $like = Like::find($id);
        $like_comment = $this->like->updateComment($request, $like);

        return redirect()->route('dashboard');
    }

    public function follow(User $user) {
        
        $follow = $this->user->follow($user);
        
        return redirect()->back();
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyHistory($id)
    {
        $destroyHistory = History::destroy($id);
        
        return redirect()->route('dashboard');
    }

    public function deleteFollow(User $user) {

        $follow = $this->user->deleteFollow($user);

        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteproblem = $this->problem->deleteProblemById($id);
        
        return redirect()->route('dashboard');
    }
}
