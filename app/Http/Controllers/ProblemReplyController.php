<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Problem;
use App\Models\User;
use App\Models\ProblemReply;

class ProblemReplyController extends Controller
{
    public function __construct() {
        $this->problem = new Problem();
        $this->user = new User();
        $this->reply = new ProblemReply();
    }

    public function Reply(Request $request, $id) {
        
        ProblemReply::create([
            'user_id' => auth()->user()->id,
            'problem_id' => $id,
            'body' => $request->input('body'),
        ]);

        return redirect()->route('historia.index');
    }
}
