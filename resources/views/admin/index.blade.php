@extends('admin.layouts.layout')
@section('styles')
@endsection
@section('content')
 <div class="main-content app-content">
                <div class="container-fluid">
                    
                    <!-- Start::page-header -->
                    <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div>
                            <h1 class="page-title fw-medium fs-18 mb-2">Analytics</h1>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript:void(0);">Dashboards</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Analytics</li>
                            </ol>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <div class="d-flex gap-2">
                                <div class="position-relative">
                                    <button class="btn btn-primary btn-wave" type="button" id="dropdownMenuClickableInside"
                                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
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
                                <button class="btn btn-secondary btn-icon btn-wave" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="Download">
                                    <i class="ti ti-download"></i>
                                </button>
                                <button class="btn btn-success btn-icon btn-wave" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="Share">
                                    <i class="ti ti-share-3"></i>
                                </button>
                            </div>
                        </div>
                    </div>                
                    <!-- End::page-header -->

                    <!-- Start:: row-1 -->
                    <div class="row">
                        <div class="col-xxl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="card custom-card">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <div>
                                            <p class="fw-medium mb-2">Total Income</p>
                                            <h5 class="fw-semibold mb-3">$45,248.05</h5>
                                            <div>
                                                <span class="badge bg-success-transparent me-2 d-inline-block"><i
                                                        class="ri-arrow-up-line lh-1"></i> 0.45%</span>
                                                <span class="text-muted fs-12">From Last Month</span>
                                            </div>
                                        </div>
                                        <div class="main-card-icon primary">
                                            <div
                                                class="avatar avatar-lg bg-primary border border-primary border-opacity-10 svg-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8s8 3.59 8 8s-3.59 8-8 8m.31-8.86c-1.77-.45-2.34-.94-2.34-1.67c0-.84.79-1.43 2.1-1.43c1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81c0 1.79 1.49 2.69 3.66 3.21c1.95.46 2.34 1.15 2.34 1.87c0 .53-.39 1.39-2.1 1.39c-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77c-.01-2.2-1.9-2.96-3.66-3.42" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="card custom-card">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <div>
                                            <p class="fw-medium mb-2">Total Profit</p>
                                            <h5 class="fw-semibold mb-3">$12,768.40</h5>
                                            <div>
                                                <span class="badge bg-danger-transparent me-2 d-inline-block"><i
                                                        class="ri-arrow-down-line lh-1"></i> 1.25%</span>
                                                <span class="text-muted fs-12">From Last Month</span>
                                            </div>
                                        </div>
                                        <div class="main-card-icon secondary">
                                            <div
                                                class="avatar avatar-lg bg-secondary border border-secondary border-opacity-10 svg-secondary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="m16.85 6.85l1.44 1.44l-4.88 4.88l-3.29-3.29a.996.996 0 0 0-1.41 0l-6 6.01a.996.996 0 1 0 1.41 1.41L9.41 12l3.29 3.29c.39.39 1.02.39 1.41 0l5.59-5.58l1.44 1.44a.5.5 0 0 0 .85-.35V6.5a.48.48 0 0 0-.49-.5h-4.29a.5.5 0 0 0-.36.85" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="card custom-card">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <div>
                                            <p class="fw-medium mb-2">Average Sessions</p>
                                            <h5 class="fw-semibold mb-3">1,250</h5>
                                            <div>
                                                <span class="badge bg-success-transparent me-2 d-inline-block"><i
                                                        class="ri-arrow-up-line lh-1"></i> 5.80%</span>
                                                <span class="text-muted fs-12">From Last Month</span>
                                            </div>
                                        </div>
                                        <div class="main-card-icon success">
                                            <div
                                                class="avatar avatar-lg bg-success border border-success border-opacity-10 svg-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M15 1H9v2h6zm-4 13h2V8h-2zm8.03-6.61l1.42-1.42c-.43-.51-.9-.99-1.41-1.41l-1.42 1.42A8.96 8.96 0 0 0 12 4c-4.97 0-9 4.03-9 9s4.02 9 9 9a8.994 8.994 0 0 0 7.03-14.61M12 20c-3.87 0-7-3.13-7-7s3.13-7 7-7s7 3.13 7 7s-3.13 7-7 7" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="card custom-card">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <div>
                                            <p class="fw-medium mb-2">Conversion Rate</p>
                                            <h5 class="fw-semibold mb-3">3.75%</h5>
                                            <div>
                                                <span class="badge bg-success-transparent me-2 d-inline-block"><i
                                                        class="ri-arrow-up-line lh-1"></i> 0.95%</span>
                                                <span class="text-muted fs-12">From Last Month</span>
                                            </div>
                                        </div>
                                        <div class="main-card-icon pink">
                                            <div
                                                class="avatar avatar-lg bg-pink border border-pink border-opacity-10 svg-pink">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M12.89 11.1c-1.78-.59-2.64-.96-2.64-1.9c0-1.02 1.11-1.39 1.81-1.39c1.31 0 1.79.99 1.9 1.34l1.58-.67c-.15-.45-.82-1.92-2.54-2.24V5h-2v1.26c-2.48.56-2.49 2.86-2.49 2.96c0 2.27 2.25 2.91 3.35 3.31c1.58.56 2.28 1.07 2.28 2.03c0 1.13-1.05 1.61-1.98 1.61c-1.82 0-2.34-1.87-2.4-2.09l-1.66.67c.63 2.19 2.28 2.78 2.9 2.96V19h2v-1.24c.4-.09 2.9-.59 2.9-3.22c0-1.39-.61-2.61-3.01-3.44M3 21H1v-6h6v2H4.52c1.61 2.41 4.36 4 7.48 4a9 9 0 0 0 9-9h2c0 6.08-4.92 11-11 11c-3.72 0-7.01-1.85-9-4.67zm-2-9C1 5.92 5.92 1 12 1c3.72 0 7.01 1.85 9 4.67V3h2v6h-6V7h2.48C17.87 4.59 15.12 3 12 3a9 9 0 0 0-9 9z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- End:: row-1 -->

                    <!-- Start:: row-2 -->
                    <div class="row">
                        <div class="col-xl-8">
                            <div class="card custom-card">
                                <div class="card-header justify-content-between">
                                    <div class="card-title">
                                        Session Insights
                                    </div>
                                    <div class="dropdown">
                                        <a href="javascript:void(0);"
                                            class="fs-12 text-muted fw-medium bg-light rounded p-1"
                                            data-bs-toggle="dropdown" aria-expanded="true"> Sort By <i
                                                class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i> </a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a class="dropdown-item" href="javascript:void(0);">This Week</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Last Week</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">This Month</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="sessions-insights"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card custom-card">
                                <div class="card-header justify-content-between flex-wrap">
                                    <div class="card-title">
                                        Sessions by Country
                                    </div>
                                    <div class="dropdown">
                                        <a aria-label="anchor" href="javascript:void(0);"
                                            class="btn btn-light btn-icon btn-sm text-muted" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="fe fe-more-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end" role="menu">
                                            <li class=""><a class="dropdown-item" href="javascript:void(0);">Today</a></li>
                                            <li class=""><a class="dropdown-item" href="javascript:void(0);">This Week</a>
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Last Week</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled analytics-activity mb-0">
                                        <li>
                                            <div class="d-flex align-items-center gap-2">
                                                <div>
                                                    <span class="avatar avatar-sm avatar-rounded bg-primary-transparent">
                                                        <img src="assets/images/flags/us_flag.jpg" alt="img">
                                                    </span>
                                                </div>
                                                <div class="flex-fill">
                                                    <div class="fw-semibold">United States</div>
                                                    <span class="fs-13 text-muted">Increased by <span
                                                            class="text-success fw-medium ms-1">1.75%<i
                                                                class="ti ti-arrow-narrow-up"></i></span></span>
                                                </div>
                                                <div class="d-flex gap-2 align-items-end">
                                                    <h6 class="mb-0 fw-semibold">23,124</h6>
                                                </div>
                                            </div>
                                            <div class="progress progress-animate progress-sm mt-2" role="progressbar"
                                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                                    style="width: 80%"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center gap-2">
                                                <div>
                                                    <span class="avatar avatar-sm avatar-rounded bg-secondary-transparent">
                                                        <img src="assets/images/flags/spain_flag.jpg" alt="img">
                                                    </span>
                                                </div>
                                                <div class="flex-fill">
                                                    <div class="d-block fw-semibold">Spain</div>
                                                    <span class="fs-13 text-muted">Decreased by <span
                                                            class="text-danger fw-medium ms-1">0.85%<i
                                                                class="ti ti-arrow-narrow-down"></i></span></span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">22,457</h6>
                                                </div>
                                            </div>
                                            <div class="progress progress-animate progress-sm mt-2" role="progressbar"
                                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                                    style="width: 75%"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center gap-2">
                                                <div>
                                                    <span class="avatar avatar-sm avatar-rounded bg-success-transparent">
                                                        <img src="assets/images/flags/french_flag.jpg" alt="img">
                                                    </span>
                                                </div>
                                                <div class="flex-fill">
                                                    <div class="d-block fw-semibold">France</div>
                                                    <span class="fs-13 text-muted">Increased by <span
                                                            class="text-success fw-medium ms-1">3.74%<i
                                                                class="ti ti-arrow-narrow-up"></i></span></span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">23.89k</h6>
                                                </div>
                                            </div>
                                            <div class="progress progress-animate progress-sm mt-2" role="progressbar"
                                                aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                    style="width: 65%"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center gap-2">
                                                <div>
                                                    <span class="avatar avatar-sm avatar-rounded bg-warning-transparent">
                                                        <img src="assets/images/flags/uae_flag.jpg" alt="img">
                                                    </span>
                                                </div>
                                                <div class="flex-fill">
                                                    <div class="d-block fw-semibold">UAE</div>
                                                    <span class="fs-13 text-muted">Increased by <span
                                                            class="text-success fw-medium ms-1">0.23%<i
                                                                class="ti ti-arrow-narrow-up"></i></span></span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">32,567</h6>
                                                </div>
                                            </div>
                                            <div class="progress progress-animate progress-sm mt-2" role="progressbar"
                                                aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-pink"
                                                    style="width: 65%"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center gap-2">
                                                <div>
                                                    <span class="avatar avatar-sm avatar-rounded bg-info-transparent">
                                                        <img src="assets/images/flags/germany_flag.jpg" alt="img">
                                                    </span>
                                                </div>
                                                <div class="flex-fill">
                                                    <div class="d-block fw-semibold">Germany</div>
                                                    <span class="fs-13 text-muted">Decreased by <span
                                                            class="text-danger fw-medium ms-1">4.95%<i
                                                                class="ti ti-arrow-narrow-down"></i></span></span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">84.33k</h6>
                                                </div>
                                            </div>
                                            <div class="progress progress-animate progress-sm mt-2" role="progressbar"
                                                aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                                                    style="width: 65%"></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End:: row-2 -->

                    <!-- Start:: row-3 -->
                    <div class="row">
                        <div class="col-xxl-3">
                            <div class="card custom-card overflow-hidden">
                                <div class="card-header justify-content-between">
                                    <div class="card-title">
                                        New Subscription
                                    </div>
                                    <div class="dropdown">
                                        <a href="javascript:void(0);" class="p-2 bg-primary-transparent fs-12 rounded-1" data-bs-toggle="dropdown"
                                            aria-expanded="true"> Sort By <i
                                                class="ri-arrow-down-s-line align-middle ms-1 lh-1 d-inline-block"></i> </a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a class="dropdown-item" href="javascript:void(0);">This Week</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Last Week</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">This Month</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div id="subscribers"></div>
                                    <ul class="list-group list-group-flush border-top mt-3">
                                        <li class="list-group-item">
                                            <div class="d-flex align-items-center gap-3 p-2 bg-light rounded-2 bg-opacity-50"> 
                                                <span class="avatar avatar-md bg-primary"> 
                                                    <i class="ri-wallet-3-line fs-18"></i> 
                                                </span>
                                                <div>
                                                    <div class="fw-medium text-muted mb-1">New Subscriptions</div>
                                                    <h5 class="mb-0 fw-semibold">4,784 </h5>
                                                </div>
                                                <div class="ms-auto">
                                                    <div class="badge bg-success fw-medium"><i class="ri-arrow-up-s-fill me-1 align-middle"></i>1.05%</div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex align-items-center gap-3 p-2 bg-light rounded-2 bg-opacity-50"> 
                                                <span class="avatar avatar-md bg-secondary"> 
                                                    <i class="ri-wallet-3-line fs-18"></i> 
                                                </span>
                                                <div>
                                                    <div class="fw-medium text-muted mb-1">Active Subscriptions</div>
                                                    <h5 class="mb-0 fw-semibold">3,743</h5>
                                                </div>
                                                <div class="ms-auto">
                                                    <div class="badge bg-danger fw-medium"><i class="ri-arrow-down-s-fill me-1 align-middle"></i>0.35%</div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-9">
                            <div class="row">
                                <div class="col-xxl-5 col-md-12 col-sm-12">
                                    <div class="card custom-card overflow-hidden">
                                        <div class="card-header justify-content-between">
                                            <div class="card-title">
                                                Browser Statistics
                                            </div>
                                            <div class="dropdown">
                                                <a aria-label="anchor" href="javascript:void(0);"
                                                    class="btn btn-light btn-icon btn-sm text-muted" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fe fe-more-vertical"></i>
                                                </a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li class=""><a class="dropdown-item" href="javascript:void(0);">Today</a></li>
                                                    <li class=""><a class="dropdown-item" href="javascript:void(0);">This Week</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="javascript:void(0);">Last Week</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Browser</th>
                                                            <th class="text-center">Sessions</th>
                                                            <th class="text-center">Bounce</th>
                                                            <th class="text-center">Type</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <div>
                                                                        <span class="avatar avatar-rounded avatar-md p-1 bg-light border border-warning border-opacity-10">
                                                                            <img src="assets/images/browsers/safari.png" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="fw-medium">Safari</span>
                                                                        <div class="d-block text-muted fs-12">Apple Corp, Inc</div>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <td class="text-center">1130</td>
                                                            <td class="text-center text-danger">40.15%</td>
                                                            <td class="text-center">Mobile</td>
                                                        </tr>
                                                        <tr>
                                                            <th>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <div>
                                                                        <span class="avatar avatar-rounded avatar-md p-1 bg-light border border-warning border-opacity-10">
                                                                            <img src="assets/images/browsers/firefox.png" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="fw-medium">Firefox</span>
                                                                        <div class="d-block text-muted fs-12">Mozilla, Inc</div>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <td class="text-center">820</td>
                                                            <td class="text-center text-success">34.90%</td>
                                                            <td class="text-center">Desktop</td>
                                                        </tr>
                                                        <tr>
                                                            <th>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <div>
                                                                        <span class="avatar avatar-rounded avatar-md p-1 bg-light border border-warning border-opacity-10">
                                                                            <img src="assets/images/browsers/opera.png" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="fw-medium">Opera</span>
                                                                        <div class="d-block text-muted fs-12">Opera, Inc</div>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <td class="text-center">1330</td>
                                                            <td class="text-center text-danger">26.80%</td>
                                                            <td class="text-center">Desktop</td>
                                                        </tr>
                                                        <tr>
                                                            <th>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <div>
                                                                        <span class="avatar avatar-rounded avatar-md p-1 bg-light border border-warning border-opacity-10">
                                                                            <img src="assets/images/browsers/chrome.png" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="fw-medium">Google Chrome</span>
                                                                        <div class="d-block text-muted fs-12">Google, Inc</div>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <td class="text-center">1220</td>
                                                            <td class="text-center text-success">28.00%</td>
                                                            <td class="text-center">Mobile</td>
                                                        </tr>
                                                        <tr>
                                                            <th>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <div>
                                                                        <span class="avatar avatar-rounded avatar-md p-1 bg-light border border-warning border-opacity-10">
                                                                            <img src="assets/images/browsers/edge.png" alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="fw-medium">Edge</span>
                                                                        <div class="d-block text-muted fs-12">Microsoft Corp, Inc</div>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <td class="text-center">970</td>
                                                            <td class="text-center text-success">25.10%</td>
                                                            <td class="text-center">Desktop</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-7 col-md-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="card custom-card">
                                                <div class="card-header justify-content-between">
                                                    <div class="card-title">Sales Metrics by Region</div>
                                                    <div class="dropdown">
                                                        <a href="javascript:void(0);" class="p-2 fs-12 text-muted"
                                                            data-bs-toggle="dropdown" aria-expanded="true"> Sort By <i
                                                                class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                                                        </a>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a class="dropdown-item" href="javascript:void(0);">This
                                                                    Week</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0);">Last
                                                                    Week</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0);">This
                                                                    Month</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-body pt-1">
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div id="sales-region"></div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="list-group list-group-flush border-start border-inline-start-dashed">
                                                                <div class="list-group-item border-0 country-item">
                                                                    <div class="d-flex align-items-start gap-3 flex-wrap">
                                                                        <div class="avatar avatar-sm avatar-rounded border">
                                                                            <img src="assets/images/flags/argentina_flag.jpg" alt="Argentina Flag">
                                                                        </div>
                                                                        <div>
                                                                            <div class="mb-1 text-muted">Argentina</div>
                                                                            <h6 class="mb-0 fw-semibold">$1,250,000</h6>
                                                                        </div>
                                                                        <div class="ms-auto mb-1 align-self-end fw-medium"><span class="badge bg-success-transparent">+5% Growth</span></div>
                                                                    </div>
                                                                </div>
                                                                <div class="list-group-item border-0 country-item">
                                                                    <div class="d-flex align-items-start gap-3 flex-wrap">
                                                                        <div class="avatar avatar-sm avatar-rounded border">
                                                                            <img src="assets/images/flags/spain_flag.jpg" alt="Spain Flag">
                                                                        </div>
                                                                        <div>
                                                                            <div class="mb-1 text-muted">Spain</div>
                                                                            <h6 class="mb-0 fw-semibold">$850,000</h6>
                                                                        </div>
                                                                        <div class="ms-auto mb-1 align-self-end fw-medium"><span class="badge bg-danger-transparent">-3% Decrease</span></div>
                                                                    </div>
                                                                </div>
                                                                <div class="list-group-item border-0 country-item">
                                                                    <div class="d-flex align-items-start gap-3 flex-wrap">
                                                                        <div class="avatar avatar-sm avatar-rounded border">
                                                                            <img src="assets/images/flags/germany_flag.jpg" alt="Germany Flag">
                                                                        </div>
                                                                        <div>
                                                                            <div class="mb-1 text-muted">Germany</div>
                                                                            <h6 class="mb-0 fw-semibold">$600,000</h6>
                                                                        </div>
                                                                        <div class="ms-auto mb-1 align-self-end fw-medium"><span class="badge bg-success-transparent">+8% Growth</span></div>
                                                                    </div>
                                                                </div>
                                                                <div class="list-group-item border-0 country-item">
                                                                    <div class="d-flex align-items-start gap-3 flex-wrap">
                                                                        <div class="avatar avatar-sm avatar-rounded border">
                                                                            <img src="assets/images/flags/canada_flag.jpg" alt="canada Flag">
                                                                        </div>
                                                                        <div>
                                                                            <div class="mb-1 text-muted">Canada</div>
                                                                            <h6 class="mb-0 fw-semibold">$950,000</h6>
                                                                        </div>
                                                                        <div class="ms-auto mb-1 align-self-end fw-medium"><span class="badge bg-success-transparent">+2% Growth</span></div>
                                                                    </div>
                                                                </div>
                                                                <div class="list-group-item border-0 country-item">
                                                                    <div class="d-flex align-items-start gap-3 flex-wrap">
                                                                        <div class="avatar avatar-sm avatar-rounded border">
                                                                            <img src="assets/images/flags/us_flag.jpg" alt="US Flag">
                                                                        </div>
                                                                        <div>
                                                                            <div class="mb-1 text-muted">United States</div>
                                                                            <h6 class="mb-0 fw-semibold">$350,000</h6>
                                                                        </div>
                                                                        <div class="ms-auto mb-1 align-self-end fw-medium"><span class="badge bg-danger-transparent">-1% Decrease</span></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End:: row-3 -->

                    <!-- Start:: row-4 -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card custom-card">
                                <div class="card-header justify-content-between">
                                    <div class="card-title">
                                        Visitors 
                                    </div>
                                    <div class="d-flex flex-wrap gap-2">
                                        <div>
                                            <input class="form-control form-control-sm" type="text"
                                                placeholder="Search Here" aria-label=".form-control-sm example">
                                        </div>
                                        <div class="dropdown">
                                            <a href="javascript:void(0);"
                                                class="btn btn-primary btn-sm btn-wave waves-effect waves-light"
                                                data-bs-toggle="dropdown" aria-expanded="false"> Sort By<i
                                                    class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
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
                                        <table class="table table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>S.NO</th>
                                                    <th>Top Referral Sources</th>
                                                    <th>New Visitors</th>
                                                    <th>Returned</th>
                                                    <th>Bounce Rate</th>
                                                    <th>Conversion Rate</th>
                                                    <th>Avg. Session</th>
                                                    <th>Total Visitors</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>01</td>
                                                    <td><i class="p-1 bg-danger-transparent ri-google-line lh-1 rounded-circle me-2 d-inline-block"></i>Google</td>
                                                    <td>12,345</td>
                                                    <td>19,845</td>
                                                    <td>45%</td>
                                                    <td><span class="text-success"><i class="ti ti-trending-up me-2 d-inline-block"></i>3.5%</span></td>
                                                    <td>3m 45s</td>
                                                    <td><span class="fw-semibold">32,190</span></td>
                                                </tr>
                                                <tr>
                                                    <td>02</td>
                                                    <td><i class="p-1 bg-teal-transparent ri-facebook-line lh-1 rounded-circle me-2 d-inline-block"></i>Facebook</td>
                                                    <td>10,432</td>
                                                    <td>18,242</td>
                                                    <td>47%</td>
                                                    <td><span class="text-success"><i class="ti ti-trending-up me-2 d-inline-block"></i>3.8%</span></td>
                                                    <td>3m 10s</td>
                                                    <td><span class="fw-semibold">28,674</span></td>
                                                </tr>
                                                <tr>
                                                    <td>03</td>
                                                    <td><i class="p-1 bg-primary-transparent ri-twitter-x-line lh-1 rounded-circle me-2 d-inline-block"></i>Twitter</td>
                                                    <td>13,567</td>
                                                    <td>22,222</td>
                                                    <td>43%</td>
                                                    <td><span class="text-danger"><i class="ti ti-trending-down me-2 d-inline-block"></i>3.2%</span></td>
                                                    <td>4m 05s</td>
                                                    <td><span class="fw-semibold">35,789</span></td>
                                                </tr>
                                                <tr>
                                                    <td>04</td>
                                                    <td><i class="p-1 bg-pink-transparent ri-instagram-line lh-1 rounded-circle me-2 d-inline-block"></i>Instagram</td>
                                                    <td>11,678</td>
                                                    <td>18,556</td>
                                                    <td>46%</td>
                                                    <td><span class="text-success"><i class="ti ti-trending-up me-2 d-inline-block"></i>3.6%</span></td>
                                                    <td>3m 30s</td>
                                                    <td><span class="fw-semibold">30,234</span></td>
                                                </tr>
                                                <tr>
                                                    <td>05</td>
                                                    <td><i class="p-1 bg-danger-transparent ri-youtube-line lh-1 rounded-circle me-2 d-inline-block"></i>Youtube</td>
                                                    <td>12,890</td>
                                                    <td>20,566</td>
                                                    <td>44%</td>
                                                    <td><span class="text-danger"><i class="ti ti-trending-down me-2 d-inline-block"></i>3.4%</span></td>
                                                    <td>3m 55s</td>
                                                    <td><span class="fw-semibold">33,456</span></td>
                                                </tr>
                                            </tbody>                                        
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer border-top-0">
                                    <div class="d-flex align-items-center">
                                        <div> Showing 5 Entries <i class="bi bi-arrow-right ms-2 fw-semibold"></i> </div>
                                        <div class="ms-auto">
                                            <nav aria-label="Page navigation" class="pagination-style-4">
                                                <ul class="pagination mb-0">
                                                    <li class="page-item disabled"> <a class="page-link"
                                                            href="javascript:void(0);"> Prev </a> </li>
                                                    <li class="page-item active"><a class="page-link"
                                                            href="javascript:void(0);">1</a></li>
                                                    <li class="page-item"><a class="page-link"
                                                            href="javascript:void(0);">2</a></li>
                                                    <li class="page-item"> <a class="page-link text-primary"
                                                            href="javascript:void(0);"> next </a> </li>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End:: row-4 -->


                </div>
            </div>
@endsection
@section('scripts')

@endsection