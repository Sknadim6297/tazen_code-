<!-- Start::main-sidebar -->
            
    <aside class="app-sidebar sticky" id="sidebar">

        <!-- Start::main-sidebar-header -->
        <div class="main-sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="header-logo">
                <img src="{{ asset('frontend/assets/img/tazen_logo-01-removebg-preview.png') }}" alt="logo" class="desktop-logo" style="width: 130px; height: auto;">
                <img src="assets/images/brand-logos/toggle-dark.png" alt="logo" class="toggle-dark">
                <img src="{{ asset('frontend/assets/img/tazen_logo-01-removebg-preview.png') }}" alt="logo" class="desktop-dark" style="width: 130px; height: 130px;">
                <img src="{{ asset('frontend/assets/img/tazen_logo-01-removebg-preview.png') }}" alt="logo" class="toggle-logo">
            </a>
        </div>
        <!-- End::main-sidebar-header -->

        <!-- Start::main-sidebar -->
        <div class="main-sidebar" id="sidebar-scroll">

            <!-- Start::nav -->
            <nav class="main-menu-container nav nav-pills flex-column sub-open">
                <div class="slide-left" id="slide-left">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg>
                </div>
                
                <ul class="main-menu">
                    <!-- Start::slide__category -->
                    <li class="slide__category"><span class="category-name">Main</span></li>
                    <!-- End::slide__category -->

                    <!-- Start::slide -->
                    <li class="slide has-sub">
                        <a href="{{ route('admin.dashboard') }}" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><path d="m9 22l-.251-3.509a3.259 3.259 0 1 1 6.501 0L15 22"/><path d="M2.352 13.214c-.354-2.298-.53-3.446-.096-4.465s1.398-1.715 3.325-3.108L7.021 4.6C9.418 2.867 10.617 2 12.001 2c1.382 0 2.58.867 4.978 2.6l1.44 1.041c1.927 1.393 2.89 2.09 3.325 3.108c.434 1.019.258 2.167-.095 4.464l-.301 1.96c-.5 3.256-.751 4.884-1.919 5.856S16.554 22 13.14 22h-2.28c-3.415 0-5.122 0-6.29-.971c-1.168-.972-1.418-2.6-1.918-5.857z"/></g></svg>
                            <span class="side-menu__label">Dashboards</span>
                        </a>
                        <ul class="slide-menu child1">
                          
                        </ul>
                    </li>
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em" height="1em" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2 18c0-1.54 0-2.31.347-2.876c.194-.317.46-.583.777-.777C3.689 14 4.46 14 6 14s2.31 0 2.876.347c.317.194.583.46.777.777C10 15.689 10 16.46 10 18s0 2.31-.347 2.877c-.194.316-.46.582-.777.776C8.311 22 7.54 22 6 22s-2.31 0-2.876-.347a2.35 2.35 0 0 1-.777-.776C2 20.31 2 19.54 2 18m12 0c0-1.54 0-2.31.347-2.876c.194-.317.46-.583.777-.777C15.689 14 16.46 14 18 14s2.31 0 2.877.347c.316.194.582.46.776.777C22 15.689 22 16.46 22 18s0 2.31-.347 2.877a2.36 2.36 0 0 1-.776.776C20.31 22 19.54 22 18 22s-2.31 0-2.876-.347a2.35 2.35 0 0 1-.777-.776C14 20.31 14 19.54 14 18M2 6c0-1.54 0-2.31.347-2.876c.194-.317.46-.583.777-.777C3.689 2 4.46 2 6 2s2.31 0 2.876.347c.317.194.583.46.777.777C10 3.689 10 4.46 10 6s0 2.31-.347 2.876c-.194.317-.46.583-.777.777C8.311 10 7.54 10 6 10s-2.31 0-2.876-.347a2.35 2.35 0 0 1-.777-.777C2 8.311 2 7.54 2 6m12 0c0-1.54 0-2.31.347-2.876c.194-.317.46-.583.777-.777C15.689 2 16.46 2 18 2s2.31 0 2.877.347c.316.194.582.46.776.777C22 3.689 22 4.46 22 6s0 2.31-.347 2.876c-.194.317-.46.583-.776.777C20.31 10 19.54 10 18 10s-2.31 0-2.876-.347a2.35 2.35 0 0 1-.777-.777C14 8.311 14 7.54 14 6" color="currentColor"/></svg>
                            <span class="side-menu__label">Professional</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Apps</a>
                            </li>
                        
                            <li class="slide has-sub">
                                <a href="{{ route('admin.professional.requests') }}" class="side-menu__item">Manage Professional</a>
                                <a href="{{ route('admin.manage-professional.index') }}" class="side-menu__item">All Professional</a>
                                <a href="{{ route('admin.professional.billing') }}" class="side-menu__item">Professional Billing</a>
                            </li>
                        </ul>
                    </li>

                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em" height="1em" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2 18c0-1.54 0-2.31.347-2.876c.194-.317.46-.583.777-.777C3.689 14 4.46 14 6 14s2.31 0 2.876.347c.317.194.583.46.777.777C10 15.689 10 16.46 10 18s0 2.31-.347 2.877c-.194.316-.46.582-.777.776C8.311 22 7.54 22 6 22s-2.31 0-2.876-.347a2.35 2.35 0 0 1-.777-.776C2 20.31 2 19.54 2 18m12 0c0-1.54 0-2.31.347-2.876c.194-.317.46-.583.777-.777C15.689 14 16.46 14 18 14s2.31 0 2.877.347c.316.194.582.46.776.777C22 15.689 22 16.46 22 18s0 2.31-.347 2.877a2.36 2.36 0 0 1-.776.776C20.31 22 19.54 22 18 22s-2.31 0-2.876-.347a2.35 2.35 0 0 1-.777-.776C14 20.31 14 19.54 14 18M2 6c0-1.54 0-2.31.347-2.876c.194-.317.46-.583.777-.777C3.689 2 4.46 2 6 2s2.31 0 2.876.347c.317.194.583.46.777.777C10 3.689 10 4.46 10 6s0 2.31-.347 2.876c-.194.317-.46.583-.777.777C8.311 10 7.54 10 6 10s-2.31 0-2.876-.347a2.35 2.35 0 0 1-.777-.777C2 8.311 2 7.54 2 6m12 0c0-1.54 0-2.31.347-2.876c.194-.317.46-.583.777-.777C15.689 2 16.46 2 18 2s2.31 0 2.877.347c.316.194.582.46.776.777C22 3.689 22 4.46 22 6s0 2.31-.347 2.876c-.194.317-.46.583-.776.777C20.31 10 19.54 10 18 10s-2.31 0-2.876-.347a2.35 2.35 0 0 1-.777-.777C14 8.311 14 7.54 14 6" color="currentColor"/></svg>
                            <span class="side-menu__label">Customer</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Apps</a>
                            </li>
                        
                            <li class="slide has-sub">
                                <a href="{{ route('admin.manage-customer.index') }}" class="side-menu__item">Manage Customer</a>
                                <a href="{{ route('admin.customer.billing') }}" class="side-menu__item">Customer Billing</a>
                            </li>
                        </ul>
                    </li>

                                      @php
    $onetimeCount = \App\Models\Booking::whereIn('plan_type', ['one_time', 'One Time'])->count();
    $monthlyCount = \App\Models\Booking::whereIn('plan_type', ['monthly', 'Monthly'])->count();
    $freehandCount = \App\Models\Booking::whereIn('plan_type', ['free_hand', 'Free Hand'])->count();
    $quarterlyCount = \App\Models\Booking::whereIn('plan_type', ['quarterly', 'Quarterly'])->count();
