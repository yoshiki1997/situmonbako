<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\models\Tips;
use App\models\History;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $historys = History::select('url', 'title')->where('user_id', $user_id)->get();
        
        
        return view('dashboard')->with(['historys' => $historys]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
