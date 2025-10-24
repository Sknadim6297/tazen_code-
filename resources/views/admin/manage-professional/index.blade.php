<!-- filepath: c:\xampp\htdocs\tazen_marge_code\Tazen_multi\resources\views\admin\manage-professional\index.blade.php -->
@extends('admin.layouts.layout')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" />
<style>
    .active-status-dropdown {
        min-width: 100px;
        font-size: 14px;
        padding: 4px 8px;
        cursor: pointer;
    }
    
    .active-status-dropdown option[value="1"] {
        color: #28a745;
        font-weight: 500;
    }
    
    .active-status-dropdown option[value="0"] {
        color: #dc3545;
        font-weight: 500;
    }
    
    /* For JS-disabled browsers */
    .status-toggle-form {
        margin: 0;
    }
    
    /* Toast styling overrides */
    .toast-success {
        background-color: #51a351;
    }
    
    .toast-error {
        background-color: #bd362f;
    }
  
    /* Toggle switch styles */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
        margin-bottom: 0;
    }

    .toggle-checkbox {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #dc3545; 
        transition: .4s;
        border-radius: 34px;
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        border-radius: 50%;
        transition: .4s;
    }

    input:checked + .toggle-slider {
        background-color: #28a745; 
    }

    input:checked + .toggle-slider:before {
        transform: translateX(26px);
    }
    .toggle-text {
        display: none;
    }

    .toggle-processing {
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .spinner {
        width: 20px;
        height: 20px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #3498db;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .margin-update-form {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        justify-content: center;
    }
    
    .margin-input-container {
        position: relative;
        width: 160px;
        height: 40px;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        transition: box-shadow 0.2s;
        border: 1px solid #ced4da;
    }
    
    .margin-input-container:focus-within {
        box-shadow: 0 3px 8px rgba(78, 115, 223, 0.15);
        border-color: #4e73df;
    }
    
    .margin-input-container .form-control {
        height: 40px;
        padding-right: 40px;
        font-size: 16px;
        font-weight: 500;
        border: none;
        border-radius: 0;
        text-align: center;
        color: #3a3b45;
    }
    
    .margin-input-container .input-group-text {
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        border: none;
        background-color: #f8f9fa;
        font-weight: 600;
        color: #5a5c69;
        border-left: 1px solid #ced4da;
        width: 40px;
        display: flex;
        justify-content: center;
        padding: 0;
    }
    
    .margin-save-btn {
        height: 40px;
        min-width: 80px;
        font-weight: 600;
        font-size: 14px;
        border-radius: 6px;
        background-color: #4e73df;
        border-color: #4e73df;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: all 0.2s;
    }
    
    .margin-save-btn:hover {
        background-color: #2e59d9;
        border-color: #2653d4;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .margin-save-btn:active {
        transform: translateY(0);
        box-shadow: 0 2px 3px rgba(0,0,0,0.1);
    }
    
    .margin-save-btn .spinner-border {
        width: 1rem;
        height: 1rem;
        margin-right: 5px;
    }
    
    /* Not Applicable styling */
    .not-applicable {
        color: #6c757d;
        font-style: italic;
        padding: 8px 12px;
        background-color: #f8f9fa;
        border-radius: 6px;
        display: inline-block;
    }

    /* Specialization badge styles */
    .specialization-badge {
        display: inline-block;
        padding: 4px 10px;
        font-size: 0.75rem;
        font-weight: 500;
        background-color: #e9f8f3;
        color: #198754;
        border-radius: 12px;
        border: 1px solid #d1e7dd;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 15px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .bg-primary {
        background-color: #4e73df !important;
    }

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
        padding: 6px 12px;
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

    /* Custom Pagination Styling (copied from Requested_professional) */
    .pagination {
        margin-bottom: 0;
    }
    .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
    }
    .page-link {
        color: #667eea;
        padding: 0.5rem 0.75rem;
        margin: 0 3px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    .page-link:hover {
        background-color: #f0f2ff;
        color: #5a6fd8;
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
    }
    .page-link:focus {
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    @media (max-width: 768px) {
        .pagination .page-link {
            padding: 0.4rem 0.6rem;
            font-size: 0.9rem;
        }
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">All Professionals</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Professional</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Professional</li>
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
                    Filter Professionals
                </h5>
            </div>
            <div class="card-body">
                <form id="filter-form" action="{{ route('admin.manage-professional.index') }}" method="GET">
                    <div class="row g-3">
                        <!-- Search Input -->
                        <div class="col-lg-3 col-md-6">
                            <label for="autoComplete" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-search-line me-1"></i>Search
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-user-line text-muted"></i>
                                </span>
                                <input type="search" name="search" class="form-control border-start-0" 
                                       id="autoComplete" placeholder="Name or email...">
                            </div>
                        </div>
                        
                        <!-- Specialization Filter -->
                        <div class="col-lg-3 col-md-6">
                            <label for="specializationFilter" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-award-line me-1"></i>Services
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-star-line text-muted"></i>
                                </span>
                                <select name="specialization" class="form-select border-start-0" id="specializationFilter">
                                    <option value="">All Services</option>
                                    @if(isset($specializations))
                                        @foreach($specializations as $specialization)
                                            <option value="{{ $specialization }}" {{ request('specialization') == $specialization ? 'selected' : '' }}>
                                                {{ $specialization }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        
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
                                       placeholder="Start Date" name="start_date" id="start_date">
                                <span class="input-group-text bg-light border-start-0 border-end-0 text-muted">to</span>
                                <input type="date" class="form-control border-start-0" 
                                       placeholder="End Date" name="end_date" id="end_date">
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="col-12">
                            <div class="d-flex gap-2 justify-content-end pt-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="ri-search-line me-1"></i>Search
                                </button>
                                <a href="{{ route('admin.manage-professional.index') }}" class="btn btn-outline-secondary px-4">
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
        <form id="export-form" method="GET" action="{{ route('admin.manage-professional.index') }}">
            <!-- Hidden inputs to carry over current filters -->
            <input type="hidden" name="search" id="export-search">
            <input type="hidden" name="specialization" id="export-specialization">
            <input type="hidden" name="start_date" id="export-start-date">
            <input type="hidden" name="end_date" id="export-end-date">
            <input type="hidden" name="export" id="export-type">
        </form>

        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Total Professionals
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th><input class="form-check-input check-all" type="checkbox" id="all-professionals" aria-label="..."></th>
                                        <th scope="col">Sl.No</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Send Email</th>
                                        <th scope="col">Service Offered</th>
                                        <th scope="col">Margin Percentage</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Active</th> 
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="professional-table-body">
                                    @foreach ($professionals as $professional)
                                        <tr class="professional-list">
                                            <td class="professional-checkbox">
                                                <input class="form-check-input" type="checkbox" value="{{ $professional->id }}" aria-label="...">
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $loop->iteration }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $professional->name }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $professional->email }}</span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info send-email-btn" 
                                                    data-email="{{ $professional->email }}" 
                                                    data-name="{{ $professional->name }}"
                                                    data-type="professional"
                                                    title="Send Email">
                                                    <i class="ri-mail-send-line"></i> Email
                                                </button>
                                            </td>
                                            <td>
                                                <!-- Specialization Column -->
                                                @if($professional->profile && $professional->profile->specialization)
                                                    <span class="specialization-badge">{{ $professional->profile->specialization }}</span>
                                                @else
                                                    <span class="text-muted">Not specified</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($professional->status === 'accepted')
                                                    <form action="{{ route('admin.updateMargin', $professional->id) }}" method="POST" class="margin-update-form">
                                                        @csrf
                                                        <div class="margin-input-container">
                                                            <input class="form-control" type="number" name="margin_percentage" 
                                                                value="{{ $professional->margin }}" min="0" max="100" required>
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary margin-save-btn">Save</button>
                                                    </form>
                                                @else
                                                    <span class="not-applicable">Not Applicable</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($professional->status == 'accepted')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($professional->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($professional->status == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form class="status-toggle-form" method="POST" action="{{ route('admin.professional.toggle-status') }}">
                                                    @csrf
                                                    <input type="hidden" name="professional_id" value="{{ $professional->id }}">
                                                    <input type="hidden" name="active_status" value="{{ $professional->active ? '0' : '1' }}">
                                                    
                                                    <label class="toggle-switch" data-id="{{ $professional->id }}" data-active="{{ $professional->active ? '1' : '0' }}">
                                                        <input type="checkbox" class="toggle-checkbox" {{ $professional->active ? 'checked' : '' }}>
                                                        <span class="toggle-slider">
                                                            <div class="toggle-processing">
                                                                <div class="spinner"></div>
                                                            </div>
                                                        </span>
                                                    </label>
                                                    
                                                    <noscript>
                                                        <div class="mt-2">
                                                            <span class="badge {{ $professional->active ? 'bg-success' : 'bg-danger' }} mb-2">
                                                                {{ $professional->active ? 'Active' : 'Inactive' }}
                                                            </span>
                                                            <button type="submit" class="btn btn-sm btn-primary d-block">
                                                                {{ $professional->active ? 'Deactivate' : 'Activate' }}
                                                            </button>
                                                        </div>
                                                    </noscript>
                                                </form>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $professional->created_at->format('d M, Y') }}</span>
                                            </td>
                                            <td class="">
                                                <a href="{{ route('admin.manage-professional.show', $professional->id) }}" class="btn btn-success-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-title="view">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('admin.manage-professional.edit', $professional->id) }}" class="btn btn-primary-light btn-icon btn-sm ms-1" data-bs-toggle="tooltip" data-bs-title="edit">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <button type="button" class="btn btn-info-light btn-icon btn-sm ms-1 chat-btn" 
                                                        data-participant-type="professional" 
                                                        data-participant-id="{{ $professional->id }}" 
                                                        data-bs-toggle="tooltip" 
                                                        data-bs-title="Chat">
                                                    <i class="ri-message-3-line"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer border-top-0">
                        <div class="d-flex justify-content-center">
                            {{ $professionals->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                        <div id="pagination-links" class="d-flex justify-content-center"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="emailModalLabel">
                    <i class="ri-mail-send-line me-2"></i>Send Email
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="emailForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipientName" class="form-label">Recipient Name</label>
                        <input type="text" class="form-control" id="recipientName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="recipientEmail" class="form-label">Recipient Email</label>
                        <input type="email" class="form-control" id="recipientEmail" name="recipient_email" readonly>
                    </div>
                    <input type="hidden" id="recipientType" name="recipient_type">
                    <div class="mb-3">
                        <label for="emailSubject" class="form-label">Subject <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="emailSubject" name="subject" required placeholder="Enter email subject">
                    </div>
                    <div class="mb-3">
                        <label for="emailMessage" class="form-label">Message <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="emailMessage" name="message" rows="8" required placeholder="Enter your message here..."></textarea>
                    </div>
                    <div class="alert alert-info">
                        <i class="ri-information-line me-2"></i>
                        <strong>Note:</strong> This email will be sent from the admin email address configured in your system.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ri-close-line me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="sendEmailBtn">
                        <i class="ri-send-plane-fill me-1"></i>Send Email
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    $(document).ready(function() {
        // Add submit handler for the FILTER form only (not email form)
        $('#filter-form').on('submit', function(e) {
            e.preventDefault();
            let searchTerm = $('#autoComplete').val();
            let specializationFilter = $('#specializationFilter').val();
            let startDate = $('#start_date').val();
            let endDate = $('#end_date').val();
            
            // Check if dates are valid
            if (startDate && endDate) {
                // Ensure end date is not before start date
                if (new Date(endDate) < new Date(startDate)) {
                    alert('End date cannot be before start date');
                    return false;
                }
            }
            
            filterData(startDate, endDate, searchTerm, specializationFilter);
        });

        // Individual filter change handlers for immediate filtering
        $('#autoComplete').on('keyup', function() {
            if($(this).val().length >= 3 || $(this).val().length === 0) {
                setTimeout(function() {
                    $('#filter-form').submit();
                }, 500);
            }
        });

        $('#specializationFilter').on('change', function() {
            $('#filter-form').submit();
        });

        $('#start_date, #end_date').on('change', function() {
            // Only trigger if both dates have values
            if($('#start_date').val() && $('#end_date').val()) {
                $('#filter-form').submit();
            }
        });

        // Function to fetch data based on filters
        function filterData(startDate = '', endDate = '', searchTerm = '', specializationFilter = '', page = 1) {
            // Show loading indicator
            $('#professional-table-body').html('<tr><td colspan="12" class="text-center"><i class="ri-loader-4-line fa-spin me-2"></i> Loading...</td></tr>');
            
            // Format dates to ensure they're in YYYY-MM-DD format for backend
            if (startDate) {
                // Add time component to start date to include the entire day
                startDate = startDate + ' 00:00:00';
            }
            
            if (endDate) {
                // Add time component to end date to include the entire day
                endDate = endDate + ' 23:59:59';
            }
            
            $.ajax({
                url: '{{ route('admin.manage-professional.index') }}',
                method: 'GET',
                data: {
                    search: searchTerm,
                    start_date: startDate,
                    end_date: endDate,
                    specialization: specializationFilter,
                    page: page
                },
                success: function(response) {
                    let professionalsHtml = '';
                    
                    if (response.professionals.data.length === 0) {
                        professionalsHtml = '<tr><td colspan="12" class="text-center">No professionals found matching your criteria</td></tr>';
                    } else {
                        $.each(response.professionals.data, function(index, professional) {
                            // Generate specialization HTML
                            let specializationHtml = '';
                            if (professional.profile && professional.profile.specialization) {
                                specializationHtml = `<span class="specialization-badge">${professional.profile.specialization}</span>`;
                            } else {
                                specializationHtml = '<span class="text-muted">Not specified</span>';
                            }

                            // Generate margin HTML
                            const marginHtml = professional.status === 'accepted' ? 
                                `<form action="/admin/professional/${professional.id}/margin" method="POST" class="margin-update-form">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="margin-input-container">
                                        <input class="form-control" type="number" name="margin_percentage" 
                                            value="${professional.margin || 0}" min="0" max="100" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                    <button type="submit" class="btn btn-primary margin-save-btn">Save</button>
                                </form>` : 
                                '<span class="not-applicable">Not Applicable</span>';

                            // Generate status badge
                            const statusBadge = professional.status === 'accepted' ? 
                                '<span class="badge bg-success">Approved</span>' : 
                                professional.status === 'pending' ? 
                                '<span class="badge bg-warning">Pending</span>' : 
                                '<span class="badge bg-danger">Rejected</span>';

                            // Generate toggle switch HTML
                            const toggleSwitchHtml = `
                                <form class="status-toggle-form" method="POST" action="{{ route('admin.professional.toggle-status') }}">
                                    @csrf
                                    <input type="hidden" name="professional_id" value="${professional.id}">
                                    <input type="hidden" name="active_status" value="${professional.active ? '0' : '1'}">
                                    
                                    <label class="toggle-switch" data-id="${professional.id}" data-active="${professional.active ? '1' : '0'}">
                                        <input type="checkbox" class="toggle-checkbox" ${professional.active ? 'checked' : ''}>
                                        <span class="toggle-slider">
                                            <div class="toggle-processing">
                                                <div class="spinner"></div>
                                            </div>
                                        </span>
                                    </label>
                                </form>
                            `;
                            // Build the row
                            professionalsHtml += `
                                <tr class="professional-list">
                                    <td class="professional-checkbox">
                                        <input class="form-check-input" type="checkbox" value="${professional.id}" aria-label="...">
                                    </td>
                                    <td><span class="fw-medium">${index + 1}</span></td>
                                    <td><span class="fw-medium">${professional.name}</span></td>
                                    <td><span class="fw-medium">${professional.email}</span></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info send-email-btn" 
                                            data-email="${professional.email}" 
                                            data-name="${professional.name}"
                                            data-type="professional"
                                            title="Send Email">
                                            <i class="ri-mail-send-line"></i> Email
                                        </button>
                                    </td>
                                    <td>${specializationHtml}</td>
                                    <td style="display: flex; justify-content: center; align-items: center;">${marginHtml}</td>
                                    <td>${statusBadge}</td>
                                    <td>${toggleSwitchHtml}</td>
                                    <td><span class="fw-medium">${formatDate(professional.created_at)}</span></td>
                                    <td>
                                        <a href="/admin/manage-professional/${professional.id}" class="btn btn-success-light btn-icon btn-sm">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                        <a href="/admin/manage-professional/${professional.id}/edit" class="btn btn-primary-light btn-icon btn-sm ms-1">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        <button type="button" class="btn btn-info-light btn-icon btn-sm ms-1 chat-btn" 
                                                data-participant-type="professional" 
                                                data-participant-id="${professional.id}" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-title="Chat">
                                            <i class="ri-message-3-line"></i>
                                        </button>
                                    </td>
                                </tr>`;
                        });
                    }
                    
                    $('#professional-table-body').html(professionalsHtml);
                    // Update pagination links and center them
                    $('#pagination-links').html(response.pagination).addClass('d-flex justify-content-center');
                },
                error: function() {
                    $('#professional-table-body').html('<tr><td colspan="11" class="text-center text-danger">Error loading data. Please try again.</td></tr>');
                }
            });
        }

        // Setup CSRF protection for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Handle active status change
        $(document).on('change', '.active-status-dropdown', function() {
            const dropdown = $(this);
            const professionalId = dropdown.data('id');
            const newValue = dropdown.val();
            const statusText = newValue == 1 ? 'activate' : 'deactivate';
            
            // Confirm before changing
            if (confirm(`Are you sure you want to ${statusText} this professional?`)) {
                // Store original selected value in case we need to revert
                const originalValue = newValue == 1 ? 0 : 1;
                
                // Disable dropdown during processing
                dropdown.prop('disabled', true);
                
                // Send AJAX request with explicitly defined data
                $.ajax({
                    url: "{{ route('admin.professional.toggle-status') }}",
                    type: 'POST',
                    data: {
                        professional_id: professionalId,
                        active_status: newValue,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show success message using toastr
                            toastr.success(response.message);
                        } else {
                            // Revert to original value and show error
                            dropdown.val(originalValue);
                            toastr.error(response.message || 'Failed to update status');
                        }
                    },
                    error: function(xhr) {
                        // Revert to original value on error
                        dropdown.val(originalValue);
                        
                        console.error("Error response:", xhr.responseText);
                        
                        // Show error message
                        let errorMsg = 'An error occurred while updating status';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        toastr.error(errorMsg);
                    },
                    complete: function() {
                        // Re-enable dropdown
                        dropdown.prop('disabled', false);
                    }
                });
            } else {
                // If user cancels, revert the dropdown to its original value
                dropdown.val(originalValue == 1 ? 1 : 0);
            }
        });

        // Handle toggle switch click
        $(document).on('change', '.toggle-checkbox', function() {
            const checkbox = $(this);
            const toggleSwitch = checkbox.closest('.toggle-switch');
            const professionalId = toggleSwitch.data('id');
            const isCurrentlyActive = toggleSwitch.data('active') == '1';
            const willBeActive = checkbox.prop('checked');
            
            // Revert the checkbox state until confirmed
            checkbox.prop('checked', isCurrentlyActive);
            
            // Confirm before changing
            const statusText = isCurrentlyActive ? 'deactivate' : 'activate';
            if (confirm(`Are you sure you want to ${statusText} this professional?`)) {
                // Show processing state
                const processingOverlay = toggleSwitch.find('.toggle-processing');
                processingOverlay.show();
                
                // Disable the checkbox during processing
                checkbox.prop('disabled', true);
                
                // Send AJAX request
                $.ajax({
                    url: "{{ route('admin.professional.toggle-status') }}",
                    type: 'POST',
                    data: {
                        professional_id: professionalId,
                        active_status: isCurrentlyActive ? '0' : '1',
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update checkbox and data attribute
                            checkbox.prop('checked', !isCurrentlyActive);
                            toggleSwitch.data('active', isCurrentlyActive ? '0' : '1');
                            
                            // Update hidden form field for JS-disabled fallback
                            toggleSwitch.closest('form').find('input[name="active_status"]').val(isCurrentlyActive ? '0' : '1');
                            
                            // Show success message
                            toastr.success(response.message);
                        } else {
                            // Show error message
                            toastr.error(response.message || 'Failed to update status');
                        }
                    },
                    error: function(xhr) {
                        // Show error message
                        let errorMsg = 'An error occurred while updating status';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        toastr.error(errorMsg);
                        console.error("Error response:", xhr.responseText);
                    },
                    complete: function() {
                        // Hide processing overlay
                        processingOverlay.hide();
                        
                        // Re-enable checkbox
                        checkbox.prop('disabled', false);
                    }
                });
            }
        });

        // Handle margin percentage form submission via AJAX
        $(document).on('submit', '.margin-update-form', function(e) {
            e.preventDefault();
            const form = $(this);
            const submitButton = form.find('button[type="submit"]');
            const marginInput = form.find('input[name="margin_percentage"]');
            const marginValue = marginInput.val();
            
            // Disable button and show loading state
            submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Saving...');
            
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response, textStatus, xhr) {
                    // Check if we got a redirect (302)
                    if (xhr.status === 200 && response.success === true) {
                        toastr.success(response.message || 'Margin updated successfully');
                        // Show success message before reload
                        setTimeout(function() {
                            window.location.reload(); // Reload the page after a short delay
                        }, 1000); // 1 second delay to show the toast message
                    } else {
                        // Even if we get redirected but the database was updated, show success
                        toastr.success('Margin updated successfully');
                        setTimeout(function() {
                            window.location.reload(); // Reload to reflect changes
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    console.error("Error response:", xhr.responseText);
                    
                    // Special handling for redirects that might indicate success
                    if (xhr.status === 302) {
                        toastr.success('Margin updated successfully');
                        setTimeout(function() {
                            window.location.reload(); // Reload to reflect changes
                        }, 1000);
                        return;
                    }
                    
                    let errorMsg = 'Failed to update margin';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    toastr.error(errorMsg);
                    
                    // Restore button state in case of error
                    submitButton.prop('disabled', false).text('Save');
                },
                complete: function() {
                    // We don't restore the button here since we're reloading the page
                    // The button will be restored when the page reloads
                }
            });
        });

        // Helper function to format dates
        function formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            return `${date.getDate()} ${months[date.getMonth()]}, ${date.getFullYear()}`;
        }

        // Export data function
        window.exportData = function(type) {
            // Set the export type
            document.getElementById('export-type').value = type;
            
            // Set the values of the hidden inputs to current filter values
            document.getElementById('export-search').value = document.getElementById('autoComplete').value;
            document.getElementById('export-specialization').value = document.getElementById('specializationFilter').value;
            document.getElementById('export-start-date').value = document.getElementById('start_date').value;
            document.getElementById('export-end-date').value = document.getElementById('end_date').value;
            
            // Show a loading message (optional)
            toastr.info('Preparing ' + type.toUpperCase() + ' export...');
            
            // Submit the form
            document.getElementById('export-form').submit();
        }

        // Handle AJAX pagination link clicks
        $(document).on('click', '#pagination-links .pagination a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var page = 1;
            var match = url.match(/page=(\d+)/);
            if (match) {
                page = match[1];
            }
            let searchTerm = $('#autoComplete').val();
            let specializationFilter = $('#specializationFilter').val();
            let startDate = $('#start_date').val();
            let endDate = $('#end_date').val();
            filterData(startDate, endDate, searchTerm, specializationFilter, page);
        });

        // Handle Send Email button click
        $(document).on('click', '.send-email-btn', function() {
            const email = $(this).data('email');
            const name = $(this).data('name');
            const type = $(this).data('type');
            
            // Populate modal fields
            $('#recipientName').val(name);
            $('#recipientEmail').val(email);
            $('#recipientType').val(type);
            
            // Clear previous form data
            $('#emailSubject').val('');
            $('#emailMessage').val('');
            
            // Show modal
            $('#emailModal').modal('show');
        });

        // Handle Email Form Submission
        $('#emailForm').on('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = $('#sendEmailBtn');
            const originalBtnText = submitBtn.html();
            
            // Get form data
            const formData = {
                recipient_email: $('#recipientEmail').val(),
                recipient_type: $('#recipientType').val(),
                subject: $('#emailSubject').val(),
                message: $('#emailMessage').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };
            
            // Disable button and show loading state
            submitBtn.prop('disabled', true).html('<i class="ri-loader-4-line fa-spin me-1"></i>Sending...');
            
            $.ajax({
                url: '{{ route("admin.send-email") }}',
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message || 'Email sent successfully!');
                        $('#emailModal').modal('hide');
                        $('#emailForm')[0].reset();
                    } else {
                        toastr.error(response.message || 'Failed to send email.');
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Failed to send email. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        errorMsg = Object.values(errors).flat().join(', ');
                    }
                    toastr.error(errorMsg);
                },
                complete: function() {
                    // Restore button state
                    submitBtn.prop('disabled', false).html(originalBtnText);
                }
            });
        });
    });
</script>
@endsection