<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 📋 عرض المستخدمين
    public function index()
{
    $authUser = Auth::user();

    if ($authUser->hasRole('admin')) {

        $users = User::with(['enrolledCourses', 'exams'])->get();

    } else {

        $studentsIds = $authUser->courses()
            ->with('students')
            ->get()
            ->pluck('students.*.id')
            ->flatten()
            ->unique();

        $users = User::whereIn('id', $studentsIds)
            ->with(['enrolledCourses', 'exams'])
            ->get();
    }

    return view('admin.users.index', compact('users'));
}

public function userExams(User $user)
{
    $attempts = $user->attempt()
        ->with('exam')
        ->latest()
        ->get();

    return view('admin.users.exams', compact('user', 'attempts'));
}

public function showAttempt(ExamAttempt $attempt)
{
    $attempt->load([
        'exam',
        'answers.question'
    ]);

    return view('admin.users.attempt', compact('attempt'));
}

    // ➕ صفحة إنشاء مستخدم
    public function create()
    {
        return view('admin.users.create');
    }

    // 💾 حفظ مستخدم جديد
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role); // مهم جداً

        return redirect('/admin/users');
    }

    // ✏️ صفحة تعديل
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // 🔄 تحديث
    public function update(Request $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        $user->syncRoles([$request->role]);

        return redirect('/admin/users');
    }

    // 🗑️ حذف
    public function destroy(User $user)
    {
        $user->delete();

        return back();
    }
}