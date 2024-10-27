<?php

// app/Http/Controllers/NotificationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display the notifications page.
     */
    public function index()
    {
        $user = Auth::user();

        // Fetch notifications, latest first
        $notifications = $user->notifications()->latest()->get();

        return view('notifications.index', compact('notifications'));
    }

  /**
     * Mark a notification as read.
     */
    public function markAsRead(Request $request, $id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            Log::info('Notification marked as read', ['user_id' => $user->id, 'notification_id' => $id]);
            return response()->json(['success' => true]);
        } else {
            Log::warning('Notification not found or does not belong to user', ['user_id' => $user->id, 'notification_id' => $id]);
            return response()->json(['success' => false, 'message' => 'Notification not found.'], 404);
        }
    }
}