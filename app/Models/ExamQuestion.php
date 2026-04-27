<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    protected $fillable=['exam_courses_id','question','options','correct_answer'];
     protected $casts = [
        'options' => 'array',
    ];
    public function exam()
    {
        return $this->belongsTo(Exam::class,'exam_courses_id');
    }
    public function answers(){
        return $this->hasMany(ExamAnswer::class,'exam_answers');
    }
}
