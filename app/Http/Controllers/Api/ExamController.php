<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExamRequest;
use App\Http\Requests\UpdateExamRequest;
use App\Models\Exam;
use App\Models\Course;

class ExamController extends Controller
{
    // عرض كل الامتحانات لكورس معيّن
    public function index($course_id)
    {
        $course = Course::with('exams')->find($course_id);
        return response()->json([
            'course' => $course->title,
            'exams' => $course->exams
        ]);
    }

    // إنشاء امتحان جديد
    public function store(StoreExamRequest $request, $course_id)
    {
        $course = Course::findOrFail($course_id);
        $exam = $course->exams()->create($request->validated());

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

    public function update(UpdateExamRequest $request, $course_id, $exam_id)
    {
        $exam = Exam::where('course_id', $course_id)->where('id', $exam_id)->first();
        if (!$exam) {
            return response()->json([
                'message' => 'الامتحان غير موجود ❌'
            ], 404);
        }
        $exam->update($request->validated());

        return response()->json([
            'message' => 'تم تعديل الامتحان بنجاح ✅',
            'exam' => $exam
        ]);
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
