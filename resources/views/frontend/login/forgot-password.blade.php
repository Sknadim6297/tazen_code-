@extends('layouts.layout')
@section('styles')
<style>
    .container {
        max-width: 500px;
        margin: 5rem auto;
        padding: 2rem;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }

    .form-control {
        height: 45px;
        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 0 15px;
        margin-top: 5px;
    }

    .form-control:focus {
        border-color: #3490dc;
        box-shadow: 0 0 0 0.2rem rgba(52, 144, 220, 0.25);
    }

    .mb-3 {
        margin-bottom: 1.5rem;
    }

    label {
        font-weight: 500;
        color: #4a5568;
    }

    .btn-primary {
        width: 100%;
        padding: 10px;
        background-color: #3490dc;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: 500;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #2779bd;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .text-danger {
        color: #e3342f;
        font-size: 14px;
        margin-top: 5px;
        display: block;
    }
</style>
@endsection

@section('content')
<div class="container">
    <h2>Forgot Password</h2>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('forgot.send') }}">
        @csrf
        <div class="mb-3">
            <label>Email address</label>
            <input type="email" name="email" class="form-control" required>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Send Reset Link</button>
    </form>
</div>
@endsection