@extends('admin.layouts.layout')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .management-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
    }

    .management-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .management-subtitle {
        opacity: 0.9;
        margin: 0;
    }

    .availability-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .availability-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .availability-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .availability-month {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    .availability-duration {
        background: #4f46e5;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .availability-slots {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .slot-badge {
        background: #f3f4f6;
        color: #374151;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
        border: 1px solid #d1d5db;
    }

    .btn-group {
        display: flex;
        gap: 0.5rem;
    }

    .btn {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: #4f46e5;
        color: white;
    }

    .btn-primary:hover {
        background: #4338ca;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 3rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }

    .actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e5e7eb;
    }

    /* Time slot styling */
    .time-slot {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        padding: 10px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #f9fafb;
    }

    .time-input-group {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .remove-slot-btn {
        background: #ef4444;
        border: none;
        color: white;
        cursor: pointer;
        padding: 5px 8px;
        border-radius: 4px;
        font-size: 12px;
    }

    .remove-slot-btn:hover {
        background: #dc2626;
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
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        background: white;
        cursor: pointer;
        transition: all 0.2s;
    }

    .weekday-label:hover {
        background: #f3f4f6;
    }

    .weekday-label input[type="checkbox"]:checked + span {
        font-weight: 600;
        color: #4f46e5;
    }

    .flatpickr-input {
        background: white !important;
    }

    /* Time slot styling */
    .time-slot {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        padding: 10px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #f9fafb;
    }

    .time-input-group {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .remove-slot-btn {
        background: #ef4444;
        border: none;
        color: white;
        cursor: pointer;
        padding: 5px 8px;
        border-radius: 4px;
        font-size: 12px;
    }

    .remove-slot-btn:hover {
        background: #dc2626;
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
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        background: white;
        cursor: pointer;
        transition: all 0.2s;
    }

    .weekday-label:hover {
        background: #f3f4f6;
    }

    .weekday-label input[type="checkbox"]:checked + span {
        font-weight: 600;
        color: #4f46e5;
    }

    .flatpickr-input {
        background: white !important;
    }

    .availability-weekdays {
        margin-top: 8px;
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
    }

    .weekday-chip {
        background: #e0e7ff;
        color: #4338ca;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .slot-config {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 15px;
        align-items: end;
        margin-bottom: 15px;
        padding: 15px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #f8fafc;
    }

    .slot-config label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 5px;
        display: block;
    }

    .generated-slots {
        margin-top: 15px;
        padding: 15px;
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 8px;
    }

    .generated-slots h6 {
        color: #0369a1;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .generated-slot-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: white;
        padding: 8px 12px;
        margin: 4px 0;
        border-radius: 6px;
        font-size: 0.875rem;
        border: 1px solid #bae6fd;
    }
    
    .generated-slot-item .btn {
        padding: 2px 6px;
        font-size: 0.75em;
        margin-left: 8px;
        min-width: auto;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid mt-4">
        <!-- Header -->
        <div class="management-header">
            <h1 class="management-title">Manage Availability Schedule</h1>
            <p class="management-subtitle">Professional: {{ $professional->name }} ({{ $professional->email }})</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Availability List -->
        <div class="row">
            <div class="col-12">
                @if($availabilities->count() > 0)
                    @foreach($availabilities as $availability)
                        <div class="availability-card">
                            <div class="availability-header">
                                <div>
                                    @php
                                        $monthNames = [
                                            'jan' => 'January', 'feb' => 'February', 'mar' => 'March', 
                                            'apr' => 'April', 'may' => 'May', 'jun' => 'June',
                                            'jul' => 'July', 'aug' => 'August', 'sep' => 'September',
                                            'oct' => 'October', 'nov' => 'November', 'dec' => 'December'
                                        ];
                                        $fullMonth = $monthNames[$availability->month] ?? ucfirst($availability->month);
                                    @endphp
                                    <h3 class="availability-month">{{ $fullMonth }}</h3>
                                    <div class="availability-duration">{{ $availability->session_duration }} min sessions</div>
                                    @if($availability->weekdays)
                                        <div class="availability-weekdays">
                                            @php
                                                $weekdays = json_decode($availability->weekdays, true) ?? [];
                                                $dayNames = [
                                                    'mon' => 'Mon', 'tue' => 'Tue', 'wed' => 'Wed', 
                                                    'thu' => 'Thu', 'fri' => 'Fri', 'sat' => 'Sat', 'sun' => 'Sun'
                                                ];
                                            @endphp
                                            @foreach($weekdays as $day)
                                                <span class="weekday-chip">{{ $dayNames[$day] ?? $day }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="btn-group">
                                    <button onclick="editAvailability({{ $availability->id }})" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button onclick="deleteAvailability({{ $availability->id }})" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                            
                            <div class="availability-slots">
                                @if($availability->slots && $availability->slots->count() > 0)
                                    @foreach($availability->slots as $slot)
                                        <div class="slot-badge">
                                            @php
                                                $startTime = \Carbon\Carbon::createFromFormat('H:i:s', $slot->start_time)->format('g:i A');
                                                $endTime = \Carbon\Carbon::createFromFormat('H:i:s', $slot->end_time)->format('g:i A');
                                            @endphp
                                            {{ $startTime }} - {{ $endTime }}
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-muted">No time slots defined</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <h3>No Availability Found</h3>
                        <p>This professional hasn't set up any availability schedule yet.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="actions">
            <button onclick="showAddAvailabilityModal()" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Add New Availability
            </button>
            <a href="{{ route('admin.manage-professional.show', $professional->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Professional Details
            </a>
        </div>
    </div>
</div>

<!-- Add Availability Modal -->
<div class="modal fade" id="addAvailabilityModal" tabindex="-1" role="dialog" aria-labelledby="addAvailabilityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAvailabilityModalLabel">Add New Availability</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addAvailabilityForm">
                @csrf
                <div class="modal-body">
                    <div class="form-row mb-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label for="month">Select Month</label>
                            <select class="form-control" id="month" name="month" required>
                                <option value="">Select Month</option>
                                @php
                                    $currentMonth = now()->format('n');
                                    $months = [
                                        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                                        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                                        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
                                    ];
                                @endphp
                                @foreach($months as $num => $name)
                                    @if($num >= $currentMonth)
                                        <option value="{{ strtolower(substr($name, 0, 3)) }}">{{ $name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="session_duration">Session Duration</label>
                            <select class="form-control" id="session_duration" name="session_duration" required>
                                @foreach([30, 45, 60, 90, 120] as $duration)
                                    <option value="{{ $duration }}" {{ $duration == 60 ? 'selected' : '' }}>
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
                                    <input type="checkbox" name="weekdays[]" value="{{ $dayVal }}">
                                    <span>{{ $dayName }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Time Slots Configuration</label>
                        
                        <!-- Individual Slot Generator -->
                        <div class="slot-config">
                            <div>
                                <label for="slotStartTime">Slot Start Time</label>
                                <input type="text" id="slotStartTime" class="form-control" placeholder="e.g., 3:00 PM, 15:00" />
                            </div>
                            <div>
                                <button type="button" class="btn btn-success" id="addGeneratedSlotBtn">
                                    <i class="fas fa-plus"></i> Add This Slot
                                </button>
                            </div>
                        </div>
                        
                        <div class="text-muted mb-3" style="font-size: 0.9em;">
                            <i class="fas fa-info-circle"></i> 
                            Add individual time slots. End time will be calculated automatically based on session duration.
                            <br>Examples: "3:00 PM" → 3:00-3:30 PM (30min), "15:00" → 3:00-4:00 PM (60min)
                        </div>

                        <!-- Generated Slots Preview -->
                        <div id="generatedSlotsPreview" class="generated-slots" style="display: none;">
                            <h6>Added Time Slots:</h6>
                            <div id="slotsPreviewContainer"></div>
                            <button type="button" class="btn btn-danger btn-sm" id="clearAllSlotsBtn" style="margin-top: 10px;">
                                <i class="fas fa-trash"></i> Clear All Slots
                            </button>
                        </div>

                        <!-- Toggle Manual Mode -->
                        <div style="text-align: center; margin: 15px 0;">
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleManualMode">
                                <i class="fas fa-cog"></i> Switch to Manual Mode
                            </button>
                        </div>

                        <!-- Manual Time Slots Container (fallback) -->
                        <div id="timeSlotsContainer" style="display: none;">
                            <!-- Dynamic time slots will be added here -->
                        </div>
                        <button type="button" class="btn btn-success btn-sm" id="addSlotBtn" style="display: none;">
                            <i class="fas fa-plus"></i> Add Manual Time Slot
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Availability</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Availability Modal -->
<div class="modal fade" id="editAvailabilityModal" tabindex="-1" role="dialog" aria-labelledby="editAvailabilityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAvailabilityModalLabel">Edit Availability</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editAvailabilityForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-row mb-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label for="edit_month">Select Month</label>
                            <select class="form-control" id="edit_month" name="month" required>
                                <option value="">Select Month</option>
                                @php
                                    $currentMonth = now()->format('n');
                                    $months = [
                                        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                                        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                                        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
                                    ];
                                @endphp
                                @foreach($months as $num => $name)
                                    @if($num >= $currentMonth)
                                        <option value="{{ strtolower(substr($name, 0, 3)) }}">{{ $name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_session_duration">Session Duration</label>
                            <select class="form-control" id="edit_session_duration" name="session_duration" required>
                                @foreach([30, 45, 60, 90, 120] as $duration)
                                    <option value="{{ $duration }}">
                                        {{ $duration }} {{ $duration == 120 ? 'minutes (2 hours)' : 'minutes' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Select Week Days</label>
                        <div class="weekday-group" id="editWeekdayGroup">
                            @foreach(['mon' => 'Monday', 'tue' => 'Tuesday', 'wed' => 'Wednesday', 'thu' => 'Thursday', 'fri' => 'Friday', 'sat' => 'Saturday', 'sun' => 'Sunday'] as $dayVal => $dayName)
                                <label class="weekday-label">
                                    <input type="checkbox" name="weekdays[]" value="{{ $dayVal }}">
                                    <span>{{ $dayName }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Time Slots Configuration</label>
                        
                        <!-- Individual Slot Generator -->
                        <div class="slot-config">
                            <div>
                                <label for="editSlotStartTime">Slot Start Time</label>
                                <input type="text" id="editSlotStartTime" class="form-control" placeholder="e.g., 3:00 PM, 15:00" />
                            </div>
                            <div>
                                <button type="button" class="btn btn-success" id="editAddGeneratedSlotBtn">
                                    <i class="fas fa-plus"></i> Add This Slot
                                </button>
                            </div>
                        </div>
                        
                        <div class="text-muted mb-3" style="font-size: 0.9em;">
                            <i class="fas fa-info-circle"></i> 
                            Add individual time slots. End time will be calculated automatically based on session duration.
                            <br>Examples: "3:00 PM" → 3:00-3:30 PM (30min), "15:00" → 3:00-4:00 PM (60min)
                        </div>

                        <!-- Generated Slots Preview -->
                        <div id="editGeneratedSlotsPreview" class="generated-slots" style="display: none;">
                            <h6>Added Time Slots:</h6>
                            <div id="editSlotsPreviewContainer"></div>
                            <button type="button" class="btn btn-danger btn-sm" id="editClearAllSlotsBtn" style="margin-top: 10px;">
                                <i class="fas fa-trash"></i> Clear All Slots
                            </button>
                        </div>

                        <!-- Toggle Manual Mode -->
                        <div style="text-align: center; margin: 15px 0;">
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleEditManualMode">
                                <i class="fas fa-cog"></i> Switch to Manual Mode
                            </button>
                        </div>

                        <!-- Manual Time Slots Container (fallback) -->
                        <div id="editTimeSlotsContainer" style="display: none;">
                            <!-- Dynamic time slots will be inserted here -->
                        </div>
                        <button type="button" class="btn btn-success btn-sm" id="addEditSlotBtn" style="display: none;">
                            <i class="fas fa-plus"></i> Add Manual Time Slot
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Availability</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const timeSlotsContainer = document.getElementById('timeSlotsContainer');
    const addSlotBtn = document.getElementById('addSlotBtn');
    const sessionDurationSelect = document.querySelector('#session_duration');

    // Get the selected session duration in minutes
    function getSessionDuration() {
        return parseInt(sessionDurationSelect?.value || 60);
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
                minuteIncrement: 15,
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
                minuteIncrement: 15,
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
    addSlotBtn?.addEventListener('click', () => createTimeSlot());

    // Remove time slot
    timeSlotsContainer?.addEventListener('click', function(e) {
        if (e.target.closest('.remove-slot-btn')) {
            const timeSlots = timeSlotsContainer.querySelectorAll('.time-slot');
            if (timeSlots.length > 1) {
                e.target.closest('.time-slot').remove();
            } else {
                // Clear inputs instead of removing if it's the last slot
                const inputs = e.target.closest('.time-slot').querySelectorAll('input');
                inputs.forEach(input => {
                    input.value = '';
                    if (input._flatpickr) {
                        input._flatpickr.clear();
                    }
                });
            }
        }
    });
    
    // Recalculate time slots when duration changes
    sessionDurationSelect?.addEventListener('change', function() {
        // Re-initialize all pickers with new duration
        initializeFlatpickr();
        
        // Reset any existing end times to match new duration
        document.querySelectorAll('.time-slot').forEach(slot => {
            const startInput = slot.querySelector('input[name="start_time[]"]');
            const endInput = slot.querySelector('input[name="end_time[]"]');

            if (startInput && startInput.value) {
                // Trigger onChange event to recalculate end time
                if (startInput._flatpickr) {
                    const currentValue = startInput.value;
                    startInput._flatpickr.setDate(currentValue);
                }
            }
        });
    });

    // Generate slots - individual slot addition
    let generatedSlots = [];
    let editGeneratedSlots = [];
    
    function addIndividualSlot(isEdit = false) {
        const slotStartTimeId = isEdit ? 'editSlotStartTime' : 'slotStartTime';
        const startTimeInput = document.getElementById(slotStartTimeId);
        const startTime = startTimeInput.value;
        const sessionDuration = isEdit ? 
            parseInt(document.getElementById('edit_session_duration')?.value || 60) : 
            getSessionDuration();
        
        if (!startTime) {
            toastr.error('Please enter a start time');
            return;
        }
        
        // Parse start time
        const startDate = parseTimeString(startTime);
        if (!startDate) {
            toastr.error('Invalid start time format. Use format like "9:00 AM" or "14:30"');
            return;
        }
        
        const slotEnd = new Date(startDate.getTime() + (sessionDuration * 60 * 1000));
        
        const newSlot = {
            start: formatTime12Hour(startDate),
            end: formatTime12Hour(slotEnd),
            start24: formatTime24Hour(startDate),
            end24: formatTime24Hour(slotEnd)
        };
        
        // Check for duplicates
        const targetSlots = isEdit ? editGeneratedSlots : generatedSlots;
        const isDuplicate = targetSlots.some(slot => 
            slot.start24 === newSlot.start24 && slot.end24 === newSlot.end24
        );
        
        if (isDuplicate) {
            toastr.warning('This time slot already exists');
            return;
        }
        
        // Check for overlaps
        const hasOverlap = targetSlots.some(slot => {
            const existingStart = new Date(`1/1/2023 ${slot.start24}`);
            const existingEnd = new Date(`1/1/2023 ${slot.end24}`);
            const newStart = new Date(`1/1/2023 ${newSlot.start24}`);
            const newEnd = new Date(`1/1/2023 ${newSlot.end24}`);
            
            return (newStart < existingEnd && newEnd > existingStart);
        });
        
        if (hasOverlap) {
            toastr.error('This time slot overlaps with an existing slot');
            return;
        }
        
        // Add the slot
        targetSlots.push(newSlot);
        
        // Sort by start time
        targetSlots.sort((a, b) => {
            return new Date(`1/1/2023 ${a.start24}`) - new Date(`1/1/2023 ${b.start24}`);
        });
        
        // Clear the input
        startTimeInput.value = '';
        
        // Update display
        if (isEdit) {
            displayEditGeneratedSlots();
        } else {
            displayGeneratedSlots();
        }
        
        toastr.success('Time slot added successfully');
    }
    
    function parseTimeString(timeStr) {
        // Handle formats like "9:00 AM", "14:30", "9 AM", "2:30 PM"
        const time = timeStr.trim().toUpperCase();
        
        if (time.includes('AM') || time.includes('PM')) {
            // 12-hour format
            const [timePart, period] = time.split(/\s+/);
            let [hours, minutes = '00'] = timePart.split(':');
            
            hours = parseInt(hours);
            minutes = parseInt(minutes);
            
            if (period === 'PM' && hours !== 12) hours += 12;
            if (period === 'AM' && hours === 12) hours = 0;
            
            const date = new Date();
            date.setHours(hours, minutes, 0, 0);
            return date;
        } else {
            // 24-hour format
            const [hours, minutes = '00'] = time.split(':');
            const date = new Date();
            date.setHours(parseInt(hours), parseInt(minutes), 0, 0);
            return date;
        }
    }
    
    function formatTime12Hour(date) {
        return date.toLocaleString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
    }
    
    function formatTime24Hour(date) {
        return date.toLocaleString('en-US', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        });
    }
    
    function displayGeneratedSlots() {
        const preview = document.getElementById('generatedSlotsPreview');
        const container = document.getElementById('slotsPreviewContainer');
        
        if (generatedSlots.length > 0) {
            container.innerHTML = generatedSlots.map((slot, index) => 
                `<div class="generated-slot-item">
                    ${slot.start} - ${slot.end}
                    <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="removeGeneratedSlot(${index}, false)" title="Remove this slot">
                        <i class="fas fa-times"></i>
                    </button>
                </div>`
            ).join('');
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    }
    
    function displayEditGeneratedSlots() {
        const preview = document.getElementById('editGeneratedSlotsPreview');
        const container = document.getElementById('editSlotsPreviewContainer');
        
        if (editGeneratedSlots.length > 0) {
            container.innerHTML = editGeneratedSlots.map((slot, index) => 
                `<div class="generated-slot-item">
                    ${slot.start} - ${slot.end}
                    <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="removeGeneratedSlot(${index}, true)" title="Remove this slot">
                        <i class="fas fa-times"></i>
                    </button>
                </div>`
            ).join('');
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    }
    
    function removeGeneratedSlot(index, isEdit = false) {
        if (isEdit) {
            editGeneratedSlots.splice(index, 1);
            displayEditGeneratedSlots();
        } else {
            generatedSlots.splice(index, 1);
            displayGeneratedSlots();
        }
        toastr.success('Time slot removed');
    }
    
    function clearAllSlots(isEdit = false) {
        if (isEdit) {
            editGeneratedSlots = [];
            displayEditGeneratedSlots();
        } else {
            generatedSlots = [];
            displayGeneratedSlots();
        }
        toastr.success('All time slots cleared');
    }

    // Show add modal
    window.showAddAvailabilityModal = function() {
        // Reset form
        document.getElementById('addAvailabilityForm').reset();
        
        // Reset slot generator
        generatedSlots = [];
        document.getElementById('slotStartTime').value = '';
        document.getElementById('generatedSlotsPreview').style.display = 'none';
        
        // Clear manual slots container
        timeSlotsContainer.innerHTML = '';
        
        // Show modal
        $('#addAvailabilityModal').modal('show');
    };

    // Function to convert time to 24-hour format
    function convertTo24Hour(time12h) {
        if (!time12h) return '';
        
        // If already in 24-hour format, return as is
        if (!time12h.includes('AM') && !time12h.includes('PM')) {
            return time12h;
        }
        
        // Allow lowercase am/pm and extra whitespace
        const parts = time12h.trim().split(' ');
        if (parts.length < 2) return time12h; // unexpected format
        const time = parts[0];
        const modifier = parts[1].toUpperCase();

        let [hoursStr, minutes] = time.split(':');
        let hours = parseInt(hoursStr, 10);
        if (isNaN(hours) || !minutes) return time12h;

        if (modifier === 'AM') {
            if (hours === 12) hours = 0;
        } else if (modifier === 'PM') {
            if (hours !== 12) hours = hours + 12;
        }

        const hoursPadded = String(hours).padStart(2, '0');
        return `${hoursPadded}:${minutes}`;
    }

    // Safely read input value, falling back to Flatpickr's internal input if needed
    function getInputValue(el) {
        if (!el) return '';
        const raw = (el.value || '').toString().trim();
        if (raw) return raw;
        if (el._flatpickr && el._flatpickr.input) {
            return (el._flatpickr.input.value || '').toString().trim();
        }
        return '';
    }

    // Handle add form submission
    $('#addAvailabilityForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        
        // Validation: Check if at least one weekday is selected
        const selectedWeekdays = document.querySelectorAll('input[name="weekdays[]"]:checked');
        if (selectedWeekdays.length === 0) {
            toastr.error("Please select at least one weekday");
            return false;
        }
        
        // Gather manual slots and validate presence when no generated slots
        const manualTimeSlots = document.querySelectorAll('#timeSlotsContainer .time-slot');
        if (generatedSlots.length === 0) {
            if (manualTimeSlots.length === 0) {
                toastr.error("Please generate time slots or add manual slots");
                return false;
            }

            for (const slot of manualTimeSlots) {
                const startEl = slot.querySelector('input[name="start_time[]"]');
                const endEl = slot.querySelector('input[name="end_time[]"]');
                const startTime = getInputValue(startEl);
                const endTime = getInputValue(endEl);

                if (!startEl || !endEl || !startTime || !endTime) {
                    toastr.error("Please fill all time slots");
                    return false;
                }
            }
        }

        // Build timeRanges from both generatedSlots and manual slots for overlap checking
        const timeRanges = [];
        // Add generated slots first
        if (generatedSlots.length > 0) {
            generatedSlots.forEach(slot => {
                if (slot.start && slot.end) {
                    timeRanges.push({ start: slot.start, end: slot.end });
                }
            });
        }

        // Add manual slots (if any)
        Array.from(manualTimeSlots).forEach(slot => {
            const startEl = slot.querySelector('input[name="start_time[]"]');
            const endEl = slot.querySelector('input[name="end_time[]"]');
            const startTime = getInputValue(startEl);
            const endTime = getInputValue(endEl);
            if (startTime && endTime) {
                timeRanges.push({ start: startTime, end: endTime });
            }
        });

        // Filter out incomplete ranges
        const filteredRanges = timeRanges.filter(tr => tr.start && tr.end);
        
        // Sort by start time for easier comparison
        filteredRanges.sort((a, b) => {
            return new Date(`1/1/2023 ${a.start}`) - new Date(`1/1/2023 ${b.start}`);
        });

        // Check for overlaps
        for (let i = 0; i < filteredRanges.length - 1; i++) {
            const currentEnd = new Date(`1/1/2023 ${filteredRanges[i].end}`);
            const nextStart = new Date(`1/1/2023 ${filteredRanges[i+1].start}`);

            if (currentEnd > nextStart) {
                toastr.error("Time slots cannot overlap. Please adjust your schedule.");
                return false;
            }
        }

        // Create custom FormData with proper slot format
        const formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    const monthEl = document.getElementById('month');
    const sessionDurationEl = document.getElementById('session_duration');
    formData.append('month', monthEl ? monthEl.value : '');
    formData.append('session_duration', sessionDurationEl ? sessionDurationEl.value : '60');
        
        // Add weekdays
        selectedWeekdays.forEach(checkbox => {
            formData.append('weekdays[]', checkbox.value);
        });
        
        // Add slots in the correct format
        let slotIndex = 0;
        
        // Use generated slots if available
        if (generatedSlots.length > 0) {
            generatedSlots.forEach((slot) => {
                formData.append(`slots[${slotIndex}][start_time]`, slot.start24);
                formData.append(`slots[${slotIndex}][end_time]`, slot.end24);
                slotIndex++;
            });
        } else {
            // Use manual slots
            const timeSlots = document.querySelectorAll('#timeSlotsContainer .time-slot');
            timeSlots.forEach((slot) => {
                const startEl = slot.querySelector('input[name="start_time[]"]');
                const endEl = slot.querySelector('input[name="end_time[]"]');
                if (!startEl || !endEl) return; // skip malformed slot

                const startTime = getInputValue(startEl);
                const endTime = getInputValue(endEl);
                if (!startTime || !endTime) return;

                // Convert to 24-hour format
                const startTime24 = convertTo24Hour(startTime);
                const endTime24 = convertTo24Hour(endTime);

                formData.append(`slots[${slotIndex}][start_time]`, startTime24);
                formData.append(`slots[${slotIndex}][end_time]`, endTime24);
                slotIndex++;
            });
        }

        $.ajax({
            url: "{{ route('admin.professional.availability.store', $professional->id) }}",
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
                    toastr.success(response.message || "Availability added successfully");
                    form.reset();
                    $('#addAvailabilityModal').modal('hide');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    toastr.error(response.message || "Error adding availability");
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(key => {
                        errors[key].forEach(error => {
                            toastr.error(error);
                        });
                    });
                } else {
                    toastr.error(xhr.responseJSON?.message || "Unexpected error occurred");
                }
            }
        });
    });

    // Handle edit form submission
    $('#editAvailabilityForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        
        // Validation: Check if at least one weekday is selected
        const selectedWeekdays = document.querySelectorAll('#editAvailabilityModal input[name="weekdays[]"]:checked');
        if (selectedWeekdays.length === 0) {
            toastr.error("Please select at least one weekday");
            return false;
        }
        
        // Validation: Check if all time slots are filled
        const timeSlots = document.querySelectorAll('#editTimeSlotsContainer .time-slot');
        for (const slot of timeSlots) {
            const startEl = slot.querySelector('input[name="start_time[]"]');
            const endEl = slot.querySelector('input[name="end_time[]"]');
            const startTime = startEl ? startEl.value : null;
            const endTime = endEl ? endEl.value : null;

            if (!startEl || !endEl || !startTime || !endTime) {
                toastr.error("Please fill all time slots");
                return false;
            }
        }
        
        // Create custom FormData with proper slot format
        const formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('_method', 'PUT');
    const editMonthEl = document.getElementById('edit_month');
    const editSessionDurationEl = document.getElementById('edit_session_duration');
    formData.append('month', editMonthEl ? editMonthEl.value : '');
    formData.append('session_duration', editSessionDurationEl ? editSessionDurationEl.value : '60');
        
        // Add weekdays
        selectedWeekdays.forEach(checkbox => {
            formData.append('weekdays[]', checkbox.value);
        });
        
        // Add slots in the correct format
        let slotIndex = 0;
        
        // Use generated slots if available
        if (editGeneratedSlots.length > 0) {
            editGeneratedSlots.forEach((slot) => {
                formData.append(`slots[${slotIndex}][start_time]`, slot.start24);
                formData.append(`slots[${slotIndex}][end_time]`, slot.end24);
                slotIndex++;
            });
        } else {
            // Use manual slots
            const timeSlots = document.querySelectorAll('#editTimeSlotsContainer .time-slot');
            timeSlots.forEach((slot) => {
                const startEl = slot.querySelector('input[name="start_time[]"]');
                const endEl = slot.querySelector('input[name="end_time[]"]');
                if (!startEl || !endEl) return;

                const startTime = startEl.value;
                const endTime = endEl.value;
                if (!startTime || !endTime) return;

                // Convert to 24-hour format
                const startTime24 = convertTo24Hour(startTime);
                const endTime24 = convertTo24Hour(endTime);

                formData.append(`slots[${slotIndex}][start_time]`, startTime24);
                formData.append(`slots[${slotIndex}][end_time]`, endTime24);
                slotIndex++;
            });
        }

        $.ajax({
            url: form.action,
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
                    toastr.success(response.message || "Availability updated successfully");
                    form.reset();
                    $('#editAvailabilityModal').modal('hide');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    toastr.error(response.message || "Error updating availability");
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(key => {
                        errors[key].forEach(error => {
                            toastr.error(error);
                        });
                    });
                } else {
                    toastr.error(xhr.responseJSON?.message || "Unexpected error occurred");
                }
            }
        });
    });

    // Edit availability function
    window.editAvailability = function(availabilityId) {
        const availabilities = @json($availabilities);
        const availability = availabilities.find(a => a.id === availabilityId);
        
        if (availability) {
            // Set form values
            $('#edit_month').val(availability.month || '');
            $('#edit_session_duration').val(availability.session_duration || 60);
            
            // Handle weekdays
            const weekdayCheckboxes = document.querySelectorAll('#editAvailabilityModal input[name="weekdays[]"]');
            weekdayCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
                const selectedWeekdays = availability.weekdays ? JSON.parse(availability.weekdays) : [];
                if (selectedWeekdays.includes(checkbox.value)) {
                    checkbox.checked = true;
                }
            });
            
            // Reset edit slot generator (use new field IDs and guard nulls)
            editGeneratedSlots = [];
            const editSlotStartEl = document.getElementById('editSlotStartTime');
            if (editSlotStartEl) editSlotStartEl.value = '';
            const editNumEl = document.getElementById('editNumberOfSlots');
            if (editNumEl) editNumEl.value = availability.slots ? availability.slots.length : '1';
            const editPreviewEl = document.getElementById('editGeneratedSlotsPreview');
            if (editPreviewEl) editPreviewEl.style.display = 'none';
            
            // Clear and populate time slots
            const editContainer = document.getElementById('editTimeSlotsContainer');
            if (editContainer) {
                editContainer.innerHTML = '';
                
                if (availability.slots && availability.slots.length > 0) {
                    availability.slots.forEach(slot => {
                        createEditTimeSlot(slot.start_time, slot.end_time);
                    });
                } else {
                    createEditTimeSlot();
                }
            }
            
            // Set form action
            $('#editAvailabilityForm').attr('action', '{{ route('admin.professional.availability.update', ['professional' => $professional->id, 'availability' => '__AVAILABILITY_ID__']) }}'.replace('__AVAILABILITY_ID__', availabilityId));
            $('#editAvailabilityModal').modal('show');
        }
    };

    // Create edit time slot
    function createEditTimeSlot(start = '', end = '') {
        const editContainer = document.getElementById('editTimeSlotsContainer');
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
            <button type="button" class="remove-slot-btn" onclick="removeEditTimeSlot(this)" title="Remove slot">
                <i class="fas fa-trash"></i>
            </button>
        `;
        editContainer.appendChild(div);
        initializeFlatpickr();
    }

    // Remove edit time slot
    window.removeEditTimeSlot = function(button) {
        const editContainer = document.getElementById('editTimeSlotsContainer');
        const timeSlots = editContainer.querySelectorAll('.time-slot');
        if (timeSlots.length > 1) {
            button.closest('.time-slot').remove();
        } else {
            const inputs = button.closest('.time-slot').querySelectorAll('input');
            inputs.forEach(input => {
                input.value = '';
                if (input._flatpickr) {
                    input._flatpickr.clear();
                }
            });
        }
    };



    // Toggle between generated and manual modes
    document.getElementById('toggleManualMode')?.addEventListener('click', function() {
        const slotConfig = document.querySelector('.slot-config');
        const generatedPreview = document.getElementById('generatedSlotsPreview');
        const manualContainer = document.getElementById('timeSlotsContainer');
        const addBtn = document.getElementById('addSlotBtn');
        const toggleBtn = this;
        
        if (manualContainer.style.display === 'none') {
            // Switch to manual mode
            slotConfig.style.display = 'none';
            generatedPreview.style.display = 'none';
            manualContainer.style.display = 'block';
            addBtn.style.display = 'inline-block';
            toggleBtn.innerHTML = '<i class="fas fa-magic"></i> Switch to Auto Mode';
            
            // Clear generated slots and add one manual slot
            generatedSlots = [];
            if (manualContainer.children.length === 0) {
                createTimeSlot();
            }
        } else {
            // Switch to auto mode
            slotConfig.style.display = 'grid';
            manualContainer.style.display = 'none';
            addBtn.style.display = 'none';
            toggleBtn.innerHTML = '<i class="fas fa-cog"></i> Switch to Manual Mode';
            
            // Clear manual slots
            manualContainer.innerHTML = '';
        }
    });
    
    document.getElementById('toggleEditManualMode')?.addEventListener('click', function() {
        const slotConfig = document.querySelector('#editAvailabilityModal .slot-config');
        const generatedPreview = document.getElementById('editGeneratedSlotsPreview');
        const manualContainer = document.getElementById('editTimeSlotsContainer');
        const addBtn = document.getElementById('addEditSlotBtn');
        const toggleBtn = this;
        
        if (manualContainer.style.display === 'none') {
            // Switch to manual mode
            slotConfig.style.display = 'none';
            generatedPreview.style.display = 'none';
            manualContainer.style.display = 'block';
            addBtn.style.display = 'inline-block';
            toggleBtn.innerHTML = '<i class="fas fa-magic"></i> Switch to Auto Mode';
            
            // Clear generated slots and add one manual slot
            editGeneratedSlots = [];
            if (manualContainer.children.length === 0) {
                createEditTimeSlot();
            }
        } else {
            // Switch to auto mode
            slotConfig.style.display = 'grid';
            manualContainer.style.display = 'none';
            addBtn.style.display = 'none';
            toggleBtn.innerHTML = '<i class="fas fa-cog"></i> Switch to Manual Mode';
            
            // Clear manual slots
            manualContainer.innerHTML = '';
        }
    });

    // Add edit slot button
    document.getElementById('addEditSlotBtn')?.addEventListener('click', () => createEditTimeSlot());

    // Add individual slot buttons
    document.getElementById('addGeneratedSlotBtn')?.addEventListener('click', () => addIndividualSlot(false));
    document.getElementById('editAddGeneratedSlotBtn')?.addEventListener('click', () => addIndividualSlot(true));
    
    // Clear all slots buttons
    document.getElementById('clearAllSlotsBtn')?.addEventListener('click', () => clearAllSlots(false));
    document.getElementById('editClearAllSlotsBtn')?.addEventListener('click', () => clearAllSlots(true));
    
    // Handle Enter key in slot input fields
    document.getElementById('slotStartTime')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addIndividualSlot(false);
        }
    });
    
    document.getElementById('editSlotStartTime')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addIndividualSlot(true);
        }
    });

    // Delete availability
    window.deleteAvailability = function(availabilityId) {
        if (confirm('Are you sure you want to delete this availability schedule?')) {
            $.ajax({
                url: '{{ route('admin.professional.availability.delete', ['professional' => $professional->id, 'availability' => '__AVAILABILITY_ID__']) }}'.replace('__AVAILABILITY_ID__', availabilityId),
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message || 'Availability deleted successfully');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        toastr.error(response.message || 'Error deleting availability');
                    }
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'An error occurred while deleting');
                }
            });
        }
    };

    // Modal management
    $('.modal').on('hidden.bs.modal', function() {
        const modal = $(this);
        
        // Reset forms
        modal.find('form')[0]?.reset();
        modal.find('input[type="checkbox"]').prop('checked', false);
        modal.find('select').prop('selectedIndex', 0);
        
        // Clear time slots and reset containers
        if (modal.attr('id') === 'addAvailabilityModal') {
            // Reset slot generator
            generatedSlots = [];
            const slotStartTime = document.getElementById('slotStartTime');
            if (slotStartTime) slotStartTime.value = '';
            const generatedPreviewEl = document.getElementById('generatedSlotsPreview');
            if (generatedPreviewEl) generatedPreviewEl.style.display = 'none';
            
            if (timeSlotsContainer) {
                timeSlotsContainer.innerHTML = '';
            }
        } else if (modal.attr('id') === 'editAvailabilityModal') {
            // Reset edit slot generator
            editGeneratedSlots = [];
            const editSlotStartTime = document.getElementById('editSlotStartTime');
            if (editSlotStartTime) editSlotStartTime.value = '';
            const editGeneratedPreviewEl = document.getElementById('editGeneratedSlotsPreview');
            if (editGeneratedPreviewEl) editGeneratedPreviewEl.style.display = 'none';
            
            const editContainer = document.getElementById('editTimeSlotsContainer');
            if (editContainer) {
                editContainer.innerHTML = '';
            }
        }
        
        // Clear any validation errors
        modal.find('.is-invalid').removeClass('is-invalid');
        modal.find('.invalid-feedback').remove();
    });

    // Handle close button clicks - prevent event bubbling
    $('.modal .close, .modal [data-dismiss="modal"], .modal .btn-secondary').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).closest('.modal').modal('hide');
    });

    // Handle modal backdrop clicks
    $('.modal').on('click', function(e) {
        if (e.target === this) {
            $(this).modal('hide');
        }
    });

    // Prevent modal from closing when clicking inside modal content
    $('.modal-content').on('click', function(e) {
        e.stopPropagation();
    });
});
</script>
@endsection