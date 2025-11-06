@extends('admin.layouts.layout')

@section('styles')
<style>
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 20px;
        color: white;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    .stats-card:hover {
        transform: translateY(-5px);
    }
    .stats-card.pending { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .stats-card.approved { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .stats-card.rejected { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
    .stats-card.paid { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #333; }
    
    /* Consulting Status Cards */
    .stats-card.consulting-not-started { background: linear-gradient(135deg, #868f96 0%, #596164 100%); }
    .stats-card.consulting-pending { background: linear-gradient(135deg, #ffc371 0%, #ff5f6d 100%); }
    .stats-card.consulting-completed { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    
    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .stats-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    
    .filter-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .table-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .status-badge {
        padding: 6px 12px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-approved { background: #d4edda; color: #155724; }
    .status-rejected { background: #f8d7da; color: #721c24; }
    .status-paid { background: #d1ecf1; color: #0c5460; }
    .status-later { background: #e2e3e5; color: #383d41; }
    
    /* Consulting Status Badges */
    .status-secondary { background: #e2e3e5; color: #6c757d; }
    .status-warning { background: #fff3cd; color: #856404; }
    .status-info { background: #d1ecf9; color: #0c5460; }
    .status-success { background: #d4edda; color: #155724; }
    
    .action-btn {
        padding: 4px 8px;
        font-size: 0.8rem;
        border-radius: 4px;
        margin: 2px;
    }
    
    .bulk-actions {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: none;
    }
    
    .price-display {
        font-weight: 600;
        color: #28a745;
    }
    .price-modified {
        color: #fd7e14;
        position: relative;
    }
    .price-modified::after {
        content: "Modified";
        position: absolute;
        top: -8px;
        right: -8px;
        background: #fd7e14;
        color: white;
        font-size: 0.6rem;
        padding: 2px 4px;
        border-radius: 3px;
    }
    
    .table th {
        background: #f8f9fa;
        border: none;
        font-weight: 600;
        color: #495057;
    }
    
    .table td {
        vertical-align: middle;
        border-color: #f1f3f4;
    }
    
    .select-all-checkbox, .select-item-checkbox {
        transform: scale(1.2);
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Re-requested Services Management</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Re-requested Services</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

            <!-- Filters -->
            <div class="filter-card">
                <form method="GET" action="{{ route('admin.re-requested-services.index') }}" id="filterForm">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status">Admin Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="user_status">User Status</label>
                                <select name="user_status" id="user_status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('user_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ request('user_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="later" {{ request('user_status') == 'later' ? 'selected' : '' }}>Do Later</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="consulting_status">Consulting Status</label>
                                <select name="consulting_status" id="consulting_status" class="form-control">
                                    <option value="">All Consulting Status</option>
                                    <option value="not_started" {{ request('consulting_status') == 'not_started' ? 'selected' : '' }}>Not Started</option>
                                    <option value="professional_completed" {{ request('consulting_status') == 'professional_completed' ? 'selected' : '' }}>Pending Customer</option>
                                    <option value="completed" {{ request('consulting_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="per_page">Per Page</label>
                                <select name="per_page" id="per_page" class="form-control">
                                    <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="search">Search</label>
                                <input type="text" name="search" id="search" class="form-control" 
                                       placeholder="Service name, professional, user..." 
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-search"></i> Apply Filters
                                    </button>
                                    <a href="{{ route('admin.re-requested-services.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Clear Filters
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Bulk Actions -->
            <div class="bulk-actions" id="bulkActions">
                <div class="row">
                    <div class="col-md-6">
                        <span id="selectedCount">0</span> items selected
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-success btn-sm" onclick="bulkAction('approve')">
                            <i class="fas fa-check"></i> Bulk Approve
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="bulkAction('reject')">
                            <i class="fas fa-times"></i> Bulk Reject
                        </button>
                    </div>
                </div>
            </div>

            <!-- Re-requested Services Table -->
            <div class="table-card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th width="40">
                                    <input type="checkbox" class="select-all-checkbox" id="selectAll">
                                </th>
                                <th>ID</th>
                                <th>Service Details</th>
                                <th>Professional</th>
                                <th>Customer</th>
                                <th>Price</th>
                                <th>Professional Payment</th>
                                <th>Admin Status</th>
                                <th>User Status</th>
                                <th>Consulting Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reRequestedServices as $service)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="select-item-checkbox" value="{{ $service->id }}">
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">#{{ $service->id }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ Str::limit($service->service_name, 30) }}</strong>
                                            <br>
                                            <small class="text-muted">Booking #{{ $service->booking_id }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            {{ $service->professional->name }}
                                            <br>
                                            <small class="text-muted">{{ $service->professional->email }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            {{ $service->user->name }}
                                            <br>
                                            <small class="text-muted">{{ $service->user->email }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="price-display {{ $service->price_modified_by_admin ? 'price-modified' : '' }}">
                                            @if($service->price_modified_by_admin)
                                                <div class="text-muted small" style="text-decoration: line-through;">
                                                    ₹{{ number_format($service->total_price, 2) }}
                                                </div>
                                                ₹{{ number_format($service->modified_total_price, 2) }}
                                            @else
                                                ₹{{ number_format($service->total_price, 2) }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="price-display">
                                            @php
                                                $earningsDetails = $service->getProfessionalEarningsDetailsAttribute();
                                            @endphp
                                            @if($earningsDetails['calculation_ready'] && $earningsDetails['platform_percentage'] > 0)
                                                <span class="text-success fw-bold">₹{{ number_format($earningsDetails['professional_amount'], 2) }}</span>
                                                <br><small class="text-muted">{{ $earningsDetails['professional_percentage'] }}% (Platform: {{ $earningsDetails['platform_percentage'] }}%)</small>
                                                @if($earningsDetails['is_calculated'])
                                                    <br><small class="text-success"><i class="fas fa-check-circle"></i> Calculated</small>
                                                @else
                                                    <br><small class="text-info"><i class="fas fa-calculator"></i> Preview</small>
                                                @endif
                                            @else
                                                <span class="text-warning">Not Configured</span>
                                                <br><small class="text-muted">Platform fee not set</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $service->admin_status }}">
                                            {{ ucfirst($service->admin_status) }}
                                        </span>
                                        @if($service->admin_reviewed_at)
                                            <br><small class="text-muted">{{ $service->admin_reviewed_at->format('M d') }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $service->user_status }}">
                                            {{ $service->user_status == 'later' ? 'Do Later' : ucfirst($service->user_status) }}
                                        </span>
                                        @if($service->user_responded_at)
                                            <br><small class="text-muted">{{ $service->user_responded_at->format('M d') }}</small>
                                        @endif
                                        
                                        @if($service->delivery_date_set && $service->delivery_date)
                                            <br>
                                            <span class="badge badge-{{ $service->delivery_date->isPast() && !$service->professional_completed_at ? 'danger' : ($service->delivery_date->isToday() ? 'warning' : 'info') }}">
                                                <i class="fas fa-calendar-check"></i> 
                                                @if($service->professional_completed_at)
                                                    Delivered
                                                @elseif($service->delivery_date->isPast())
                                                    Overdue
                                                @elseif($service->delivery_date->isToday())
                                                    Due Today
                                                @else
                                                    Due {{ $service->delivery_date->format('M d') }}
                                                @endif
                                            </span>
                                        @elseif($service->user_status === 'paid' && !$service->delivery_date_set)
                                            <br>
                                            <span class="badge badge-secondary">
                                                <i class="fas fa-clock"></i> Awaiting Delivery Date
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $consultingStatus = $service->consulting_status ?? 'not_started';
                                            $statusLabels = [
                                                'not_started' => 'Not Started',
                                                'professional_completed' => 'Pending Customer',
                                                'in_progress' => 'In Progress',
                                                'completed' => 'Completed'
                                            ];
                                            $statusColors = [
                                                'not_started' => 'secondary',
                                                'professional_completed' => 'warning',
                                                'in_progress' => 'info',
                                                'completed' => 'success'
                                            ];

                                            // safe fallback to avoid undefined index errors
                                            $statusLabel = $statusLabels[$consultingStatus] ?? ucfirst(str_replace('_', ' ', $consultingStatus));
                                            $statusColorClass = $statusColors[$consultingStatus] ?? 'secondary';
                                        @endphp
                                        <span class="status-badge status-{{ $statusColorClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                        @if($service->professional_completed_at)
                                            <br><small class="text-muted">Pro: {{ $service->professional_completed_at->format('M d') }}</small>
                                        @endif
                                        @if($service->customer_confirmed_at)
                                            <br><small class="text-muted">Customer: {{ $service->customer_confirmed_at->format('M d') }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span title="{{ $service->created_at->format('M d, Y h:i A') }}">
                                            {{ $service->created_at->format('M d, Y') }}
                                        </span>
                                        <br>
                                        <small class="text-muted">{{ $service->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group-vertical">
                                            <a href="{{ route('admin.re-requested-services.show', $service) }}" 
                                               class="action-btn btn btn-info btn-sm" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.re-requested-services.edit', $service) }}" 
                                               class="action-btn btn btn-warning btn-sm" title="Review & Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No re-requested services found.</p>
                                        <p class="text-muted small">
                                            @if(request()->hasAny(['status', 'user_status', 'search']))
                                                Try adjusting your filters to see more results.
                                            @else
                                                Professionals haven't created any additional service requests yet.
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($reRequestedServices->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Showing {{ $reRequestedServices->firstItem() }} to {{ $reRequestedServices->lastItem() }} 
                                of {{ $reRequestedServices->total() }} results
                            </div>
                            {{ $reRequestedServices->withQueryString()->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Bulk Action Modal -->
<div class="modal fade" id="bulkActionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bulk Action</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="bulkActionForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="action" id="bulkActionType">
                    <input type="hidden" name="ids" id="bulkActionIds">
                    
                    <div class="form-group">
                        <label for="bulk_reason">Reason/Comments</label>
                        <textarea class="form-control" id="bulk_reason" name="reason" rows="3" 
                                  placeholder="Enter reason for this action..."></textarea>
                    </div>
                    
                    <div id="confirmMessage" class="alert alert-warning"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="confirmBulkAction">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Auto-submit form on filter change
    $('#status, #user_status, #per_page').on('change', function() {
        $('#filterForm').submit();
    });

    // Search with debounce
    let searchTimeout;
    $('#search').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            $('#filterForm').submit();
        }, 500);
    });

    // Select all functionality
    $('#selectAll').on('change', function() {
        $('.select-item-checkbox').prop('checked', this.checked);
        updateBulkActions();
    });

    $('.select-item-checkbox').on('change', function() {
        updateBulkActions();
        
        // Update select all checkbox
        const totalCheckboxes = $('.select-item-checkbox').length;
        const checkedCheckboxes = $('.select-item-checkbox:checked').length;
        $('#selectAll').prop('checked', totalCheckboxes === checkedCheckboxes);
    });

    function updateBulkActions() {
        const selectedCount = $('.select-item-checkbox:checked').length;
        $('#selectedCount').text(selectedCount);
        
        if (selectedCount > 0) {
            $('#bulkActions').show();
        } else {
            $('#bulkActions').hide();
        }
    }

    // Bulk action handler
    window.bulkAction = function(action) {
        const selectedIds = $('.select-item-checkbox:checked').map(function() {
            return this.value;
        }).get();

        if (selectedIds.length === 0) {
            alert('Please select at least one item.');
            return;
        }

        $('#bulkActionType').val(action);
        $('#bulkActionIds').val(selectedIds.join(','));
        
        const actionText = action === 'approve' ? 'approve' : 'reject';
        const count = selectedIds.length;
        
        $('#confirmMessage').html(
            `<strong>Are you sure?</strong><br>` +
            `This will ${actionText} ${count} selected request(s). This action cannot be undone.`
        );
        
        $('#confirmBulkAction').removeClass('btn-primary btn-success btn-danger')
                               .addClass(action === 'approve' ? 'btn-success' : 'btn-danger')
                               .text(action === 'approve' ? 'Approve Selected' : 'Reject Selected');
        
        $('#bulkActionForm').attr('action', "{{ route('admin.re-requested-services.bulk-action') }}");
        $('#bulkActionModal').modal('show');
    };

    // Handle bulk action form submission
    $('#bulkActionForm').on('submit', function(e) {
        const submitBtn = $('#confirmBulkAction');
        submitBtn.prop('disabled', true).text('Processing...');
    });
});
</script>
@endsection
