<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Display a listing of all notifications for the admin.
     */
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        if (!$admin) {
            return redirect()->route('admin.login');
        }

        // Clean up old notifications (older than 30 days)
        DB::table('notifications')
            ->where('notifiable_type', 'App\Models\Admin')
            ->where('notifiable_id', $admin->id)
            ->where('created_at', '<', now()->subDays(30))
            ->delete();

        // Use Laravel's notification methods (same as header) for consistency
        $notificationsQuery = $admin->notifications()->latest();

        // Filter by type if requested
        if ($request->filled('type')) {
            $notificationsQuery->where('type', $request->type);
        }

        // Filter by read status
        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $notificationsQuery->whereNull('read_at');
            } elseif ($request->status === 'read') {
                $notificationsQuery->whereNotNull('read_at');
            }
        }

        $notifications = $notificationsQuery->paginate(20);
        
        // Get notification statistics using Laravel's notification methods
        $stats = [
            'total' => $admin->notifications()->count(),
            'unread' => $admin->unreadNotifications()->count(),
            'read' => $admin->notifications()->whereNotNull('read_at')->count(),
        ];

        // Get available notification types for filter
        $notificationTypes = [
            'App\Notifications\AppointmentRescheduled' => 'Appointment Rescheduled',
            'App\Notifications\NewChatMessage' => 'Chat Messages',
            'App\Notifications\NewProfessionalEvent' => 'New Professional Events',
            'App\Notifications\EventBookingNotification' => 'Event Bookings',
            'App\Notifications\AdditionalServiceNotification' => 'Additional Services',
        ];

        return view('admin.notifications.index', compact('notifications', 'stats', 'notificationTypes'));
    }

    /**
     * Mark a specific notification as read
     */
    public function markAsRead($id)
    {
        $admin = Auth::guard('admin')->user();

        $notification = $admin->notifications()->where('id', $id)->first();
        
        if ($notification && !$notification->read_at) {
            $notification->markAsRead();
            return response()->json(['success' => true, 'message' => 'Notification marked as read']);
        }

        return response()->json(['success' => false, 'message' => 'Notification not found or already read']);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        $admin = Auth::guard('admin')->user();

        $unreadNotifications = $admin->unreadNotifications;
        $count = $unreadNotifications->count();
        
        $admin->unreadNotifications->markAsRead();

        return response()->json([
            'success' => true,
            'message' => "Marked {$count} notifications as read"
        ]);
    }

    /**
     * Delete old notifications
     */
    public function deleteOld()
    {
        $admin = Auth::guard('admin')->user();

        $deleted = $admin->notifications()
            ->where('created_at', '<', now()->subDays(30))
            ->delete();

        return response()->json([
            'success' => true,
            'message' => "Deleted {$deleted} old notifications"
        ]);
    }

    /**
     * Delete a specific notification
     */
    public function destroy($id)
    {
        $admin = Auth::guard('admin')->user();

        $deleted = DB::table('notifications')
            ->where('id', $id)
            ->where('notifiable_type', 'App\Models\Admin')
            ->where('notifiable_id', $admin->id)
            ->delete();

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Notification deleted successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Notification not found']);
    }
}