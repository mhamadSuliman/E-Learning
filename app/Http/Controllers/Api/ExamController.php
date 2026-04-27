<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Course;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    // عرض كل الامتحانات لكورس معيّن
    public function index($course_id)
    {
        $course = Course::with('exams')->find($course_id);

        if (!$course) {
            return response()->json(['message' => 'الكورس غير موجود ❌'], 404);
        }

        return response()->json([
            'course' => $course->title,
            'exams' => $course->exams
        ]);
    }

    // إنشاء امتحان جديد
    public function store(Request $request, $courses_id)
    {
        $course = Course::find($courses_id);

        if (!$course) {
            return response()->json(['message' => 'الكورس غير موجود ❌'], 404);
        }

       $data = $request->validate([
    'title' => 'required|string',
    'description' => 'nullable|string',
    'duration' => 'nullable|integer',
]);

$exam = $course->exams()->create($data);


        return response()->json([
            'message' => 'تم إنشاء الامتحان بنجاح ✅',
            'exam' => $exam
        ], 201);
    }

    // عرض امتحان واحد بالتفاصيل
    public function show($course_id, $exam_id)
    {
        $exam = Exam::with('questions')->where('course_id', $course_id)->find($exam_id);

        if (!$exam) {
            return response()->json(['message' => 'الامتحان غير موجود ❌'], 404);
        }

        return response()->json($exam);
    }

    // حذف امتحان
    public function destroy($course_id, $exam_id)
    {
        $exam = Exam::where('course_id', $course_id)->find($exam_id);

        if (!$exam) {
            return response()->json(['message' => 'الامتحان غير موجود ❌'], 404);
        }

        $exam->delete();

        return response()->json(['message' => 'تم حذف الامتحان ✅']);
    }
}
