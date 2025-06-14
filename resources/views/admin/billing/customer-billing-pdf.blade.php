<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Customer Billing Report</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('{{ storage_path('fonts/DejaVuSans.ttf') }}');
            font-weight: normal;
            font-style: normal;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
        h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .date {
            font-size: 12px;
            margin-bottom: 20px;
        }
        .filter-info {
            font-size: 10px;
            margin-bottom: 15px;
            padding: 5px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #f2f2f2;
        }
        .summary {
            margin-top: 20px;
            margin-bottom: 30px;
            width: 50%;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>CUSTOMER BILLING REPORT</h1>
        <div class="date">Generated on: {{ $filterInfo['generated_at'] }}</div>
    </div>
    
    <div class="filter-info">
        <strong>Filter:</strong> Date: {{ $filterInfo['start_date'] }} to {{ $filterInfo['end_date'] }} | 
        Plan Type: {{ $filterInfo['plan_type'] }} | SMS Status: {{ $filterInfo['sms_status'] }}
    </div>
    
    <div class="summary">
        <table>
            <tr>
                <th colspan="2">Summary</th>
            </tr>
            <tr>
                <td>Total Billings</td>
                <td>{{ count($billings) }}</td>
            </tr>
            <tr>
                <td>Total Amount</td>
                <td>&#8377;{{ number_format($totalAmount, 2) }}</td>
            </tr>
            <tr>
                <td>One Time Plans</td>
                <td>{{ $planCounts['one_time'] }}</td>
            </tr>
            <tr>
                <td>Monthly Plans</td>
                <td>{{ $planCounts['monthly'] }}</td>
            </tr>
            <tr>
                <td>Quarterly Plans</td>
                <td>{{ $planCounts['quarterly'] }}</td>
            </tr>
            <tr>
                <td>Free Hand Plans</td>
                <td>{{ $planCounts['free_hand'] }}</td>
            </tr>
        </table>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Date</th>
                <th>Customer Name</th>
                <th>Service</th>
                <th>Professional</th>
                <th>Plan</th>
                <th>Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($billings as $key => $billing)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $billing->created_at->format('d M Y') }}</td>
                <td>{{ $billing->customer_name }}</td>
                <td>{{ $billing->service_name }}</td>
                <td>{{ $billing->professional->name ?? 'N/A' }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $billing->plan_type)) }}</td>
                <td>&#8377;{{ number_format($billing->amount, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center">No billing records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        © {{ date('Y') }} Tazen - Customer Billing Report
    </div>
    
    <script type="text/php">
        if (isset($pdf)) {
            $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
            $size = 8;
            $font = $fontMetrics->getFont("DejaVu Sans");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) - 15;
            $y = $pdf->get_height() - 15;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>
</html>