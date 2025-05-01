 <!-- Sidebar -->
 <div class="sidebar">
    <div class="sidebar-header">
        <img src="../images/tazen_logo-01-removebg-preview.png" alt="Logo" class="sidebar-logo">
    </div> 

    <div class="sidebar-menu">
        <div class="menu-title">Main</div>
        <a href="index.html" class="menu-item active">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>

        <div class="menu-title">Manage</div>
        <a href="{{ route('professional.profile.index') }}" class="menu-item">
            <i class="fas fa-user-cog"></i>
            <span>Add Profile</span>
        </a>
        <a href="{{ route('professional.service.index') }}" class="menu-item">
            <i class="fas fa-plus-circle"></i>
            <span>Add Service</span>
        </a>
        <a href="{{ route('professional.rate.index') }}" class="menu-item">
            <i class="fas fa-dollar-sign"></i>
            <span>Add Rate</span>
        </a>

        <a href="{{ route('professional.availability.index') }}" class="menu-item">
            <i class="fas fa-clock"></i>
            <span>Add Availability</span>
        </a>

        <div class="menu-title">Bookings</div>
        <a href="{{ route('professional.booking.index') }}" class="menu-item">
            <i class="fas fa-list"></i>
            <span>All Bookings</span>
        </a>

        <div class="menu-title">Billing</div>
        <a href="{{ route('professional.billing.index') }}" class="menu-item">
            <i class="fas fa-wallet"></i>
            <span>All Billing</span>
        </a>
    </div>
</div>