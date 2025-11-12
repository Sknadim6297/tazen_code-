@extends('admin.layouts.layout')

@section('title', 'Additional Services Management')

@section('styles')
<style>
    /* Blink animation for special statuses */
    .blink {
        animation: blink-animation 1.5s infinite;
    }

    @keyframes blink-animation {
        0%, 50% { opacity: 1; }
        51%, 100% { opacity: 0.5; }
    }

    .label-warning.blink {
        background-color: #f39c12 !important;
        color: white !important;
        font-weight: bold;
    }

    /* Modern Card Styling */
    .stats-card {
        border-radius: 12px;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.15);
    }

    .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    /* Filter Section Styling */
    .filter-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .filter-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px 12px 0 0;
        border: none;
        padding: 1rem 1.25rem;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #e1e5e9;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-outline-secondary {
        border-radius: 8px;
        border: 1px solid #e1e5e9;
        color: #6c757d;
        transition: all 0.3s ease;
    }

    /* Table Styling */
    .table-responsive {
        border-radius: 12px;
        overflow-x: auto;
        max-width: 100%;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        min-width: 1200px; /* Ensure minimum width for proper column display */
        margin-bottom: 0;
    }

    .table th {
        background-color: #f8f9fa;
        border: none;
        font-weight: 600;
        color: #495057;
        padding: 1rem 0.75rem;
        white-space: nowrap; /* Prevent header text wrapping */
    }

    .table td {
        border: none;
        border-bottom: 1px solid #e9ecef;
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }

    /* Status badges */
    .badge {
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-semibold fs-18 mb-2">
                    <i class="ri-service-line me-2 text-primary"></i>
                    Additional Services Management
                </h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Additional Services</li>
                    </ol>
                </nav>
            </div>

        </div>



        <!-- Filter Section -->
        <div class="card filter-card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="ri-filter-3-line me-2"></i>
                    Filter Additional Services
                </h5>
            </div>
            <div class="card-body">
                <form id="filter-form" method="GET">
                    <div class="row g-3">
                        <!-- Status Filter -->
                        <div class="col-lg-3 col-md-6">
                            <label for="status-filter" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-checkbox-circle-line me-1"></i>Status
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-flag-line text-muted"></i>
                                </span>
                                <select class="form-select border-start-0" id="status-filter" name="status">
                                    <option value="">All Statuses</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="negotiation" {{ request('status') == 'negotiation' ? 'selected' : '' }}>Under Negotiation</option>
                                </select>
                            </div>
                        </div>

                        <!-- Search Filter -->
                        <div class="col-lg-6 col-md-12">
                            <label for="search-filter" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-search-line me-1"></i>Search Professional or Customer
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-search-2-line text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" id="search-filter" name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Search by professional name, customer name, or service details..."
                                       autocomplete="off">
                                <button class="btn btn-outline-secondary" type="button" onclick="clearSearch()" 
                                        title="Clear search">
                                    <i class="ri-close-line"></i>
                                </button>
                                <button class="btn btn-primary" type="submit" title="Search">
                                    <i class="ri-search-line"></i>
                                </button>
                            </div>
                            <small class="text-muted">
                                <i class="ri-information-line me-1"></i>
                                Search across professional names, customer names, service titles, and descriptions
                                @if(request('search'))
                                    <br><strong class="text-primary">
                                        <i class="ri-search-eye-line me-1"></i>
                                        Currently searching for: "{{ request('search') }}"
                                    </strong>
                                @endif
                            </small>
                        </div>

                        <!-- Date Range -->
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label fw-medium text-muted mb-2">
                                <i class="ri-calendar-line me-1"></i>Date Range
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-calendar-event-line text-muted"></i>
                                </span>
                                <input type="date" class="form-control border-start-0 border-end-0" 
                                       id="date-from" name="date_from" value="{{ request('date_from') }}" placeholder="From Date">
                                <span class="input-group-text bg-light border-start-0 border-end-0 text-muted">to</span>
                                <input type="date" class="form-control border-start-0" 
                                       id="date-to" name="date_to" value="{{ request('date_to') }}" placeholder="To Date">
                            </div>
                        </div>
                    </div>

                    <!-- Filter Actions -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="submit" class="btn btn-primary" id="apply-filters">
                                    <i class="ri-search-line me-1"></i>
                                    Apply Filters
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="clearFilters()">
                                    <i class="ri-refresh-line me-1"></i>
                                    Clear Filters
                                </button>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>

        <!-- Data Table Section -->
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">
                    Additional Services Management
                    @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                        <small class="text-muted ms-2">
                            ({{ $additionalServices->total() }} 
                            {{ Str::plural('result', $additionalServices->total()) }} found)
                        </small>
                    @endif
                </div>
                @if(request('search'))
                    <div class="mt-2">
                        <span class="badge bg-primary-light text-primary">
                            <i class="ri-search-line me-1"></i>
                            Searching: "{{ request('search') }}"
                        </span>
                    </div>
                @endif
            </div>
            <div class="card-body">
                
                <div class="table-responsive">
                    <table class="table text-nowrap table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Service Details</th>
                                <th scope="col">Professional</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Price</th>
                                <th scope="col">Status</th>
                                <th scope="col">Payment</th>
                                <th scope="col">Delivery</th>
                                <th scope="col">Consultation</th>
                                <th scope="col">Created</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($additionalServices as $service)
                            <tr>
                                <td>#{{ $service->id }}</td>
                                <td>
                                    <strong>{{ $service->service_name }}</strong>
                                    @if($service->delivery_date)
                                        <br><small class="text-info">
                                            <i class="fa fa-calendar"></i> 
                                            {{ \Carbon\Carbon::parse($service->delivery_date)->format('M d, Y') }}
                                        </small>
                                    @endif
                                </td>
                                <td>{{ $service->professional->name }}</td>
                                <td>{{ $service->user->name }}</td>
                                
                                <td>
                                    <span class="text-success">
                                        ₹{{ number_format($service->final_price, 2) }}
                                    </span>
                                    @if($service->price_modified_by_admin)
                                        <br><small class="text-warning">
                                            <i class="fa fa-edit"></i> Modified
                                        </small>
                                    @endif
                                    @if($service->negotiation_status !== 'none')
                                        <br><small class="text-info">
                                            <i class="fa fa-handshake-o"></i> 
                                            @if($service->negotiation_status === 'user_negotiated')
                                                <strong class="text-warning">Pending Review</strong>
                                            @else
                                                Negotiated
                                            @endif
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    @if($service->admin_status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($service->admin_status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($service->admin_status === 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                    
                                    @if($service->negotiation_status === 'user_negotiated')
                                        <br><span class="badge bg-warning blink">⚠️ Negotiation Pending</span>
                                    @elseif($service->negotiation_status === 'admin_responded')
                                        <br><span class="badge bg-primary">✅ Responded</span>
                                    @endif
                                </td>
                                <td>
                                    @if($service->payment_status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($service->payment_status === 'paid')
                                        <span class="badge bg-success">Paid</span>
                                        @if($service->professional_payment_status === 'pending')
                                            <br><small class="text-danger">Payout Pending</small>
                                        @else
                                            <br><small class="text-success">Payout Released</small>
                                        @endif
                                    @elseif($service->payment_status === 'failed')
                                        <span class="badge bg-danger">Failed</span>
                                    @endif
                                </td>
                                <td>
                                    @if($service->delivery_date)
                                        <span class="text-info">
                                            <i class="fa fa-calendar"></i>
                                            {{ \Carbon\Carbon::parse($service->delivery_date)->format('M d, Y') }}
                                        </span>
                                        @if($service->delivery_date_set_by_professional_at)
                                            <br><small class="text-muted">Set by Professional</small>
                                        @endif
                                        @if($service->delivery_date_modified_by_admin_at)
                                            <br><small class="text-warning">Modified by Admin</small>
                                        @endif
                                    @else
                                        <span class="text-muted">Not Set</span>
                                    @endif
                                </td>
                                <td>
                                    @if($service->consulting_status === 'pending')
                                        <span class="badge bg-secondary">Not Started</span>
                                    @elseif($service->consulting_status === 'in_progress')
                                        <span class="badge bg-info">In Progress</span>
                                    @elseif($service->consulting_status === 'done')
                                        @if($service->customer_confirmed_at)
                                            <span class="badge bg-success">Completed & Confirmed</span>
                                            <br><small class="text-success">
                                                <i class="fa fa-check"></i> 
                                                {{ \Carbon\Carbon::parse($service->customer_confirmed_at)->format('M d, Y h:i A') }}
                                            </small>
                                        @else
                                            <span class="badge bg-warning text-dark">Awaiting Customer Confirmation</span>
                                            @if($service->professional_completed_at)
                                                <br><small class="text-muted">
                                                    Completed: {{ \Carbon\Carbon::parse($service->professional_completed_at)->format('M d, Y h:i A') }}
                                                </small>
                                            @endif
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $service->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('admin.additional-services.show', $service->id) }}" class="dropdown-item">
                                                    <i class="fa fa-eye"></i> View Details
                                                </a>
                                            </li>
                                            
                                            @if($service->consulting_status === 'done' && $service->payment_status === 'paid')
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a href="{{ route('admin.additional-services.invoice', $service->id) }}" class="dropdown-item">
                                                    <i class="fa fa-file-text"></i> View Invoice
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.additional-services.invoice.pdf', $service->id) }}" class="dropdown-item" target="_blank">
                                                    <i class="fa fa-download"></i> Download PDF Invoice
                                                </a>
                                            </li>
                                            @endif

                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                            @if($additionalServices->count() == 0)
                            <tr>
                                <td colspan="11" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="ri-search-line" style="font-size: 3rem; color: #6c757d; margin-bottom: 1rem;"></i>
                                        <h5 class="text-muted mb-2">No Results Found</h5>
                                        @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                                            <p class="text-muted mb-3">
                                                No additional services match your current filters.
                                                @if(request('search'))
                                                    <br><strong>Search term:</strong> "{{ request('search') }}"
                                                @endif
                                            </p>
                                            <button type="button" class="btn btn-outline-primary" onclick="clearFilters()">
                                                <i class="ri-refresh-line me-2"></i>Clear All Filters
                                            </button>
                                        @else
                                            <p class="text-muted">No additional services have been created yet.</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="dataTables_info">
                        Showing {{ $additionalServices->firstItem() ?? 0 }} to {{ $additionalServices->lastItem() ?? 0 }} 
                        of {{ $additionalServices->total() }} entries
                    </div>
                    <div class="dataTables_paginate">
                        {{ $additionalServices->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Approve Service Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Additional Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="approveForm">
                <div class="modal-body">
                    <p>Are you sure you want to approve this additional service?</p>
                    <div class="form-group">
                        <label for="approve_reason">Approval Note (Optional)</label>
                        <textarea class="form-control" id="approve_reason" name="reason" rows="3" 
                                  placeholder="Add any notes about the approval..."></textarea>
                    </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Approve Service</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Service Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Additional Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="reject_reason">Reason for Rejection *</label>
                        <textarea class="form-control" id="reject_reason" name="reason" rows="4" required
                                  placeholder="Please provide a detailed reason for rejecting this service..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Service</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modify Price Modal -->
<div class="modal fade" id="modifyPriceModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modify Service Price</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="modifyPriceForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="modified_base_price">New Base Price (₹) *</label>
                        <input type="number" class="form-control" id="modified_base_price" name="modified_base_price" 
                               min="0" step="0.01" required>
                        <small class="form-text text-muted">GST will be calculated automatically</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="modification_reason">Reason for Price Modification *</label>
                        <textarea class="form-control" id="modification_reason" name="modification_reason" 
                                  rows="4" required placeholder="Please explain why the price is being modified..."></textarea>
                    </div>
                    
                    <div class="card border-info">
                        <div class="card-body">
                            <h6>Price Calculation Preview:</h6>
                            <div class="row">
                                <div class="col-6">
                                    <small>Base Price: ₹<span id="preview_base">0.00</span></small><br>
                                    <small>CGST (9%): ₹<span id="preview_cgst">0.00</span></small>
                                </div>
                                <div class="col-6">
                                    <small>SGST (9%): ₹<span id="preview_sgst">0.00</span></small><br>
                                    <strong>Total: ₹<span id="preview_total">0.00</span></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Price</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Respond to Negotiation Modal -->
<div class="modal fade" id="negotiationResponseModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Respond to Price Negotiation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="negotiationResponseForm">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>User's Negotiated Price:</strong> ₹<span id="user_negotiated_price">0.00</span><br>
                        <strong>User's Reason:</strong> <span id="user_negotiation_reason">-</span>
                    </div>
                    
                    <div class="form-group">
                        <label for="admin_final_price">Your Final Price (₹) *</label>
                        <input type="number" class="form-control" id="admin_final_price" name="admin_final_price" 
                               min="0" step="0.01" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="admin_response">Your Response *</label>
                        <textarea class="form-control" id="admin_response" name="admin_response" 
                                  rows="4" required placeholder="Provide your response to the negotiation..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Response</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Delivery Date Modal -->
<div class="modal fade" id="deliveryDateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Delivery Date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deliveryDateForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="delivery_date">New Delivery Date *</label>
                        <input type="date" class="form-control" id="delivery_date" name="delivery_date" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="date_change_reason">Reason for Change *</label>
                        <textarea class="form-control" id="date_change_reason" name="date_change_reason" 
                                  rows="3" required placeholder="Explain why the delivery date is being changed..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Date</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Global functions - defined outside document.ready to be accessible from HTML onclick
function clearFilters() {
    // Clear specific form fields
    document.getElementById('status-filter').value = '';
    document.getElementById('search-filter').value = '';
    document.getElementById('date-from').value = '';
    document.getElementById('date-to').value = '';
    
    // Redirect to base URL without query parameters
    window.location.href = '{{ route("admin.additional-services.index") }}';
}

function clearSearch() {
    document.getElementById('search-filter').value = '';
    // Submit the form to apply the cleared search
    document.getElementById('filter-form').submit();
}

// Enhanced search functionality
function performSearch() {
    const searchValue = document.getElementById('search-filter').value.trim();
    console.log('Performing search for:', searchValue); // Debug log
    if (searchValue.length >= 2 || searchValue.length === 0) {
        document.getElementById('filter-form').submit();
    } else if (searchValue.length > 0 && searchValue.length < 2) {
        // Show message for short search terms
        const searchHelp = document.querySelector('.search-help-message');
        if (!searchHelp) {
            const helpMsg = document.createElement('small');
            helpMsg.className = 'text-warning search-help-message';
            helpMsg.innerHTML = '<i class="ri-information-line me-1"></i>Please enter at least 2 characters to search';
            document.getElementById('search-filter').parentNode.appendChild(helpMsg);
            setTimeout(() => helpMsg.remove(), 3000);
        }
    }
}

$(document).ready(function() {
    // Load statistics
    loadStatistics();
    
    // Initialize DataTable
    $('#additional-services-table').DataTable({
        "order": [[ 7, "desc" ]],
        "pageLength": 15,
        "responsive": true
    });
    
    // Enhanced search functionality
    $('#search-filter').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            e.preventDefault();
            performSearch();
        }
    });
    
    // Auto-focus search if there's a search term
    @if(request('search'))
        $('#search-filter').focus();
    @endif
    
    let currentServiceId = null;
    
    // Load statistics
    function loadStatistics() {
        // Get current filter parameters from URL
        const currentParams = new URLSearchParams(window.location.search);
        currentParams.append('ajax_stats', '1');
        
        $.get('{{ route("admin.additional-services.statistics") }}?' + currentParams.toString())
        .done(function(data) {
            $('#total-services').text(data.total || 0);
            $('#pending-services').text(data.pending || 0);
            $('#approved-services').text(data.approved || 0);
            $('#paid-services').text(data.paid || 0);
            $('#negotiation-services').text(data.with_negotiation || 0);
            
            // Update total count in table header
            $('#total-count').text('Total: ' + (data.total || 0));
        })
        .fail(function() {
            console.log('Failed to load statistics');
            // Set default values on failure
            $('#total-services, #pending-services, #approved-services, #paid-services, #negotiation-services').text('0');
            $('#total-count').text('Total: 0');
        });
    }
    
    // Handle filter form submission
    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const queryParams = new URLSearchParams();
        
        // Add only non-empty values to query params
        for (let [key, value] of formData.entries()) {
            if (value.trim() !== '') {
                queryParams.append(key, value);
            }
        }
        
        // Redirect with filters
        const queryString = queryParams.toString();
        window.location.href = '{{ route("admin.additional-services.index") }}' + (queryString ? '?' + queryString : '');
    });

    // Apply filters button (fallback for direct click)
    $('#apply-filters').click(function(e) {
        e.preventDefault();
        $('#filter-form').submit();
    });




    
    // Price calculation for modify price modal
    $('#modified_base_price').on('input', function() {
        const basePrice = parseFloat($(this).val()) || 0;
        const cgst = basePrice * 0.09;
        const sgst = basePrice * 0.09;
        const total = basePrice + cgst + sgst;
        
        $('#preview_base').text(basePrice.toFixed(2));
        $('#preview_cgst').text(cgst.toFixed(2));
        $('#preview_sgst').text(sgst.toFixed(2));
        $('#preview_total').text(total.toFixed(2));
    });
    
    // Modal handlers
    $(document).on('click', '.approve-service', function() {
        currentServiceId = $(this).data('id');
        $('#approveModal').modal('show');
    });
    
    $(document).on('click', '.reject-service', function() {
        currentServiceId = $(this).data('id');
        $('#rejectModal').modal('show');
    });
    
    $(document).on('click', '.modify-price', function() {
        currentServiceId = $(this).data('id');
        $('#modifyPriceModal').modal('show');
    });
    
    $(document).on('click', '.respond-negotiation', function() {
        currentServiceId = $(this).data('id');
        // You would need to fetch the negotiation details here
        $('#negotiationResponseModal').modal('show');
    });
    
    $(document).on('click', '.update-delivery-date', function() {
        currentServiceId = $(this).data('id');
        $('#deliveryDateModal').modal('show');
    });
    
    $(document).on('click', '.release-payment', function() {
        const serviceId = $(this).data('id');
        if (confirm('Are you sure you want to release payment to the professional?')) {
            $.ajax({
                url: `/admin/additional-services/${serviceId}/release-payment`,
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        location.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('An error occurred. Please try again.');
                }
            });
        }
    });
    
    // Form submissions
    $('#approveForm').submit(function(e) {
        e.preventDefault();
        submitAction('approve', $(this).serialize());
    });
    
    $('#rejectForm').submit(function(e) {
        e.preventDefault();
        submitAction('reject', $(this).serialize());
    });
    
    $('#modifyPriceForm').submit(function(e) {
        e.preventDefault();
        submitAction('modify-price', $(this).serialize());
    });
    
    $('#negotiationResponseForm').submit(function(e) {
        e.preventDefault();
        submitAction('respond-negotiation', $(this).serialize());
    });
    
    $('#deliveryDateForm').submit(function(e) {
        e.preventDefault();
        submitAction('update-delivery-date', $(this).serialize());
    });
    
    function submitAction(action, data) {
        if (!currentServiceId) return;
        
        $.ajax({
            url: `/admin/additional-services/${currentServiceId}/${action}`,
            type: 'POST',
            data: data + '&_token={{ csrf_token() }}',
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    location.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    Object.values(errors).forEach(function(error) {
                        toastr.error(error[0]);
                    });
                } else {
                    toastr.error('An error occurred. Please try again.');
                }
            }
        });
        
        $('.modal').modal('hide');
    }
    

});
</script>
@endsection