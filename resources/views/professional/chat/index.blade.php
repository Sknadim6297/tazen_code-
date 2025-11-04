@extends('professional.layout.layout')

@section('styles')
<style>
    .chat-container {
        height: calc(100vh - 120px);
        display: flex;
        flex-direction: column;
    }
    
    .chat-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        padding: 20px;
        border-radius: 10px 10px 0 0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        background-color: #f8f9fa;
        max-height: 400px;
    }
    
    .message-bubble {
        max-width: 75%;
        word-wrap: break-word;
        margin-bottom: 15px;
        animation: slideInUp 0.3s ease-out;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .message-sender {
        font-size: 0.85rem;
        opacity: 0.9;
    }
    
    .message-time {
        font-size: 0.75rem;
        opacity: 0.7;
    }
    
    .chat-input-area {
        background: white;
        padding: 20px;
        border-top: 1px solid #dee2e6;
        border-radius: 0 0 10px 10px;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
    }
    
    .attachment-preview {
        background: #f8f9fa;
        border: 1px dashed #dee2e6;
        border-radius: 5px;
        padding: 10px;
        margin-top: 10px;
    }
    
    .btn-attach {
        border: none;
        background: #f8f9fa;
        color: #6c757d;
        transition: all 0.3s ease;
    }
    
    .btn-attach:hover {
        background: #e9ecef;
        color: #495057;
    }
    
    .btn-send {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border: none;
        transition: all 0.3s ease;
        color: white !important;
        min-width: 50px;
        height: 40px;
    }
    
    .btn-send:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
        background: linear-gradient(135deg, #375abd 0%, #1d4087 100%);
    }
    
    .btn-attach {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        color: #6c757d;
        min-width: 50px;
        height: 40px;
    }
    
    .btn-attach:hover {
        background: #e9ecef;
        color: #495057;
    }
    
    .chat-empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 300px;
        color: #6c757d;
    }
    
    .chat-empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .admin-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        margin-right: 10px;
    }
    
    .professional-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #1cc88a 0%, #13a085 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        margin-left: 10px;
    }
    
    .loading-spinner {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 200px;
    }
    
    /* Chat Message Styles */
    .message-bubble {
        position: relative;
        border-radius: 18px !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin: 8px 0;
        max-width: 75%;
    }
    
    .message-bubble.bg-primary {
        background: linear-gradient(135deg, #1cc88a 0%, #13a085 100%) !important;
        margin-left: auto;
    }
    
    .message-bubble.bg-light {
        background: #f8f9fa !important;
        border: 1px solid #e9ecef;
        color: #495057 !important;
        margin-right: auto;
    }
    
    .justify-content-end .message-bubble::after {
        content: '';
        position: absolute;
        bottom: 10px;
        right: -8px;
        width: 0;
        height: 0;
        border: 8px solid transparent;
        border-left-color: #1cc88a;
        border-right: 0;
        border-bottom: 0;
        margin-top: -4px;
    }
    
    .justify-content-start .message-bubble::after {
        content: '';
        position: absolute;
        bottom: 10px;
        left: -8px;
        width: 0;
        height: 0;
        border: 8px solid transparent;
        border-right-color: #f8f9fa;
        border-left: 0;
        border-bottom: 0;
        margin-top: -4px;
    }
    
    .message-sender {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .message-time {
        font-size: 10px;
        opacity: 0.7;
    }
    
    #chatMessages {
        max-height: 400px;
        overflow-y: auto;
        padding: 15px;
    }
    
    #chatMessages::-webkit-scrollbar {
        width: 6px;
    }
    
    #chatMessages::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    #chatMessages::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    
    #chatMessages::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>
@endsection

