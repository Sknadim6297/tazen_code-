{{-- Chat Modal Component --}}
<div id="chatModal" class="chat-modal" style="display: none;">
    <div class="chat-modal-overlay"></div>
    <div class="chat-modal-container">
        <div class="chat-modal-header">
            <div class="chat-modal-title">
                <i class="fas fa-comments"></i>
                <span id="chatModalTitle">Chat</span>
            </div>
            <button class="chat-modal-close" onclick="closeChatModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="chat-modal-body">
            <div id="chatMessagesContainer" class="chat-messages">
                {{-- Messages will be loaded here dynamically --}}
            </div>
        </div>
        <div class="chat-modal-footer">
            <form id="chatMessageForm" class="chat-message-form">
                @csrf
                <input type="hidden" id="chatParticipantType" name="participant_type">
                <input type="hidden" id="chatParticipantId" name="participant_id">
                
                <div class="chat-input-container">
                    <textarea 
                        id="chatMessageInput" 
                        class="chat-message-input" 
                        placeholder="Type your message..." 
                        rows="1"
                    ></textarea>
                    <button type="submit" class="chat-send-btn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .chat-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
    }

    .chat-modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(3px);
    }

    .chat-modal-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90%;
        max-width: 600px;
        height: 80vh;
        max-height: 700px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .chat-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .chat-modal-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
        font-weight: 600;
    }

    .chat-modal-title i {
        font-size: 20px;
    }

    .chat-modal-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .chat-modal-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    .chat-modal-body {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        background: #f8f9fa;
    }

    .chat-messages {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .chat-message {
        display: flex;
        gap: 10px;
        animation: fadeInUp 0.3s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .chat-message.sent {
        flex-direction: row-reverse;
    }

    .chat-message-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        flex-shrink: 0;
    }

    .chat-message-content {
        max-width: 70%;
    }

    .chat-message-bubble {
        padding: 12px 16px;
        border-radius: 18px;
        background: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        word-wrap: break-word;
    }

    .chat-message.sent .chat-message-bubble {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .chat-message-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 4px;
        font-size: 12px;
        color: #6c757d;
    }

    .chat-message.sent .chat-message-meta {
        justify-content: flex-end;
    }

    .chat-modal-footer {
        padding: 20px;
        background: white;
        border-top: 1px solid #e9ecef;
    }

    .chat-message-form {
        width: 100%;
    }

    .chat-input-container {
        display: flex;
        gap: 10px;
        align-items: flex-end;
    }

    .chat-message-input {
        flex: 1;
        padding: 12px 16px;
        border: 2px solid #e9ecef;
        border-radius: 24px;
        font-size: 14px;
        resize: none;
        max-height: 120px;
        transition: border-color 0.3s ease;
    }

    .chat-message-input:focus {
        outline: none;
        border-color: #667eea;
    }

    .chat-send-btn {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .chat-send-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .chat-send-btn:active {
        transform: scale(0.95);
    }

    .chat-loading {
        text-align: center;
        padding: 40px;
        color: #6c757d;
    }

    .chat-loading i {
        font-size: 32px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    .chat-empty {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }

    .chat-empty i {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .chat-empty p {
        font-size: 16px;
        margin: 0;
    }

    /* Scrollbar styling */
    .chat-modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .chat-modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .chat-modal-body::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    .chat-modal-body::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .chat-modal-container {
            width: 100%;
            height: 100%;
            max-width: none;
            max-height: none;
            border-radius: 0;
        }

        .chat-message-content {
            max-width: 80%;
        }
    }
</style>

<script>
    function closeChatModal() {
        document.getElementById('chatModal').style.display = 'none';
    }

    // Close modal when clicking overlay
    document.addEventListener('DOMContentLoaded', function() {
        const overlay = document.querySelector('.chat-modal-overlay');
        if (overlay) {
            overlay.addEventListener('click', closeChatModal);
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeChatModal();
            }
        });
    });
</script>
