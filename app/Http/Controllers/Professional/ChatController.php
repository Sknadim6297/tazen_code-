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
            ->with(['latestMessage.sender'])
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
            'professional_id' => $professional->id,
            'chat_type' => 'admin_professional'
        ]);

        // Load chat with messages
        $chat->load(['messages.sender', 'messages.attachments']);

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
            'professional_id' => $professional->id,
            'chat_type' => 'admin_professional'
        ]);

        // Create the message
        $messageData = [
            'chat_id' => $chat->id,
            'sender_type' => Professional::class,
            'sender_id' => $professional->id,
            'message' => trim($request->message) ?: null
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
        }

        // Update chat's last message info
        $chat->update([
            'last_message_at' => now(),
            'last_message_by' => $professional->id
        ]);

        // Send notification to admin
        try {
            $adminUser = \App\Models\Admin::first();
            if ($adminUser) {
                $adminUser->notify(new NewChatMessage($message, $professional->name));
            }
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
