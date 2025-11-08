@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Edit FAQ</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.faq.index') }}">FAQs</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit FAQ</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header Close -->

        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            Edit FAQ
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.faq.update', $faq->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row gy-4">
                                
                                <!-- Question -->
                                <div class="col-xl-12">
                                    <label for="question" class="form-label">Question</label>
                                    <input type="text" class="form-control" name="question" id="question" value="{{ old('question', $faq->question) }}" placeholder="Enter FAQ question" required>
                                    @error('question')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Answer -->
                                <div class="col-xl-12">
                                    <label for="answer" class="form-label">Answer</label>
                                    <textarea class="form-control" name="answer" id="answer" rows="5" placeholder="Enter FAQ answer" required>{{ old('answer', $faq->answer) }}</textarea>
                                    @error('answer')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Order -->
                                <div class="col-xl-6">
                                    <label for="order" class="form-label">Display Order</label>
                                    <input type="number" class="form-control" name="order" id="order" value="{{ old('order', $faq->order) }}" placeholder="0">
                                    @error('order')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="col-xl-6">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ old('status', $faq->status) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status">Active</label>
                                    </div>
                                </div>

                            </div>

                            <div class="mt-4">
                                <a href="{{ route('admin.faq.index') }}" class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update FAQ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-1 -->

    </div>
</div>
@endsection

