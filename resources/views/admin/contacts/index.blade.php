@extends('admin.layouts.layout')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" />
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
                <h1 class="page-title fw-medium fs-18 mb-2">Contact Form Submissions</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contact Form Submissions</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Filter Section - Modern Design -->
        <div class="card custom-card filter-card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="ri-filter-3-line me-2 text-primary"></i>
                    Filter Contact Submissions
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.contact-forms.index') }}" method="GET" id="searchForm">
                    <div class="row g-3">
                        <!-- Search Input -->
                        <div class="col-lg-4 col-md-6">
                            <label for="searchInput" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-search-line me-1"></i>Search
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-user-line text-muted"></i>
                                </span>
                                <input type="search" name="search" class="form-control border-start-0" 
                                       id="searchInput" placeholder="Search by name, email or message" value="{{ request('search') }}">
                            </div>
                        </div>
                        
                        <!-- Date Range -->
                        <div class="col-lg-4 col-md-6">
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
                        
                        <!-- Action Buttons -->
                        <div class="col-lg-4 col-md-12">
                            <label class="form-label fw-medium text-muted mb-2"><!-- spacer --></label>
                            <div class="d-flex gap-2 pt-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="ri-search-line me-1"></i>Search
                                </button>
                                <a href="{{ route('admin.contact-forms.index') }}" class="btn btn-outline-secondary px-4">
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
                    <i class="ri-file-excel-line me-1"></i> Export CSV
                </button>
                <button type="button" class="export-btn export-btn-pdf" onclick="exportData('pdf')">
                    <i class="ri-file-pdf-line me-1"></i> Export PDF
                </button>
            </div>
        </div>

        <!-- Add this hidden form for export -->
        <form id="export-form" method="GET" action="{{ route('admin.contact-forms.export') }}">
            <!-- Hidden inputs to carry over current filters -->
            <input type="hidden" name="search" id="export-search">
            <input type="hidden" name="start_date" id="export-start-date">
            <input type="hidden" name="end_date" id="export-end-date">
            <input type="hidden" name="type" id="export-type">
        </form>

        <!-- Start::row-2 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Contact Form Submissions ({{ $submissions->total() }})
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" style="width: 100%; min-width: 1000px;">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" 
                                               class="text-decoration-none text-dark">
                                                Name 
                                                @if(request('sort') === 'name')
                                                    <i class="ri-arrow-{{ request('direction') === 'asc' ? 'up' : 'down' }}-line"></i>
                                                @else
                                                    <i class="ri-expand-up-down-line"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" 
                                               class="text-decoration-none text-dark">
                                                Email 
                                                @if(request('sort') === 'email')
                                                    <i class="ri-arrow-{{ request('direction') === 'asc' ? 'up' : 'down' }}-line"></i>
                                                @else
                                                    <i class="ri-expand-up-down-line"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>Phone</th>
                                        <th>Message</th>
                                        <th>Verification Answer</th>
                                        <!--<th>-->
                                        <!--    <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" -->
                                        <!--       class="text-decoration-none text-dark">-->
                                        <!--        Submitted At -->
                                        <!--        @if(request('sort') === 'created_at')-->
                                        <!--            <i class="ri-arrow-{{ request('direction') === 'asc' ? 'up' : 'down' }}-line"></i>-->
                                        <!--        @else-->
                                        <!--            <i class="ri-expand-up-down-line"></i>-->
                                        <!--        @endif-->
                                        <!--    </a>-->
                                        <!--</th>-->
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($submissions as $key => $submission)
                                        <tr>
                                            <td>{{ $submissions->firstItem() + $key }}</td>
                                            <td>{{ $submission->name }}</td>
                                            <td>{{ $submission->email }}</td>
                                            <td>{{ $submission->phone ?? 'N/A' }}</td>
                                            <td>{{ Str::limit($submission->message, 50) }}</td>
                                            <td>{{ $submission->verification_answer ?? 'N/A' }}</td>
                                            <!--<td>{{ $submission->created_at->format('d M, Y H:i') }}</td>-->
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal{{ $submission->id }}">
                                                    View
                                                </button>
                                                <form action="{{ route('admin.contact-forms.destroy', $submission->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this submission?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- View Modal -->
                                        <div class="modal fade" id="viewModal{{ $submission->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $submission->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="viewModalLabel{{ $submission->id }}">Contact Form Submission Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Name:</strong> {{ $submission->name }}</p>
                                                        <p><strong>Email:</strong> {{ $submission->email }}</p>
                                                        <p><strong>Phone:</strong> {{ $submission->phone ?? 'N/A' }}</p>
                                                        <p><strong>Message:</strong> {{ $submission->message }}</p>
                                                        <p><strong>Verification Answer:</strong> {{ $submission->verification_answer ?? 'N/A' }}</p>
                                                        <!--<p><strong>Submitted At:</strong> {{ $submission->created_at->format('d M, Y H:i') }}</p>-->
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-3">No contact submissions found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $submissions->withQueryString()->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-2 -->
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle Enter key on search input
        $('input[name="search"]').keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();
                $('#searchForm').submit();
            }
        });
    });
    
    // Export data function
    window.exportData = function(type) {
        console.log('Export requested:', type);
        
        // Set the export type explicitly
        document.getElementById('export-type').value = type;
        
        // Set the values of the hidden inputs to current filter values
        document.getElementById('export-search').value = document.getElementById('searchInput').value || '';
        document.getElementById('export-start-date').value = document.querySelector('input[name="start_date"]')?.value || '';
        document.getElementById('export-end-date').value = document.querySelector('input[name="end_date"]')?.value || '';
        
        // Show a loading message (optional)
        if (typeof toastr !== 'undefined') {
            if (type === 'excel') {
                toastr.info('Preparing CSV export...');
            } else {
                toastr.info('Preparing PDF export...');
            }
        }
        
        // Debug what's being submitted
        console.log('Form action:', document.getElementById('export-form').action);
        console.log('Type value:', document.getElementById('export-type').value);
        
        // Submit the form
        document.getElementById('export-form').submit();
    }
</script>
@endsection