@section('title', 'Chat with Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="chat-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-1">
                                <i class="ri-message-3-line me-2"></i>Chat with Admin
                            </h4>
                            <p class="mb-0 opacity-75">Direct communication with the admin team</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-success" id="connectionStatus">Connected</span>
                        </div>
                    </div>
                </div>
                
                <div class="chat-container">
                    <!-- Chat Messages Area -->
                    <div class="chat-messages" id="chatMessages">
                        <div class="loading-spinner">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span class="ms-3">Loading chat...</span>
                        </div>
                    </div>
                    
                    <!-- Chat Input Area -->
                    <div class="chat-input-area">
                        <form id="chatMessageForm" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="input-group">
                                <input type="text" 
                                       class="form-control form-control-lg" 
                                       id="messageInput" 
                                       name="message" 
                                       placeholder="Type your message to admin..." 
                                       autocomplete="off">
                                       
                                <input type="file" 
                                       id="fileInput" 
                                       name="attachment" 
                                       style="display: none;" 
                                       accept=".pdf,.doc,.docx,.xls,.xlsx,.txt,.jpg,.jpeg,.png,.gif">
                                       
                                <button type="button" 
                                        class="btn btn-attach" 
                                        id="attachBtn" 
                                        title="Attach File">
                                    <i class="ri-attachment-line fs-5"></i>
                                </button>
                                
                                <button type="submit" 
                                        class="btn btn-send btn-primary" 
                                        id="sendBtn">
                                    <i class="ri-send-plane-fill fs-5"></i>
                                </button>
                            </div>
                            
                            <!-- File Preview -->
                            <div id="filePreview" class="attachment-preview" style="display: none;">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i class="ri-attachment-line me-2"></i>
                                        <span id="fileName"></span>
                                        <span id="fileSize" class="text-muted ms-2"></span>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0" id="removeFileBtn">
                                        <i class="ri-close-line"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let currentChatId = null;
    let isLoading = false;
    
    // Initialize chat
    loadChat();
    
    // Load chat with admin
    function loadChat() {
        if (isLoading) return;
        isLoading = true;
        
        showLoadingState();
        
        $.ajax({
            url: '{{ route("professional.admin-chat.messages") }}',
            method: 'GET',
            success: function(response) {
                if (response.success && response.chat) {
                    currentChatId = response.chat.id;
                    displayMessages(response.chat.messages);
                    updateConnectionStatus(true);
                } else {
                    showEmptyState();
                }
            },
            error: function(xhr) {
                showErrorState('Failed to load chat. Please refresh the page.');
                updateConnectionStatus(false);
            },
            complete: function() {
                isLoading = false;
            }
        });
    }
    
    // Display messages
    function displayMessages(messages) {
        let messagesHtml = '';
        
        if (!messages || messages.length === 0) {
            showEmptyState();
            return;
        }
        
        // Sort messages by creation time
        messages.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
        
        messages.forEach(function(message) {
            messagesHtml += buildMessageHtml(message);
        });
        
        $('#chatMessages').html(messagesHtml);
        scrollToBottom();
    }
    
    // Build message HTML
    function buildMessageHtml(message) {
        const isProfessional = message.sender_type === 'App\\Models\\Professional';
        const messageClass = isProfessional ? 'justify-content-end' : 'justify-content-start';
        const bgClass = isProfessional ? 'bg-primary text-white' : 'bg-light';
        const alignClass = isProfessional ? 'text-end' : 'text-start';
        
        let attachmentHtml = '';
        if (message.attachments && message.attachments.length > 0) {
            message.attachments.forEach(function(attachment) {
                attachmentHtml += `
                    <div class="mt-2">
                        <a href="/professional/admin-chat/attachment/${attachment.id}/download" 
                           class="btn btn-sm btn-outline-secondary text-decoration-none">
                            <i class="${attachment.file_icon || 'ri-attachment-line'}"></i>
                            ${attachment.original_name}
                            <small>(${attachment.human_file_size || 'N/A'})</small>
                        </a>
                    </div>
                `;
            });
        }
        
        return `
            <div class="d-flex ${messageClass} mb-3">
                <div class="message-bubble ${bgClass} rounded-3 px-3 py-2">
                    <div class="message-sender fw-bold small mb-1 ${alignClass}">
                        ${isProfessional ? 'You' : message.sender_name}
                    </div>
                    ${message.message ? `<div class="message-text">${escapeHtml(message.message)}</div>` : ''}
                    ${attachmentHtml}
                    <div class="message-time small mt-1 ${alignClass}">
                        ${formatDateTime(message.created_at)}
                    </div>
                </div>
            </div>
        `;
    }
    
    // Send message
    $('#chatMessageForm').on('submit', function(e) {
        e.preventDefault();
        
        const message = $('#messageInput').val().trim();
        const hasFile = $('#fileInput')[0].files.length > 0;
        
        if (!message && !hasFile) {
            return;
        }
        
        const formData = new FormData(this);
        const sendBtn = $('#sendBtn');
        const originalBtnHtml = sendBtn.html();
        
        // Disable form
        sendBtn.prop('disabled', true).html('<i class="ri-loader-4-line fa-spin"></i>');
        $('#messageInput').prop('disabled', true);
        
        $.ajax({
            url: '{{ route("professional.admin-chat.send-message") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Clear form
                    $('#messageInput').val('');
                    clearFileSelection();
                    
                    // Add message to chat
                    appendMessage(response.message);
                    scrollToBottom();
                    updateConnectionStatus(true);
                } else {
                    toastr.error('Failed to send message');
                }
            },
            error: function(xhr) {
                let errorMsg = 'Failed to send message. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    errorMsg = Object.values(errors).flat().join(', ');
                }
                toastr.error(errorMsg);
                updateConnectionStatus(false);
            },
            complete: function() {
                sendBtn.prop('disabled', false).html(originalBtnHtml);
                $('#messageInput').prop('disabled', false).focus();
            }
        });
    });
    
    // Append new message
    function appendMessage(message) {
        const messageHtml = buildMessageHtml(message);
        
        // Check if we need to replace empty state
        if ($('#chatMessages').find('.chat-empty-state').length > 0) {
            $('#chatMessages').html(messageHtml);
        } else {
            $('#chatMessages').append(messageHtml);
        }
        
        scrollToBottom();
    }
    
    // File handling
    $('#attachBtn').on('click', function() {
        $('#fileInput').click();
    });
    
    $('#fileInput').on('change', function() {
        const file = this.files[0];
        if (file) {
            showFilePreview(file);
        }
    });
    
    $('#removeFileBtn').on('click', function() {
        clearFileSelection();
    });
    
    function showFilePreview(file) {
        $('#fileName').text(file.name);
        
        // Format file size
        let fileSize = file.size;
        const units = ['B', 'KB', 'MB', 'GB'];
        let unitIndex = 0;
        
        while (fileSize > 1024 && unitIndex < units.length - 1) {
            fileSize /= 1024;
            unitIndex++;
        }
        
        $('#fileSize').text(`(${fileSize.toFixed(2)} ${units[unitIndex]})`);
        $('#filePreview').show();
    }
    
    function clearFileSelection() {
        $('#fileInput').val('');
        $('#filePreview').hide();
        $('#fileName').text('');
        $('#fileSize').text('');
    }
    
    // Utility functions
    function scrollToBottom() {
        const chatMessages = $('#chatMessages');
        chatMessages.scrollTop(chatMessages[0].scrollHeight);
    }
    
    function showLoadingState() {
        $('#chatMessages').html(`
            <div class="loading-spinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <span class="ms-3">Loading chat...</span>
            </div>
        `);
    }
    
    function showEmptyState() {
        $('#chatMessages').html(`
            <div class="chat-empty-state">
                <i class="ri-message-3-line"></i>
                <h5>No messages yet</h5>
                <p class="text-muted mb-0">Start a conversation with the admin team</p>
            </div>
        `);
    }
    
    function showErrorState(message) {
        $('#chatMessages').html(`
            <div class="chat-empty-state text-danger">
                <i class="ri-error-warning-line"></i>
                <h5>Error</h5>
                <p class="mb-0">${message}</p>
            </div>
        `);
    }
    
    function updateConnectionStatus(connected) {
        const statusEl = $('#connectionStatus');
        if (connected) {
            statusEl.removeClass('bg-danger').addClass('bg-success').text('Connected');
        } else {
            statusEl.removeClass('bg-success').addClass('bg-danger').text('Disconnected');
        }
    }
    
    function formatDateTime(dateTime) {
        const date = new Date(dateTime);
        return date.toLocaleString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
    
    function formatFileSize(bytes) {
        const units = ['B', 'KB', 'MB', 'GB'];
        let size = bytes;
        let unitIndex = 0;
        
        while (size >= 1024 && unitIndex < units.length - 1) {
            size /= 1024;
            unitIndex++;
        }
        
        return `${Math.round(size * 100) / 100} ${units[unitIndex]}`;
    }
    
    function getFileIcon(mimeType) {
        if (mimeType.startsWith('image/')) {
            return 'ri-image-line';
        } else if (mimeType === 'application/pdf') {
            return 'ri-file-pdf-line';
        } else if (mimeType.includes('word')) {
            return 'ri-file-word-line';
        } else if (mimeType.includes('excel') || mimeType.includes('spreadsheet')) {
            return 'ri-file-excel-line';
        } else {
            return 'ri-attachment-line';
        }
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Auto-focus on message input
    $('#messageInput').focus();
    
    // Handle Enter key
    $('#messageInput').on('keypress', function(e) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            $('#chatMessageForm').submit();
        }
    });
    
    // Auto-refresh chat every 30 seconds
    setInterval(function() {
        if (!isLoading && currentChatId) {
            loadChat();
        }
    }, 30000);
});
</script>
@endsection