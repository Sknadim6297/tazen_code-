<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failure Alert</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .header .icon {
            font-size: 48px;
            margin-bottom: 10px;
            display: block;
        }
        .content {
            padding: 30px;
        }
        .alert-box {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
            color: #721c24;
        }
        .info-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .info-section h3 {
            margin-top: 0;
            color: #495057;
            font-size: 18px;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 10px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 15px;
        }
        .info-item {
            display: flex;
            flex-direction: column;
        }
        .info-label {
            font-weight: 600;
            color: #6c757d;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .info-value {
            color: #212529;
            font-size: 14px;
            word-break: break-word;
        }
        .reference-id {
            background-color: #e9ecef;
            border-radius: 6px;
            padding: 8px 12px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #495057;
            text-align: center;
            margin: 10px 0;
        }
        .action-needed {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }
        .action-needed h4 {
            color: #856404;
            margin-top: 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 10px 5px;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 12px;
            border-top: 1px solid #dee2e6;
        }
        .timestamp {
            color: #adb5bd;
            font-size: 12px;
            margin-top: 15px;
        }
        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            .content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <span class="icon">⚠️</span>
            <h1>Payment Failure Alert</h1>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">
                {{ $recipientType === 'professional' ? 'Customer Payment Failed' : 'Payment System Alert' }}
            </p>
        </div>

        <div class="content">
            <div class="alert-box">
                <strong>Payment Failed:</strong> A {{ $paymentData['booking_type'] }} booking payment has failed and requires attention.
            </div>

            <!-- Customer Information -->
            <div class="info-section">
                <h3>👤 Customer Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Customer Name</span>
                        <span class="info-value">{{ $userDetails['name'] }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $userDetails['email'] }}</span>
                    </div>
                    @if(isset($paymentData['phone']) && $paymentData['phone'])
                    <div class="info-item">
                        <span class="info-label">Phone</span>
                        <span class="info-value">{{ $paymentData['phone'] }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Booking Information -->
            <div class="info-section">
                <h3>{{ $isAppointment ? '📅 Appointment Details' : '🎉 Event Details' }}</h3>
                <div class="info-grid">
                    @if($isAppointment)
                        <div class="info-item">
                            <span class="info-label">Service</span>
                            <span class="info-value">{{ $paymentData['service_name'] ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Plan Type</span>
                            <span class="info-value">{{ ucwords(str_replace('_', ' ', $paymentData['plan_type'] ?? 'N/A')) }}</span>
                        </div>
                    @else
                        <div class="info-item">
                            <span class="info-label">Event Name</span>
                            <span class="info-value">{{ $paymentData['event_name'] ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Event Date</span>
                            <span class="info-value">{{ $paymentData['event_date'] ?? 'N/A' }}</span>
                        </div>
                        @if(isset($paymentData['location']))
                        <div class="info-item">
                            <span class="info-label">Location</span>
                            <span class="info-value">{{ $paymentData['location'] }}</span>
                        </div>
                        @endif
                    @endif
                    <div class="info-item">
                        <span class="info-label">Amount</span>
                        <span class="info-value">₹{{ number_format($paymentData['amount'] / 100, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Failure Details -->
            <div class="info-section">
                <h3>💳 Payment Failure Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Failure Reason</span>
                        <span class="info-value">{{ $paymentData['error_description'] ?? 'Unknown error' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Error Code</span>
                        <span class="info-value">{{ $paymentData['error_code'] ?? 'N/A' }}</span>
                    </div>
                </div>
                
                <div class="reference-id">
                    <strong>Reference ID:</strong> {{ $paymentData['reference_id'] }}
                </div>
            </div>

            @if($recipientType === 'professional')
            <div class="action-needed">
                <h4>Action Required</h4>
                <p>Your customer's payment has failed. Please reach out to them to help complete their booking.</p>
                <a href="tel:{{ $paymentData['phone'] ?? '' }}" class="btn">📞 Call Customer</a>
                <a href="mailto:{{ $userDetails['email'] }}" class="btn btn-secondary">✉️ Email Customer</a>
            </div>
            @else
            <div class="action-needed">
                <h4>Admin Review Required</h4>
                <p>This payment failure has been logged and may require follow-up with the customer or payment gateway.</p>
                <a href="#" class="btn">View Dashboard</a>
                <a href="#" class="btn btn-secondary">Payment Logs</a>
            </div>
            @endif

            <div class="timestamp">
                Notification sent on {{ now()->format('d M Y, h:i A') }}
            </div>
        </div>

        <div class="footer">
            <p>This is an automated notification from the Tazen booking system.</p>
            <p>Please do not reply to this email. For support, contact our technical team.</p>
        </div>
    </div>
</body>
</html>
