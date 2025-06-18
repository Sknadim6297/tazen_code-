<!-- filepath: c:\xampp\htdocs\tazen_marge_code\Tazen_multi\resources\views\emails\otp-verification.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
        }
        .logo {
            max-height: 50px;
        }
        .content {
            background: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .verification-code {
            text-align: center;
            font-size: 32px;
            letter-spacing: 5px;
            font-weight: bold;
            color: #152a70;
            margin: 20px 0;
            padding: 10px;
            background: #f0f4ff;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #999;
        }
        .note {
            margin-top: 15px;
            padding: 15px;
            background: #fff9e6;
            border-left: 4px solid #ffcc00;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('customer-css/assets/images/tazen_logo.png') }}" alt="Tazen Logo" class="logo">
        </div>
        
        <div class="content">
            <h2>Verify Your Email Address</h2>
            
            <p>Thank you for registering with Tazen. To complete your registration, please enter the verification code below on the registration page:</p>
            
            <div class="verification-code">{{ $otp }}</div>
            
            <p>This code will expire in 10 minutes.</p>
            
            <div class="note">
                <strong>Note:</strong> If you did not request this verification code, please ignore this email.
            </div>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Tazen. All rights reserved.</p>
        </div>
    </div>
</body>
</html>