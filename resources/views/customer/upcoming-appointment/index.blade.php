@extends('customer.layout.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/upcoming-appointment.css') }}" />

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
