@extends('customer.layout.layout')

@section('title', 'Chat with Admin')

@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/styles.css') }}" />
<style>
    :root {
        --primary: #f97316;
        --primary-dark: #ea580c;
        --soft-sand: #f5e9da;
        --soft-sand-dark: #e8d4c0;
        --muted: #6c757d;
        --surface: #ffffff;
        --shell-bg: #f8f8fb;
        --border: rgba(148, 163, 184, 0.2);
    }

    body,
    .app-content {
        background: var(--shell-bg);
    }

    .customer-chat-page {
        width: 100%;
        padding: 2.5rem 1.4rem 3.5rem;
    }

    .customer-chat-shell {
        max-width: 960px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .chat-hero {
        position: relative;
        overflow: hidden;
        padding: 2.2rem 2.6rem;
        border-radius: 32px;
        border: 1px solid rgba(249, 115, 22, 0.18);
        background: linear-gradient(135deg, rgba(249, 115, 22, 0.12), rgba(234, 88, 12, 0.18));
        box-shadow: 0 26px 58px rgba(249, 115, 22, 0.18);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1.6rem;
    }

    .chat-hero::before,
    .chat-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .chat-hero::before {
        width: 340px;
        height: 340px;
        top: -45%;
        right: -12%;
        background: rgba(249, 115, 22, 0.2);
    }

    .chat-hero::after {
        width: 240px;
        height: 240px;
        bottom: -50%;
        left: -18%;
        background: rgba(234, 88, 12, 0.22);
    }

    .chat-hero > * { position: relative; z-index: 1; }

    .hero-copy {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        color: #4a2f19;
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.45rem 1.05rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        background: rgba(255, 255, 255, 0.52);
        border: 1px solid rgba(255, 255, 255, 0.58);
    }

    .hero-copy h1 {
        margin: 0;
        font-size: 2.1rem;
        font-weight: 700;
    }

    .hero-copy p {
        margin: 0;
        font-size: 0.98rem;
        max-width: 420px;
        color: rgba(74, 47, 25, 0.8);
    }

    .chat-hero-illustration {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.65);
        border: 1px solid rgba(255, 255, 255, 0.7);
        box-shadow: inset 0 14px 32px rgba(255, 255, 255, 0.4);
        color: rgba(74, 47, 25, 0.75);
        font-size: 3rem;
    }

    .chat-card {
        background: var(--surface);
        border-radius: 28px;
        border: 1px solid var(--border);
        box-shadow: 0 24px 52px rgba(15, 23, 42, 0.12);
        overflow: hidden;
    }

    .chat-card__header {
        padding: 1.9rem 2.2rem 1.4rem;
        border-bottom: 1px solid var(--border);
        background: rgba(245, 233, 218, 0.4);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1.2rem;
    }

    .chat-card__header h2 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: #4a2f19;
    }

    .chat-status-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.45rem 1.05rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        background: rgba(76, 175, 80, 0.18);
        color: #166534;
    }

    .chat-card__body {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .chat-messages {
        height: 520px;
        overflow-y: auto;
        background: linear-gradient(180deg, #fefefe 0%, #f8f9fb 100%);
        padding: 1.9rem 2.2rem;
        scroll-behavior: smooth;
    }

    .chat-messages::-webkit-scrollbar {
        width: 10px;
    }

    .chat-messages::-webkit-scrollbar-track {
        background: rgba(241, 245, 249, 0.8);
    }

    .chat-messages::-webkit-scrollbar-thumb {
        background: rgba(209, 213, 219, 0.8);
        border-radius: 999px;
    }

    .chat-footer {
        padding: 1.8rem 2.2rem 2.2rem;
        background: rgba(248, 248, 251, 0.85);
        border-top: 1px solid var(--border);
    }

    .message-bubble {
        max-width: 74%;
        padding: 0.85rem 1.1rem;
        border-radius: 1.2rem;
        margin-bottom: 1.1rem;
        word-wrap: break-word;
        box-shadow: 0 12px 22px rgba(15, 23, 42, 0.08);
        font-size: 0.95rem;
    }

    .message-customer {
        background: var(--soft-sand);
        color: #6d421e;
        margin-left: auto;
        border-bottom-right-radius: 0.35rem;
        border: 1px solid var(--soft-sand-dark);
    }

    .message-admin {
        background: #ffffff;
        color: #1f2937;
        margin-right: auto;
        border: 1px solid rgba(229, 231, 235, 0.92);
        border-bottom-left-radius: 0.35rem;
    }

    .message-time {
        font-size: 0.74rem;
        opacity: 0.7;
        margin-top: 0.35rem;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .message-time::before {
        content: "\f017";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        font-size: 0.7rem;
        opacity: 0.5;
    }

    .attachment-item {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        background: rgba(245, 233, 218, 0.65);
        padding: 0.35rem 0.75rem;
        border-radius: 0.65rem;
        margin: 0.35rem 0.35rem 0 0;
        color: #6d421e;
        text-decoration: none;
        font-size: 0.86rem;
        font-weight: 600;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .attachment-item:hover { background: rgba(245, 233, 218, 0.9); color: #6d421e; }

    .message-admin .attachment-item {
        background: rgba(248, 249, 250, 0.9);
        color: #1f2937;
    }

    .message-admin .attachment-item:hover {
        background: rgba(229, 231, 235, 0.9);
        color: #111827;
    }

    .chat-input-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.3rem;
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 18px 34px rgba(15, 23, 42, 0.12);
        border: 1px solid rgba(226, 232, 240, 0.8);
    }

    .chat-input-group .form-control {
        flex: 1;
        border: none;
        padding: 0.9rem 1.1rem;
        font-size: 0.96rem;
        border-radius: 16px;
        background: transparent;
        color: #1f2937;
    }

    .chat-input-group .form-control::placeholder { color: rgba(107, 114, 128, 0.9); }
    .chat-input-group .form-control:focus { box-shadow: none; }

    .chat-attach-btn,
    .chat-send-btn {
        border: none;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.1rem;
        font-size: 1.15rem;
        cursor: pointer;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
        background: transparent;
    }

    .chat-attach-btn { color: rgba(107, 114, 128, 0.9); }
    .chat-attach-btn:hover { color: rgba(55, 65, 81, 0.95); transform: translateY(-1px); }

    .chat-send-btn {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffffff;
        min-width: 56px;
        min-height: 48px;
        box-shadow: 0 18px 36px rgba(249, 115, 22, 0.22);
    }

    .chat-send-btn:hover { transform: translateY(-1px); }

    .chat-send-btn svg {
        width: 22px;
        height: 22px;
        fill: currentColor;
    }

    .selected-files {
        background: rgba(248, 250, 252, 0.9);
        border-radius: 14px;
        padding: 0.8rem 1rem;
        margin-top: 0.8rem;
        font-size: 0.88rem;
        border: 1px dashed rgba(209, 213, 219, 0.9);
    }

    .selected-files .file-entry {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.4rem 0;
        color: #1f2937;
    }

    .selected-files .file-entry i { color: rgba(107, 114, 128, 0.9); }
    .selected-files .file-entry small { color: rgba(107, 114, 128, 0.7); }

    .empty-state {
        text-align: center;
        color: var(--muted);
        padding: 4rem 1.4rem;
    }

    .empty-state i {
        font-size: 3.2rem;
        margin-bottom: 1.1rem;
        opacity: 0.45;
    }

    .empty-state h5 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #374151;
    }

    @media (max-width: 768px) {
        .customer-chat-page { padding: 2.2rem 1rem 3.1rem; }
        .chat-hero { padding: 1.8rem 1.6rem; }
        .chat-card__header { padding: 1.6rem 1.6rem 1.2rem; }
        .chat-messages { padding: 1.5rem 1.6rem; }
        .chat-footer { padding: 1.6rem 1.6rem 1.8rem; }
        .message-bubble { max-width: 86%; }
        .chat-hero-illustration { width: 100px; height: 100px; font-size: 2.2rem; }
    }
</style>
@endsection

@section('content')
<div class="customer-chat-page">
    <div class="customer-chat-shell">
        <section class="chat-hero">
            <div class="hero-copy">
                <span class="hero-eyebrow"><i class="ri-customer-service-2-line"></i>Support</span>
                <h1>Chat with Admin</h1>
                <p>We're here to help with bookings, services, and anything else you need. Send a message and the support team will respond shortly.</p>
            </div>
            <div class="chat-hero-illustration">
                <i class="ri-chat-3-line"></i>
            </div>
        </section>

        <section class="chat-card">
            <header class="chat-card__header">
                <h2>Support Conversation</h2>
                <span class="chat-status-chip"><i class="ri-shield-check-line"></i>Secure & Private</span>
            </header>
            <div class="chat-card__body">
                <div id="chatMessages" class="chat-messages">
                    <div class="empty-state">
                        <i class="ri-message-3-line"></i>
                        <h5>Start a conversation</h5>
                        <p>Send a message to our admin team and we'll get back to you shortly.</p>
                    </div>
                </div>
                <footer class="chat-footer">
                    <form id="chatForm" enctype="multipart/form-data">
                        <div class="chat-input-group">
                            <input type="text" class="form-control" id="messageInput" name="message" placeholder="Type your message..." required>
                            <input type="file" class="d-none" id="attachmentInput" name="attachments[]" multiple accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt,.zip">
                            <button type="button" class="chat-attach-btn" id="attachBtn" title="Attach files">
                                <i class="ri-attachment-2"></i>
                            </button>
                            <button type="submit" class="chat-send-btn" id="sendBtn" aria-label="Send message">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M3.4 20.6c-.3.3-.3.8 0 1.1.3.3.7.3 1 .1l16.9-9.7c.3-.2.4-.5.3-.9a.8.8 0 0 0-.4-.5L4.4 1.7c-.3-.2-.7-.2-1 .1-.3.3-.4.7-.2 1.1l2.5 6.3c.1.3.4.4.7.4l7.3-.7-6.8 3.4c-.3.2-.4.5-.4.8l.2 7.4c0 .4.3.7.7.8h.1c.2 0 .3 0 .5-.2l4.8-5.2-6.6 4.5c-.3.2-.4.6-.2 1l2.4 4.6c.2.3.5.5.9.4.3 0 .6-.3.7-.6l2.1-7.4-7.4 2.1c-.3.1-.6 0-.8-.2l-2.4-2.4z" />
                                </svg>
                            </button>
                        </div>
                        <div id="selectedFiles" class="selected-files" style="display: none;"></div>
                    </form>
                </footer>
            </div>
        </section>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let currentChatId = null;
    let messagePollingInterval = null;
    initializeChat();

    function initializeChat() {
        $.ajax({
            url: '{{ route("user.admin-chat.get-or-create") }}',
            method: 'POST',
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                if (response.success) {
                    currentChatId = response.chat.id;
                    loadMessages();
                    startMessagePolling();
                } else {
                    showError('Failed to initialize chat');
                }
            },
            error: function() { showError('Failed to initialize chat'); }
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
            error: function() { console.error('Failed to load messages'); }
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
        container.scrollTop(container[0].scrollHeight);
    }

    // Phone number detection utility
    function detectPersonalInfo(text) {
        // Comprehensive phone number patterns
        const phonePatterns = [
            // Indian numbers with country code: +91, 0091, 91
            /(\+91|0091|91)[\s\-]?[6-9]\d{9}/g,
            // Indian numbers without country code: 10 digits starting with 6-9
            /(?<!\d)[6-9]\d{9}(?!\d)/g,
            // International formats with common separators
            /(\+\d{1,3})?[\s\-\.]?\(?\d{1,4}\)?[\s\-\.]?\d{1,4}[\s\-\.]?\d{1,4}[\s\-\.]?\d{1,9}/g,
            // Numbers with brackets, dashes, dots, spaces (10+ digits)
            /\(?\d{3,4}\)?[\s\-\.]?\d{3,4}[\s\-\.]?\d{3,6}/g,
            // WhatsApp pattern: "whatsapp me" followed by number
            /whatsapp\s*(me|at|on)?\s*[\+\d\s\-\(\)\.]{8,}/gi,
            // Call me pattern
            /call\s*(me\s*)?(?:at|on)?\s*[\+\d\s\-\(\)\.]{8,}/gi,
            // Phone/mobile pattern
            /(phone|mobile|contact|number)\s*[:=]?\s*[\+\d\s\-\(\)\.]{8,}/gi,
        ];

        // Additional personal info patterns
        const emailPattern = /\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b/g;
        const socialMediaPatterns = [
            /(?:instagram|insta)\s*[:@]?\s*[A-Za-z0-9._]+/gi,
            /(?:facebook|fb)\s*[:@]?\s*[A-Za-z0-9._]+/gi,
            /(?:twitter|x\.com)\s*[:@]?\s*[A-Za-z0-9._]+/gi,
            /(?:telegram|tg)\s*[:@]?\s*[A-Za-z0-9._]+/gi,
        ];

        // Check for phone numbers
        for (const pattern of phonePatterns) {
            if (pattern.test(text)) {
                return { 
                    detected: true, 
                    type: 'phone number', 
                    message: 'Phone numbers are not allowed in messages. Please use the platform\'s communication features only.' 
                };
            }
        }

        // Check for emails
        if (emailPattern.test(text)) {
            return { 
                detected: true, 
                type: 'email address', 
                message: 'Email addresses are not allowed in messages. Please use the platform\'s communication features only.' 
            };
        }

        // Check for social media
        for (const pattern of socialMediaPatterns) {
            if (pattern.test(text)) {
                return { 
                    detected: true, 
                    type: 'social media handle', 
                    message: 'Social media handles are not allowed in messages. Please use the platform\'s communication features only.' 
                };
            }
        }

        return { detected: false };
    }

    // Show notification for blocked content
    function showPersonalInfoAlert(type, message) {
        // Remove any existing alerts
        $('.personal-info-alert').remove();
        
        const alertHtml = `
            <div class="personal-info-alert" style="
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 10000;
                max-width: 400px;
                background: #fff3cd;
                border: 1px solid #ffeaa7;
                border-left: 4px solid #f39c12;
                border-radius: 8px;
                padding: 15px 20px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                animation: slideInRight 0.3s ease;
            ">
                <div style="display: flex; align-items: flex-start; gap: 10px;">
                    <i class="fas fa-exclamation-triangle" style="color: #f39c12; font-size: 18px; margin-top: 2px;"></i>
                    <div>
                        <strong style="color: #856404; font-size: 14px;">Personal Information Detected</strong>
                        <p style="margin: 5px 0 0 0; color: #856404; font-size: 13px; line-height: 1.4;">${message}</p>
                    </div>
                    <button onclick="$(this).closest('.personal-info-alert').fadeOut(300)" style="
                        background: none;
                        border: none;
                        color: #856404;
                        font-size: 16px;
                        cursor: pointer;
                        padding: 0;
                        margin-left: auto;
                    ">&times;</button>
                </div>
            </div>
            <style>
                @keyframes slideInRight {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
            </style>
        `;
        
        $('body').append(alertHtml);
        
        // Auto-remove after 6 seconds
        setTimeout(() => {
            $('.personal-info-alert').fadeOut(300);
        }, 6000);
    }

    $('#chatForm').on('submit', function(e) {
        e.preventDefault();
        const message = $('#messageInput').val().trim();
        if (!message) return;

        // Check for personal information
        const personalInfoCheck = detectPersonalInfo(message);
        if (personalInfoCheck.detected) {
            showPersonalInfoAlert(personalInfoCheck.type, personalInfoCheck.message);
            return; // Block the message from being sent
        }

        const sendBtn = $('#sendBtn');
        const originalContent = sendBtn.html();
        sendBtn.prop('disabled', true).html('<i class="ri-loader-4-line fa-spin"></i>');

        const formData = new FormData();
        formData.append('message', message);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
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
            error: function(xhr) { 
                // Check if the error is due to personal information detection
                if (xhr.status === 422 && xhr.responseJSON) {
                    const response = xhr.responseJSON;
                    if (response.type && response.message) {
                        showPersonalInfoAlert(response.type, response.message);
                    } else {
                        showError('Failed to send message');
                    }
                } else {
                    showError('Failed to send message');
                }
            },
            complete: function() { sendBtn.prop('disabled', false).html(originalContent); }
        });
    });

    $('#attachBtn').on('click', function() { $('#attachmentInput').click(); });

    $('#attachmentInput').on('change', function() {
        const files = this.files;
        const container = $('#selectedFiles');
        container.empty();
        if (files.length > 0) {
            container.show();
            container.append('<div class="fw-bold mb-2">Selected files:</div>');
            for (let i = 0; i < files.length; i++) {
                container.append(`
                    <div class="file-entry">
                        <i class="ri-file-line"></i>
                        <span>${files[i].name}</span>
                        <small>(${formatFileSize(files[i].size)})</small>
                    </div>
                `);
            }
        } else {
            container.hide();
        }
    });

    $('#messageInput').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#chatForm').submit();
        }
    });

    function startMessagePolling() {
        messagePollingInterval = setInterval(function() { loadMessages(); }, 5000);
    }

    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            if (messagePollingInterval) clearInterval(messagePollingInterval);
        } else {
            startMessagePolling();
        }
    });

    $(window).on('beforeunload', function() {
        if (messagePollingInterval) clearInterval(messagePollingInterval);
    });

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
            return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        } else if (diffDays === 1) {
            return 'Yesterday ' + date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }
        return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
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