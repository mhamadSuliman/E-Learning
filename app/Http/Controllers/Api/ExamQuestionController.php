<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamQuestionController extends Controller
{
    public function index($exam_id){
        $exam=Exam::with('questions')->find($exam_id);
        if(!$exam){
            return response()->json(['message' => 'الامتحان غير موجود ❌'], 404);
        }
         return response()->json([
            'exam' => $exam->title,
            'questions' => $exam->questions
        ]);
    }
    public function store(Request $request,$exam_id){
    $exam=Exam::find($exam_id);
    if(!$exam){
        return response()->json(['message' => 'الامتحان غير موجود ❌'], 404);
    }
    $data= $request->validate([
        'question' => 'required|string',
        'type' => 'required|in:multiple_choice,true_false',
        'options' => 'nullable|array',
        'correct_answer' => 'required|string',
    ]);
         $question = $exam->questions()->create($data);
            return response()->json([
            'message' => 'تمت إضافة السؤال بنجاح ✅',
            'question' => $question
        ], 201);
    }
    public function show($exam_id,$question_id){
        $exam=Exam::find($exam_id);
        if(!$exam){
            return response()->json(['message' => 'الامتحان غير موجود ❌'], 404);
        }
        $question=$exam->questions()->find($question_id);
        if (!$question) {
            return response()->json(['message' => 'السؤال غير موجود ❌'], 404);
    }
    return response()->json($question);
}
 public function destroy($exam_id, $question_id)
    {
        $exam = Exam::find($exam_id);

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
