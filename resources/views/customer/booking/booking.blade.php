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

                        <div class="head">
                            <div class="title">
                                <h3>{{ $professional['name'] ?? 'Booking Details' }}</h3>
                                {{ $professional->profile->address ?? 'Booking Address is not available' }} -<a href="https://www.google.com/maps/dir//Assistance+–+Hôpitaux+De+Paris,+3+Avenue+Victoria,+75004+Paris,+Francia/@48.8606548,2.3348734,14z/data=!4m15!1m6!3m5!1s0x47e66e1de36f4147:0xb6615b4092e0351f!2sAssistance+Publique+-+Hôpitaux+de+Paris+(AP-HP)+-+Siège!8m2!3d48.8568376!4d2.3504305!4m7!1m0!1m5!1m1!1s0x47e67031f8c20147:0xa6a9af76b1e2d899!2m2!1d2.3504327!2d48.8568361" target="blank">Get directions</a>
                            </div>
                        </div>
                        {{-- <pre>{{ print_r(session()->all(), true) }}</pre> --}}

                        <div class="main">
                            <h6>Booking Summary</h6>
                            <ul>
                                <li>Service name: <span>{{ session('selected_service_name') ?? 'N/A' }}</span></li>
                                @if(!empty($bookingData['bookings']))
                                    <li><strong>Date & Time:</strong>
                                        <ul style="margin-left: 20px;">
                                            @foreach($bookingData['bookings'] as $booking)
                                                <li>{{ $booking['date'] ?? 'N/A' }} - {{ $booking['time_slot'] ?? 'N/A' }}</li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li>No bookings found.</li>
                                @endif
                                <li>Plan type: <span>{{ $planType ?? 'N/A' }}</span></li>
                                <li>Type: <span>Appointment</span></li>
                                <li>Your name: <span>{{ Auth::guard('user')->user()->name ?? 'N/A' }}</span></li>
                                <li>Your email: <span>{{ Auth::guard('user')->user()->email ?? 'N/A' }}</span></li>
                            </ul>
                            <hr>
                            <h6>Personal Details</h6>
<div class="form-group add_bottom_15">
    <input type="tel" class="form-control" id="phone" placeholder="Phone" maxlength="10" pattern="\d{10}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
    <i class="icon_phone"></i>
</div>
    

                            <a href="javascript:void(0);" class="btn_1 full-width mb_5 booking">Book Now</a>
                            <a href="#" class="btn_1 full-width outline mb_25">Change Booking</a>
                        </div>
                    @else
                        <div class="main">
                            <h6>No booking data available.</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
    
    document.addEventListener('DOMContentLoaded', function () {
    const bookingBtn = document.querySelector('.booking');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (bookingBtn) {
        bookingBtn.addEventListener('click', function (e) {
            e.preventDefault();

            const phone = document.getElementById('phone').value;

            // Validation check before sending data
            if (!phone) {
                toastr.warning('Please fill all the personal details.');
                return;
            }

            // Only send the phone number, as booking data is stored in session
            const requestData = {
                phone: phone
            };

            fetch("{{ route('user.booking.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify(requestData)
            })
            .then(res => {
                if (!res.ok) throw new Error('Network error or validation failed');
                return res.json();
            })
            .then(data => {
                console.log('Response Data:', data);

                if (data.status === 'success') {
                    toastr.success(data.message);
                    setTimeout(() => {
                        window.location.href = "{{ route('user.booking.success') }}";
                    }, 1000);
                } else {
                    toastr.error(data.message);
                }
            })
            .catch(error => {
                toastr.error('An error occurred while processing your booking.');
                console.error(error);
            });
        });
    } else {
        console.warn('Booking button not found.');
    }
});


    </script>
    
@endsection
