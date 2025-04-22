@extends('admin.layout.layout')

@section('styles')

@endsection

@section('content')
  <a href="{{ route('about.create') }}" class="add-about-btn">+ Add About</a>
@endsection
