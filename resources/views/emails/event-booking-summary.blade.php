<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 30px 0;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
        }
        .logo {
            max-height: 60px;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
        }
        .content {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.2);
        }
        .title {
            color: #2c3e50;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            text-align: center;
        }
        .subtitle {
            color: #7f8c8d;
            font-size: 16px;
            text-align: center;
            margin-bottom: 30px;
        }
        .greeting {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .event-image {
            width: 100%;
            max-height: 250px;
            object-fit: cover;
            border-radius: 12px;
            margin: 20px 0;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        .event-info {
            background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #81c784;
        }
        .event-name {
            font-size: 20px;
            font-weight: 700;
            color: #2e7d32;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .event-date {
            font-size: 16px;
            color: #388e3c;
            font-weight: 500;
        }
        .booking-details {
            margin: 30px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 25px;
            border: 1px solid #e9ecef;
        }
        .booking-item {
            margin: 15px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f1f3f4;
        }
        .booking-item:last-child {
            border-bottom: none;
        }
        .booking-label {
            font-weight: 600;
            color: #495057;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .booking-value {
            color: #2c3e50;
            font-weight: 500;
            text-align: right;
            max-width: 60%;
        }
        .amount-highlight {
            background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
            border: 1px solid #81c784;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            margin: 20px 0;
        }
        .amount-value {
            font-size: 24px;
            font-weight: 700;
            color: #2e7d32;
        }
        .payment-details {
            margin-top: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border-radius: 12px;
            border: 1px solid #ffcc02;
        }
        .payment-id {
            font-family: 'Courier New', monospace;
            background: #ffffff;
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            font-size: 14px;
            word-break: break-all;
        }
        .event-type {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .event-type.online {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            color: #0d47a1;
            border: 1px solid #90caf9;
        }
        .event-type.offline {
            background: linear-gradient(135deg, #fce4ec 0%, #f8bbd9 100%);
            color: #ad1457;
            border: 1px solid #f48fb1;
        }
        .location-info {
            background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
            border: 1px solid #ce93d8;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }
        .footer p {
            color: #ffffff;
            font-size: 14px;
            margin: 5px 0;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 30px;
            margin-top: 30px;
            font-weight: 600;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(102, 126, 234, 0.4);
        }
        .note {
            background: #f8f9fa;
            border-left: 4px solid #17a2b8;
            padding: 15px;
            margin: 25px 0;
            border-radius: 0 8px 8px 0;
            font-style: italic;
            color: #495057;
        }
        
        /* Mobile Responsive */
        @media only screen and (max-width: 600px) {
            .container {
                padding: 10px;
            }
            .content {
                padding: 20px;
                margin: 10px;
            }
            .title {
                font-size: 24px;
            }
            .event-name {
                font-size: 18px;
            }
            .booking-item {
                flex-direction: column;
                align-items: flex-start;
                padding: 15px 0;
            }
            .booking-label {
                margin-bottom: 8px;
            }
            .booking-value {
                max-width: 100%;
                text-align: left;
                font-size: 16px;
            }
            .amount-value {
                font-size: 20px;
            }
            .btn {
                padding: 12px 24px;
                font-size: 14px;
                width: 100%;
                text-align: center;
                box-sizing: border-box;
            }
            .event-info {
                padding: 15px;
            }
            .event-image {
                max-height: 200px;
            }
        }
        
        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .content {
                background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
                color: #ecf0f1;
            }
            .booking-details {
                background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
                border-color: #4a5568;
            }
            .booking-item {
                border-bottom-color: #4a5568;
            }
            .booking-label {
                color: #a0aec0;
            }
            .booking-value {
                color: #e2e8f0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('customer-css/assets/images/tazen_logo.png') }}" alt="Tazen Logo" class="logo">
        </div>
        
        <div class="content">
            <h1 class="title">🎉 Event Booking Confirmed!</h1>
            <p class="subtitle">Get ready for an amazing experience</p>
            
            <p class="greeting">Dear {{ $bookingDetails['user_name'] }},</p>
            
            <p>Thank you for booking with Tazen! We're thrilled to confirm your event registration. Here are your booking details:</p>
            
            @if(isset($event->image) && $event->image)
                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->heading }}" class="event-image">
            @endif
            
            <div class="event-info">
                <div class="event-name">
                    🎪 {{ $event->heading }}
                </div>
                <div class="event-date">
                    📅 {{ isset($event->date) ? \Carbon\Carbon::parse($event->date)->format('l, d M Y') : 'Date TBA' }}
                </div>
            </div>
            
            <div class="booking-details">
                <div class="booking-item">
                    <span class="booking-label">Event Type</span>
                    <span class="event-type {{ strtolower($event->type ?? 'offline') }}">
                        @if(strtolower($event->type ?? 'offline') === 'online')
                            💻 {{ ucfirst($event->type ?? 'Offline') }}
                        @else
                            📍 {{ ucfirst($event->type ?? 'Offline') }}
                        @endif
                    </span>
                </div>
                
                @if($event->city ?? false)
                <div class="booking-item">
                    <span class="booking-label">Location</span>
                    <div class="location-info">
                        📍 {{ $event->city }}
                    </div>
                </div>
                @endif
                
                <div class="booking-item">
                    <span class="booking-label">Number of Persons</span>
                    <span class="booking-value">{{ $bookingDetails['persons'] }} {{ $bookingDetails['persons'] > 1 ? 'persons' : 'person' }}</span>
                </div>
            </div>
            
            <div class="amount-highlight">
                <div style="color: #2e7d32; font-size: 14px; margin-bottom: 5px;">Total Amount Paid</div>
                <div class="amount-value">₹{{ number_format($bookingDetails['total_price'], 2) }}</div>
            </div>
            
            <div class="payment-details">
                <div class="booking-item">
                    <span class="booking-label">Transaction ID</span>
                    <span class="booking-value payment-id">{{ $bookingDetails['payment_id'] }}</span>
                </div>
                <div class="booking-item">
                    <span class="booking-label">Payment Date</span>
                    <span class="booking-value">{{ \Carbon\Carbon::parse($bookingDetails['created_at'])->format('d M, Y H:i') }}</span>
                </div>
            </div>
            
            <div class="note">
                <strong>📝 Important Note:</strong> Please save this confirmation email and bring a valid ID to the event. For online events, you'll receive joining details 24 hours before the event.
            </div>
            
            <div style="text-align: center;">
                <a href="{{ route('user.dashboard') }}" class="btn">View My Dashboard</a>
            </div>
        </div>
        
        <div class="footer">
            <p>🎊 Thank you for choosing Tazen - Creating memorable experiences!</p>
            <p>&copy; {{ date('Y') }} Tazen. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
