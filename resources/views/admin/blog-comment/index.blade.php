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

    .badge.highlighted {
        font-size: 0.85rem;
        padding: 0.4rem 0.6rem;
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
                <h1 class="page-title fw-medium fs-18 mb-2">Blog Comments</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Comments</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Comments</li>
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
                    Filter Blog Comments
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.comments.index') }}" method="GET" id="searchForm">
                    <div class="row g-3">
                        <!-- Status Filter -->
                        <div class="col-lg-3 col-md-6">
                            <label for="statusFilter" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-check-line me-1"></i>Status
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-shield-check-line text-muted"></i>
                                </span>
                                <select name="status" class="form-select border-start-0" id="statusFilter">
                                    <option value="">All Status</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Blog Post Filter -->
                        <div class="col-lg-3 col-md-6">
                            <label for="blogFilter" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-article-line me-1"></i>Blog Post
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-book-open-line text-muted"></i>
                                </span>
                                <select name="blog_post" class="form-select border-start-0" id="blogFilter">
                                    <option value="">All Blog Posts</option>
                                    @if(isset($blogPosts))
                                        @foreach($blogPosts as $post)
                                            <option value="{{ $post->id }}" {{ request('blog_post') == $post->id ? 'selected' : '' }}>
                                                {{ Str::limit($post->blog->title, 50) }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        
                        <!-- Search Input -->
                        <div class="col-lg-3 col-md-6">
                            <label for="searchInput" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-search-line me-1"></i>Search
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-user-line text-muted"></i>
                                </span>
                                <input type="search" name="search" class="form-control border-start-0" 
                                       id="searchInput" placeholder="Search by name, email or comment" value="{{ request('search') }}">
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
                                       placeholder="Start Date" name="start_date" value="{{ request('start_date') }}">
                                <span class="input-group-text bg-light border-start-0 border-end-0 text-muted">to</span>
                                <input type="date" class="form-control border-start-0" 
                                       placeholder="End Date" name="end_date" value="{{ request('end_date') }}">
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="col-12">
                            <div class="d-flex gap-2 justify-content-end pt-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="ri-search-line me-1"></i>Search
                                </button>
                                <a href="{{ route('admin.comments.index') }}" class="btn btn-outline-secondary px-4">
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
        <form id="export-form" method="GET" action="{{ route('admin.comments.export') }}">
            <!-- Hidden inputs to carry over current filters -->
            <input type="hidden" name="search" id="export-search">
            <input type="hidden" name="status" id="export-status">
            <input type="hidden" name="blog_post" id="export-blog-post">
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
                            Blog Comments ({{ $comments->total() }})
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" style="width: 100%; min-width: 1200px;">
                                <thead>
                                    <tr>
                                        <th>
                                            <input class="form-check-input check-all" type="checkbox" id="all-tasks" value="" aria-label="...">
                                        </th>
                                        <th scope="col">Sl.No</th>
                                        <th scope="col">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'blog_post', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" 
                                               class="text-decoration-none text-dark">
                                                Blog Post 
                                                @if(request('sort') === 'blog_post')
                                                    <i class="ri-arrow-{{ request('direction') === 'asc' ? 'up' : 'down' }}-line"></i>
                                                @else
                                                    <i class="ri-expand-up-down-line"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" 
                                               class="text-decoration-none text-dark">
                                                Commenter 
                                                @if(request('sort') === 'name')
                                                    <i class="ri-arrow-{{ request('direction') === 'asc' ? 'up' : 'down' }}-line"></i>
                                                @else
                                                    <i class="ri-expand-up-down-line"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Comment</th>
                                        <th scope="col">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" 
                                               class="text-decoration-none text-dark">
                                                Date 
                                                @if(request('sort') === 'created_at')
                                                    <i class="ri-arrow-{{ request('direction') === 'asc' ? 'up' : 'down' }}-line"></i>
                                                @else
                                                    <i class="ri-expand-up-down-line"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'is_approved', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" 
                                               class="text-decoration-none text-dark">
                                                Status 
                                                @if(request('sort') === 'is_approved')
                                                    <i class="ri-arrow-{{ request('direction') === 'asc' ? 'up' : 'down' }}-line"></i>
                                                @else
                                                    <i class="ri-expand-up-down-line"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($comments as $index => $comment)
                                        <tr class="task-list">
                                            <td class="task-checkbox">
                                                <input class="form-check-input" type="checkbox" value="" aria-label="...">
                                            </td>
                                            <td>{{ $comments->firstItem() + $index }}</td>
                                            <td>
                                                <span class="fw-medium">{{ $comment->blogPost->blog->title ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $comment->name }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $comment->email }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $comment->mobile ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ Str::limit($comment->comment, 50) }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $comment->created_at->format('d M Y') }}</span>
                                            </td>
                                            <td>
                                                @if($comment->is_approved)
                                                    <span class="badge bg-success highlighted">Approved</span>
                                                @else
                                                    <span class="badge bg-warning highlighted">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-info-light btn-icon btn-sm" data-bs-toggle="modal" data-bs-target="#viewComment{{ $comment->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                    <i class="ri-eye-line"></i>
                                                </button>
                                                @if(!$comment->is_approved)
                                                    <form action="{{ route('admin.comments.approve', $comment->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approve">
                                                            <i class="ri-check-line"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger-light btn-icon ms-1 btn-sm task-delete-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                        <i class="ri-delete-bin-5-line"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- View Comment Modal -->
                                        <div class="modal fade" id="viewComment{{ $comment->id }}" tabindex="-1" aria-labelledby="viewCommentLabel{{ $comment->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="viewCommentLabel{{ $comment->id }}">Comment Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <h6>Blog Post:</h6>
                                                            <p>{{ $comment->blogPost->blog->title ?? 'N/A' }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6>Commenter:</h6>
                                                            <p>{{ $comment->name }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6>Email:</h6>
                                                            <p>{{ $comment->email }}</p>
                                                        </div>
                                                        @if($comment->website)
                                                        <div class="mb-3">
                                                            <h6>Website:</h6>
                                                            <p><a href="{{ $comment->website }}" target="_blank">{{ $comment->website }}</a></p>
                                                        </div>
                                                        @endif
                                                        <div class="mb-3">
                                                            <h6>Comment:</h6>
                                                            <p>{{ $comment->comment }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6>Date:</h6>
                                                            <p>{{ $comment->created_at->format('d M Y') }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6>Status:</h6>
                                                            <p>
                                                                @if($comment->is_approved)
                                                                    <span class="badge bg-success highlighted">Approved</span>
                                                                @else
                                                                    <span class="badge bg-warning highlighted">Pending</span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-3">No comments found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $comments->withQueryString()->links('pagination::bootstrap-4') }}
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
        document.getElementById('export-status').value = document.getElementById('statusFilter').value || '';
        document.getElementById('export-blog-post').value = document.getElementById('blogFilter').value || '';
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