<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Exam;

class ExamQuestionController extends Controller
{
    public function index($exam_id)
    {
        $exam = Exam::with('questions')->find($exam_id);
        if (!$exam) {
            return response()->json(['message' => 'الامتحان غير موجود ❌'], 404);
        }
        return response()->json([
            'exam' => $exam->title,
            'questions' => $exam->questions
        ]);
    }
    public function store(StoreQuestionRequest $request, $course_id, $exam_id)
    {
        $exam = Exam::where('course_id', $course_id)->find($exam_id);
        if (!$exam) {
            return response()->json([
                'message' => 'الامتحان غير موجود ❌'
            ], 404);
        }

        $question = $exam->questions()->create($request->validated());

        return response()->json([
            'message' => 'تمت إضافة السؤال بنجاح ✅',
            'question' => $question
        ], 201);
    }
    public function show($course_id, $exam_id, $question_id)
    {
        $exam = Exam::where('course_id', $course_id)->find($exam_id);
        if (!$exam) {
            return response()->json(['message' => 'الامتحان غير موجود ❌'], 404);
        }
        $question = $exam->questions()->find($question_id);
        if (!$question) {
            return response()->json(['message' => 'السؤال غير موجود ❌'], 404);
        }
        return response()->json($question);
    }
    public function update(UpdateQuestionRequest $request, $course_id, $exam_id, $question_id)
    {
        $exam = Exam::where('course_id', $course_id)->find($exam_id);
        if (!$exam) {
            return response()->json([
                'message' =>
                'الامتحان غير موجود ❌'
            ], 404);
        }

        $question = $exam->questions()->find($question_id);
        if (!$question) {
            return response()->json([
                'message' =>
                'السؤال غير موجود ❌'
            ], 404);
        }

        $question->update($request->validated());

        return response()->json([

            'message' =>
            'تم تعديل السؤال بنجاح ✅',

            'question' => $question
        ]);
    }

    public function destroy($course_id, $exam_id, $question_id)
    {
        $exam = Exam::where('course_id', $course_id)->find($exam_id);

        if (!$exam) {
            return response()->json(['message' => 'الامتحان غير موجود ❌'], 404);
        }

        $question = $exam->questions()->find($question_id);

        if (!$question) {
            return response()->json(['message' => 'السؤال غير موجود ❌'], 404);
        }

        $question->delete();

        return response()->json(['message' => 'تم حذف السؤال ✅']);
    }
}
