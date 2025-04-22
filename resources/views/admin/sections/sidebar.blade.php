<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('frontend/assets/img/tazen_logo-01-removebg-preview.png') }}" alt="Logo" class="sidebar-logo" height="100">
        <i class="fas fa-times close-sidebar"></i>
    </div>            

    <div class="sidebar-menu">
        <div class="menu-title">Main</div>
        <a href="index.html" class="menu-item active">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>

        <div class="menu-title">Manage</div>
        <div class="dropdown-container">
            <div class="menu-item dropdown-header">
                <div class="dropdown-title">
                    <i class="fas fa-globe"></i>
                    <span>Manage Website</span>
                </div>
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </div>
            <div class="dropdown-content">
                <a href="{{ route('about.index') }}" class="submenu-item">
                    <i class="fas fa-info-circle"></i>
                    <span>About</span>
                </a>
                <a href="{{ route('testimonial.index') }}" class="submenu-item">
                    <i class="fas fa-quote-left"></i>
                    <span>Testimonial</span>
                </a>
                <a href="{{ route('whychooseus.index') }}" class="submenu-item">
                    <i class="fas fa-quote-left"></i>
                    <span>Why Choose Us</span>
                </a>
            </div>
        </div>

        <a href="professional.html" class="menu-item">
            <i class="fas fa-user-tie"></i>
            <span>Professional</span>
        </a>
        <a href="customer.html" class="menu-item">
            <i class="fas fa-users"></i>
            <span>Customer</span>
        </a>
        
        <!-- Rest of your menu items -->
        <div class="menu-title">Booking</div>
        <a href="one-time.html" class="menu-item">
            <i class="fas fa-calendar-day"></i>
            <span>One Time</span>
        </a>
        <a href="monthly.html" class="menu-item">
            <i class="fas fa-calendar-week"></i>
            <span>Monthly</span>
        </a>
        <a href="quaterly.html" class="menu-item">
            <i class="fas fa-calendar-alt"></i>
            <span>Quarterly</span>
        </a>
        <a href="free-hand.html" class="menu-item">
            <i class="fas fa-calendar-check"></i>
            <span>Free Hand</span>
        </a>

        <div class="menu-title">Billing</div>
        <a href="customer-bill.html" class="menu-item">
            <i class="fas fa-receipt"></i>
            <span>Customer Billing</span>
        </a>
        <a href="professional-bill.html" class="menu-item">
            <i class="fas fa-file-invoice"></i>
            <span>Professional Billing</span>
        </a>
    </div>
</div>