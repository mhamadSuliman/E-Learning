<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CheckCoursePermission
{
    public function handle(Request $request, Closure $next, $permissionType = 'access')
    {
        $courseId = $request->route('course_id');
        $course = Course::with('students')->find($courseId);
        $user = Auth::user();

        if (!$course) {
            return response()->json(['message' => 'الكورس غير موجود ❌'], 404);
        }

        if ($permissionType === 'edit' && !$this->canEditCourse($user, $course)) {
            return response()->json(['message' => 'غير مصرح لك بإدارة هذا الكورس ❌'], 403);
        }

        if ($permissionType === 'access' && !$this->canAccessCourse($user, $course)) {
            return response()->json(['message' => 'غير مصرح لك بالوصول لهذا الكورس ❌'], 403);
        }

        // مرر الطلب إذا تحقق الشرط
        return $next($request);
    }

    private function canAccessCourse($user, $course)
    {
        // الطالب لازم يكون مشترك أو ادمن أو مدرس الكورس
        return $user->hasRole('admin') ||
               $user->id == $course->instructor_id ||
               $course->students->contains($user->id);
    }

    private function canEditCourse($user, $course)
    {
        // فقط الادمن أو المعلم صاحب الكورس
        return $user->hasRole('admin') ||
               $user->id == $course->instructor_id;
    }
}
