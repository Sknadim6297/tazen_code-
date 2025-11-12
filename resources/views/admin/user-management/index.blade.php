@extends('admin.layouts.layout')

@section('title', 'User Management')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-flex align-items-center justify-content-between page-header-breadcrumb flex-wrap gap-2">
    <div>
        <nav>
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">User Management</li>
            </ol>
        </nav>
        <p class="mb-0 text-muted">Manage user registrations and accounts</p>
    </div>
    <div class="btn-list">
        <button class="btn btn-primary" id="exportPdfBtn">
            <i class="ri-file-pdf-line me-1"></i> Export PDF
        </button>
        <button class="btn btn-success" id="exportExcelBtn">
            <i class="ri-file-excel-line me-1"></i> Export Excel
        </button>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <!-- First Row - Main Stats -->
    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12">
        <div class="card custom-card stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <span class="avatar avatar-lg bg-primary-gradient">
                            <i class="ri-user-line fs-18"></i>
                        </span>
                    </div>
                    <div class="flex-fill">
                        <div class="fw-semibold fs-15">Total Users</div>
                        <div class="text-muted fs-13">All registered users</div>
                    </div>
                    <div class="text-end">
                        <div class="fs-20 fw-bold text-primary">{{ number_format($stats['total_users']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12">
        <div class="card custom-card stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <span class="avatar avatar-lg bg-success-gradient">
                            <i class="ri-checkbox-circle-line fs-18"></i>
                        </span>
                    </div>
                    <div class="flex-fill">
                        <div class="fw-semibold fs-15">Completed</div>
                        <div class="text-muted fs-13">Full registration</div>
                    </div>
                    <div class="text-end">
                        <div class="fs-20 fw-bold text-success">{{ number_format($stats['completed_registrations']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12">
        <div class="card custom-card stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <span class="avatar avatar-lg bg-warning-gradient">
                            <i class="ri-time-line fs-18"></i>
                        </span>
                    </div>
                    <div class="flex-fill">
                        <div class="fw-semibold fs-15">Incomplete</div>
                        <div class="text-muted fs-13">Pending setup</div>
                    </div>
                    <div class="text-end">
                        <div class="fs-20 fw-bold text-warning">{{ number_format($stats['incomplete_registrations']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xxl-3 col-xl-12 col-lg-6 col-md-6 col-sm-12">
        <div class="row g-3">
            <!-- Email Statistics in smaller cards -->
            <div class="col-lg-6 col-md-12">
                <div class="card custom-card stats-card-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <span class="avatar avatar-sm bg-info-gradient">
                                    <i class="ri-mail-check-line fs-14"></i>
                                </span>
                            </div>
                            <div class="flex-fill">
                                <div class="fw-semibold fs-13">Email Verified</div>
                                <div class="fs-16 fw-bold text-info">{{ number_format($stats['email_verified']) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card custom-card stats-card-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <span class="avatar avatar-sm bg-danger-gradient">
                                    <i class="ri-mail-close-line fs-14"></i>
                                </span>
                            </div>
                            <div class="flex-fill">
                                <div class="fw-semibold fs-13">Email Pending</div>
                                <div class="fs-16 fw-bold text-danger">{{ number_format($stats['email_not_verified']) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card custom-card">
    <div class="card-header">
        <div class="card-title">Filter Users</div>
    </div>
    <div class="card-body">
        <form id="filterForm" method="GET">
            <div class="row g-3">
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <label class="form-label">Registration Status</label>
                    <select class="form-control" name="registration_status" id="registration_status">
                        <option value="">All Status</option>
                        <option value="completed" {{ request('registration_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="incomplete" {{ request('registration_status') == 'incomplete' ? 'selected' : '' }}>Incomplete</option>
                        <option value="email_verified" {{ request('registration_status') == 'email_verified' ? 'selected' : '' }}>Email Verified</option>
                        <option value="email_not_verified" {{ request('registration_status') == 'email_not_verified' ? 'selected' : '' }}>Email Not Verified</option>
                    </select>
                </div>
                <div class="col-xl-2 col-lg-4 col-md-6">
                    <label class="form-label">From Date</label>
                    <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
                </div>
                <div class="col-xl-2 col-lg-4 col-md-6">
                    <label class="form-label">To Date</label>
                    <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <label class="form-label">Search</label>
                    <input type="text" class="form-control" name="search" placeholder="Name, Email, Phone..." value="{{ request('search') }}" id="search">
                </div>
                <div class="col-xl-2 col-lg-6 col-md-6">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-search-line me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card custom-card">
    <div class="card-header">
        <div class="card-title">
            Users List
            @if(request()->hasAny(['registration_status', 'search', 'date_from', 'date_to']))
                <span class="badge bg-primary ms-2">Filtered</span>
            @endif
        </div>
    </div>
    <div class="card-body p-0">
        <!-- Desktop Table -->
        <div class="table-responsive d-none d-lg-block">
            <table class="table text-nowrap table-hover">
                <thead>
                    <tr>
                        <th scope="col">User Info</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Registration Status</th>
                        <th scope="col">Email Status</th>
                        <th scope="col">Registration Date</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    @include('admin.user-management.table')
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="d-lg-none" id="mobileCards">
            @include('admin.user-management.mobile-cards')
        </div>
    </div>
    
    <!-- Pagination -->
    @if($users->total() > 0)
    <div class="card-footer border-top-0">
        @if($users->hasPages())
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="dataTables_info">
                <span class="text-muted fs-13">
                    Showing <strong>{{ $users->firstItem() ?? 0 }}</strong> to <strong>{{ $users->lastItem() ?? 0 }}</strong> 
                    of <strong>{{ $users->total() }}</strong> entries
                </span>
            </div>
            <div class="dataTables_paginate" id="paginationContainer">
                @if(view()->exists('pagination.custom-pagination'))
                    {{ $users->appends(request()->all())->links('pagination.custom-pagination') }}
                @else
                    {{ $users->appends(request()->all())->links() }}
                @endif
            </div>
        </div>
        @else
        <div class="d-flex justify-content-center align-items-center">
            <span class="text-muted fs-13">
                Showing all <strong>{{ $users->total() }}</strong> entries
            </span>
        </div>
        @endif
    </div>
    @endif
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
$(document).ready(function() {
    // Export PDF
    $('#exportPdfBtn').on('click', function() {
        const params = new URLSearchParams();
        const registration_status = $('#registration_status').val();
        const search = $('[name="search"]').val();
        const date_from = $('[name="date_from"]').val();
        const date_to = $('[name="date_to"]').val();
        
        if (registration_status) params.append('registration_status', registration_status);
        if (search) params.append('search', search);
        if (date_from) params.append('date_from', date_from);
        if (date_to) params.append('date_to', date_to);
        
        window.location.href = '{{ route("admin.user-management.export.pdf") }}?' + params.toString();
    });

    // Export Excel
    $('#exportExcelBtn').on('click', function() {
        const params = new URLSearchParams();
        const registration_status = $('#registration_status').val();
        const search = $('[name="search"]').val();
        const date_from = $('[name="date_from"]').val();
        const date_to = $('[name="date_to"]').val();
        
        if (registration_status) params.append('registration_status', registration_status);
        if (search) params.append('search', search);
        if (date_from) params.append('date_from', date_from);
        if (date_to) params.append('date_to', date_to);
        
        window.location.href = '{{ route("admin.user-management.export.excel") }}?' + params.toString();
    });

    // Auto-submit filters
    $('#registration_status, [name="date_from"], [name="date_to"]').on('change', function() {
        $('#filterForm').submit();
    });

    // Search with delay
    let searchTimeout;
    $('#search').on('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            $('#filterForm').submit();
        }, 500);
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Handle pagination clicks
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        
        if (url) {
            window.location.href = url;
        }
    });
});

// View user details
function viewUser(userId) {
    toastr.info('User details view functionality can be implemented here');
    // You can implement a modal or redirect to a detailed view page
    // window.location.href = `/admin/user-management/${userId}`;
}

// Delete user
function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        $.ajax({
            url: `/admin/user-management/${userId}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    location.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('Failed to delete user');
            }
        });
    }
}
</script>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<style>
/* Statistics Cards Styling */
.stats-card {
    border-radius: 12px;
    border: none;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.stats-card-sm {
    border-radius: 10px;
    border: none;
    transition: all 0.3s ease;
    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.06);
}

.stats-card-sm:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.12);
}

/* Gradient Backgrounds */
.bg-primary-gradient {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
}

.bg-success-gradient {
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
}

.bg-warning-gradient {
    background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
}

.bg-info-gradient {
    background: linear-gradient(135deg, #06b6d4 0%, #67e8f9 100%);
}

.bg-danger-gradient {
    background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
}

/* Table and Layout Improvements */
.badge {
    font-size: 0.75em;
    padding: 0.35em 0.65em;
    border-radius: 6px;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
    margin-right: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.mobile-card {
    border: 1px solid #dee2e6;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 12px;
    background: white;
    transition: all 0.3s ease;
}

.mobile-card:hover {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transform: translateY(-1px);
}

.status-badge {
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
}

.action-buttons .btn {
    padding: 6px 12px;
    font-size: 13px;
    margin-right: 6px;
    margin-bottom: 4px;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.action-buttons .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

/* Pagination Styling */
.dataTables_info {
    padding: 8px 0;
    flex-shrink: 0;
}

.dataTables_paginate {
    padding: 8px 0;
    flex-shrink: 0;
}

.dataTables_paginate .pagination {
    margin: 0;
    justify-content: flex-end;
}

.dataTables_paginate .page-link {
    border-radius: 6px;
    margin: 0 2px;
    padding: 6px 10px;
    font-size: 13px;
    border: 1px solid #dee2e6;
    color: #6c757d;
    transition: all 0.2s ease;
    text-decoration: none;
}

.dataTables_paginate .page-link:hover {
    background-color: #6366f1;
    border-color: #6366f1;
    color: white;
    transform: translateY(-1px);
    text-decoration: none;
}

.dataTables_paginate .page-item.active .page-link {
    background-color: #6366f1;
    border-color: #6366f1;
    color: white;
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
}

.dataTables_paginate .page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
}

/* Fix for pagination breaking */
.card-footer {
    padding: 1rem 1.5rem;
    background-color: rgba(248, 249, 250, 0.8);
    border-top: 1px solid #dee2e6;
}

.card-footer .d-flex {
    min-height: 40px;
    align-items: center;
}

/* Card Header Improvements */
.card-header {
    border-bottom: 1px solid #e9ecef;
    padding: 1.25rem 1.5rem;
    background: rgba(248, 249, 250, 0.8);
    border-radius: 12px 12px 0 0;
}

.card-title {
    font-weight: 600;
    font-size: 1.1rem;
    color: #495057;
    margin: 0;
}

/* Table Improvements */
.table-responsive {
    border-radius: 0 0 12px 12px;
    overflow: hidden;
}

.table th {
    font-weight: 600;
    color: #495057;
    border-top: none;
    padding: 1rem 0.75rem;
    background-color: rgba(248, 249, 250, 0.8);
}

.table td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border-top: 1px solid #e9ecef;
}

.table-hover tbody tr:hover {
    background-color: rgba(99, 102, 241, 0.05);
}

/* Responsive Improvements */
@media (max-width: 768px) {
    .btn-list {
        flex-direction: column;
        gap: 8px;
    }
    
    .btn-list .btn {
        width: 100%;
    }
    
    .stats-card .card-body {
        padding: 1rem;
    }
    
    .dataTables_info,
    .dataTables_paginate {
        text-align: center;
        margin-bottom: 0.5rem;
        flex: 1;
    }
    
    .card-footer .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .dataTables_paginate .pagination {
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .dataTables_paginate .page-link {
        padding: 4px 8px;
        font-size: 12px;
        margin: 1px;
    }
}

@media (max-width: 480px) {
    .dataTables_paginate .page-link {
        padding: 3px 6px;
        font-size: 11px;
    }
    
    .pagination {
        margin: 0;
    }
    
    .card-footer {
        padding: 0.75rem 1rem;
    }
}

@media (max-width: 576px) {
    .avatar.avatar-lg {
        width: 2.5rem;
        height: 2.5rem;
    }
    
    .fs-20 {
        font-size: 1.125rem !important;
    }
    
    .fs-15 {
        font-size: 0.9rem !important;
    }
}
</style>
@endsection