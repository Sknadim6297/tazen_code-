@extends('admin.layouts.layout')
@section('styles')
<style>
    .btn-export {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        border-radius: 8px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(40, 167, 69, 0.4);
        color: white;
    }
    
    .btn-pdf {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    }
    
    .btn-pdf:hover {
        box-shadow: 0 8px 15px rgba(220, 53, 69, 0.4);
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Download Reports</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Download Reports</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header Close -->

        
        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            <i class="ri-file-download-line me-2"></i>
                            Booking Summary Report
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-0">
                            Generate comprehensive reports including professional and customer billing details with GST calculations, platform commissions, and TCS computations.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End::row-1 -->

        <!-- Start::row-2 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            <i class="ri-filter-3-line me-2"></i>
                            Report Filters
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="reportForm">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-xl-3">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" class="form-control" name="start_date" id="start_date">
                                </div>
                                <div class="col-xl-3">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control" name="end_date" id="end_date">
                                </div>
                                <div class="col-xl-3">
                                    <label class="form-label">Professional</label>
                                    <select class="form-control" name="professional_id" id="professional_id">
                                        <option value="">All Professionals</option>
                                    </select>
                                </div>
                                <div class="col-xl-3">
                                    <label class="form-label">Plan Type</label>
                                    <select class="form-control" name="plan_type" id="plan_type">
                                        <option value="">All Plans</option>
                                        <option value="one_time">One Time</option>
                                        <option value="monthly">Monthly</option>
                                        <option value="quarterly">Quarterly</option>
                                        <option value="free_hand">Free Hand</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End::row-2 -->

        <!-- Start::row-3 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            <i class="ri-download-cloud-2-line me-2"></i>
                            Export Options
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <div class="d-grid">
                                    <button type="button" class="btn btn-export btn-lg btn-wave waves-light" id="exportExcel">
                                        <i class="ri-file-list-3-line me-2"></i>
                                        Download CSV Report
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-grid">
                                    <button type="button" class="btn btn-export btn-pdf btn-lg btn-wave waves-light" id="exportPdf">
                                        <i class="ri-file-pdf-2-line me-2"></i>
                                        Download PDF Report
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End::row-3 -->

        <!-- Start::row-4 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="alert alert-info" role="alert">
                    <h6 class="alert-heading fw-semibold">
                        <i class="ri-information-line me-2"></i>
                        Report Information
                    </h6>
                    <p class="mb-2">This report includes the following details for each booking:</p>
                    <ul class="mb-0">
                        <li><strong>Professional Details:</strong> Name and billing information</li>
                        <li><strong>Customer Billing:</strong> Invoice details with GST breakdown</li>
                        <li><strong>Platform Commission:</strong> Service charges with tax calculations</li>
                        <li><strong>TCS Calculation:</strong> Tax Collection at Source @1% on net supply</li>
                        <li><strong>Professional Payment:</strong> Final amount payable after deductions</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End::row-4 -->

    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load professionals for dropdown
    loadProfessionals();
    
    // Export CSV
    document.getElementById('exportExcel').addEventListener('click', function() {
        exportReport('excel');
    });
    
    // Export PDF
    document.getElementById('exportPdf').addEventListener('click', function() {
        exportReport('pdf');
    });
    
    function loadProfessionals() {
        fetch('{{ route("admin.reports.professionals") }}')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('professional_id');
                data.forEach(professional => {
                    const option = document.createElement('option');
                    option.value = professional.id;
                    option.textContent = professional.name;
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading professionals:', error);
            });
    }
    
    function exportReport(format) {
        const form = document.getElementById('reportForm');
        const formData = new FormData(form);
        
        // Show loading state
        const button = format === 'excel' ? 
            document.getElementById('exportExcel') : 
            document.getElementById('exportPdf');
        
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="ri-loader-4-line spinner-border spinner-border-sm me-2"></i>Generating...';
        button.disabled = true;
        
        // Create download URL
        const url = format === 'excel' ? 
            '{{ route("admin.reports.booking-summary.excel") }}' : 
            '{{ route("admin.reports.booking-summary.pdf") }}';
        
        // Convert FormData to URLSearchParams
        const params = new URLSearchParams();
        for (let [key, value] of formData.entries()) {
            if (value) {
                params.append(key, value);
            }
        }
        
        // Download file
        window.location.href = url + '?' + params.toString();
        
        // Reset button after delay
        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        }, 2000);
    }
    
    // Set default date range (last 30 days)
    const today = new Date();
    const thirtyDaysAgo = new Date(today.getTime() - (30 * 24 * 60 * 60 * 1000));
    
    document.getElementById('end_date').value = today.toISOString().split('T')[0];
    document.getElementById('start_date').value = thirtyDaysAgo.toISOString().split('T')[0];
});
</script>
@endsection
