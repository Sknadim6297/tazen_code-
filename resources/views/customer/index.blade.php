<!-- /header -->
@extends('customer.layout.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
@endsection
@section('content')

<div class="main-content app-content">
    <div class="container-fluid">

            
        <!-- Start::page-header -->
        <div class="d-flex align-items-center justify-content-between my-3 page-header-breadcrumb flex-wrap gap-2">
            <div>
                <p class="fw-medium fs-18 mb-0">Hello there, Arjun Arora</p>
                <p class="fs-13 text-muted mb-0">Let's make today a productive one!</p>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <div class="d-flex gap-2">
                    <div class="position-relative">
                        <button class="btn btn-primary btn-wave" type="button"
                            id="dropdownMenuClickableInside" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" aria-expanded="false">
                            Filter By <i class="ri-arrow-down-s-fill ms-1"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuClickableInside">
                            <li><a class="dropdown-item" href="javascript:void(0);">Today</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Yesterday</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Last 7 Days</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Last 30 Days</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Last 6 Months</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Last Year</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-secondary btn-icon btn-wave" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download">
                        <i class="ti ti-download"></i>
                    </button>
                    <button class="btn btn-success btn-icon btn-wave" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Share">
                        <i class="ti ti-share-3"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- End::page-header -->

        <!-- Start:: row-1 -->
        <div class="row">
            <div class="col-xxl-9">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex gap-3">
                                    <div class="avatar avatar-md bg-primary svg-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><path d="M33.6,145.5A96,96,0,0,1,96,37.5v72Z" opacity="0.2"/><path d="M33.6,145.5A96,96,0,0,1,96,37.5v72Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M128,128.42V32A96,96,0,1,1,45.22,176.64Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                                    </div>
                                    <div class="flex-fill">
                                        <div class="flex-fill fw-medium fs-13 mb-1 text-dark">Number Of Sales</div>
                                        <div class="fs-22 fw-semibold mb-1 text-primary ">12,432</div>
                                        <div class="d-flex align-items-center fs-11">
                                            <span class="text-success fw-semibold me-1"><i class="ti ti-trending-up me-1 fw-medium align-middle text-success d-inline-flex"></i>2.5%</span>
                                            <span class="text-default op-6">This Month</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex gap-3">
                                    <div class="avatar avatar-md bg-secondary svg-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><path d="M128,144a191.14,191.14,0,0,1-96-25.68h0V200a8,8,0,0,0,8,8H216a8,8,0,0,0,8-8V118.31A191.08,191.08,0,0,1,128,144Z" opacity="0.2"/><line x1="112" y1="112" x2="144" y2="112" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><rect x="32" y="64" width="192" height="144" rx="8" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M168,64V48a16,16,0,0,0-16-16H104A16,16,0,0,0,88,48V64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M224,118.31A191.09,191.09,0,0,1,128,144a191.14,191.14,0,0,1-96-25.68" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                                    </div>
                                    <div>
                                        <div class="flex-fill fw-medium fs-13 mb-1 text-dark">Profit By Sale</div>
                                        <div class="fs-22 fw-semibold mb-1 text-secondary">$4,132</div>
                                        <div class="d-flex align-items-center fs-11">
                                            <span class=" text-success fw-semibold me-1"><i class="ti ti-trending-up me-1 fw-medium align-middle text-success d-inline-flex"></i>1.5%</span>
                                            <span class="text-default op-6">This Month</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body  ">
                                <div class="d-flex gap-3">
                                    <div class="avatar avatar-md bg-success svg-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><path d="M48,208H16a8,8,0,0,1-8-8V160a8,8,0,0,1,8-8H48Z" opacity="0.2"/><path d="M204,56a28,28,0,0,0-12,2.71h0A28,28,0,1,0,176,85.29h0A28,28,0,1,0,204,56Z" opacity="0.2"/><circle cx="204" cy="84" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M48,208H16a8,8,0,0,1-8-8V160a8,8,0,0,1,8-8H48" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M112,160h32l67-15.41a16.61,16.61,0,0,1,21,16h0a16.59,16.59,0,0,1-9.18,14.85L184,192l-64,16H48V152l25-25a24,24,0,0,1,17-7H140a20,20,0,0,1,20,20h0a20,20,0,0,1-20,20Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M176,85.29A28,28,0,1,1,192,58.71" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                                    </div>
                                    <div>
                                        <div class="flex-fill fw-medium fs-13 mb-1 text-dark">Total Revenue</div>
                                        <div class="fs-22 fw-semibold mb-1 text-success">$15,482</div>
                                        <div class="d-flex align-items-center  fs-11">
                                            <span class="text-danger fw-semibold me-1"><i class="ti ti-trending-down me-1 fw-medium align-middle text-danger d-inline-flex"></i>3.4%</span>
                                            <span class="text-default op-6">This Month</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body ">
                                <div class="d-flex gap-3">
                                    <div class="avatar avatar-md bg-pink svg-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><circle cx="84" cy="108" r="52" opacity="0.2"/><path d="M10.23,200a88,88,0,0,1,147.54,0" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M172,160a87.93,87.93,0,0,1,73.77,40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><circle cx="84" cy="108" r="52" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M152.69,59.7A52,52,0,1,1,172,160" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                                    </div>
                                    <div>
                                        <div class="flex-fill fw-medium fs-13 mb-1 text-dark">Total Customers</div>
                                        <div class="fs-22 fw-semibold mb-1 text-pink">3,532</div>
                                        <div class="d-flex align-items-center fs-11">
                                            <span class="text-danger fw-semibold me-1"><i class="ti ti-trending-down me-1 fw-medium align-middle text-danger d-inline-flex"></i>4.5%</span>
                                            <span class="text-default op-6">This Month</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title">
                                    Sales Revenue
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="sales-revenue"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title mb-0 pb-0">
                                    Visitors By Gender
                                </div>
                            </div>
                            <div class="card-body pb-0 p-0 mb-0">
                                <div id="orders-summary"></div>
                            </div>
                            <div class="card-footer mt-0">
                                <div class="row gy-3">
                                    <div class="col-xl-12">
                                        <div class="d-flex align-items-center gap-2 py-1">
                                            
                                            <div class="d-flex align-items-center justify-content-between flex-fill">
                                                <i class="ri-checkbox-blank-circle-fill align-middle me-2 d-inline-block text-primary"></i>
                                                <span class="d-block flex-fill">Male</span>
                                                <span class="d-block fw-semibold h6 mb-0"><span class="me-2 text-success fs-13 d-inline-flex align-items-center"><i class="ti ti-arrow-narrow-up align-middle"></i>0.75%</span>1,754</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="d-flex align-items-center gap-2 py-1">
                                            
                                            <div class="d-flex align-items-center justify-content-between flex-fill">
                                                <i class="ri-checkbox-blank-circle-fill align-middle me-2 d-inline-block text-secondary"></i>
                                                <span class="d-block flex-fill">Female</span>
                                                <span class="d-block fw-semibold h6 mb-0"><span class="me-2 text-danger fs-13 d-inline-flex align-items-center"><i class="ti ti-arrow-narrow-down align-middle"></i>1.64%</span> 834</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="d-flex align-items-center gap-2 py-1">
                                            
                                            <div class="d-flex align-items-center justify-content-between flex-fill">
                                                <i class="ri-checkbox-blank-circle-fill align-middle me-2 d-inline-block text-success"></i>
                                                <span class="d-block flex-fill">Others</span>
                                                <span class="d-block fw-semibold h6 mb-0"><span class="me-2 text-danger fs-13 d-inline-flex align-items-center"><i class="ti ti-arrow-narrow-down align-middle"></i>2.64%</span> 549</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="d-flex align-items-center gap-2 py-1">
                                            
                                            <div class="d-flex align-items-center justify-content-between flex-fill">
                                                <i class="ri-checkbox-blank-circle-fill align-middle me-2 d-inline-block text-pink"></i>
                                                <span class="d-block flex-fill">Not mentioned</span>
                                                <span class="d-block fw-semibold h6 mb-0"><span class="me-2 text-success fs-13 d-inline-flex align-items-center"><i class="ti ti-arrow-narrow-up align-middle"></i>0.64%</span>234 </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card custom-card">
                            <div class="card-header justify-content-between">
                                <div class="card-title">
                                    Visitors By Countries
                                </div>
                                <button class="btn btn-sm btn-primary-light">View All
                                    <i class="ti ti-arrow-narrow-right ms-2 d-inline-block align-center rtl-transform-icon"></i>
                                </button>
                            </div>
                            <div class="card-body p-0 py-2 my-1">
                                <div class="table-responsive">
                                    <table class="table text-nowrap">
                                        <thead>
                                            <tr>
                                                <th scope="col">Countries</th>

                                                <th scope="col"> Percentage</th>
                                                <th scope="col">Visitors</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider">
                                            <tr>
                                                <th scope="row ">
                                                    <div class="lh-1 d-flex align-items-center gap-2 py-1">
                                                        <span
                                                            class="avatar avatar-xs avatar-rounded text-default">
                                                            <img src="assets/images/flags/us_flag.jpg"
                                                                alt="">
                                                        </span>
                                                        <span>United States</span>
                                                    </div>
                                                </th>
                                                <td><a href="javascript:void(0);" class="text-success">24.23%<i
                                                            class="ri-arrow-up-fill ms-1"></i></a></td>
                                                <td class="fw-semibold">32,190</td>
                                            </tr>
                                            <tr>
                                                <th scope="row ">
                                                    <div class=" lh-1 d-flex align-items-center gap-2 py-1">
                                                        <span
                                                            class="avatar avatar-xs avatar-rounded text-default">
                                                            <img src="assets/images/flags/argentina_flag.jpg"
                                                                alt="">
                                                        </span>
                                                        <span>Argentina</span>
                                                    </div>
                                                </th>

                                                <td><a href="javascript:void(0);" class="text-danger">12.45%<i
                                                            class="ri-arrow-down-fill ms-1"></i></a></td>
                                                <td class="fw-semibold">123/985</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <div class="lh-1 d-flex align-items-center gap-2 py-1">
                                                        <span
                                                            class="avatar avatar-xs avatar-rounded text-default">
                                                            <img src="assets/images/flags/canada_flag.jpg"
                                                                alt="">
                                                        </span>
                                                        <span class="fs-14">Canada</span>
                                                    </div>
                                                </th>

                                                <td><a href="javascript:void(0);" class="text-success">06.64%<i
                                                            class="ri-arrow-up-fill ms-1"></i></a></td>
                                                <td class="fw-semibold">10,397</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <div class="lh-1 d-flex align-items-center gap-2 py-1">
                                                        <span
                                                            class="avatar avatar-xs avatar-rounded text-default">
                                                            <img src="assets/images/flags/india_flag.jpg"
                                                                alt="">
                                                        </span>
                                                        <span class="fs-14">India</span>
                                                    </div>
                                                </th>

                                                <td><a href="javascript:void(0);" class="text-success">14.42%<i
                                                            class="ri-arrow-up-fill ms-1"></i></a></td>
                                                <td class=" fw-semibold">18,694</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <div class="lh-1 d-flex align-items-center gap-2 py-1">
                                                        <span
                                                            class="avatar avatar-xs avatar-rounded text-default">
                                                            <img src="assets/images/flags/italy_flag.jpg"
                                                                alt="">
                                                        </span>
                                                        <span class="fs-14">Italy</span>
                                                    </div>
                                                </th>

                                                <td><a href="javascript:void(0);" class="text-success">06.64%<i
                                                            class="ri-arrow-up-fill ms-1"></i></a></td>
                                                <td class="fw-semibold">15,386</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="border-bottom-0">
                                                    <div class="lh-1 d-flex align-items-center gap-2 py-1">
                                                        <span
                                                            class="avatar avatar-xs avatar-rounded text-default">
                                                            <img src="assets/images/flags/germany_flag.jpg"
                                                                alt="">
                                                        </span>
                                                        <span class="fs-14">Germany</span>
                                                    </div>
                                                </th>

                                                <td class="border-bottom-0 py-1"><a href="javascript:void(0);"
                                                        class="text-success">06.64%<i
                                                            class="ri-arrow-up-fill ms-1"></i></a></td>
                                                <td class=" border-bottom-0 fw-semibold">17,479</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card custom-card">
                            <div class="card-header justify-content-between">
                                <div class="card-title">
                                    Sales Summary
                                </div>
                                <div class="dropdown"> 
                                    <a href="javascript:void(0);" class="p-2 fs-12 text-muted" data-bs-toggle="dropdown" aria-expanded="true"> Sort By <i class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i> </a> 
                                    <ul class="dropdown-menu"> 
                                        <li><a class="dropdown-item" href="javascript:void(0);">This Week</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Last Week</a></li> 
                                            <li><a class="dropdown-item" href="javascript:void(0);">This Month</a></li> 
                                    </ul> 
                                </div>
                            </div>
                            <div class="card-body mx-auto">
                                <div id="sales-summary"></div>
                            </div>
                            <div class="card-footer">
                                <div class="row gy-3">
                                    <div class="col-xl-6">
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <div>
                                                <span class="avatar avatar-sm bg-primary-transparent">
                                                    <i class="ti ti-box fs-17"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between flex-fill gap-1">
                                                <span class=" flex-fill">Delivered</span>
                                                <span class="fw-semibold h6 mb-0">1,754</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <div>
                                                <span class="avatar avatar-sm bg-secondary-transparent">
                                                    <i class="ti ti-circle-x fs-17"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between flex-fill gap-1">
                                                <span class="d-block flex-fill">Cancelled</span>
                                                <span class="d-block fw-semibold h6 mb-0">1,234</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <div>
                                                <span class="avatar avatar-sm bg-success-transparent">
                                                    <i class="ti ti-file-alert fs-17"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between flex-fill gap-1">
                                                <span class="d-block flex-fill">Pending</span>
                                                <span class="d-block fw-semibold h6 mb-0">873</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <div>
                                                <span class="avatar avatar-sm bg-pink-transparent">
                                                    <i class="ti ti-jump-rope fs-17"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between flex-fill gap-1">
                                                <span class="d-block flex-fill">Returned</span>
                                                <span class="d-block fw-semibold h6 mb-0">270</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-header pb-0 justify-content-between">
                                <div class="card-title">
                                    Overall Statistics
                                </div>
                                <a href="javascript:void(0);" class="btn btn-light btn-wave btn-sm text-muted waves-effect waves-light">View All</a>
                            </div>
                            <div class="card-body ">
                                <ul class="list-group activity-feed ">
                                    <li class="list-group-item py-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="lh-1">
                                                <p class="mb-2 fs-13 text-muted">Total Expenses</p>
                                                <h6 class="fw-medium mb-0">$134,032<span class="fs-12 text-success ms-2 fw-normal d-inline-block">0.45%<i class="ti ti-trending-up ms-1 d-inline-flex"></i></span></h6>
                                            </div>
                                            <div class="text-end">
                                                <div id="line-graph1"></div>
                                                
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item py-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="lh-1">
                                                <p class="mb-2 fs-13 text-muted">General Leads</p>
                                                <h6 class="fw-medium mb-0">74,354<span class="fs-12 text-danger ms-2 fw-normal d-inline-block">3.84%<i class="ti ti-trending-down ms-1 d-inline-flex"></i></span></h6>
                                            </div>
                                            <div class="text-end">
                                                <div id="line-graph2"></div>
                                                
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item py-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="lh-1">
                                                <p class="mb-2 fs-13 text-muted">Churn Rate</p>
                                                <h6 class="fw-medium mb-0">6.02%<span class="fs-12 text-success ms-2 fw-normal d-inline-block">0.72%<i class="ti ti-trending-up ms-1 d-inline-flex"></i></span></h6>
                                            </div>
                                            <div class="text-end">
                                                <div id="line-graph3"></div>
                                                
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item py-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="lh-1">
                                                <p class="mb-2 fs-13 text-muted">New Users</p>
                                                <h6 class="fw-medium mb-0">7,893<span class="fs-12 text-success ms-2 fw-normal d-inline-block">11.05%<i class="ti ti-trending-up ms-1 d-inline-flex"></i></span></h6>
                                            </div>
                                            <div class="text-end">
                                                <div id="line-graph4"></div>
                                                
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item py-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="lh-1">
                                                <p class="mb-2 fs-13 text-muted">Returning Users</p>
                                                <h6 class="fw-medium mb-0">3,258<span class="fs-12 text-success ms-2 fw-normal d-inline-block">1.69%<i class="ti ti-trending-up ms-1 d-inline-flex"></i></span></h6>
                                            </div>
                                            <div class="text-end">
                                                <div id="line-graph5"></div>
                                                
                                            </div>
                                        </div>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-header justify-content-between">
                                <div class="card-title">
                                    Recent Orders
                                </div>
                                <div class="d-flex flex-wrap gap-2"> 
                                    <div> 
                                        <input class="form-control form-control-sm" type="text" placeholder="Search Here" aria-label=".form-control-sm example"> 
                                    </div> 
                                    <div class="dropdown"> 
                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm btn-wave waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false"> Sort By<i class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i> 
                                        </a> 
                                        <ul class="dropdown-menu" role="menu"> 
                                            <li><a class="dropdown-item" href="javascript:void(0);">New</a></li> 
                                            <li><a class="dropdown-item" href="javascript:void(0);">Popular</a></li> 
                                            <li><a class="dropdown-item" href="javascript:void(0);">Relevant</a></li> 
                                        </ul> 
                                    </div> 
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table text-nowrap table-hover">
                                        <thead>
                                            
                                            <th>Customer</th>
                                            <th>Products</th>
                                            <th>Ordered Date</th>
                                            <th>Status</th>
                                            <th>Total Amount</th>
                                            <th>Payment Method</th>
                                            <th>Actions</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="lh-1">
                                                            <span class="avatar avatar-md bg-primary-transparent">
                                                                JD
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="fw-semibold d-block">John Doe</span>
                                                            <span class="text-muted fs-12">#SPK1001</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="lh-1">
                                                            <span class="avatar avatar-sm avatar-rounded">
                                                                <img src="assets/images/ecommerce/png/20.png" alt="">
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <span class="d-block fw-semibold">Wrist Watch</span>
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold d-block">2024-10-05</span>
                                                    <span class="fs-12 text-muted">12:45PM</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary">Shipped</span>
                                                </td>
                                                <td>
                                                    $150.00
                                                </td>
                                                <td>
                                                    <div>
                                                        <i class="ri-bank-card-line me-1 fs-14"></i>Credit Card
                                                    </div>
                                                    <div class="fs-12 text-muted">**** **** 1111</div>
                                                </td>
                                                <td>
                                                    <div class="btn-list">
                                                        <button class="btn btn-primary-light btn-icon btn-sm "><i class="ri-eye-line"></i></button>
                                                        <button class="btn btn-secondary-light btn-icon btn-sm "><i class="ti ti-pencil"></i></button>

                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="lh-1">
                                                            <span class="avatar avatar-md bg-primary-transparent">
                                                                JS
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="fw-semibold d-block">Jane Smith</span>
                                                            <span class="text-muted fs-12">#SPK1002</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="lh-1">
                                                            <span class="avatar avatar-sm avatar-rounded">
                                                                <img src="assets/images/ecommerce/png/16.png" alt="">
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <span class="d-block fw-semibold">Teddy Bear</span>
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold d-block">2024-10-06</span>
                                                    <span class="fs-12 text-muted">10:15AM</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">Pending</span>
                                                </td>
                                                <td>
                                                    $230.00
                                                </td>
                                                <td>
                                                    <div>
                                                        <i class="ri-bank-card-line me-1 fs-14"></i>MasterCard
                                                    </div>
                                                    <div class="fs-12 text-muted">**** **** 4444</div>
                                                </td>
                                                <td>
                                                    <div class="btn-list">
                                                        <button class="btn btn-primary-light btn-icon btn-sm "><i class="ri-eye-line"></i></button>
                                                        <button class="btn btn-secondary-light btn-icon btn-sm "><i class="ti ti-pencil"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="lh-1">
                                                            <span class="avatar avatar-md bg-primary-transparent">
                                                                BL
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="fw-semibold d-block">Bob Lee</span>
                                                            <span class="text-muted fs-12">#SPK1003</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="lh-1">
                                                            <span class="avatar avatar-sm avatar-rounded">
                                                                <img src="assets/images/ecommerce/png/23.png" alt="">
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <span class="d-block fw-semibold">Shoes</span>
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold d-block">2024-10-07</span>
                                                    <span class="fs-12 text-muted">04:53PM</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success">Delivered</span>
                                                </td>
                                                <td>
                                                    $120.00
                                                </td>
                                                <td>
                                                    <div>
                                                        <i class="ri-bank-card-line me-1 fs-14"></i>Bank Transfer
                                                    </div>
                                                    <div class="fs-12 text-muted">Direct Payment</div>
                                                </td>
                                                <td>
                                                    <div class="btn-list">
                                                        <button class="btn btn-primary-light btn-icon btn-sm "><i class="ri-eye-line"></i></button>
                                                        <button class="btn btn-secondary-light btn-icon btn-sm "><i class="ti ti-pencil"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="lh-1">
                                                            <span class="avatar avatar-md bg-primary-transparent">
                                                                AJ
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="fw-semibold d-block">Alice Johnson</span>
                                                            <span class="text-muted fs-12">#SPK1004</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="lh-1">
                                                            <span class="avatar avatar-sm avatar-rounded">
                                                                <img src="assets/images/ecommerce/png/11.png" alt="">
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <span class="d-block fw-semibold">Over Coat</span>
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold d-block">2024-10-08</span>
                                                    <span class="fs-12 text-muted">11:26AM</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger">Cancelled</span>
                                                </td>
                                                <td>
                                                    $85.00
                                                </td>
                                                <td>
                                                    <div>
                                                        <i class="ri-bank-card-line me-1 fs-14"></i>American Express
                                                    </div>
                                                    <div class="fs-12 text-muted">****** 10005</div>
                                                </td>
                                                <td>
                                                    <div class="btn-list">
                                                        <button class="btn btn-primary-light btn-icon btn-sm "><i class="ri-eye-line"></i></button>
                                                        <button class="btn btn-secondary-light btn-icon btn-sm "><i class="ti ti-pencil"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                
                                                <td class="border-bottom-0">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="lh-1">
                                                            <span class="avatar avatar-md bg-primary-transparent">
                                                                MB
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="fw-semibold d-block">Michael Brown</span>
                                                            <span class="text-muted fs-12">#SPK1005</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="lh-1">
                                                            <span class="avatar avatar-sm avatar-rounded">
                                                                <img src="assets/images/ecommerce/png/13.png" alt="">
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <span class="d-block fw-semibold">Leather Watch</span>
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <span class="fw-semibold d-block">2024-10-09</span>
                                                    <span class="fs-12 text-muted">03:29PM</span>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <span class="badge bg-primary">Shipped</span>
                                                </td>
                                                <td class="border-bottom-0">
                                                    $500.00
                                                </td>
                                                <td class="border-bottom-0">
                                                    <div>
                                                        <i class="ri-bank-card-line me-1 fs-14"></i>PayPal
                                                    </div>
                                                    <div class="fs-12 text-muted">PayPal App</div>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <div class="btn-list">
                                                        <button class="btn btn-primary-light btn-icon btn-sm "><i class="ri-eye-line"></i></button>
                                                        <button class="btn btn-secondary-light btn-icon btn-sm "><i class="ti ti-pencil"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer py-2"> 
                                <div class="d-flex align-items-center "> 
                                    <div> Showing 5 Entries <i class="bi bi-arrow-right ms-2 fw-semibold"></i> </div>
                                    <div class="ms-auto"> 
                                    <nav aria-label="Page navigation" class="pagination-style-4"> 
                                        <ul class="pagination mb-0"> 
                                            <li class="page-item disabled"> <a class="page-link" href="javascript:void(0);"> Prev </a> </li>
                                                <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li> 
                                                <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li> 
                                                <li class="page-item"> <a class="page-link text-primary" href="javascript:void(0);"> next </a> </li> 
                                            </ul> 
                                        </nav> 
                                    </div> 
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3">
                <div class="row">
                    <div class="col-xl-12 ">
                        <div class="card custom-card bg-primary-transparent main-banner-img overflow-hidden border border-primary border-opacity-10">
                            <div class="card-body p-4">
                                <div class="row justify-content-between">
                                    <div class="col-xxl-8 col-xl-7 col-6">
                                    <div class="ps-2 pe-0 py-1">
                                        <h5 class="mb-2 fw-semibold">Upgrade to get more</h5>
                                        <p class="mb-4 pt-1">Enhance your experience with advanced tools. Gain access to exclusive features now!"</p>
                                        <a href="javascript:void(0);" class="fw-semibold text-primary text-decoration-underline">Upgrade To Pro<i class="ti ti-arrow-narrow-right"></i></a>
                                    </div> 
                                    </div>
                                    <div class="col-xxl-4 col-xl-2 col-sm-3 col-5">
                                    <img src="assets/images/media/media-78.png" class="dash-img">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header justify-content-between ">
                                <div class="card-title">
                                    Recent Transactions
                                </div>
                                <a href="javascript:void(0);" class="fs-12 text-muted fw-medium bg-light rounded p-1"> View All<i class="ti ti-arrow-narrow-right ms-1"></i> </a>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled recent-transactions-list">
                                    <li>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="lh-1">
                                                <span class="avatar avatar-md avatar-rounded">
                                                    <img src="assets/images/ecommerce/jpg/1.jpg" alt="">
                                                </span>
                                            </div>
                                            <div class="flex-fill">
                                                <span class="d-block fw-semibold">Wireless Headphones</span>
                                                <span class="d-block text-muted fs-12">2024-10-08, 14:35</span>
                                            </div>
                                            <div class="text-end">
                                                
                                                <span class="d-block fs-11 fw-medium mt-1 text-danger ">$150.00</span>
                                                <span class="badge text-success">Paid</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="lh-1">
                                                <span class="avatar avatar-md avatar-rounded">
                                                    <img src="assets/images/ecommerce/jpg/2.jpg" alt="">
                                                </span>
                                            </div>
                                            <div class="flex-fill">
                                                <span class="d-block fw-semibold">Smartwatch</span>
                                                <span class="d-block text-muted fs-12">2024-10-08, 13:20</span>
                                            </div>
                                            <div class="text-end">
                                                
                                                <span class="d-block fs-11 fw-medium mt-1 text-primary">$275.50</span>
                                                <span class="badge text-orange">Pending</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="lh-1">
                                                <span class="avatar avatar-md avatar-rounded">
                                                    <img src="assets/images/ecommerce/jpg/5.jpg" alt="">
                                                </span>
                                            </div>
                                            <div class="flex-fill">
                                                <span class="d-block fw-semibold">Gaming Laptop</span>
                                                <span class="d-block text-muted fs-12">2024-10-08, 12:05</span>
                                            </div>
                                            <div class="text-end">
                                                
                                                <span class="d-block fs-11 fw-medium mt-1 text-info ">$250.00</span>
                                                <span class="badge text-success">Paid</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="lh-1">
                                                <span class="avatar avatar-md avatar-rounded">
                                                    <img src="assets/images/ecommerce/jpg/7.jpg" alt="">
                                                </span>
                                            </div>
                                            <div class="flex-fill">
                                                <span class="d-block fw-semibold">Bluetooth Speaker</span>
                                                <span class="d-block text-muted fs-12">2024-10-08, 11:50</span>
                                            </div>
                                            <div class="text-end">
                                                
                                                <span class="d-block fs-11 fw-medium mt-1 text-secondary ">$120.00</span>
                                                <span class="badge text-success">Paid</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="lh-1">
                                                <span class="avatar avatar-md avatar-rounded">
                                                    <img src="assets/images/ecommerce/jpg/8.jpg" alt="">
                                                </span>
                                            </div>
                                            <div class="flex-fill">
                                                <span class="d-block fw-semibold">Fitness Tracker</span>
                                                <span class="d-block text-muted fs-12">2024-10-08, 10:30</span>
                                            </div>
                                            <div class="text-end">
                                                
                                                <span class="d-block fs-11 fw-medium mt-1 text-primary ">$160.00</span>
                                                <span class=" badge text-danger">Failed</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="lh-1">
                                                <span class="avatar avatar-md avatar-rounded">
                                                    <img src="assets/images/ecommerce/jpg/3.jpg" alt="">
                                                </span>
                                                
                                            </div>
                                            <div class="flex-fill">
                                                <span class="d-block fw-semibold">DSLR Camera</span>
                                                <span class="d-block text-muted fs-12">2024-10-08, 14:35</span>
                                            </div>
                                            <div class="text-end">
                                                
                                                <span class="d-block fs-11 fw-medium mt-1  text-orange">$150.00</span>
                                                <span class="badge text-success">Paid</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header pb-0">
                                <div class="card-title">Visitors By Device</div>
                            </div>
                            <div class="card-body px-1">
                                <div id="visitors-device"></div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card custom-card overflow-hidden ">
                            <div class="card-header justify-content-between py-3 mt-2">
                                <div class="card-title">
                                    Transactions
                                </div>
                                <a href="javascript:void(0);" class="fs-12 text-muted"> View All<i class="ti ti-arrow-narrow-right ms-1"></i> </a>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled transactions-list mb-0">
                                    <li>
                                        <div class="d-flex align-items-center justify-content-between py-2 pt-1">
                                            <div class="d-flex align-items-start flex-wrap gap-2">
                                                <div>
                                                    <span class="avatar avatar-sm bg-primary-transparent">
                                                        <i class="ri-paypal-line fs-18"></i> 
                                                    </span>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0);">
                                                        <span class="d-block fw-medium mb-1">Paypal ****2783</span>
                                                    </a>
                                                    <span class="d-block fs-11 text-muted">15,Mar 2024 at 4:25PM</span>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="d-block fw-medium">$15,260</span>
                                                <span class="text-success fs-12">Paid</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center justify-content-between py-2">
                                            <div class="d-flex align-items-start flex-wrap gap-2">
                                                <div>
                                                    <span class="avatar avatar-sm bg-secondary-transparent">
                                                        <i class="ri-wallet-3-line fs-18"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0);">
                                                        <span class="d-block fw-medium mb-1">Digital Wallet</span>
                                                    </a>    
                                                    <span class="d-block fs-11 text-muted">13,May 2024 at 11:21AM</span>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="d-block fw-medium">$11,449</span>
                                                <span class="text-success fs-12">Paid</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center justify-content-between py-2">
                                            <div class="d-flex align-items-start flex-wrap gap-2">
                                                <div>
                                                    <span class="avatar avatar-sm bg-success-transparent">
                                                        <i class="ri-mastercard-line fs-18"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0);">
                                                        <span class="d-block fw-medium mb-1">Mastro Card ****7893</span>
                                                    </a>    
                                                    <span class="d-block fs-11 text-muted">16,Feb 2024 at 4:36PM</span>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="d-block fw-medium">$10,999</span>
                                                <span class="text-danger fs-12">Pending</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center justify-content-between py-2">
                                            <div class="d-flex align-items-start flex-wrap gap-2">
                                                <div>
                                                    <span class="avatar avatar-sm bg-info-transparent">
                                                        <i class="ri-visa-line fs-18"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0);">
                                                        <span class="d-block fw-medium mb-1">Visa Card ****2563</span>
                                                    </a>    
                                                    <span class="d-block fs-11 text-muted">21,Mar 2024 at 10:15AM</span>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="d-block fw-medium">$9,249</span>
                                                <span class="text-success fs-12">Paid</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center justify-content-between py-2">
                                            <div class="d-flex align-items-start flex-wrap gap-2">
                                                <div>
                                                    <span class="avatar avatar-sm bg-primary-transparent">
                                                        <i class="ri-paypal-line fs-18"></i> 
                                                    </span>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0);">
                                                        <span class="d-block fw-medium mb-1">Paypal ****2783</span>
                                                    </a>
                                                    <span class="d-block fs-11 text-muted">24,Jul 2024 at 2:45PM</span>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="d-block fw-medium">$12,300</span>
                                                <span class="text-success fs-12">Paid</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center justify-content-between py-2">
                                            <div class="d-flex align-items-start flex-wrap gap-2">
                                                <div>
                                                    <span class="avatar avatar-sm bg-secondary-transparent">
                                                        <i class="ri-wallet-3-line fs-18"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0);">
                                                        <span class="d-block fw-medium mb-1">Digital Wallet</span>
                                                    </a>    
                                                    <span class="d-block fs-11 text-muted">13,May 2024 at 11:21AM</span>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="d-block fw-medium">$11,449</span>
                                                <span class="text-success fs-12">Paid</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center justify-content-between py-2">
                                            <div class="d-flex align-items-start flex-wrap gap-2">
                                                <div>
                                                    <span class="avatar avatar-sm bg-success-transparent">
                                                        <i class="ri-mastercard-line fs-18"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0);">
                                                        <span class="d-block fw-medium mb-1">Mastro Card ****7893</span>
                                                    </a>    
                                                    <span class="d-block fs-11 text-muted">16,Feb 2024 at 4:36PM</span>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="d-block fw-medium">$10,999</span>
                                                <span class="text-danger fs-12">Pending</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End:: row-1 -->


    </div>
</div>
<!-- End::app-content -->

<!-- Start::main-modal -->

<div class="modal fade" id="header-responsive-search" tabindex="-1" aria-labelledby="header-responsive-search" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="input-group">
                    <input type="text" class="form-control border-end-0" placeholder="Search Anything ..."
                        aria-label="Search Anything ..." aria-describedby="button-addon2">
                    <button class="btn btn-primary" type="button"
                        id="button-addon2"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>    

@endsection