<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function checkout($course_id)
    {
        $user = Auth::user();
        $course = Course::findOrFail($course_id);

        // منع التسجيل إذا هو أصلاً مشترك
        if ($course->students()->where('student_id', $user->id)->exists()) {
            return response()->json(['message' => 'أنت مسجل مسبقاً ⚠️'], 400);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

       $session = Session::create([
    'payment_method_types' => ['card'],
    'mode' => 'payment',
    'success_url' => 'http://localhost:8000/success', // شكلي فقط
    'cancel_url' => 'http://localhost:8000/cancel',
    'metadata' => [
        'course_id' => $course->id,
        'user_id' => $user->id,
    ],
]);

        return response()->json([
            'url' => $session->url
        ]);
    }

    public function success()
{
    return response()->json([
        'message'=>'تم الدفع بنجاح، سيتم تفعيل الكورس خلال لحظات'
    ]);
}
}
