@extends('professional.layout.layout')

@section('styles')
<style>
    .custom-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 25px;
    }
    
    .custom-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 35px rgba(0, 0, 0, 0.12);
    }
    
    .event-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .status-badge-large {
        padding: 12px 20px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 16px;
        display: inline-flex;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .status-pending { 
        background: linear-gradient(135deg, #ffc107 0%, #ffca2c 100%);
        color: #856404;
        border: 2px solid #ffeaa7;
    }
    
    .status-approved { 
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        border: 2px solid #c3e6cb;
    }
    
    .status-rejected { 
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        border: 2px solid #f5c6cb;
    }
    
    .detail-row {
        display: flex;
        padding: 15px 0;
        border-bottom: 1px solid #f1f3f4;
        align-items: flex-start;
    }
    
    .detail-row:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        font-weight: 600;
        color: #495057;
        min-width: 140px;
        margin-right: 20px;
        font-size: 14px;
    }
    
    .detail-value {
        flex: 1;
        color: #2c3e50;
        font-size: 14px;
        line-height: 1.5;
    }
    
    .btn-action {
        padding: 12px 24px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        margin-right: 10px;
        margin-bottom: 10px;
        border: none;
        cursor: pointer;
    }
    
    .btn-primary-custom {
        background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        color: white;
    }
    
    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(76, 175, 80, 0.3);
        color: white;
    }
    
    .btn-warning-custom {
        background: linear-gradient(135deg, #ffc107 0%, #ffca2c 100%);
        color: #212529;
    }
    
    .btn-warning-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 193, 7, 0.3);
        color: #212529;
    }
    
    .btn-danger-custom {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
    }
    
    .btn-danger-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
        color: white;
    }
    
    .btn-secondary-custom {
        background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
        color: white;
    }
    
    .btn-secondary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
        color: white;
    }
    
    .page-title {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 0;
    }
    
    .breadcrumb-item a {
        color: #4CAF50;
        text-decoration: none;
    }
    
    .breadcrumb-item.active {
        color: #6c757d;
    }
    
    .admin-notes {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-left: 4px solid #dc3545;
        padding: 20px;
        border-radius: 10px;
        margin: 20px 0;
    }
    
    .meet-link-btn {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 12px 20px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .meet-link-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        color: white;
    }

    .timeline-container {
        position: relative;
        padding-left: 30px;
        background: #f8f9fa;
        border-radius: 15px;
        padding: 25px;
        margin: 20px 0;
    }

    .timeline-container::before {
        content: '';
        position: absolute;
        left: 35px;
        top: 25px;
        bottom: 25px;
        width: 3px;
        background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        border-radius: 2px;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
        padding-left: 25px;
    }

    .timeline-marker {
        position: absolute;
        left: -6px;
        top: 5px;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 0 0 3px #4CAF50;
        background: #4CAF50;
    }

    .timeline-content {
        background: white;
        padding: 15px 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-left: 15px;
    }

    .timeline-title {
        margin-bottom: 5px;
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
    }

    .timeline-time {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .timeline-desc {
        font-size: 14px;
        color: #495057;
        margin-bottom: 0;
        line-height: 1.5;
    }
</style>
@endsection

@section('content')
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
        </div>

        <div class="row">
            <!-- Event Image and Basic Info -->
            <div class="col-xl-4">
                <div class="card custom-card">
                    <div class="card-body text-center">
                        @if($event->card_image)
                            <img src="{{ asset('storage/' . $event->card_image) }}" 
                                 alt="{{ $event->heading }}" 
                                 class="event-image mb-3">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 300px; border-radius: 15px;">
                                <i class="ri-image-line" style="font-size: 48px; color: #6c757d;"></i>
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="status-badge-large status-{{ $event->status }}">
                            @if($event->status === 'approved')
                                <i class="ri-check-line me-2"></i>Approved
                            @elseif($event->status === 'pending')
                                <i class="ri-time-line me-2"></i>Pending Review
                            @elseif($event->status === 'rejected')
                                <i class="ri-close-line me-2"></i>Rejected
                            @endif
                        </div>
                        
                        <h4 class="mb-2" style="color: #2c3e50;">{{ $event->heading }}</h4>
                        <p class="text-muted mb-3">{{ $event->mini_heading }}</p>
                        <h5 class="text-success mb-0">
                            <i class="ri-money-rupee-circle-line me-1"></i>
                            ₹{{ number_format($event->starting_fees, 2) }}
                        </h5>
                    </div>
                </div>

                <!-- Timeline -->
                @if($event->created_at || $event->updated_at || $event->approved_at)
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="ri-time-line me-2"></i>Timeline
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="timeline-container">
                            @if($event->approved_at)
                            <div class="timeline-item">
                                <div class="timeline-marker" style="background: #28a745; box-shadow: 0 0 0 3px #28a745;"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title" style="color: #28a745;">Event Approved</div>
                                    <div class="timeline-time">{{ $event->approved_at->format('M d, Y \a\t H:i A') }}</div>
                                    <div class="timeline-desc">Your event has been approved and is now live.</div>
                                </div>
                            </div>
                            @endif
                            
                            @if($event->updated_at->gt($event->created_at))
                            <div class="timeline-item">
                                <div class="timeline-marker" style="background: #ffc107; box-shadow: 0 0 0 3px #ffc107;"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title" style="color: #ffc107;">Event Updated</div>
                                    <div class="timeline-time">{{ $event->updated_at->format('M d, Y \a\t H:i A') }}</div>
                                    <div class="timeline-desc">Event details were modified.</div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="timeline-item">
                                <div class="timeline-marker" style="background: #17a2b8; box-shadow: 0 0 0 3px #17a2b8;"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title" style="color: #17a2b8;">Event Created</div>
                                    <div class="timeline-time">{{ $event->created_at->format('M d, Y \a\t H:i A') }}</div>
                                    <div class="timeline-desc">Event was submitted for review.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Event Details -->
            <div class="col-xl-8">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="ri-information-line me-2"></i>Event Information
                        </div>
                        <div>
                            @if($event->status === 'approved')
                                <span class="badge bg-success-transparent">
                                    <i class="ri-check-line me-1"></i>Live
                                </span>
                            @elseif($event->status === 'pending')
                                <span class="badge bg-warning-transparent">
                                    <i class="ri-time-line me-1"></i>Under Review
                                </span>
                            @elseif($event->status === 'rejected')
                                <span class="badge bg-danger-transparent">
                                    <i class="ri-close-line me-1"></i>Needs Revision
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="detail-row">
                            <div class="detail-label"><i class="ri-calendar-line me-2"></i>Event Date:</div>
                            <div class="detail-value"><strong>{{ \Carbon\Carbon::parse($event->date)->format('l, F j, Y') }}</strong></div>
                        </div>

                        <div class="detail-row">
                            <div class="detail-label"><i class="ri-price-tag-3-line me-2"></i>Event Type:</div>
                            <div class="detail-value">{{ $event->mini_heading }}</div>
                        </div>

                        <div class="detail-row">
                            <div class="detail-label"><i class="ri-money-rupee-circle-line me-2"></i>Starting Fees:</div>
                            <div class="detail-value"><strong style="color: #28a745; font-size: 18px;">₹{{ number_format($event->starting_fees, 2) }}</strong></div>
                        </div>

                        <div class="detail-row">
                            <div class="detail-label"><i class="ri-file-text-line me-2"></i>Description:</div>
                            <div class="detail-value" style="white-space: pre-wrap;">{{ $event->short_description }}</div>
                        </div>

                        <!-- Meet Link -->
                        <div class="detail-row">
                            <div class="detail-label"><i class="ri-video-line me-2"></i>Meet Link:</div>
                            <div class="detail-value">
                                @if($event->meet_link)
                                    <a href="{{ $event->meet_link }}" target="_blank" class="meet-link-btn">
                                        <i class="ri-external-link-line me-2"></i>Join Meeting
                                    </a>
                                @else
                                    <span style="color: #6c757d;">
                                        <i class="ri-close-circle-line me-1"></i>Not set by admin yet
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Notes -->
                @if($event->admin_notes)
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title text-danger">
                            <i class="ri-message-3-line me-2"></i>Admin Notes
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="admin-notes">
                            <p style="margin: 0; font-size: 15px; line-height: 1.6;">{{ $event->admin_notes }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="card custom-card">
                    <div class="card-body text-center">
                        <a href="{{ route('professional.events.index') }}" class="btn-action btn-secondary-custom">
                            <i class="ri-arrow-left-line me-2"></i>Back to Events
                        </a>

                        @if($event->status !== 'approved')
                            <a href="{{ route('professional.events.edit', $event) }}" class="btn-action btn-warning-custom">
                                <i class="ri-edit-line me-2"></i>Edit Event
                            </a>

                            <button onclick="deleteEvent()" class="btn-action btn-danger-custom">
                                <i class="ri-delete-bin-line me-2"></i>Delete Event
                            </button>
                        @endif

                        @if($event->status === 'approved')
                            <a href="{{ route('event.details', $event->id) }}" 
                               class="btn-action btn-primary-custom" target="_blank">
                                <i class="ri-external-link-line me-2"></i>View on Frontend
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
function deleteEvent() {
    if (confirm('Are you sure you want to delete this event? This action cannot be undone.')) {
        // Create a form to submit DELETE request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('professional.events.destroy', $event) }}';
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add METHOD spoofing for DELETE
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        // Submit the form
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
