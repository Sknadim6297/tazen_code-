@extends('admin.layouts.layout')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Professional Events</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Events</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Professional Events</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.professional-events.index') }}" id="filterForm">
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">From Date</label>
                                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">To Date</label>
                                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Search</label>
                                    <input type="text" name="search" class="form-control" placeholder="Search events or professionals..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-filter-line me-1"></i>Filter
                                        </button>
                                        <a href="{{ route('admin.professional-events.index') }}" class="btn btn-outline-secondary">
                                            <i class="ri-refresh-line"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-success" onclick="exportData('excel')">
                                            <i class="ri-file-excel-2-line me-1"></i> Export to Excel
                                        </button>
                                        <button type="button" class="btn btn-danger" onclick="exportData('pdf')">
                                            <i class="ri-file-pdf-line me-1"></i> Export to PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex align-items-top">
                            <div class="me-3">
                                <span class="avatar avatar-md bg-primary-transparent">
                                    <i class="ri-calendar-event-line fs-16"></i>
                                </span>
                            </div>
                            <div class="flex-fill">
                                <h6 class="fw-semibold mb-0">{{ $stats['total'] }}</h6>
                                <span class="text-muted">Total Events</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex align-items-top">
                            <div class="me-3">
                                <span class="avatar avatar-md bg-warning-transparent">
                                    <i class="ri-time-line fs-16"></i>
                                </span>
                            </div>
                            <div class="flex-fill">
                                <h6 class="fw-semibold mb-0">{{ $stats['pending'] }}</h6>
                                <span class="text-muted">Pending Approval</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex align-items-top">
                            <div class="me-3">
                                <span class="avatar avatar-md bg-success-transparent">
                                    <i class="ri-check-circle-line fs-16"></i>
                                </span>
                            </div>
                            <div class="flex-fill">
                                <h6 class="fw-semibold mb-0">{{ $stats['approved'] }}</h6>
                                <span class="text-muted">Approved</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex align-items-top">
                            <div class="me-3">
                                <span class="avatar avatar-md bg-danger-transparent">
                                    <i class="ri-close-circle-line fs-16"></i>
                                </span>
                            </div>
                            <div class="flex-fill">
                                <h6 class="fw-semibold mb-0">{{ $stats['rejected'] }}</h6>
                                <span class="text-muted">Rejected</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Events Table -->
        <div class="row">
            <div class="col-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Professional Events Management
                        </div>
                        <div class="d-flex">
                            <button type="button" class="btn btn-sm btn-success me-2" onclick="bulkApprove()">
                                <i class="ri-check-line me-1"></i> Bulk Approve
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="bulkReject()">
                                <i class="ri-close-line me-1"></i> Bulk Reject
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if($events->count() > 0)
                            <form id="bulkActionForm" method="POST">
                                @csrf
                                <input type="hidden" name="action" id="bulkAction">
                                <input type="hidden" name="admin_notes" id="bulkNotes">
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" id="selectAll" class="form-check-input">
                                                </th>
                                                <th>Event Image</th>
                                                <th>Professional</th>
                                                <th>Services Offered</th>
                                                <th>Event Details</th>
                                                <th>Date</th>
                                                <th>Fees</th>
                                                <th>Meet Link</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($events as $event)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="event_ids[]" value="{{ $event->id }}" class="form-check-input event-checkbox">
                                                    </td>
                                                    <td>
                                                        <img src="{{ asset('storage/' . $event->card_image) }}" alt="Event Image" class="rounded" width="60" height="60" style="object-fit: cover;">
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <strong>{{ $event->professional->name }}</strong>
                                                            <br>
                                                            <small class="text-muted">{{ $event->professional->email }}</small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            @if($event->professional->professionalServices && $event->professional->professionalServices->count() > 0)
                                                                @foreach($event->professional->professionalServices->take(3) as $service)
                                                                    <span class="badge bg-primary me-1 mb-1">{{ $service->service->name ?? 'N/A' }}</span>
                                                                @endforeach
                                                                @if($event->professional->professionalServices->count() > 3)
                                                                    <span class="badge bg-secondary">+{{ $event->professional->professionalServices->count() - 3 }} more</span>
                                                                @endif
                                                            @else
                                                                <small class="text-muted">No services listed</small>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <strong>{{ $event->heading }}</strong>
                                                            <br>
                                                            <span class="badge bg-info">{{ $event->mini_heading }}</span>
                                                            <br>
                                                            <small class="text-muted">{{ Str::limit($event->short_description, 80) }}</small>
                                                        </div>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                                                    <td>₹{{ number_format($event->starting_fees, 2) }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if($event->meet_link)
                                                                <a href="{{ $event->meet_link }}" target="_blank" class="btn btn-sm btn-success me-2" title="Join Meeting">
                                                                    <i class="ri-video-line"></i>
                                                                </a>
                                                            @endif
                                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="editMeetLink({{ $event->id }}, '{{ $event->meet_link }}')" title="Edit Meet Link">
                                                                <i class="ri-edit-line"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($event->status === 'pending')
                                                            <span class="badge bg-warning">Pending</span>
                                                        @elseif($event->status === 'approved')
                                                            <span class="badge bg-success">Approved</span>
                                                        @else
                                                            <span class="badge bg-danger">Rejected</span>
                                                        @endif
                                                        
                                                        @if($event->admin_notes)
                                                            <br>
                                                            <small class="text-muted" title="{{ $event->admin_notes }}">
                                                                <i class="ri-message-line"></i> Has notes
                                                            </small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('admin.professional-events.show', $event) }}" class="btn btn-sm btn-info">
                                                                <i class="ri-eye-line"></i>
                                                            </a>
                                                            
                                                            @if($event->status === 'pending')
                                                                <button type="button" class="btn btn-sm btn-success" onclick="approveEvent({{ $event->id }})">
                                                                    <i class="ri-check-line"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-danger" onclick="rejectEvent({{ $event->id }})">
                                                                    <i class="ri-close-line"></i>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                            
                            <!-- Pagination -->
                            <div class="card-footer">
                                {{ $events->withQueryString()->links() }}
                            </div>
                        @else
                            <div class="text-center p-4">
                                <i class="ri-calendar-event-line fs-48 text-muted"></i>
                                <h5 class="mt-3">No Events Found</h5>
                                <p class="text-muted">No professional events match your current filters.</p>
                            </div>
                        @endif
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
                <h5 class="modal-title" id="approvalModalTitle">Approve Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="approvalForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Admin Notes (Optional)</label>
                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="Add any notes for the professional..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="approvalSubmitBtn">Approve Event</button>
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
            <form id="rejectionForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="Please provide a reason for rejection..." required></textarea>
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
// Select all functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.event-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Individual approval
function approveEvent(eventId) {
    document.getElementById('approvalForm').action = `/admin/professional-events/${eventId}/approve`;
    new bootstrap.Modal(document.getElementById('approvalModal')).show();
}

