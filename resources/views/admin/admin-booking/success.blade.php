@extends('admin.layouts.layout')

@section('styles')
<style>
    .success-card {
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        border-radius: 15px;
    }

    .success-icon {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
    }

    .success-icon i {
        font-size: 3rem;
        color: white;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #218838 0%, #1ca085 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
    }

    .detail-card {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }

    .detail-label {
        font-size: 0.875rem;
        color: #6c757d;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .detail-value {
        font-size: 1rem;
        color: #333;
        font-weight: 600;
        margin-bottom: 0;
    }

    .time-slot-badge {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
        border: 1px solid rgba(102, 126, 234, 0.2);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        margin-bottom: 0.5rem;
        display: inline-block;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Booking Success</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.admin-booking.index') }}">Admin Bookings</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Success</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card custom-card">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <div class="avatar avatar-xxl avatar-rounded bg-success-transparent mb-3 mx-auto">
                        <i class="ri-check-line fs-1 text-success"></i>
                    </div>
                    <h3 class="fw-semibold text-success mb-2">Booking Created Successfully!</h3>
                    <p class="text-muted fs-15 mb-4">
                        The booking has been created and confirmed. All parties have been notified.
                    </p>
                </div>

                <!-- Booking Details Card -->
                <div class="card border">
                    <div class="card-header">
                        <h6 class="mb-0">Booking Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Booking ID</label>
                                    <p class="fw-semibold">#{{ $booking->id }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Customer</label>
                                    <p class="fw-semibold">{{ $booking->user->first_name }} {{ $booking->user->last_name }}</p>
                                    <small class="text-muted">{{ $booking->user->email }}</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Service</label>
                                    <p class="fw-semibold">{{ $booking->service_name ?? 'N/A' }}</p>
                                    @if(!empty($booking->sub_service_name))
                                        <small class="text-muted">{{ $booking->sub_service_name }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Professional</label>
                                    <p class="fw-semibold">{{ optional($booking->professional)->name }}</p>
                                    <small class="text-muted">{{ optional($booking->professional)->email }}</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Session Details</label>
                                    <p class="fw-semibold">{{ ucfirst($booking->session_type) }} Session</p>
                                    @if($booking->session_duration)
                                        <small class="text-muted">{{ $booking->session_duration }} minutes</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Amount</label>
                                    <p class="fw-semibold text-success">₹{{ number_format($booking->amount ?? $booking->base_amount ?? 0, 2) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Payment Status</label>
                                    <p class="fw-semibold">
                                        <span class="badge {{ $booking->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }}">
                                            {{ ucfirst($booking->payment_status ?? 'Pending') }}
                                        </span>
                                    </p>
                                    @if($booking->razorpay_payment_id)
                                        <small class="text-muted">Payment ID: {{ $booking->razorpay_payment_id }}</small>
                                    @endif
                                </div>
                                @if($booking->created_by)
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Created By</label>
                                        <p class="fw-semibold">{{ ucfirst($booking->created_by) }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($booking->timedates->count() > 0)
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Scheduled Date & Time</label>
                                        @foreach($booking->timedates as $timeSlot)
                                            <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2">
                                                <div>
                                                    <p class="mb-0 fw-semibold">{{ \Carbon\Carbon::parse($timeSlot->date)->format('F d, Y') }}</p>
                                                    <small class="text-muted">{{ $timeSlot->time_slot }}</small>
                                                </div>
                                                <span class="badge bg-success-transparent">{{ ucfirst($timeSlot->status) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-3 mt-4">
                    <a href="{{ route('admin.admin-booking.index') }}" class="btn btn-primary">
                        <i class="ri-list-check me-1"></i>View All Bookings
                    </a>
                    <a href="{{ route('admin.admin-booking.create') }}" class="btn btn-success">
                        <i class="ri-add-line me-1"></i>Create Another Booking
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection