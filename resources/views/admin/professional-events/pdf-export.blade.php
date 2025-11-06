<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Professional Events Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
        }
        h1 {
            text-align: center;
            color: #333;
            font-size: 20px;
            margin-bottom: 20px;
        }
        .header-info {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #667eea;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 6px;
            vertical-align: top;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }
        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>
<body>
    <h1>Professional Events Report</h1>
    <div class="header-info">
        <p>Generated on: {{ date('F j, Y, g:i a') }}</p>
        <p>Total Events: {{ $events->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 15%;">Professional</th>
                <th style="width: 20%;">Event Details</th>
                <th style="width: 10%;">Date</th>
                <th style="width: 10%;">Fees</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 15%;">Meet Link</th>
                <th style="width: 15%;">Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
                <tr>
                    <td>{{ $event->id }}</td>
                    <td>
                        <strong>{{ $event->professional->name ?? 'N/A' }}</strong><br>
                        <small>{{ $event->professional->email ?? 'N/A' }}</small>
                    </td>
                    <td>
                        <strong>{{ $event->heading }}</strong><br>
                        <small>{{ $event->mini_heading }}</small>
                    </td>
                    <td>{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y') : 'N/A' }}</td>
                    <td>₹{{ number_format($event->starting_fees, 2) }}</td>
                    <td>
                        <span class="status-badge status-{{ $event->status }}">
                            {{ ucfirst($event->status) }}
                        </span>
                        @if($event->approved_at)
                            <br><small>{{ $event->approved_at->format('M d, Y') }}</small>
                        @endif
                    </td>
                    <td>
                        @if($event->meet_link)
                            {{ Str::limit($event->meet_link, 30) }}
                        @else
                            <small style="color: #999;">Not set</small>
                        @endif
                    </td>
                    <td>
                        @if($event->admin_notes)
                            {{ Str::limit($event->admin_notes, 50) }}
                        @else
                            <small style="color: #999;">-</small>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Professional Events Management System - {{ config('app.name') }}</p>
    </div>
</body>
</html>
