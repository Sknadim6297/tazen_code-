@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
   <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">

<!-- SPECIFIC CSS -->
<link href="{{ asset('frontend/assets/css/listing.css') }}" rel="stylesheet">

<!-- YOUR CUSTOM CSS -->
<link href="{{ asset('frontend/assets/css/custom.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/event-list.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive2.css') }}" media="screen and (max-width: 992px)">

<style>
/* Ensure event cards have consistent image sizes and card body heights */
.event-card .featured-thumbnail { overflow: hidden; }
.event-card-img { width: 100%; height: 220px; object-fit: cover; display: block; }
.featured-content-inner { min-height: 140px; }
@media (max-width: 768px) {
    .event-card-img { height: 160px; }
    .featured-content-inner { min-height: 120px; }
}
</style>


@endsection
@section('content')

<main class="bg_color">

    <div class="hero_single blog-head" style="background-image:{{ asset('frontend/assets/img/event-banner.jpg') }} ;">
        <!-- Content inside the div, if needed -->    
     <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.4)">
         <div class="container">
             <div class="row">
                 <div class="col-xl-12 col-lg-12">
                     <h1>Events Page</h1>
                     <p>Looking for the perfect event? We've got you covered!</p>
                     
                 </div>
             </div>
             <!-- /row -->
         </div>
     </div>
    </div>

    {{-- <div class="filters_full element_to_stick version_2">
        <div class="container clearfix">
            <div class="sort_select">
                <select name="sort" id="sort">
                    <option value="popularity" selected="selected">Sort by Popularity</option>
                    <option value="rating">Sort by Average rating</option>
                    <option value="date">Sort by newness</option>
                </select>
            </div>
            <a href="#0" class="open_filters btn_filters"><i class="icon_adjust-vert"></i><span>Filters</span></a>
            <a class="btn_map mobile btn_filters" data-bs-toggle="collapse" href="#collapseMap"><i class="icon_pin_alt"></i></a>
            <div class="search_bar_list">
                <input type="text" class="form-control" placeholder="Search again...">
            </div>
            <a class="btn_search_mobile btn_filters" data-bs-toggle="collapse" href="#collapseSearch"><i class="icon_search"></i></a>
        </div> --}}
      
    <div class="collapse" id="collapseMap">
        <div id="map" class="map"></div>
    </div>
    <!-- /Map -->
    <div class="collapse" id="collapseSearch">
        <div class="search_bar_list">
            <input type="text" class="form-control" placeholder="Search again...">
        </div>
    </div>
    <!-- /collapseSearch -->
    </div>
    <!-- /filters_full -->
    
    <div class="container margin_30_40">
        <div class="page_header">
            <div class="row">
                <div class="col-lg-3">
                    <h1>Events</h1><span>: 814 found</span>
                </div>
                <div class="col-lg-9">
                    <h1><span>Event in Kolkata</span></h1>
                </div>
            </div>
           
        </div>		
        <div class="row">
            <aside class="col-lg-3" id="sidebar_fixed">
                <div class="filter_col">
                    <div class="inner_bt"><a href="#" class="open_filters"><i class="icon_close"></i></a></div>
                    <div class="filter_type">
                        <h4><a href="#filter_1" data-bs-toggle="collapse" class="opened">Categories</a></h4>
                        <div class="collapse show" id="filter_1">
                            <ul>
                                @foreach($categories as $cat)
                                <li>
                                    <label class="container_check">{{ $cat }}
                                        <input type="checkbox" name="category" value="{{ $cat }}" 
                                            {{ $category == $cat ? 'checked' : '' }}
                                            onchange="window.location.href='{{ route('event.list', ['category' => $cat]) }}'">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- /filter_type -->
                    
                    <!-- /filter_type -->
                    <div class="filter_type">
                        <h4><a href="#filter_3" data-bs-toggle="collapse" class="closed">City</a></h4>
                        <div class="collapse" id="filter_3">
                            <ul>
                                @foreach($cities as $cityName)
                                <li>
                                    <label class="container_check">{{ $cityName }}
                                        <input type="checkbox" name="city" value="{{ $cityName }}"
                                            {{ request('city') == $cityName ? 'checked' : '' }}
                                            onchange="window.location.href='{{ route('event.list', ['city' => $cityName]) }}'">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- /filter_type -->
                    <div class="filter_type">
                        <h4><a href="#filter_4" data-bs-toggle="collapse" class="closed">Event Mode</a></h4>
                        <div class="collapse" id="filter_4">
                            <ul>
                                <li>
                                    <label class="container_check">Online
                                        <input type="checkbox" name="event_mode" value="online"
                                            {{ request('event_mode') == 'online' ? 'checked' : '' }}
                                            onchange="window.location.href='{{ route('event.list', ['event_mode' => 'online']) }}'">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="container_check">Offline
                                        <input type="checkbox" name="event_mode" value="offline"
                                            {{ request('event_mode') == 'offline' ? 'checked' : '' }}
                                            onchange="window.location.href='{{ route('event.list', ['event_mode' => 'offline']) }}'">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /filter_type -->
                    <div class="filter_type">
                        <h4><a href="#filter_5" data-bs-toggle="collapse" class="closed">Price</a></h4>
                        <div class="collapse" id="filter_5">
                            <ul>
                                <li>
                                    <label class="container_check">₹0 — ₹500
                                        <input type="checkbox" name="price_range" value="0-500"
                                            {{ $price_range == '0-500' ? 'checked' : '' }}
                                            onchange="window.location.href='{{ route('event.list', ['price_range' => '0-500']) }}'">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="container_check">₹500 — ₹1000
                                        <input type="checkbox" name="price_range" value="500-1000"
                                            {{ $price_range == '500-1000' ? 'checked' : '' }}
                                            onchange="window.location.href='{{ route('event.list', ['price_range' => '500-1000']) }}'">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="container_check">₹1000 — ₹2500
                                        <input type="checkbox" name="price_range" value="1000-2500"
                                            {{ $price_range == '1000-2500' ? 'checked' : '' }}
                                            onchange="window.location.href='{{ route('event.list', ['price_range' => '1000-2500']) }}'">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="container_check">₹2500+
                                        <input type="checkbox" name="price_range" value="2500-plus"
                                            {{ $price_range == '2500-plus' ? 'checked' : '' }}
                                            onchange="window.location.href='{{ route('event.list', ['price_range' => '2500-plus']) }}'">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /filter_type -->
                    <div class="buttons">
                        <a href="#0" class="btn_1 full-width">Filter</a>
                    </div>
                </div>
            </aside>

            <div class="col-lg-9 listing-area mt_15 mb_30">
                <ul class="campain-upper-list li">
                    <li><a href="{{ route('event.list', ['filter' => 'today']) }}">Today</a></li>
                    <li><a href="{{ route('event.list', ['filter' => 'tomorrow']) }}">Tomorrow</a></li>
                    <li><a href="{{ route('event.list', ['filter' => 'weekend']) }}">This weekend</a></li>
                    <li><a href="{{ route('event.list', ['filter' => 'month']) }}">This month</a></li>
                </ul>                
                <div class="row grid_sidebar">
                    <!-- Display Total Event Count -->
                    
                
                    <!-- Loop through each event and display details -->
                    @if($events->count())
                    @foreach($events as $event)
                        <div class="col-lg-3 col-md-6 col-sm-12 ttm-box-col-wrapper">
                            <div class="featured-imagebox featured-imagebox-blog style2 event-card">
                                <div class="featured-thumbnail">
                                    <a href="{{ route('event.details', $event->id) }}">
                                        <img class="event-card-img" src="{{ asset('storage/' . $event->event->card_image) }}" alt="image">
                                    </a>
                                    <div class="ttm-box-date">
                                        <i class="fa fa-calendar ttm-textcolor-skincolor"></i>
                                        <span class="ttm-entry-date">{{ \Carbon\Carbon::parse($event->event->date)->format('M d, Y') }}</span>
                                    </div>
                                </div>
                                <div class="featured-content-inner">
                                    <p class="category">{{ $event->event->mini_heading }}</p>
                                    <div class="featured-title">
                                        <h3><a href="{{ route('event.details', $event->id) }}">{{ $event->event->heading }}</a></h3>
                                    </div>
                                    <div class="featured-desc">
                                        <p>{{ \Illuminate\Support\Str::words($event->event->short_description, 6, '...') }}</p>
                                    </div>
                                    <div class="ttm-blogbox-footer-readmore">
                                        <span class="ttm-btn btn-inline ttm-btn-size-md ttm-icon-btn-right ttm-btn-color-dark">
                                            ₹ {{ $event->event->starting_fees }} onwards
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @else
                    <p>No event available for the selected filter.</p>
                    @endif
                </div>
                <!-- /row -->
                @if(method_exists($events, 'hasPages') && $events->hasPages())
                <div class="pagination_fg">
                    {{-- Previous Page Link --}}
                    @if ($events->onFirstPage())
                        <span class="disabled">&laquo;</span>
                    @else
                        <a href="{{ $events->previousPageUrl() }}">&laquo;</a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                        @if ($page == $events->currentPage())
                            <a href="#" class="active">{{ $page }}</a>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($events->hasMorePages())
                        <a href="{{ $events->nextPageUrl() }}">&raquo;</a>
                    @else
                        <span class="disabled">&raquo;</span>
                    @endif
                </div>
                @endif
            </div>
            <!-- /col -->
        </div>		
    </div>
    <!-- /container -->
    
</main>

@endsection