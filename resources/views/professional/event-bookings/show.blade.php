@extends('professional.layout.layout')

@section('styles')
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --success: #16a34a;
        --warning: #f59e0b;
        --danger: #dc2626;
        --slate-900: #0f172a;
        --slate-700: #334155;
        --slate-500: #64748b;
        --surface: #ffffff;
        --surface-soft: #f8fafc;
        --accent-bg: linear-gradient(135deg, rgba(79, 70, 229, 0.18), rgba(14, 165, 233, 0.22));
        --shadow-lg: 0 26px 48px rgba(15, 23, 42, 0.12);
        --radius-xl: 26px;
    }

    body {
        background: #eef1f8;
    }

    .event-show-page {
        padding: 2.6rem 1.6rem 3.4rem;
        background: linear-gradient(180deg, rgba(79, 70, 229, 0.08), rgba(255, 255, 255, 0.9));
        min-height: 100vh;
    }

    .event-show-shell {
        max-width: 1240px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .event-hero {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.8rem;
        padding: 2.4rem 2.6rem;
        border-radius: var(--radius-xl);
        background: var(--accent-bg);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .event-hero::before,
    .event-hero::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        opacity: 0.45;
    }

    .event-hero::before {
        width: 320px;
        height: 320px;
        top: -140px;
        right: -120px;
        background: rgba(79, 70, 229, 0.35);
    }

    .event-hero::after {
        width: 220px;
        height: 220px;
        bottom: -140px;
        left: -90px;
        background: rgba(14, 165, 233, 0.35);
    }

    .event-hero > * {
        position: relative;
        z-index: 1;
    }

    .event-hero__meta {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        color: var(--slate-700);
    }

    .event-hero__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        background: rgba(255, 255, 255, 0.7);
        border-radius: 999px;
        padding: 0.45rem 1.3rem;
        font-size: 0.76rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--slate-900);
        border: 1px solid rgba(255, 255, 255, 0.75);
        align-self: flex-start;
        backdrop-filter: blur(8px);
    }

    .event-hero__title {
        font-size: 2.4rem;
        font-weight: 800;
        line-height: 1.2;
        color: var(--slate-900);
        margin: 0.5rem 0;
    }

    .event-hero__subtitle {
        font-size: 1.1rem;
        font-weight: 500;
        color: var(--slate-500);
        line-height: 1.6;
        margin-bottom: 1.2rem;
    }

    .event-hero__actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.8rem;
    }

    .event-layout {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 2rem;
    }

    @media (max-width: 1024px) {
        .event-layout {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
    }

    .event-card {
        background: var(--surface);
        border-radius: var(--radius-xl);
        padding: 2.4rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(148, 163, 184, 0.15);
    }

    .event-card__header {
        margin-bottom: 1.8rem;
    }

    .event-card__title {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--slate-900);
        margin: 0 0 0.6rem 0;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .event-card__subtitle {
        color: var(--slate-500);
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .event-details-grid {
        display: grid;
        gap: 1.6rem;
    }

    .event-detail {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .event-detail__icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: rgba(79, 70, 229, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .event-detail__content {
        flex: 1;
    }

    .event-detail__label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--slate-500);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.3rem;
    }

    .event-detail__value {
        font-size: 1rem;
        font-weight: 500;
        color: var(--slate-900);
        line-height: 1.5;
    }

    .booking-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.2rem;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .booking-status--pending {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .booking-status--confirmed {
        background: rgba(34, 197, 94, 0.1);
        color: #16a34a;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .booking-status--cancelled {
        background: rgba(220, 38, 38, 0.1);
        color: #dc2626;
        border: 1px solid rgba(220, 38, 38, 0.3);
    }

    .booking-status--completed {
        background: rgba(79, 70, 229, 0.1);
        color: var(--primary);
        border: 1px solid rgba(79, 70, 229, 0.3);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        padding: 0.85rem 1.8rem;
        border-radius: 14px;
        font-size: 0.95rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        line-height: 1;
    }

    .btn--primary {
        background: var(--primary);
        color: white;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
    }

    .btn--primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
    }

    .btn--secondary {
        background: var(--surface-soft);
        color: var(--slate-700);
        border: 1px solid rgba(148, 163, 184, 0.3);
    }

    .btn--secondary:hover {
        background: #e2e8f0;
        border-color: rgba(148, 163, 184, 0.5);
    }

    .btn--success {
        background: var(--success);
        color: white;
        box-shadow: 0 4px 14px rgba(34, 197, 94, 0.35);
    }

    .btn--success:hover {
        background: #15803d;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
    }

    .btn--warning {
        background: var(--warning);
        color: white;
        box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35);
    }

    .btn--warning:hover {
        background: #d97706;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
    }

    .btn--danger {
        background: var(--danger);
        color: white;
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.35);
    }

    .btn--danger:hover {
        background: #b91c1c;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
    }

    .actions-card {
        position: sticky;
        top: 2rem;
        height: fit-content;
    }

    .actions-grid {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    /* Modal Styles */
    .modal-content {
        border-radius: 16px;
        overflow: hidden;
    }

    .modal-header {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(14, 165, 233, 0.1));
        padding: 1.5rem 1.75rem 1rem;
    }

    .modal-title {
        color: var(--slate-900);
        font-size: 1.25rem;
    }

    .modal-body {
        padding: 1rem 1.75rem;
    }

    .modal-footer {
        padding: 1rem 1.75rem 1.5rem;
        gap: 0.75rem;
    }

    /* Alert Styles */
    .alert {
        border: none;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(10px);
    }

    .alert-success {
        background: rgba(34, 197, 94, 0.95);
        color: white;
    }

    .alert-danger {
        background: rgba(220, 38, 38, 0.95);
        color: white;
    }

    .alert .btn-close {
        filter: invert(1);
    }

    @media (max-width: 768px) {
        .event-show-page {
            padding: 1.5rem 1rem 2rem;
        }

        .event-hero {
            grid-template-columns: 1fr;
            padding: 1.8rem 1.5rem;
        }

        .event-hero__title {
            font-size: 1.8rem;
        }

        .event-card {
            padding: 1.8rem 1.5rem;
        }

        .actions-card {
            position: static;
        }

        .alert {
            left: 10px !important;
            right: 10px !important;
            min-width: auto !important;
        }
    }
