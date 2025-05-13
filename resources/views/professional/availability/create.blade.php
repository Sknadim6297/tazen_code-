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
        <h3>Add Availability</h3>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Set Your Availability</h4>
        </div>
        <div class="card-body">
            <form id="availabilityForm">
                @csrf
                <div class="form-row mb-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>Select Month</label>
                        <select id="avail-month" class="form-control" name="month" required>
                            <option value="">Select Month</option>
                            @foreach($months as $num => $name)
                                @if($num >= $currentMonth)
                                    <option value="{{ strtolower(substr($name, 0, 3)) }}">{{ $name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Session Duration</label>
                        <select class="form-control" name="session_duration" required>
                            <option value="30">30 minutes</option>
                            <option value="45">45 minutes</option>
                            <option value="60" selected>60 minutes</option>
                            <option value="90">90 minutes</option>
                            <option value="120">2 hours</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Select Week Days</label>
                    <div class="weekday-group">
                        @foreach(['mon' => 'Monday', 'tue' => 'Tuesday', 'wed' => 'Wednesday', 'thu' => 'Thursday', 'fri' => 'Friday', 'sat' => 'Saturday', 'sun' => 'Sunday'] as $dayVal => $dayName)
                        <label class="weekday-label">
                            <input type="checkbox" name="weekdays[]" value="{{ $dayVal }}"> {{ $dayName }}
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <label>Time Slots</label>
                    <div id="time-slots-container"></div>
                    <button type="button" class="btn btn-success" id="addSlotBtn">
                        <i class="fas fa-plus"></i> Add more
                    </button>
                </div>

                <div class="form-actions mt-3">
                    <button type="button" class="btn btn-outline-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">
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
    const timeSlotsContainer = document.getElementById('time-slots-container');
    const addSlotBtn = document.getElementById('addSlotBtn');

    function initializeFlatpickr() {
        flatpickr(".timepicker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",
            time_24hr: false,
            minuteIncrement: 5,
            disableMobile: true 
        });
    }

    // Create new time slot
    function createTimeSlot() {
    const div = document.createElement('div');
    div.classList.add('time-slot');
    div.innerHTML = `
        <label>From</label>
        <div class="time-input-group">
            <input type="text" class="form-control timepicker" name="start_time[]" required placeholder="Start Time">
            </select>
        </div>
        <label>To</label>
        <div class="time-input-group">
            <input type="text" class="form-control timepicker" name="end_time[]" required placeholder="End Time">
            </select>
        </div>
        <button type="button" class="remove-slot-btn" title="Remove slot">
            <i class="fas fa-trash"></i>
        </button>
    `;
    timeSlotsContainer.appendChild(div);
    initializeFlatpickr(); 
}

    createTimeSlot();
    addSlotBtn.addEventListener('click', createTimeSlot);

    timeSlotsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-slot-btn')) {
            e.target.closest('.time-slot').remove();
        }
    });

    $('#availabilityForm').submit(function(e) {
    e.preventDefault();
    const form = this;
    const formData = new FormData(form);

    $.ajax({
        url: "{{ route('professional.availability.store') }}",
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
                form.reset();
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
