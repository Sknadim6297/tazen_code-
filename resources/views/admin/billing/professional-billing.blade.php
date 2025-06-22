@extends('admin.layouts.layout')

@section('styles')
<style>
    /* Export buttons styling */
    .export-buttons {
        display: flex;
        gap: 10px;
        margin-left: 10px;
    }

    .export-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .export-btn-excel {
        background-color: #1f7244;
        color: white;
        border: none;
    }

    .export-btn-excel:hover {
        background-color: #155a33;
    }

    .export-btn-pdf {
        background-color: #c93a3a;
        color: white;
        border: none;
    }

    .export-btn-pdf:hover {
        background-color: #a52929;
    }

    /* Filter Section Styling */
    .filter-card {
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .filter-card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.12);
    }

    .filter-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px 12px 0 0;
        border: none;
        padding: 1rem 1.5rem;
    }

    .filter-card .card-title {
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .filter-card .card-body {
        padding: 1.5rem;
        background: #fafbfc;
    }

    .form-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .input-group {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
    }

    .input-group:focus-within {
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        transform: translateY(-1px);
    }

    .input-group-text {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        color: #6c757d;
        font-size: 0.875rem;
        padding: 0.75rem 1rem;
    }

    .form-control, .form-select {
        border: 1px solid #e9ecef;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
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

    .btn-outline-secondary {
        border: 2px solid #6c757d;
        color: #6c757d;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        background: #6c757d;
        border-color: #6c757d;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .filter-card .card-body {
            padding: 1rem;
        }
        
        .input-group {
            margin-bottom: 1rem;
        }
        
        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Professional Billing</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Professional</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Professional Billing</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Filter Section - Modern Design -->
        <div class="card custom-card filter-card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="ri-filter-3-line me-2 text-primary"></i>
                    Filter Billing Records
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.professional.billing') }}" method="GET" id="searchForm">
                    <div class="row g-3">
                        <!-- Date Range -->
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label fw-medium text-muted mb-2">
                                <i class="ri-calendar-line me-1"></i>Date Range
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-calendar-event-line text-muted"></i>
                                </span>
                                <input type="date" class="form-control border-start-0 border-end-0" 
                                       placeholder="Start Date" name="start_date" value="{{ request('start_date') }}">
                                <span class="input-group-text bg-light border-start-0 border-end-0 text-muted">to</span>
                                <input type="date" class="form-control border-start-0" 
                                       placeholder="End Date" name="end_date" value="{{ request('end_date') }}">
                            </div>
                        </div>
                        
                        <!-- Plan Type -->
                        <div class="col-lg-3 col-md-6">
                            <label for="planTypeFilter" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-briefcase-line me-1"></i>Plan Type
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-settings-line text-muted"></i>
                                </span>
                                <select class="form-select border-start-0" name="plan_type" id="planTypeFilter">
                                    <option value="">All Plans</option>
                                    <option value="one_time" {{ request('plan_type') == 'one_time' ? 'selected' : '' }}>One Time</option>
                                    <option value="monthly" {{ request('plan_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="quarterly" {{ request('plan_type') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                    <option value="free_hand" {{ request('plan_type') == 'free_hand' ? 'selected' : '' }}>Free Hand</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Payment Status -->
                        <div class="col-lg-3 col-md-6">
                            <label for="paymentStatusFilter" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-bank-card-line me-1"></i>Payment Status
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-check-line text-muted"></i>
                                </span>
                                <select class="form-select border-start-0" name="payment_status" id="paymentStatusFilter">
                                    <option value="">All Status</option>
                                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Service Filter -->
                        <div class="col-lg-3 col-md-6">
                            <label for="serviceFilter" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-service-line me-1"></i>Service
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-tools-line text-muted"></i>
                                </span>
                                <select class="form-select border-start-0" name="service" id="serviceFilter">
                                    <option value="">All Services</option>
                                    @foreach($serviceOptions as $serviceName)
                                    <option value="{{ $serviceName }}" {{ request('service') == $serviceName ? 'selected' : '' }}>
                                        {{ $serviceName }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <!-- Search Input -->
                        <div class="col-lg-9 col-md-6">
                            <label for="searchInput" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-search-line me-1"></i>Search
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-user-line text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" name="search" 
                                       id="searchInput" placeholder="Search by name, email or phone" value="{{ request('search') }}">
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="col-12">
                            <div class="d-flex gap-2 justify-content-end pt-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="ri-search-line me-1"></i>Search
                                </button>
                                <a href="{{ route('admin.professional.billing') }}" class="btn btn-outline-secondary px-4">
                                    <i class="ri-refresh-line me-1"></i>Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Add Export buttons outside the filter form -->
        <div class="d-flex justify-content-end mb-3">
            <div class="export-buttons">
                <button type="button" class="export-btn export-btn-excel" onclick="exportData('excel')">
                    <i class="ri-file-excel-line me-1"></i> Export Excel
                </button>
                <button type="button" class="export-btn export-btn-pdf" onclick="exportData('pdf')">
                    <i class="ri-file-pdf-line me-1"></i> Export PDF
                </button>
            </div>
        </div>

        <!-- Add this hidden form for export -->
        <form id="export-form" method="GET" action="{{ route('admin.professional.billing.export') }}">
            <!-- Hidden inputs to carry over current filters -->
            <input type="hidden" name="search" id="export-search">
            <input type="hidden" name="service" id="export-service">
            <input type="hidden" name="plan_type" id="export-plan-type">
            <input type="hidden" name="payment_status" id="export-payment-status">
            <input type="hidden" name="start_date" id="export-start-date">
            <input type="hidden" name="end_date" id="export-end-date">
        </form>

        <!-- Billing Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th>Sl. No</th>
                                <th>Date</th>
                                <th>Customer Name</th>
                                <th>Service</th>
                                <th>Professional Name</th>
                                <th>Plan Type</th>
                                <th>Received Amount</th>
                                <th>Commission Rate</th>
                                <th>Professional Pay</th>
                                <th>Status</th>
                                <th>Amount Earned</th>
                                <th>Month</th>
                                <th>Action</th>
                                <th>Details</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($billings as $key => $billing)
                            @php
                               $commissionRate = $billing->professional->margin ?? 0; 
                              $professionalPay = $billing->amount * ((100 - $commissionRate) / 100);
                              $amountEarned = $billing->amount * ($commissionRate / 100);
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $billing->created_at->format('d M Y') }}</td>
                                <td>{{ $billing->customer_name }}</td>
                                <td>
                                    <!-- Highlight the service if it's filtered -->
                                    @if(request('service') == $billing->service_name)
                                        <span class="badge bg-info">{{ $billing->service_name }}</span>
                                    @else
                                        {{ $billing->service_name }}
                                    @endif
                                </td>
                                <td>{{ $billing->professional->name ?? 'N/A' }}</td> 
                                <td>{{ ucfirst(str_replace('_', ' ', $billing->plan_type)) }}</td>
                                <td>₹{{ number_format($billing->amount, 2) }}</td>
                                <td>{{ $commissionRate }}%</td>
                                <td>₹{{ number_format($professionalPay, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $billing->payment_status == 'paid' ? 'success' : 'warning' }}">
                                        {{ ucfirst($billing->payment_status) }}
                                    </span>
                                </td>
                                <td>₹{{ number_format($amountEarned, 2) }}</td>
                                <td>{{ $billing->created_at->format('M Y') }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input payment-toggle" type="checkbox" role="switch" 
                                               id="payment-toggle-{{ $billing->id }}" 
                                               data-id="{{ $billing->id }}"
                                               data-amount="{{ $professionalPay }}"
                                               data-professional="{{ $billing->professional->id ?? '' }}"
                                               {{ $billing->paid_status == 'paid' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="payment-toggle-{{ $billing->id }}">
                                            Mark as paid
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <!-- Details button -->
                                    <button class="btn btn-info btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#detailsModal-{{ $billing->id }}">
                                        Details
                                    </button>

                                    <!-- Details Modal -->
                                    <div class="modal fade" id="detailsModal-{{ $billing->id }}" tabindex="-1" aria-labelledby="detailsModalLabel-{{ $billing->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailsModalLabel-{{ $billing->id }}">Billing Details - {{ $billing->customer_name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Service</th>
                                                            <td>{{ $billing->service_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Plan Type</th>
                                                            <td>{{ ucfirst(str_replace('_', ' ', $billing->plan_type)) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Amount</th>
                                                            <td>₹{{ number_format($billing->amount, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Commission Rate</th>
                                                            <td>{{ $commissionRate }}%</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Professional Pay</th>
                                                            <td>₹{{ number_format($professionalPay, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Payment Status</th>
                                                            <td>
                                                                <span class="badge bg-{{ $billing->paid_status == 'paid' ? 'success' : 'warning' }}">
                                                                    {{ ucfirst($billing->paid_status) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Transaction Number</th>
                                                            <td>{{ $billing->transaction_number ?? 'N/A' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Paid Date</th>
                                                            <td>{{ $billing->paid_date ? \Carbon\Carbon::parse($billing->paid_date)->format('d M Y') : 'N/A' }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="14" class="text-center">No billing records found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $billings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Process Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="paymentForm">
                    @csrf
                    <input type="hidden" id="billing_id" name="billing_id">
                    <input type="hidden" id="professional_id" name="professional_id">
                    
                    <div class="mb-3">
                        <label for="transaction_number" class="form-label">Transaction Number</label>
                        <input type="text" class="form-control" id="transaction_number" name="transaction_number" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="paid_date" class="form-label">Paid Date</label>
                        <input type="date" class="form-control" id="paid_date" name="paid_date" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="amount" class="form-label">Payable Amount</label>
                        <input type="text" class="form-control" id="amount" name="amount" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Payment Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="paid">Paid</option>
                            <option value="unpaid">Unpaid</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="savePayment">Save Payment</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        // Add Select2 for better service selection (if Select2 is available)
        if ($.fn.select2) {
            $('select[name="service"]').select2({
                placeholder: "Select a service",
                allowClear: true,
                width: '100%'
            });
        }
        
        $('#paid_date').val(new Date().toISOString().split('T')[0]);
        $('.payment-toggle').change(function () {
            const isChecked = $(this).is(':checked');
            const billingId = $(this).data('id');
            const amount = $(this).data('amount');
            const professionalId = $(this).data('professional');

            if (isChecked) {
                // Open modal to confirm and input payment info
                $('#billing_id').val(billingId);
                $('#professional_id').val(professionalId);
                $('#amount').val(amount);
                $('#status').val('paid');
                $('#paymentModal').modal('show');
            } else {
                // Confirm marking as unpaid
                if (confirm('Are you sure you want to mark this payment as unpaid?')) {
                    updatePaymentStatus(billingId, 'unpaid');
                } else {
                    $(this).prop('checked', true); // Revert switch
                }
            }
        });

        // Handle Save Payment button click from modal
        $('#savePayment').click(function () {
            const form = $('#paymentForm')[0];
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            $.ajax({
                url: "{{ route('admin.professional.payment.save') }}",
                method: "POST",
                data: $('#paymentForm').serialize(),
                success: function (response) {
                    if (response.success) {
                        toastr.success('Payment saved successfully!');
                        $('#paymentModal').modal('hide');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        toastr.error(response.message || 'Error saving payment.');
                    }
                },
                error: function (xhr) {
                    const errors = xhr.responseJSON?.errors 
                        ? Object.values(xhr.responseJSON.errors).flat() 
                        : ['An error occurred while processing your request.'];
                    errors.forEach(msg => toastr.error(msg));
                }
            });
        });

        // Reset toggle if modal is closed without saving
        $('#paymentModal').on('hidden.bs.modal', function () {
            const billingId = $('#billing_id').val();
            const toggle = $(`#payment-toggle-${billingId}`);
            if ($('#status').val() === 'unpaid') {
                toggle.prop('checked', false);
            }
        });
    });

    // Update payment status via AJAX (used for unpaid toggle)
    function updatePaymentStatus(billingId, status) {
        $.ajax({
            url: "{{ route('admin.professional.payment.update-status') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                billing_id: billingId,
                status: status
            },
            success: function (response) {
                if (response.success) {
                    toastr.success('Payment status updated successfully!');
                    
                    const row = $(`#payment-toggle-${billingId}`).closest('tr');
                    const statusBadge = row.find('.badge');

                    // Update badge status
                    if (status === 'paid') {
                        statusBadge.removeClass('bg-warning').addClass('bg-success').text('Paid');
                    } else {
                        statusBadge.removeClass('bg-success').addClass('bg-warning').text('Unpaid');
                    }

                    setTimeout(() => location.reload(), 1500);
                } else {
                    toastr.error(response.message || 'Error updating payment status');
                    $(`#payment-toggle-${billingId}`).prop('checked', status === 'paid');
                }
            },
            error: function (xhr) {
                const errors = xhr.responseJSON?.errors 
                    ? Object.values(xhr.responseJSON.errors).flat() 
                    : ['An error occurred while processing your request.'];
                errors.forEach(msg => toastr.error(msg));
                $(`#payment-toggle-${billingId}`).prop('checked', status === 'paid');
            }
        });
    }

    // Export data function
    window.exportData = function(type) {
        // Set the values of the hidden inputs to current filter values
        document.getElementById('export-search').value = document.getElementById('searchInput').value;
        document.getElementById('export-service').value = document.getElementById('serviceFilter').value;
        document.getElementById('export-plan-type').value = document.getElementById('planTypeFilter').value;
        document.getElementById('export-payment-status').value = document.getElementById('paymentStatusFilter').value;
        document.getElementById('export-start-date').value = document.querySelector('input[name="start_date"]').value;
        document.getElementById('export-end-date').value = document.querySelector('input[name="end_date"]').value;

        // Set the correct action for the export
        let form = document.getElementById('export-form');
        if (type === 'excel') {
            form.action = "{{ route('admin.professional.billing.export.excel') }}";
        } else if (type === 'pdf') {
            form.action = "{{ route('admin.professional.billing.export') }}";
        }

        // Submit the form
        form.submit();
    }
</script>
@endsection