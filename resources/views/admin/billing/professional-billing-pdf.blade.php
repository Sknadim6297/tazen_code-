<!-- Save as: resources/views/admin/billing/professional-billing-pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Professional Billing Report</title>
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
        <h1>PROFESSIONAL BILLING REPORT</h1>
        <div class="date">Generated on: {{ now()->format('F d, Y H:i:s') }}</div>
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
                <td>Total Commission Earned</td>
                <td>&#8377;{{ number_format($totalCommission, 2) }}</td>
            </tr>
            <tr>
                <td>Total Professional Pay</td>
                <td>&#8377;{{ number_format($totalProfessionalPay, 2) }}</td>
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
                <th>Commission</th>
                <th>Prof. Pay (₹)</th>
                <th>Status</th>
                <th>Month</th>
            </tr>
        </thead>
        <tbody>
            @forelse($billings as $key => $billing)
            @php
                $commissionRate = $billing->professional->margin ?? 0; 
                $professionalPay = $billing->amount * ((100 - $commissionRate) / 100);
                $amountEarned = $billing->amount * ($commissionRate / 100);
            @endphp
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $billing->created_at->format('d M Y') }}</td>
                <td>{{ $billing->customer_name }}</td>
                <td>{{ $billing->service_name }}</td>
                <td>{{ $billing->professional->name ?? 'N/A' }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $billing->plan_type)) }}</td>
                <td>&#8377;{{ number_format($billing->amount, 2) }}</td>
                <td>{{ $commissionRate }}%</td>
                <td>&#8377;{{ number_format($professionalPay, 2) }}</td>
                <td>{{ ucfirst($billing->payment_status) }}</td>
                <td>{{ $billing->created_at->format('M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="11" style="text-align:center">No billing records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        © {{ date('Y') }} Tazen - All Rights Reserved
    </div>
</body>
</html>