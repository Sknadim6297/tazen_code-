@extends('professional.layout.layout')
@section('content')
<div class="container">
  <form method="POST" action="{{ route('professional.forgot.send') }}">
    @csrf
    <label>Email:</label>
    <input type="email" name="email" required>
    <button type="submit">Send Password Reset Link</button>
</form>

@endsection

