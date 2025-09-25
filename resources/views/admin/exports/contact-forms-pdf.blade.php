<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contact Form Submissions Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .date {
            font-size: 12px;
            color: #666;
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
            vertical-align: top;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .message-text {
            max-width: 300px;
            word-wrap: break-word;
        }
        .contact-info {
            max-width: 150px;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Contact Form Submissions Report</div>
        <div class="date">Generated on: {{ date('d M Y H:i') }}</div>
        <div class="date">Total Submissions: {{ count($submissions) }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">Sl.No</th>
                <th width="15%">Name</th>
                <th width="20%">Email</th>
                <th width="12%">Phone</th>
                <th width="30%">Message</th>
                <th width="10%">Verification</th>
                <th width="8%">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($submissions as $index => $submission)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="contact-info">{{ $submission->name }}</td>
                <td class="contact-info">{{ $submission->email }}</td>
                <td>{{ $submission->phone ?? 'N/A' }}</td>
                <td class="message-text">{{ Str::limit($submission->message, 200) }}</td>
                <td>{{ $submission->verification_answer ?? 'N/A' }}</td>
                <td>{{ $submission->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if(count($submissions) == 0)
        <div style="text-align: center; margin-top: 50px; color: #666;">
            No contact form submissions found for the selected criteria.
        </div>
    @endif
</body>
</html>
