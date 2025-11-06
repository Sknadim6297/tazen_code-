@extends('professional.layout.layout')

@section('styles')
<style>
    /* Weekly Scheduler Styles */
    .weekly-scheduler-container {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e9ecef;
        margin-bottom: 20px;
    }

    .weekly-scheduler {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 15px;
        margin-top: 15px;
    }

    .day-column {
        background: white;
        border-radius: 8px;
        padding: 15px;
        border: 1px solid #dee2e6;
        min-height: 200px;
    }

    .day-header {
        font-weight: 600;
        color: #495057;
        margin-bottom: 10px;
        text-align: center;
        padding: 8px;
        background: #e9ecef;
        border-radius: 6px;
        font-size: 0.9rem;
    }

    .day-slots {
        margin-top: 10px;
    }

    .slot-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #e3f2fd;
        padding: 8px 12px;
        margin-bottom: 8px;
        border-radius: 6px;
        font-size: 0.85rem;
        border: 1px solid #bbdefb;
    }

    .slot-time {
        font-weight: 500;
        color: #1565c0;
    }

    .delete-slot {
        background: none;
        border: none;
        color: #dc3545;
        cursor: pointer;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 0.8rem;
    }

    .delete-slot:hover {
        background: #f8d7da;
    }

    .add-slot-form {
        margin-top: 10px;
        padding: 10px;
        background: #f1f3f4;
        border-radius: 6px;
        border: 1px dashed #adb5bd;
    }

    .time-inputs {
        display: flex;
        gap: 5px;
        margin-bottom: 8px;
        align-items: center;
    }

    .time-inputs input {
        width: 70px;
        padding: 4px 6px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 0.8rem;
    }

    .time-inputs input:disabled {
        background-color: #e9ecef;
        cursor: not-allowed;
    }

    .add-slot-btn {
        background: #28a745;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 0.8rem;
        cursor: pointer;
        width: 100%;
    }

    .add-slot-btn:hover {
        background: #218838;
    }

    .time-inputs span {
        color: #6c757d;
        font-size: 0.8rem;
        font-weight: 500;
    }

    /* Month Selection */
    .months-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }

    .month-card {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .month-card:hover {
        border-color: #007bff;
        box-shadow: 0 2px 8px rgba(0,123,255,0.1);
    }

    .month-card.selected {
        border-color: #007bff;
        background: #e7f3ff;
    }

    .month-card input[type="checkbox"] {
        margin-right: 8px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        border-radius: 6px;
        border: 1px solid #ced4da;
        padding: 10px 12px;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
    }

    /* Submit section */
    .submit-section {
        background: white;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        text-align: center;
    }

    .btn-primary {
        background: #007bff;
        border-color: #007bff;
        padding: 12px 30px;
        font-weight: 600;
        border-radius: 6px;
    }

    .btn-secondary {
        background: #6c757d;
        border-color: #6c757d;
        padding: 12px 30px;
        font-weight: 600;
        border-radius: 6px;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .weekly-scheduler {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 768px) {
        .weekly-scheduler {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .months-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .weekly-scheduler {
            grid-template-columns: 1fr;
        }
        
        .months-grid {
            grid-template-columns: 1fr;
        }
    }

    .alert {
        border-radius: 6px;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Add New Availability</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('professional.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('professional.availability.index') }}">Availability</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Error Messages -->
        <div id="error-messages"></div>

        <!-- Availability Form -->
        <form id="availability-form">
            @csrf
            
            <!-- Basic Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="ri-settings-line me-2"></i>Basic Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="session_duration">Session Duration (in minutes)</label>
                                <select name="session_duration" id="session_duration" class="form-control" required>
                                    @foreach([30, 45, 60, 90, 120] as $duration)
                                        <option value="{{ $duration }}" {{ $duration == 30 ? 'selected' : '' }}>
                                            {{ $duration }} {{ $duration == 120 ? 'minutes (2 hours)' : 'minutes' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Month Selection -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="ri-calendar-line me-2"></i>Select Months</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Choose the months for which you want to set this availability schedule.</p>
                    <div class="months-grid">
                        @php
                            $currentYear = date('Y');
                            $currentMonth = date('n');
                            $months = [
                                1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                                5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                                9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                            ];
                        @endphp
                        
                        @for($year = $currentYear; $year <= $currentYear + 1; $year++)
                            @foreach($months as $monthNum => $monthName)
                                @if($year == $currentYear && $monthNum < $currentMonth)
                                    @continue
                                @endif
                                @php
                                    $monthValue = sprintf('%04d-%02d', $year, $monthNum);
                                @endphp
                                <div class="month-card" onclick="toggleMonth('{{ $monthValue }}')">
                                    <input type="checkbox" name="months[]" value="{{ $monthValue }}" id="month_{{ $monthValue }}">
                                    <label for="month_{{ $monthValue }}" class="mb-0">
                                        {{ $monthName }} {{ $year }}
                                    </label>
                                </div>
                            @endforeach
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Weekly Schedule -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="ri-time-line me-2"></i>Weekly Schedule</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Set your available time slots for each day of the week. You can add multiple time slots per day.</p>
                    
                    <div class="weekly-scheduler">
                        @php
                            $days = [
                                'mon' => 'Monday',
                                'tue' => 'Tuesday', 
                                'wed' => 'Wednesday',
                                'thu' => 'Thursday',
                                'fri' => 'Friday',
                                'sat' => 'Saturday',
                                'sun' => 'Sunday'
                            ];
                        @endphp
                        
                        @foreach($days as $dayCode => $dayName)
                            <div class="day-column">
                                <div class="day-header">{{ $dayName }}</div>
                                <div class="day-slots" id="slots-{{ $dayCode }}">
                                    <!-- Slots will be added dynamically -->
                                </div>
                                <div class="add-slot-form">
                                    <div class="time-inputs">
                                        <input type="time" id="start-{{ $dayCode }}" placeholder="Start" onchange="calculateEndTime('{{ $dayCode }}')">
                                        <span>to</span>
                                        <input type="time" id="end-{{ $dayCode }}" placeholder="End" readonly>
                                    </div>
                                    <button type="button" class="add-slot-btn" onclick="addSlot('{{ $dayCode }}')">
                                        <i class="ri-add-line me-1"></i>Add Slot
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Submit Section -->
            <div class="submit-section">
                <button type="submit" class="btn btn-primary me-3">
                    <i class="ri-save-line me-2"></i>Save Availability
                </button>
                <a href="{{ route('professional.availability.index') }}" class="btn btn-secondary">
                    <i class="ri-arrow-left-line me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Store weekly slots data
    let weeklySlots = {
        mon: [], tue: [], wed: [], thu: [], fri: [], sat: [], sun: []
    };

    // Toggle month selection
    window.toggleMonth = function(monthValue) {
        const checkbox = document.getElementById('month_' + monthValue);
        const card = checkbox.closest('.month-card');
        
        checkbox.checked = !checkbox.checked;
        card.classList.toggle('selected', checkbox.checked);
    };

    // Calculate end time based on start time and session duration
    window.calculateEndTime = function(day) {
        const startInput = document.getElementById('start-' + day);
        const endInput = document.getElementById('end-' + day);
        const sessionDuration = document.getElementById('session_duration').value;
        
        if (!startInput.value || !sessionDuration) {
            endInput.value = '';
            return;
        }
        
        // Parse start time
        const [hours, minutes] = startInput.value.split(':').map(Number);
        const startDate = new Date();
        startDate.setHours(hours, minutes, 0, 0);
        
        // Add session duration
        const endDate = new Date(startDate.getTime() + parseInt(sessionDuration) * 60000);
        
        // Format end time
        const endHours = String(endDate.getHours()).padStart(2, '0');
        const endMinutes = String(endDate.getMinutes()).padStart(2, '0');
        endInput.value = `${endHours}:${endMinutes}`;
    };

    // Update all end times when session duration changes
    document.getElementById('session_duration').addEventListener('change', function() {
        // Update all start time inputs that have values
        const days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
        days.forEach(day => {
            const startInput = document.getElementById('start-' + day);
            if (startInput.value) {
                calculateEndTime(day);
            }
        });
    });

    // Add time slot to a specific day
    window.addSlot = function(day) {
        const startInput = document.getElementById('start-' + day);
        const endInput = document.getElementById('end-' + day);
        
        const startTime = startInput.value;
        const endTime = endInput.value;
        
        if (!startTime || !endTime) {
            alert('Please select both start and end times');
            return;
        }
        
        if (startTime >= endTime) {
            alert('Start time must be before end time');
            return;
        }
        
        // Add to data structure
        weeklySlots[day].push({
            start_time: startTime,
            end_time: endTime
        });
        
        // Update UI
        renderDaySlots(day);
        
        // Clear inputs
        startInput.value = '';
        endInput.value = '';
    };

    // Remove slot from a specific day
    window.deleteSlot = function(day, index) {
        weeklySlots[day].splice(index, 1);
        renderDaySlots(day);
    };

    // Render slots for a specific day
    function renderDaySlots(day) {
        const container = document.getElementById('slots-' + day);
        container.innerHTML = '';
        
        weeklySlots[day].forEach((slot, index) => {
            const slotDiv = document.createElement('div');
            slotDiv.className = 'slot-item';
            slotDiv.innerHTML = `
                <span class="slot-time">${formatTime(slot.start_time)} - ${formatTime(slot.end_time)}</span>
                <button type="button" class="delete-slot" onclick="deleteSlot('${day}', ${index})">
                    <i class="ri-delete-bin-line"></i>
                </button>
            `;
            container.appendChild(slotDiv);
        });
    }

    // Format time for display
    function formatTime(time) {
        return new Date('2000-01-01 ' + time).toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
    }

    // Form submission
    document.getElementById('availability-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate form
        const selectedMonths = document.querySelectorAll('input[name="months[]"]:checked');
        if (selectedMonths.length === 0) {
            showError('Please select at least one month');
            return;
        }
        
        // Check if any slots are added
        const totalSlots = Object.values(weeklySlots).reduce((total, daySlots) => total + daySlots.length, 0);
        if (totalSlots === 0) {
            showError('Please add at least one time slot');
            return;
        }
        
        // Prepare data
        const formData = new FormData(this);
        
        // Convert weeklySlots to the format expected by backend
        const slotsArray = [];
        Object.keys(weeklySlots).forEach(day => {
            weeklySlots[day].forEach(slot => {
                slotsArray.push({
                    weekday: day,
                    start_time: slot.start_time,
                    end_time: slot.end_time
                });
            });
        });
        
        formData.append('weekly_slots', JSON.stringify(slotsArray));
        
        // Submit form
        fetch('{{ route("professional.availability.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccess(data.message);
                setTimeout(() => {
                    window.location.href = data.redirect || '{{ route("professional.availability.index") }}';
                }, 1500);
            } else {
                if (data.errors) {
                    showError(data.errors.join('<br>'));
                } else {
                    showError(data.message || 'An error occurred');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('An error occurred while saving availability');
        });
    });

    function showError(message) {
        const errorContainer = document.getElementById('error-messages');
        errorContainer.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        errorContainer.scrollIntoView({ behavior: 'smooth' });
    }

    function showSuccess(message) {
        const errorContainer = document.getElementById('error-messages');
        errorContainer.innerHTML = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        errorContainer.scrollIntoView({ behavior: 'smooth' });
    }
});
</script>
@endsection