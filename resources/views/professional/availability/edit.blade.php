@extends('professional.layout.layout')

@section('title', 'Edit Availability')

@section('styles')
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --accent: #22c55e;
        --background: #f4f6fb;
        --card-bg: #ffffff;
        --border: #e5e7eb;
        --text-dark: #0f172a;
        --text-muted: #64748b;
    }

    body,
    .app-content {
        background: var(--background);
    }

    .availability-page {
        width: 100%;
        padding: 0 1.25rem 3rem;
    }

    .availability-shell {
        max-width: 1180px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 1.75rem;
    }

    .availability-header {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        padding: 2rem 2.4rem;
        background: linear-gradient(135deg, rgba(79,70,229,0.12), rgba(59,130,246,0.08));
        border-radius: 22px;
        border: 1px solid rgba(79,70,229,0.15);
        position: relative;
        overflow: hidden;
    }

    .availability-header::after {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, rgba(79,70,229,0.2), transparent 55%);
        pointer-events: none;
    }

    .availability-header > * {
        position: relative;
        z-index: 1;
    }

    .availability-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }

    .availability-header .breadcrumb {
        margin: 0.4rem 0 0;
        padding: 0;
        background: transparent;
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .availability-header .breadcrumb a {
        color: var(--primary);
        text-decoration: none;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .header-actions .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.8rem 1.45rem;
        border-radius: 999px;
        font-weight: 600;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        color: #fff;
        box-shadow: 0 14px 32px rgba(79,70,229,0.25);
    }

    .header-actions .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 40px rgba(79,70,229,0.3);
    }

    .availability-form {
        display: flex;
        flex-direction: column;
        gap: 1.75rem;
    }

    .form-card {
        background: var(--card-bg);
        border-radius: 20px;
        border: 1px solid var(--border);
        box-shadow: 0 12px 38px rgba(15,23,42,0.12);
        padding: 1.9rem;
        display: flex;
        flex-direction: column;
        gap: 1.4rem;
    }

    .form-card header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 700;
        font-size: 1.05rem;
        color: var(--text-dark);
    }

    .form-card header i {
        font-size: 1.2rem;
        color: var(--primary);
    }

    .form-card p.description {
        margin: 0;
        color: var(--text-muted);
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.25rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.55rem;
    }

    .form-group label {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.92rem;
    }

    .form-control,
    .form-select {
        border-radius: 12px;
        border: 1px solid var(--border);
        padding: 0.85rem 1rem;
        font-size: 0.95rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79,70,229,0.15);
    }

    .months-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 1rem;
    }

    .month-card {
        position: relative;
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1rem 1.1rem;
        background: #fff;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }

    .month-card:hover {
        border-color: rgba(79,70,229,0.45);
        box-shadow: 0 12px 28px rgba(79,70,229,0.15);
    }

    .month-card.selected {
        border-color: var(--primary);
        background: rgba(79,70,229,0.08);
        box-shadow: 0 12px 28px rgba(79,70,229,0.18);
    }

    .month-card input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: var(--primary);
    }

    .month-card label {
        margin: 0;
        font-weight: 600;
        color: var(--text-dark);
        cursor: pointer;
    }

    .weekly-scheduler {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.25rem;
    }

    .day-column {
        background: rgba(248,250,252,0.95);
        border-radius: 16px;
        border: 1px solid var(--border);
        padding: 1.2rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        min-height: 240px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .day-column:hover {
        border-color: rgba(79,70,229,0.3);
        box-shadow: 0 12px 26px rgba(79,70,229,0.14);
    }

    .day-header {
        font-weight: 700;
        padding: 0.65rem 0.75rem;
        border-radius: 12px;
        background: rgba(79,70,229,0.12);
        color: var(--primary-dark);
        text-align: center;
        margin-bottom: 0.25rem;
    }

    .day-slots {
        display: flex;
        flex-direction: column;
        gap: 0.65rem;
    }

    .slot-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8fafc;
        border: 1px solid rgba(79,70,229,0.18);
        border-radius: 12px;
        padding: 0.55rem 0.75rem;
        font-size: 0.9rem;
        color: var(--text-dark);
    }

    .slot-time {
        font-weight: 600;
        color: var(--primary-dark);
    }

    .delete-slot {
        background: rgba(239,68,68,0.12);
        border: none;
        color: #dc2626;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .delete-slot:hover {
        background: rgba(239,68,68,0.18);
    }

    .add-slot-form {
        border: 1px dashed rgba(79,70,229,0.35);
        padding: 0.8rem;
        border-radius: 12px;
        background: rgba(79,70,229,0.08);
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }

    .time-inputs {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.4rem;
    }

    .time-inputs input[type="time"] {
        width: 76px;
        border-radius: 10px;
        border: 1px solid var(--border);
        padding: 0.45rem 0.55rem;
        font-size: 0.88rem;
    }

    .time-inputs span {
        color: var(--text-muted);
        font-weight: 600;
        font-size: 0.82rem;
    }

    .time-inputs input[type="time"]:disabled {
        background: #e5e7eb;
        cursor: not-allowed;
    }

    .add-slot-btn,
    .add-for-all-btn {
        background: linear-gradient(135deg, var(--accent), #16a34a);
        border: none;
        color: #fff;
        padding: 0.6rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 0.4rem;
    }

    .add-for-all-wrap {
        grid-column: 1 / -1;
    }

    .add-for-all-btn {
        width: 100%;
        padding: 0.75rem;
        margin-top: 0.5rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    }

    .form-actions {
        display: flex;
        justify-content: center;
        gap: 1rem;
        padding: 1.8rem;
        background: var(--card-bg);
        border-radius: 22px;
        border: 1px solid var(--border);
        box-shadow: 0 14px 38px rgba(15,23,42,0.12);
    }

    .form-actions .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        padding: 0.85rem 2.4rem;
        border-radius: 999px;
        font-weight: 700;
        color: #fff;
        box-shadow: 0 16px 32px rgba(79,70,229,0.24);
    }

    .form-actions .btn-secondary {
        background: #fff;
        color: var(--text-muted);
        border: 1px solid rgba(100,116,139,0.35);
        padding: 0.85rem 2.4rem;
        border-radius: 999px;
        font-weight: 600;
    }

    .modal-content {
        border-radius: 18px;
        border: none;
        box-shadow: 0 18px 48px rgba(15,23,42,0.18);
    }

    .modal-header {
        border-bottom: 1px solid var(--border);
        padding: 1.2rem 1.5rem;
    }

    .modal-body {
        padding: 1.5rem 1.75rem;
    }

    .modal-footer {
        border-top: 1px solid var(--border);
        padding: 1.2rem 1.75rem;
    }

    @media (max-width: 768px) {
        .availability-page {
            padding: 0 1rem 2.5rem;
        }

        .availability-header {
            padding: 1.75rem 1.6rem;
        }

        .availability-header h1 {
            font-size: 1.45rem;
        }

        .form-actions {
            flex-direction: column;
            padding: 1.4rem;
        }

        .form-actions .btn-primary,
        .form-actions .btn-secondary {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="availability-page">
        <div class="availability-shell">
            <header class="availability-header">
                <div class="header-content">
                    <h1>Edit Availability</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('professional.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('professional.availability.index') }}">Availability</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
                <div class="header-actions">
                    <a href="{{ route('professional.availability.index') }}" class="btn">
                        <i class="ri-arrow-left-line"></i>
                        Back to Availability
                    </a>
                </div>
            </header>

            <form id="editAvailabilityForm" class="availability-form">
                @csrf
                @method('PUT')

                <section class="form-card">
                    <header>
                        <i class="ri-calendar-line"></i>
                        Select Months
                    </header>
                    <p class="description">Choose the months you want this availability to apply to.</p>
                    <div class="month-selector">
                        <div class="months-grid" id="monthGrid"></div>
                    </div>
                </section>

                <section class="form-card">
                    <header>
                        <i class="ri-settings-line"></i>
                        Session Settings
                    </header>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="session_duration">Session Duration (minutes)</label>
                            <select class="form-select" id="session_duration" name="session_duration" required>
                                @foreach([30, 45, 60, 90, 120] as $duration)
                                    <option value="{{ $duration }}" {{ $availability->session_duration == $duration ? 'selected' : '' }}>
                                        {{ $duration }} {{ $duration == 120 ? 'minutes (2 hours)' : 'minutes' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </section>

                <section class="form-card schedule-card">
                    <header>
                        <i class="ri-time-line"></i>
                        Weekly Schedule
                    </header>
                    <p class="description">Adjust your available time slots for each day. Add or remove slots as needed.</p>
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
                                <div class="day-slots" id="slots_{{ $dayCode }}"></div>
                                <div class="add-slot-form">
                                    <div class="time-inputs">
                                        <input type="time" id="start-{{ $dayCode }}" onchange="calculateEndTime('{{ $dayCode }}')">
                                        <span>to</span>
                                        <input type="time" id="end-{{ $dayCode }}" readonly>
                                    </div>
                                    <button type="button" class="add-slot-btn" onclick="addSlot('{{ $dayCode }}')">
                                        <i class="ri-add-line"></i>
                                        Add Slot
                                    </button>
                                </div>
                            </div>
                        @endforeach

                        <div class="add-for-all-wrap">
                            <button type="button" class="add-for-all-btn" onclick="showAddForAllModal()">
                                <i class="ri-calendar-event-line"></i>
                                Add Slot To All Days
                            </button>
                        </div>
                    </div>
                </section>

                <section class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line"></i> Update Availability
                    </button>
                    <a href="{{ route('professional.availability.index') }}" class="btn btn-secondary">
                        <i class="ri-close-line"></i> Cancel
                    </a>
                </section>
            </form>
        </div>
    </div>
</div>

<!-- Add for All Days Modal -->
<div class="modal fade" id="addForAllModal" tabindex="-1" aria-labelledby="addForAllModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addForAllModalLabel">Add Time Slot for All Days</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="allDaysTime">Start Time</label>
                    <input type="time" class="form-control" id="allDaysTime" required>
                </div>
                <p class="description" style="margin-top: 0.5rem;">End time will be calculated automatically based on session duration.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="applyToAllDays()">Add to All Days</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let weeklySlots = { mon: [], tue: [], wed: [], thu: [], fri: [], sat: [], sun: [] };
    let slotIdCounter = 0;
    let selectedMonths = [];

    const availabilityData = @json($availability);
    selectedMonths = availabilityData.month ? [availabilityData.month] : [];

    populateMonthGrid();
    loadExistingSlots();

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

    window.calculateEndTime = function(day) {
        const startInput = document.getElementById('start-' + day);
        const endInput = document.getElementById('end-' + day);
        const sessionDuration = document.getElementById('session_duration').value;
        if (!startInput.value || !sessionDuration) {
            endInput.value = '';
            return;
        }
        const [hours, minutes] = startInput.value.split(':').map(Number);
        const startDate = new Date();
        startDate.setHours(hours, minutes, 0, 0);
        const endDate = new Date(startDate.getTime() + parseInt(sessionDuration) * 60000);
        endInput.value = `${String(endDate.getHours()).padStart(2, '0')}:${String(endDate.getMinutes()).padStart(2, '0')}`;
    };

    document.getElementById('session_duration').addEventListener('change', function() {
        ['mon','tue','wed','thu','fri','sat','sun'].forEach(day => {
            const startInput = document.getElementById('start-' + day);
            if (startInput.value) calculateEndTime(day);
        });
    });

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
        weeklySlots[day].sort((a, b) => new Date(`1/1/2023 ${a.start_time}`) - new Date(`1/1/2023 ${b.start_time}`));
        renderDaySlots(day);
        startInput.value = '';
        endInput.value = '';
    };

    window.deleteSlot = function(day, slotId) {
        if (confirm('Are you sure you want to delete this time slot?')) {
            weeklySlots[day] = weeklySlots[day].filter(slot => slot.id !== slotId);
            renderDaySlots(day);
        }
    };

    window.showAddForAllModal = function() {
        document.getElementById('allDaysTime').value = '';
        $('#addForAllModal').modal('show');
    };

    window.applyToAllDays = function() {
        const timeValue = document.getElementById('allDaysTime').value.trim();
        const sessionDuration = document.getElementById('session_duration').value;
        if (!timeValue || !sessionDuration) {
            alert('Please select start time and session duration');
            return;
        }
        const startTime = formatTimeToHHMM(timeValue);
        const [hours, minutes] = startTime.split(':').map(Number);
        const startDate = new Date();
        startDate.setHours(hours, minutes, 0, 0);
        const endDate = new Date(startDate.getTime() + parseInt(sessionDuration) * 60000);
        const endTime = `${String(endDate.getHours()).padStart(2, '0')}:${String(endDate.getMinutes()).padStart(2, '0')}`;
        const days = ['mon','tue','wed','thu','fri','sat','sun'];
        let addedCount = 0;
        let skippedCount = 0;
        days.forEach(day => {
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
                weeklySlots[day].sort((a, b) => new Date(`1/1/2023 ${a.start_time}`) - new Date(`1/1/2023 ${b.start_time}`));
                renderDaySlots(day);
                addedCount++;
            } else {
                skippedCount++;
            }
        });
        $('#addForAllModal').modal('hide');
        if (addedCount > 0) alert(`Added slot to ${addedCount} days`);
        if (skippedCount > 0) alert(`Skipped ${skippedCount} days due to overlapping slots`);
    };

    function renderDaySlots(day) {
        const container = document.getElementById(`slots_${day}`);
        const slots = weeklySlots[day];
        if (slots.length === 0) {
            container.innerHTML = '<div class="text-muted small" style="text-align:center;padding:0.75rem;">No slots added</div>';
            return;
        }
        container.innerHTML = slots.map(slot => `
            <div class="slot-item">
                <span class="slot-time">${slot.start_time} - ${slot.end_time}</span>
                <button type="button" class="delete-slot" onclick="deleteSlot('${day}', ${slot.id})">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </div>
        `).join('');
    }

    function populateMonthGrid() {
        const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        const monthGrid = document.getElementById('monthGrid');
        monthGrid.innerHTML = '';
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        for (let year = currentYear; year <= currentYear + 1; year++) {
            months.forEach((month, index) => {
                const monthNum = index + 1;
                const monthValue = `${year}-${String(monthNum).padStart(2,'0')}`;
                const isSelected = selectedMonths.includes(monthValue);
                const colDiv = document.createElement('div');
                colDiv.className = 'col-md-3 mb-3';
                colDiv.innerHTML = `
                    <div class="month-card ${isSelected ? 'selected' : ''}" onclick="toggleMonth('${monthValue}')">
                        <input type="checkbox" name="months[]" value="${monthValue}" ${isSelected ? 'checked' : ''} style="display:none;">
                        <label>${month} ${year}</label>
                    </div>`;
                monthGrid.appendChild(colDiv);
            });
        }
    }

    function loadExistingSlots() {
        if (availabilityData.availability_slots) {
            availabilityData.availability_slots.forEach(slot => {
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
            ['mon','tue','wed','thu','fri','sat','sun'].forEach(day => renderDaySlots(day));
        }
    }

    function formatTimeToHHMM(timeString) {
        if (!timeString) return '';
        const cleanTime = timeString.toString().trim();
        if (/^\d{1,2}:\d{2}$/.test(cleanTime)) {
            const [hours, minutes] = cleanTime.split(':');
            return `${String(hours).padStart(2, '0')}:${minutes}`;
        }
        if (/^\d{1,2}:\d{2}:\d{2}$/.test(cleanTime)) {
            const [hours, minutes] = cleanTime.split(':');
            return `${String(hours).padStart(2, '0')}:${minutes}`;
        }
        const date = new Date(`1970-01-01T${cleanTime}`);
        if (!isNaN(date.getTime())) {
            return `${String(date.getHours()).padStart(2,'0')}:${String(date.getMinutes()).padStart(2,'0')}`;
        }
        return cleanTime;
    }

    function showLoading() {
        if (!document.getElementById('loadingOverlay')) {
            const overlay = document.createElement('div');
            overlay.id = 'loadingOverlay';
            overlay.className = 'loading-overlay';
            overlay.innerHTML = `
                <div class="loading-spinner">
                    <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                    <div class="mt-2">Updating availability...</div>
                </div>`;
            document.body.appendChild(overlay);
        }
        document.getElementById('loadingOverlay').style.display = 'flex';
    }

    function hideLoading() {
        const overlay = document.getElementById('loadingOverlay');
        if (overlay) overlay.style.display = 'none';
    }

    document.getElementById('editAvailabilityForm').addEventListener('submit', function(e) {
        e.preventDefault();
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
        const formData = new FormData();
        formData.append('_token', document.querySelector('input[name="_token"]').value);
        formData.append('_method', 'PUT');
        formData.append('session_duration', sessionDuration);
        selectedMonths.forEach(month => formData.append('months[]', month));
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
});
</script>
@endsection