@php
    $currentMonth = now()->format('n');
    $months = [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
    ];
    $selectedWeekdays = json_decode($availability->weekdays, true);
@endphp

@extends('professional.layout.layout')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
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
}
.weekday-label {
    display: flex;
    align-items: center;
    gap: 5px;
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3>Edit Availability</h3>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Update Your Availability</h4>
        </div>
        <div class="card-body">
            <form id="availabilityForm">
                @csrf
                @method('PUT')

                <div class="form-row mb-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: end;">
                    <div class="form-group">
                        <label>Select Service <span class="text-danger">*</span></label>
                        <select id="professional_service_id" class="form-control" name="professional_service_id" required>
                            <option value="">Choose a service to set availability</option>
                            @foreach($professionalServices as $service)
                                <option value="{{ $service->id }}" {{ $availability->professional_service_id == $service->id ? 'selected' : '' }}>
                                    {{ $service->service_name }}
                                    @if($service->service_type)
                                        ({{ $service->service_type }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Each service can have its own availability schedule</small>
                    </div>
                    <div class="form-group" id="subServiceGroup">
                        <label>Select Sub-Service (optional)</label>
                        <select id="subServiceSelect" name="sub_service_id" class="form-control" disabled>
                            <option value="">All / None</option>
                        </select>
                        <small class="text-muted">Selecting a sub-service will set availability only for that sub-service.</small>
                    </div>
                </div>

                <div class="form-row mb-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>Select Month</label>
                        <select id="avail-month" class="form-control" name="month" required>
                            <option value="">Select Month</option>
                            @foreach($months as $num => $name)
                                @if($num >= $currentMonth)
                                    <option value="{{ strtolower(substr($name, 0, 3)) }}" {{ strtolower(substr($name, 0, 3)) == $availability->month ? 'selected' : '' }}>{{ $name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Session Duration</label>
                        <select class="form-control" name="session_duration" required>
                            @foreach([30, 45, 60, 90, 120] as $duration)
                                <option value="{{ $duration }}" {{ $availability->session_duration == $duration ? 'selected' : '' }}>
                                    {{ $duration }} {{ $duration == 120 ? 'minutes (2 hours)' : 'minutes' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Select Week Days</label>
                    <div class="weekday-group">
                        @foreach(['mon' => 'Monday', 'tue' => 'Tuesday', 'wed' => 'Wednesday', 'thu' => 'Thursday', 'fri' => 'Friday', 'sat' => 'Saturday', 'sun' => 'Sunday'] as $dayVal => $dayName)
                            <label class="weekday-label">
                                <input type="checkbox" name="weekdays[]" value="{{ $dayVal }}" {{ in_array($dayVal, $selectedWeekdays) ? 'checked' : '' }}> {{ $dayName }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <label>Time Slots</label>
                    <div id="time-slots-container">
                        @foreach($availability->slots as $slot)
                            <div class="time-slot">
                                <label>From</label>
                                <div class="time-input-group">
                                    <input type="text" class="form-control timepicker" name="start_time[]" value="{{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}" required>
                                </div>
                                <label>To</label>
                                <div class="time-input-group">
                                    <input type="text" class="form-control timepicker" name="end_time[]" value="{{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}" required readonly>
                                </div>
                                <button type="button" class="remove-slot-btn" title="Remove slot">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-success" id="addSlotBtn">
                        <i class="fas fa-plus"></i> Add more
                    </button>
                </div>

                <div class="form-actions mt-3">
                    <a href="{{ route('professional.availability.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    @media only screen and (min-width: 768px) and (max-width: 1024px) {
    .user-profile-wrapper {
        margin-top: -57px;
    }
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const timeSlotsContainer = document.getElementById('time-slots-container');
    const addSlotBtn = document.getElementById('addSlotBtn');
    const sessionDurationSelect = document.querySelector('select[name="session_duration"]');
    const professionalServices = @json($professionalServices);
    const currentServiceId = '{{ $availability->professional_service_id }}';
    const currentSubServiceId = '{{ $availability->sub_service_id ?? '' }}';

    // Get the selected session duration in minutes
    function getSessionDuration() {
        return parseInt(sessionDurationSelect.value);
    }
    
    // Initialize Flatpickr with duration-based settings
    function initializeFlatpickr() {
        const duration = getSessionDuration();
        
        // Destroy existing instances first to prevent duplicates
        document.querySelectorAll('.timepicker').forEach(el => {
            if (el._flatpickr) {
                el._flatpickr.destroy();
            }
        });
        
        // Initialize start time pickers
        document.querySelectorAll('input[name="start_time[]"]').forEach(el => {
            flatpickr(el, {
                enableTime: true,
                noCalendar: true,
                dateFormat: "h:i K",
                time_24hr: false,
                minuteIncrement: duration,
                disableMobile: true,
                onChange: function(selectedDates, dateStr, instance) {
                    // When start time changes, update end time
                    if (dateStr) {
                        const timeSlot = instance.element.closest('.time-slot');
                        const endTimeInput = timeSlot.querySelector('input[name="end_time[]"]');
                        
                        // Calculate end time based on duration
                        const startTime = new Date(`1/1/2023 ${dateStr}`);
                        const endTime = new Date(startTime.getTime() + (duration * 60 * 1000));
                        
                        // Format end time for display
                        const hours = endTime.getHours();
                        const minutes = endTime.getMinutes();
                        const ampm = hours >= 12 ? 'PM' : 'AM';
                        const formattedHours = hours % 12 || 12;
                        const formattedMinutes = minutes.toString().padStart(2, '0');
                        const formattedTime = `${formattedHours}:${formattedMinutes} ${ampm}`;
                        
                        // Set the end time value
                        if (endTimeInput._flatpickr) {
                            endTimeInput._flatpickr.setDate(formattedTime);
                        } else {
                            endTimeInput.value = formattedTime;
                        }
                    }
                }
            });
        });
        
        // Initialize end time pickers (readonly)
        document.querySelectorAll('input[name="end_time[]"]').forEach(el => {
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
        });
    }

    // Create new time slot
    function createTimeSlot(start = '', end = '') {
        const div = document.createElement('div');
        div.classList.add('time-slot');
        div.innerHTML = `
            <label>From</label>
            <div class="time-input-group">
                <input type="text" class="form-control timepicker" name="start_time[]" value="${start}" required placeholder="Start Time">
            </div>
            <label>To</label>
            <div class="time-input-group">
                <input type="text" class="form-control timepicker" name="end_time[]" value="${end}" required placeholder="End Time" readonly>
            </div>
            <button type="button" class="remove-slot-btn" title="Remove slot">
                <i class="fas fa-trash"></i>
            </button>
        `;
        timeSlotsContainer.appendChild(div);
        initializeFlatpickr();
    }

    // Add new time slot when button is clicked
    addSlotBtn.addEventListener('click', () => createTimeSlot());

    // Remove time slot
    timeSlotsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-slot-btn')) {
            e.target.closest('.time-slot').remove();
        }
    });
    
    // Recalculate time slots when duration changes
    sessionDurationSelect.addEventListener('change', function() {
        // Re-initialize all pickers with new duration
        initializeFlatpickr();
        
        // Reset any existing end times to match new duration
        document.querySelectorAll('.time-slot').forEach(slot => {
            const startInput = slot.querySelector('input[name="start_time[]"]');
            const endInput = slot.querySelector('input[name="end_time[]"]');
            
            if (startInput.value) {
                // Trigger onChange event to recalculate end time
                if (startInput._flatpickr) {
                    const currentValue = startInput.value;
                    startInput._flatpickr.setDate(currentValue);
                }
            }
        });
    });

    // Initialize Flatpickr for existing time slots
    initializeFlatpickr();

    // Populate sub-service select based on current or selected service
    function populateSubServices(serviceId) {
        const svc = professionalServices.find(s => s.id == serviceId);
        const subGroup = document.getElementById('subServiceGroup');
        const subSelect = document.getElementById('subServiceSelect');
        subSelect.innerHTML = '<option value="">All / None</option>';
        subSelect.disabled = true;
        if (svc && svc.sub_services && svc.sub_services.length) {
            svc.sub_services.forEach(ss => {
                const opt = document.createElement('option');
                opt.value = ss.id;
                opt.textContent = ss.name;
                if (ss.id == currentSubServiceId) opt.selected = true;
                subSelect.appendChild(opt);
            });
            subSelect.disabled = false;
            subGroup.style.display = 'block';
        } else {
            // keep visible but disabled so user sees context
            subSelect.disabled = true;
            subGroup.style.display = 'block';
        }
    }

    // Initial populate
    populateSubServices(currentServiceId);

    document.getElementById('professional_service_id').addEventListener('change', function() {
        populateSubServices(this.value);
    });

    $('#availabilityForm').submit(function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        
        // Validation: Check if at least one weekday is selected
        const selectedWeekdays = document.querySelectorAll('input[name="weekdays[]"]:checked');
        if (selectedWeekdays.length === 0) {
            toastr.error("Please select at least one weekday");
            return false;
        }
        
        // Validation: Check if all time slots are filled
        const timeSlots = document.querySelectorAll('.time-slot');
        for (const slot of timeSlots) {
            const startTime = slot.querySelector('input[name="start_time[]"]').value;
            const endTime = slot.querySelector('input[name="end_time[]"]').value;
            
            if (!startTime || !endTime) {
                toastr.error("Please fill all time slots");
                return false;
            }
        }
        
        // Validation: Check for overlapping time slots
        const timeRanges = Array.from(timeSlots).map(slot => {
            const startTime = slot.querySelector('input[name="start_time[]"]').value;
            const endTime = slot.querySelector('input[name="end_time[]"]').value;
            return { start: startTime, end: endTime };
        });
        
        // Sort by start time for easier comparison
        timeRanges.sort((a, b) => {
            return new Date(`1/1/2023 ${a.start}`) - new Date(`1/1/2023 ${b.start}`);
        });
        
        // Check for overlaps
        for (let i = 0; i < timeRanges.length - 1; i++) {
            const currentEnd = new Date(`1/1/2023 ${timeRanges[i].end}`);
            const nextStart = new Date(`1/1/2023 ${timeRanges[i+1].start}`);
            
            if (currentEnd > nextStart) {
                toastr.error("Time slots cannot overlap. Please adjust your schedule.");
                return false;
            }
        }

        $.ajax({
            url: "{{ route('professional.availability.update', $availability->id) }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(() => {
                        window.location.href = "{{ route('professional.availability.index') }}";
                    }, 1500);
                } else {
                    $.each(response.errors, function(index, error) {
                        toastr.error(error);  
                    });
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(index, error) {
                        toastr.error(error);
                    });
                } else {
                    toastr.error(xhr.responseJSON.message || "Unexpected error occurred");
                }
            }
        });
    });
});
</script>
@endsection
