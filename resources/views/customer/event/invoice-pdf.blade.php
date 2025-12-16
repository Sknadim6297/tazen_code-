<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Tax Invoice #{{ $invoice_no }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 5px;
            background: white;
            color: black;
            font-size: 11px;
            line-height: 1.1;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border: 1px solid black;
            padding: 0;
        }

        /* Header Section */
        .invoice-header {
            background: white;
            color: black;
            padding: 5px 10px;
            border-bottom: 1px solid black;
        }

        .header-content {
            width: 100%;
            border-collapse: collapse;
        }

        .header-content td {
            vertical-align: middle;
            border: none;
        }

        .logo-cell {
            width: 40%;
            text-align: left;
        }

        .title-cell {
            width: 60%;
            text-align: right;
        }

        .logo {
            height: 80px;
            max-width: 270px;
        }

        .invoice-title {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            color: black;
        }

        .invoice-subtitle {
            font-size: 9px;
            margin: 0;
            color: black;
        }

        /* Company Info Section */
        .company-section {
            padding: 5px 10px;
            background: white;
            border-bottom: 1px solid black;
        }

        .company-table {
            width: 100%;
            border-collapse: collapse;
        }

        .company-table td {
            width: 50%;
            vertical-align: top;
            padding: 0 5px 0 0;
            border: none;
        }

        .section-header {
            background: black;
            color: white;
            padding: 2px 4px;
            font-weight: bold;
            font-size: 10px;
            margin: 0 0 3px 0;
            text-transform: uppercase;
            text-align: center;
        }

        .company-info {
            background: #f8f9fa;
            padding: 5px;
            border: 1px solid #ddd;
            font-size: 9px;
            line-height: 1.2;
        }

        /* Invoice Details Section */
        .invoice-details-section {
            padding: 5px 10px;
            background: white;
            border-bottom: 1px solid black;
        }

        .invoice-details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-details-table td {
            width: 50%;
            vertical-align: top;
            padding: 0 5px 0 0;
            border: none;
        }

        .invoice-info {
            background: #f8f9fa;
            padding: 5px;
            border: 1px solid #ddd;
            font-size: 9px;
            line-height: 1.2;
        }

        /* Event Details Section */
        .event-section {
            padding: 5px 10px;
            background: white;
            border-bottom: 1px solid black;
        }

        .event-details {
            background: #f8f9fa;
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 10px;
            line-height: 1.3;
        }

        .event-title {
            font-weight: bold;
            font-size: 12px;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        /* Service Table */
        .service-table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
            font-size: 10px;
        }

        .service-table th, .service-table td {
            border: 1px solid black;
            padding: 4px;
            text-align: left;
        }

        .service-table th {
            background: black;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .service-table .number-cell {
            text-align: center;
            width: 8%;
        }

        .service-table .amount-cell {
            text-align: right;
            width: 15%;
        }

        /* Tax Section */
        .tax-section {
            padding: 5px 10px;
            background: white;
            border-bottom: 1px solid black;
        }

        .tax-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .tax-table td {
            padding: 2px 4px;
            border: 1px solid black;
        }

        .tax-table .tax-label {
            background: #f8f9fa;
            font-weight: bold;
            width: 70%;
        }

        .tax-table .tax-amount {
            text-align: right;
            width: 30%;
        }

        .total-row {
            background: black;
            color: white;
            font-weight: bold;
        }

        /* Footer */
        .footer {
            padding: 10px;
            background: white;
            text-align: center;
            font-size: 8px;
            color: #666;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <table class="header-content">
                <tr>
                    <td class="logo-cell">
                        @if(file_exists(public_path('img/logo.png')))
                            <img src="{{ public_path('img/logo.png') }}" alt="Logo" class="logo">
                        @else
                            <div style="font-size: 14px; font-weight: bold;">Your Company</div>
                        @endif
                    </td>
                    <td class="title-cell">
                        <h1 class="invoice-title">TAX INVOICE</h1>
                        <p class="invoice-subtitle">Original for Recipient</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Company & Customer Info -->
        <div class="company-section">
            <table class="company-table">
                <tr>
                    <td>
                        <div class="section-header">Company Details</div>
                        <div class="company-info">
                            <strong>{{ config('app.name', 'Your Company') }}</strong><br>
                            Your Company Address<br>
                            City, State - PIN Code<br>
                            Phone: +91 XXXXXXXXXX<br>
                            Email: info@yourcompany.com<br>
                            GSTIN: XXGSTXXXXXXXXX
                        </div>
                    </td>
                    <td>
                        <div class="section-header">Bill To</div>
                        <div class="company-info">
                            <strong>{{ $customer->name ?? 'N/A' }}</strong><br>
                            {{ $customer->email ?? 'N/A' }}<br>
                            {{ $customer->phone ?? 'N/A' }}<br>
                            @if($customer->address ?? false)
                                {{ $customer->address }}<br>
                            @endif
                            @if($customer->city ?? false)
                                {{ $customer->city }}, {{ $customer->state ?? '' }} - {{ $customer->pincode ?? '' }}<br>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details-section">
            <table class="invoice-details-table">
                <tr>
                    <td>
                        <div class="section-header">Invoice Details</div>
                        <div class="invoice-info">
                            <strong>Invoice No:</strong> {{ $invoice_no }}<br>
                            <strong>Invoice Date:</strong> {{ $invoice_date }}<br>
                            <strong>Event Booking ID:</strong> #{{ $eventBooking->id }}<br>
                            <strong>Payment Status:</strong> 
                            <span style="color: green; font-weight: bold;">{{ ucfirst($eventBooking->payment_status) }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="section-header">Professional Details</div>
                        <div class="invoice-info">
                            @if($professional)
                                <strong>{{ $professional->name ?? 'N/A' }}</strong><br>
                                {{ $professional->email ?? 'N/A' }}<br>
                                {{ $professional->phone ?? 'N/A' }}<br>
                                @if($professional->business_name ?? false)
                                    Business: {{ $professional->business_name }}<br>
                                @endif
                            @else
                                <strong>Professional information not available</strong>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Event Details -->
        <div class="event-section">
            <div class="section-header">Event Details</div>
            <div class="event-details">
                <div class="event-title">{{ $event->heading ?? 'Event Booking' }}</div>
                @if($event->description ?? false)
                    <div style="margin-bottom: 5px;"><strong>Description:</strong> {{ strip_tags($event->description) }}</div>
                @endif
                <div style="margin-bottom: 3px;"><strong>Event Date:</strong> 
                    {{ $eventBooking->event_date ? \Carbon\Carbon::parse($eventBooking->event_date)->format('d M, Y') : 'TBD' }}
                </div>
                <div style="margin-bottom: 3px;"><strong>Event Time:</strong> 
                    {{ $eventBooking->event_time ?? 'TBD' }}
                </div>
                @if($eventBooking->attendees ?? false)
                    <div style="margin-bottom: 3px;"><strong>Number of Attendees:</strong> {{ $eventBooking->attendees }}</div>
                @endif
                @if($eventBooking->type ?? false)
                    <div style="margin-bottom: 3px;"><strong>Event Type:</strong> {{ ucfirst($eventBooking->type) }}</div>
                @endif
                <div style="margin-bottom: 3px;"><strong>Booking Date:</strong> 
                    {{ $eventBooking->created_at->format('d M, Y H:i A') }}
                </div>
            </div>
        </div>

        <!-- Service Details Table -->
        <div style="padding: 5px 10px;">
            <table class="service-table">
                <thead>
                    <tr>
                        <th class="number-cell">S.No</th>
                        <th>Description</th>
                        <th class="amount-cell">Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="number-cell">1</td>
                        <td>{{ $event->heading ?? 'Event Booking Service' }}</td>
                        <td class="amount-cell">₹{{ number_format($pricing['base_price'], 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tax Calculation -->
        <div class="tax-section">
            <div class="section-header">Tax Calculation</div>
            <table class="tax-table">
                <tr>
                    <td class="tax-label">Subtotal</td>
                    <td class="tax-amount">₹{{ number_format($pricing['base_price'], 2) }}</td>
                </tr>
                @if($pricing['cgst'] > 0)
                <tr>
                    <td class="tax-label">CGST @ {{ $pricing['cgst'] }}%</td>
                    <td class="tax-amount">₹{{ number_format(($pricing['base_price'] * $pricing['cgst']) / 100, 2) }}</td>
                </tr>
                @endif
                @if($pricing['sgst'] > 0)
                <tr>
                    <td class="tax-label">SGST @ {{ $pricing['sgst'] }}%</td>
                    <td class="tax-amount">₹{{ number_format(($pricing['base_price'] * $pricing['sgst']) / 100, 2) }}</td>
                </tr>
                @endif
                @if($pricing['igst'] > 0)
                <tr>
                    <td class="tax-label">IGST @ {{ $pricing['igst'] }}%</td>
                    <td class="tax-amount">₹{{ number_format(($pricing['base_price'] * $pricing['igst']) / 100, 2) }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td class="tax-label">Total Amount</td>
                    <td class="tax-amount">₹{{ number_format($pricing['total_price'], 2) }}</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Thank you for your business!</strong></p>
            <p>This is a computer-generated invoice and does not require a physical signature.</p>
            <p>Generated on {{ now()->format('d M, Y H:i A') }}</p>
        </div>
    </div>
</body>
</html>