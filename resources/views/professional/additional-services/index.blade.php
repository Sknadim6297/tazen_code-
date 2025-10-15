@extends('professional.layout.layout')

@section('title', 'Additional Services')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="page-title">
            <h3>Additional Services</h3>
        </div>
        <ul class="breadcrumb">
            <li><a href="{{ route('professional.dashboard') }}">Dashboard</a></li>
            <li class="active">Additional Services</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <div class="card-block">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">Additional Services List</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('professional.additional-services.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add New Service
                            </a>
                        </div>
                    </div>
                
                @if($additionalServices->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="additional-services-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Service Name</th>
                                <th>Customer</th>
                                <th>Booking Ref</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Payment Status</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($additionalServices as $service)
                            <tr>
                                <td>#{{ $service->id }}</td>
                                <td>{{ $service->service_name }}</td>
                                <td>{{ $service->user->name }}</td>
                                <td>
                                    <a href="#" class="text-primary">
                                        #{{ $service->booking_id }}
                                    </a>
                                </td>
                                <td>₹{{ number_format($service->final_price, 2) }}</td>
                                <td>
                                    @if($service->admin_status === 'pending')
                                        <span class="label label-warning">Pending Admin</span>
                                    @elseif($service->admin_status === 'approved')
                                        <span class="label label-success">Approved</span>
                                    @elseif($service->admin_status === 'rejected')
                                        <span class="label label-danger">Rejected</span>
                                    @endif
                                    
                                    @if($service->negotiation_status !== 'none')
                                        @if($service->negotiation_status === 'user_negotiated')
                                            <br><small class="text-warning">⏳ Negotiation Pending Admin</small>
                                        @elseif($service->negotiation_status === 'admin_responded')
                                            <br><small class="text-success">✅ Price Updated</small>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if($service->payment_status === 'pending')
                                        <span class="label label-warning">Pending</span>
                                    @elseif($service->payment_status === 'paid')
                                        <span class="label label-success">Paid</span>
                                    @elseif($service->payment_status === 'failed')
                                        <span class="label label-danger">Failed</span>
                                    @endif
                                </td>
                                <td>{{ $service->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" 
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cog"></i> Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('professional.additional-services.show', $service->id) }}" class="dropdown-item">
                                                    <i class="fas fa-eye"></i> View Details
                                                </a>
                                            </li>
                                            @if($service->canBeCompletedByProfessional())
                                            <li>
                                                <a href="javascript:void(0)" class="dropdown-item mark-completed" data-id="{{ $service->id }}">
                                                    <i class="fas fa-check"></i> Mark Completed
                                                </a>
                                            </li>
                                            @endif
                                            @if(!$service->delivery_date_set)
                                            <li>
                                                <a href="javascript:void(0)" class="dropdown-item set-delivery-date" data-id="{{ $service->id }}">
                                                    <i class="fas fa-calendar"></i> Set Delivery Date
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $additionalServices->links() }}
                        </div>
                @else
                        <div class="text-center py-5">
                            <i class="fas fa-plus-circle fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">No Additional Services Found</h4>
                            <p class="text-muted">You haven't created any additional services yet.</p>
                            <a href="{{ route('professional.additional-services.create') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus"></i> Create Your First Additional Service
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
</div>

<!-- Mark Completed Modal -->
<div class="modal fade" id="markCompletedModal" tabindex="-1" aria-labelledby="markCompletedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="markCompletedModalLabel">Mark Consultation Completed</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to mark this consultation as completed? The customer will be notified to confirm the completion.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmComplete">
                    <i class="fas fa-check"></i> Mark Completed
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Set Delivery Date Modal -->
<div class="modal fade" id="deliveryDateModal" tabindex="-1" aria-labelledby="deliveryDateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deliveryDateModalLabel">Set Delivery Date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deliveryDateForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="delivery_date" class="form-label">Delivery Date *</label>
                        <input type="date" class="form-control" id="delivery_date" name="delivery_date" 
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-calendar-check"></i> Set Date
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#additional-services-table').DataTable({
        "order": [[ 7, "desc" ]],
        "pageLength": 10,
        "responsive": true
    });
    
    let currentServiceId = null;



    // Mark Completed
    $(document).on('click', '.mark-completed', function(e) {
        e.preventDefault();
        e.stopPropagation();
        currentServiceId = $(this).data('id');
        console.log('Mark completed clicked for service:', currentServiceId);
        var modal = new bootstrap.Modal(document.getElementById('markCompletedModal'));
        modal.show();
    });

    $('#confirmComplete').click(function() {
        if (currentServiceId) {
            $.ajax({
                url: `/professional/additional-services/${currentServiceId}/mark-completed`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        location.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error('An error occurred. Please try again.');
                }
            });
        }
        var modal = bootstrap.Modal.getInstance(document.getElementById('markCompletedModal'));
        modal.hide();
    });

    // Set Delivery Date
    $(document).on('click', '.set-delivery-date', function(e) {
        e.preventDefault();
        e.stopPropagation();
        currentServiceId = $(this).data('id');
        console.log('Set delivery date clicked for service:', currentServiceId);
        var modal = new bootstrap.Modal(document.getElementById('deliveryDateModal'));
        modal.show();
    });

    $('#deliveryDateForm').submit(function(e) {
        e.preventDefault();
        
        if (currentServiceId) {
            $.ajax({
                url: `/professional/additional-services/${currentServiceId}/set-delivery-date`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    delivery_date: $('#delivery_date').val()
                },
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
        }
        var modal = bootstrap.Modal.getInstance(document.getElementById('deliveryDateModal'));
        modal.hide();
    });
});
</script>
@endsection