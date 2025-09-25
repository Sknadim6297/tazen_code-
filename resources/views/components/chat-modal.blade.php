<!-- Chat Modal -->
<div id="chatModal" class="chat-modal" style="display: none;">
    <div class="chat-modal-content">
        <div class="chat-header">
            <div class="chat-participant-info">
                <div class="participant-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="participant-details">
                    <h4 id="participantName">Loading...</h4>
                    <span id="participantStatus" class="status-indicator">Checking status...</span>
                </div>
            </div>
            <div class="chat-controls">
                <button id="minimizeChat" class="btn-minimize" title="Minimize">
                    <i class="fas fa-minus"></i>
                </button>
                <button id="closeChat" class="btn-close" title="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <div class="chat-messages" id="chatMessages">
            <div class="loading-messages">
                <i class="fas fa-spinner fa-spin"></i>
                <span>Loading messages...</span>
            </div>
        </div>
        
        <div class="chat-input-container">
            <div class="chat-input-wrapper">
                <input type="file" id="chatFileInput" accept="image/*,.pdf,.doc,.docx" style="display: none;">
                <button id="attachFileBtn" class="btn-attach" title="Attach file">
                    <i class="fas fa-paperclip"></i>
                </button>
                <input type="text" id="chatMessageInput" placeholder="Type your message..." maxlength="1000">
                <button id="sendMessageBtn" class="btn-send" title="Send message">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Chat Button (floating) -->
<div id="chatFloatingBtn" class="chat-floating-btn" style="display: none;" title="Open Chat">
    <i class="fas fa-comments"></i>
    <span id="chatUnreadBadge" class="unread-badge" style="display: none;">0</span>
</div>

<style>
.chat-modal {
    position: fixed;
    bottom: 0;
    right: 20px;
    width: 380px;
    height: 500px;
    background: #fff;
    border-radius: 12px 12px 0 0;
    box-shadow: 0 -5px 25px rgba(0,0,0,0.2);
    z-index: 9999;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
}

.chat-modal.minimized {
    height: 60px;
}

.chat-modal-content {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.chat-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 15px 20px;
    border-radius: 12px 12px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.chat-participant-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.participant-avatar {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.participant-details h4 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}

.status-indicator {
    font-size: 12px;
    opacity: 0.9;
    display: flex;
    align-items: center;
    gap: 5px;
}

.status-indicator.online:before {
    content: '';
    width: 8px;
    height: 8px;
    background: #4CAF50;
    border-radius: 50%;
    display: inline-block;
}

.status-indicator.offline:before {
    content: '';
    width: 8px;
    height: 8px;
    background: #757575;
    border-radius: 50%;
    display: inline-block;
}

.chat-controls {
    display: flex;
    gap: 8px;
}

.btn-minimize, .btn-close {
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
}

.btn-minimize:hover, .btn-close:hover {
    background: rgba(255,255,255,0.3);
}

.chat-messages {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    background: #f8f9fa;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.loading-messages {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 10px;
    color: #666;
    height: 100%;
}

.message {
    max-width: 80%;
    word-wrap: break-word;
    padding: 12px 16px;
    border-radius: 18px;
    position: relative;
    line-height: 1.4;
}

.message.sent {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    align-self: flex-end;
    margin-left: auto;
}

.message.received {
    background: white;
    color: #333;
    border: 1px solid #e1e5e9;
    align-self: flex-start;
}

.message-time {
    font-size: 11px;
    opacity: 0.7;
    margin-top: 4px;
    text-align: right;
}

.message.received .message-time {
    text-align: left;
}

.chat-input-container {
    padding: 20px;
    background: white;
    border-top: 1px solid #e1e5e9;
}

.chat-input-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8f9fa;
    border-radius: 25px;
    padding: 8px 12px;
    border: 1px solid #e1e5e9;
    transition: border-color 0.2s;
}

.chat-input-wrapper:focus-within {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn-attach {
    background: none;
    border: none;
    color: #666;
    cursor: pointer;
    padding: 6px;
    border-radius: 50%;
    transition: background 0.2s;
}

.btn-attach:hover {
    background: #e9ecef;
    color: #667eea;
}

#chatMessageInput {
    flex: 1;
    border: none;
    background: none;
    padding: 8px 12px;
    font-size: 14px;
    outline: none;
    resize: none;
}

.btn-send {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s;
}

.btn-send:hover {
    transform: scale(1.05);
}

.btn-send:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

.chat-floating-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
    z-index: 9998;
    transition: all 0.3s ease;
    font-size: 24px;
}

.chat-floating-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 25px rgba(102, 126, 234, 0.5);
}

.unread-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff4757;
    color: white;
    border-radius: 50%;
    width: 22px;
    height: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: bold;
    border: 2px solid white;
}

.file-attachment {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(102, 126, 234, 0.1);
    padding: 8px 12px;
    border-radius: 8px;
    margin-top: 4px;
}

.file-attachment i {
    color: #667eea;
}

.file-attachment a {
    color: #667eea;
    text-decoration: none;
    font-size: 13px;
}

.file-attachment a:hover {
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 768px) {
    .chat-modal {
        width: 100%;
        right: 0;
        height: 100vh;
        border-radius: 0;
    }
    
    .chat-floating-btn {
        bottom: 15px;
        right: 15px;
        width: 50px;
        height: 50px;
        font-size: 20px;
    }
}

/* Animation for new messages */
@keyframes slideInRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes slideInLeft {
    from { transform: translateX(-100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

.message.sent {
    animation: slideInRight 0.3s ease;
}

.message.received {
    animation: slideInLeft 0.3s ease;
}

/* Scrollbar styling */
.chat-messages::-webkit-scrollbar {
    width: 6px;
}

.chat-messages::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.chat-messages::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.chat-messages::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>