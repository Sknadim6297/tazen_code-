<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Billing Transactions</title>
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
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
        }
        
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
        
        h1 {
            font-size: 22px;
            margin-bottom: 5px;
            color: #2d3748;
        }
        
        .date {
            font-size: 12px;
            margin-bottom: 10px;
            color: #718096;
        }
        
        .user-info {
            margin-bottom: 30px;
        }
        
        .summary-container {
            margin-bottom: 30px;
        }
        
        .summary {
            width: 100%;
            margin-bottom: 20px;
        }
        
        .summary td {
            padding: 8px 12px;
        }
        
        .summary-title {
            font-weight: bold;
            background-color: #f7fafc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            border: 1px solid #e2e8f0;
            padding: 10px;
            text-align: left;
            font-size: 10px;
        }
        
        th {
            background-color: #f7fafc;
            font-weight: bold;
            color: #4a5568;
        }
        
        .table-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            color: #2d3748;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #718096;
        }
        
        .badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 500;
        }
        
        .badge-weekly {
            background-color: #e6fffa;
            color: #38b2ac;
        }
        
        .badge-monthly {
            background-color: #ebf4ff;
            color: #667eea;
        }
        
        .badge-quarterly {
            background-color: #feebc8;
            color: #ed8936;
        }
        
        .badge-one_time, .badge-free_hand {
            background-color: #e9e9ff;
            color: #5a67d8;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>TAZEN BILLING TRANSACTIONS</h1>
        <div class="date">Generated on: {{ $generatedDate }}</div>
    </div>
    
    <div class="user-info">
        <strong>User:</strong> {{ $user->name }} ({{ $user->email }})<br>
        <strong>Account Since:</strong> {{ $user->created_at->format('d M Y') }}
    </div>
    
    <div class="summary-container">
        <div class="summary-title">Summary</div>
        <table class="summary">
            <tr>
                <td width="50%"><strong>Total Transactions:</strong></td>
                <td>{{ $totalTransactions }}</td>
            </tr>
            <tr>
                <td><strong>Total Amount Paid:</strong></td>
                <td>₹{{ number_format($totalAmount, 2) }}</td>
            </tr>
        </table>
        
        <div class="summary-title">Plan Type Breakdown</div>
        <table class="summary">
            <tr>
                <th>Plan Type</th>
                <th>Count</th>
                <th>Total Amount</th>
            </tr>
            @foreach($planTypeSummary as $planType => $summary)
            <tr>
                <td>{{ ucwords(str_replace('_', ' ', $planType)) }}</td>
                <td>{{ $summary['count'] }}</td>
                <td>₹{{ number_format($summary['amount'], 2) }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    
    <div class="table-title">Transaction History</div>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Date</th>
                <th>Service</th>
                <th>Professional</th>
                <th>Plan Type</th>
                <th>Amount</th>
                <th>Payment ID</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $index => $booking)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $booking->created_at->format('d M Y') }}</td>
                <td>{{ $booking->service_name }}</td>
                <td>{{ $booking->professional->name ?? 'N/A' }}</td>
                <td>
                    <span class="badge badge-{{ strtolower($booking->plan_type) }}">
                        {{ ucwords(str_replace('_', ' ', $booking->plan_type)) }}
                    </span>
                </td>
                <td>₹{{ number_format($booking->amount, 2) }}</td>
                <td>{{ $booking->payment_id }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center">No transactions found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        © {{ date('Y') }} Tazen - This is an automatically generated report of your billing transactions.
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