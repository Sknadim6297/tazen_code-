@extends('admin.layouts.layout')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Review Management</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Reviews</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Add Export Button -->
            <div>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-download-line me-1"></i> Export
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                        <li><a class="dropdown-item" href="javascript:void(0);" onclick="exportData('excel')">
                            <i class="ri-file-excel-2-line me-2 text-success"></i> Export to Excel
                        </a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);" onclick="exportData('pdf')">
                            <i class="ri-file-pdf-line me-2 text-danger"></i> Export to PDF
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- End Page Header -->

        <!-- Search Container -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.reviews.index') }}" method="GET" id="filter-form">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Date From</label>
                            <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date To</label>
                            <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Rating</label>
                            <select class="form-select" name="rating">
                                <option value="">All Ratings</option>
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Professional Name</label>
                            <input type="text" class="form-control" name="professional" value="{{ request('professional') }}" placeholder="Search by name">
                        </div>
                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                            <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Clear Filters</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Reviews Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer Name</th>
                                <th>Professional Name</th>
                                <th>Rating</th>
                                <th>Review</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reviews as $review)
                            <tr>
                                <td>{{ $review->id }}</td>
                                <td>{{ $review->user->name ?? 'N/A' }}</td>
                                <td>{{ $review->professional->name ?? 'N/A' }}</td>
                                <td>
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="ri-star-fill text-warning"></i>
                                        @else
                                            <i class="ri-star-fill text-muted"></i>
                                        @endif
                                    @endfor
                                </td>
                                <td>{{ Str::limit($review->review_text, 100) }}</td>
                                <td>{{ $review->created_at->format('d M Y') }}</td>
                                <td>
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No reviews found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $reviews->withQueryString()->links() }}
                </div>
            </div>
        </div>

        <!-- Add this hidden form for export -->
        <form id="export-form" method="GET" action="{{ route('admin.reviews.export') }}">
            <input type="hidden" name="start_date" id="export-start-date">
            <input type="hidden" name="end_date" id="export-end-date">
            <input type="hidden" name="rating" id="export-rating">
            <input type="hidden" name="professional" id="export-professional">
            <input type="hidden" name="type" id="export-type">
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // The Export Filtered Data button functionality has been replaced
    });
    
    // Export data function
    function exportData(type) {
        console.log('Export requested:', type);
        
        // Set the export type
        document.getElementById('export-type').value = type;
        
        // Set the values of the hidden inputs to current filter values
        document.getElementById('export-start-date').value = document.querySelector('input[name="start_date"]')?.value || '';
        document.getElementById('export-end-date').value = document.querySelector('input[name="end_date"]')?.value || '';
        document.getElementById('export-rating').value = document.querySelector('select[name="rating"]')?.value || '';
        document.getElementById('export-professional').value = document.querySelector('input[name="professional"]')?.value || '';
        
        // Submit the form
        document.getElementById('export-form').submit();
    }
</script>
@endsection