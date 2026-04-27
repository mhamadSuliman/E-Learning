<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ExamAttempt;

class CheckExamOwnership
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $attemptId = $request->route('attempt_id'); // جاي من الرابط مثلاً /attempts/{attempt_id}/submit

        if ($attemptId) {
            $attempt = ExamAttempt::with('exam.course.students')->find($attemptId);

            if (!$attempt) {
                return response()->json(['message' => 'المحاولة غير موجودة ❌'], 404);
            }

            // التأكد إنو صاحب المحاولة هو نفسه المستخدم الحالي
            if ($attempt->student_id !== $user->id) {
                return response()->json(['message' => 'غير مصرح لك بالوصول إلى هذه المحاولة 🚫'], 403);
            }

            // التحقق من أن الطالب مشترك ضمن الكورس
            $courseStudents = $attempt->exam->course->students; // كل الطلاب بالكورس
            if (!$courseStudents->contains($user->id)) {
                return response()->json(['message' => 'أنت لست مشتركاً في هذا الكورس 🚫'], 403);
            }
        }

        return $next($request);
    }
}
