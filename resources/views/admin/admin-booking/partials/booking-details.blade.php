<div class="booking-details-content">
    <div class="row g-4">
        <!-- Customer Information -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary bg-gradient text-white">
                    <h6 class="mb-0"><i class="ri-user-line me-2"></i>Customer Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" width="120">Name:</td>
                            <td class="fw-semibold">{{ $booking->customer_name ?? $booking->user->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email:</td>
                            <td>{{ $booking->customer_email ?? $booking->user->email ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Phone:</td>
                            <td>{{ $booking->customer_phone ?? $booking->user->phone ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Professional Information -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-success bg-gradient text-white">
                    <h6 class="mb-0"><i class="ri-user-star-line me-2"></i>Professional Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" width="120">Name:</td>
                            <td class="fw-semibold">{{ $booking->professional->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email:</td>
                            <td>{{ $booking->professional->email ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Specialization:</td>
                            <td>{{ $booking->professional->specialization ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Service Details -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-info bg-gradient text-white">
                    <h6 class="mb-0"><i class="ri-service-line me-2"></i>Service Details</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" width="140">Service:</td>
                            <td class="fw-semibold">{{ $booking->service_name ?? $booking->service->name ?? 'N/A' }}</td>
                        </tr>
                        @if($booking->sub_service_name || ($booking->subService && $booking->subService->name))
                        <tr>
                            <td class="text-muted">Sub-Service:</td>
                            <td>{{ $booking->sub_service_name ?? $booking->subService->name }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="text-muted">Session Type:</td>
                            <td><span class="badge bg-info">{{ ucfirst($booking->session_type ?? 'N/A') }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Plan Type:</td>
                            <td>{{ $booking->plan_type ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-warning bg-gradient text-white">
                    <h6 class="mb-0"><i class="ri-money-dollar-circle-line me-2"></i>Payment Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" width="140">Base Amount:</td>
                            <td class="fw-semibold">₹{{ number_format($booking->base_amount ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">CGST (9%):</td>
                            <td>₹{{ number_format($booking->cgst_amount ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">SGST (9%):</td>
                            <td>₹{{ number_format($booking->sgst_amount ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-bold">Total Amount:</td>
                            <td class="fw-bold text-success fs-5">₹{{ number_format($booking->amount ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Payment Status:</td>
                            <td>
                                @if($booking->payment_status === 'paid')
                                    <span class="badge bg-success">Paid</span>
                                @else
                                    <span class="badge bg-warning">{{ ucfirst($booking->payment_status ?? 'Pending') }}</span>
                                @endif
                            </td>
                        </tr>
                        @if($booking->payment_method)
                        <tr>
                            <td class="text-muted">Payment Method:</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $booking->payment_method)) }}</td>
                        </tr>
                        @endif
                        @if($booking->transaction_id)
                        <tr>
                            <td class="text-muted">Transaction ID:</td>
                            <td><code>{{ $booking->transaction_id }}</code></td>
                        </tr>
                        @endif
                    </table>
                    @if($booking->payment_screenshot)
                        <div class="mt-3">
                            <button type="button" class="btn btn-sm btn-primary" 
                                    onclick="viewPaymentScreenshot('{{ asset('storage/' . $booking->payment_screenshot) }}')">
                                <i class="ri-image-line me-1"></i>View Payment Receipt
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Booking Schedule -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary bg-gradient text-white">
                    <h6 class="mb-0"><i class="ri-calendar-check-line me-2"></i>Booking Schedule</h6>
                </div>
                <div class="card-body">
                    @if($booking->timedates && $booking->timedates->count() > 0)
                        <div class="row g-3">
                            @foreach($booking->timedates as $timedate)
                                <div class="col-md-4">
                                    <div class="alert alert-light mb-0">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="ri-calendar-event-line fs-4 text-primary"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">{{ \Carbon\Carbon::parse($timedate->date)->format('l, M d, Y') }}</h6>
                                                <p class="mb-0 text-muted">
                                                    <i class="ri-time-line me-1"></i>{{ $timedate->time_slot }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-light mb-0">
                            <i class="ri-calendar-line me-2"></i>
                            <strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('l, F j, Y') }}
                            @if($booking->booking_time)
                                <br>
                                <i class="ri-time-line me-2 ms-4"></i>
                                <strong>Time:</strong> {{ $booking->booking_time }}
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-secondary bg-gradient text-white">
                    <h6 class="mb-0"><i class="ri-information-line me-2"></i>Additional Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Booking ID:</strong> #{{ $booking->id }}</p>
                            <p class="mb-2"><strong>Created By:</strong> {{ ucfirst($booking->created_by ?? 'Customer') }}</p>
                            <p class="mb-2"><strong>Created At:</strong> {{ $booking->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Status:</strong> 
                                <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'cancelled' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($booking->status ?? 'Pending') }}
                                </span>
                            </p>
                            <p class="mb-2"><strong>Updated At:</strong> {{ $booking->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    @if($booking->payment_notes)
                        <hr>
                        <p class="mb-0"><strong>Payment Notes:</strong><br>{{ $booking->payment_notes }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
