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
        .invoice-total {
            float: right;
            width: 300px;
        }
        .invoice-total table {
            width: 100%;
        }
        .invoice-total td {
            padding: 5px;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>INVOICE</h1>
    </div>

    <div class="invoice-details">
        <table>
            <tr>
                <td>
                    <strong>Invoice No:</strong> {{ $invoice_no }}<br>
                    <strong>Date:</strong> {{ $date }}<br>
                </td>
                <td style="text-align: right;">
                    <strong>Professional:</strong> {{ $professional_name }}<br>
                    <strong>Customer:</strong> {{ $customer_name }}<br>
                </td>
            </tr>
        </table>
    </div>

    <table class="invoice-items">
        <thead>
            <tr>
                <th>Description</th>
                <th>Plan Type</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Service Charges</td>
                <td>{{ $plan_type }}</td>
                <td class="text-right">₹{{ number_format($amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="invoice-total">
        <table>
            <tr>
                <td><strong>Total Amount:</strong></td>
                <td class="text-right">₹{{ number_format($amount, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Platform Fee (20%):</strong></td>
                <td class="text-right">₹{{ number_format($platform_fee, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Professional Share (80%):</strong></td>
                <td class="text-right">₹{{ number_format($professional_share, 2) }}</td>
            </tr>
        </table>
    </div>

    <div style="clear: both; margin-top: 50px; text-align: center;">
        <p>Thank you for your business!</p>
    </div>
</body>
</html> 