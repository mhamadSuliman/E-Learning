<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Webhook;
use App\Models\Course;
use App\Models\User;
use App\Models\Payment;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $secret);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Webhook error'], 400);
        }

        // 🎯 أهم حدث
        if ($event->type === 'checkout.session.completed') {

            $session = $event->data->object;

            $courseId = $session->metadata->course_id;
            $userId = $session->metadata->user_id;

            $user = User::find($userId);
            $course = Course::find($courseId);

            if ($user && $course) {

                // تسجيل الطالب
                $course->students()->syncWithoutDetaching([$user->id]);

                // حفظ الدفع
                Payment::create([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'amount' => $course->price,
                    'status' => 'paid',
                    'payment_id' => $session->payment_intent,
                ]);
            }
        }

        return response()->json(['status' => 'success']);
    }
}