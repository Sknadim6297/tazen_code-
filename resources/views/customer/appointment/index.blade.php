@extends('customer.layout.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/appointment.css') }}" />

<style>
    /* Custom Modal Styles */
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .custom-modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 20px;
        width: 90%;
        max-width: 800px;
        border-radius: 10px;
        position: relative;
    }

    .custom-modal .close-modal {
        position: absolute;
        right: 15px;
        top: 10px;
        font-size: 24px;
        font-weight: bold;
        color: #aaa;
        cursor: pointer;
    }

    .custom-modal .close-modal:hover {
        color: #e74c3c;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <h3>Summary of your appointments</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">Appointment</li>
        </ul>
    </div>

    <!-- Appointments Summary -->
    <div class="content-section">
        <div class="section-header mb-3">
            <button class="btn btn-primary">Download Full Report</button>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Date</th>
                    <th>Professional Name</th>
                    <th>Service Category</th>
                    <th>Sessions Taken</th>
                    <th>Sessions Remaining</th>
                    <th>Summary/Remarks</th>
                    <th>Documents</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $key => $booking)
                    @php
                        $sessionsTaken = $booking->timedates->where('status', 'pending')->count();
                        $sessionsRemaining = $booking->total_sessions - $sessionsTaken;
                        $latestTimedate = $booking->timedates->where('status', 'pending')->first();
                    @endphp
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $latestTimedate ? \Carbon\Carbon::parse($latestTimedate->date)->format('d-m-Y') : '-' }}</td>
                        <td>{{ $booking->professional->name ?? 'No Professional' }}</td>
                        <td>{{ $booking->service_name }}</td>
                        <td>{{ $sessionsTaken }}</td>
                        <td>{{ $sessionsRemaining }}</td>
                        <td>{{ $booking->remarks ?? 'No remarks' }}</td>
                        <td>
                            @if ($booking->professional_documents)
                            <a href="{{ asset('storage/' . $booking->professional_documents) }}" class="btn btn-sm btn-secondary mt-1" target="_blank">
                                <img src="{{ asset('images/pdf-icon.png') }}" alt="PDFs" style="width: 20px;">
                            </a>
                        @else
                            No Documents
                        @endif
                        
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary view-details-btn" data-id="{{ $booking->id }}">
                                View Details
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Custom Appointment Details Modal -->
    <div id="customModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="close-modal">&times;</span>
            <h4>Appointment Details</h4>
            <table class="table table-bordered" id="appointmentDetailsTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time Slot(s)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

</div>
@endsection
@section('scripts')
<script>
   $(document).on('click', '.view-details-btn', function () {
    const bookingId = $(this).data('id');

    $.ajax({
        url: `/user/appointments/${bookingId}/details`,  
        type: 'GET',
        success: function (response) {
            const tbody = $('#appointmentDetailsTable tbody');
            tbody.empty();

            response.dates.forEach(item => {
                const timeSlots = item.time_slot.join(', ');
                const status = item.status ?? 'Pending';

                tbody.append(`
                    <tr>
                        <td>${item.date}</td>
                        <td>${timeSlots}</td>
                        <td>${status}</td>
                    </tr>
                `);
            });

            $('#customModal').show();  // Shows the modal
        },
        error: function () {
            alert('Failed to load appointment details.');
        }
    });
});

// Close modal
$(document).on('click', '.close-modal', function () {
    $('#customModal').hide();  // Hides the modal
});

// Close modal when clicking outside modal content
$(window).on('click', function (e) {
    if ($(e.target).is('#customModal')) {
        $('#customModal').hide();  // Hides the modal
    }
});

</script>
@endsection
