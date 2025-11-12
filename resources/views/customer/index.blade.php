<!-- /header -->
@extends('customer.layout.layout')
@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/styles.css') }}" />
<style>
    :root {
        --primary: #fbd1ad;
        --primary-dark: #f7a86c;
        --primary-light: #fff1e2;
        --accent: #ffe1b8;
        --success: #22c55e;
        --warning: #fbbf24;
        --danger: #fbcfe8;
        --surface: #ffffff;
        --muted: #a08873;
        --text-dark: #2c1b0f;
        --shadow-lg: 0 18px 38px rgba(122, 63, 20, 0.1);
        --shadow-md: 0 8px 20px rgba(122, 63, 20, 0.08);
        --border-soft: rgba(247, 168, 108, 0.2);
    }

    html,
    body,
    .content-wrapper {
        background: linear-gradient(180deg, #fff9f3 0%, #fff4e8 100%);
        overflow-x: hidden;
    }

    .customer-dashboard {
        width: 100%;
        box-sizing: border-box;
    }

    .customer-dashboard {
        max-width: 1180px;
        margin: 0 auto;
        padding: 2.8rem 1.6rem 3.4rem;
        display: flex;
        flex-direction: column;
        gap: 2.4rem;
    }

    .dashboard-hero {
        background: linear-gradient(135deg, rgba(255, 239, 224, 0.92), rgba(255, 245, 233, 0.88));
        border-radius: 32px;
        padding: 2.6rem 2.8rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.4rem 2.2rem;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .dashboard-hero::before,
    .dashboard-hero::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        opacity: 0.6;
    }

    .dashboard-hero::before {
        width: 320px;
        height: 320px;
        top: -140px;
        right: -160px;
        background: rgba(255, 225, 193, 0.46);
    }

    .dashboard-hero::after {
        width: 240px;
        height: 240px;
        bottom: -160px;
        left: -120px;
        background: rgba(255, 236, 214, 0.4);
    }

    .dashboard-hero > * {
        position: relative;
        z-index: 1;
    }

    .hero-meta {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        color: rgba(15, 23, 42, 0.95);
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.42rem 1.2rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(247, 168, 108, 0.26);
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: var(--text-dark);
    }

    .hero-meta h1 {
        margin: 0;
        font-size: 2.32rem;
        font-weight: 700;
        letter-spacing: -0.02em;
    }

    .hero-meta p {
        margin: 0;
        max-width: 520px;
        line-height: 1.6;
        color: rgba(44, 27, 15, 0.6);
    }

    .hero-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.9rem;
        flex-wrap: wrap;
    }

    .btn-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.95rem 1.9rem;
        border-radius: 999px;
        font-weight: 600;
        text-decoration: none;
        transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
    }

    .btn-pill--primary {
        background: linear-gradient(135deg, rgba(251, 209, 173, 1), rgba(247, 168, 108, 0.9));
        color: #7a4a1b;
        box-shadow: 0 16px 28px rgba(247, 168, 108, 0.24);
    }

    .btn-pill--primary:hover {
        transform: translateY(-2px);
    }

    .btn-pill--outline {
        background: rgba(255, 255, 255, 0.97);
        color: #b36b31;
        border: 1px solid rgba(251, 209, 173, 0.6);
    }

    .btn-pill--outline:hover {
        transform: translateY(-1px);
        background: rgba(255, 255, 255, 0.99);
    }

    .metrics-section {
        display: flex;
        flex-direction: column;
        gap: 1.6rem;
    }

    .section-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .section-heading h2 {
        margin: 0;
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--text-dark);
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
    }

    .section-heading h2 i {
        color: #f3a76b;
        font-size: 1.4rem;
    }

    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.6rem;
    }

    .metric-card {
        background: var(--surface);
        border-radius: 24px;
        border: 1px solid var(--border-soft);
        padding: 1.8rem;
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: transform 0.18s ease, box-shadow 0.2s ease;
        text-decoration: none;
        color: inherit;
    }

    .metric-card::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: inherit;
        background: linear-gradient(135deg, rgba(247, 168, 108, 0.12), rgba(255, 238, 221, 0.05));
        opacity: 0;
        transition: opacity 0.18s ease;
    }

    .metric-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 26px 60px rgba(15, 23, 42, 0.16);
    }

    .metric-card:hover::after {
        opacity: 1;
    }

    .metric-card__icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(251, 209, 173, 0.55);
        color: var(--primary-dark);
        font-size: 1.4rem;
    }

    .metric-card__label {
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        font-weight: 700;
        color: var(--muted);
    }

    .metric-card__value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
        letter-spacing: -0.02em;
    }

    .metric-card__trend {
        font-size: 0.95rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        color: var(--success);
    }

    .metric-card__trend.negative {
        color: #f18b9c;
    }

    .metric-card__cta {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.92rem;
        color: #d58c4e;
        font-weight: 600;
        margin-top: auto;
    }

    .metric-card__cta i {
        font-size: 1rem;
    }

    .insight-panels {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.6rem;
    }

    .insight-card {
        background: var(--surface);
        border-radius: 24px;
        border: 1px solid var(--border-soft);
        padding: 1.8rem;
        box-shadow: var(--shadow-md);
        display: flex;
        flex-direction: column;
        gap: 1.4rem;
    }

    .insight-card header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.8rem;
    }

    .insight-card header h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
    }

    .insight-card header span {
        font-size: 0.82rem;
        color: var(--muted);
        font-weight: 600;
    }

    .appointment-list,
    .event-grid {
        display: grid;
        gap: 1rem;
    }

    .appointment-item,
    .event-card {
        border-radius: 18px;
        border: 1px solid rgba(249, 208, 175, 0.5);
        padding: 1.2rem 1.4rem;
        background: linear-gradient(135deg, rgba(255, 244, 229, 0.96), rgba(255, 237, 219, 0.92));
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
    }

    .appointment-item::after,
    .event-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(135deg, rgba(247, 168, 108, 0.18), rgba(255, 236, 214, 0.28));
    }

    .appointment-item h4,
    .event-card h4 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .appointment-item p,
    .event-card p {
        margin: 0;
        font-size: 0.92rem;
        color: var(--muted);
        line-height: 1.5;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.38rem 0.75rem;
        border-radius: 999px;
        font-size: 0.76rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        background: rgba(251, 209, 173, 0.36);
        color: #b36b31;
    }

    .badge--warning {
        background: rgba(255, 224, 196, 0.46);
        color: #c46a1e;
    }

    .badge--outline {
        border: 1px solid rgba(251, 209, 173, 0.5);
        background: transparent;
    }

    .empty-state {
        border-radius: 18px;
        padding: 2.2rem 1.8rem;
        background: rgba(255, 255, 255, 0.96);
        border: 1px dashed rgba(247, 168, 108, 0.28);
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
        align-items: flex-start;
        color: var(--muted);
    }

    .empty-state i {
        font-size: 1.6rem;
        color: #d58c4e;
    }

    @media (max-width: 1024px) {
        .customer-dashboard {
            padding: 2.4rem 1.4rem 2.8rem;
        }

        .dashboard-hero {
            padding: 2.2rem 2.4rem;
        }
    }

    @media (max-width: 768px) {
        .customer-dashboard {
            padding: 2rem 1rem 2.4rem;
        }

        
        .dashboard-hero {
            grid-template-columns: 1fr;
            padding: 1.8rem 1.6rem;
        }

        .hero-actions {
            width: 100%;
            justify-content: flex-start;
            flex-direction: column;
            align-items: stretch;
            gap: 0.75rem;
        }

        .btn-pill {
            width: 100%;
            justify-content: center;
        }

        .metrics-grid,
        .insight-panels {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .dashboard-hero {
            padding: 1.6rem 1.3rem;
        }

        .hero-meta h1 {
            font-size: 1.8rem;
        }

        .hero-meta p {
            font-size: 0.94rem;
        }

        .metric-card {
            padding: 1.6rem 1.4rem;
        }

        .insight-card {
            padding: 1.6rem 1.4rem;
        }
    }

    @media (max-width: 540px) {
        .customer-dashboard {
            padding: 1.8rem 0.85rem 2.1rem;
            margin: -8px;
        }

        .dashboard-hero {
            padding: 1.5rem 1.15rem;
        }

        .hero-meta h1 {
            font-size: 1.68rem;
        }

        .hero-meta p {
            font-size: 0.92rem;
        }

        .metric-card {
            padding: 1.6rem;
        }

        .metric-card__value {
            font-size: 1.8rem;
        }

        .appointment-item,
        .event-card {
            padding: 1.1rem 1.2rem;
        }
    }
</style>
@endsection
@section('content')

@php
    // Get current user ID
    $userId = Auth::guard('user')->id();
    $today = \Carbon\Carbon::today();
    $threeDaysLater = \Carbon\Carbon::today()->addDays(3);
    $user = Auth::guard('user')->user();
    
    // Get upcoming appointments (future dates)
    $upcomingAppointments = \App\Models\Booking::where('user_id', $userId)
        ->whereHas('timedates', function($query) use ($today) {
            $query->where('date', '>=', $today->format('Y-m-d'))
                  ->whereIn('status', ['pending', 'confirmed']);
        })
        ->with([
            'professional',
            'timedates' => function($query) use ($today) {
            $query->where('date', '>=', $today->format('Y-m-d'))
                  ->whereIn('status', ['pending', 'confirmed'])
                  ->orderBy('date', 'asc');
            }
        ])
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

<div class="customer-dashboard">
    <section class="dashboard-hero">
        <div class="hero-meta">
            <span class="hero-eyebrow"><i class="fas fa-home"></i> Customer Hub</span>
            <h1>Welcome back, {{ optional($user)->name ?? 'Guest' }}!</h1>
            <p>Track your upcoming appointments, explore curated events and stay on top of your payments all from one place.</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('user.upcoming-appointment.index') }}" class="btn-pill btn-pill--outline">
                <i class="fas fa-calendar-plus"></i>
                Manage Appointments
            </a>
            <a href="{{ route('user.customer-event.index') }}" class="btn-pill btn-pill--primary">
                <i class="fas fa-search"></i>
                Discover Events
            </a>
        </div>
    </section>

    <section class="metrics-section">
        <div class="section-heading">
            <h2><i class="fas fa-chart-line"></i>Snapshot Overview</h2>
            <span class="badge badge--outline"><i class="fas fa-sync"></i> Updated {{ now()->diffForHumans() }}</span>
        </div>
        <div class="metrics-grid">
            <a href="{{ route('user.upcoming-appointment.index') }}" class="metric-card">
                <span class="metric-card__icon"><i class="fas fa-calendar-check"></i></span>
                <span class="metric-card__label">Upcoming Appointments</span>
                <span class="metric-card__value">{{ $upcomingCount }}</span>
                <span class="metric-card__trend">
                    <i class="fas fa-clock"></i>{{ $todayCount }} today
                </span>
                <span class="metric-card__cta">
                    View appointments <i class="fas fa-arrow-right"></i>
                </span>
            </a>

            <a href="{{ route('user.all-appointment.index') }}" class="metric-card">
                <span class="metric-card__icon"><i class="fas fa-calendar-alt"></i></span>
                <span class="metric-card__label">Total Appointments</span>
                <span class="metric-card__value">{{ $totalAppointments }}</span>
                <span class="metric-card__trend">
                    <i class="fas fa-check-circle"></i>{{ $completedAppointments }} completed
                </span>
                <span class="metric-card__cta">
                    Review history <i class="fas fa-arrow-right"></i>
                </span>
            </a>

            <a href="{{ route('user.customer-event.index') }}" class="metric-card">
                <span class="metric-card__icon"><i class="fas fa-calendar-day"></i></span>
                <span class="metric-card__label">Upcoming Events</span>
                <span class="metric-card__value">{{ $totalEventCount }}</span>
                <span class="metric-card__trend">
                    <i class="fas fa-bolt"></i>{{ $upcomingBookedEvents }} in 3 days
                </span>
                <span class="metric-card__cta">
                    Explore events <i class="fas fa-arrow-right"></i>
                </span>
            </a>

            <a href="{{ route('user.billing.index') }}" class="metric-card">
                <span class="metric-card__icon"><i class="fas fa-wallet"></i></span>
                <span class="metric-card__label">Total Payments</span>
                <span class="metric-card__value">₹{{ number_format($totalPayments, 0) }}</span>
                <span class="metric-card__trend negative">
                    <i class="fas fa-hourglass-half"></i>₹{{ number_format($pendingPayments, 0) }} pending
                </span>
                <span class="metric-card__cta">
                    View payment history <i class="fas fa-arrow-right"></i>
                </span>
            </a>
        </div>
    </section>

    <section class="insight-panels">
        <div class="insight-card">
            <header>
                <h3><i class="fas fa-clipboard-list"></i>Upcoming Appointments</h3>
                <span>{{ $upcomingAppointments->count() }} scheduled</span>
            </header>

            <div class="appointment-list">
                @php
                    $upcomingPreview = $upcomingAppointments->take(3);
                @endphp
                @forelse($upcomingPreview as $appointment)
                    @php
                        $nextSlot = $appointment->timedates->first();
                        $professionalName = optional($appointment->professional)->name ?? ($appointment->professional_name ?? 'Professional');
                    @endphp
                    <div class="appointment-item">
                        <h4><i class="fas fa-user-md"></i>{{ $professionalName }}</h4>
                        @if($nextSlot)
                            <p><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($nextSlot->date)->format('M d, Y') }} &bull; {{ \Carbon\Carbon::parse($nextSlot->start_time)->format('h:i A') }}</p>
                            <span class="badge"><i class="fas fa-info-circle"></i>{{ ucfirst($nextSlot->status) }}</span>
                        @else
                            <p>No time slot available</p>
                        @endif
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <strong>No appointments scheduled.</strong>
                        <span>Book a session with your preferred professional to see it appear here.</span>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="insight-card">
            <header>
                <h3><i class="fas fa-star"></i>Featured Events</h3>
                <span>{{ $events->count() }} highlighted</span>
            </header>

            <div class="event-grid">
                @forelse($events as $event)
                    <div class="event-card">
                        <h4><i class="fas fa-microphone-alt"></i>{{ $event->heading }}</h4>
                        <p>{{ \Illuminate\Support\Str::limit($event->short_description, 110) }}</p>
                        <div class="badge badge--warning">
                            <i class="far fa-calendar"></i>{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                        </div>
                        <div class="metric-card__cta" style="margin-top: 0.8rem;">
                            Starting at ₹{{ number_format($event->starting_fees ?? 0, 0) }}
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-rocket"></i>
                        <strong>No events to display right now.</strong>
                        <span>Check back soon or explore more events from the marketplace.</span>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
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

<!-- Include Onboarding Tutorial -->
@include('components.onboarding-tutorial')
@include('components.customer-onboarding')
@endsection