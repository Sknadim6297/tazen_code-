<div id="loader" >
            <img src="assets/images/media/loader.svg" alt="">
        </div>
        <!-- Loader -->
<header class="app-header sticky" id="header">

    <!-- Start::main-header-container -->
    <div class="main-header-container container-fluid">

        <!-- Start::header-content-left -->
        <div class="header-content-left">

            <!-- Start::header-element -->
            <div class="header-element">
                <div class="horizontal-logo">
                    <a href="{{ route('admin.dashboard') }}" class="header-logo">
                        <img src="{{ asset('frontend/assets/img/tazen_logo-01-removebg-preview.png') }}" alt="logo" class="desktop-logo">
                        <img src="{{ asset('frontend/assets/img/tazen_logo-01-removebg-preview.png') }}" alt="logo" class="toggle-logo">
                        <img src="{{ asset('frontend/assets/img/tazen_logo-01-removebg-preview.png') }}" alt="logo" class="desktop-dark">
                        <img src="{{ asset('frontend/assets/img/tazen_logo-01-removebg-preview.png') }}" alt="logo" class="toggle-dark">
                    </a>
                </div>
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="header-element mx-lg-0 mx-2">
                <a aria-label="Hide Sidebar" class="sidemenu-toggle header-link" data-bs-toggle="sidebar" href="javascript:void(0);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon menu-btn" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5h12M4 12h16M4 19h8" color="currentColor"/></svg>
                </a>
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="header-element header-search d-md-block d-none my-auto">
                <!-- Start::header-link -->
                <input type="text" class="header-search-bar form-control search-sidebar bg-light-transparent" id="header-search" placeholder="Search for Results..." spellcheck=false autocomplete="off" autocapitalize="off">
                <a href="javascript:void(0);" class="header-search-icon border-0 ">
                    <i class="bi bi-search"></i>
                </a>
                <!-- End::header-link -->
            </div>
            <!-- End::header-element -->


        </div>
        <!-- End::header-content-left -->

        <!-- Start::header-content-right -->
        <ul class="header-content-right">



            <!-- Start::header-element -->
            <li class="header-element header-theme-mode">
                <!-- Start::header-link|layout-setting -->
                <a href="javascript:void(0);" class="header-link layout-setting">
                    <span class="light-layout">
                        <!-- Start::header-link-icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" width="1em" height="1em" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.5 14.078A8.557 8.557 0 0 1 9.922 2.5C5.668 3.497 2.5 7.315 2.5 11.873a9.627 9.627 0 0 0 9.627 9.627c4.558 0 8.376-3.168 9.373-7.422" color="currentColor"/></svg>
                        <!-- End::header-link-icon -->
                    </span>
                    <span class="dark-layout">
                        <!-- Start::header-link-icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" width="1em" height="1em" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 12a5 5 0 1 1-10 0a5 5 0 0 1 10 0M12 2v1.5m0 17V22m7.07-2.929l-1.06-1.06M5.99 5.989L4.928 4.93M22 12h-1.5m-17 0H2m17.071-7.071l-1.06 1.06M5.99 18.011l-1.06 1.06" color="currentColor"/></svg>
                        <!-- End::header-link-icon -->
                    </span>
                </a>
                <!-- End::header-link|layout-setting -->
            </li>
            <!-- End::header-element -->


            <!-- Start::header-element -->
            <li class="header-element notifications-dropdown dropdown">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" id="messageDropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><path d="M2.53 14.77c-.213 1.394.738 2.361 1.902 2.843c4.463 1.85 10.673 1.85 15.136 0c1.164-.482 2.115-1.45 1.902-2.843c-.13-.857-.777-1.57-1.256-2.267c-.627-.924-.689-1.931-.69-3.003C19.525 5.358 16.157 2 12 2S4.475 5.358 4.475 9.5c0 1.072-.062 2.08-.69 3.003c-.478.697-1.124 1.41-1.255 2.267"/><path d="M8 19c.458 1.725 2.076 3 4 3c1.925 0 3.541-1.275 4-3"/></g></svg>
                    @php
                        $admin = Auth::guard('admin')->user();
                        $unreadNotifications = $admin ? $admin->unreadNotifications : collect();
                        $notificationCount = $unreadNotifications->count();
                    @endphp
                    @if($notificationCount > 0)
                        <span class="header-icon-pulse bg-pink rounded pulse pulse-pink"></span>
                    @endif
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <!-- Start::main-header-dropdown -->
                <div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                    <div class="p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 fs-16">Notifications</p>
                            @if($notificationCount > 0)
                                <span class="badge bg-secondary-transparent">{{ $notificationCount }} Unread</span>
                            @else
                                <span class="badge bg-secondary-transparent">No New</span>
                            @endif
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    
                    @if($notificationCount > 0)
                        <ul class="list-unstyled mb-0" id="header-notification-scroll" style="max-height: 300px; overflow-y: auto;">
                            @foreach($unreadNotifications->take(5) as $notification)
                                @php
                                    $data = $notification->data;
                                    $type = $notification->type;
                                @endphp
                                
                                @if($type === 'App\Notifications\AppointmentRescheduled')
                                    <li class="dropdown-item">
                                        <div class="d-flex align-items-start gap-3">
                                            <span class="avatar avatar-md flex-shrink-0 bg-info-transparent">
                                                <i class="fas fa-calendar-alt fs-18 lh-1 align-middle"></i>
                                            </span>
                                            <div class="flex-grow-1">
                                                <div class="fs-13">
                                                    <div class="text-muted">
                                                        <strong>{{ $data['customer_name'] ?? 'Customer' }}</strong> rescheduled appointment
                                                    </div>
                                                    <div class="text-muted fw-normal fs-12">
                                                        Service: {{ $data['service_name'] ?? 'N/A' }}
                                                    </div>
                                                    <div class="text-muted fw-normal fs-12">
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <a href="javascript:void(0);" class="min-w-fit-content text-muted dropdown-item-close" onclick="markAdminNotificationAsRead('{{ $notification->id }}')">
                                                    <i class="ri-close-line fs-16"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                @else
                                    <li class="dropdown-item">
                                        <div class="d-flex align-items-start gap-3">
                                            <span class="avatar avatar-md flex-shrink-0 bg-primary-transparent">
                                                <i class="ri-notification-line fs-18 lh-1 align-middle"></i>
                                            </span>
                                            <div class="flex-grow-1">
                                                <div class="fs-13">
                                                    <div class="text-muted">
                                                        {{ $data['message'] ?? 'New notification' }}
                                                    </div>
                                                    <div class="text-muted fw-normal fs-12">
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <a href="javascript:void(0);" class="min-w-fit-content text-muted dropdown-item-close" onclick="markAdminNotificationAsRead('{{ $notification->id }}')">
                                                    <i class="ri-close-line fs-16"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <div class="p-3 empty-header-item1 border-top">
                            <div class="d-grid">
                                <a href="javascript:void(0);" class="btn btn-primary btn-wave" onclick="markAllAdminNotificationsAsRead()">Mark All as Read</a>
                            </div>
                        </div>
                    @else
                        <div class="p-5 empty-item1">
                            <div class="text-center">
                                <span class="avatar avatar-xl avatar-rounded bg-secondary-transparent">
                                    <i class="ri-notification-off-line fs-2"></i>
                                </span>
                                <h6 class="fw-medium mt-3">No New Notifications</h6>
                                <p class="text-muted">You're all caught up! No new notifications at this time.</p>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- End::main-header-dropdown -->
            </li>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <li class="header-element dropdown">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div>
                            <img src="{{ asset('admin/assets/images/admin_logo.jpg') }}" alt="img" class="avatar avatar-sm avatar-rounded">
                        </div>
                    </div>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end" aria-labelledby="mainHeaderProfile">
                    <li class="p-3 border-bottom">
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <div>
                                <p class="mb-0 fw-semibold lh-1">{{ Auth::guard('admin')->user()->name }}</p>
                                <span class="fs-11 text-muted">{{ Auth::guard('admin')->user()->email }}</span>
                            </div>
                        </div>
                    </li>
                    {{-- <li><a class="dropdown-item d-flex align-items-center" href="profile.html"><i class="ri-user-line fs-15 me-2 text-gray fw-normal"></i>Profile</a></li>
                    <li> <hr class="dropdown-divider"> </li> --}}
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('admin.logout') }}"><i class="ri-logout-circle-line fs-15 me-2 text-gray fw-normal"></i>Sign Out</a></li>
                </ul>
            </li>  
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <li class="header-element">
               
                <!-- End::header-link|switcher-icon -->
            </li>
            <!-- End::header-element -->

        </ul>
        <!-- End::header-content-right -->

    </div>
    <!-- End::main-header-container -->

