@extends('admin.layouts.layout')

@section('content')
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <p class="fw-semibold fs-18 mb-0">All Notifications</p>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Notifications</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="d-md-flex d-none align-items-center gap-2 page-header-right">
                <button type="button" class="btn btn-primary" onclick="markAllAsRead()">
                    <i class="ri-check-double-line me-1"></i>Mark All as Read
                </button>
                <button type="button" class="btn btn-outline-danger" onclick="deleteOldNotifications()">
                    <i class="ri-delete-bin-line me-1"></i>Clean Old
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-xl-4">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <span class="avatar avatar-md avatar-rounded bg-primary">
                                    <i class="ri-notification-line fs-18"></i>
                                </span>
                            </div>
                            <div class="flex-fill ms-3">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <p class="text-muted mb-0 fs-12">Total Notifications</p>
                                        <h4 class="fw-semibold mt-1 mb-0">{{ $stats['total'] }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <span class="avatar avatar-md avatar-rounded bg-secondary">
                                    <i class="ri-notification-badge-line fs-18"></i>
                                </span>
                            </div>
                            <div class="flex-fill ms-3">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <p class="text-muted mb-0 fs-12">Unread Notifications</p>
                                        <h4 class="fw-semibold mt-1 mb-0 text-warning">{{ $stats['unread'] }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <span class="avatar avatar-md avatar-rounded bg-success">
                                    <i class="ri-notification-off-line fs-18"></i>
                                </span>
                            </div>
                            <div class="flex-fill ms-3">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <p class="text-muted mb-0 fs-12">Read Notifications</p>
                                        <h4 class="fw-semibold mt-1 mb-0 text-success">{{ $stats['read'] }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Filter Notifications</div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.notifications.index') }}" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Notification Type</label>
                                <select name="type" class="form-select">
                                    <option value="">All Types</option>
                                    @foreach($notificationTypes as $key => $label)
                                        <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                                    <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid gap-2 d-md-flex">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-search-line me-1"></i>Filter
                                    </button>
                                    <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-secondary">
                                        <i class="ri-refresh-line me-1"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="card-title">All Notifications</div>
                        <div class="d-flex gap-2">
                            <span class="badge bg-primary">{{ $notifications->total() }} Total</span>
                            @if($stats['unread'] > 0)
                                <span class="badge bg-warning">{{ $stats['unread'] }} Unread</span>
                            @endif
                        </div>
                    </div>
                <div class="card-body p-0">
                    @if($notifications->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($notifications as $notification)
                                @php
                                    $data = $notification->data;
                                    $type = $notification->type;
                                    $isRead = $notification->read_at !== null;
                                @endphp
                                
                                <div class="list-group-item {{ !$isRead ? 'notification-unread' : '' }} position-relative" @if(!$isRead) data-notification-id="{{ $notification->id }}" onclick="onNotificationClick(event, '{{ $notification->id }}')" @endif>
                                    <div class="d-flex align-items-start gap-3">
                        <!-- Notification Icon -->
                        @if($type === 'App\Notifications\AppointmentRescheduled')
                            <span class="avatar avatar-md bg-info-transparent flex-shrink-0">
                                <i class="ri-calendar-line fs-16"></i>
                            </span>
                        @elseif($type === 'App\Notifications\NewChatMessage')
                            <span class="avatar avatar-md bg-success-transparent flex-shrink-0">
                                <i class="ri-message-3-line fs-16"></i>
                            </span>
                        @elseif($type === 'App\Notifications\NewProfessionalEvent')
                            <span class="avatar avatar-md bg-warning-transparent flex-shrink-0">
                                <i class="ri-calendar-event-line fs-16"></i>
                            </span>
                        @elseif($type === 'App\Notifications\EventBookingNotification')
                            <span class="avatar avatar-md bg-primary-transparent flex-shrink-0">
                                <i class="ri-calendar-check-line fs-16"></i>
                            </span>
                        @else
                            <span class="avatar avatar-md bg-secondary-transparent flex-shrink-0">
                                <i class="ri-notification-line fs-16"></i>
                            </span>
                        @endif                                        <!-- Notification Content -->
                                        <div class="flex-grow-1">
                                            @if($type === 'App\Notifications\AppointmentRescheduled')
                                                <h6 class="mb-1 fw-medium">Appointment Rescheduled</h6>
                                                <p class="mb-1 text-muted">
                                                    <strong>{{ $data['customer_name'] ?? 'Customer' }}</strong> rescheduled their appointment
                                                </p>
                                                <small class="text-muted">Service: {{ $data['service_name'] ?? 'N/A' }}</small>
                                            
                                            @elseif($type === 'App\Notifications\NewChatMessage')
                                                <h6 class="mb-1 fw-medium">New Message</h6>
                                                <p class="mb-1 text-muted">
                                                    <strong>{{ $data['sender_name'] ?? 'User' }}</strong> sent you a message
                                                </p>
                                                <small class="text-muted">"{{ $data['message_preview'] ?? 'No preview available' }}"</small>
                                            
                                            @elseif($type === 'App\Notifications\NewProfessionalEvent')
                                                <h6 class="mb-1 fw-medium">New Professional Event</h6>
                                                <p class="mb-1 text-muted">
                                                    <strong>{{ $data['professional_name'] ?? 'Professional' }}</strong> created a new event
                                                </p>
                                                <small class="text-muted">{{ $data['event_heading'] ?? 'Event' }}</small>
                                            
                                            @elseif($type === 'App\Notifications\EventBookingNotification')
                                                <h6 class="mb-1 fw-medium">New Event Booking</h6>
                                                <p class="mb-1 text-muted">
                                                    <strong>{{ $data['customer_name'] ?? 'Customer' }}</strong> booked an event
                                                </p>
                                                <small class="text-muted">
                                                    {{ $data['event_name'] ?? 'Event' }} - ₹{{ number_format($data['total_amount'] ?? 0, 2) }}
                                                </small>
                                            
                                            @else
                                                <h6 class="mb-1 fw-medium">Notification</h6>
                                                <p class="mb-1 text-muted">{{ $data['message'] ?? 'New notification received' }}</p>
                                            @endif

                                            <div class="d-flex align-items-center gap-3 mt-2">
                                                <small class="text-muted">
                                                    <i class="ri-time-line me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                                </small>
                                                @if($isRead)
                                                    <span class="badge bg-success-transparent text-success">Read</span>
                                                @else
                                                    <span class="badge bg-warning-transparent text-warning">Unread</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="d-flex flex-column gap-1">
                                            @if(!$isRead)
                                                <button type="button" class="btn btn-sm btn-primary" 
                                                        onclick="markSingleAsRead('{{ $notification->id }}')"
                                                        title="Mark as Read">
                                                    <i class="ri-check-line"></i>
                                                </button>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="deleteNotification('{{ $notification->id }}')"
                                                    title="Delete">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Unread Indicator -->
                                    @if(!$isRead)
                                        <div class="position-absolute top-50 start-0 translate-middle">
                                            <span class="bg-primary rounded-circle" style="width: 8px; height: 8px; display: block;"></span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        
                        <!-- Pagination -->
                        <div class="card-footer">
                            <div class="d-flex flex-column align-items-center">
                                <div class="custom-pagination">
                                    {{ $notifications->withQueryString()->links('admin.pagination.custom') }}
                                </div>
                                @if($notifications->hasPages())
                                    <div class="pagination-info mt-2">
                                        <small class="text-muted">
                                            Showing {{ $notifications->firstItem() ?? 0 }} to {{ $notifications->lastItem() ?? 0 }} 
                                            of {{ $notifications->total() }} results
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center p-5">
                            <div class="mb-3">
                                <span class="avatar avatar-xxl bg-secondary-transparent">
                                    <i class="ri-notification-off-line fs-2"></i>
                                </span>
                            </div>
                            <h5 class="fw-semibold">No Notifications Found</h5>
                            <p class="text-muted">There are no notifications matching your current filters.</p>
                            <a href="{{ route('admin.notifications.index') }}" class="btn btn-primary">
                                <i class="ri-refresh-line me-1"></i>Reset Filters
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- End::app-content -->

@endsection

@section('styles')
<style>
.notification-unread {
    background-color: rgba(13, 110, 253, 0.05);
    border-left: 4px solid #0d6efd;
}

.list-group-item {
    transition: all 0.2s ease;
    border: none;
    padding: 1rem 1.5rem;
}

.list-group-item:hover {
    background-color: rgba(13, 110, 253, 0.02);
}

.custom-card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.badge {
    font-size: 0.75em;
}

.avatar {
    display: flex;
    align-items: center;
    justify-content: center;
}

.fs-12 {
    font-size: 0.75rem;
}

.fs-16 {
    font-size: 1rem;
}

.fs-18 {
    font-size: 1.125rem;
}

/* Custom Pagination Styles */
.custom-pagination .pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    list-style: none;
    padding: 0;
    margin: 1rem 0;
    gap: 0.25rem;
}

.custom-pagination .page-item {
    display: inline-block;
}

.custom-pagination .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 0.75rem;
    margin: 0;
    font-size: 0.875rem;
    line-height: 1.25;
    color: #6c757d;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    transition: all 0.15s ease-in-out;
    min-width: 2.5rem;
    height: 2.5rem;
    font-weight: 500;
}

.custom-pagination .page-link:hover {
    z-index: 2;
    color: #0056b3;
    background-color: #e9ecef;
    border-color: #adb5bd;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.custom-pagination .page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #0d6efd;
    border-color: #0d6efd;
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(13, 110, 253, 0.25);
}

.custom-pagination .page-item.disabled .page-link {
    color: #adb5bd;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
    opacity: 0.65;
}

.custom-pagination .page-link i {
    font-size: 1rem;
    line-height: 1;
}

@media (max-width: 576px) {
    .custom-pagination .page-link {
        padding: 0.375rem 0.5rem;
        font-size: 0.75rem;
        min-width: 2rem;
        height: 2rem;
    }
    
    .custom-pagination .pagination {
        gap: 0.125rem;
    }
}
</style>

<script>
function markSingleAsRead(notificationId) {
    fetch(`/admin/notifications/${notificationId}/mark-as-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while marking notification as read');
    });
}

function markAllAsRead() {
    if (confirm('Mark all notifications as read?')) {
        fetch('/admin/notifications/mark-all-as-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while marking all notifications as read');
        });
    }
}

function deleteOldNotifications() {
    if (confirm('Delete notifications older than 30 days?')) {
        fetch('/admin/notifications/delete-old', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting old notifications');
        });
    }
}

function deleteNotification(notificationId) {
    if (confirm('Delete this notification?')) {
        fetch(`/admin/notifications/${notificationId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting notification');
        });
    }
}
</script>

<script>
function onNotificationClick(event, notificationId) {
    // If clicking a button or inside a button, do not treat as marking read
    if (event.target.closest('.btn')) {
        return;
    }

    // Proceed to mark as read
    markSingleAsRead(notificationId);
}
</script>