@extends('professional.layout.layout')
@section('style')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive2.css') }}" media="screen and (max-width: 992px)">

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

    <!-- Recent Bookings -->
    @php
        $professionalId = Auth::guard('professional')->id();
        $recentBookings = Booking::with('customerProfile')
                            ->where('professional_id', $professionalId)
                            ->latest()
                            ->take(5)
                            ->get();
    @endphp

    <div class="content-card">
        <div class="card-header">
            <h4>Recent Bookings</h4>
            <div class="card-action">
                <button><a href="{{ route('professional.booking.index') }}">View All</a></button>
                <button>Export</button>
            </div>
        </div>

        <!-- Table container with horizontal scrolling -->
        <div class="table-responsive-container">
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
                        <tr>
                            <td>
                                <div class="user-profile">
                                    <img src="{{ $booking->customerProfile->profile_image ?? 'https://via.placeholder.com/30' }}" 
                                         alt="User">
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
                                <div class="action-btn"><i class="fas fa-edit"></i></div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <style>
    /* Table horizontal scrolling for mobile */
    .table-responsive-container {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
    }
    
    .table {
        min-width: 600px; /* Minimum width to ensure all columns are visible when scrolling */
        width: 100%;
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
        .table-responsive-container {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 15px;
        }
        
        /* Ensure the table takes full width of container */
        .table {
            width: 100%;
            table-layout: auto;
            white-space: nowrap;
        }
        
        /* Fix the search container from overflowing */
        .search-container {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }
        
        /* Ensure content wrapper doesn't cause horizontal scroll */
        .content-wrapper {
            overflow-x: hidden;
            width: 100%;
            max-width: 100vw;
            padding: 20px 10px;
        }
        
        /* Fix card width */
        .card {
            width: 100%;
            overflow-x: hidden;
        }
        
        /* Ensure the card body doesn't cause overflow */
        .card-body {
            padding: 10px 5px;
        }
        
        /* Add scrollbar styling */
        .table-responsive-container::-webkit-scrollbar {
            height: 8px;
        }
        
        .table-responsive-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .table-responsive-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        
        .table-responsive-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

            .user-profile-wrapper{
                margin-top: -57px;
            }
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
        .table-responsive-container {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 15px;
        }
        
        /* Ensure the table takes full width of container */
        .table {
            width: 100%;
            table-layout: auto;
            white-space: nowrap;
        }
        
        /* Fix the search container from overflowing */
        .search-container {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }
        
        /* Ensure content wrapper doesn't cause horizontal scroll */
        .content-wrapper {
            overflow-x: hidden;
            width: 100%;
            max-width: 100vw;
            padding: 20px 10px;
        }
        
        /* Fix card width */
        .card {
            width: 100%;
            overflow-x: hidden;
        }
        
        /* Ensure the card body doesn't cause overflow */
        .card-body {
            padding: 10px 5px;
        }
        
        /* Add scrollbar styling */
        .table-responsive-container::-webkit-scrollbar {
            height: 8px;
        }
        
        .table-responsive-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .table-responsive-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        
        .table-responsive-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    }
</style>
@endsection