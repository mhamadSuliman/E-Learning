<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Payment;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $users = User::count();
        $students = User::role('student')->count();
        $instructors = User::role('instructor')->count();
        $admins = User::role('admin')->count();

        $courses = Course::count();

        $payments = Payment::count();
        $totalRevenue = Payment::sum('amount');

        return view('admin.dashboard', compact(
            'users',
            'students',
            'instructors',
            'admins',
            'courses',
            'payments',
            'totalRevenue'
        ));
    }
}