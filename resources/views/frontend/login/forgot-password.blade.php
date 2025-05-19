@extends('layouts.layout')
@section('styles')
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