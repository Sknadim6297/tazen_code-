<!-- /header -->
@extends('customer.layout.layout')
@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/styles.css') }}" />
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
    }
    
    .card-info h2 {
        margin: 0;
        font-size: 34px;
        font-weight: 600;
        margin-bottom: 12px;
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
        .content-wrapper {
            padding:10px 0px;
            padding-left:3px;
            width: 100vw !important;
            max-width: 100vw !important;
            overflow-x: hidden !important;
            box-sizing: border-box;
        }
        .card-grid {
            grid-template-columns: 1fr;
            gap: 12px;
            width: 100vw;
            max-width: 100vw;
            margin-bottom: 12px;
        }
        .card {
            padding: 12px;
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
    
    /* Recent events section */
    .recent-events {
        margin-top: 40px;
    }
    
    .section-title {
        font-size: 20px;
        margin-bottom: 20px;
        font-weight: 600;
        color: #333;
        border-left: 4px solid #3498db;
        padding-left: 12px;
    }
    
    .event-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    
    .event-card {
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .event-img {
        height: 160px;
        overflow: hidden;
        position: relative;
    }
    
    .event-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .event-card:hover .event-img img {
        transform: scale(1.1);
    }
    
    .event-date {
        position: absolute;
        bottom: 0;
        left: 0;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 5px 10px;
        font-size: 14px;
    }
    
    .event-body {
        padding: 15px;
    }
    
    .event-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
    }
    
    .event-desc {
        font-size: 14px;
        color: #666;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .event-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
        background-color: #f9f9f9;
        border-top: 1px solid #eee;
    }
    
    .event-price {
        font-weight: 600;
        color: #2980b9;
    }
    
    .book-btn {
        padding: 5px 15px;
        background: #2980b9;
        color: white;
        border-radius: 20px;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .book-btn:hover {
        background: #3498db;
        transform: scale(1.05);
    }
</style>
@endsection
@section('content')

@php
    // Get current user ID
    $userId = Auth::guard('user')->id();
    $today = \Carbon\Carbon::today();
    $threeDaysLater = \Carbon\Carbon::today()->addDays(3);
    
    // Get upcoming appointments (future dates)
    $upcomingAppointments = \App\Models\Booking::where('user_id', $userId)
        ->whereHas('timedates', function($query) use ($today) {
            $query->where('date', '>=', $today->format('Y-m-d'))
                  ->whereIn('status', ['pending', 'confirmed']);
        })
        ->with(['timedates' => function($query) use ($today) {
            $query->where('date', '>=', $today->format('Y-m-d'))
                  ->whereIn('status', ['pending', 'confirmed'])
                  ->orderBy('date', 'asc');
        }])
        ->get();
        
    // Count total upcoming appointments
    $upcomingCount = 0;
    foreach($upcomingAppointments as $appointment) {
        $upcomingCount += $appointment->timedates->count();
    }
    
    // Count today's appointments
    $todayAppointments = \App\Models\Booking::where('user_id', $userId)
        ->whereHas('timedates', function($query) use ($today) {
            $query->where('date', $today->format('Y-m-d'))
                  ->whereIn('status', ['pending', 'confirmed']);
        })
        ->with(['timedates' => function($query) use ($today) {
            $query->where('date', $today->format('Y-m-d'))
                  ->whereIn('status', ['pending', 'confirmed']);
        }])
        ->get();
    
    $todayCount = 0;
    foreach($todayAppointments as $appointment) {
        $todayCount += $appointment->timedates->count();
    }
    
    // Get all appointments (including completed)
    $allAppointments = \App\Models\Booking::where('user_id', $userId)
        ->with('timedates')
        ->get();
    
    $totalAppointments = 0;
    $completedAppointments = 0;
    
    foreach($allAppointments as $appointment) {
        if($appointment->timedates && $appointment->timedates->count() > 0) {
            $totalAppointments += $appointment->timedates->count();
            $completedAppointments += $appointment->timedates->where('status', 'completed')->count();
        }
    }
    
    // Get user's upcoming event bookings in next 3 days
    $upcomingEventBookings = \App\Models\EventBooking::where('user_id', $userId)
        ->whereHas('event', function($query) use ($today, $threeDaysLater) {
            $query->whereBetween('date', [
                $today->format('Y-m-d'), 
                $threeDaysLater->format('Y-m-d')
            ]);
        })
        ->with(['event' => function($query) {
            $query->select('id', 'heading', 'short_description', 'card_image', 'date', 'starting_fees');
        }])
        ->get();
    
    // Get upcoming events for the event card section
    try {
        $events = \App\Models\AllEvent::where('date', '>=', $today->format('Y-m-d'))
            ->orderBy('date', 'asc')
            ->take(3)
            ->get();
            
        // Get total active events
        $totalEventCount = \App\Models\AllEvent::where('date', '>=', $today->format('Y-m-d'))->count();
    } catch (\Exception $e) {
        // If there's any issue, set to empty collection
        $events = collect();
        $totalEventCount = 0;
    }
    
    // Get user's booked events (total count)
    $bookedEvents = \App\Models\EventBooking::where('user_id', $userId)
        ->count();
    
    // Get upcoming booked events count (in next 3 days)
    $upcomingBookedEvents = $upcomingEventBookings->count();
    
    // Calculate total payments: Bookings + Event Bookings
    $bookingPayments = \App\Models\Booking::where('user_id', $userId)
        ->where('payment_status', 'paid')
        ->sum('amount');
        
    $eventPayments = \App\Models\EventBooking::where('user_id', $userId)
        ->where('payment_status', 'paid')
        ->sum('total_price');
        
    $totalPayments = $bookingPayments + $eventPayments;
    
    // Get pending payments: Bookings + Event Bookings
    $bookingPendingPayments = \App\Models\Booking::where('user_id', $userId)
        ->where('payment_status', 'pending')
        ->sum('amount');
        
    $eventPendingPayments = \App\Models\EventBooking::where('user_id', $userId)
        ->where('payment_status', 'pending')
        ->sum('total_price');
        
    $pendingPayments = $bookingPendingPayments + $eventPendingPayments;

    // Get most recent events (for the Recent Events section)
    $recentEvents = \App\Models\AllEvent::orderBy('created_at', 'desc') // Order by created_at to get most recent
        ->take(3) // Get just the 3 most recent
        ->get();
@endphp

<div class="content-wrapper">
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
        <!-- Upcoming Appointments Card -->
        <a href="{{ route('user.upcoming-appointment.index') }}" class="card card-primary">
            <div class="card-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="card-info">
                <h4>Upcoming Appointments</h4>
                <h2>{{ $upcomingCount }}</h2>
                <p class="positive">
                    <i class="fas fa-arrow-up"></i> 
                    {{ $todayCount }} {{ $todayCount == 1 ? 'Today' : 'Today' }}
                </p>
                <div class="view-btn">
                    <i class="fas fa-eye"></i> View Appointments
                </div>
            </div>
        </a>

        <!-- Total Appointments Card -->
        <a href="{{ route('user.all-appointment.index') }}" class="card card-success">
            <div class="card-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="card-info">
                <h4>Total Appointments</h4>
                <h2>{{ $totalAppointments }}</h2>
                <p class="positive">
                    <i class="fas fa-check-circle"></i> 
                    {{ $completedAppointments }} Completed
                </p>
                <div class="view-btn">
                    <i class="fas fa-eye"></i> View All
                </div>
            </div>
        </a>

        <!-- Upcoming Events Card -->
        <a href="{{ route('user.customer-event.index') }}" class="card card-warning">
            <div class="card-icon">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="card-info">
                <h4>Upcoming Events</h4>
                <h2>{{ $totalEventCount }}</h2>
                <p class="positive">
                    <i class="fas fa-calendar"></i> 
                    {{ $upcomingBookedEvents }} in next 3 days
                </p>
                <div class="view-btn">
                    <i class="fas fa-eye"></i> View Events
                </div>
            </div>
        </a>

        <!-- Total Payments Card -->
        <a href="{{ route('user.billing.index') }}" class="card card-danger">
            <div class="card-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-info">
                <h4>Total Payments</h4>
                <h2>₹{{ number_format($totalPayments, 0) }}</h2>
                <p class="negative">
                    <i class="fas fa-arrow-down"></i> 
                    ₹{{ number_format($pendingPayments, 0) }} Pending
                </p>
                <div class="view-btn">
                    <i class="fas fa-eye"></i> View Payments
                </div>
            </div>
        </a>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate counters when in view
    const counters = document.querySelectorAll('.card-info h2');
    const options = {
        threshold: 0.5
    };

    let observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const originalValue = target.innerText;
                const isCurrency = originalValue.includes('₹');
                let value;
                
                if (isCurrency) {
                    // Remove currency symbol and commas
                    value = parseInt(originalValue.replace(/[₹,]/g, ''));
                } else {
                    value = parseInt(originalValue);
                }
                
                let current = 0;
                const duration = 1000; // 1 second
                const increment = value / (duration / 16); // 60fps
                
                function updateCount() {
                    if (current < value) {
                        current += increment;
                        if (current > value) current = value;
                        
                        // Format appropriately
                        if (isCurrency) {
                            target.innerText = '₹' + Math.floor(current).toLocaleString('en-IN');
                        } else {
                            target.innerText = Math.floor(current);
                        }
                        
                        if (current < value) {
                            requestAnimationFrame(updateCount);
                        }
                    }
                }
                
                updateCount();
                observer.unobserve(target);
            }
        });
    }, options);

    counters.forEach(counter => {
        observer.observe(counter);
    });
});
</script>
@endsection