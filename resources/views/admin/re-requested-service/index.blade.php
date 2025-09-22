@extends('admin.layouts.layout')

@section('title', 'Re-booking Services')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h4 class="mb-0">{{ $counts['total'] }}</h4>
                                <p class="mb-0">Total Requests</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fas fa-list-alt fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h4 class="mb-0">{{ $counts['pending'] }}</h4>
                                <p class="mb-0">Pending</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h4 class="mb-0">{{ $counts['approved'] }}</h4>
                                <p class="mb-0">Approved</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fas fa-check fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h4 class="mb-0">{{ $counts['paid'] }}</h4>
                                <p class="mb-0">Paid</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fas fa-money-bill fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Re-booking Services Management</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.re-requested-service.export', request()->query()) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-download"></i> Export
                            </a>
                            <a href="{{ route('admin.re-requested-service.analytics') }}" class="btn btn-info btn-sm">
                                <i class="fas fa-chart-bar"></i> Analytics
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Enhanced Filters -->
                        <form method="GET" class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="">All Status</option>
                                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="admin_approved" {{ request('status') === 'admin_approved' ? 'selected' : '' }}>Admin Approved</option>
                                        <option value="customer_paid" {{ request('status') === 'customer_paid' ? 'selected' : '' }}>Customer Paid</option>
                                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="payment_status" class="form-select form-select-sm">
                                        <option value="">Payment Status</option>
                                        <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                        <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Failed</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="priority" class="form-select form-select-sm">
                                        <option value="">Priority</option>
                                        <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                                        <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                                        <option value="normal" {{ request('priority') === 'normal' ? 'selected' : '' }}>Normal</option>
                                        <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}" placeholder="From Date">
                                </div>
                                <div class="col-md-2">
                                    <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}" placeholder="To Date">
                                </div>
                                <div class="col-md-2">
                                    <div class="d-flex gap-1">
                                        <button type="submit" class="btn btn-primary btn-sm flex-fill">
                                            <i class="fas fa-filter"></i> Filter
                                        </button>
                                        <a href="{{ route('admin.re-requested-service.index') }}" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by professional, customer name, or service..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <input type="number" name="price_from" class="form-control form-control-sm" placeholder="Min Price" value="{{ request('price_from') }}" step="0.01">
                                </div>
                                <div class="col-md-2">
                                    <input type="number" name="price_to" class="form-control form-control-sm" placeholder="Max Price" value="{{ request('price_to') }}" step="0.01">
                                </div>
                            </div>
                        </form>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($reRequestedServices->count() > 0)
                            <!-- Bulk Actions -->
                            <form id="bulkActionForm" method="POST" action="{{ route('admin.re-requested-service.bulk-action') }}">
                                @csrf
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="checkbox" id="selectAll" class="form-check-input">
                                        <label for="selectAll" class="form-check-label">Select All</label>
                                        <span class="text-muted">|</span>
                                        <select name="action" id="bulkAction" class="form-select form-select-sm" style="width: auto;">
                                            <option value="">Bulk Actions</option>
                                            <option value="approve">Approve Selected</option>
                                            <option value="reject">Reject Selected</option>
                                            <option value="delete">Delete Selected</option>
                                        </select>
                                        <button type="button" id="executeBulkAction" class="btn btn-sm btn-primary" disabled>
                                            Execute
                                        </button>
                                    </div>
                                    <div class="text-muted">
                                        Total: {{ $reRequestedServices->total() }} requests
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th width="30">
                                                    <input type="checkbox" id="selectAllHeader" class="form-check-input">
                                                </th>
                                                <th>ID</th>
                                                <th>Professional</th>
                                                <th>Customer</th>
                                                <th>Service</th>
                                                <th>Price</th>
                                                <th>CGST/SGST</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Priority</th>
                                                <th>Payment</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($reRequestedServices as $service)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="selected_ids[]" value="{{ $service->id }}" class="form-check-input service-checkbox">
                                                    </td>
                                                    <td>
                                                        <strong class="text-primary">#{{ $service->id }}</strong>
                                                        @if($service->created_at)
                                                            <br><small class="text-muted">Created: {{ $service->created_at->format('d/m/Y H:i') }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <strong>{{ $service->professional->name }}</strong><br>
                                                        <small class="text-muted">{{ $service->professional->email }}</small>
                                                    </td>
                                                    <td>
                                                        <strong>{{ $service->customer->name }}</strong><br>
                                                        <small class="text-muted">{{ $service->customer->email }}</small>
                                                    </td>
                                                    <td>
                                                        {{ $service->service_name }}
                                                        @if($service->originalBooking)
                                                            <br><small class="text-muted">Related: #{{ $service->originalBooking->id }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <strong>₹{{ number_format($service->final_price, 2) }}</strong>
                                                        @if($service->admin_modified_price && $service->admin_modified_price != $service->original_price)
                                                            <br><small class="text-info">Modified from ₹{{ number_format($service->original_price, 2) }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <small>C: ₹{{ number_format($service->cgst_amount, 2) }}</small><br>
                                                        <small>S: ₹{{ number_format($service->sgst_amount, 2) }}</small>
                                                    </td>
                                                    <td>₹{{ number_format($service->total_amount, 2) }}</td>
                                                    <td>{!! $service->status_badge !!}</td>
                                                    <td>{!! $service->priority_badge !!}</td>
                                                    <td>{!! $service->payment_status_badge !!}</td>
                                                    <td>                                                    <td>{{ $service->requested_at->format('d M Y') }}</td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('admin.re-requested-service.show', $service->id) }}" 
                                                               class="btn btn-sm btn-info" title="View">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            @if($service->status === 'pending')
                                                                <a href="{{ route('admin.re-requested-service.edit', $service->id) }}" 
                                                                   class="btn btn-sm btn-warning" title="Edit Price">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                
                                                                <!-- Approve form -->
                                                                <form method="POST" action="{{ route('admin.re-requested-service.approve', $service->id) }}" style="display: inline-block;">
                                                                    @csrf
                                                                    <button type="submit" 
                                                                            class="btn btn-sm btn-success" 
                                                                            title="Approve"
                                                                            onclick="return confirm('Are you sure you want to approve this re-booking request?')">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                </form>
                                                                
                                                                <!-- Reject button -->
                                                                <button type="button" 
                                                                        class="btn btn-sm btn-danger reject-btn" 
                                                                        title="Reject"
                                                                        data-id="{{ $service->id }}">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            @endif
                                                            
                                                            <!-- Email button -->
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-primary email-btn" 
                                                                    title="Send Email"
                                                                    data-id="{{ $service->id }}">
                                                                <i class="fas fa-envelope"></i>
                                                            </button>
                                                            
                                                            <!-- Delete button -->
                                                            <form method="POST" action="{{ route('admin.re-requested-service.destroy', $service->id) }}" style="display: inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" 
                                                                        class="btn btn-sm btn-outline-danger" 
                                                                        title="Delete"
                                                                        onclick="return confirm('Are you sure you want to delete this request? This action cannot be undone.')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="text-muted">
                                    Showing {{ $reRequestedServices->firstItem() }} to {{ $reRequestedServices->lastItem() }} of {{ $reRequestedServices->total() }} results
                                </div>
                                <div>
                                    {{ $reRequestedServices->appends(request()->query())->links() }}
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No re-booking services found</h5>
                                <p class="text-muted">No requests match your current filters.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Action Modal -->
