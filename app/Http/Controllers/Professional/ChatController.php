<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminProfessionalChat;
use App\Models\AdminProfessionalChatMessage;
use App\Models\AdminProfessionalChatAttachment;
use App\Models\Professional;
use App\Models\User;
use App\Notifications\NewChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    /**
     * Show the chat interface for professionals
     */
    public function index()
    {
        $professional = Auth::guard('professional')->user();
        
        // Get all chats for this professional
        $chats = AdminProfessionalChat::where('professional_id', $professional->id)
            ->with(['admin', 'latestMessage.sender'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        return view('professional.chat.index', compact('chats', 'professional'));
    }

    /**
     * Get chat details and messages
     */
    public function getChatMessages(Request $request)
    {
        $professional = Auth::guard('professional')->user();
        
        // Get or create chat with the first available admin
        $admin = \App\Models\Admin::first();
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'No admin available for chat'
            ], 404);
        }

        $chat = AdminProfessionalChat::firstOrCreate([
            'admin_id' => $admin->id,
            'professional_id' => $professional->id,
            'chat_type' => 'admin_professional'
        ], [
            'is_active' => true,
            'last_message_at' => now()
        ]);

        // Load chat with admin and messages
        $chat->load(['admin', 'messages.sender', 'messages.attachments']);

        // Mark messages as read for professional
        $chat->markAsReadForUser('professional', $professional->id);

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

        $professional = Auth::guard('professional')->user();
        
        // Get or create chat with the first available admin
        $admin = \App\Models\Admin::first();
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'No admin available for chat'
            ], 404);
        }

        $chat = AdminProfessionalChat::firstOrCreate([
            'admin_id' => $admin->id,
            'professional_id' => $professional->id,
            'chat_type' => 'admin_professional'
        ], [
            'is_active' => true,
            'last_message_at' => now()
        ]);

        // Create the message
        $messageData = [
            'chat_id' => $chat->id,
            'sender_type' => Professional::class,
            'sender_id' => $professional->id,
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
            'last_message_by' => $professional->id
        ]);

        // Send notification to admin
        try {
            $chat->admin->notify(new NewChatMessage($message, $professional->name));
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
     * Download an attachment
     */
    public function downloadAttachment($attachmentId)
    {
        $attachment = AdminProfessionalChatAttachment::findOrFail($attachmentId);
        $professional = Auth::guard('professional')->user();
        
        // Verify professional has access to this attachment
        $chat = $attachment->message->chat;
        if ($chat->professional_id !== $professional->id) {
            abort(403, 'Unauthorized');
        }

        $filePath = storage_path('app/public/' . $attachment->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath, $attachment->original_name);
    }

    /**
     * Get unread messages count
     */
    public function getUnreadCount()
    {
        $professional = Auth::guard('professional')->user();
        
        $totalUnread = AdminProfessionalChat::where('professional_id', $professional->id)
            ->get()
            ->sum(function ($chat) use ($professional) {
                return $chat->getUnreadCountForUser('professional', $professional->id);
            });

        return response()->json([
            'success' => true,
            'unread_count' => $totalUnread
        ]);
    }
}
