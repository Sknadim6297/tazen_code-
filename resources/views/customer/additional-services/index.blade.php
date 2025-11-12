@extends('customer.layout.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/appointment.css') }}" />
<style>
    :root {
        --add-primary: #f97316;
        --add-primary-dark: #ea580c;
        --add-secondary: #0ea5e9;
        --add-muted: #64748b;
        --add-neutral: #1f2937;
        --add-bg: #f6f7fb;
        --add-surface: #ffffff;
        --add-border: rgba(148, 163, 184, 0.22);
    }

    html,
    body {
        overflow-x: hidden;
    }

    body,
    .app-content {
        background: var(--add-bg) !important;
    }

    .customer-additional-page {
        width: 100%;
        padding: 2.6rem 1.45rem 3.6rem;
    }

    .customer-additional-shell {
        max-width: 1220px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .additional-hero {
        position: relative;
        overflow: hidden;
        padding: 2.2rem 2.6rem;
        border-radius: 32px;
        border: 1px solid rgba(249, 115, 22, 0.18);
        background: linear-gradient(135deg, rgba(249, 115, 22, 0.12), rgba(14, 165, 233, 0.18));
        box-shadow: 0 28px 64px rgba(249, 115, 22, 0.18);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1.6rem;
    }

    .additional-hero::before,
    .additional-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .additional-hero::before {
        width: 360px;
        height: 360px;
        top: -48%;
        right: -15%;
        background: rgba(249, 115, 22, 0.22);
    }

    .additional-hero::after {
        width: 240px;
        height: 240px;
        bottom: -50%;
        left: -18%;
        background: rgba(14, 165, 233, 0.24);
    }

    .additional-hero > * { position: relative; z-index: 1; }

    .additional-hero .hero-copy {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        color: #422006;
    }

    .additional-hero .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.45rem 1.05rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        background: rgba(255, 255, 255, 0.52);
        border: 1px solid rgba(255, 255, 255, 0.6);
    }

    .additional-hero h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
    }

    .additional-hero p {
        margin: 0;
        font-size: 0.96rem;
        max-width: 540px;
        color: rgba(66, 32, 6, 0.8);
    }

    .additional-hero .hero-illustration {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.68);
        border: 1px solid rgba(255, 255, 255, 0.75);
        box-shadow: inset 0 18px 38px rgba(255, 255, 255, 0.42);
        color: rgba(66, 32, 6, 0.76);
        font-size: 3rem;
    }

    .additional-card,
    .additional-content-card {
        background: var(--add-surface);
        border-radius: 28px;
        border: 1px solid var(--add-border);
        box-shadow: 0 24px 52px rgba(15, 23, 42, 0.12);
        padding: 2.3rem 2.4rem;
        display: flex;
        flex-direction: column;
        gap: 1.6rem;
    }

    .additional-card header,
    .additional-content-header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .additional-card header h2,
    .additional-content-header h2 {
        margin: 0;
        font-size: 1.16rem;
        font-weight: 700;
        color: var(--add-neutral);
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.2rem 1.4rem;
        align-items: flex-end;
    }

    .filter-grid .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
    }

    .filter-grid label {
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--add-neutral);
    }

    .filter-grid input,
    .filter-grid select {
        border-radius: 14px;
        border: 1px solid rgba(226, 232, 240, 0.9);
        padding: 0.85rem 1rem;
        font-size: 0.94rem;
        background: rgba(249, 250, 251, 0.92);
        transition: border 0.2s ease, box-shadow 0.2s ease;
    }

    .filter-grid input:focus,
    .filter-grid select:focus {
        border-color: var(--add-primary);
        box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.16);
        outline: none;
        background: #ffffff;
    }

    .filter-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        align-items: center;
    }

    .filter-actions .btn {
        padding: 0.85rem 1.55rem;
        font-size: 0.9rem;
        border-radius: 999px;
        font-weight: 600;
        border: none;
        cursor: pointer;
    }

    .filter-actions .btn-success {
        background: linear-gradient(135deg, var(--add-primary), var(--add-primary-dark));
        color: #ffffff;
        box-shadow: 0 20px 40px rgba(249, 115, 22, 0.22);
    }

    .filter-actions .btn-secondary {
        background: rgba(148, 163, 184, 0.16);
        color: var(--add-muted);
        border: 1px solid rgba(148, 163, 184, 0.32);
    }

    .additional-summary {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
    }

    .additional-summary h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
        color: var(--add-muted);
    }

    .additional-table-wrapper {
        border-radius: 24px;
        border: 1px solid rgba(226, 232, 240, 0.85);
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .additional-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 1080px;
    }

    .additional-table thead th {
        background: rgba(249, 250, 251, 0.95);
        color: var(--add-neutral);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        font-size: 0.76rem;
        padding: 0.95rem 1rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.9);
    }

    .additional-table tbody td {
        padding: 0.95rem 1rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        color: var(--add-neutral);
        font-size: 0.92rem;
        vertical-align: middle;
    }

    .additional-table tbody tr:hover { background: rgba(248, 250, 252, 0.82); }

    .badge,
    .badge-pending,
    .badge-paid,
    .badge-in-progress,
    .badge-completed,
    .badge-approved,
    .badge-rejected {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        border: 1px solid transparent;
    }

    .badge-pending { background: #fff3cd; color: #856404; border-color: #ffeaa7; }
    .badge-paid { background: #d1ecf1; color: #0c5460; border-color: #bee5eb; }
    .badge-in-progress { background: #e2e3e5; color: #383d41; border-color: #ced0d2; }
    .badge-completed,
    .badge-approved { background: #d4edda; color: #155724; border-color: #c3e6cb; }
    .badge-rejected { background: #f8d7da; color: #721c24; border-color: #f5c6cb; }

    .additional-table tbody td[data-label] {
        position: relative;
    }

    .btn {
        padding: 0.55rem 1.05rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.84rem;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }

    .pay-now-btn {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: #ffffff;
        box-shadow: 0 18px 32px rgba(40, 167, 69, 0.24);
    }

    .btn-group-vertical { display: flex; flex-direction: column; gap: 0.45rem; }

    .empty-state {
        text-align: center;
        padding: 3.2rem 1.6rem;
        border-radius: 24px;
        border: 1px dashed rgba(148, 163, 184, 0.4);
        background: rgba(248, 250, 252, 0.92);
        color: var(--add-muted);
    }

    .empty-state i { font-size: 3rem; color: rgba(148, 163, 184, 0.6); margin-bottom: 1rem; }

    .custom-modal {
        display: none;
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(6px);
        z-index: 1050;
        opacity: 0;
        transition: opacity 0.3s ease;
        overflow-y: auto;
        padding: 20px 0;
    }

    .custom-modal.show { opacity: 1; display: flex; align-items: center; justify-content: center; }

    .modal-content {
        background: #fff;
        border-radius: 22px;
        box-shadow: 0 26px 52px rgba(15, 23, 42, 0.22);
        max-width: 520px;
        width: 92%;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        animation: slideIn 0.35s ease;
        margin: 1rem;
    }

    .modal-header {
        background: linear-gradient(135deg, var(--add-secondary), #0284c7);
        color: #fff;
        padding: 1.4rem 2rem;
        border-radius: 22px 22px 0 0;
        position: relative;
    }

    .modal-title { margin: 0; font-size: 1.2rem; font-weight: 600; }

    .modal-close {
        position: absolute;
        top: 1rem;
        right: 1.5rem;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: #fff;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-body { padding: 2rem; }

    .modal-footer {
        padding: 1.4rem 2rem;
        border-top: 1px solid rgba(226, 232, 240, 0.82);
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    @keyframes slideIn {
        from { transform: translateY(40px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    @media (max-width: 1024px) {
        .additional-table { min-width: 960px; }
    }

    @media (max-width: 768px) {
        .customer-additional-page { padding: 2.2rem 1.05rem 3.1rem; }
        .additional-hero { padding: 1.9rem 1.6rem; }
        .additional-card,
        .additional-content-card { padding: 2rem 1.9rem; }
        .filter-actions { flex-direction: column; align-items: stretch; }
        .filter-grid { grid-template-columns: 1fr; }
        .additional-table-wrapper { border: none; background: transparent; overflow: visible; }
        .additional-table { min-width: 100%; border-spacing: 0; }
        .additional-table thead { display: none; }
        .additional-table tbody { display: flex; flex-direction: column; gap: 1.2rem; }
        .additional-table tbody tr {
            display: block;
            border: 1px solid var(--add-border);
            border-radius: 20px;
            background: var(--add-surface);
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }
        .additional-table tbody td {
            display: block;
            padding: 0.95rem 1.15rem;
            border-bottom: 1px solid rgba(226, 232, 240, 0.7);
            font-size: 0.9rem;
        }
        .additional-table tbody td:last-child {
            border-bottom: none;
            padding-bottom: 1.2rem;
        }
        .additional-table tbody td::before {
            content: attr(data-label);
            display: block;
            font-weight: 700;
            font-size: 0.76rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--add-muted);
            margin-bottom: 0.35rem;
        }
        .btn-group-vertical {
            width: 100%;
        }
        .btn-group-vertical .btn {
            width: 100%;
            justify-content: center;
        }
        .additional-summary { flex-direction: column; align-items: flex-start; }
        .modal-content { width: 94%; }
    }

    @media (max-width: 576px) {
        .additional-hero .hero-illustration { width: 110px; height: 110px; font-size: 2.4rem; }
        .modal-body { padding: 1.6rem; }
        .modal-footer { padding: 1.1rem 1.6rem; flex-direction: column; }
        .modal-footer .btn { width: 100%; }
    }
</style>
@endsection

@section('content')
<div class="customer-additional-page">
    <div class="customer-additional-shell">
        <section class="additional-hero">
            <div class="hero-copy">
                <span class="hero-eyebrow"><i class="ri-service-line"></i>Services</span>
                <h1>Additional Services</h1>
                <p>Track every add-on service, monitor payments, review consultation progress, and manage invoices from one place.</p>
            </div>
            <div class="hero-illustration">
                <i class="ri-customer-service-2-line"></i>
            </div>
        </section>

        <section class="additional-card">
            <header>
                <h2>Filter services</h2>
            </header>
            <form action="{{ route('user.additional-services.index') }}" method="GET" id="filter-form">
                <div class="filter-grid">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Payment Pending</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="professional">Professional</label>
                        <select id="professional" name="professional" class="form-control">
                            <option value="">All Professionals</option>
                            @foreach($professionals ?? [] as $professional)
                                <option value="{{ $professional->id }}" {{ request('professional') == $professional->id ? 'selected' : '' }}>
                                    {{ $professional->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-success">Apply Filters</button>
                    <a href="{{ route('user.additional-services.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </section>

        <section class="additional-content-card">
            <div class="additional-summary">
                <h3>Results: {{ $additionalServices->count() }} {{ Str::plural('service', $additionalServices->count()) }}</h3>
            </div>

            @if($additionalServices->count() > 0)
                <div class="additional-table-wrapper">
                    <table class="additional-table">
                        <thead>
                            <tr>
                                <th>Service Name</th>
                                <th>Professional</th>
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
                                    <td data-label="Service Name">
                                        <strong>{{ $service->service_name }}</strong>
                                        @if($service->delivery_date)
                                            <br><small class="text-info"><i class="fas fa-calendar"></i> Delivery: {{ \Carbon\Carbon::parse($service->delivery_date)->format('M d, Y') }}</small>
                                        @endif
                                    </td>
                                    <td data-label="Professional">{{ $service->professional->name }}</td>
                                    <td data-label="Booking Ref"><a href="#" class="text-primary">#{{ $service->booking_id }}</a></td>
                                    <td data-label="Total Price"><span class="text-success font-weight-bold">₹{{ number_format($service->final_price, 2) }}</span>@if($service->negotiation_status !== 'none')<br><small class="text-warning"><i class="fas fa-handshake"></i> Negotiated</small>@endif</td>
                                    <td data-label="Status">
                                        @if($service->consulting_status === 'in_progress')
                                            <span class="badge badge-in-progress">In Progress</span>
                                        @elseif($service->consulting_status === 'done' && !$service->customer_confirmed_at)
                                            <span class="badge badge-pending">Awaiting Confirmation</span>
                                        @elseif($service->isConsultationCompleted())
                                            <span class="badge badge-completed">Completed</span>
                                        @else
                                            <span class="badge badge-approved">Active</span>
                                        @endif
                                    </td>
                                    <td data-label="Payment Status">
                                        @if($service->payment_status === 'pending')
                                            <span class="badge badge-pending">Pending</span>
                                        @elseif($service->payment_status === 'paid')
                                            <span class="badge badge-paid">Paid</span>
                                        @elseif($service->payment_status === 'failed')
                                            <span class="badge badge-rejected">Failed</span>
                                        @endif
                                    </td>
                                    <td data-label="Created Date">{{ $service->created_at->format('d M Y') }}</td>
                                    <td data-label="Actions">
                                        <div class="btn-group-vertical">
                                            @if($service->payment_status === 'pending')
                                                <button class="btn btn-sm pay-now-btn mb-2" data-id="{{ $service->id }}" data-amount="{{ $service->final_price }}"><i class="fas fa-credit-card"></i> Pay ₹{{ number_format($service->final_price, 2) }}</button>
                                            @endif
                                            <a href="{{ route('user.additional-services.show', $service->id) }}" class="btn btn-sm btn-info mb-1"><i class="fas fa-eye"></i> View Details</a>
                                            @if($service->payment_status === 'paid')
                                                @if($service->consulting_status === 'not_started')
                                                    <span class="btn btn-sm btn-outline-warning mb-1" disabled><i class="fas fa-clock"></i> Awaiting Professional</span>
                                                @elseif($service->consulting_status === 'in_progress')
                                                    <span class="btn btn-sm btn-outline-primary mb-1" disabled><i class="fas fa-user-md"></i> Consulting in Progress</span>
                                                @elseif($service->consulting_status === 'done' && !$service->customer_confirmed_at)
                                                    <button class="btn btn-sm btn-primary confirm-completion-btn mb-1" data-id="{{ $service->id }}"><i class="fas fa-check-circle"></i> Confirm Completion</button>
                                                @elseif($service->customer_confirmed_at)
                                                    <span class="btn btn-sm btn-success mb-1" disabled><i class="fas fa-check-double"></i> Completed</span>
                                                @endif
                                            @endif
                                            @if($service->negotiation_status !== 'none')
                                                @if($service->negotiation_status === 'user_negotiated')
                                                    <span class="btn btn-sm btn-outline-warning mb-1" disabled><i class="fas fa-handshake"></i> Negotiation Pending</span>
                                                @elseif($service->negotiation_status === 'admin_responded')
                                                    <span class="btn btn-sm btn-outline-info mb-1" disabled><i class="fas fa-reply"></i> Professional Responded</span>
                                                @endif
                                            @endif
                                            @if($service->consulting_status === 'done' && $service->payment_status === 'paid')
                                                <div class="mt-2 pt-2 border-top">
                                                    <a href="{{ route('user.additional-services.invoice', $service->id) }}" class="btn btn-sm btn-success mb-1"><i class="fas fa-file-text"></i> View Invoice</a>
                                                    <a href="{{ route('user.additional-services.invoice.pdf', $service->id) }}" class="btn btn-sm btn-outline-success mb-1" target="_blank"><i class="fas fa-download"></i> Download PDF</a>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-info-circle"></i>
                    <h4>No additional services found</h4>
                    <p>Professionals may add additional services based on your bookings. Check back later to see new offerings.</p>
                </div>
            @endif
        </section>
    </div>
</div>
<!-- Modals remain unchanged -->
@endsection

@section('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
$(document).ready(function() {
    let currentServiceId = null;

    // Custom Modal Functions
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    // Make closeModal available globally
    window.closeModal = closeModal;

    // Close modal when clicking outside
    $('.custom-modal').click(function(e) {
        if (e.target === this) {
            closeModal(this.id);
        }
    });

    // Close modal with Escape key
    $(document).keydown(function(e) {
        if (e.keyCode === 27) {
            $('.custom-modal.show').each(function() {
                closeModal(this.id);
            });
        }
    });

    // Remove negotiate button functionality from index page
    // Negotiation should only be available on the detail page
    
    // Enhanced Pay Now button with amount display
    $('.pay-now-btn').click(function() {
        const serviceId = $(this).data('id');
        const amount = $(this).data('amount');
        const $btn = $(this);
        const originalText = $btn.html();
        
        // Show loading state
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        
        // Add visual feedback
        toastr.info('Preparing payment for ₹' + parseFloat(amount).toFixed(2) + '...');
        
        $.ajax({
            url: `/user/additional-services/${serviceId}/create-payment-order`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Controller returns: { success, order_id, amount, currency, key, service_name }
                    const rkey = response.key || response.razorpay_key || '{{ config('services.razorpay.key') }}';
                    const ramount = response.amount || response.order_amount || 0; // amount in paise
                    const rcurrency = response.currency || 'INR';
                    const rorderId = response.order_id || response.orderId || null;

                    if (!rorderId || !ramount) {
                        toastr.error('Invalid payment order returned from server. Please try again.');
                        $btn.prop('disabled', false).html(originalText);
                        return;
                    }

                    const options = {
                        key: rkey,
                        amount: ramount,
                        currency: rcurrency,
                        name: '{{ config('app.name') }}',
                        description: response.service_name || response.description || 'Additional Service Payment',
                        order_id: rorderId,
                        handler: function (razorpayResponse) {
                            handlePaymentSuccess(serviceId, razorpayResponse);
                        },
                        prefill: {
                            name: '{{ Auth::guard('user')->user()->name }}',
                            email: '{{ Auth::guard('user')->user()->email }}',
                            contact: '{{ Auth::guard('user')->user()->phone }}'
                        },
                        theme: {
                            color: '#28a745'
                        },
                        modal: {
                            ondismiss: function() {
                                toastr.warning('Payment cancelled by user');
                                $btn.prop('disabled', false).html(originalText);
                            }
                        }
                    };

                    const rzp = new Razorpay(options);
                    rzp.open();
                    
                    rzp.on('payment.failed', function (response) {
                        toastr.error('Payment failed: ' + response.error.description);
                        $btn.prop('disabled', false).html(originalText);
                    });
                } else {
                    toastr.error(response.message);
                    $btn.prop('disabled', false).html(originalText);
                }
            },
            error: function(xhr) {
                let errorMessage = 'Unable to initiate payment. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                toastr.error(errorMessage);
                $btn.prop('disabled', false).html(originalText);
            }
    });

    // Confirm completion button with enhanced feedback
    $('.confirm-completion-btn').click(function() {
        currentServiceId = $(this).data('id');
        console.log('Opening confirm modal for service (index):', currentServiceId);
        openModal('confirmCompletionModal');
    });

    // Handle payment success with enhanced feedback and consultation enabling
    function handlePaymentSuccess(serviceId, paymentResponse) {
        toastr.success('Payment successful! Verifying and enabling consultation...');
        
        $.ajax({
            url: `/user/additional-services/${serviceId}/payment-success`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                razorpay_payment_id: paymentResponse.razorpay_payment_id,
                razorpay_order_id: paymentResponse.razorpay_order_id,
                razorpay_signature: paymentResponse.razorpay_signature
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('✅ ' + response.message + ' Professional can now start consulting!');
                    
                    // Show success animation and reload
                    setTimeout(() => {
                        toastr.info('🔄 Refreshing page to show updated status...');
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                toastr.error('Payment verification failed. Please contact support.');
            }
        });
    }
    // Confirm completion with enhanced feedback
    $('#confirmCompletionBtn').click(function() {
        if (!currentServiceId) return;
        
        const $btn = $(this);
        const originalText = $btn.html();
        
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Confirming...');
        
        $.ajax({
            url: `/user/additional-services/${currentServiceId}/confirm-consultation`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    closeModal('confirmCompletionModal');
                    toastr.success('✅ ' + response.message);
                    setTimeout(() => location.reload(), 2000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                toastr.error('An error occurred. Please try again.');
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Enhanced mobile interactions
    if (window.innerWidth <= 768) {
        // Improve touch interactions on mobile
        $('.btn').on('touchstart', function() {
            $(this).addClass('active');
        }).on('touchend', function() {
            $(this).removeClass('active');
        });
    }

    // Add smooth animations to cards and enhance Pay Now button visibility
    $('.card').each(function(index) {
        $(this).css({
            'animation-delay': (index * 0.1) + 's'
        });
    });
    
    // Highlight Pay Now buttons for better visibility
    $('.pay-now-btn').addClass('pulse-animation');
});
});
</script>
@endsection
