<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return view('instructor.courses.index', [
            'courses' => auth()->user()->courses
        ]);
    }

    public function create()
    {
        return view('instructor.courses.create');
    }

    public function store(Request $request)
    {
        auth()->user()->courses()->create($request->all());

        return redirect()->route('instructor.courses.index');
    }
}