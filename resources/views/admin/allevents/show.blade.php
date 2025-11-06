@extends('admin.layouts.layout')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Event Details</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Admin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.allevents.index') }}">All Events</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Event Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.allevents.index') }}" class="btn btn-outline-primary">
                    <i class="ri-arrow-left-line me-1"></i> Back to List
                </a>
                
                @if($allevent->created_by_type === 'professional' && $allevent->status === 'pending')
                    <button type="button" class="btn btn-success" onclick="approveEvent()">
                        <i class="ri-check-line me-1"></i> Approve
                    </button>
                    <button type="button" class="btn btn-danger" onclick="rejectEvent()">
                        <i class="ri-close-line me-1"></i> Reject
                    </button>
                @endif

                @if($allevent->status === 'approved')
                    <button type="button" class="btn btn-info" onclick="editMeetLink()">
                        <i class="ri-video-line me-1"></i> Manage Meet Link
                    </button>
                @endif
            </div>
        </div>

        <!-- Event Status Alert -->
        @if($allevent->status !== 'pending')
            <div class="alert alert-{{ $allevent->status === 'approved' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                <i class="ri-{{ $allevent->status === 'approved' ? 'check' : 'close' }}-circle-line me-2"></i>
                This event has been <strong>{{ ucfirst($allevent->status) }}</strong>
                @if($allevent->approvedBy)
                    by {{ $allevent->approvedBy->name }}
                @endif
                @if($allevent->approved_at)
                    on {{ $allevent->approved_at->format('M d, Y \a\t H:i') }}
                @endif
            </div>
        @endif

        <div class="row">
            <!-- Event Details -->
            <div class="col-xl-8">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Event Information</div>
                        <div>
                            @if($allevent->status === 'approved')
                                <span class="badge bg-success-transparent">
                                    <i class="ri-check-line me-1"></i>Approved
                                </span>
                            @elseif($allevent->status === 'pending')
                                <span class="badge bg-warning-transparent">
                                    <i class="ri-time-line me-1"></i>Pending
                                </span>
                            @elseif($allevent->status === 'rejected')
                                <span class="badge bg-danger-transparent">
                                    <i class="ri-close-line me-1"></i>Rejected
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Event Image -->
                        <div class="text-center mb-4">
                            <img src="{{ asset('storage/' . $allevent->card_image) }}" 
                                 alt="Event Image" 
                                 class="img-fluid rounded" 
                                 style="max-height: 300px; object-fit: cover;">
                        </div>

                        <!-- Event Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Event Name</label>
                                    <p class="mb-0">{{ $allevent->heading }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Event Type</label>
                                    <p class="mb-0">
                                        <span class="badge bg-info">{{ $allevent->mini_heading }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Event Date</label>
                                    <p class="mb-0">{{ \Carbon\Carbon::parse($allevent->date)->format('l, F d, Y') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Starting Fees</label>
                                    <p class="mb-0 text-success fw-bold">₹{{ number_format($allevent->starting_fees, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <div class="border rounded p-3 bg-light">
                                {{ $allevent->short_description }}
                            </div>
                        </div>

                        <!-- Meet Link Section -->
                        @if($allevent->status === 'approved')
                        <div class="mb-3">
                            <label class="form-label fw-bold">Meeting Link</label>
                            <div class="d-flex align-items-center gap-2">
                                @if($allevent->meet_link)
                                    <a href="{{ $allevent->meet_link }}" target="_blank" class="btn btn-success btn-sm">
                                        <i class="ri-external-link-line me-1"></i>{{ $allevent->meet_link }}
                                    </a>
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="editMeetLink()">
                                        <i class="ri-edit-line me-1"></i>Edit
                                    </button>
                                @else
                                    <span class="text-muted">No meeting link set</span>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="editMeetLink()">
                                        <i class="ri-add-line me-1"></i>Add Meeting Link
                                    </button>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Creation Info -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Created On</label>
                                    <p class="mb-0">{{ $allevent->created_at->format('M d, Y \a\t H:i') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Last Updated</label>
                                    <p class="mb-0">{{ $allevent->updated_at->format('M d, Y \a\t H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Notes -->
                @if($allevent->admin_notes)
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Admin Notes</div>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info mb-0">
                                {{ $allevent->admin_notes }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Event Meta & Actions -->
            <div class="col-xl-4">
                <!-- Creator Information -->
                @if($allevent->created_by_type === 'professional' && $allevent->professional)
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
                                <h6 class="mb-1">{{ $allevent->professional->name }}</h6>
                                <p class="mb-0 text-muted">{{ $allevent->professional->email }}</p>
                            </div>
                        </div>

                        @if($allevent->professional->phone)
                            <div class="mb-3">
                                <label class="form-label fw-bold">Phone</label>
                                <p class="mb-0">{{ $allevent->professional->phone }}</p>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-bold">Account Status</label>
                            <p class="mb-0">
                                <span class="badge bg-{{ $allevent->professional->active ? 'success' : 'danger' }}">
                                    {{ $allevent->professional->active ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Member Since</label>
                            <p class="mb-0">{{ $allevent->professional->created_at->format('M Y') }}</p>
                        </div>

                        <div class="d-grid">
                            <a href="{{ route('admin.manage-professional.show', $allevent->professional) }}" class="btn btn-outline-primary">
                                <i class="ri-external-link-line me-1"></i> View Profile
                            </a>
                        </div>
                    </div>
                </div>
                @else
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Event Creator</div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <div class="avatar avatar-xl bg-success-transparent mb-3">
                                <i class="ri-admin-line fs-24"></i>
                            </div>
                            <h6 class="mb-1">Admin Created</h6>
                            <p class="text-muted mb-0">This event was created by admin</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Event Status -->
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Event Status</div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <div class="mb-3">
                                @if($allevent->status === 'pending')
                                    <span class="avatar avatar-xl bg-warning-transparent">
                                        <i class="ri-time-line fs-24"></i>
                                    </span>
                                    <h5 class="mt-2 text-warning">Pending Review</h5>
                                    <p class="text-muted">This event is awaiting admin approval</p>
                                @elseif($allevent->status === 'approved')
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

                            @if($allevent->created_by_type === 'professional' && $allevent->status === 'pending')
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

                <!-- Quick Actions -->
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Quick Actions</div>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.allevents.edit', $allevent) }}" class="btn btn-outline-primary">
                                <i class="ri-edit-line me-1"></i> Edit Event
                            </a>
                            @if($allevent->status === 'approved')
                                <a href="{{ route('event.details', $allevent->id) }}" class="btn btn-outline-info" target="_blank">
                                    <i class="ri-external-link-line me-1"></i> View on Frontend
                                </a>
                            @endif
                            <button type="button" class="btn btn-outline-danger" onclick="deleteEvent()">
                                <i class="ri-delete-bin-line me-1"></i> Delete Event
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Meet Link Modal -->
<div class="modal fade" id="meetLinkModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manage Meeting Link</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="meetLinkForm">
                    <div class="mb-3">
                        <label class="form-label">Meeting Link</label>
                        <input type="url" class="form-control" id="meetLinkInput" 
                               placeholder="https://meet.google.com/xxx-xxxx-xxx or https://zoom.us/j/xxxxxxxxx"
                               value="{{ $allevent->meet_link }}">
                        <div class="form-text">Enter a valid meeting URL (Google Meet, Zoom, Teams, etc.)</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveMeetLink()">Save Meeting Link</button>
            </div>
        </div>
    </div>
</div>

<!-- Approval Modal -->
@if($allevent->created_by_type === 'professional' && $allevent->status === 'pending')
<div class="modal fade" id="approvalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.allevents.approve', $allevent) }}">
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
            <form method="POST" action="{{ route('admin.allevents.reject', $allevent) }}">
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
@endif

<script>
function editMeetLink() {
    new bootstrap.Modal(document.getElementById('meetLinkModal')).show();
}

function saveMeetLink() {
    const meetLink = document.getElementById('meetLinkInput').value;
    
    // Basic URL validation
    if (meetLink && !isValidUrl(meetLink)) {
        alert('Please enter a valid URL');
        return;
    }
    
    // AJAX call to update meet link
    fetch('{{ route('admin.allevents.update-meet-link', $allevent) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            meet_link: meetLink
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Meeting link updated successfully!');
            location.reload();
        } else {
            alert('Error updating meeting link');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating meeting link');
    });
}

function isValidUrl(string) {
    try {
        new URL(string);
        return true;
    } catch (_) {
        return false;
    }
}

function approveEvent() {
    new bootstrap.Modal(document.getElementById('approvalModal')).show();
}

function rejectEvent() {
    new bootstrap.Modal(document.getElementById('rejectionModal')).show();
}

function deleteEvent() {
    if (confirm('Are you sure you want to delete this event? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('admin.allevents.destroy', $allevent) }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection