<!DOCTYPE html>
<html>
<head>
    <title>Profile Under Review</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #FF4500, #FFA500, #FFD700, #007FFF);
            background-size: 400% 400%;
            animation: gradientShift 10s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .pending-container {
            background: #ffffffdd;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            text-align: center;
            max-width: 450px;
            width: 90%;
        }

        .logo {
            width: 200px;
            margin-bottom: 20px;
        }

        .pending-container h2 {
            color: #333;
            margin-bottom: 10px;
        }

        .pending-container p {
            color: #555;
            font-size: 16px;
        }

        .highlight {
            color: #007FFF;
            font-weight: 600;
        }

        .waiting-text {
            margin-top: 20px;
            color: #FF9900;
            font-size: 14px;
            animation: blink 1.5s infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
</head>
<body>
    <div class="pending-container">
        <img src="{{ asset('frontend/assets/img/tazen_logo-01-removebg-preview.png') }}" alt="Tazen Logo" class="logo">
        <h2>Hello, <span class="highlight">{{ $professional->name ?? 'Professional' }}</span></h2>
        <p>Your profile is under review. Please wait for admin approval.</p>
        <div class="waiting-text">⏳ Kindly be patient while we verify your information.</div>
    </div>
</body>
</html>
