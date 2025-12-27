<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $unread = $user->unreadNotifications()->get();
        $read = $user->notifications()->whereNotNull('read_at')->orderBy('created_at', 'desc')->get();
        return view('notifications.index', compact('unread', 'read'));
    }

    public function markAsRead(Request $request, $id)
    {
        $user = $request->user();
        $notification = $user->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
            return back()->with('success', 'Notifikasi ditandai dibaca.');
        }
        return back()->with('error', 'Notifikasi tidak ditemukan.');
    }
}
