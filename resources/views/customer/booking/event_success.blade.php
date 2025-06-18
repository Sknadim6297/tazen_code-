@extends('layouts.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/booking-sign_up.css') }}" />
<style>
    .success-icon {
        font-size: 60px;
        color: #28a745;
        margin-bottom: 20px;
        display: block;
        text-align: center;
    }
    
    .success-header {
        text-align: center;
        margin-bottom: 20px;
    }
    
    .booking-id {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        font-weight: 500;
        margin: 15px 0;
        text-align: center;
    }
</style>
@endsection

@section('content')
<main class="bg_gray pattern">
    <div class="container margin_60_40">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="box_booking_2">
                    <div class="head">
                        <div class="title">
                            <h3>Booking Confirmed</h3>
                        </div>
                    </div>

                    @php
                        // Get the last booking if we don't have session data
                        if (!session()->has('event_booking_data')) {
                            $booking = \App\Models\EventBooking::where('user_id', Auth::guard('user')->id())
                                ->latest()
                                ->first();
                                
                            if ($booking) {
                                $event = \App\Models\AllEvent::find($booking->event_id);
                                $user = Auth::guard('user')->user();
                            }
                        } else {
                            $bookingData = session('event_booking_data');
                            $event = \App\Models\AllEvent::find($bookingData['event_id'] ?? null);
                            $user = Auth::guard('user')->user();
                        }
                    @endphp

                    @if(session()->has('event_booking_data') || isset($booking))
                        <div class="main">
                            <div class="success-header">
                                <i class="icon_check_alt2 success-icon"></i>
                                <h4>Your booking has been confirmed!</h4>
                                
                                @if(isset($booking))
                                    <div class="booking-id">
                                        Booking ID: <strong>{{ $booking->id }}</strong>
                                    </div>
                                @endif
                                
                                <p>A confirmation has been sent to your email address.</p>
                            </div>
                            
                            <h6>Event Booking Summary</h6>
                            <ul>
                                @if(isset($booking))
                                    <li>Event Name: <span>{{ $event->heading ?? $booking->event_name ?? 'N/A' }}</span></li>
                                    <li>Event Date: <span>{{ \Carbon\Carbon::parse($booking->event_date ?? $booking->booking_date)->format('d M Y') }}</span></li>
                                    <li>Total Amount: <span>₹{{ number_format($booking->amount ?? $booking->total_price ?? 0, 2) }}</span></li>
                                    <li>Status: <span class="text-success">Confirmed</span></li>
                                    <li>Location: <span>{{ $booking->location ?? 'N/A' }}</span></li>
                                    <li>Type: <span>{{ ucfirst($booking->type ?? $booking->session_type ?? 'N/A') }}</span></li>
                                    <li>Persons: <span>{{ $booking->persons ?? 'N/A' }}</span></li>
                                    <li>Phone: <span>{{ $booking->phone ?? $user->phone ?? 'N/A' }}</span></li>
                                    <li>Your Name: <span>{{ $user->name ?? 'N/A' }}</span></li>
                                    <li>Your Email: <span>{{ $user->email ?? 'N/A' }}</span></li>
                                @else
                                    <li>Event Name: <span>{{ $event->heading ?? 'N/A' }}</span></li>
                                    <li>Event Date: <span>{{ \Carbon\Carbon::parse($bookingData['event_date'])->format('d M Y') ?? 'N/A' }}</span></li>
                                    <li>Total Amount: <span>₹{{ number_format(($bookingData['total_price'] ?? $event->starting_fees ?? 0), 2) }}</span></li>
                                    <li>Status: <span class="text-success">Confirmed</span></li>
                                    <li>Location: <span>{{ $bookingData['location'] ?? 'N/A' }}</span></li>
                                    <li>Type: <span>{{ ucfirst($bookingData['type'] ?? 'N/A') }}</span></li>
                                    <li>Persons: <span>{{ $bookingData['persons'] ?? 'N/A' }}</span></li>
                                    <li>Phone: <span>{{ $bookingData['phone'] ?? 'N/A' }}</span></li>
                                    <li>Your Name: <span>{{ $user->name ?? 'N/A' }}</span></li>
                                    <li>Your Email: <span>{{ $user->email ?? 'N/A' }}</span></li>
                                @endif
                            </ul>

                            @if(isset($booking) && $booking->payment_id)
                                <div class="payment-info">
                                    <h6>Payment Information</h6>
                                    <ul>
                                        <li>Payment ID: <span>{{ $booking->payment_id }}</span></li>
                                        <li>Payment Status: <span class="text-success">Paid</span></li>
                                        <li>Payment Date: <span>{{ $booking->created_at->format('d M Y, h:i A') }}</span></li>
                                    </ul>
                                </div>
                            @elseif(isset($bookingData['payment_id']))
                                <div class="payment-info">
                                    <h6>Payment Information</h6>
                                    <ul>
                                        <li>Payment ID: <span>{{ $bookingData['payment_id'] }}</span></li>
                                        <li>Payment Status: <span class="text-success">Paid</span></li>
                                        <li>Payment Date: <span>{{ now()->format('d M Y, h:i A') }}</span></li>
                                    </ul>
                                </div>
                            @endif

                            <hr>
                            <a href="{{ route('user.customer-event.index') }}" class="btn_1 full-width mb_5">View All Bookings</a>
                            <a href="{{ route('event.list') }}" class="btn_1 full-width outline mb_25">Browse More Events</a>
                        </div>
                    @else
                        <div class="main">
                            <div class="text-center">
                                <i class="icon_error-circle_alt text-danger" style="font-size: 60px; margin-bottom: 20px;"></i>
                                <h4>Booking information not found</h4>
                                <p>We couldn't find your booking details. Please check your email for confirmation or contact customer support.</p>
                            </div>
                            <hr>
                            <a href="{{ route('user.customer-event.index') }}" class="btn_1 full-width mb_5">View My Bookings</a>
                            <a href="{{ route('home') }}" class="btn_1 full-width outline mb_25">Return to Home</a>
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
    document.addEventListener('DOMContentLoaded', () => {
        console.log('Event booking success page loaded');
    });
</script>
@endsection