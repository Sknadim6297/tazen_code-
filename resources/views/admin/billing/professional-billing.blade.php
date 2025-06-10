@extends('admin.layouts.layout')

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
        <!-- End Page Header -->

        <!-- Search Container -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.professional.billing') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Date Range</label>
                            <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">To</label>
                            <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Plan Type</label>
                            <select class="form-select" name="plan_type">
                                <option value="">All Plans</option>
                                <option value="one_time" {{ request('plan_type') == 'one_time' ? 'selected' : '' }}>One Time</option>
                                <option value="monthly" {{ request('plan_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="quarterly" {{ request('plan_type') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                <option value="free_hand" {{ request('plan_type') == 'free_hand' ? 'selected' : '' }}>Free Hand</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Payment Status</label>
                            <select class="form-select" name="payment_status">
                                <option value="">All Status</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{ route('admin.professional.billing') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

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
                               $commissionRate = $billing->professional->margin; 
                              $professionalPay = $billing->amount * ((100 - $commissionRate) / 100);
                              $amountEarned = $billing->amount * ($commissionRate / 100);
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $billing->created_at->format('d M Y') }}</td>
                                <td>{{ $billing->customer_name }}</td>
                                <td>{{ $billing->service_name }}</td>
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
</script>



@endsection