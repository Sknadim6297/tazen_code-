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

/* Month selection styling */
.month-selection-container {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.month-checkbox-label {
    display: flex;
    align-items: center;
    padding: 8px 12px;
    background: white;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s;
}

.month-checkbox-label:hover {
    background: #f3f4f6;
    border-color: #4f46e5;
}

.month-checkbox-label input[type="checkbox"]:checked + span {
    font-weight: 600;
    color: #4f46e5;
}

.months-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 10px;
}

#selectAllMonths:checked ~ .months-grid .month-checkbox-label {
    background: #f0f9ff;
    border-color: #4f46e5;
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

                <div class="form-group mb-3">
                    <label>Select Months</label>
                    <div class="month-selection-container" style="background: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #dee2e6;">
                        <div class="d-flex align-items-center mb-3">
                            <label class="d-flex align-items-center mb-0" style="cursor: pointer;">
                                <input type="checkbox" id="selectAllMonths" class="mr-2">
                                <strong>Select All Next 6 Months</strong>
                            </label>
                        </div>
                        <div class="months-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
                            @php
                                $currentDate = now();
                                for ($i = 0; $i < 6; $i++) {
                                    $monthDate = $currentDate->copy()->addMonths($i);
                                    $monthKey = $monthDate->format('Y-m'); // e.g., 2025-10
                                    $monthDisplay = $monthDate->format('F Y'); // e.g., October 2025
                                    
                                    // Check if this month matches the availability month
                                    $isChecked = $availability->month === $monthKey;
                            @endphp
                                    <label class="month-checkbox-label" style="display: flex; align-items: center; padding: 8px 12px; background: white; border: 1px solid #d1d5db; border-radius: 6px; cursor: pointer; transition: all 0.2s;">
                                        <input type="checkbox" name="months[]" value="{{ $monthKey }}" class="month-checkbox mr-2" {{ $isChecked ? 'checked' : '' }}>
                                        <span>{{ $monthDisplay }}</span>
                                    </label>
                            @php
                                }
                            @endphp
                        </div>
                        <div class="text-muted mt-2" style="font-size: 0.875rem;">
                            <i class="fas fa-info-circle"></i>
                            Select one or multiple months to create/update availability schedules.
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label>Session Duration</label>
                    <select class="form-control" name="session_duration" required>
                        @foreach([30, 45, 60, 90, 120] as $duration)
                            <option value="{{ $duration }}" {{ $availability->session_duration == $duration ? 'selected' : '' }}>
                                {{ $duration }} {{ $duration == 120 ? 'minutes (2 hours)' : 'minutes' }}
                            </option>
                        @endforeach
                    </select>
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

    // Handle select all months functionality
    function setupMonthCheckboxes() {
        const selectAllMonths = document.getElementById('selectAllMonths');
        const monthCheckboxes = document.querySelectorAll('.month-checkbox');
        
        if (selectAllMonths) {
            selectAllMonths.addEventListener('change', function() {
                monthCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        }
        
        monthCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allChecked = Array.from(monthCheckboxes).every(cb => cb.checked);
                const anyChecked = Array.from(monthCheckboxes).some(cb => cb.checked);
                
                if (selectAllMonths) {
                    selectAllMonths.checked = allChecked;
                    selectAllMonths.indeterminate = anyChecked && !allChecked;
                }
            });
        });
        
        // Initialize select all state
        const checkedMonths = document.querySelectorAll('.month-checkbox:checked');
        if (selectAllMonths) {
            selectAllMonths.checked = checkedMonths.length === monthCheckboxes.length;
            selectAllMonths.indeterminate = checkedMonths.length > 0 && checkedMonths.length < monthCheckboxes.length;
        }
    }

    // Initialize month checkboxes
    setupMonthCheckboxes();

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

    $('#availabilityForm').submit(function(e) {
        e.preventDefault();
        const form = this;
        
        // Validation: Check if at least one month is selected
        const selectedMonths = document.querySelectorAll('input[name="months[]"]:checked');
        if (selectedMonths.length === 0) {
            toastr.error("Please select at least one month");
            return false;
        }
        
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

        // Create custom FormData to handle multiple months
        const formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('_method', 'PUT');
        
        // Add selected months
        selectedMonths.forEach(checkbox => {
            formData.append('months[]', checkbox.value);
        });
        
        // Add session duration
        formData.append('session_duration', sessionDurationSelect.value);
        
        // Add weekdays
        selectedWeekdays.forEach(checkbox => {
            formData.append('weekdays[]', checkbox.value);
        });
        
        // Add time slots
        timeSlots.forEach((slot, index) => {
            const startTime = slot.querySelector('input[name="start_time[]"]').value;
            const endTime = slot.querySelector('input[name="end_time[]"]').value;
            formData.append(`start_time[${index}]`, startTime);
            formData.append(`end_time[${index}]`, endTime);
        });

        // Show loading message for multiple months
        if (selectedMonths.length > 1) {
            toastr.info(`Updating availability for ${selectedMonths.length} months... This may take a moment.`);
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
                try {
                    const details = response.details || { successful: [], skipped: [], errors: [] };
                    const updated = details.successful || [];
                    const skipped = details.skipped || [];
                    const errors = details.errors || [];

                    if (updated.length > 0) {
                        toastr.success((response.message || ('Availability updated for ' + updated.length + ' month(s)')));
                    }

                    if (skipped.length > 0) {
                        toastr.warning((skipped.length) + ' month(s) were skipped because availability already exists: ' + skipped.join(', '));
                        console.warn('Skipped months:', skipped);
                    }

                    if (errors.length > 0) {
                        toastr.error((errors.length) + ' month(s) failed to update. See console for details');
                        console.error('Availability update errors:', errors);
                    }

                    if (updated.length > 0) {
                        setTimeout(() => { window.location.href = "{{ route('professional.availability.index') }}"; }, 1200);
                    }
                } catch (e) {
                    console.error('Unexpected response format', response, e);
                    toastr.error(response.message || 'Unexpected response from server');
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
