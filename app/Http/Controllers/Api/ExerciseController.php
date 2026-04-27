<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\course;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExerciseController extends Controller
{
    // جلب كل التمارين لكورس معين
    public function index($course_id)
    {
        $course = course::with('exercises')->find($course_id);

        if (!$course) {
            return response()->json(['message' => 'الكورس غير موجود ❌'], 404);
        }

        return response()->json([
            'course' => $course->title,
            'exercises' => $course->exercises
        ]);
    }

    // جلب تمرين محدد
    public function show($course_id, $exercise_id)
    {
        $course = course::with('exercises')->find($course_id);

        if (!$course) {
            return response()->json(['message' => 'الكورس غير موجود ❌'], 404);
        }

        $exercise = $course->exercises()->find($exercise_id);

        if (!$exercise) {
            return response()->json(['message' => 'التمرين غير موجود ❌'], 404);
        }

        return response()->json($exercise);
    }

    // إنشاء تمرين جديد (للمعلم أو الادمن فقط)
    public function store(Request $request, $course_id)
    {
        $course = course::find($course_id);

        if (!$course) {
            return response()->json(['message' => 'الكورس غير موجود ❌'], 404);
        }
        $data = $request->validate([
            'question' => 'required|string',
            'type' => 'required|in:multiple_choice,true_false',
            'options' => 'nullable|array',
            'correct_answer' => 'required|string',
        ]);

        $exercise = $course->exercises()->create($data);

        return response()->json(['message' => 'تم إنشاء التمرين ✅', 'exercise' => $exercise], 201);
    }

    // تحديث تمرين (للمعلم أو الادمن فقط)
    public function update(Request $request, $course_id, $exercise_id)
    {
        $course = course::find($course_id);

        if (!$course) {
            return response()->json(['message' => 'الكورس غير موجود ❌'], 404);
        }

        $exercise = $course->exercises()->find($exercise_id);

        if (!$exercise) {
            return response()->json(['message' => 'التمرين غير موجود ❌'], 404);
        }

        $data = $request->validate([
            'question' => 'sometimes|required|string',
            'type' => 'sometimes|required|in:multiple_choice,true_false',
            'options' => 'nullable|array',
            'correct_answer' => 'sometimes|required|string',
        ]);

        $exercise->update($data);

        return response()->json(['message' => 'تم تعديل التمرين ✅', 'exercise' => $exercise]);
    }

    // حذف تمرين (للمعلم أو الادمن فقط)
    public function destroy($course_id, $exercise_id)
    {
        $course = course::find($course_id);

        if (!$course) {
            return response()->json(['message' => 'الكورس غير موجود ❌'], 404);
        }

        $exercise = $course->exercises()->find($exercise_id);

        if (!$exercise) {
            return response()->json(['message' => 'التمرين غير موجود ❌'], 404);
        }

        $exercise->delete();

        return response()->json(['message' => 'تم حذف التمرين ✅']);
    }

   
}