</style>
@endsection

@section('content')
<div class="event-show-page">
    <div class="event-show-shell">
        <!-- Hero Section -->
        <div class="event-hero">
            <div class="event-hero__meta">
                <span class="event-hero__eyebrow">
                    <i class="fas fa-calendar-check"></i>
                    Event Booking Details
                </span>
                <h1 class="event-hero__title">{{ $booking->event_name ?? $booking->event->heading ?? 'Event Booking' }}</h1>
                <p class="event-hero__subtitle">
                    Booking from {{ $booking->user->name ?? 'Customer' }} for your event
                </p>
                <div class="event-hero__actions">
                    <a href="{{ route('professional.event-bookings.index') }}" class="btn btn--secondary">
                        <i class="fas fa-arrow-left"></i>
                        Back to Bookings
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="event-layout">
            <!-- Booking Details -->
            <div class="event-card">
                <div class="event-card__header">
                    <h2 class="event-card__title">
                        <i class="fas fa-info-circle"></i>
                        Booking Information
                    </h2>
                    <p class="event-card__subtitle">Complete details about this event booking</p>
                </div>

                <div class="event-details-grid">
                    <div class="event-detail">
                        <div class="event-detail__icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="event-detail__content">
                            <div class="event-detail__label">Customer Name</div>
                            <div class="event-detail__value">{{ $booking->user->name ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="event-detail">
                        <div class="event-detail__icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="event-detail__content">
                            <div class="event-detail__label">Customer Email</div>
                            <div class="event-detail__value">{{ $booking->user->email ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="event-detail">
                        <div class="event-detail__icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="event-detail__content">
                            <div class="event-detail__label">Customer Phone</div>
                            <div class="event-detail__value">{{ $booking->phone ?? $booking->user->mobile ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="event-detail">
                        <div class="event-detail__icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="event-detail__content">
                            <div class="event-detail__label">Event Date</div>
                            <div class="event-detail__value">
                                @if($booking->event_date)
                                    {{ \Carbon\Carbon::parse($booking->event_date)->format('F d, Y') }}
                                @elseif($booking->event && $booking->event->date)
                                    {{ \Carbon\Carbon::parse($booking->event->date)->format('F d, Y') }}
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="event-detail">
                        <div class="event-detail__icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="event-detail__content">
                            <div class="event-detail__label">Event Type</div>
                            <div class="event-detail__value">{{ $booking->type ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="event-detail">
                        <div class="event-detail__icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="event-detail__content">
                            <div class="event-detail__label">Location</div>
                            <div class="event-detail__value">{{ $booking->location ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="event-detail">
                        <div class="event-detail__icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="event-detail__content">
                            <div class="event-detail__label">Number of Persons</div>
                            <div class="event-detail__value">{{ $booking->persons ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="event-detail">
                        <div class="event-detail__icon">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                        <div class="event-detail__content">
                            <div class="event-detail__label">Total Amount</div>
                            <div class="event-detail__value">₹{{ number_format($booking->total_price ?? $booking->price ?? 0, 2) }}</div>
                        </div>
                    </div>

                    <div class="event-detail">
                        <div class="event-detail__icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="event-detail__content">
                            <div class="event-detail__label">Payment Status</div>
                            <div class="event-detail__value">
                                <span class="booking-status booking-status--{{ strtolower($booking->payment_status ?? 'pending') }}">
                                    <i class="fas fa-circle"></i>
                                    {{ ucfirst($booking->payment_status ?? 'Pending') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="event-detail">
                        <div class="event-detail__icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="event-detail__content">
                            <div class="event-detail__label">Booking Status</div>
                            <div class="event-detail__value">
                                @php
                                    $bookingStatus = $booking->status ?? ($booking->payment_status === 'success' || $booking->payment_status === 'paid' ? 'confirmed' : 'pending');
                                @endphp
                                <span class="booking-status booking-status--{{ strtolower($bookingStatus) }}">
                                    <i class="fas fa-circle"></i>
                                    {{ ucfirst($bookingStatus) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="event-detail">
                        <div class="event-detail__icon">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="event-detail__content">
                            <div class="event-detail__label">Booking Date</div>
                            <div class="event-detail__value">
                                {{ $booking->created_at ? $booking->created_at->format('F d, Y h:i A') : 'N/A' }}
                            </div>
                        </div>
                    </div>

                    @if($booking->gmeet_link)
                    <div class="event-detail">
                        <div class="event-detail__icon">
                            <i class="fas fa-video"></i>
                        </div>
                        <div class="event-detail__content">
                            <div class="event-detail__label">Google Meet Link</div>
                            <div class="event-detail__value">
                                <a href="{{ $booking->gmeet_link }}" target="_blank" class="text-primary">
                                    <i class="fas fa-external-link-alt me-1"></i>Join Meeting
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions Sidebar -->
            <div class="actions-card event-card">
                <div class="event-card__header">
                    <h3 class="event-card__title">
                        <i class="fas fa-cogs"></i>
                        Quick Actions
                    </h3>
                    <p class="event-card__subtitle">Manage this booking</p>
                </div>

                <div class="actions-grid">
                    @php
                        $currentStatus = $booking->status ?? ($booking->payment_status === 'success' || $booking->payment_status === 'paid' ? 'confirmed' : 'pending');
                    @endphp
                    
                    @if($currentStatus === 'pending')
                        <button class="btn btn--success" onclick="updateBookingStatus({{ $booking->id }}, 'confirmed')">
                            <i class="fas fa-check"></i>
                            Confirm Booking
                        </button>
                        <button class="btn btn--danger" onclick="updateBookingStatus({{ $booking->id }}, 'cancelled')">
                            <i class="fas fa-times"></i>
                            Cancel Booking
                        </button>
                    @elseif($currentStatus === 'confirmed')
                        <button class="btn btn--primary" onclick="updateBookingStatus({{ $booking->id }}, 'completed')">
                            <i class="fas fa-flag-checkered"></i>
                            Mark as Completed
                        </button>
                        <button class="btn btn--warning" onclick="updateBookingStatus({{ $booking->id }}, 'cancelled')">
                            <i class="fas fa-times"></i>
                            Cancel Booking
                        </button>
                    @elseif($currentStatus === 'completed')
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle me-2"></i>
                            This booking has been completed successfully.
                        </div>
                    @elseif($currentStatus === 'cancelled')
                        <div class="alert alert-danger mb-3">
                            <i class="fas fa-times-circle me-2"></i>
                            This booking has been cancelled.
                        </div>
                    @endif

                    <a href="mailto:{{ $booking->user->email ?? '' }}" class="btn btn--secondary">
                        <i class="fas fa-envelope"></i>
                        Contact Customer
                    </a>

                    <a href="tel:{{ $booking->user->mobile ?? '' }}" class="btn btn--secondary">
                        <i class="fas fa-phone"></i>
                        Call Customer
                    </a>

                    @if($booking->event)
                    <a href="{{ route('professional.events.show', $booking->event->id) }}" class="btn btn--secondary">
                        <i class="fas fa-eye"></i>
                        View Event Details
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('scripts')
<script>
function updateBookingStatus(bookingId, status) {
    let statusText = '';
    let confirmButtonColor = '#28a745';
    let icon = 'question';
    
    switch(status) {
        case 'confirmed':
            statusText = 'confirm this booking';
            confirmButtonColor = '#28a745';
            icon = 'question';
            break;
        case 'cancelled':
            statusText = 'cancel this booking';
            confirmButtonColor = '#dc3545';
            icon = 'warning';
            break;
        case 'completed':
            statusText = 'mark this booking as completed';
            confirmButtonColor = '#007bff';
            icon = 'question';
            break;
    }
    
    Swal.fire({
        title: `Are you sure?`,
        text: `Do you want to ${statusText}? This action will notify the customer.`,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: confirmButtonColor,
        cancelButtonColor: '#6c757d',
        confirmButtonText: `Yes, ${status === 'cancelled' ? 'cancel' : (status === 'completed' ? 'complete' : 'confirm')} it!`,
        cancelButtonText: 'No, keep it',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return new Promise((resolve) => {
                // Create and submit form
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ route('professional.event-bookings.update-status', ':id') }}`.replace(':id', bookingId);
                
                // Add CSRF token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);
                
                // Add method override
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);
                
                // Add status
                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'status';
                statusInput.value = status;
                form.appendChild(statusInput);
                
                // Style the form to be invisible and submit
                form.style.display = 'none';
                document.body.appendChild(form);
                form.submit();
                
                resolve();
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    });
}

// Display success/error messages using Toastr (which is already included)
@if(session('success'))
$(document).ready(function() {
    toastr.success('{{ session('success') }}', 'Success!', {
        timeOut: 5000,
        positionClass: 'toast-top-center',
        preventDuplicates: true
    });
});
@endif

@if(session('error'))
$(document).ready(function() {
    toastr.error('{{ session('error') }}', 'Error!', {
        timeOut: 5000,
        positionClass: 'toast-top-center',
        preventDuplicates: true
    });
});
@endif
</script>
@endsection