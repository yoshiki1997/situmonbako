<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Problem;

class FavoriteController extends Controller
{
    public function index($user_id)
    {
        $user = User::with('userProblemLikes')->with('reply')->find($user_id);//dd($user->userProblemLikes->pluck('id'));

        return view('posts.favorite')
        ->with(['user' => $user]);
    }
}
