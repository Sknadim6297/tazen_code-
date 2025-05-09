@extends('layouts.layout')
@section('styles')
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/booking-sign_up.css') }}" />
@endsection
@section('content')
<main class="bg_gray pattern">
    <div class="container margin_60_40">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="box_booking_2">
                    @if(session()->has('booking_data'))
                    @php
                        $bookingData = session('booking_data');
                        $professionalId = $bookingData['professional_id'] ?? null;
                        $professional = \App\Models\Professional::with('profile')->where('id', $professionalId)->first();
                        $bookingDate = $bookingData['bookings'][0]['date'] ?? '';
                        $timeSlot = $bookingData['bookings'][0]['time_slot'] ?? '';
                        $planType = $bookingData['plan_type'] ?? '';
                    @endphp
                     @endif
                    <div class="head">
                        <div class="title">
                            <h3>{{ $professional['name'] ?? 'Booking Details' }}</h3>
                            {{ $professional->profile->address ?? 'Booking Address is not available' }}-<a href="https://www.google.com/maps/dir//Assistance+–+Hôpitaux+De+Paris,+3+Avenue+Victoria,+75004+Paris,+Francia/@48.8606548,2.3348734,14z/data=!4m15!1m6!3m5!1s0x47e66e1de36f4147:0xb6615b4092e0351f!2sAssistance+Publique+-+Hôpitaux+de+Paris+(AP-HP)+-+Siège!8m2!3d48.8568376!4d2.3504305!4m7!1m0!1m5!1m1!1s0x47e67031f8c20147:0xa6a9af76b1e2d899!2m2!1d2.3504327!2d48.8568361" target="blank">Get directions</a>
                        </div>
                    </div>
                    <!-- /head -->
                    <div class="main">
                        <div id="confirm">
                            <div class="icon icon--order-success svg add_bottom_15">
                                <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72">
                                    <g fill="none" stroke="#8EC343" stroke-width="2">
                                        <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                                        <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                                    </g>
                                </svg>
                            </div>
                            <h3>Booking Confirmed!</h3>
                            <p>We will reply shortly to confirm the appointment.</p>
                        </div>
                    </div>
                </div>
                <!-- /box_booking -->
            </div>
            <!-- /col -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</main>
@endsection
@section('script')

@endsection



