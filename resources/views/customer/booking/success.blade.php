@extends('layouts.layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/booking-sign_up.css') }}">
    <style>
        .success-box {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 50px;
        }
        .success-icon {
            color: #28a745;
            font-size: 50px;
            margin-bottom: 20px;
        }
        .booking-details {
            margin-top: 30px;
            text-align: left;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .booking-details h5 {
            color: #333;
            margin-bottom: 15px;
            border-bottom: 2px solid #28a745;
            padding-bottom: 10px;
        }
        .booking-details ul {
            list-style: none;
            padding: 0;
        }
        .booking-details ul li {
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .booking-details ul li strong {
            color: #666;
            min-width: 150px;
            display: inline-block;
        }
        .btn-dashboard {
            margin-top: 20px;
            background: #3399cc;
            color: white;
            padding: 10px 30px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-dashboard:hover {
            background: #2980b9;
            text-decoration: none;
            color: white;
        }
    </style>
@endsection

@section('content')
<main class="bg_gray pattern">
    <div class="container margin_60_40">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="success-box">
                    <div class="success-icon">
                        <i class="icon_check_alt2"></i>
                    </div>
                    <h2>Booking Confirmed!</h2>
                    <p>Your appointment has been successfully booked.</p>

                    <div class="booking-details">
                        <h5>Professional Details</h5>
                        <ul>
                            <li>
                                <strong>Professional Name:</strong>
                                <span>{{ session('booking_success.professional_name') }}</span>
                            </li>
                            <li>
                                <strong>Address:</strong>
                                <span>{{ session('booking_success.professional_address') }}</span>
                            </li>
                            <li>
                                <strong>Service:</strong>
                                <span>{{ session('booking_success.service_name') }}</span>
                            </li>
                        </ul>

                        <h5>Booking Information</h5>
                        <ul>
                            <li>
                                <strong>Plan Type:</strong>
                                <span>{{ ucwords(str_replace('_', ' ', session('booking_success.plan_type'))) }}</span>
                            </li>
                            <li>
                                <strong>Amount Paid:</strong>
                                <span>₹{{ number_format(session('booking_success.amount'), 2) }}</span>
                            </li>
                            <li>
                                <strong>Booking Dates:</strong>
                                <ul style="margin-left: 150px;">
                                    @foreach(session('booking_success.bookings') as $booking)
                                        <li style="border: none;">
                                            {{ \Carbon\Carbon::parse($booking['date'])->format('d M Y') }} - 
                                            {{ $booking['time_slot'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div style="margin-top: 30px;">
                        <a href="{{ route('user.upcoming-appointment.index') }}" class="btn-dashboard">
                            View My Appointments
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection



