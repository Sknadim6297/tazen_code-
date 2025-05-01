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
                    <a href="index-2.html" class="header-logo">
                        <img src="assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo">
                        <img src="assets/images/brand-logos/toggle-logo.png" alt="logo" class="toggle-logo">
                        <img src="assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark">
                        <img src="assets/images/brand-logos/toggle-dark.png" alt="logo" class="toggle-dark">
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
            <li class="header-element d-md-none d-block">
                <a href="javascript:void(0);" class="header-link" data-bs-toggle="modal" data-bs-target="#header-responsive-search">
                    <!-- Start::header-link-icon -->
                    <i class="bi bi-search header-link-icon"></i>
                    <!-- End::header-link-icon -->
                </a>  
            </li>
            <!-- End::header-element -->


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
            <li class="header-element notifications-dropdown d-xl-block d-none dropdown">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" id="messageDropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><path d="M2.53 14.77c-.213 1.394.738 2.361 1.902 2.843c4.463 1.85 10.673 1.85 15.136 0c1.164-.482 2.115-1.45 1.902-2.843c-.13-.857-.777-1.57-1.256-2.267c-.627-.924-.689-1.931-.69-3.003C19.525 5.358 16.157 2 12 2S4.475 5.358 4.475 9.5c0 1.072-.062 2.08-.69 3.003c-.478.697-1.124 1.41-1.255 2.267"/><path d="M8 19c.458 1.725 2.076 3 4 3c1.925 0 3.541-1.275 4-3"/></g></svg>
                    <span class="header-icon-pulse bg-pink rounded pulse pulse-pink"></span>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <!-- Start::main-header-dropdown -->
                <div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                    <div class="p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 fs-16">Notifications</p>
                            <span class="badge bg-secondary-transparent" id="notifiation-data">5 Unread</span>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <ul class="list-unstyled mb-0" id="header-notification-scroll">
                        <li class="dropdown-item">
                            <div class="d-flex align-items-center gap-3">
                                <span class="avatar avatar-md flex-shrink-0">
                                    <img src="assets/images/faces/14.jpg" alt="img">
                                    <a href="javascript:void(0);" class="badge rounded-pill bg-warning avatar-badge"><i class="fe fe-plus"></i></a>
                                </span>
                                <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                    <div class="fs-13">
                                        <div class="text-muted">
                                            <a href="javascript:void(0);" class="fw-medium">Purni </a>commented on your <span class="fw-medium text-default">post</span>
                                        </div>
                                        <div class="text-muted fw-normal fs-12">2mins ago</div>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0);" class="min-w-fit-content text-muted dropdown-item-close1"><i class="ri-delete-bin-2-line fs-16"></i></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-item">
                            <div class="d-flex align-items-center gap-3">
                                <span class="avatar avatar-md flex-shrink-0 bg-success-transparent">
                                    <i class="ri-shopping-cart-line fs-18 lh-1 align-middle"></i>
                                    <a href="javascript:void(0);" class="badge rounded-pill bg-pink avatar-badge"><i class="fe fe-box"></i></a>
                                </span>
                                <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                    <div class="fs-13">
                                        <div class="text-muted">
                                            Updated the <a href="javascript:void(0);" class="fw-medium text-default">order details</a> for your purchase.
                                        </div>
                                        <div class="text-muted fw-normal fs-12">5 mins ago</div>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0);" class="min-w-fit-content text-muted dropdown-item-close1"><i class="ri-delete-bin-2-line fs-16"></i></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-item">
                            <div class="d-flex align-items-center gap-3">
                                <span class="avatar avatar-md flex-shrink-0">
                                    <img src="assets/images/faces/2.jpg" alt="img">
                                    <a href="javascript:void(0);" class="badge rounded-pill bg-primary avatar-badge"><i class="fe fe-user-plus"></i></a>
                                </span>
                                <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                    <div class="fs-13">
                                        <div class="text-muted">
                                            <a href="javascript:void(0);" class="fw-medium">Priya Sharma</a> sent you a <span class="fw-medium text-default">follow request</span>.
                                        </div>
                                        <div class="text-muted fw-normal fs-12">15 mins ago</div>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0);" class="min-w-fit-content text-muted dropdown-item-close1"><i class="ri-delete-bin-2-line fs-16"></i></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-item">
                            <div class="d-flex align-items-center gap-3">
                                <span class="avatar avatar-md flex-shrink-0">
                                    <img src="assets/images/faces/12.jpg" alt="img">
                                    <a href="javascript:void(0);" class="badge rounded-pill bg-primary avatar-badge"><i class="fe fe-credit-card"></i></a>
                                </span>
                                <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                    <div class="fs-13">
                                        <div class="text-muted">
                                            <a href="javascript:void(0);" class="fw-medium">Amit Patel</a> sent you a <span class="fw-medium text-default">money transfer</span> of ₹15,000.
                                        </div>
                                        <div class="text-muted fw-normal fs-12">30 mins ago</div>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0);" class="min-w-fit-content text-muted dropdown-item-close1"><i class="ri-delete-bin-2-line fs-16"></i></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-item">
                            <div class="d-flex align-items-center gap-3">
                                <span class="avatar avatar-md flex-shrink-0">
                                    <img src="assets/images/faces/4.jpg" alt="img">
                                    <a href="javascript:void(0);" class="badge rounded-pill bg-warning avatar-badge"><i class="fe fe-message-circle"></i></a>
                                </span>
                                <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                    <div class="fs-13">
                                        <div class="text-muted">
                                            <a href="javascript:void(0);" class="fw-medium">Neha Verma</a> replied to your <span class="fw-medium text-default">message</span>.
                                        </div>
                                        <div class="text-muted fw-normal fs-12">1 hour ago</div>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0);" class="min-w-fit-content text-muted dropdown-item-close1"><i class="ri-delete-bin-2-line fs-16"></i></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="p-3 empty-header-item1 border-top">
                        <div class="d-grid">
                            <a href="javascript:void(0);" class="btn btn-primary btn-wave">View All</a>
                        </div>
                    </div>
                    <div class="p-5 empty-item1 d-none">
                        <div class="text-center">
                            <span class="avatar avatar-xl avatar-rounded bg-secondary-transparent">
                                <i class="ri-notification-off-line fs-2"></i>
                            </span>
                            <h6 class="fw-medium mt-3">No New Notifications</h6>
                        </div>
                    </div>
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
                            <img src="assets/images/faces/10.jpg" alt="img" class="avatar avatar-sm avatar-rounded">
                        </div>
                    </div>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end" aria-labelledby="mainHeaderProfile">
                    <li class="p-3 border-bottom">
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <div>
                                <p class="mb-0 fw-semibold lh-1">Arjun Arora</p>
                                <span class="fs-11 text-muted">arjunarora@mail.com</span>
                            </div>
                        </div>
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="profile.html"><i class="ri-user-line fs-15 me-2 text-gray fw-normal"></i>Profile</a></li>
                    <li> <hr class="dropdown-divider"> </li>
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