<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Problem;

class ProblemReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'problem_id',
        'user_id',
        'body',
    ];

    protected $table = 'problem_repleis';

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Problem(){
        return $this->hasMany(Problem::class);
    }
}
