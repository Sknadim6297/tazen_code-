@extends('admin.layouts.layout')

@section('title', 'Additional Service Details')

@section('styles')
<style>
@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(255, 193, 7, 0); }
    100% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0); }
}

.pulse-btn {
    background: linear-gradient(45deg, #ffc107, #ff9800) !important;
    border: none !important;
    color: white !important;
    font-weight: bold !important;
}
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Additional Service Details</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.additional-services.index') }}">Additional Services</a></li>
                            <li class="breadcrumb-item active">Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Service Information -->
            <div class="col-lg-8">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Service Information</div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Service Name:</label>
                                <p class="mb-0">{{ $additionalService->service_name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Booking Reference:</label>
                                <p class="mb-0">#{{ $additionalService->booking_id }}</p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Reason/Description:</label>
                            <p class="mb-0">{{ $additionalService->reason }}</p>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Base Price:</label>
                                @php
                                    $effectiveBasePrice = $additionalService->getEffectiveBasePrice();
                                    $originalBasePrice = $additionalService->base_price;
                                @endphp
                                <p class="mb-0">₹{{ number_format($effectiveBasePrice, 2) }}</p>
                                @if($effectiveBasePrice != $originalBasePrice)
                                    <small class="text-muted">Original: ₹{{ number_format($originalBasePrice, 2) }}</small>
                                    @if($additionalService->user_negotiated_price)
                                        <br><small class="text-warning">User negotiated: ₹{{ number_format($additionalService->user_negotiated_price, 2) }}</small>
                                    @endif
                                    @if($additionalService->admin_final_negotiated_price)
                                        <br><small class="text-info">Admin final: ₹{{ number_format($additionalService->admin_final_negotiated_price, 2) }}</small>
                                    @endif
                                    @if($additionalService->modified_base_price)
                                        <br><small class="text-warning">Admin modified: ₹{{ number_format($additionalService->modified_base_price, 2) }}</small>
                                    @endif
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">GST (18%):</label>
                                @php
                                    $cgst = $additionalService->cgst ?? ($effectiveBasePrice * 0.09);
                                    $sgst = $additionalService->sgst ?? ($effectiveBasePrice * 0.09);
                                    $totalGst = $cgst + $sgst;
                                @endphp
                                <p class="mb-0">₹{{ number_format($totalGst, 2) }}</p>
                                <small class="text-muted">(CGST: ₹{{ number_format($cgst, 2) }} + SGST: ₹{{ number_format($sgst, 2) }})</small>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Final Price:</label>
                                @php
                                    $effectiveTotalPrice = $additionalService->getEffectiveTotalPrice();
                                @endphp
                                <p class="mb-0 text-success fw-bold">₹{{ number_format($effectiveTotalPrice, 2) }}</p>
                                @if($additionalService->negotiation_status !== 'none')
                                    <small class="text-info">✅ Updated after negotiation</small>
                                @endif
                            </div>
                        </div>

                        @if($additionalService->delivery_date)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Delivery Date:</label>
                            <p class="mb-0">
                                <i class="fe fe-calendar"></i> 
                                {{ \Carbon\Carbon::parse($additionalService->delivery_date)->format('M d, Y') }}
                            </p>
                        </div>
                        @endif

                        @if($additionalService->price_modified_by_admin && $additionalService->price_modification_reason)
                        <div class="alert alert-warning">
                            <h6 class="mb-2"><i class="fe fe-edit"></i> Price Modification</h6>
                            <p class="mb-0"><strong>Reason:</strong> {{ $additionalService->price_modification_reason }}</p>
                        </div>
                        @endif

                        @if($additionalService->negotiation_status !== 'none')
                        <div class="alert {{ $additionalService->negotiation_status === 'user_negotiated' ? 'alert-warning' : 'alert-info' }}">
                            <h6 class="mb-2">
                                <i class="fe fe-message-square"></i> 
                                @if($additionalService->negotiation_status === 'user_negotiated')
                                    🔥 PENDING NEGOTIATION - ACTION REQUIRED
                                @else
                                    Negotiation Details
                                @endif
                            </h6>
                            @if($additionalService->negotiation_status === 'user_negotiated')
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Customer's Proposed Price:</strong> <span class="text-success">₹{{ number_format($additionalService->user_negotiated_price, 2) }}</span></p>
                                        <p class="mb-2"><strong>Current Price:</strong> <span class="text-muted">₹{{ number_format($additionalService->total_price, 2) }}</span></p>
                                        <p class="mb-0"><strong>Potential Savings:</strong> <span class="text-info">₹{{ number_format($additionalService->total_price - $additionalService->user_negotiated_price, 2) }}</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-0"><strong>Customer's Reason:</strong></p>
                                        <div class="bg-light p-2 rounded">{{ $additionalService->user_negotiation_reason }}</div>
                                    </div>
                                </div>
                            @elseif($additionalService->negotiation_status === 'admin_responded')
                                <p class="mb-2"><strong>Customer's Proposed Price:</strong> ₹{{ number_format($additionalService->user_negotiated_price, 2) }}</p>
                                <p class="mb-2"><strong>Customer's Reason:</strong> {{ $additionalService->user_negotiation_reason }}</p>
                                <p class="mb-2"><strong>Admin's Final Price:</strong> ₹{{ number_format($additionalService->admin_final_negotiated_price, 2) }}</p>
                                <p class="mb-0"><strong>Admin's Response:</strong> {{ $additionalService->admin_negotiation_response }}</p>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Price History Panel -->
            <div class="col-lg-8 mt-3">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Price History & Negotiation Timeline</div>
                    </div>
                    <div class="card-body">
                        @php
                            // Build timeline from price_history JSON when available, otherwise infer from fields
                            $history = json_decode($additionalService->price_history ?? '[]', true) ?: [];

                            // Add initial entry
                            $initial = [
                                'label' => 'Original Price',
                                'previous_price' => null,
                                'new_price' => $additionalService->total_price ?? $additionalService->base_price,
                                'modified_by' => 'system',
                                'modified_at' => $additionalService->created_at->toDateTimeString(),
                                'reason' => 'Initial service price'
                            ];

                            // If history empty, try to infer negotiation events
                            if (empty($history)) {
                                if ($additionalService->user_negotiated_price) {
                                    $history[] = [
                                        'previous_price' => $additionalService->total_price,
                                        'new_price' => $additionalService->user_negotiated_price,
                                        'modified_by' => 'customer',
                                        'modified_at' => $additionalService->user_responded_at ? $additionalService->user_responded_at->toDateTimeString() : $additionalService->created_at->toDateTimeString(),
                                        'reason' => $additionalService->user_negotiation_reason ?? 'Customer negotiation request'
                                    ];
                                }

                                if ($additionalService->admin_final_negotiated_price) {
                                    $history[] = [
                                        'previous_price' => $additionalService->user_negotiated_price ?? $additionalService->total_price,
                                        'new_price' => $additionalService->admin_final_negotiated_price,
                                        'modified_by' => (stripos($additionalService->price_modification_reason ?? '', 'professional') !== false) ? 'professional' : 'admin',
                                        'modified_at' => $additionalService->admin_reviewed_at ? $additionalService->admin_reviewed_at->toDateTimeString() : now()->toDateTimeString(),
                                        'reason' => $additionalService->admin_negotiation_response ?? $additionalService->price_modification_reason ?? 'Negotiation response'
                                    ];
                                }
                            }

                            // Prepend initial price for display consistency
                            array_unshift($history, $initial);
                        @endphp

                        <div class="timeline">
                            @foreach($history as $item)
                                <div class="timeline-item mb-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>{{ ucfirst($item['label'] ?? ($item['modified_by'] ?? 'update')) }}</strong>
                                            <div class="text-muted small">By: {{ ucfirst($item['modified_by'] ?? 'system') }} @if(!empty($item['modified_at'])) • {{ \Carbon\Carbon::parse($item['modified_at'])->format('M d, Y h:i A') }} @endif</div>
                                        </div>
                                        <div class="text-end">
                                            <div><strong>₹{{ number_format($item['new_price'] ?? 0, 2) }}</strong></div>
                                        </div>
                                    </div>
                                    @if(!empty($item['previous_price']))
                                        <div class="mt-1 small text-muted">Previous: ₹{{ number_format($item['previous_price'], 2) }}</div>
                                    @endif
                                    @if(!empty($item['reason']))
                                        <div class="mt-2 bg-light p-2 rounded small">{{ $item['reason'] }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status & Actions -->
            <div class="col-lg-4">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Status Information</div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Service Type:</label>
                            <p class="mb-0">
                                @if($additionalService->professional_id)
                                    <span class="badge bg-info">Professional Service</span>
                                @else
                                    <span class="badge bg-primary">Admin Service</span>
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Payment Status:</label>
                            <p class="mb-0">
                                @if($additionalService->payment_status === 'pending')
                                    <span class="badge bg-warning">Payment Pending</span>
                                @elseif($additionalService->payment_status === 'paid')
                                    <span class="badge bg-success">Paid</span>
                                @elseif($additionalService->payment_status === 'failed')
                                    <span class="badge bg-danger">Payment Failed</span>
                                @endif
                            </p>
                        </div>

                        @if($additionalService->payment_status === 'paid')
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Professional Payout:</label>
                            <p class="mb-0">
                                @if($additionalService->professional_payment_status === 'pending')
                                    <span class="badge bg-warning">Payout Pending</span>
                                @else
                                    <span class="badge bg-success">Payout Released</span>
                                @endif
                            </p>
                        </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Created Date:</label>
                            <p class="mb-0">{{ $additionalService->created_at->format('M d, Y h:i A') }}</p>
                        </div>

                        @if($additionalService->admin_reviewed_at)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Last Reviewed:</label>
                            <p class="mb-0">{{ $additionalService->admin_reviewed_at->format('M d, Y h:i A') }}</p>
                        </div>
                        @endif

                        <!-- Delivery Date Information -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Delivery Date:</label>
                            @if($additionalService->delivery_date)
                                <p class="mb-0">
                                    <span class="badge bg-info">
                                        <i class="fe fe-calendar"></i>
                                        {{ \Carbon\Carbon::parse($additionalService->delivery_date)->format('M d, Y') }}
                                    </span>
                                </p>
                                @if($additionalService->delivery_date_set_by_professional_at)
                                    <small class="text-muted">
                                        Set by Professional: {{ \Carbon\Carbon::parse($additionalService->delivery_date_set_by_professional_at)->format('M d, Y h:i A') }}
                                    </small>
                                @endif
                                @if($additionalService->delivery_date_modified_by_admin_at)
                                    <br><small class="text-warning">
                                        Modified by Admin: {{ \Carbon\Carbon::parse($additionalService->delivery_date_modified_by_admin_at)->format('M d, Y h:i A') }}
                                    </small>
                                @endif
                                @if($additionalService->delivery_date_reason)
                                    <br><small class="text-muted">
                                        <strong>Reason:</strong> {{ $additionalService->delivery_date_reason }}
                                    </small>
                                @endif
                            @else
                                <p class="mb-0">
                                    <span class="badge bg-secondary">Not Set</span>
                                </p>
                            @endif
                        </div>

                        <!-- Consultation Status -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Consultation Status:</label>
                            <p class="mb-0">
                                @if($additionalService->consulting_status === 'pending')
                                    <span class="badge bg-secondary">Not Started</span>
                                @elseif($additionalService->consulting_status === 'in_progress')
                                    <span class="badge bg-primary">In Progress</span>
                                @elseif($additionalService->consulting_status === 'done')
                                    @if($additionalService->customer_confirmed_at)
                                        <span class="badge bg-success">Completed & Confirmed</span>
                                    @else
                                        <span class="badge bg-warning">Awaiting Customer Confirmation</span>
                                    @endif
                                @endif
                            </p>
                            
                            @if($additionalService->professional_completed_at)
                                <small class="text-muted">
                                    Professional completed: {{ \Carbon\Carbon::parse($additionalService->professional_completed_at)->format('M d, Y h:i A') }}
                                </small>
                            @endif
                            
                            @if($additionalService->customer_confirmed_at)
                                <br><small class="text-success">
                                    Customer confirmed: {{ \Carbon\Carbon::parse($additionalService->customer_confirmed_at)->format('M d, Y h:i A') }}
                                </small>
                            @endif
                            
                            @if($additionalService->admin_completed_at)
                                <br><small class="text-info">
                                    <i class="fe fe-shield"></i> Admin marked as completed: {{ \Carbon\Carbon::parse($additionalService->admin_completed_at)->format('M d, Y h:i A') }}
                                </small>
                                @if($additionalService->admin_completion_note)
                                    <br><small class="text-muted fst-italic">
                                        Note: {{ $additionalService->admin_completion_note }}
                                    </small>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Commission & Earnings Breakdown -->
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fe fe-pie-chart"></i>
                            Commission & Earnings Breakdown
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $professional = $additionalService->professional;
                            $finalPrice = $additionalService->final_price;
                            $serviceRequestMargin = $professional->service_request_margin ?? 0;
                            $serviceRequestOffset = $professional->service_request_offset ?? 0;
                            $platformCommission = ($finalPrice * $serviceRequestMargin) / 100;
                            $professionalEarning = $finalPrice - $platformCommission;
                            $minNegotiablePrice = $additionalService->base_price - (($additionalService->base_price * $serviceRequestOffset) / 100);
                        @endphp
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="p-3 bg-primary bg-opacity-10 rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-fill">
                                            <p class="fs-12 text-muted mb-1">Service Request Margin</p>
                                            <h6 class="mb-0">{{ number_format($serviceRequestMargin, 2) }}%</h6>
                                        </div>
                                        <div class="ms-2">
                                            <i class="fe fe-trending-up fs-16 text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-success bg-opacity-10 rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-fill">
                                            <p class="fs-12 text-muted mb-1">Platform Commission</p>
                                            <h6 class="mb-0">₹{{ number_format($platformCommission, 2) }}</h6>
                                        </div>
                                        <div class="ms-2">
                                            <i class="fe fe-dollar-sign fs-16 text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-info bg-opacity-10 rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-fill">
                                            <p class="fs-12 text-muted mb-1">Professional Earning</p>
                                            <h6 class="mb-0">₹{{ number_format($professionalEarning, 2) }}</h6>
                                        </div>
                                        <div class="ms-2">
                                            <i class="fe fe-user fs-16 text-info"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="p-3 bg-warning bg-opacity-10 rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-fill">
                                            <p class="fs-12 text-muted mb-1">Negotiation Offset</p>
                                            <h6 class="mb-0">{{ number_format($serviceRequestOffset, 2) }}%</h6>
                                            <small class="text-muted">Max customer discount</small>
                                        </div>
                                        <div class="ms-2">
                                            <i class="fe fe-arrow-down fs-16 text-warning"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-secondary bg-opacity-10 rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-fill">
                                            <p class="fs-12 text-muted mb-1">Min Negotiable Price</p>
                                            <h6 class="mb-0">₹{{ number_format($minNegotiablePrice, 2) }}</h6>
                                            <small class="text-muted">Customer cannot go below</small>
                                        </div>
                                        <div class="ms-2">
                                            <i class="fe fe-shield fs-16 text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($additionalService->payment_status === 'paid')
                        <div class="alert alert-success mt-3">
                            <div class="d-flex align-items-center">
                                <i class="fe fe-check-circle me-2"></i>
                                <div>
                                    <h6 class="mb-1">Payment Received</h6>
                                    <p class="mb-0">Platform commission: ₹{{ number_format($platformCommission, 2) }} | Professional earns: ₹{{ number_format($professionalEarning, 2) }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Professional Information -->
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Professional Details</div>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <label class="form-label fw-semibold">Name:</label>
                            <p class="mb-0">{{ $additionalService->professional->name }}</p>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-semibold">Email:</label>
                            <p class="mb-0">{{ $additionalService->professional->email }}</p>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Phone:</label>
                            <p class="mb-0">{{ $additionalService->professional->phone }}</p>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Customer Details</div>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <label class="form-label fw-semibold">Name:</label>
                            <p class="mb-0">{{ $additionalService->user->name }}</p>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-semibold">Email:</label>
                            <p class="mb-0">{{ $additionalService->user->email }}</p>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Phone:</label>
                            <p class="mb-0">{{ $additionalService->user->phone }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Quick Actions</div>
                    </div>
                    <div class="card-body d-grid gap-2">
                        {{-- Only show price modification if consultation is not completed --}}
                        @if($additionalService->consulting_status !== 'done')
                        <button class="btn btn-warning btn-sm modify-price" data-id="{{ $additionalService->id }}">
                            <i class="fe fe-edit"></i> Modify Price
                        </button>
                        @endif

                        @if($additionalService->negotiation_status === 'user_negotiated')
                        <button class="btn btn-warning btn-sm respond-negotiation pulse-btn" data-id="{{ $additionalService->id }}" style="animation: pulse 2s infinite;">
                            <i class="fe fe-message-square"></i> 🔥 RESPOND TO NEGOTIATION
                        </button>
                        @endif

                        {{-- Only show delivery date update if consultation is not completed --}}
                        @if($additionalService->consulting_status !== 'done')
                        <button class="btn btn-primary btn-sm update-delivery-date" data-id="{{ $additionalService->id }}">
                            <i class="fe fe-calendar"></i> Update Delivery Date
                        </button>
                        @endif

                        {{-- Release payment only after consultation is completed and payment is received --}}
                        @if($additionalService->consulting_status === 'done' && $additionalService->payment_status === 'paid' && $additionalService->professional_payment_status === 'pending')
                        <button class="btn btn-success btn-sm release-payment" data-id="{{ $additionalService->id }}">
                            <i class="fe fe-dollar-sign"></i> Release Payment
                        </button>
                        @endif

                        {{-- Admin can mark as completed only when payment is received --}}
                        @if($additionalService->consulting_status !== 'done' && $additionalService->payment_status === 'paid')
                        <button class="btn btn-info btn-sm mark-completed" data-id="{{ $additionalService->id }}">
                            <i class="fe fe-check-circle"></i> Mark as Completed
                        </button>
                        @endif

                        @if($additionalService->consulting_status === 'done' && $additionalService->payment_status === 'paid')
                        <hr class="my-2">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.additional-services.invoice', $additionalService->id) }}" class="btn btn-success btn-sm">
                                <i class="fe fe-file-text"></i> View Invoice
                            </a>
                            <a href="{{ route('admin.additional-services.invoice.pdf', $additionalService->id) }}" class="btn btn-outline-success btn-sm" target="_blank">
                                <i class="fe fe-download"></i> Download PDF Invoice
                            </a>
                        </div>
                        @endif

                        <a href="{{ route('admin.additional-services.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fe fe-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modify Price Modal -->
<div class="modal fade" id="modifyPriceModal" tabindex="-1" aria-labelledby="modifyPriceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modifyPriceModalLabel">Modify Service Price</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="modifyPriceForm">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Current Base Price:</strong> ₹{{ number_format($additionalService->base_price, 2) }}<br>
                        <strong>Current Total Price:</strong> ₹{{ number_format($additionalService->final_price, 2) }}
                    </div>
                    <div class="mb-3">
                        <label for="modified_base_price" class="form-label">New Base Price (₹) *</label>
                        <input type="number" class="form-control" id="modified_base_price" name="modified_base_price" 
                               step="0.01" min="0" required value="{{ $additionalService->base_price }}">
                        <small class="form-text text-muted">GST (18%) will be calculated automatically</small>
                    </div>
                    <div class="mb-3">
                        <label for="modification_reason" class="form-label">Modification Reason *</label>
                        <textarea class="form-control" id="modification_reason" name="modification_reason" rows="3" required
                                  placeholder="Please provide reason for price modification..."></textarea>
                    </div>
                    <div class="alert alert-success" id="price-preview" style="display: none;">
                        <strong>New Price Preview:</strong>
                        <div>Base Price: ₹<span id="preview-base">0.00</span></div>
                        <div>GST (18%): ₹<span id="preview-gst">0.00</span></div>
                        <div><strong>Total Price: ₹<span id="preview-total">0.00</span></strong></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Update Price</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Respond to Negotiation Modal -->
<div class="modal fade" id="respondNegotiationModal" tabindex="-1" aria-labelledby="respondNegotiationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="respondNegotiationModalLabel">Respond to Price Negotiation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="respondNegotiationForm">
                <div class="modal-body">
                    @if($additionalService->negotiation_status === 'user_negotiated')
                    <div class="alert alert-info">
                        <strong>Customer's Proposed Price:</strong> ₹{{ number_format($additionalService->user_negotiated_price, 2) }}<br>
                        <strong>Customer's Reason:</strong> {{ $additionalService->user_negotiation_reason }}<br>
                        <strong>Current Price:</strong> ₹{{ number_format($additionalService->final_price, 2) }}
                    </div>
                    @endif
                    <div class="mb-3">
                        <label for="admin_final_price" class="form-label">Your Final Price (₹) *</label>
                        <input type="number" class="form-control" id="admin_final_price" name="admin_final_price" 
                               step="0.01" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="admin_response" class="form-label">Your Response *</label>
                        <textarea class="form-control" id="admin_response" name="admin_response" rows="3" required
                                  placeholder="Provide your response to the customer's negotiation..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Response</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Delivery Date Modal -->
<div class="modal fade" id="updateDeliveryModal" tabindex="-1" aria-labelledby="updateDeliveryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateDeliveryModalLabel">Update Delivery Date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateDeliveryForm">
                <div class="modal-body">
                    @if($additionalService->delivery_date)
                    <div class="alert alert-info">
                        <strong>Current Delivery Date:</strong> {{ \Carbon\Carbon::parse($additionalService->delivery_date)->format('M d, Y') }}
                    </div>
                    @endif
                    <div class="mb-3">
                        <label for="delivery_date" class="form-label">New Delivery Date *</label>
                        <input type="date" class="form-control" id="delivery_date" name="delivery_date" required
                               min="{{ date('Y-m-d') }}" value="{{ $additionalService->delivery_date }}">
                    </div>
                    <div class="mb-3">
                        <label for="date_change_reason" class="form-label">Reason for Date Change *</label>
                        <textarea class="form-control" id="date_change_reason" name="date_change_reason" rows="3" required
                                  placeholder="Please provide reason for changing the delivery date..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Date</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Release Payment Modal -->
<div class="modal fade" id="releasePaymentModal" tabindex="-1" aria-labelledby="releasePaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="releasePaymentModalLabel">Release Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="releasePaymentForm">
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <strong>Important:</strong> This action will release the payment to the professional and cannot be undone.
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Professional:</strong><br>
                            {{ $additionalService->professional->name }}
                        </div>
                        <div class="col-6">
                            <strong>Amount:</strong><br>
                            ₹{{ number_format($additionalService->final_price, 2) }}
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="payment_transaction_id" class="form-label">Payment Transaction ID *</label>
                        <input type="text" class="form-control" id="payment_transaction_id" name="payment_transaction_id" 
                               required placeholder="Enter payment transaction ID (e.g., TXN123456789)">
                        <small class="form-text text-muted">This ID will be shown to the professional as payment reference</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select class="form-control" id="payment_method" name="payment_method">
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="upi">UPI</option>
                            <option value="cheque">Cheque</option>
                            <option value="cash">Cash</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="payment_notes" class="form-label">Payment Notes (Optional)</label>
                        <textarea class="form-control" id="payment_notes" name="payment_notes" rows="2" 
                                  placeholder="Any additional notes about the payment..."></textarea>
                    </div>
                    
                    <p><strong>Are you sure you want to release this payment?</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="confirmReleasePayment">Release Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Mark Completed Modal -->
<div class="modal fade" id="markCompletedModal" tabindex="-1" aria-labelledby="markCompletedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="markCompletedModalLabel">Mark Service as Completed</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fe fe-info"></i>
                    <strong>Mark as Completed</strong><br>
                    This will mark the consultation as completed and notify both the user and professional.
                    Payment has been received and will be available for release after completion.
                </div>
                
                <p><strong>Are you sure you want to mark this service as completed?</strong></p>
                
                <div class="row text-center">
                    <div class="col-6">
                        <strong>Service:</strong><br>
                        {{ $additionalService->service_name }}
                    </div>
                    <div class="col-6">
                        <strong>Professional:</strong><br>
                        {{ $additionalService->professional->name }}
                    </div>
                </div>
                
                <div class="row text-center mt-2">
                    <div class="col-6">
                        <strong>Current Status:</strong><br>
                        <span class="badge bg-{{ $additionalService->consulting_status === 'pending' ? 'warning' : ($additionalService->consulting_status === 'in_progress' ? 'info' : 'success') }}">
                            {{ ucfirst(str_replace('_', ' ', $additionalService->consulting_status)) }}
                        </span>
                    </div>
                    <div class="col-6">
                        <strong>Payment Status:</strong><br>
                        <span class="badge bg-success">Paid</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-info" id="confirmMarkCompleted">
                    <i class="fe fe-check-circle"></i> Mark as Completed
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let currentServiceId = {{ $additionalService->id }};

    // Modify Price
    $('.modify-price').click(function() {
        $('#modifyPriceModal').modal('show');
    });

    // Price preview calculation
    $('#modified_base_price').on('input', function() {
        const basePrice = parseFloat($(this).val()) || 0;
        const gst = basePrice * 0.18;
        const total = basePrice + gst;
        
        $('#preview-base').text(basePrice.toFixed(2));
        $('#preview-gst').text(gst.toFixed(2));
        $('#preview-total').text(total.toFixed(2));
        $('#price-preview').show();
    });

    $('#modifyPriceForm').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: `/admin/additional-services/${currentServiceId}/modify-price`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                modified_base_price: $('#modified_base_price').val(),
                modification_reason: $('#modification_reason').val()
            },
            success: function(response) {
                if (response.success) {
                    $('#modifyPriceModal').modal('hide');
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
    });

    // Respond to Negotiation
    $('.respond-negotiation').click(function() {
        $('#respondNegotiationModal').modal('show');
    });

    $('#respondNegotiationForm').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: `/admin/additional-services/${currentServiceId}/respond-negotiation`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                admin_final_price: $('#admin_final_price').val(),
                admin_response: $('#admin_response').val()
            },
            success: function(response) {
                if (response.success) {
                    $('#respondNegotiationModal').modal('hide');
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
    });

    // Update Delivery Date
    $('.update-delivery-date').click(function() {
        $('#updateDeliveryModal').modal('show');
    });

    $('#updateDeliveryForm').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: `/admin/additional-services/${currentServiceId}/update-delivery-date`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                delivery_date: $('#delivery_date').val(),
                date_change_reason: $('#date_change_reason').val()
            },
            success: function(response) {
                if (response.success) {
                    $('#updateDeliveryModal').modal('hide');
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
    });

    // Release Payment
    $('.release-payment').click(function() {
        $('#releasePaymentModal').modal('show');
    });

    $('#releasePaymentForm').submit(function(e) {
        e.preventDefault();
        
        // Basic frontend validation
        const transactionId = $('#payment_transaction_id').val().trim();
        const paymentMethod = $('#payment_method').val();
        
        if (!transactionId) {
            toastr.error('Payment Transaction ID is required');
            return;
        }
        
        if (!paymentMethod) {
            toastr.error('Payment Method is required');
            return;
        }
        
        const $submitBtn = $('#confirmReleasePayment');
        const originalText = $submitBtn.html();
        
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        
        $.ajax({
            url: `/admin/additional-services/${currentServiceId}/release-payment`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                payment_transaction_id: $('#payment_transaction_id').val(),
                payment_method: $('#payment_method').val(),
                payment_notes: $('#payment_notes').val()
            },
            success: function(response) {
                if (response.success) {
                    $('#releasePaymentModal').modal('hide');
                    toastr.success(response.message);
                    setTimeout(() => location.reload(), 1500);
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
            },
            complete: function() {
                $submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Reset form when modal is closed
    $('#releasePaymentModal').on('hidden.bs.modal', function() {
        $('#releasePaymentForm')[0].reset();
    });

    // Mark as Completed
    $('.mark-completed').click(function() {
        console.log('Mark completed button clicked');
        $('#markCompletedModal').modal('show');
    });

    $('#confirmMarkCompleted').click(function() {
        console.log('Confirm mark completed clicked');
        
        const $btn = $(this);
        const originalText = $btn.html();
        
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        
        $.ajax({
            url: `/admin/additional-services/${currentServiceId}/mark-completed`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('Success response:', response);
                if (response.success) {
                    $('#markCompletedModal').modal('hide');
                    toastr.success(response.message);
                    setTimeout(() => location.reload(), 1500);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                console.error('Error response:', xhr);
                const errorMessage = xhr.responseJSON?.message || 'An error occurred. Please try again.';
                toastr.error(errorMessage);
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalText);
            }
        });
    });
});
</script>
@endsection