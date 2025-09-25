<!-- Sidebar -->
     <div class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('home') }}">
                <img src="{{ asset('customer-css/assets/images/tazen_logo.png') }}" alt="Logo" class="sidebar-logo" height="80">
            </a>
            <i class="fas fa-times close-sidebar"></i>
        </div> 

        <div class="sidebar-menu">
            <div class="menu-title">Main</div>
            <a href="{{ route('user.dashboard') }}" class="menu-item {{ Route::is('user.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            
             <a href="{{ route('home') }}" class="menu-item">
                <i class="fas fa-home"></i>
                <span>Back to Home</span>
            </a>
            <div class="menu-title">Manage</div>
            <a href="{{ route('user.profile.index') }}" class="menu-item {{ Route::is('user.profile.*') ? 'active' : '' }}">
                <i class="fas fa-user-cog"></i>
                <span>Add Profile</span>
            </a>
            <a href="{{ route('user.all-appointment.index') }}" class="menu-item {{ Route::is('user.all-appointment.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i>
                <span>All Appointment</span>
            </a>
            <a href="{{ route('user.upcoming-appointment.index') }}" class="menu-item {{ Route::is('user.upcoming-appointment.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i>
                <span>Upcoming Appointment</span>
            </a>

            <a href="{{ route('user.customer-event.index') }}" class="menu-item {{ Route::is('user.customer-event.*') ? 'active' : '' }}">
                <i class="fas fa-clock"></i>
                <span>Events</span>
            </a>

            <div class="menu-title">Billing</div>
            <a href="{{ route('user.billing.index') }}" class="menu-item {{ Route::is('user.billing.*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>All Billing</span>
            </a>
        </div>
    </div>
    <style>
        .menu-item.active {
            background: linear-gradient(45deg, #FF4500, #FFA500);
            color: white;
            border-radius: 5px;
            margin: 2px 0;
        }
        
        .menu-item.active i {
            color: white;
        }

        .sidebar-header a {
            display: inline-block;
            transition: transform 0.2s ease;
        }

        .sidebar-header a:hover {
            transform: scale(1.05);
        }

        .sidebar-header a:active {
            transform: scale(0.98);
        }

        /* Mobile-specific styles for proper z-index layering */
        @media (max-width: 768px) {
            .sidebar {
                z-index: 1060; /* High z-index for mobile to ensure it's above header */
            }

            .sidebar.active {
                z-index: 1060; /* Maintain high z-index when active */
            }

            /* Ensure sidebar header (logo) is always visible on mobile */
            .sidebar .sidebar-header {
                position: relative;
                z-index: 1061;
                background: var(--sidebar-bg);
            }

            /* Ensure close button is accessible */
            .sidebar .close-sidebar {
                position: relative;
                z-index: 1062;
                cursor: pointer;
                color: var(--sidebar-color);
                font-size: 18px;
                transition: color 0.3s ease;
            }

            .sidebar .close-sidebar:hover {
                color: white;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                z-index: 1070; /* Even higher z-index for smaller mobile devices */
            }

            .sidebar.active {
                z-index: 1070;
            }

            .sidebar .sidebar-header {
                z-index: 1071;
            }

            .sidebar .close-sidebar {
                z-index: 1072;
            }
        }
    </style>
