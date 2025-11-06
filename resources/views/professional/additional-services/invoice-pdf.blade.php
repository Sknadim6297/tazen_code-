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
        
        .gst-breakdown {
            background: #e3f2fd;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
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



        <!-- GST Breakdown -->
        <div class="gst-breakdown">
            <h5>Price Breakdown</h5>
            <table class="table">
                <tbody>
                    <tr>
                        <td>Base Price</td>
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
                        <td><strong>Total Amount</strong></td>
                        <td class="text-end"><strong>₹{{ number_format($pricing['total_price'], 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>



        <!-- Footer -->
        <div class="text-center border-top">
            <p class="text-muted">
                <small>
                    This is a computer-generated invoice. No signature required.<br>
                    Generated on {{ now()->format('d M, Y H:i') }}
                </small>
            </p>
        </div>
    </div>
</body>
</html>