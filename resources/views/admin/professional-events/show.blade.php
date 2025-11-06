@extends('admin.layouts.layout')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Review Professional Event</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Events</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.professional-events.index') }}">Professional Events</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Review Event</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.professional-events.index') }}" class="btn btn-outline-primary">
                    <i class="ri-arrow-left-line me-1"></i> Back to List
                </a>
                
                @if($event->status === 'pending')
                    <button type="button" class="btn btn-success" onclick="approveEvent()">
                        <i class="ri-check-line me-1"></i> Approve
                    </button>
                    <button type="button" class="btn btn-danger" onclick="rejectEvent()">
                        <i class="ri-close-line me-1"></i> Reject
                    </button>
                @endif
            </div>
        </div>

        <!-- Event Status Alert -->
        @if($event->status !== 'pending')
            <div class="alert alert-{{ $event->status === 'approved' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                <i class="ri-{{ $event->status === 'approved' ? 'check' : 'close' }}-circle-line me-2"></i>
                This event has been <strong>{{ ucfirst($event->status) }}</strong>
                @if($event->approvedBy)
                    by {{ $event->approvedBy->name }}
                @endif
                @if($event->approved_at)
                    on {{ $event->approved_at->format('M d, Y \a\t H:i') }}
                @endif
            </div>
        @endif

        <div class="row">
            <!-- Event Details -->
            <div class="col-xl-8">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Event Details</div>
                    </div>
                    <div class="card-body">
                        <!-- Event Image -->
                        <div class="text-center mb-4">
                            <img src="{{ asset('storage/' . $event->card_image) }}" 
                                 alt="Event Image" 
                                 class="img-fluid rounded" 
                                 style="max-height: 300px; object-fit: cover;">
                        </div>

                        <!-- Event Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Event Name</label>
                                    <p class="mb-0">{{ $event->heading }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Event Type</label>
                                    <p class="mb-0">
                                        <span class="badge bg-info">{{ $event->mini_heading }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Event Date</label>
                                    <p class="mb-0">{{ \Carbon\Carbon::parse($event->date)->format('l, F d, Y') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Starting Fees</label>
                                    <p class="mb-0 text-success fw-bold">₹{{ number_format($event->starting_fees, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <div class="border rounded p-3 bg-light">
                                {{ $event->short_description }}
                            </div>
                        </div>

                        <!-- Creation Info -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Created On</label>
                                    <p class="mb-0">{{ $event->created_at->format('M d, Y \a\t H:i') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Last Updated</label>
                                    <p class="mb-0">{{ $event->updated_at->format('M d, Y \a\t H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Notes -->
                @if($event->admin_notes)
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Admin Notes</div>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info mb-0">
                                {{ $event->admin_notes }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Professional Info & Actions -->
            <div class="col-xl-4">
                <!-- Professional Information -->
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Professional Information</div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-lg bg-primary-transparent me-3">
                                <i class="ri-user-line fs-18"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">{{ $event->professional->name }}</h6>
                                <p class="mb-0 text-muted">{{ $event->professional->email }}</p>
                            </div>
                        </div>

                        @if($event->professional->phone)
                            <div class="mb-3">
                                <label class="form-label fw-bold">Phone</label>
                                <p class="mb-0">{{ $event->professional->phone }}</p>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-bold">Account Status</label>
                            <p class="mb-0">
                                <span class="badge bg-{{ $event->professional->active ? 'success' : 'danger' }}">
                                    {{ $event->professional->active ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Member Since</label>
                            <p class="mb-0">{{ $event->professional->created_at->format('M Y') }}</p>
                        </div>

                        <div class="d-grid">
                            <a href="{{ route('admin.manage-professional.show', $event->professional) }}" class="btn btn-outline-primary">
                                <i class="ri-external-link-line me-1"></i> View Profile
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Event Status -->
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Event Status</div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <div class="mb-3">
                                @if($event->status === 'pending')
                                    <span class="avatar avatar-xl bg-warning-transparent">
                                        <i class="ri-time-line fs-24"></i>
                                    </span>
                                    <h5 class="mt-2 text-warning">Pending Review</h5>
                                    <p class="text-muted">This event is awaiting admin approval</p>
                                @elseif($event->status === 'approved')
                                    <span class="avatar avatar-xl bg-success-transparent">
                                        <i class="ri-check-circle-line fs-24"></i>
                                    </span>
                                    <h5 class="mt-2 text-success">Approved</h5>
                                    <p class="text-muted">This event is live on the website</p>
                                @else
                                    <span class="avatar avatar-xl bg-danger-transparent">
                                        <i class="ri-close-circle-line fs-24"></i>
                                    </span>
                                    <h5 class="mt-2 text-danger">Rejected</h5>
                                    <p class="text-muted">This event was rejected</p>
                                @endif
                            </div>

                            @if($event->status === 'pending')
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-success" onclick="approveEvent()">
                                        <i class="ri-check-line me-1"></i> Approve Event
                                    </button>
                                    <button type="button" class="btn btn-danger" onclick="rejectEvent()">
                                        <i class="ri-close-line me-1"></i> Reject Event
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approval Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.professional-events.approve', $event) }}">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-success">
                        <i class="ri-check-circle-line me-2"></i>
                        You are about to approve this event. It will become visible on the website.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Admin Notes (Optional)</label>
                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="Add any notes for the professional..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Approve Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div class="modal fade" id="rejectionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.professional-events.reject', $event) }}">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="ri-alert-line me-2"></i>
                        You are about to reject this event. Please provide a reason.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea name="admin_notes" class="form-control" rows="4" placeholder="Please provide a detailed reason for rejection..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function approveEvent() {
    new bootstrap.Modal(document.getElementById('approvalModal')).show();
}

function rejectEvent() {
    new bootstrap.Modal(document.getElementById('rejectionModal')).show();
}
</script>
@endsection