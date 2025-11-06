@extends('layouts.layout')

@section('styles')
<style>
    .bookings-container {
        padding: 2rem 0;
    }

    .booking-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .booking-card:hover {
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }

    .booking-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;
    }

    .booking-id {
        font-weight: 600;
        font-size: 1.1rem;
        color: #333;
    }

    .booking-status {
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .status-confirmed {
        background: #d4edda;
        color: #155724;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-completed {
        background: #d1ecf1;
        color: #0c5460;
    }

    .booking-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
    }

    .detail-label {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }

    .detail-value {
        font-weight: 500;
        color: #333;
    }

    .booking-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
    }

    .   no-bookings {
        text-align: center;
        padding: 3rem;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .no-bookings i {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<div class="container bookings-container">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">My Bookings</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if($bookings && count($bookings) > 0)
                @foreach($bookings as $booking)
                <div class="booking-card">
                    <div class="booking-header">
                        <div class="booking-id">
                            Booking #{{ $booking->id }}
                        </div>
                        <span class="booking-status status-{{ strtolower($booking->status) }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>

                    <div class="booking-details">
                        <div class="detail-item">
                            <span class="detail-label">Service</span>
                            <span class="detail-value">{{ $booking->service_name ?? 'N/A' }}</span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Professional</span>
                            <span class="detail-value">
                                {{ $booking->professional->name ?? 'Not Assigned' }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Booking Date</span>
                            <span class="detail-value">
                                {{ $booking->booking_date ? date('M d, Y', strtotime($booking->booking_date)) : 'N/A' }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Amount</span>
                            <span class="detail-value">₹{{ number_format($booking->amount, 2) }}</span>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="mt-4">
                    {{ $bookings->links() }}
                </div>
            @else
                <div class="no-bookings">
                    <i class="ri-calendar-line"></i>
                    <h4>No Bookings Found</h4>
                    <p class="text-muted">You haven't made any bookings yet.</p>
                    <a href="{{ route('booking') }}" class="btn btn-primary mt-3">Make a Booking</a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
@section('scripts')
<script>
// Your other JavaScript code can go here if needed
</script>
@endsection
</script>
@endsection
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ booking_id: bookingId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            currentChatId = data.chat_id;
            document.getElementById('chatModalTitle').textContent = 
                `Chat with ${data.participant.name} - ${data.booking.service_name}`;
            
            // Load messages
            loadMessages(bookingId);
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('bookingChatModal'));
            modal.show();
            
            // Start polling for new messages
            messageCheckInterval = setInterval(() => loadMessages(bookingId), 3000);
        }
    })
    .catch(error => console.error('Error:', error));
}

function loadMessages(bookingId) {
    fetch(`/user/booking-chat/${bookingId}/messages`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayMessages(data.messages);
            }
        })
        .catch(error => console.error('Error:', error));
}

function displayMessages(messages) {
    const chatContainer = document.getElementById('chatMessages');
    let html = '';
    
    messages.forEach(msg => {
        const isOwnMessage = msg.sender_type === 'customer';
        const alignClass = isOwnMessage ? 'text-end' : 'text-start';
        const bgClass = isOwnMessage ? 'bg-primary text-white' : 'bg-light';
        
        html += `
            <div class="mb-3 ${alignClass}">
                <div class="d-inline-block ${bgClass} p-3 rounded" style="max-width: 70%;">
                    <div>${msg.message}</div>
                    <small class="text-muted">${msg.formatted_time}</small>
                </div>
            </div>
        `;
    });
    
    chatContainer.innerHTML = html;
    chatContainer.scrollTop = chatContainer.scrollHeight;
}

document.getElementById('sendMessageBtn').addEventListener('click', sendMessage);
document.getElementById('chatMessageInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        sendMessage();
    }
});

function sendMessage() {
    const input = document.getElementById('chatMessageInput');
    const message = input.value.trim();
    
    if (!message || !currentBookingId) return;
    
    fetch(`/user/booking-chat/${currentBookingId}/send`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ message: message })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            input.value = '';
            loadMessages(currentBookingId);
        }
    })
    .catch(error => console.error('Error:', error));
}

// Clean up interval when modal closes
document.getElementById('bookingChatModal').addEventListener('hidden.bs.modal', function() {
    if (messageCheckInterval) {
        clearInterval(messageCheckInterval);
        messageCheckInterval = null;
    }
});
</script>
@endsection
