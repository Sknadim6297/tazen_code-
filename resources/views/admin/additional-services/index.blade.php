@extends('admin.layouts.layout')

@section('title', 'Additional Services Management')

@section('styles')
<style>
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
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Additional Services Management</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Additional Services</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-md-2 col-sm-6">
        <div class="info-box">
            <div class="info-box-icon bg-blue">
                <i class="fa fa-list-alt"></i>
            </div>
            <div class="info-box-content">
                <span class="info-box-text">Total Services</span>
                <span class="info-box-number" id="total-services">-</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-2 col-sm-6">
        <div class="info-box">
            <div class="info-box-icon bg-yellow">
                <i class="fa fa-clock-o"></i>
            </div>
            <div class="info-box-content">
                <span class="info-box-text">Pending</span>
                <span class="info-box-number" id="pending-services">-</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-2 col-sm-6">
        <div class="info-box">
            <div class="info-box-icon bg-green">
                <i class="fa fa-check"></i>
            </div>
            <div class="info-box-content">
                <span class="info-box-text">Approved</span>
                <span class="info-box-number" id="approved-services">-</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-2 col-sm-6">
        <div class="info-box">
            <div class="info-box-icon bg-aqua">
                <i class="fa fa-credit-card"></i>
            </div>
            <div class="info-box-content">
                <span class="info-box-text">Paid</span>
                <span class="info-box-number" id="paid-services">-</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-2 col-sm-6">
        <div class="info-box">
            <div class="info-box-icon bg-purple">
                <i class="fa fa-handshake-o"></i>
            </div>
            <div class="info-box-content">
                <span class="info-box-text">Negotiations</span>
                <span class="info-box-number" id="negotiation-services">-</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-2 col-sm-6">
        <div class="info-box">
            <div class="info-box-icon bg-red">
                <i class="fa fa-money"></i>
            </div>
            <div class="info-box-content">
                <span class="info-box-text">Pending Payouts</span>
                <span class="info-box-number" id="pending-payouts">₹0</span>
            </div>
        </div>
    </div>
</div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between d-flex align-items-center">
                        <div class="card-title">Additional Services List</div>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-sm btn-outline-secondary">Export</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                
                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-2">
                        <select class="form-control" id="status-filter">
                            <option value="">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                            <option value="paid">Paid</option>
                            <option value="negotiation">Under Negotiation</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" id="professional-filter">
                            <option value="">All Professionals</option>
                            @foreach($professionals as $professional)
                                <option value="{{ $professional->id }}">{{ $professional->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" id="user-filter">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control" id="date-from" placeholder="From Date">
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control" id="date-to" placeholder="To Date">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary" id="apply-filters">Apply Filters</button>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="additional-services-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Service Name</th>
                                <th>Professional</th>
                                <th>Customer</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Delivery Date</th>
                                <th>Consultation</th>
                                <th>Created</th>
                                <th>Actions</th>
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
                                        <span class="label label-warning">Pending</span>
                                    @elseif($service->admin_status === 'approved')
                                        <span class="label label-success">Approved</span>
                                    @elseif($service->admin_status === 'rejected')
                                        <span class="label label-danger">Rejected</span>
                                    @endif
                                    
                                    @if($service->negotiation_status === 'user_negotiated')
                                        <br><span class="label label-warning blink">⚠️ Negotiation Pending</span>
                                    @elseif($service->negotiation_status === 'admin_responded')
                                        <br><span class="label label-primary">✅ Responded</span>
                                    @endif
                                </td>
                                <td>
                                    @if($service->payment_status === 'pending')
                                        <span class="label label-warning">Pending</span>
                                    @elseif($service->payment_status === 'paid')
                                        <span class="label label-success">Paid</span>
                                        @if($service->professional_payment_status === 'pending')
                                            <br><small class="text-danger">Payout Pending</small>
                                        @else
                                            <br><small class="text-success">Payout Released</small>
                                        @endif
                                    @elseif($service->payment_status === 'failed')
                                        <span class="label label-danger">Failed</span>
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
                                        <span class="label label-secondary">Not Started</span>
                                    @elseif($service->consulting_status === 'in_progress')
                                        <span class="label label-info">In Progress</span>
                                    @elseif($service->consulting_status === 'done')
                                        @if($service->customer_confirmed_at)
                                            <span class="label label-success">Completed & Confirmed</span>
                                            <br><small class="text-success">
                                                <i class="fa fa-check"></i> 
                                                {{ \Carbon\Carbon::parse($service->customer_confirmed_at)->format('M d, Y h:i A') }}
                                            </small>
                                        @else
                                            <span class="label label-warning">Awaiting Customer Confirmation</span>
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
                                            

                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                    <div class="card-footer border-top-0">
                        <nav aria-label="Page navigation">
                            {{ $additionalServices->appends(request()->query())->links() }}
                        </nav>
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
$(document).ready(function() {
    // Load statistics
    loadStatistics();
    
    // Initialize DataTable
    $('#additional-services-table').DataTable({
        "order": [[ 7, "desc" ]],
        "pageLength": 15,
        "responsive": true
    });
    
    let currentServiceId = null;
    
    // Load statistics
    function loadStatistics() {
        $.get('{{ route("admin.additional-services.statistics") }}', function(data) {
            $('#total-services').text(data.total);
            $('#pending-services').text(data.pending);
            $('#approved-services').text(data.approved);
            $('#paid-services').text(data.paid);
            $('#negotiation-services').text(data.with_negotiation);
            $('#pending-payouts').text('₹' + Number(data.pending_payouts).toLocaleString());
        });
    }
    
    // Apply filters
    $('#apply-filters').click(function() {
        const filters = {
            status: $('#status-filter').val(),
            professional: $('#professional-filter').val(),
            user: $('#user-filter').val(),
            date_from: $('#date-from').val(),
            date_to: $('#date-to').val()
        };
        
        const queryString = Object.keys(filters)
            .filter(key => filters[key])
            .map(key => key + '=' + encodeURIComponent(filters[key]))
            .join('&');
            
        window.location.href = '{{ route("admin.additional-services.index") }}' + (queryString ? '?' + queryString : '');
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