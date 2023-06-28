<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    public function store(Request $request){

        $user_id = $request->input('user_id');
        $title = $request->input('title');
        $url = $request->input('url');

        $existingLike = Like::where('user_id', $user_id)->where('url', $url)->first();

        if($existingLike){
            $existingLike->delete();
        }else{
             // いいねを新規保存します
             $like = new Like();
             $like->user_id = $user_id;
             $like->title = $title;
             $like->url = $url;
             $like->save();
        }
    }
}
