<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCorseRequest;
use App\Models\Course;
use App\Models\Courses_Categories;
use App\Models\User;
use App\Notifications\NewCourseNotification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
{
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        $courses = Course::all();
    } else {
        $courses = Course::where('instructor_id', $user->id)->get();
    }

    return view('admin.courses.index', compact('courses'));
}
    public function create()
{
    $categories = Courses_Categories::all();
    $instructors = User::role('instructor')->get();

    return view('admin.courses.create', compact('categories', 'instructors'));
}

    public function store(StoreCorseRequest $request)
{
    $user = Auth::user();

    // 🔒 منع أي شخص غير admin أو instructor
    if (!$user->hasRole('admin') && !$user->hasRole('instructor')) {
        return response()->json([
            'message' => 'غير مصرح لك بهذا الإجراء ❌'
        ], 403);
    }

    // 🔒 منع بدون صلاحية إنشاء كورس
    if (!$user->can('create course')) {
        return response()->json([
            'message' => 'ليس لديك صلاحية لاضافة كورسات ❌'
        ], 403);
    }

    // 🎯 تحديد الأستاذ الصحيح
    // admin بيختار instructor من الفورم
    // instructor بياخد حاله تلقائي
    $instructorId = $user->hasRole('admin')
        ? $request->instructor_id
        : $user->id;

    // 🧠 إنشاء الكورس
    $course = Course::create([
        'title' => $request->title,
        'description' => $request->description,
        'price' => $request->price,
        'author' => $request->author,
        'duration' => $request->duration,
        'students_number' => $request->students_number,
        'rating' => $request->rating,
        'image' => $request->image,
        'category_id' => $request->category_id,

        // 🔥 أهم سطر (حماية الملكية)
        'instructor_id' => $instructorId,
    ]);

    // 📢 إرسال إشعار للطلاب
    $students = User::role('student')->get();

    foreach ($students as $student) {
        $student->notify(new NewCourseNotification($course));
    }

    return redirect('/admin/courses')
        ->with('success', 'Course created successfully ✅');
}

    public function edit(Course $course)
    {
        return view('admin.courses.edit', [
            'course' => $course,
            'instructors' => User::role('instructor')->get()
        ]);
    }

    public function update(Request $request, Course $course)
{
    $user = auth()->user();

    // 🔒 منع غير المصرح
    if (!$user->hasRole('admin') && !$user->hasRole('instructor')) {
        return response()->json(['message' => 'غير مصرح ❌'], 403);
    }

    // 🎯 تحديد من يحق له تغيير الأستاذ
    $instructorId = $user->hasRole('admin')
        ? $request->instructor_id
        : $course->instructor_id; // الأستاذ ما بيغيره

    $course->update([
        'title' => $request->title,
        'description' => $request->description,
        'price' => $request->price,
        'author' => $request->author,
        'duration' => $request->duration,
        'students_number' => $request->students_number,
        'rating' => $request->rating,
        'image' => $request->image,
        'category_id' => $request->category_id,

        // 🔥 حماية الملكية
        'instructor_id' => $instructorId,
    ]);

    return redirect('/admin/courses')
        ->with('success', 'Course updated successfully ✅');
}

    public function destroy(Course $course)
    {
        $course->delete();

        return back();
    }
}