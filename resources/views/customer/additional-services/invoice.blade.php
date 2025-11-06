@extends('customer.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Additional Service Invoice</h3>
                    <div class="btn-group">
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="fas fa-print"></i> Print
                        </button>
                        <a href="{{ route('user.additional-services.invoice.pdf', $service->id) }}" 
                           class="btn btn-success" target="_blank">
                            <i class="fas fa-download"></i> Download PDF
                        </a>
                        <a href="{{ route('user.additional-services.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Services
                        </a>
                    </div>
                </div>

                <div class="card-body" id="invoice-content">
                    <!-- Invoice Header -->
                    <div class="invoice-header mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h1 class="text-primary display-4 fw-bold">INVOICE</h1>
                                <p class="text-muted fs-5">Additional Service</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <p><strong>Invoice #:</strong> {{ $invoice_number }}</p>
                                <p><strong>Date:</strong> {{ $invoice_date }}</p>
                                <p><strong>Service ID:</strong> AS-{{ str_pad($service->id, 6, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                        <hr class="border-primary border-3">
                    </div>

                    <!-- Customer & Professional Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-primary">Bill To:</h5>
                            <div class="border p-3 rounded">
                                <strong>{{ $customer->name }}</strong><br>
                                {{ $customer->email }}<br>
                                @if($customer->phone)
                                    {{ $customer->phone }}<br>
                                @endif
                                @if($customer->address)
                                    {{ $customer->address }}
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-primary">Service Provider:</h5>
                            <div class="border p-3 rounded">
                                <strong>{{ $professional->name }}</strong><br>
                                {{ $professional->email }}<br>
                                Professional ID: {{ $professional->id }}
                            </div>
                        </div>
                    </div>

                    <!-- Service Details -->
                    <div class="mb-4">
                        <h5 class="text-primary">Service Details</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="30%">Service Name</th>
                                        <td>{{ $service->service_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>{{ $service->reason }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge bg-success">Completed & Paid</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Completion Date</th>
                                        <td>{{ $service->professional_completed_at ? $service->professional_completed_at->format('d M, Y H:i') : '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pricing Flow - Only show if there was actual price change -->
                    @php
                        $showPricingJourney = false;
                        if (isset($negotiation_details) && $negotiation_details['negotiation_status'] !== 'none') {
                            // Check if user negotiated price is different from original
                            $userNegotiatedDifferent = $negotiation_details['user_negotiated_price'] && 
                                                     (float)$negotiation_details['user_negotiated_price'] !== (float)$negotiation_details['original_price'];
                            
                            // Check if admin final price is different from original
                            $adminFinalDifferent = $negotiation_details['admin_final_price'] && 
                                                 (float)$negotiation_details['admin_final_price'] !== (float)$negotiation_details['original_price'];
                            
                            $showPricingJourney = $userNegotiatedDifferent || $adminFinalDifferent;
                        }
                    @endphp
                    
                    @if($showPricingJourney)
                    <div class="pricing-breakdown mb-4 p-4 bg-light rounded">
                        <h5 class="text-primary">Pricing Journey</h5>
                        <div class="d-flex justify-content-around align-items-center flex-wrap pricing-flow">
                            <!-- Original Price -->
                            <div class="text-center price-stage">
                                <div class="price-value text-success fw-bold fs-4">₹{{ number_format($negotiation_details['original_price'], 2) }}</div>
                                <div class="price-label text-muted">Original Price</div>
                            </div>
                            
                            <!-- User Negotiated Price (only if different from original) -->
                            @if($negotiation_details['user_negotiated_price'] && $negotiation_details['user_negotiated_price'] != $negotiation_details['original_price'])
                            <div class="price-arrow">
                                <i class="fas fa-arrow-right text-primary fs-3"></i>
                            </div>
                            <div class="text-center price-stage">
                                <div class="price-value text-warning fw-bold fs-4">₹{{ number_format($negotiation_details['user_negotiated_price'], 2) }}</div>
                                <div class="price-label text-muted">You Negotiated</div>
                            </div>
                            @endif
                            
                            <!-- Admin Final Price (only if different and exists) -->
                            @if($negotiation_details['admin_final_price'] && $negotiation_details['admin_final_price'] != $negotiation_details['original_price'])
                            <div class="price-arrow">
                                <i class="fas fa-arrow-right text-primary fs-3"></i>
                            </div>
                            <div class="text-center price-stage">
                                <div class="price-value text-info fw-bold fs-4">₹{{ number_format($negotiation_details['admin_final_price'], 2) }}</div>
                                <div class="price-label text-muted">Final Agreed Price</div>
                            </div>
                            @endif
                            
                            <!-- Final Amount with GST -->
                            <div class="price-arrow">
                                <i class="fas fa-arrow-right text-primary fs-3"></i>
                            </div>
                            <div class="text-center price-stage">
                                <div class="price-value text-success fw-bold fs-4">₹{{ number_format($pricing['total_price'], 2) }}</div>
                                <div class="price-label text-muted">Final Amount Paid (with GST)</div>
                            </div>
                        </div>
                        
                        <div class="mt-3 p-2 bg-success bg-opacity-10 rounded">
                            <small class="text-success">
                                <i class="fas fa-check-circle"></i> 
                                @if(isset($negotiation_details['user_negotiated_price']) && $negotiation_details['user_negotiated_price'] < $negotiation_details['original_price'])
                                    You saved ₹{{ number_format($negotiation_details['original_price'] - $pricing['base_price'], 2) }} through negotiation!
                                @else
                                    Service completed successfully at agreed price.
                                @endif
                            </small>
                        </div>
                    </div>
                    @endif

                    <!-- GST Breakdown -->
                    <div class="mb-4">
                        <h5 class="text-primary">Payment Breakdown</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Service Amount</td>
                                        <td class="text-end">₹{{ number_format($pricing['base_price'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>CGST (9%)</td>
                                        <td class="text-end">₹{{ number_format($pricing['cgst'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>SGST (9%)</td>
                                        <td class="text-end">₹{{ number_format($pricing['sgst'], 2) }}</td>
                                    </tr>
                                    @if($pricing['igst'] > 0)
                                    <tr>
                                        <td>IGST (18%)</td>
                                        <td class="text-end">₹{{ number_format($pricing['igst'], 2) }}</td>
                                    </tr>
                                    @endif
                                    <tr class="table-success">
                                        <td><strong>Total Amount Paid</strong></td>
                                        <td class="text-end"><strong>₹{{ number_format($pricing['total_price'], 2) }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Negotiation History - Only show if there was meaningful negotiation -->
                    @php
                        $showNegotiation = false;
                        if (isset($negotiation_details) && $negotiation_details['negotiation_status'] !== 'none') {
                            // Check if user negotiated price is different from original
                            $userNegotiatedDifferent = $negotiation_details['user_negotiated_price'] && 
                                                     (float)$negotiation_details['user_negotiated_price'] !== (float)$negotiation_details['original_price'];
                            
                            // Check if there are negotiation comments/responses
                            $hasNegotiationComments = $service->user_negotiation_reason || $service->admin_negotiation_response;
                            
                            $showNegotiation = $userNegotiatedDifferent || $hasNegotiationComments;
                        }
                    @endphp
                    
                    @if($showNegotiation)
                    <div class="negotiation-history mb-4 p-3 bg-info bg-opacity-10 rounded border-start border-info border-4">
                        <h5 class="text-primary">Negotiation Summary</h5>
                        <div class="mb-2">
                            <strong>Status:</strong> 
                            @switch($negotiation_details['negotiation_status'])
                                @case('user_negotiated')
                                    <span class="badge bg-warning">You Negotiated</span>
                                    @break
                                @case('admin_responded')
                                    <span class="badge bg-success">Negotiation Completed</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $negotiation_details['negotiation_status'])) }}</span>
                            @endswitch
                        </div>
                        
                        @if($service->user_negotiation_reason)
                        <div class="mb-2">
                            <strong>Your Request:</strong> {{ $service->user_negotiation_reason }}
                        </div>
                        @endif
                        
                        @if($service->admin_negotiation_response)
                        <div class="mb-2">
                            <strong>Admin Response:</strong> {{ $service->admin_negotiation_response }}
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Footer -->
                    <div class="text-center border-top pt-3 mt-4">
                        <p class="text-muted">
                            <small>
                                Thank you for using our services!<br>
                                This is a computer-generated invoice. Generated on {{ now()->format('d M, Y H:i') }}
                            </small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn-group, .card-header {
        display: none !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    
    .pricing-flow {
        page-break-inside: avoid;
    }
}

.price-arrow {
    padding: 0 10px;
}

.pricing-flow {
    padding: 20px;
    background: white;
    border-radius: 8px;
    border-left: 4px solid #28a745;
}

.price-stage {
    margin: 10px;
}

.price-value {
    font-size: 1.5rem;
    font-weight: bold;
    color: #28a745;
}

.price-label {
    font-size: 0.9rem;
    color: #666;
    margin-top: 5px;
}
</style>
@endsection