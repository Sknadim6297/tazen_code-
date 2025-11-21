@extends('professional.layout.layout')

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
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(59, 130, 246, 0.08));
        border-radius: 22px;
        border: 1px solid rgba(79, 70, 229, 0.15);
        position: relative;
        overflow: hidden;
    }

    .availability-header::after {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, rgba(79, 70, 229, 0.2), transparent 55%);
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
        box-shadow: 0 14px 30px rgba(79, 70, 229, 0.25);
    }

    .header-actions .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 40px rgba(79, 70, 229, 0.3);
    }

    .alert {
        border-radius: 12px;
        border: 1px solid rgba(248, 113, 113, 0.2);
        box-shadow: 0 10px 24px rgba(248, 113, 113, 0.12);
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
        box-shadow: 0 14px 40px rgba(15, 23, 42, 0.12);
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
    select.form-control {
        border-radius: 12px;
        border: 1px solid var(--border);
        padding: 0.85rem 1rem;
        font-size: 0.95rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus,
    select.form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
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
        border-color: rgba(79, 70, 229, 0.45);
        box-shadow: 0 12px 28px rgba(79, 70, 229, 0.15);
    }

    .month-card.selected {
        border-color: var(--primary);
        background: rgba(79, 70, 229, 0.08);
        box-shadow: 0 12px 28px rgba(79, 70, 229, 0.18);
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
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 1.25rem;
    }

    .day-column {
        background: rgba(248, 250, 252, 0.95);
        border-radius: 16px;
        border: 1px solid var(--border);
        padding: 1.2rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        min-height: 220px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .day-column:hover {
        border-color: rgba(79, 70, 229, 0.3);
        box-shadow: 0 12px 26px rgba(79, 70, 229, 0.14);
    }

    .day-header {
        font-weight: 700;
        padding: 0.65rem 0.75rem;
        border-radius: 12px;
        background: rgba(79, 70, 229, 0.12);
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
        border: 1px solid rgba(79, 70, 229, 0.18);
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
        background: rgba(239, 68, 68, 0.12);
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
        background: rgba(239, 68, 68, 0.18);
    }

    .add-slot-form {
        border: 1px dashed rgba(79, 70, 229, 0.35);
        padding: 0.8rem;
        border-radius: 12px;
        background: rgba(79, 70, 229, 0.08);
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

    .add-slot-btn {
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

    .add-slot-btn:hover {
        filter: brightness(0.98);
    }

    .form-actions {
        display: flex;
        justify-content: center;
        gap: 1rem;
        padding: 1.8rem;
        background: var(--card-bg);
        border-radius: 22px;
        border: 1px solid var(--border);
        box-shadow: 0 14px 38px rgba(15, 23, 42, 0.12);
        margin-bottom: 1rem;
    }

    .form-actions .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        padding: 0.85rem 2.4rem;
        border-radius: 999px;
        font-weight: 700;
        letter-spacing: 0.02em;
        color: #fff;
        box-shadow: 0 16px 32px rgba(79, 70, 229, 0.24);
    }

    .form-actions .btn-secondary {
        background: #fff;
        color: var(--text-muted);
        border: 1px solid rgba(100, 116, 139, 0.35);
        padding: 0.85rem 2.4rem;
        border-radius: 999px;
        font-weight: 600;
    }

    .form-actions .btn-secondary:hover {
        background: rgba(15, 23, 42, 0.05);
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
                    <h1>Add New Availability</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('professional.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('professional.availability.index') }}">Availability</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New</li>
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

            <div id="error-messages"></div>

            <form id="availability-form" class="availability-form">
                @csrf

                <section class="form-card">
                    <header>
                        <i class="ri-settings-line"></i>
                        Basic Information
                    </header>
                    <div class="form-grid">
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
                </section>

                <section class="form-card">
                    <header>
                        <i class="ri-calendar-line"></i>
                        Select Months
                    </header>
                    <p class="description">Choose the months for which you want to set this availability schedule.</p>
                    <div class="months-grid">
                        @php
                            $currentYear = date('Y');
                            $currentMonth = date('n');
                            $months = [
                                1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                                5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                                9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                            ];
                            // Calculate 6 months ahead from current date
                            $endDate = strtotime('+6 months');
                            $endYear = date('Y', $endDate);
                            $endMonth = date('n', $endDate);
                        @endphp

                        @for($year = $currentYear; $year <= $endYear; $year++)
                            @foreach($months as $monthNum => $monthName)
                                @php
                                    // Skip past months
                                    if($year == $currentYear && $monthNum < $currentMonth) {
                                        continue;
                                    }
                                    // Skip months beyond 6 months from now
                                    if($year == $endYear && $monthNum > $endMonth) {
                                        continue;
                                    }
                                    // Skip if year is beyond end year
                                    if($year > $endYear) {
                                        continue;
                                    }
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
                </section>

                <section class="form-card schedule-card">
                    <header>
                        <i class="ri-time-line"></i>
                        Weekly Schedule
                    </header>
                    <p class="description">Set your available time slots for each day of the week. You can add multiple time slots per day.</p>
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
                                <div class="day-slots" id="slots-{{ $dayCode }}"></div>
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
                    </div>
                </section>

                <section class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line"></i>Save Availability
                    </button>
                    <a href="{{ route('professional.availability.index') }}" class="btn btn-secondary">
                        <i class="ri-arrow-left-line"></i>Cancel
                    </a>
                </section>
            </form>
        </div>
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