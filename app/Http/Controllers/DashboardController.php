<?php

namespace App\Http\Controllers;


use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\Tips;
use App\Models\History;
use App\Models\Problem;
use App\Models\Problem_URL;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->problem = new Problem();
        $this->problem_url = new Problem_URL();
        $this->history = new History();
        $this->Tips = new Tips();
        $this->like = new Like();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $historys = History::select('url', 'title')->where('user_id', $user_id)->get();
        $likes = Like::select('url','title')->where('user_id',$user_id)->get();
        $problems = Problem::where('user_id',$user_id)->get();
        $problem_urls = [];
        foreach($problems as $problem)
        {
            $problem_urls[$problem->id] = Problem_URL::where('problem_id', $problem->id)->get();
        }
        //$problem_urls = Problem_URL::where('problem_id', $problems->id)->get();
        
        return view('dashboard')->with(['historys' => $historys,'likes' => $likes,'problems' => $problems,'problem_urls' => $problem_urls]);
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
        // URLとタイトルの取得
        $url = $request->input('problem_url'); 
        $title = $request->input('title');
        $user_id = auth()->user()->id;
        $status = $request->input('status');
        $description = $request->input('description');
        $priority = $request->input('priority');
        $categroy = $request->input('category');

        // URLを保存する処理
        $problem = new Problem();
        $problem->title = $title;
        $problem->user_id = $user_id;
        $problem->status = $status;
        $problem->description = $description;
        $problem->priority = $priority;
        $problem->category = $categroy;
        $problem->save();

        $newProblemId = $problem->id;

        $problem_url = new Problem_URL();
        if(isset($url))
        {
            $problem_url->problem_id = $newProblemId;
            $problem_url->url = $url;
            $problem_url->save();
        }

        // 適切なリダイレクト先にリダイレクトする
        return redirect()->back();
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
        $problem = Problem::find($id);
        $update_problem = $this->problem->updateProblem($request, $problem);

        return redirect()->route('dashboard');
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
