<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
  protected $fillable = [
    'title',
    'description',
    'price',
    'author',
    'duration',
    'students_number',
    'rating',
    'image',
    'category_id',
    'instructor_id',
];



 public function category()
    {
        return $this->belongsTo(Courses_Categories::class, 'category_id');
    }
    public function  instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
    public function  students()
    {
        return $this->belongsToMany(User::class, 'course_student', 'course_id', 'student_id');
    }
    public function lessons()
{
    return $this->hasMany(Lesson::class, 'course_id');
}

public function exercises()
{
    return $this->hasMany(Exercise::class, 'course_id');
}
public function exams(){
    return $this->hasMany(Exam::class,'course_id');
}


}
