@extends('admin.layout.layout')

@section('styles')

@endsection

@section('content')
  <a href="{{ route('testimonial.create') }}" class="add-about-btn">+ Add Testimonial</a>
@endsection
