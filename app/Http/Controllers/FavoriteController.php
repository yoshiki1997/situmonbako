<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Problem;
use League\Csv\Reader;


class FavoriteController extends Controller
{
    public function index($user_id)
    {
        $user = User::with('userProblemLikes')->with('reply')->find($user_id);//dd($user->userProblemLikes->pluck('id'));

        // csv処理
        $csv = Reader::createFromPath(storage_path('app/amazon.csv'), 'r');
        $csv->setHeaderOffset(0); // ヘッダー行をスキップする場合はコメントアウト

        $records = $csv->getRecords();//dd($records);

        return view('posts.favorite')
        ->with([
            'user' => $user,
            'records' => $records,
        ]);
    }
}
