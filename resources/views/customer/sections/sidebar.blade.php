<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('customer-css/assets/images/tazen_logo.png') }}" alt="Logo" class="sidebar-logo" height="100">
        <i class="fas fa-times close-sidebar"></i>
    </div> 

    <div class="sidebar-menu">
        <div class="menu-title">Main</div>
        <a href="{{ route('user.dashboard') }}" class="menu-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('home') }}" class="menu-item">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Home</span>
        </a>

        <div class="menu-title">Manage</div>
        <a href="{{ route('user.profile.index') }}" class="menu-item {{ request()->routeIs('user.profile.*') ? 'active' : '' }}">
            <i class="fas fa-user-cog"></i>
            <span>Add Profile</span>
        </a>
        <a href="{{ route('user.all-appointment.index') }}" class="menu-item {{ request()->routeIs('user.all-appointment.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i>
            <span>All Appointment</span>
        </a>
        <a href="{{ route('user.upcoming-appointment.index') }}" class="menu-item {{ request()->routeIs('user.upcoming-appointment.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i>
            <span>Upcoming Appointment</span>
        </a>

        <a href="{{ route('user.customer-event.index') }}" class="menu-item {{ request()->routeIs('user.customer-event.*') ? 'active' : '' }}">
            <i class="fas fa-clock"></i>
            <span>Events</span>
        </a>

        <div class="menu-title">Billing</div>
        <a href="{{ route('user.billing.index') }}" class="menu-item {{ request()->routeIs('user.billing.*') ? 'active' : '' }}">
            <i class="fas fa-file-invoice-dollar"></i>
            <span>All Billing</span>
        </a>
    </div>
</div>