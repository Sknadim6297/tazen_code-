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

        .company-details {
            background: white;
            padding: 4px;
            border: 1px solid black;
            min-height: 60px;
        }

        .company-name {
            font-size: 11px;
            font-weight: bold;
            color: black;
            margin: 0 0 2px 0;
        }

        .detail-line {
            margin: 1px 0;
            color: black;
        }

        /* Order Details */
        .order-section {
            padding: 4px 10px;
            background: white;
            color: black;
            border-bottom: 1px solid black;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-table td {
            width: 50%;
            vertical-align: top;
            padding: 0 10px 0 0;
            border: none;
        }

        .order-label {
            font-weight: bold;
            display: inline-block;
            width: 90px;
        }

        /* Items Table */
        .items-section {
            padding: 4px 10px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            margin: 3px 0;
        }

        .items-table th {
            background: black;
            color: white;
            padding: 4px 2px;
            text-align: center;
            font-weight: bold;
            font-size: 9px;
            border: 1px solid black;
        }

        .items-table td {
            padding: 3px 2px;
            border: 1px solid black;
            text-align: center;
        }

        .items-table td:nth-child(2) {
            text-align: left;
        }

        .service-name {
            font-weight: bold;
            color: black;
            margin-bottom: 1px;
        }

        .service-details {
            font-size: 8px;
            color: black;
        }

        /* Total Section */
        .total-section {
            background: white;
            color: black;
            padding: 4px 10px;
            text-align: right;
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }

        .total-amount {
            font-size: 14px;
            font-weight: bold;
        }

        /* Amount in Words */
        .words-section {
            padding: 4px 10px;
            background: white;
            border-bottom: 1px solid black;
        }

        .words-label {
            font-weight: bold;
            color: black;
            margin-bottom: 1px;
        }

        .words-text {
            color: black;
            font-weight: bold;
        }

        /* Tax Info */
        .tax-info {
            padding: 3px 10px;
            background: white;
            text-align: center;
            border-bottom: 1px solid black;
        }

        /* Payment Section */
        .payment-section {
            padding: 4px 10px;
            background: white;
            border-bottom: 1px solid black;
        }

        .payment-table {
            width: 100%;
            border-collapse: collapse;
        }

        .payment-table td {
            width: 50%;
            vertical-align: top;
            padding: 1px 10px 1px 0;
            border: none;
        }

        .payment-item {
            margin: 2px 0;
            padding: 1px 0;
        }

        .payment-label {
            font-weight: bold;
            color: black;
            display: inline-block;
            width: 100px;
        }

        .payment-value {
            color: black;
        }

        /* Footer */
        .footer-section {
            padding: 4px 10px;
            background: white;
            color: black;
            text-align: right;
            border-bottom: 1px solid black;
        }

        .signature-area {
            margin: 5px 0;
        }

        .signature-line {
            border-top: 1px solid black;
            width: 120px;
            margin: 10px 0 3px auto;
        }

        .footer-note {
            text-align: center;
            padding: 4px 10px;
            background: white;
            font-size: 8px;
            color: black;
        }

        /* Utility Classes */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .mb-10 { margin-bottom: 10px; }
        .mt-10 { margin-top: 10px; }

        /* Print/PDF Optimization */
        @media print {
            body { 
                background: white; 
                padding: 0;
            }
            .invoice-container { 
                border: 1px solid #000;
                max-width: none;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header Section -->
        <div class="invoice-header">
            <table class="header-content">
                <tr>
                    <td class="logo-cell">
                        @php
                            $logoPath = public_path('customer-css/assets/images/tazen_logo.png');
                            $logoExists = file_exists($logoPath);
                        @endphp
                        
                        @if($logoExists)
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents($logoPath)) }}" alt="Tazen Logo" class="logo">
                        @else
                            <div style="font-size: 24px; font-weight: bold; color: black; text-align: center; padding: 12px; border: 1px solid black; width: 270px; height: 80px; line-height: 56px;">
                                TAZEN
                            </div>
                        @endif
                    </td>
                    <td class="title-cell">
                        <div class="invoice-title">TAX INVOICE</div>
                        <div class="invoice-subtitle">Bill of Supply/Cash Memo (Original for Recipient)</div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Company Information Section -->
        <div class="company-section">
            <table class="company-table">
                <tr>
                    <td>
                        <div class="section-header sold-by-header">Sold By</div>
                        <div class="company-details">
                            <div class="company-name">{{ strtoupper($booking->professional->name ?? 'Professional Name') }}</div>
                            @if($booking->professional && $booking->professional->profile)
                                @php $profile = $booking->professional->profile; @endphp
                                @if($profile->gst_address)
                                    <div class="detail-line">{{ $profile->gst_address }}</div>
                                @elseif($profile->address)
                                    <div class="detail-line">{{ $profile->address }}</div>
                                @elseif($profile->full_address)
                                    <div class="detail-line">{{ $profile->full_address }}</div>
                                @else
                                    <div class="detail-line">{{ $booking->professional->email }}</div>
                                @endif
                                @if($profile->state_name)
                                    <div class="detail-line">{{ strtoupper($profile->state_name) }}, INDIA</div>
                                @else
                                    <div class="detail-line">INDIA</div>
                                @endif
                            @else
                                <div class="detail-line">{{ $booking->professional->email ?? 'Professional Email' }}</div>
                                <div class="detail-line">INDIA</div>
                            @endif
                            <div class="detail-line mt-10">
                                @if($booking->professional && $booking->professional->profile)
                                    @php $profile = $booking->professional->profile; @endphp
                                    @if($profile->gst_number)
                                        <div><strong>GST Registration No:</strong> {{ strtoupper($profile->gst_number) }}</div>
                                    @endif
                                    @if($profile->state_code)
                                        <div><strong>State/UT Code:</strong> {{ $profile->state_code }}</div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="section-header">Billing Address</div>
                        <div class="company-details">
                            <div class="company-name">{{ $booking->customer_name }}</div>
                            <div class="detail-line">{{ $booking->customer_email }}</div>
                            <div class="detail-line">Phone: {{ $booking->customer_phone }}</div>
                            @if($booking->customer && $booking->customer->customerProfile)
                                @php $customerProfile = $booking->customer->customerProfile; @endphp
                                @if($customerProfile->address)
                                    <div class="detail-line">{{ $customerProfile->address }}</div>
                                @endif
                                @if($customerProfile->city)
                                    <div class="detail-line">{{ $customerProfile->city }}@if($customerProfile->state), {{ $customerProfile->state }}@endif @if($customerProfile->zip_code)- {{ $customerProfile->zip_code }}@endif</div>
                                @endif
                            @else
                                <div class="detail-line">Customer Address</div>
                                <div class="detail-line">City, State, PIN</div>
                            @endif
                            <div class="detail-line">INDIA</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Order Details Section -->
        <div class="order-section">
            <table class="order-table">
                <tr>
                    <td>
                        <div class="detail-line"><span class="order-label">Order Number:</span> TZ-{{ str_pad($booking->id, 8, '0', STR_PAD_LEFT) }}</div>
                        <div class="detail-line"><span class="order-label">Order Date:</span> {{ $booking->created_at->format('d.m.Y') }}</div>
                        <div class="detail-line"><span class="order-label">Service Date:</span> {{ \Carbon\Carbon::parse($booking->service_datetime)->format('d/m/Y H:i') }}</div>
                    </td>
                    <td>
                        <div class="detail-line"><span class="order-label">Invoice Number:</span> {{ $invoice_no }}</div>
                        <div class="detail-line"><span class="order-label">Invoice Date:</span> {{ $invoice_date }}</div>
                        <div class="detail-line"><span class="order-label">Place of Supply:</span> {{ $booking->professional->profile->state_name ?? 'West Bengal' }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- GST Calculation Summary -->
        <div style="margin: 10px; padding: 8px; border: 1px solid #ddd; background: #f9f9f9;">
            <h4 style="margin: 0 0 8px 0; font-size: 12px; text-align: center; color: #333;">BILLING SUMMARY</h4>
            @php
                $baseAmount = $booking->base_amount ?? ($booking->amount / 1.18);
                $cgstAmount = $booking->cgst_amount ?? ($baseAmount * 0.09);
                $sgstAmount = $booking->sgst_amount ?? ($baseAmount * 0.09);
                $igstAmount = $booking->igst_amount ?? 0;
                $totalTax = $cgstAmount + $sgstAmount + $igstAmount;
                $totalAmount = $baseAmount + $totalTax;
            @endphp
            <table style="width: 100%; border-collapse: collapse; font-size: 10px;">
                <tr>
                    <td style="border: 1px solid #ccc; padding: 4px; background: #e8f4f8;"><strong>Service Amount:</strong></td>
                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right; background: #e8f4f8;"><strong>₹{{ number_format($baseAmount, 2) }}</strong></td>
                </tr>
                @if($cgstAmount > 0)
                <tr>
                    <td style="border: 1px solid #ccc; padding: 4px;">CGST (9%):</td>
                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">₹{{ number_format($cgstAmount, 2) }}</td>
                </tr>
                @endif
                @if($sgstAmount > 0)
                <tr>
                    <td style="border: 1px solid #ccc; padding: 4px;">SGST (9%):</td>
                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">₹{{ number_format($sgstAmount, 2) }}</td>
                </tr>
                @endif
                @if($igstAmount > 0)
                <tr>
                    <td style="border: 1px solid #ccc; padding: 4px;">IGST (18%):</td>
                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">₹{{ number_format($igstAmount, 2) }}</td>
                </tr>
                @endif
                <tr>
                    <td style="border: 1px solid #ccc; padding: 4px; color: #d9534f;"><strong>Total GST (18%):</strong></td>
                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right; color: #d9534f;"><strong>₹{{ number_format($totalTax, 2) }}</strong></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ccc; padding: 4px; background: #d4edda; color: #155724;"><strong>Total Amount Payable:</strong></td>
                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right; background: #d4edda; color: #155724;"><strong>₹{{ number_format($totalAmount, 2) }}</strong></td>
                </tr>
            </table>
        </div>

        <!-- Items Section -->
        <div class="items-section">
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">Sl. No</th>
                        <th style="width: 40%;">Description</th>
                        <th style="width: 10%;">Unit Price</th>
                        <th style="width: 5%;">Qty</th>
                        <th style="width: 12%;">Net Amount</th>
                        <th style="width: 8%;">Tax Rate</th>
                        <th style="width: 8%;">Tax Type</th>
                        <th style="width: 12%;">Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $baseAmount = $booking->base_amount ?? ($booking->amount / 1.18);
                        $cgstAmount = $booking->cgst_amount ?? ($baseAmount * 0.09);
                        $sgstAmount = $booking->sgst_amount ?? ($baseAmount * 0.09);
                        $igstAmount = $booking->igst_amount ?? 0;
                        $totalTax = $cgstAmount + $sgstAmount + $igstAmount;
                        $totalAmount = $baseAmount + $totalTax;
                    @endphp
                    <!-- Service Line Item -->
                    <tr>
                        <td>1</td>
                        <td>
                            <div class="service-name">{{ $booking->service_name ?? 'Professional Service' }}</div>
                            <div class="service-details">
                                {{ ucwords(str_replace('_', ' ', $booking->plan_type)) }} Plan<br>
                                Professional Service Session<br>
                                Service Date: {{ $booking->service_datetime ? \Carbon\Carbon::parse($booking->service_datetime)->format('d/m/Y H:i') : $booking->created_at->format('d/m/Y H:i') }}<br>
                            </div>
                        </td>
                        <td>₹{{ number_format($baseAmount, 2) }}</td>
                        <td>1</td>
                        <td>₹{{ number_format($baseAmount, 2) }}</td>
                        <td>18%</td>
                        <td>GST</td>
                        <td>₹{{ number_format($baseAmount, 2) }}</td>
                    </tr>
                    
                    <!-- CGST Line Item -->
                    @if($cgstAmount > 0)
                    <tr>
                        <td></td>
                        <td><strong>CGST @ 9%</strong></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>9%</td>
                        <td>CGST</td>
                        <td>₹{{ number_format($cgstAmount, 2) }}</td>
                    </tr>
                    @endif
                    
                    <!-- SGST Line Item -->
                    @if($sgstAmount > 0)
                    <tr>
                        <td></td>
                        <td><strong>SGST @ 9%</strong></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>9%</td>
                        <td>SGST</td>
                        <td>₹{{ number_format($sgstAmount, 2) }}</td>
                    </tr>
                    @endif
                    
                    <!-- IGST Line Item -->
                    @if($igstAmount > 0)
                    <tr>
                        <td></td>
                        <td><strong>IGST @ 18%</strong></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>18%</td>
                        <td>IGST</td>
                        <td>₹{{ number_format($igstAmount, 2) }}</td>
                    </tr>
                    @endif
                    
                    <!-- Total Row -->
                    <tr style="background-color: #f0f0f0; font-weight: bold;">
                        <td colspan="7" style="text-align: right; padding-right: 10px;"><strong>TOTAL AMOUNT</strong></td>
                        <td style="font-weight: bold; font-size: 12px;">₹{{ number_format($totalAmount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Total Section -->
        <div class="total-section">
            <div class="total-amount">TOTAL: ₹{{ number_format($totalAmount, 2) }}</div>
        </div>

        <!-- Amount in Words -->
        <div class="words-section">
            <div class="words-label">Amount in Words:</div>
            <div class="words-text">{{ ucwords(\App\Helpers\NumberToWords::convert($totalAmount)) }} Only</div>
        </div>

        <!-- Tax Information -->
        <div class="tax-info">
            <strong>Whether tax is payable under reverse charge: NO</strong>
        </div>

        <!-- Payment Information -->
        <div class="payment-section">
            <table class="payment-table">
                <tr>
                    <td>
                        <div class="payment-item">
                            <span class="payment-label">Transaction ID:</span>
                            <span class="payment-value">{{ $booking->payment_id ?? 'CASH_PAYMENT_' . $booking->id }}</span>
                        </div>
                        <div class="payment-item">
                            <span class="payment-label">Payment Method:</span>
                            <span class="payment-value">{{ $booking->payment_method ?? 'Online Payment' }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="payment-item">
                            <span class="payment-label">Date & Time:</span>
                            <span class="payment-value">{{ $booking->created_at->format('d/m/Y, H:i:s') }}</span>
                        </div>
                        <div class="payment-item">
                            <span class="payment-label">Invoice Value:</span>
                            <span class="payment-value font-bold">₹{{ number_format($totalAmount, 2) }}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Footer Section -->
        <div class="footer-section">
            <div class="signature-area">
                <div class="font-bold">For {{ strtoupper($booking->professional->name ?? 'PROFESSIONAL NAME') }}:</div>
                <div class="signature-line"></div>
                <div>Authorized Signatory</div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="footer-note">
            <p>This is a computer generated invoice and does not require physical signature.</p>
            <p>For any queries regarding this invoice, please contact us at support@tazen.com</p>
            <p><strong>Thank you for choosing our services!</strong></p>
        </div>
    </div>
</body>
</html>