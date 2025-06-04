<header class="header clearfix element_to_stick">
    <div class="container-fluid">
        <div id="logo">
            <a href="{{ url('/') }}" title="Tazen">
                {{-- <img src="{{ asset('frontend/assets/img/logo.svg') }}" width="120" height="35" alt="" class="logo_normal"> --}}
                {{-- <img src="{{ asset('frontend/assets/img/logo_sticky.svg') }}" width="120" height="35" alt="" class="logo_sticky"> --}}
                <img src="{{ asset('frontend/assets/img/tazen_logo-01-removebg-preview.png') }}" width="150" height="auto" alt="" class="logo_normal">
                <img src="{{ asset('frontend/assets/img/tazen_logo-01-removebg-preview.png') }}" width="150" height="auto" alt="" class="logo_sticky">
            </a>
        </div>
        <ul id="top_menu">
            @php
                $user = Auth::guard('user')->user(); 
                $professional = Auth::guard('professional')->user();
            @endphp
        
            @if($user)
                <li class="d-flex align-items-center gap-2">
                    <a href="{{ route('user.dashboard') }}" class="btn btn-custom" style="border-radius: 4px;
    background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
    border: none;
    color: aliceblue;"">Dashboard</a>
                </li>
            @elseif($professional)
                <li class="d-flex align-items-center gap-2">
                    <a href="{{ route('professional.dashboard') }}" class="btn btn-custom" style="border-radius: 4px;
    background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
    border: none;
    color: aliceblue;">Professional Dashboard</a>
                </li>
            @else
                <li class="d-flex align-items-center gap-2">
                    <a href="{{ route('login') }}" class="btn_access">Log In</a>
                    <a href="{{ route('professional.login') }}" class="btn_access green"><i class="fa-solid fa-user-plus"></i> Join as a Professional</a>
                </li>
            @endif
        </ul>
        
        <style>
            @media (max-width: 767px) {
                #top_menu {
                    display: flex;
                    flex-direction: column;
                    gap: 10px;
                    padding: 10px;
                }
                
                #top_menu li {
                    width: 100%;
                }
                
                #top_menu .btn_access {
                    width: 100%;
                    text-align: center;
                    padding: 8px 15px;
                    font-size: 14px;
                }
                
                #top_menu .btn_access i {
                    margin-right: 5px;
                }
            }
            @media (max-width: 767px) {
    ul#top_menu>li a.btn_access {
        padding: 6px 0px;
                font-size: 11px;
    }
}

@media (max-width: 991px) {
    #logo img {
        width: auto;
        height: 50px;
        margin-right: 260px;
        margin-top: 0;

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
                $icon = $icons[$service->id] ?? 'default.png';
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