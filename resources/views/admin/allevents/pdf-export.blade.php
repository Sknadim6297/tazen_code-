<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>All Events Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
            font-size: 22px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .header-info {
            text-align: center;
            margin-bottom: 25px;
            color: #666;
            font-size: 11px;
        }
        .header-info p {
            margin: 3px 0;
        }
        .filters-applied {
            background-color: #f8f9fa;
            padding: 10px;
            border-left: 4px solid #667eea;
            margin-bottom: 20px;
            font-size: 10px;
        }
        .filters-applied strong {
            color: #667eea;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #667eea;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
        }
        td {
            padding: 6px;
            vertical-align: top;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            text-align: center;
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
        .creator-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .creator-admin {
            background-color: #e7f3ff;
            color: #0066cc;
        }
        .creator-professional {
            background-color: #fff3e0;
            color: #e65100;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .summary-stats {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .stat-box {
            display: table-cell;
            width: 25%;
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }
        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #667eea;
        }
        .stat-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h1>All Events Report</h1>
    <div class="header-info">
        <p><strong>Generated on:</strong> {{ date('F j, Y, g:i a') }}</p>
        <p><strong>Total Events:</strong> {{ $events->count() }}</p>
    </div>

    @if(request('filter') || request('status') || request('from_date') || request('to_date') || request('search'))
    <div class="filters-applied">
        <strong>Filters Applied:</strong>
        @if(request('filter'))
            <span>Creator: {{ ucfirst(request('filter')) }}</span> |
        @endif
        @if(request('status'))
            <span>Status: {{ ucfirst(request('status')) }}</span> |
        @endif
        @if(request('from_date'))
            <span>From: {{ date('M d, Y', strtotime(request('from_date'))) }}</span> |
        @endif
        @if(request('to_date'))
            <span>To: {{ date('M d, Y', strtotime(request('to_date'))) }}</span> |
        @endif
        @if(request('search'))
            <span>Search: "{{ request('search') }}"</span>
        @endif
    </div>
    @endif

    <!-- Summary Statistics -->
    <div class="summary-stats">
        <div class="stat-box">
            <div class="stat-number">{{ $events->where('created_by_type', 'admin')->count() }}</div>
            <div class="stat-label">Admin Events</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $events->where('created_by_type', 'professional')->count() }}</div>
            <div class="stat-label">Professional Events</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $events->where('status', 'approved')->count() }}</div>
            <div class="stat-label">Approved</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $events->where('status', 'pending')->count() }}</div>
            <div class="stat-label">Pending</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 4%;">ID</th>
                <th style="width: 8%;">Date</th>
                <th style="width: 18%;">Event Details</th>
                <th style="width: 12%;">Created By</th>
                <th style="width: 12%;">Service Offered</th>
                <th style="width: 8%;">Fees</th>
                <th style="width: 8%;">Status</th>
                <th style="width: 15%;">Meet Link</th>
                <th style="width: 15%;">Notes</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
                <tr>
                    <td style="text-align: center;">{{ $event->id }}</td>
                    <td>{{ $event->date ? date('M d, Y', strtotime($event->date)) : 'N/A' }}</td>
                    <td>
                        <strong>{{ $event->heading }}</strong><br>
                        <small style="color: #666;">{{ $event->mini_heading }}</small><br>
                        <small style="color: #888;">{{ \Illuminate\Support\Str::limit($event->short_description, 80) }}</small>
                    </td>
                    <td>
                        <span class="creator-badge {{ $event->created_by_type == 'admin' ? 'creator-admin' : 'creator-professional' }}">
                            {{ ucfirst($event->created_by_type) }}
                        </span>
                        @if($event->professional)
                            <br><small><strong>{{ $event->professional->name }}</strong></small>
                            <br><small style="color: #666;">{{ $event->professional->email }}</small>
                        @else
                            <br><small style="color: #666;">Admin Created</small>
                        @endif
                    </td>
                    <td>
                        @if($event->isProfessionalEvent() && $event->professional)
                            @php
                                $professionalService = $event->professional->professionalServices->first();
                            @endphp
                            @if($professionalService)
                                <strong style="color: #667eea;">{{ $professionalService->service_name ?? $professionalService->service->name ?? 'N/A' }}</strong>
                                @if($professionalService->category)
                                    <br><small style="color: #666;">{{ $professionalService->category }}</small>
                                @endif
                            @else
                                <small style="color: #999;">No service</small>
                            @endif
                        @else
                            <small style="color: #999;">-</small>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        <strong>₹{{ number_format($event->starting_fees, 2) }}</strong>
                    </td>
                    <td style="text-align: center;">
                        <span class="status-badge status-{{ $event->status }}">
                            {{ ucfirst($event->status) }}
                        </span>
                        @if($event->approved_at)
                            <br><small style="color: #666;">{{ date('M d, Y', strtotime($event->approved_at)) }}</small>
                        @endif
                    </td>
                    <td>
                        @if($event->meet_link)
                            <small style="word-break: break-all;">{{ \Illuminate\Support\Str::limit($event->meet_link, 50) }}</small>
                        @else
                            <small style="color: #999;">Not Available</small>
                        @endif
                    </td>
                    <td>
                        @if($event->admin_notes)
                            <small>{{ \Illuminate\Support\Str::limit($event->admin_notes, 60) }}</small>
                        @else
                            <small style="color: #999;">-</small>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px; color: #999;">
                        No events found matching the criteria.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>All Events Management System - {{ config('app.name') }}</p>
        <p>This is a computer-generated document. No signature is required.</p>
    </div>
</body>
</html>
