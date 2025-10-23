<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Booking;
use App\Models\User;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingChatController extends Controller
{
    /**
     * Get or create chat for a specific booking
     */
    public function initializeBookingChat(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id'
        ]);

        $booking = Booking::with(['customer', 'professional'])->findOrFail($request->booking_id);
        
        // Check if user has access to this booking
        if (!$this->canAccessBooking($booking)) {
            return response()->json(['error' => 'Unauthorized access to booking'], 403);
        }

        // Find or create chat for this booking
        // First check if chat exists for this booking
        $chat = Chat::where('booking_id', $booking->id)->first();
        
        if (!$chat) {
            // Check if chat already exists between these participants (for any booking)
            $chat = Chat::where(function($query) use ($booking) {
                $query->where('participant_type_1', 'customer')
                      ->where('participant_id_1', $booking->user_id)
                      ->where('participant_type_2', 'professional')
                      ->where('participant_id_2', $booking->professional_id);
            })->orWhere(function($query) use ($booking) {
                $query->where('participant_type_1', 'professional')
                      ->where('participant_id_1', $booking->professional_id)
                      ->where('participant_type_2', 'customer')
                      ->where('participant_id_2', $booking->user_id);
            })->first();
            
            // If chat exists between these participants, link it to this booking
            if ($chat && !$chat->booking_id) {
                $chat->update(['booking_id' => $booking->id]);
            }
            
            // Create new chat only if no chat exists between these participants
            if (!$chat) {
                try {
                    // Now that columns are VARCHAR, Eloquent create() works perfectly
                    $chat = Chat::create([
                        'booking_id' => $booking->id,
                        'participant_type_1' => 'customer',
                        'participant_id_1' => $booking->user_id,
                        'participant_type_2' => 'professional',
                        'participant_id_2' => $booking->professional_id,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Chat creation failed: ' . $e->getMessage());
                    return response()->json([
                        'error' => 'Failed to create chat',
                        'message' => $e->getMessage()
                    ], 500);
                }
            }
        }

        // Get the other participant's details
        $currentUserType = $this->getCurrentUserType();
        $otherParticipant = $currentUserType === 'customer' 
            ? $booking->professional 
            : $booking->customer;

        return response()->json([
            'success' => true,
            'chat_id' => $chat->id,
            'booking' => [
                'id' => $booking->id,
                'service_name' => $booking->service_name,
                'booking_date' => $booking->booking_date,
                'status' => $booking->status
            ],
            'participant' => [
                'id' => $otherParticipant->id,
                'name' => $otherParticipant->name,
                'type' => $currentUserType === 'customer' ? 'professional' : 'customer'
            ]
        ]);
    }

    /**
     * Get all chats for current user's bookings
     */
    public function getBookingChats()
    {
        $currentUserType = $this->getCurrentUserType();
        $currentUserId = $this->getCurrentUserId();

        if ($currentUserType === 'customer') {
            // Get all bookings for customer
            $bookings = Booking::with(['professional', 'chat.messages', 'service'])
                ->where('user_id', $currentUserId)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Get all bookings for professional
            $bookings = Booking::with(['customer', 'chat.messages', 'service'])
                ->where('professional_id', $currentUserId)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $chatList = [];
        foreach ($bookings as $booking) {
            $otherParticipant = $currentUserType === 'customer' 
                ? $booking->professional 
                : $booking->customer;

            $unreadCount = 0;
            $lastMessage = null;

            if ($booking->chat) {
                $unreadCount = $booking->chat->messages()
                    ->where('sender_type', '!=', $currentUserType)
                    ->where('is_read', false)
                    ->count();

                $lastMessage = $booking->chat->latestMessage;
            }

            $chatList[] = [
                'booking_id' => $booking->id,
                'chat_id' => $booking->chat ? $booking->chat->id : null,
                'booking_date' => $booking->booking_date,
                'service_name' => $booking->service_name ?? ($booking->service->name ?? 'N/A'),
                'status' => $booking->status,
                'participant' => [
                    'id' => $otherParticipant->id ?? null,
                    'name' => $otherParticipant->name ?? 'N/A',
                    'type' => $currentUserType === 'customer' ? 'professional' : 'customer'
                ],
                'unread_count' => $unreadCount,
                'last_message' => $lastMessage ? [
                    'message' => $lastMessage->message,
                    'created_at' => $lastMessage->created_at->diffForHumans()
                ] : null
            ];
        }

        return response()->json([
            'success' => true,
            'chats' => $chatList
        ]);
    }

    /**
     * Get chat messages for a booking
     */
    public function getBookingMessages($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        if (!$this->canAccessBooking($booking)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Find chat for this booking or between these participants
        $chat = Chat::where('booking_id', $booking->id)->first();
        
        if (!$chat) {
            // Check if chat exists between these participants
            $chat = Chat::where(function($query) use ($booking) {
                $query->where('participant_type_1', 'customer')
                      ->where('participant_id_1', $booking->user_id)
                      ->where('participant_type_2', 'professional')
                      ->where('participant_id_2', $booking->professional_id);
            })->orWhere(function($query) use ($booking) {
                $query->where('participant_type_1', 'professional')
                      ->where('participant_id_1', $booking->professional_id)
                      ->where('participant_type_2', 'customer')
                      ->where('participant_id_2', $booking->user_id);
            })->first();
        }

        if (!$chat) {
            return response()->json([
                'success' => true,
                'messages' => []
            ]);
        }

        // Mark messages as read
        $currentUserType = $this->getCurrentUserType();
        ChatMessage::where('chat_id', $chat->id)
            ->where('sender_type', '!=', $currentUserType)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        $messages = ChatMessage::where('chat_id', $chat->id)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'message_type' => $message->message_type,
                    'file_path' => $message->file_path,
                    'sender_type' => $message->sender_type,
                    'sender_id' => $message->sender_id,
                    'sender_name' => $message->sender->name ?? 'Unknown',
                    'is_read' => $message->is_read,
                    'created_at' => $message->created_at->format('Y-m-d H:i:s'),
                    'formatted_time' => $message->created_at->format('H:i'),
                    'formatted_date' => $message->created_at->format('M d, Y')
                ];
            });

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

    /**
     * Send message in booking chat
     */
    public function sendBookingMessage(Request $request, $bookingId)
    {
        try {
            $request->validate([
                'message' => 'required_without:file|string|max:1000',
                'file' => 'nullable|file|max:10240',
                'message_type' => 'nullable|in:text,file,image'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Booking chat validation error', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Validation failed',
                'details' => $e->errors()
            ], 422);
        }

        $booking = Booking::findOrFail($bookingId);

        if (!$this->canAccessBooking($booking)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Get or create chat - same logic as initialization
        $chat = Chat::where('booking_id', $booking->id)->first();
        
        if (!$chat) {
            // Check if chat exists between these participants
            $chat = Chat::where(function($query) use ($booking) {
                $query->where('participant_type_1', 'customer')
                      ->where('participant_id_1', $booking->user_id)
                      ->where('participant_type_2', 'professional')
                      ->where('participant_id_2', $booking->professional_id);
            })->orWhere(function($query) use ($booking) {
                $query->where('participant_type_1', 'professional')
                      ->where('participant_id_1', $booking->professional_id)
                      ->where('participant_type_2', 'customer')
                      ->where('participant_id_2', $booking->user_id);
            })->first();
            
            // If found, link to this booking
            if ($chat && !$chat->booking_id) {
                $chat->update(['booking_id' => $booking->id]);
            }
        }
        
        if (!$chat) {
            // Create new chat if none exists
            $chat = Chat::create([
                'participant_type_1' => 'customer',
                'participant_id_1' => $booking->user_id,
                'participant_type_2' => 'professional',
                'participant_id_2' => $booking->professional_id,
                'booking_id' => $booking->id,
            ]);
        }

        $currentUserType = $this->getCurrentUserType();
        $currentUserId = $this->getCurrentUserId();

        // Handle file upload
        $messageType = $request->message_type ?? 'text';
        $filePath = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('chat-files', 'public');
            $messageType = in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif']) ? 'image' : 'file';
        }

        // Create message
        $message = ChatMessage::create([
            'chat_id' => $chat->id,
            'sender_type' => $currentUserType,
            'sender_id' => $currentUserId,
            'message' => $request->message ?? ($messageType === 'file' ? 'File attachment' : 'Image attachment'),
            'message_type' => $messageType,
            'file_path' => $filePath
        ]);

        // Update chat last message info
        $chat->update([
            'last_message_at' => now(),
            'last_message_by' => $currentUserId,
            'last_message_by_type' => $currentUserType
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'message' => $message->message,
                'message_type' => $message->message_type,
                'file_path' => $message->file_path,
                'sender_type' => $message->sender_type,
                'sender_id' => $message->sender_id,
                'sender_name' => $this->getCurrentUser()->name,
                'is_read' => $message->is_read,
                'created_at' => $message->created_at->format('Y-m-d H:i:s'),
                'formatted_time' => $message->created_at->format('H:i'),
                'formatted_date' => $message->created_at->format('M d, Y')
            ]
        ]);
    }

    /**
     * Get unread messages count for all bookings
     */
    public function getUnreadCount()
    {
        $currentUserType = $this->getCurrentUserType();
        $currentUserId = $this->getCurrentUserId();

        if ($currentUserType === 'customer') {
            $bookingIds = Booking::where('user_id', $currentUserId)->pluck('id');
        } else {
            $bookingIds = Booking::where('professional_id', $currentUserId)->pluck('id');
        }

        $chatIds = Chat::whereIn('booking_id', $bookingIds)->pluck('id');

        $unreadCount = ChatMessage::whereIn('chat_id', $chatIds)
            ->where('sender_type', '!=', $currentUserType)
            ->where('is_read', false)
            ->count();

        // Get recent unread messages with booking details
        $recentUnread = ChatMessage::with(['chat.booking', 'sender'])
            ->whereIn('chat_id', $chatIds)
            ->where('sender_type', '!=', $currentUserType)
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'message' => $msg->message,
                    'sender_name' => $msg->sender->name ?? 'Unknown',
                    'booking_id' => $msg->chat->booking_id,
                    'service_name' => $msg->chat->booking->service_name ?? 'N/A',
                    'created_at' => $msg->created_at->diffForHumans()
                ];
            });

        return response()->json([
            'success' => true,
            'unread_count' => $unreadCount,
            'recent_messages' => $recentUnread
        ]);
    }

    // Helper Methods

    private function canAccessBooking($booking)
    {
        $currentUserType = $this->getCurrentUserType();
        $currentUserId = $this->getCurrentUserId();

        if ($currentUserType === 'customer') {
            return $booking->user_id == $currentUserId;
        } elseif ($currentUserType === 'professional') {
            return $booking->professional_id == $currentUserId;
        }

        return false;
    }

    private function getCurrentUserType()
    {
        if (Auth::guard('user')->check()) {
            return 'customer';
        } elseif (Auth::guard('professional')->check()) {
            return 'professional';
        }
        return null;
    }

    private function getCurrentUserId()
    {
        if (Auth::guard('user')->check()) {
            return Auth::guard('user')->id();
        } elseif (Auth::guard('professional')->check()) {
            return Auth::guard('professional')->id();
        }
        return null;
    }

    private function getCurrentUser()
    {
        if (Auth::guard('user')->check()) {
            return Auth::guard('user')->user();
        } elseif (Auth::guard('professional')->check()) {
            return Auth::guard('professional')->user();
        }
        return null;
    }
}
