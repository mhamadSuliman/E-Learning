<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Course;

class TestPaymentController extends Controller
{
    public function checkout($courseId, Request $request)
    {
        $course = Course::findOrFail($courseId);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $course->title,
                    ],
                    'unit_amount' => $course->price * 100,
                ],
                'quantity' => 1,
            ]],
            'metadata' => [
                'course_id' => $course->id,
                'user_id' => $request->user()->id,
            ],
            'success_url' => 'http://localhost:8000/success',
            'cancel_url' => 'http://localhost:8000/cancel',
        ]);

        return response()->json([
            'url' => $session->url
        ]);
    }
}