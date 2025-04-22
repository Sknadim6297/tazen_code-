	<!-- Start::main-sidebar -->
            
    <aside class="app-sidebar sticky" id="sidebar">

        <!-- Start::main-sidebar-header -->
        <div class="main-sidebar-header">
            <a href="index-2.html" class="header-logo">
                <img src="assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo">
                <img src="assets/images/brand-logos/toggle-dark.png" alt="logo" class="toggle-dark">
                <img src="assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark">
                <img src="assets/images/brand-logos/toggle-logo.png" alt="logo" class="toggle-logo">
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
                                <a href="javascript:void(0);" class="side-menu__item">Crypto
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i></a>
                                <ul class="slide-menu child2">
                                    <li class="slide">
                                        <a href="crypto-transactions.html" class="side-menu__item">Transactions</a>
                                    </li>
                                    <li class="slide">
                                        <a href="crypto-currency-exchange.html" class="side-menu__item">Currency Exchange</a>
                                    </li>
                                    <li class="slide">
                                        <a href="crypto-buy-sell.html" class="side-menu__item">Buy & Sell</a>
                                    </li>
                                    <li class="slide">
                                        <a href="crypto-marketcap.html" class="side-menu__item">Marketcap</a>
                                    </li>
                                    <li class="slide">
                                        <a href="crypto-wallet.html" class="side-menu__item">Wallet</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
  
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
                                <a href="javascript:void(0);" class="side-menu__item">Logo</a>
                            </li>
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">Home Page
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i></a>
                                <ul class="slide-menu child2">
                                    <li class="slide">
                                        <a href="{{ route('admin.banner.index') }}" class="side-menu__item">Banner Section</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">About Page
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i></a>
                                <ul class="slide-menu child2">
                                    <li class="slide">
                                        <a href="javascript:void(0);" class="side-menu__item">Banner Section</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- End::slide -->

                    </aside>