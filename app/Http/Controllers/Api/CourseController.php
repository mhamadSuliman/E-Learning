<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCorseRequest;
use App\Http\Requests\UpdateCorseRequest;
use App\Models\Course;
use App\Models\User;
use App\Notifications\NewCourseNotification;
use App\Notifications\NewStudentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Stripe\Stripe;
use Stripe\Checkout\Session;


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
        $user = Auth::user();
        if (!$user->hasRole('instructor')) {
        return response()->json(['message' => 'غير مصرح لك بهذا الإجراء ❌'], 403);
    }
    if (!$user->can('create course')) {
        return response()->json(['message' => 'ليس لديك صلاحية لاضافة كورسات  ❌'], 403);
    }
    
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
    $authUser = Auth::user();
    $course = Course::with('instructor', 'students')->find($id);

    if (!$course) {
        return response()->json(['message' => 'الكورس غير موجود'], 404);
    }

    // التحقق من أن المستخدم مسجل في الكورس
    if ($authUser->hasRole('student') && !$course->students->contains($authUser->id)) {
        return response()->json(['message' => 'ليس لديك صلاحية الوصول لمحتوى هذا الكورس'], 403);
    }

    return response()->json([
        'message' => 'الكورس متاح',
        'course' => $course
    ], 200);
}


    // ✏️ تعديل دورة
    public function update(UpdateCorseRequest $request, $id)
    {
          $user = Auth::user();
           $course = course::find($id);

        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'الدورة غير موجودة ❌'
            ], 404);
        }
    if (!$user->can('update course')) {
        return response()->json(['message' => 'ليس لديك صلاحية لتعديل كورسات  ❌'], 403);
    }
    
        
    if (!$user->hasRole('admin') && $course->instructor_id !== $user->id) {
    return response()->json(['message' => 'غير مصرح لك بتعديل هذا الكورس ❌'], 403);
}
       

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
          $user = Auth::user();
          $course = Course::find($id);
           if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'الدورة غير موجودة ❌'
            ], 404);
        }
    if (!$user->can('delete course')) {
        return response()->json(['message' => 'ليس لديك صلاحية لحذف كورسات  ❌'], 403);
    }
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
    // تحقق أنه عنده الصلاحية 'view students' (اختياري بس يفضل)
    if (!$user->can('view students')) {
        return response()->json(['message' => 'ليس لديك صلاحية عرض الطلاب ❌'], 403);
    }

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
//اضافة طالب الى كورس معين 
public function enroll($course_id)
{
    $user = Auth::user();
    $course = Course::findOrFail($course_id);

    // تأكد أنه المستخدم طالب
    if (!$user->hasRole('student')) {
        return response()->json(['message' => 'فقط الطلاب يمكنهم التسجيل في الكورس ❌'], 403);
    }

    // تأكد أنه مو مسجل مسبقاً
    if ($course->students()->where('student_id', $user->id)->exists()) {
        return response()->json(['message' => 'أنت مسجل بالفعل في هذا الكورس ⚠️'], 400);
    }

    // تسجيل الطالب في الكورس
    $course->students()->attach($user->id);
    // نجيب المدرس
$instructor = $course->instructor;
// نجيب كل الأدمن
$admins = User::role('admin')->get();

// نرسل الإشعار
$instructor->notify(new NewStudentNotification($user, $course));
foreach ($admins as $admin) {
    $admin->notify(new NewStudentNotification($user, $course));
}

    return response()->json(['message' => 'تم التسجيل في الكورس بنجاح ✅']);
}

public function checkout($course_id)
{
    $user = Auth::user();
    $course = Course::findOrFail($course_id);

    if ($course->students()->where('student_id', $user->id)->exists()) {
        return response()->json(['message' => 'أنت مسجل مسبقاً ⚠️'], 400);
    }

    Stripe::setApiKey(config('services.stripe.secret'));

  $session = Session::create([
    'payment_method_types' => ['card'],
    'mode' => 'payment',
    'line_items' => [[
        'price_data' => [
            'currency' => 'usd',
            'product_data' => [
                'name' => $course->title,
            ],
            'unit_amount' => $course->price * 100,
        ],
        'quantity' => 1,
    ]],
    'metadata' => [
        'course_id' => $course->id,
        'user_id' => $user->id,
    ],
    'success_url' => 'http://localhost:8000/dummy',
    'cancel_url' => 'http://localhost:8000/cancel',
]);

    return response()->json([
        'url' => $session->url
    ]);
}

}

