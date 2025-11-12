<?php

namespace App\Http\Controllers\Customer;

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

class ChatController extends Controller
{
    /**
     * Get or create a chat between customer and admin
     */
    public function getOrCreateChat()
    {
        $customerId = Auth::id();

        // Find the admin (assuming there's only one admin or get the first one)
        $admin = Admin::first();
        
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin not found'
            ], 404);
        }

        // Get or create the chat (admin_id not needed, chat_type identifies admin chats)
        $chat = AdminProfessionalChat::firstOrCreate([
            'customer_id' => $customerId,
            'chat_type' => 'admin_customer'
        ]);

        // Load relationships
        $chat->load(['messages.sender', 'messages.attachments']);

        // Mark messages as read for customer
        $chat->markAsReadForUser('customer', $customerId);

        return response()->json([
            'success' => true,
            'chat' => $chat
        ]);
    }

    /**
     * Send a message from customer to admin
     */
    public function sendMessage(Request $request)
    {
        // First validate basic required fields
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check for personal information in message
        if ($request->has('message') && $request->message) {
            $personalInfoCheck = $this->detectPersonalInfo($request->message);
            if ($personalInfoCheck['detected']) {
                return response()->json([
                    'success' => false,
                    'message' => $personalInfoCheck['message'],
                    'type' => $personalInfoCheck['type']
                ], 422);
            }
        }

        // Handle file validation separately only if files are present
        $validatedFiles = [];
        if ($request->hasFile('attachments')) {
            $files = $request->file('attachments');
            
            // Filter out any null/empty files
            $validFiles = array_filter($files, function($file) {
                return $file !== null && $file->isValid();
            });

            // Allowed file types for customers (for security)
            $allowedMimes = [
                'jpg', 'jpeg', 'png', 'gif', 'webp', // Images
                'pdf', // PDF
                'doc', 'docx', 'odt', // Documents
                'txt', 'rtf', // Text files
                'zip', 'rar', '7z', // Archives
                'mp3', 'wav', 'mp4', 'avi', 'mov', // Media files
                'xlsx', 'xls', 'csv', // Spreadsheets
                'ppt', 'pptx' // Presentations
            ];

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

                // Check file type for customers (security measure)
                $extension = strtolower($file->getClientOriginalExtension());
                if (!in_array($extension, $allowedMimes)) {
                    return response()->json([
                        'success' => false,
                        'message' => "File type '{$extension}' is not allowed. Allowed types: " . implode(', ', $allowedMimes)
                    ], 422);
                }
            }
            
            $validatedFiles = $validFiles;
        }

        try {
            $customerId = Auth::id();
            
            // Find the admin
            $admin = Admin::first();
            
            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Admin not found'
                ], 404);
            }

            // Get the chat
            $chat = AdminProfessionalChat::where('customer_id', $customerId)
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
                'sender_type' => User::class,
                'sender_id' => $customerId,
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
                'last_message_by' => $customerId
            ]);

            // Load message with relationships
            $message->load(['sender', 'attachments']);

            // Send notification to admin
            try {
                $adminUser = \App\Models\Admin::first();
                if ($adminUser) {
                    $senderName = Auth::user()->name ?? 'Customer';
                    $adminUser->notify(new NewChatMessage($message, $senderName));
                }
            } catch (\Exception $e) {
                // Log notification error but don't fail the message sending
                Log::warning('Failed to send chat notification: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            Log::error('Error sending customer message to admin: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error sending message'
            ], 500);
        }
    }

    /**
     * Get chat messages
     */
    public function getMessages()
    {
        $customerId = Auth::id();
        
        // Find the admin
        $admin = Admin::first();
        
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin not found'
            ], 404);
        }
        
        $chat = AdminProfessionalChat::where('customer_id', $customerId)
            ->where('chat_type', 'admin_customer')
            ->with(['messages.sender', 'messages.attachments'])
            ->first();

        if (!$chat) {
            return response()->json([
                'success' => false,
                'message' => 'Chat not found'
            ], 404);
        }

        // Mark messages as read for customer
        $chat->markAsReadForUser('customer', $customerId);

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
        
        // Verify customer has access to this attachment
        $customerId = Auth::id();
        $chat = $attachment->message->chat;
        
        if ($chat->customer_id !== $customerId || $chat->chat_type !== 'admin_customer') {
            abort(403, 'Unauthorized');
        }

        $filePath = storage_path('app/public/' . $attachment->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath, $attachment->original_name);
    }

    /**
     * Show the chat page
     */
    public function index()
    {
        return view('customer.chat');
    }

    /**
     * Mark chat as read
     */
    public function markAsRead()
    {
        $customerId = Auth::id();
        
        // Find the admin
        $admin = Admin::first();
        
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin not found'
            ], 404);
        }
        
        $chat = AdminProfessionalChat::where('customer_id', $customerId)
            ->where('chat_type', 'admin_customer')
            ->first();

        if (!$chat) {
            return response()->json([
                'success' => false,
                'message' => 'Chat not found'
            ], 404);
        }

        $chat->markAsReadForUser('customer', $customerId);

        return response()->json([
            'success' => true,
            'message' => 'Chat marked as read'
        ]);
    }

    /**
     * Get unread message count for customer
     */
    public function getUnreadCount()
    {
        $customerId = Auth::id();
        
        // Find the admin
        $admin = Admin::first();
        
        if (!$admin) {
            return response()->json([
                'success' => true,
                'unread_count' => 0
            ]);
        }
        
        $chat = AdminProfessionalChat::where('customer_id', $customerId)
            ->where('chat_type', 'admin_customer')
            ->first();

        $unreadCount = 0;
        if ($chat) {
            // Get unread messages sent by admin to this customer
            $unreadCount = \App\Models\AdminProfessionalChatMessage::whereHas('chat', function($q) use ($customerId) {
                    $q->where('customer_id', $customerId)
                      ->where('chat_type', 'admin_customer');
                })
                ->where('sender_type', 'App\\Models\\Admin')
                ->where('is_read', false)
                ->count();
        }

        return response()->json([
            'success' => true,
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * Mark a specific admin message as read
     */
    public function markMessageAsRead(Request $request, $messageId)
    {
        try {
            $customerId = Auth::id();
            
            $message = AdminProfessionalChatMessage::whereHas('chat', function($q) use ($customerId) {
                    $q->where('customer_id', $customerId)
                      ->where('chat_type', 'admin_customer');
                })
                ->where('id', $messageId)
                ->where('sender_type', 'App\\Models\\Admin')
                ->first();

            if (!$message) {
                return response()->json([
                    'success' => false,
                    'message' => 'Message not found'
                ], 404);
            }

            // Mark message as read by customer
            $message->update(['is_read' => true, 'read_at' => now()]);

            return response()->json([
                'success' => true,
                'message' => 'Message marked as read'
            ]);

        } catch (\Exception $e) {
            Log::error('Error marking admin message as read', [
                'customer_id' => Auth::id(),
                'message_id' => $messageId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to mark message as read'
            ], 500);
        }
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

    /**
     * Detect personal information in text
     */
    private function detectPersonalInfo($text)
    {
        // Phone number patterns (comprehensive)
        $phonePatterns = [
            // Indian numbers with country code: +91, 0091, 91
            '/(\+91|0091|91)[\s\-]?[6-9]\d{9}/',
            // Indian numbers without country code: 10 digits starting with 6-9
            '/(?<!\d)[6-9]\d{9}(?!\d)/',
            // International formats with common separators
            '/(\+\d{1,3})?[\s\-\.]?\(?\d{1,4}\)?[\s\-\.]?\d{1,4}[\s\-\.]?\d{1,4}[\s\-\.]?\d{1,9}/',
            // Numbers with brackets, dashes, dots, spaces (10+ digits)
            '/\(?\d{3,4}\)?[\s\-\.]?\d{3,4}[\s\-\.]?\d{3,6}/',
            // WhatsApp pattern: "whatsapp me" followed by number
            '/whatsapp\s*(me|at|on)?\s*[\+\d\s\-\(\)\.]{8,}/i',
            // Call me pattern
            '/call\s*(me\s*)?(?:at|on)?\s*[\+\d\s\-\(\)\.]{8,}/i',
            // Phone/mobile pattern
            '/(phone|mobile|contact|number)\s*[:=]?\s*[\+\d\s\-\(\)\.]{8,}/i',
        ];

        // Check for phone numbers
        foreach ($phonePatterns as $pattern) {
            if (preg_match($pattern, $text)) {
                return [
                    'detected' => true,
                    'type' => 'phone number',
                    'message' => 'Phone numbers are not allowed in messages. Please use the platform\'s communication features only.'
                ];
            }
        }

        // Email pattern
        if (preg_match('/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b/', $text)) {
            return [
                'detected' => true,
                'type' => 'email address',
                'message' => 'Email addresses are not allowed in messages. Please use the platform\'s communication features only.'
            ];
        }

        // Social media patterns
        $socialMediaPatterns = [
            '/(?:instagram|insta)\s*[:@]?\s*[A-Za-z0-9._]+/i',
            '/(?:facebook|fb)\s*[:@]?\s*[A-Za-z0-9._]+/i',
            '/(?:twitter|x\.com)\s*[:@]?\s*[A-Za-z0-9._]+/i',
            '/(?:telegram|tg)\s*[:@]?\s*[A-Za-z0-9._]+/i',
        ];

        foreach ($socialMediaPatterns as $pattern) {
            if (preg_match($pattern, $text)) {
                return [
                    'detected' => true,
                    'type' => 'social media handle',
                    'message' => 'Social media handles are not allowed in messages. Please use the platform\'s communication features only.'
                ];
            }
        }

        return ['detected' => false];
    }
}