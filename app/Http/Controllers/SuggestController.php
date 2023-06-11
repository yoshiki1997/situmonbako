<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class SuggestController extends Controller
{
    public function suggest(Request $request) {
        // クライアントから送信されたキーワードを取得
        $tags = $request->input('tag');

        // サジェスト候補を生成する処理を実装
        $suggestions = $this->generateSuggestions($tags);
        // レスポンスとしてサジェスト候補を返す
        return response()->json(['suggestions' => $suggestions]);
    }

    private function generateSuggestions($tags)
    {
        // サジェスト候補を格納する空の配列を作成
        $suggestions = [];

        // タグテーブルからキーワードに関連するタグを取得
        $relatedTags = Tag::whereRaw('LOWER(tag_name) LIKE ?', [strtolower($tags) . '%'])->get();

        // 取得したタグをサジェスト候補として追加
        foreach ($relatedTags as $tag) {
            $suggestions[] = $tag->tag_name;
        }

        // 生成されたサジェスト候補を返す
        return $suggestions;
    }
}
