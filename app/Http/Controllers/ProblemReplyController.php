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

        $request->validate([
            'user_id' => 'required',
            'problem_id' => 'required',
            'body' => 'required',
        ]);
        
        ProblemReply::create([
            'user_id' => auth()->user()->id,
            'problem_id' => $id,
            'body' => $request->input('body'),
        ]);

        // CSRFトークンを再生成して、二重送信対策
        $request->session()->regenerateToken(); // <- この一行を追加

        return redirect()->route('historia.index');
    }
}
