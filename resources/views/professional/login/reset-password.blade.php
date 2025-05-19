@extends('professional.layout.layout')
@section('content')
<div class="container">
    <h2>Reset Password</h2>

   <form method="POST" action="{{ route('professional.password.reset') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="email" name="email" value="{{ old('email', $email) }}" required>
    <input type="password" name="password" required>
    <input type="password" name="password_confirmation" required>
    <button type="submit">Reset Password</button>
</form>

@endsection