@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    $user = Auth::guard('user')->user();
    $profile = $user ? $user->customerProfile : null;
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
        @if($user)
            @php
                // Get unread booking chats with booking details
                $userId = Auth::guard('user')->id();
                
                try {
                    $unreadBookingChats = \App\Models\BookingChat::whereHas('booking', function($q) use ($userId) {
                            $q->where('user_id', $userId);
                        })
                        ->where('sender_type', 'professional')
                        ->where('is_read', false)
                        ->where('is_system_message', false)
                        ->select('booking_id', DB::raw('COUNT(*) as unread_count'), DB::raw('MAX(created_at) as last_message_at'))
                        ->groupBy('booking_id')
                        ->orderBy('last_message_at', 'desc')
                        ->get();
                    
                    // Load booking relationships separately to avoid groupBy issues
                    if ($unreadBookingChats->isNotEmpty()) {
                        $bookingIds = $unreadBookingChats->pluck('booking_id')->toArray();
                        $bookings = \App\Models\Booking::with(['professional', 'service'])
                            ->whereIn('id', $bookingIds)
                            ->get()
                            ->keyBy('id');
                        
                        // Attach booking data to each chat group
                        foreach ($unreadBookingChats as $chatGroup) {
                            $chatGroup->booking = $bookings->get($chatGroup->booking_id);
                        }
                    }
                    
                    $unreadChatCount = $unreadBookingChats->sum('unread_count');

                    // Get unread database notifications for additional services
                    $unreadNotifications = $user->unreadNotifications()
                        ->where('type', 'App\Notifications\AdditionalServiceNotification')
                        ->orderBy('created_at', 'desc')
                        ->get();
                    
                    $unreadNotificationsCount = $unreadNotifications->count();

                    // Get unread admin messages
                    $unreadAdminMessages = \App\Models\AdminProfessionalChatMessage::whereHas('chat', function($q) use ($userId) {
                            $q->where('customer_id', $userId)
                              ->where('chat_type', 'admin_customer');
                        })
                        ->where('sender_type', 'App\\Models\\Admin')
                        ->where('is_read', false)
                        ->orderBy('created_at', 'desc')
                        ->get();
                    
                    $unreadAdminMessagesCount = $unreadAdminMessages->count();
                    
                    // Merge all notifications with timestamps for proper sorting
                    $allNotifications = collect();
                    
                    // Add additional service notifications
                    foreach($unreadNotifications as $notification) {
                        $allNotifications->push([
                            'type' => 'service_notification',
                            'timestamp' => $notification->created_at,
                            'data' => $notification
                        ]);
                    }
                    
                    // Add admin messages
                    foreach($unreadAdminMessages as $adminMessage) {
                        $allNotifications->push([
                            'type' => 'admin_message',
                            'timestamp' => $adminMessage->created_at,
                            'data' => $adminMessage
                        ]);
                    }
                    
                    // Add chat notifications
                    foreach($unreadBookingChats as $chatGroup) {
                        $allNotifications->push([
                            'type' => 'chat_notification',
                            'timestamp' => \Carbon\Carbon::parse($chatGroup->last_message_at),
                            'data' => $chatGroup
                        ]);
                    }
                    
                    // Sort all notifications by timestamp (newest first)
                    $allNotifications = $allNotifications->sortByDesc('timestamp');
                    
                } catch (\Exception $e) {
                    $unreadBookingChats = collect();
                    $unreadChatCount = 0;
                    $unreadNotifications = collect();
                    $unreadNotificationsCount = 0;
                    $unreadAdminMessages = collect();
                    $unreadAdminMessagesCount = 0;
                    $allNotifications = collect();
                }
                
                // Total notifications (chat + additional service notifications + admin messages)
                $totalNotifications = $unreadChatCount + $unreadNotificationsCount + $unreadAdminMessagesCount;
            @endphp
            
            <div class="header-actions">
                <!-- Notification Icon -->
                <div class="header-icon notification-icon" id="notificationIcon" title="Notifications">
                    <i class="fas fa-bell"></i>
                    @if($totalNotifications > 0)
                        <span class="notification-badge">{{ $totalNotifications }}</span>
                    @endif
                </div>

                <!-- Chat Icon (Admin Chat) -->
                <div class="header-icon chat-icon" id="chatIcon" title="Chat with Admin">
                    <button type="button" class="chat-btn" data-participant-type="admin" data-participant-id="1">
                        <i class="fas fa-comments"></i>
                        @if($unreadAdminMessagesCount > 0)
                            <span id="chatUnreadBadge" class="notification-badge">{{ $unreadAdminMessagesCount }}</span>
                        @else
                            <span id="chatUnreadBadge" class="notification-badge" style="display: none;">0</span>
                        @endif
                    </button>
                </div>
                
                <!-- Logout Icon -->
                <div class="header-icon logout">
                    <a href="{{ route('user.logout') }}" class="btn-logout" title="Logout">
                        <i class="fas fa-power-off"></i>
                    </a>
                </div>
            </div>

            <div class="user-profile-wrapper">
                <div class="user-profile">
                    <img src="{{ $profile && $profile->profile_image ? asset($profile->profile_image) : asset('default-avatar.png') }}" 
                         alt="User" 
                         onerror="this.onerror=null;this.src='{{ asset('default-avatar.png') }}';">
                </div>
                
                <div class="user-info">
                    <h5>{{ $user->name }}</h5>
                    <p>Customer</p>
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
            {{-- All Notifications Sorted by Timestamp (Newest First) --}}
            @if($allNotifications && $allNotifications->count() > 0)
                @foreach($allNotifications as $notificationItem)
                    @if($notificationItem['type'] == 'service_notification')
                        @php
                            $notification = $notificationItem['data'];
                            $data = $notification->data;
                            $serviceId = $data['additional_service_id'] ?? null;
                            $serviceName = $data['service_name'] ?? 'Additional Service';
                            $type = $data['type'] ?? 'update';
                            $icon = $data['icon'] ?? 'fas fa-bell';
                            $color = $data['color'] ?? '#3498db';
                        @endphp
                        <div class="notification-item service-notification" data-notification-id="{{ $notification->id }}">
                            <div class="notification-icon-wrapper" style="background-color: {{ $color }};">
                                <i class="{{ $icon }}"></i>
                            </div>
                            <div class="notification-content">
                                <h5>{{ $data['title'] ?? 'Service Update' }}</h5>
                                <p>{{ $data['message'] ?? 'You have a new update regarding your additional service.' }}</p>
                                <p><small>Service: {{ $serviceName }} - {{ $notification->created_at->diffForHumans() }}</small></p>
                                <div class="button-container">
                                    @if($serviceId)
                                        <a href="{{ route('user.additional-services.show', $serviceId) }}" class="notification-btn view-btn">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                    @endif
                                    <button class="notification-btn mark-read-btn" onclick="markNotificationAsRead('{{ $notification->id }}')">
                                        <i class="fas fa-check"></i> Mark as Read
                                    </button>
                                </div>
                            </div>
                        </div>
                    @elseif($notificationItem['type'] == 'admin_message')
                        @php
                            $adminMessage = $notificationItem['data'];
                            $messagePreview = $adminMessage->message ? 
                                (strlen($adminMessage->message) > 100 ? substr($adminMessage->message, 0, 100) . '...' : $adminMessage->message) : 
                                'File attachment';
                        @endphp
                        <div class="notification-item admin-chat-notification" data-message-id="{{ $adminMessage->id }}">
                            <div class="notification-icon-wrapper" style="background-color: #e74c3c;">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <div class="notification-content">
                                <h5>New Message from Admin</h5>
                                <p>{{ $messagePreview }}</p>
                                <p><small>{{ $adminMessage->created_at->diffForHumans() }}</small></p>
                                <div class="button-container">
                                    <button class="notification-btn view-btn admin-chat-btn">
                                        <i class="fas fa-comments"></i> Open Admin Chat
                                    </button>
                                    <button class="notification-btn mark-read-btn" onclick="markAdminMessageAsRead('{{ $adminMessage->id }}')">
                                        <i class="fas fa-check"></i> Mark as Read
                                    </button>
                                </div>
                            </div>
                        </div>
                    @elseif($notificationItem['type'] == 'chat_notification')
                        @php
                            $chatGroup = $notificationItem['data'];
                            $booking = $chatGroup->booking ?? null;
                            if (!$booking) continue;
                            
                            $professionalName = optional($booking->professional)->name ?? 'Professional';
                            $serviceName = $booking->service_name ?? (optional($booking->service)->name ?? 'Service');
                        @endphp
                        <div class="notification-item chat-notification">
                            <div class="notification-icon-wrapper">
                                <i class="fas fa-message"></i>
                            </div>
                            <div class="notification-content">
                                <h5>New Message from {{ $professionalName }}</h5>
                                <p>{{ $chatGroup->unread_count }} unread message(s) for Booking #{{ $booking->id }}</p>
                                <p><small>Service: {{ $serviceName }} - {{ \Carbon\Carbon::parse($chatGroup->last_message_at)->diffForHumans() }}</small></p>
                                <div class="button-container">
                                    <a href="{{ route('user.chat.open', $booking->id) }}" class="notification-btn view-btn">
                                        <i class="fas fa-comments"></i> Open Chat
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
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
        z-index: 98;
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
        overflow: hidden;
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
        overflow: hidden;
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

    .header-icon.chat-icon:hover {
        background: #9b59b6;
        box-shadow: 0 4px 12px rgba(155, 89, 182, 0.3);
    }

    .header-icon.chat-icon button {
        background: none;
        border: none;
        color: inherit;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        position: relative;
        cursor: pointer;
    }

    .header-icon i {
        font-size: 18px;
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
    }

    .user-profile img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
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
        }
        
        .header-left {
            gap: 20px;
        }
        
        .header-right {
            gap: 15px;
        }
        
        .search-box {
            max-width: 250px;
        }
        
        .search-box input {
            padding: 10px 16px 10px 45px;
        }
        
        .user-info h5 {
            max-width: 80px;
        }
    }

    @media (max-width: 768px) {
        .header {
            padding: 8px 12px;
            position: relative;
            z-index: 97; /* Lower z-index for mobile to ensure sidebar overlays */
        }
        
        .header-left {
            gap: 15px;
        }
        
        .header-right {
            gap: 12px;
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
            z-index: 97;
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
        
        .header-icon,
        .toggle-sidebar,
        .search-toggle {
            width: 40px;
            height: 40px;
            border-radius: 10px;
        }
        
        .header-icon i,
        .toggle-sidebar i,
        .search-toggle i {
            font-size: 16px;
        }
        
        .user-info {
            display: none;
        }
        
        .user-profile-wrapper {
            padding: 6px;
            background: transparent;
            border: none;
        }
        
        .user-profile-wrapper:hover {
            background: #f8f9fa;
            border: none;
            box-shadow: none;
            transform: none;
        }
        
        .user-profile img {
            width: 36px;
            height: 36px;
        }
    }

    @media (max-width: 480px) {
        .header {
            padding: 6px 10px;
            z-index: 96; /* Even lower z-index for smaller mobile devices */
        }
        
        .header-left {
            gap: 10px;
        }
        
        .header-right {
            gap: 8px;
        }
        
        .header-icon,
        .toggle-sidebar,
        .search-toggle {
            width: 36px;
            height: 36px;
            border-radius: 8px;
        }
        
        .header-icon i,
        .toggle-sidebar i,
        .search-toggle i {
            font-size: 14px;
        }
        
        .user-profile img {
            width: 32px;
            height: 32px;
        }
        
        .search-box.mobile-visible {
            padding: 12px;
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

    /* Notification Modal Styles */
    .notification-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        backdrop-filter: blur(5px);
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .notification-modal-content {
        position: absolute;
        top: 70px;
        right: 20px;
        width: 400px;
        max-height: 600px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .notification-modal-header {
        padding: 20px;
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .notification-modal-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .notification-modal-close {
        background: transparent;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .notification-modal-close:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: rotate(90deg);
    }

    .notification-modal-body {
        max-height: 540px;
        overflow-y: auto;
        padding: 10px;
    }

    .notification-item {
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 8px;
        border-left: 4px solid #3498db;
        background: #f8f9fa;
        transition: all 0.3s ease;
    }

    .notification-item:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .notification-item.chat-notification {
        border-left-color: #9b59b6;
        background: linear-gradient(135deg, #f4ecf7, #ffffff);
        display: flex;
        gap: 15px;
        align-items: flex-start;
    }

    .notification-item.chat-notification .notification-icon-wrapper {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #9b59b6, #8e44ad);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
    }

    .notification-item.chat-notification .notification-content {
        flex: 1;
    }

    /* Service Notification Specific Styles */
    .notification-item.service-notification {
        border-left-color: #e67e22;
        background: linear-gradient(135deg, #fef9e7, #ffffff);
        display: flex;
        gap: 15px;
        align-items: flex-start;
    }

    .notification-item.service-notification .notification-icon-wrapper {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 16px;
        background: var(--icon-color, linear-gradient(135deg, #e67e22, #d35400));
    }

    .notification-item.service-notification .notification-content {
        flex: 1;
    }

    /* Mark as Read Button */
    .notification-item .mark-read-btn {
        background: linear-gradient(135deg, #95a5a6, #7f8c8d);
        color: white;
    }

    .notification-item .mark-read-btn:hover {
        background: linear-gradient(135deg, #7f8c8d, #6c7b7d);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(149, 165, 166, 0.3);
    }

    /* Animation for notification items */
    .notification-item {
        animation: slideInFromRight 0.3s ease-out;
    }

    @keyframes slideInFromRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .notification-item h5 {
        margin: 0 0 10px 0;
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }

    .notification-item p {
        margin: 0 0 10px 0;
        color: #555;
        font-size: 14px;
        line-height: 1.5;
    }

    .notification-item .button-container {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .notification-item .notification-btn {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .notification-item .view-btn {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
    }

    .notification-item .view-btn:hover {
        background: linear-gradient(135deg, #2980b9, #21618c);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    }

    .notification-empty {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }

    .notification-empty i {
        font-size: 48px;
        margin-bottom: 15px;
        color: #4CAF50;
    }

    .notification-empty p:first-of-type {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    /* Pulse animation for notification badge */
    @keyframes pulse-animation {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }

    .notification-icon.pulse-animation {
        animation: pulse-animation 0.5s ease-in-out;
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
</style>

<script>
    class CustomerHeaderManager {
        constructor() {
            this.init();
            this.setupNotificationModal();
        }

        init() {
            this.setupMobileSearch();
            this.setupScrollEffect();
            this.setupKeyboardShortcuts();
            this.setupRippleEffect();
        }

        setupNotificationModal() {
            const notificationIcon = document.getElementById('notificationIcon');
            const notificationModal = document.getElementById('notificationModal');
            const closeBtn = document.querySelector('.notification-modal-close');

            if (notificationIcon && notificationModal) {
                // Open notification modal
                notificationIcon.addEventListener('click', () => {
                    notificationModal.style.display = 'block';
                });

                // Close on close button
                if (closeBtn) {
                    closeBtn.addEventListener('click', () => {
                        notificationModal.style.display = 'none';
                    });
                }

                // Close on outside click
                notificationModal.addEventListener('click', (e) => {
                    if (e.target === notificationModal) {
                        notificationModal.style.display = 'none';
                    }
                });

                // Close on escape key
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && notificationModal.style.display === 'block') {
                        notificationModal.style.display = 'none';
                    }
                });
            }
        }

        setupMobileSearch() {
            const searchToggle = document.querySelector('.search-toggle');
            const searchBox = document.querySelector('.search-box');

            if (searchToggle && searchBox) {
                searchToggle.addEventListener('click', () => {
                    searchBox.classList.toggle('mobile-visible');
                    if (searchBox.classList.contains('mobile-visible')) {
                        setTimeout(() => {
                            const input = searchBox.querySelector('input');
                            if (input) input.focus();
                        }, 100);
                    }
                });

                // Close search on outside click
                document.addEventListener('click', (e) => {
                    if (!searchBox.contains(e.target) && !searchToggle.contains(e.target)) {
                        searchBox.classList.remove('mobile-visible');
                    }
                });
            }
        }

        setupScrollEffect() {
            const header = document.querySelector('.header');
            let lastScrollTop = 0;

            if (header) {
                window.addEventListener('scroll', () => {
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    
                    if (scrollTop > 50) {
                        header.classList.add('scrolled');
                    } else {
                        header.classList.remove('scrolled');
                    }

                    lastScrollTop = scrollTop;
                });
            }
        }

        setupKeyboardShortcuts() {
            document.addEventListener('keydown', (e) => {
                // Ctrl+K to focus search
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    const searchInput = document.querySelector('.search-box input');
                    if (searchInput) {
                        searchInput.focus();
                    }
                }
            });
        }

        setupRippleEffect() {
            const buttons = document.querySelectorAll('.header-icon, .toggle-sidebar, .search-toggle');
            
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple');
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });

            // Add CSS for ripple effect
            const style = document.createElement('style');
            style.textContent = `
                .header-icon, .toggle-sidebar, .search-toggle {
                    position: relative;
                    overflow: hidden;
                }
                
                .ripple {
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.6);
                    transform: scale(0);
                    animation: ripple-animation 0.6s linear;
                    pointer-events: none;
                }
                
                @keyframes ripple-animation {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
    }

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', () => {
        new CustomerHeaderManager();
        
        // Add animation for notification badge if there are notifications
        const notificationBadge = document.querySelector('.notification-badge');
        if (notificationBadge) {
            const notificationIcon = document.getElementById('notificationIcon');
            setInterval(function() {
                notificationIcon?.classList.toggle('pulse-animation');
            }, 3000);
        }

        // Add chat button functionality
        const chatButton = document.querySelector('.chat-btn');
        if (chatButton) {
            chatButton.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Redirect to customer chat page
                window.location.href = '{{ route("user.admin-chat.index") }}';
            });
        }

        // Start checking for new admin messages
        startAdminMessageNotificationCheck();

        // Add admin chat button functionality in notifications
        document.addEventListener('click', function(e) {
            // Check for admin chat button
            const adminChatBtn = e.target.closest('.admin-chat-btn');
            if (adminChatBtn) {
                e.preventDefault();
                e.stopPropagation();
                
                // Close notification modal and redirect to admin chat
                const notificationModal = document.getElementById('notificationModal');
                if (notificationModal) {
                    notificationModal.style.display = 'none';
                }
                
                // Redirect to customer admin chat page
                window.location.href = '{{ route("user.admin-chat.index") }}';
                return;
            }
        });

        // Alternative approach - direct event attachment
        setTimeout(() => {
            const adminChatBtns = document.querySelectorAll('.admin-chat-btn');
            adminChatBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Close notification modal
                    const notificationModal = document.getElementById('notificationModal');
                    if (notificationModal) {
                        notificationModal.style.display = 'none';
                    }
                    
                    // Redirect to admin chat
                    window.location.href = '{{ route("user.admin-chat.index") }}';
                });
            });
        }, 500);
    });

    // Function to mark notification as read
    function markNotificationAsRead(notificationId) {
        fetch(`/customer/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                notification_id: notificationId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the notification from the modal
                const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (notificationItem) {
                    notificationItem.style.opacity = '0.5';
                    notificationItem.style.pointerEvents = 'none';
                    
                    // Fade out and remove
                    setTimeout(() => {
                        notificationItem.remove();
                        // Update badge count
                        updateNotificationBadge();
                    }, 300);
                }
            } else {
                console.error('Failed to mark notification as read');
            }
        })
        .catch(error => {
            console.error('Error marking notification as read:', error);
        });
    }

    // Function to update notification badge count
    function updateNotificationBadge() {
        const remainingNotifications = document.querySelectorAll('.notification-item:not([style*="opacity: 0.5"])').length;
        const badge = document.querySelector('.notification-badge');
        
        if (remainingNotifications === 0) {
            if (badge) badge.style.display = 'none';
            
            // Show empty state if modal is open
            const modalBody = document.querySelector('.notification-modal-body');
            if (modalBody && modalBody.querySelector('.notification-empty') === null) {
                modalBody.innerHTML = `
                    <div class="notification-empty">
                        <i class="fas fa-check-circle"></i>
                        <p>No notifications available</p>
                        <p>You're all caught up! No new notifications at this time.</p>
                    </div>
                `;
            }
        } else {
            if (badge) {
                badge.textContent = remainingNotifications;
                badge.style.display = 'inline-block';
            }
        }
    }

    // Function to mark admin message as read
    function markAdminMessageAsRead(messageId) {
        fetch(`/customer/admin-chat/messages/${messageId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                message_id: messageId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the notification from the modal
                const notificationItem = document.querySelector(`[data-message-id="${messageId}"]`);
                if (notificationItem) {
                    notificationItem.style.opacity = '0.5';
                    notificationItem.style.pointerEvents = 'none';
                    
                    // Fade out and remove
                    setTimeout(() => {
                        notificationItem.remove();
                        // Update badge count
                        updateNotificationBadge();
                    }, 300);
                }
            } else {
                console.error('Failed to mark admin message as read');
            }
        })
        .catch(error => {
            console.error('Error marking admin message as read:', error);
        });
    }

    // Function to check for new admin messages
    function startAdminMessageNotificationCheck() {
        // Check every 30 seconds for new admin messages
        setInterval(function() {
            fetch('/customer/admin-chat/unread-count', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.unread_count > 0) {
                    // Update chat badge
                    const chatBadge = document.getElementById('chatUnreadBadge');
                    if (chatBadge) {
                        chatBadge.textContent = data.unread_count;
                        chatBadge.style.display = 'inline-block';
                    }
                    
                    // Update main notification badge
                    updateNotificationBadgeWithAdminMessages(data.unread_count);
                    
                    // Add pulse animation to notification icon
                    const notificationIcon = document.getElementById('notificationIcon');
                    if (notificationIcon) {
                        notificationIcon.classList.add('pulse-animation');
                        setTimeout(() => {
                            notificationIcon.classList.remove('pulse-animation');
                        }, 1000);
                    }
                } else {
                    // Hide chat badge if no unread messages
                    const chatBadge = document.getElementById('chatUnreadBadge');
                    if (chatBadge) {
                        chatBadge.style.display = 'none';
                    }
                }
            })
            .catch(error => {
                console.error('Error checking for new admin messages:', error);
            });
        }, 30000); // Check every 30 seconds
    }

    // Function to update notification badge including admin messages
    function updateNotificationBadgeWithAdminMessages(adminMessageCount) {
        // Get current notification counts from DOM
        const currentNotifications = document.querySelectorAll('.notification-item:not([style*="opacity: 0.5"])').length;
        const totalCount = currentNotifications + (adminMessageCount || 0);
        
        const badge = document.querySelector('.notification-badge');
        if (totalCount > 0) {
            if (badge) {
                badge.textContent = totalCount;
                badge.style.display = 'inline-block';
            }
        } else {
            if (badge) {
                badge.style.display = 'none';
            }
        }
    }
</script>