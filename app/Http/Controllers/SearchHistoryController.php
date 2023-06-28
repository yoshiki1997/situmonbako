<?php

namespace App\Http\Controllers;

use App\Http\SearchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SearchHistoryController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $userId = Auth::id();

        // データ保存前に古いデータを削除する
        $searchHistories = SearchHistory::where('user_id', $userId)
        ->orderBy('created_at')
        ->limit(50)
        ->get();

        if ($searchHistories->count() >= 50) {
            $oldestHistory = $searchHistories->first();
            $oldestHistory->delete();
        }

        SearchHistory::create([
            'user_id' => $userId,
            'keyword' => $keyword,
        ]);

        // 検索の実行など、その他の処理を追加する

        // リダイレクトなどのレスポンスを返す
    }
}
