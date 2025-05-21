<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-details {
            margin-bottom: 30px;
        }
        .invoice-details table {
            width: 100%;
        }
        .invoice-details td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .invoice-items th, .invoice-items td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .invoice-items th {
            background-color: #f8f9fa;
        }
        .total-row {
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h2>INVOICE</h2>
    </div>

    <div class="invoice-details">
        <table>
            <tr>
                <td width="50%">
                    <strong>From:</strong><br>
                    Tazen<br>
                    support@tazen.com<br>
                </td>
                <td width="50%" style="text-align: right;">
                    <strong>Invoice #:</strong> {{ $invoice_no }}<br>
                    <strong>Date:</strong> {{ $invoice_date }}<br>
                </td>
            </tr>
            <tr>
                <td colspan="2" height="20"></td>
            </tr>
            <tr>
                <td>
                    <strong>Billed To:</strong><br>
                    {{ $booking->customer_name }}<br>
                    {{ $booking->customer_email }}<br>
                    {{ $booking->customer_phone }}
                </td>
                <td style="text-align: right;">
                    <strong>Professional:</strong><br>
                    {{ $booking->professional->name ?? 'N/A' }}<br>
                </td>
            </tr>
        </table>
    </div>

    <table class="invoice-items">
        <thead>
            <tr>
                <th>Service</th>
                <th>Plan Type</th>
                <th>Sessions</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $booking->service_name }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $booking->plan_type)) }}</td>
                <td>{{ count(json_decode($booking->days, true)) }}</td>
                <td>₹{{ number_format($booking->amount, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="3" style="text-align: right;"><strong>Total Amount:</strong></td>
                <td>₹{{ number_format($booking->amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Thank you for choosing Tazen. For any queries, please contact support@tazen.com
    </div>
</body>
</html> 