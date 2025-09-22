@extends('professional.layout.layout')

@section('styles')
<style>
    /* Search card - compact and responsive */
    .search-card {
        background: #fff;
        border: 1px solid var(--border-color);
        padding: 12px 14px;
        border-radius: 8px;
        box-shadow: 0 8px 20px rgba(17,24,39,0.03);
        display: flex;
        gap: 12px;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .search-card .form-group 
    .search-card .form-group label { display: block; font-weight: 600; margin-bottom: 6px; color: #333; }
    .search-card .form-control { padding: 10px 12px; border-radius: 6px; border: 1px solid #e6e9ef; background: #fff; }

    .search-actions { display:flex; gap:8px; align-items:center; }
    .search-actions .btn { padding: 9px 14px; border-radius: 6px; }
    .search-actions .btn + .btn { margin-left: 6px; }

    /* Small screens: stack search fields */
    @media screen and (max-width: 767px) {
        .search-card { flex-direction: column; align-items: stretch; }
        .search-card .form-group { width: 100%; }
        .search-actions { justify-content: flex-end; }
    }

    /* Table layout tweaks kept minimal */
    .table-responsive { overflow-x: auto; }
    .table { width: 100%; border-collapse: collapse; }

</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">All Availability</li>
        </ul>
    </div>

    
    <!-- Advanced Filters -->
    <div class="filters-section mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-filter"></i> Filter Availability
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
                        <label for="filterMonth">Month</label>
                        <select id="filterMonth" class="form-control">
                            <option value="">All Months</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filterDuration">Session Duration</label>
                        <select id="filterDuration" class="form-control">
                            <option value="">All Durations</option>
                            <option value="30">30 minutes</option>
                            <option value="45">45 minutes</option>
                            <option value="60">60 minutes</option>
                            <option value="90">90 minutes</option>
                            <option value="120">120 minutes</option>
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

    <div class="card">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0">Availability List</h4>
                    <small class="text-muted">Manage availability per sub-service</small>
                </div>
                <div class="card-actions">
                    <a href="{{ route('professional.availability.create') }}" class="btn btn-primary btn-sm">Add Availability</a>
                </div>
            </div>
            <div class="table-responsive">
                @php
                    $groupedAvailability = $availability->groupBy('professional_service_id');
                @endphp
                
                @if($groupedAvailability->count() > 0)
                    @foreach($groupedAvailability as $serviceId => $serviceAvailability)
                        @php
                            $service = $serviceAvailability->first()->professionalService;
                            $serviceOnlyAvailability = $serviceAvailability->where('sub_service_id', null);
                            $subServiceAvailability = $serviceAvailability->where('sub_service_id', '!=', null)->groupBy('sub_service_id');
                        @endphp
                        
                        <!-- Service Level Availability -->
                        @if($serviceOnlyAvailability->count() > 0)
                            <div class="service-section mb-4">
                                <h5 class="service-header">{{ $service->service_name ?? 'N/A' }}</h5>
                                <table class="table table-bordered service-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Service</th>
                                            <th>Month</th>
                                            <th>Session Duration (mins)</th>
                                            <th>Weekdays</th>
                                            <th>Slots</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($serviceOnlyAvailability as $item)
                                            <tr>
                                                <td data-label="Service">
                                                    <div class="service-info">
                                                        <div class="service-name">{{ $service->service_name ?? 'N/A' }}</div>
                                                    </div>
                                                </td>
                                                <td data-label="Month">
                                                    @php
                                                        $raw = trim((string) $item->month);
                                                        $monthNames = [1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'];
                                                        $parts = preg_split('/[\s,]+/', $raw, -1, PREG_SPLIT_NO_EMPTY);
                                                        $labels = array_map(function($p) use ($monthNames) {
                                                            if (is_numeric($p) && isset($monthNames[(int)$p])) return $monthNames[(int)$p];
                                                            // common string values
                                                            if (strtolower($p) === 'all' || strtolower($p) === 'allavailablemonths' ) return 'All Months';
                                                            return ucfirst($p);
                                                        }, $parts);
                                                    @endphp
                                                    {{ implode(', ', $labels) }}
                                                </td>
                                                <td data-label="Session Duration">{{ $item->session_duration }}</td>
                                                <td data-label="Weekdays">
                                                    @foreach(json_decode($item->weekdays) as $day)
                                                        <span class="badge bg-info text-dark">{{ $day }}</span>
                                                    @endforeach
                                                </td>
                                                <td data-label="Slots">
                                                    @if($item->slots->count())
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach($item->slots as $slot)
                                                                <li>
                                                                    {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }} - 
                                                                    {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span class="text-muted">No slots</span>
                                                    @endif
                                                </td>
                                                <td data-label="Actions" class="text-nowrap">
                                                    <div class="" role="group">
                                                        <a href="{{ route('professional.availability.edit', $item->id) }}" class="rate-button" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" data-url="{{ route('professional.availability.destroy', $item->id) }}" class="delete-item" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        
                        <!-- Sub-Service Level Availability -->
                        @if($subServiceAvailability->count() > 0)
                            @foreach($subServiceAvailability as $subServiceId => $subAvailability)
                                @php
                                    $subService = $subAvailability->first()->subService;
                                @endphp
                                <div class="sub-service-section mb-4">
                                    <h6 class="sub-service-header">{{ $subService->name ?? 'N/A' }}</h6>
                                    <table class="table table-bordered sub-service-table">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th>Sub-Service</th>
                                                <th>Month</th>
                                                <th>Session Duration (mins)</th>
                                                <th>Weekdays</th>
                                                <th>Slots</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($subAvailability as $item)
                                                <tr>
                                                    <td data-label="Sub-Service">
                                                        <span class="subservice-name">{{ $subService->name ?? 'N/A' }}</span>
                                                    </td>
                                                    <td data-label="Month">
                                                        @php
                                                            $raw = trim((string) $item->month);
                                                            $monthNames = [1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'];
                                                            $parts = preg_split('/[\s,]+/', $raw, -1, PREG_SPLIT_NO_EMPTY);
                                                            $labels = array_map(function($p) use ($monthNames) {
                                                                if (is_numeric($p) && isset($monthNames[(int)$p])) return $monthNames[(int)$p];
                                                                if (strtolower($p) === 'all' || strtolower($p) === 'allavailablemonths' ) return 'All Months';
                                                                return ucfirst($p);
                                                            }, $parts);
                                                        @endphp
                                                        {{ implode(', ', $labels) }}
                                                    </td>
                                                    <td data-label="Session Duration">{{ $item->session_duration }}</td>
                                                    <td data-label="Weekdays">
                                                        @foreach(json_decode($item->weekdays) as $day)
                                                            <span class="badge bg-info text-dark">{{ $day }}</span>
                                                        @endforeach
                                                    </td>
                                                    <td data-label="Slots">
                                                        @if($item->slots->count())
                                                            <ul class="list-unstyled mb-0">
                                                                @foreach($item->slots as $slot)
                                                                    <li>
                                                                        {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }} - 
                                                                        {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            <span class="text-muted">No slots</span>
                                                        @endif
                                                    </td>
                                                    <td data-label="Actions" class="text-nowrap">
                                                        <div class="" role="group">
                                                            <a href="{{ route('professional.availability.edit', $item->id) }}" class="rate-button" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="javascript:void(0)" data-url="{{ route('professional.availability.destroy', $item->id) }}" class="delete-item" title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        @endif
                        
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
                                        <i class="fas fa-calendar-alt fa-3x mb-3 text-muted"></i>
                                        <h5>No availability found</h5>
                                        <p style="margin-bottom: 20px">You haven't set up any availability yet. Start by adding availability for your services.</p>
                                        <a href="{{ route('professional.availability.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Add Your First Availability
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
<style>
    .service-name { font-weight: 600; color: #0d6efd; }
    .subservice-name { font-size: 0.9rem; }
    
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

    /* Ensure action links use outline look and are touch-friendly */
    .rate-button, .delete-item {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 10px;
        border-radius: 6px;
        border: 1px solid transparent;
        color: var(--text-dark);
        background: transparent;
    }

    .rate-button { border-color: var(--primary); color: var(--primary); }
    .rate-button:hover { background: var(--primary); color: #fff; }

    .delete-item { border-color: var(--danger); color: var(--danger); }
    .delete-item:hover { background: var(--danger); color: #fff; }

    .table .service-info { min-width: 220px; }

    /* Mobile: action buttons become flexible for stacked cards */
    @media screen and (max-width: 767px) {
        table.table td[data-label="Actions"] a { flex: 1 1 auto; margin-left: 8px; }
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
    const filterMonth = document.getElementById('filterMonth');
    const filterDuration = document.getElementById('filterDuration');
    const applyFiltersBtn = document.getElementById('applyFilters');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const filterResults = document.getElementById('filterResults');
    
    let allAvailability = [];
    
    // Toggle filters visibility
    toggleFiltersBtn.addEventListener('click', function() {
        const isVisible = filtersBody.style.display !== 'none';
        filtersBody.style.display = isVisible ? 'none' : 'block';
        const icon = this.querySelector('i');
        icon.className = isVisible ? 'fas fa-chevron-down' : 'fas fa-chevron-up';
    });
    
    // Collect all availability data for filtering
    function collectAvailabilityData() {
        allAvailability = [];
        document.querySelectorAll('.service-section, .sub-service-section').forEach(section => {
            section.querySelectorAll('tbody tr').forEach(row => {
                const serviceName = row.querySelector('[data-label="Service"], [data-label="Sub-Service"]')?.textContent.trim();
                const month = row.querySelector('[data-label="Month"]')?.textContent.trim();
                const duration = row.querySelector('[data-label="Session Duration"]')?.textContent.trim();
                
                if (serviceName && month) {
                    const isSubService = row.querySelector('[data-label="Sub-Service"]') !== null;
                    
                    allAvailability.push({
                        element: row,
                        section: section,
                        serviceName: serviceName,
                        month: month,
                        duration: duration,
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
        const months = new Set();
        
        allAvailability.forEach(availability => {
            if (availability.isSubService) {
                subServices.add(availability.serviceName);
            } else {
                services.add(availability.serviceName);
            }
            months.add(availability.month);
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
        
        // Populate month filter
        filterMonth.innerHTML = '<option value="">All Months</option>';
        Array.from(months).sort().forEach(month => {
            const option = document.createElement('option');
            option.value = month;
            option.textContent = month;
            filterMonth.appendChild(option);
        });
    }
    
    // Apply filters
    function applyFilters() {
        const serviceFilter = filterService.value.toLowerCase();
        const subServiceFilter = filterSubService.value.toLowerCase();
        const monthFilter = filterMonth.value.toLowerCase();
        const durationFilter = filterDuration.value;
        
        let visibleCount = 0;
        
        allAvailability.forEach(availability => {
            let visible = true;
            
            // Service filter
            if (serviceFilter && !availability.serviceName.toLowerCase().includes(serviceFilter)) {
                visible = false;
            }
            
            // Sub-service filter
            if (subServiceFilter && (!availability.isSubService || !availability.serviceName.toLowerCase().includes(subServiceFilter))) {
                visible = false;
            }
            
            // Month filter
            if (monthFilter && !availability.month.toLowerCase().includes(monthFilter)) {
                visible = false;
            }
            
            // Duration filter
            if (durationFilter && !availability.duration.includes(durationFilter)) {
                visible = false;
            }
            
            // Show/hide row
            availability.element.style.display = visible ? '' : 'none';
            
            if (visible) {
                visibleCount++;
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
        filterResults.textContent = `Showing ${visibleCount} of ${allAvailability.length} availability entries`;
    }
    
    // Clear all filters
    function clearAllFilters() {
        filterService.value = '';
        filterSubService.value = '';
        filterMonth.value = '';
        filterDuration.value = '';
        
        // Show all elements
        allAvailability.forEach(availability => {
            availability.element.style.display = '';
            availability.section.style.display = 'block';
        });
        
        filterResults.textContent = '';
    }
    
    // Event listeners
    applyFiltersBtn.addEventListener('click', applyFilters);
    clearFiltersBtn.addEventListener('click', clearAllFilters);
    
    // Auto-apply filters on dropdown change
    [filterService, filterSubService, filterMonth, filterDuration].forEach(filter => {
        filter.addEventListener('change', applyFilters);
    });
    
    // Initialize
    collectAvailabilityData();
    populateFilters();
});
</script>
@endsection