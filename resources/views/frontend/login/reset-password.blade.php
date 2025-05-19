@extends('layouts.layout')
@section('styles')
<style>
    .container {
        max-width: 500px;
        margin: 5rem auto;
        padding: 2.5rem;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    h2 {
        text-align: center;
        color: #2d3748;
        margin-bottom: 2rem;
        font-weight: 600;
        font-size: 1.8rem;
    }

    .form-control {
        height: 48px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 0 15px;
        margin-top: 8px;
        font-size: 15px;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
    }

    .mb-3 {
        margin-bottom: 1.75rem;
    }

    label {
        font-weight: 500;
        color: #4a5568;
        font-size: 15px;
    }

    .btn-success {
        width: 100%;
        padding: 12px;
        background-color: #38a169;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 500;
        color: white;
        transition: background-color 0.3s;
        cursor: pointer;
        margin-top: 0.5rem;
    }

    .btn-success:hover {
        background-color: #2f855a;
    }

    .text-danger {
        color: #e53e3e;
        font-size: 14px;
        margin-top: 6px;
        display: block;
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .container {
            margin: 2rem auto;
            padding: 1.5rem;
        }
        
        h2 {
            font-size: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <h2>Reset Password</h2>

    <form method="POST" action="{{ route('password.reset') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label>New Password</label>
            <input type="password" name="password" class="form-control" required>
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Reset Password</button>
    </form>
</div>
@endsection