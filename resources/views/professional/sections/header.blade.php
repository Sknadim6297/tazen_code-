@php
    use App\Models\Profile;
    use App\Models\ProfessionalOtherInformation;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    $professional = Auth::guard('professional')->user();
    $profile = $professional ? Profile::where('professional_id', $professional->id)->first() : null;
@endphp

<div class="header">
    <div class="header-left">
        <div class="toggle-sidebar">
            <i class="fas fa-bars"></i>
        </div>
        <div class="search-box">
            <input type="text" placeholder="Search... (Ctrl+K)">
            <i class="fas fa-search"></i>
        </div>
        <div class="search-toggle">
            <i class="fas fa-search"></i>
        </div>
    </div>

    <div class="header-right">
        @if($professional)
            @php
                // Check for new bookings in the last 24 hours
                $professionalId = Auth::guard('professional')->id();
                $yesterday = \Carbon\Carbon::now()->subDay();
                $newBookings = \App\Models\Booking::where('professional_id', $professionalId)
                    ->where('created_at', '>=', $yesterday)
                    ->count();
                
                // Check for reschedule notifications (for notification icon only)
                $rescheduleNotifications = DB::table('notifications')
                    ->where('notifiable_type', 'App\Models\Professional')
                    ->where('notifiable_id', $professionalId)
                    ->where('type', 'App\Notifications\AppointmentRescheduled')
                    ->whereNull('read_at')
                    ->get();
                $rescheduleCount = $rescheduleNotifications->count();
                
                // Check if professional has services
                $hasServices = \App\Models\ProfessionalService::where('professional_id', $professionalId)->exists();
                
                // Check if professional has rates configured
                $hasRates = \App\Models\Rate::where('professional_id', $professionalId)->exists();
                
                // Check if professional has availability defined
                $hasAvailability = \App\Models\Availability::where('professional_id', $professionalId)->exists();
                
                // Check if professional has requested services (other information)
                $hasRequestedServices = \App\Models\ProfessionalOtherInformation::where('professional_id', $professionalId)->exists();
                
                // Count total notifications (including reschedule notifications in icon)
                $totalNotifications = $newBookings + $rescheduleCount;
                if (!$hasServices) $totalNotifications++;
                if (!$hasRates) $totalNotifications++;
                if (!$hasAvailability) $totalNotifications++;
                if (!$hasRequestedServices) $totalNotifications++;
            @endphp
            
            <div class="header-actions">
                <!-- Notification Icon -->
                <div class="header-icon notification-icon" id="notificationIcon">
                    <i class="fas fa-bell"></i>
                    @if($totalNotifications > 0)
                        <span class="notification-badge">{{ $totalNotifications }}</span>
                    @endif
                </div>
                
                <!-- Logout Icon -->
                <div class="header-icon logout">
                    <a href="{{ route('professional.logout') }}" class="btn-logout" title="Logout">
                        <i class="fas fa-power-off"></i>
                    </a>
                </div>
            </div>

            <div class="user-profile-wrapper">
                <div class="user-profile">
                    <img src="{{ $profile && $profile->photo ? asset('storage/'.$profile->photo) : asset('default.jpg') }}" alt="Profile Photo">
                </div>
                
                <div class="user-info">
                    <h5>{{ $professional->name }}</h5>
                    <p>Professional</p>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Notification Modal -->
