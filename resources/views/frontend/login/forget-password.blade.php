<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tazen - Professional Login</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/account.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/custom.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #FF4500;
            --secondary-color: #FFA500;
            --white: #ffffff;
            --light-gray: #f9fafb;
            --border-color: #e5e7eb;
            --text-primary: #111827;
            --text-secondary: #6b7280;
        }

        /* Add logo styles */
        .logo-container {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo-container img {
            max-width: 180px;
            height: auto;
            margin-bottom: 15px;
        }

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
        

        .contain {
            width: 100%;
            max-width: 500px;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }

        .card {
            background: transparent;
            border: none;
            box-shadow: none;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--white);
            font-size: 1.25rem;
            font-weight: 600;
            padding: 1.25rem 1.5rem;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }

        .card-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-control {
            height: 45px;
            border-radius: 8px;
            border: 2px solid var(--border-color);
            padding: 0 15px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 69, 0, 0.2);
            outline: none;
        }

        .col-form-label {
            font-weight: 500;
            color: var(--text-primary);
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #064e3b;
            border: 1px solid #a7f3d0;
        }

        .invalid-feedback {
            color: #ef4444;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }

        @media (max-width: 768px) {
            .contain {
                margin: 1rem;
                padding: 1.5rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .text-md-right {
                text-align: left;
            }
        }
    </style>
</head>

<body>
    <div class="contain">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="logo-container">
                        <img src="{{ asset('customer-css/assets/images/tazen_logo.png') }}" alt="Tazen Logo">
                    </div>
                    <div class="card-header">{{ __('Reset Password') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('forgot.send') }}">
                            @csrf

                            <div class="form-group">
                                <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label>
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>