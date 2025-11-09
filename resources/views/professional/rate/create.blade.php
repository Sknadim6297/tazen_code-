@extends('professional.layout.layout')

@section('styles')
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --secondary: #0ea5e9;
        --text-dark: #0f172a;
        --text-muted: #64748b;
        --page-bg: #f5f7fb;
        --card-border: rgba(148, 163, 184, 0.24);
    }

    body,
    .app-content {
        background: var(--page-bg) !important;
    }

    .content-wrapper.rates-create-page {
        background: transparent !important;
        padding: 0 !important;
        box-shadow: none !important;
        margin: 0 auto !important;
        width: 100% !important;
    }

    .rates-create-page {
        padding: 2.75rem 1.25rem 3.5rem !important;
    }

    .rates-shell {
        max-width: 1180px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .rates-header {
        border-radius: 24px !important;
        padding: 2rem 2.4rem !important;
        display: flex !important;
        flex-wrap: wrap !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 1.25rem !important;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(59, 130, 246, 0.1)) !important;
        border: 1px solid rgba(79, 70, 229, 0.18) !important;
        box-shadow: 0 22px 48px rgba(79, 70, 229, 0.14) !important;
        position: relative !important;
        overflow: hidden !important;
    }

    .rates-header::before,
    .rates-header::after {
        content: "" !important;
        position: absolute !important;
        border-radius: 50% !important;
        pointer-events: none !important;
        opacity: 0.6 !important;
    }

    .rates-header::before {
        width: 340px !important;
        height: 340px !important;
        top: -46% !important;
        right: -14% !important;
        background: rgba(79, 70, 229, 0.18) !important;
    }

    .rates-header::after {
        width: 220px !important;
        height: 220px !important;
        bottom: -42% !important;
        left: -10% !important;
        background: rgba(59, 130, 246, 0.16) !important;
    }

    .header-info,
    .header-actions {
        position: relative;
        z-index: 1;
    }

    .header-info .pretitle {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border-radius: 999px;
        padding: 0.4rem 1rem;
        font-size: 0.72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        background: rgba(255, 255, 255, 0.38) !important;
        border: 1px solid rgba(255, 255, 255, 0.45) !important;
        color: var(--text-dark) !important;
    }

    .header-info h1 {
        margin: 1.15rem 0 0.65rem !important;
        font-size: 2.2rem !important;
        font-weight: 700 !important;
        letter-spacing: -0.015em !important;
        color: var(--text-dark) !important;
    }

    .header-info p {
        margin: 0 !important;
        max-width: 520px !important;
        font-size: 1rem !important;
        line-height: 1.6rem !important;
        color: var(--text-muted) !important;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 0.9rem;
    }

    .header-btn {
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.55rem !important;
        padding: 0.85rem 1.65rem !important;
        border-radius: 999px !important;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
        color: #ffffff !important;
        border: none !important;
        box-shadow: 0 14px 30px rgba(79, 70, 229, 0.24) !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        transition: all 0.25s ease !important;
    }

    .header-btn:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 18px 36px rgba(79, 70, 229, 0.28) !important;
    }

    .rates-card {
        border-radius: 28px !important;
        background: #ffffff !important;
        border: 1px solid var(--card-border) !important;
        box-shadow: 0 32px 70px rgba(15, 23, 42, 0.12) !important;
        overflow: hidden !important;
    }

    .rates-card__head {
        padding: 2.1rem 2.6rem 1.75rem !important;
        border-bottom: 1px solid rgba(148, 163, 184, 0.24) !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 0.55rem !important;
    }

    .rates-card__head h2 {
        margin: 0;
        font-size: 1.55rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .rates-card__head .subtitle {
        margin: 0;
        color: var(--text-muted);
        font-size: 0.96rem;
        line-height: 1.55rem;
    }

    .rates-card__body {
        padding: 2.35rem 2.6rem 2.5rem !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 1.9rem !important;
    }

    .info-card {
        padding: 1.85rem !important;
        border-radius: 22px !important;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.18), rgba(129, 140, 248, 0.1)) !important;
        border: 1px solid rgba(59, 130, 246, 0.22) !important;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.35) !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 1.2rem !important;
    }

    .info-card__header {
        display: flex !important;
        flex-wrap: wrap !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 0.9rem !important;
    }

    .info-card__header h3 {
        margin: 0 !important;
        font-size: 1.12rem !important;
        font-weight: 700 !important;
        color: var(--text-dark) !important;
    }

    .info-badge {
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.4rem !important;
        padding: 0.35rem 1rem !important;
        border-radius: 999px !important;
        background: rgba(40, 120, 255, 0.18) !important;
        border: 1px solid rgba(59, 130, 246, 0.35) !important;
        color: #1d4ed8 !important;
        font-weight: 600 !important;
        font-size: 0.8rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.06em !important;
    }

    .info-card__hint {
        margin: 0 !important;
        color: var(--text-muted) !important;
        font-size: 0.95rem !important;
    }

    .info-grid {
        display: grid !important;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)) !important;
        gap: 1.2rem !important;
    }

    .info-field {
        display: flex !important;
        flex-direction: column !important;
        gap: 0.6rem !important;
    }

    .info-field label {
        font-size: 0.92rem !important;
        font-weight: 600 !important;
        color: var(--text-dark) !important;
    }

    .info-input {
        border-radius: 14px !important;
        border: 1px solid rgba(148, 163, 184, 0.35) !important;
        padding: 0.78rem 1rem !important;
        font-size: 0.96rem !important;
        background: rgba(248, 250, 252, 0.92) !important;
        color: var(--text-dark) !important;
        transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
    }

    .info-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.18);
    }

    .small-note {
        font-size: 0.86rem;
        color: var(--text-muted);
    }

    .rate-section {
        border-radius: 22px !important;
        border: 1px solid rgba(226, 232, 240, 0.85) !important;
        background: #f8fafc !important;
        padding: 1.95rem !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 1.35rem !important;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.6) !important;
    }

    .section-heading {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.85rem;
    }

    .section-heading h4 {
        margin: 0;
        font-size: 1.08rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .section-heading p {
        margin: 0;
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .table-shell {
        border-radius: 20px !important;
        overflow: hidden !important;
        border: 1px solid rgba(226, 232, 240, 0.85) !important;
        background: #ffffff !important;
    }

    .styled-table {
        width: 100% !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;
    }

    .styled-table thead {
        background: rgba(79, 70, 229, 0.09) !important;
    }
    .styled-table th {
        padding: 0.95rem 1.05rem !important;
        font-size: 0.84rem !important;
        font-weight: 700 !important;
        letter-spacing: 0.05em !important;
        text-transform: uppercase !important;
        color: rgba(15, 23, 42, 0.9) !important;
        border-bottom: 1px solid rgba(148, 163, 184, 0.24) !important;
        white-space: nowrap !important;
    }

    .styled-table td {
        padding: 0.85rem 1.05rem !important;
        border-bottom: 1px solid rgba(148, 163, 184, 0.18) !important;
        background: #ffffff !important;
        vertical-align: middle !important;
    }

    .styled-table tr:last-child td {
        border-bottom: none !important;
    }

    .styled-table input.form-control,
    .styled-table select.form-control {
        border-radius: 12px !important;
        border: 1px solid rgba(148, 163, 184, 0.35) !important;
        padding: 0.68rem 0.9rem !important;
        font-size: 0.93rem !important;
        color: var(--text-dark) !important;
        transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
    }

    .styled-table input.form-control:focus,
    .styled-table select.form-control:focus {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.16) !important;
    }

    .inline-actions {
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 0.85rem !important;
        align-items: center !important;
    }

    .btn-outline {
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.55rem !important;
        padding: 0.8rem 1.45rem !important;
        border-radius: 999px !important;
        border: 1px solid rgba(79, 70, 229, 0.45) !important;
        background: rgba(79, 70, 229, 0.12) !important;
        color: var(--primary-dark) !important;
        font-weight: 600 !important;
        transition: all 0.2s ease !important;
    }

    .btn-outline:hover {
        background: rgba(79, 70, 229, 0.18) !important;
        border-color: rgba(79, 70, 229, 0.6) !important;
        transform: translateY(-1px) !important;
    }

    .btn-danger.btn-sm {
        border-radius: 13px;
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .sub-service-rate-section {
        border-radius: 22px !important;
        border: 1px solid rgba(203, 213, 225, 0.8) !important;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.08), rgba(129, 140, 248, 0.06)) !important;
        padding: 1.7rem !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 1.2rem !important;
    }

    .sub-service-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .sub-service-heading h5 {
        margin: 0;
        font-size: 1.02rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .sub-service-heading span {
        font-size: 0.88rem;
        color: var(--text-muted);
    }

    .form-footer {
        display: flex !important;
        flex-wrap: wrap !important;
        justify-content: space-between !important;
        align-items: center !important;
        gap: 1rem !important;
        padding-top: 1.2rem !important;
        border-top: 1px solid rgba(148, 163, 184, 0.2) !important;
    }

    .primary-btn {
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.6rem !important;
        padding: 0.96rem 2.2rem !important;
        border-radius: 999px !important;
        border: none !important;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        font-size: 1rem !important;
        box-shadow: 0 26px 52px rgba(79, 70, 229, 0.3) !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease !important;
    }

    .primary-btn:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 30px 58px rgba(79, 70, 229, 0.35) !important;
    }

    .primary-btn:disabled {
        opacity: 0.65 !important;
        box-shadow: none !important;
        cursor: not-allowed !important;
    }

    .empty-state {
        padding: 2.3rem;
        border-radius: 24px;
        border: 1px solid rgba(248, 113, 113, 0.35);
        background: rgba(254, 226, 226, 0.7);
        display: flex;
        flex-direction: column;
        gap: 0.95rem;
        align-items: center;
        text-align: center;
        color: #b91c1c;
    }

    .empty-state .btn {
        padding: 0.85rem 1.6rem;
        border-radius: 999px;
        border: none;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #ffffff;
        font-weight: 600;
    }

    @media (max-width: 1024px) {
        .rates-create-page {
            padding: 2.4rem 1.15rem 3rem;
        }

        .rates-card__body {
            padding: 2rem;
        }
    }

    @media (max-width: 768px) {
        .rates-header {
            padding: 2rem 1.8rem;
        }

        .header-actions {
            width: 100%;
            justify-content: flex-start;
        }

        .header-btn {
            width: 100%;
            justify-content: center;
        }

        .rates-card__head {
            padding: 1.6rem 1.8rem;
        }

        .rates-card__body {
            padding: 1.75rem;
        }

        .info-grid {
            grid-template-columns: repeat(auto-fit, minmax(100%, 1fr));
        }

        .rate-section {
            padding: 1.55rem;
        }

        .styled-table,
        .styled-table thead,
        .styled-table tbody,
        .styled-table th,
        .styled-table td,
        .styled-table tr {
            display: block;
        }

        .styled-table thead {
            display: none;
        }

        .styled-table tr {
            border-radius: 18px;
            border: 1px solid rgba(203, 213, 225, 0.65);
            margin-bottom: 1.1rem;
            overflow: hidden;
            background: #ffffff;
        }

        .styled-table td {
            border: none;
            padding: 0.8rem 1.1rem;
            display: flex;
            justify-content: space-between;
            gap: 1.3rem;
            background: transparent;
        }

        .styled-table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--text-muted);
            flex: 0 0 48%;
            text-transform: capitalize;
        }

        .styled-table input.form-control,
        .styled-table select.form-control {
            width: 55%;
        }

        .inline-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-outline,
        .primary-btn {
            width: 100%;
            justify-content: center;
        }

        .form-footer {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper rates-create-page">
    <div class="rates-shell">
        <header class="rates-header">
            <div class="header-info">
                <span class="pretitle">Rates & Packages</span>
                <h1>Add Rate</h1>
                <p>Set up clear, structured pricing so clients immediately understand the value of your offerings.</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('professional.rate.index') }}" class="header-btn">
                    <i class="fas fa-arrow-left"></i>
                    Back to Rates
                </a>
            </div>
        </header>

        <section class="rates-card">
            <div class="rates-card__head">
                <h2>Create Rate Packages</h2>
                <p class="subtitle">Configure pricing for your service and any sub-services. Add multiple session bundles and rates without altering existing logic.</p>
            </div>

            <div class="rates-card__body">
                <form id="rateForm">
                    @csrf

                    @if($professionalServices && count($professionalServices) > 0)
                        @php $currentService = $professionalServices[0]; @endphp
                        <div class="info-card">
                            <div class="info-card__header">
                                <h3>{{ $currentService->service_name }}</h3>
                                <span class="info-badge">
                                    <i class="fas fa-briefcase"></i>
                                    Active Service
                                </span>
                            </div>
                            <p class="info-card__hint">All rate plans you create below will attach to this service. You can add as many session-based packages as you need.</p>

                            <div class="info-grid">
                                <div class="info-field">
                                    <label>Your Service</label>
                                    <input type="text" class="form-control info-input" value="{{ $currentService->service_name }}" readonly>
                                    <input type="hidden" id="serviceId" value="{{ $currentService->id }}">
                                    <span class="small-note">This field is locked to the primary service linked to your professional profile.</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>No service found yet.</strong>
                            <p>Please create a service first before setting up rate packages.</p>
                            <a href="{{ route('professional.service.create') }}" class="btn">
                                Create Service
                            </a>
                        </div>
                    @endif

                    <div class="rate-section" id="serviceRateTableContainer" style="display: none;">
                        <div class="section-heading">
                            <h4>Service Level Rates</h4>
                            <p>Add session-based plans for your main service offering.</p>
                        </div>
                        <div class="table-shell">
                            <div class="table-responsive">
                                <table class="table table-bordered styled-table">
                                    <thead>
                                        <tr>
                                            <th>Select Service</th>
                                            <th>Session Type</th>
                                            <th>No of Sessions</th>
                                            <th>Rate Per Session</th>
                                            <th>Final Rate</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="serviceRateTableBody">
                                        <!-- Service level rates will be added here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="inline-actions">
                            <button type="button" class="btn btn-outline add-btn" id="addServiceRateBtn">
                                <i class="fas fa-plus"></i>
                                Add New Rate
                            </button>
                        </div>
                    </div>

                    <div class="rate-section" id="subServiceRateContainer" style="display: none;">
                        <div class="section-heading">
                            <h4>Sub-Service Level Rates</h4>
                            <p>Need different pricing for specific sub-services? Configure them here.</p>
                        </div>
                        <div id="subServiceRatesList">
                            <!-- Sub-service rate tables will be dynamically added here -->
                        </div>
                    </div>

                    <div class="form-footer" id="saveButtonContainer" style="display: none;">
                        <button type="submit" class="btn primary-btn">
                            <i class="fas fa-save"></i>
                            Save Rates
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sessionTypes = ['One Time', 'Monthly', 'Quarterly', 'Free Hand']; 
    let currentServiceId = null;
    let currentService = null;
    let serviceRateCounter = 0;
    let subServiceRateCounters = {};
    let usedSessionTypes = [];
    let usedForSubMap = {}; // subServiceId => array of used session types from DB
    
    // Auto-initialize with the professional's service
    const serviceId = document.getElementById('serviceId');
    if (serviceId && serviceId.value) {
        currentServiceId = serviceId.value;
        currentService = @json($professionalServices).find(s => s.id == currentServiceId);
        
        if (currentService) {
            // Show service level rate table
            document.getElementById('serviceRateTableContainer').style.display = 'block';
            document.getElementById('saveButtonContainer').style.display = 'block';
            
            // Check if service has sub-services
            if (currentService && currentService.sub_services && currentService.sub_services.length > 0) {
                document.getElementById('subServiceRateContainer').style.display = 'block';
                createSubServiceRateTables();
            } else {
                document.getElementById('subServiceRateContainer').style.display = 'none';
            }
            
            // Add initial service rate row
            // fetch used session types for this service (service-level) and then add rows
            (async () => {
                usedSessionTypes = await fetchUsedSessionTypes();
                addServiceRateRow();
            })();
        }
    }
    
    // Service selection handler (removed as no longer needed)
    /*
    document.getElementById('serviceSelect').addEventListener('change', function() {
        currentServiceId = this.value;
        currentService = null;
        
        if (currentServiceId) {
            // Find the selected service
            currentService = @json($professionalServices).find(s => s.id == currentServiceId);
            
            // Show service level rate table
            document.getElementById('serviceRateTableContainer').style.display = 'block';
            document.getElementById('saveButtonContainer').style.display = 'block';
            
            // Clear existing tables
            document.getElementById('serviceRateTableBody').innerHTML = '';
            document.getElementById('subServiceRatesList').innerHTML = '';
            
            // Reset counters
            serviceRateCounter = 0;
            subServiceRateCounters = {};
            
            // Check if service has sub-services
            if (currentService && currentService.sub_services && currentService.sub_services.length > 0) {
                document.getElementById('subServiceRateContainer').style.display = 'block';
                createSubServiceRateTables();
            } else {
                document.getElementById('subServiceRateContainer').style.display = 'none';
            }
            
            // Add initial service rate row
            addServiceRateRow();
            
        } else {
            document.getElementById('serviceRateTableContainer').style.display = 'none';
            document.getElementById('subServiceRateContainer').style.display = 'none';
            document.getElementById('saveButtonContainer').style.display = 'none';
        }
    });
    */
    
    // Create sub-service rate tables
    function createSubServiceRateTables() {
        const container = document.getElementById('subServiceRatesList');
        
        currentService.sub_services.forEach(subService => {
            subServiceRateCounters[subService.id] = 0;
            
            const subServiceDiv = document.createElement('div');
            subServiceDiv.className = 'sub-service-rate-section';
            subServiceDiv.innerHTML = `
                <div class="sub-service-heading">
                    <h5>${subService.name}</h5>
                    <span>Add session plans specific to this sub-service.</span>
                </div>
                <div class="table-shell">
                    <div class="table-responsive">
                        <table class="table table-bordered styled-table">
                            <thead>
                            <tr>
                                <th style="width: 200px;">Select Sub-service</th>
                                <th style="width: 150px;">Session Type</th>
                                <th style="width: 130px;">No of Sessions</th>
                                <th style="width: 150px;">Rate Per Session</th>
                                <th style="width: 120px;">Final Rate</th>
                                <th style="width: 80px;">Action</th>
                            </tr>
                        </thead>
                        <tbody data-subservice-id="${subService.id}">
                            <!-- Sub-service rates will be added here -->
                        </tbody>
                        </table>
                    </div>
                </div>
                <div class="inline-actions">
                    <button type="button" class="btn btn-outline add-subservice-rate-btn" data-subservice-id="${subService.id}" data-subservice-name="${subService.name}">
                        <i class="fas fa-plus"></i> Add New Rate
                    </button>
                </div>
            `;
            
            container.appendChild(subServiceDiv);

            // Add initial sub-service rate row after fetching used session types for that sub-service
            (async () => {
                const usedForSub = await fetchUsedSessionTypes(subService.id);
                usedForSubMap[subService.id] = usedForSub;
                addSubServiceRateRow(subService.id, subService.name, usedForSub);
            })();
        });
        
        // Add event listeners for sub-service add buttons
        document.querySelectorAll('.add-subservice-rate-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                const subServiceId = this.dataset.subserviceId;
                const subServiceName = this.dataset.subserviceName;
                // ensure we have latest used list for this sub-service
                const usedForSub = await fetchUsedSessionTypes(subServiceId);
                usedForSubMap[subServiceId] = usedForSub;
                // check if any remaining session type is available
                const combined = Array.from(new Set([...(usedForSubMap[subServiceId] || []), ...Array.from(document.querySelectorAll(`tbody[data-subservice-id="${subServiceId}"] .session-type`)).map(s=>s.value).filter(Boolean)]));
                const remaining = sessionTypes.filter(t => !combined.includes(t));
                if (remaining.length === 0) {
                    toastr.error('All session types already added for this sub-service.');
                    return;
                }
                addSubServiceRateRow(subServiceId, subServiceName, usedForSub);
            });
        });
    }

    // Fetch already used session types for current service/sub-service scope
    async function fetchUsedSessionTypes(subServiceId = null) {
        try {
            const url = `{{ route('professional.rate.get-session-types') }}`;
            const resp = await fetch(url, { credentials: 'same-origin' });
            if (!resp.ok) return [];
            const data = await resp.json();
            if (data.status === 'success' && Array.isArray(data.rates)) {
                // Filter rates based on service_id and sub_service_id
                const filteredRates = data.rates.filter(rate => {
                    if (subServiceId) {
                        // For sub-service rates, match sub_service_id
                        return rate.sub_service_id == subServiceId;
                    } else {
                        // For service rates, sub_service_id should be null
                        return rate.sub_service_id == null;
                    }
                });
                return filteredRates.map(rate => rate.session_type);
            }
        } catch (err) {
            console.error('Error fetching used session types:', err);
        }
        return [];
    }
    
    // Add service level rate row
    function addServiceRateRow() {
        const tbody = document.getElementById('serviceRateTableBody');
        serviceRateCounter++;
        
        const newRow = document.createElement('tr');
        newRow.dataset.type = 'service';
        newRow.dataset.counter = serviceRateCounter;
        
        newRow.innerHTML = `
            <td data-label="Service">
                <input type="text" class="form-control" value="${currentService.service_name}" readonly style="background-color: #f8f9fa;">
            </td>
            <td data-label="Session Type">
                <select class="form-control session-type" name="service_rates[${serviceRateCounter}][session_type]" >
                    <option value="">Select Session Type</option>
                    ${sessionTypes.map(type => {
                        const disabled = usedSessionTypes.includes(type) ? 'disabled' : '';
                        return `<option value="${type}" ${disabled}>${type}${disabled ? ' - Already Added' : ''}</option>`;
                    }).join('')}
                </select>
            </td>
            <td data-label="No of Sessions">
                <input type="number" class="form-control num-sessions" name="service_rates[${serviceRateCounter}][num_sessions]" value="1" min="1" >
            </td>
            <td data-label="Rate Per Session">
                <input type="number" class="form-control rate-per-session" name="service_rates[${serviceRateCounter}][rate_per_session]" value="0" min="0" step="100" >
            </td>
            <td data-label="Final Rate">
                <input type="number" class="form-control final-rate" name="service_rates[${serviceRateCounter}][final_rate]" readonly style="background-color: #f8f9fa;">
            </td>
            <td data-label="Action">
                <button type="button" class="btn btn-danger btn-sm delete-row" title="Remove rate">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(newRow);
        attachRateCalculationEvents(newRow);
        updateUsedState();
    }
    
    // Add sub-service level rate row
    function addSubServiceRateRow(subServiceId, subServiceName, usedForSub = []) {
        const tbody = document.querySelector(`tbody[data-subservice-id="${subServiceId}"]`);
        subServiceRateCounters[subServiceId]++;
        const counter = subServiceRateCounters[subServiceId];
        
        const newRow = document.createElement('tr');
        newRow.dataset.type = 'subservice';
        newRow.dataset.subserviceId = subServiceId;
        newRow.dataset.counter = counter;
        
        newRow.innerHTML = `
            <td data-label="Sub-service">
                <input type="text" class="form-control" value="${subServiceName}" readonly style="background-color: #f8f9fa;">
            </td>
            <td data-label="Session Type">
                <select class="form-control session-type" name="subservice_rates[${subServiceId}][${counter}][session_type]" >
                    <option value="">Select Session Type</option>
                    ${sessionTypes.map(type => {
                        const disabled = (usedForSub.length ? usedForSub.includes(type) : usedSessionTypes.includes(type)) ? 'disabled' : '';
                        return `<option value="${type}" ${disabled}>${type}${disabled ? ' - Already Added' : ''}</option>`;
                    }).join('')}
                </select>
            </td>
            <td data-label="No of Sessions">
                <input type="number" class="form-control num-sessions" name="subservice_rates[${subServiceId}][${counter}][num_sessions]" value="1" min="1">
            </td>
            <td data-label="Rate Per Session">
                <input type="number" class="form-control rate-per-session" name="subservice_rates[${subServiceId}][${counter}][rate_per_session]" value="0" min="0" step="100">
            </td>
            <td data-label="Final Rate">
                <input type="number" class="form-control final-rate" name="subservice_rates[${subServiceId}][${counter}][final_rate]" readonly style="background-color: #f8f9fa;">
            </td>
            <td data-label="Action">
                <button type="button" class="btn btn-danger btn-sm delete-row" title="Remove rate">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(newRow);
        attachRateCalculationEvents(newRow);
        updateUsedState();
    }

    // Update UI state: disable options already used (DB + current form), and disable Add buttons when none remain
    function updateUsedState() {
        // Service-level
        const serviceSelects = Array.from(document.querySelectorAll('#serviceRateTableBody .session-type'));
        const serviceFormUsed = serviceSelects.map(s => s.value).filter(Boolean);
        const serviceCombined = Array.from(new Set([...(usedSessionTypes || []), ...serviceFormUsed]));

        serviceSelects.forEach(select => {
            const currentVal = select.value;
            Array.from(select.options).forEach(opt => {
                if (!opt.value) return;
                const isUsed = opt.value !== currentVal && serviceCombined.includes(opt.value);
                opt.disabled = isUsed;
                
                // Update the text content to show "Already Added"
                if (isUsed && !opt.textContent.includes(' - Already Added')) {
                    opt.textContent = opt.value + ' - Already Added';
                } else if (!isUsed && opt.textContent.includes(' - Already Added')) {
                    opt.textContent = opt.value;
                }
            });
        });

        // Disable service add button if no remaining
        const serviceRemaining = sessionTypes.filter(t => !serviceCombined.includes(t));
        const addServiceBtn = document.getElementById('addServiceRateBtn');
        if (serviceRemaining.length === 0) {
            addServiceBtn.disabled = true;
        } else {
            addServiceBtn.disabled = false;
        }

        // Sub-service level
        document.querySelectorAll('#subServiceRatesList tbody[data-subservice-id]').forEach(tbody => {
            const subId = tbody.dataset.subserviceId;
            const selects = Array.from(tbody.querySelectorAll('.session-type'));
            const formUsed = selects.map(s => s.value).filter(Boolean);
            const dbUsed = usedForSubMap[subId] || [];
            const combined = Array.from(new Set([...(dbUsed), ...formUsed]));

            selects.forEach(select => {
                const currentVal = select.value;
                Array.from(select.options).forEach(opt => {
                    if (!opt.value) return;
                    const isUsed = opt.value !== currentVal && combined.includes(opt.value);
                    opt.disabled = isUsed;
                    
                    // Update the text content to show "Already Added"
                    if (isUsed && !opt.textContent.includes(' - Already Added')) {
                        opt.textContent = opt.value + ' - Already Added';
                    } else if (!isUsed && opt.textContent.includes(' - Already Added')) {
                        opt.textContent = opt.value;
                    }
                });
            });

            // disable sub-service add button if none remaining
            const remaining = sessionTypes.filter(t => !combined.includes(t));
            const btn = document.querySelector(`.add-subservice-rate-btn[data-subservice-id="${subId}"]`);
            if (btn) btn.disabled = (remaining.length === 0);
        });
    }

    // When any session-type select changes, recompute used state
    document.addEventListener('change', function(e) {
        if (e.target && e.target.classList && e.target.classList.contains('session-type')) {
            updateUsedState();
        }
    });
    
    // Attach calculation events to a row
    function attachRateCalculationEvents(row) {
        const numSessionsInput = row.querySelector('.num-sessions');
        const ratePerSessionInput = row.querySelector('.rate-per-session');
        const finalRateInput = row.querySelector('.final-rate');
        
        function calculateFinalRate() {
            const numSessions = parseInt(numSessionsInput.value) || 0;
            const ratePerSession = parseInt(ratePerSessionInput.value) || 0;
            finalRateInput.value = numSessions * ratePerSession;
        }
        
        numSessionsInput.addEventListener('input', calculateFinalRate);
        ratePerSessionInput.addEventListener('input', calculateFinalRate);
        
        // Initial calculation
        calculateFinalRate();
    }
    
    // Add service rate button event listener
    document.getElementById('addServiceRateBtn').addEventListener('click', function() {
        addServiceRateRow();
    });
    
    // Row deletion event listener
    document.addEventListener('click', function(e) {
        if (e.target && (e.target.classList.contains('delete-row') || e.target.closest('.delete-row'))) {
            const rowToDelete = e.target.closest('tr');
            
            // Check if this is the last row in service rates
            if (rowToDelete.dataset.type === 'service') {
                const serviceRows = document.querySelectorAll('#serviceRateTableBody tr');
                if (serviceRows.length <= 1) {
                    toastr.error('At least one service rate is required.');
                    return;
                }
            }
            
            // Check if this is the last row in a sub-service
            if (rowToDelete.dataset.type === 'subservice') {
                const subServiceId = rowToDelete.dataset.subserviceId;
                const subServiceRows = document.querySelectorAll(`tbody[data-subservice-id="${subServiceId}"] tr`);
                if (subServiceRows.length <= 1) {
                    toastr.error('At least one rate is required for each sub-service.');
                    return;
                }
            }
            
            rowToDelete.remove();
            updateUsedState();
        }
    });
    
    // Form submission
    document.getElementById('rateForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!currentServiceId) {
            toastr.error('Please select a service.');
            return;
        }
        
        // Collect form data and build rateData array expected by backend
        const formData = new FormData(this);
        formData.append('professional_id', "{{ Auth::guard('professional')->id() }}");
        formData.append('professional_service_id', currentServiceId);

        // Build rateData from all rows (service-level and sub-service-level)
        // Only include rows that have session_type selected
        const rateData = [];
        document.querySelectorAll('#serviceRateTableBody tr').forEach(row => {
            const sessionType = row.querySelector('.session-type').value;
            // Only add if session type is selected
            if (sessionType) {
                rateData.push({
                    session_type: sessionType,
                    num_sessions: row.querySelector('.num-sessions').value,
                    rate_per_session: row.querySelector('.rate-per-session').value,
                    final_rate: row.querySelector('.final-rate').value,
                    sub_service_id: null
                });
            }
        });

        document.querySelectorAll('#subServiceRatesList tbody').forEach(tbody => {
            const subServiceId = tbody.dataset.subserviceId;
            tbody.querySelectorAll('tr').forEach(row => {
                const sessionType = row.querySelector('.session-type').value;
                // Only add if session type is selected
                if (sessionType) {
                    rateData.push({
                        session_type: sessionType,
                        num_sessions: row.querySelector('.num-sessions').value,
                        rate_per_session: row.querySelector('.rate-per-session').value,
                        final_rate: row.querySelector('.final-rate').value,
                        sub_service_id: subServiceId
                    });
                }
            });
        });
        
        // Validate that we have at least one complete rate after filtering
        if (rateData.length === 0) {
            toastr.error('Please fill in at least one complete rate with session type selected.');
            return;
        }
        
        // NOW check what complete rates were added and show confirmation alerts
        const hasSubServicesAvailable = currentService && currentService.sub_services && currentService.sub_services.length > 0;
        const hasCompleteMainServiceRates = rateData.some(r => r.sub_service_id === null);
        const hasCompleteSubServiceRates = rateData.some(r => r.sub_service_id !== null);
        
        // Show confirmation alerts for skipped sections (only if sub-services are available)
        if (hasSubServicesAvailable && hasCompleteMainServiceRates && !hasCompleteSubServiceRates) {
            if (!confirm('You skipped the sub-service add rate. Do you want to continue saving only main service rates?')) {
                return;
            }
        }
        
        if (hasSubServicesAvailable && !hasCompleteMainServiceRates && hasCompleteSubServiceRates) {
            if (!confirm('You skipped the main service add rate. Do you want to continue saving only sub-service rates?')) {
                return;
            }
        }

        // Check for duplicate session types with same sub-service combination
        const combinations = rateData.map(r => {
            return r.session_type.toLowerCase() + '|' + (r.sub_service_id || 'null');
        });
        const duplicates = combinations.filter((item, index) => combinations.indexOf(item) !== index);
        
        if (duplicates.length > 0) {
            toastr.error('Duplicate session types with the same sub-service are not allowed. Please ensure each combination is unique.');
            return;
        }

        // Append rateData entries to FormData as rateData[0][field]
        rateData.forEach((r, idx) => {
            formData.append(`rateData[${idx}][session_type]`, r.session_type);
            formData.append(`rateData[${idx}][num_sessions]`, r.num_sessions);
            formData.append(`rateData[${idx}][rate_per_session]`, r.rate_per_session);
            formData.append(`rateData[${idx}][final_rate]`, r.final_rate);
            if (r.sub_service_id !== null) {
                formData.append(`rateData[${idx}][sub_service_id]`, r.sub_service_id);
            }
        });
        
        // Show loading indicator
        const submitBtn = document.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        
        // AJAX request
        $.ajax({
            url: "{{ route('professional.rate.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    setTimeout(() => {
                        window.location.href = "{{ route('professional.rate.index') }}";
                    }, 1500);
                } else {
                    toastr.error(response.message || "Something went wrong");
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            },
            error: function(xhr) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
                
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    if (xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]);
                        });
                    }
                } else {
                    toastr.error(xhr.responseJSON?.message || "An unexpected error occurred");
                }
            }
        });
    });
});
</script>
@endsection
