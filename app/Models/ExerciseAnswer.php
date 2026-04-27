<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciseAnswer extends Model
{
     protected $fillable = ['exercise_id', 'student_id', 'answer', 'is_correct'];

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
