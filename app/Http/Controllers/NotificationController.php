<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get notifications for topbar
     */
    public function getTopbarNotifications()
    {
        $notifications = Notification::where('user_id', auth()->id())
                                   ->orderBy('created_at', 'desc')
                                   ->take(10)
                                   ->get();

        $unreadCount = Notification::where('user_id', auth()->id())
                                 ->unread()
                                 ->count();

        return response()->json([
            'notifications' => $notifications->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'icon' => $notification->icon,
                    'color' => $notification->color,
                    'action_url' => $notification->action_url,
                    'is_read' => $notification->is_read,
                    'time_ago' => $notification->time_ago,
                    'created_at' => $notification->created_at->toISOString()
                ];
            }),
            'unread_count' => $unreadCount,
            'has_notifications' => $notifications->count() > 0
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read'
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
                   ->unread()
                   ->update([
                       'is_read' => true,
                       'read_at' => now()
                   ]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read'
        ]);
    }

    /**
     * Get notification count
     */
    public function getUnreadCount()
    {
        $count = Notification::where('user_id', auth()->id())
                            ->unread()
                            ->count();

        return response()->json([
            'unread_count' => $count
        ]);
    }

    /**
     * Delete notification
     */
    public function destroy(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted'
        ]);
    }

    /**
     * Display full notifications page
     */
    public function index(Request $request)
    {
        $query = Notification::where('user_id', auth()->id());

        // Filter by type
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        // Filter by read status
        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->unread();
            } elseif ($request->status === 'read') {
                $query->read();
            }
        }

        $notifications = $query->orderBy('created_at', 'desc')
                             ->paginate(20);

        // Get notification types for filter
        $types = Notification::where('user_id', auth()->id())
                            ->distinct('type')
                            ->pluck('type')
                            ->filter();

        // Statistics
        $statistics = [
            'total' => Notification::where('user_id', auth()->id())->count(),
            'unread' => Notification::where('user_id', auth()->id())->unread()->count(),
            'read' => Notification::where('user_id', auth()->id())->read()->count(),
            'today' => Notification::where('user_id', auth()->id())
                                 ->whereDate('created_at', today())
                                 ->count()
        ];

        return view('notifications.index', compact('notifications', 'types', 'statistics'));
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:mark_read,delete',
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'exists:notifications,id'
        ]);

        $notifications = Notification::where('user_id', auth()->id())
                                   ->whereIn('id', $request->notification_ids);

        $count = $notifications->count();

        switch ($request->action) {
            case 'mark_read':
                $notifications->update([
                    'is_read' => true,
                    'read_at' => now()
                ]);
                $message = "{$count} notifications marked as read";
                break;

            case 'delete':
                $notifications->delete();
                $message = "{$count} notifications deleted";
                break;
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Real-time notification check (for polling)
     */
    public function checkNew($lastNotificationId = null)
    {
        $query = Notification::where('user_id', auth()->id());

        if ($lastNotificationId) {
            $query->where('id', '>', $lastNotificationId);
        }

        $newNotifications = $query->orderBy('created_at', 'desc')->get();
        $unreadCount = Notification::where('user_id', auth()->id())->unread()->count();

        return response()->json([
            'has_new' => $newNotifications->count() > 0,
            'new_notifications' => $newNotifications->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'icon' => $notification->icon,
                    'color' => $notification->color,
                    'action_url' => $notification->action_url,
                    'time_ago' => $notification->time_ago
                ];
            }),
            'unread_count' => $unreadCount,
            'latest_id' => $newNotifications->first()?->id
        ]);
    }
}