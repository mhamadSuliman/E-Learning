<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCorseRequest;
use App\Http\Requests\UpdateCorseRequest;
use App\Models\Course;
use App\Models\User;
use App\Notifications\NewCourseNotification;
use Illuminate\Support\Facades\Auth;

class coursecontroller extends Controller
{
    // 📋 عرض كل الدورات
    public function index()
{
    $courses = Course::with('instructor')->get(); // جميع الكورسات
    return response()->json([
        'message' => 'جميع الكورسات المتاحة',
        'courses' => $courses
    ], 200);
}

    // ➕ إنشاء دورة جديدة
    public function store(StoreCorseRequest $request)
    {
    
        $validated = $request->validated();

        $course = Course::create($validated);
        $students = User::role('student')->get();

        foreach($students as $student){
            $student->notify(new NewCourseNotification($course));
        }

        return response()->json([
            'success' => true,
            'message' => 'تمت إضافة الدورة بنجاح ✅',
            'data' => $course
        ], 201);
    }

    // 🔍 عرض دورة واحدة
   public function show($id)
{

    $course = Course::with('instructor')->find($id);

    return response()->json([
        'message' => 'الكورس متاح',
        'course' => $course
    ], 200);
}
 // ✏️ تعديل دورة
    public function update(UpdateCorseRequest $request, $id)
    {
           $course = course::find($id);
        $validated = $request->validated();

        $course->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الدورة بنجاح ✅',
            'data' => $course
        ]);
    }

    // 🗑️ حذف دورة
    public function destroy($id)
    {
          $course = Course::find($id);
        $course->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الدورة بنجاح 🗑️'
        ]);
    }
//هون منجيب الطلاب الخاصين فقط بالاستاذ تبع الدورة يعني كل استاذ وطلابو 
  public function myStudents()
{
    $user = Auth::user();
    // جلب كل الطلاب المسجلين في كورسات هذا الأستاذ
    $students =$user->hasRole('admin')
    ? User::all():User::whereHas('enrolledCourses', function($query) use ($user) {
        $query->where('instructor_id', $user->id);
    })->get();

    return response()->json([
        'success' => true,
        'students' => $students
    ]);
}
}
