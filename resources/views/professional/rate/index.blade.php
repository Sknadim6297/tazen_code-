@extends('professional.layout.layout')

@section('title', 'Rate Management')

@section('styles')
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --accent: #22c55e;
        --background: #f4f6fb;
        --card-bg: #ffffff;
        --border: #e5e7eb;
        --text-dark: #0f172a;
        --text-muted: #64748b;
    }

    body,
    .app-content {
        background: var(--background);
    }

    .rates-page {
        width: 100%;
        padding: 0 1.25rem 3rem;
    }

    .rates-shell {
        max-width: 1240px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 1.75rem;
    }

    .rates-header {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        justify-content: space-between;
        padding: 2rem 2.4rem;
        gap: 1.25rem;
        border-radius: 24px;
        border: 1px solid rgba(79,70,229,0.15);
        background: linear-gradient(135deg, rgba(79,70,229,0.12), rgba(59,130,246,0.08));
        position: relative;
        overflow: hidden;
    }

    .rates-header::after {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, rgba(79,70,229,0.2), transparent 55%);
        pointer-events: none;
    }

    .rates-header > * {
        position: relative;
        z-index: 1;
    }

    .rates-header h1 {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }

    .rates-header .breadcrumb {
        margin: 0.45rem 0 0;
        padding: 0;
        background: transparent;
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .rates-header .breadcrumb a {
        color: var(--primary);
        text-decoration: none;
    }

    .header-actions {
        display: flex;
        gap: 0.85rem;
        flex-wrap: wrap;
    }

    .header-actions .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.85rem 1.5rem;
        border-radius: 999px;
        font-weight: 600;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        color: #fff;
        box-shadow: 0 15px 34px rgba(79,70,229,0.28);
    }

    .header-actions .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 40px rgba(79,70,229,0.32);
    }

    .filters-card {
        background: var(--card-bg);
        border-radius: 20px;
        border: 1px solid var(--border);
        box-shadow: 0 14px 34px rgba(15,23,42,0.12);
        padding: 1.8rem;
    }

    .filters-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .filters-header h2 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-dark);
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
    }

    .filters-toggle {
        border: 1px solid rgba(79,70,229,0.35);
        color: var(--primary-dark);
        border-radius: 999px;
        padding: 0.45rem 1rem;
        background: transparent;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        cursor: pointer;
    }

    .filters-body {
        margin-top: 1.4rem;
        display: none;
        animation: fadeIn 0.2s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.2rem;
        margin-bottom: 1.25rem;
    }

    .filters-grid label {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.88rem;
        margin-bottom: 0.4rem;
        display: block;
    }

    .filters-grid select {
        border-radius: 12px;
        border: 1px solid var(--border);
        padding: 0.7rem 0.9rem;
        font-size: 0.95rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .filters-grid select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79,70,229,0.15);
    }

    .filters-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        align-items: center;
    }

    .filters-actions .btn {
        border-radius: 12px;
        padding: 0.65rem 1.3rem;
        font-weight: 600;
    }

    .filters-actions .btn-outline-secondary {
        border: 1px solid rgba(100,116,139,0.35);
        color: var(--text-muted);
        background: #fff;
    }

    .filters-actions .btn-outline-secondary:hover {
        background: rgba(15,23,42,0.05);
    }

    .filters-results {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .service-section {
        background: var(--card-bg);
        border-radius: 20px;
        border: 1px solid var(--border);
        box-shadow: 0 14px 36px rgba(15,23,42,0.12);
        padding: 1.75rem;
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
    }

    .service-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        padding-bottom: 0.75rem;
    }

    .service-title h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .rates-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
        border-radius: 16px;
        border: 1px solid rgba(226,232,240,0.9);
    }

    .rates-table thead {
        background: rgba(79,70,229,0.08);
    }

    .rates-table th {
        font-weight: 700;
        color: var(--text-dark);
        padding: 0.85rem 1rem;
        font-size: 0.9rem;
    }

    .rates-table td {
        padding: 0.8rem 1rem;
        border-top: 1px solid rgba(226,232,240,0.7);
        font-size: 0.9rem;
    }

    .rate-type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.7rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        background: rgba(79,70,229,0.12);
        color: var(--primary-dark);
    }

    .rate-type-badge.sub {
        background: rgba(14,165,233,0.12);
        color: #0369a1;
    }

    .feature-pill {
        display: inline-block;
        padding: 0.35rem 0.65rem;
        border-radius: 999px;
        background: rgba(15,23,42,0.06);
        color: var(--text-dark);
        font-weight: 600;
        font-size: 0.78rem;
        margin: 0.15rem;
    }

    .table-actions {
        display: inline-flex;
        gap: 0.4rem;
        align-items: center;
    }

    .table-actions a {
        display: inline-flex;
        width: 36px;
        height: 36px;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: rgba(79,70,229,0.1);
        color: var(--primary-dark);
    }

    .table-actions a.text-danger {
        background: rgba(239,68,68,0.12);
        color: #dc2626;
    }

    .available-session-info {
        background: rgba(248,250,252,0.85);
        border-radius: 14px;
        padding: 1rem;
        font-size: 0.88rem;
        color: var(--text-muted);
    }

    .available-session-info strong {
        color: var(--text-dark);
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.2rem;
    }

    .summary-card {
        background: var(--card-bg);
        border-radius: 18px;
        border: 1px solid var(--border);
        box-shadow: 0 10px 28px rgba(15,23,42,0.1);
        padding: 1.4rem;
        display: flex;
        flex-direction: column;
        gap: 0.55rem;
    }

    .summary-card h4 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--primary-dark);
    }

    .summary-card p {
        margin: 0;
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .empty-state {
        background: transparent;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 1rem;
        padding: 2.5rem 1rem;
    }

    .empty-state i {
        color: var(--primary);
    }

    .empty-state .btn {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        color: #fff;
        padding: 0.85rem 1.8rem;
        border-radius: 999px;
        font-weight: 600;
        box-shadow: 0 16px 32px rgba(79,70,229,0.24);
    }

    @media (max-width: 768px) {
        .rates-page {
            padding: 0 1rem 2.5rem;
        }

        .rates-header {
            padding: 1.75rem 1.6rem;
        }

        .filters-grid {
            grid-template-columns: 1fr;
        }

        .filters-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .filters-actions .btn,
        .filters-actions .btn-outline-secondary {
            width: 100%;
            justify-content: center;
        }

        .rates-table,
        .rates-table thead,
        .rates-table tbody,
        .rates-table th,
        .rates-table td,
        .rates-table tr {
            display: block;
        }

        .rates-table thead {
            display: none;
        }

        .rates-table tr {
            margin-bottom: 1rem;
            border: 1px solid rgba(226,232,240,0.8);
            border-radius: 14px;
            background: #fff;
            padding: 0.75rem 0.9rem;
        }

        .rates-table td {
            border: none;
            padding: 0.45rem 0;
            display: flex;
            justify-content: space-between;
            gap: 1rem;
        }

        .rates-table td::before {
            content: attr(data-label);
            font-weight: 700;
            color: var(--text-muted);
        }

        .table-actions {
            justify-content: flex-end;
            gap: 0.55rem;
        }

        .table-actions a {
            width: 40px;
            height: 40px;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="rates-page">
        <div class="rates-shell">
            <header class="rates-header">
                <div>
                    <h1>Rate Management</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('professional.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Rates</li>
                        </ol>
                    </nav>
                </div>
                <div class="header-actions">
                    <a href="{{ route('professional.rate.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Rate
                    </a>
                </div>
            </header>

            <section class="filters-card">
                <div class="filters-header">
                    <h2><i class="fas fa-filter"></i> Filter Rates</h2>
                    <button class="filters-toggle" id="toggleFilters">
                        <i class="fas fa-chevron-down"></i> Toggle Filters
                    </button>
                </div>
                <div class="filters-body" id="filtersBody">
                    <div class="filters-grid">
                        <div>
                            <label for="filterService">Service</label>
                            <select id="filterService">
                                <option value="">All Services</option>
                            </select>
                        </div>
                        <div>
                            <label for="filterSubService">Sub-Service</label>
                            <select id="filterSubService">
                                <option value="">All Sub-Services</option>
                            </select>
                        </div>
                        <div>
                            <label for="filterSessionType">Session Type</label>
                            <select id="filterSessionType">
                                <option value="">All Session Types</option>
                                <option value="One Time">One Time</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Quarterly">Quarterly</option>
                                <option value="Free Hand">Free Hand</option>
                            </select>
                        </div>
                        <div>
                            <label for="filterRate">Rate Range</label>
                            <select id="filterRate">
                                <option value="">All Rates</option>
                                <option value="0-500">₹0 - ₹500</option>
                                <option value="501-1000">₹501 - ₹1000</option>
                                <option value="1001-2000">₹1001 - ₹2000</option>
                                <option value="2001-5000">₹2001 - ₹5000</option>
                                <option value="5000+">₹5000+</option>
                            </select>
                        </div>
                    </div>
                    <div class="filters-actions">
                        <button id="applyFilters" class="btn btn-primary">Apply Filters</button>
                        <button id="clearFilters" class="btn btn-outline-secondary">Clear All</button>
                        <span id="filterResults" class="filters-results"></span>
                    </div>
                </div>
            </section>

            @php
                $groupedRates = $rates->groupBy(function($rate) {
                    if ($rate->professionalService && $rate->professionalService->service_id) {
                        return $rate->professionalService->service_id;
                    }
                    if ($rate->subService && $rate->subService->service_id) {
                        return $rate->subService->service_id;
                    }
                    return 'unknown';
                });
            @endphp

            @if($groupedRates->count() > 0)
                @foreach($groupedRates as $serviceId => $serviceRates)
                    @php
                        $firstRate = $serviceRates->first();
                        $serviceName = null;

                        if ($firstRate && $firstRate->professionalService) {
                            if ($firstRate->professionalService->service) {
                                $serviceName = $firstRate->professionalService->service->name;
                            } elseif ($firstRate->professionalService->service_name) {
                                $serviceName = $firstRate->professionalService->service_name;
                            }
                        }

                        if (!$serviceName && $firstRate && $firstRate->subService) {
                            $subServiceModel = $firstRate->subService;
                            if ($subServiceModel && $subServiceModel->service_id) {
                                $serviceFromSubService = \App\Models\Service::find($subServiceModel->service_id);
                                if ($serviceFromSubService) {
                                    $serviceName = $serviceFromSubService->name;
                                }
                            }
                        }

                        if (!$serviceName) {
                            $serviceName = 'Service';
                        }

                        $serviceOnlyRates = $serviceRates->where('sub_service_id', null);
                        $subServiceRates = $serviceRates->where('sub_service_id', '!=', null)->groupBy('sub_service_id');
                    @endphp

                    <section class="service-section" data-service="{{ $serviceName }}">
                        <div class="service-title">
                            <h3>{{ $serviceName }}</h3>
                            <span class="filters-results">Total rates: {{ $serviceRates->count() }}</span>
                        </div>

                        <div class="table-responsive">
                            <table class="rates-table">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Session Type</th>
                                        <th>No. of Sessions</th>
                                        <th>Rate/Session (₹)</th>
                                        <th>Final Rate (₹)</th>
                                        <th>Features</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($serviceOnlyRates as $rate)
                                        <tr data-service="{{ $serviceName }}" data-sub-service="" data-session-type="{{ $rate->session_type }}" data-final-rate="{{ $rate->final_rate }}">
                                            <td data-label="Type">
                                                <span class="rate-type-badge"><i class="fas fa-briefcase"></i> {{ $serviceName }}</span>
                                            </td>
                                            <td data-label="Session Type">{{ $rate->session_type }}</td>
                                            <td data-label="No. of Sessions">{{ $rate->num_sessions }}</td>
                                            <td data-label="Rate/Session">₹{{ number_format($rate->rate_per_session, 2) }}</td>
                                            <td data-label="Final Rate">₹{{ number_format($rate->final_rate, 2) }}</td>
                                            <td data-label="Features">
                                                @if($rate->features && count($rate->features) > 0)
                                                    @foreach($rate->features as $feature)
                                                        @if(trim($feature))
                                                            <span class="feature-pill">{{ $feature }}</span>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <small class="text-muted">No features</small>
                                                @endif
                                            </td>
                                            <td data-label="Actions">
                                                <div class="table-actions">
                                                    <a href="{{ route('professional.rate.edit', $rate->id) }}" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" data-url="{{ route('professional.rate.destroy', $rate->id) }}" class="delete-item text-danger" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach($subServiceRates as $subServiceId => $subRates)
                                        @php
                                            $subService = $subRates->first()->subService;
                                        @endphp
                                        @foreach($subRates as $rate)
                                            <tr data-service="{{ $serviceName }}" data-sub-service="{{ $subService->name ?? 'Sub-Service' }}" data-session-type="{{ $rate->session_type }}" data-final-rate="{{ $rate->final_rate }}">
                                                <td data-label="Type">
                                                    <span class="rate-type-badge sub"><i class="fas fa-layer-group"></i> {{ $subService->name ?? 'Sub-Service' }}</span>
                                                </td>
                                                <td data-label="Session Type">{{ $rate->session_type }}</td>
                                                <td data-label="No. of Sessions">{{ $rate->num_sessions }}</td>
                                                <td data-label="Rate/Session">₹{{ number_format($rate->rate_per_session, 2) }}</td>
                                                <td data-label="Final Rate">₹{{ number_format($rate->final_rate, 2) }}</td>
                                                <td data-label="Features">
                                                    @if($rate->features && count($rate->features) > 0)
                                                        @foreach($rate->features as $feature)
                                                            @if(trim($feature))
                                                                <span class="feature-pill">{{ $feature }}</span>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <small class="text-muted">No features</small>
                                                    @endif
                                                </td>
                                                <td data-label="Actions">
                                                    <div class="table-actions">
                                                        <a href="{{ route('professional.rate.edit', $rate->id) }}" title="Edit">
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
                                </tbody>
                            </table>
                        </div>
                    </section>
                @endforeach

                <section class="summary-grid">
                    <div class="summary-card">
                        <h4><i class="fas fa-chart-bar"></i> Rate Summary</h4>
                        <p><strong>Total Rate Entries:</strong> {{ $rates->count() }}</p>
                        <p><strong>Services with Rates:</strong> {{ $rates->pluck('service_id')->unique()->count() }}</p>
                        <p><strong>Sub-Services with Rates:</strong> {{ $rates->whereNotNull('sub_service_id')->pluck('sub_service_id')->unique()->count() }}</p>
                    </div>
                    <div class="summary-card">
                        <h4><i class="fas fa-info-circle"></i> Quick Info</h4>
                        <p>Each service can include up to four session types: One Time, Monthly, Quarterly, and Free Hand.</p>
                        <p>Use the filters above to quickly find rates for a specific offering.</p>
                    </div>
                </section>
            @else
                <section class="service-section">
                    <div class="empty-state">
                        <i class="fas fa-money-bill-wave fa-3x"></i>
                        <h4>No rate details found</h4>
                        <p>You haven't set up any rates yet. Start by adding rates for your services.</p>
                        <a href="{{ route('professional.rate.create') }}" class="btn">
                            <i class="fas fa-plus"></i> Add Your First Rate
                        </a>
                    </div>
                </section>
            @endif
        </div>
    </div>
</div>
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

    toggleFiltersBtn.addEventListener('click', function() {
        const isVisible = filtersBody.style.display !== 'none';
        filtersBody.style.display = isVisible ? 'none' : 'block';
        const icon = this.querySelector('i');
        icon.className = isVisible ? 'fas fa-chevron-down' : 'fas fa-chevron-up';
    });

    function collectRateData() {
        allRates = [];
        document.querySelectorAll('.service-section').forEach(section => {
            section.querySelectorAll('tbody tr[data-service]').forEach(row => {
                const serviceName = row.getAttribute('data-service') || '';
                const subServiceName = row.getAttribute('data-sub-service') || '';
                const sessionType = row.getAttribute('data-session-type') || '';
                const finalRate = parseFloat(row.getAttribute('data-final-rate')) || 0;
                const isSubService = subServiceName !== '';
                
                if (serviceName && sessionType) {
                    allRates.push({
                        element: row,
                        section: section,
                        serviceName,
                        subServiceName,
                        sessionType,
                        finalRate,
                        isSubService
                    });
                }
            });
        });
    }

    function populateFilters() {
        const services = new Set();
        const subServices = new Set();
        
        allRates.forEach(rate => {
            services.add(rate.serviceName);
            if (rate.isSubService && rate.subServiceName) {
                subServices.add(rate.subServiceName);
            }
        });
        
        filterService.innerHTML = '<option value="">All Services</option>';
        Array.from(services).sort().forEach(service => {
            const option = document.createElement('option');
            option.value = service;
            option.textContent = service;
            filterService.appendChild(option);
        });
        
        filterSubService.innerHTML = '<option value="">All Sub-Services</option>';
        Array.from(subServices).sort().forEach(subService => {
            const option = document.createElement('option');
            option.value = subService;
            option.textContent = subService;
            filterSubService.appendChild(option);
        });
    }

    function applyFilters() {
        const serviceFilter = filterService.value.toLowerCase();
        const subServiceFilter = filterSubService.value.toLowerCase();
        const sessionTypeFilter = filterSessionType.value.toLowerCase();
        const rateFilter = filterRate.value;
        let visibleCount = 0;
        
        allRates.forEach(rate => {
            let visible = true;
            
            // Service filter
            if (serviceFilter && !rate.serviceName.toLowerCase().includes(serviceFilter)) {
                visible = false;
            }
            
            // Sub-service filter
            if (subServiceFilter && (!rate.isSubService || !rate.subServiceName.toLowerCase().includes(subServiceFilter))) {
                visible = false;
            }
            
            // Session type filter
            if (sessionTypeFilter && !rate.sessionType.toLowerCase().includes(sessionTypeFilter)) {
                visible = false;
            }
            
            // Rate range filter
            if (rateFilter) {
                const val = rate.finalRate;
                let match = false;
                switch(rateFilter) {
                    case '0-500': match = val >= 0 && val <= 500; break;
                    case '501-1000': match = val >= 501 && val <= 1000; break;
                    case '1001-2000': match = val >= 1001 && val <= 2000; break;
                    case '2001-5000': match = val >= 2001 && val <= 5000; break;
                    case '5000+': match = val > 5000; break;
                    default: match = true;
                }
                if (!match) visible = false;
            }
            
            rate.element.style.display = visible ? '' : 'none';
            if (visible) visibleCount++;
        });
        
        // Hide/show service sections based on visible rows
        document.querySelectorAll('.service-section').forEach(section => {
            const visibleRows = Array.from(section.querySelectorAll('tbody tr[data-service]')).filter(row => row.style.display !== 'none');
            section.style.display = visibleRows.length > 0 ? 'block' : 'none';
        });
        
        filterResults.textContent = `Showing ${visibleCount} of ${allRates.length} rates`;
    }

    function clearAllFilters() {
        filterService.value = '';
        filterSubService.value = '';
        filterSessionType.value = '';
        filterRate.value = '';
        
        allRates.forEach(rate => {
            rate.element.style.display = '';
        });
        
        document.querySelectorAll('.service-section').forEach(section => {
            section.style.display = 'block';
        });
        
        filterResults.textContent = '';
    }

    applyFiltersBtn.addEventListener('click', applyFilters);
    clearFiltersBtn.addEventListener('click', clearAllFilters);
    [filterService, filterSubService, filterSessionType, filterRate].forEach(filter => {
        filter.addEventListener('change', applyFilters);
    });

    collectRateData();
    populateFilters();
});
</script>
@endsection