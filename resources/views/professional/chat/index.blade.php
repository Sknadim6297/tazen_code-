@extends('professional.layout.layout')

@section('styles')
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --secondary: #0ea5e9;
        --muted: #64748b;
        --page-bg: #f4f6fb;
        --card-bg: #ffffff;
        --border: rgba(148, 163, 184, 0.22);
    }

    body,
    .app-content {
        background: var(--page-bg);
    }

    .chat-page {
        width: 100%;
        padding: 2.6rem 1.45rem 3.6rem;
    }

    .chat-shell {
        max-width: 1040px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .chat-hero {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1.2rem;
        padding: 2rem 2.3rem;
        border-radius: 26px;
        border: 1px solid rgba(79, 70, 229, 0.18);
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(14, 165, 233, 0.16));
        position: relative;
        overflow: hidden;
        box-shadow: 0 24px 48px rgba(79, 70, 229, 0.16);
    }

    .chat-hero::before,
    .chat-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .chat-hero::before {
        width: 320px;
        height: 320px;
        top: -45%;
        right: -12%;
        background: rgba(79, 70, 229, 0.2);
    }

    .chat-hero::after {
        width: 220px;
        height: 220px;
        bottom: -40%;
        left: -10%;
        background: rgba(59, 130, 246, 0.18);
    }

    .chat-hero > * { position: relative; z-index: 1; }

    .hero-meta {
        display: flex;
        flex-direction: column;
        gap: 0.72rem;
        color: var(--muted);
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.35rem 1.05rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.42);
        border: 1px solid rgba(255, 255, 255, 0.55);
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #0f172a;
    }

    .hero-meta h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
    }

    .hero-breadcrumb {
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
        font-size: 0.86rem;
        color: var(--muted);
    }

    .hero-breadcrumb li a {
        color: var(--primary);
        text-decoration: none;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.48rem 1.2rem;
        border-radius: 999px;
        background: rgba(34, 197, 94, 0.18);
        border: 1px solid rgba(34, 197, 94, 0.28);
        font-size: 0.82rem;
        font-weight: 600;
        color: #166534;
    }

    .chat-card {
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: 0 22px 52px rgba(15, 23, 42, 0.14);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .chat-card__head {
        padding: 1.7rem 2.1rem 1.2rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.22);
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .chat-card__head h2 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
    }

    .chat-card__head p {
        margin: 0;
        color: var(--muted);
        font-size: 0.9rem;
    }

    .chat-card__body {
        display: flex;
        flex-direction: column;
        height: 560px;
        background: #f8fafc;
    }

    .chat-messages-wrapper {
        flex: 1;
        padding: 1.6rem 1.9rem;
        overflow: hidden;
    }

    #chatMessages {
        height: 100%;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
        padding-right: 0.4rem;
    }

    #chatMessages::-webkit-scrollbar { width: 6px; }
    #chatMessages::-webkit-scrollbar-track { background: rgba(226, 232, 240, 0.6); border-radius: 3px; }
    #chatMessages::-webkit-scrollbar-thumb { background: rgba(79, 70, 229, 0.32); border-radius: 3px; }
    #chatMessages::-webkit-scrollbar-thumb:hover { background: rgba(79, 70, 229, 0.48); }

    .chat-empty-state,
    .loading-spinner {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        gap: 0.8rem;
        color: var(--muted);
    }

    .chat-empty-state i {
        font-size: 3rem;
        color: var(--primary);
        opacity: 0.6;
    }

    .message-row {
        display: flex;
        align-items: flex-end;
        gap: 0.65rem;
    }

    .message-bubble {
        position: relative;
        border-radius: 18px !important;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12);
        padding: 0.85rem 1rem;
        max-width: 72%;
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        animation: fadeInUp 0.3s ease-out;
    }

    .message-bubble.bg-primary {
        background: linear-gradient(135deg, #22c55e, #16a34a) !important;
        margin-left: auto;
        color: #ffffff !important;
    }

    .message-bubble.bg-light {
        background: #ffffff !important;
        border: 1px solid rgba(148, 163, 184, 0.24);
        color: #0f172a !important;
        margin-right: auto;
    }

    .message-sender {
        font-size: 0.72rem;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        opacity: 0.8;
    }

    .message-bubble.bg-primary .message-sender { color: rgba(255,255,255,0.9); }
    .message-bubble.bg-light .message-sender { color: var(--muted); }

    .message-time {
        font-size: 0.7rem;
        opacity: 0.75;
    }

    .attachment-card a {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.45rem 0.75rem;
        border-radius: 10px;
        border: 1px solid rgba(148, 163, 184, 0.22);
        color: #0f172a;
        background: rgba(248, 250, 252, 0.9);
        font-size: 0.78rem;
        text-decoration: none;
    }

    .chat-input-area {
        padding: 1.4rem 1.9rem;
        border-top: 1px solid rgba(148, 163, 184, 0.18);
        background: var(--card-bg);
    }

    .chat-input-area .input-group {
        border-radius: 18px;
        border: 1px solid rgba(148, 163, 184, 0.28);
        background: rgba(248, 250, 252, 0.92);
        overflow: hidden;
        display: flex;
        align-items: center;
    }

    .form-control-lg {
        border: none;
        background: transparent;
        padding: 0.85rem 1rem;
        font-size: 0.95rem;
    }

    .form-control-lg:focus { box-shadow: none; background: transparent; }

    .btn-attach,
    .btn-send {
        border: none;
        width: 48px;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        cursor: pointer;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .btn-attach i,
    .btn-send i {
        font-size: 1.2rem;
        line-height: 1;
        pointer-events: none;
    }

    .btn-attach {
        color: #475569;
        background: rgba(148, 163, 184, 0.18);
        border-left: 1px solid rgba(148, 163, 184, 0.32);
    }

    .btn-attach:hover {
        color: #0f172a;
        background: rgba(148, 163, 184, 0.28);
        box-shadow: 0 10px 20px rgba(148, 163, 184, 0.28);
    }

    .btn-send {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffffff !important;
    }

    .btn-send:hover,
    .btn-attach:hover { transform: translateY(-1px); }

    .attachment-preview {
        border-radius: 14px;
        border: 1px dashed rgba(148, 163, 184, 0.35);
        background: rgba(226, 232, 240, 0.28);
        padding: 0.75rem 1rem;
        margin-top: 0.9rem;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .chat-page { padding: 2.2rem 1rem 3.2rem; }
        .chat-hero { padding: 1.75rem 1.6rem; }
        .chat-card__body { height: 520px; }
        .message-bubble { max-width: 82%; }
        .chat-input-area { padding: 1.2rem 1.3rem; }
        .chat-input-area .input-group { border-radius: 14px; }
    }
</style>
@endsection

@section('title', 'Chat with Admin')

@section('content')
<div class="chat-page">
    <div class="chat-shell">
        <section class="chat-hero">
            <div class="hero-meta">
                <span class="hero-eyebrow"><i class="ri-message-3-line"></i>Support</span>
                <h1>Chat with Admin</h1>
                <ul class="hero-breadcrumb">
                    <li><a href="{{ route('professional.dashboard') }}">Home</a></li>
                    <li class="active" aria-current="page">Chat</li>
                </ul>
            </div>
            <span class="status-pill" id="connectionStatus">
                <i class="ri-flashlight-line"></i>
                Connected
            </span>
        </section>

        <section class="chat-card">
            <header class="chat-card__head">
                <h2><i class="ri-chat-voice-line"></i>Conversation</h2>
                <p>Stay connected with the admin team for quick assistance.</p>
            </header>
            <div class="chat-card__body">
                <div class="chat-messages-wrapper">
                    <div id="chatMessages">
                        <div class="loading-spinner">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span class="mt-3">Loading chat...</span>
                        </div>
                    </div>
                </div>
                <div class="chat-input-area">
                    <form id="chatMessageForm" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="form-control form-control-lg" id="messageInput" name="message" placeholder="Type your message to admin..." autocomplete="off">
                            <input type="file" id="fileInput" name="attachment" style="display:none;" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt,.jpg,.jpeg,.png,.gif">
                            <button type="button" class="btn-attach" id="attachBtn" title="Attach File">
                                <i class="fas fa-paperclip" style="font-size:1.2rem; line-height:1; pointer-events:none;"></i>
                            </button>
                            <button type="submit" class="btn-send" id="sendBtn">
                                <i class="fas fa-paper-plane" style="font-size:1.1rem; line-height:1; pointer-events:none;"></i>
                            </button>
                        </div>
                        <div id="filePreview" class="attachment-preview" style="display:none;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ri-attachment-line"></i>
                                    <span id="fileName"></span>
                                    <span id="fileSize" class="text-muted"></span>
                                </div>
                                <button type="button" class="btn btn-sm btn-link text-danger p-0" id="removeFileBtn">
                                    <i class="ri-close-line"></i> Remove
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let currentChatId = null;
    let isLoading = false;
    loadChat();
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
            error: function() {
                showErrorState('Failed to load chat. Please refresh the page.');
                updateConnectionStatus(false);
            },
            complete: function() {
                isLoading = false;
            }
        });
    }
    function displayMessages(messages) {
        if (!messages || messages.length === 0) { showEmptyState(); return; }
        messages.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
        const html = messages.map(buildMessageHtml).join('');
        $('#chatMessages').html(html);
        scrollToBottom();
    }
    function buildMessageHtml(message) {
        const isProfessional = message.sender_type === 'App\\Models\\Professional';
        const bubbleClass = isProfessional ? 'message-bubble bg-primary text-white' : 'message-bubble bg-light';
        const alignClass = isProfessional ? 'text-end' : 'text-start';
        let attachmentHtml = '';
        if (message.attachments && message.attachments.length > 0) {
            message.attachments.forEach(function(attachment) {
                attachmentHtml += `
                    <div class="attachment-card">
                        <a href="/professional/admin-chat/attachment/${attachment.id}/download" target="_blank">
                            <i class="${attachment.file_icon || 'ri-attachment-line'}"></i>
                            ${attachment.original_name}
                            <small>(${attachment.human_file_size || 'N/A'})</small>
                        </a>
                    </div>`;
            });
        }
        return `
            <div class="message-row ${isProfessional ? 'justify-content-end' : 'justify-content-start'}">
                <div class="${bubbleClass}">
                    <div class="message-sender ${alignClass}">${isProfessional ? 'You' : (message.sender_name || 'Admin')}</div>
                    ${message.message ? `<div class="message-text">${escapeHtml(message.message)}</div>` : ''}
                    ${attachmentHtml}
                    <div class="message-time ${alignClass}">${formatDateTime(message.created_at)}</div>
                </div>
            </div>`;
    }
    $('#chatMessageForm').on('submit', function(e) {
        e.preventDefault();
        const message = $('#messageInput').val().trim();
        const hasFile = $('#fileInput')[0].files.length > 0;
        if (!message && !hasFile) { return; }
        const formData = new FormData(this);
        const sendBtn = $('#sendBtn');
        const originalBtnHtml = sendBtn.html();
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
                    $('#messageInput').val('');
                    clearFileSelection();
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
    function appendMessage(message) {
        const html = buildMessageHtml(message);
        if ($('#chatMessages').find('.chat-empty-state').length > 0) {
            $('#chatMessages').html(html);
        } else {
            $('#chatMessages').append(html);
        }
    }
    $('#attachBtn').on('click', function() { $('#fileInput').click(); });
    $('#fileInput').on('change', function() { const file = this.files[0]; if (file) showFilePreview(file); });
    $('#removeFileBtn').on('click', function() { clearFileSelection(); });
    function showFilePreview(file) {
        $('#fileName').text(file.name);
        $('#fileSize').text(`(${formatFileSize(file.size)})`);
        $('#filePreview').show();
    }
    function clearFileSelection() {
        $('#fileInput').val('');
        $('#filePreview').hide();
        $('#fileName').text('');
        $('#fileSize').text('');
    }
    function scrollToBottom() {
        const container = $('#chatMessages');
        container.scrollTop(container[0].scrollHeight);
    }
    function showLoadingState() {
        $('#chatMessages').html(`
            <div class="loading-spinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <span class="mt-3">Loading chat...</span>
            </div>`);
    }
    function showEmptyState() {
        $('#chatMessages').html(`
            <div class="chat-empty-state">
                <i class="ri-message-3-line"></i>
                <h5>No messages yet</h5>
                <p class="text-muted mb-0">Start a conversation with the admin team</p>
            </div>`);
    }
    function showErrorState(message) {
        $('#chatMessages').html(`
            <div class="chat-empty-state text-danger">
                <i class="ri-error-warning-line"></i>
                <h5>Error</h5>
                <p class="mb-0">${message}</p>
            </div>`);
    }
    function updateConnectionStatus(connected) {
        const statusEl = $('#connectionStatus');
        if (connected) {
            statusEl.removeClass('badge bg-danger').addClass('status-pill').html('<i class="ri-flashlight-line"></i> Connected');
        } else {
            statusEl.removeClass('status-pill').addClass('badge bg-danger').text('Disconnected');
        }
    }
    function formatDateTime(dateTime) {
        const date = new Date(dateTime);
        return date.toLocaleString('en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
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
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    $('#messageInput').focus();
    $('#messageInput').on('keypress', function(e) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            $('#chatMessageForm').submit();
        }
    });
    setInterval(function() {
        if (!isLoading && currentChatId) {
            loadChat();
        }
    }, 30000);
});
</script>
@endsection