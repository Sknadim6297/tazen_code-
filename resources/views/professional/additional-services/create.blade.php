@extends('professional.layout.layout')

@section('title', 'Create Additional Service')

@section('style')
<style>
    /* Core layout */
    .content-wrapper {
        background-color: #f8f9fa;
        padding: 1.5rem;
        min-height: calc(100vh - 60px);
    }
    
    .page-header {
        margin-bottom: 1.5rem;
    }
    
    .page-header .page-title h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }

    /* Card styling */
    .card {
        background-color: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        border: 1px solid #e9ecef;
    }
    
    .card-header {
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        padding: 1rem 1.25rem;
        border-radius: 0.5rem 0.5rem 0 0;
    }

    .card-header h4 {
        font-size: 1.125rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    .card-body {
        padding: 1.25rem;
    }

    /* Form elements */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.875rem;
    }

    .form-control {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        background-color: #ffffff;
    }

    .form-control:focus {
        border-color: #0d67c7;
        outline: none;
        box-shadow: 0 0 0 3px rgba(13, 103, 199, 0.1);
        background-color: #f0f7ff;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .form-text {
        font-size: 0.8125rem;
        color: #6c757d;
        margin-top: 0.375rem;
        display: block;
    }

    /* Price breakdown card */
    .price-card {
        background: linear-gradient(135deg, #e3f2fd 0%, #f0f7ff 100%);
        border: 1px solid #90caf9;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-top: 0.5rem;
    }

    .price-card h6 {
        font-size: 0.9375rem;
        font-weight: 700;
        color: #0d47a1;
        margin: 0 0 0.875rem 0;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #90caf9;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.625rem;
    }

    .price-label {
        font-size: 0.8125rem;
        color: #495057;
        font-weight: 500;
    }

    .price-value {
        font-size: 0.875rem;
        font-weight: 600;
        color: #2c3e50;
    }

    .price-total {
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 2px solid #90caf9;
    }

    .price-total .price-label {
        font-weight: 700;
        color: #0d47a1;
    }

    .price-total .price-value {
        font-size: 1.125rem;
        font-weight: 700;
        color: #28a745;
    }

    /* Info alert */
    .alert-info {
        background: linear-gradient(135deg, #d1ecf1 0%, #c3e6ec 100%);
        border-left: 4px solid #17a2b8;
        border-radius: 0.5rem;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        color: #0c5460;
    }

    .alert-info strong {
        color: #0a3f4a;
    }

    /* Buttons */
    .btn {
        padding: 0.625rem 1.25rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-primary {
        background-color: #0d67c7;
        color: white;
        box-shadow: 0 2px 6px rgba(13, 103, 199, 0.25);
    }

    .btn-primary:hover {
        background-color: #0b5bb5;
        box-shadow: 0 4px 10px rgba(13, 103, 199, 0.35);
        transform: translateY(-1px);
    }

    .btn-primary:disabled {
        background-color: #6c757d;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .btn-default {
        background-color: #6c757d;
        color: white;
        box-shadow: 0 2px 6px rgba(108, 117, 125, 0.25);
    }

    .btn-default:hover {
        background-color: #5a6268;
        box-shadow: 0 4px 10px rgba(108, 117, 125, 0.35);
        transform: translateY(-1px);
        color: white;
    }

    /* Breadcrumb */
    .breadcrumb {
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 14px;
    }

    .breadcrumb li {
        display: inline;
        color: #6c757d;
    }

    .breadcrumb li:not(:last-child):after {
        content: '/';
        margin: 0 8px;
        color: #adb5bd;
    }

    .breadcrumb li.active {
        color: #495057;
        font-weight: 500;
    }

    .breadcrumb a {
        color: #0d67c7;
        text-decoration: none;
    }

    /* Select2 overrides */
    .select2-container--default .select2-selection--single {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        padding: 0.25rem 0.5rem;
        height: auto;
    }

    .select2-container--default .select2-selection--single:focus,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #0d67c7;
        box-shadow: 0 0 0 3px rgba(13, 103, 199, 0.1);
    }

    /* Grid layout */
    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    /* Utilities */
    .mt-3 {
        margin-top: 1.5rem;
    }

    .mt-2 {
        margin-top: 1rem;
    }

    .mb-0 {
        margin-bottom: 0;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .text-success {
        color: #28a745 !important;
    }

    .text-center {
        text-align: center;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .content-wrapper {
            padding: 1rem;
        }

        .page-header .page-title h3 {
            font-size: 1.25rem;
        }

        .card-body {
            padding: 1rem;
        }

        .form-grid-2,
        [style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
            gap: 0 !important;
        }

        .price-card {
            margin-top: 1rem;
        }

        .btn {
            width: 100%;
            justify-content: center;
            margin-bottom: 0.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="page-title">
            <h3>Create Additional Service</h3>
        </div>
        <ul class="breadcrumb">
            <li><a href="{{ route('professional.dashboard') }}">Home</a></li>
            <li><a href="{{ route('professional.additional-services.index') }}">Additional Services</a></li>
            <li class="active">Create</li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Add New Additional Service</h4>
        </div>
        <div class="card-body">
            <form id="additionalServiceForm">
                @csrf
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
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
                        <small class="form-text">Select the booking this additional service is related to</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="service_name">Service Name *</label>
                        <input type="text" class="form-control" id="service_name" name="service_name" 
                               placeholder="Enter service name" maxlength="255" required>
                        <small class="form-text">Brief name for the additional service</small>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="reason">Reason for Additional Service *</label>
                    <textarea class="form-control" id="reason" name="reason" rows="4" 
                              placeholder="Explain why this additional service is needed..." required></textarea>
                    <small class="form-text">Provide detailed explanation for the customer</small>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label for="base_price">Base Price (₹) *</label>
                        <input type="number" class="form-control" id="base_price" name="base_price" 
                               min="0" step="0.01" placeholder="0.00" required>
                        <small class="form-text">Price excluding GST</small>
                    </div>
                    
                    <div class="price-card">
                        <h6>Price Breakdown</h6>
                        <div class="price-row">
                            <span class="price-label">Base Price:</span>
                            <span class="price-value" id="display_base_price">₹0.00</span>
                        </div>
                        <div class="price-row">
                            <span class="price-label">CGST (9%):</span>
                            <span class="price-value" id="display_cgst">₹0.00</span>
                        </div>
                        <div class="price-row">
                            <span class="price-label">SGST (9%):</span>
                            <span class="price-value" id="display_sgst">₹0.00</span>
                        </div>
                        <div class="price-row price-total">
                            <span class="price-label">Total Price:</span>
                            <span class="price-value" id="display_total_price">₹0.00</span>
                        </div>
                    </div>
                </div>
                
                @if($booking)
                <div class="alert-info">
                    <strong>Selected Booking Details:</strong><br>
                    <strong>Customer:</strong> {{ $booking->customer_name }}<br>
                    <strong>Service:</strong> {{ $booking->service_name }}<br>
                    <strong>Booking Date:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}<br>
                    <strong>Amount:</strong> ₹{{ number_format($booking->amount, 2) }}
                </div>
                @endif
                
                <div class="text-center" style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e9ecef;">
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
@endsection

@section('scripts')
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
                const items = (data || []).map(function(item) {
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
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });
    
    // Initial calculation
    calculatePrices();
});
</script>
@endsection