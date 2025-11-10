@extends('admin.layouts.layout')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<style>
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.375rem;
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        padding: 1rem 1.25rem;
    }
    
    .card-body {
        padding: 1.25rem;
    }
    
    .table {
        margin-bottom: 0;
    }
    
    .table th {
        background-color: #f8f9fa;
        border-top: none;
        font-weight: 600;
        font-size: 0.875rem;
        color: #495057;
        white-space: nowrap;
    }
    
    .table td {
        vertical-align: middle;
        font-size: 0.875rem;
        padding: 0.75rem;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.65rem;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .filter-row {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 0.375rem;
        margin-bottom: 1rem;
    }
    
    .export-buttons {
        margin-bottom: 1rem;
    }
    
    .bank-account-card {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 1rem;
        margin-bottom: 1rem;
        background-color: #fff;
    }
    
    .professional-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .professional-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .status-active {
        background-color: #d1edff;
        color: #0c63e4;
    }
    
    .status-inactive {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .account-type-savings {
        background-color: #d4edda;
        color: #155724;
    }
    
    .account-type-current {
        background-color: #cce5ff;
        color: #004085;
    }
    
    .verification-verified {
        background-color: #d1ecf1;
        color: #0c5460;
    }
    
    .verification-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .verification-failed {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        margin-bottom: 1rem;
    }
    
    .dataTables_wrapper .dataTables_length {
        float: left;
        margin-bottom: 1rem;
    }
    
    .dataTables_wrapper .dataTables_info {
        clear: both;
        float: left;
        padding-top: 0.755em;
    }
    
    .dataTables_wrapper .dataTables_paginate {
        float: right;
        text-align: right;
        padding-top: 0.25em;
    }
    
    .dt-buttons {
        margin-bottom: 1rem;
    }
    
    .dt-button {
        margin-right: 0.5rem;
        background-color: #0d6efd;
        color: white;
        border: 1px solid #0d6efd;
        padding: 0.375rem 0.75rem;
        border-radius: 0.375rem;
        text-decoration: none;
        display: inline-block;
        font-size: 0.875rem;
        transition: all 0.15s ease-in-out;
    }
    
    .dt-button:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
        color: white;
    }
    
    .dt-button.btn-success {
        background-color: #198754;
        border-color: #198754;
    }
    
    .dt-button.btn-success:hover {
        background-color: #157347;
        border-color: #146c43;
    }
    
    .mobile-view {
        display: none;
    }
    
    @media (max-width: 768px) {
        .desktop-view {
            display: none;
        }
        
        .mobile-view {
            display: block;
        }
        
        .bank-account-card {
            margin-bottom: 1rem;
        }
        
        .filter-row .row > div {
            margin-bottom: 0.5rem;
        }
    }
    
    .account-details {
        font-family: 'Courier New', monospace;
        font-weight: 600;
        color: #495057;
    }
    
    .ifsc-code {
        font-family: 'Courier New', monospace;
        font-weight: 600;
        color: #6f42c1;
    }
    
    .created-date {
        font-size: 0.75rem;
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-semibold fs-18 mb-0">Professional Bank Accounts</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Bank Accounts</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="d-md-flex d-block align-items-center justify-content-between">
                <div class="export-buttons">
                    <button id="exportPdf" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                    <button id="exportExcel" class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-filter me-2"></i>Filters
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="filterForm" method="GET">
                            <div class="row">
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <label for="professional_status" class="form-label">Professional Status</label>
                                    <select name="professional_status" id="professional_status" class="form-select">
                                        <option value="">All Statuses</option>
                                        <option value="accepted" {{ request('professional_status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                        <option value="rejected" {{ request('professional_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <label for="account_type" class="form-label">Account Type</label>
                                    <select name="account_type" id="account_type" class="form-select">
                                        <option value="">All Types</option>
                                        <option value="savings" {{ request('account_type') == 'savings' ? 'selected' : '' }}>Savings</option>
                                        <option value="current" {{ request('account_type') == 'current' ? 'selected' : '' }}>Current</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <label for="verification_status" class="form-label">Verification Status</label>
                                    <select name="verification_status" id="verification_status" class="form-select">
                                        <option value="">All Statuses</option>
                                        <option value="verified" {{ request('verification_status') == 'verified' ? 'selected' : '' }}>Verified</option>
                                        <option value="pending" {{ request('verification_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="failed" {{ request('verification_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-1"></i>Apply Filters
                                    </button>
                                    <a href="{{ route('admin.bank-accounts.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>Clear
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Summary -->
        @if(request()->hasAny(['professional_status', 'account_type', 'verification_status', 'search']))
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Showing <strong>{{ $bankAccounts->total() }}</strong> bank account(s) 
                        @if(request()->hasAny(['professional_status', 'account_type', 'verification_status', 'search']))
                            with applied filters:
                            @if(request('professional_status'))
                                <span class="badge bg-primary ms-1">Status: {{ ucfirst(request('professional_status')) }}</span>
                            @endif
                            @if(request('account_type'))
                                <span class="badge bg-success ms-1">Type: {{ ucfirst(request('account_type')) }}</span>
                            @endif
                            @if(request('verification_status'))
                                <span class="badge bg-warning ms-1">Verification: {{ ucfirst(request('verification_status')) }}</span>
                            @endif
                            @if(request('search'))
                                <span class="badge bg-info ms-1">Search: "{{ request('search') }}"</span>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Desktop Table View -->
        <div class="row desktop-view">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-university me-2"></i>Professional Bank Accounts
                        </h5>
                        <span class="badge bg-primary">{{ $bankAccounts->total() }} Total</span>
                    </div>
                    <div class="card-body">
                        @if($bankAccounts->count() > 0)
                            <div class="table-responsive">
                                <table id="bankAccountsTable" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Professional</th>
                                            <th>Bank Details</th>
                                            <th>Account Info</th>
                                            <th>IFSC Code</th>
                                            <th>Account Type</th>
                                            <th>Professional Status</th>
                                            <th>Verification</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bankAccounts as $account)
                                            <tr>
                                                <td>
                                                    <div class="professional-info">
                                                        @if($account->professional->profile_picture)
                                                            <img src="{{ asset('storage/' . $account->professional->profile_picture) }}" 
                                                                 alt="Profile" class="professional-avatar">
                                                        @else
                                                            <div class="professional-avatar bg-secondary d-flex align-items-center justify-content-center">
                                                                <i class="fas fa-user text-white"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="fw-semibold">{{ $account->professional->name }}</div>
                                                            <small class="text-muted">{{ $account->professional->email }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="fw-semibold">{{ $account->bank_name }}</div>
                                                    <small class="text-muted">{{ $account->branch_name }}</small>
                                                </td>
                                                <td>
                                                    <div class="account-details">{{ $account->account_number }}</div>
                                                    <small class="text-muted">{{ $account->account_holder_name }}</small>
                                                </td>
                                                <td>
                                                    <span class="ifsc-code">{{ $account->ifsc_code }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge account-type-{{ $account->account_type }}">
                                                        {{ ucfirst($account->account_type) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge1 status-{{ $account->professional->status }}">
                                                        {{ ucfirst($account->professional->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge verification-{{ $account->verification_status ?? 'pending' }}">
                                                        {{ ucfirst($account->verification_status ?? 'pending') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="created-date">
                                                        {{ $account->created_at->format('M d, Y') }}
                                                    </div>
                                                    <small class="text-muted">{{ $account->created_at->format('h:i A') }}</small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                                onclick="viewAccount({{ $account->id }})"
                                                                title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        @if($account->verification_status !== 'verified')
                                                        <button type="button" class="btn btn-sm btn-outline-success" 
                                                                onclick="verifyAccount({{ $account->id }})"
                                                                title="Verify Account">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-university fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Bank Accounts Found</h5>
                                <p class="text-muted">No professional bank accounts match your current filters.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="row mobile-view">
            <div class="col-12">
                @if($bankAccounts->count() > 0)
                    @foreach($bankAccounts as $account)
                        <div class="bank-account-card">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="professional-info">
                                        @if($account->professional->profile_picture)
                                            <img src="{{ asset('storage/' . $account->professional->profile_picture) }}" 
                                                 alt="Profile" class="professional-avatar">
                                        @else
                                            <div class="professional-avatar bg-secondary d-flex align-items-center justify-content-center">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold">{{ $account->professional->name }}</div>
                                            <small class="text-muted">{{ $account->professional->email }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <strong>Bank:</strong><br>
                                    <span>{{ $account->bank_name }}</span>
                                </div>
                                <div class="col-6 mb-2">
                                    <strong>Branch:</strong><br>
                                    <span>{{ $account->branch_name }}</span>
                                </div>
                                <div class="col-6 mb-2">
                                    <strong>Account:</strong><br>
                                    <span class="account-details">{{ $account->account_number }}</span>
                                </div>
                                <div class="col-6 mb-2">
                                    <strong>IFSC:</strong><br>
                                    <span class="ifsc-code">{{ $account->ifsc_code }}</span>
                                </div>
                                <div class="col-6 mb-2">
                                    <strong>Type:</strong><br>
                                    <span class="badge account-type-{{ $account->account_type }}">
                                        {{ ucfirst($account->account_type) }}
                                    </span>
                                </div>
                                <div class="col-6 mb-2">
                                    <strong>Status:</strong><br>
                                    <span class="badge status-{{ $account->professional->status }}">
                                        {{ ucfirst($account->professional->status) }}
                                    </span>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="btn-group w-100" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                onclick="viewAccount({{ $account->id }})">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        @if($account->verification_status !== 'verified')
                                        <button type="button" class="btn btn-sm btn-outline-success" 
                                                onclick="verifyAccount({{ $account->id }})">
                                            <i class="fas fa-check"></i> Verify
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-university fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Bank Accounts Found</h5>
                        <p class="text-muted">No professional bank accounts match your current filters.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pagination -->
        @if($bankAccounts->hasPages())
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        {{ $bankAccounts->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- View Account Modal -->
<div class="modal fade" id="viewAccountModal" tabindex="-1" aria-labelledby="viewAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewAccountModalLabel">
                    <i class="fas fa-university me-2"></i>Bank Account Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="accountDetailsContent">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    const table = $('#bankAccountsTable').DataTable({
        responsive: true,
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        order: [[7, 'desc']], // Sort by created date
        columnDefs: [
            { orderable: false, targets: [8] } // Actions column
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-success btn-sm',
                title: 'Professional Bank Accounts',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7] // Exclude actions column
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-danger btn-sm',
                title: 'Professional Bank Accounts',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7] // Exclude actions column
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-info btn-sm',
                title: 'Professional Bank Accounts',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7] // Exclude actions column
                }
            }
        ]
    });

    // Export buttons
    $('#exportExcel').on('click', function() {
        // Get current filter values
        const params = new URLSearchParams();
        const professional_status = $('#professional_status').val();
        const account_type = $('#account_type').val();
        const verification_status = $('#verification_status').val();
        const search = $('#search').val();
        
        if (professional_status) params.append('professional_status', professional_status);
        if (account_type) params.append('account_type', account_type);
        if (verification_status) params.append('verification_status', verification_status);
        if (search) params.append('search', search);
        
        window.location.href = '{{ route("admin.bank-accounts.export.excel") }}?' + params.toString();
    });

    $('#exportPdf').on('click', function() {
        // Get current filter values
        const params = new URLSearchParams();
        const professional_status = $('#professional_status').val();
        const account_type = $('#account_type').val();
        const verification_status = $('#verification_status').val();
        const search = $('#search').val();
        
        if (professional_status) params.append('professional_status', professional_status);
        if (account_type) params.append('account_type', account_type);
        if (verification_status) params.append('verification_status', verification_status);
        if (search) params.append('search', search);
        
        window.location.href = '{{ route("admin.bank-accounts.export.pdf") }}?' + params.toString();
    });

    // Auto-submit filters
    $('#professional_status, #account_type, #verification_status').on('change', function() {
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

// View account details
function viewAccount(accountId) {
    $.ajax({
        url: `/admin/bank-accounts/${accountId}`,
        type: 'GET',
        success: function(response) {
            $('#accountDetailsContent').html(response);
            $('#viewAccountModal').modal('show');
        },
        error: function() {
            toastr.error('Failed to load account details');
        }
    });
}

// Verify account
function verifyAccount(accountId) {
    Swal.fire({
        title: 'Verify Bank Account?',
        text: 'Are you sure you want to verify this bank account?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Verify',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/bank-accounts/${accountId}/verify`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        location.reload();
                    } else {
                        toastr.error(response.message || 'Failed to verify account');
                    }
                },
                error: function() {
                    toastr.error('Failed to verify account');
                }
            });
        }
    });
}
</script>
@endsection