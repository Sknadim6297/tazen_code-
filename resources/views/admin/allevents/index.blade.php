@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">All Events Management</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Admin</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Events</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Events</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header Close -->

        <!-- Filter & Search -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.allevents.index') }}" id="filterForm">
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <label class="form-label">Created By</label>
                                    <select name="filter" class="form-select">
                                        <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>All Events</option>
                                        <option value="admin" {{ request('filter') == 'admin' ? 'selected' : '' }}>Admin Created</option>
                                        <option value="professional" {{ request('filter') == 'professional' ? 'selected' : '' }}>Professional Created</option>
                                    </select>
                                </div>
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
                                <div class="col-md-2">
                                    <label class="form-label">Search</label>
                                    <input type="text" name="search" class="form-control" placeholder="Search events..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-filter-line me-1"></i>Filter
                                        </button>
                                        <a href="{{ route('admin.allevents.index') }}" class="btn btn-outline-secondary">
                                            <i class="ri-refresh-line"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export Buttons -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('admin.allevents.export.excel', request()->query()) }}" class="btn btn-success btn-sm">
                        <i class="ri-file-excel-line me-1"></i>Export to Excel
                    </a>
                    <a href="{{ route('admin.allevents.export.pdf', request()->query()) }}" class="btn btn-danger btn-sm">
                        <i class="ri-file-pdf-line me-1"></i>Export to PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- Start::row-2 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            All Events (Admin + Professional)
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-task"><i class="ri-add-line fw-medium align-middle me-1"></i> Create Event</button>
                            <!-- Start::add task modal -->
                            <div class="modal fade" id="create-task" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('admin.allevents.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add Event</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                    
                                            <div class="modal-body px-4">
                                                <div class="row gy-3">
                                    
                                                    {{-- Card Image --}}
                                                    <div class="col-xl-12">
                                                        <label for="card_image" class="form-label">Event Image</label>
                                                        <input type="file" class="form-control" id="card_image" name="card_image" accept="image/*" required>
                                                    </div>
                                    
                                                    {{-- Date --}}
                                                    <div class="col-xl-6">
                                                        <label for="date" class="form-label">Event Date</label>
                                                        <input type="date" class="form-control" id="date" name="date" required>
                                                    </div>
                                    
                                                    {{-- Starting Fees --}}
                                                    <div class="col-xl-6">
                                                        <label for="starting_fees" class="form-label">Starting Fees</label>
                                                        <input type="number" class="form-control" id="starting_fees" name="starting_fees" placeholder="Enter Starting Fees" required>
                                                    </div>
                                    
                                                    {{-- Mini Heading --}}
                                                    <div class="col-xl-12">
                                                        <label for="mini_heading" class="form-label">Event Type</label>
                                                        <input type="text" class="form-control" id="mini_heading" name="mini_heading" placeholder="Enter Mini Heading" required>
                                                    </div>
                                    
                                                    {{-- Heading --}}
                                                    <div class="col-xl-12">
                                                        <label for="heading" class="form-label">Event Name</label>
                                                        <input type="text" class="form-control" id="heading" name="heading" placeholder="Enter Main Heading" required>
                                                    </div>
                                    
                                                    {{-- Short Description --}}
                                                    <div class="col-xl-12">
                                                        <label for="short_description" class="form-label">Short Description</label>
                                                        <textarea class="form-control" id="short_description" name="short_description" rows="4" placeholder="Enter a short description about the event" required></textarea>
                                                    </div>
                                    
                                                </div>
                                            </div>
                                    
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Add Event</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Event Image</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Event Type</th>
                                        <th scope="col">Event Name</th>
                                        <th scope="col">Short Description</th>
                                        <th scope="col">Starting Fees</th>
                                        <th scope="col">Meet Link</th>
                                        <th scope="col">Show on Homepage</th>
                                        <th scope="col">Created By</th>
                                        <th scope="col">Service Offered</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($allevents as $event)
                                        <tr>
                                            <td>
                                                <img src="{{ asset('storage/' . $event->card_image) }}" alt="Event Image" width="80" height="80" class="rounded">
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($event->date)->format('d M, Y') }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $event->mini_heading }}</span>
                                            </td>
                                            <td>{{ $event->heading }}</td>
                                            <td>{{ Str::limit($event->short_description, 50) }}</td>
                                            <td>₹{{ number_format($event->starting_fees, 2) }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($event->meet_link)
                                                        <a href="{{ $event->meet_link }}" target="_blank" class="table-action-btn table-action-join me-2" title="Join Meeting">
                                                            <i class="ri-video-line"></i> Join
                                                        </a>
                                                    @else
                                                        <span class="text-muted small">Not set</span>
                                                    @endif
                                                    @if($event->status === 'approved')
                                                        <button type="button" class="table-action-btn table-action-link" onclick="openMeetLinkModal({{ $event->id }}, '{{ $event->meet_link ?? '' }}')">
                                                            <i class="ri-link"></i> Update Link
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" 
                                                           id="homepage_{{ $event->id }}" 
                                                           {{ $event->show_on_homepage ? 'checked' : '' }}
                                                           onchange="toggleHomepageDisplay({{ $event->id }}, this.checked)"
                                                           @if($event->status !== 'approved') disabled @endif>
                                                    <label class="form-check-label" for="homepage_{{ $event->id }}">
                                                        @if($event->show_on_homepage)
                                                            <span class="text-success small">Showing</span>
                                                        @else
                                                            <span class="text-muted small">Hidden</span>
                                                        @endif
                                                    </label>
                                                </div>
                                                @if($event->status !== 'approved')
                                                    <small class="text-muted">Only approved events can be shown</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($event->isProfessionalEvent())
                                                    <div class="d-flex flex-column">
                                                        <span class="badge bg-warning-transparent mb-1">
                                                            <i class="ri-user-star-line"></i> By Professional
                                                        </span>
                                                        @if($event->professional)
                                                            <small class="text-muted">{{ $event->professional->name }}</small>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="badge bg-primary-transparent">
                                                        <i class="ri-admin-line"></i> By Admin
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($event->isProfessionalEvent() && $event->professional)
                                                    @php
                                                        $professionalService = $event->professional->professionalServices->first();
                                                    @endphp
                                                    @if($professionalService)
                                                        <span class="badge bg-info-transparent">
                                                            <i class="ri-service-line"></i> {{ $professionalService->service_name ?? $professionalService->service->name ?? 'N/A' }}
                                                        </span>
                                                        @if($professionalService->category)
                                                            <br><small class="text-muted">{{ $professionalService->category }}</small>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">No service</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($event->status == 'pending')
                                                    <span class="badge bg-warning">
                                                        <i class="ri-time-line"></i> Pending
                                                    </span>
                                                @elseif($event->status == 'approved')
                                                    <span class="badge bg-success">
                                                        <i class="ri-check-line"></i> Approved
                                                    </span>
                                                @elseif($event->status == 'rejected')
                                                    <span class="badge bg-danger">
                                                        <i class="ri-close-line"></i> Rejected
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="table-action-group" role="group">
                                                    @if($event->isProfessionalEvent() && $event->status == 'pending')
                                                        <form action="{{ route('admin.allevents.approve', $event->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="table-action-btn table-action-accept" onclick="return confirm('Are you sure you want to approve this event?')" title="Approve Event">
                                                                <i class="ri-check-line"></i> Accept
                                                            </button>
                                                        </form>
                                                        <button type="button" class="table-action-btn table-action-reject" onclick="openRejectModal({{ $event->id }})" title="Reject Event">
                                                            <i class="ri-close-line"></i> Reject
                                                        </button>
                                                    @endif

                                                    <a href="{{ route('admin.allevents.show', $event->id) }}" class="table-action-btn table-action-view" title="View Details">
                                                        <i class="ri-eye-line"></i> View
                                                    </a>

                                                    @if($event->isAdminEvent() || $event->status != 'pending')
                                                        <a href="{{ route('admin.allevents.edit', $event->id) }}" class="table-action-btn table-action-edit" title="Edit Event">
                                                            <i class="ri-edit-line"></i> Edit
                                                        </a>
                                                    @endif

                                                    <form action="{{ route('admin.allevents.destroy', $event->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="table-action-btn table-action-delete" onclick="return confirm('Are you sure you want to delete this event?')" title="Delete Event">
                                                            <i class="ri-delete-bin-line"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="ri-inbox-line fs-48 mb-3"></i>
                                                    <p>No events found</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer border-top-0">
                        {{ $allevents->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-2 -->
    </div>
</div>

<!-- Reject Event Modal -->
<div class="modal fade" id="rejectEventModal" tabindex="-1" aria-labelledby="rejectEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="rejectEventForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectEventModalLabel">Reject Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Reason for Rejection <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="4" placeholder="Please provide a reason for rejecting this event..." required></textarea>
                        <small class="text-muted">This will be sent to the professional.</small>
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

@endsection

@section('scripts')
<style>
    .table td {
        vertical-align: middle;
    }

    .table-action-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.35rem;
    }

    .table-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.45rem 0.95rem;
        border-radius: 999px;
        border: none;
        font-size: 0.78rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: transform 0.18s ease, box-shadow 0.18s ease, opacity 0.18s ease;
        background: rgba(148, 163, 184, 0.16);
        color: #0f172a;
    }

    .table-action-btn i {
        font-size: 0.95rem;
        line-height: 1;
    }

    .table-action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 22px rgba(15, 23, 42, 0.12);
    }

    .table-action-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .table-action-join {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: #ffffff;
        box-shadow: 0 14px 28px rgba(34, 197, 94, 0.22);
    }

    .table-action-link {
        background: linear-gradient(135deg, #38bdf8, #0ea5e9);
        color: #ffffff;
        box-shadow: 0 14px 28px rgba(14, 165, 233, 0.22);
    }

    .table-action-accept {
        background: linear-gradient(135deg, #4ade80, #22c55e);
        color: #0f172a;
    }

    .table-action-reject {
        background: linear-gradient(135deg, #f97316, #ef4444);
        color: #ffffff;
    }

    .table-action-view {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff;
    }

    .table-action-edit {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: #0f172a;
    }

    .table-action-delete {
        background: linear-gradient(135deg, #f97316, #dc2626);
        color: #ffffff;
    }
</style>

<script>
    // Show success/error messages
    @if(session('success'))
        alert('{{ session('success') }}');
    @endif
    @if(session('error'))
        alert('{{ session('error') }}');
    @endif

    // Open reject modal with event ID
    window.openRejectModal = function(eventId) {
        const form = document.getElementById('rejectEventForm');
        form.action = '{{ url("admin/allevents") }}/' + eventId + '/reject';
        document.getElementById('admin_notes').value = '';
        const modal = new bootstrap.Modal(document.getElementById('rejectEventModal'));
        modal.show();
    };

    // Open meet link modal
    window.openMeetLinkModal = function(eventId, currentLink) {
        document.getElementById('event_id').value = eventId;
        document.getElementById('meet_link').value = currentLink || '';
        const modal = new bootstrap.Modal(document.getElementById('meetLinkModal'));
        modal.show();
    };

    // Update meet link
    window.updateMeetLink = function() {
        const eventId = document.getElementById('event_id').value;
        const meetLink = document.getElementById('meet_link').value;
        
        fetch(`{{ url("admin/allevents") }}/${eventId}/meet-link`, {
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
                alert('Meet link updated successfully!');
                location.reload();
            } else {
                alert('Error updating meet link');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating meet link');
        });
    };

    // Toggle homepage display
    function toggleHomepageDisplay(eventId, showOnHomepage) {
        console.log('Toggling homepage display for event:', eventId, 'show:', showOnHomepage);
        
        // Show loading state
        const checkbox = document.getElementById(`homepage_${eventId}`);
        checkbox.disabled = true;
        
        fetch(`{{ url('admin/allevents') }}/${eventId}/toggle-homepage`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                show_on_homepage: showOnHomepage
            })
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            
            if (data.success) {
                // Update the label text
                const label = document.querySelector(`label[for="homepage_${eventId}"] span`);
                if (label) {
                    if (showOnHomepage) {
                        label.textContent = 'Showing';
                        label.className = 'text-success small';
                    } else {
                        label.textContent = 'Hidden';
                        label.className = 'text-muted small';
                    }
                }
                
                // Show success message
                alert(data.message);
            } else {
                console.error('Server returned error:', data.message);
                alert(data.message || 'Error updating homepage display');
                // Revert the checkbox
                checkbox.checked = !showOnHomepage;
            }
        })
        .catch(error => {
            console.error('Network or parsing error:', error);
            alert('Error updating homepage display: ' + error.message);
            // Revert the checkbox
            checkbox.checked = !showOnHomepage;
        })
        .finally(() => {
            // Re-enable checkbox
            checkbox.disabled = false;
        });
    }
</script>

<!-- Meet Link Modal -->
<div class="modal fade" id="meetLinkModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Meeting Link</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="ri-information-line me-2"></i>
                    Add a meeting link (Zoom, Google Meet, etc.) for this approved event. Customers who book this event will see this link.
                </div>
                <div class="mb-3">
                    <label class="form-label">Meeting Link</label>
                    <input type="hidden" id="event_id">
                    <input type="url" id="meet_link" class="form-control" placeholder="https://zoom.us/j/123456789 or https://meet.google.com/xxx-xxx-xxx">
                    <div class="form-text">Enter the full meeting URL (optional)</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="updateMeetLink()">Update Link</button>
            </div>
        </div>
    </div>
</div>
</script>
@endsection
