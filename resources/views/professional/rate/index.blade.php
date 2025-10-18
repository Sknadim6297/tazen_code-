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
            
            <!-- Advanced Filters -->
            <div class="filters-section mb-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-filter"></i> Filter Rates
                            <button class="btn btn-sm btn-outline-secondary float-right" id="toggleFilters">
                                <i class="fas fa-chevron-down"></i> Toggle Filters
                            </button>
                        </h6>
                    </div>
                    <div class="card-body" id="filtersBody" style="display: none;">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="filterService">Service</label>
                                <select id="filterService" class="form-control">
                                    <option value="">All Services</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filterSubService">Sub-Service</label>
                                <select id="filterSubService" class="form-control">
                                    <option value="">All Sub-Services</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filterSessionType">Session Type</label>
                                <select id="filterSessionType" class="form-control">
                                    <option value="">All Session Types</option>
                                    <option value="One Time">One Time</option>
                                    <option value="Monthly">Monthly</option>
                                    <option value="Quarterly">Quarterly</option>
                                    <option value="Free Hand">Free Hand</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filterRate">Rate Range</label>
                                <select id="filterRate" class="form-control">
                                    <option value="">All Rates</option>
                                    <option value="0-500">₹0 - ₹500</option>
                                    <option value="501-1000">₹501 - ₹1000</option>
                                    <option value="1001-2000">₹1001 - ₹2000</option>
                                    <option value="2001-5000">₹2001 - ₹5000</option>
                                    <option value="5000+">₹5000+</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button id="applyFilters" class="btn btn-primary">Apply Filters</button>
                                <button id="clearFilters" class="btn btn-outline-secondary ml-2">Clear All</button>
                                <span id="filterResults" class="ml-3 text-muted"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                @php
                    $groupedRates = $rates->groupBy('service_id');
                @endphp
                
                @if($groupedRates->count() > 0)
                    @foreach($groupedRates as $serviceId => $serviceRates)
                        @php
                            // Ensure serviceId is properly typed
                            $serviceId = $serviceId ? (int)$serviceId : null;
                            $professionalService = $serviceId ? $professionalServices->get($serviceId) : null;
                            
                            // Get service name from multiple sources in order of preference
                            if ($professionalService && $professionalService->service) {
                                $serviceName = $professionalService->service->name;
                            } elseif ($professionalService && isset($professionalService->service_name)) {
                                $serviceName = $professionalService->service_name;
                            } elseif ($serviceRates->first() && $serviceRates->first()->service) {
                                $serviceName = $serviceRates->first()->service->name;
                            } else {
                                $serviceName = 'N/A';
                            }
                            $serviceOnlyRates = $serviceRates->where('sub_service_id', null);
                            $subServiceRates = $serviceRates->where('sub_service_id', '!=', null)->groupBy('sub_service_id');
                            
                            // Get all session types for this service (both main service and sub-services)
                            $allSessionTypes = $serviceRates->pluck('session_type')->unique()->toArray();
                            $availableSessionTypes = ['One Time', 'Monthly', 'Quarterly', 'Free Hand'];
                        @endphp
                        
                        <div class="service-section mb-4">
                            <h5 class="service-header">{{ $serviceName }}</h5>
                            
                            <!-- Combined Service and Sub-Service Rates Table -->
                            <table class="table table-bordered service-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Type</th>
                                        <th>Session Type</th>
                                        <th>No. of Sessions</th>
                                        <th>Rate/Session (₹)</th>
                                        <th>Final Rate (₹)</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Service Level Rates -->
                                    @foreach($serviceOnlyRates as $rate)
                                        <tr class="service-rate">
                                            <td data-label="Type">
                                                <span class="badge bg-primary">{{ $serviceName }}</span>
                                            </td>
                                            <td data-label="Session Type">{{ $rate->session_type }}</td>
                                            <td data-label="No. of Sessions">{{ $rate->num_sessions }}</td>
                                            <td data-label="Rate/Session">₹{{ number_format($rate->rate_per_session, 2) }}</td>
                                            <td data-label="Final Rate">₹{{ number_format($rate->final_rate, 2) }}</td>
                                            <td data-label="Actions">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('professional.rate.edit', $rate->id) }}" class="text-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" data-url="{{ route('professional.rate.destroy', $rate->id) }}" class="delete-item text-danger" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                    <!-- Sub-Service Level Rates -->
                                    @foreach($subServiceRates as $subServiceId => $subRates)
                                        @php
                                            $subService = $subRates->first()->subService;
                                        @endphp
                                        @foreach($subRates as $rate)
                                            <tr class="sub-service-rate">
                                                <td data-label="Type">
                                                    <span class="badge bg-info">{{ $subService->name ?? 'Sub-Service' }}</span>
                                                </td>
                                                <td data-label="Session Type">{{ $rate->session_type }}</td>
                                                <td data-label="No. of Sessions">{{ $rate->num_sessions }}</td>
                                                <td data-label="Rate/Session">₹{{ number_format($rate->rate_per_session, 2) }}</td>
                                                <td data-label="Final Rate">₹{{ number_format($rate->final_rate, 2) }}</td>
                                                <td data-label="Actions">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('professional.rate.edit', $rate->id) }}" class="text-primary" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" data-url="{{ route('professional.rate.destroy', $rate->id) }}" class="delete-item text-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    
                                    <!-- Show Available Session Types -->
                                    @php
                                        $usedSessionTypes = $serviceRates->pluck('session_type')->toArray();
                                        $availableToAdd = array_diff($availableSessionTypes, $usedSessionTypes);
                                        
                                        // Separate service-level and sub-service-level session types
                                        $serviceSessionTypes = $serviceOnlyRates->pluck('session_type')->toArray();
                                        $subServiceSessionTypes = $subServiceRates->flatten()->pluck('session_type')->toArray();
                                        $availableForService = array_diff($availableSessionTypes, $serviceSessionTypes);
                                        $availableForSubServices = array_diff($availableSessionTypes, $subServiceSessionTypes);
                                    @endphp
                                    
                                    @if(count($availableToAdd) > 0)
                                        <tr class="available-sessions-row">
                                            <td colspan="6" class="text-center bg-light">
                                                <div class="session-status-info">
                                                    <small class="text-muted">
                                                        <i class="fas fa-plus-circle"></i> 
                                                        <strong>Available to add:</strong> {{ implode(', ', $availableToAdd) }}
                                                    </small>
                                                    @if(count($availableForService) > 0)
                                                        <br><small class="text-info">
                                                            <i class="fas fa-info-circle"></i> 
                                                            For main service: {{ implode(', ', $availableForService) }}
                                                        </small>
                                                    @endif
                                                    @if($subServiceRates->count() > 0 && count($availableForSubServices) > 0)
                                                        <br><small class="text-secondary">
                                                            <i class="fas fa-layer-group"></i> 
                                                            For sub-services: {{ implode(', ', $availableForSubServices) }}
                                                        </small>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        <tr class="complete-sessions-row">
                                            <td colspan="6" class="text-center bg-success text-white">
                                                <small>
                                                    <i class="fas fa-check-circle"></i> All session types configured for this service
                                                </small>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        
                        @if(!$loop->last)
                            <hr class="service-separator">
                        @endif
                    @endforeach
                @else
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center text-muted">
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
                        </tbody>
                    </table>
                @endif
            </div>

            @if($rates->count() > 0)
                <div class="summary-info mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6><i class="fas fa-chart-bar"></i> Rate Summary</h6>
                                <p><strong>Total Rate Entries:</strong> {{ $rates->count() }}</p>
                                                                <p><strong>Services with Rates:</strong> {{ $rates->pluck('service_id')->unique()->count() }}</p>
                                <p><strong>Sub-Services with Rates:</strong> {{ $rates->whereNotNull('sub_service_id')->pluck('sub_service_id')->unique()->count() }}</p>
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
    
    .service-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
    
    .service-header {
        color: #0d6efd;
        font-weight: 600;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 2px solid #0d6efd;
    }
    
    .sub-service-section {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 12px;
        margin-left: 20px;
        margin-bottom: 15px;
    }
    
    .sub-service-header {
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 10px;
        padding-bottom: 5px;
        border-bottom: 1px solid #dee2e6;
    }
    
    .service-table {
        margin-bottom: 0;
    }
    
    .sub-service-table {
        margin-bottom: 0;
        background: #fff;
    }
    
    .service-separator {
        border-top: 2px solid #dee2e6;
        margin: 30px 0;
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
    
    /* Rate type styling */
    .service-rate {
        background-color: #f8f9ff;
    }
    
    .sub-service-rate {
        background-color: #f0f8ff;
    }
    
    .available-sessions-row td {
        padding: 12px;
        font-style: italic;
    }
    
    .complete-sessions-row td {
        padding: 8px;
        font-weight: 500;
    }
    
    .session-status-info {
        line-height: 1.5;
    }
    
    .session-status-info small {
        display: inline-block;
        margin: 2px 0;
    }
    
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
        
        .service-section {
            padding: 10px;
            margin-bottom: 15px;
        }
        
        .sub-service-section {
            margin-left: 10px;
            padding: 8px;
        }
        
        .service-header {
            font-size: 1.1rem;
        }
        
        .sub-service-header {
            font-size: 1rem;
        }

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

        .btn-group a {
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
    const toggleFiltersBtn = document.getElementById('toggleFilters');
    const filtersBody = document.getElementById('filtersBody');
    const filterService = document.getElementById('filterService');
    const filterSubService = document.getElementById('filterSubService');
    const filterSessionType = document.getElementById('filterSessionType');
    const filterRate = document.getElementById('filterRate');
    const applyFiltersBtn = document.getElementById('applyFilters');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const filterResults = document.getElementById('filterResults');
    
    let allRates = [];
    
    // Toggle filters visibility
    toggleFiltersBtn.addEventListener('click', function() {
        const isVisible = filtersBody.style.display !== 'none';
        filtersBody.style.display = isVisible ? 'none' : 'block';
        const icon = this.querySelector('i');
        icon.className = isVisible ? 'fas fa-chevron-down' : 'fas fa-chevron-up';
    });
    
    // Collect all rate data for filtering
    function collectRateData() {
        allRates = [];
        document.querySelectorAll('.service-section, .sub-service-section').forEach(section => {
            section.querySelectorAll('tbody tr').forEach(row => {
                const serviceName = row.querySelector('[data-label="Service"], [data-label="Sub-Service"]')?.textContent.trim();
                const sessionType = row.querySelector('[data-label="Session Type"]')?.textContent.trim();
                const rateText = row.querySelector('[data-label="Rate/Session"]')?.textContent.trim();
                const finalRateText = row.querySelector('[data-label="Final Rate"]')?.textContent.trim();
                
                if (serviceName && sessionType) {
                    const rate = parseFloat(rateText.replace(/[₹,]/g, '')) || 0;
                    const finalRate = parseFloat(finalRateText.replace(/[₹,]/g, '')) || 0;
                    const isSubService = row.querySelector('[data-label="Sub-Service"]') !== null;
                    
                    allRates.push({
                        element: row,
                        section: section,
                        serviceName: serviceName,
                        sessionType: sessionType,
                        rate: rate,
                        finalRate: finalRate,
                        isSubService: isSubService
                    });
                }
            });
        });
    }
    
    // Populate filter dropdowns
    function populateFilters() {
        const services = new Set();
        const subServices = new Set();
        
        allRates.forEach(rate => {
            if (rate.isSubService) {
                subServices.add(rate.serviceName);
            } else {
                services.add(rate.serviceName);
            }
        });
        
        // Populate service filter
        filterService.innerHTML = '<option value="">All Services</option>';
        Array.from(services).sort().forEach(service => {
            const option = document.createElement('option');
            option.value = service;
            option.textContent = service;
            filterService.appendChild(option);
        });
        
        // Populate sub-service filter
        filterSubService.innerHTML = '<option value="">All Sub-Services</option>';
        Array.from(subServices).sort().forEach(subService => {
            const option = document.createElement('option');
            option.value = subService;
            option.textContent = subService;
            filterSubService.appendChild(option);
        });
    }
    
    // Apply filters
    function applyFilters() {
        const serviceFilter = filterService.value.toLowerCase();
        const subServiceFilter = filterSubService.value.toLowerCase();
        const sessionTypeFilter = filterSessionType.value.toLowerCase();
        const rateFilter = filterRate.value;
        
        let visibleCount = 0;
        let hiddenSections = new Set();
        
        allRates.forEach(rate => {
            let visible = true;
            
            // Service filter
            if (serviceFilter && !rate.serviceName.toLowerCase().includes(serviceFilter)) {
                visible = false;
            }
            
            // Sub-service filter
            if (subServiceFilter && (!rate.isSubService || !rate.serviceName.toLowerCase().includes(subServiceFilter))) {
                visible = false;
            }
            
            // Session type filter
            if (sessionTypeFilter && !rate.sessionType.toLowerCase().includes(sessionTypeFilter)) {
                visible = false;
            }
            
            // Rate filter
            if (rateFilter) {
                const rateValue = rate.finalRate;
                let rateMatch = false;
                
                switch(rateFilter) {
                    case '0-500':
                        rateMatch = rateValue >= 0 && rateValue <= 500;
                        break;
                    case '501-1000':
                        rateMatch = rateValue >= 501 && rateValue <= 1000;
                        break;
                    case '1001-2000':
                        rateMatch = rateValue >= 1001 && rateValue <= 2000;
                        break;
                    case '2001-5000':
                        rateMatch = rateValue >= 2001 && rateValue <= 5000;
                        break;
                    case '5000+':
                        rateMatch = rateValue > 5000;
                        break;
                    default:
                        rateMatch = true;
                }
                
                if (!rateMatch) {
                    visible = false;
                }
            }
            
            // Show/hide row
            rate.element.style.display = visible ? '' : 'none';
            
            if (visible) {
                visibleCount++;
            } else {
                hiddenSections.add(rate.section);
            }
        });
        
        // Hide sections that have no visible rows
        document.querySelectorAll('.service-section, .sub-service-section').forEach(section => {
            const visibleRows = Array.from(section.querySelectorAll('tbody tr')).filter(row => 
                row.style.display !== 'none'
            );
            
            if (visibleRows.length === 0) {
                section.style.display = 'none';
            } else {
                section.style.display = 'block';
            }
        });
        
        // Update results
        filterResults.textContent = `Showing ${visibleCount} of ${allRates.length} rates`;
    }
    
    // Clear all filters
    function clearAllFilters() {
        filterService.value = '';
        filterSubService.value = '';
        filterSessionType.value = '';
        filterRate.value = '';
        
        // Show all elements
        allRates.forEach(rate => {
            rate.element.style.display = '';
            rate.section.style.display = 'block';
        });
        
        filterResults.textContent = '';
    }
    
    // Event listeners
    applyFiltersBtn.addEventListener('click', applyFilters);
    clearFiltersBtn.addEventListener('click', clearAllFilters);
    
    // Auto-apply filters on dropdown change
    [filterService, filterSubService, filterSessionType, filterRate].forEach(filter => {
        filter.addEventListener('change', applyFilters);
    });
    
    // Initialize
    collectRateData();
    populateFilters();
});
</script>
@endsection