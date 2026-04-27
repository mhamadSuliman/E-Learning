<?php

use App\Models\course;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
// لو بتحب قناة خاصة بكل كورس (ممكن تستخدمها لو بدك تبث على قناة course.{id})
Broadcast::channel('course.{courseId}', function ($user, $courseId) {
    // السماح لو الأدمن أو المدرّس مال الكورس أو الطالب مشترك بالكورس
    $course = course::find($courseId);
    if (!$course) return false;

    if ($user->hasRole('admin')) return true;
    if ($user->hasRole('instructor') && $course->instructor_id === $user->id) return true;
    // تحقق إن الطالب مسجّل بالكورس
    return $user->enrolledCourses()->where('course_id', $courseId)->exists();
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id; // يسمح فقط للمستخدم صاحب الـ ID بالاشتراك
});
Broadcast::channel('students-channel', function ($user) {
    // نسمح فقط للمستخدمين اللي دورهم "student"
    return $user->hasRole('student');
});

