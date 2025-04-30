@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
   <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">

<!-- SPECIFIC CSS -->
<link href="{{ asset('frontend/assets/css/listing.css') }}" rel="stylesheet">

<!-- YOUR CUSTOM CSS -->
<link href="{{ asset('frontend/assets/css/custom.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/event-list.css') }}" rel="stylesheet">


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
                                <li>
                                    <label class="container_check">Psychologist<small>12</small>
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="container_check">Dermatologist <small>24</small>
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="container_check">Cardiologist <small>23</small>
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="container_check">General Medicine <small>11</small>
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="container_check">Gynecologist <small>18</small>
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="container_check">Autoimmune Deseas <small>12</small>
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="container_check">Pediatrician <small>15</small>
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <!-- /filter_type -->
                    </div>
                    <!-- /filter_type -->
                    <div class="filter_type">
                        <h4><a href="#filter_2" data-bs-toggle="collapse" class="closed">Rating</a></h4>
                        <div class="collapse" id="filter_2">
                            <ul>
                                <li>
                                    <label class="container_check">Superb 9+ <small>06</small>
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="container_check">Very Good 8+ <small>12</small>
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="container_check">Good 7+ <small>17</small>
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="container_check">Pleasant 6+ <small>43</small>
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
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
                                        <label class="container_check">$0 — $50<small>11</small>
                                          <input type="checkbox">
                                          <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="container_check">$50 — $100<small>08</small>
                                          <input type="checkbox">
                                          <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="container_check">$100 — $150<small>05</small>
                                          <input type="checkbox">
                                          <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="container_check">$150 — $200<small>18</small>
                                          <input type="checkbox">
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
                    <li><a href="">Today</a></li>
                    <li><a href="">Tomorrow</a></li>
                    <li><a href="">This weekend</a></li>
                     <li><a href="">Mental Health</a></li>
                </ul>
                <div class="row grid_sidebar">
                    <!-- Display Total Event Count -->
                    
                
                    <!-- Loop through each event and display details -->
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
                                        <p>{{ $event->event->short_description }}</p>
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