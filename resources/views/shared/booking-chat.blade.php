<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat - Booking #{{ $booking->id }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            overflow: hidden;
        }

        .chat-container {
            max-width: 1200px;
            margin: 20px auto;
            height: calc(100vh - 40px);
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Chat Header */
        .chat-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .chat-header-info h4 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 600;
        }

        .chat-header-info p {
            margin: 5px 0 0 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .chat-header-actions .btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .chat-header-actions .btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        /* Chat Messages Area */
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 25px;
            background: #f8f9fa;
            background-image: 
                repeating-linear-gradient(
                    45deg,
                    transparent,
                    transparent 10px,
                    rgba(255,255,255,.03) 10px,
                    rgba(255,255,255,.03) 20px
                );
        }

        .chat-messages::-webkit-scrollbar {
            width: 8px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 10px;
        }

        /* Message Bubble */
        .message {
            display: flex;
            margin-bottom: 20px;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.sent {
            justify-content: flex-end;
        }

        .message.received {
            justify-content: flex-start;
        }

        .message.system {
            justify-content: center;
        }

        .message-content {
            max-width: 65%;
            position: relative;
        }

        .message.system .message-content {
            max-width: 80%;
        }

        .message-bubble {
            padding: 12px 16px;
            border-radius: 18px;
            word-wrap: break-word;
            position: relative;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Sent Message (Current User) */
        .message.sent .message-bubble {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-bottom-right-radius: 4px;
        }

        /* Received Message (Other User) */
        .message.received .message-bubble {
            background: white;
            color: #333;
            border-bottom-left-radius: 4px;
            border: 1px solid #e9ecef;
        }

        /* System Message */
        .message.system .message-bubble {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffc107;
            text-align: center;
            font-style: italic;
            font-size: 0.9rem;
        }

        .message-sender {
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 4px;
            opacity: 0.8;
        }

        .message.sent .message-sender {
            color: white;
            text-align: right;
        }

        .message.received .message-sender {
            color: #667eea;
        }

        .message-text {
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 5px;
        }

        .message-time {
            font-size: 0.7rem;
            opacity: 0.7;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 5px;
        }

        .message.sent .message-time {
            justify-content: flex-end;
            color: white;
        }

        .message.received .message-time {
            color: #6c757d;
        }

        /* Read Receipts */
        .read-receipt {
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        .read-receipt i {
            font-size: 0.8rem;
        }

        .read-receipt.read {
            color: #4fc3f7;
        }

        .read-receipt.unread {
            color: rgba(255, 255, 255, 0.6);
        }

        /* Attachment */
        .message-attachment {
            margin-top: 8px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            display: inline-block;
        }

        .message.received .message-attachment {
            background: #f8f9fa;
        }

        .message-attachment a {
            color: inherit;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .message-attachment i {
            font-size: 1.2rem;
        }

        .message-attachment:hover {
            opacity: 0.8;
        }

        /* Chat Input Area */
        .chat-input-area {
            background: white;
            padding: 20px 25px;
            border-top: 2px solid #e9ecef;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .chat-input-area textarea {
            flex: 1;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            padding: 12px 20px;
            resize: none;
            font-size: 0.95rem;
            transition: all 0.3s;
            font-family: inherit;
        }

        .chat-input-area textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .chat-input-area .btn-attachment {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            color: #6c757d;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .chat-input-area .btn-attachment:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .chat-input-area .btn-send {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .chat-input-area .btn-send:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .chat-input-area .btn-send:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* File preview */
        .file-preview {
            padding: 10px 15px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .file-preview-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .file-preview-remove {
            cursor: pointer;
            color: #dc3545;
            font-size: 1.2rem;
        }

        /* Loading indicator */
        .typing-indicator {
            display: none;
            padding: 10px 15px;
            background: white;
            border-radius: 18px;
            width: fit-content;
            border: 1px solid #e9ecef;
        }

        .typing-indicator span {
            height: 8px;
            width: 8px;
            background: #667eea;
            border-radius: 50%;
            display: inline-block;
            margin: 0 2px;
            animation: typing 1.4s infinite;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {
            0%, 60%, 100% {
                transform: translateY(0);
            }
            30% {
                transform: translateY(-10px);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .chat-container {
                margin: 0;
                height: 100vh;
                border-radius: 0;
            }

            .message-content {
                max-width: 85%;
            }

            .chat-header-info h4 {
                font-size: 1.1rem;
            }

            .chat-header-info p {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <!-- Chat Header -->
        <div class="chat-header">
            <div class="chat-header-info">
                <h4>
                    <i class="fas fa-comments"></i> 
                    Chat - Booking #{{ $booking->id }}
                </h4>
                <p>
                    @if($userType === 'customer')
                        Chatting with: <strong>{{ $booking->professional->name ?? 'Professional' }}</strong>
                    @else
                        Chatting with: <strong>{{ $booking->user->name ?? 'Customer' }}</strong>
                    @endif
                    | Service: <strong>{{ $booking->service_name ?? ($booking->service->name ?? 'N/A') }}</strong>
                    @if($booking->sub_service_name ?? ($booking->subservice->name ?? null))
                        | Sub-service: <strong>{{ $booking->sub_service_name ?? $booking->subservice->name }}</strong>
                    @endif
                </p>
            </div>
            <div class="chat-header-actions">
                <button class="btn" onclick="window.history.back()">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
            </div>
        </div>

        <!-- Chat Messages -->
        <div class="chat-messages" id="chatMessages">
            @foreach($messages as $message)
                @if($message->is_system_message)
                    <div class="message system">
                        <div class="message-content">
                            <div class="message-bubble">
                                <div class="message-text">{{ $message->message }}</div>
                            </div>
                        </div>
                    </div>
                @else
                    @php
                        $isSent = ($userType === $message->sender_type);
                        $senderName = '';
                        if ($message->sender_type === 'customer') {
                            $senderName = $booking->user->name ?? 'Customer';
                        } else {
                            $senderName = $booking->professional->name ?? 'Professional';
                        }
                    @endphp
                    <div class="message {{ $isSent ? 'sent' : 'received' }}" data-message-id="{{ $message->id }}">
                        <div class="message-content">
                            @if(!$isSent)
                                <div class="message-sender">{{ $senderName }}</div>
                            @endif
                            <div class="message-bubble">
                                @if($message->message)
                                    <div class="message-text">{{ $message->message }}</div>
                                @endif
                                @if($message->attachment)
                                    <div class="message-attachment">
                                        <a href="{{ asset('storage/' . $message->attachment) }}" target="_blank">
                                            <i class="fas fa-file"></i>
                                            <span>View Attachment</span>
                                        </a>
                                    </div>
                                @endif
                                <div class="message-time">
                                    <span>{{ $message->created_at->format('h:i A') }}</span>
                                    @if($isSent)
                                        <span class="read-receipt {{ $message->is_read ? 'read' : 'unread' }}">
                                            <i class="fas fa-check-double"></i>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            <!-- Typing Indicator -->
            <div class="typing-indicator" id="typingIndicator">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <!-- Chat Input -->
        <div class="chat-input-area">
            <form id="chatForm" style="display: flex; width: 100%; gap: 10px; align-items: center;">
                <input type="file" id="attachmentInput" name="attachment" style="display: none;" accept="image/*,.pdf,.doc,.docx">
                
                <label for="attachmentInput" class="btn-attachment">
                    <i class="fas fa-paperclip"></i>
                </label>

                <textarea 
                    id="messageInput" 
                    name="message" 
                    rows="1" 
                    placeholder="Type your message here..."
                    maxlength="5000"
                ></textarea>

                <button type="submit" class="btn-send" id="btnSend">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>

        <!-- File Preview (shown when file is selected) -->
        <div id="filePreviewContainer" style="display: none; padding: 10px 25px; background: white; border-top: 1px solid #e9ecef;">
            <div class="file-preview">
                <div class="file-preview-info">
                    <i class="fas fa-file"></i>
                    <span id="fileName"></span>
                </div>
                <i class="fas fa-times file-preview-remove" id="removeFile"></i>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            const bookingId = {{ $booking->id }};
            const userType = '{{ $userType }}';
            let pollingInterval;
            let selectedFile = null;

            // CSRF Token Setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Auto-scroll to bottom
            function scrollToBottom() {
                const chatMessages = document.getElementById('chatMessages');
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            // Initial scroll
            scrollToBottom();

            // File attachment handler
            $('#attachmentInput').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    selectedFile = file;
                    $('#fileName').text(file.name);
                    $('#filePreviewContainer').slideDown();
                }
            });

            // Remove file
            $('#removeFile').on('click', function() {
                selectedFile = null;
                $('#attachmentInput').val('');
                $('#filePreviewContainer').slideUp();
            });

            // Auto-resize textarea
            $('#messageInput').on('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 120) + 'px';
            });

            // Send message on Enter (Shift+Enter for new line)
            $('#messageInput').on('keypress', function(e) {
                if (e.which === 13 && !e.shiftKey) {
                    e.preventDefault();
                    $('#chatForm').submit();
                }
            });

            // Submit form
            $('#chatForm').on('submit', function(e) {
                e.preventDefault();

                const message = $('#messageInput').val().trim();
                
                if (!message && !selectedFile) {
                    return;
                }

                const formData = new FormData();
                if (message) {
                    formData.append('message', message);
                }
                if (selectedFile) {
                    formData.append('attachment', selectedFile);
                }

                // Disable send button
                $('#btnSend').prop('disabled', true);

                @if($userType === 'customer')
                    const sendUrl = '{{ route("user.chat.send", $booking->id) }}';
                @else
                    const sendUrl = '{{ route("professional.chat.send", $booking->id) }}';
                @endif

                $.ajax({
                    url: sendUrl,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Clear input
                        $('#messageInput').val('').css('height', 'auto');
                        $('#attachmentInput').val('');
                        $('#filePreviewContainer').hide();
                        selectedFile = null;

                        // Add message to chat
                        addMessageToChat(response.message, response.sender_name, true);
                        
                        // Enable send button
                        $('#btnSend').prop('disabled', false);
                        
                        // Scroll to bottom
                        scrollToBottom();
                    },
                    error: function(xhr) {
                        alert('Failed to send message. Please try again.');
                        $('#btnSend').prop('disabled', false);
                    }
                });
            });

            // Add message to chat UI
            function addMessageToChat(message, senderName, isSent) {
                const messageHtml = `
                    <div class="message ${isSent ? 'sent' : 'received'}" data-message-id="${message.id}">
                        <div class="message-content">
                            ${!isSent ? `<div class="message-sender">${senderName}</div>` : ''}
                            <div class="message-bubble">
                                ${message.message ? `<div class="message-text">${message.message}</div>` : ''}
                                ${message.attachment ? `
                                    <div class="message-attachment">
                                        <a href="/storage/${message.attachment}" target="_blank">
                                            <i class="fas fa-file"></i>
                                            <span>View Attachment</span>
                                        </a>
                                    </div>
                                ` : ''}
                                <div class="message-time">
                                    <span>${message.created_at ? new Date(message.created_at).toLocaleTimeString('en-US', {hour: '2-digit', minute: '2-digit'}) : ''}</span>
                                    ${isSent ? `
                                        <span class="read-receipt ${message.is_read ? 'read' : 'unread'}">
                                            <i class="fas fa-check-double"></i>
                                        </span>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                $('#chatMessages').append(messageHtml);
            }

            // Polling for new messages
            function pollMessages() {
                @if($userType === 'customer')
                    const messagesUrl = '{{ route("user.chat.messages", $booking->id) }}';
                @else
                    const messagesUrl = '{{ route("professional.chat.messages", $booking->id) }}';
                @endif

                $.ajax({
                    url: messagesUrl,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            updateMessages(response.messages);
                        }
                    },
                    error: function(xhr) {
                        console.error('Polling failed');
                    }
                });
            }

            // Update messages in UI
            function updateMessages(messages) {
                const currentMessages = {};
                $('.message[data-message-id]').each(function() {
                    const id = $(this).data('message-id');
                    currentMessages[id] = true;
                });

                messages.forEach(function(message) {
                    if (message.is_system_message) return;

                    const isSent = (userType === message.sender_type);
                    
                    if (!currentMessages[message.id]) {
                        // New message - add to chat
                        addMessageToChat(message, message.sender_name, isSent);
                        scrollToBottom();
                    } else {
                        // Update read status
                        const $message = $(`.message[data-message-id="${message.id}"]`);
                        if (isSent) {
                            const $receipt = $message.find('.read-receipt');
                            if (message.is_read) {
                                $receipt.removeClass('unread').addClass('read');
                            }
                        }
                    }
                });
            }

            // Start polling every 5 seconds
            pollingInterval = setInterval(pollMessages, 5000);

            // Stop polling when leaving page
            $(window).on('beforeunload', function() {
                if (pollingInterval) {
                    clearInterval(pollingInterval);
                }
            });
        });
    </script>
</body>
</html>
