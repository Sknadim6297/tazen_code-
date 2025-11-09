@extends('professional.layout.layout')

@section('title', 'Create Additional Service')

@section('styles')
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --secondary: #0ea5e9;
        --accent: #22c55e;
        --muted: #64748b;
        --page-bg: #f4f6fb;
        --card-bg: #ffffff;
        --border: rgba(148, 163, 184, 0.22);
    }

    body,
    .app-content {
        background: var(--page-bg);
    }

    .additional-service-create {
        width: 100%;
        padding: 2.6rem 1.45rem 3.6rem;
    }

    .create-shell {
        max-width: 1100px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .create-hero {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1.4rem;
        padding: 2.1rem 2.4rem;
        border-radius: 28px;
        border: 1px solid rgba(79, 70, 229, 0.18);
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(14, 165, 233, 0.14));
        position: relative;
        overflow: hidden;
        box-shadow: 0 24px 54px rgba(79, 70, 229, 0.16);
    }

    .create-hero::before,
    .create-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .create-hero::before {
        width: 340px;
        height: 340px;
        top: -48%;
        right: -14%;
        background: rgba(79, 70, 229, 0.2);
    }

    .create-hero::after {
        width: 220px;
        height: 220px;
        bottom: -45%;
        left: -12%;
        background: rgba(14, 165, 233, 0.16);
    }

    .create-hero > * {
        position: relative;
        z-index: 1;
    }

    .hero-meta {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.38rem 1.05rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.42);
        border: 1px solid rgba(255, 255, 255, 0.6);
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #0f172a;
    }

    .hero-meta h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
    }

    .hero-breadcrumb {
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
        font-size: 0.86rem;
        color: var(--muted);
    }

    .hero-breadcrumb li a {
        color: var(--primary);
        text-decoration: none;
    }

    .form-card {
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: 0 20px 48px rgba(15, 23, 42, 0.14);
        overflow: hidden;
    }

    .form-card__head {
        padding: 1.8rem 2.2rem 1.2rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.22);
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .form-card__head h2 {
        margin: 0;
        font-size: 1.18rem;
        font-weight: 700;
        color: #0f172a;
    }

    .form-card__head p {
        margin: 0;
        color: var(--muted);
        font-size: 0.92rem;
    }

    .form-card__body {
        padding: 2rem 2.2rem;
        display: flex;
        flex-direction: column;
        gap: 1.6rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.6rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.55rem;
    }

    .form-group label {
        font-weight: 600;
        color: #0f172a;
        font-size: 0.92rem;
    }

    .form-control,
    .select2-container--default .select2-selection--single {
        border-radius: 14px !important;
        border: 1px solid rgba(148, 163, 184, 0.35) !important;
        padding: 0.65rem 0.85rem !important;
        font-size: 0.9rem !important;
        transition: border 0.2s ease, box-shadow 0.2s ease;
        min-height: 48px;
    }

    .form-control:focus,
    .select2-container--default .select2-selection--single:focus,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12) !important;
        outline: none;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.2;
        color: #0f172a;
        padding: 0.2rem 0;
    }

    .select2-container .select2-selection--single .select2-selection__arrow {
        top: 50%;
        transform: translateY(-50%);
    }

    textarea.form-control {
        min-height: 140px;
        resize: vertical;
    }

    .form-text {
        font-size: 0.8rem;
        color: var(--muted);
    }

    .price-card {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.15), rgba(14, 165, 233, 0.18));
        border-radius: 20px;
        padding: 1.2rem 1.4rem;
        border: 1px solid rgba(79, 70, 229, 0.26);
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.12);
    }

    .price-card h6 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e1b4b;
        border-bottom: 1px solid rgba(79, 70, 229, 0.28);
        padding-bottom: 0.6rem;
    }

    .price-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .price-label {
        font-size: 0.82rem;
        color: var(--muted);
        font-weight: 600;
    }

    .price-value {
        font-size: 0.9rem;
        font-weight: 700;
        color: #0f172a;
    }

    .price-total {
        margin-top: 0.6rem;
        padding-top: 0.6rem;
        border-top: 1px solid rgba(79, 70, 229, 0.28);
    }

    .price-total .price-label {
        color: #1e40af;
    }

    .price-total .price-value {
        font-size: 1.12rem;
        color: var(--primary-dark);
    }

    .booking-alert {
        border-radius: 18px;
        border: 1px solid rgba(14, 165, 233, 0.22);
        background: rgba(14, 165, 233, 0.12);
        padding: 1.2rem 1.35rem;
        color: #0c4a6e;
        font-size: 0.9rem;
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }

    .cta-footer {
        margin-top: 0.8rem;
        padding-top: 1.6rem;
        border-top: 1px solid rgba(148, 163, 184, 0.18);
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 1rem;
        align-items: center;
    }

    .cta-actions {
        display: inline-flex;
        gap: 0.8rem;
        flex-wrap: wrap;
    }

    .cta-actions .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border-radius: 999px;
        border: none;
        padding: 0.82rem 1.6rem;
        font-weight: 600;
        font-size: 0.92rem;
        text-decoration: none;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffffff;
        box-shadow: 0 18px 40px rgba(79, 70, 229, 0.22);
    }

    .btn-neutral {
        background: rgba(148, 163, 184, 0.18);
        color: #0f172a;
        border: 1px solid rgba(148, 163, 184, 0.35);
    }

    .cta-actions .btn:hover {
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .additional-service-create {
            padding: 2.2rem 1rem 3.2rem;
        }

        .create-hero {
            padding: 1.75rem 1.6rem;
        }

        .form-card__body {
            padding: 1.7rem 1.6rem;
        }

        .cta-footer {
            flex-direction: column;
            align-items: stretch;
        }

        .cta-actions {
            width: 100%;
        }

        .cta-actions .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="additional-service-create">
    <div class="create-shell">
        <section class="create-hero">
            <div class="hero-meta">
                <span class="hero-eyebrow"><i class="fas fa-layer-group"></i>Create</span>
                <h1>New Additional Service</h1>
                <ul class="hero-breadcrumb">
                    <li><a href="{{ route('professional.dashboard') }}">Home</a></li>
                    <li><a href="{{ route('professional.additional-services.index') }}">Additional Services</a></li>
                    <li class="active" aria-current="page">Create</li>
                </ul>
            </div>
            <div class="hero-actions">
                <a href="{{ route('professional.additional-services.index') }}" class="btn-neutral" style="border-radius: 999px; padding: 0.75rem 1.5rem; font-weight: 600; text-decoration: none;">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </section>

        <article class="form-card">
            <header class="form-card__head">
                <h2>Add New Additional Service</h2>
                <p>Link a booking, define the service scope, and preview the GST-inclusive pricing before submitting for review.</p>
            </header>
            <div class="form-card__body">
                <form id="additionalServiceForm">
                    @csrf

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="booking_id">Select Booking <span class="text-danger">*</span></label>
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
                            <small class="form-text">Select the booking this additional service relates to.</small>
                        </div>

                        <div class="form-group">
                            <label for="service_name">Service Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="service_name" name="service_name" placeholder="Enter service name" maxlength="255" required>
                            <small class="form-text">Provide a concise title for the additional service.</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="reason">Reason for Additional Service <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="reason" name="reason" rows="5" placeholder="Explain why this additional service is needed..." required></textarea>
                        <small class="form-text">Share context for the customer and internal review.</small>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="base_price">Base Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="base_price" name="base_price" min="0" step="0.01" placeholder="0.00" required>
                            <small class="form-text">Amount before taxes are applied.</small>
                        </div>

                        <div class="price-card">
                            <h6>Price Breakdown</h6>
                            <div class="price-row">
                                <span class="price-label">Base Price</span>
                                <span class="price-value" id="display_base_price">₹0.00</span>
                            </div>
                            <div class="price-row">
                                <span class="price-label">CGST (9%)</span>
                                <span class="price-value" id="display_cgst">₹0.00</span>
                            </div>
                            <div class="price-row">
                                <span class="price-label">SGST (9%)</span>
                                <span class="price-value" id="display_sgst">₹0.00</span>
                            </div>
                            <div class="price-row price-total">
                                <span class="price-label">Total Price</span>
                                <span class="price-value" id="display_total_price">₹0.00</span>
                            </div>
                        </div>
                    </div>

                    @if($booking)
                        <div class="booking-alert">
                            <strong>Selected Booking Details</strong>
                            <span><strong>Customer:</strong> {{ $booking->customer_name }}</span>
                            <span><strong>Service:</strong> {{ $booking->service_name }}</span>
                            <span><strong>Booking Date:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</span>
                            <span><strong>Amount:</strong> ₹{{ number_format($booking->amount, 2) }}</span>
                        </div>
                    @endif

                    <footer class="cta-footer">
                        <span class="text-muted" style="font-size: 0.82rem;">Fields marked with <span class="text-danger">*</span> are required for submission.</span>
                        <div class="cta-actions">
                            <a href="{{ route('professional.additional-services.index') }}" class="btn btn-neutral">
                                <i class="fas fa-arrow-left"></i>
                                Back to List
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save"></i>
                                Create Additional Service
                            </button>
                        </div>
                    </footer>
                </form>
            </div>
        </article>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#booking_id').select2({
        placeholder: 'Search and select a booking...'
        , allowClear: true,
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

    $('#additionalServiceForm').submit(function(e) {
        e.preventDefault();

        const submitBtn = $('#submitBtn');
        const originalText = submitBtn.html();

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

    calculatePrices();
});
</script>
@endsection