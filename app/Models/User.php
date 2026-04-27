<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // لاحقاً ممكن تحذفه بعد ما تعتمد على Spatie بالكامل
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id');
    }

    public function instructorProfile()
    {
        return $this->hasOne(InstructorProfile::class);
    }
    public function attempt(){
        return $this->hasMany(ExamAttempt::class,'student_id');
    }

    public function dashboardRoute()
{
    return match(true) {
        $this->hasRole('admin') => '/admin/dashboard',
        $this->hasRole('instructor') => '/instructor/dashboard',
        $this->hasRole('student') => '/student/dashboard',
        default => '/dashboard',
    };
}

public function exams()
{
    return $this->hasManyThrough(
        \App\Models\Exam::class,
        \App\Models\ExamAttempt::class,
        'student_id', // foreign key في attempts
        'id',         // foreign key في exams
        'id',         // local key في user
        'exam_id'     // local key في attempts
    );
}
    
}
