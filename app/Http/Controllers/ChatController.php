<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\UserActivity;
use App\Models\User;
use App\Models\Professional;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    /**
     * Initialize chat between admin and user/professional
     */
    public function initializeChat(Request $request)
    {
        // Debug logging
        // Validate request
        $validated = $request->validate([
            'participant_type' => 'required|in:admin,professional,user',
            'participant_id' => 'required|integer'
        ]);

        // Get current user info
        $currentUserType = $this->getCurrentUserType();
        $currentUserId = $this->getCurrentUserId();
        
        if (!$currentUserType || !$currentUserId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Create or find chat
        $chat = Chat::findOrCreateChat(
            $currentUserType,
            $currentUserId,
            $request->participant_type,
            $request->participant_id
        );

        // Get participant details
        $participant = $this->getParticipantDetails($request->participant_type, $request->participant_id);
        
        if (!$participant) {
            return response()->json(['error' => 'Participant not found'], 404);
        }

        // Get online status
        $isOnline = UserActivity::isUserOnline($request->participant_type, $request->participant_id);
        $lastSeen = UserActivity::where('user_type', $request->participant_type)
                                ->where('user_id', $request->participant_id)
                                ->first();

        return response()->json([
            'chat_id' => $chat->id,
            'participant' => [
                'id' => $participant->id,
                'name' => $participant->name,
                'type' => $request->participant_type,
                'is_online' => $isOnline,
                'last_seen' => $lastSeen ? $lastSeen->last_seen_formatted : 'Never'
            ]
        ]);
    }

    /**
     * Get chat messages
     */
    public function getMessages(Request $request, $chatId)
    {
        $currentUserType = $this->getCurrentUserType();
        $currentUserId = $this->getCurrentUserId();

        $chat = Chat::findOrFail($chatId);

        // Verify user is part of this chat
        if (!$this->isUserInChat($chat, $currentUserType, $currentUserId)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $messages = $chat->messages()->with('sender')->get();

        // Mark messages as read that are not from current user
        ChatMessage::where('chat_id', $chatId)
                   ->where(function($query) use ($currentUserType, $currentUserId) {
                       $query->where('sender_type', '!=', $currentUserType)
                             ->orWhere('sender_id', '!=', $currentUserId);
                   })
                   ->where('is_read', false)
                   ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json([
            'messages' => $messages->map(function($message) {
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
                    'formatted_time' => $message->created_at->format('H:i')
                ];
            })
        ]);
    }

    /**
     * Send a message
     */
    public function sendMessage(Request $request, $chatId)
    {
        $request->validate([
            'message' => 'required_without:file|string|max:1000',
            'file' => 'nullable|file|max:10240', // 10MB max
            'message_type' => 'in:text,file,image'
        ]);

        $currentUserType = $this->getCurrentUserType();
        $currentUserId = $this->getCurrentUserId();

        $chat = Chat::findOrFail($chatId);

        // Verify user is part of this chat
        if (!$this->isUserInChat($chat, $currentUserType, $currentUserId)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $messageType = $request->message_type ?? 'text';
        $filePath = null;

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('chat-files', 'public');
            $messageType = in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif']) ? 'image' : 'file';
        }

        // Create message
        $message = ChatMessage::create([
            'chat_id' => $chatId,
            'sender_type' => $currentUserType,
            'sender_id' => $currentUserId,
            'message' => $request->message ?? ($messageType === 'file' ? 'File attachment' : 'Image attachment'),
            'message_type' => $messageType,
            'file_path' => $filePath
        ]);

        // Update chat's last message info
        $chat->update([
            'last_message_at' => now(),
            'last_message_by' => $currentUserId,
            'last_message_by_type' => $currentUserType
        ]);

        // Update sender's activity
        UserActivity::updateUserActivity($currentUserType, $currentUserId, true);

        return response()->json([
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
                'formatted_time' => $message->created_at->format('H:i')
            ]
        ]);
    }

    /**
     * Get user's chat list
     */
    public function getChatList()
    {
        $currentUserType = $this->getCurrentUserType();
        $currentUserId = $this->getCurrentUserId();

        $chats = Chat::where(function($query) use ($currentUserType, $currentUserId) {
            $query->where('participant_type_1', $currentUserType)
                  ->where('participant_id_1', $currentUserId);
        })->orWhere(function($query) use ($currentUserType, $currentUserId) {
            $query->where('participant_type_2', $currentUserType)
                  ->where('participant_id_2', $currentUserId);
        })->with('latestMessage')
          ->orderBy('last_message_at', 'desc')
          ->get();

        $chatList = $chats->map(function($chat) use ($currentUserType, $currentUserId) {
            $otherParticipant = $chat->getOtherParticipant($currentUserType, $currentUserId);
            $participant = $this->getParticipantDetails($otherParticipant['type'], $otherParticipant['id']);
            
            $unreadCount = $chat->getUnreadCountForUser($currentUserType, $currentUserId);
            $isOnline = UserActivity::isUserOnline($otherParticipant['type'], $otherParticipant['id']);
            
            $lastSeen = UserActivity::where('user_type', $otherParticipant['type'])
                                   ->where('user_id', $otherParticipant['id'])
                                   ->first();

            return [
                'chat_id' => $chat->id,
                'participant' => [
                    'id' => $participant->id ?? 0,
                    'name' => $participant->name ?? 'Unknown User',
                    'type' => $otherParticipant['type'],
                    'is_online' => $isOnline,
                    'last_seen' => $lastSeen ? $lastSeen->last_seen_formatted : 'Never'
                ],
                'last_message' => $chat->latestMessage ? [
                    'message' => $chat->latestMessage->message,
                    'created_at' => $chat->latestMessage->created_at->format('H:i'),
                    'sender_type' => $chat->latestMessage->sender_type
                ] : null,
                'unread_count' => $unreadCount
            ];
        });

        return response()->json(['chats' => $chatList]);
    }

    /**
     * Update user activity (heartbeat)
     */
    public function updateActivity()
    {
        $currentUserType = $this->getCurrentUserType();
        $currentUserId = $this->getCurrentUserId();

        if ($currentUserType && $currentUserId) {
            UserActivity::updateUserActivity($currentUserType, $currentUserId, true);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Get unread messages count
     */
    public function getUnreadCount()
    {
        $currentUserType = $this->getCurrentUserType();
        $currentUserId = $this->getCurrentUserId();

        $unreadCount = ChatMessage::whereHas('chat', function($query) use ($currentUserType, $currentUserId) {
            $query->where(function($q) use ($currentUserType, $currentUserId) {
                $q->where('participant_type_1', $currentUserType)
                  ->where('participant_id_1', $currentUserId);
            })->orWhere(function($q) use ($currentUserType, $currentUserId) {
                $q->where('participant_type_2', $currentUserType)
                  ->where('participant_id_2', $currentUserId);
            });
        })->where(function($query) use ($currentUserType, $currentUserId) {
            $query->where('sender_type', '!=', $currentUserType)
                  ->orWhere('sender_id', '!=', $currentUserId);
        })->where('is_read', false)->count();

        return response()->json(['unread_count' => $unreadCount]);
    }

    // Helper methods
    private function getCurrentUserType()
    {
        if (Auth::guard('admin')->check()) {
            return 'admin';
        } elseif (Auth::guard('professional')->check()) {
            return 'professional';
        } elseif (Auth::guard('user')->check()) {
            return 'user';
        }
        return null;
    }

    private function getCurrentUserId()
    {
        if (Auth::guard('admin')->check()) {
            return Auth::guard('admin')->id();
        } elseif (Auth::guard('professional')->check()) {
            return Auth::guard('professional')->id();
        } elseif (Auth::guard('user')->check()) {
            return Auth::guard('user')->id();
        }
        return null;
    }

    private function getCurrentUser()
    {
        if (Auth::guard('admin')->check()) {
            return Auth::guard('admin')->user();
        } elseif (Auth::guard('professional')->check()) {
            return Auth::guard('professional')->user();
        } elseif (Auth::guard('user')->check()) {
            return Auth::guard('user')->user();
        }
        return null;
    }

    private function getParticipantDetails($type, $id)
    {
        switch ($type) {
            case 'admin':
                return Admin::find($id);
            case 'professional':
                return Professional::find($id);
            case 'user':
                return User::find($id);
            default:
                return null;
        }
    }

    private function isUserInChat($chat, $userType, $userId)
    {
        return ($chat->participant_type_1 == $userType && $chat->participant_id_1 == $userId) ||
               ($chat->participant_type_2 == $userType && $chat->participant_id_2 == $userId);
    }
}
