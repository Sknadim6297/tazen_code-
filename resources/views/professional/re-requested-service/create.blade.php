@extends('professional.layout.layout')

@section('title', 'Create Re-requested Service')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Create New Re-requested Service</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('professional.re-requested-service.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_id" class="form-label">Select Customer <span class="text-danger">*</span></label>
                                    <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                                        <option value="">Choose Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }} ({{ $customer->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="original_booking_id" class="form-label">Related Booking (Optional)</label>
                                    <select name="original_booking_id" id="original_booking_id" class="form-select @error('original_booking_id') is-invalid @enderror">
                                        <option value="">No Related Booking</option>
                                        @foreach($bookings as $booking)
                                            @php
                                                // prefer amount then base_amount
                                                $price = $booking->amount ?? $booking->base_amount ?? 0;
                                            @endphp
                                            <option value="{{ $booking->id }}" 
                                                    data-service="{{ e($booking->service_name) }}" 
                                                    data-price="{{ number_format($price, 2, '.', '') }}"
                                                    {{ old('original_booking_id') == $booking->id ? 'selected' : '' }}>
                                                #{{ $booking->id }} - {{ $booking->customer->name }} ({{ $booking->created_at->format('d M Y') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('original_booking_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="service_name" class="form-label">Service Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="service_name" 
                                   id="service_name" 
                                   class="form-control @error('service_name') is-invalid @enderror" 
                                   value="{{ old('service_name') }}" 
                                   placeholder="Enter service name"
                                   required>
                            @error('service_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason for Re-request <span class="text-danger">*</span></label>
                            <textarea name="reason" 
                                      id="reason" 
                                      rows="4" 
                                      class="form-control @error('reason') is-invalid @enderror" 
                                      placeholder="Explain why you need to request additional payment from the customer"
                                      required>{{ old('reason') }}</textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="original_price" class="form-label">Service Price <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" 
                                               name="original_price" 
                                               id="original_price" 
                                               class="form-control @error('original_price') is-invalid @enderror" 
                                               value="{{ old('original_price') }}" 
                                               step="0.01" 
                                               min="1"
                                               placeholder="0.00"
                                               required
                                               onInput="calculateTotal()">
                                    </div>
                                    @error('original_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">CGST (8%)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="text" id="cgst_amount" class="form-control" readonly placeholder="0.00">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">SGST (8%)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="text" id="sgst_amount" class="form-control" readonly placeholder="0.00">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Total Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="text" id="total_amount" class="form-control" readonly placeholder="0.00">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="priority" class="form-label">Priority Level <span class="text-danger">*</span></label>
                            <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                <option value="">Select Priority</option>
                                <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                                <option value="normal" {{ old('priority', 'normal') === 'normal' ? 'selected' : '' }}>Normal</option>
                                <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <small>
                                    <strong>Low:</strong> Standard processing time<br>
                                    <strong>Normal:</strong> Regular priority<br>
                                    <strong>High:</strong> Faster processing<br>
                                    <strong>Urgent:</strong> Immediate attention required
                                </small>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Note:</strong> Your request will be sent to the admin for approval. The admin may modify the price before sending it to the customer for payment.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('professional.re-requested-service.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Submit Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function calculateTotal() {
    const price = parseFloat(document.getElementById('original_price').value) || 0;
    const cgst = (price * 8) / 100;
    const sgst = (price * 8) / 100;
    const total = price + cgst + sgst;
    
    document.getElementById('cgst_amount').value = cgst.toFixed(2);
    document.getElementById('sgst_amount').value = sgst.toFixed(2);
    document.getElementById('total_amount').value = total.toFixed(2);
}

// Initialize calculation on page load
document.addEventListener('DOMContentLoaded', function() {
    calculateTotal();

    // Auto-fill when a related booking is selected
    const bookingSelect = document.getElementById('original_booking_id');
    const serviceNameInput = document.getElementById('service_name');
    const priceInput = document.getElementById('original_price');

    function applyBookingDetails() {
        const opt = bookingSelect.options[bookingSelect.selectedIndex];
        if (!opt || !opt.value) return;

        const svc = opt.getAttribute('data-service') || '';
        const price = parseFloat(opt.getAttribute('data-price')) || 0;

        // Fill fields
        if (svc && (!serviceNameInput.value || serviceNameInput.value.trim() === '')) {
            serviceNameInput.value = svc;
        }
        if (price > 0) {
            priceInput.value = price;
        }

        calculateTotal();
    }

    bookingSelect.addEventListener('change', applyBookingDetails);

    // If an option is pre-selected on page load, apply its values
    if (bookingSelect.value) {
        applyBookingDetails();
    }
});
</script>
@endpush
