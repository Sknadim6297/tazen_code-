<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Bookings Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #667eea;
            margin: 0;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .summary {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .summary h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        
        th {
            background-color: #667eea;
            color: white;
            font-weight: bold;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .status {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-confirmed {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .status-completed {
            background: #d4edda;
            color: #155724;
        }
        
        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .amount {
            font-weight: bold;
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Bookings Report</h1>
        <p>Generated on {{ date('F j, Y \a\t g:i A') }}</p>
        <p>Total Records: {{ $bookings->count() }}</p>
    </div>

    <div class="summary">
        <h3>Summary</h3>
        <div style="display: flex; justify-content: space-between;">
            <div>
                <strong>Total Bookings:</strong> {{ $bookings->count() }}<br>
                <strong>Total Revenue:</strong> ₹{{ number_format($bookings->sum('total_amount'), 2) }}
            </div>
            <div>
                <strong>Completed:</strong> {{ $bookings->where('status', 'completed')->count() }}<br>
                <strong>Pending:</strong> {{ $bookings->where('status', 'pending')->count() }}<br>
                <strong>Cancelled:</strong> {{ $bookings->where('status', 'cancelled')->count() }}
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Professional</th>
                <th>Service</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>#{{ $booking->id }}</td>
                <td>
                    {{ $booking->customer_name }}<br>
                    <small>{{ optional($booking->user)->email }}</small>
                </td>
                <td>
                    {{ optional($booking->professional)->name }}<br>
                    <small>{{ optional($booking->professional)->email }}</small>
                </td>
                <td>
                    {{ $booking->service_name }}<br>
                    <small>{{ $booking->session_type }}</small>
                </td>
                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('M j, Y') }}</td>
                <td class="amount">₹{{ number_format($booking->total_amount, 2) }}</td>
                <td>
                    <span class="status status-{{ $booking->status }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This report was generated automatically by the Admin Booking Management System</p>
        <p>© {{ date('Y') }} Tazen. All rights reserved.</p>
    </div>
</body>
</html>