// Individual rejection
function rejectEvent(eventId) {
    document.getElementById('rejectionForm').action = `/admin/professional-events/${eventId}/reject`;
    new bootstrap.Modal(document.getElementById('rejectionModal')).show();
}

// Bulk approve
function bulkApprove() {
    const selectedEvents = document.querySelectorAll('.event-checkbox:checked');
    if (selectedEvents.length === 0) {
        alert('Please select at least one event to approve.');
        return;
    }
    
    const notes = prompt('Enter optional notes for bulk approval:');
    if (notes !== null) { // User didn't cancel
        // Clear any existing event inputs
        document.querySelectorAll('input[name="events[]"]').forEach(input => input.remove());
        
        // Add selected event IDs to form
        selectedEvents.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'events[]';
            input.value = checkbox.value;
            document.getElementById('bulkActionForm').appendChild(input);
        });
        
        document.getElementById('bulkAction').value = 'approve';
        document.getElementById('bulkNotes').value = notes;
        document.getElementById('bulkActionForm').action = '{{ route("admin.professional-events.bulk-action") }}';
        document.getElementById('bulkActionForm').submit();
    }
}

// Bulk reject
function bulkReject() {
    const selectedEvents = document.querySelectorAll('.event-checkbox:checked');
    if (selectedEvents.length === 0) {
        alert('Please select at least one event to reject.');
        return;
    }
    
    const notes = prompt('Enter rejection reason (required):');
    if (notes && notes.trim() !== '') {
        // Clear any existing event inputs
        document.querySelectorAll('input[name="events[]"]').forEach(input => input.remove());
        
        // Add selected event IDs to form
        selectedEvents.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'events[]';
            input.value = checkbox.value;
            document.getElementById('bulkActionForm').appendChild(input);
        });
        
        document.getElementById('bulkAction').value = 'reject';
        document.getElementById('bulkNotes').value = notes;
        document.getElementById('bulkActionForm').action = '{{ route("admin.professional-events.bulk-action") }}';
        document.getElementById('bulkActionForm').submit();
    } else if (notes !== null) {
        alert('Rejection reason is required.');
    }
}

// Meet link management
function editMeetLink(eventId, currentLink) {
    const newLink = prompt('Enter meet link (leave empty to remove):', currentLink || '');
    if (newLink !== null) {
        fetch(`/admin/professional-events/${eventId}/meet-link`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ meet_link: newLink })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Refresh to show updated meet link
            } else {
                alert('Error updating meet link: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the meet link.');
        });
    }
}

// Export data function
function exportData(format) {
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    
    // Build query string from form data
    const params = new URLSearchParams(formData);
    params.append('export', format);
    
    // Redirect to export URL with filters
    window.location.href = '{{ route("admin.professional-events.index") }}?' + params.toString();
}
</script>
@endsection