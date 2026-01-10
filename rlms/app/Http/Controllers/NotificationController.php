<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Get filter from request
        $filter = $request->get('filter');

        // Build query
        $query = $user->notifications();

        // Apply filters
        if ($filter === 'unread') {
            $query->whereNull('read_at');
        }

        // Get notifications with pagination
        $notifications = $query->paginate(20);

        // Get unread count
        $unreadCount = $user->unreadNotifications()->count();

        return view('notifications.index', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()
            ->notifications()
            ->findOrFail($id);

        $notification->markAsRead();

        return redirect()->back()->with('success', __('Notification marked as read.'));
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', __('All notifications marked as read.'));
    }

    /**
     * Delete a notification.
     */
    public function destroy(Request $request, $id)
    {
        $notification = $request->user()
            ->notifications()
            ->findOrFail($id);

        $notification->delete();

        return redirect()->back()->with('success', __('Notification deleted.'));
    }
}
