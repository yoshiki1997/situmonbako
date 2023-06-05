<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'url',
        'comment',
    ];

    public function updateComment($request, $like) {
        $result = $like->fill([
            'comment' => $request->like_comment,
        ])->save();

        return $result;
    }
}
