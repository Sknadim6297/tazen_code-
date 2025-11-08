<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('home') }}">
            <img src="{{ asset('customer-css/assets/images/tazen_logo.png') }}" alt="Logo" class="sidebar-logo" style="align-items: center; justify-content: center; display: flex;" height="80">
        </a>
        <i class="fas fa-times close-sidebar"></i>
    </div> 
    <div class="sidebar-menu">
        <div class="menu-title">Main</div>
        <a href="{{ route('professional.dashboard') }}" class="menu-item {{ Route::is('professional.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('home') }}" class="menu-item {{ Route::is('home') ? 'active' : '' }}">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Home</span>
        </a>

        <div class="menu-title">Manage</div>
        <a href="{{ route('professional.profile.index') }}" class="menu-item {{ Route::is('professional.profile.*') ? 'active' : '' }}">
            <i class="fas fa-user-cog"></i>
            <span>Add Profile</span>
        </a>
        <a href="{{ route('professional.service.index') }}" class="menu-item {{ Route::is('professional.service.*') ? 'active' : '' }}">
            <i class="fas fa-plus-circle"></i>
            <span>Add Service</span>
        </a>
        <a href="{{ route('professional.rate.index') }}" class="menu-item {{ Route::is('professional.rate.*') ? 'active' : '' }}">
            <i class="fas fa-dollar-sign"></i>
            <span>Add Rate</span>
        </a>

        <a href="{{ route('professional.availability.index') }}" class="menu-item {{ Route::is('professional.availability.*') ? 'active' : '' }}">
            <i class="fas fa-clock"></i>
            <span>Add Availability</span>
        </a>
        <a href="{{ route('professional.requested_services.index') }}" class="menu-item {{ Route::is('professional.requested_services.*') ? 'active' : '' }}">
            <i class="fas fa-dollar-sign"></i>
            <span>Other Information</span>
        </a>

        <div class="menu-title">Bookings</div>
        <a href="{{ route('professional.booking.index') }}" class="menu-item {{ Route::is('professional.booking.*') ? 'active' : '' }}">
            <i class="fas fa-list"></i>
            <span>All Bookings</span>
        </a>
        <a href="{{ route('professional.additional-services.index') }}" class="menu-item {{ Route::is('professional.additional-services.*') ? 'active' : '' }}">
            <i class="fas fa-plus-square"></i>
            <span>Additional Services</span>
        </a>
 <div class="menu-title">Events</div>
        <a href="{{ route('professional.events.index') }}" class="menu-item {{ Route::is('professional.events.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i>
            <span>My Events</span>
        </a>
        <div class="menu-title">Billing</div>
        <a href="{{ route('professional.billing.index') }}" class="menu-item {{ Route::is('professional.billing.*') ? 'active' : '' }}">
            <i class="fas fa-wallet"></i>
            <span>All Billing</span>
        </a>

        <div class="menu-title">Reviews</div>
        <a href="{{ route('professional.reviews.index') }}" class="menu-item {{ Route::is('professional.reviews.*') ? 'active' : '' }}">
            <i class="fas fa-star"></i>
            <span>My Reviews</span>
        </a>
    </div>
</div>

<style>
    .sidebar {
        max-height: 100vh;
        overflow-y: auto;
        /* Optional: for smooth scrolling */
        scroll-behavior: smooth;
        z-index: 1000; /* Ensure sidebar is above header in mobile */
    }
    
    /* Mobile responsive adjustments */
    @media (max-width: 768px) {
        .sidebar {
            z-index: 1000; /* Higher than header's z-index: 998 */
        }
        
        .sidebar.active {
            z-index: 1000; /* Maintain high z-index when active */
        }
    }
    
    .menu-item.active {
        background: linear-gradient(45deg, #FF4500, #FFA500);
        color: white;
        border-radius: 5px;
        margin: 2px 0;
    }
    
    .menu-item.active i {
        color: white;
    }
    
    .menu-item:hover {
        background: rgba(255, 69, 0, 0.1);
        border-radius: 5px;
        margin: 2px 0;
    }
    
    /* Add styling for the logo link */
    .sidebar-header a {
        display: block;
        text-decoration: none;
        transition: transform 0.2s ease;
    }
    
    .sidebar-header a:hover {
        transform: scale(1.03);
    }
    
    .sidebar-header a:active {
        transform: scale(0.98);
    }
</style>