<div id="notificationModal" class="notification-modal">
    <div class="notification-modal-content">
        <div class="notification-modal-header">
            <h4>Notifications</h4>
            <button class="notification-modal-close">&times;</button>
        </div>
        <div class="notification-modal-body">
            @if($newBookings > 0)
                <div class="notification-item new">
                    <h5>New Booking Alert!</h5>
                    <p>You have {{ $newBookings }} new booking(s) in the last 24 hours.</p>
                    <div class="button-container">
                        <a href="{{ route('professional.booking.index') }}" class="notification-btn view-btn">View Bookings</a>
                    </div>
                </div>
            @endif
            
            @if($rescheduleCount > 0)
                @foreach($rescheduleNotifications as $notification)
                    @php
                        $data = json_decode($notification->data, true);
                    @endphp
                    <div class="notification-item reschedule">
                        <h5>Appointment Rescheduled</h5>
                        <p><strong>{{ $data['customer_name'] ?? 'Customer' }}</strong> rescheduled their appointment</p>
                        <p><small>Service: {{ $data['service_name'] ?? 'N/A' }} - {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small></p>
                        <div class="button-container">
                            <a href="{{ route('professional.booking.index') }}" class="notification-btn view-btn">View Bookings</a>
                            <button class="notification-btn mark-read-btn" onclick="markProfessionalNotificationAsRead('{{ $notification->id }}')">Mark as Read</button>
                        </div>
                    </div>
                @endforeach
            @endif
            
            @if(!$hasServices)
                <div class="notification-item warning">
                    <h5>Complete Your Profile</h5>
                    <p>Add your professional services to start accepting bookings.</p>
                    <div class="button-container">
                        <a href="{{ route('professional.service.index') }}" class="notification-btn view-btn">Add Services</a>
                    </div>
                </div>
            @endif
            
            @if(!$hasRates)
                <div class="notification-item warning">
                    <h5>Configure Your Rates</h5>
                    <p>Set up your pricing rates to start accepting bookings.</p>
                    <div class="button-container">
                        <a href="{{ route('professional.rate.index') }}" class="notification-btn view-btn">Configure Rates</a>
                    </div>
                </div>
            @endif
            
            @if(!$hasAvailability)
                <div class="notification-item warning">
                    <h5>Set Your Availability</h5>
                    <p>Define your availability schedule to start accepting bookings.</p>
                    <div class="button-container">
                        <a href="{{ route('professional.availability.index') }}" class="notification-btn view-btn">Set Availability</a>
                    </div>
                </div>
            @endif
            
            @if(!$hasRequestedServices)
                <div class="notification-item warning">
                    <h5>Add Other Information</h5>
                    <p>Complete your profile with additional service details and specializations.</p>
                    <div class="button-container">
                        <a href="{{ route('professional.requested_services.index') }}" class="notification-btn view-btn">Add Information</a>
                    </div>
                </div>
            @endif
            
            @if($totalNotifications == 0)
                <div class="notification-empty">
                    <i class="fas fa-check-circle"></i>
                    <p>No notifications available</p>
                    <p>You're all caught up! No new notifications at this time.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Global layout fixes for header */
    * {
        box-sizing: border-box;
    }
    
    html, body {
        overflow-x: hidden !important;
        width: 100% !important;
        max-width: 100% !important;
    }
    
    .app-container {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: hidden !important;
    }
    
    .main-content {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: hidden !important;
    }
    
    /* Enhanced Header Styles */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(135deg, #ffffff, #f8f9fa);
        padding: 15px 30px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        position: sticky;
        top: 0;
        z-index: 998;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .header.scrolled {
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.15);
        background: rgba(255, 255, 255, 0.95);
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 25px;
        flex: 1;
        overflow: hidden;
    }

    .toggle-sidebar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #f8f9fa;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        position: relative;
      
    }

    .toggle-sidebar:hover {
        background: #3498db;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    }

    .toggle-sidebar i {
        font-size: 18px;
        transition: all 0.3s ease;
        z-index: 2;
    }

    .toggle-sidebar::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transition: all 0.4s ease;
        transform: translate(-50%, -50%);
    }

    .toggle-sidebar:hover::before {
        width: 60px;
        height: 60px;
    }

    .search-box {
        position: relative;
        flex-grow: 1;
        max-width: 400px;
    }

    .search-box input {
        width: 100%;
        padding: 12px 20px 12px 50px;
        border: 2px solid #e9ecef;
        border-radius: 25px;
        background: #f8f9fa;
        font-size: 14px;
        font-weight: 500;
        outline: none;
        transition: all 0.3s ease;
        color: #495057;
    }

    .search-box input:focus {
        border-color: #3498db;
        background: white;
        box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
        transform: translateY(-1px);
    }

    .search-box input::placeholder {
        color: #adb5bd;
        font-weight: 400;
    }

    .search-box i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        font-size: 16px;
        transition: all 0.3s ease;
        z-index: 2;
    }

    .search-box input:focus ~ i {
        color: #3498db;
        transform: translateY(-50%) scale(1.1);
    }

    /* Mobile Search Toggle */
    .search-toggle {
        display: none;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #f8f9fa;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .search-toggle:hover {
        background: #3498db;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    }

    .search-toggle i {
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-shrink: 0;
        overflow: hidden;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .header-icon {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #f8f9fa;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .header-icon:hover {
        background: #3498db;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    }

    .header-icon.logout:hover {
        background: #e74c3c;
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
    }

    .header-icon.notification-icon:hover {
        background: #f39c12;
        box-shadow: 0 4px 12px rgba(243, 156, 18, 0.3);
    }

    .header-icon i {
        transition: all 0.3s ease;
        z-index: 2;
    }

    .header-icon .btn-logout {
        color: inherit;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
    }

    .notification-badge {
        position: absolute;
        top: -6px;
        right: -6px;
        background: #e74c3c;
        color: white;
        border-radius: 50%;
        min-width: 20px;
        height: 20px;
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 4px;
        border: 2px solid white;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 20%, 53%, 80%, 100% {
            transform: translate(0, 0);
        }
        40%, 43% {
            transform: translate(0, -8px);
        }
        70% {
            transform: translate(0, -4px);
        }
        90% {
            transform: translate(0, -2px);
        }
    }

    .user-profile-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
        padding: 8px 16px 8px 8px;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
        min-height: 48px; /* Ensure consistent height */
    }

    .user-profile-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 25px;
        background: linear-gradient(145deg, rgba(52, 152, 219, 0.1), rgba(52, 152, 219, 0.05));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .user-profile-wrapper:hover::before {
        opacity: 1;
    }

    .user-profile-wrapper:hover {
        background: white;
        border-color: #3498db;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .user-profile {
        position: relative;
        flex-shrink: 0; /* Prevent image from shrinking */
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px; /* Fixed width */
        height: 40px; /* Fixed height */
    }

    .user-profile img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        display: block; /* Ensure proper display */
        max-width: 100%; /* Ensure image doesn't exceed container */
        max-height: 100%; /* Ensure image doesn't exceed container */
        background-color: #f8f9fa; /* Fallback background */
    }

    /* Fallback for broken images */
    .user-profile img:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, #3498db, #2980b9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
    }

    .user-profile::after {
        content: '';
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #27ae60;
        border: 2px solid white;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(39, 174, 96, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(39, 174, 96, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(39, 174, 96, 0);
        }
    }

    .user-info h5 {
        margin: 0 0 2px 0;
        font-size: 15px;
        font-weight: 600;
        color: #495057;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 120px;
        position: relative;
    }

    .user-info h5::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: #3498db;
        transition: width 0.3s ease;
    }

    .user-profile-wrapper:hover .user-info h5::after {
        width: 100%;
    }

    .user-info p {
        margin: 0;
        font-size: 12px;
        color: #6c757d;
        font-weight: 500;
    }

    /* Enhanced Responsive Design */
    @media (max-width: 1200px) {
        .header {
            padding: 12px 20px;
        }
        
        .search-box {
            max-width: 300px;
        }
        
        .user-info h5 {
            max-width: 100px;
        }
    }

    @media (max-width: 992px) {
        .header {
            padding: 10px 16px;
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: hidden !important;
            box-sizing: border-box !important;
        }
        
        .header-left {
            gap: 15px;
            flex: 1;
            max-width: calc(100% - 200px);
        }
        
        .header-right {
            gap: 12px;
            flex-shrink: 0;
            max-width: 200px;
        }
        
        .search-box {
            max-width: 200px;
        }
        
        .search-box input {
            padding: 10px 16px 10px 45px;
            font-size: 13px;
        }
        
        .header-actions {
            gap: 10px;
        }
        
        .header-icon,
        .toggle-sidebar {
            width: 40px;
            height: 40px;
        }
        
        .header-icon i,
        .toggle-sidebar i {
            font-size: 16px;
        }
        
        .user-info h5 {
            max-width: 80px;
            font-size: 14px;
        }
        
        .user-info p {
            font-size: 11px;
        }
        
        .user-profile-wrapper {
            padding: 6px 12px 6px 6px;
            gap: 8px;
            min-height: 42px; /* Ensure consistent height */
            display: flex !important;
            align-items: center;
        }
        
        .user-profile {
            width: 36px;
            height: 36px;
        }
        
        .user-profile img {
            width: 36px;
            height: 36px;
            border: 2px solid white; /* Thinner border for smaller size */
        }
    }

    @media (max-width: 768px) {
        .header {
            padding: 8px 12px;
            position: relative;
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: hidden !important;
            box-sizing: border-box !important;
        }
        
        .header-left {
            gap: 10px;
            flex: 1;
            max-width: calc(100% - 160px); /* Reduced to give more space to header-right */
            overflow: hidden;
        }
        
        .header-right {
            gap: 6px; /* Reduced gap to fit better */
            flex-shrink: 0;
            min-width: 160px; /* Set minimum width instead of max-width */
            max-width: 160px;
            justify-content: flex-end;
            display: flex !important;
            align-items: center;
            overflow: visible; /* Allow content to be visible */
        }
        
        .search-box {
            display: none;
        }
        
        .search-toggle {
            display: flex;
        }
        
        .search-box.mobile-visible {
            display: block;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            padding: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border-top: 1px solid #e9ecef;
            z-index: 1000;
            animation: slideDown 0.3s ease;
        }
        
        .search-box.mobile-visible input {
            max-width: none;
            border-radius: 20px;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .header-actions {
            gap: 6px; /* Reduced gap to fit both icons */
            display: flex !important; /* Ensure it's always visible */
            align-items: center;
            flex-shrink: 0;
            min-width: 80px; /* Ensure minimum width for both icons */
        }
        
        .header-icon,
        .toggle-sidebar,
        .search-toggle {
            width: 32px; /* Slightly smaller to fit better */
            height: 32px;
            border-radius: 8px;
            flex-shrink: 0;
            display: flex !important; /* Ensure icons are visible */
            align-items: center;
            justify-content: center;
            position: relative; /* For proper badge positioning */
        }
        
        .header-icon.notification-icon {
            position: relative;
            display: flex !important;
            overflow: visible; /* Ensure badge is not clipped */
        }
        
        .user-info {
            display: none;
        }
        
        .user-profile-wrapper {
            padding: 2px; /* Reduced padding */
            background: transparent;
            border: none;
            flex-shrink: 0;
            min-width: 36px; /* Slightly increased for better visibility */
            max-width: 36px;
            gap: 0;
            overflow: visible; /* Ensure profile image is not clipped */
            border-radius: 50%; /* Make wrapper circular */
            display: flex !important;
            align-items: center;
            justify-content: center;
        }
        
        .user-profile-wrapper:hover {
            background: rgba(52, 152, 219, 0.1);
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transform: none;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }
        
        .user-profile img {
            width: 32px;
            height: 32px;
            border: 2px solid white; /* Keep border for better definition */
            object-fit: cover; /* Ensure proper image scaling */
            display: block; /* Ensure proper display */
        }
        
        .notification-badge {
            top: -6px; /* Adjusted positioning */
            right: -6px;
            min-width: 16px;
            height: 16px;
            font-size: 9px;
            z-index: 20; /* Higher z-index to ensure visibility */
            display: flex !important;
            background: #e74c3c !important;
            color: white !important;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            border: 1px solid white; /* Thinner border */
            font-weight: bold;
            position: absolute; /* Ensure absolute positioning */
        }
    }

    @media (max-width: 480px) {
        .header {
            padding: 6px 8px; /* Reduced padding for very small screens */
        }
        
        .header-left {
            gap: 8px;
            max-width: calc(100% - 140px); /* Give more space to header-right */
        }
        
        .header-right {
            gap: 4px; /* Minimal gap */
            min-width: 140px;
            max-width: 140px;
        }
        
        .header-actions {
            gap: 4px; /* Minimal gap between icons */
            min-width: 70px;
        }
        
        .header-icon,
        .toggle-sidebar,
        .search-toggle {
            width: 30px; /* Even smaller for very small screens */
            height: 30px;
            border-radius: 6px;
        }
        
        .header-icon i,
        .toggle-sidebar i,
        .search-toggle i {
            font-size: 13px; /* Slightly smaller icons */
        }
        
        .user-profile-wrapper {
            min-width: 32px;
            max-width: 32px;
            padding: 2px;
            border-radius: 50%;
            display: flex !important;
            align-items: center;
            justify-content: center;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }
        
        .user-profile img {
            width: 28px; /* Smaller profile image */
            height: 28px;
            border: 2px solid white;
            object-fit: cover;
            display: block;
        }
        
        .search-box.mobile-visible {
            padding: 10px; /* Reduced padding */
        }
        
        .notification-badge {
            top: -5px;
            right: -5px;
            min-width: 14px;
            height: 14px;
            font-size: 8px;
        }
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .header {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            border-bottom-color: rgba(255, 255, 255, 0.1);
        }
        
        .toggle-sidebar,
        .search-toggle,
        .header-icon {
            background: #34495e;
            color: #ecf0f1;
        }
        
        .search-box input {
            background: #34495e;
            border-color: #4a5f7a;
            color: #ecf0f1;
        }
        
        .search-box input::placeholder {
            color: #95a5a6;
        }
        
        .user-profile-wrapper {
            background: linear-gradient(145deg, #34495e, #2c3e50);
        }
        
        .user-info h5 {
            color: #ecf0f1;
        }
        
        .user-info p {
            color: #bdc3c7;
        }
    }

    /* High contrast mode */
    @media (prefers-contrast: high) {
        .header {
            border-bottom: 3px solid #000;
        }
        
        .toggle-sidebar,
        .search-toggle,
        .header-icon,
        .user-profile-wrapper {
            border: 2px solid #000;
        }
        
        .search-box input {
            border: 2px solid #000;
        }
    }

    /* Reduced motion */
    @media (prefers-reduced-motion: reduce) {
        .header,
        .header *,
        .header *::before,
        .header *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

    /* Notification Icon Enhanced Styles */
    .notification-icon {
        position: relative;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .notification-icon i {
        transition: all 0.3s ease;
    }

    .pulse-animation i {
        animation: pulse-icon 1s infinite;
    }

    @keyframes pulse-icon {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    /* Modal Styles - Enhanced */
    .notification-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 1001;
        overflow: auto;
        backdrop-filter: blur(5px);
    }

    .notification-modal-content {
        background-color: #fff;
        margin: 5% auto;
        width: 90%;
        max-width: 500px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        position: relative;
        animation: modalFadeIn 0.4s ease-out;
        overflow: hidden;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: translateY(-30px) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .notification-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        border-bottom: 1px solid #e9ecef;
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
    }

    .notification-modal-header h4 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
        color: #333;
    }

    .notification-modal-close {
        font-size: 24px;
        cursor: pointer;
        color: #999;
        background: none;
        border: none;
        padding: 5px;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .notification-modal-close:hover {
        color: #e74c3c;
        background: #f8f9fa;
        transform: rotate(90deg);
    }

    .notification-modal-body {
        padding: 25px;
        max-height: 60vh;
        overflow-y: auto;
    }

    .notification-item {
        padding: 18px;
        border-radius: 12px;
        margin-bottom: 15px;
        position: relative;
        border-left: 4px solid;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        background: white;
    }

    .notification-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .notification-item.new {
        border-left-color: #3498db;
        background: linear-gradient(135deg, #ebf7ff, #ffffff);
    }

    .notification-item.warning {
        border-left-color: #f39c12;
        background: linear-gradient(135deg, #fff8e6, #ffffff);
    }

    .notification-item.reschedule {
        border-left-color: #e67e22;
        background: linear-gradient(135deg, #fdf2e6, #ffffff);
    }

    .notification-item h5 {
        margin: 0 0 10px 0;
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }

    .notification-item p {
        margin: 0 0 15px 0;
        color: #555;
        font-size: 14px;
        line-height: 1.5;
    }

    .notification-item .button-container {
        display: flex;
        gap: 10px;
    }

    .notification-item .notification-btn {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        border: none;
    }

    .notification-item .view-btn {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
    }

    .notification-item .view-btn:hover {
        background: linear-gradient(135deg, #2980b9, #1f4e79);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    }

    .notification-item .mark-read-btn {
        background: linear-gradient(135deg, #95a5a6, #7f8c8d);
        color: white;
    }

    .notification-item .mark-read-btn:hover {
        background: linear-gradient(135deg, #7f8c8d, #6c7b7d);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(149, 165, 166, 0.3);
    }

    /* Empty state styling */
    .notification-empty {
        text-align: center;
        padding: 30px;
        color: #6c757d;
    }

    .notification-empty i {
        font-size: 48px;
        color: #27ae60;
        margin-bottom: 15px;
    }

    .notification-empty p:first-of-type {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .notification-empty p:last-of-type {
        font-size: 14px;
        color: #777;
    }

/* Notification Icon Enhanced Styles */
.notification-icon {
    position: relative;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.notification-icon i {
    transition: color 0.3s;
}

.notification-icon:hover i {
    color: #3498db;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.pulse-animation i {
    animation: pulse 1s infinite;
}

.notification-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #e74c3c;
    color: white;
    border-radius: 50%;
    min-width: 18px;
    height: 18px;
    font-size: 11px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 4px;
}

/* Modal Styles */
.notification-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1001;
    overflow: auto;
}

.notification-modal-content {
    background-color: #fff;
    margin: 80px auto;
    width: 90%;
    max-width: 500px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    position: relative;
    animation: modalFadeIn 0.3s;
}

@keyframes modalFadeIn {
    from {opacity: 0; transform: translateY(-20px);}
    to {opacity: 1; transform: translateY(0);}
}

.notification-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid #e9ecef;
}

.notification-modal-header h4 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.notification-modal-close {
    font-size: 22px;
    cursor: pointer;
    color: #999;
    background: none;
    border: none;
    padding: 0;
}

.notification-modal-close:hover {
    color: #333;
}

.notification-modal-body {
    padding: 20px;
    max-height: 60vh;
    overflow-y: auto;
}

.notification-item {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 15px;
    position: relative;
    border-left: 4px solid;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    transition: transform 0.2s;
}

.notification-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.notification-item.new {
    border-left-color: #3498db;
    background-color: #ebf7ff;
}

.notification-item.warning {
    border-left-color: #f39c12;
    background-color: #fff8e6;
}

.notification-item h5 {
    margin: 0 0 8px 0;
    font-size: 16px;
    font-weight: 600;
    color: #333;
}

.notification-item p {
    margin: 0 0 10px 0;
    color: #555;
    font-size: 14px;
}

.notification-item .button-container {
    display: flex;
    gap: 10px;
}

.notification-item .notification-btn {
    padding: 6px 14px;
    border-radius: 4px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: all 0.2s;
}

.notification-item .view-btn {
    background-color: #3498db;
    color: white;
    border: none;
}

.notification-item .view-btn:hover {
    background-color: #2980b9;
}
</style>

<script>
/**
 * Enhanced Header JavaScript for Professional Panel
 */
class ProfessionalHeaderManager {
    constructor() {
        this.header = document.querySelector('.header');
        this.searchBox = document.querySelector('.search-box');
        this.searchInput = document.querySelector('.search-box input');
        this.searchToggle = document.querySelector('.search-toggle');
        this.notificationIcon = document.getElementById('notificationIcon');
        this.notificationModal = document.getElementById('notificationModal');
        this.closeModalBtn = document.querySelector('.notification-modal-close');
        
        this.init();
    }
    
    init() {
        this.bindEvents();
        this.handleScroll();
        this.initRippleEffect();
        this.initKeyboardShortcuts();
    }
    
    bindEvents() {
        // Mobile search toggle
        if (this.searchToggle) {
            this.searchToggle.addEventListener('click', () => {
                this.toggleMobileSearch();
            });
        }
        
        // Search input events
        if (this.searchInput) {
            this.searchInput.addEventListener('focus', () => {
                this.onSearchFocus();
            });
            
            this.searchInput.addEventListener('blur', () => {
                this.onSearchBlur();
            });
            
            this.searchInput.addEventListener('input', (e) => {
                this.onSearchInput(e.target.value);
            });
        }
        
        // Notification modal events
        if (this.notificationIcon) {
            this.notificationIcon.addEventListener('click', () => {
                this.openNotificationModal();
            });
        }
        
        if (this.closeModalBtn) {
            this.closeModalBtn.addEventListener('click', () => {
                this.closeNotificationModal();
            });
        }
        
        // Close modal when clicking outside
        if (this.notificationModal) {
            window.addEventListener('click', (event) => {
                if (event.target === this.notificationModal) {
                    this.closeNotificationModal();
                }
            });
        }
        
        // Scroll event for header effects
        window.addEventListener('scroll', () => {
            this.handleScroll();
        });
        
        // Resize event for responsive adjustments
        window.addEventListener('resize', () => {
            this.handleResize();
        });
        
        // Close mobile search on outside click
        document.addEventListener('click', (e) => {
            this.handleOutsideClick(e);
        });
    }
    
    toggleMobileSearch() {
        if (this.searchBox) {
            const isVisible = this.searchBox.classList.contains('mobile-visible');
            
            if (!isVisible) {
                this.searchBox.classList.add('mobile-visible');
                this.searchToggle.innerHTML = '<i class="fas fa-times"></i>';
                this.searchToggle.style.background = '#e74c3c';
                this.searchToggle.style.color = 'white';
                
                setTimeout(() => {
                    this.searchInput?.focus();
                }, 300);
            } else {
                this.searchBox.classList.remove('mobile-visible');
                this.searchToggle.innerHTML = '<i class="fas fa-search"></i>';
                this.searchToggle.style.background = '';
                this.searchToggle.style.color = '';
            }
        }
    }
    
    onSearchFocus() {
        this.header?.classList.add('search-focused');
    }
    
    onSearchBlur() {
        setTimeout(() => {
            this.header?.classList.remove('search-focused');
        }, 200);
    }
    
    onSearchInput(value) {
        if (value.length > 0) {
            this.header?.classList.add('search-active');
        } else {
            this.header?.classList.remove('search-active');
        }
    }
    
    openNotificationModal() {
        if (this.notificationModal) {
            this.notificationModal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
    }
    
    closeNotificationModal() {
        if (this.notificationModal) {
            this.notificationModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }
    
    handleScroll() {
        const scrollY = window.scrollY;
        
        if (scrollY > 10) {
            this.header?.classList.add('scrolled');
        } else {
            this.header?.classList.remove('scrolled');
        }
        
        // Hide mobile search when scrolling
        if (scrollY > 50 && this.searchBox?.classList.contains('mobile-visible')) {
            this.toggleMobileSearch();
        }
    }
    
    handleResize() {
        const width = window.innerWidth;
        
        // Hide mobile search on resize to desktop
        if (width > 768 && this.searchBox?.classList.contains('mobile-visible')) {
            this.searchBox.classList.remove('mobile-visible');
            this.searchToggle.innerHTML = '<i class="fas fa-search"></i>';
            this.searchToggle.style.background = '';
            this.searchToggle.style.color = '';
        }
    }
    
    handleOutsideClick(e) {
        // Close mobile search if clicking outside
        if (this.searchBox?.classList.contains('mobile-visible') && 
            !this.searchBox.contains(e.target) && 
            !this.searchToggle?.contains(e.target)) {
            this.toggleMobileSearch();
        }
    }
    
    initRippleEffect() {
        // Add ripple effect to clickable elements
        const clickableElements = this.header?.querySelectorAll('.header-icon, .toggle-sidebar, .search-toggle, .user-profile-wrapper');
        
        clickableElements?.forEach(element => {
            element.addEventListener('click', (e) => {
                this.createRipple(e, element);
            });
        });
    }
    
    createRipple(event, element) {
        const ripple = document.createElement('span');
        const rect = element.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
            z-index: 1;
        `;
        
        // Add ripple animation if not exists
        if (!document.querySelector('#ripple-animation-style')) {
            const style = document.createElement('style');
            style.id = 'ripple-animation-style';
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
        element.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }
    
    initKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Ctrl/Cmd + K for search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                this.searchInput?.focus();
            }
            
            // Escape to close mobile search or modal
            if (e.key === 'Escape') {
                if (this.searchBox?.classList.contains('mobile-visible')) {
                    this.toggleMobileSearch();
                } else if (this.notificationModal?.style.display === 'block') {
                    this.closeNotificationModal();
                }
            }
        });
    }
}

// Function to mark professional notification as read
function markProfessionalNotificationAsRead(notificationId) {
    fetch('/professional/notifications/' + notificationId + '/mark-as-read', {
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
            // Refresh the page to update notification counts
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}

// Initialize header manager when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new ProfessionalHeaderManager();
    
    // Animation for notification icon if there are notifications
    const notificationBadge = document.querySelector('.notification-badge');
    if (notificationBadge) {
        const notificationIcon = document.getElementById('notificationIcon');
        setInterval(function() {
            notificationIcon?.classList.toggle('pulse-animation');
        }, 3000);
    }
});
</script>
