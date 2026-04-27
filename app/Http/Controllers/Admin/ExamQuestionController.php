<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamQuestionController extends Controller
{
     public function index($exam_id)
{
    $exam = Exam::with('questions')->findOrFail($exam_id);

    return view('admin.exams.questions.index', compact('exam'));
}
public function store(Request $request, Exam $exam)
{
    $data = $request->validate([
        'question' => 'required|string',
        'type' => 'required|in:multiple_choice,true_false',
        'options' => 'nullable|array',
        'options.*' => 'nullable|string',
        'correct_answer' => 'required|string',
    ]);

    // تنظيف الخيارات (نشيل الفارغ)
    if (!empty($data['options'])) {
        $data['options'] = array_values(array_filter($data['options']));
    }

    $exam->questions()->create($data);

    return redirect()->back()->with('success', 'تمت إضافة السؤال بنجاح ✅');
}
public function show($exam_id, $question_id)
{
    $exam = Exam::findOrFail($exam_id);

    $question = $exam->questions()->findOrFail($question_id);

    return view('admin.exams.questions.show', compact('question', 'exam'));
}
public function destroy($exam_id, $question_id)
{
    $exam = Exam::findOrFail($exam_id);

    $question = $exam->questions()->findOrFail($question_id);

    $question->delete();

    return redirect()
        ->back()
        ->with('success', 'تم حذف السؤال ✅');
}
}
