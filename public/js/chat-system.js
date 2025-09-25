/**
 * Chat System JavaScript
 * Handles real-time chat functionality with WebSocket-like polling
 */

class ChatSystem {
    constructor() {
        this.currentChatId = null;
        this.currentParticipant = null;
        this.isMinimized = false;
        this.pollInterval = null;
        this.activityInterval = null;
        this.lastMessageId = 0;
        this.isTyping = false;
        
        this.init();
    }

    getRoutePrefix() {
        const userType = document.querySelector('meta[name="user-type"]')?.getAttribute('content');
        
        switch(userType) {
            case 'admin':
                return '/admin';
            case 'professional':
                return '/professional';
            case 'user':
                return '/user';
            default:
                // If no user-type meta tag is found, assume it's a user page
                return '/user';
        }
    }

    init() {
        this.bindEvents();
        this.startActivityTracking();
        this.checkUnreadMessages();
        
        // Check for unread messages every 30 seconds
        setInterval(() => {
            this.checkUnreadMessages();
        }, 30000);
    }

    bindEvents() {
        // Open chat modal
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('chat-btn')) {
                const participantType = e.target.dataset.participantType;
                const participantId = e.target.dataset.participantId;
                this.openChat(participantType, participantId);
            }
        });

        // Floating chat button
        const floatingBtn = document.getElementById('chatFloatingBtn');
        if (floatingBtn) {
            floatingBtn.addEventListener('click', () => {
                this.showChatModal();
            });
        }

        // Close chat
        const closeBtn = document.getElementById('closeChat');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                this.closeChat();
            });
        }

        // Minimize chat
        const minimizeBtn = document.getElementById('minimizeChat');
        if (minimizeBtn) {
            minimizeBtn.addEventListener('click', () => {
                this.toggleMinimize();
            });
        }

        // Send message
        const sendBtn = document.getElementById('sendMessageBtn');
        const messageInput = document.getElementById('chatMessageInput');
        
        if (sendBtn) {
            sendBtn.addEventListener('click', () => {
                this.sendMessage();
            });
        }

        if (messageInput) {
            messageInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    this.sendMessage();
                }
            });

            // Show typing indicator
            messageInput.addEventListener('input', () => {
                this.handleTyping();
            });
        }

        // File attachment
        const attachBtn = document.getElementById('attachFileBtn');
        const fileInput = document.getElementById('chatFileInput');
        
        if (attachBtn && fileInput) {
            attachBtn.addEventListener('click', () => {
                fileInput.click();
            });

            fileInput.addEventListener('change', (e) => {
                if (e.target.files.length > 0) {
                    this.sendFile(e.target.files[0]);
                }
            });
        }
    }

    async openChat(participantType, participantId) {
        try {
            const routePrefix = this.getRoutePrefix();
            
            const response = await fetch(`${routePrefix}/chat/initialize`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    participant_type: participantType,
                    participant_id: participantId
                })
            });
            
            if (response.ok) {
                const data = await response.json();
                this.currentChatId = data.chat_id;
                this.currentParticipant = data.participant;
                
                this.showChatModal();
                this.updateParticipantInfo();
                this.loadMessages();
                this.startPolling();
            } else {
                const text = await response.text();
                console.error('Error response:', text);
                this.showError('Failed to initialize chat: ' + response.status);
            }
        } catch (error) {
            console.error('Chat initialization error:', error);
            this.showError('Connection error. Please try again.');
        }
    }

    showChatModal() {
        const modal = document.getElementById('chatModal');
        const floatingBtn = document.getElementById('chatFloatingBtn');
        
        if (modal) {
            modal.style.display = 'block';
            if (floatingBtn) {
                floatingBtn.style.display = 'none';
            }
        }
    }

    closeChat() {
        const modal = document.getElementById('chatModal');
        const floatingBtn = document.getElementById('chatFloatingBtn');
        
        if (modal) {
            modal.style.display = 'none';
        }
        
        if (floatingBtn) {
            floatingBtn.style.display = 'block';
        }

        this.stopPolling();
        this.currentChatId = null;
        this.currentParticipant = null;
        this.isMinimized = false;
    }

    toggleMinimize() {
        const modal = document.getElementById('chatModal');
        if (modal) {
            this.isMinimized = !this.isMinimized;
            modal.classList.toggle('minimized', this.isMinimized);
        }
    }

    updateParticipantInfo() {
        if (!this.currentParticipant) return;

        const nameEl = document.getElementById('participantName');
        const statusEl = document.getElementById('participantStatus');

        if (nameEl) {
            nameEl.textContent = this.currentParticipant.name;
        }

        if (statusEl) {
            statusEl.textContent = this.currentParticipant.is_online ? 'Online' : this.currentParticipant.last_seen;
            statusEl.className = 'status-indicator ' + (this.currentParticipant.is_online ? 'online' : 'offline');
        }
    }

    async loadMessages() {
        if (!this.currentChatId) return;

        try {
            const routePrefix = this.getRoutePrefix();
            const response = await fetch(`${routePrefix}/chat/${this.currentChatId}/messages`);
            if (response.ok) {
                const data = await response.json();
                this.displayMessages(data.messages);
            }
        } catch (error) {
            console.error('Error loading messages:', error);
        }
    }

    displayMessages(messages) {
        const container = document.getElementById('chatMessages');
        if (!container) return;

        container.innerHTML = '';

        messages.forEach(message => {
            this.appendMessage(message);
        });

        this.scrollToBottom();
        
        if (messages.length > 0) {
            this.lastMessageId = messages[messages.length - 1].id;
        }
    }

    appendMessage(message) {
        const container = document.getElementById('chatMessages');
        if (!container) return;

        const messageEl = document.createElement('div');
        messageEl.className = `message ${this.isMyMessage(message) ? 'sent' : 'received'}`;
        
        let content = `<div class="message-text">${this.escapeHtml(message.message)}</div>`;
        
        if (message.file_path) {
            content += `<div class="file-attachment">
                <i class="fas fa-${this.getFileIcon(message.message_type)}"></i>
                <a href="/storage/${message.file_path}" target="_blank" download>
                    ${message.message_type === 'image' ? 'View Image' : 'Download File'}
                </a>
            </div>`;
        }
        
        content += `<div class="message-time">${message.formatted_time}</div>`;
        
        messageEl.innerHTML = content;
        container.appendChild(messageEl);
        
        this.scrollToBottom();
    }

    async sendMessage() {
        const input = document.getElementById('chatMessageInput');
        const sendBtn = document.getElementById('sendMessageBtn');
        
        if (!input || !this.currentChatId) return;

        const message = input.value.trim();
        if (!message) return;

        try {
            sendBtn.disabled = true;
            
            const routePrefix = this.getRoutePrefix();
            const response = await fetch(`${routePrefix}/chat/${this.currentChatId}/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message })
            });

            if (response.ok) {
                const data = await response.json();
                this.appendMessage(data.message);
                input.value = '';
                this.lastMessageId = data.message.id;
            } else {
                this.showError('Failed to send message');
            }
        } catch (error) {
            console.error('Error sending message:', error);
            this.showError('Connection error. Please try again.');
        } finally {
            sendBtn.disabled = false;
        }
    }

    async sendFile(file) {
        if (!this.currentChatId) return;

        const formData = new FormData();
        formData.append('file', file);
        formData.append('message_type', file.type.startsWith('image/') ? 'image' : 'file');

        try {
            const routePrefix = this.getRoutePrefix();
            const response = await fetch(`${routePrefix}/chat/${this.currentChatId}/send`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            if (response.ok) {
                const data = await response.json();
                this.appendMessage(data.message);
                this.lastMessageId = data.message.id;
                
                // Clear file input
                document.getElementById('chatFileInput').value = '';
            } else {
                this.showError('Failed to send file');
            }
        } catch (error) {
            console.error('Error sending file:', error);
            this.showError('Connection error. Please try again.');
        }
    }

    startPolling() {
        if (this.pollInterval) return;

        this.pollInterval = setInterval(async () => {
            await this.checkForNewMessages();
        }, 3000); // Poll every 3 seconds
    }

    stopPolling() {
        if (this.pollInterval) {
            clearInterval(this.pollInterval);
            this.pollInterval = null;
        }
    }

    async checkForNewMessages() {
        if (!this.currentChatId) return;

        try {
            const routePrefix = this.getRoutePrefix();
            const response = await fetch(`${routePrefix}/chat/${this.currentChatId}/messages`);
            if (response.ok) {
                const data = await response.json();
                const newMessages = data.messages.filter(msg => msg.id > this.lastMessageId);
                
                newMessages.forEach(message => {
                    this.appendMessage(message);
                    if (!this.isMyMessage(message)) {
                        this.playNotificationSound();
                    }
                });

                if (newMessages.length > 0) {
                    this.lastMessageId = newMessages[newMessages.length - 1].id;
                }
            }
        } catch (error) {
            console.error('Error checking for new messages:', error);
        }
    }

    startActivityTracking() {
        // Send heartbeat every 2 minutes
        this.activityInterval = setInterval(async () => {
            try {
                const routePrefix = this.getRoutePrefix();
                await fetch(`${routePrefix}/chat/update-activity`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
            } catch (error) {
                console.error('Error updating activity:', error);
            }
        }, 120000);

        // Update activity on page visibility change
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) {
                const routePrefix = this.getRoutePrefix();
                fetch(`${routePrefix}/chat/update-activity`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).catch(console.error);
            }
        });
    }

    async checkUnreadMessages() {
        try {
            const routePrefix = this.getRoutePrefix();
            const response = await fetch(`${routePrefix}/chat/unread-count`);
            if (response.ok) {
                const data = await response.json();
                this.updateUnreadBadge(data.unread_count);
            }
        } catch (error) {
            console.error('Error checking unread messages:', error);
        }
    }

    updateUnreadBadge(count) {
        const badge = document.getElementById('chatUnreadBadge');
        if (badge) {
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }
    }

    handleTyping() {
        // Implement typing indicator logic here if needed
        // This would require WebSocket for real-time updates
    }

    playNotificationSound() {
        // Create and play notification sound
        const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+L3vW0gBzGE0fPahzYWY7vu6aJTFAlBmeL+v3QbDz2SzvHSfS8HKXzM7+CLPQgQaLXq7aRWEQtGnN/5wnMhDjeF0O3WgDkHJHfJ9dmCNhYQZrjw46dQFQpBnOD4vXUkDz2P0e3MfDANKH3H7+KOPwcSZqrq56FUFwxInN3/vmciEDKL0OzWfTAGKXjH9tyFNRcKYLPw5J5TGQ5HmNn6xnstDTCE3PO5gToHJHfH9dqDOBATarPo7KBUGAo+nNz5xW8hETC1vGogEDaBjy4rrJFUGwlDkNbz');
        audio.volume = 0.1;
        audio.play().catch(() => {}); // Ignore errors if audio can't play
    }

    scrollToBottom() {
        const container = document.getElementById('chatMessages');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    }

    isMyMessage(message) {
        // Get current user info from meta tags or global variables
        const currentUserType = document.querySelector('meta[name="user-type"]')?.getAttribute('content');
        const currentUserId = document.querySelector('meta[name="user-id"]')?.getAttribute('content');
        
        return message.sender_type === currentUserType && message.sender_id == currentUserId;
    }

    getFileIcon(messageType) {
        switch (messageType) {
            case 'image': return 'image';
            case 'file': return 'file';
            default: return 'file';
        }
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    showError(message) {
        // Show error toast or alert
        if (typeof toastr !== 'undefined') {
            toastr.error(message);
        } else {
            alert(message);
        }
    }

    // Public method to open chat from external buttons
    static openChatWith(participantType, participantId) {
        const chatSystem = window.chatSystem || new ChatSystem();
        chatSystem.openChat(participantType, participantId);
        window.chatSystem = chatSystem;
    }
}

// Initialize chat system when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.chatSystem = new ChatSystem();
});

// Add helper function to window for easy access
window.openChatWith = ChatSystem.openChatWith;