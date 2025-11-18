<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #333333;
        }
        
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            text-align: center;
            padding: 30px 20px;
        }
        
        .logo {
            max-width: 150px;
            height: auto;
            margin-bottom: 10px;
        }
        
        .company-name {
            font-size: 28px;
            font-weight: bold;
            margin: 10px 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .email-body {
            padding: 40px 30px;
            background-color: #ffffff;
        }
        
        .greeting {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .admin-message-intro {
            font-size: 16px;
            color: #34495e;
            margin-bottom: 25px;
            font-weight: 500;
        }
        
        .message-content {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 25px 0;
            border-radius: 5px;
            font-size: 15px;
            line-height: 1.7;
            color: #2c3e50;
        }
        
        .email-footer {
            background-color: #2c3e50;
            color: #ffffff;
            text-align: center;
            padding: 30px 20px;
        }
        
        .regards {
            font-size: 16px;
            margin-bottom: 15px;
            font-weight: 500;
        }
        
        .company-logo {
            max-width: 120px;
            height: auto;
            margin: 15px 0;
        }
        
        .footer-info {
            font-size: 12px;
            color: #95a5a6;
            margin-top: 20px;
            line-height: 1.5;
        }
        
        .divider {
            height: 2px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 30px 0;
            border: none;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 5px;
            }
            
            .email-body {
                padding: 25px 20px;
            }
            
            .email-header {
                padding: 25px 15px;
            }
            
            .company-name {
                font-size: 24px;
            }
            
            .greeting {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <div class="company-name">TAZEN</div>
            <p style="margin: 0; font-size: 14px; opacity: 0.9;">Professional Services Platform</p>
        </div>
        
        <!-- Body -->
        <div class="email-body">
            <!-- Greeting -->
            <div class="greeting">
                Dear {{ $recipientName }},
            </div>
            
            <!-- Admin Message Introduction -->
            <div class="admin-message-intro">
                Admin wants to inform you that:
            </div>
            
            <!-- Divider -->
            <hr class="divider">
            
            <!-- Message Content -->
            <div class="message-content">
                {!! nl2br(e($messageContent)) !!}
            </div>
            
            <!-- Divider -->
            <hr class="divider">
            
            <p style="margin-top: 30px; color: #7f8c8d; font-size: 14px;">
                This is an official communication from the Tazen administration team. 
                If you have any questions or concerns, please don't hesitate to contact our support team.
            </p>
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <div class="regards">
                Regards,<br>
                <strong>Tazen Team</strong>
            </div>
            
            <!-- Company Logo -->
            <div style="margin: 20px 0;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: bold;">
                    T
                </div>
            </div>
            
            <div class="footer-info">
                © {{ date('Y') }} Tazen. All rights reserved.<br>
                Professional Services Platform<br>
                <em>Connecting professionals with clients seamlessly</em>
            </div>
        </div>
    </div>
</body>
</html>