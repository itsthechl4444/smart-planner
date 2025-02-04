<?php

// app/Http/Controllers/NotificationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * Display the notifications page.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->get('filter', 'all'); // 'all', 'read', 'unread'

        if ($filter === 'read') {
            $notifications = $user->notifications()->whereNotNull('read_at')->latest()->get();
        } elseif ($filter === 'unread') {
            $notifications = $user->notifications()->whereNull('read_at')->latest()->get();
        } else {
            $notifications = $user->notifications()->latest()->get();
        }

        return view('notifications.index', compact('notifications', 'filter'));
    }


   /**
     * Display the specified notification details.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $notification = Auth::user()->notifications()->find($id);

        if (!$notification) {
            return response()->json(['success' => false, 'message' => 'Notification not found.'], 404);
        }

        // Customize the notification data as needed
        $data = [
            'message' => $notification->data['message'] ?? 'You have a new notification.',
            'project_name' => $notification->data['project_name'] ?? null,
            'inviter_name' => $notification->data['inviter_name'] ?? null,
            'removed_by_name' => $notification->data['removed_by_name'] ?? null,
            'collaborator_name' => $notification->data['collaborator_name'] ?? null,
            'response' => $notification->data['response'] ?? null,
            // Add other fields as necessary
        ];

        return response()->json([
            'success' => true,
            'notification' => $data,
            'type' => class_basename($notification->type),
        ]);
    }

     /**
     * Mark all unread notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        try {
            auth()->user()->unreadNotifications->markAsRead();
            return response()->json(['success' => true, 'message' => 'All notifications marked as read.']);
        } catch (\Exception $e) {
            Log::error('Error marking all notifications as read: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to mark all as read.'], 500);
        }
    }

    /**
     * Delete a specific notification.
     */
    public function delete($id)
    {
        try {
            $notification = auth()->user()->notifications()->findOrFail($id);
            $notification->delete();
            return response()->json(['success' => true, 'message' => 'Notification deleted successfully.']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Notification not found: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Notification not found.'], 404);
        } catch (\Exception $e) {
            Log::error('Error deleting notification: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the notification.'], 500);
        }
    }

    /**
     * Mark a specific notification as read.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead($id)
    {
        try {
            $notification = auth()->user()->notifications()->findOrFail($id);
            
            if (is_null($notification->read_at)) {
                $notification->markAsRead();
            }

            return response()->json(['success' => true, 'message' => 'Notification marked as read.']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Notification not found: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Notification not found.'], 404);
        } catch (\Exception $e) {
            Log::error('Error marking notification as read: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while marking the notification as read.'], 500);
        }
    }
}
