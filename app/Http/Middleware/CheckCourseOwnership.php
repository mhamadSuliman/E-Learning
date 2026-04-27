<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class CheckCourseOwnership
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $courseParam = $request->route('course');
        $course = $courseParam instanceof Course 
        ? $courseParam 
         : Course::findOrFail($courseParam);


        if ($user->hasRole('instructor') && $course->instructor_id !== $user->id) {
            return response()->json(['message' => 'غير مصرح لك بالوصول لهذا الكورس ❌'], 403);
        }

        return $next($request);
    }
}
