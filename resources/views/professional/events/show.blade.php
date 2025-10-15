@extends('professional.layout.layout')
@section('content')
        </div>

        <div class="detail-row">
            <div class="detail-label">Starting Fees:</div>
            <div class="detail-value"><strong style="color: #28a745;">₹{{ number_format($event->starting_fees, 2) }}</strong></div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Description:</div>
            <div class="detail-value">{{ $event->short_description }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Created On:</div>
            <div class="detail-value">{{ $event->created_at->format('M d, Y \a\t H:i A') }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Last Updated:</div>
            <div class="detail-value">{{ $event->updated_at->format('M d, Y \a\t H:i A') }}</div>
        </div>

        @if($event->approved_at)
            <div class="detail-row">
                <div class="detail-label">Approved On:</div>
                <div class="detail-value">{{ $event->approved_at->format('M d, Y \a\t H:i A') }}</div>
            </div>
        @endif

        <!-- Meet Link -->
        <div class="detail-row">
            <div class="detail-label">Meet Link:</div>
            <div class="detail-value">
                @if($event->meet_link)
                    <a href="{{ $event->meet_link }}" target="_blank" 
                       style="background-color: #28a745; 
                              color: white; 
                              padding: 8px 15px; 
                              border-radius: 5px; 
                              text-decoration: none; 
                              display: inline-block;
                              font-size: 14px;">
                        <i class="fas fa-video"></i> Join Meeting
                    </a>
                @else
                    <span style="color: #6c757d;">
                        <i class="fas fa-times-circle"></i> Not set by admin
                    </span>
                @endif
            </div>
        </div>

        <!-- Admin Notes -->
        @if($event->admin_notes)
            <div class="admin-notes">
                <h5 style="margin-bottom: 10px; color: #dc3545;">Admin Notes:</h5>
                <p style="margin: 0;">{{ $event->admin_notes }}</p>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('professional.events.index') }}" class="btn-action btn-back">
                Back to Events
            </a>

            @if($event->status !== 'approved')
                <a href="{{ route('professional.events.edit', $event) }}" class="btn-action btn-edit">
                    Edit Event
                </a>

                <button onclick="deleteEvent()" class="btn-action btn-delete">
                    Delete Event
                </button>
            @endif

            @if($event->status === 'approved')
                <a href="{{ route('professional-event.details', $event->id) }}" class="btn-action btn-edit" target="_blank">
                    View on Frontend
                </a>
            @endif
        </div>
    </div>
</div>

