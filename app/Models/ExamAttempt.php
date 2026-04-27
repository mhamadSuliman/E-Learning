<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    protected $fillable=[
        'exam_id',
        'student_id',
        'started_at',
        'ended_at',
        'score',
        'is_submitted'
    ];

    public function exam(){
        return $this->belongsTo(Exam::class);
    }

    public function student(){
        return $this->belongsTo(User::class,'student_id');
    }
    public function answers(){
        return $this->hasMany(ExamAnswer::class,'attempt_id');
    }
}
