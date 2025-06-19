@extends('professional.layout.layout')
@section('styles')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive2.css') }}" media="screen and (max-width: 992px)">
<style>
    /* Enhanced Dashboard Cards */
    .card-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 30px;
    }

    .card {
        position: relative;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 24px;
        display: flex;
        transition: all 0.3s ease;
        cursor: pointer;
        overflow: hidden;
        border: none;
        height: 100%;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
    }
    
    .card:active {
        transform: translateY(0);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    
    .card:after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        height: 100%;
        width: 6px;
        background: rgba(255, 255, 255, 0.3);
    }
    
    .card-primary {
        background: linear-gradient(135deg, #2980b9, #3498db);
        color: white;
    }
    
    .card-success {
        background: linear-gradient(135deg, #27ae60, #2ecc71);
        color: white;
    }
    
    .card-warning {
        background: linear-gradient(135deg, #f39c12, #f1c40f);
        color: white;
    }
    
    .card-danger {
        background: linear-gradient(135deg, #c0392b, #e74c3c);
        color: white;
    }
    
    .card-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        margin-right: 18px;
        flex-shrink: 0;
    }
    
    .card-icon i {
        font-size: 32px;
        color: white;
    }
    
    .card-info {
        flex: 1;
    }
    
    .card-info h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 500;
        opacity: 0.9;
        margin-bottom: 8px;
        color: white;
    }
    
    .card-info h2 {
        margin: 0;
        font-size: 34px;
        font-weight: 600;
        margin-bottom: 12px;
        color: white !important;
    }
    
    .card p {
        margin: 0;
        font-size: 15px;
        opacity: 0.9;
    }
    
    .positive {
        color: rgba(255, 255, 255, 0.9);
    }
    
    .negative {
        color: rgba(255, 255, 255, 0.9);
    }
    
    .fa-arrow-up, .fa-calendar, .fa-check-circle {
        margin-right: 5px;
    }
    
    .fa-arrow-down {
        margin-right: 5px;
    }
    
    /* View Button */
    .view-btn {
        display: inline-flex;
        align-items: center;
        padding: 6px 16px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        font-size: 14px;
        transition: all 0.2s;
        text-decoration: none;
        margin-top: 12px;
    }
    
    .view-btn i {
        margin-right: 6px;
        font-size: 14px;
    }
    
    .card:hover .view-btn {
        background: rgba(255, 255, 255, 0.3);
    }
    
    /* Enhanced for mobile */
    @media (max-width: 768px) {
        .card-grid {
            grid-template-columns: 1fr;
        }
        
        .card {
            margin-bottom: 15px;
        }
    }
    
    /* Pulse animation for attention on hover */
    .card:hover .card-icon {
        animation: pulse 1.5s infinite;
    }
    
    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
        }
    }
    
    /* Table styling */
    .content-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        overflow: hidden;
    }
    
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        border-bottom: 1px solid #e9ecef;
    }
    
    .card-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: #333;
    }
    
    .card-action {
        display: flex;
        gap: 10px;
    }
    
    .card-action button {
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        background: #f1f1f1;
        color: #333;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .card-action button:hover {
        background: #e1e1e1;
    }
    
    .card-action button a {
        color: #333;
        text-decoration: none;
    }
    
    /* Table styling */
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table th {
        padding: 15px 24px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
        color: #555;
        border-bottom: 1px solid #e9ecef;
        background-color: #f8f9fa;
    }
    
    .table td {
        padding: 15px 24px;
        font-size: 14px;
        color: #333;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }
    
    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }
    
    .success {
        background-color: #d4edda;
        color: #155724;
    }
    
    .warning {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .info {
        background-color: #d1ecf1;
        color: #0c5460;
    }
    
    .secondary {
        background-color: #e9ecef;
        color: #383d41;
    }
    
    .user-profile {
        display: flex;
        align-items: center;
    }
    
    .user-profile img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 10px;
        object-fit: cover;
    }
    
    .user-info h5 {
        margin: 0;
        font-size: 14px;
        font-weight: 500;
    }
    
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        background: #f1f1f1;
        color: #333;
        margin-right: 5px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }
    
    .action-btn:hover {
        background: #e1e1e1;
    }
    
    /* Table horizontal scrolling for mobile */
    .table-responsive-container {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
    }
    
    .dashboard-card-link {
        text-decoration: none;
        color: inherit;
        display: block;
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

        <!-- Total Bookings Card - Make it clickable -->
        <a href="{{ route('professional.booking.index') }}" class="dashboard-card-link">
            <div class="card card-primary">
                <div class="card-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="card-info">
                    <h4>Total Bookings</h4>
                    <h2 style="color: black">{{ $totalBookings }}</h2>
                </div>
            </div>
        </a>

<a href="{{ route('professional.billing.index') }}" class="dashboard-card-link">
        <div class="card card-success">
            <div class="card-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-info">
                @php
                    $professionalId = Auth::guard('professional')->id();
                    
                    // Get the total amount earned from bookings with paid_status = 'paid'
                    $totalRevenue = \App\Models\Booking::where('professional_id', $professionalId)
                        ->where('paid_status', 'paid')
                        ->sum('amount');
                        
                    // Get the professional's margin rate from the professionals table
                    $professional = \App\Models\Professional::find($professionalId);
                    $marginRate = $professional->margin ?? 20; // Default to 20% if not set
                    
                    // Calculate actual professional earnings after deducting platform commission
                    $actualEarnings = $totalRevenue * ((100 - $marginRate) / 100);
                    
                    // Calculate previous month's earnings for comparison
                    $previousMonth = now()->subMonth();
                    $prevMonthStart = $previousMonth->startOfMonth()->format('Y-m-d');
                    $prevMonthEnd = $previousMonth->endOfMonth()->format('Y-m-d');
                    
                    $previousEarnings = \App\Models\Booking::where('professional_id', $professionalId)
                        ->where('paid_status', 'paid')
                        ->whereBetween('paid_date', [$prevMonthStart, $prevMonthEnd])
                        ->sum('amount') * ((100 - $marginRate) / 100);
                        
                    // Calculate percentage change
                    $percentChange = 0;
                    if ($previousEarnings > 0) {
                        $percentChange = (($actualEarnings - $previousEarnings) / $previousEarnings) * 100;
                    }
                    $isPositive = $percentChange >= 0;
                @endphp
                <h4>Total Revenue</h4>
                <h2  style="color: black">₹{{ number_format($actualEarnings, 2) }}</h2>
                @if($previousEarnings > 0)
                    <p class="{{ $isPositive ? 'positive' : 'negative' }}">
                        <i class="fas fa-arrow-{{ $isPositive ? 'up' : 'down' }}"></i> 
                        {{ abs(round($percentChange)) }}% from last month
                    </p>
                @else
                    <p>No earnings last month</p>
                @endif
            </div>
        </div>
        </a>

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
            </div>
        </div>

        <!-- Upcoming Appointments Card - Dynamic Version -->
        @php
            $professionalId = Auth::guard('professional')->id();
            
            // Get the current date
            $today = \Carbon\Carbon::today();
            $threeDaysLater = \Carbon\Carbon::today()->addDays(3);
            
            // Get bookings with timedate entries in the next 3 days
            $upcomingBookings = \App\Models\Booking::where('professional_id', $professionalId)
                ->whereHas('timedates', function($query) use ($today, $threeDaysLater) {
                    $query->whereIn('status', ['pending', 'confirmed'])
                          ->where('date', '>=', $today->format('Y-m-d'))
                          ->where('date', '<=', $threeDaysLater->format('Y-m-d'));
                })
                ->with(['timedates' => function($query) use ($today, $threeDaysLater) {
                    $query->whereIn('status', ['pending', 'confirmed'])
                          ->where('date', '>=', $today->format('Y-m-d'))
                          ->where('date', '<=', $threeDaysLater->format('Y-m-d'))
                          ->orderBy('date', 'asc');
                }])
                ->get();
            
            // Count total upcoming bookings
            $upcomingCount = 0;
            foreach($upcomingBookings as $booking) {
                $upcomingCount += $booking->timedates->count();
            }
            
            // Count today's bookings
            $todayBookings = \App\Models\Booking::where('professional_id', $professionalId)
                ->whereHas('timedates', function($query) use ($today) {
                    $query->whereIn('status', ['pending', 'confirmed'])
                          ->where('date', $today->format('Y-m-d'));
                })
                ->with(['timedates' => function($query) use ($today) {
                    $query->whereIn('status', ['pending', 'confirmed'])
                          ->where('date', $today->format('Y-m-d'));
                }])
                ->get();
            
            $todayCount = 0;
            foreach($todayBookings as $booking) {
                $todayCount += $booking->timedates->count();
            }
        @endphp

        <a href="{{ route('professional.booking.index') }}" class="dashboard-card-link">
            <div class="card card-danger">
                <div class="card-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="card-info">
                    <h4>Upcoming Appointments</h4>
                    <h2>{{ $upcomingCount }}</h2>
                    @if($todayCount > 0)
                        <p class="positive">
                            <i class="fas fa-arrow-up"></i> 
                            {{ $todayCount }} new {{ $todayCount == 1 ? 'appointment' : 'appointments' }} today
                        </p>
                    @else
                        <p>No appointments today</p>
                    @endif
                </div>
            </div>
        </a>
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