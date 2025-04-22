<header class="header clearfix element_to_stick">
    <div class="container-fluid">
        <div id="logo">
            <a href="index-3.html">
                <img src="{{ asset('frontend/assets/img/tazen logo-01.png') }}" width="150" height="60" alt="" class="logo_normal">
                <img src="{{ asset('frontend/assets/img/tazen logo-01.png') }}" width="150" height="60" alt="" class="logo_sticky">
            </a>
        </div>
        <ul id="top_menu">
            <li><a href="login.html" class="btn_access">Log In</a></li>
            <li><a href="professional-dashboard.html" class="btn_access green"><i class="fa-solid fa-user-plus"></i>
                    Join as a Professional</a></li>
        </ul>
        <!-- /top_menu -->
        <a href="#0" class="open_close">
            <i class="icon_menu"></i><span>Menu</span>
        </a>
        <nav class="main-menu">
            <div id="header_menu">
                <a href="#0" class="open_close">
                    <i class="icon_close"></i><span>Menu</span>
                </a>
                <a href="index-2.html"><img src="{{ asset('frontend/assets/img/logo.svg') }}" width="120" height="35" alt=""></a>
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

            <li class="submenu">
                <a href="#0" class="show-submenu">Listing</a>
                <ul>
                    <li>
                        <img src="{{ asset('frontend/assets/img/new-icons/header-menu-icon/work-life-balance.png') }}" alt="">
                        <a href="{{ url('/job') }}">Job, Career and Business</a>
                    </li>
                    <li>
                        <img src="{{ asset('frontend/assets/img/new-icons/header-menu-icon/interior-designer.png') }}" alt="">
                        <a href="{{ url('/interiordesign') }}">Interior Designer</a>
                    </li>
                    <li>
                        <img src="{{ asset('frontend/assets/img/new-icons/header-menu-icon/horoscope.png') }}" alt="">
                        <a href="{{ url('/astro') }}">Astrologer/Priest</a>
                    </li>
                    <li>
                        <img src="{{ asset('frontend/assets/img/new-icons/header-menu-icon/cardio.png') }}" alt="">
                        <a href="{{ url('/fitness') }}">Fitness Yoga Zumba Weight Training</a>
                    </li>
                    <li>
                        <img src="{{ asset('frontend/assets/img/new-icons/header-menu-icon/designer.png') }}" alt="">
                        <a href="{{ url('/stylist') }}">Style / Image Consultant</a>
                    </li>
                    <li>
                        <img src="{{ asset('frontend/assets/img/new-icons/header-menu-icon/influencer.png') }}" alt="">
                        <a href="{{ url('/influencer') }}">Influencers for Business</a>
                    </li>
                    <li>
                        <img src="{{ asset('frontend/assets/img/new-icons/header-menu-icon/psychologist.png') }}" alt="">
                        <a href="{{ url('/pshychology') }}">Psychologist</a>
                    </li>
                    <li>
                        <img src="{{ asset('frontend/assets/img/new-icons/header-menu-icon/dieticians.png') }}" alt="">
                        <a href="{{ url('/dieticians') }}">Dieticians</a>
                    </li>
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