<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function markAsRead($id) {
        $notification = DatabaseNotification::findOrFail($id);

        if ($notification->notifiable_id === auth()->id()) {
            $notification->markAsRead();
        }

        return back()->with('message', 'Notification marked as read.');
    }
}
