<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\Tips;
use App\Models\History;
use App\Models\Problem;
use App\Models\Problem_URL;

class UserPageController extends Controller
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
    public function index($id)
    {
        $user_id = $id;
        $historys = History::select('id', 'url', 'title', 'comment')->where('user_id', $user_id)->get();
        $likes = Like::select('id', 'url', 'title', 'comment')->where('user_id',$user_id)->get();
        $problems = Problem::where('user_id',$user_id)->with('problemUrl')->get();
        //$problem_urls = Problem_URL::where('problem_id', $problems->id)->get();

        
        return view('user.page')->with(['historys' => $historys,'likes' => $likes,'problems' => $problems,]);
    }
}
