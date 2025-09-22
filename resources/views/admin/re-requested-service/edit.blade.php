@extends('admin.layouts.layout')

@section('title', 'Edit Re-requested Service')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Re-requested Service Price</h5>
                    <a href="{{ route('admin.re-requested-service.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.re-requested-service.update', $reRequestedService->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6>Service Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Service ID:</strong></td>
                                                <td>#{{ $reRequestedService->id }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Service Name:</strong></td>
                                                <td>{{ $reRequestedService->service_name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Professional:</strong></td>
                                                <td>{{ $reRequestedService->professional->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Customer:</strong></td>
                                                <td>{{ $reRequestedService->customer->name }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6>Original Pricing</h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Original Price:</strong></td>
                                                <td>₹{{ number_format($reRequestedService->original_price, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Original GST:</strong></td>
                                                <td>₹{{ number_format(($reRequestedService->original_price * 18) / 100, 2) }}</td>
                                            </tr>
                                            <tr class="table-active">
                                                <td><strong>Original Total:</strong></td>
                                                <td><strong>₹{{ number_format($reRequestedService->original_price + (($reRequestedService->original_price * 18) / 100), 2) }}</strong></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6>Professional's Request Reason</h6>
                                    </div>
                                    <div class="card-body">
                                        <p>{{ $reRequestedService->reason }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Modify Pricing</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="admin_modified_price" class="form-label">New Price <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">₹</span>
                                                <input type="number" 
                                                       name="admin_modified_price" 
                                                       id="admin_modified_price" 
                                                       class="form-control @error('admin_modified_price') is-invalid @enderror" 
                                                       value="{{ old('admin_modified_price', $reRequestedService->admin_modified_price ?? $reRequestedService->original_price) }}" 
                                                       step="0.01" 
                                                       min="0" 
                                                       required
                                                       onchange="calculateTotal()">
                                            </div>
                                            @error('admin_modified_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="admin_notes" class="form-label">Admin Notes</label>
                                            <textarea name="admin_notes" 
                                                      id="admin_notes" 
                                                      class="form-control @error('admin_notes') is-invalid @enderror" 
                                                      rows="4" 
                                                      placeholder="Add notes explaining the price modification">{{ old('admin_notes', $reRequestedService->admin_notes) }}</textarea>
                                            @error('admin_notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Calculated Totals</h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Modified Price:</strong></td>
                                                <td id="display-price">₹{{ number_format($reRequestedService->admin_modified_price ?? $reRequestedService->original_price, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>GST (18%):</strong></td>
                                                <td id="display-gst">₹{{ number_format((($reRequestedService->admin_modified_price ?? $reRequestedService->original_price) * 18) / 100, 2) }}</td>
                                            </tr>
                                            <tr class="table-active">
                                                <td><strong>Final Total:</strong></td>
                                                <td id="display-total"><strong>₹{{ number_format(($reRequestedService->admin_modified_price ?? $reRequestedService->original_price) + ((($reRequestedService->admin_modified_price ?? $reRequestedService->original_price) * 18) / 100), 2) }}</strong></td>
                                            </tr>
                                        </table>
                                        
                                        <div class="alert alert-info mt-3">
                                            <i class="fas fa-info-circle"></i>
                                            <small>GST is automatically calculated at 18% of the modified price.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Price
                                    </button>
                                    <a href="{{ route('admin.re-requested-service.show', $reRequestedService->id) }}" class="btn btn-secondary">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
function calculateTotal() {
    const priceInput = document.getElementById('admin_modified_price');
    const price = parseFloat(priceInput.value) || 0;
    const gst = (price * 18) / 100;
    const total = price + gst;
    
    document.getElementById('display-price').textContent = '₹' + price.toFixed(2);
    document.getElementById('display-gst').textContent = '₹' + gst.toFixed(2);
    document.getElementById('display-total').innerHTML = '<strong>₹' + total.toFixed(2) + '</strong>';
}

// Initialize calculation on page load
document.addEventListener('DOMContentLoaded', function() {
    calculateTotal();
});
</script>
@endpush
