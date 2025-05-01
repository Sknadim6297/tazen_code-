@extends('professional.layout.layout')

@section('style')
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
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="page-title">
            <h3>Add Availability</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">Add Availability</li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Set Your Availability</h4>
        </div>
        <div class="card-body">
            <form id="availabilityForm">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="form-group">
                        <label for="avail-month">Select Month</label>
                        <select id="avail-month" class="form-control" name="month">
                            <option value="">Select Month</option>
                            <option value="jan">January</option>
                            <option value="feb">February</option>
                            <option value="mar">March</option>
                            <option value="apr">April</option>
                            <option value="may">May</option>
                            <option value="jun">June</option>
                            <option value="jul">July</option>
                            <option value="aug">August</option>
                            <option value="sep">September</option>
                            <option value="oct">October</option>
                            <option value="nov">November</option>
                            <option value="dec">December</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="session-duration">Session Duration</label>
                        <select id="session-duration" class="form-control" name="session_duration">
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
                            <input type="checkbox" name="weekdays[]" value="{{ $dayVal }}">
                            <span class="checkmark"></span> {{ $dayName }}
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <label>Time Slots</label>
                    <div id="time-slots-container">
                        <!-- Time slots will be appended here -->
                    </div>
                    <button type="button" class="btn btn-success" id="addSlotBtn">
                        <i class="fas fa-plus"></i> Add Another Time Slot
                    </button>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-outline">Cancel</button>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const timeSlotsContainer = document.getElementById('time-slots-container');
    const addSlotBtn = document.getElementById('addSlotBtn');

    // Function to create a new time slot
    function createTimeSlot() {
        const timeSlot = document.createElement('div');
        timeSlot.classList.add('time-slot');

        timeSlot.innerHTML = `
            <label>From</label>
            <div class="time-input-group">
                <input type="time" class="form-control" name="start_time[]">
                <select class="form-control" name="start_period[]">
                    <option value="am">AM</option>
                    <option value="pm">PM</option>
                </select>
            </div>
            <label>To</label>
            <div class="time-input-group">
                <input type="time" class="form-control" name="end_time[]">
                <select class="form-control" name="end_period[]">
                    <option value="am">AM</option>
                    <option value="pm">PM</option>
                </select>
            </div>
            <button type="button" class="remove-slot-btn" title="Remove slot">
                <i class="fas fa-trash"></i>
            </button>
        `;

        timeSlotsContainer.appendChild(timeSlot);
    }

    // Add initial time slot on page load
    createTimeSlot();

    // Add new time slot
    addSlotBtn.addEventListener('click', function() {
        createTimeSlot();
    });

    // Delete time slot using event delegation
    timeSlotsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-slot-btn')) {
            const slot = e.target.closest('.time-slot');
            slot.remove();
        }
    });

    $('#availabilityForm').submit(function(e) {
    e.preventDefault();
    let form = this;
    let formData = new FormData(form);

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
                setTimeout(function() {
                    window.location.href = "{{ route('professional.dashboard') }}";
                }, 1500);
            } else {
                toastr.error(response.message || "Something went wrong");
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    toastr.error(value[0]);
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
