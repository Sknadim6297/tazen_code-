@extends('admin.layouts.layout')

@section('styles')
<style>
    /* Export buttons styling */
    .export-buttons {
        display: flex;
        gap: 10px;
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

    .btn-success {
        background-color: #1f7244;
        color: white;
        border: none;
    }

    .btn-success:hover {
        background-color: #155a33;
    }

    .btn-danger {
        background-color: #c93a3a;
        color: white;
        border: none;
    }

    .btn-danger:hover {
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

    /* Answer Group Cards */
    .answer-group {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .answer-group:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .answer-group .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #dee2e6;
        padding: 1.25rem 1.5rem;
    }

    .answer-group .card-body {
        padding: 1.5rem;
        background: white;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-weight: 500;
    }

    .badge-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        color: white;
    }

    .badge-success {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
        color: white;
    }

    .badge-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
        color: white;
    }

    .badge-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    /* Table Styling */
    .table {
        margin-bottom: 0;
    }

    .table th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 600;
        border: none;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
    }

    .table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #f1f3f4;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
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

        .answer-group .card-header {
            padding: 1rem;
        }

        .answer-group .card-body {
            padding: 1rem;
        }
    }

    /* Custom Pagination Styling */
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
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">MCQ Answers Management</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">MCQ Answers</li>
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
                    Filter MCQ Answers
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.mcq-answers.index') }}" method="GET" id="filter-form">
                    <div class="row g-3">
                        <!-- Username Search -->
                        <div class="col-lg-3 col-md-6">
                            <label for="username" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-user-line me-1"></i>Username
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-search-line text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" id="username" name="username" 
                                       value="{{ request('username') }}" placeholder="Search by username">
                            </div>
                        </div>
                        
                        <!-- Service Filter -->
                        <div class="col-lg-3 col-md-6">
                            <label for="service" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-service-line me-1"></i>Service
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-settings-line text-muted"></i>
                                </span>
                                <select class="form-select border-start-0" id="service" name="service">
                                    <option value="">All Services</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ request('service') == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <!-- Date Range -->
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label fw-medium text-muted mb-2">
                                <i class="ri-calendar-line me-1"></i>Date Range
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-calendar-event-line text-muted"></i>
                                </span>
                                <input type="date" class="form-control border-start-0 border-end-0" 
                                       name="start_date" value="{{ request('start_date') }}" placeholder="Start Date">
                                <span class="input-group-text bg-light border-start-0 border-end-0 text-muted">to</span>
                                <input type="date" class="form-control border-start-0" 
                                       name="end_date" value="{{ request('end_date') }}" placeholder="End Date">
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="col-12">
                            <div class="d-flex gap-2 justify-content-end pt-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="ri-search-line me-1"></i>Apply Filters
                                </button>
                                <a href="{{ route('admin.mcq-answers.index') }}" class="btn btn-outline-secondary px-4">
                                    <i class="ri-refresh-line me-1"></i>Clear Filters
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Export Buttons -->
        <div class="d-flex justify-content-end mb-3">
            <div class="export-buttons" style="display: flex; gap: 10px;">
                <button type="button" class="btn btn-success export-btn" onclick="exportData('excel')">
                    <i class="ri-file-excel-line me-1"></i> Export Excel
                </button>
                <button type="button" class="btn btn-danger export-btn" onclick="exportData('pdf')">
                    <i class="ri-file-pdf-line me-1"></i> Export PDF
                </button>
            </div>
        </div>

        <!-- Hidden Export Form -->
        <form id="export-form" method="GET" action="{{ route('admin.mcq-answers.export') }}">
            <!-- Hidden inputs to carry over current filters -->
            <input type="hidden" name="username" id="export-username">
            <input type="hidden" name="service" id="export-service">
            <input type="hidden" name="start_date" id="export-start-date">
            <input type="hidden" name="end_date" id="export-end-date">
            <input type="hidden" name="type" id="export-type">
        </form>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filter Status Display -->
        @if(request('username') || request('service') || request('start_date') || request('end_date'))
        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
            <strong><i class="ri-filter-line me-1"></i>Active Filters:</strong>
            @if(request('username'))
                <span class="badge badge-primary me-2">Username: {{ request('username') }}</span>
            @endif
            @if(request('service'))
                @php
                    $selectedService = $services->find(request('service'));
                @endphp
                <span class="badge badge-info me-2">Service: {{ $selectedService ? $selectedService->name : 'Unknown' }}</span>
            @endif
            @if(request('start_date'))
                <span class="badge badge-secondary me-2">From: {{ request('start_date') }}</span>
            @endif
            @if(request('end_date'))
                <span class="badge badge-secondary me-2">To: {{ request('end_date') }}</span>
            @endif
            <a href="{{ route('admin.mcq-answers.index') }}" class="btn btn-sm btn-outline-danger ms-2">
                <i class="ri-close-line me-1"></i> Clear All
            </a>
        </div>
        @endif

        <!-- MCQ Answers Display -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="ri-question-answer-line me-2"></i>MCQ Answers
                </h5>
                <span class="badge badge-info">{{ $filteredRecords }} of {{ $totalRecords }} Records</span>
            </div>
            <div class="card-body">
                @if(count($groupedAnswers) > 0)
                    @foreach($groupedAnswers as $key => $group)
                    <div class="card answer-group">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <h6 class="mb-1 fw-semibold">
                                        <i class="ri-user-line text-primary me-1"></i>
                                        {{ $group['user']->name ?? 'N/A' }}
                                    </h6>
                                    <small class="text-muted">{{ $group['user']->email ?? '' }}</small>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="mb-1 fw-semibold">
                                        <i class="ri-service-line text-info me-1"></i>
                                        Service: <span class="badge badge-info">{{ $group['service']->name ?? 'N/A' }}</span>
                                    </h6>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="mb-1 fw-semibold">
                                        <i class="ri-user-star-line text-success me-1"></i>
                                        Professional: 
                                        @if($group['professional'] && $group['professional']->profile)
                                            <span class="badge badge-success">{{ $group['professional']->name }}</span>
                                            <br><small class="text-muted">{{ $group['professional']->profile->specialization ?? '' }}</small>
                                        @else
                                            <span class="badge badge-secondary">Not Assigned</span>
                                        @endif
                                    </h6>
                                </div>
                                <div class="col-md-3 text-end">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="downloadSingleGroupPDF('{{ $key }}', '{{ $group['user']->id }}', '{{ $group['service']->id }}', '{{ $group['created_at']->format('Y-m-d') }}')" title="Download this answer as PDF">
                                        <i class="ri-file-pdf-line me-1"></i>Download PDF
                                    </button>
                                </div>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="ri-time-line me-1"></i>
                                    Answered on: {{ $group['created_at']->format('M d, Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="mt-4">
                        <div class="d-flex justify-content-center">
                            {{ $mcqAnswers->withQueryString()->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="ri-emotion-sad-line fs-48 text-muted mb-3"></i>
                        <h5 class="text-muted">
                            @if(request('username') || request('service') || request('start_date') || request('end_date'))
                                No records found matching your current filters.
                            @else
                                No MCQ answers found in the system.
                            @endif
                        </h5>
                        @if(request('username') || request('service') || request('start_date') || request('end_date'))
                            <a href="{{ route('admin.mcq-answers.index') }}" class="btn btn-outline-primary mt-2">
                                <i class="ri-refresh-line me-1"></i>Clear Filters
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Handle Enter key on search inputs
        $('input[name="username"]').keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();
                $('#filter-form').submit();
            }
        });
    });
    
    // Export all data function
    window.exportData = function(type) {
        console.log('Export requested:', type);
        
        // Set the export type
        document.getElementById('export-type').value = type;
        
        // Set the values of the hidden inputs to current filter values
        document.getElementById('export-username').value = document.querySelector('input[name="username"]')?.value || '';
        document.getElementById('export-service').value = document.getElementById('service')?.value || '';
        document.getElementById('export-start-date').value = document.querySelector('input[name="start_date"]')?.value || '';
        document.getElementById('export-end-date').value = document.querySelector('input[name="end_date"]')?.value || '';
        
        // Show a loading message
        if (typeof toastr !== 'undefined') {
            toastr.info('Preparing ' + type.toUpperCase() + ' export...', 'Please Wait');
        }
        
        // Submit the form
        document.getElementById('export-form').submit();
        
        // Show success message after a delay
        setTimeout(function() {
            if (typeof toastr !== 'undefined') {
                toastr.success('Download started!', 'Success');
            }
        }, 1000);
    }
    
    // Download single group PDF
    window.downloadSingleGroupPDF = function(groupKey, userId, serviceId, date) {
        console.log('Downloading single group PDF:', groupKey);
        
        // Create a temporary form
        var form = document.createElement('form');
        form.method = 'GET';
        form.action = '{{ route("admin.mcq-answers.export") }}';
        form.target = '_blank';
        
        // Add hidden fields
        var fields = {
            'type': 'pdf',
            'username': '', // We'll filter by exact user
            'service': serviceId,
            'start_date': date,
            'end_date': date,
            'user_id': userId // Add user_id filter
        };
        
        for (var key in fields) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = fields[key];
            form.appendChild(input);
        }
        
        // Add form to body, submit, and remove
        document.body.appendChild(form);
        
        // Show loading message
        if (typeof toastr !== 'undefined') {
            toastr.info('Preparing PDF for this answer group...', 'Please Wait');
        }
        
        form.submit();
        
        // Show success message
        setTimeout(function() {
            if (typeof toastr !== 'undefined') {
                toastr.success('PDF download started!', 'Success');
            }
            document.body.removeChild(form);
        }, 1000);
    }
</script>
@endsection 