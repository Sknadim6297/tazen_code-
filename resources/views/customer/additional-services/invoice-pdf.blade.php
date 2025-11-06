<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Additional Service Invoice - {{ $invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .invoice-header {
            border-bottom: 3px solid #007bff;
            margin-bottom: 30px;
            padding-bottom: 20px;
        }
        
        .invoice-title {
            color: #007bff;
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .invoice-subtitle {
            color: #666;
            font-size: 16px;
        }
        
        .row {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .col-6 {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 15px;
        }
        
        .text-end {
            text-align: right;
        }
        
        .border {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .table th,
        .table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        
        .table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        
        .pricing-breakdown {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .price-flow {
            display: table;
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            background: white;
            border-radius: 5px;
            border-left: 4px solid #28a745;
        }
        
        .price-stage {
            display: table-cell;
            text-align: center;
            width: 20%;
            vertical-align: middle;
        }
        
        .price-arrow {
            display: table-cell;
            text-align: center;
            width: 5%;
            font-size: 18px;
            color: #007bff;
            vertical-align: middle;
        }
        
        .price-value {
            font-size: 16px;
            font-weight: bold;
            color: #28a745;
        }
        
        .price-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
        
        .savings-note {
            background: #d4edda;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
            border-left: 4px solid #28a745;
            font-size: 11px;
        }
        
        .negotiation-history {
            background: #e3f2fd;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid #2196f3;
        }
        
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .badge.bg-success {
            background-color: #28a745;
            color: white;
        }
        
        .badge.bg-warning {
            background-color: #ffc107;
            color: black;
        }
        
        .badge.bg-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-muted {
            color: #666;
        }
        
        .border-top {
            border-top: 1px solid #ddd;
            padding-top: 20px;
            margin-top: 20px;
        }
        
        h5 {
            font-size: 16px;
            margin: 15px 0 10px 0;
            color: #333;
        }
        
        .table-success {
            background-color: #d4edda;
        }
        
        strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Invoice Header -->
        <div class="invoice-header">
            <div class="row">
                <div class="col-6">
                    <h1 class="invoice-title">INVOICE</h1>
                    <p class="invoice-subtitle">Additional Service</p>
                </div>
                <div class="col-6 text-end">
                    <p><strong>Invoice #:</strong> {{ $invoice_number }}</p>
                    <p><strong>Date:</strong> {{ $invoice_date }}</p>
                    <p><strong>Service ID:</strong> AS-{{ str_pad($service->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
        </div>

        <!-- Customer & Professional Details -->
        <div class="row">
            <div class="col-6">
                <h5>Bill To:</h5>
                <div class="border">
                    <strong>{{ $customer->name }}</strong><br>
                    {{ $customer->email }}<br>
                    @if($customer->phone)
                        {{ $customer->phone }}<br>
                    @endif
                    @if($customer->address)
                        {{ $customer->address }}
                    @endif
                </div>
            </div>
            <div class="col-6">
                <h5>Service Provider:</h5>
                <div class="border">
                    <strong>{{ $professional->name }}</strong><br>
                    {{ $professional->email }}<br>
                    Professional ID: {{ $professional->id }}
                </div>
            </div>
        </div>

        <!-- Service Details -->
        <h5>Service Details</h5>
        <table class="table">
            <tbody>
                <tr>
                    <td><strong>Service Name</strong></td>
                    <td>{{ $service->service_name }}</td>
                </tr>
                <tr>
                    <td><strong>Description</strong></td>
                    <td>{{ $service->reason }}</td>
                </tr>
                <tr>
                    <td><strong>Status</strong></td>
                    <td>
                        <span class="badge bg-success">Completed & Paid</span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Completion Date</strong></td>
                    <td>{{ $service->professional_completed_at ? $service->professional_completed_at->format('d M, Y H:i') : '-' }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Payment Breakdown -->
        <h5>Payment Breakdown</h5>
        <table class="table">
            <tbody>
                <tr>
                    <td>Service Amount</td>
                    <td class="text-end">₹{{ number_format($pricing['base_price'], 2) }}</td>
                </tr>
                <tr>
                    <td>CGST (9%)</td>
                    <td class="text-end">₹{{ number_format($pricing['cgst'], 2) }}</td>
                </tr>
                <tr>
                    <td>SGST (9%)</td>
                    <td class="text-end">₹{{ number_format($pricing['sgst'], 2) }}</td>
                </tr>
                @if($pricing['igst'] > 0)
                <tr>
                    <td>IGST (18%)</td>
                    <td class="text-end">₹{{ number_format($pricing['igst'], 2) }}</td>
                </tr>
                @endif
                <tr class="table-success">
                    <td><strong>Total Amount Paid</strong></td>
                    <td class="text-end"><strong>₹{{ number_format($pricing['total_price'], 2) }}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Footer -->
        <div class="text-center border-top">
            <p class="text-muted">
                <small>
                    Thank you for using our services!<br>
                    This is a computer-generated invoice. Generated on {{ now()->format('d M, Y H:i') }}
                </small>
            </p>
        </div>
    </div>
</body>
</html>