<script>
function deleteEvent() {
    if(confirm('Are you sure you want to delete this event? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("professional.events.destroy", $event) }}';
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = '{{ csrf_token() }}';
        
        form.appendChild(methodInput);
        form.appendChild(tokenInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Event Details</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('professional.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('professional.events.index') }}">Events</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $event->heading }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="d-flex gap-2">
                @if($event->status === 'pending')
                    <a href="{{ route('professional.events.edit', $event->id) }}" class="btn btn-primary btn-sm">
                        <i class="ri-edit-line me-1"></i>Edit Event
                    </a>
                @endif
                <a href="{{ route('professional.events.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="ri-arrow-left-line me-1"></i>Back to Events
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Event Details Card -->
            <div class="col-xl-8">
                <div class="card custom-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="card-title">
                            <i class="ri-calendar-event-line me-2"></i>Event Information
                        </div>
                        <div>
                            @if($event->status === 'approved')
                                <span class="badge bg-success-transparent">
                                    <i class="ri-check-line me-1"></i>Approved
                                </span>
                            @elseif($event->status === 'pending')
                                <span class="badge bg-warning-transparent">
                                    <i class="ri-time-line me-1"></i>Pending Approval
                                </span>
                            @elseif($event->status === 'rejected')
                                <span class="badge bg-danger-transparent">
                                    <i class="ri-close-line me-1"></i>Rejected
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Event Image -->
                        <div class="text-center mb-4">
                            <img src="{{ asset('storage/' . $event->card_image) }}" 
                                 alt="{{ $event->heading }}" 
                                 class="img-fluid rounded" 
                                 style="max-height: 300px; object-fit: cover;">
                        </div>

                        <!-- Event Type -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Event Type</label>
                            <div class="fs-14">
                                <span class="badge bg-info-transparent">{{ $event->mini_heading }}</span>
                            </div>
                        </div>

                        <!-- Event Name -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Event Name</label>
                            <h4 class="fw-medium mb-0">{{ $event->heading }}</h4>
                        </div>

                        <!-- Event Description -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted">Description</label>
                            <div class="bg-light rounded p-3">
                                {{ $event->short_description }}
                            </div>
                        </div>

                        <!-- Event Details Grid -->
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Event Date</label>
                                <div class="d-flex align-items-center">
                                    <i class="ri-calendar-line text-primary me-2"></i>
                                    <span class="fw-medium">{{ \Carbon\Carbon::parse($event->date)->format('l, F j, Y') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Starting Fees</label>
                                <div class="d-flex align-items-center">
                                    <i class="ri-money-rupee-circle-line text-success me-2"></i>
                                    <span class="fw-medium">₹{{ number_format($event->starting_fees, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status & Timeline Card -->
            <div class="col-xl-4">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="ri-timeline-line me-2"></i>Event Status & Timeline
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Current Status -->
                        <div class="alert @if($event->status === 'approved') alert-success @elseif($event->status === 'pending') alert-warning @else alert-danger @endif" role="alert">
                            <h6 class="alert-heading">
                                @if($event->status === 'approved')
                                    <i class="ri-check-line me-2"></i>Event Approved
                                @elseif($event->status === 'pending')
                                    <i class="ri-time-line me-2"></i>Awaiting Approval
                                @else
                                    <i class="ri-close-line me-2"></i>Event Rejected
                                @endif
                            </h6>
                            <p class="mb-0">
                                @if($event->status === 'approved')
                                    Your event has been approved and is now visible on the frontend.
                                @elseif($event->status === 'pending')
                                    Your event is under review by our admin team.
                                @else
                                    Your event has been rejected. Please check admin notes below.
                                @endif
                            </p>
                        </div>

                        <!-- Timeline -->
                        <div class="timeline-container">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Event Created</h6>
                                    <p class="timeline-time text-muted">{{ $event->created_at->format('M j, Y \a\t g:i A') }}</p>
                                </div>
                            </div>

                            @if($event->status !== 'pending')
                                <div class="timeline-item">
                                    <div class="timeline-marker @if($event->status === 'approved') bg-success @else bg-danger @endif"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">
                                            @if($event->status === 'approved')
                                                Event Approved
                                            @else
                                                Event Rejected
                                            @endif
                                        </h6>
                                        <p class="timeline-time text-muted">{{ $event->updated_at->format('M j, Y \a\t g:i A') }}</p>
                                        @if($event->approvedBy)
                                            <p class="timeline-desc">By: {{ $event->approvedBy->name }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Admin Notes -->
                        @if($event->admin_notes)
                            <div class="mt-4">
                                <label class="form-label fw-semibold text-muted">Admin Notes</label>
                                <div class="bg-light rounded p-3">
                                    <small>{{ $event->admin_notes }}</small>
                                </div>
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="mt-4">
                            @if($event->status === 'pending')
                                <a href="{{ route('professional.events.edit', $event->id) }}" class="btn btn-primary btn-sm w-100 mb-2">
                                    <i class="ri-edit-line me-1"></i>Edit Event
                                </a>
                            @elseif($event->status === 'rejected')
                                <a href="{{ route('professional.events.edit', $event->id) }}" class="btn btn-warning btn-sm w-100 mb-2">
                                    <i class="ri-edit-line me-1"></i>Revise & Resubmit
                                </a>
                            @endif
                            
                            <form action="{{ route('professional.events.destroy', $event->id) }}" method="POST" class="d-inline w-100">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100" 
                                        onclick="return confirm('Are you sure you want to delete this event?')">
                                    <i class="ri-delete-bin-line me-1"></i>Delete Event
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card custom-card mt-3">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="ri-bar-chart-line me-2"></i>Quick Info
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="avatar avatar-lg bg-primary-transparent rounded">
                                        <i class="ri-calendar-line fs-18"></i>
                                    </div>
                                    <p class="fw-semibold mb-0 mt-2">{{ \Carbon\Carbon::parse($event->date)->diffForHumans() }}</p>
                                    <small class="text-muted">Event Date</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="avatar avatar-lg bg-success-transparent rounded">
                                        <i class="ri-money-rupee-circle-line fs-18"></i>
                                    </div>
                                    <p class="fw-semibold mb-0 mt-2">₹{{ number_format($event->starting_fees) }}</p>
                                    <small class="text-muted">Starting Fee</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline-container {
    position: relative;
    padding-left: 30px;
}

.timeline-container::before {
    content: '';
    position: absolute;
    left: 12px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -18px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content {
    padding-left: 20px;
}

.timeline-title {
    margin-bottom: 5px;
    font-size: 14px;
}

.timeline-time {
    font-size: 12px;
    margin-bottom: 0;
}

.timeline-desc {
    font-size: 12px;
    margin-bottom: 0;
    margin-top: 2px;
}
</style>
@endsection