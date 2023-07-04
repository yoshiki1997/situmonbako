<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'histories';

    protected $fillable = [
        'user_id',
        'url',
        'title',
        'stored_at',
        'comment',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function updateComment($request,$history){
        $result = $history->fill([
            'comment' => $request->comment,
        ])->save();

        return $result;
    }
}
