<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\Lesson;
use App\Models\Course;
use App\Notifications\NewLessonNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    
    public function index($course_id)
    {
        $user = Auth::user();
        $course = Course::with('lessons')->findOrFail($course_id);
        $lessons = $course->lessons()->orderBy('order')->get();

        return response()->json([
            'message' => 'دروس الكورس:',
            'course' => $course->title,
            'lessons' => $lessons
        ], 200);
    }

    /**
     * إضافة درس جديد
     */
    public function store(StoreLessonRequest $request, $course_id)
    {
        $course = Course::findOrFail($course_id);
       $validated = $request->validated();

        $videoPath = $request->hasFile('video') 
            ? $request->file('video')->store('lessons/videos', 'public') 
            : null;

        $filePath = $request->hasFile('file') 
            ? $request->file('file')->store('lessons/files', 'public') 
            : null;

        $lesson = Lesson::create([
            'course_id' => $course->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'video_url' => $videoPath,
            'file_url' => $filePath,
            'order' => $validated['order'] ?? 0,
        ]);
        // جلب كل الطلاب المسجلين بالكورس
       $students = $course->students;

        // إرسال الإشعار لكل طالب
        foreach ($students as $student) {
         $student->notify(new NewLessonNotification($lesson));
}

        return response()->json([
            'message' => 'تمت إضافة الدرس بنجاح ✅',
            'lesson' => $lesson
        ], 201);
    }

    /**
     * تعديل درس
     */
    public function update(UpdateLessonRequest  $request, $course_id, $lesson_id)
    {
        $lesson = Lesson::findOrFail($lesson_id);
        $course = Course::findOrFail($course_id);

        if ($lesson->course_id !== $course->id) {
            return response()->json(['message' => 'الدرس لا ينتمي لهذا الكورس ❌'], 400);
        }
        $validated =$request->validated();

        if ($request->hasFile('video')) {
            if ($lesson->video_url) {
                Storage::disk('public')->delete($lesson->video_url);
            }
            $lesson->video_url = $request->file('video')->store('lessons/videos', 'public');
        }

        if ($request->hasFile('file')) {
            if ($lesson->file_url) {
                Storage::disk('public')->delete($lesson->file_url);
            }
            $lesson->file_url = $request->file('file')->store('lessons/files', 'public');
        }

        $lesson->update($validated);

        return response()->json([
            'message' => 'تم تعديل الدرس بنجاح ✅',
            'lesson' => $lesson
        ]);
    }

    /**
     * حذف درس
     */
    public function destroy($course_id, $lesson_id)
    {
        $lesson = Lesson::findOrFail($lesson_id);
        $course = Course::findOrFail($course_id);

        if ($lesson->course_id !== $course->id) {
            return response()->json(['message' => 'الدرس لا ينتمي لهذا الكورس ❌'], 400);
        }
        if ($lesson->video_url) {
            Storage::disk('public')->delete($lesson->video_url);
        }
        if ($lesson->file_url) {
            Storage::disk('public')->delete($lesson->file_url);
        }

        $lesson->delete();

        return response()->json(['message' => 'تم حذف الدرس بنجاح 🗑️']);
    }
}
