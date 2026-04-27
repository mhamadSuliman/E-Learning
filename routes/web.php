<?php

use App\Http\Controllers\Admin\AdminDashboardController;

use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\ExamQuestionController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Instructor\CourseController as InstructorCourseController;
use App\Http\Controllers\Instructor\InstructorDashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\StudentDashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;





//admin
Route::middleware(['auth', 'role:admin|instructor'])->group(function () {

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index']);

    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit']);
    Route::put('/admin/users/{user}', [UserController::class, 'update']);
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy']);

    Route::get('/admin/courses', [CourseController::class, 'index']);
    
    Route::get('/admin/courses/create', [CourseController::class, 'create']);
    Route::post('/admin/courses', [CourseController::class, 'store']);
    Route::get('/admin/courses/{course}/edit', [CourseController::class, 'edit']);
    Route::put('/admin/courses/{course}', [CourseController::class, 'update']);
    Route::delete('/admin/courses/{course}', [CourseController::class, 'destroy']);

    Route::get('/admin/payments', [PaymentController::class, 'index']);
});

Route::middleware(['auth', 'role:admin|instructor'])->group(function () {

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/exams', [UserController::class, 'userExams']);
Route::get('/attempts/{attempt}', [UserController::class, 'showAttempt']);
    Route::get('/admin/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create']);
    Route::post('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'store']);

    Route::get('/admin/users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit']);
    Route::put('/admin/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update']);

    Route::delete('/admin/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy']);
});

Route::middleware(['auth', 'role:admin|instructor'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);

    Route::get('/admin/courses/{course}/exams', [ExamController::class, 'index'])
    ->name('admin.exams.index');
    Route::get('/admin/courses/{course}/exams/create', [ExamController::class, 'create']);
    Route::post('/admin/courses/{course}/exams', [ExamController::class, 'store']);
    Route::get('/admin/courses/{course}/exams/{exam}/edit', [ExamController::class, 'edit'])
    ->name('admin.exams.edit');
    Route::put('/admin/courses/{course}/exams/{exam}', [ExamController::class, 'update'])
    ->name('admin.exams.update');

    Route::get('/admin/courses/{course}/exams/{exam}', [ExamController::class, 'show']);
    Route::delete('/admin/courses/{course}/exams/{exam}', [ExamController::class, 'destroy']);
   
    Route::get('/admin/exams/{exam}/questions', [ExamQuestionController::class, 'index']);
Route::post('/admin/exams/{exam}/questions', [ExamQuestionController::class, 'store']);
Route::delete('/admin/exams/{exam}/questions/{question}', [ExamQuestionController::class, 'destroy']);
});



//instractur
Route::middleware(['auth', 'role:instructor'])->group(function () {

    Route::get('/instructor/dashboard', [InstructorDashboardController::class, 'index']);

    Route::get('/instructor/courses', [InstructorCourseController::class, 'index']);
    Route::get('/instructor/courses/create', [InstructorCourseController::class, 'create']);
    Route::post('/instructor/courses', [InstructorCourseController::class, 'store']);
});

//student
Route::middleware(['auth', 'role:student'])->group(function () {

    Route::get('/student/dashboard', [StudentDashboardController::class, 'index']);
});




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
