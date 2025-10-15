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
        gap: 0.25rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.875rem;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
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

    #editSelectAllMonths:checked ~ #editMonthsGrid .month-checkbox-label {
        background: #f0f9ff;
        border-color: #4f46e5;
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
                                        // Handle both old format (jan, feb, etc.), new format (2025-10),
                                        // and the special 'all_months' value which means the next 6 months.
                                        $monthValue = $availability->month;

                                        if ($monthValue === 'all_months') {
                                            // Build a human-readable list of the next 6 months
                                            $months = [];
                                            $currentDate = now();
                                            for ($i = 0; $i < 6; $i++) {
                                                $months[] = $currentDate->copy()->addMonths($i)->format('F Y');
                                            }
                                            $fullMonth = implode(', ', $months);
                                        } elseif (strpos($monthValue, '-') !== false) {
                                            // New format: 2025-10
                                            try {
                                                $fullMonth = \Carbon\Carbon::createFromFormat('Y-m', $monthValue)->format('F Y');
                                            } catch (\Exception $e) {
                                                $fullMonth = $monthValue;
                                            }
                                        } else {
                                            // Old format: jan, feb, etc.
                                            $monthNames = [
                                                'jan' => 'January', 'feb' => 'February', 'mar' => 'March', 
                                                'apr' => 'April', 'may' => 'May', 'jun' => 'June',
                                                'jul' => 'July', 'aug' => 'August', 'sep' => 'September',
                                                'oct' => 'October', 'nov' => 'November', 'dec' => 'December'
                                            ];
                                            $fullMonth = $monthNames[$monthValue] ?? ucfirst($monthValue);
                                        }
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
                                    <button onclick="editAvailability({{ $availability->id }})" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button onclick="deleteAvailability({{ $availability->id }})" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                    <button onclick="editSpecificMonth('{{ $availability->month }}', {{ $availability->id }})" class="btn btn-info btn-sm">
                                        <i class="fas fa-calendar-edit"></i> Edit This Month Only
                                    </button>
                                </div>
                            </div>
                            
                            <div class="availability-slots">
                                @if($availability->slots && $availability->slots->count() > 0)
                                    @foreach($availability->slots as $slot)
                                        <div class="slot-badge">
                                            @php
                                                // Use Carbon::parse so both "H:i" and "H:i:s" are accepted
                                                try {
                                                    $startTime = \Carbon\Carbon::parse($slot->start_time)->format('g:i A');
                                                } catch (\Exception $e) {
                                                    $startTime = $slot->start_time;
                                                }

                                                try {
                                                    $endTime = \Carbon\Carbon::parse($slot->end_time)->format('g:i A');
                                                } catch (\Exception $e) {
                                                    $endTime = $slot->end_time;
                                                }
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
                                @endphp
                                        <label class="month-checkbox-label" style="display: flex; align-items: center; padding: 8px 12px; background: white; border: 1px solid #d1d5db; border-radius: 6px; cursor: pointer; transition: all 0.2s;">
                                            <input type="checkbox" name="months[]" value="{{ $monthKey }}" class="month-checkbox mr-2">
                                            <span>{{ $monthDisplay }}</span>
                                        </label>
                                @php
                                    }
                                @endphp
                            </div>
                            <div class="text-muted mt-2" style="font-size: 0.875rem;">
                                <i class="fas fa-info-circle"></i>
                                Select one or multiple months to create availability schedules.
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="session_duration">Session Duration</label>
                        <select class="form-control" id="session_duration" name="session_duration" required>
                            @foreach([30, 45, 60, 90, 120] as $duration)
                                <option value="{{ $duration }}" {{ $duration == 60 ? 'selected' : '' }}>
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
                                <label>Slot Start Time</label>
                                <div style="display: flex; gap: 5px; align-items: center;">
                                    <input type="text" id="slotHour" class="form-control" style="width: 80px;" placeholder="Hr" maxlength="2">
                                    <span>:</span>
                                    <input type="text" id="slotMinute" class="form-control" style="width: 80px;" placeholder="MM" maxlength="2">
                                    <select id="slotAMPM" class="form-control" style="width: 80px;">
                                        <option value="">--</option>
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                                <input type="hidden" id="slotStartTime" />
                            </div>
                            <div>
                                <button type="button" class="btn btn-success" id="addGeneratedSlotBtn">
                                    <i class="fas fa-plus"></i> Add This Slot
                                </button>
                            </div>
                        </div>
                        
                        <div class="text-muted mb-3" style="font-size: 0.9em;">
                            <i class="fas fa-info-circle"></i> 
                            Add individual time slots using AM/PM format only. End time will be calculated automatically based on session duration.
                            <br>Examples: "9:00 AM" → 9:00-9:30 AM (30min), "3:00 PM" → 3:00-4:00 PM (60min)
                        </div>

                        <!-- Generated Slots Preview -->
                        <div id="generatedSlotsPreview" class="generated-slots" style="display: none;">
                            <h6>Added Time Slots:</h6>
                            <div id="slotsPreviewContainer"></div>
                            <button type="button" class="btn btn-danger btn-sm" id="clearAllSlotsBtn" style="margin-top: 10px;">
                                <i class="fas fa-trash"></i> Clear All Slots
                            </button>
                        </div>
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
                    <div class="form-group mb-3">
                        <label>Select Months</label>
                        <div class="month-selection-container" style="background: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #dee2e6;">
                            <div class="d-flex align-items-center mb-3">
                                <label class="d-flex align-items-center mb-0" style="cursor: pointer;">
                                    <input type="checkbox" id="editSelectAllMonths" class="mr-2">
                                    <strong>Select All Next 6 Months</strong>
                                </label>
                            </div>
                            <div class="months-grid" id="editMonthsGrid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
                                @php
                                    $currentDate = now();
                                    for ($i = 0; $i < 6; $i++) {
                                        $monthDate = $currentDate->copy()->addMonths($i);
                                        $monthKey = $monthDate->format('Y-m'); // e.g., 2025-10
                                        $monthDisplay = $monthDate->format('F Y'); // e.g., October 2025
                                @endphp
                                        <label class="month-checkbox-label" style="display: flex; align-items: center; padding: 8px 12px; background: white; border: 1px solid #d1d5db; border-radius: 6px; cursor: pointer; transition: all 0.2s;">
                                            <input type="checkbox" name="months[]" value="{{ $monthKey }}" class="edit-month-checkbox mr-2">
                                            <span>{{ $monthDisplay }}</span>
                                        </label>
                                @php
                                    }
                                @endphp
                            </div>
                            <div class="text-muted mt-2" style="font-size: 0.875rem;">
                                <i class="fas fa-info-circle"></i>
                                Select one or multiple months to create availability schedules.
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_session_duration">Session Duration</label>
                        <select class="form-control" id="edit_session_duration" name="session_duration" required>
                            @foreach([30, 45, 60, 90, 120] as $duration)
                                <option value="{{ $duration }}">
                                    {{ $duration }} {{ $duration == 120 ? 'minutes (2 hours)' : 'minutes' }}
                                </option>
                            @endforeach
                        </select>
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
                                <label>Slot Start Time</label>
                                <div style="display: flex; gap: 5px; align-items: center;">
                                    <input type="text" id="editSlotHour" class="form-control" style="width: 80px;" placeholder="Hr" maxlength="2">
                                    <span>:</span>
                                    <input type="text" id="editSlotMinute" class="form-control" style="width: 80px;" placeholder="MM" maxlength="2">
                                    <select id="editSlotAMPM" class="form-control" style="width: 80px;">
                                        <option value="">--</option>
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                                <input type="hidden" id="editSlotStartTime" />
                            </div>
                            <div>
                                <button type="button" class="btn btn-success" id="editAddGeneratedSlotBtn">
                                    <i class="fas fa-plus"></i> Add This Slot
                                </button>
                            </div>
                        </div>
                        
                        <div class="text-muted mb-3" style="font-size: 0.9em;">
                            <i class="fas fa-info-circle"></i> 
                            Add individual time slots using AM/PM format only. End time will be calculated automatically based on session duration.
                            <br>Examples: "9:00 AM" → 9:00-9:30 AM (30min), "3:00 PM" → 3:00-4:00 PM (60min)
                        </div>

                        <!-- Generated Slots Preview -->
                        <div id="editGeneratedSlotsPreview" class="generated-slots" style="display: none;">
                            <h6>Added Time Slots:</h6>
                            <div id="editSlotsPreviewContainer"></div>
                            <button type="button" class="btn btn-danger btn-sm" id="editClearAllSlotsBtn" style="margin-top: 10px;">
                                <i class="fas fa-trash"></i> Clear All Slots
                            </button>
                        </div>
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
    // Initialize month checkboxes functionality
    setupMonthCheckboxes();
    // Generate slots - individual slot addition
    let generatedSlots = [];
    let editGeneratedSlots = [];
    
    // Handle select all months functionality
    function setupMonthCheckboxes() {
        // For Add Modal
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
        
        // For Edit Modal
        const editSelectAllMonths = document.getElementById('editSelectAllMonths');
        const editMonthCheckboxes = document.querySelectorAll('.edit-month-checkbox');
        
        if (editSelectAllMonths) {
            editSelectAllMonths.addEventListener('change', function() {
                editMonthCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        }
        
        editMonthCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allChecked = Array.from(editMonthCheckboxes).every(cb => cb.checked);
                const anyChecked = Array.from(editMonthCheckboxes).some(cb => cb.checked);
                
                if (editSelectAllMonths) {
                    editSelectAllMonths.checked = allChecked;
                    editSelectAllMonths.indeterminate = anyChecked && !allChecked;
                }
            });
        });
    }
    
    function addIndividualSlot(isEdit = false) {
        const prefix = isEdit ? 'editSlot' : 'slot';
        const hourInput = document.getElementById(prefix + 'Hour');
        const minuteInput = document.getElementById(prefix + 'Minute');
        const ampmSelect = document.getElementById(prefix + 'AMPM');

        let hour = (hourInput?.value || '').toString().trim();
        let minute = (minuteInput?.value || '').toString().trim();
        const ampm = (ampmSelect?.value || '').toString().trim();

        // Validation
        if (!hour || !minute || !ampm) {
            toastr.error('Please enter hour, minute and select AM/PM');
            return;
        }

        // Normalize numeric inputs
        // Remove non-digits
        hour = hour.replace(/[^0-9]/g, '');
        minute = minute.replace(/[^0-9]/g, '');

        if (hour === '') hour = '0';
        if (minute === '') minute = '00';

        let hourNum = parseInt(hour, 10);
        let minuteNum = parseInt(minute, 10);

        if (isNaN(hourNum) || isNaN(minuteNum)) {
            toastr.error('Invalid hour or minute');
            return;
        }

        // Clamp hour to 1-12
        if (hourNum < 1) hourNum = 1;
        if (hourNum > 12) hourNum = 12;

        // Clamp minutes to 0-59
        if (minuteNum < 0) minuteNum = 0;
        if (minuteNum > 59) minuteNum = 59;

        // Pad minutes
        const hourStr = String(hourNum);
        const minuteStr = String(minuteNum).padStart(2, '0');

        // Construct time string
        const startTime = `${hourStr}:${minuteStr} ${ampm}`;
        
        const sessionDuration = isEdit ? 
            parseInt(document.getElementById('edit_session_duration')?.value || 60) : 
            parseInt(document.getElementById('session_duration')?.value || 60);
        
        // Parse start time
        const startDate = parseAMPMTime(startTime);
        if (!startDate) {
            toastr.error('Invalid time selection');
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
        
    // Clear the inputs
    if (hourInput) hourInput.value = '';
    if (minuteInput) minuteInput.value = '00'; // Reset to 00
    if (ampmSelect) ampmSelect.value = '';
        
        // Update display
        if (isEdit) {
            displayEditGeneratedSlots();
        } else {
            displayGeneratedSlots();
        }
        
        toastr.success('Time slot added successfully');
    }
    
    // Validate AM/PM format
    function isValidAMPMFormat(timeStr) {
        const ampmRegex = /^(1[0-2]|0?[1-9]):([0-5][0-9])\s?(AM|PM)$/i;
        return ampmRegex.test(timeStr.trim());
    }
    
    // Parse AM/PM time string to Date object
    function parseAMPMTime(timeStr) {
        const time = timeStr.trim().toUpperCase();
        
        if (!(time.includes('AM') || time.includes('PM'))) {
            return null; // Only accept AM/PM format
        }
        
        const [timePart, period] = time.split(/\s+/);
        let [hours, minutes = '00'] = timePart.split(':');
        
        hours = parseInt(hours);
        minutes = parseInt(minutes);
        
        if (hours < 1 || hours > 12 || minutes < 0 || minutes > 59) {
            return null;
        }
        
        if (period === 'PM' && hours !== 12) hours += 12;
        if (period === 'AM' && hours === 12) hours = 0;
        
        const date = new Date();
        date.setHours(hours, minutes, 0, 0);
        return date;
    }
    
    function formatTime12Hour(date) {
        return date.toLocaleString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
    }
    
    function formatTime24Hour(date) {
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        return `${hours}:${minutes}`;
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

    // Make functions globally available
    window.removeGeneratedSlot = removeGeneratedSlot;
    window.clearAllSlots = clearAllSlots;

    // Show add modal
    window.showAddAvailabilityModal = function() {
        // Reset form
        document.getElementById('addAvailabilityForm').reset();
        
        // Reset slot generator
        generatedSlots = [];
        document.getElementById('slotStartTime').value = '';
        document.getElementById('generatedSlotsPreview').style.display = 'none';
        
        // Clear manual slots container (if present)
        if (typeof timeSlotsContainer !== 'undefined' && timeSlotsContainer) {
            timeSlotsContainer.innerHTML = '';
        }
        
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
        
        // Validation: Check if time slots are generated
        if (generatedSlots.length === 0) {
            toastr.error("Please add at least one time slot using AM/PM format");
            return false;
        }

        // Check for overlaps in generated slots
        const filteredSlots = generatedSlots.filter(slot => slot.start && slot.end);
        
        // Sort by start time for easier comparison
        filteredSlots.sort((a, b) => {
            return new Date(`1/1/2023 ${a.start}`) - new Date(`1/1/2023 ${b.start}`);
        });

        // Check for overlaps
        for (let i = 0; i < filteredSlots.length - 1; i++) {
            const currentEnd = new Date(`1/1/2023 ${filteredSlots[i].end}`);
            const nextStart = new Date(`1/1/2023 ${filteredSlots[i+1].start}`);

            if (currentEnd > nextStart) {
                toastr.error("Time slots cannot overlap. Please adjust your schedule.");
                return false;
            }
        }

        // Create custom FormData with proper slot format
        const formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        
        // Add selected months
        selectedMonths.forEach(checkbox => {
            formData.append('months[]', checkbox.value);
        });
        
        const sessionDurationEl = document.getElementById('session_duration');
        formData.append('session_duration', sessionDurationEl ? sessionDurationEl.value : '60');
        
        // Add weekdays
        selectedWeekdays.forEach(checkbox => {
            formData.append('weekdays[]', checkbox.value);
        });
        
        // Add generated slots
        generatedSlots.forEach((slot, index) => {
            formData.append(`slots[${index}][start_time]`, slot.start24);
            formData.append(`slots[${index}][end_time]`, slot.end24);
        });

        // Show loading message for multiple months
        if (selectedMonths.length > 1) {
            toastr.info(`Creating availability for ${selectedMonths.length} months... This may take a moment.`);
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
                try {
                    // Prefer structured details when provided
                    const details = response.details || { successful: [], skipped: [], errors: [] };
                    const created = details.successful || [];
                    const skipped = details.skipped || [];
                    const errors = details.errors || [];

                    if (created.length > 0) {
                        toastr.success((response.message || 'Availability created for ' + created.length + ' month(s)'));
                    }

                    if (skipped.length > 0) {
                        toastr.warning((skipped.length) + ' month(s) were skipped because availability already exists: ' + skipped.join(', '));
                        console.warn('Skipped months:', skipped);
                    }

                    if (errors.length > 0) {
                        toastr.error((errors.length) + ' month(s) failed to create. See console for details');
                        console.error('Availability create errors:', errors);
                    }

                    // Reset form and UI only if at least one month was created
                    if (created.length > 0) {
                        form.reset();
                        document.querySelectorAll('input[name="months[]"]').forEach(cb => cb.checked = false);
                        const selectAll = document.getElementById('selectAllMonths');
                        if (selectAll) { selectAll.checked = false; selectAll.indeterminate = false; }
                        $('#addAvailabilityModal').modal('hide');
                        setTimeout(() => { window.location.reload(); }, 1200);
                    }
                } catch (e) {
                    console.error('Unexpected response format', response, e);
                    toastr.error(response.message || 'Unexpected response from server');
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
        
        // Validation: Check if at least one month is selected
        const selectedMonths = document.querySelectorAll('#editAvailabilityModal input[name="months[]"]:checked');
        if (selectedMonths.length === 0) {
            toastr.error("Please select at least one month");
            return false;
        }
        
        // Validation: Check if at least one weekday is selected
        const selectedWeekdays = document.querySelectorAll('#editAvailabilityModal input[name="weekdays[]"]:checked');
        if (selectedWeekdays.length === 0) {
            toastr.error("Please select at least one weekday");
            return false;
        }
        
        // Validation: Check if time slots are generated
        if (editGeneratedSlots.length === 0) {
            toastr.error("Please add at least one time slot using AM/PM format");
            return false;
        }
        
        // Create custom FormData with proper slot format
        const formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('_method', 'PUT');
        
        // Add selected months
        selectedMonths.forEach(checkbox => {
            formData.append('months[]', checkbox.value);
        });
        
        const editSessionDurationEl = document.getElementById('edit_session_duration');
        formData.append('session_duration', editSessionDurationEl ? editSessionDurationEl.value : '60');
        
        // Add weekdays
        selectedWeekdays.forEach(checkbox => {
            formData.append('weekdays[]', checkbox.value);
        });
        
        // Add generated slots
        editGeneratedSlots.forEach((slot, index) => {
            formData.append(`slots[${index}][start_time]`, slot.start24);
            formData.append(`slots[${index}][end_time]`, slot.end24);
        });

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
                try {
                    const details = response.details || { successful: [], skipped: [], errors: [] };
                    const updated = details.successful || [];
                    const skipped = details.skipped || [];
                    const errors = details.errors || [];

                    if (updated.length > 0) {
                        toastr.success((response.message || 'Availability updated for ' + updated.length + ' month(s)'));
                    }

                    if (skipped.length > 0) {
                        toastr.warning((skipped.length) + ' month(s) were skipped because availability already exists: ' + skipped.join(', '));
                        console.warn('Skipped months:', skipped);
                    }

                    if (errors.length > 0) {
                        toastr.error((errors.length) + ' month(s) failed to update. See console for details');
                        console.error('Availability update errors:', errors);
                    }

                    // Reset form and UI only if at least one month was created/updated
                    if (updated.length > 0) {
                        form.reset();
                        document.querySelectorAll('#editAvailabilityModal input[name="months[]"]').forEach(cb => cb.checked = false);
                        const editSelectAll = document.getElementById('editSelectAllMonths');
                        if (editSelectAll) { editSelectAll.checked = false; editSelectAll.indeterminate = false; }
                        $('#editAvailabilityModal').modal('hide');
                        setTimeout(() => { window.location.reload(); }, 1200);
                    }
                } catch (e) {
                    console.error('Unexpected response format', response, e);
                    toastr.error(response.message || 'Unexpected response from server');
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

    // Edit specific month only
    window.editSpecificMonth = function(monthValue, availabilityId) {
        const availabilities = @json($availabilities);
        const availability = availabilities.find(a => a.id === availabilityId);
        
        if (availability) {
            // Reset all month checkboxes first
            document.querySelectorAll('#editAvailabilityModal input[name="months[]"]').forEach(cb => {
                cb.checked = false;
            });
            
            // Set only the specific month checkbox
            const monthCheckbox = document.querySelector(`#editAvailabilityModal input[name="months[]"][value="${monthValue}"]`);
            if (monthCheckbox) {
                monthCheckbox.checked = true;
            }
            
            // Update select all checkbox state (should be false since only one is selected)
            const editSelectAllMonths = document.getElementById('editSelectAllMonths');
            if (editSelectAllMonths) {
                editSelectAllMonths.checked = false;
                editSelectAllMonths.indeterminate = false;
            }
            
            // Set session duration
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
            
            // Reset edit slot generator
            editGeneratedSlots = [];
            
            // Reset input/select for edit slot generator
            const editHourInput = document.getElementById('editSlotHour');
            const editMinuteInput = document.getElementById('editSlotMinute');
            const editAmpmSelect = document.getElementById('editSlotAMPM');

            if (editHourInput) editHourInput.value = '';
            if (editMinuteInput) editMinuteInput.value = '00';
            if (editAmpmSelect) editAmpmSelect.value = '';
            
            const editPreviewEl = document.getElementById('editGeneratedSlotsPreview');
            if (editPreviewEl) editPreviewEl.style.display = 'none';
            
            // Convert existing slots to generated slots format
            if (availability.slots && availability.slots.length > 0) {
                availability.slots.forEach(slot => {
                    // Convert 24-hour time to 12-hour format for display
                    let startTime24 = slot.start_time;
                    let endTime24 = slot.end_time;
                    
                    // Remove seconds if present (convert H:i:s to H:i)
                    if (startTime24.includes(':') && startTime24.split(':').length === 3) {
                        startTime24 = startTime24.substring(0, 5); // Keep only HH:MM
                    }
                    if (endTime24.includes(':') && endTime24.split(':').length === 3) {
                        endTime24 = endTime24.substring(0, 5); // Keep only HH:MM
                    }
                    
                    // Parse and format times
                    const startDate = new Date(`1/1/2023 ${startTime24}`);
                    const endDate = new Date(`1/1/2023 ${endTime24}`);
                    
                    const slotData = {
                        start: formatTime12Hour(startDate),
                        end: formatTime12Hour(endDate),
                        start24: startTime24,
                        end24: endTime24
                    };
                    
                    editGeneratedSlots.push(slotData);
                });
                
                // Display the existing slots
                displayEditGeneratedSlots();
            }
            
            // Set form action and update modal title
            $('#editAvailabilityForm').attr('action', '{{ route('admin.professional.availability.update', ['professional' => $professional->id, 'availability' => '__AVAILABILITY_ID__']) }}'.replace('__AVAILABILITY_ID__', availabilityId));
            $('#editAvailabilityModalLabel').text('Edit Specific Month Only');
            $('#editAvailabilityModal').modal('show');
        }
    };

    // Edit availability function
    window.editAvailability = function(availabilityId) {
        const availabilities = @json($availabilities);
        const availability = availabilities.find(a => a.id === availabilityId);
        
        if (availability) {
            // Reset all month checkboxes first
            document.querySelectorAll('#editAvailabilityModal input[name="months[]"]').forEach(cb => {
                cb.checked = false;
            });
            
            // Set the month checkbox for this availability
            const monthValue = availability.month;
            const monthCheckbox = document.querySelector(`#editAvailabilityModal input[name="months[]"][value="${monthValue}"]`);
            if (monthCheckbox) {
                monthCheckbox.checked = true;
            }
            
            // Update select all checkbox state
            const editSelectAllMonths = document.getElementById('editSelectAllMonths');
            const editMonthCheckboxes = document.querySelectorAll('#editAvailabilityModal input[name="months[]"]');
            const checkedMonths = document.querySelectorAll('#editAvailabilityModal input[name="months[]"]:checked');
            
            if (editSelectAllMonths) {
                editSelectAllMonths.checked = checkedMonths.length === editMonthCheckboxes.length;
                editSelectAllMonths.indeterminate = checkedMonths.length > 0 && checkedMonths.length < editMonthCheckboxes.length;
            }
            
            // Set session duration
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
            
            // Reset edit slot generator
            editGeneratedSlots = [];
            
            // Reset input/select for edit slot generator
            const editHourInput = document.getElementById('editSlotHour');
            const editMinuteInput = document.getElementById('editSlotMinute');
            const editAmpmSelect = document.getElementById('editSlotAMPM');

            if (editHourInput) editHourInput.value = '';
            if (editMinuteInput) editMinuteInput.value = '00';
            if (editAmpmSelect) editAmpmSelect.value = '';
            
            const editPreviewEl = document.getElementById('editGeneratedSlotsPreview');
            if (editPreviewEl) editPreviewEl.style.display = 'none';
            
            // Convert existing slots to generated slots format
            if (availability.slots && availability.slots.length > 0) {
                availability.slots.forEach(slot => {
                    // Convert 24-hour time to 12-hour format for display
                    let startTime24 = slot.start_time;
                    let endTime24 = slot.end_time;
                    
                    // Remove seconds if present (convert H:i:s to H:i)
                    if (startTime24.includes(':') && startTime24.split(':').length === 3) {
                        startTime24 = startTime24.substring(0, 5); // Keep only HH:MM
                    }
                    if (endTime24.includes(':') && endTime24.split(':').length === 3) {
                        endTime24 = endTime24.substring(0, 5); // Keep only HH:MM
                    }
                    
                    // Parse and format times
                    const startDate = new Date(`1/1/2023 ${startTime24}`);
                    const endDate = new Date(`1/1/2023 ${endTime24}`);
                    
                    const slotData = {
                        start: formatTime12Hour(startDate),
                        end: formatTime12Hour(endDate),
                        start24: startTime24,
                        end24: endTime24
                    };
                    
                    editGeneratedSlots.push(slotData);
                });
                
                // Display the existing slots
                displayEditGeneratedSlots();
            }
            
            // Set form action and reset modal title
            $('#editAvailabilityForm').attr('action', '{{ route('admin.professional.availability.update', ['professional' => $professional->id, 'availability' => '__AVAILABILITY_ID__']) }}'.replace('__AVAILABILITY_ID__', availabilityId));
            $('#editAvailabilityModalLabel').text('Edit Availability');
            $('#editAvailabilityModal').modal('show');
        }
    };

    // (second showAddAvailabilityModal removed - single definition earlier in the file is used)

    // Add individual slot buttons
    document.getElementById('addGeneratedSlotBtn')?.addEventListener('click', () => addIndividualSlot(false));
    document.getElementById('editAddGeneratedSlotBtn')?.addEventListener('click', () => addIndividualSlot(true));
    
    // Clear all slots buttons
    document.getElementById('clearAllSlotsBtn')?.addEventListener('click', () => clearAllSlots(false));
    document.getElementById('editClearAllSlotsBtn')?.addEventListener('click', () => clearAllSlots(true));

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
        
        // Reset modal title to default
        if (modal.attr('id') === 'editAvailabilityModal') {
            $('#editAvailabilityModalLabel').text('Edit Availability');
        }
        
        // Reset month checkboxes specifically
        if (modal.attr('id') === 'addAvailabilityModal') {
            document.querySelectorAll('input[name="months[]"]').forEach(cb => cb.checked = false);
            const selectAllMonths = document.getElementById('selectAllMonths');
            if (selectAllMonths) {
                selectAllMonths.checked = false;
                selectAllMonths.indeterminate = false;
            }
        } else if (modal.attr('id') === 'editAvailabilityModal') {
            document.querySelectorAll('#editAvailabilityModal input[name="months[]"]').forEach(cb => cb.checked = false);
            const editSelectAllMonths = document.getElementById('editSelectAllMonths');
            if (editSelectAllMonths) {
                editSelectAllMonths.checked = false;
                editSelectAllMonths.indeterminate = false;
            }
        }
        
        // Clear generated slots
        if (modal.attr('id') === 'addAvailabilityModal') {
            // Reset slot generator
            generatedSlots = [];

            // Reset inputs
            const hourInput = document.getElementById('slotHour');
            const minuteInput = document.getElementById('slotMinute');
            const ampmSelect = document.getElementById('slotAMPM');

            if (hourInput) hourInput.value = '';
            if (minuteInput) minuteInput.value = '00';
            if (ampmSelect) ampmSelect.value = '';

            const generatedPreviewEl = document.getElementById('generatedSlotsPreview');
            if (generatedPreviewEl) generatedPreviewEl.style.display = 'none';
        } else if (modal.attr('id') === 'editAvailabilityModal') {
            // Reset edit slot generator
            editGeneratedSlots = [];

            // Reset edit inputs
            const editHourInput = document.getElementById('editSlotHour');
            const editMinuteInput = document.getElementById('editSlotMinute');
            const editAmpmSelect = document.getElementById('editSlotAMPM');

            if (editHourInput) editHourInput.value = '';
            if (editMinuteInput) editMinuteInput.value = '00';
            if (editAmpmSelect) editAmpmSelect.value = '';

            const editGeneratedPreviewEl = document.getElementById('editGeneratedSlotsPreview');
            if (editGeneratedPreviewEl) editGeneratedPreviewEl.style.display = 'none';
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