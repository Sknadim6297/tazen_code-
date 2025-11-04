<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminProfessionalChat;
use App\Models\AdminProfessionalChatMessage;
use App\Models\AdminProfessionalChatAttachment;
use App\Models\User;
use App\Models\Admin;
use App\Notifications\NewChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class CustomerChatController extends Controller
{
    /**
     * Get or create a chat between admin and customer
     */
    public function getOrCreateChat(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id'
        ]);

        $adminId = Auth::guard('admin')->id();
        $customerId = $request->customer_id;

        // Get or create the chat
        $chat = AdminProfessionalChat::firstOrCreate([
            'admin_id' => $adminId,
            'customer_id' => $customerId,
            'chat_type' => 'admin_customer'
        ], [
            'is_active' => true
        ]);

        // Load relationships
        $chat->load(['customer', 'messages.sender', 'messages.attachments']);

        // Mark messages as read for admin
        $chat->markAsReadForUser('admin', $adminId);

        return response()->json([
            'success' => true,
            'chat' => $chat
        ]);
    }

    /**
     * Send a message from admin to customer
     */
    public function sendMessage(Request $request)
    {
        // First validate basic required fields
        $validator = Validator::make($request->all(), [
            'chat_id' => 'required|exists:admin_professional_chats,id',
            'message' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Handle file validation separately only if files are present
        $validatedFiles = [];
        if ($request->hasFile('attachments')) {
            $files = $request->file('attachments');
            
            // Filter out any null/empty files
            $validFiles = array_filter($files, function($file) {
                return $file !== null && $file->isValid();
            });

            // Validate each file individually
            foreach ($validFiles as $index => $file) {
                if (!$file->isValid()) {
                    return response()->json([
                        'success' => false,
                        'message' => "File at position $index is invalid"
                    ], 422);
                }

                // Check file size (10MB max)
                if ($file->getSize() > 10240 * 1024) {
                    return response()->json([
                        'success' => false,
                        'message' => "File '{$file->getClientOriginalName()}' is too large. Maximum size is 10MB."
                    ], 422);
                }

                // Allow any file type as requested by admin
                // No MIME type restriction for admin uploads
            }
            
            $validatedFiles = $validFiles;
        }

        try {
            $adminId = Auth::guard('admin')->id();
            $chat = AdminProfessionalChat::where('id', $request->chat_id)
                ->where('admin_id', $adminId)
                ->where('chat_type', 'admin_customer')
                ->first();

            if (!$chat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chat not found'
                ], 404);
            }

            // Create the message
            $message = AdminProfessionalChatMessage::create([
                'chat_id' => $chat->id,
                'sender_type' => Admin::class,
                'sender_id' => $adminId,
                'message' => $request->message,
                'is_read' => false
            ]);

            // Handle file attachments
            if (!empty($validatedFiles)) {
                foreach ($validatedFiles as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('chat_attachments', $filename, 'public');

                    AdminProfessionalChatAttachment::create([
                        'message_id' => $message->id,
                        'original_name' => $file->getClientOriginalName(),
                        'file_name' => $filename,
                        'file_path' => $path,
                        'file_type' => $this->getFileType($file->getMimeType()),
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize()
                    ]);
                }
            }

            // Update chat last message info
            $chat->update([
                'last_message_at' => now(),
                'last_message_by' => $adminId
            ]);

            // Load message with relationships
            $message->load(['sender', 'attachments']);

            // Send notification to customer
            if ($chat->customer) {
                $senderName = Auth::guard('admin')->user()->name ?? 'Admin';
                $chat->customer->notify(new NewChatMessage($message, $senderName));
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            Log::error('Error sending admin message to customer: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error sending message'
            ], 500);
        }
    }

    /**
     * Get chat messages
     */
    public function getMessages(Request $request, $chatId)
    {
        $adminId = Auth::guard('admin')->id();
        
        $chat = AdminProfessionalChat::where('id', $chatId)
            ->where('admin_id', $adminId)
            ->where('chat_type', 'admin_customer')
            ->with(['messages.sender', 'messages.attachments'])
            ->first();

        if (!$chat) {
            return response()->json([
                'success' => false,
                'message' => 'Chat not found'
            ], 404);
        }

        // Mark messages as read for admin
        $chat->markAsReadForUser('admin', $adminId);

        return response()->json([
            'success' => true,
            'messages' => $chat->messages
        ]);
    }

    /**
     * Download attachment
     */
    public function downloadAttachment($attachmentId)
    {
        $attachment = AdminProfessionalChatAttachment::findOrFail($attachmentId);
        
        // Verify admin has access to this attachment
        $adminId = Auth::guard('admin')->id();
        $chat = $attachment->message->chat;
        
        if ($chat->admin_id !== $adminId || $chat->chat_type !== 'admin_customer') {
            abort(403, 'Unauthorized');
        }

        $filePath = storage_path('app/public/' . $attachment->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath, $attachment->original_name);
    }

    /**
     * Get all admin-customer chats for the admin
     */
    public function getChats()
    {
        $adminId = Auth::guard('admin')->id();
        
        $chats = AdminProfessionalChat::where('admin_id', $adminId)
            ->where('chat_type', 'admin_customer')
            ->with(['customer', 'latestMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        // Add unread count for each chat
        foreach ($chats as $chat) {
            $chat->unread_count = $chat->getUnreadCountForUser('admin', $adminId);
        }

        return response()->json([
            'success' => true,
            'chats' => $chats
        ]);
    }

    /**
     * Mark chat as read
     */
    public function markAsRead(Request $request, $chatId)
    {
        $adminId = Auth::guard('admin')->id();
        
        $chat = AdminProfessionalChat::where('id', $chatId)
            ->where('admin_id', $adminId)
            ->where('chat_type', 'admin_customer')
            ->first();

        if (!$chat) {
            return response()->json([
                'success' => false,
                'message' => 'Chat not found'
            ], 404);
        }

        $chat->markAsReadForUser('admin', $adminId);

        return response()->json([
            'success' => true,
            'message' => 'Chat marked as read'
        ]);
    }

    /**
     * Get file type based on mime type
     */
    private function getFileType($mimeType)
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            return 'video';
        } elseif (str_starts_with($mimeType, 'audio/')) {
            return 'audio';
        } elseif (in_array($mimeType, ['application/pdf'])) {
            return 'document';
        } elseif (in_array($mimeType, [
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation'
        ])) {
            return 'document';
        } elseif (in_array($mimeType, ['application/zip', 'application/x-rar-compressed', 'application/x-7z-compressed'])) {
            return 'archive';
        } elseif (str_starts_with($mimeType, 'text/')) {
            return 'text';
        } else {
            return 'other';
        }
    }
}