<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exam_courses';
    protected $fillable=['course_id','title','descrption','duration'];
      // يخلي Laravel يحول الـ options تلقائياً لمصفوفة
    protected $casts = [
        'options' => 'array',
    ];
    public function course()
    {
        
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function questions(){
        return $this->hasMany(ExamQuestion::class, 'exam_courses_id');
    }
    public function attempt(){
        return $this->hasMany(ExamAttempt::class);
    }
}
