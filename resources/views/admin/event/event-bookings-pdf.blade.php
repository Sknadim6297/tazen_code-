<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Event Bookings Report</title>
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
        <h1>EVENT BOOKINGS REPORT</h1>
        <div class="date">Generated on: {{ $filterInfo['generated_at'] }}</div>
    </div>
    
    <div class="filter-info">
        <strong>Filter:</strong> Date: {{ $filterInfo['start_date'] }} to {{ $filterInfo['end_date'] }} | 
        Status: {{ $filterInfo['status'] }} | Search: {{ $filterInfo['search'] }}
    </div>
    
    <div class="summary">
        <table>
            <tr>
                <th colspan="2">Summary</th>
            </tr>
            <tr>
                <td>Total Bookings</td>
                <td>{{ $totalBookings }}</td>
            </tr>
            <tr>
                <td>Total Amount</td>
                <td>&#8377;{{ number_format($totalAmount, 2) }}</td>
            </tr>
            @foreach($statusCounts as $status => $count)
            <tr>
                <td>{{ ucfirst($status) }} Bookings</td>
                <td>{{ $count }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Booking Date</th>
                <th>Event Date</th>
                <th>Customer Name</th>
                <th>Event Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Amount (₹)</th>
                <th>Status</th>
                <th>Meeting Link</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $key => $booking)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $booking->created_at->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($booking->event_date)->format('d M Y') }}</td>
                <td>{{ $booking->user->name ?? 'N/A' }}</td>
                <td>{{ $booking->event->heading ?? 'N/A' }}</td>
                <td>{{ $booking->user->email ?? 'N/A' }}</td>
                <td>{{ $booking->user->phone ?? 'N/A' }}</td>
                <td>&#8377;{{ number_format($booking->amount, 2) }}</td>
                <td>{{ ucfirst($booking->payment_status) }}</td>
                <td>{{ $booking->gmeet_link ? 'Available' : 'Not Set' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align:center">No event bookings found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        © {{ date('Y') }} Tazen - Event Bookings Report
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