<!-- filepath: c:\xampp\htdocs\tazen_marge_code\Tazen_multi\resources\views\emails\professional-deactivated.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }
        }
        
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .wrapper {
            background-color: #f8f9fa;
            padding: 30px;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            padding: 20px 0;
        }
        
        .content {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .footer {
            text-align: center;
            color: #6c757d;
            font-size: 12px;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #e9ecef;
        }
        
        .btn {
            display: inline-block;
            background-color: #3498db;
            color: white !important;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            margin-top: 15px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <img src="{{ asset('customer-css/assets/images/tazen_logo.png') }}" alt="Tazen Logo" width="150">
            </div>
            
            <div class="content">
                <h2>Account Deactivation Notice</h2>
                
                <p>Dear {{ $professional->name }},</p>
                
                <p>We regret to inform you that your professional account at Tazen has been <strong>deactivated</strong>.</p>
                
                <p>This could be due to one of the following reasons:</p>
                
                <ul>
                    <li>Violation of our platform's terms of service</li>
                    <li>Extended period of inactivity</li>
                    <li>Administrative review of your account</li>
                    <li>Temporary suspension pending verification</li>
                </ul>
                
                <p>If you believe this has been done in error or would like to have your account reactivated, please contact our support team.</p>
                
                <div style="text-align: center;">
                    <a href="mailto:support@tazen.com" class="btn">Contact Support</a>
                </div>
                
                <p style="margin-top: 25px;">Thank you for your understanding.</p>
                
                <p>Best regards,<br>The Tazen Team</p>
            </div>
            
            <div class="footer">
                <p>&copy; {{ date('Y') }} Tazen. All rights reserved.</p>
                <p>This is an automated message. Please do not reply directly to this email.</p>
            </div>
        </div>
    </div>
</body>
</html>