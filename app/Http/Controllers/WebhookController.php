<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $secret);
        } catch (\Exception $e) {
            return response('Invalid payload', 400);
        }

        // 🎯 أهم جزء
        if ($event->type === 'checkout.session.completed') {

            $session = $event->data->object;

            $courseId = $session->metadata->course_id;
            $userId = $session->metadata->user_id;

            $course = Course::find($courseId);
            $user = User::find($userId);

            if ($course && $user) {

                // تسجيل الطالب
                $course->students()->syncWithoutDetaching([$user->id]);

                // حفظ الدفع
                Payment::create([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'amount' => $course->price,
                    'status' => 'paid',
                    'payment_id' => $session->id,
                ]);

                // إشعار
                $user->notify(new \App\Notifications\PaymentSuccessNotification($course));
            }
        }

        return response('Success', 200);
    }
}