@extends('professional.layout.layout')

@section('title', 'Create Additional Service')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="page-title">
            <h3>Create Additional Service</h3>
        </div>
        <ul class="breadcrumb">
            <li><a href="{{ route('professional.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('professional.additional-services.index') }}">Additional Services</a></li>
            <li class="active">Create</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <div class="card-block">
                    <h4 class="card-title">Add New Additional Service</h4>
                
                <form id="additionalServiceForm" class="mt-3">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="booking_id">Select Booking *</label>
                                <select class="form-control select2" id="booking_id" name="booking_id" required>
                                    <option value="">Choose a booking...</option>
                                    @if($booking)
                                        <option value="{{ $booking->id }}" selected>
                                            {{ $booking->customer_name }} - {{ $booking->service_name }} - {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                                        </option>
                                    @else
                                        @foreach($bookings as $bookingOption)
                                            <option value="{{ $bookingOption->id }}">
                                                {{ $bookingOption->customer_name }} - {{ $bookingOption->service_name }} - {{ \Carbon\Carbon::parse($bookingOption->booking_date)->format('M d, Y') }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <small class="form-text text-muted">Select the booking this additional service is related to</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="service_name">Service Name *</label>
                                <input type="text" class="form-control" id="service_name" name="service_name" 
                                       placeholder="Enter service name" maxlength="255" required>
                                <small class="form-text text-muted">Brief name for the additional service</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="reason">Reason for Additional Service *</label>
                                <textarea class="form-control" id="reason" name="reason" rows="4" 
                                          placeholder="Explain why this additional service is needed..." required></textarea>
                                <small class="form-text text-muted">Provide detailed explanation for the customer</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="base_price">Base Price (₹) *</label>
                                <input type="number" class="form-control" id="base_price" name="base_price" 
                                       min="0" step="0.01" placeholder="0.00" required>
                                <small class="form-text text-muted">Price excluding GST</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">Price Breakdown</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted">Base Price:</small><br>
                                            <span id="display_base_price">₹0.00</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">CGST (9%):</small><br>
                                            <span id="display_cgst">₹0.00</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <small class="text-muted">SGST (9%):</small><br>
                                            <span id="display_sgst">₹0.00</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted"><strong>Total Price:</strong></small><br>
                                            <strong class="text-success" id="display_total_price">₹0.00</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($booking)
                    <div class="alert alert-info">
                        <strong>Selected Booking Details:</strong><br>
                        <strong>Customer:</strong> {{ $booking->customer_name }}<br>
                        <strong>Service:</strong> {{ $booking->service_name }}<br>
                        <strong>Booking Date:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}<br>
                        <strong>Amount:</strong> ₹{{ number_format($booking->amount, 2) }}
                    </div>
                    @endif
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-save"></i> Create Additional Service
                        </button>
                        <a href="{{ route('professional.additional-services.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Select2 for booking dropdown
    $('#booking_id').select2({
        placeholder: "Search and select a booking...",
        allowClear: true,
        ajax: {
            url: '{{ route("professional.additional-services.get-bookings") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term
                };
            },
            processResults: function (data) {
                // Ensure Select2 receives items in { id, text } format.
                // The server may return full booking objects; map them to a display string that includes the booking date.
                const items = (data || []).map(function(item) {
                    // Format booking date if present
                    let dateText = '';
                    if (item.booking_date) {
                        try {
                            const d = new Date(item.booking_date);
                            dateText = d.toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });
                        } catch (e) {
                            dateText = item.booking_date;
                        }
                    }

                    const customer = item.customer_name || item.name || '';
                    const service = item.service_name || item.service || '';
                    const textParts = [customer, service];
                    if (dateText) textParts.push(dateText);

                    return {
                        id: item.id,
                        text: textParts.filter(Boolean).join(' - '),
                        raw: item
                    };
                });

                return { results: items };
            },
            cache: true
        }
    });
    
    // Real-time price calculation
    $('#base_price').on('input', function() {
        calculatePrices();
    });
    
    function calculatePrices() {
        const basePrice = parseFloat($('#base_price').val()) || 0;
        const cgst = basePrice * 0.09;
        const sgst = basePrice * 0.09;
        const totalPrice = basePrice + cgst + sgst;
        
        $('#display_base_price').text('₹' + basePrice.toFixed(2));
        $('#display_cgst').text('₹' + cgst.toFixed(2));
        $('#display_sgst').text('₹' + sgst.toFixed(2));
        $('#display_total_price').text('₹' + totalPrice.toFixed(2));
    }
    
    // Form submission
    $('#additionalServiceForm').submit(function(e) {
        e.preventDefault();
        
        const submitBtn = $('#submitBtn');
        const originalText = submitBtn.html();
        
        // Disable button and show loading
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Creating...');
        
        $.ajax({
            url: '{{ route("professional.additional-services.store") }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    }
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
                } else if (xhr.responseJSON?.message) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error('An error occurred. Please try again.');
                }
            },
            complete: function() {
                // Re-enable button
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });
    
    // Initial calculation
    calculatePrices();
});
</script>
@endsection