<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->orderBy('created_at','desc')->paginate(20);
        return view('notifications.index', compact('notifications'));
    }

    public function read(Request $request, $id)
    {
        $user = auth()->user();
        $notification = $user->notifications()->where('id', $id)->firstOrFail();
        $notification->markAsRead();
        return back();
    }

    public function readAll()
    {
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();
        return back();
    }
}
