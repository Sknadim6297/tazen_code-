<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #{{ $invoice_no }}</title>
    
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #fff;
            font-size: 14px;
            line-height: 1.4;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            background-color: #fff;
        }
        
        .invoice-header {
            display: flex;
            margin-bottom: 40px;
        }
        
        .logo-container {
            flex: 1;
        }
        
        .logo {
            max-width: 150px;
        }
        
        .invoice-title {
            flex: 1;
            text-align: right;
        }
        
        .invoice-title h1 {
            color: #5D3FD3;
            font-size: 28px;
            margin: 0;
        }
        
        .invoice-title h3 {
            color: #666;
            font-size: 16px;
            margin: 5px 0;
            font-weight: normal;
        }

        .invoice-info {
            display: flex;
            margin-bottom: 30px;
        }
        
        .client-info {
            flex: 1;
        }
        
        .invoice-details {
            flex: 1;
            text-align: right;
        }
        
        .invoice-details h4, .client-info h4 {
            color: #5D3FD3;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            font-size: 14px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        
        table.info-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table.info-table td {
            padding: 5px 0;
            vertical-align: top;
        }
        
        table.info-table td:first-child {
            font-weight: bold;
            padding-right: 20px;
            color: #666;
        }

        .invoice-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 35px;
        }
        
        .invoice-items th {
            background-color: #5D3FD3;
            color: white;
            font-weight: 500;
            text-align: left;
            padding: 12px 15px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: none;
        }
        
        .invoice-items td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            border-left: none;
            border-right: none;
        }
        
        .invoice-items tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .text-right {
            text-align: right;
        }
        
        .invoice-totals {
            margin-left: auto;
            width: 350px;
        }
        
        .invoice-totals table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .invoice-totals td {
            padding: 8px 15px;
        }
        
        .invoice-totals tr.total {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 16px;
            border-top: 2px solid #5D3FD3;
        }
        
        .invoice-totals tr.total td {
            padding: 12px 15px;
            color: #5D3FD3;
        }
        
        .footer {
            margin-top: 60px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        
        .footer p {
            margin: 5px 0;
        }
        
        .footer .thank-you {
            font-size: 18px;
            color: #5D3FD3;
            margin-bottom: 10px;
        }
        
        /* Payment status */
        .payment-status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 15px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }
        
        .status-paid {
            background-color: #e6f7e6;
            color: #2e7d32;
        }
        
        .status-pending {
            background-color: #fff8e1;
            color: #f57c00;
        }
        
        /* For the rupee symbol */
        .rupee {
            font-family: Arial, sans-serif;
            display: inline-block;
            margin-right: 1px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <div class="logo-container">
                <!-- Replace with your logo -->
                <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Tazen Logo">
            </div>
            <div class="invoice-title">
                <h1>INVOICE</h1>
                <h3>#{{ $invoice_no }}</h3>
                <div class="payment-status status-paid">Paid</div>
            </div>
        </div>

        <div class="invoice-info">
            <div class="client-info">
                <h4>Billed To</h4>
                <p>
                    <strong>{{ $booking->customer_name }}</strong><br>
                    {{ $booking->customer_email }}<br>
                    {{ $booking->customer_phone }}
                </p>

                <h4>Professional</h4>
                <p>
                    <strong>{{ $booking->professional->name ?? 'N/A' }}</strong><br>
                    <!-- Add professional details if available -->
                    @if(isset($booking->professional))
                        {{ $booking->professional->email ?? '' }}
                    @endif
                </p>
            </div>
            <div class="invoice-details">
                <h4>Invoice Details</h4>
                <table class="info-table">
                    <tr>
                        <td>Invoice Number:</td>
                        <td>{{ $invoice_no }}</td>
                    </tr>
                    <tr>
                        <td>Issue Date:</td>
                        <td>{{ $invoice_date }}</td>
                    </tr>
                    <tr>
                        <td>Payment Method:</td>
                        <td>Online Payment</td>
                    </tr>
                </table>
            </div>
        </div>

        <table class="invoice-items">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Plan Type</th>
                    <th>Sessions</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $booking->service_name }}</td>
                    <td>{{ ucwords(str_replace('_', ' ', $booking->plan_type)) }}</td>
                    <td>{{ count(json_decode($booking->days, true)) }}</td>
                    <td class="text-right">Rs. {{ number_format($booking->amount, 2) }}</td>
                </tr>
                <!-- You can add additional items here if needed -->
            </tbody>
        </table>

        <div class="invoice-totals">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td class="text-right">Rs. {{ number_format($booking->amount, 2) }}</td>
                </tr>
                <tr>
                    <td>Tax (0%):</td>
                    <td class="text-right">Rs. 0.00</td>
                </tr>
                <tr class="total">
                    <td>Total Amount:</td>
                    <td class="text-right">Rs. {{ number_format($booking->amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p class="thank-you">Thank you for choosing Tazen!</p>
            <p>This is a computer-generated invoice. No signature required.</p>
            <p>For any queries related to this invoice, please contact support@tazen.com</p>
            <p>&copy; {{ date('Y') }} Tazen. All rights reserved.</p>
        </div>
    </div>
</body>
</html>