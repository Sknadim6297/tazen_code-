<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Quarterly Bookings Report</title>
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
        <h1>QUARTERLY BOOKINGS REPORT</h1>
        <div class="date">Generated on: {{ $filterInfo['generated_at'] }}</div>
    </div>
    
    <div class="filter-info">
        <strong>Filter:</strong> Date: {{ $filterInfo['start_date'] }} to {{ $filterInfo['end_date'] }} | 
        Status: {{ $filterInfo['status'] }} | Service: {{ $filterInfo['service'] }}
        @if(!empty($filterInfo['search']))
        | Search: "{{ $filterInfo['search'] }}"
        @endif
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
            <tr>
                <td>Completed Sessions</td>
                <td>{{ $completedSessions }}</td>
            </tr>
            <tr>
                <td>Pending Sessions</td>
                <td>{{ $pendingSessions }}</td>
            </tr>
        </table>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Customer Details</th>
                <th>Professional</th>
                <th>Service</th>
                <th>Sub-Service</th>
                <th>Amount</th>
                <th>Sessions (Total/Done/Pending)</th>
                <th>Validity Till</th>
                <th>Next Session</th>
                <th>Status</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $key => $booking)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $booking->customer_name }}<br>{{ $booking->customer_phone }}</td>
                <td>{{ $booking->professional->name ?? 'N/A' }}</td>
                <td>{{ $booking->service_name }}</td>
                <td>{{ $booking->sub_service_name ?? '-' }}</td>
                <td>
                    @if($booking->payment_status === 'paid')
                        &#8377;{{ number_format($booking->amount, 2) }}
                    @else
                        Not Paid
                    @endif
                </td>
                <td>
                    {{ is_array($booking->days) ? count($booking->days) : count(json_decode($booking->days, true)) }} / 
                    {{ $booking->completed_sessions }} / 
                    {{ $booking->pending_sessions }}
                </td>
                <td>{{ $booking->quarter ?? '3 months' }}</td>
                <td>
                    @if($booking->next_booking)
                        {{ \Carbon\Carbon::parse($booking->next_booking->date)->format('d M Y') }}
                        <br>{{ $booking->next_booking->time_slot }}
                    @else
                        No upcoming sessions
                    @endif
                </td>
                <td>{{ ucfirst($booking->status ?? 'Pending') }}</td>
                <td>{{ $booking->remarks ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align:center">No booking records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        © {{ date('Y') }} Tazen - Quarterly Bookings Report
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