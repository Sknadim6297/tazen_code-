@php
    $currentMonth = now()->format('n');
    $months = [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
    ];
@endphp

@extends('professional.layout.layout')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
/* Availability form specific styles */
.availability-form-container {
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

.sub-service-availability-section {
    border: 1px solid #e3e6f0;
    border-radius: 8px;
    padding: 15px;
    background-color: #f8f9fa;
    margin-bottom: 20px;
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

.time-slot {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.time-input-group {
    display: flex;
    align-items: center;
    gap: 5px;
}

.remove-slot-btn {
    background: transparent;
    border: none;
    color: red;
    cursor: pointer;
}

.weekday-group {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 10px;
}

.weekday-label {
    display: flex;
    align-items: center;
    gap: 5px;
}

.time-slots-container {
    background: #f8f9fa;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 10px;
}

.month-selection {
    background: #f8f9fa;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 10px;
}

.month-checkbox-group {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 10px;
    margin-top: 10px;
}

.month-label {
    display: flex;
    align-items: center;
    gap: 5px;
}

@media screen and (max-width: 767px) {
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
        min-width: 1000px; /* Minimum width to ensure proper display */
    }
    
    /* Ensure content wrapper doesn't cause horizontal scroll */
    .content-wrapper {
        overflow-x: hidden;
        width: 100%;
        max-width: 100vw;
        padding: 20px 10px;
    }
    
    /* Make form responsive */
    .form-container {
        padding: 10px;
    }
    
    .sub-service-availability-section {
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
    
    .weekday-group {
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    }
    
    .month-checkbox-group {
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    }
    
    .time-slot {
        flex-direction: column;
        align-items: stretch;
        gap: 5px;
    }
    
    .time-input-group {
        flex-direction: row;
        justify-content: space-between;
    }
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3>Add Availability</h3>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Set Your Availability</h4>
        </div>
        <div class="card-body">
            <form id="availabilityForm">
                @csrf
                
                <!-- Service Information (Auto-selected) -->
                @if($professionalServices && count($professionalServices) > 0)
                    @php $currentService = $professionalServices[0]; @endphp
                    <div class="form-row" style="margin-bottom: 20px;">
                        <div style="width: 100%; max-width: 400px;">
                            <label>Your Service</label>
                            <input type="text" class="form-control" value="{{ $currentService->service_name }}" readonly style="background-color: #f8f9fa;">
                            <input type="hidden" id="serviceId" name="professional_service_id" value="{{ $currentService->id }}">
                            <small class="text-muted">Setting availability for your professional service.</small>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <strong>No Service Found!</strong> Please create a service first before setting availability.
                        <a href="{{ route('professional.service.create') }}" class="btn btn-primary btn-sm ml-2">Create Service</a>
                    </div>
                @endif
                
                <!-- Service Level Availability Table -->
                <div id="serviceAvailabilityContainer" style="display: none; margin-bottom: 30px;">
                    <h4 style="margin-bottom: 15px; color: #333;">Service Level Availability</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="width: 200px;">Select Service</th>
                                    <th style="width: 150px;">Select Month(s)</th>
                                    <th style="width: 130px;">Week Days</th>
                                    <th style="width: 150px;">Time Slots</th>
                                    <th style="width: 120px;">Session Duration</th>
                                    <th style="width: 80px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="serviceAvailabilityBody">
                                <!-- Service level availability will be added here -->
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="form-actions" style="margin-bottom: 20px;">
                        <button type="button" class="btn btn-outline" id="addServiceAvailabilityBtn">
                            <i class="fas fa-plus"></i> Add New Availability
                        </button>
                    </div>
                </div>

                <!-- Sub-Service Level Availability -->
                <div id="subServiceAvailabilityContainer" style="display: none;">
                    <h4 style="margin-bottom: 15px; color: #333;">Sub-Service Level Availability</h4>
                    <div id="subServiceAvailabilityList">
                        <!-- Sub-service availability tables will be dynamically added here -->
                    </div>
                </div>

                <!-- Save Button -->
                <div class="form-actions" id="saveButtonContainer" style="display: none; margin-top: 30px;">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Save Availability
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentServiceId = null;
    let currentService = null;
    let serviceAvailabilityCounter = 0;
    let subServiceAvailabilityCounters = {};
    
    const months = @json($months);
    const currentMonth = @json($currentMonth);
    
    // Auto-initialize with the professional's service
    const serviceId = document.getElementById('serviceId');
    if (serviceId && serviceId.value) {
        currentServiceId = serviceId.value;
        currentService = @json($professionalServices).find(s => s.id == currentServiceId);
        
        if (currentService) {
            // Show service level availability table
            document.getElementById('serviceAvailabilityContainer').style.display = 'block';
            document.getElementById('saveButtonContainer').style.display = 'block';
            
            // Check if service has sub-services
            if (currentService && currentService.sub_services && currentService.sub_services.length > 0) {
                document.getElementById('subServiceAvailabilityContainer').style.display = 'block';
                createSubServiceAvailabilityTables();
            } else {
                document.getElementById('subServiceAvailabilityContainer').style.display = 'none';
            }
            
            // Add initial service availability row
            addServiceAvailabilityRow();
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
            
            // Show service level availability table
            document.getElementById('serviceAvailabilityContainer').style.display = 'block';
            document.getElementById('saveButtonContainer').style.display = 'block';
            
            // Clear existing tables
            document.getElementById('serviceAvailabilityBody').innerHTML = '';
            document.getElementById('subServiceAvailabilityList').innerHTML = '';
            
            // Reset counters
            serviceAvailabilityCounter = 0;
            subServiceAvailabilityCounters = {};
            
            // Check if service has sub-services
            if (currentService && currentService.sub_services && currentService.sub_services.length > 0) {
                document.getElementById('subServiceAvailabilityContainer').style.display = 'block';
                createSubServiceAvailabilityTables();
            } else {
                document.getElementById('subServiceAvailabilityContainer').style.display = 'none';
            }
            
            // Add initial service availability row
            addServiceAvailabilityRow();
            
        } else {
            document.getElementById('serviceAvailabilityContainer').style.display = 'none';
            document.getElementById('subServiceAvailabilityContainer').style.display = 'none';
            document.getElementById('saveButtonContainer').style.display = 'none';
        }
    });
    */
    
    // Create sub-service availability tables
    function createSubServiceAvailabilityTables() {
        const container = document.getElementById('subServiceAvailabilityList');
        
        currentService.sub_services.forEach(subService => {
            subServiceAvailabilityCounters[subService.id] = 0;
            
            const subServiceDiv = document.createElement('div');
            subServiceDiv.className = 'sub-service-availability-section';
            
            subServiceDiv.innerHTML = `
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead style="background-color: #e9ecef;">
                            <tr>
                                <th style="width: 200px;">Select Sub-service</th>
                                <th style="width: 150px;">Select Month(s)</th>
                                <th style="width: 130px;">Week Days</th>
                                <th style="width: 150px;">Time Slots</th>
                                <th style="width: 120px;">Session Duration</th>
                                <th style="width: 80px;">Action</th>
                            </tr>
                        </thead>
                        <tbody data-subservice-id="${subService.id}">
                            <!-- Sub-service availability will be added here -->
                        </tbody>
                    </table>
                </div>
                <div class="form-actions" style="margin-bottom: 20px;">
                    <button type="button" class="btn btn-outline add-subservice-availability-btn" data-subservice-id="${subService.id}" data-subservice-name="${subService.name}">
                        <i class="fas fa-plus"></i> Add New Availability
                    </button>
                </div>
            `;
            
            container.appendChild(subServiceDiv);
            
            // Add initial sub-service availability row
            addSubServiceAvailabilityRow(subService.id, subService.name);
        });
        
        // Add event listeners for sub-service add buttons
        document.querySelectorAll('.add-subservice-availability-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const subServiceId = this.dataset.subserviceId;
                const subServiceName = this.dataset.subserviceName;
                addSubServiceAvailabilityRow(subServiceId, subServiceName);
            });
        });
    }
    
    // Create month selection dropdown
    function createMonthSelection(prefix, counter) {
        let monthOptions = '<option value="">Select Month(s)</option>';
        monthOptions += '<option value="all">All Available Months</option>';
        
        Object.entries(months).forEach(([num, name]) => {
            if (parseInt(num) >= currentMonth) {
                monthOptions += `<option value="${num}">${name}</option>`;
            }
        });
        
        return `
            <select class="form-control month-select" name="${prefix}[${counter}][month_type]" onchange="toggleMonthSelection(this)">
                ${monthOptions}
            </select>
            <div class="month-selection" style="display: none;">
                <div class="month-checkbox-group">
                    ${Object.entries(months).map(([num, name]) => {
                        if (parseInt(num) >= currentMonth) {
                            return `
                                <label class="month-label">
                                    <input type="checkbox" name="${prefix}[${counter}][months][]" value="${num}"> ${name}
                                </label>
                            `;
                        }
                        return '';
                    }).join('')}
                </div>
            </div>
        `;
    }
    
    // Create weekdays selection
    function createWeekdaysSelection(prefix, counter) {
        const weekdays = {
            'mon': 'Monday', 'tue': 'Tuesday', 'wed': 'Wednesday', 'thu': 'Thursday',
            'fri': 'Friday', 'sat': 'Saturday', 'sun': 'Sunday'
        };
        
        return `
            <div class="weekday-group">
                ${Object.entries(weekdays).map(([dayVal, dayName]) => `
                    <label class="weekday-label">
                        <input type="checkbox" name="${prefix}[${counter}][weekdays][]" value="${dayVal}"> ${dayName}
                    </label>
                `).join('')}
            </div>
        `;
    }
    
    // Create time slots selection
    function createTimeSlotsSelection(prefix, counter) {
        return `
            <div class="time-slots-container">
                <div class="time-slot">
                    <label>From</label>
                    <div class="time-input-group">
                        <input type="text" class="form-control timepicker" name="${prefix}[${counter}][start_time][]" required placeholder="Start Time">
                    </div>
                    <label>To</label>
                    <div class="time-input-group">
                        <input type="text" class="form-control timepicker" name="${prefix}[${counter}][end_time][]" required placeholder="End Time" readonly>
                    </div>
                    <button type="button" class="btn btn-sm btn-success add-time-slot" data-prefix="${prefix}" data-counter="${counter}">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        `;
    }
    
    // Create session duration selection
    function createSessionDurationSelection(prefix, counter) {
        return `
            <select class="form-control session-duration" name="${prefix}[${counter}][session_duration]" required onchange="updateTimePickers(this)">
                <option value="30">30 minutes</option>
                <option value="45">45 minutes</option>
                <option value="60" selected>60 minutes</option>
                <option value="90">90 minutes</option>
                <option value="120">2 hours</option>
            </select>
        `;
    }
    
    // Add service level availability row
    function addServiceAvailabilityRow() {
        const tbody = document.getElementById('serviceAvailabilityBody');
        serviceAvailabilityCounter++;
        
        const newRow = document.createElement('tr');
        newRow.dataset.type = 'service';
        newRow.dataset.counter = serviceAvailabilityCounter;
        
        newRow.innerHTML = `
            <td>
                <input type="text" class="form-control" value="${currentService.service_name}" readonly style="background-color: #f8f9fa;">
            </td>
            <td>${createMonthSelection('service_availability', serviceAvailabilityCounter)}</td>
            <td>${createWeekdaysSelection('service_availability', serviceAvailabilityCounter)}</td>
            <td>${createTimeSlotsSelection('service_availability', serviceAvailabilityCounter)}</td>
            <td>${createSessionDurationSelection('service_availability', serviceAvailabilityCounter)}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm delete-row">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(newRow);
        initializeRowEventHandlers(newRow);
    }
    
    // Add sub-service level availability row
    function addSubServiceAvailabilityRow(subServiceId, subServiceName) {
        const tbody = document.querySelector(`tbody[data-subservice-id="${subServiceId}"]`);
        subServiceAvailabilityCounters[subServiceId]++;
        const counter = subServiceAvailabilityCounters[subServiceId];
        
        const newRow = document.createElement('tr');
        newRow.dataset.type = 'subservice';
        newRow.dataset.subserviceId = subServiceId;
        newRow.dataset.counter = counter;
        
        newRow.innerHTML = `
            <td>
                <input type="text" class="form-control" value="${subServiceName}" readonly style="background-color: #f8f9fa;">
            </td>
            <td>${createMonthSelection(`subservice_availability[${subServiceId}]`, counter)}</td>
            <td>${createWeekdaysSelection(`subservice_availability[${subServiceId}]`, counter)}</td>
            <td>${createTimeSlotsSelection(`subservice_availability[${subServiceId}]`, counter)}</td>
            <td>${createSessionDurationSelection(`subservice_availability[${subServiceId}]`, counter)}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm delete-row">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(newRow);
        initializeRowEventHandlers(newRow);
    }
    
    // Initialize event handlers for a row
    function initializeRowEventHandlers(row) {
        // Initialize time pickers
        initializeTimePickers(row);
        
        // Add time slot handler
        row.querySelector('.add-time-slot').addEventListener('click', function() {
            const timeSlotsContainer = this.closest('.time-slots-container');
            const prefix = this.dataset.prefix;
            const counter = this.dataset.counter;
            
            const newTimeSlot = document.createElement('div');
            newTimeSlot.className = 'time-slot';
            newTimeSlot.innerHTML = `
                <label>From</label>
                <div class="time-input-group">
                    <input type="text" class="form-control timepicker" name="${prefix}[${counter}][start_time][]" required placeholder="Start Time">
                </div>
                <label>To</label>
                <div class="time-input-group">
                    <input type="text" class="form-control timepicker" name="${prefix}[${counter}][end_time][]" required placeholder="End Time" readonly>
                </div>
                <button type="button" class="btn btn-sm btn-danger remove-time-slot">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            
            timeSlotsContainer.appendChild(newTimeSlot);
            initializeTimePickers(newTimeSlot);
            
            // Add remove handler
            newTimeSlot.querySelector('.remove-time-slot').addEventListener('click', function() {
                newTimeSlot.remove();
            });
        });
    }
    
    // Initialize time pickers for a container
    function initializeTimePickers(container) {
        const sessionDurationSelect = container.querySelector('.session-duration');
        const duration = sessionDurationSelect ? parseInt(sessionDurationSelect.value) : 60;
        
        container.querySelectorAll('input[name*="[start_time]"]').forEach(el => {
            if (!el._flatpickr) {
                flatpickr(el, {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "h:i K",
                    time_24hr: false,
                    minuteIncrement: duration,
                    disableMobile: true,
                    onChange: function(selectedDates, dateStr, instance) {
                        if (dateStr) {
                            const timeSlot = instance.element.closest('.time-slot');
                            const endTimeInput = timeSlot.querySelector('input[name*="[end_time]"]');
                            
                            const startTime = new Date(`1/1/2023 ${dateStr}`);
                            const endTime = new Date(startTime.getTime() + (duration * 60 * 1000));
                            
                            const hours = endTime.getHours();
                            const minutes = endTime.getMinutes();
                            const ampm = hours >= 12 ? 'PM' : 'AM';
                            const formattedHours = hours % 12 || 12;
                            const formattedMinutes = minutes.toString().padStart(2, '0');
                            const formattedTime = `${formattedHours}:${formattedMinutes} ${ampm}`;
                            
                            if (endTimeInput._flatpickr) {
                                endTimeInput._flatpickr.setDate(formattedTime);
                            } else {
                                endTimeInput.value = formattedTime;
                            }
                        }
                    }
                });
            }
        });
        
        container.querySelectorAll('input[name*="[end_time]"]').forEach(el => {
            if (!el._flatpickr) {
                flatpickr(el, {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "h:i K",
                    time_24hr: false,
                    minuteIncrement: duration,
                    disableMobile: true,
                    allowInput: false,
                    clickOpens: false
                });
            }
        });
    }
    
    // Add service availability button event listener
    document.getElementById('addServiceAvailabilityBtn').addEventListener('click', function() {
        addServiceAvailabilityRow();
    });
    
    // Global functions for dropdown handlers
    window.toggleMonthSelection = function(selectElement) {
        const monthSelection = selectElement.nextElementSibling;
        if (selectElement.value === 'all') {
            monthSelection.style.display = 'block';
        } else {
            monthSelection.style.display = 'none';
            // Clear all checkboxes
            monthSelection.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.checked = false;
            });
        }
    };
    
    window.updateTimePickers = function(selectElement) {
        const row = selectElement.closest('tr');
        const duration = parseInt(selectElement.value);
        
        // Destroy existing pickers and reinitialize
        row.querySelectorAll('.timepicker').forEach(el => {
            if (el._flatpickr) {
                el._flatpickr.destroy();
            }
        });
        
        initializeTimePickers(row);
    };
    
    // Row deletion event listener
    document.addEventListener('click', function(e) {
        if (e.target && (e.target.classList.contains('delete-row') || e.target.closest('.delete-row'))) {
            const rowToDelete = e.target.closest('tr');
            
            // Check if this is the last row in service availability
            if (rowToDelete.dataset.type === 'service') {
                const serviceRows = document.querySelectorAll('#serviceAvailabilityBody tr');
                if (serviceRows.length <= 1) {
                    toastr.error('At least one service availability is required.');
                    return;
                }
            }
            
            // Check if this is the last row in a sub-service
            if (rowToDelete.dataset.type === 'subservice') {
                const subServiceId = rowToDelete.dataset.subserviceId;
                const subServiceRows = document.querySelectorAll(`tbody[data-subservice-id="${subServiceId}"] tr`);
                if (subServiceRows.length <= 1) {
                    toastr.error('At least one availability is required for each sub-service.');
                    return;
                }
            }
            
            rowToDelete.remove();
        }
    });
    
    // Form submission
    document.getElementById('availabilityForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!currentServiceId) {
            toastr.error('Please select a service.');
            return;
        }
        
        // Validate that we have at least one service availability
        const serviceRows = document.querySelectorAll('#serviceAvailabilityBody tr');
        if (serviceRows.length === 0) {
            toastr.error('Please add at least one service availability.');
            return;
        }
        
        // Validate all inputs
        let isValid = true;
        const allRows = document.querySelectorAll('tbody tr');
        
        allRows.forEach(row => {
            // Check month selection
            const monthSelect = row.querySelector('.month-select');
            if (!monthSelect.value) {
                isValid = false;
                toastr.error('Please select month(s) for all availability entries.');
                return;
            }
            
            // Check if "all" is selected but no specific months are checked
            if (monthSelect.value === 'all') {
                const checkedMonths = row.querySelectorAll('input[name*="[months]"]:checked');
                if (checkedMonths.length === 0) {
                    isValid = false;
                    toastr.error('Please select specific months when "All Available Months" is selected.');
                    return;
                }
            }
            
            // Check weekdays
            const checkedWeekdays = row.querySelectorAll('input[name*="[weekdays]"]:checked');
            if (checkedWeekdays.length === 0) {
                isValid = false;
                toastr.error('Please select at least one weekday for all availability entries.');
                return;
            }
            
            // Check time slots
            const startTimes = row.querySelectorAll('input[name*="[start_time]"]');
            const endTimes = row.querySelectorAll('input[name*="[end_time]"]');
            
            if (startTimes.length === 0) {
                isValid = false;
                toastr.error('Please add at least one time slot for all availability entries.');
                return;
            }
            
            for (let i = 0; i < startTimes.length; i++) {
                if (!startTimes[i].value || !endTimes[i].value) {
                    isValid = false;
                    toastr.error('Please fill all time slots.');
                    return;
                }
            }
        });
        
        if (!isValid) {
            return;
        }
        
        // We'll build per-row requests because the controller expects top-level fields: month, session_duration, weekdays, start_time[], end_time[]
        const token = document.querySelector('input[name="_token"]').value;
        const submitBtn = document.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

        // Helper to send a single availability payload
        function sendAvailabilityPayload(payload) {
            return new Promise((resolve, reject) => {
                const fd = new FormData();
                fd.append('_token', token);
                fd.append('professional_id', "{{ Auth::guard('professional')->id() }}");
                fd.append('professional_service_id', payload.professional_service_id);
                if (payload.sub_service_id) fd.append('sub_service_id', payload.sub_service_id);
                fd.append('month', payload.month);
                fd.append('session_duration', payload.session_duration);
                payload.weekdays.forEach(w => fd.append('weekdays[]', w));
                payload.start_time.forEach(s => fd.append('start_time[]', s));
                payload.end_time.forEach(e => fd.append('end_time[]', e));

                $.ajax({
                    url: "{{ route('professional.availability.store') }}",
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(res) { resolve(res); },
                    error: function(xhr) { reject(xhr); }
                });
            });
        }

        // Build payloads from each row (service-level and sub-service-level)
        const payloads = [];

        // Service-level rows
        document.querySelectorAll('#serviceAvailabilityBody tr').forEach(row => {
            const prefix = `service_availability[${row.dataset.counter}]`;
            const monthSelect = row.querySelector('.month-select');
            const monthType = monthSelect ? monthSelect.value : '';
            let monthsToSend = [];
            if (monthType === 'all') {
                row.querySelectorAll(`input[name*="[months][]"]:checked`).forEach(cb => monthsToSend.push(cb.value));
            } else if (monthType) {
                monthsToSend.push(monthType);
            }
            if (monthsToSend.length === 0) {
                // already validated earlier, but double-check
                return;
            }

            const weekdays = [];
            row.querySelectorAll(`input[name*="[weekdays][]"]:checked`).forEach(cb => weekdays.push(cb.value));

            const sessionDuration = row.querySelector('.session-duration').value;

            // collect start/end times for this row
            const startTimes = Array.from(row.querySelectorAll('input[name*="[start_time]"]')).map(i => i.value).filter(Boolean);
            const endTimes = Array.from(row.querySelectorAll('input[name*="[end_time]"]')).map(i => i.value).filter(Boolean);

            monthsToSend.forEach(m => {
                payloads.push({
                    professional_service_id: currentServiceId,
                    sub_service_id: null,
                    month: m,
                    session_duration: sessionDuration,
                    weekdays: weekdays,
                    start_time: startTimes,
                    end_time: endTimes
                });
            });
        });

        // Sub-service rows
        document.querySelectorAll('#subServiceAvailabilityList tbody[data-subservice-id]').forEach(tbody => {
            const subId = tbody.dataset.subserviceId;
            tbody.querySelectorAll('tr').forEach(row => {
                const monthSelect = row.querySelector('.month-select');
                const monthType = monthSelect ? monthSelect.value : '';
                let monthsToSend = [];
                if (monthType === 'all') {
                    row.querySelectorAll(`input[name*="[months][]"]:checked`).forEach(cb => monthsToSend.push(cb.value));
                } else if (monthType) {
                    monthsToSend.push(monthType);
                }
                if (monthsToSend.length === 0) return;

                const weekdays = [];
                row.querySelectorAll(`input[name*="[weekdays][]"]:checked`).forEach(cb => weekdays.push(cb.value));

                const sessionDuration = row.querySelector('.session-duration').value;
                const startTimes = Array.from(row.querySelectorAll('input[name*="[start_time]"]')).map(i => i.value).filter(Boolean);
                const endTimes = Array.from(row.querySelectorAll('input[name*="[end_time]"]')).map(i => i.value).filter(Boolean);

                monthsToSend.forEach(m => {
                    payloads.push({
                        professional_service_id: currentServiceId,
                        sub_service_id: subId,
                        month: m,
                        session_duration: sessionDuration,
                        weekdays: weekdays,
                        start_time: startTimes,
                        end_time: endTimes
                    });
                });
            });
        });

        if (payloads.length === 0) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
            toastr.error('No availability payloads to submit.');
            return;
        }

        // Send payloads sequentially to make error handling simpler
        (async () => {
            try {
                for (let i = 0; i < payloads.length; i++) {
                    await sendAvailabilityPayload(payloads[i]);
                }
                toastr.success('Availability saved successfully.');
                setTimeout(() => { window.location.href = "{{ route('professional.availability.index') }}"; }, 1200);
            } catch (xhr) {
                // show server validation errors if present
                if (xhr.status === 422) {
                    const resp = xhr.responseJSON;
                    if (resp.message) toastr.error(resp.message);
                    if (resp.errors) {
                        Object.values(resp.errors).forEach(arr => toastr.error(arr[0]));
                    }
                } else {
                    toastr.error(xhr.responseJSON?.message || 'An unexpected error occurred');
                }
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        })();
    });
});
</script>
@endsection
