@extends('customer.layout.layout')

@section('title', 'Invoice - Re-requested Service')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <!-- Invoice Header -->
                    <div class="invoice-header bg-primary text-white p-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h2 class="mb-1">INVOICE</h2>
                                <p class="mb-0">Re-requested Service Payment</p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <h4 class="mb-1">#{{ $reRequestedService->id }}</h4>
                                <p class="mb-0">{{ $reRequestedService->payment_completed_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Company & Customer Info -->
                    <div class="row p-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">FROM:</h6>
                            <div class="company-info">
                                <h5>Your Company Name</h5>
                                <p class="mb-1">123 Business Street</p>
                                <p class="mb-1">City, State 12345</p>
                                <p class="mb-1">Phone: +1 (234) 567-8900</p>
                                <p class="mb-0">Email: info@company.com</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">TO:</h6>
                            <div class="customer-info">
                                <h5>{{ $reRequestedService->customer->name }}</h5>
                                <p class="mb-1">{{ $reRequestedService->customer->email }}</p>
                                @if($reRequestedService->customer->phone)
                                <p class="mb-1">Phone: {{ $reRequestedService->customer->phone }}</p>
                                @endif
                                @if($reRequestedService->customer->address)
                                <p class="mb-0">{{ $reRequestedService->customer->address }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Service Details -->
                    <div class="px-4">
                        <h6 class="text-muted mb-3">SERVICE DETAILS:</h6>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Service</th>
                                        <th>Professional</th>
                                        <th>Request Date</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong>{{ $reRequestedService->service_name }}</strong>
                                            <br>
                                            <small class="text-muted">Additional Service Request</small>
                                        </td>
                                        <td>
                                            <strong>{{ $reRequestedService->professional->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $reRequestedService->professional->email }}</small>
                                        </td>
                                        <td>{{ $reRequestedService->requested_at->format('d M Y') }}</td>
                                        <td>₹{{ number_format($reRequestedService->final_price, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Request Details -->
                    <div class="px-4 mb-4">
                        <h6 class="text-muted mb-3">REQUEST DETAILS:</h6>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-2"><strong>Professional's Reason:</strong></p>
                            <p class="mb-0">{{ $reRequestedService->reason }}</p>
                            
                            @if(!empty($reRequestedService->admin_notes))
                            <hr>
                            <p class="mb-2"><strong>Admin Notes:</strong></p>
                            <p class="mb-0">{{ $reRequestedService->admin_notes }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div class="px-4">
                        <div class="row">
                            <div class="col-md-6 offset-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3">PAYMENT SUMMARY:</h6>
                                        <table class="table table-borderless mb-0">
                                            <tr>
                                                <td>Service Amount:</td>
                                                <td class="text-end">₹{{ number_format($reRequestedService->final_price, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>GST (18%):</td>
                                                <td class="text-end">₹{{ number_format($reRequestedService->gst_amount, 2) }}</td>
                                            </tr>
                                            <tr class="border-top border-2">
                                                <td><strong>Total Amount:</strong></td>
                                                <td class="text-end"><strong class="h5 text-primary">₹{{ number_format($reRequestedService->total_amount, 2) }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Payment Status:</td>
                                                <td class="text-end"><span class="badge bg-success">PAID</span></td>
                                            </tr>
                                            <tr>
                                                <td>Payment Date:</td>
                                                <td class="text-end">{{ $reRequestedService->payment_completed_at->format('d M Y, h:i A') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="invoice-footer bg-light p-4 mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted">PAYMENT METHOD:</h6>
                                <p class="mb-0">Online Payment (Razorpay)</p>
                                @if($reRequestedService->payment_id)
                                <small class="text-muted">Payment ID: {{ $reRequestedService->payment_id }}</small>
                                @endif
                            </div>
                            <div class="col-md-6 text-md-end">
                                <h6 class="text-muted">THANK YOU!</h6>
                                <p class="mb-0">For choosing our services</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="p-4 text-center border-top">
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <button onclick="window.print()" class="btn btn-primary">
                                <i class="fas fa-print"></i> Print Invoice
                            </button>
                            
                            <button onclick="downloadPDF()" class="btn btn-success">
                                <i class="fas fa-download"></i> Download PDF
                            </button>
                            
                            <a href="{{ route('user.customer.re-requested-service.show', $reRequestedService->id) }}" 
                               class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Details
                            </a>
                            
                            <a href="{{ route('user.customer.re-requested-service.index') }}" 
                               class="btn btn-outline-secondary">
                                <i class="fas fa-list"></i> All Requests
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
@media print {
    body * {
        visibility: hidden;
    }
    
    .card, .card * {
        visibility: visible;
    }
    
    .card {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none !important;
        border: none !important;
    }
    
    .btn, .no-print {
        display: none !important;
    }
    
    .invoice-header {
        background: #007bff !important;
        color: white !important;
        -webkit-print-color-adjust: exact;
    }
    
    .bg-light {
        background: #f8f9fa !important;
        -webkit-print-color-adjust: exact;
    }
}

.invoice-header {
    border-radius: 0;
}

.company-info, .customer-info {
    font-size: 0.95rem;
}

.table th {
    font-weight: 600;
    color: #495057;
}

.border-2 {
    border-width: 2px !important;
}

.card {
    border: none;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .invoice-header .text-md-end {
        text-align: left !important;
        margin-top: 1rem;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 10px;
    }
}
</style>
@endpush

@push('scripts')
<script>
function downloadPDF() {
    // You can implement PDF generation here
    // For now, we'll use the browser's print to PDF feature
    window.print();
}

document.addEventListener('DOMContentLoaded', function() {
    // Add any invoice-specific JavaScript here
    console.log('Invoice loaded for request #{{ $reRequestedService->id }}');
});
</script>
@endpush
