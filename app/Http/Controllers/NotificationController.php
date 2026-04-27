<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['message' => 'تم تعليم الإشعار كمقروء ✅']);
        }
        return response()->json(['message' => 'الإشعار غير موجود ❌'], 404);
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['message' => 'تم تعليم جميع الإشعارات كمقروءة ✅']);
    }

    public function index()
{
    return view('notifications.index', [
        'notifications' => auth()->user()->notifications()->latest()->get()
    ]);
}
}

