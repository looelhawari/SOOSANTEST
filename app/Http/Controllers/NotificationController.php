<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(15);
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return redirect()->back();
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', __('admin.all_notifications_marked_read'));
    }

    /**
     * Return notifications as JSON for AJAX polling
     */
    public function fetch()
    {
        $notifications = auth()->user()->unreadNotifications()->latest()->take(10)->get();
        return response()->json([
            'notifications' => $notifications
        ]);
    }
}
