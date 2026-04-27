<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;

class ExamAttemptController extends Controller
{
     public function startAttempt($exam_id)
{
    $user = auth()->user();

    $exam = Exam::findOrFail($exam_id);

    $existingAttempt = $user->attempt()
        ->where('exam_id', $exam_id)
        ->where('is_submitted', false)
        ->first();

    if ($existingAttempt) {
        return redirect()
            ->back()
            ->with('info', 'عندك محاولة مفتوحة بالفعل 🔄');
    }

    $attempt = $user->attempt()->create([
        'exam_id' => $exam_id,
        'started_at' => now(),
    ]);

    return redirect()->route('exams.take', $attempt->id);
}
public function submitAnswer(Request $request, $attempt_id)
{
    $attempt = ExamAttempt::with('exam')->findOrFail($attempt_id);

    if ($attempt->is_submitted) {
        return redirect()->back()->with('error', 'تم التسليم مسبقاً 🚫');
    }

    $data = $request->validate([
        'question_id' => 'required|exists:exam_questions,id',
        'answer' => 'required|string',
    ]);

    $question = $attempt->exam->questions()->findOrFail($data['question_id']);

    $isCorrect = trim($data['answer']) === trim($question->correct_answer);

    $attempt->answers()->updateOrCreate(
        ['question_id' => $question->id],
        [
            'answer' => $data['answer'],
            'is_correct' => $isCorrect,
        ]
    );

    return redirect()->back()->with('success', $isCorrect ? 'صح ✅' : 'خطأ ❌');
}
public function submitAttempt($attempt_id)
{
    $attempt = ExamAttempt::with('answers')->findOrFail($attempt_id);

    if ($attempt->is_submitted) {
        return redirect()->back()->with('error', 'تم التسليم مسبقاً');
    }

    $total = $attempt->answers->count();
    $correct = $attempt->answers->where('is_correct', true)->count();

    $score = $total ? ($correct / $total) * 100 : 0;

    $attempt->update([
        'score' => $score,
        'is_submitted' => true,
        'ended_at' => now(),
    ]);

    return view('admin.exams.result', compact('attempt', 'score'));
}
}
