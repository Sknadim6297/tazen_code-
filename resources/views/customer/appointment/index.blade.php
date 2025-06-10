@extends('customer.layout.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/appointment.css') }}" />

<style>
    /* Custom Modal Styles */
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(3px);
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .custom-modal-content {
        background-color: #fff;
        margin: 5% auto;
        width: 90%;
        max-width: 800px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        position: relative;
        animation: slideDown 0.4s ease-out;
        overflow: hidden;
    }

    @keyframes slideDown {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-header {
        background: linear-gradient(to right, #2c3e50, #3498db);
        color: white;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: none;
    }

    .modal-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 1.4rem;
        color: white;
    }

    .modal-body {
        padding: 20px;
        max-height: 60vh;
        overflow-y: auto;
    }

    .custom-modal .close-modal {
        color: white;
        opacity: 0.8;
        font-size: 28px;
        cursor: pointer;
        transition: all 0.2s;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .custom-modal .close-modal:hover {
        opacity: 1;
        transform: scale(1.1);
        background: rgba(255, 255, 255, 0.1);
    }

    /* Enhanced Table Styles */
    #appointmentDetailsTable {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e6e6e6;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    #appointmentDetailsTable thead th {
        background-color: #f8f9fa;
        color: #333;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
        padding: 15px;
        vertical-align: middle;
        border-bottom: 2px solid #dee2e6;
        text-align: left;
    }

    #appointmentDetailsTable tbody td {
        padding: 15px;
        vertical-align: middle;
        border-top: 1px solid #e9ecef;
        color: #495057;
        transition: background 0.2s;
    }

    #appointmentDetailsTable tbody tr:hover {
        background-color: #f7fbff;
    }

    /* Status styles */
    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-completed {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }

    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    /* Remarks section */
    .remarks-cell {
        max-width: 250px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .empty-state {
        color: #6c757d;
        font-style: italic;
    }

    /* Footer actions */
    .modal-footer {
        padding: 15px 20px;
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .modal-footer .btn {
        padding: 8px 20px;
        border-radius: 5px;
        transition: all 0.3s;
    }
    .search-container {
        background: #f5f7fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .search-form {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: flex-end;
    }

    .search-form .form-group {
        flex: 1;
        min-width: 200px;
        display: flex;
        flex-direction: column;
    }

    .search-form label {
        margin-bottom: 5px;
        font-weight: 600;
        color: #333;
    }

    .search-form input[type="text"],
    .search-form input[type="date"] {
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 14px;
    }

    .search-buttons {
        display: flex;
        gap: 10px;
    }

    .search-buttons button,
    .search-buttons a {
        padding: 10px 20px;
        font-size: 14px;
        border-radius: 6px;
        cursor: pointer;
        text-decoration: none;
        border: none;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
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
<div class="search-container">
    <form action="{{ route('user.all-appointment.index') }}" method="GET" class="search-form">
        <div class="form-group">
            <label for="search_name">Search</label>
            <input type="text" name="search_name" id="search_name" value="{{ request('search_name') }}" placeholder="Search appointment">
        </div>

        <div class="form-group">
            <label for="search_date_from">From Date</label>
            <input type="date" name="search_date_from" value="{{ request('search_date_from') }}">
        </div>

        <div class="form-group">
            <label for="search_date_to">To Date</label>
            <input type="date" name="search_date_to" value="{{ request('search_date_to') }}">
        </div>

        <div class="search-buttons">
            <button type="submit" class="btn-success">Search</button>
            <a href="{{ route('user.all-appointment.index') }}" class="btn-secondary">Reset</a>
        </div>
    </form>
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
                    <th>Booking date</th>
                    <th>Professional Name</th>
                    <th>Service Category</th>
                    <th>Sessions Taken</th>
                    <th>Sessions Remaining</th>
                    <th>Documents</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
    @foreach ($bookings as $key => $booking)
        @php
            $totalSessions = $booking->timedates->count();
            $sessionsTaken = $booking->timedates->where('status', '!=', 'pending')->count();

            // Sessions remaining (count of 'pending' timedates)
            $sessionsRemaining = $totalSessions - $sessionsTaken;
        @endphp

        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $booking->timedates->first() ? \Carbon\Carbon::parse($booking->timedates->first()->date)->format('d-m-Y') : '-' }}</td>
            <td>{{ $booking->professional->name ?? 'No Professional' }}</td>
            <td>{{ $booking->service_name }}</td>
            <td>{{ $sessionsTaken }}</td> <!-- Sessions taken -->
            <td>{{ $sessionsRemaining }}</td> <!-- Sessions remaining -->
            <td>
                @if ($booking->professional_documents)
                    <a href="{{ asset('storage/' . $booking->professional_documents) }}" class="btn btn-sm btn-secondary mt-1" target="_blank">
                        <img src="{{ asset('images/pdf-icon.png') }}" alt="PDF" style="width: 20px;">
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

    <!-- Enhanced Appointment Details Modal -->
    <div id="customModal" class="custom-modal">
        <div class="custom-modal-content">
            <div class="modal-header">
                <h4>Appointment Details</h4>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <table class="table" id="appointmentDetailsTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time Slot(s)</th>
                            <th>Status</th>
                            <th>Summary/Remarks</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal-btn">Close</button>
            </div>
        </div>
    </div>

</div>
<style>
    @media screen and (max-width: 767px) {
        /* Fix header to prevent horizontal scrolling */
        .page-header {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f8f9fa;
            padding-top: 10px;
            padding-bottom: 10px;
            width: 100%;
            max-width: 100vw;
            overflow-x: hidden;
        }
        
        /* Make table container scrollable horizontally */
        .content-section {
            overflow-x: auto;
            max-width: 100%;
            -webkit-overflow-scrolling: touch; /* Better scrolling on iOS */
            padding: 10px;
        }
        
        /* Ensure the table takes full width of container */
        .table {
            width: 100%;
            min-width: 800px; /* Minimum width to ensure all columns are visible */
        }
        
        /* Fix the search container from overflowing */
        .search-container {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
            padding: 15px;
        }
        
        /* Ensure content wrapper doesn't cause horizontal scroll */
        .content-wrapper {
            overflow-x: hidden;
            width: 100%;
            max-width: 100vw;
            padding: 15px 10px;
        }
        
        /* Make table columns width-responsive */
        .table th,
        .table td {
            white-space: nowrap;
            padding: 8px;
        }
        
        /* Adjust button sizes for mobile */
        .btn-sm {
            padding: 4px 8px;
            font-size: 12px;
        }
        
        /* Ensure modal content is properly sized on mobile */
        .custom-modal-content {
            width: 95%;
            margin: 10% auto;
            padding: 15px;
        }
    }

    @media only screen and (min-width: 768px) and (max-width: 1024px) {

         /* Fix header to prevent horizontal scrolling */
        .page-header {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f8f9fa;
            padding-top: 10px;
            padding-bottom: 10px;
            width: 100%;
            max-width: 100vw;
            overflow-x: hidden;
        }
        
        /* Make table container scrollable horizontally */
        .content-section {
            overflow-x: auto;
            max-width: 100%;
            -webkit-overflow-scrolling: touch; /* Better scrolling on iOS */
            padding: 10px;
        }
        
        /* Ensure the table takes full width of container */
        .table {
            width: 100%;
            min-width: 800px; /* Minimum width to ensure all columns are visible */
        }
        
        /* Fix the search container from overflowing */
        .search-container {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
        padding: 15px;
    }
        
        /* Ensure content wrapper doesn't cause horizontal scroll */
        .content-wrapper {
            overflow-x: hidden;
            width: 100%;
            max-width: 100vw;
            padding: 15px 10px;
        }
        
        /* Make table columns width-responsive */
        .table th,
        .table td {
            white-space: nowrap;
            padding: 8px;
        }
        
        /* Adjust button sizes for mobile */
        .btn-sm {
            padding: 4px 8px;
            font-size: 12px;
        }
        
        /* Ensure modal content is properly sized on mobile */
        .custom-modal-content {
            width: 95%;
            margin: 10% auto;
            padding: 15px;
        }
    }

    /* Responsive styles for modal */
@media screen and (max-width: 767px) {
    .custom-modal-content {
        width: 95%;
        margin: 10% auto;
    }
    
    .modal-header h4 {
        font-size: 1.2rem;
    }
    
    #appointmentDetailsTable thead th {
        font-size: 0.7rem;
        padding: 10px 5px;
    }
    
    #appointmentDetailsTable tbody td {
        padding: 10px 5px;
    }
    
    .status-badge {
        padding: 4px 8px;
        font-size: 11px;
    }
    
    .remarks-cell {
        max-width: 100px;
    }
    
    .modal-body {
        padding: 10px;
        max-height: 70vh;
    }
}
</style>
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
                const status = item.status ?? 'pending';
                
                // Generate status badge with appropriate class
                let statusClass = '';
                switch(status.toLowerCase()) {
                    case 'completed':
                        statusClass = 'status-completed';
                        break;
                    case 'pending':
                        statusClass = 'status-pending';
                        break;
                    case 'cancelled':
                        statusClass = 'status-cancelled';
                        break;
                    default:
                        statusClass = 'status-pending';
                }
                
                const statusBadge = `<span class="status-badge ${statusClass}">${status}</span>`;
                const formattedDate = new Date(item.date).toLocaleDateString('en-GB', {
                    day: '2-digit', 
                    month: 'short', 
                    year: 'numeric'
                });
                
                const remarks = item.remarks ? item.remarks : '<span class="empty-state">No remarks available</span>';

                tbody.append(`
                    <tr>
                        <td>${formattedDate}</td>
                        <td>${timeSlots}</td>
                        <td>${statusBadge}</td>
                        <td class="remarks-cell">${remarks}</td>
                    </tr>
                `);
            });

            $('#customModal').show();  
        },
        error: function () {
            alert('Failed to load appointment details.');
        }
    });
});

// Close modal - both X button and the Close button in footer
$(document).on('click', '.close-modal, .close-modal-btn', function () {
    $('#customModal').hide();
});

// Close modal when clicking outside modal content
$(window).on('click', function (e) {
    if ($(e.target).is('#customModal')) {
        $('#customModal').hide();
    }
});
</script>
@endsection
