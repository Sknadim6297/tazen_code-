<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

    <!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>

        <!-- Meta Data -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="Description" content="Codeigniter Bootstrap Responsive Admin Web Dashboard Template">
        <meta name="Author" content="Spruko Technologies Private Limited">
        <meta name="keywords" content="admin panel template, bootstrap, bootstrap admin template, bootstrap codeigniter, bootstrap dashboard, bootstrap framework, bootstrap template, codeigniter, codeigniter admin, codeigniter dashboard, codeigniter template, codeigniter ui, dashboard bootstrap, framework codeigniter, template codeigniter, template dashboard codeigniter.">
        
        <!-- Title -->
        <title> Meno - Codeigniter Bootstrap 5 Premium Admin & Dashboard Template </title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('customer/assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">
       
        <!-- Start::Styles -->
        
        <!-- Choices JS -->
        <script src="{{ asset('customer/assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

        <!-- Main Theme Js -->
        <script src="{{ asset('customer/assets/js/main.js') }}"></script>

        <!-- Bootstrap Css -->
        <link id="style" href="{{ asset('customer/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" >

        <!-- Style Css -->
        <link href="{{ asset('customer/assets/css/styles.css') }}" rel="stylesheet" >

        <!-- Icons Css -->
        <link href="{{ asset('customer/assets/css/icons.css') }}" rel="stylesheet" >

        <!-- Node Waves Css -->
        <link href="{{ asset('customer/assets/libs/node-waves/waves.min.css') }}" rel="stylesheet" > 

        <!-- Simplebar Css -->
        <link href="{{ asset('customer/assets/libs/simplebar/simplebar.min.css') }}" rel="stylesheet" >

        <!-- Color Picker Css -->
        <link rel="stylesheet" href="{{ asset('customer/assets/libs/%40simonwep/pickr/themes/nano.min.css') }}">

        <!-- Choices Css -->
        <link rel="stylesheet" href="{{ asset('customer/assets/libs/choices.js/public/assets/styles/choices.min.css') }}">

        <!-- FlatPickr CSS -->
        <link rel="stylesheet" href="{{ asset('customer/assets/libs/flatpickr/flatpickr.min.css') }}">

        <!-- Auto Complete CSS -->
        <link rel="stylesheet" href="{{ asset('customer/assets/libs/%40tarekraafat/autocomplete.js/css/autoComplete.css') }}">

        <link rel="stylesheet" href="{{ asset('customer/assets/libs/prismjs/themes/prism-coy.min.css') }}">
        
        


        <!-- End::Styles -->

    </head>    
    
    <body class="">

        <!-- Start::main-switcher -->
        
         {{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="switcher-canvas" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header border-bottom d-block p-0">
                <div class="d-flex align-items-center justify-content-between p-3">
                    <h5 class="offcanvas-title text-default" id="offcanvasRightLabel">Switcher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <nav class="border-top border-block-start-dashed">
                    <div class="nav nav-tabs nav-justified" id="switcher-main-tab" role="tablist">
                        <button class="nav-link active" id="switcher-home-tab" data-bs-toggle="tab"
                            data-bs-target="#switcher-home" type="button" role="tab" aria-controls="switcher-home"
                            aria-selected="true">Theme Styles</button>
                        <button class="nav-link" id="switcher-profile-tab" data-bs-toggle="tab"
                            data-bs-target="#switcher-profile" type="button" role="tab" aria-controls="switcher-profile"
                            aria-selected="false">Theme Colors</button>
                    </div>
                </nav>
            </div>
            <div class="offcanvas-body">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active border-0" id="switcher-home" role="tabpanel"
                        aria-labelledby="switcher-home-tab" tabindex="0">
                        <div class="">
                            <p class="switcher-style-head">Theme Color Mode:</p>
                            <div class="row switcher-style gx-0">
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-light-theme">
                                            Light
                                        </label>
                                        <input class="form-check-input" type="radio" name="theme-style"
                                            id="switcher-light-theme" checked>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-dark-theme">
                                            Dark
                                        </label>
                                        <input class="form-check-input" type="radio" name="theme-style"
                                            id="switcher-dark-theme">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Directions:</p>
                            <div class="row switcher-style gx-0">
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-ltr">
                                            LTR
                                        </label>
                                        <input class="form-check-input" type="radio" name="direction" id="switcher-ltr" checked>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-rtl">
                                            RTL
                                        </label>
                                        <input class="form-check-input" type="radio" name="direction" id="switcher-rtl">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Navigation Styles:</p>
                            <div class="row switcher-style gx-0">
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-vertical">
                                            Vertical
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-style"
                                            id="switcher-vertical" checked>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-horizontal">
                                            Horizontal
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-style"
                                            id="switcher-horizontal">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="navigation-menu-styles">
                            <p class="switcher-style-head">Vertical & Horizontal Menu Styles:</p>
                            <div class="row switcher-style gx-0 pb-2 gy-2">
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-menu-click">
                                            Menu Click
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                            id="switcher-menu-click">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-menu-hover">
                                            Menu Hover
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                            id="switcher-menu-hover">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-icon-click">
                                            Icon Click
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                            id="switcher-icon-click">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-icon-hover">
                                            Icon Hover
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                            id="switcher-icon-hover">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sidemenu-layout-styles">
                            <p class="switcher-style-head">Sidemenu Layout Styles:</p>
                            <div class="row switcher-style gx-0 pb-2 gy-2">
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-default-menu">
                                            Default Menu
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                            id="switcher-default-menu" checked>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-closed-menu">
                                            Closed Menu
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                            id="switcher-closed-menu">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-icontext-menu">
                                            Icon Text
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                            id="switcher-icontext-menu">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-icon-overlay">
                                            Icon Overlay
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                            id="switcher-icon-overlay">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-detached">
                                            Detached
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                            id="switcher-detached">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-double-menu">
                                            Double Menu
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                            id="switcher-double-menu">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Page Styles:</p>
                            <div class="row switcher-style gx-0">
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-regular">
                                            Regular
                                        </label>
                                        <input class="form-check-input" type="radio" name="page-styles" id="switcher-regular"
                                            checked>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-classic">
                                            Classic
                                        </label>
                                        <input class="form-check-input" type="radio" name="page-styles" id="switcher-classic">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-modern">
                                            Modern
                                        </label>
                                        <input class="form-check-input" type="radio" name="page-styles" id="switcher-modern">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Layout Width Styles:</p>
                            <div class="row switcher-style gx-0">
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-default-width">
                                            Compact
                                        </label>
                                        <input class="form-check-input" type="radio" name="layout-width"
                                            id="switcher-default-width">
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-full-width">
                                            Full Width
                                        </label>
                                        <input class="form-check-input" type="radio" name="layout-width"
                                            id="switcher-full-width" checked>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-boxed">
                                            Boxed
                                        </label>
                                        <input class="form-check-input" type="radio" name="layout-width" id="switcher-boxed">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Menu Positions:</p>
                            <div class="row switcher-style gx-0">
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-menu-fixed">
                                            Fixed
                                        </label>
                                        <input class="form-check-input" type="radio" name="menu-positions"
                                            id="switcher-menu-fixed" checked>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-menu-scroll">
                                            Scrollable
                                        </label>
                                        <input class="form-check-input" type="radio" name="menu-positions"
                                            id="switcher-menu-scroll">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Header Positions:</p>
                            <div class="row switcher-style gx-0">
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-header-fixed">
                                            Fixed
                                        </label>
                                        <input class="form-check-input" type="radio" name="header-positions"
                                            id="switcher-header-fixed" checked>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-header-scroll">
                                            Scrollable
                                        </label>
                                        <input class="form-check-input" type="radio" name="header-positions"
                                            id="switcher-header-scroll">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Loader:</p>
                            <div class="row switcher-style gx-0">
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-loader-enable">
                                            Enable
                                        </label>
                                        <input class="form-check-input" type="radio" name="page-loader"
                                            id="switcher-loader-enable">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-loader-disable">
                                            Disable
                                        </label>
                                        <input class="form-check-input" type="radio" name="page-loader"
                                            id="switcher-loader-disable" checked>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade border-0" id="switcher-profile" role="tabpanel"
                        aria-labelledby="switcher-profile-tab" tabindex="0">
                        <div>
                            <div class="theme-colors">
                                <p class="switcher-style-head">Menu Colors:</p>
                                <div class="d-flex switcher-style pb-2">
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-white" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Light Menu" type="radio" name="menu-colors"
                                            id="switcher-menu-light" checked>
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-dark" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Dark Menu" type="radio" name="menu-colors"
                                            id="switcher-menu-dark">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Color Menu" type="radio" name="menu-colors"
                                            id="switcher-menu-primary">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-gradient" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Gradient Menu" type="radio" name="menu-colors"
                                            id="switcher-menu-gradient">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-transparent" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Transparent Menu" type="radio" name="menu-colors"
                                            id="switcher-menu-transparent">
                                    </div>
                                </div>
                                <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Menu dynamically change
                                    from below Theme Primary color picker</div>
                            </div>
                            <div class="theme-colors">
                                <p class="switcher-style-head">Header Colors:</p>
                                <div class="d-flex switcher-style pb-2">
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-white" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Light Header" type="radio" name="header-colors"
                                            id="switcher-header-light" checked>
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-dark" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Dark Header" type="radio" name="header-colors"
                                            id="switcher-header-dark">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Color Header" type="radio" name="header-colors"
                                            id="switcher-header-primary">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-gradient" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Gradient Header" type="radio" name="header-colors"
                                            id="switcher-header-gradient">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-transparent" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Transparent Header" type="radio" name="header-colors"
                                            id="switcher-header-transparent">
                                    </div>
                                </div>
                                <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Header dynamically
                                    change from below Theme Primary color picker</div>
                            </div>
                            <div class="theme-colors">
                                <p class="switcher-style-head">Theme Primary:</p>
                                <div class="d-flex flex-wrap align-items-center switcher-style">
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary-1" type="radio"
                                            name="theme-primary" id="switcher-primary">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary-2" type="radio"
                                            name="theme-primary" id="switcher-primary1">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary-3" type="radio"
                                            name="theme-primary" id="switcher-primary2">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary-4" type="radio"
                                            name="theme-primary" id="switcher-primary3">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary-5" type="radio"
                                            name="theme-primary" id="switcher-primary4">
                                    </div>
                                    <div class="form-check switch-select ps-0 mt-1 color-primary-light">
                                        <div class="theme-container-primary"></div>
                                        <div class="pickr-container-primary" onchange="updateChartColor(this.value)"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="theme-colors">
                                <p class="switcher-style-head">Theme Background:</p>
                                <div class="d-flex flex-wrap align-items-center switcher-style">
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-bg-1" type="radio"
                                            name="theme-background" id="switcher-background">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-bg-2" type="radio"
                                            name="theme-background" id="switcher-background1">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-bg-3" type="radio"
                                            name="theme-background" id="switcher-background2">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-bg-4" type="radio"
                                            name="theme-background" id="switcher-background3">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-bg-5" type="radio"
                                            name="theme-background" id="switcher-background4">
                                    </div>
                                    <div class="form-check switch-select ps-0 mt-1 tooltip-static-demo color-bg-transparent">
                                        <div class="theme-container-background"></div>
                                        <div class="pickr-container-background"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="menu-image mb-3">
                                <p class="switcher-style-head">Menu With Background Image:</p>
                                <div class="d-flex flex-wrap align-items-center switcher-style">
                                    <div class="form-check switch-select m-2">
                                        <input class="form-check-input bgimage-input bg-img1" type="radio"
                                            name="menu-background" id="switcher-bg-img">
                                    </div>
                                    <div class="form-check switch-select m-2">
                                        <input class="form-check-input bgimage-input bg-img2" type="radio"
                                            name="menu-background" id="switcher-bg-img1">
                                    </div>
                                    <div class="form-check switch-select m-2">
                                        <input class="form-check-input bgimage-input bg-img3" type="radio"
                                            name="menu-background" id="switcher-bg-img2">
                                    </div>
                                    <div class="form-check switch-select m-2">
                                        <input class="form-check-input bgimage-input bg-img4" type="radio"
                                            name="menu-background" id="switcher-bg-img3">
                                    </div>
                                    <div class="form-check switch-select m-2">
                                        <input class="form-check-input bgimage-input bg-img5" type="radio"
                                            name="menu-background" id="switcher-bg-img4">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between canvas-footer gap-1"> 
                        <a href="https://themeforest.net/item/meno-bootstrap-dashboard-codeigniter-admin-panel-template/57343356" target="_blank" class="btn btn-primary flex-fill">Buy Now</a> 
                        <a href="https://themeforest.net/user/spruko/portfolio" target="_blank" class="btn btn-secondary flex-fill">Our Portfolio</a> 
                        <a href="javascript:void(0);" id="reset-all" class="btn btn-danger flex-fill">Reset</a> 
                    </div>
                </div>
            </div>
        </div>        <!-- End::main-switcher --> --}} 

        <!-- Loader -->
        {{-- <div id="loader" >
            <img src="assets/images/media/loader.svg" alt="">
        </div> --}}
        <!-- Loader -->

		<!-- page -->
        <div class="page">

			<!-- Start::main-header -->
            
            @include('customer.sections.header')
					<!-- End::main-header -->

			<!-- Start::main-sidebar -->
            
			@include('customer.sections.sidebar')		<!-- End::main-sidebar -->

            <!-- Start::app-content -->
            @yield('content')          <!-- End::main-modal -->

            <!-- Start::main-footer -->
            
            @include('customer.sections.footer')           <!-- End::main-footer -->

        </div> 
        <!-- End Page -->          

        <!-- Start::main-scripts -->
        
         <!-- Scroll To Top -->
         <div class="scrollToTop">
            <span class="arrow lh-1"><i class="ri-rocket-line align-middle fs-18"></i></span>
         </div>
         <div id="responsive-overlay"></div>
         <!-- Scroll To Top -->

         <!-- Popper JS -->
         <script src="{{ asset('customer/assets/libs/%40popperjs/core/umd/popper.min.js') }}"></script>

         <!-- Bootstrap JS -->
         <script src="{{ asset('customer/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

         <!-- Defaultmenu JS -->
         <script src="{{ asset('customer/assets/js/defaultmenu.js') }}"></script>

         <!-- Node Waves JS-->
         <script src="{{ asset('customer/assets/libs/node-waves/waves.min.js') }}"></script>

         <!-- Sticky JS -->
         <script src="{{ asset('customer/assets/js/sticky.js') }}"></script>

         <!-- Simplebar JS -->
         <script src="{{ asset('customer/assets/libs/simplebar/simplebar.min.js') }}"></script>
         <script src="{{ asset('customer/assets/js/simplebar.js') }}"></script>

         <!-- Auto Complete JS -->
         <script src="{{ asset('customer/assets/libs/%40tarekraafat/autocomplete.js/autoComplete.min.js') }}"></script>

         <!-- Color Picker JS -->
         <script src="{{ asset('customer/assets/libs/%40simonwep/pickr/pickr.es5.min.js') }}"></script>

         <!-- Date & Time Picker JS -->
         <script src="{{ asset('customer/assets/libs/flatpickr/flatpickr.min.js') }}"></script>
            
         	
        <!-- Apex Charts JS -->
        <script src="{{ asset('customer/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

        <!-- Sales Dashboard --> 
        <script src="{{ asset('customer/assets/js/sales-dashboard.js') }}"></script>

            
         <!-- Custom-Switcher JS -->
         <script src="{{ asset('customer/assets/js/custom-switcher.js') }}"></script>

         <!-- Custom JS -->
         <script src="{{ asset('customer/assets/js/custom.js') }}"></script>
        <!-- End::main-scripts -->

        <script src="{{ asset('customer/assets/libs/prismjs/prism.js') }}"></script>
        <script src="{{ asset('customer/assets/js/prism-custom.js') }}"></script>

    </body>

</html>