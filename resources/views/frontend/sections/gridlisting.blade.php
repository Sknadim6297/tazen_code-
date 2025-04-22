@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
@endsection
@section('content')
<main class="bg_color">
		
    <div class="filters_full element_to_stick">
        <div class="container clearfix">
            <div class="sort_select">
                <select name="sort" id="sort">
                    <option value="popularity" selected="selected">Sort by Popularity</option>
                    <option value="rating">Sort by Average rating</option>
                    <option value="date">Sort by newness</option>
                </select>
            </div>
            <a href="#collapseFilters" data-bs-toggle="collapse" class="btn_filters"><i class="icon_adjust-vert"></i><span>Filters</span></a>
            <a class="btn_map mobile btn_filters" data-bs-toggle="collapse" href="#collapseMap"><i class="icon_pin_alt"></i></a>
            <div class="search_bar_list">
                <input type="text" class="form-control" placeholder="Search again...">
            </div>
            <a class="btn_search_mobile btn_filters" data-bs-toggle="collapse" href="#collapseSearch"><i class="icon_search"></i></a>
        </div>
        <div class="collapse filters_2" id="collapseFilters">
        <div class="container margin_detail">
            <div class="row">
                <div class="col-md-4">
                    <div class="filter_type">
                        <h6>Rating</h6>
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
                <div class="col-md-4">
                     <div class="filter_type">
                        <h6>Availability</h6>
                        <ul>
                            <li>
                                <label class="container_check">Apointment <small>12</small>
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </li>
                            <li>
                                <label class="container_check">Chat <small>24</small>
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </li>
                            <li>
                                <label class="container_check">Video Call <small>23</small>
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="filter_type">
                        <h6>Price</h6>
                        <div class="range_input">Price range from 0 to <span></span>$</div>
                        <div><input type="range" min="10" max="100" step="10" value="30" data-orientation="horizontal"></div>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
    </div>
    <!-- /filters -->
    <div class="collapse" id="collapseSearch">
        <div class="search_bar_list">
            <input type="text" class="form-control" placeholder="Search again...">
        </div>
    </div>
    <!-- /collapseSearch -->
    </div>
    <!-- /filters_full -->

    <div class="collapse" id="collapseMap">
        <div id="map" class="map"></div>
    </div>
    <!-- /Map -->

    <div class="container margin_30_40">
        <div class="page_header">
            <div class="breadcrumbs">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Category</a></li>
                    <li>Page active</li>
                </ul>
            </div>
            <h1>Doctors</h1><span>: 814 found</span>
        </div>
        <!-- /page_header -->
        <div class="row">
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                <div class="strip">
                    <figure>
                        <a href="#0" class="wish_bt"><i class="icon_heart"></i></a>
                        <img src="img/lazy-placeholder.png" data-src="img/professionals_photos/1.jpg" class="img-fluid lazy" alt="">
                        <a href="detail-page.html" class="strip_info">
                            <div class="item_title">
                                <h3>Dr. Maria Cornfield</h3>
                                <p class="about">Expert in child psychology and development</p>
                                <small>From Rs.7500</small><br>
                                <small>Pediatrician, Psychologist ...</small>
                            </div>
                        </a>
                    </figure>
                    <ul>
                        <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Appointment"><i class="icon-users"></i></a></li>
                        <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Chat"><i class="icon-chat"></i></a></li>
                        <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Video Call"><i class="icon-videocam"></i></a></li>
                        <li>
                            <div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /strip grid -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                 <div class="strip">
                    <figure>
                        <a href="#0" class="wish_bt"><i class="icon_heart"></i></a>
                        <img src="img/lazy-placeholder.png" data-src="img/professionals_photos/2.jpg" class="img-fluid lazy" alt="">
                        <a href="detail-page.html" class="strip_info">
                            <div class="item_title">
                                <h3>Dr. Lucy Shoemaker</h3>
                                <p class="about">Specialized in autoimmune disorder treatments</p>
                                <small>From Rs.7500</small><br>
                                <small>Autoimmune Diseases</small>
                            </div>
                        </a>
                    </figure>
                    <ul>
                        <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Appointment"><i class="icon-users"></i></a></li>
                        <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Chat"><i class="icon-chat"></i></a></li>
                        <li>
                            <div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /strip grid -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                <div class="strip">
                    <figure>
                        <a href="#0" class="wish_bt"><i class="icon_heart"></i></a>
                        <img src="img/lazy-placeholder.png" data-src="img/professionals_photos/3.jpg" class="img-fluid lazy" alt="">
                        <a href="detail-page.html" class="strip_info">
                            <div class="item_title">
                                <h3>Dr. Luke Lachinet</h3>
                                <p class="about">Comprehensive women's health services</p>
                                <small>From Rs.7500</small><br>
                                <small>Obstetrician, Gynecologist...</small>
                            </div>
                        </a>
                    </figure>
                    <ul>
                        <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Appointment"><i class="icon-users"></i></a></li>
                        <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Video Call"><i class="icon-videocam"></i></a></li>
                        <li>
                            <div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /strip grid -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                <div class="strip">
                    <figure>
                        <a href="#0" class="wish_bt"><i class="icon_heart"></i></a>
                        <img src="img/lazy-placeholder.png" data-src="img/professionals_photos/4.jpg" class="img-fluid lazy" alt="">
                        <a href="detail-page.html" class="strip_info">
                            <div class="item_title">
                                <h3>Dr. Marta Rainwater</h3>
                                <p class="about">Advanced skin care and treatments</p>
                                <small>From Rs.7500</small><br>
                                <small>Dermatologist</small>
                            </div>
                        </a>
                    </figure>
                    <ul>
                        <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Chat"><i class="icon-chat"></i></a></li>
                        <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Video Call"><i class="icon-videocam"></i></a></li>
                        <li>
                            <div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /strip grid -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                <div class="strip">
                    <figure>
                        <a href="#0" class="wish_bt"><i class="icon_heart"></i></a>
                        <img src="img/lazy-placeholder.png" data-src="img/professionals_photos/5.jpg" class="img-fluid lazy" alt="">
                        <a href="detail-page.html" class="strip_info">
                            <div class="item_title">
                                <h3>Dr. Tom Manzone</h3>
                                <p class="about">Mental health and wellness expert</p>
                                <small>From Rs.7500</small><br>
                                <small>Psychologist</small>
                            </div>
                        </a>
                    </figure>
                    <ul>
                        <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Chat"><i class="icon-chat"></i></a></li>
                        <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Video Call"><i class="icon-videocam"></i></a></li>
                        <li>
                            <div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /strip grid -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                <div class="strip">
                    <figure>
                        <a href="#0" class="wish_bt"><i class="icon_heart"></i></a>
                        <img src="img/lazy-placeholder.png" data-src="img/professionals_photos/6.jpg" class="img-fluid lazy" alt="">
                        <a href="detail-page.html" class="strip_info">
                            <div class="item_title">
                                <h3>Dr. Rose Cornfield</h3>
                                <p class="about">General health and preventive care</p>
                                <small>From Rs.7500</small><br>
                                <small>General Medicine</small>
                            </div>
                        </a>
                    </figure>
                    <ul>
                        <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Appointment"><i class="icon-users"></i></a></li>
                        <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Chat"><i class="icon-chat"></i></a></li>
                        <li>
                            <div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /strip grid -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                <div class="strip">
                    <figure>
                        <a href="#0" class="wish_bt"><i class="icon_heart"></i></a>
                        <img src="img/lazy-placeholder.png" data-src="img/professionals_photos/7.jpg" class="img-fluid lazy" alt="">
                        <a href="detail-page.html" class="strip_info">
                            <div class="item_title">
                                <h3>Dr. Maria Cornfield</h3>
                                <p class="about">Heart health and cardiovascular care</p>
                                <small>From Rs.7500</small><br>
                                <small>Cardiologist</small>
                            </div>
                        </a>
                    </figure>
                    <ul>
                        <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Appointment"><i class="icon-users"></i></a></li>
                        <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Video Call"><i class="icon-videocam"></i></a></li>
                        <li>
                            <div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /strip grid -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                <div class="strip">
                    <figure>
                        <a href="#0" class="wish_bt"><i class="icon_heart"></i></a>
                        <img src="img/lazy-placeholder.png" data-src="img/professionals_photos/8.jpg" class="img-fluid lazy" alt="">
                        <a href="detail-page.html" class="strip_info">
                            <div class="item_title">
                                <h3>Dr. Jim Jake</h3>
                                <p class="about">Women's reproductive health specialist</p>
                                <small>From Rs.7500</small><br>
                                <small>Obstetrician, Gynecologist...</small>
                            </div>
                        </a>
                    </figure>
                    <ul>
                        <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Appointment"><i class="icon-users"></i></a></li>
                        <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Chat"><i class="icon-chat"></i></a></li>
                        <li>
                            <div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /strip grid -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                <div class="strip">
                    <figure>
                        <a href="#0" class="wish_bt"><i class="icon_heart"></i></a>
                        <img src="img/lazy-placeholder.png" data-src="img/professionals_photos/9.jpg" class="img-fluid lazy" alt="">
                        <a href="detail-page.html" class="strip_info">
                            <div class="item_title">
                                <h3>Dr. Barbara Ocean</h3>
                                <p class="about">Cardiac health and prevention expert</p>
                                <small>From Rs.7500</small><br>
                                <small>Cardiologist</small>
                            </div>
                        </a>
                    </figure>
                    <ul>
                        <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Appointment"><i class="icon-users"></i></a></li>
                        <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Chat"><i class="icon-chat"></i></a></li>
                        <li>
                            <div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /strip grid -->
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
<!-- /container -->
    
</main>
@endsection