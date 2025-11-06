<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingChat;
use App\Models\Booking;
use App\Models\User;
use App\Models\Professional;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookingChatController extends Controller
{
    /**
     * Open chat window for a booking
     */
    public function openChat($bookingId)
    {
        // Determine if user is customer or professional
        $isCustomer = Auth::guard('user')->check();
        $isProfessional = Auth::guard('professional')->check();

        if (!$isCustomer && !$isProfessional) {
            abort(403, 'Unauthorized access');
        }

        // Get booking
        $booking = Booking::with(['user', 'professional', 'service', 'subservice'])->findOrFail($bookingId);

        // Authorization check
        if ($isCustomer) {
            $userId = Auth::guard('user')->id();
            if ($booking->user_id != $userId) {
                abort(403, 'You cannot access this chat');
            }
            $userType = 'customer';
            $currentUserId = $userId;
        } else {
            $professionalId = Auth::guard('professional')->id();
            if ($booking->professional_id != $professionalId) {
                abort(403, 'You cannot access this chat');
            }
            $userType = 'professional';
            $currentUserId = $professionalId;
        }

        // Check if this is first time opening chat (no messages yet)
        $messageCount = BookingChat::where('booking_id', $bookingId)->count();
        
        if ($messageCount == 0) {
            // Create system welcome message
            $professionalName = $booking->professional ? $booking->professional->name : 'Professional';
            $customerName = $booking->user ? $booking->user->name : 'Customer';
            $serviceName = $booking->service_name ?? ($booking->service->name ?? 'Service');
            
            $welcomeMessage = "Hi! You are chatting regarding Booking #{$bookingId} for {$serviceName} between {$customerName} and {$professionalName}.";
            
            BookingChat::create([
                'booking_id' => $bookingId,
                'sender_id' => 0,
                'sender_type' => 'system',
                'message' => $welcomeMessage,
                'is_system_message' => true,
                'is_read' => true
            ]);
        }

        // Get all messages
        $messages = BookingChat::forBooking($bookingId)->get();

        // Mark messages as read (only messages sent by the other party)
        if ($isCustomer) {
            BookingChat::where('booking_id', $bookingId)
                ->where('sender_type', 'professional')
                ->where('is_read', false)
                ->update(['is_read' => true]);
        } else {
            BookingChat::where('booking_id', $bookingId)
                ->where('sender_type', 'customer')
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return view('shared.booking-chat', compact('booking', 'messages', 'userType', 'currentUserId'));
    }

    /**
     * Send a message
     */
    public function sendMessage(Request $request, $bookingId)
    {
        $request->validate([
            'message' => 'required_without:attachment|string|max:5000',
            'attachment' => 'nullable|file|max:10240' // 10MB max
        ]);

        // Determine sender
        $isCustomer = Auth::guard('user')->check();
        $isProfessional = Auth::guard('professional')->check();

        if (!$isCustomer && !$isProfessional) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Verify booking access
        $booking = Booking::findOrFail($bookingId);
        
        if ($isCustomer) {
            $userId = Auth::guard('user')->id();
            if ($booking->user_id != $userId) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            $senderType = 'customer';
            $senderId = $userId;
        } else {
            $professionalId = Auth::guard('professional')->id();
            if ($booking->professional_id != $professionalId) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            $senderType = 'professional';
            $senderId = $professionalId;
        }

        // Handle file upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentPath = $file->store('chat-attachments', 'public');
        }

        // Create message
        $chat = BookingChat::create([
            'booking_id' => $bookingId,
            'sender_id' => $senderId,
            'sender_type' => $senderType,
            'message' => $request->message,
            'attachment' => $attachmentPath,
            'is_read' => false
        ]);

        // Get sender name
        if ($senderType === 'customer') {
            $sender = User::find($senderId);
        } else {
            $sender = Professional::find($senderId);
        }

        return response()->json([
            'success' => true,
            'message' => $chat,
            'sender_name' => $sender ? $sender->name : 'Unknown',
            'formatted_time' => $chat->created_at->format('h:i A')
        ]);
    }

    /**
     * Get messages for a booking (for polling/AJAX)
     */
    public function getMessages($bookingId)
    {
        // Authorization check
        $isCustomer = Auth::guard('user')->check();
        $isProfessional = Auth::guard('professional')->check();

        if (!$isCustomer && !$isProfessional) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $booking = Booking::findOrFail($bookingId);

        if ($isCustomer) {
            $userId = Auth::guard('user')->id();
            if ($booking->user_id != $userId) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            $currentUserType = 'customer';
        } else {
            $professionalId = Auth::guard('professional')->id();
            if ($booking->professional_id != $professionalId) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            $currentUserType = 'professional';
        }

        $messages = BookingChat::forBooking($bookingId)->get()->map(function($message) use ($booking) {
            if ($message->is_system_message) {
                $senderName = 'System';
            } elseif ($message->sender_type === 'customer') {
                $senderName = $booking->user ? $booking->user->name : 'Customer';
            } else {
                $senderName = $booking->professional ? $booking->professional->name : 'Professional';
            }

            return [
                'id' => $message->id,
                'message' => $message->message,
                'attachment' => $message->attachment,
                'sender_type' => $message->sender_type,
                'sender_name' => $senderName,
                'is_read' => $message->is_read,
                'is_system_message' => $message->is_system_message,
                'created_at' => $message->created_at->format('Y-m-d H:i:s'),
                'formatted_time' => $message->created_at->format('h:i A'),
                'formatted_date' => $message->created_at->format('M d, Y')
            ];
        });

        // Mark unread messages as read
        if ($currentUserType === 'customer') {
            BookingChat::where('booking_id', $bookingId)
                ->where('sender_type', 'professional')
                ->where('is_read', false)
                ->update(['is_read' => true]);
        } else {
            BookingChat::where('booking_id', $bookingId)
                ->where('sender_type', 'customer')
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

    /**
     * Get unread message count
     */
    public function getUnreadCount($bookingId)
    {
        $isCustomer = Auth::guard('user')->check();
        $isProfessional = Auth::guard('professional')->check();

        if (!$isCustomer && !$isProfessional) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $booking = Booking::findOrFail($bookingId);

        if ($isCustomer) {
            $userId = Auth::guard('user')->id();
            if ($booking->user_id != $userId) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            // Count unread messages from professional
            $unreadCount = BookingChat::where('booking_id', $bookingId)
                ->where('sender_type', 'professional')
                ->where('is_read', false)
                ->count();
        } else {
            $professionalId = Auth::guard('professional')->id();
            if ($booking->professional_id != $professionalId) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            // Count unread messages from customer
            $unreadCount = BookingChat::where('booking_id', $bookingId)
                ->where('sender_type', 'customer')
                ->where('is_read', false)
                ->count();
        }

        return response()->json([
            'success' => true,
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * Get total unread message count across all bookings
     */
    public function getTotalUnreadCount()
    {
        $isCustomer = Auth::guard('user')->check();
        $isProfessional = Auth::guard('professional')->check();

        if (!$isCustomer && !$isProfessional) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($isCustomer) {
            $userId = Auth::guard('user')->id();
            
            // Get all bookings for this customer
            $bookingIds = Booking::where('user_id', $userId)->pluck('id');
            
            // Count unread messages from professionals across all bookings
            $totalUnread = BookingChat::whereIn('booking_id', $bookingIds)
                ->where('sender_type', 'professional')
                ->where('is_read', false)
                ->count();
        } else {
            $professionalId = Auth::guard('professional')->id();
            
            // Get all bookings for this professional
            $bookingIds = Booking::where('professional_id', $professionalId)->pluck('id');
            
            // Count unread messages from customers across all bookings
            $totalUnread = BookingChat::whereIn('booking_id', $bookingIds)
                ->where('sender_type', 'customer')
                ->where('is_read', false)
                ->count();
        }

        return response()->json([
            'success' => true,
            'total_unread' => $totalUnread
        ]);
    }
}
