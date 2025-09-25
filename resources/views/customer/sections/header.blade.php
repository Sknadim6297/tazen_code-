@php
    use Illuminate\Support\Facades\Auth;
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
            <div class="header-actions">
                <!-- Chat Icon -->
                <div class="header-icon chat-icon" id="chatIcon" title="Chat with Admin">
                    <button type="button" class="chat-btn" data-participant-type="admin" data-participant-id="1">
                        <i class="fas fa-comments"></i>
                        <span id="chatUnreadBadge" class="notification-badge" style="display: none;">0</span>
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
        }

        init() {
            this.setupMobileSearch();
            this.setupScrollEffect();
            this.setupKeyboardShortcuts();
            this.setupRippleEffect();
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
    });
</script>