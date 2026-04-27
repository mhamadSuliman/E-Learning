<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        return view('admin.payments.index', [
            'payments' => Payment::with(['user','course'])->latest()->get()
        ]);
    }
}