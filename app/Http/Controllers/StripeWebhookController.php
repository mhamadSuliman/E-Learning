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

    $event = Webhook::constructEvent(
        $payload,
        $request->header('Stripe-Signature'),
        env('STRIPE_WEBHOOK_SECRET')
    );

    if ($event->type === 'checkout.session.completed') {

        $session = $event->data->object;

        $user = User::find(
            $session->metadata->user_id
        );

        $course = Course::find(
            $session->metadata->course_id
        );

        if ($user && $course) {

            // تسجيل الطالب (مرة واحدة فقط)
            $course->students()
                ->syncWithoutDetaching([
                    $user->id
                ]);

            // حفظ الدفع (مرة واحدة فقط)
            if (
                !Payment::where(
                    'payment_id',
                    $session->payment_intent
                )->exists()
            ) {

                Payment::create([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'amount' => $course->price,
                    'status' => 'paid',
                    'payment_id' => $session->payment_intent
                ]);
            }
        }
    }

    return response()->json([
        'success' => true
    ]);
}
}