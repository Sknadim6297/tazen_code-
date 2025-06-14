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
                <a href="{{ route('admin.reviews.export', request()->all()) }}" class="btn btn-primary">
                    <i class="fas fa-file-pdf me-1"></i> Export to PDF
                </a>
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
                            <button type="button" class="btn btn-success" id="exportFilteredBtn">
                                <i class="fas fa-file-pdf me-1"></i> Export Filtered Data
                            </button>
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
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Export filtered data button
        $('#exportFilteredBtn').click(function() {
            var formData = $('#filter-form').serialize();
            window.location.href = "{{ route('admin.reviews.export') }}?" + formData;
        });
    });
</script>
@endsection