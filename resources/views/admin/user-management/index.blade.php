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
    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <span class="avatar avatar-md bg-primary">
                            <i class="ri-user-line fs-16"></i>
                        </span>
                    </div>
                    <div class="flex-fill">
                        <div class="fw-semibold">Total Users</div>
                        <div class="text-muted fs-12">All registered</div>
                    </div>
                    <div class="text-end">
                        <div class="fs-18 fw-semibold text-primary">{{ number_format($stats['total_users']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <span class="avatar avatar-md bg-success">
                            <i class="ri-checkbox-circle-line fs-16"></i>
                        </span>
                    </div>
                    <div class="flex-fill">
                        <div class="fw-semibold">Completed</div>
                        <div class="text-muted fs-12">Full registration</div>
                    </div>
                    <div class="text-end">
                        <div class="fs-18 fw-semibold text-success">{{ number_format($stats['completed_registrations']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <span class="avatar avatar-md bg-warning">
                            <i class="ri-time-line fs-16"></i>
                        </span>
                    </div>
                    <div class="flex-fill">
                        <div class="fw-semibold">Incomplete</div>
                        <div class="text-muted fs-12">Pending password</div>
                    </div>
                    <div class="text-end">
                        <div class="fs-18 fw-semibold text-warning">{{ number_format($stats['incomplete_registrations']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <span class="avatar avatar-md bg-info">
                            <i class="ri-mail-check-line fs-16"></i>
                        </span>
                    </div>
                    <div class="flex-fill">
                        <div class="fw-semibold">Email Verified</div>
                        <div class="text-muted fs-12">Verified emails</div>
                    </div>
                    <div class="text-end">
                        <div class="fs-18 fw-semibold text-info">{{ number_format($stats['email_verified']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <span class="avatar avatar-md bg-danger">
                            <i class="ri-mail-close-line fs-16"></i>
                        </span>
                    </div>
                    <div class="flex-fill">
                        <div class="fw-semibold">Email Pending</div>
                        <div class="text-muted fs-12">Unverified emails</div>
                    </div>
                    <div class="text-end">
                        <div class="fs-18 fw-semibold text-danger">{{ number_format($stats['email_not_verified']) }}</div>
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
                        <th>User Info</th>
                        <th>Contact</th>
                        <th>Registration Status</th>
                        <th>Email Status</th>
                        <th>Registration Date</th>
                        <th>Actions</th>
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
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted">
                Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} results
            </div>
            <div id="paginationContainer">
                {{ $users->links() }}
            </div>
        </div>
    </div>
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
});

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
.badge {
    font-size: 0.75em;
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
}

.mobile-card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 12px;
    background: white;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
}

.action-buttons .btn {
    padding: 4px 8px;
    font-size: 12px;
    margin-right: 4px;
    margin-bottom: 4px;
}

@media (max-width: 768px) {
    .btn-list {
        flex-direction: column;
        gap: 8px;
    }
    
    .btn-list .btn {
        width: 100%;
    }
}
</style>
@endsection