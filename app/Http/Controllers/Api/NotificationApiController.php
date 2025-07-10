<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationApiController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->take(10)->get();
        $unreadCount = Auth::user()->unreadNotifications()->count();

        return response()->json([
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    public function check()
    {
        $unreadCount = Auth::user()->unreadNotifications()->count();
        $latestNotification = Auth::user()->unreadNotifications()->latest()->first();

        // Check if there are new notifications since last check
        $lastCheckTime = session('last_notification_check', now()->subMinutes(1));
        $hasNew = Auth::user()->unreadNotifications()
            ->where('created_at', '>', $lastCheckTime)
            ->exists();

        session(['last_notification_check' => now()]);

        return response()->json([
            'hasNew' => $hasNew,
            'unreadCount' => $unreadCount,
            'latestNotification' => $latestNotification,
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications()->update(['read_at' => now()]);
        
        return response()->json(['success' => true]);
    }
}
