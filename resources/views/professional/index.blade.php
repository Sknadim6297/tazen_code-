@extends('professional.layout.layout')
@section('style')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive2.css') }}" media="screen and (max-width: 992px)">

<style>
    html, body {
        overflow-x: hidden;
        max-width: 100%;
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
    
    /* Fix all container elements to prevent horizontal scrolling */
    body, .content-wrapper, .container, .container-fluid, .content-card {
        overflow-x: hidden !important;
        max-width: 100% !important;
        position: relative;
    }
    
    /* Critical table scrolling styles */
    .table-wrapper {
        width: 100%;
        overflow-x: scroll !important;
        -webkit-overflow-scrolling: touch;
        margin: 0;
        padding: 0;
        position: relative;
    }
    
    /* Set table to minimum width to ensure it triggers horizontal scroll */
    .table {
        min-width: 800px; /* Ensures table is wide enough to scroll */
        width: 100%;
        margin: 0;
    }
    
    /* Force no-wrap on table cells */
    .table th,
    .table td {
        white-space: nowrap;
    }
    
    /* Ensure the card body doesn't cause overflow */
    .card-body {
        padding: 10px 5px;
        overflow-x: hidden;
    }

    /* Card styling */
    .card {
        width: 100%;
        overflow-x: hidden;
    }

    /* Fix content card to contain the table properly */
    .content-card {
        overflow-x: hidden;
        width: 100%;
    }

    .card-header {
        overflow-x: hidden;
    }
}
</style>
@endsection
@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <h3>Dashboard</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">Dashboard</li>
        </ul>
    </div>

    <!-- Dashboard Cards -->
    <div class="card-grid">
        @php
    use Illuminate\Support\Facades\Auth;
    use App\Models\Booking;

    $professionalId = Auth::guard('professional')->id();
    $totalBookings = Booking::where('professional_id', $professionalId)->count();
@endphp

         <div class="card card-primary">
        <div class="card-icon">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="card-info">
            <h4>Total Bookings</h4>
            <h2>{{ $totalBookings }}</h2>
            <p class="positive"><i class="fas fa-arrow-up"></i> 12% from last month</p>
        </div>
    </div>

        <div class="card card-success">
            <div class="card-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-info">
                <h4>Total Revenue</h4>
                <h2>₹12,600</h2>
                <p class="positive"><i class="fas fa-arrow-up"></i> 8% from last month</p>
            </div>
        </div>

        @php
    $professionalId = Auth::guard('professional')->id();
    $activeClients = Booking::where('professional_id', $professionalId)
 
                            ->distinct('user_id')
                            ->count('user_id');
@endphp

<div class="card card-warning">
    <div class="card-icon">
        <i class="fas fa-users"></i>
    </div>
    <div class="card-info">
        <h4>Active Clients</h4>
        <h2>{{ $activeClients }}</h2>
        <p class="negative"><i class="fas fa-arrow-down"></i> 2% from last month</p>
    </div>
</div>


        <div class="card card-danger">
            <div class="card-icon">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="card-info">
                <h4>Pending Tasks</h4>
                <h2>7</h2>
                <p class="positive"><i class="fas fa-arrow-up"></i> 3 new today</p>
            </div>
        </div>
    </div>
@php

    $professionalId = Auth::guard('professional')->id();

    $recentBookings = Booking::with('customerProfile')
                        ->where('professional_id', $professionalId)
                        ->latest()
                        ->take(5)
                        ->get();
@endphp

    <!-- Recent Bookings -->
    <div class="content-card">
        <div class="card-header">
            <h4>Recent Bookings</h4>
            <div class="card-action">
                <button><a href="{{ route('professional.booking.index') }}">View All</a></button>
                <button>Export</button>
            </div>
        </div>

        <!-- Wrap table in table-wrapper div for horizontal scrolling -->
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Meeting Link</th>
                        <th>Action</th>
                    </tr>
                </thead>
            <tbody>
    @foreach ($recentBookings as $booking)
    @php
    @endphp
        <tr>
            <td>
                <div class="user-profile" style="margin-left: 0;">
                    <img src="{{ $booking->customerProfile->profile_image ?? 'https://via.placeholder.com/30' }}" 
                         alt="User" style="width: 30px; height: 30px;">
                    <div class="user-info">
                        <h5>{{ $booking->customer_name ?? 'N/A' }}</h5>
                    </div>
                </div>
            </td>
            <td>{{ ucfirst($booking->plan_type ?? 'N/A') }}</td>
            <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') }}</td>
            <td>{{ $booking->time_slot }}</td>
            <td>₹{{ $booking->customerProfile->package_price ?? 'N/A' }}</td>
            <td>
                <span class="status-badge 
                    @if(strtolower($booking->session_type) == 'completed') success
                    @elseif(strtolower($booking->session_type) == 'pending') warning
                    @elseif(strtolower($booking->session_type) == 'confirmed') info
                    @else secondary
                    @endif">    
                    {{ ucfirst($booking->session_type) }}
                </span>
            </td>
            <td>
                @if ($booking->meeting_link)
                    <a href="{{ $booking->meeting_link }}" target="_blank" class="action-btn">
                        <i class="fas fa-video"></i> Join
                    </a>
                @else
                    <span class="text-gray">Not scheduled</span>
                @endif
            </td>
            <td>
                <div class="action-btn"><i class="fas fa-eye"></i></div>
            </td>
        </tr>
    @endforeach
</tbody>

            </table>
        </div>
    </div>
@endsection