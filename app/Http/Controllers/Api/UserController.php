<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SearchUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
{
    $authUser = Auth::user();

    // 1️⃣ الأدمن: عرض كل المستخدمين
    if ($authUser->hasRole('admin')) {
        $users = User::all(); // كل الطلاب والأساتذة
        return response()->json([
            'message' => 'كل المستخدمين',
            'users' => $users
        ], 200);
    }

    // 2️⃣ المدرس: عرض الطلاب المرتبطين بكورساته فقط
    elseif ($authUser->hasRole('instructor')) {
        $studentsIds = $authUser->courses()->with('students')->get()
            ->pluck('students.*.id')
            ->flatten()
            ->unique()
            ->toArray();

        $students = User::whereIn('id', $studentsIds)->get();

        return response()->json([
            'message' => 'طلابك المرتبطين بالكورسات',
            'students' => $students
        ], 200);
    }

    // 3️⃣ الطالب: عرض كل المدرسين
    elseif ($authUser->hasRole('student')) {
        $instructors = User::role('instructor')->get(); // Spatie method
        return response()->json([
            'message' => 'كل المدرسين',
            'instructors' => $instructors
        ], 200);
    }

    // 4️⃣ أي مستخدم آخر (في حال وجود دور جديد)
    else {
        return response()->json([
            'message' => 'غير مصرح لك برؤية المستخدمين ❌'
        ], 403);
    }
}



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
{
    $authUser = Auth::user();
    // لو الأستاذ حاول يضيف غير طالب
    if ($authUser->hasRole('instructor') && $request->role !== 'student') {
        return response()->json(['message' => 'الأستاذ يستطيع إضافة طلاب فقط 🎓'], 403);
    }

    $newuser = new User();
    $newuser->name = $request->name;
    $newuser->email = $request->email;
    $newuser->password = Hash::make($request->password);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('users', 'public');
        $newuser->image = $imagePath;
    }

    $newuser->save();

    // تعيين الدور
    $newuser->assignRole($request->role);

    return response()->json([
        'message' => 'تم إنشاء المستخدم بنجاح ✅',
        'user' => $newuser
    ], 201);
}




    public function login(LoginRequest $request)
{
    
    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    // إنشاء توكن جديد
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'token' => $token,
        'user' => $user
    ]);
}
    public function show(){}


    public function search(SearchUserRequest $request)
{
    $authUser = Auth::user();

    // 1️⃣ فقط الأدمن مسموح له
    if (!$authUser->hasRole('admin')) {
        return response()->json(['message' => 'غير مصرح لك بهذا الإجراء ❌'], 403);
    }
    $name = $request->name;

    // 3️⃣ البحث عن المستخدم بالاسم
    $user = User::where('name', 'LIKE', "%{$name}%")
        ->with([
            'courses',          // الكورسات التي ينشئها المستخدم (إن كان مدرس)
            'enrolledCourses',  // الكورسات المسجل بها (إن كان طالب)
            'instructorProfile' // الملف الشخصي للأستاذ
        ])
        ->first();

    if (!$user) {
        return response()->json(['message' => 'المستخدم غير موجود ❌'], 404);
    }

    return response()->json([
        'message' => 'تم العثور على المستخدم ✅',
        'user' => $user
    ], 200);
}


    /**
     * Update the specified resource in storage.
     */
   public function update(UpdateUserRequest $request, User $user)
{
    /** @var \App\Models\User $authUser */
    $authUser = Auth::user();

    // 2️⃣ لو المدرس، يتحقق أنه يعدل طالب من طلابه فقط
    if ($authUser->hasRole('instructor')) {
        // جمع كل الطلاب المرتبطين بالكورسات التي ينشئها المدرس
        $studentsIds = $authUser->courses()->with('students')->get()
            ->pluck('students.*.id') // يجمع جميع الطلاب
            ->flatten()
            ->unique()
            ->toArray();

        if (!in_array($user->id, $studentsIds)) {
            return response()->json(['message' => 'المدرس يستطيع تعديل طلابه فقط 🎓'], 403);
        }
    }

    // 4️⃣ تحديث البيانات
    if ($request->has('name')) $user->name = $request->name;
    if ($request->has('email')) $user->email = $request->email;
    if ($request->has('password')) $user->password = Hash::make($request->password);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('users', 'public');
        $user->image = $imagePath;
    }

    $user->save();

    return response()->json([
        'message' => 'تم تعديل المستخدم بنجاح ✅',
        'user' => $user
    ], 200);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
{
    $authUser = Auth::user();

    // 2️⃣ لو المدرس، يتحقق أنه يحذف طالب مرتبط بكورساته
    if ($authUser->hasRole('instructor')) {
        // جمع كل الطلاب المرتبطين بالكورسات التي ينشئها المدرس
        $studentsIds = $authUser->courses()->with('students')->get()
            ->pluck('students.*.id')
            ->flatten()
            ->unique()
            ->toArray();

        if (!in_array($user->id, $studentsIds)) {
            return response()->json(['message' => 'المدرس يستطيع حذف طلابه فقط 🎓'], 403);
        }
    }
    if ($authUser->id === $user->id) {
    return response()->json(['message' => 'لا يمكنك حذف حسابك الشخصي ❌'], 403);
}
    // 4️⃣ الحذف
    $user->delete();

    return response()->json([
        'message' => 'تم حذف المستخدم بنجاح ✅'
    ], 200);
}
public function myNotifications()
{
    $user = Auth::user();

    // جلب كل الإشعارات بترتيب الأحدث أولاً
    $notifications = $user->notifications()->latest()->get(); 
    $unreadCount = $user->unreadNotifications()->count();

    return response()->json([
        'notifications' => $notifications,
        'unread_count' => $unreadCount,
    ]);
}




}
