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
                        @endphp

                        <div class="head">
                            <div class="title">
                                <h3>{{ Auth::guard('user')->user()->name ?? 'N/A' }}</h3>
                                {{ Auth::guard('user')->user()->email ?? 'N/A' }}</a>
                            </div>
                        </div>

                        <div class="main">
                            <h6 style="text-align: center">Booking Summary</h6>
                            <ul>
                                @if(!empty($bookingData['bookings']))
                                    <li><strong>Date & Time:</strong>
                                        <ul>
                                            @foreach($bookingData['bookings'] as $booking)
                                                <li>{{ \Carbon\Carbon::parse($booking['date'])->format('d/m/y') }} - {{ $booking['time_slot'] ?? 'N/A' }}</li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li>No bookings found.</li>
                                @endif
                                <hr>
                                <li>Service name: <span>{{ session('selected_service_name') ?? 'N/A' }}</span></li>
                                <li>Plan type: <span>{{ isset($bookingData['plan_type']) ? ucwords(str_replace('_', ' ', $bookingData['plan_type'])) : 'N/A' }}</span></li>
                                <li>Type: <span>Appointment</span></li>
                                <li>Total Amount: <span>₹{{ number_format($bookingData['total_amount'] ?? 0, 2) }}</span></li>
                                <li>Professional name: <span>{{ $professional['name'] ?? 'Booking Details' }}</span></li>
                                <li>Professional Address: <span>{{ $professional->profile->address ?? 'Booking Address is not available' }}</span></li>
                            </ul>
                            <hr>
                            <h6>Enter contact number for the booking</h6>
                            <div class="form-group add_bottom_15">
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone" maxlength="10" pattern="\d{10}" autocomplete="tel" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
                                <i class="icon_phone"></i>
                            </div>

                            <a href="javascript:void(0);" class="btn_1 full-width mb_5 booking">Book Now</a>
                            <a href="{{ route('user.reset-booking') }}" class="btn_1 full-width outline mb_25">Change Booking</a>
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
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const bookingBtn = document.querySelector('.booking');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (bookingBtn) {
        bookingBtn.addEventListener('click', function (e) {
            e.preventDefault();

            const phone = document.getElementById('phone').value;

            if (!phone || phone.length !== 10) {
                toastr.warning('Please enter a valid 10-digit phone number.');
                return;
            }

            // First, initiate payment
            fetch("{{ route('user.booking.initiate-payment') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ phone: phone })
            })
            .then(res => res.json())
            .then(data => { // Fixed missing arrow here
                if (data.status === 'success') {
                    // Initialize Razorpay
                    const options = {
                        key: data.key,
                        amount: data.amount,
                        currency: "INR",
                        name: "Tazen",
                        description: "Booking Payment",
                        order_id: data.order_id,
                        handler: function (response) {
                            // Verify payment
                            fetch("{{ route('user.booking.verify-payment') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    razorpay_payment_id: response.razorpay_payment_id,
                                    razorpay_order_id: response.razorpay_order_id,
                                    razorpay_signature: response.razorpay_signature
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    toastr.success(data.message);
                                    setTimeout(() => {
                                        window.location.href = data.redirect_url;
                                    }, 1000);
                                } else {
                                    toastr.error(data.message);
                                }
                            })
                            .catch(error => {
                                toastr.error('Payment verification failed');
                                console.error(error);
                            });
                        },
                        prefill: {
                            name: data.name,
                            email: data.email,
                            contact: data.phone
                        },
                        theme: {
                            color: "#3399cc"
                        }
                    };
                    const rzp = new Razorpay(options);
                    rzp.open();
                } else {
                    toastr.error(data.message);
                }
            })
            .catch(error => {
                toastr.error('An error occurred while processing your request.');
                console.error(error);
            });
        });
    }
});
</script>
@endsection
