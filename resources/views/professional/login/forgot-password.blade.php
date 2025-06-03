<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tazen - Professional Forgot Password</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/account.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/custom.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/password-reset.css') }}">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ff4400b3, #cd952d, #d0be5b, #3776b5);
            background-size: 300% 300%;
            animation: gradientFlow 10s ease infinite;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes gradientFlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .forgot-password-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            margin: 20px;
        }
        .forgot-password-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .forgot-password-header .logo {
            width: 180px;
            height: auto;
            margin-bottom: 20px;
        }
        .forgot-password-header h2 {
            color: #333;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .forgot-password-header p {
            color: #666;
            font-size: 16px;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-control {
            height: 50px;
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 10px 15px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #152a70;
            box-shadow: 0 0 0 0.2rem rgba(21, 42, 112, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
            border: none;
            height: 50px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            width: 100%;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .back-to-login {
            text-align: center;
            margin-top: 20px;
        }
        .back-to-login a {
            color: #152a70;
            text-decoration: none;
            font-weight: 500;
        }
        .back-to-login a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="forgot-password-container">
        <div class="forgot-password-header">
            <img src="{{ asset('customer-css/assets/images/tazen_logo.png') }}" alt="Tazen Logo" class="logo">
            <h2>Forgot Password</h2>
        </div>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('professional.forgot.send') }}">
            @csrf
            <div class="form-group">
                <label for="email">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>

            <div class="back-to-login">
                <a href="{{ route('professional.login') }}">Back to Login</a>
            </div>
        </form>
    </div>
</body>
</html>