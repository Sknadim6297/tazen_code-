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


@endsection
@section('content')

<main class="bg_color">

    <div class="filters_full element_to_stick version_2">
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
        </div>
      
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
                        <h4><a href="#filter_3" data-bs-toggle="collapse" class="closed">Distance</a></h4>
                        <div class="collapse" id="filter_3">
                            <div class="range_input">Radius around destination <span></span> km</div>
                            <div class="add_bottom_15"><input type="range" min="10" max="100" step="10" value="30" data-orientation="horizontal"></div>
                        </div>
                    </div>
                    <!-- /filter_type -->
                    <div class="filter_type">
                        <h4><a href="#filter_4" data-bs-toggle="collapse" class="closed">Price</a></h4>
                        <div class="collapse" id="filter_4">
                            <ul>
                                <li>
                                    <label class="container_check">₹100 — ₹200
                                        <input type="checkbox" name="price_range" value="100-200"
                                            {{ $price_range == '100-200' ? 'checked' : '' }}
                                            onchange="window.location.href='{{ route('event.list', ['price_range' => '100-200']) }}'">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="container_check">₹200 — ₹300
                                        <input type="checkbox" name="price_range" value="200-300"
                                            {{ $price_range == '200-300' ? 'checked' : '' }}
                                            onchange="window.location.href='{{ route('event.list', ['price_range' => '200-300']) }}'">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="container_check">₹300 — ₹400
                                        <input type="checkbox" name="price_range" value="300-400"
                                            {{ $price_range == '300-400' ? 'checked' : '' }}
                                            onchange="window.location.href='{{ route('event.list', ['price_range' => '300-400']) }}'">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="container_check">₹400 — ₹500
                                        <input type="checkbox" name="price_range" value="400-500"
                                            {{ $price_range == '400-500' ? 'checked' : '' }}
                                            onchange="window.location.href='{{ route('event.list', ['price_range' => '400-500']) }}'">
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
                </ul>                
                <div class="row grid_sidebar">
                    <!-- Display Total Event Count -->
                    
                
                    <!-- Loop through each event and display details -->
                    @if($events->count())
                    @foreach($events as $event)
                        <div class="col-lg-3 col-md-6 col-sm-12 ttm-box-col-wrapper">
                            <div class="featured-imagebox featured-imagebox-blog style2">
                                <div class="featured-thumbnail">
                                    <a href="{{ route('event.details', $event->id) }}">
                                        <img class="img-fluid" width="370" height="254" src="{{ asset('storage/' . $event->event->card_image) }}" alt="image">
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
                <div class="pagination_fg">
                  <a href="#">&laquo;</a>
                  <a href="#" class="active">1</a>
                  <a href="#">2</a>
                  <a href="#">3</a>
                  <a href="#">4</a>
                  <a href="#">5</a>
                  <a href="#">&raquo;</a>
                </div>
            </div>
            <!-- /col -->
        </div>		
    </div>
    <!-- /container -->
    
</main>

@endsection