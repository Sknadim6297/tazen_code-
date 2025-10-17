@extends('professional.layout.layout')

@section('title', 'Edit Availability')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Edit Availability</h4>
                    <a href="{{ route('professional.availability.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <form id="editAvailabilityForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Month Selection -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="mb-3">Select Months</h5>
                                <div class="month-selector">
                                    <div class="row" id="monthGrid">
                                        <!-- Months will be populated by JavaScript -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Session Duration -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="session_duration" class="form-label">Session Duration (minutes)</label>
                                <select class="form-select" id="session_duration" name="session_duration" required>
                                    @foreach([30, 45, 60, 90, 120] as $duration)
                                        <option value="{{ $duration }}" {{ $availability->session_duration == $duration ? 'selected' : '' }}>
                                            {{ $duration }} {{ $duration == 120 ? 'minutes (2 hours)' : 'minutes' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Weekly Schedule -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="mb-3">Weekly Schedule</h5>
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
                                    <div class="weekday-column">
                                        <div class="weekday-header">{{ $dayName }}</div>
                                        
                                        <div class="slot-container" id="slots_{{ $dayCode }}">
                                            <!-- Slots will be populated by JavaScript -->
                                        </div>
                                        
                                        <div class="add-slot-form">
                                            <div class="time-inputs">
                                                <input type="time" id="start-{{ $dayCode }}" placeholder="Start" onchange="calculateEndTime('{{ $dayCode }}')">
                                                <span>-</span>
                                                <input type="time" id="end-{{ $dayCode }}" placeholder="End" readonly style="background-color: #e9ecef; cursor: not-allowed;">
                                            </div>
                                            <button type="button" class="add-slot-btn" onclick="addSlot('{{ $dayCode }}')">
                                                <i class="fas fa-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                    
                                    <button type="button" class="add-for-all-btn" onclick="showAddForAllModal()">
                                        <i class="fas fa-calendar-plus"></i> Add for All Days
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Availability
                                </button>
                                <a href="{{ route('professional.availability.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add for All Days Modal -->
<div class="modal fade" id="addForAllModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Time Slot for All Days</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="allDaysTime" class="form-label">Start Time</label>
                    <input type="time" class="form-control" id="allDaysTime" required>
                </div>
                <div class="text-muted small">
                    End time will be calculated automatically based on session duration.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="applyToAllDays()">Add to All Days</button>
            </div>
        </div>
    </div>
</div>

<style>
.month-card {
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.month-card:hover {
    border-color: #007bff;
    box-shadow: 0 2px 8px rgba(0,123,255,0.3);
}

.month-card.selected {
    border-color: #007bff;
    background: #007bff;
    color: white;
    box-shadow: 0 4px 12px rgba(0,123,255,0.4);
}

.month-name {
    font-weight: bold;
    font-size: 1.1rem;
    margin-bottom: 5px;
}

/* Weekly Scheduler */
.weekly-scheduler {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1rem;
    margin-top: 1.5rem;
}

.weekday-column {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1rem;
    min-height: 350px;
}

.weekday-header {
    font-weight: 600;
    font-size: 0.95rem;
    color: #495057;
    text-align: center;
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 6px;
    margin-bottom: 1rem;
    border: 1px solid #e9ecef;
}

.slot-item {
    background: #e3f2fd;
    padding: 8px 10px;
    margin-bottom: 8px;
    border-radius: 6px;
    font-size: 0.85rem;
    border: 1px solid #bbdefb;
    display: flex;
    justify-content: space-between;
    align-items: center;
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

.time-inputs span {
    font-size: 0.9rem;
    color: #6c757d;
}

.add-slot-btn {
    width: 100%;
    padding: 0.6rem;
    background: #10b981;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s;
}

.add-slot-btn:hover {
    background: #059669;
}

.add-for-all-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    width: 100%;
    padding: 0.75rem;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 1rem;
    transition: all 0.2s;
    font-size: 0.9rem;
}

.add-for-all-btn:hover {
    opacity: 0.9;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.loading-spinner {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    text-align: center;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Store weekly slots data
    let weeklySlots = {
        mon: [], tue: [], wed: [], thu: [], fri: [], sat: [], sun: []
    };
    
    let slotIdCounter = 0;
    let selectedMonths = [];

    // Load existing availability data
    const availabilityData = @json($availability);
    
    // Populate selected months - since each availability record is for one month
    selectedMonths = availabilityData.month ? [availabilityData.month] : [];
    
    // Populate month grid
    populateMonthGrid();
    
    // Load existing slots
    loadExistingSlots();

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
        const sessionDuration = document.getElementById('session_duration').value;
        
        if (!startInput.value || !sessionDuration) {
            alert('Please select start time and session duration');
            return;
        }
        
        const startTime = formatTimeToHHMM(startInput.value);
        const endTime = formatTimeToHHMM(endInput.value);
        
        if (!startTime || !endTime) {
            alert('Invalid time format');
            return;
        }
        
        // Check for overlaps
        const hasOverlap = weeklySlots[day].some(slot => {
            const newStart = new Date(`1/1/2023 ${startTime}`);
            const newEnd = new Date(`1/1/2023 ${endTime}`);
            const existingStart = new Date(`1/1/2023 ${slot.start_time}`);
            const existingEnd = new Date(`1/1/2023 ${slot.end_time}`);
            
            return (newStart < existingEnd && newEnd > existingStart);
        });
        
        if (hasOverlap) {
            alert('This time slot overlaps with an existing slot');
            return;
        }
        
        const newSlot = {
            id: ++slotIdCounter,
            start_time: startTime,
            end_time: endTime,
            weekday: day
        };
        
        weeklySlots[day].push(newSlot);
        weeklySlots[day].sort((a, b) => {
            return new Date(`1/1/2023 ${a.start_time}`) - new Date(`1/1/2023 ${b.start_time}`);
        });
        
        renderDaySlots(day);
        
        // Clear inputs
        startInput.value = '';
        endInput.value = '';
    };

    // Render slots for a specific day
    function renderDaySlots(day) {
        const container = document.getElementById(`slots_${day}`);
        const slots = weeklySlots[day];
        
        if (slots.length === 0) {
            container.innerHTML = '<div class="text-muted small" style="text-align: center; padding: 10px;">No slots added</div>';
            return;
        }
        
        container.innerHTML = slots.map(slot => `
            <div class="slot-item">
                <span class="slot-time">${slot.start_time} - ${slot.end_time}</span>
                <button type="button" class="delete-slot" onclick="deleteSlot('${day}', ${slot.id})">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `).join('');
    }

    // Delete slot
    window.deleteSlot = function(day, slotId) {
        if (confirm('Are you sure you want to delete this time slot?')) {
            weeklySlots[day] = weeklySlots[day].filter(slot => slot.id !== slotId);
            renderDaySlots(day);
        }
    };

    // Show "Add for All" modal
    window.showAddForAllModal = function() {
        document.getElementById('allDaysTime').value = '';
        $('#addForAllModal').modal('show');
    };

    // Apply slot to all days
    window.applyToAllDays = function() {
        const timeValue = document.getElementById('allDaysTime').value.trim();
        const sessionDuration = document.getElementById('session_duration').value;
        
        if (!timeValue || !sessionDuration) {
            alert('Please select start time and session duration');
            return;
        }
        
        const startTime = formatTimeToHHMM(timeValue);
        
        // Calculate end time
        const [hours, minutes] = startTime.split(':').map(Number);
        const startDate = new Date();
        startDate.setHours(hours, minutes, 0, 0);
        const endDate = new Date(startDate.getTime() + parseInt(sessionDuration) * 60000);
        const endTime = `${String(endDate.getHours()).padStart(2, '0')}:${String(endDate.getMinutes()).padStart(2, '0')}`;
        
        const days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
        let addedCount = 0;
        let skippedCount = 0;
        
        days.forEach(day => {
            // Check for overlaps
            const hasOverlap = weeklySlots[day].some(slot => {
                const newStart = new Date(`1/1/2023 ${startTime}`);
                const newEnd = new Date(`1/1/2023 ${endTime}`);
                const existingStart = new Date(`1/1/2023 ${slot.start_time}`);
                const existingEnd = new Date(`1/1/2023 ${slot.end_time}`);
                
                return (newStart < existingEnd && newEnd > existingStart);
            });
            
            if (!hasOverlap) {
                const newSlot = {
                    id: ++slotIdCounter,
                    start_time: startTime,
                    end_time: endTime,
                    weekday: day
                };
                
                weeklySlots[day].push(newSlot);
                weeklySlots[day].sort((a, b) => {
                    return new Date(`1/1/2023 ${a.start_time}`) - new Date(`1/1/2023 ${b.start_time}`);
                });
                
                renderDaySlots(day);
                addedCount++;
            } else {
                skippedCount++;
            }
        });
        
        $('#addForAllModal').modal('hide');
        
        if (addedCount > 0) {
            alert(`Added slot to ${addedCount} days`);
        }
        if (skippedCount > 0) {
            alert(`Skipped ${skippedCount} days due to overlapping slots`);
        }
    };

    function populateMonthGrid() {
        const months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        
        const monthGrid = document.getElementById('monthGrid');
        monthGrid.innerHTML = '';
        
        // Generate current and next year months
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        
        for (let year = currentYear; year <= currentYear + 1; year++) {
            months.forEach((month, index) => {
                const monthNum = index + 1;
                const monthValue = `${year}-${String(monthNum).padStart(2, '0')}`;
                const isSelected = selectedMonths.includes(monthValue);
                
                const colDiv = document.createElement('div');
                colDiv.className = 'col-md-3 mb-3';
                
                colDiv.innerHTML = `
                    <div class="month-card ${isSelected ? 'selected' : ''}" onclick="toggleMonth('${monthValue}')">
                        <div class="month-name">${month} ${year}</div>
                        <input type="checkbox" name="months[]" value="${monthValue}" ${isSelected ? 'checked' : ''} style="display: none;">
                    </div>
                `;
                
                monthGrid.appendChild(colDiv);
            });
        }
    }

    window.toggleMonth = function(monthValue) {
        const card = event.currentTarget;
        const checkbox = card.querySelector('input[type="checkbox"]');
        
        checkbox.checked = !checkbox.checked;
        card.classList.toggle('selected', checkbox.checked);
        
        if (checkbox.checked) {
            selectedMonths.push(monthValue);
        } else {
            selectedMonths = selectedMonths.filter(m => m !== monthValue);
        }
    };

    function loadExistingSlots() {
        if (availabilityData.availability_slots) {
            availabilityData.availability_slots.forEach(slot => {
                // Ensure time format is HH:MM
                const startTime = formatTimeToHHMM(slot.start_time);
                const endTime = formatTimeToHHMM(slot.end_time);
                
                const newSlot = {
                    id: ++slotIdCounter,
                    start_time: startTime,
                    end_time: endTime,
                    weekday: slot.weekday
                };
                
                weeklySlots[slot.weekday].push(newSlot);
            });
            
            // Render all days
            const days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
            days.forEach(day => renderDaySlots(day));
        }
    }

    // Function to ensure time is in HH:MM format
    function formatTimeToHHMM(timeString) {
        if (!timeString) return '';
        
        // Remove any extra characters and ensure HH:MM format
        let cleanTime = timeString.toString().trim();
        
        // If it's already in HH:MM format, return as is
        if (/^\d{1,2}:\d{2}$/.test(cleanTime)) {
            const [hours, minutes] = cleanTime.split(':');
            return `${String(hours).padStart(2, '0')}:${minutes}`;
        }
        
        // If it has seconds (HH:MM:SS), remove seconds
        if (/^\d{1,2}:\d{2}:\d{2}$/.test(cleanTime)) {
            const [hours, minutes] = cleanTime.split(':');
            return `${String(hours).padStart(2, '0')}:${minutes}`;
        }
        
        // Try to parse as time and reformat
        try {
            const date = new Date(`1970-01-01 ${cleanTime}`);
            if (!isNaN(date.getTime())) {
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                return `${hours}:${minutes}`;
            }
        } catch (e) {
            console.error('Time format error:', e);
        }
        
        return cleanTime;
    }

    // Handle form submission
    document.getElementById('editAvailabilityForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validation
        if (selectedMonths.length === 0) {
            alert('Please select at least one month');
            return;
        }
        
        const totalSlots = Object.values(weeklySlots).reduce((sum, daySlots) => sum + daySlots.length, 0);
        if (totalSlots === 0) {
            alert('Please add at least one time slot');
            return;
        }
        
        const sessionDuration = document.getElementById('session_duration').value;
        if (!sessionDuration) {
            alert('Please select session duration');
            return;
        }
        
        // Prepare form data
        const formData = new FormData();
        formData.append('_token', document.querySelector('input[name="_token"]').value);
        formData.append('_method', 'PUT');
        formData.append('session_duration', sessionDuration);
        
        // Add selected months
        selectedMonths.forEach(month => {
            formData.append('months[]', month);
        });
        
        // Convert weeklySlots to JSON format expected by backend
        const slotsArray = [];
        Object.keys(weeklySlots).forEach(day => {
            weeklySlots[day].forEach(slot => {
                slotsArray.push({
                    weekday: day,
                    start_time: formatTimeToHHMM(slot.start_time),
                    end_time: formatTimeToHHMM(slot.end_time)
                });
            });
        });
        formData.append('weekly_slots', JSON.stringify(slotsArray));
        
        // Show loading
        showLoading();
        
        fetch(`{{ route('professional.availability.update', $availability->id) }}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            
            if (data.success) {
                alert(data.message);
                window.location.href = "{{ route('professional.availability.index') }}";
            } else {
                alert(data.message || 'An error occurred. Please try again.');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    });

    function showLoading() {
        if (!document.getElementById('loadingOverlay')) {
            const overlay = document.createElement('div');
            overlay.id = 'loadingOverlay';
            overlay.className = 'loading-overlay';
            overlay.innerHTML = `
                <div class="loading-spinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="mt-2">Updating availability...</div>
                </div>
            `;
            document.body.appendChild(overlay);
        }
        document.getElementById('loadingOverlay').style.display = 'flex';
    }

    function hideLoading() {
        const overlay = document.getElementById('loadingOverlay');
        if (overlay) {
            overlay.style.display = 'none';
        }
    }
});
</script>
@endsection