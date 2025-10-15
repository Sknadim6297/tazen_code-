@extends('admin.layouts.layout')

@section('styles')
<style>
    /* Page Header */
    .page-header {
        margin-bottom: 1.5rem;
    }

    .page-header .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 0.5rem;
    }

    .professional-info-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .professional-info-card h5 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .professional-info-card p {
        margin: 0.25rem 0 0 0;
        opacity: 0.9;
    }

    /* Availability Cards */
    .availability-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        margin-bottom: 1rem;
        transition: all 0.2s ease;
    }

    .availability-card:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-color: #d1d5db;
    }

    .card-header {
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        padding: 1rem 1.25rem;
    }

    .card-header h6 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #495057;
    }

    .card-body {
        padding: 1.25rem;
    }

    .availability-meta {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6c757d;
        font-size: 0.875rem;
    }

    .meta-item i {
        color: #8b5cf6;
    }

    .badge {
        padding: 0.35rem 0.75rem;
        font-size: 0.8rem;
        font-weight: 500;
        border-radius: 4px;
    }

    .badge-primary {
        background: #667eea;
        color: white;
    }

    .badge-secondary {
        background: #e9ecef;
        color: #495057;
    }

    .availability-slots {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin: 1rem 0;
    }

    .slot-badge {
        background: #f8f9fa;
        color: #495057;
        padding: 0.4rem 0.8rem;
        border-radius: 4px;
        font-size: 0.85rem;
        border: 1px solid #e9ecef;
    }

    .btn-action-group {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 3rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }

    .availability-weekdays {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
        margin: 0.75rem 0;
    }

    .weekday-chip {
        background: #e0e7ff;
        color: #5b21b6;
        padding: 0.25rem 0.6rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
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

    .time-slot-card {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 0.75rem;
        margin-bottom: 0.75rem;
        transition: all 0.2s;
    }

    .time-slot-card:hover {
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        border-color: #667eea;
    }

    .time-slot-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .time-display {
        font-weight: 600;
        color: #667eea;
        font-size: 0.85rem;
    }

    .slot-actions {
        display: flex;
        gap: 0.25rem;
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
        margin-top: 0.75rem;
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

    .slot-time-inputs {
        margin-bottom: 0.75rem;
    }

    .time-input-wrapper label {
        font-size: 0.75rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
        font-weight: 500;
        display: block;
    }

    .time-input-custom {
        display: flex;
        gap: 0.25rem;
        align-items: center;
    }

    .time-input-custom input,
    .time-input-custom select {
        padding: 0.4rem 0.5rem;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 0.8rem;
    }

    .time-input-custom input {
        width: 45px;
        text-align: center;
    }

    .time-input-custom select {
        width: 60px;
    }

    .btn-icon {
        padding: 0.25rem 0.5rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.7rem;
    }

    .btn-edit {
        background: #0d6efd;
        color: white;
    }

    .btn-edit:hover {
        background: #0b5ed7;
    }

    .btn-delete {
        background: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background: #bb2d3b;
    }

    .empty-slots-message {
        text-align: center;
        color: #adb5bd;
        font-size: 0.8rem;
        padding: 1.5rem 0.5rem;
        font-style: italic;
    }

    /* Month Selection */
    .month-selection-container {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 6px;
        border: 1px solid #e9ecef;
    }

    .month-checkbox-label {
        display: flex;
        align-items: center;
        padding: 0.6rem 0.75rem;
        background: white;
        border: 1px solid #ced4da;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.875rem;
    }

    .month-checkbox-label:hover {
        background: #f8f9fa;
        border-color: #667eea;
    }

    .month-checkbox-label input[type="checkbox"]:checked + span {
        font-weight: 600;
        color: #667eea;
    }

    .months-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 0.75rem;
    }

    /* Modal Styling */
    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom: none;
    }

    .modal-header .modal-title {
        font-weight: 600;
    }

    .modal-header .close {
        color: white;
        opacity: 0.9;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .form-group label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .alert-info {
        background-color: #e7f3ff;
        border-color: #b3d9ff;
        color: #004085;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-md-flex d-block align-items-center justify-content-between my-4">
                <div>
                    <h1 class="page-title mb-1">Manage Availability Schedule</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.manage-professional.index') }}">Professionals</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.manage-professional.show', $professional->id) }}">{{ $professional->name }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Availability</li>
                        </ol>
                    </nav>
                </div>
                <div class="mt-3 mt-md-0">
                    <button onclick="showAddAvailabilityModal()" class="btn btn-primary">
                        <i class="fe fe-plus me-2"></i>Add New Availability
                    </button>
                </div>
            </div>
        </div>

        <!-- Professional Info Card -->
        <div class="professional-info-card">
            <h5><i class="fe fe-user me-2"></i>{{ $professional->name }}</h5>
            <p><i class="fe fe-mail me-2"></i>{{ $professional->email }}</p>
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
                        <div class="card availability-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    <i class="fe fe-calendar me-2"></i>
                                    @php
                                        $monthValue = $availability->month;
                                        if ($monthValue === 'all_months') {
                                            $months = [];
                                            $currentDate = now();
                                            for ($i = 0; $i < 6; $i++) {
                                                $months[] = $currentDate->copy()->addMonths($i)->format('F Y');
                                            }
                                            $fullMonth = implode(', ', $months);
                                        } elseif (strpos($monthValue, '-') !== false) {
                                            try {
                                                $fullMonth = \Carbon\Carbon::createFromFormat('Y-m', $monthValue)->format('F Y');
                                            } catch (\Exception $e) {
                                                $fullMonth = $monthValue;
                                            }
                                        } else {
                                            $monthNames = [
                                                'jan' => 'January', 'feb' => 'February', 'mar' => 'March', 
                                                'apr' => 'April', 'may' => 'May', 'jun' => 'June',
                                                'jul' => 'July', 'aug' => 'August', 'sep' => 'September',
                                                'oct' => 'October', 'nov' => 'November', 'dec' => 'December'
                                            ];
                                            $fullMonth = $monthNames[$monthValue] ?? ucfirst($monthValue);
                                        }
                                    @endphp
                                    {{ $fullMonth }}
                                </h6>
                                <div class="btn-action-group">
                                    <button onclick="editAvailability({{ $availability->id }})" class="btn btn-sm btn-primary">
                                        <i class="fe fe-edit"></i> Edit
                                    </button>
                                    <button onclick="deleteAvailability({{ $availability->id }})" class="btn btn-sm btn-danger">
                                        <i class="fe fe-trash-2"></i> Delete
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="availability-meta">
                                    <div class="meta-item">
                                        <i class="fe fe-clock"></i>
                                        <strong>Session:</strong> {{ $availability->session_duration }} min
                                    </div>
                                    @if($availability->weekdays)
                                        @php
                                            $weekdays = json_decode($availability->weekdays, true) ?? [];
                                            $dayNames = [
                                                'mon' => 'Mon', 'tue' => 'Tue', 'wed' => 'Wed', 
                                                'thu' => 'Thu', 'fri' => 'Fri', 'sat' => 'Sat', 'sun' => 'Sun'
                                            ];
                                        @endphp
                                        <div class="meta-item">
                                            <i class="fe fe-calendar"></i>
                                            <strong>Days:</strong>
                                            <div class="availability-weekdays ms-2">
                                                @foreach($weekdays as $day)
                                                    <span class="weekday-chip">{{ $dayNames[$day] ?? $day }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                @if($availability->slots && $availability->slots->count() > 0)
                                    <div class="mt-3">
                                        <strong class="text-muted d-block mb-2"><i class="fe fe-clock me-1"></i>Time Slots:</strong>
                                        <div class="availability-slots">
                                            @foreach($availability->slots as $slot)
                                                <span class="slot-badge">
                                                    @php
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
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning mb-0 mt-2">
                                        <i class="fe fe-alert-circle me-2"></i>No time slots defined
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="card">
                        <div class="card-body">
                            <div class="empty-state">
                                <i class="fe fe-calendar"></i>
                                <h4>No Availability Found</h4>
                                <p>This professional hasn't set up any availability schedule yet.</p>
                                <button onclick="showAddAvailabilityModal()" class="btn btn-primary mt-3">
                                    <i class="fe fe-plus me-2"></i>Add First Availability
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add Availability Modal -->
<div class="modal fade" id="addAvailabilityModal" tabindex="-1" role="dialog" aria-labelledby="addAvailabilityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAvailabilityModalLabel"><i class="fe fe-plus-circle me-2"></i>Add New Availability</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addAvailabilityForm">
                @csrf
                <div class="modal-body">
                    <!-- Packages removed: no longer used in slot creation -->
                    
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
                                <i class="fe fe-info"></i>
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
                    <!-- Weekday selection removed: days are determined per-slot in the weekly scheduler -->
                    <div class="form-group">
                        <label style="font-size: 1.1rem; font-weight: 600; margin-bottom: 15px;">
                            <i class="fe fe-calendar"></i> Weekly Time Slots Configuration
                        </label>
                        
                        <div class="alert alert-info" style="font-size: 0.9rem;">
                            <i class="fe fe-info"></i> 
                            Add time slots for each weekday. You can add multiple slots per day.
                            Use "Add for All Days" to quickly apply a slot to all weekdays.
                        </div>

                        <!-- Weekly Scheduler Grid -->
                        <div class="weekly-scheduler" id="weeklyScheduler">
                            @foreach(['mon' => 'Monday', 'tue' => 'Tuesday', 'wed' => 'Wednesday', 'thu' => 'Thursday', 'fri' => 'Friday', 'sat' => 'Saturday', 'sun' => 'Sunday'] as $dayVal => $dayName)
                                <div class="weekday-column" data-day="{{ $dayVal }}">
                                    <div class="weekday-header">{{ $dayName }}</div>
                                    
                                    <!-- Slots Container -->
                                    <div class="weekday-slots-container" id="slots_{{ $dayVal }}">
                                        <div class="empty-slots-message">No slots added yet</div>
                                    </div>
                                    
                                    <!-- Add Slot Form -->
                                    <div class="slot-time-inputs">
                                        <div class="time-input-wrapper">
                                            <label>Start Time</label>
                                            <input type="time" class="form-control slot-time-picker" data-day="{{ $dayVal }}" placeholder="Select time">
                                        </div>
                                    </div>
                                    
                                    <button type="button" class="add-slot-btn" onclick="addSlotToDay('{{ $dayVal }}', false)">
                                        <i class="fe fe-plus"></i> Add Slot
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        <!-- Add for All Days Button -->
                        <div style="margin-top: 20px; text-align: center;">
                            <button type="button" class="add-for-all-btn" onclick="showAddForAllModal()">
                                <i class="fe fe-layers"></i> Add Time Slot for All Days
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class="fe fe-x me-1"></i>Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fe fe-check me-1"></i>Add Availability</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add for All Days Modal -->
<div class="modal fade" id="addForAllModal" tabindex="-1" role="dialog" aria-labelledby="addForAllModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addForAllModalLabel"><i class="fe fe-layers me-2"></i>Add Time Slot for All Days</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Start Time</label>
                    <input type="time" id="allDaysTime" class="form-control" placeholder="Select time">
                </div>
                <div class="alert alert-info" style="font-size: 0.875rem; margin-top: 10px;">
                    <i class="fe fe-info"></i> This will add the same time slot to all 7 weekdays
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class="fe fe-x me-1"></i>Cancel</button>
                <button type="button" class="btn btn-primary" onclick="applyToAllDays()">
                    <i class="fe fe-check me-1"></i> Add to All Days
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Availability Modal -->
<div class="modal fade" id="editAvailabilityModal" tabindex="-1" role="dialog" aria-labelledby="editAvailabilityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAvailabilityModalLabel"><i class="fe fe-edit me-2"></i>Edit Availability</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                <i class="fe fe-info"></i>
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
                        <label>Time Slots Configuration</label>
                        
                        <!-- Individual Slot Generator -->
                        <div class="slot-config">
                            <div>
                                <label>Slot Start Time</label>
                                <input type="time" id="editSlotTime" class="form-control" placeholder="Select time">
                            </div>
                            <div>
                                <button type="button" class="btn btn-success" id="editAddGeneratedSlotBtn">
                                    <i class="fe fe-plus"></i> Add This Slot
                                </button>
                            </div>
                        </div>
                        
                        <div class="text-muted mb-3" style="font-size: 0.9em;">
                            <i class="fe fe-info"></i> 
                            Add individual time slots. End time will be calculated automatically based on session duration.
                        </div>

                        <!-- Generated Slots Preview -->
                        <div id="editGeneratedSlotsPreview" class="generated-slots" style="display: none;">
                            <h6>Added Time Slots:</h6>
                            <div id="editSlotsPreviewContainer"></div>
                            <button type="button" class="btn btn-danger btn-sm" id="editClearAllSlotsBtn" style="margin-top: 10px;">
                                <i class="fe fe-trash-2"></i> Clear All Slots
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class="fe fe-x me-1"></i>Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fe fe-save me-1"></i>Update Availability</button>
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
    
    // Weekly scheduler data structure
    let weeklySlots = {
        mon: [],
        tue: [],
        wed: [],
        thu: [],
        fri: [],
        sat: [],
        sun: []
    };
    
    let slotIdCounter = 0;
    
    // Legacy support
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
        const timeInput = document.getElementById(isEdit ? 'editSlotTime' : 'slotTime');
        const timeValue = timeInput?.value;

        // Validation
        if (!timeValue) {
            toastr.error('Please select a time');
            return;
        }
        
        // Parse 24-hour format time (HH:mm)
        const [hours, minutes] = timeValue.split(':').map(Number);
        const startDate = new Date();
        startDate.setHours(hours, minutes, 0, 0);
        
        const sessionDuration = isEdit ? 
            parseInt(document.getElementById('edit_session_duration')?.value || 60) : 
            parseInt(document.getElementById('session_duration')?.value || 60);
        
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
        if (timeInput) timeInput.value = '';
        
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
                        <i class="fe fe-x"></i>
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
                        <i class="fe fe-x"></i>
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

    // ====== WEEKLY SCHEDULER FUNCTIONS ======
    
    // Add slot to specific day
    window.addSlotToDay = function(day, isEdit = false) {
        const timeInput = document.querySelector(`.slot-time-picker[data-day="${day}"]`);
        const timeValue = timeInput?.value;
        
        if (!timeValue) {
            toastr.error('Please select a time');
            return;
        }
        
        // Parse 24-hour format time (HH:mm)
        const [hours, minutes] = timeValue.split(':').map(Number);
        const startDate = new Date();
        startDate.setHours(hours, minutes, 0, 0);
        
        const sessionDuration = parseInt(document.getElementById('session_duration')?.value || 60);
        const endDate = new Date(startDate.getTime() + (sessionDuration * 60 * 1000));
        
        const newSlot = {
            id: slotIdCounter++,
            day: day,
            start: formatTime12Hour(startDate),
            end: formatTime12Hour(endDate),
            start24: formatTime24Hour(startDate),
            end24: formatTime24Hour(endDate)
        };
        
        // Check for overlaps
        const daySlots = weeklySlots[day];
        const hasOverlap = daySlots.some(slot => {
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
        
        weeklySlots[day].push(newSlot);
        weeklySlots[day].sort((a, b) => {
            return new Date(`1/1/2023 ${a.start24}`) - new Date(`1/1/2023 ${b.start24}`);
        });
        
        renderDaySlots(day);
        
        // Clear input
        if (timeInput) timeInput.value = '';
        
        toastr.success('Slot added successfully');
    };
    
    // Render slots for a specific day
    function renderDaySlots(day) {
        const container = document.getElementById(`slots_${day}`);
        const slots = weeklySlots[day];
        
        if (slots.length === 0) {
            container.innerHTML = '<div class="empty-slots-message">No slots added yet</div>';
            return;
        }
        
        container.innerHTML = slots.map(slot => `
            <div class="time-slot-card" data-slot-id="${slot.id}">
                <div class="time-slot-header">
                    <div class="time-display">${slot.start} - ${slot.end}</div>
                    <div class="slot-actions">
                        <button type="button" class="btn-icon btn-delete" onclick="deleteSlot('${day}', ${slot.id})" title="Delete">
                            <i class="fe fe-trash-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }
    
    // Edit slot
    window.editSlot = function(day, slotId) {
        const slot = weeklySlots[day].find(s => s.id === slotId);
        if (!slot) return;
        
        // For now, we'll just allow re-entry
        toastr.info('Delete this slot and add a new one to change the time');
    };
    
    // Delete slot
    window.deleteSlot = function(day, slotId) {
        if (confirm('Are you sure you want to delete this time slot?')) {
            weeklySlots[day] = weeklySlots[day].filter(s => s.id !== slotId);
            renderDaySlots(day);
            toastr.success('Slot deleted');
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
        
        if (!timeValue) {
            toastr.error('Please select a time');
            return;
        }
        
        // Parse 24-hour format time (HH:mm)
        const [hours, minutes] = timeValue.split(':').map(Number);
        const startDate = new Date();
        startDate.setHours(hours, minutes, 0, 0);
        
        const sessionDuration = parseInt(document.getElementById('session_duration')?.value || 60);
        const endDate = new Date(startDate.getTime() + (sessionDuration * 60 * 1000));
        
        const days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
        let addedCount = 0;
        let skippedCount = 0;
        
        days.forEach(day => {
            const newSlot = {
                id: slotIdCounter++,
                day: day,
                start: formatTime12Hour(startDate),
                end: formatTime12Hour(endDate),
                start24: formatTime24Hour(startDate),
                end24: formatTime24Hour(endDate)
            };
            
            // Check for overlaps
            const daySlots = weeklySlots[day];
            const hasOverlap = daySlots.some(slot => {
                const existingStart = new Date(`1/1/2023 ${slot.start24}`);
                const existingEnd = new Date(`1/1/2023 ${slot.end24}`);
                const newStart = new Date(`1/1/2023 ${newSlot.start24}`);
                const newEnd = new Date(`1/1/2023 ${newSlot.end24}`);
                
                return (newStart < existingEnd && newEnd > existingStart);
            });
            
            if (!hasOverlap) {
                weeklySlots[day].push(newSlot);
                weeklySlots[day].sort((a, b) => {
                    return new Date(`1/1/2023 ${a.start24}`) - new Date(`1/1/2023 ${b.start24}`);
                });
                renderDaySlots(day);
                addedCount++;
            } else {
                skippedCount++;
            }
        });
        
        $('#addForAllModal').modal('hide');
        
        if (addedCount > 0) {
            toastr.success(`Added to ${addedCount} day(s)`);
        }
        if (skippedCount > 0) {
            toastr.warning(`Skipped ${skippedCount} day(s) due to overlapping times`);
        }
    };
    
    // Render all days on initial load
    const days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
    days.forEach(day => renderDaySlots(day));

    // Show add modal
    window.showAddAvailabilityModal = function() {
        // Reset form
        document.getElementById('addAvailabilityForm').reset();
        
        // Reset weekly slots
        weeklySlots = {
            mon: [],
            tue: [],
            wed: [],
            thu: [],
            fri: [],
            sat: [],
            sun: []
        };
        slotIdCounter = 0;
        
        // Re-render all days
        days.forEach(day => renderDaySlots(day));
        
        // Clear all time inputs
        document.querySelectorAll('.slot-time-picker').forEach(input => input.value = '');
        
        // Reset slot generator (legacy)
        generatedSlots = [];
        const slotStartTime = document.getElementById('slotStartTime');
        if (slotStartTime) slotStartTime.value = '';
        
        const generatedSlotsPreview = document.getElementById('generatedSlotsPreview');
        if (generatedSlotsPreview) generatedSlotsPreview.style.display = 'none';
        
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
        
        // Validation: Check if at least one time slot is added to any day
        const totalSlots = Object.values(weeklySlots).reduce((sum, daySlots) => sum + daySlots.length, 0);
        if (totalSlots === 0) {
            toastr.error("Please add at least one time slot to any weekday");
            return false;
        }
        
        // Get days that have slots
        const daysWithSlots = Object.keys(weeklySlots).filter(day => weeklySlots[day].length > 0);
        if (daysWithSlots.length === 0) {
            toastr.error("Please add time slots to at least one weekday");
            return false;
        }

        // Check for overlaps in generated slots (legacy support)
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
        
        // Add all slots with their weekday and start/end times
        let slotIndex = 0;
        daysWithSlots.forEach(day => {
            weeklySlots[day].forEach(slot => {
                formData.append(`slots[${slotIndex}][weekday]`, day);
                formData.append(`slots[${slotIndex}][start_time]`, slot.start24);
                formData.append(`slots[${slotIndex}][end_time]`, slot.end24);
                slotIndex++;
            });
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
        
        // Weekday selection removed; weekdays are determined per-slot in the scheduler
        
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
        
        // Weekdays are included per-slot; no top-level weekdays[] required
        
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
            
            // Weekday checkboxes removed; weekdays will be handled per-slot
            
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
            
            // Weekday checkboxes removed; existing availability's weekdays will be represented by its slots
            
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
            const timeInput = document.getElementById('slotTime');
            if (timeInput) timeInput.value = '';

            const generatedPreviewEl = document.getElementById('generatedSlotsPreview');
            if (generatedPreviewEl) generatedPreviewEl.style.display = 'none';
        } else if (modal.attr('id') === 'editAvailabilityModal') {
            // Reset edit slot generator
            editGeneratedSlots = [];

            // Reset edit inputs
            const editTimeInput = document.getElementById('editSlotTime');
            if (editTimeInput) editTimeInput.value = '';

            const editGeneratedPreviewEl = document.getElementById('editGeneratedSlotsPreview');
            if (editGeneratedPreviewEl) editGeneratedPreviewEl.style.display = 'none';
        }
        
        // Clear any validation errors
        modal.find('.is-invalid').removeClass('is-invalid');
        modal.find('.invalid-feedback').remove();
    });

    // Handle close button clicks - prevent event bubbling
    $('.modal .btn-close, .modal [data-bs-dismiss="modal"], .modal .btn-light').on('click', function(e) {
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