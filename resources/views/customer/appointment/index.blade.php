@extends('customer.layout.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/appointment.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
    .search-form input[type="date"],
    .search-form select {
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

    /* Service highlight */
    .service-highlight {
        background-color: #e7f3ff;
    }
    
    /* Plan type highlight */
    .plan-highlight {
        background-color: #f0fff0;
    }
    
    .export-buttons {
        display: flex;
        gap: 10px;
    }
    
    .btn-export {
        padding: 8px 15px;
        font-size: 14px;
        border-radius: 6px;
        text-align: center;
    }
    
    .btn-pdf {
        background-color: #dc3545;
        color: white;
    }
    
    .btn-excel {
        background-color: #28a745;
        color: white;
    }

    /* Plan type badge */
    .plan-type-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 600;
        background-color: #e3f2fd;
        color: #0d47a1;
        border: 1px solid #bbdefb;
    }

    .plan-type-premium {
        background-color: #fce4ec;
        color: #c2185b;
        border-color: #f8bbd0;
    }

    .plan-type-standard {
        background-color: #e8f5e9;
        color: #2e7d32;
        border-color: #c8e6c9;
    }

    .plan-type-basic {
        background-color: #ede7f6;
        color: #4527a0;
        border-color: #d1c4e9;
    }

    .plan-type-corporate {
        background-color: #fff3e0;
        color: #e65100;
        border-color: #ffe0b2;
    }

    /* Chat notification badge - TEMPORARILY DISABLED */
    /*
    .chat-badge {
        font-size: 10px;
        min-width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 5px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: translate(-50%, -50%) scale(1);
        }
        50% {
            transform: translate(-50%, -50%) scale(1.1);
        }
    }

    .btn.position-relative {
        overflow: visible;
    }
    */
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

            <!-- Service Filter -->
            <div class="form-group">
                <label for="service">Service</label>
                <select name="service" id="service" class="form-control">
                    <option value="all">All Services</option>
                    @foreach($serviceOptions as $service)
                        <option value="{{ $service }}" {{ request('service') == $service ? 'selected' : '' }}>
                            {{ $service }}
                        </option>
                    @endforeach
                </select>
            </div>
<!-- filepath: c:\xampp\htdocs\tazen_marge_code\Tazen_multi\resources\views\customer\appointment\index.blade.php -->

<!-- Add this helper function in the PHP section at the top of the blade file -->
@php
    /**
     * Format plan type for display (e.g., "one_time" becomes "One Time")
     *
     * Wrapped in function_exists check to avoid redeclaration when views are
     * compiled multiple times or included from other templates.
     */
    if (! function_exists('formatPlanType')) {
        function formatPlanType($planType) {
            if (empty($planType)) return null;

            // Handle special case for "one_time"
            if (strtolower($planType) == 'one_time') {
                return 'One Time';
            }
            if( strtolower($planType) == 'no_plan') {
                return 'No Plan';
            }
            if( strtolower($planType) == 'monthly') {
                return 'Monthly';
            }
            if ( strtolower($planType) == 'quarterly') {
                return 'Quarterly';
            }
            if ( strtolower($planType) == 'free_hand') {
                return 'Free Hand';
            }

            // Replace underscores with spaces and capitalize each word
            $planType = str_replace('_', ' ', $planType);
            return ucwords($planType);
        }
    }
@endphp
            <!-- Plan Type Filter -->
            <!-- Update the plan type filter dropdown -->
<div class="form-group">
    <label for="plan_type">Plan Type</label>
    <select name="plan_type" id="plan_type" class="form-control">
        <option value="all">All Plans</option>
        @foreach($planTypeOptions as $planType)
            @php
                $formattedPlanType = formatPlanType($planType);
                // For value attribute, keep the original database value
                $originalValue = $planType;
            @endphp
            <option value="{{ $originalValue }}" {{ request('plan_type') == $originalValue ? 'selected' : '' }}>
                {{ $formattedPlanType }}
            </option>
        @endforeach
    </select>
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
        <div class="section-header mb-3 d-flex justify-content-between align-items-center">
            <h4>
                Results: {{ $bookings->count() }} {{ Str::plural('appointment', $bookings->count()) }}
                @if(request('service') && request('service') != 'all')
                    for <strong>{{ request('service') }}</strong>
                @endif
                @if(request('plan_type') && request('plan_type') != 'all')
                    with plan <strong>{{ request('plan_type') }}</strong>
                @endif
            </h4>
            {{-- <div class="export-buttons">
                <a href="{{ route('user.all-appointment.index', array_merge(request()->all(), ['export' => 'pdf'])) }}" class="btn-export btn-pdf">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
                <a href="{{ route('user.all-appointment.index', array_merge(request()->all(), ['export' => 'excel'])) }}" class="btn-export btn-excel">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
            </div> --}}
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Booking date</th>
                    <th>Professional Name</th>
                    <th>Service Category</th>
                    <th>Sub-Service</th>
                    <th>Plan Type</th>
                    <th>Sessions Taken</th>
                    <th>Sessions Remaining</th>
                    <th>Documents</th>
                    {{-- <th>Chat</th> --}}
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bookings as $key => $booking)
                    @php
                        $totalSessions = $booking->timedates->count();
                        $sessionsTaken = $booking->timedates->where('status', '!=', 'pending')->count();

                        // Sessions remaining (count of 'pending' timedates)
                        $sessionsRemaining = $totalSessions - $sessionsTaken;
                        
                        // Check if this service is the one being filtered
                        $isFilteredService = request('service') == $booking->service_name;
                        
                        // Check if this plan type is the one being filtered
                        $isFilteredPlan = request('plan_type') == $booking->plan_type;
                        
                        // Determine plan type class
                        $planTypeClass = 'plan-type-badge';
                        if (strtolower($booking->plan_type) == 'premium') {
                            $planTypeClass .= ' plan-type-premium';
                        } elseif (strtolower($booking->plan_type) == 'standard') {
                            $planTypeClass .= ' plan-type-standard';
                        } elseif (strtolower($booking->plan_type) == 'basic') {
                            $planTypeClass .= ' plan-type-basic';
                        } elseif (strtolower($booking->plan_type) == 'corporate') {
                            $planTypeClass .= ' plan-type-corporate';
                        }
                    @endphp

                    <tr class="{{ $isFilteredService ? 'service-highlight' : '' }} {{ $isFilteredPlan ? 'plan-highlight' : '' }}">
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $booking->timedates->first() ? \Carbon\Carbon::parse($booking->timedates->first()->date)->format('d-m-Y') : '-' }}</td>
                        <td>{{ $booking->professional->name ?? 'No Professional' }}</td>
                        <td>
                            @if($isFilteredService)
                                <strong>{{ $booking->service_name }}</strong>
                            @else
                                {{ $booking->service_name }}
                            @endif
                        </td>
                        <td>
                            @if($booking->sub_service_name)
                                <span class="badge bg-info">{{ $booking->sub_service_name }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                      <!-- Change this part in the table row -->
<td>
    @if($booking->plan_type)
        @php
            $formattedPlanType = formatPlanType($booking->plan_type);
            
            // Determine plan type class - use the raw value for class determination
            $planTypeClass = 'plan-type-badge';
            $planTypeLower = strtolower($booking->plan_type);
            
            if ($planTypeLower == 'premium') {
                $planTypeClass .= ' plan-type-premium';
            } elseif ($planTypeLower == 'standard') {
                $planTypeClass .= ' plan-type-standard';
            } elseif ($planTypeLower == 'basic') {
                $planTypeClass .= ' plan-type-basic';
            } elseif ($planTypeLower == 'corporate') {
                $planTypeClass .= ' plan-type-corporate';
            } elseif ($planTypeLower == 'one_time') {
                $planTypeClass .= ' plan-type-one-time';
            }
        @endphp
        <span class="{{ $planTypeClass }}">{{ $formattedPlanType }}</span>
    @else
        <span class="empty-state">No Plan</span>
    @endif
</td>
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
                        {{-- <td>
                            <a href="{{ route('user.chat.open', $booking->id) }}" 
                               class="btn btn-sm btn-success position-relative chat-btn-{{ $booking->id }}" 
                               target="_blank" 
                               title="Chat with Professional"
                               data-booking-id="{{ $booking->id }}">
                                <i class="fas fa-comments"></i> Chat
                                <span class="chat-badge badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill d-none" 
                                      id="chat-badge-{{ $booking->id }}">
                                    0
                                </span>
                            </a>
                        </td> --}}
                        <td>
                            <button class="btn btn-sm btn-primary view-details-btn" data-id="{{ $booking->id }}">
                                View Details
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">No appointments found</td>
                    </tr>
                @endforelse
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

        .content-section {
            overflow-x: auto;
            max-width: 100%;
            -webkit-overflow-scrolling: touch; 
            padding: 10px;
        }
        .table {
            width: 100%;
            min-width: 900px;
        }
        

        .search-container {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
            padding: 15px;
        }

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
        
        /* Make the export buttons stack on mobile */
        .export-buttons {
            flex-direction: column;
            width: 100%;
        }
        
        .btn-export {
            width: 100%;
            margin-bottom: 5px;
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
            min-width: 900px; /* Increased minimum width to accommodate new column */
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



/*
// CHAT FUNCTIONALITY TEMPORARILY DISABLED
function openBookingChat(bookingId) {
    // Prevent opening multiple chats
    if(currentBookingChatId === bookingId && $('#bookingChatModal').is(':visible')) {
        return;
    }
    
    // Clear any existing interval
    if(messageCheckInterval) {
        clearInterval(messageCheckInterval);
        messageCheckInterval = null;
    }
    
    currentBookingChatId = bookingId;
    isPolling = false;
    
    // Initialize or get existing chat
    $.ajax({
        url: '/user/booking-chat/initialize',
        type: 'POST',
        data: {
            booking_id: bookingId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if(response.success) {
                currentChatId = response.chat_id;
                
                // Update modal title with booking context
                const title = `
                    <div>
                        <strong>${response.booking.service_name}</strong><br>
                        <small style="font-weight: normal; opacity: 0.8;">
                            Chat with ${response.participant.name} (${response.participant.type})
                        </small>
                    </div>
                `;
                $('#chatModalTitle').html(title);
                $('#bookingChatModal').fadeIn(300);
                
                // Load messages
                loadChatMessages(bookingId);
                
                // Attach send button click handler directly (not delegated)
                $('#sendMessageBtn').off('click').on('click', function() {
                    console.log('Send button clicked');
                    sendChatMessage();
                });
                
                // Attach Enter key handler directly
                $('#chatMessageInput').off('keypress').on('keypress', function(e) {
                    if(e.which === 13) {
                        console.log('Enter key pressed');
                        sendChatMessage();
                    }
                });
                
                // Start polling only if not already polling
                if(!messageCheckInterval && !isPolling) {
                    isPolling = true;
                    messageCheckInterval = setInterval(() => {
                        if($('#bookingChatModal').is(':visible')) {
                            loadChatMessages(bookingId);
                        }
                    }, 3000);
                }
            }
        },
        error: function(xhr) {
            alert('Error opening chat: ' + (xhr.responseJSON?.error || 'Unknown error'));
        }
    });
}

function loadChatMessages(bookingId) {
    $.ajax({
        url: `/user/booking-chat/${bookingId}/messages`,
        type: 'GET',
        success: function(response) {
            if(response.success) {
                displayChatMessages(response.messages);
            }
        },
        error: function(xhr) {
            console.error('Error loading messages:', xhr);
        }
    });
}

function displayChatMessages(messages) {
    const chatContainer = $('#chatMessages');
    const wasScrolledToBottom = chatContainer[0].scrollHeight - chatContainer.scrollTop() <= chatContainer.outerHeight() + 50;
    
    chatContainer.empty();
    
    if(messages.length === 0) {
        chatContainer.append('<div style="text-align: center; color: #999; padding: 20px;">No messages yet. Start the conversation!</div>');
    } else {
        messages.forEach(msg => {
            const isOwn = msg.sender_type === 'customer';
            const messageClass = isOwn ? 'message-own' : 'message-other';
            
            // Get sender name - fallback to type if name not available
            let senderName = msg.sender_name || 'Unknown';
            if (!msg.sender_name) {
                senderName = isOwn ? 'You' : (msg.sender_type === 'professional' ? 'Professional' : msg.sender_type);
            } else if (isOwn) {
                senderName = 'You';
            }
            
            const time = msg.formatted_time || new Date(msg.created_at).toLocaleTimeString('en-US', {hour: '2-digit', minute: '2-digit'});
            
            let messageContent = '';
            
            // Handle different message types
            if(msg.message_type === 'image' && msg.file_path) {
                messageContent = `
                    <img src="/storage/${msg.file_path}" alt="Image" style="max-width: 200px; border-radius: 8px; cursor: pointer;" onclick="window.open('/storage/${msg.file_path}', '_blank')">
                    ${msg.message ? '<div>' + msg.message + '</div>' : ''}
                `;
            } else if(msg.message_type === 'file' && msg.file_path) {
                const fileName = msg.file_path.split('/').pop();
                messageContent = `
                    <a href="/storage/${msg.file_path}" target="_blank" style="color: inherit; text-decoration: underline;">
                        <i class="fas fa-file"></i> ${fileName}
                    </a>
                    ${msg.message ? '<div>' + msg.message + '</div>' : ''}
                `;
            } else {
                messageContent = msg.message;
            }
            
            chatContainer.append(`
                <div class="chat-message ${messageClass}">
                    <div class="message-sender" style="font-weight: bold; margin-bottom: 5px;">${senderName}</div>
                    <div class="message-content">${messageContent}</div>
                    <div class="message-time" style="font-size: 11px; opacity: 0.7; margin-top: 5px;">${time}</div>
                </div>
            `);
        });
    }
    
    // Auto scroll to bottom
    if(wasScrolledToBottom) {
        chatContainer.scrollTop(chatContainer[0].scrollHeight);
    }
}

function sendChatMessage() {
    const messageInput = $('#chatMessageInput');
    const fileInput = $('#chatFileInput')[0];
    
    console.log('sendChatMessage called');
    console.log('messageInput element:', messageInput);
    console.log('messageInput length:', messageInput.length);
    console.log('messageInput value:', messageInput.val());
    
    const message = messageInput.val()?.trim() || '';
    const file = fileInput?.files[0];
    
    console.log('After processing - message:', message);
    console.log('After processing - message length:', message.length);
    console.log('After processing - file:', file);
    
    console.log('Sending message:', { message: message, hasFile: !!file });
    
    if(!message && !file) {
        console.log('No message or file to send');
        return;
    }
    
    const formData = new FormData();
    if(message) formData.append('message', message);
    if(file) formData.append('file', file);
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    
    console.log('FormData contents:', {
        hasMessage: formData.has('message'),
        hasFile: formData.has('file'),
        hasToken: formData.has('_token')
    });
    
    // Disable send button
    $('#sendMessageBtn').prop('disabled', true);
    
    $.ajax({
        url: `/user/booking-chat/${currentBookingChatId}/send`,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log('Message sent successfully:', response);
            if(response.success) {
                messageInput.val('');
                if(fileInput) fileInput.value = '';
                $('#selectedFileName').text('');
                loadChatMessages(currentBookingChatId);
            } else {
                console.error('Response success was false:', response);
                alert('Failed to send message: ' + (response.error || 'Unknown error'));
            }
        },
        error: function(xhr) {
            console.error('Error sending message:', xhr);
            const errorMsg = xhr.responseJSON?.error || xhr.responseJSON?.message || 'Unknown error';
            const details = xhr.responseJSON?.details ? JSON.stringify(xhr.responseJSON.details) : '';
            alert('Error sending message: ' + errorMsg + (details ? '\n' + details : ''));
        },
        complete: function() {
            $('#sendMessageBtn').prop('disabled', false);
        }
    });
}

// Show selected file name
$(document).on('change', '#chatFileInput', function() {
    const fileName = this.files[0]?.name || '';
    $('#selectedFileName').text(fileName ? `📎 ${fileName}` : '');
});

// Close modal and stop polling - Use OFF to prevent multiple bindings
$(document).off('click', '#closeChatModal').on('click', '#closeChatModal', function() {
    $('#bookingChatModal').fadeOut(300);
    if(messageCheckInterval) {
        clearInterval(messageCheckInterval);
        messageCheckInterval = null;
        isPolling = false;
    }
    currentBookingChatId = null;
    currentChatId = null;
});

// Close on outside click
$(window).off('click.chatModal').on('click.chatModal', function (e) {
    if ($(e.target).is('#bookingChatModal')) {
        $('#closeChatModal').trigger('click');
    }
});

// Load unread chat counts for all bookings
function loadUnreadChatCounts() {
    $('[data-booking-id]').each(function() {
        const bookingId = $(this).data('booking-id');
        const badgeElement = $(`#chat-badge-${bookingId}`);
        
        $.ajax({
            url: `/user/chat/booking/${bookingId}/unread-count`,
            method: 'GET',
            success: function(response) {
                if(response.success && response.unread_count > 0) {
                    badgeElement.text(response.unread_count);
                    badgeElement.removeClass('d-none');
                } else {
                    badgeElement.addClass('d-none');
                }
            },
            error: function() {
                // Silently fail
            }
        });
    });
}

// Load counts on page load
$(document).ready(function() {
    loadUnreadChatCounts();
    
    // Refresh counts every 30 seconds
    setInterval(loadUnreadChatCounts, 30000);
});
*/

</script>

@endsection
