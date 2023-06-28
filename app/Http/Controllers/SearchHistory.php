<?php

use App\Models\SearchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchHistoryQuery {

    /*public function __construct()
    {

    }*/

public function search(Request $request)
{
    $userId = Auth::id();
    $searchHistories = SearchHistory::where('user_id', $userId)
        ->orderByDesc('created_at')
        ->limit(10)
        ->get();

    // 検索の実行など、その他の処理を追加する
    return  $searchHistories;
    // リダイレクトなどのレスポンスを返す
}
}