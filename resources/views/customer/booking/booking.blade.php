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
                            $professionalId = session('booking_data.professional_id');
                            $professionaladd= session('booking_data.professional_address');
                            $professional = \App\Models\Professional::where('id', $professionalId)->first(); 
                        @endphp

                        <div class="head">
                            <div class="title">
                                <h3>{{ $professional['name'] ?? 'Booking Details' }}</h3>
                                {{ $professionaladd ?? 'Address not available' }}
                            </div>
                        </div>
                        <!-- /head -->
                        <div class="main">
                            <h6>Booking summary</h6>
                            <ul>
                                <li>Date <span>{{ $bookingData['booking_date'] ?? 'N/A' }}</span></li>
                                <li>Time <span>{{ $bookingData['time_slot'] ?? 'N/A' }}</span></li>
                                <li>Plan type <span>{{ $bookingData['plan_type'] ?? 'N/A' }}</span></li>
                                <li>Type <span>Appointment</span></li>
                            </ul>
                
                            <hr>
                            <h6>Personal details</h6>
                            <div class="form-group">
                                <input class="form-control" id="name" placeholder="First and Last Name">
                                <i class="icon_pencil"></i>
                            </div>
                            <div class="form-group">
                                <input class="form-control" id="email" placeholder="Email Address">
                                <i class="icon_mail"></i>
                            </div>
                            <div class="form-group add_bottom_15">
                                <input class="form-control" id="phone" placeholder="Phone">
                                <i class="icon_phone"></i>
                            </div>
                            <a href="" class="btn_1 full-width mb_5 booking">Book Now</a>
                            <a href="#" class="btn_1 full-width outline mb_25">Change Booking</a>
                        </div>
                    @else
                        <div class="main">
                            <h6>No booking data available.</h6>
                        </div>
                    @endif
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
<script>
    document.querySelector('.booking').addEventListener('click', function (e) {
        e.preventDefault();

        // Get form values
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const bookingDate = '{{ $bookingData['booking_date'] ?? '' }}'; 
        const timeSlot = '{{ $bookingData['time_slot'] ?? '' }}'; 
        const planType = '{{ $bookingData['plan_type'] ?? '' }}'; 
        const professionalId = '{{ $bookingData['professional_id'] ?? '' }}'; 

        // Validation check if required fields are empty
        if (!name || !email || !phone) {
            alert('Please fill all the personal details.');
            return;
        }
        fetch("{{ route('user.booking.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                professional_id: professionalId,
                plan_type: planType,
                booking_date: bookingDate,
                time_slot: timeSlot,
                name: name,
                email: email,
                phone: phone,
            })
        })
        .then(res => res.json())
        .then(data => {
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
        });
    });
</script>
@endsection



