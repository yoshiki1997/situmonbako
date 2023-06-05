<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Problem_URL extends Model
{
    use HasFactory;

    protected $table = 'problems_url';

    protected $fillable = [
        'problem_id',
        'url',
    ];

    public function problem() {
        return $this->belongsTo(Probles::class, 'problem_id');
    }
}
