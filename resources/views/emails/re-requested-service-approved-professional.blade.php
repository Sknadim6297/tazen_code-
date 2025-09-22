<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Re-requested Service Approved</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #28a745; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f8f9fa; }
        .amount-box { background: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .button { display: inline-block; background: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 20px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Service Request Approved!</h1>
        </div>
        
        <div class="content">
            <h2>Hello {{ $reRequestedService->professional->name }},</h2>
            
            <p>Congratulations! Your re-requested service has been approved by our admin team.</p>
            
            <div class="amount-box">
                <h3>Service Details:</h3>
                <p><strong>Customer:</strong> {{ $reRequestedService->customer->name }}</p>
                <p><strong>Service:</strong> {{ $reRequestedService->service_name }}</p>
                <p><strong>Requested Amount:</strong> ₹{{ number_format($reRequestedService->original_price, 2) }}</p>
                
                @if($reRequestedService->admin_modified_price)
                <p><strong>Admin Modified Amount:</strong> ₹{{ number_format($reRequestedService->final_price, 2) }}</p>
                @endif
                
                <p><strong>Total Amount (with GST):</strong> ₹{{ number_format($reRequestedService->total_amount, 2) }}</p>
                
                @if($reRequestedService->admin_notes)
                <p><strong>Admin Notes:</strong> {{ $reRequestedService->admin_notes }}</p>
                @endif
            </div>
            
            <p>The customer has been notified and can now proceed with the payment. Once the payment is completed, you will be notified and can start providing the additional service.</p>
            
            <a href="{{ url('/professional/re-requested-service/' . $reRequestedService->id) }}" class="button">
                View Request Details
            </a>
            
            <p><strong>Next Steps:</strong></p>
            <ul>
                <li>Wait for customer payment confirmation</li>
                <li>Once paid, you can start providing the service</li>
                <li>Track the progress from your dashboard</li>
            </ul>
        </div>
        
        <div class="footer">
            <p>Thank you for using {{ config('app.name') }}!</p>
            <p>This is an automated email. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
