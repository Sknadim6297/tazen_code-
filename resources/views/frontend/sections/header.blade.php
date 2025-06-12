<header class="header clearfix element_to_stick">
    <div class="container-fluid">
        <div id="logo">
            <a href="{{ url('/') }}" title="Tazen">
                <img src="{{ asset('frontend/assets/img/tazen_logo-01-removebg-preview.png') }}" width="150" height="auto" alt="" class="logo_normal">
                <img src="{{ asset('frontend/assets/img/tazen_logo-01-removebg-preview.png') }}" width="150" height="auto" alt="" class="logo_sticky">
            </a>
        </div>
        <ul id="top_menu">
            @php
                $user = Auth::guard('user')->user(); 
                $professional = Auth::guard('professional')->user();
                
                // Get profile photo based on user type
                $profilePhoto = 'frontend/assets/img/avatar.jpg'; 
                $userName = '';
                
                if ($user) {
                    $userName = $user->name;
                    // Check if user has a customer profile with photo
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
                        $profilePhoto =$professionalProfile->photo;
                    }
                }
            @endphp
        
            @if($user || $professional)
                <li class="dropdown profile-dropdown">
                    <a href="#" class="dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="profile-photo">
                            <img src="{{ asset($profilePhoto) }}" alt="{{ $userName }}" 
                                 onerror="this.onerror=null; this.src='{{ asset('frontend/assets/img/avatar.jpg') }}'">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li class="dropdown-item user-info">
                            <div class="d-flex align-items-center">
                                <div class="profile-photo-sm">
                                    <img src="{{ asset($profilePhoto) }}" alt="{{ $userName }}" 
                                         onerror="this.onerror=null; this.src='{{ asset('frontend/assets/img/avatar.jpg') }}'">
                                </div>
                                <div class="ms-2">
                                    <span class="d-block fw-bold">{{ $userName }}</span>
                                    <span class="small text-muted">{{ $user ? 'Customer' : 'Professional' }}</span>
                                </div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @if($user)
                            <li><a class="dropdown-item" href="{{ route('user.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.profile.index') }}"><i class="fas fa-user-circle me-2"></i> My Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.all-appointment.index') }}"><i class="fas fa-calendar-check me-2"></i> My Bookings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('user.logout') }}" class="d-inline w-100">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        @elseif($professional)
                            <li><a class="dropdown-item" href="{{ route('professional.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('professional.profile.index') }}"><i class="fas fa-user-circle me-2"></i> My Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('professional.booking.index') }}"><i class="fas fa-calendar-check me-2"></i> My Bookings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('professional.logout') }}" class="d-inline w-100">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        @endif
                    </ul>
                </li>
            @else
                <li class="d-flex align-items-center gap-2">
                    <a href="{{ route('login') }}" class="btn_access">Log In</a>
                    <a href="{{ route('professional.login') }}" class="btn_access green"><i class="fa-solid fa-user-plus"></i> Join as a Professional</a>
                </li>
            @endif
        </ul>
        
        <style>
            /* Profile dropdown styles */
            .profile-dropdown {
                position: relative;
            }
            
            .profile-photo {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                overflow: hidden;
                border: 2px solid #fff;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                cursor: pointer;
                transition: all 0.3s ease;
            }
            
            .profile-photo img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            
            .profile-photo-sm {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                overflow: hidden;
            }
            
            .profile-photo-sm img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            
            .profile-dropdown .dropdown-menu {
                padding: 0.5rem 0;
                min-width: 240px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                border: none;
                border-radius: 8px;
            }
            
            .profile-dropdown .dropdown-menu .user-info {
                padding: 0.75rem 1rem;
                background: #f8f9fa;
            }
            
            .profile-dropdown .dropdown-item {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }
            
            .profile-dropdown .dropdown-item:active,
            .profile-dropdown .dropdown-item:focus {
                background-color: #e9ecef;
                color: #212529;
            }
            
            .profile-dropdown .dropdown-item.text-danger:hover {
                background-color: #f8d7da;
            }
            
            .profile-dropdown .dropdown-item i {
                width: 20px;
                text-align: center;
            }
            
            .profile-dropdown .dropdown-toggle::after {
                display: none;
            }
            
            .profile-dropdown .profile-photo:hover {
                transform: scale(1.05);
                box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            }

            @media (max-width: 767px) {
                #top_menu {
                    display: flex;
                    flex-direction: row; /* Changed from column to row */
                    align-items: center;
                    justify-content: flex-end; /* Align right side */
                    padding: 10px;
                }
                
                /* Make profile dropdown more visible on mobile */
                .profile-dropdown {
                    width: auto !important;
                    margin-left: auto;
                    margin-right: 15px; /* Add some margin */
                    position: relative;
                    display: block !important; /* Ensure it's displayed */
                    z-index: 1050; /* Ensure it appears above other elements */
                }
                
                .profile-photo {
                    width: 38px;
                    height: 38px;
                    border: 2px solid #007bff; /* Blue border to make it more visible */
                }
                
                /* Fix dropdown menu positioning on mobile */
                .profile-dropdown .dropdown-menu {
                    position: absolute !important;
                    right: 0 !important;
                    left: auto !important;
                    top: 45px !important;
                    width: 230px;
                    transform: none !important;
                }
                
                /* Login buttons styling for mobile */
                #top_menu li:not(.profile-dropdown) {
                    width: 100%;
                }
                
                #top_menu .btn_access {
                    width: 100%;
                    text-align: center;
                    padding: 8px 15px;
                    font-size: 14px;
                    margin-bottom: 5px;
                }
                
                #top_menu .btn_access i {
                    margin-right: 5px;
                }
                
                /* Mobile menu service items styling */
                .main-menu ul li.submenu ul li {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    padding: 8px 15px;
                }

                .main-menu ul li.submenu ul li img {
                    width: 38px;
                    height: 49px;
                    object-fit: contain;
                    margin: 0;
                }

                .main-menu ul li.submenu ul li a {
                    margin: 0;
                    padding: 0;
                    font-size: 14px;
                }
                
                /* Ensure navigation toggle is still visible */
                .open_close {
                    position: relative;
                    z-index: 1051;
                }
            }

            /* Tablet styling adjustments */
            @media only screen and (min-width: 768px) and (max-width: 1024px) {
                #top_menu {
                    display: flex;
                    align-items: center;
                    justify-content: flex-end;
                    padding: 10px;
                }
                
                .profile-dropdown {
                    width: auto !important;
                    margin-left: auto;
                    margin-right: 15px;
                }
                
                #top_menu li.d-flex {
                    gap: 10px;
                }
                
                .btn-custom-logout {
                    padding: 8px 15px;
                    transition: all 0.3s ease;
                }
                
                .btn-custom-logout:hover {
                    background: #e9ecef !important;
                }
            }
            
        </style>
        
        <!-- /top_menu -->
        <a href="#0" class="open_close">
            <i class="icon_menu"></i><span>Menu</span>
        </a>
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

           @php
    use App\Models\Service;

    $dropdown_services = Service::all();

    $icons = [
        1 => 'work-life-balance.png',
        2 => 'interior-designer.png',
        3 => 'horoscope.png',
        4 => 'cardio.png',
        5 => 'designer.png',
        6 => 'influencer.png',
        7 => 'psychologist.png',
        8 => 'dieticians.png',
        9 => 'influencer.png',
        10 => 'horoscope.png',
    ];
@endphp

<li class="submenu">
    <a href="#0" class="show-submenu">Listing</a>
    <ul>
        @foreach ($dropdown_services as $service)
            @php
                $icon = $icons[$service->id] ?? 'influencer.png';
            @endphp
            <li>
                <img src="{{ asset('frontend/assets/img/new-icons/header-menu-icon/' . $icon) }}" alt="{{ $service->name }}">
                <a href="{{ url('/service/' . $service->id) }}">{{ $service->name }}</a>
            </li>
        @endforeach
    </ul>
</li>


            


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