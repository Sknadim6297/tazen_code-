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
            min-width: 1000px; /* Minimum width to ensure all columns are visible */
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
        
        /* Style for the Join link */
        .table a {
            padding: 4px 8px;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-size: 12px;
        }
        
        /* Style for badges */
        .badge {
            padding: 4px 8px;
            font-size: 12px;
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
</style>
@endsection

@section('content')
<div class="content-wrapper">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <h3>Summary of your Event booking</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">events</li>
        </ul>
    </div>
<div class="search-container">
    <form action="{{ route('user.customer-event.index') }}" method="GET" class="search-form">
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
            <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sl.No</th>
                <th>Event Name</th>
                <th>Event Date</th>
                <th>Address</th>
                <th>Type</th>
                <th>No. of Persons</th>
                <th>Paid Price</th>
                <th>Gmeet Link</th>
                <th>Payment Status</th>
                <th>Order ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $index => $booking)
                <tr>
                    <td>{{ $index + 1 }}</td>
    <td>{{ $booking->event->heading ?? 'N/A' }}</td>
                    <td>{{ $booking->event_date }}</td>
                    <td>{{ $booking->location ?? 'N/A' }}</td>
                    <td>{{ $booking->type ?? 'N/A' }}</td>
                    <td>{{ $booking->persons ?? 'N/A' }}</td>
                    <td>₹{{ number_format($booking->total_price, 2) }}</td>
                    <td>
       <a href="{{ $booking->gmeet_link }}" target="_blank">Join</a>
    </td>

                    <td>
                        @if($booking->payment_status == 'success')
                            <span class="badge bg-success">Confirmed</span>
                        @elseif($booking->payment_status == 'failed')
                            <span class="badge bg-warning text-dark">Failed</span>
                        @else
                            <span class="badge bg-danger">Unknown</span>
                        @endif
                    </td>
                    <td>{{ $booking->order_id ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
            </table>
    </div>

</div>

@endsection
@section('scripts')

@endsection


