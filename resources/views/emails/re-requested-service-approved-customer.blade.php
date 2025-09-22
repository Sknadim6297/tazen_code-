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
            <h1>🎉 Service Request Approved!</h1>
        </div>
        
        <div class="content">
            <h2>Hello {{ $reRequestedService->customer->name }},</h2>
            
            <p>Great news! Your professional <strong>{{ $reRequestedService->professional->name }}</strong> has requested an additional service, and our admin has approved it.</p>
            
            <div class="amount-box">
                <h3>Service Details:</h3>
                <p><strong>Service:</strong> {{ $reRequestedService->service_name }}</p>
                <p><strong>Reason:</strong> {{ $reRequestedService->reason }}</p>
                
                @if($reRequestedService->admin_notes)
                <p><strong>Admin Notes:</strong> {{ $reRequestedService->admin_notes }}</p>
                @endif
                
                <hr>
                <h4>Payment Details:</h4>
                <p>Service Amount: ₹{{ number_format($reRequestedService->final_price, 2) }}</p>
                <p>GST (18%): ₹{{ number_format($reRequestedService->gst_amount, 2) }}</p>
                <p><strong>Total Amount: ₹{{ number_format($reRequestedService->total_amount, 2) }}</strong></p>
            </div>
            
            <p>You can now proceed with the payment from your dashboard.</p>
            
            <a href="{{ url('/customer/re-requested-service/' . $reRequestedService->id . '/payment') }}" class="button">
                Pay Now - ₹{{ number_format($reRequestedService->total_amount, 2) }}
            </a>
            
            <p>You can also choose to pay later by visiting your dashboard anytime.</p>
            
            <p>If you have any questions, please feel free to contact us.</p>
        </div>
        
        <div class="footer">
            <p>Thank you for using {{ config('app.name') }}!</p>
            <p>This is an automated email. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