</header>
<!-- End::main-header -->

<style>
/* Mobile Responsive Styles for Admin Header Notifications */
@media (max-width: 1199.98px) {
    /* Show notifications on all screen sizes */
    .notifications-dropdown {
        display: block !important;
    }
    
    /* Adjust notification dropdown for mobile */
    .notifications-dropdown .main-header-dropdown {
        position: fixed !important;
        top: 60px !important;
        right: 10px !important;
        left: 10px !important;
        width: auto !important;
        max-width: calc(100vw - 20px) !important;
        z-index: 1055 !important;
        border-radius: 8px !important;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        border: 1px solid #e0e0e0 !important;
        background-color: #ffffff !important;
        max-height: 70vh !important;
        overflow: hidden !important;
    }
}

@media (max-width: 991.98px) {
    /* Further mobile optimizations */
    .notifications-dropdown .main-header-dropdown {
        top: 55px !important;
        right: 8px !important;
        left: 8px !important;
        max-width: calc(100vw - 16px) !important;
        max-height: 60vh !important;
    }
    
    /* Adjust notification list height for mobile */
    .notifications-dropdown #header-notification-scroll {
        max-height: 200px !important;
    }
    
    /* Make notification items more compact for mobile */
    .notifications-dropdown .dropdown-item {
        padding: 12px !important;
        border-bottom: 1px solid #f0f0f0;
        margin-bottom: 0 !important;
    }
    
    .notifications-dropdown .dropdown-item:hover {
        background-color: #f8f9fa !important;
    }
    
    /* Compact header section */
    .notifications-dropdown .p-3 {
        padding: 12px !important;
    }
    
    .notifications-dropdown .p-5 {
        padding: 20px !important;
    }
    
    /* Smaller text for mobile */
    .notifications-dropdown .fs-16 {
        font-size: 14px !important;
    }
    
    /* Improve notification icon visibility */
    .header-element .header-link {
        padding: 8px !important;
        border-radius: 6px !important;
        transition: all 0.3s ease !important;
        min-width: 40px !important;
        min-height: 40px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    
    .header-element .header-link:hover {
        background-color: rgba(108, 117, 125, 0.1) !important;
        transform: scale(1.05) !important;
    }
    
    /* Enhanced pulse animation for notification badge */
    .header-icon-pulse {
        position: absolute !important;
        top: -2px !important;
        right: -2px !important;
        width: 10px !important;
        height: 10px !important;
        animation: pulse-notification 2s infinite !important;
    }
    
    @keyframes pulse-notification {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.2);
            opacity: 0.7;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
}

