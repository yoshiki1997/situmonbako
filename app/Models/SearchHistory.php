<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{
    use HasFactory;

    protected $table = 'search_histories';

    // user_idのヌル制限コマンド　ALTER TABLE search_historys MODIFY user_id bigint(20) unsigned NOT NULL;
    // user_idのヌル制限解除コマンド　ALTER TABLE search_historys MODIFY user_id bigint(20) unsigned NULL;

    protected $fillable = [
        'user_id',
        'keyword',
        'count',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function insertKeyword($request, $user_id) {

        $keyword = $request->keyword;

        $existingRecode = SearchHistory::where('keyword', $keyword)->first();

        if ($existingRecode) 
        {
            $existingRecode->increment('count');
        } else
        {
            $result = $this->create([
                'user_id' => $user_id,
                'keyword' => $request->keyword,
                'count' => 1,
            ]);
        }
    }

    public function getTopKeywords() {
        return SearchHistory::orderBy('count', 'desc')->take(5)->pluck('keyword');
    }
}
