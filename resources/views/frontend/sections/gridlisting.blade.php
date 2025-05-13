@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
@endsection
@section('content')
    <div class="container margin_30_40" style="margin-top: 100px;">
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
            @foreach($professionals as $professional)
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                    <div class="strip">
                       <figure style="position: relative;">
    {{-- Wishlist Heart Icon --}}
    <a href="#0" class="wish_bt"><i class="icon_heart"></i></a>

    {{-- Experience Badge --}}
    @if(!empty($professional->profile->experience))
        <div style="position: absolute; top: 10px; right: 10px; background: #ff6f61; color: white; padding: 5px 10px; border-radius: 20px; font-size: 14px; display: flex; align-items: center; justify-content: center; z-index: 5;">
            <i class="icon_briefcase" style="margin-right: 5px;"></i> {{ $professional->profile->experience }} years
        </div>
    @endif

    {{-- Professional Image --}}
    <img src="{{ asset($professional->profile->photo ?? 'img/lazy-placeholder.png') }}" class="img-fluid lazy" alt="{{ $professional->first_name }}" style="z-index: 1;">

    {{-- Professional Details Link --}}
    <a href="{{ route('professionals.details', ['id' => $professional->id]) }}" class="strip_info">
        <div class="item_title">
            <h3>{{ $professional->name }}</h3>
            <p class="about">{{ $professional->bio }}</p>
            <small>From ₹{{ number_format($professional->profile->starting_price ?? 0, 2) }}</small>
            <small>{{ $professional->profile->specialization }}</small>
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
                    </a>
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
@endsection
