@extends('admin.layouts.layout')

@section('styles')
<style>
    .invoice-container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    
    .invoice-header {
        border-bottom: 3px solid #007bff;
        margin-bottom: 30px;
        padding-bottom: 20px;
    }
    
    .invoice-title {
        color: #007bff;
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .invoice-subtitle {
        color: #6c757d;
        font-size: 1.1rem;
    }
    
    .pricing-breakdown {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin: 20px 0;
    }
    
    .price-flow {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
        padding: 10px;
        background: white;
        border-radius: 5px;
        border-left: 4px solid #28a745;
    }
    
    .price-stage {
        text-align: center;
        flex: 1;
    }
    
    .price-arrow {
        font-size: 1.5rem;
        color: #007bff;
        margin: 0 15px;
    }
    
    .price-value {
        font-size: 1.2rem;
        font-weight: bold;
        color: #28a745;
    }
    
    .price-label {
        font-size: 0.9rem;
        color: #6c757d;
        margin-top: 5px;
    }
    
    .gst-breakdown {
        background: #e3f2fd;
        border-radius: 5px;
        padding: 15px;
        margin: 15px 0;
    }
    
    .negotiation-history {
        background: #fff3cd;
        border-radius: 5px;
        padding: 15px;
        margin: 15px 0;
        border-left: 4px solid #ffc107;
    }
    
    .print-btn {
        background: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 10px;
    }
    
    .download-btn {
        background: #28a745;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }
    
    @media print {
        .no-print {
            display: none !important;
        }
        
        .invoice-container {
            box-shadow: none;
            margin: 0;
        }
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">Additional Service Invoice</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.additional-services.index') }}">Additional Services</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Invoice</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Action Buttons -->
                        <div class="no-print text-end mb-4">
                            <button class="print-btn" onclick="window.print()">
                                <i class="fas fa-print me-2"></i>Print Invoice
                            </button>
                            <a href="{{ route('admin.additional-services.invoice.pdf', $service->id) }}" class="download-btn">
                                <i class="fas fa-download me-2"></i>Download PDF
                            </a>
                        </div>

                        <div class="invoice-container">
                            <!-- Invoice Header -->
                            <div class="invoice-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h1 class="invoice-title">INVOICE</h1>
                                        <p class="invoice-subtitle">Additional Service</p>
                                    </div>
                                    <div class="col-md-6 text-md-end">
                                        <p><strong>Invoice #:</strong> {{ $invoice_number }}</p>
                                        <p><strong>Date:</strong> {{ $invoice_date }}</p>
                                        <p><strong>Service ID:</strong> AS-{{ str_pad($service->id, 6, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer & Professional Details -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5>Bill To:</h5>
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
                                    <h5>Service Provider:</h5>
                                    <div class="border p-3 rounded">
                                        <strong>{{ $professional->name }}</strong><br>
                                        {{ $professional->email }}<br>
                                        @if($professional->phone)
                                            {{ $professional->phone }}<br>
                                        @endif
                                        Professional ID: {{ $professional->id }}
                                    </div>
                                </div>
                            </div>

                            <!-- Service Details -->
                            <div class="mb-4">
                                <h5>Service Details</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td><strong>Service Name</strong></td>
                                                <td>{{ $service->service_name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Description</strong></td>
                                                <td>{{ $service->reason }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status</strong></td>
                                                <td>
                                                    <span class="badge bg-success">Completed & Paid</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Completion Date</strong></td>
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
                                // Also show if admin manually modified price
                                $showPricingJourney = $showPricingJourney || $service->price_modified_by_admin;
                            @endphp
                            
                            @if($showPricingJourney)
                            <div class="pricing-breakdown">
                                <h5>Pricing Flow</h5>
                                <div class="price-flow">
                                    <div class="price-stage">
                                        <div class="price-value">₹{{ number_format($negotiation_details['original_price'], 2) }}</div>
                                        <div class="price-label">Original Price</div>
                                    </div>
                                    
                                    @if($negotiation_details['user_negotiated_price'])
                                    <div class="price-arrow">→</div>
                                    <div class="price-stage">
                                        <div class="price-value">₹{{ number_format($negotiation_details['user_negotiated_price'], 2) }}</div>
                                        <div class="price-label">Customer Negotiated</div>
                                    </div>
                                    @endif
                                    
                                    @if($negotiation_details['admin_final_price'])
                                    <div class="price-arrow">→</div>
                                    <div class="price-stage">
                                        <div class="price-value">₹{{ number_format($negotiation_details['admin_final_price'], 2) }}</div>
                                        <div class="price-label">Admin Final Price</div>
                                    </div>
                                    @endif
                                    
                                    <div class="price-arrow">→</div>
                                    <div class="price-stage">
                                        <div class="price-value">₹{{ number_format($pricing['total_price'], 2) }}</div>
                                        <div class="price-label">Final Price (with GST)</div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- GST Breakdown -->
                            <div class="gst-breakdown">
                                <h5>Price Breakdown</h5>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tbody>
                                            <tr>
                                                <td>Base Price</td>
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
                                                <td><strong>Total Amount</strong></td>
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
                            <div class="negotiation-history">
                                <h5>Negotiation History</h5>
                                <div class="mb-2">
                                    <strong>Status:</strong> 
                                    @switch($negotiation_details['negotiation_status'])
                                        @case('user_negotiated')
                                            <span class="badge bg-warning">Customer Negotiated</span>
                                            @break
                                        @case('admin_responded')
                                            <span class="badge bg-success">Admin Responded</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $negotiation_details['negotiation_status'])) }}</span>
                                    @endswitch
                                </div>
                                
                                @if($service->user_negotiation_reason)
                                <div class="mb-2">
                                    <strong>Customer Request:</strong> {{ $service->user_negotiation_reason }}
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
                            <div class="text-center mt-4 pt-4 border-top">
                                <p class="text-muted">
                                    <small>
                                        This is a computer-generated invoice. No signature required.<br>
                                        Generated on {{ now()->format('d M, Y H:i') }}
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Auto-focus for better printing experience
document.addEventListener('DOMContentLoaded', function() {
    // Print functionality
    window.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'p') {
            e.preventDefault();
            window.print();
        }
    });
});
</script>
@endsection