<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $fillable=['course_id','question','type','options','correct_answer'];
      // يخلي Laravel يحول الـ options تلقائياً لمصفوفة
    protected $casts = [
        'options' => 'array',
    ];

     public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
