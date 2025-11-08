@extends('admin.layouts.layout')

@section('styles')
<style>
    .form-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-bottom: 25px;
        border: 1px solid #e3f2fd;
    }
    
    .info-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 25px;
        border-radius: 12px;
        border-left: 4px solid #007bff;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.1);
    }
    
    .price-display {
        background: linear-gradient(135deg, #e8f5e8 0%, #f0f8f0 100%);
        padding: 25px;
        border-radius: 12px;
        border-left: 4px solid #28a745;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.1);
    }
    
    .price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        padding: 8px 0;
    }
    
    .price-row.total {
        border-top: 2px solid #28a745;
        padding-top: 15px;
        margin-top: 15px;
        font-weight: bold;
        font-size: 1.2rem;
        color: #28a745;
    }
    
    .status-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-pending { 
        background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); 
        color: #856404; 
        border: 1px solid #ffeaa7;
    }
    
    .status-approved { 
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); 
        color: #155724; 
        border: 1px solid #c3e6cb;
    }
    
    .status-rejected { 
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); 
        color: #721c24; 
        border: 1px solid #f5c6cb;
    }
    
    .nav-tabs {
        border-bottom: 3px solid #e9ecef;
        margin-bottom: 0;
    }
    
    .nav-tabs .nav-link {
        border: none;
        padding: 15px 25px;
        font-weight: 600;
        color: #6c757d;
        background: transparent;
        transition: all 0.3s ease;
        border-radius: 10px 10px 0 0;
        margin-right: 5px;
    }
    
    .nav-tabs .nav-link:hover {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        color: #495057;
        transform: translateY(-2px);
    }
    
    .nav-tabs .nav-link.active {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
        border: none;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
    }
    
    .tab-content {
        background: white;
        padding: 30px;
        border-radius: 0 15px 15px 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: 1px solid #e9ecef;
        border-top: none;
    }
    
    .alert {
        border: none;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .alert-info {
        background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
        color: #0c5460;
        border-left: 4px solid #17a2b8;
    }
    
    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
        border-left: 4px solid #28a745;
    }
    
    .alert-warning {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
        color: #856404;
        border-left: 4px solid #ffc107;
    }
    
    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
        border-left: 4px solid #dc3545;
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        transform: translateY(-1px);
    }
    
    .btn {
        padding: 12px 25px;
        border-radius: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border: none;
        min-width: 140px;
        margin-right: 10px;
        margin-bottom: 10px;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
        color: #212529;
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #545b62 100%);
    }
    
    .price-calculation {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 25px;
        border-radius: 12px;
        margin-top: 25px;
        border: 1px solid #dee2e6;
    }
    
    .price-comparison {
        margin-top: 25px;
    }
    
    .original-price-section {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
        padding: 20px;
        border-radius: 12px;
        border-left: 4px solid #ffc107;
        margin-bottom: 15px;
    }
    
    .modified-price-section {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        padding: 20px;
        border-radius: 12px;
        border-left: 4px solid #28a745;
    }
    
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }
    
    .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #dee2e6;
        border-radius: 12px 12px 0 0 !important;
        padding: 15px 20px;
    }
    
    .custom-control-label {
        font-weight: 600;
        color: #495057;
    }
    
    .required::after {
        content: ' *';
        color: #dc3545;
        font-weight: bold;
    }
    
    .text-muted {
        color: #6c757d !important;
    }
    
    .badge {
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 600;
    }
    
    .badge-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">
                    <i class="fas fa-edit text-primary"></i> Review Re-requested Service
                </h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.re-requested-services.index') }}">Re-requested Services</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Review #{{ $reRequestedService->id }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Request Information -->
                <div class="form-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-file-invoice text-primary"></i> Request Details
                        </h5>
                        <div>
                            <span class="badge badge-primary">#{{ $reRequestedService->id }}</span>
                            <span class="status-badge status-{{ $reRequestedService->admin_status }}">
                                {{ ucfirst($reRequestedService->admin_status) }}
                            </span>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-user-tie"></i> Professional Information
                                </h6>
                                <p><strong>Name:</strong> {{ $reRequestedService->professional->name }}</p>
                                <p><strong>Email:</strong> {{ $reRequestedService->professional->email }}</p>
                                <p><strong>Mobile:</strong> {{ $reRequestedService->professional->mobile }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-user"></i> Customer Information
                                </h6>
                                <p><strong>Name:</strong> {{ $reRequestedService->user->name }}</p>
                                <p><strong>Email:</strong> {{ $reRequestedService->user->email }}</p>
                                <p><strong>Mobile:</strong> {{ $reRequestedService->user->mobile ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Service Name:</strong> {{ $reRequestedService->service_name }}</p>
                                <p><strong>Original Booking:</strong> #{{ $reRequestedService->booking_id }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Created:</strong> {{ $reRequestedService->created_at->format('M d, Y h:i A') }}</p>
                                <p><strong>GST State:</strong> {{ ucfirst($reRequestedService->gst_state) }}</p>
                            </div>
                        </div>

                        <div class="mt-3">
                            <strong><i class="fas fa-comment-alt"></i> Reason for Additional Service:</strong>
                            <div class="alert alert-light mt-2">
                                {{ $reRequestedService->reason }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Actions -->
                <div class="form-card">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-clipboard-check text-primary"></i> Admin Actions
                    </h5>

                    <!-- Navigation Tabs -->
                    <ul class="nav nav-tabs" id="adminTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="price-edit-tab" data-toggle="tab" href="#price-edit" role="tab">
                                <i class="fas fa-dollar-sign"></i> Edit Price
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="approve-tab" data-toggle="tab" href="#approve" role="tab">
                                <i class="fas fa-check"></i> Approve
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="reject-tab" data-toggle="tab" href="#reject" role="tab">
                                <i class="fas fa-times"></i> Reject
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="approve-modify-tab" data-toggle="tab" href="#approve-modify" role="tab">
                                <i class="fas fa-check-double"></i> Approve & Modify
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="adminTabsContent">
                        <!-- Price Edit Tab -->
                        <div class="tab-pane fade show active" id="price-edit" role="tabpanel">
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle"></i> Price Edit Only</h6>
                                <p class="mb-0">Update service price without changing approval status. Current status: <strong>{{ ucfirst($reRequestedService->admin_status) }}</strong></p>
                            </div>

                            <form action="{{ route('admin.re-requested-services.update-price', $reRequestedService) }}" method="POST" id="priceEditForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_base_price" class="required">Base Price (₹)</label>
                                            <input type="number" class="form-control" id="edit_base_price" name="modified_base_price" 
                                                   value="{{ $reRequestedService->modified_base_price ?? $reRequestedService->base_price }}" 
                                                   min="1" step="0.01" required>
                                            <small class="form-text text-muted">
                                                Original: ₹{{ number_format($reRequestedService->base_price, 2) }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Price (with GST)</label>
                                            <input type="text" class="form-control" id="edit_total_display" readonly 
                                                   style="background-color: #f8f9fa; font-weight: bold; color: #28a745;">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="edit_reason" class="required">Reason for Price Change</label>
                                    <textarea class="form-control" id="edit_reason" name="price_modification_reason" rows="3" 
                                              placeholder="Enter detailed reason for price modification..." required>{{ $reRequestedService->price_modification_reason }}</textarea>
                                    <small class="form-text text-muted">This will be visible to the customer</small>
                                </div>

                                <div class="price-calculation" id="editPriceBreakdown">
                                    <h6 class="mb-3"><i class="fas fa-calculator"></i> Price Breakdown</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Base Price:</span>
                                                <span id="edit_calc_base" class="font-weight-bold text-primary"></span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>CGST (9%):</span>
                                                <span id="edit_calc_cgst" class="text-info"></span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>SGST (9%):</span>
                                                <span id="edit_calc_sgst" class="text-info"></span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>IGST (0%):</span>
                                                <span class="text-muted">₹0.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between price-row total">
                                        <strong>Total Amount:</strong>
                                        <strong id="edit_calc_total" class="text-success"></strong>
                                    </div>
                                </div>

                                <div class="text-right mt-4">
                                    <a href="{{ route('admin.re-requested-services.show', $reRequestedService) }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back to View
                                    </a>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-save"></i> Update Price
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Approve Tab -->
                        <div class="tab-pane fade" id="approve" role="tabpanel">
                            <div class="alert alert-success">
                                <h6><i class="fas fa-check-circle"></i> Approve Request</h6>
                                <p class="mb-0">Approve this request with current pricing. Notifications will be sent to both professional and customer.</p>
                            </div>

                            <form action="{{ route('admin.re-requested-services.update', $reRequestedService) }}" method="POST" id="approveForm">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="admin_status" value="approved">

                                <div class="form-group">
                                    <label for="approve_comments">Admin Comments (Optional)</label>
                                    <textarea class="form-control" id="approve_comments" name="admin_reason" rows="4" 
                                              placeholder="Enter any comments for this approval...">{{ old('admin_reason', $reRequestedService->admin_reason) }}</textarea>
                                </div>

                                <!-- Optional Price Modification -->
                                <div class="card">
                                    <div class="card-header">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="approve_with_price_change">
                                            <label class="custom-control-label" for="approve_with_price_change">
                                                <i class="fas fa-dollar-sign"></i> Also modify price during approval
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-body" id="approve_price_section" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="approve_base_price">Modified Base Price (₹)</label>
                                                    <input type="number" class="form-control" id="approve_base_price" name="modified_base_price" 
                                                           value="{{ $reRequestedService->base_price }}" min="1" step="0.01">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Total with GST</label>
                                                    <input type="text" class="form-control" id="approve_total_display" readonly 
                                                           style="background-color: #f8f9fa;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="approve_price_reason">Reason for Price Change</label>
                                            <textarea class="form-control" id="approve_price_reason" name="price_modification_reason" 
                                                      rows="2" placeholder="Why is the price being modified?"></textarea>
                                        </div>
                                        <input type="hidden" name="price_modified_by_admin" id="approve_price_flag" value="0">
                                    </div>
                                </div>

                                <div class="text-right mt-4">
                                    <a href="{{ route('admin.re-requested-services.show', $reRequestedService) }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back to View
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check"></i> Approve Request
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Reject Tab -->
                        <div class="tab-pane fade" id="reject" role="tabpanel">
                            <div class="alert alert-danger">
                                <h6><i class="fas fa-exclamation-triangle"></i> Reject Request</h6>
                                <p class="mb-0">Reject this request. A notification will be sent to the professional with your reason.</p>
                            </div>

                            <form action="{{ route('admin.re-requested-services.update', $reRequestedService) }}" method="POST" id="rejectForm">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="admin_status" value="rejected">

                                <div class="form-group">
                                    <label for="reject_reason" class="required">Reason for Rejection</label>
                                    <textarea class="form-control @error('admin_reason') is-invalid @enderror" 
                                              id="reject_reason" name="admin_reason" rows="5" 
                                              placeholder="Please provide a detailed explanation for why this request is being rejected..."
                                              required>{{ old('admin_reason', $reRequestedService->admin_reason) }}</textarea>
                                    @error('admin_reason')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Minimum 20 characters required</small>
                                </div>

                                <div class="text-right mt-4">
                                    <a href="{{ route('admin.re-requested-services.show', $reRequestedService) }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back to View
                                    </a>
                                    <button type="submit" class="btn btn-danger" id="rejectBtn" disabled>
                                        <i class="fas fa-times"></i> Reject Request
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Approve & Modify Tab -->
                        <div class="tab-pane fade" id="approve-modify" role="tabpanel">
                            <div class="alert alert-warning">
                                <h6><i class="fas fa-edit"></i> Approve with Price Modification</h6>
                                <p class="mb-0">Approve the request with a modified price. Customer will see both original and new pricing.</p>
                            </div>

                            <form action="{{ route('admin.re-requested-services.update', $reRequestedService) }}" method="POST" id="approveModifyForm">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="admin_status" value="approved">
                                <input type="hidden" name="price_modified_by_admin" value="1">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="modify_base_price" class="required">Modified Base Price (₹)</label>
                                            <input type="number" class="form-control @error('modified_base_price') is-invalid @enderror" 
                                                   id="modify_base_price" name="modified_base_price" 
                                                   value="{{ old('modified_base_price', $reRequestedService->modified_base_price ?? $reRequestedService->base_price) }}" 
                                                   min="1" step="0.01" required>
                                            @error('modified_base_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="modify_gst_state" class="required">GST State</label>
                                            <select class="form-control @error('modified_gst_state') is-invalid @enderror" 
                                                    id="modify_gst_state" name="modified_gst_state" required>
                                                <option value="">Select GST State</option>
                                                <option value="same" {{ old('modified_gst_state', $reRequestedService->gst_state) == 'same' ? 'selected' : '' }}>
                                                    Same State (CGST + SGST)
                                                </option>
                                                <option value="different" {{ old('modified_gst_state', $reRequestedService->gst_state) == 'different' ? 'selected' : '' }}>
                                                    Different State (IGST)
                                                </option>
                                            </select>
                                            @error('modified_gst_state')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="modify_price_reason" class="required">Reason for Price Modification</label>
                                    <textarea class="form-control @error('price_modification_reason') is-invalid @enderror" 
                                              id="modify_price_reason" name="price_modification_reason" rows="3" 
                                              placeholder="Explain why the price is being modified..."
                                              required>{{ old('price_modification_reason', $reRequestedService->price_modification_reason) }}</textarea>
                                    @error('price_modification_reason')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="modify_admin_comments">Additional Admin Comments (Optional)</label>
                                    <textarea class="form-control" id="modify_admin_comments" name="admin_reason" rows="2" 
                                              placeholder="Any additional comments for this approval...">{{ old('admin_reason', $reRequestedService->admin_reason) }}</textarea>
                                </div>

                                <!-- Price Comparison -->
                                <div class="price-comparison" id="modifyPriceComparison" style="display: none;">
                                    <h6 class="mb-3"><i class="fas fa-balance-scale"></i> Price Comparison</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="original-price-section">
                                                <h6 class="text-warning mb-3"><i class="fas fa-tag"></i> Original Price</h6>
                                                <div class="price-row">
                                                    <span>Base Price:</span>
                                                    <span>₹{{ number_format($reRequestedService->base_price, 2) }}</span>
                                                </div>
                                                <div class="price-row">
                                                    <span>CGST (9%):</span>
                                                    <span>₹{{ number_format($reRequestedService->cgst, 2) }}</span>
                                                </div>
                                                <div class="price-row">
                                                    <span>SGST (9%):</span>
                                                    <span>₹{{ number_format($reRequestedService->sgst, 2) }}</span>
                                                </div>
                                                <div class="price-row">
                                                    <span>IGST (0%):</span>
                                                    <span>₹{{ number_format($reRequestedService->igst, 2) }}</span>
                                                </div>
                                                <div class="price-row total">
                                                    <span>Total:</span>
                                                    <span>₹{{ number_format($reRequestedService->total_price, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="modified-price-section">
                                                <h6 class="text-success mb-3"><i class="fas fa-tags"></i> Modified Price</h6>
                                                <div class="price-row">
                                                    <span>Base Price:</span>
                                                    <span id="modify_calc_base">₹0.00</span>
                                                </div>
                                                <div class="price-row" id="modify_cgst_row">
                                                    <span>CGST (9%):</span>
                                                    <span id="modify_calc_cgst">₹0.00</span>
                                                </div>
                                                <div class="price-row" id="modify_sgst_row">
                                                    <span>SGST (9%):</span>
                                                    <span id="modify_calc_sgst">₹0.00</span>
                                                </div>
                                                <div class="price-row" id="modify_igst_row" style="display: none;">
                                                    <span>IGST (18%):</span>
                                                    <span id="modify_calc_igst">₹0.00</span>
                                                </div>
                                                <div class="price-row total">
                                                    <span>Total:</span>
                                                    <span id="modify_calc_total">₹0.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right mt-4">
                                    <a href="{{ route('admin.re-requested-services.show', $reRequestedService) }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back to View
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-check-double"></i> Approve with Modified Price
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Current Price Display -->
                <div class="form-card">
                    <h6 class="text-primary mb-4">
                        <i class="fas fa-calculator"></i> Current Price Information
                    </h6>
                    
                    <div class="price-display">
                        @if($reRequestedService->price_modified_by_admin)
                            <div class="alert alert-warning mb-3">
                                <small><i class="fas fa-edit"></i> Price has been modified by admin</small>
                            </div>
                        @endif
                        
                        <div class="price-row">
                            <span>Base Price:</span>
                            <span class="font-weight-bold">₹{{ number_format($reRequestedService->modified_base_price ?? $reRequestedService->base_price, 2) }}</span>
                        </div>
                        <div class="price-row">
                            <span>CGST (9%):</span>
                            <span>₹{{ number_format(($reRequestedService->modified_base_price ?? $reRequestedService->base_price) * 0.09, 2) }}</span>
                        </div>
                        <div class="price-row">
                            <span>SGST (9%):</span>
                            <span>₹{{ number_format(($reRequestedService->modified_base_price ?? $reRequestedService->base_price) * 0.09, 2) }}</span>
                        </div>
                        <div class="price-row">
                            <span>IGST (0%):</span>
                            <span>₹0.00</span>
                        </div>
                        <div class="price-row total">
                            <span>Total Price:</span>
                            <span>₹{{ number_format(($reRequestedService->modified_base_price ?? $reRequestedService->base_price) * 1.18, 2) }}</span>
                        </div>
                        
                        @if($reRequestedService->price_modified_by_admin && $reRequestedService->price_modification_reason)
                            <hr>
                            <div class="mt-3">
                                <small class="text-muted">
                                    <strong>Price Modification Reason:</strong><br>
                                    {{ $reRequestedService->price_modification_reason }}
                                </small>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Original Booking Information -->
                <div class="form-card">
                    <h6 class="text-primary mb-4">
                        <i class="fas fa-history"></i> Original Booking
                    </h6>
                    
                    <div class="info-card">
                        <p><strong>Booking ID:</strong> #{{ $reRequestedService->booking->id }}</p>
                        <p><strong>Service:</strong> {{ $reRequestedService->booking->service_name }}</p>
                        <p><strong>Plan Type:</strong> {{ ucfirst(str_replace('_', ' ', $reRequestedService->booking->plan_type)) }}</p>
                        <p><strong>Original Amount:</strong> ₹{{ number_format($reRequestedService->booking->amount, 2) }}</p>
                        <p><strong>Booking Date:</strong> {{ \Carbon\Carbon::parse($reRequestedService->booking->booking_date)->format('M d, Y') }}</p>
                        
                        @if($reRequestedService->base_price != $reRequestedService->booking->amount)
                            <hr>
                            <div class="alert alert-info">
                                <small>
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Note:</strong> Re-request amount (₹{{ number_format($reRequestedService->base_price, 2) }}) 
                                    differs from original booking amount.
                                </small>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Guidelines -->
                <div class="form-card">
                    <h6 class="text-primary mb-4">
                        <i class="fas fa-lightbulb"></i> Action Guidelines
                    </h6>
                    
                    <div class="info-card">
                        <div class="small">
                            <div class="mb-3">
                                <strong class="text-warning"><i class="fas fa-dollar-sign"></i> Edit Price:</strong>
                                <p class="mb-0 text-muted">Update pricing without changing approval status</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong class="text-success"><i class="fas fa-check"></i> Approve:</strong>
                                <p class="mb-0 text-muted">Accept request with current/optional pricing</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong class="text-danger"><i class="fas fa-times"></i> Reject:</strong>
                                <p class="mb-0 text-muted">Decline request with detailed reason</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong class="text-primary"><i class="fas fa-check-double"></i> Approve & Modify:</strong>
                                <p class="mb-0 text-muted">Accept with comprehensive price changes</p>
                            </div>
                            
                            <hr>
                            
                            <div class="alert alert-light">
                                <strong><i class="fas fa-envelope"></i> Notifications:</strong>
                                <ul class="mb-0 pl-3">
                                    <li>Professional: Gets all decision updates</li>
                                    <li>Customer: Notified on approval/price changes</li>
                                    <li>System: Automatic status tracking</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="form-card">
                    <h6 class="text-primary mb-4">
                        <i class="fas fa-chart-line"></i> Request Stats
                    </h6>
                    
                    <div class="info-card">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-right">
                                    <h5 class="mb-1 text-primary">{{ $reRequestedService->created_at->diffInDays() }}</h5>
                                    <small class="text-muted">Days Old</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h5 class="mb-1 text-{{ $reRequestedService->admin_status == 'pending' ? 'warning' : ($reRequestedService->admin_status == 'approved' ? 'success' : 'danger') }}">
                                    {{ ucfirst($reRequestedService->admin_status) }}
                                </h5>
                                <small class="text-muted">Status</small>
                            </div>
                        </div>
                        
                        @if($reRequestedService->admin_reviewed_at)
                            <hr>
                            <small class="text-muted">
                                <i class="fas fa-clock"></i> 
                                Last reviewed: {{ $reRequestedService->admin_reviewed_at->format('M d, Y h:i A') }}
                            </small>
                        @endif
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Tab switching functionality
    $('.nav-tabs a').on('click', function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // Price calculation functions
    function calculateGST(basePrice) {
        const cgst = basePrice * 0.09;
        const sgst = basePrice * 0.09;
        const igst = 0;
        const total = basePrice + cgst + sgst + igst;
        
        return {
            basePrice: basePrice,
            cgst: cgst,
            sgst: sgst,
            igst: igst,
            total: total
        };
    }

    function updatePriceDisplay(prices, targetPrefix = '') {
        $(`${targetPrefix}#base-price-display`).text('₹' + prices.basePrice.toLocaleString('en-IN', {minimumFractionDigits: 2}));
        $(`${targetPrefix}#cgst-display`).text('₹' + prices.cgst.toLocaleString('en-IN', {minimumFractionDigits: 2}));
        $(`${targetPrefix}#sgst-display`).text('₹' + prices.sgst.toLocaleString('en-IN', {minimumFractionDigits: 2}));
        $(`${targetPrefix}#igst-display`).text('₹' + prices.igst.toLocaleString('en-IN', {minimumFractionDigits: 2}));
        $(`${targetPrefix}#total-price-display`).text('₹' + prices.total.toLocaleString('en-IN', {minimumFractionDigits: 2}));
    }

    // Tab 1: Price Edit Only
    $('#new_base_price').on('input', function() {
        const basePrice = parseFloat($(this).val()) || 0;
        const prices = calculateGST(basePrice);
        updatePriceDisplay(prices, '#price-edit-');
        
        // Update hidden fields
        $('#price_edit_cgst').val(prices.cgst.toFixed(2));
        $('#price_edit_sgst').val(prices.sgst.toFixed(2));
        $('#price_edit_igst').val(prices.igst.toFixed(2));
        $('#price_edit_total').val(prices.total.toFixed(2));
    });

    // Tab 2: Approve (optional price change)
    $('#approve_new_price').on('input', function() {
        const basePrice = parseFloat($(this).val()) || {{ $reRequestedService->modified_base_price ?? $reRequestedService->base_price }};
        const prices = calculateGST(basePrice);
        updatePriceDisplay(prices, '#approve-');
        
        // Update hidden fields
        $('#approve_cgst').val(prices.cgst.toFixed(2));
        $('#approve_sgst').val(prices.sgst.toFixed(2));
        $('#approve_igst').val(prices.igst.toFixed(2));
        $('#approve_total').val(prices.total.toFixed(2));
    });

    // Tab 4: Approve & Modify
    $('#modify_new_price').on('input', function() {
        const basePrice = parseFloat($(this).val()) || 0;
        const originalPrice = {{ $reRequestedService->modified_base_price ?? $reRequestedService->base_price }};
        const prices = calculateGST(basePrice);
        
        updatePriceDisplay(prices, '#modify-');
        
        // Show price comparison
        const difference = basePrice - originalPrice;
        const percentChange = ((difference / originalPrice) * 100).toFixed(1);
        
        let changeText = '';
        let changeClass = '';
        
        if (difference > 0) {
            changeText = `+₹${difference.toFixed(2)} (+${percentChange}%)`;
            changeClass = 'text-success';
        } else if (difference < 0) {
            changeText = `-₹${Math.abs(difference).toFixed(2)} (${percentChange}%)`;
            changeClass = 'text-danger';
        } else {
            changeText = 'No change';
            changeClass = 'text-muted';
        }
        
        $('#price-change-indicator').html(`<span class="${changeClass}"><i class="fas fa-exchange-alt"></i> ${changeText}</span>`);
        
        // Update hidden fields
        $('#modify_cgst').val(prices.cgst.toFixed(2));
        $('#modify_sgst').val(prices.sgst.toFixed(2));
        $('#modify_igst').val(prices.igst.toFixed(2));
        $('#modify_total').val(prices.total.toFixed(2));
    });

    // Initialize displays with current values
    const currentBasePrice = {{ $reRequestedService->modified_base_price ?? $reRequestedService->base_price }};
    const currentPrices = calculateGST(currentBasePrice);
    
    // Set default values for approve tab
    $('#approve_new_price').val(currentBasePrice);
    updatePriceDisplay(currentPrices, '#approve-');
    $('#approve_cgst').val(currentPrices.cgst.toFixed(2));
    $('#approve_sgst').val(currentPrices.sgst.toFixed(2));
    $('#approve_igst').val(currentPrices.igst.toFixed(2));
    $('#approve_total').val(currentPrices.total.toFixed(2));

    // Form submission handling
    $('.admin-form').on('submit', function(e) {
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        // Show loading state
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        
        // Basic validation
        if (form.attr('id') === 'reject-form') {
            const reason = $('#reject_reason').val().trim();
            if (reason.length < 10) {
                e.preventDefault();
                alert('Please provide a detailed rejection reason (minimum 10 characters).');
                submitBtn.prop('disabled', false).html(originalText);
                return;
            }
        }
        
        if (form.find('input[name="new_base_price"]').length > 0) {
            const price = parseFloat(form.find('input[name="new_base_price"]').val());
            if (isNaN(price) || price <= 0) {
                e.preventDefault();
                alert('Please enter a valid price greater than 0.');
                submitBtn.prop('disabled', false).html(originalText);
                return;
            }
        }
        
        // Add confirmation for price changes
        if (form.attr('id') === 'modify-form') {
            const newPrice = parseFloat($('#modify_new_price').val());
            const originalPrice = {{ $reRequestedService->modified_base_price ?? $reRequestedService->base_price }};
            
            if (Math.abs(newPrice - originalPrice) > (originalPrice * 0.5)) {
                if (!confirm('The price change is more than 50%. Are you sure you want to proceed?')) {
                    e.preventDefault();
                    submitBtn.prop('disabled', false).html(originalText);
                    return;
                }
            }
        }
        
        // Re-enable button after 3 seconds if form hasn't submitted
        setTimeout(function() {
            if (submitBtn.prop('disabled')) {
                submitBtn.prop('disabled', false).html(originalText);
            }
        }, 3000);
    });

    // Character counter for text areas
    $('textarea').each(function() {
        const maxLength = $(this).attr('maxlength');
        if (maxLength) {
            const textarea = $(this);
            const counter = $('<small class="text-muted float-right"></small>');
            textarea.after(counter);
            
            function updateCounter() {
                const remaining = maxLength - textarea.val().length;
                counter.text(`${remaining} characters remaining`);
                
                if (remaining < 50) {
                    counter.removeClass('text-muted').addClass('text-warning');
                } else if (remaining < 20) {
                    counter.removeClass('text-warning').addClass('text-danger');
                } else {
                    counter.removeClass('text-warning text-danger').addClass('text-muted');
                }
            }
            
            textarea.on('input', updateCounter);
            updateCounter();
        }
    });

    // Auto-resize textareas
    $('textarea').each(function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    }).on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    // Enhanced tooltips
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        placement: 'top'
    });

    // Status indicator animations
    $('.status-badge').hover(function() {
        $(this).addClass('animated pulse');
    }, function() {
        $(this).removeClass('animated pulse');
    });

    // Price input formatting
    $('input[type="number"]').on('blur', function() {
        const value = parseFloat($(this).val());
        if (!isNaN(value)) {
            $(this).val(value.toFixed(2));
        }
    });

    // Prevent form submission on enter key in input fields
    $('input').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
});
</script>

<style>
.animated {
    animation-duration: 1s;
    animation-fill-mode: both;
}

.pulse {
    animation-name: pulse;
}

@keyframes pulse {
    from {
        transform: scale3d(1, 1, 1);
    }

    50% {
        transform: scale3d(1.05, 1.05, 1.05);
    }

    to {
        transform: scale3d(1, 1, 1);
    }
}

.price-row {
    animation: fadeInUp 0.3s ease-in-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translate3d(0, 40px, 0);
    }

    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}

/* Loading states */
button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

/* Form validation states */
.is-valid {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

/* Enhanced form controls */
.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    transform: translateY(-1px);
}

/* Price display enhancements */
.price-display {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.price-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

.price-row:last-child {
    border-bottom: none;
}

.price-row.total {
    font-weight: bold;
    font-size: 1.1em;
    color: #007bff;
    border-top: 2px solid #007bff;
    margin-top: 10px;
    padding-top: 15px;
}
</style>
@endpush

@section('scripts')
<script>
$(document).ready(function() {
    // Price calculation for modify tab
    function calculateModifiedPrice() {
        const basePrice = parseFloat($('#modified_base_price').val()) || 0;
        const gstState = $('#modified_gst_state').val();
        
        let cgst = 0, sgst = 0, igst = 0;
        
        if (gstState === 'same') {
            cgst = basePrice * 0.09;
            sgst = basePrice * 0.09;
            igst = 0;
            
            $('#modifiedCGSTRow, #modifiedSGSTRow').show();
            $('#modifiedIGSTRow').hide();
        } else if (gstState === 'different') {
            cgst = 0;
            sgst = 0;
            igst = basePrice * 0.18;
            
            $('#modifiedCGSTRow, #modifiedSGSTRow').hide();
            $('#modifiedIGSTRow').show();
        }
        
        const totalPrice = basePrice + cgst + sgst + igst;
        
        // Update display
        $('#modifiedBasePrice').text('₹' + basePrice.toFixed(2));
        $('#modifiedCGST').text('₹' + cgst.toFixed(2));
        $('#modifiedSGST').text('₹' + sgst.toFixed(2));
        $('#modifiedIGST').text('₹' + igst.toFixed(2));
        $('#modifiedTotalPrice').text('₹' + totalPrice.toFixed(2));
        
        // Show price comparison if both fields are filled
        if (basePrice > 0 && gstState) {
            $('#priceComparison').show();
        } else {
            $('#priceComparison').hide();
        }
    }
    
    // Bind events for price calculation
    $('#modified_base_price, #modified_gst_state').on('input change', calculateModifiedPrice);
    
    // Initialize calculation when modify tab is shown
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        if (e.target.getAttribute('href') === '#modify') {
            calculateModifiedPrice();
        }
    });
    
    // Form validation for reject tab
    $('#reject_reason').on('input', function() {
        const reason = $(this).val().trim();
        const submitBtn = $(this).closest('form').find('button[type="submit"]');
        
        if (reason.length < 10) {
            submitBtn.prop('disabled', true);
        } else {
            submitBtn.prop('disabled', false);
        }
    });
    
    // Form validation for modify tab
    $('#modifyForm').on('submit', function(e) {
        const basePrice = parseFloat($('#modified_base_price').val());
        const gstState = $('#modified_gst_state').val();
        const reason = $('#price_modification_reason').val().trim();
        
        if (!basePrice || basePrice <= 0) {
            e.preventDefault();
            alert('Please enter a valid modified base price');
            $('#modified_base_price').focus();
            return false;
        }
        
        if (!gstState) {
            e.preventDefault();
            alert('Please select GST state');
            $('#modified_gst_state').focus();
            return false;
        }
        
        if (reason.length < 10) {
            e.preventDefault();
            alert('Please provide a detailed reason for price modification (minimum 10 characters)');
            $('#price_modification_reason').focus();
            return false;
        }
        
        // Show loading
        $(this).find('button[type="submit"]').prop('disabled', true).html(
            '<i class="fas fa-spinner fa-spin"></i> Processing...'
        );
    });
    
    // Show loading for other forms
    $('form').not('#modifyForm').on('submit', function() {
        $(this).find('button[type="submit"]').prop('disabled', true).html(
            '<i class="fas fa-spinner fa-spin"></i> Processing...'
        );
    });

    // Price Edit Only form validation
    $('#priceOnlyEditForm').on('submit', function(e) {
        const basePrice = parseFloat($('#price_only_base_price').val());
        const reason = $('#price_only_reason').val().trim();

        if (!basePrice || basePrice <= 0) {
            e.preventDefault();
            alert('Please enter a valid price');
            $('#price_only_base_price').focus();
            return false;
        }

        if (reason.length < 10) {
            e.preventDefault();
            alert('Please provide a detailed reason for price modification (minimum 10 characters)');
            $('#price_only_reason').focus();
            return false;
        }

        // Show loading
        $(this).find('button[type="submit"]').prop('disabled', true).html(
            '<i class="fas fa-spinner fa-spin"></i> Updating Price...'
        );
    });

    // Initialize price calculation for Price Edit Only tab
    calculatePriceOnly();
});

// Price calculation function for Price Edit Only tab
function calculatePriceOnly() {
    const basePrice = parseFloat($('#price_only_base_price').val()) || 0;
    const cgst = basePrice * 0.09;
    const sgst = basePrice * 0.09;
    const total = basePrice + cgst + sgst;

    // Update form field
    $('#price_only_total_price').val(total.toFixed(2));

    // Update display with proper formatting
    $('#price_only_calc_base').text('₹' + basePrice.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    $('#price_only_calc_cgst').text('₹' + cgst.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    $('#price_only_calc_sgst').text('₹' + sgst.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    $('#price_only_calc_total').text('₹' + total.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));

    // Add visual feedback for changes
    const originalPrice = {{ $reRequestedService->base_price }};
    const priceChange = basePrice - originalPrice;

    if (priceChange > 0) {
        $('#price_only_calc_total').removeClass('text-danger').addClass('text-success');
    } else if (priceChange < 0) {
        $('#price_only_calc_total').removeClass('text-success').addClass('text-danger');
    } else {
        $('#price_only_calc_total').removeClass('text-success text-danger');
    }
}
</script>
@endsection
