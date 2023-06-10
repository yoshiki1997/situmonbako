<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Problem;
use App\Models\Problem_URL;
use App\Models\User;

class KnowlegeController extends Controller
{
    public function __construct()
    {
        $this->problem = new Problem();
        $this->problem_url = new Problem_URL();
        $this->user = new User();
    }

    public function index(Problem $problem)
    {
        $problems = $this->problem->latestCreatedAtProblem();
        $problem_urls = [];
        foreach($problems as $problem)
        {
            $problem_urls = Problem_URL::where('problem_id', $problem->id)->get();
        }

        if(auth()->check())
        {
            $userProblemLikes = auth()->user()->userProblemLikes()->pluck('problem_id')->toArray();
        } else {
            $userProblemLikes = null;
        }

        $replies = $problem->reply();
        
        return view('posts.historia')->with([
            'problems' => $problems,
            'problem_urls' => $problem_urls,
            'userProblemLikes' => $userProblemLikes,
        ]);
    }

    public function problemLikes(Request $request) {
        
        $problem_id = $request->input('problem_id');
        $problem = Problem::find($problem_id);
        $problemLike = $this->user->problemLike($problem);

        return redirect()->back();
    }
}
