<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
   public function index($course_id)
{
    $course = Course::with('exams')->findOrFail($course_id);

    return view('admin.exams.index', compact('course'));
}

public function create($course_id)
{
    $course = Course::findOrFail($course_id);

    return view('admin.exams.create', compact('course'));
}

public function store(Request $request, $course_id)
{
    $course = Course::findOrFail($course_id);

    $data = $request->validate([
        'title' => 'required|string',
        'description' => 'nullable|string',
        'duration' => 'nullable|integer',
    ]);

    $course->exams()->create($data);

    return redirect()
        ->route('admin.exams.index', $course_id)
        ->with('success', 'تم إنشاء الامتحان بنجاح ✅');
}
public function update(Request $request, $course_id, $exam_id)
{
    $exam = Exam::where('course_id', $course_id)
        ->findOrFail($exam_id);

    $data = $request->validate([
        'title' => 'required|string',
        'description' => 'nullable|string',
        'duration' => 'nullable|integer',
    ]);

    $exam->update($data);

    return redirect()
        ->route('admin.exams.index', $course_id)
        ->with('success', 'تم التعديل بنجاح ✅');
}

public function show($course_id, $exam_id)
{
    $exam = Exam::with('questions')
        ->where('course_id', $course_id)
        ->findOrFail($exam_id);

    return view('admin.exams.show', compact('exam'));
}


public function edit($course_id, $exam_id)
{
    $course = Course::findOrFail($course_id);
    $exam = Exam::findOrFail($exam_id);

    $courses = Course::all(); // 👈 هذا الناقص

    return view('admin.exams.edit', compact('course', 'exam', 'courses'));
}
public function destroy($course_id, $exam_id)
{
    $exam = Exam::where('course_id', $course_id)->findOrFail($exam_id);

    $exam->delete();

    return redirect()
        ->back()
        ->with('success', 'تم حذف الامتحان ✅');
}
}