@media (max-width: 767.98px) {
    /* Small mobile adjustments */
    .notifications-dropdown .main-header-dropdown {
        top: 50px !important;
        right: 5px !important;
        left: 5px !important;
        max-width: calc(100vw - 10px) !important;
        max-height: 50vh !important;
    }
    
    /* More compact notification items on very small screens */
    .notifications-dropdown .dropdown-item {
        padding: 10px !important;
    }
    
    /* Smaller text sizes */
    .notifications-dropdown .fs-13 {
        font-size: 12px !important;
    }
    
    .notifications-dropdown .fs-12 {
        font-size: 11px !important;
    }
    
    /* Compact header */
    .notifications-dropdown .p-3 {
        padding: 10px !important;
    }
    
    .notifications-dropdown .p-5 {
        padding: 15px !important;
    }
    
    /* Adjust avatar sizes for mobile */
    .notifications-dropdown .avatar-md {
        width: 35px !important;
        height: 35px !important;
        font-size: 14px !important;
    }
    
    .notifications-dropdown .avatar-xl {
        width: 50px !important;
        height: 50px !important;
        font-size: 20px !important;
    }
    
    /* Make close buttons compact for touch */
    .notifications-dropdown .dropdown-item-close {
        padding: 6px !important;
        min-width: 28px !important;
        min-height: 28px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 4px !important;
    }
    
    .notifications-dropdown .dropdown-item-close:hover {
        background-color: rgba(220, 53, 69, 0.1) !important;
    }
    
    .notifications-dropdown .dropdown-item-close i {
        font-size: 14px !important;
    }
    
    /* Compact button in footer */
    .notifications-dropdown .btn {
        padding: 8px 16px !important;
        font-size: 12px !important;
    }
}

