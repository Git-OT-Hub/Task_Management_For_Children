<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function read(DatabaseNotification $notification)
    {
        if ($notification->notifiable_id !== Auth::user()->id) {
            $message = ["message" => "権限がありません。"];

            return response()->json($message, 400);
        }
        $notification->markAsRead();
        $count = Auth::user()->unreadNotifications->count();

        return response()->json(["notification" => $notification, "count" => $count]);
    }
}
