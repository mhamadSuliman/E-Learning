<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamAttemptController extends Controller
{
    public function startAttempt(Request $request,$exam_id){
        $user = Auth::user();
        //اول شي بدنا نتاكد انو الاكتحان موجود
          $exam = Exam::find($exam_id);
    if (!$exam) {
        return response()->json(['message' => 'الامتحان غير موجود ❌'], 404);
    }
    // نتأكد إنو ما عندو محاولة مفتوحة لنفس الامتحان (ما سلّمها)
    $existingAttempt = $user->attempt()
        ->where('exam_id', $exam_id)
        ->where('is_submitted', false)
        ->first();

    if ($existingAttempt) {
        return response()->json([
            'message' => 'عندك محاولة مفتوحة بالفعل! 🔄',
            'attempt' => $existingAttempt
        ]);
    }
     // نخلق محاولة جديدة
    $attempt = $user->attempt()->create([
        'exam_id' => $exam_id,
        'started_at' => now(),
    ]);

    return response()->json([
        'message' => 'بدأت المحاولة بنجاح ✅',
        'attempt' => $attempt,
    ], 201);
    }
    public function submitAnswer(Request $request, $attempt_id)
{
    $attempt = ExamAttempt::with('exam')->find($attempt_id);

    if (!$attempt) {
        return response()->json(['message' => 'المحاولة غير موجودة ❌'], 404);
    }

    // نمنع الطالب من الإرسال بعد التسليم
    if ($attempt->is_submitted) {
        return response()->json(['message' => 'تم تسليم الامتحان بالفعل 🚫'], 403);
    }

    $data = $request->validate([
        'question_id' => 'required|exists:exam_questions,id',
        'answer' => 'required|string',
    ]);

    // نجيب السؤال
    $question = $attempt->exam->questions()->find($data['question_id']);
    if (!$question) {
        return response()->json(['message' => 'السؤال غير تابع لهذا الامتحان ❌'], 400);
    }

    // نقارن الجواب
    $isCorrect = trim($data['answer']) === trim($question->correct_answer);

    // نخزن الاجابة
    $attempt->answers()->updateOrCreate(
        ['question_id' => $question->id],
        [
            'answer' => $data['answer'],
            'is_correct' => $isCorrect,
        ]
    );

    return response()->json([
        'message' => $isCorrect ? 'إجابة صحيحة ✅' : 'إجابة خاطئة ❌',
    ]);
}
public function submitAttempt($attempt_id)
{
    $attempt = ExamAttempt::with('answers')->find($attempt_id);

    if (!$attempt) {
        return response()->json(['message' => 'المحاولة غير موجودة ❌'], 404);
    }

    if ($attempt->is_submitted) {
        return response()->json(['message' => 'تم تسليم الامتحان مسبقًا ⚠️']);
    }

    // نحسب عدد الإجابات الصحيحة
    $totalQuestions = $attempt->answers->count();
    $correctAnswers = $attempt->answers->where('is_correct', true)->count();

    // نحسب العلامة بالنسبة المئوية
    $score = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;

    // نحدّث بيانات المحاولة
    $attempt->update([
        'score' => $score,
        'is_submitted' => true,
        'ended_at' => now(),
    ]);

    return response()->json([
        'message' => 'تم تسليم الامتحان بنجاح 🎉',
        'score' => $score,
    ]);
}
public function getResult($exam_id)
{
    $user = Auth::user();
    $attempts = $user->attempt()->where('exam_id', $exam_id)->get();

    return response()->json([
        'exam_id' => $exam_id,
        'attempts' => $attempts
    ]);
}

}