@media (max-width: 575.98px) {
    /* Extra small mobile devices */
    .notifications-dropdown .main-header-dropdown {
        top: 45px !important;
        right: 3px !important;
        left: 3px !important;
        max-width: calc(100vw - 6px) !important;
        max-height: 45vh !important;
    }
    
    .header-element .header-link {
        min-width: 36px !important;
        min-height: 36px !important;
        padding: 6px !important;
    }
    
    .header-link-icon {
        width: 18px !important;
        height: 18px !important;
    }
    
    /* Very compact notifications */
    .notifications-dropdown .dropdown-item {
        padding: 8px !important;
    }
    
    .notifications-dropdown .p-3 {
        padding: 8px !important;
    }
    
    .notifications-dropdown .p-5 {
        padding: 12px !important;
    }
}

/* Light mode styling - ensure notifications always have light background unless explicitly dark mode */
.notifications-dropdown .main-header-dropdown {
    background-color: #ffffff !important;
    color: #333333 !important;
}

.notifications-dropdown .dropdown-item {
    background-color: #ffffff !important;
    color: #333333 !important;
}

.notifications-dropdown .text-muted {
    color: #6c757d !important;
}

.notifications-dropdown .badge {
    background-color: rgba(108, 117, 125, 0.1) !important;
    color: #495057 !important;
}

/* Dark mode support - only when explicitly in dark mode */
@media (prefers-color-scheme: dark) {
    .notifications-dropdown .main-header-dropdown {
        background-color: #2d3748 !important;
        border-color: #4a5568 !important;
        color: #e2e8f0 !important;
    }
    
    .notifications-dropdown .dropdown-item {
        border-bottom-color: #4a5568 !important;
        background-color: #2d3748 !important;
        color: #e2e8f0 !important;
    }
    
    .notifications-dropdown .dropdown-item:hover {
        background-color: #374151 !important;
    }
    
    .notifications-dropdown .text-muted {
        color: #a0aec0 !important;
    }
    
    .notifications-dropdown .badge {
        background-color: rgba(160, 174, 192, 0.2) !important;
        color: #e2e8f0 !important;
    }
}

/* Force light mode for notification dropdown when not in system dark mode */
html:not([data-theme="dark"]) .notifications-dropdown .main-header-dropdown {
    background-color: #ffffff !important;
    color: #333333 !important;
    border-color: #e0e0e0 !important;
}

