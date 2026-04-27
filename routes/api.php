<?php

use App\Http\Controllers\Api\CourseCategoryController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\ExamAttemptController;
use App\Http\Controllers\Api\ExamController;
use App\Http\Controllers\Api\ExamQuestionController;
use App\Http\Controllers\Api\ExerciseAnswerController;
use App\Http\Controllers\Api\ExerciseController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\TestPaymentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WebhookController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;

// Middleware auth:sanctum لجميع الـ routes المحمية
Route::middleware('auth:sanctum','throttle:60,1')->group(function () {

    // المستخدمين
    Route::apiResource('users', UserController::class)
        ->middleware('check.role:admin,instructor'); // الأدمن أو المدرس يقدروا يشوفوا/يتعاملوا مع المستخدمين
    Route::post('users/search', [UserController::class, 'search'])
        ->middleware('check.role:admin'); // البحث للأدمن فقط

    // الكورسات
    Route::apiResource('courses', CourseController::class)
        ->middleware('check.role:admin,instructor'); // الأدمن أو المدرس فقط

    // الدروس (nested route) 
    Route::apiResource('courses.lessons', LessonController::class)
        ->middleware([
            'check.role:admin,instructor',        // الأدمن أو المدرس
            'check.course.ownership'              // للتحقق من ملكية الكورس إذا كان مدرس
        ]);

    // الطلاب المرتبطين بالأستاذ
    Route::get('/mystudents', [CourseController::class, 'myStudents'])
        ->middleware('check.role:admin,instructor');

    // تصنيفات الكورسات مفتوحة للجميع (يمكن تحط auth بعدين إذا بدك)
    Route::apiResource('categories', CourseCategoryController::class);

    // route لجلب المستخدم الحالي
});

// تسجيل الدخول مفتوح
Route::post('/login', [UserController::class, 'login'])->middleware('throttle:10,1');


Route::middleware('auth:sanctum')->get('/notifications', [UserController::class, 'myNotifications']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
});

Route::post('/courses/{course_id}/enroll', [CourseController::class, 'enroll'])
    ->middleware('auth:sanctum');


// لازم يكون المستخدم عامل تسجيل دخول (middleware auth:sanctum)
Route::middleware(['auth:sanctum', 'check.course.permission:edit'])->group(function () {
    Route::post('/courses/{course_id}/exercises', [ExerciseController::class, 'store']);
    Route::put('/courses/{course_id}/exercises/{exercise_id}', [ExerciseController::class, 'update']);
    Route::delete('/courses/{course_id}/exercises/{exercise_id}', [ExerciseController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'check.course.permission:access'])->group(function () {
    Route::get('/courses/{course_id}/exercises', [ExerciseController::class, 'index']);
    Route::get('/courses/{course_id}/exercises/{exercise_id}', [ExerciseController::class, 'show']);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/exercises/{exercise_id}/answer', [ExerciseAnswerController::class, 'store']);
});

// 🔒 مبدئياً نضيفهم داخل مجموعة middleware فيها التحقق من المستخدم
Route::middleware(['auth:sanctum'])->group(function () {

    // 🎓 الامتحانات التابعة لكورس معيّن
    Route::prefix('courses/{course_id}')->group(function () {

        // --- الامتحانات ---
        Route::get('/exams', [ExamController::class, 'index'])->middleware('check.course.permission:access');         // عرض كل الامتحانات ضمن كورس
        Route::post('/exams', [ExamController::class, 'store'])->middleware('check.course.permission:edit');        // إنشاء امتحان جديد
        Route::get('/exams/{exam_id}', [ExamController::class, 'show'])->middleware('check.course.permission:access'); // عرض امتحان بالتفصيل
        Route::delete('/exams/{exam_id}', [ExamController::class, 'destroy'])->middleware('check.course.permission:edit'); // حذف امتحان

        // --- الأسئلة ضمن الامتحان ---
        Route::get('/exams/{exam_id}/questions', [ExamQuestionController::class, 'index'])->middleware('check.course.permission:access');   // عرض الأسئلة
        Route::post('/exams/{exam_id}/questions', [ExamQuestionController::class, 'store'])->middleware('check.course.permission:edit');  // إضافة سؤال
        Route::get('/exams/{exam_id}/questions/{question_id}', [ExamQuestionController::class, 'show'])->middleware('check.course.permission:access'); // عرض سؤال محدد
        Route::delete('/exams/{exam_id}/questions/{question_id}', [ExamQuestionController::class, 'destroy'])->middleware('check.course.permission:edit'); // حذف سؤال


        
    });

});
// 🎓 راوتات إدارة المحاولات الخاصة بالامتحانات
Route::middleware(['auth:sanctum'])->group(function () {

    // بدء محاولة جديدة لامتحان معيّن
    Route::post('/exams/{exam_id}/attempts/start', [ExamAttemptController::class, 'startAttempt']);

    // إرسال إجابة لسؤال ضمن المحاولة
    Route::post('/attempts/{attempt_id}/answer', [ExamAttemptController::class, 'submitAnswer']);

    // تسليم الامتحان (إنهاء المحاولة)
    Route::post('/attempts/{attempt_id}/submit', [ExamAttemptController::class, 'submitAttempt']);

    // عرض نتيجة محاولة معيّنة
    Route::get('/attempts/{exam_id}/result', [ExamAttemptController::class, 'getResult']);
});

// Route::middleware('auth:sanctum')->group(function () {
    // Route::post('/courses/{course_id}/checkout', [PaymentController::class, 'checkout']);
    Route::get('/payment/success', [PaymentController::class, 'success']);
    Route::get('/payment/cancel', [PaymentController::class, 'cancel']);
// });


Route::post('/stripe/webhook', [WebhookController::class, 'handle']);

 Route::middleware('auth:sanctum')->post('/courses/{course}/checkout', [CourseController::class, 'checkout']);

Route::middleware('auth:sanctum')->post('/test-payment/{course}', [TestPaymentController::class, 'checkout']);
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);

//انشات التمرين ضل عليك تنشا جدول للاجابة لكل طالب مشان يتخزن فيه اجابتو ويتاكد اذا صح او لا
