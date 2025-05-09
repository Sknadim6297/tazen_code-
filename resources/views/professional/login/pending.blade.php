<!DOCTYPE html>
<html>
<head>
    <title>Profile Under Review</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        body {
            background-color: #f4f4f4;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .pending-container {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 450px;
            width: 90%;
        }

        .pending-container h2 {
            color: #333;
            margin-bottom: 10px;
        }

        .pending-container p {
            color: #777;
            font-size: 16px;
        }

        .pending-container .highlight {
            color: #007bff;
            font-weight: bold;
        }

        .pending-container .waiting-text {
            margin-top: 20px;
            color: #ff9900;
            font-size: 14px;
            animation: blink 1.5s infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }
    </style>
</head>
<body>
    <div class="pending-container">
        <h2>Hello, <span class="highlight">{{ $professional->name ?? 'Professional' }}</span></h2>
        <p>Your profile is under review. Please wait for admin approval.</p>
        <div class="waiting-text">⏳ Kindly be patient while we verify your information.</div>
    </div>
</body>
</html>