html:not([data-theme="dark"]) .notifications-dropdown .dropdown-item {
    background-color: #ffffff !important;
    color: #333333 !important;
    border-bottom-color: #f0f0f0 !important;
}

html:not([data-theme="dark"]) .notifications-dropdown .text-muted {
    color: #6c757d !important;
}

/* Fix for dropdown position - override Bootstrap's transform */
.notifications-dropdown .dropdown-menu.show {
    transform: translate(0px, 71px) !important;
}

/* Ensure dropdown fits on mobile screens */
@media (max-width: 575.98px) {
    .notifications-dropdown .dropdown-menu.show {
        right: 0 !important;
        left: auto !important;
        width: 90vw;
        max-width: 90vw;
        transform: translate(-3px, 71px) !important;
    }
}

/* Backdrop for mobile dropdown - REMOVED */
/* No backdrop overlay on mobile */
</style>

<script>
// Enhanced Admin Header Mobile Notification Management
document.addEventListener('DOMContentLoaded', function() {
    // Function to mark individual admin notification as read
    window.markAdminNotificationAsRead = function(notificationId) {
        const button = event.target.closest('.dropdown-item-close');
        if (button) {
            button.style.opacity = '0.5';
            button.style.pointerEvents = 'none';
        }
        
        fetch('/admin/notifications/' + notificationId + '/mark-as-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the notification item with animation
                const notificationItem = event.target.closest('.dropdown-item');
                if (notificationItem) {
                    notificationItem.style.transition = 'all 0.3s ease';
                    notificationItem.style.opacity = '0';
                    notificationItem.style.transform = 'translateX(100%)';
                    notificationItem.style.maxHeight = '0';
                    notificationItem.style.padding = '0';
                    notificationItem.style.marginBottom = '0';
                    
                    setTimeout(() => {
                        notificationItem.remove();
                        
                        // Update notification count
                        updateNotificationCount();
                        
                        // Check if no notifications left
                        const remainingNotifications = document.querySelectorAll('#header-notification-scroll .dropdown-item');
                        if (remainingNotifications.length === 0) {
                            // Reload to show "No notifications" state
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        }
                    }, 300);
                }
            } else {
                // Restore button if failed
                if (button) {
                    button.style.opacity = '1';
                    button.style.pointerEvents = 'auto';
                }
            }
        })
        .catch(error => {
            console.error('Error marking notification as read:', error);
            // Restore button on error
            if (button) {
                button.style.opacity = '1';
                button.style.pointerEvents = 'auto';
            }
        });
    };
    
    // Function to mark all admin notifications as read
    window.markAllAdminNotificationsAsRead = function() {
        const button = event.target;
        if (button) {
            button.style.opacity = '0.5';
            button.style.pointerEvents = 'none';
            button.innerHTML = 'Processing...';
        }
        
        fetch('/admin/notifications/mark-all-as-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add success feedback
                if (button) {
                    button.innerHTML = 'Marked All as Read!';
                    button.classList.remove('btn-primary');
                    button.classList.add('btn-success');
                }
                
                // Refresh the page after a short delay
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                // Restore button if failed
                if (button) {
                    button.style.opacity = '1';
                    button.style.pointerEvents = 'auto';
                    button.innerHTML = 'Mark All as Read';
                }
            }
        })
        .catch(error => {
            console.error('Error marking all notifications as read:', error);
            // Restore button on error
            if (button) {
                button.style.opacity = '1';
                button.style.pointerEvents = 'auto';
                button.innerHTML = 'Mark All as Read';
            }
        });
    };
    
    // Function to update notification count badge
    function updateNotificationCount() {
        const notificationItems = document.querySelectorAll('#header-notification-scroll .dropdown-item');
        const count = notificationItems.length;
        const badge = document.querySelector('.notifications-dropdown .badge');
        const pulse = document.querySelector('.header-icon-pulse');
        
        if (badge) {
            if (count > 0) {
                badge.textContent = count + ' Unread';
            } else {
                badge.textContent = 'No New';
                if (pulse) {
                    pulse.style.display = 'none';
                }
            }
        }
    }
    
    // Mobile dropdown management - simplified without backdrop
    
    // Handle dropdown events
    const notificationDropdown = document.querySelector('.notifications-dropdown [data-bs-toggle="dropdown"]');
    if (notificationDropdown) {
        notificationDropdown.addEventListener('show.bs.dropdown', function() {
            // No backdrop creation - just show dropdown
            
            // Fix the dropdown positioning to match our CSS override
            setTimeout(() => {
                const dropdownMenu = document.querySelector('.notifications-dropdown .dropdown-menu.show');
                if (dropdownMenu) {
                    // Apply our fixed positioning directly
                    dropdownMenu.style.transform = 'translate(0px, 71px)';
                    
                    // For mobile, adjust position
                    if (window.innerWidth <= 575.98) {
                        dropdownMenu.style.right = '0';
                        dropdownMenu.style.left = 'auto';
                        dropdownMenu.style.maxWidth = '90vw';
                    }
                }
            }, 0);
        });
        
        notificationDropdown.addEventListener('hide.bs.dropdown', function() {
            // No backdrop removal needed
        });
    }
    
    // Handle window resize - simplified
    window.addEventListener('resize', function() {
        // No backdrop management needed
    });
    
    // Add touch feedback for notification icon
    const notificationIcon = document.querySelector('.notifications-dropdown .header-link');
    if (notificationIcon) {
        notificationIcon.addEventListener('touchstart', function() {
            this.style.transform = 'scale(0.95)';
        });
        
        notificationIcon.addEventListener('touchend', function() {
            this.style.transform = 'scale(1)';
        });
        
        // Add click feedback
        notificationIcon.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    }
    
    // Auto-hide notification dropdown after interaction - simplified
    const originalMarkAsRead = window.markAdminNotificationAsRead;
    if (originalMarkAsRead) {
        window.markAdminNotificationAsRead = function(notificationId) {
            originalMarkAsRead(notificationId);
            
            // Auto-hide dropdown on mobile after marking as read
            if (window.innerWidth <= 991.98) {
                setTimeout(() => {
                    const dropdownToggle = document.querySelector('.notifications-dropdown [data-bs-toggle="dropdown"]');
                    if (dropdownToggle && bootstrap.Dropdown) {
                        const dropdown = bootstrap.Dropdown.getInstance(dropdownToggle);
                        if (dropdown) {
                            dropdown.hide();
                        }
                    }
                }, 1500);
            }
        };
    }
    
    // Initialize notification count on page load
    updateNotificationCount();
    
    // Override Bootstrap Dropdown positioning for notifications
    if (typeof bootstrap !== 'undefined' && bootstrap.Dropdown) {
        const originalSetup = bootstrap.Dropdown.prototype._getMenuElement;
        
        bootstrap.Dropdown.prototype._getMenuElement = function() {
            const menuElement = originalSetup.call(this);
            
            // Check if this is our notification dropdown
            if (this._element && this._element.closest('.notifications-dropdown')) {
                // Set a custom data attribute to identify it
                menuElement.setAttribute('data-notif-dropdown', 'true');
                
                // Override any popper instance settings
                if (this._popper) {
                    this._popper.state.elements.popper.style.transform = 'translate(0px, 71px)';
                    this._popper.update();
                }
            }
            
            return menuElement;
        };
        
        // Check for any dropdowns already initialized and apply our fix
        document.querySelectorAll('.notifications-dropdown [data-bs-toggle="dropdown"]').forEach(function(el) {
            const dropdownInstance = bootstrap.Dropdown.getInstance(el);
            if (dropdownInstance) {
                const menuElement = dropdownInstance._menu;
                if (menuElement) {
                    menuElement.setAttribute('data-notif-dropdown', 'true');
                }
            }
        });
    }
});
</script>