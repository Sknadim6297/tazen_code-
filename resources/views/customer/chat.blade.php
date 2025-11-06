@extends('customer.layout.layout')

@section('title', 'Chat with Admin')

@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/styles.css') }}" />
<style>
    .chat-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .chat-header {
        background: #f5e9da;
        color: #a67c52;
        padding: 1.5rem;
        border-bottom: 1px solid #e9ecef;
    }
    
    .chat-messages {
        height: 500px;
        overflow-y: auto;
        background-color: #fafafa;
        padding: 1.5rem;
    }
    
    .chat-footer {
        background: white;
        padding: 1.5rem;
        border-top: 1px solid #e9ecef;
    }
    
    .message-bubble {
        max-width: 70%;
        padding: 0.75rem 1rem;
        border-radius: 1rem;
        margin-bottom: 1rem;
        word-wrap: break-word;
    }
    
    .message-customer {
        background: #f5e9da;
        color: #a67c52;
        margin-left: auto;
        border-bottom-right-radius: 0.25rem;
        border: 1px solid #e8d4c0;
    }
    
    .message-admin {
        background: white;
        color: #333;
        margin-right: auto;
        border: 1px solid #e9ecef;
        border-bottom-left-radius: 0.25rem;
    }
    
    .message-time {
        font-size: 0.75rem;
        opacity: 0.7;
        margin-top: 0.25rem;
    }
    
    .attachment-item {
        display: inline-block;
        background: #e8d4c0;
        padding: 0.25rem 0.5rem;
        border-radius: 0.5rem;
        margin: 0.25rem 0.25rem 0 0;
        color: #a67c52;
        text-decoration: none;
        font-size: 0.875rem;
    }
    
    .attachment-item:hover {
        background: #dcc5a8;
        color: #a67c52;
        text-decoration: none;
    }
    
    .message-admin .attachment-item {
        background: #f8f9fa;
        color: #495057;
    }
    
    .message-admin .attachment-item:hover {
        background: #e9ecef;
        color: #495057;
    }
    
    .input-group {
        background: white;
        border-radius: 2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .form-control {
        border: none;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
    }
    
    .form-control:focus {
        box-shadow: none;
        border-color: transparent;
    }
    
    .btn-send {
        background: #a67c52;
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
    }
    
    .btn-send:hover {
        background: #8f6341;
        color: white;
        transform: translateY(-1px);
    }
    
    .btn-attach {
        background: transparent;
        border: none;
        color: #6c757d;
        padding: 0.75rem;
    }
    
    .btn-attach:hover {
        color: #495057;
    }
    
    .selected-files {
        background: #f8f9fa;
        border-radius: 0.5rem;
        padding: 0.5rem;
        margin-top: 0.5rem;
        font-size: 0.875rem;
    }
    
    .empty-state {
        text-align: center;
        color: #6c757d;
        padding: 3rem 1rem;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .loading-indicator {
        text-align: center;
        padding: 1rem;
        color: #6c757d;
    }
    
    .chat-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }
    
    .chat-subtitle {
        font-size: 0.9rem;
        opacity: 0.9;
        margin: 0;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <h3>Chat with Admin</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">Chat</li>
        </ul>
    </div>

    <!-- Chat Container -->
    <div class="chat-container">
        <div class="chat-header">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="chat-title">
                        <i class="ri-customer-service-2-line me-2"></i>Support Chat
                    </h1>
                    <p class="chat-subtitle">Get help and support from our team</p>
                </div>
                <div>
                    <i class="ri-chat-3-line" style="font-size: 2rem; opacity: 0.7;"></i>
                </div>
            </div>
        </div>
        
        <div id="chatMessages" class="chat-messages">
            <div class="empty-state">
                <i class="ri-message-3-line"></i>
                <h5>Start a conversation</h5>
                <p>Send a message to our admin team and we'll get back to you shortly.</p>
            </div>
        </div>
        
        <div class="chat-footer">
            <form id="chatForm" enctype="multipart/form-data">
                <div class="input-group">
                    <input type="text" 
                           class="form-control" 
                           id="messageInput" 
                           name="message" 
                           placeholder="Type your message..." 
                           required>
                    <input type="file" 
                           class="d-none" 
                           id="attachmentInput" 
                           name="attachments[]" 
                           multiple 
                           accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt,.zip">
                    <button type="button" class="btn btn-attach" id="attachBtn" title="Attach files">
                        <i class="ri-attachment-2"></i>
                    </button>
                    <button type="submit" class="btn btn-send" id="sendBtn">
                        <i class="ri-send-plane-line"></i>
                    </button>
                </div>
                <div id="selectedFiles" class="selected-files" style="display: none;"></div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let currentChatId = null;
    let messagePollingInterval = null;
    
    // Initialize chat
    initializeChat();
    
    function initializeChat() {
        $.ajax({
            url: '{{ route("user.admin-chat.get-or-create") }}',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    currentChatId = response.chat.id;
                    loadMessages();
                    startMessagePolling();
                } else {
                    showError('Failed to initialize chat');
                }
            },
            error: function() {
                showError('Failed to initialize chat');
            }
        });
    }
    
    function loadMessages() {
        if (!currentChatId) return;
        
        $.ajax({
            url: '{{ route("user.admin-chat.messages") }}',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    displayMessages(response.messages);
                }
            },
            error: function() {
                console.error('Failed to load messages');
            }
        });
    }
    
    function displayMessages(messages) {
        const container = $('#chatMessages');
        container.empty();
        
        if (messages.length === 0) {
            container.html(`
                <div class="empty-state">
                    <i class="ri-message-3-line"></i>
                    <h5>Start a conversation</h5>
                    <p>Send a message to our admin team and we'll get back to you shortly.</p>
                </div>
            `);
            return;
        }
        
        messages.forEach(function(message) {
            const isCustomer = message.sender_type === 'App\\Models\\User';
            const messageClass = isCustomer ? 'message-customer' : 'message-admin';
            const alignmentClass = isCustomer ? 'ms-auto' : 'me-auto';
            
            let messageHtml = `
                <div class="d-flex ${isCustomer ? 'justify-content-end' : 'justify-content-start'} mb-3">
                    <div class="message-bubble ${messageClass} ${alignmentClass}">
                        <div>${escapeHtml(message.message)}</div>
            `;
            
            // Add attachments if any
            if (message.attachments && message.attachments.length > 0) {
                messageHtml += '<div class="mt-2">';
                message.attachments.forEach(function(attachment) {
                    const downloadUrl = '{{ route("user.admin-chat.attachment.download", ":id") }}'.replace(':id', attachment.id);
                    messageHtml += `
                        <a href="${downloadUrl}" class="attachment-item">
                            <i class="${attachment.file_icon || 'ri-file-line'}"></i>
                            ${escapeHtml(attachment.filename)}
                            <small>(${attachment.human_file_size || 'Unknown size'})</small>
                        </a>
                    `;
                });
                messageHtml += '</div>';
            }
            
            messageHtml += `
                        <div class="message-time">${formatDateTime(message.created_at)}</div>
                    </div>
                </div>
            `;
            
            container.append(messageHtml);
        });
        
        // Scroll to bottom
        container.scrollTop(container[0].scrollHeight);
    }
    
    // Handle form submission
    $('#chatForm').on('submit', function(e) {
        e.preventDefault();
        
        const message = $('#messageInput').val().trim();
        if (!message) return;
        
        const sendBtn = $('#sendBtn');
        const originalContent = sendBtn.html();
        sendBtn.prop('disabled', true).html('<i class="ri-loader-4-line fa-spin"></i>');
        
        const formData = new FormData();
        formData.append('message', message);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        
        // Add attachments only if files are selected
        const fileInput = $('#attachmentInput')[0];
        if (fileInput && fileInput.files && fileInput.files.length > 0) {
            for (let i = 0; i < fileInput.files.length; i++) {
                formData.append('attachments[]', fileInput.files[i]);
            }
        }
        
        $.ajax({
            url: '{{ route("user.admin-chat.send-message") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#messageInput').val('');
                    $('#attachmentInput').val('');
                    $('#selectedFiles').hide().empty();
                    loadMessages();
                } else {
                    showError('Failed to send message');
                }
            },
            error: function() {
                showError('Failed to send message');
            },
            complete: function() {
                sendBtn.prop('disabled', false).html(originalContent);
            }
        });
    });
    
    // Handle attachment button
    $('#attachBtn').on('click', function() {
        $('#attachmentInput').click();
    });
    
    // Handle file selection
    $('#attachmentInput').on('change', function() {
        const files = this.files;
        const container = $('#selectedFiles');
        container.empty();
        
        if (files.length > 0) {
            container.show();
            container.append('<div class="fw-bold mb-2">Selected files:</div>');
            for (let i = 0; i < files.length; i++) {
                container.append(`
                    <div class="d-flex align-items-center mb-1">
                        <i class="ri-file-line me-2"></i>
                        <span>${files[i].name}</span>
                        <small class="text-muted ms-2">(${formatFileSize(files[i].size)})</small>
                    </div>
                `);
            }
        } else {
            container.hide();
        }
    });
    
    // Handle Enter key
    $('#messageInput').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#chatForm').submit();
        }
    });
    
    // Start polling for new messages
    function startMessagePolling() {
        messagePollingInterval = setInterval(function() {
            loadMessages();
        }, 5000); // Poll every 5 seconds
    }
    
    // Stop polling when page is hidden
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            if (messagePollingInterval) {
                clearInterval(messagePollingInterval);
            }
        } else {
            startMessagePolling();
        }
    });
    
    // Clean up on page unload
    $(window).on('beforeunload', function() {
        if (messagePollingInterval) {
            clearInterval(messagePollingInterval);
        }
    });
    
    // Utility functions
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    function formatDateTime(dateTimeString) {
        const date = new Date(dateTimeString);
        const now = new Date();
        const diff = now - date;
        const diffDays = Math.floor(diff / (1000 * 60 * 60 * 24));
        
        if (diffDays === 0) {
            return date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        } else if (diffDays === 1) {
            return 'Yesterday ' + date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        } else {
            return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        }
    }
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    function showError(message) {
        if (typeof toastr !== 'undefined') {
            toastr.error(message);
        } else {
            alert(message);
        }
    }
});
</script>
@endsection