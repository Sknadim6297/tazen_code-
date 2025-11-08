<header class="header clearfix element_to_stick">
    <div class="container-fluid">
        <!-- Fiverr-style header layout -->
        <div class="header-content">
            <!-- Logo Section -->
            <div class="logo-section">
                <a href="{{ url('/') }}" title="Tazen">
                    <img src="{{ asset('frontend/assets/img/tazen_logo-01-removebg-preview.png') }}" width="120" height="auto" alt="Tazen" class="logo">
                </a>
            </div>

            <!-- Search Bar Section -->
            <div class="search-section" id="searchSection">
                <form class="search-form">
                    <div class="search-input-group">
                        <input type="text" class="search-input" placeholder="What service are you looking for today?" autocomplete="off">
                        <button type="submit" class="search-button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>


            <!-- Navigation Section -->
            <div class="nav-section">
                <nav class="main-nav">
                    {{-- <ul class="nav-list">
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Explore</a>
                            <ul class="dropdown-menu explore-dropdown">
                                <li><a class="dropdown-item" href="{{ route('blog.index') }}"><i class="fas fa-blog me-2"></i> Blog</a></li>
                                <li><a class="dropdown-item" href="{{ url('/contact') }}"><i class="fas fa-envelope me-2"></i> Contacts</a></li>
                                <li><a class="dropdown-item" href="{{ url('/about') }}"><i class="fas fa-info-circle me-2"></i> About Us</a></li>
                                <li><a class="dropdown-item" href="{{ route('event.list') }}"><i class="fas fa-calendar-alt me-2"></i> Events</a></li>
                            </ul>
                        </li>
                    </ul> --}}
                </nav>

                <!-- User Section -->
                <div class="user-section">
                    @php
                        $user = Auth::guard('user')->user(); 
                        $professional = Auth::guard('professional')->user();
                        
                        $userName = '';
                        $profilePhoto = 'frontend/assets/img/avatar.jpg';
                        
                        if ($user) {
                            $userName = $user->name;
                            $customerProfile = \App\Models\CustomerProfile::where('user_id', $user->id)->first();
                            if ($customerProfile && $customerProfile->profile_image) {
                                $profilePhoto = $customerProfile->profile_image;
                            } elseif ($user->profile_photo_path) {
                                $profilePhoto = 'uploads/user_images/' . $user->profile_photo_path;
                            }
                        } elseif ($professional) {
                            $userName = $professional->name;
                            $professionalProfile = \App\Models\Profile::where('professional_id', $professional->id)->first();
                            if ($professionalProfile && $professionalProfile->photo) {
                                $profilePhoto = $professionalProfile->photo;
                            }
                        }
                    @endphp

                    @if($user || $professional)
                        <div class="user-menu">
                            <div class="profile-dropdown">
                                <a href="#" class="profile-link" data-bs-toggle="dropdown">
                                    <img src="{{ $user ? ($customerProfile && $customerProfile->profile_image ? asset($customerProfile->profile_image) : asset('frontend/assets/img/avatar.jpg')) : ($professionalProfile && $professionalProfile->photo ? asset('storage/'.$professionalProfile->photo) : asset('frontend/assets/img/avatar.jpg')) }}" alt="{{ $userName }}" class="profile-img">
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-info">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $user ? ($customerProfile && $customerProfile->profile_image ? asset($customerProfile->profile_image) : asset('frontend/assets/img/avatar.jpg')) : ($professionalProfile && $professionalProfile->photo ? asset('storage/'.$professionalProfile->photo) : asset('frontend/assets/img/avatar.jpg')) }}" alt="{{ $userName }}" class="profile-img-sm">
                                            <div class="ms-2">
                                                <span class="fw-bold">{{ $userName }}</span>
                                                <span class="text-muted">{{ $user ? 'Customer' : 'Professional' }}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    @if($user)
                                        <li><a href="{{ route('user.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                                        <li><a href="{{ route('user.profile.index') }}"><i class="fas fa-user-circle me-2"></i> My Profile</a></li>
                                        <li><a href="{{ route('user.all-appointment.index') }}"><i class="fas fa-calendar-check me-2"></i> My Bookings</a></li>
                                    @elseif($professional)
                                        <li><a href="{{ route('professional.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                                        <li><a href="{{ route('professional.profile.index') }}"><i class="fas fa-user-circle me-2"></i> My Profile</a></li>
                                        <li><a href="{{ route('professional.booking.index') }}"><i class="fas fa-calendar-check me-2"></i> My Bookings</a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ $user ? route('user.logout') : route('professional.logout') }}" class="d-inline w-100">
                                            @csrf
                                            <button type="submit" class="logout-btn">
                                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @else
                        <div class="auth-buttons">
                            
                            <a href="{{ route('login') }}" class="btn-signin">Customer Login</a>
                            <a href="{{ route('professional.login') }}" class="btn-join">Professional Login</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Category Navigation Bar -->
        <div class="category-nav" id="categoryNav">
            <div class="category-container">
                <ul class="category-list" id="categoryList">
                    <li class="category-item trending">
                        <a href="{{ route('gridlisting') }}" class="category-link">
                            <i class="fas fa-fire"></i>
                            <span>Trending</span>
                        </a>
                        <!-- Proper Dropdown -->
                        <div class="mega-dropdown">
                            <div class="dropdown-header">
                                <h3>Trending Services</h3>
                                <p>Most popular services right now</p>
                            </div>
                            <div class="dropdown-columns">
                                @php
                                    // Get first 10 sub-services across all services for trending
                                    $trending_subservices = \App\Models\SubService::with('service')
                                        ->take(10)
                                        ->get()
                                        ->chunk(5);
                                @endphp
                                @foreach($trending_subservices as $chunk)
                                <div class="dropdown-column">
                                    <h4>{{ $loop->first ? 'Popular Services' : 'More Services' }}</h4>
                                    <ul>
                                        @foreach($chunk as $subService)
                                        <li>
                                            <a href="{{ route('service.show', $subService->service?->slug) }}">{{ $subService->name }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </li>
                    
                    @php
                        // Fetch active headers with their features and services
                        $activeHeaders = \App\Models\Header::where('status', 'active')
                            ->with(['features.services'])
                            ->latest()
                            ->get();
                    @endphp
                    
                    @foreach($activeHeaders as $header)
                    <li class="category-item">
                        <a href="{{ route('gridlisting') }}" class="category-link">
                            <span>{{ $header->tagline }}</span>
                        </a>
                    
                        <!-- Multi-Column Dropdown Menu -->
                        <div class="mega-dropdown">
                            <div class="dropdown-columns">
                                @foreach($header->features as $feature)
                                <div class="dropdown-column">
                                    <h4>{{ $feature->feature_heading }}</h4>
                                    <ul>
                                        @if($feature->services->count() > 0)
                                            @foreach($feature->services as $service)
                                            <li>
                                                <a href="{{ route('service.show', $service->slug) }}">{{ $service->name }}</a>
                                            </li>
                                            @endforeach
                                        @else
                                            <li><span style="padding: 4px 0; color: #74767e; font-size: 13px;">No services available</span></li>
                                        @endif
                                    </ul>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </li>
                    @endforeach
                    @if(false)
                        <!-- FALLBACK: Add static services if database is empty -->
                        <li class="category-item">
                            <a href="#" class="category-link">
                                <span>Web Development</span>
                            </a>
                            <div class="mega-dropdown">
                                <div class="dropdown-header">
                                    <h3>Web Development</h3>
                                    <p>Professional web development services</p>
                                </div>
                                <div class="dropdown-columns">
                                    <div class="dropdown-column">
                                        <h4>Popular Services</h4>
                                        <ul>
                                            <li><a href="#">Web Design</a></li>
                                            <li><a href="#">Logo Design</a></li>
                                            <li><a href="#">Content Writing</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="category-item">
                            <a href="#" class="category-link">
                                <span>Design</span>
                            </a>
                            <div class="mega-dropdown">
                                <div class="dropdown-header">
                                    <h3>Design</h3>
                                    <p>Creative design services</p>
                                </div>
                                <div class="dropdown-columns">
                                    <div class="dropdown-column">
                                        <h4>Popular Services</h4>
                                        <ul>
                                            <li><a href="#">Logo Design</a></li>
                                            <li><a href="#">Web Design</a></li>
                                            <li><a href="#">Graphic Design</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                    <li class="category-item more">
                        <a href="{{ route('gridlisting') }}" class="category-link">
                            <span>More</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
                <div class="scroll-arrow left" id="scrollLeft">
                    <i class="fas fa-chevron-left"></i>
                </div>
                <div class="scroll-arrow right" id="scrollRight">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
        </div>

        
        <style>
            /* Fiverr-style header CSS */
            .header {
                background: #fff;
                border-bottom: 1px solid #e4e5e7;
                padding: 0;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                width: 100%;
                z-index: 1000;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                transition: all 0.3s ease;
            }

            .header-content {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 16px 32px;
                max-width: 1400px;
                margin: 0 auto;
                min-height: 70px;
            }

            /* Add padding to body to account for fixed header */
            body {
                padding-top: 120px;
            }

            /* Category Navigation Bar */
            .category-nav {
                background: #fff;
                border-bottom: 1px solid #e4e5e7;
                position: fixed;
                top: 85px;
                left: 0;
                right: 0;
                width: 100%;
                z-index: 999;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
                transition: all 0.3s ease;
                overflow: visible !important;
            }

            .category-container {
                max-width: 1400px;
                margin: 0 auto;
                padding: 0 32px;
                padding-right: 50px;
                overflow: visible !important;
                position: relative;
            }

            .category-list {
                display: flex;
                list-style: none;
                margin: 0;
                padding: 0;
                align-items: center;
                overflow-x: auto;
                overflow-y: visible !important;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }

            .category-list::-webkit-scrollbar {
                display: none;
            }

            /* Scroll Arrows for Category Nav */
            .scroll-arrow {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                background: #fff;
                padding: 10px 12px;
                border: 1px solid #e4e5e7;
                border-radius: 4px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                cursor: pointer;
                z-index: 1000;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #333;
                font-size: 16px;
                transition: all 0.3s ease;
                width: 40px;
                height: 40px;
            }

            .scroll-arrow:hover {
                background-color: #f8f9fa;
                border-color: #1dbf73;
                color: #1dbf73;
            }

            .scroll-arrow.left {
                left: 10px;
            }

            .scroll-arrow.right {
                right: 10px;
            }

            .category-item {
                flex-shrink: 0;
                white-space: nowrap;
                position: relative !important;
                overflow: visible !important;
            }

            .category-link {
                display: flex;
                align-items: center;
                gap: 6px;
                padding: 12px 16px;
                color: #283a85;
                text-decoration: none;
                font-size: 14px;
                font-weight: 500;
                transition: all 0.2s ease;
                border-radius: 4px;
                margin: 4px 0;
            }

            .category-link:hover {
                background: #f5f5f5;
                color: #101110;
            }

            .category-item.trending .category-link {
                color: #ff6b35;
                font-weight: 600;
            }

            .category-item.trending .category-link:hover {
                background: #fff5f2;
                color: #ff6b35;
            }

            .category-item.more .category-link {
                color: #74767e;
                font-weight: 500;
            }

            .category-item.more .category-link:hover {
                background: #f5f5f5;
                color: #404145;
            }

            .category-link i {
                font-size: 12px;
            }

            .category-item.trending .category-link i {
                color: #ff6b35;
            }

            /* Logo Section */
            .logo-section {
                flex: 0 0 auto;
                margin-bottom: 8px;
            }

            .logo {
                height: 50px;
                width: auto;
            }

            /* Search Section */
            .search-section {
                flex: 1;
                max-width: 600px;
                margin: 0 32px;
                padding: 0 8px;
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
                transition: all 0.3s ease;
            }

            .search-form {
                width: 100%;
            }

            .search-input-group {
                position: relative;
                display: flex;
                background: #fff;
                border: 1px solid #e4e5e7;
                border-radius: 4px;
                overflow: hidden;
            }

            .search-input {
                flex: 1;
                padding: 14px 18px;
                border: none;
                outline: none;
                font-size: 16px;
                background: transparent;
                line-height: 1.4;
            }

            .search-input::placeholder {
                color: #74767e;
                font-size: 15px;
            }

            .search-button {
                background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
                border: none;
                padding: 14px 24px;
                color: white;
                cursor: pointer;
                transition: all 0.2s;
                font-size: 16px;
            }

            .search-button:hover {
                background: linear-gradient(135deg, #1a3585, #e01515, #ffa726);
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            }

            /* Navigation Section */
            .nav-section {
                display: flex;
                align-items: center;
                gap: 24px;
                padding: 0 8px;
            }

            .main-nav {
                display: flex;
                align-items: center;
            }

            .nav-list {
                display: flex;
                list-style: none;
                margin: 0;
                padding: 0;
                gap: 24px;
            }

            .nav-item {
                position: relative;
            }

            .nav-link {
                color: #404145;
                text-decoration: none;
                font-weight: 500;
                font-size: 14px;
                padding: 10px 0;
                transition: color 0.2s;
                display: flex;
                align-items: center;
                gap: 4px;
                line-height: 1.4;
            }

            .nav-link:hover {
                color: #1dbf73;
            }

            .nav-link i {
                font-size: 12px;
            }

            /* Explore Dropdown Menu */
            .explore-dropdown {
                min-width: 200px;
                padding: 8px 0;
                margin-top: 8px;
                border: 1px solid #e4e5e7;
                border-radius: 4px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            }

            .explore-dropdown .dropdown-item {
                padding: 10px 20px;
                color: #404145;
                font-size: 14px;
                font-weight: 500;
                transition: all 0.2s;
                display: flex;
                align-items: center;
            }

            .explore-dropdown .dropdown-item:hover {
                background: #f5f5f5;
                color: #1dbf73;
            }

            .explore-dropdown .dropdown-item i {
                font-size: 14px;
                width: 20px;
            }

            /* User Section */
            .user-section {
                display: flex;
                align-items: center;
                padding: 0 8px;
            }

            .auth-buttons {
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .btn-signin {
                color: #283a85;
                text-decoration: none;
                font-weight: 500;
                padding: 10px 18px;
                border-radius: 4px;
                transition: background 0.2s;
                font-size: 14px;
                line-height: 1.4;
            }

            .btn-signin:hover {
                background: #f5f5f5;
                color: #404145;
            }

            .btn-join {
                background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
                color: white;
                text-decoration: none;
                font-weight: 500;
                padding: 10px 18px;
                border-radius: 4px;
                border: none;
                transition: all 0.2s;
                font-size: 14px;
                line-height: 1.4;
            }

            .btn-join:hover {
                background: linear-gradient(135deg, #1a3585, #e01515, #ffa726);
                color: white;
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            }

            /* Profile Dropdown */
            .profile-dropdown {
                position: relative;
            }

            .profile-link {
                display: flex;
                align-items: center;
            }

            .profile-img {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #e4e5e7;
            }

            .profile-img-sm {
                width: 24px;
                height: 24px;
                border-radius: 50%;
                object-fit: cover;
            }

            .dropdown-menu {
                position: absolute;
                top: 100%;
                right: 0;
                background: white;
                border: 1px solid #e4e5e7;
                border-radius: 4px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                min-width: 200px;
                padding: 8px 0;
                margin-top: 8px;
                z-index: 1000;
                display: none;
            }

            .profile-dropdown:hover .dropdown-menu {
                display: block;
            }

            /* NEW APPROACH - Simple Dropdown */
            .category-item {
                position: relative;
            }

            /* Dropdown Container */
            .mega-dropdown {
                position: fixed;
                background: white;
                border: 1px solid #e4e5e7;
                border-radius: 6px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                width: auto;
                max-width: 800px;
                min-width: 350px;
                padding: 20px;
                margin-top: -40px;
                z-index: 10000;
                opacity: 0;
                visibility: hidden;
                transform: translateY(-10px);
                transition: all 0.3s ease;
                pointer-events: none;
                box-sizing: border-box;
            }

            /* Show dropdown on hover */
            .category-item:hover .mega-dropdown {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
                pointer-events: auto;
            }


            /* Dropdown Header */
            .dropdown-header {
                margin-bottom: 15px;
                padding-bottom: 10px;
                border-bottom: 1px solid #f0f0f0;
            }

            .dropdown-header h3 {
                margin: 0 0 3px 0;
                font-size: 16px;
                font-weight: 600;
                color: #404145;
            }

            .dropdown-header p {
                margin: 0;
                font-size: 13px;
                color: #74767e;
            }

            /* Dropdown Columns */
            .dropdown-columns {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
                margin-bottom: 0;
            }
            
            .dropdown-column {
                min-width: 180px;
            }

            .dropdown-column h4 {
                margin: 0 0 8px 0;
                font-size: 13px;
                font-weight: 600;
                color: #404145;
                text-transform: uppercase;
                letter-spacing: 0.3px;
                padding-bottom: 5px;
                border-bottom: 2px solid #f39c12;
            }

            .dropdown-column ul {
                list-style: none;
                margin: 0;
                padding: 0;
                max-height: 400px;
                overflow-y: auto;
            }
            
            .dropdown-column ul::-webkit-scrollbar {
                width: 6px;
            }
            
            .dropdown-column ul::-webkit-scrollbar-thumb {
                background: #ddd;
                border-radius: 3px;
            }
            
            .dropdown-column ul::-webkit-scrollbar-thumb:hover {
                background: #bbb;
            }

            .dropdown-column li {
                margin-bottom: 6px;
            }

            .dropdown-column a {
                display: block;
                padding: 4px 0;
                color: #404145;
                text-decoration: none;
                font-size: 13px;
                font-weight: 500;
                transition: all 0.2s ease;
                border-radius: 3px;
            }

            .dropdown-column a:hover {
                color: white;
                background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
                padding-left: 6px;
            }

            /* Dropdown Footer */
            .dropdown-footer {
                display: none;
            }

            .view-all-btn {
                display: none;
            }

            /* Responsive Design */
            @media (max-width: 1200px) {
                .category-item .mega-dropdown {
                    min-width: 350px;
                    max-width: 450px;
                }
                
                .dropdown-columns {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 12px;
                }
            }

            @media (max-width: 768px) {
                .category-item .mega-dropdown {
                    position: absolute;
                    top: 100%;
                    left: 0;
                    width: 85vw !important;
                    max-width: 85vw !important;
                    min-width: 85vw !important;
                    transform: none;
                    border-radius: 6px;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                    border: 1px solid #e4e5e7;
                    opacity: 0;
                    visibility: hidden;
                    display: none;
                    padding: 15px !important;
                    margin-top: 2px;
                    box-sizing: border-box !important;
                }
                
                body .category-item.active .mega-dropdown {
                    opacity: 1 !important;
                    visibility: visible !important;
                    display: block !important;
                    position: fixed !important;
                    top: 38px !important;
                    left: 50% !important;
                    transform: translateX(-50%) !important;
                    pointer-events: auto !important;
                    z-index: 99999 !important;
                    background: white !important;
                    border: 1px solid #e4e5e7 !important;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
                    box-sizing: border-box !important;
                    overflow: hidden !important;
                    word-wrap: break-word !important;
                    width: 85vw !important;
                    max-width: 85vw !important;
                    min-width: 85vw !important;
                }
                
                .dropdown-columns {
                    grid-template-columns: 1fr !important; /* Single column on mobile */
                    gap: 12px !important;
                    display: block !important;
                }
                
                .dropdown-column {
                    width: 100% !important;
                    min-width: 100% !important;
                    max-width: 100% !important;
                    margin-bottom: 0 !important;
                    box-sizing: border-box !important;
                }
                
                .dropdown-column h4 {
                    font-size: 13px !important;
                    margin-bottom: 8px !important;
                    padding-bottom: 5px !important;
                    word-wrap: break-word !important;
                    overflow-wrap: break-word !important;
                }
                
                .dropdown-column a {
                    font-size: 13px !important;
                    padding: 6px 0 !important;
                    line-height: 1.4 !important;
                    word-wrap: break-word !important;
                    overflow-wrap: break-word !important;
                    display: block !important;
                    width: 100% !important;
                    box-sizing: border-box !important;
                }
                
                .dropdown-column li {
                    margin-bottom: 4px !important;
                    width: 100% !important;
                    overflow: hidden !important;
                    word-wrap: break-word !important;
                }
                
                .dropdown-column ul {
                    max-height: 300px !important;
                    overflow-y: auto !important;
                    width: 100% !important;
                    box-sizing: border-box !important;
                }
                
                .dropdown-column span {
                    word-wrap: break-word !important;
                    overflow-wrap: break-word !important;
                    display: block !important;
                    width: 100% !important;
                    box-sizing: border-box !important;
                }
                
                .dropdown-header {
                    margin-bottom: 12px !important;
                    padding-bottom: 8px !important;
                }
                
                .dropdown-header h3 {
                    font-size: 15px !important;
                    margin-bottom: 4px !important;
                }
                
                .dropdown-header p {
                    font-size: 12px !important;
                }
            }

            .dropdown-menu li {
                list-style: none;
            }

            .dropdown-menu a {
                display: block;
                padding: 8px 16px;
                color: #404145;
                text-decoration: none;
                font-size: 14px;
                transition: background 0.2s;
            }

            .dropdown-menu a:hover {
                background: #f5f5f5;
            }

            .user-info {
                padding: 12px 16px;
                background: #f8f9fa;
                border-bottom: 1px solid #e4e5e7;
            }

            .logout-btn {
                background: none;
                border: none;
                width: 100%;
                text-align: left;
                padding: 8px 16px;
                color: #dc3545;
                cursor: pointer;
                font-size: 14px;
            }

            .logout-btn:hover {
                background: #f8d7da;
            }


            /* Tablet and smaller screens */
            @media (max-width: 1024px) {
                .header-content {
                    max-width: 100%;
                    padding: 16px 24px;
                }

                .category-container {
                    max-width: 100%;
                    padding: 0 24px;
                    padding-right: 50px;
                }

                .search-section {
                    max-width: 500px;
                }
            }

            /* Mobile Responsive */
            @media (max-width: 768px) {
                .header-content {
                    flex-direction: row;
                    padding: 12px 15px;
                    min-height: 60px;
                    max-width: 100%;
                    gap: 0;
                    justify-content: space-between;
                    align-items: center;
                }

                /* Logo section */
                .logo-section {
                    order: 1;
                    flex: 0 0 auto;
                    margin-bottom: 0;
                }

                .logo {
                    height: 35px;
                }

                /* Search section - hide on mobile or make smaller */
                .search-section {
                    order: 2;
                    flex: 1;
                    margin: 0 10px;
                    max-width: none;
                    display: none; /* Hide search on mobile to save space */
                }

                /* Navigation section - always show on mobile */
                .nav-section {
                    order: 3;
                    display: flex !important;
                    align-items: center;
                    gap: 8px;
                    padding: 0;
                }

                /* Ensure nav-section is visible even when user-menu is present */
                .nav-section {
                    display: flex !important;
                }

                /* User section - ensure login buttons are visible */
                .user-section {
                    display: flex !important;
                    align-items: center;
                    gap: 8px;
                }

                /* Auth buttons styling for mobile */
                .auth-buttons {
                    display: flex !important;
                    align-items: center;
                    gap: 6px;
                    visibility: visible !important;
                    opacity: 1 !important;
                }

                .btn-signin, .btn-join {
                    padding: 8px 12px;
                    font-size: 12px;
                    white-space: nowrap;
                    border-radius: 4px;
                    text-decoration: none;
                    display: inline-block;
                    text-align: center;
                }

                .btn-signin {
                    background: transparent;
                    color: #404145;
                    border: 1px solid #e4e5e7;
                }

                .btn-join {
                    background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
                    color: white;
                    border: none;
                }

                /* Adjust body padding for mobile */
                body {
                    padding-top: 100px;
                }

                /* Category bar mobile styles */
                .category-nav {
                    top: 56px;
                    opacity: 1 !important;
                    visibility: visible !important;
                    transform: translateY(0) !important;
                }

                .category-container {
                    padding: 0 15px;
                    padding-right: 40px;
                }

                .category-link {
                    padding: 8px 10px;
                    font-size: 12px;
                }

                /* Show all category text in mobile */
                .category-link span {
                    display: inline;
                }

                /* Scroll arrow adjustments */
                .scroll-arrow {
                    width: 35px;
                    height: 35px;
                    font-size: 12px;
                }

                .scroll-arrow.right {
                    right: 8px;
                }
            }

            @media (max-width: 480px) {
                .header-content {
                    padding: 8px 12px;
                    min-height: 55px;
                    gap: 0;
                }

                .logo {
                    height: 30px;
                }

                /* Navigation section adjustments for very small screens */
                .nav-section {
                    gap: 4px;
                }

                /* Auth buttons for very small screens */
                .auth-buttons {
                    gap: 4px;
                }

                .btn-signin, .btn-join {
                    padding: 6px 8px;
                    font-size: 11px;
                    white-space: nowrap;
                    border-radius: 3px;
                }

                /* Ensure buttons are still visible and clickable */
                .btn-signin {
                    min-width: 60px;
                }

                .btn-join {
                    min-width: 80px;
                }

                /* Adjust body padding for small mobile */
                body {
                    padding-top: 90px;
                }

                /* Category bar mobile styles */
                .category-nav {
                    top: 56px;
                    opacity: 1 !important;
                    visibility: visible !important;
                    transform: translateY(0) !important;
                }

                .category-container {
                    padding: 0 12px;
                    padding-right: 35px;
                }

                .category-link {
                    padding: 6px 8px;
                    font-size: 11px;
                }

                .scroll-arrow {
                    width: 30px;
                    height: 30px;
                    font-size: 10px;
                    right: 6px;
                }

                /* Show all category text in mobile */
                .category-link span {
                    display: inline;
                }

                /* Hide the "More" button in mobile */
                .category-item.more {
                    display: none;
                }
            }
        </style>
        
        <!-- /top_menu -->
        {{-- <a href="#0" class="open_close">
            <i class="icon_menu"></i><span>Menu</span>
        </a> --}}
        <nav class="main-menu">
            <div id="header_menu">
                <a href="#0" class="open_close">
                    <i class="icon_close"></i><span>Menu</span>
                </a>
                <a href="{{ url('/') }}"><img src="{{ asset('frontend/assets/img/tazen_logo-01-removebg-preview.png') }}" width="120" height="auto" alt=""></a>
            </div>
            <ul>
                <!-- <li class="submenu">
                <a href="#0" class="show-submenu">Home</a>
                <ul>
                    <li><a href="index-2.html">Default</a></li>
                    <li><a href="index-3.html">Video Background</a></li>
                    <li><a href="index-4.html">Slider</a></li>
                    <li><a href="index-6.html">GDPR Cookie Bar EU Law</a></li>
                    <li><a href="index-5.html">Full Screen</a></li>
                    <li><a href="user-logged-1.html">User Logged</a></li>
                </ul>
            </li> -->



            


                <!-- <li class="submenu">
                <a href="#0" class="show-submenu">Other Pages</a>
                <ul>
                    <li><a href="admin_section/index.html">Admin Dashboard</a></li>
                    <li><a href="404.html">404 Error</a></li>
                    <li><a href="help.html">Help and Faq</a></li>
                    <li><a href="modal-login.html">Modal Login</a></li>
                    <li><a href="modal-popup.html">Modal Advertise</a></li>
                    <li><a href="modal-newsletter.html">Modal Newsletter</a></li>
                    <li><a href="pricing-tables-1.html">Pricing Tables 1</a></li>
                    <li><a href="pricing-tables-2.html">Pricing Tables 2</a></li>
                    <li><a href="blog.html">Blog</a></li>
                    <li><a href="contacts.html">Contacts</a></li>
                    <li><a href="coming_soon/index.html" target="_blank">Coming Soon</a></li>
                    <li><a href="login.html">Login</a></li>
                    <li><a href="register.html">Register</a></li>
                    <li><a href="icon-pack-1.html">Icon Pack 1</a></li>
                </ul>
            </li>
             -->
            </ul>
        </nav>

    </div>
   
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Wait a bit for elements to be fully rendered
    setTimeout(function() {
        // Category scroll functionality
        const categoryList = document.getElementById('categoryList');
        const scrollLeft = document.getElementById('scrollLeft');
        const scrollRight = document.getElementById('scrollRight');
        
        console.log('Category List:', categoryList);
        console.log('Scroll Left:', scrollLeft);
        console.log('Scroll Right:', scrollRight);
        
        function updateArrowVisibility() {
            if (!categoryList || !scrollLeft || !scrollRight) return;
            
            const currentScroll = categoryList.scrollLeft;
            const maxScroll = categoryList.scrollWidth - categoryList.clientWidth;
            
            // Show/hide arrows based on scroll position
            if (currentScroll <= 0) {
                scrollLeft.style.display = 'none';
            } else {
                scrollLeft.style.display = 'flex';
            }
            
            if (currentScroll >= maxScroll - 1) { // Small tolerance for rounding
                scrollRight.style.display = 'none';
            } else {
                scrollRight.style.display = 'flex';
            }
        }
        
        if (categoryList && scrollLeft && scrollRight) {
            // Left scroll functionality
            scrollLeft.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Scroll left clicked');
                
                const categoryItems = categoryList.querySelectorAll('.category-item');
                if (categoryItems.length > 0) {
                    const itemWidth = categoryItems[0].offsetWidth;
                    const currentScroll = categoryList.scrollLeft;
                    
                    const newScroll = Math.max(currentScroll - itemWidth, 0);
                    
                    console.log('Scrolling left to:', newScroll);
                    
                    categoryList.scrollTo({
                        left: newScroll,
                        behavior: 'smooth'
                    });
                    
                    // Update arrow visibility after scroll
                    setTimeout(updateArrowVisibility, 300);
                }
            });
            
            // Right scroll functionality
            scrollRight.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Scroll right clicked');
                
                const categoryItems = categoryList.querySelectorAll('.category-item');
                if (categoryItems.length > 0) {
                    const itemWidth = categoryItems[0].offsetWidth;
                    const currentScroll = categoryList.scrollLeft;
                    const maxScroll = categoryList.scrollWidth - categoryList.clientWidth;
                    
                    const newScroll = Math.min(currentScroll + itemWidth, maxScroll);
                    
                    console.log('Scrolling right to:', newScroll);
                    
                    categoryList.scrollTo({
                        left: newScroll,
                        behavior: 'smooth'
                    });
                    
                    // Update arrow visibility after scroll
                    setTimeout(updateArrowVisibility, 300);
                }
            });
            
            // Update arrow visibility on scroll
            categoryList.addEventListener('scroll', updateArrowVisibility);
            
            // Initial arrow visibility
            updateArrowVisibility();
            
        } else {
            console.log('Elements not found:', {
                categoryList: !!categoryList,
                scrollLeft: !!scrollLeft,
                scrollRight: !!scrollRight
            });
        }
    }, 100);

    // Search bar and category nav are now always visible
    // Removed scroll functionality as elements should be visible from the start

    // Position dropdowns below their category items
    function positionDropdowns() {
        const categoryItems = document.querySelectorAll('.category-item');
        const viewportWidth = document.documentElement.clientWidth;
        const isMobile = viewportWidth <= 768;
        
        // Skip completely for mobile - let CSS handle everything
        if (isMobile) {
            return;
        }
        
        const padding = 40;
        const dropdownWidth = 300;
        
        categoryItems.forEach((item, index) => {
            const dropdown = item.querySelector('.mega-dropdown');
            if (dropdown) {
                const rect = item.getBoundingClientRect();
                
                // Set desktop width
                dropdown.style.width = dropdownWidth + 'px';
                dropdown.style.maxWidth = dropdownWidth + 'px';
                dropdown.style.minWidth = dropdownWidth + 'px';
                
                // Calculate left position starting from category left edge
                let leftPos = rect.left;
                
                // For the last 2 categories, shift left more aggressively
                const totalItems = categoryItems.length;
                const isLastTwoCategories = index >= totalItems - 2;
                
                if (isLastTwoCategories) {
                    // Shift left by an additional 100px for last 2 categories
                    leftPos = rect.left - 100;
                }
                
                // If dropdown would overflow right edge, shift it left
                const wouldOverflow = leftPos + dropdownWidth > viewportWidth - padding;
                
                if (wouldOverflow) {
                    // Position so right edge is at viewport right minus padding
                    leftPos = viewportWidth - dropdownWidth - padding;
                }
                
                // Ensure not too far left
                leftPos = Math.max(padding, leftPos);
                
                // Desktop positioning with user's custom adjustment
                dropdown.style.top = (rect.bottom - 40) + 'px';
                dropdown.style.left = leftPos + 'px';
                dropdown.style.right = 'auto';
                dropdown.style.position = 'fixed';
            }
        });
    }

    // Position on load
    positionDropdowns();

    // Reposition on scroll and resize
    window.addEventListener('scroll', positionDropdowns);
    window.addEventListener('resize', positionDropdowns);
    
    // Reposition when category list scrolls
    const categoryList = document.getElementById('categoryList');
    if (categoryList) {
        categoryList.addEventListener('scroll', positionDropdowns);
    }

    // Mobile dropdown functionality
    function setupMobileDropdowns() {
        const isMobile = window.innerWidth <= 768;
        const categoryItems = document.querySelectorAll('.category-item');
        
        if (isMobile) {
            console.log('Setting up mobile dropdowns');
            
            categoryItems.forEach((item, index) => {
                const categoryLink = item.querySelector('.category-link');
                const dropdown = item.querySelector('.mega-dropdown');
                
                if (categoryLink && dropdown) {
                    // Remove existing event listeners by cloning the link
                    const newLink = categoryLink.cloneNode(true);
                    categoryLink.parentNode.replaceChild(newLink, categoryLink);
                    
                    // Add click event listener
                    newLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        console.log('Mobile dropdown clicked:', index);
                        
                        // Close all other dropdowns
                        categoryItems.forEach(otherItem => {
                            if (otherItem !== item) {
                                otherItem.classList.remove('active');
                            }
                        });
                        
                        // Clear any conflicting inline styles for mobile positioning
                        dropdown.style.position = '';
                        dropdown.style.top = '';
                        dropdown.style.left = '';
                        dropdown.style.right = '';
                        dropdown.style.width = '';
                        dropdown.style.maxWidth = '';
                        dropdown.style.minWidth = '';
                        
                        // Toggle current dropdown
                        item.classList.toggle('active');
                        
                        console.log('Mobile dropdown toggled:', item.classList.contains('active'));
                    });
                }
            });
            
            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.category-item')) {
                    categoryItems.forEach(item => {
                        item.classList.remove('active');
                    });
                }
            });
        } else {
            // Desktop hover behavior - remove mobile click handlers
            categoryItems.forEach((item) => {
                const categoryLink = item.querySelector('.category-link');
                if (categoryLink) {
                    // Remove any existing event listeners
                    const newLink = categoryLink.cloneNode(true);
                    categoryLink.parentNode.replaceChild(newLink, categoryLink);
                }
            });
        }
    }

    // Setup mobile dropdowns on load and resize
    setupMobileDropdowns();
    window.addEventListener('resize', function() {
        setTimeout(setupMobileDropdowns, 100);
    });

});
</script>