@endphp

                    @if($isMenuAccessible('booking'))
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em" height="1em" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2 18c0-1.54 0-2.31.347-2.876c.194-.317.46-.583.777-.777C3.689 14 4.46 14 6 14s2.31 0 2.876.347c.317.194.583.46.777.777C10 15.689 10 16.46 10 18s0 2.31-.347 2.877c-.194.316-.46.582-.777.776C8.311 22 7.54 22 6 22s-2.31 0-2.876-.347a2.35 2.35 0 0 1-.777-.776C2 20.31 2 19.54 2 18m12 0c0-1.54 0-2.31.347-2.876c.194-.317.46-.583.777-.777C15.689 14 16.46 14 18 14s2.31 0 2.877.347c.316.194.582.46.776.777C22 15.689 22 16.46 22 18s0 2.31-.347 2.877a2.36 2.36 0 0 1-.776.776C20.31 22 19.54 22 18 22s-2.31 0-2.876-.347a2.35 2.35 0 0 1-.777-.776C14 20.31 14 19.54 14 18M2 6c0-1.54 0-2.31.347-2.876c.194-.317.46-.583.777-.777C3.689 2 4.46 2 6 2s2.31 0 2.876.347c.317.194.583.46.777.777C10 3.689 10 4.46 10 6s0 2.31-.347 2.876c-.194.317-.46.583-.777.777C8.311 10 7.54 10 6 10s-2.31 0-2.876-.347a2.35 2.35 0 0 1-.777-.777C2 8.311 2 7.54 2 6m12 0c0-1.54 0-2.31.347-2.876c.194-.317.46-.583.777-.777C15.689 2 16.46 2 18 2s2.31 0 2.877.347c.316.194.582.46.776.777C22 3.689 22 4.46 22 6s0 2.31-.347 2.876c-.194.317-.46.583-.776.777C20.31 10 19.54 10 18 10s-2.31 0-2.876-.347a2.35 2.35 0 0 1-.777-.777C14 8.311 14 7.54 14 6" color="currentColor"/></svg>
                            <span class="side-menu__label">Booking</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Apps</a>
                            </li>
                        
                            <li class="slide has-sub">
                                <a href="{{ route('admin.onetime') }}" class="side-menu__item">
                                    One Time ({{ $onetimeCount }})
                                </a>
                                <a href="{{ route('admin.monthly') }}" class="side-menu__item">
                                    Monthly ({{ $monthlyCount }})
                                </a>
                                <a href="{{ route('admin.freehand') }}" class="side-menu__item">
                                    Free Hand ({{ $freehandCount }})
                                </a>
                                <a href="{{ route('admin.quaterly') }}" class="side-menu__item">
                                    Quarterly ({{ $quarterlyCount }})
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif
  


                    @if($isMenuAccessible('bank_accounts'))
                    <li class="slide">
                        <a href="{{ route('admin.bank-accounts.index') }}" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em" height="1em" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                                    <path d="M3 21h18"/>
                                    <path d="M3 10h18"/>
                                    <path d="M5 6l7-3l7 3"/>
                                    <path d="M4 10v11"/>
                                    <path d="M20 10v11"/>
                                    <path d="M8 14v3"/>
                                    <path d="M12 14v3"/>
                                    <path d="M16 14v3"/>
                                </g>
                            </svg>
                            <span class="side-menu__label">Bank Accounts</span>
                        </a>
                    </li>
                    @endif

                    @if($isMenuAccessible('admin_booking'))
                    <li class="slide">
                        <a href="{{ route('admin.admin-booking.index') }}" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em" height="1em" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                    <polyline points="9,22 9,12 15,12 15,22"/>
                                    <path d="M8 6h8v2H8z"/>
                                    <path d="M10 8h4v2h-4z"/>
                                </g>
                            </svg>
                            <span class="side-menu__label">Admin Booking</span>
                        </a>
                    </li>
                    @endif

                    @if($isMenuAccessible('additional_services'))
                    <li class="slide">
                        <a href="{{ route('admin.additional-services.index') }}" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em" height="1em" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                                    <path d="M12 5v14"/>
                                    <path d="M5 12h14"/>
                                    <path d="M3 5h18v14H3z"/>
                                </g>
                            </svg>
                            <span class="side-menu__label">Additional Services</span>
                        </a>
                    </li>
                    @endif

                    @if($isMenuAccessible('user_management'))
                    <li class="slide">
                        <a href="{{ route('admin.user-management.index') }}" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em" height="1em" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="m22 21-3-3m0 0a2 2 0 1 0-3-3 2 2 0 0 0 3 3"/>
                                </g>
                            </svg>
                            <span class="side-menu__label">User Management</span>
                        </a>
                    </li>
                    @endif
                    @if($isMenuAccessible('manage_website'))
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><path d="m8.643 3.146l-1.705.788C4.313 5.147 3 5.754 3 6.75s1.313 1.603 3.938 2.816l1.705.788c1.652.764 2.478 1.146 3.357 1.146s1.705-.382 3.357-1.146l1.705-.788C19.687 8.353 21 7.746 21 6.75s-1.313-1.603-3.938-2.816l-1.705-.788C13.705 2.382 12.879 2 12 2s-1.705.382-3.357 1.146"/><path d="M20.788 11.097c.141.199.212.406.212.634c0 .982-1.313 1.58-3.938 2.776l-1.705.777c-1.652.753-2.478 1.13-3.357 1.13s-1.705-.377-3.357-1.13l-1.705-.777C4.313 13.311 3 12.713 3 11.731c0-.228.07-.435.212-.634"/><path d="M20.377 16.266c.415.331.623.661.623 1.052c0 .981-1.313 1.58-3.938 2.776l-1.705.777C13.705 21.624 12.879 22 12 22s-1.705-.376-3.357-1.13l-1.705-.776C4.313 18.898 3 18.299 3 17.318c0-.391.208-.72.623-1.052"/></g></svg>
                            <span class="side-menu__label">Manage Website</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Nested Menu</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('admin.logo.index') }}" class="side-menu__item">Logo</a>
                            </li>
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">Home Page
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i></a>
                                <ul class="slide-menu child2">
                                    <li class="slide">
                                        <a href="{{ route('admin.banners.index') }}" class="side-menu__item">Banner Section</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('admin.header.index') }}" class="side-menu__item">Header Section</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('admin.whychoose.index') }}" class="side-menu__item">Why Choose us Section</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('admin.testimonials.index') }}" class="side-menu__item">Testimonials Section</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('admin.blogs.index') }}" class="side-menu__item">Blog Section</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('admin.howworks.index') }}" class="side-menu__item">How It Works Section</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('admin.servicemcq.index') }}" class="side-menu__item">MCQ</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('admin.faq.index') }}" class="side-menu__item">FAQ Section</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">About Page
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i></a>
                                <ul class="slide-menu child2">
                                    <li class="slide">
                                        <a href="{{ route('admin.about-banner.index') }}" class="side-menu__item">Banner Section</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('admin.aboutus.index') }}" class="side-menu__item">About Us Section</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('admin.aboutexperiences.index') }}" class="side-menu__item">Experience Section</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('admin.abouthowweworks.index') }}" class="side-menu__item">How we work Section</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('admin.aboutfaq.index') }}" class="side-menu__item">FAQ Section</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">Contact Page
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i></a>
                                <ul class="slide-menu child2">
                                    <li class="slide">
                                        <a href="{{ route('admin.contactbanner.index') }}" class="side-menu__item">Banner Section</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('admin.contactdetails.index') }}" class="side-menu__item">Contact Details Section</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">Blog Page
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i></a>
                                <ul class="slide-menu child2">
                                    <li class="slide">
                                        <a href="{{ route('admin.blogbanners.index') }}" class="side-menu__item">Banner Section</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('admin.blogposts.index') }}" class="side-menu__item">Blog Details</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">Event Page
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i></a>
                                <ul class="slide-menu child2">
                                    <li class="slide">
                                        <a href="{{ route('admin.allevents.index') }}" class="side-menu__item">All Event </a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('admin.eventdetails.index') }}" class="side-menu__item">Event Details </a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('admin.eventfaq.index') }}" class="side-menu__item">Event FAQ </a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">Service Page
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i></a>
                                <ul class="slide-menu child2">
                                    <li class="slide">
                                        <a href="{{ route('admin.service.index') }}" class="side-menu__item">Service Cards </a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('admin.sub-service.index') }}" class="side-menu__item">Sub-Services </a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('admin.service-details.index') }}" class="side-menu__item">Service Details </a>
                                    </li>
                                    {{-- <li class="slide">
                                        <a href="{{ route('admin.re-requested-service.index') }}" class="side-menu__item">Re-requested Service </a>
                                    </li> --}}
                                    <li class="slide">
                                        <a href="{{ route('admin.categorybox.index') }}" class="side-menu__item">Category Management </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">Help Page
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i></a>
                        <ul class="slide-menu child2">
                            <li class="slide">
                                <a href="{{ route('admin.help.index') }}" class="side-menu__item">FAQ</a>
                            </li>
                        </ul>
                    </li>

                            @php
                                $pendingApplicationsCount = \App\Models\JobApplication::where('status', 'pending')->count();
                            @endphp
                            <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">Career Page
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i></a>
                        <ul class="slide-menu child2">
                            <li class="slide">
                                <a href="{{ route('admin.careers.index') }}" class="side-menu__item">Career Jobs</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('admin.job-applications.index') }}" class="side-menu__item">
                                    Job Applications
                                    @if($pendingApplicationsCount > 0)
                                        <span class="badge bg-danger rounded-pill ms-2">{{ $pendingApplicationsCount }}</span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </li>

                        </ul>
                    @endif
                     <!-- Download Reports Menu -->
                    @if($isMenuAccessible('reports'))
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em" height="1em" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v13m0 0l-4-4m4 4l4-4M8 21h8"/></svg>
                            <span class="side-menu__label">Download Reports</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Reports</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('admin.reports.booking-summary') }}" class="side-menu__item">Booking Summary Report</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    
                    @if($isMenuAccessible('events'))
                        <li class="slide has-sub">
                        <a href="{{ route('admin.eventpage.index') }}" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><path d="m9 22l-.251-3.509a3.259 3.259 0 1 1 6.501 0L15 22"/><path d="M2.352 13.214c-.354-2.298-.53-3.446-.096-4.465s1.398-1.715 3.325-3.108L7.021 4.6C9.418 2.867 10.617 2 12.001 2c1.382 0 2.58.867 4.978 2.6l1.44 1.041c1.927 1.393 2.89 2.09 3.325 3.108c.434 1.019.258 2.167-.095 4.464l-.301 1.96c-.5 3.256-.751 4.884-1.919 5.856S16.554 22 13.14 22h-2.28c-3.415 0-5.122 0-6.29-.971c-1.168-.972-1.418-2.6-1.918-5.857z"/></g></svg>
                            <span class="side-menu__label">Events</span>
                        </a>
                        <ul class="slide-menu child1">
                          
                        </ul>
                    </li>
                    @endif
                    
                    @if($isMenuAccessible('mcq'))
                    <li class="slide has-sub">
                        <a href="#" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><path d="m9 22l-.251-3.509a3.259 3.259 0 1 1 6.501 0L15 22"/><path d="M2.352 13.214c-.354-2.298-.53-3.446-.096-4.465s1.398-1.715 3.325-3.108L7.021 4.6C9.418 2.867 10.617 2 12.001 2c1.382 0 2.58.867 4.978 2.6l1.44 1.041c1.927 1.393 2.89 2.09 3.325 3.108c.434 1.019.258 2.167-.095 4.464l-.301 1.96c-.5 3.256-.751 4.884-1.919 5.856S16.554 22 13.14 22h-2.28c-3.415 0-5.122 0-6.29-.971c-1.168-.972-1.418-2.6-1.918-5.857z"/></g></svg>
                            <span class="side-menu__label">MCQ</span>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide">
                                <a href="{{ route('admin.mcq-answers.index') }}" class="side-menu__item">View Answers</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    
                    @if($isMenuAccessible('contacts'))
                    <li class="slide has-sub">
                        <a href="{{ route('admin.contact-forms.index') }}" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><path d="m9 22l-.251-3.509a3.259 3.259 0 1 1 6.501 0L15 22"/><path d="M2.352 13.214c-.354-2.298-.53-3.446-.096-4.465s1.398-1.715 3.325-3.108L7.021 4.6C9.418 2.867 10.617 2 12.001 2c1.382 0 2.58.867 4.978 2.6l1.44 1.041c1.927 1.393 2.89 2.09 3.325 3.108c.434 1.019.258 2.167-.095 4.464l-.301 1.96c-.5 3.256-.751 4.884-1.919 5.856S16.554 22 13.14 22h-2.28c-3.415 0-5.122 0-6.29-.971c-1.168-.972-1.418-2.6-1.918-5.857z"/></g></svg>
                            <span class="side-menu__label">Contacts</span>
                        </a>
                        <ul class="slide-menu child1">
                          
                        </ul>
                    </li>
                    @endif
                    
                    @if($isMenuAccessible('blog_comments'))
                    <li class="slide has-sub">
                        <a href="{{ route('admin.comments.index') }}" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><path d="m9 22l-.251-3.509a3.259 3.259 0 1 1 6.501 0L15 22"/><path d="M2.352 13.214c-.354-2.298-.53-3.446-.096-4.465s1.398-1.715 3.325-3.108L7.021 4.6C9.418 2.867 10.617 2 12.001 2c1.382 0 2.58.867 4.978 2.6l1.44 1.041c1.927 1.393 2.89 2.09 3.325 3.108c.434 1.019.258 2.167-.095 4.464l-.301 1.96c-.5 3.256-.751 4.884-1.919 5.856S16.554 22 13.14 22h-2.28c-3.415 0-5.122 0-6.29-.971c-1.168-.972-1.418-2.6-1.918-5.857z"/></g></svg>
                            <span class="side-menu__label">Blog Comments</span>
                        </a>
                        <ul class="slide-menu child1">
                          
                        </ul>
                    </li>
                    @endif
                    
                    @if($isMenuAccessible('reviews'))
                    <li class="slide has-sub">
    <a href="javascript:void(0);" class="side-menu__item">
        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em" height="1em" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5z" />
        </svg>
        <span class="side-menu__label">Reviews</span>
        <i class="ri-arrow-down-s-line side-menu__angle"></i>
    </a>
    <ul class="slide-menu child1">
        <li class="slide side-menu__label1">
            <a href="javascript:void(0)">Reviews</a>
        </li>
        <li class="slide">
            <a href="{{ route('admin.reviews.index') }}" class="side-menu__item">Manage Reviews</a>
        </li>
    </ul>
</li>
@endif

@if($isMenuAccessible('manage_control'))
<li class="slide has-sub">
    <a href="javascript:void(0);" class="side-menu__item">
        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em" height="1em" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 5.25a3 3 0 013 3m-3-3a3 3 0 00-3 3m3-3v1.5m0 9.75a3 3 0 100-6 3 3 0 000 6zm0 0v1.5m-6-9v-1.5a3 3 0 114.5-2.62M8.25 15v1.5m0 0a3 3 0 110 6 3 3 0 010-6z" />
        </svg>
        <span class="side-menu__label">Manage Control</span>
        <i class="ri-arrow-down-s-line side-menu__angle"></i>
    </a>
    <ul class="slide-menu child1">
        <li class="slide side-menu__label1">
            <a href="javascript:void(0)">Admin Control</a>
        </li>
        <li class="slide">
            <a href="{{ route('admin.manage_admins.index') }}" class="side-menu__item">Manage Admins</a>
        </li>
        <li class="slide">
            <a href="{{ route('admin.admin_menus.index') }}" class="side-menu__item">Menu Permissions</a>
        </li>
    </ul>
</li>
@endif
                </ul>
                
                </li>
                    
                    <!-- End::slide -->

                    </aside>