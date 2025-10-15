@extends('professional.layout.layout')

@section('style')
<!-- Add your custom styles here -->
@endsection

@section('content')
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-title">
                <h3>Add Rate</h3>
            </div>
            <ul class="breadcrumb">
                <li>Home</li>
                <li class="active">Add Rate</li>
            </ul>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <form id="rateForm">
                @csrf
                
                <!-- Service Information (Auto-selected) -->
                @if($professionalServices && count($professionalServices) > 0)
                    @php $currentService = $professionalServices[0]; @endphp
                    <div class="form-row" style="margin-bottom: 20px;">
                        <div style="width: 100%; max-width: 400px;">
                            <label>Your Service</label>
                            <input type="text" class="form-control" value="{{ $currentService->service_name }}" readonly style="background-color: #f8f9fa;">
                            <input type="hidden" id="serviceId" value="{{ $currentService->id }}">
                            <small class="text-muted">Setting rates for your professional service.</small>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <strong>No Service Found!</strong> Please create a service first before setting rates.
                        <a href="{{ route('professional.service.create') }}" class="btn btn-primary btn-sm ml-2">Create Service</a>
                    </div>
                @endif
                
                <!-- Service Level Rates Table -->
                <div id="serviceRateTableContainer" style="display: none; margin-bottom: 30px;">
                    <h4 style="margin-bottom: 15px; color: #333;">Service Level Rates</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="width: 200px;">Select Service</th>
                                    <th style="width: 150px;">Session Type</th>
                                    <th style="width: 130px;">No of Sessions</th>
                                    <th style="width: 150px;">Rate Per Session</th>
                                    <th style="width: 120px;">Final Rate</th>
                                    <th style="width: 80px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="serviceRateTableBody">
                                <!-- Service level rates will be added here -->
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="form-actions" style="margin-bottom: 20px;">
                        <button type="button" class="btn btn-outline" id="addServiceRateBtn">
                            <i class="fas fa-plus"></i> Add New Rate
                        </button>
                    </div>
                </div>

                <!-- Sub-Service Level Rates -->
                <div id="subServiceRateContainer" style="display: none;">
                    <h4 style="margin-bottom: 15px; color: #333;">Sub-Service Level Rates</h4>
                    <div id="subServiceRatesList">
                        <!-- Sub-service rate tables will be dynamically added here -->
                    </div>
                </div>

                <!-- Save Button -->
                <div class="form-actions" id="saveButtonContainer" style="display: none; margin-top: 30px;">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Save Rates
                    </button>
                </div>
            </form>
        </div>
    </div>
    
