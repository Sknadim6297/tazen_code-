@extends('layouts.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/booking-sign_up.css') }}" />
@endsection

@section('content')
<main class="bg_gray pattern">
    <div class="container margin_60_40">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="box_booking_2">

                    @if(session()->has('event_booking_data'))
                        @php
                            $bookingData = session('event_booking_data');
                            $event = \App\Models\AllEvent::find($bookingData['event_id'] ?? null);
                            $user = Auth::guard('user')->user();
                            $amount = ($bookingData['total_price'] ?? $event->starting_fees ?? 0) * 100;
                        @endphp

                        <div class="head">
                            <div class="title">
                                <h3>{{ $event->heading ?? 'Event Booking' }}</h3>
                                <p>{{ $bookingData['location'] ?? 'Location N/A' }} ({{ ucfirst($bookingData['type'] ?? '') }})</p>
                            </div>
                        </div>

                        <div class="main">
                            <h6>Event Booking Summary</h6>
                            <ul>
                                <li>Event Name: <span>{{ $event->heading ?? 'N/A' }}</span></li>
                                <li>Event Date: <span>{{ \Carbon\Carbon::parse($bookingData['event_date'])->format('d M Y') ?? 'N/A' }}</span></li>
                                <li>Total Amount: <span>₹{{ number_format($amount / 100, 2) }}</span></li>
                                <li>Status: <span>{{ ucfirst($event->status ?? 'Pending') }}</span></li>
                                <li>Location: <span>{{ $bookingData['location'] ?? 'N/A' }}</span></li>
                                <li>Type: <span>{{ ucfirst($bookingData['type'] ?? 'N/A') }}</span></li>
                                <li>Persons: <span>{{ $bookingData['persons'] ?? 'N/A' }}</span></li>
                                <li>Phone: <span>{{ $bookingData['phone'] ?? 'N/A' }}</span></li>
                                <li>Your Name: <span>{{ $user->name ?? 'N/A' }}</span></li>
                                <li>Your Email: <span>{{ $user->email ?? 'N/A' }}</span></li>
                            </ul>

                            <hr>
                            <button class="btn_1 full-width mb_5" id="payNowBtn">Confirm Booking</button>
                            <a href="{{ route('event.list') }}" class="btn_1 full-width outline mb_25">Change Booking</a>
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
document.addEventListener('DOMContentLoaded', () => {
    const payBtn = document.getElementById('payNowBtn');
    if (!payBtn) return;

    payBtn.addEventListener('click', function () {
        fetch("{{ route('user.booking.payment.init') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
        })
        .then(res => res.json())
        .then(data => {
            if (!data || !data.order_id) {
                toastr.error('Payment initiation failed.');
                return;
            }

            const options = {
                key: data.key,
                amount: data.amount,
                currency: "INR",
                name: "Your Website",
                description: "Event Booking",
                image: "{{ asset('frontend/assets/img/logo.png') }}",
                order_id: data.order_id,
                handler: function (response) {
                    fetch("{{ route('user.booking.payment.success') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
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
                            window.location.href = "{{ route('user.event.booking.success') }}";
                        } else {
                            toastr.error('Payment verification failed.');
                        }
                    });
                },
                prefill: {
                    name: "{{ $user->name ?? '' }}",
                    email: "{{ $user->email ?? '' }}",
                    contact: "{{ $bookingData['phone'] ?? '' }}"
                },
                theme: {
                    color: "#0a58ca"
                }
            };

            const rzp = new Razorpay(options);
            rzp.on('payment.failed', function (response) {
                fetch("{{ route('user.booking.payment.failed') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        razorpay_payment_id: response.error.metadata.payment_id,
                        razorpay_order_id: response.error.metadata.order_id,
                        error_code: response.error.code,
                        error_description: response.error.description,
                        error_source: response.error.source,
                        error_step: response.error.step,
                        error_reason: response.error.reason
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'failed') {
                        toastr.error('Payment failed: ' + response.error.description);
                    } else {
                        toastr.error('Payment failure not logged properly.');
                    }
                })
                .catch(() => {
                    toastr.error('Unable to record payment failure. Please contact support.');
                });
            });

            rzp.open();
        })
        .catch(err => {
            console.error(err);
            toastr.error('Something went wrong. Please try again.');
        });
    });
});
</script>

@endsection
