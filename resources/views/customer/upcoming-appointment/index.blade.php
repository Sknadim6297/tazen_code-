@extends('customer.layout.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/upcoming-appointment.css') }}" />
<style>
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
            <h3>Upcoming Details of Your Appointments</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">upcoming-appointment</li>
        </ul>
    </div>
<div class="search-container">
    <form action="{{ route('user.upcoming-appointment.index') }}" method="GET" class="search-form">
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
            <a href="{{ route('user.upcoming-appointment.index') }}" class="btn-secondary">Reset</a>
        </div>
    </form>
</div>

    <div class="content-section">
        <div class="section-header">
            
            <button class="btn btn-primary">Add New Appointment</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Date</th>
                    <th>Month</th>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Professional Name</th>
                    <th>Service Category</th>
                    <th>Sessions Taken</th>
                    <th>Sessions Remaining</th>
                    <th>Meet Link</th>
                    <th>Documents</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $index => $booking)
                    @php
                        // Filter for future timedates and get the first upcoming one
                        $upcomingTimedate = $booking->timedates->filter(function ($timedate) {
                            return \Carbon\Carbon::parse($timedate->date)->isFuture(); 
                        })->first(); 
                        if ($upcomingTimedate) {
                            $sessionsTaken = $booking->timedates->where('status', 'pending')->count();
                            $sessionsRemaining = $booking->total_sessions - $sessionsTaken;
                        }
                    @endphp
        
                    @if ($upcomingTimedate)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($upcomingTimedate->date)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($upcomingTimedate->date)->format('F') }}</td>
                            <td>{{ \Carbon\Carbon::parse($upcomingTimedate->date)->format('D') }}</td>
                            <td>{{ $upcomingTimedate->time_slot}}</td>
                            <td>{{ $booking->professional->name }}</td>
                            <td>{{ $booking->service_name }}</td>
                            <td>{{ $sessionsTaken }}</td>
                            <td>{{ $sessionsRemaining }}</td>
                            <td><button class="btn btn-primary" style="padding: 4px 8px;"><a href="{{ $booking->meeting_link }}" style="color:white">Join</a></button></td>
                            <td>
                                @if($booking->professional_documents)
                                    <a href="{{ asset('storage/' . $booking->professional_documents) }}" class="btn btn-sm btn-secondary" target="_blank">
                                        <i class="fas fa-upload action-icon"></i>
                                    </a>
                                @else
                                    No Documents
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        
       
    </div>
</div>
@endsection
@section('scripts')

@endsection
