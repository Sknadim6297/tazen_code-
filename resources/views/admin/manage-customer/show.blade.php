@extends('admin.layouts.layout')

@section('styles')
@endsection

@section('content')
<div class="content-wrapper" style="padding-left: 260px; padding-right: 30px; padding-top: 20px;">
    <div class="container-fluid" style="max-width: 1200px; margin: auto;">
        <div class="profile-header d-flex justify-content-between align-items-center shadow-sm p-3 mb-4 rounded bg-white">
            <h3 class="profile-title">👤 Customer Profile</h3>
            <a href="{{ route('admin.manage-customer.index') }}" class="btn btn-primary">
                <i class="ri-arrow-left-line"></i> Back to Customers
            </a>
        </div>

        <div class="card border-0 shadow-lg rounded-lg">
            <div class="card-header bg-gradient-primary text-white fw-semibold">
                <i class="ri-user-line me-2"></i> Profile Details
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <!-- Profile Photo Section -->
                    <div class="col-md-4 col-lg-3 mb-4 mb-md-0 text-center">
                        @if($customer_profile && $customer_profile->profile_image)
                            <img src="{{ asset('storage/'.$customer_profile->profile_image) }}" alt="Profile Photo" class="rounded-circle shadow" width="150" height="150">
                        @else
                            <img src="{{ asset('default-avatar.png') }}" alt="Default Profile" class="rounded-circle shadow" width="150" height="150">
                        @endif
                    </div>

                    <!-- Profile Info Section -->
                    <div class="col-md-8 col-lg-9">
                        <div class="profile-info">
                            <h4 class="fw-bold mb-3">{{ $customer_profile->name ?? $user->name ?? 'N/A' }}</h4>
                            <div class="row">
                                <div class="col-sm-6 mb-2">
                                    <strong>Email:</strong> {{ $customer_profile->email ?? $user->email ?? 'N/A' }}
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <strong>Phone:</strong> {{ $customer_profile->phone ?? $user->phone ?? 'N/A' }}
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <strong>Address:</strong> {{ $customer_profile->address ?? 'N/A' }}
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <strong>City:</strong> {{ $customer_profile->city ?? 'N/A' }}
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <strong>State:</strong> {{ $customer_profile->state ?? 'N/A' }}
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <strong>Zip Code:</strong> {{ $customer_profile->zip_code ?? 'N/A' }}
                                </div>
                                <div class="col-12 mt-3">
                                    <strong>Notes:</strong><br> 
                                    <span>{{ $customer_profile->notes ?? 'No notes available' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>
@endsection


@section('scripts')
@endsection
