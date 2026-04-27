<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;

class InstructorDashboardController extends Controller
{
    public function index()
{
    $user = auth()->user();

    $courses = Course::where('instructor_id', $user->id)->get();

    $coursesCount = $courses->count();

    $studentsCount = $courses->sum('students_number');

    $revenue = $courses->sum('price');

    $latestCourses = Course::where('instructor_id', $user->id)
        ->latest()
        ->take(5)
        ->get();

    // Chart data
    $chartLabels = $courses->pluck('title');
    $chartData = $courses->pluck('students_number');

    return view('instructor.dashboard', compact(
        'coursesCount',
        'studentsCount',
        'revenue',
        'latestCourses',
        'chartLabels',
        'chartData'
    ));
}
}