<div class="modal fade" id="bulkActionModal" tabindex="-1" aria-labelledby="bulkActionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkActionModalLabel">Bulk Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to <span id="bulkActionText"></span> the selected <span id="selectedCount"></span> request(s)?</p>
                <div class="mb-3" id="bulkNotesContainer" style="display: none;">
                    <label for="bulk_admin_notes" class="form-label">Notes</label>
                    <textarea name="bulk_admin_notes" id="bulk_admin_notes" class="form-control" rows="3" placeholder="Enter notes (required for rejection)"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmBulkAction">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Reject Re-booking Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="reject-form" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reject_notes" class="form-label">Reason for Rejection <span class="text-danger">*</span></label>
                        <textarea name="admin_notes" id="reject_notes" class="form-control" rows="3" placeholder="Explain why this request is being rejected" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject & Send Notifications</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailModalLabel">Send Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="email-form" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient" class="form-label">Send To <span class="text-danger">*</span></label>
                        <select name="recipient" id="recipient" class="form-select" required>
                            <option value="">Choose Recipient</option>
                            <option value="customer">Customer Only</option>
                            <option value="professional">Professional Only</option>
                            <option value="both">Both Customer & Professional</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email_subject" class="form-label">Subject <span class="text-danger">*</span></label>
                        <input type="text" name="subject" id="email_subject" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email_message" class="form-label">Message <span class="text-danger">*</span></label>
                        <textarea name="message" id="email_message" class="form-control" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Email</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.modal {
    z-index: 1055 !important;
}
.modal-backdrop {
    z-index: 1050 !important;
}
.btn-group .btn {
    margin-right: 2px;
}
.btn-group .btn:last-child {
    margin-right: 0;
}
.service-checkbox:checked {
    background-color: #0d6efd;
}
.table-responsive {
    border-radius: 0.375rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
.btn-group .btn {
    border-radius: 0.25rem !important;
    margin-right: 3px;
}
.btn-group .btn:last-child {
    margin-right: 0;
}
.form-check-input:indeterminate {
    background-color: #0d6efd;
    border-color: #0d6efd;
}
.alert {
    border-radius: 0.5rem;
}
#executeBulkAction:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
.table th {
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}
.table td {
    vertical-align: middle;
}
.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all elements
    const selectAll = document.getElementById('selectAll');
    const selectAllHeader = document.getElementById('selectAllHeader');
    const serviceCheckboxes = document.querySelectorAll('.service-checkbox');
    const bulkAction = document.getElementById('bulkAction');
    const executeBulkAction = document.getElementById('executeBulkAction');
    const bulkActionForm = document.getElementById('bulkActionForm');

    // Function to update select all checkboxes state
    function updateSelectAllState() {
        const totalCheckboxes = serviceCheckboxes.length;
        const checkedCheckboxes = document.querySelectorAll('.service-checkbox:checked').length;
        
        const allSelected = checkedCheckboxes === totalCheckboxes && totalCheckboxes > 0;
        const someSelected = checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes;
        
        // Update main select all checkbox
        if (selectAll) {
            selectAll.checked = allSelected;
            selectAll.indeterminate = someSelected;
        }
        
        // Update header select all checkbox
        if (selectAllHeader) {
            selectAllHeader.checked = allSelected;
            selectAllHeader.indeterminate = someSelected;
        }
        
        // Update execute button state
        if (executeBulkAction) {
            const hasAction = bulkAction && bulkAction.value !== '';
            executeBulkAction.disabled = checkedCheckboxes === 0 || !hasAction;
        }
    }

    // Function to toggle all checkboxes
    function toggleAllCheckboxes(checked) {
        serviceCheckboxes.forEach(checkbox => {
            checkbox.checked = checked;
        });
        updateSelectAllState();
    }

    // Event listeners for select all checkboxes
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            toggleAllCheckboxes(this.checked);
        });
    }

    if (selectAllHeader) {
        selectAllHeader.addEventListener('change', function() {
            toggleAllCheckboxes(this.checked);
        });
    }

    // Event listeners for individual checkboxes
    serviceCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectAllState);
    });

    // Event listener for bulk action dropdown
    if (bulkAction) {
        bulkAction.addEventListener('change', updateSelectAllState);
    }

    // Execute bulk action
    if (executeBulkAction) {
        executeBulkAction.addEventListener('click', function() {
            const selectedAction = bulkAction.value;
            const checkedBoxes = document.querySelectorAll('.service-checkbox:checked');
            
            if (!selectedAction) {
                alert('Please select a bulk action.');
                return;
            }
            
            if (checkedBoxes.length === 0) {
                alert('Please select at least one request.');
                return;
            }

            // Set modal content based on action
            const actionText = selectedAction === 'approve' ? 'approve' : selectedAction === 'reject' ? 'reject' : 'delete';
            document.getElementById('bulkActionText').textContent = actionText;
            document.getElementById('selectedCount').textContent = checkedBoxes.length;
            
            // Show/hide notes container for reject action
            const notesContainer = document.getElementById('bulkNotesContainer');
            if (notesContainer) {
                notesContainer.style.display = selectedAction === 'reject' ? 'block' : 'none';
            }

            // Show modal
            const bulkModal = new bootstrap.Modal(document.getElementById('bulkActionModal'));
            bulkModal.show();
        });
    }

    // Confirm bulk action
    const confirmBulkAction = document.getElementById('confirmBulkAction');
    if (confirmBulkAction) {
        confirmBulkAction.addEventListener('click', function() {
            const selectedAction = bulkAction.value;
            const adminNotes = document.getElementById('bulk_admin_notes')?.value || '';
            
            // Validate notes for reject action
            if (selectedAction === 'reject' && !adminNotes.trim()) {
                alert('Please provide a reason for rejection.');
                return;
            }

            // Add hidden input for admin notes if needed
            if (bulkActionForm) {
                let notesField = bulkActionForm.querySelector('input[name="bulk_admin_notes"]');
                if (!notesField) {
                    notesField = document.createElement('input');
                    notesField.type = 'hidden';
                    notesField.name = 'bulk_admin_notes';
                    bulkActionForm.appendChild(notesField);
                }
                notesField.value = adminNotes;
                
                // Submit the form
                bulkActionForm.submit();
            }
        });
    }

    // Individual reject button functionality
    document.querySelectorAll('.reject-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const serviceId = this.getAttribute('data-id');
            const rejectForm = document.getElementById('reject-form');
            
            if (rejectForm) {
                // Set the correct action URL
                rejectForm.action = `/admin/re-requested-service/${serviceId}/reject`;
                
                // Clear previous notes
                const notesField = document.getElementById('reject_notes');
                if (notesField) {
                    notesField.value = '';
                }
                
                // Show modal
                const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
                rejectModal.show();
            }
        });
    });

    // Individual email button functionality
    document.querySelectorAll('.email-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const serviceId = this.getAttribute('data-id');
            const emailForm = document.getElementById('email-form');
            
            if (emailForm) {
                // Set the correct action URL
                emailForm.action = `/admin/re-requested-service/${serviceId}/send-email`;
                
                // Reset form
                emailForm.reset();
                
                // Show modal
                const emailModal = new bootstrap.Modal(document.getElementById('emailModal'));
                emailModal.show();
            }
        });
    });

    // Reject form validation
    const rejectForm = document.getElementById('reject-form');
    if (rejectForm) {
        rejectForm.addEventListener('submit', function(e) {
            const notes = document.getElementById('reject_notes').value.trim();
            if (!notes) {
                e.preventDefault();
                alert('Please provide a reason for rejection.');
                return false;
            }
        });
    }

    // Email form validation
    const emailForm = document.getElementById('email-form');
    if (emailForm) {
        emailForm.addEventListener('submit', function(e) {
            const recipient = document.getElementById('recipient').value;
            const subject = document.getElementById('email_subject').value.trim();
            const message = document.getElementById('email_message').value.trim();
            
            if (!recipient) {
                e.preventDefault();
                alert('Please select a recipient.');
                return false;
            }
            
            if (!subject) {
                e.preventDefault();
                alert('Please enter a subject.');
                return false;
            }
            
            if (!message) {
                e.preventDefault();
                alert('Please enter a message.');
                return false;
            }
        });
    }

    // Initialize state
    updateSelectAllState();
});
</script>
@endpush
