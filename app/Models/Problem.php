<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    use HasFactory;

    protected $table = "problems";

    protected $fillable = [
        'user_id',
        'title',
        'priority',
        'description',
        'status',
        'category',
    ];

    public function updateProblem($request, $problem)
    {
        $result = $problem->fill([
            'title' => $request->title,
            'priority' => $request->priority,
            'description' => $request->description
        ])->save();

        return $result;
    }

    /**
     * 削除
     */
    public function deleteProblemById($id)
    {
        return $this->destroy($id);
    }
}
