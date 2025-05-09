<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Application Rejected</title>
</head>
<body>
    <p>Dear {{ $professional->name }},</p>

    <p>Thank you for applying to our platform. We appreciate your interest, but unfortunately, we are unable to approve your application at this time.</p>

    <p><strong>Reason for Rejection:</strong></p>
    <blockquote>{{ $reason }}</blockquote>

    <p>If you believe this was a mistake or wish to update your information, you may log in and resubmit the necessary details for reconsideration.</p>

    <p>Regards,<br>Admin Team</p>
</body>
</html>