<style>
    /* Rate form specific styles */
    .rate-form-container {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .table-bordered {
        border: 2px solid #dee2e6;
    }
    
    .table-bordered th {
        border: 1px solid #dee2e6;
        background-color: #f8f9fa;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
    }
    
    .table-bordered td {
        border: 1px solid #dee2e6;
        vertical-align: middle;
    }
    
    .sub-service-rate-section {
        border: 1px solid #e3e6f0;
        border-radius: 8px;
        padding: 15px;
        background-color: #f8f9fa;
    }
    
    .form-control[readonly] {
        background-color: #f8f9fa !important;
        opacity: 1;
    }
    
    .btn-outline {
        background-color: #fff;
        border: 2px solid #007bff;
        color: #007bff;
        font-weight: 500;
    }
    
    .btn-outline:hover {
        background-color: #007bff;
        color: #fff;
    }
    
    .form-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    
    h4 {
        color: #495057;
        font-weight: 600;
        border-bottom: 2px solid #007bff;
        padding-bottom: 8px;
        margin-bottom: 20px;
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
        .table-responsive {
            overflow-x: auto;
            max-width: 100%;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Ensure the table takes full width of container */
        .table {
            width: 100%;
            table-layout: auto;
            min-width: 800px; /* Minimum width to ensure proper display */
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
        
        /* Make form responsive */
        .form-container {
            padding: 10px;
        }
        
        .sub-service-rate-section {
            margin-bottom: 20px;
            padding: 10px;
        }
        
        .form-actions {
            flex-direction: column;
            gap: 10px;
            align-items: stretch;
        }
        
        .btn {
            width: 100%;
            margin-bottom: 5px;
        }
    }
</style>
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
            subServiceDiv.style.marginBottom = '30px';
            
            subServiceDiv.innerHTML = `
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead style="background-color: #e9ecef;">
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
                <div class="form-actions" style="margin-bottom: 20px;">
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
            const params = new URLSearchParams();
            params.append('professional_service_id', currentServiceId);
            if (subServiceId) params.append('sub_service_id', subServiceId);
            const url = `{{ route('professional.rate.get-session-types') }}?` + params.toString();
            const resp = await fetch(url, { credentials: 'same-origin' });
            if (!resp.ok) return [];
            const data = await resp.json();
            if (data.status === 'success' && Array.isArray(data.session_types)) {
                return data.session_types;
            }
        } catch (err) {
            // ignore errors
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
            <td>
                <input type="text" class="form-control" value="${currentService.service_name}" readonly style="background-color: #f8f9fa;">
            </td>
            <td>
                <select class="form-control session-type" name="service_rates[${serviceRateCounter}][session_type]" required>
                    <option value="">Select Session Type</option>
                    ${sessionTypes.map(type => {
                        const disabled = usedSessionTypes.includes(type) ? 'disabled' : '';
                        return `<option value="${type}" ${disabled}>${type}${disabled ? ' (used)' : ''}</option>`;
                    }).join('')}
                </select>
            </td>
            <td>
                <input type="number" class="form-control num-sessions" name="service_rates[${serviceRateCounter}][num_sessions]" value="1" min="1" required>
            </td>
            <td>
                <input type="number" class="form-control rate-per-session" name="service_rates[${serviceRateCounter}][rate_per_session]" value="0" min="0" step="100" required>
            </td>
            <td>
                <input type="number" class="form-control final-rate" name="service_rates[${serviceRateCounter}][final_rate]" readonly style="background-color: #f8f9fa;">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm delete-row">
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
            <td>
                <input type="text" class="form-control" value="${subServiceName}" readonly style="background-color: #f8f9fa;">
            </td>
            <td>
                <select class="form-control session-type" name="subservice_rates[${subServiceId}][${counter}][session_type]" required>
                    <option value="">Select Session Type</option>
                    ${sessionTypes.map(type => {
                        const disabled = (usedForSub.length ? usedForSub.includes(type) : usedSessionTypes.includes(type)) ? 'disabled' : '';
                        return `<option value="${type}" ${disabled}>${type}${disabled ? ' (used)' : ''}</option>`;
                    }).join('')}
                </select>
            </td>
            <td>
                <input type="number" class="form-control num-sessions" name="subservice_rates[${subServiceId}][${counter}][num_sessions]" value="1" min="1" required>
            </td>
            <td>
                <input type="number" class="form-control rate-per-session" name="subservice_rates[${subServiceId}][${counter}][rate_per_session]" value="0" min="0" step="100" required>
            </td>
            <td>
                <input type="number" class="form-control final-rate" name="subservice_rates[${subServiceId}][${counter}][final_rate]" readonly style="background-color: #f8f9fa;">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm delete-row">
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
                if (opt.value !== currentVal && serviceCombined.includes(opt.value)) {
                    opt.disabled = true;
                } else {
                    opt.disabled = false;
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
                    if (opt.value !== currentVal && combined.includes(opt.value)) {
                        opt.disabled = true;
                    } else {
                        opt.disabled = false;
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
        }
    });
    
    // Form submission
    document.getElementById('rateForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!currentServiceId) {
            toastr.error('Please select a service.');
            return;
        }
        
        // Validate that we have at least one service rate
        const serviceRows = document.querySelectorAll('#serviceRateTableBody tr');
        if (serviceRows.length === 0) {
            toastr.error('Please add at least one service rate.');
            return;
        }
        
        // Validate all inputs
        let isValid = true;
        const allRows = document.querySelectorAll('tbody tr');
        
        allRows.forEach(row => {
            const sessionType = row.querySelector('.session-type').value;
            const numSessions = row.querySelector('.num-sessions').value;
            const ratePerSession = row.querySelector('.rate-per-session').value;
            
            if (!sessionType || !numSessions || !ratePerSession) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            toastr.error('Please fill in all required fields.');
            return;
        }
        
        // Collect form data and build rateData array expected by backend
        const formData = new FormData(this);
        formData.append('professional_id', "{{ Auth::guard('professional')->id() }}");
        formData.append('professional_service_id', currentServiceId);

        // Build rateData from all rows (service-level and sub-service-level)
        const rateData = [];
        document.querySelectorAll('#serviceRateTableBody tr').forEach(row => {
            rateData.push({
                session_type: row.querySelector('.session-type').value,
                num_sessions: row.querySelector('.num-sessions').value,
                rate_per_session: row.querySelector('.rate-per-session').value,
                final_rate: row.querySelector('.final-rate').value,
                sub_service_id: null
            });
        });

        document.querySelectorAll('#subServiceRatesList tbody').forEach(tbody => {
            const subServiceId = tbody.dataset.subserviceId;
            tbody.querySelectorAll('tr').forEach(row => {
                rateData.push({
                    session_type: row.querySelector('.session-type').value,
                    num_sessions: row.querySelector('.num-sessions').value,
                    rate_per_session: row.querySelector('.rate-per-session').value,
                    final_rate: row.querySelector('.final-rate').value,
                    sub_service_id: subServiceId
                });
            });
        });

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
