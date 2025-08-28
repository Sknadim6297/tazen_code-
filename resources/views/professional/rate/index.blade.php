@extends('professional.layout.layout')

@section('style')
<!-- Page-specific styles (kept minimal here) -->
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">All Rates</li>
        </ul>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0">Rate List</h4>
                    <small class="text-muted">Manage rates per service and sub-service</small>
                </div>
                <div class="card-actions">
                    <a href="{{ route('professional.rate.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i> Add Rate
                    </a>
                </div>
            </div>
                <!-- Filter: Sub-Service only -->
                <div class="row my-3 align-items-center">
                    <div class="col-md-6">
                        <label for="filterSubService" class="form-label">Filter by Sub-Service</label>
                        <select id="filterSubService" class="form-control">
                            <option value="">All / None</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <button id="clearFilters" class="btn btn-outline-secondary">Clear Filters</button>
                    </div>
                </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Service</th>
                            <th>Sub-Service</th>
                            <th>Session Type</th>
                            <th>No. of Sessions</th>
                            <th>Rate/Session (₹)</th>
                            <th>Final Rate (₹)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rates as $rate)
                            <tr data-service="{{ $rate->professionalService->service_name ?? 'N/A' }}" data-subservice="{{ $rate->subService->name ?? '' }}">
                                <td data-label="Service">
                                    <div class="service-info">
                                        <div class="service-name">{{ $rate->professionalService->service_name ?? 'N/A' }}</div>
                                    </div>
                                </td>
                                <td data-label="Sub-Service" class="align-middle">
                                    @if($rate->subService)
                                        <span class="subservice-name text-muted">{{ $rate->subService->name }}</span>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td data-label="Session Type">{{ $rate->session_type }}</td>
                                <td data-label="No. of Sessions">{{ $rate->num_sessions }}</td>
                                <td data-label="Rate/Session">₹{{ number_format($rate->rate_per_session, 2) }}</td>
                                <td data-label="Final Rate">₹{{ number_format($rate->final_rate, 2) }}</td>
                                <td data-label="Actions">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('professional.rate.edit', $rate->id) }}" class="" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" data-url="{{ route('professional.rate.destroy', $rate->id) }}" class="delete-item" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    <div class="empty-state">
                                        <i class="fas fa-money-bill-wave fa-3x mb-3 text-muted"></i>
                                        <h5>No rate details found</h5>
                                        <p>You haven't set up any rates yet. Start by adding rates for your services.</p>
                                        <a href="{{ route('professional.rate.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Add Your First Rate
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($rates->count() > 0)
                <div class="summary-info mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6><i class="fas fa-chart-bar"></i> Rate Summary</h6>
                                <p><strong>Total Rate Entries:</strong> {{ $rates->count() }}</p>
                                <p><strong>Services with Rates:</strong> {{ $rates->pluck('professional_service_id')->unique()->count() }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6><i class="fas fa-info-circle"></i> Quick Info</h6>
                                <p>Each service can have up to 4 different session types (One Time, Monthly, Quarterly, Free Hand)</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .service-info {
        min-width: 200px;
    }
    
    .empty-state {
        padding: 2rem;
        text-align: center;
    }
    
    .info-card {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        border-left: 4px solid #007bff;
    }
    
    .info-card h6 {
        color: #007bff;
        margin-bottom: 0.5rem;
    }
    
    .info-card p {
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
    }

    /* Enhanced visuals */
    .service-name { font-weight: 600; color: #0d6efd; }
    .subservice-name { font-size: 0.9rem; }

    .btn-outline-primary { color: #0d6efd; border-color: #0d6efd; }
    .btn-outline-danger { color: #dc3545; border-color: #dc3545; }

    .empty-state h5 { margin-top: 0.5rem; }
    .empty-state p { margin-bottom: 1rem; }
    
    @media only screen and (min-width: 768px) and (max-width: 1024px) {
    .user-profile-wrapper {
        margin-top: -57px;
    }
}
    @media screen and (max-width: 767px) {
    /* Fix header to prevent horizontal scrolling */
    .page-header {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f8f9fa;
        padding-top: 10px;
        padding-bottom: 10px;
        width: 100%;
        max-width: 100vw;
        overflow-x: hidden;
    }
    
    /* Make table container scrollable horizontally */
    .table-wrapper {
        overflow-x: auto;
        max-width: 100%;
        -webkit-overflow-scrolling: touch; /* Better scrolling on iOS */
    }
    
    /* Ensure the table takes full width of container */
    .data-table {
        width: 100%;
        table-layout: auto;
    }
    
    /* Fix the search container from overflowing */
    .search-container {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }
    
    /* Ensure content wrapper doesn't cause horizontal scroll */
    .content-wrapper {
        overflow-x: hidden;
        width: 100%;
        max-width: 100vw;
        padding: 20px 10px;
    }
    
    /* Fix card width */
    .card {
        width: 100%;
        overflow-x: hidden;
    }
    
    /* Ensure the card body doesn't cause overflow */
    .card-body {
        padding: 10px 5px;
    }
    
    /* Optional: Make some table columns width-responsive */
    .data-table th,
    .data-table td {
        white-space: nowrap;
    }
}
</style>

<style>
    /* Mobile: convert table rows into stacked cards for easier management */
    @media screen and (max-width: 767px) {
        .table-responsive { overflow-x: auto; }

        table.table {
            border-collapse: separate;
        }

        table.table thead {
            display: none;
        }

        table.table, table.table tbody, table.table tr, table.table td {
            display: block;
            width: 100%;
        }

        table.table tr {
            margin-bottom: 12px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 10px;
            background: #fff;
        }

        table.table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 8px;
            border: none;
            white-space: normal;
        }

        /* Use the data-label attribute already present on TDs for header labels */
        table.table td:before {
            content: attr(data-label) ": ";
            font-weight: 600;
            color: #495057;
            margin-right: 8px;
            flex: 0 0 auto;
        }

        /* Make action buttons easier to tap */
        table.table td[data-label="Actions"] {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        .btn-group a.btn {
            padding: 8px 10px;
            font-size: 14px;
            flex: 1 1 auto; /* make buttons share available space on small screens */
            text-align: center;
        }

        /* Reduce summary section clutter on mobile */
        .summary-info .info-card {
            padding: 0.75rem;
        }
    }

    /* Tablet: allow horizontal scroll but keep readable padding */
    @media screen and (min-width: 768px) and (max-width: 1024px) {
        .table-responsive { overflow-x: auto; }
        table.table td, table.table th { padding: 8px; }
    }
</style>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterSubService = document.getElementById('filterSubService');
    const clearFilters = document.getElementById('clearFilters');

    // Populate sub-service options based on current table rows
    function populateSubServices() {
        const subservices = new Set();
        document.querySelectorAll('table tbody tr').forEach(row => {
            const ss = row.getAttribute('data-subservice');
            if (ss) subservices.add(ss);
        });

        // Clear and re-add
        filterSubService.innerHTML = '<option value="">All / None</option>';
        Array.from(subservices).sort().forEach(name => {
            const opt = document.createElement('option');
            opt.value = name;
            opt.textContent = name;
            filterSubService.appendChild(opt);
        });
    }

    function applyFilters() {
        const ss = filterSubService.value;

        document.querySelectorAll('table tbody tr').forEach(row => {
            const rowSs = row.getAttribute('data-subservice') || '';
            const visible = ss ? (rowSs === ss) : true;
            row.style.display = visible ? '' : 'none';
        });
    }

    filterSubService.addEventListener('change', applyFilters);

    clearFilters.addEventListener('click', function() {
        filterSubService.value = '';
        populateSubServices();
        applyFilters();
    });

    // Initial population
    populateSubServices();
});
</script>

@endsection