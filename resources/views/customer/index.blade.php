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
                <h2>7</h2>
                <p class="positive">
                    <i class="fas fa-arrow-up"></i> 
                    2 Today
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
                <h2>24</h2>
                <p class="positive">
                    <i class="fas fa-check-circle"></i> 
                    18 Completed
                </p>
                <div class="view-btn">
                    <i class="fas fa-eye"></i> View All
                </div>
            </div>
        </a>

        <!-- Upcoming Events Card -->
        <a href="" class="card card-warning">
            <div class="card-icon">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="card-info">
                <h4>Events</h4>
                <h2>12</h2>
                <p class="positive">
                    <i class="fas fa-calendar"></i> 
                    3 Booked
                </p>
                <div class="view-btn">
                    <i class="fas fa-eye"></i> Explore Events
                </div>
            </div>
        </a>

        <!-- Total Payments Card -->
        <a href="" class="card card-danger">
            <div class="card-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-info">
                <h4>Total Payments</h4>
                <h2>₹16,500</h2>
                <p class="negative">
                    <i class="fas fa-arrow-down"></i> 
                    ₹2,500 Pending
                </p>
                <div class="view-btn">
                    <i class="fas fa-eye"></i> View Payments
                </div>
            </div>
        </a>
    </div>

    <!-- Recent Events Section -->
    <div class="recent-events">
        <h3 class="section-title">Upcoming Events</h3>
        
        <div class="event-cards">
            <!-- Static Event Card 1 -->
            <div class="event-card">
                <div class="event-img">
                    <img src="{{ asset('images/events/event1.jpg') }}" alt="Yoga Workshop">
                    <div class="event-date">
                        <i class="far fa-calendar-alt"></i> 28 Jun, 2025
                    </div>
                </div>
                <div class="event-body">
                    <h4 class="event-title">Yoga Workshop for Beginners</h4>
                    <p class="event-desc">Join us for a beginner-friendly yoga workshop designed to introduce you to fundamental poses and breathing techniques.</p>
                </div>
                <div class="event-footer">
                    <div class="event-price">₹1,200</div>
                    <a href="" class="book-btn">View Details</a>
                </div>
            </div>

            <!-- Static Event Card 2 -->
            <div class="event-card">
                <div class="event-img">
                    <img src="{{ asset('images/events/event2.jpg') }}" alt="Mindfulness Retreat">
                    <div class="event-date">
                        <i class="far fa-calendar-alt"></i> 15 Jul, 2025
                    </div>
                </div>
                <div class="event-body">
                    <h4 class="event-title">Mindfulness Weekend Retreat</h4>
                    <p class="event-desc">Escape the city for a weekend of mindfulness meditation, relaxation, and rejuvenation in a peaceful setting.</p>
                </div>
                <div class="event-footer">
                    <div class="event-price">₹4,500</div>
                    <a href="" class="book-btn">View Details</a>
                </div>
            </div>

            <!-- Static Event Card 3 -->
            <div class="event-card">
                <div class="event-img">
                    <img src="{{ asset('images/events/event3.jpg') }}" alt="Wellness Conference">
                    <div class="event-date">
                        <i class="far fa-calendar-alt"></i> 05 Aug, 2025
                    </div>
                </div>
                <div class="event-body">
                    <h4 class="event-title">Annual Wellness Conference</h4>
                    <p class="event-desc">Join industry experts for talks, workshops, and networking opportunities focused on holistic health and wellness.</p>
                </div>
                <div class="event-footer">
                    <div class="event-price">₹3,000</div>
                    <a href="" class="book-btn">View Details</a>
                </div>
            </div>
        </div>
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