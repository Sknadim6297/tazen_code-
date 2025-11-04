<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminProfessionalChat;
use App\Models\AdminProfessionalChatMessage;
use App\Models\AdminProfessionalChatAttachment;
use App\Models\Professional;
use App\Models\User;
use App\Models\Admin;
use App\Notifications\NewChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ChatController extends Controller
{
    /**
     * Get or create a chat between admin and professional
     */
    public function getOrCreateChat(Request $request)
    {
        $request->validate([
            'professional_id' => 'required|exists:professionals,id'
        ]);

        $adminId = Auth::guard('admin')->id();
        $professionalId = $request->professional_id;

        // Get or create the chat
        $chat = AdminProfessionalChat::firstOrCreate([
            'admin_id' => $adminId,
            'professional_id' => $professionalId,
            'chat_type' => 'admin_professional'
        ], [
            'is_active' => true
        ]);

        // Load relationships
        $chat->load(['professional', 'messages.sender', 'messages.attachments']);

        // Mark messages as read for admin
        $chat->markAsReadForUser('admin', $adminId);

        return response()->json([
            'success' => true,
            'chat' => $chat
        ]);
    }

    /**
     * Send a message in the chat
     */
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chat_id' => 'required|exists:admin_professional_chats,id',
            'message' => 'nullable|string|max:5000',
            'attachment' => 'nullable|file|max:10240', // 10MB max
        ]);

        // Custom validation: require either message or attachment
        $validator->after(function ($validator) use ($request) {
            if (empty(trim($request->message)) && !$request->hasFile('attachment')) {
                $validator->errors()->add('message', 'Either a message or an attachment is required.');
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $adminId = Auth::guard('admin')->id();
        $chat = AdminProfessionalChat::findOrFail($request->chat_id);

        // Verify admin owns this chat
        if ($chat->admin_id !== $adminId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Create the message
        $messageData = [
            'chat_id' => $chat->id,
            'sender_type' => Admin::class,
            'sender_id' => $adminId,
            'message' => trim($request->message) ?: null,
            'message_type' => $request->hasFile('attachment') ? 'file' : 'text'
        ];

        $message = AdminProfessionalChatMessage::create($messageData);

        // Handle file attachment
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . uniqid() . '.' . $extension;
            $filePath = $file->storeAs('chat_attachments', $fileName, 'public');

            // Determine file type
            $mimeType = $file->getMimeType();
            $fileType = 'document';
            if (str_starts_with($mimeType, 'image/')) {
                $fileType = 'image';
            } elseif (str_starts_with($mimeType, 'video/')) {
                $fileType = 'video';
            }

            AdminProfessionalChatAttachment::create([
                'message_id' => $message->id,
                'original_name' => $originalName,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'file_type' => $fileType,
                'mime_type' => $mimeType,
                'file_size' => $file->getSize()
            ]);

            $message->message_type = 'file';
            $message->save();
        }

        // Update chat's last message info
        $chat->update([
            'last_message_at' => now(),
            'last_message_by' => $adminId
        ]);

        // Send notification to professional
        try {
            $adminUser = Auth::guard('admin')->user();
            $chat->professional->notify(new NewChatMessage($message, $adminUser->name));
        } catch (\Exception $e) {
            // Log notification error but don't fail the message sending
            Log::warning('Failed to send chat notification: ' . $e->getMessage());
        }

        // Load relationships for response
        $message->load(['sender', 'attachments']);

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Get messages for a chat
     */
    public function getMessages(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:admin_professional_chats,id',
            'page' => 'nullable|integer|min:1'
        ]);

        $adminId = Auth::guard('admin')->id();
        $chat = AdminProfessionalChat::findOrFail($request->chat_id);

        // Verify admin owns this chat
        if ($chat->admin_id !== $adminId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $messages = $chat->messages()
            ->with(['sender', 'attachments'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        // Mark messages as read for admin
        $chat->markAsReadForUser('admin', $adminId);

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

    /**
     * Download an attachment
     */
    public function downloadAttachment($attachmentId)
    {
        $attachment = AdminProfessionalChatAttachment::findOrFail($attachmentId);
        $adminId = Auth::guard('admin')->id();
        
        // Verify admin has access to this attachment
        $chat = $attachment->message->chat;
        if ($chat->admin_id !== $adminId) {
            abort(403, 'Unauthorized');
        }

        $filePath = storage_path('app/public/' . $attachment->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath, $attachment->original_name);
    }

    /**
     * Get chat summary for admin dashboard
     */
    public function getChatSummary()
    {
        $adminId = Auth::guard('admin')->id();
        
        $chats = AdminProfessionalChat::where('admin_id', $adminId)
            ->with(['professional', 'latestMessage.sender'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        $summary = $chats->map(function ($chat) use ($adminId) {
            return [
                'chat_id' => $chat->id,
                'professional' => [
                    'id' => $chat->professional->id,
                    'name' => $chat->professional->name,
                    'email' => $chat->professional->email
                ],
                'latest_message' => $chat->latestMessage ? [
                    'message' => $chat->latestMessage->message,
                    'created_at' => $chat->latestMessage->created_at,
                    'sender_name' => $chat->latestMessage->sender_name,
                    'is_sent_by_admin' => $chat->latestMessage->isSentByAdmin()
                ] : null,
                'unread_count' => $chat->getUnreadCountForUser('admin', $adminId),
                'last_activity' => $chat->last_message_at
            ];
        });

        return response()->json([
            'success' => true,
            'chats' => $summary
        ]);
    }
}
