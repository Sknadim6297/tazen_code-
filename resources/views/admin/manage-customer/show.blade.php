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

        <!-- Onboarding Status Card -->
        <div class="card border-0 shadow-lg rounded-lg mt-4">
            <div class="card-header bg-gradient-info text-white fw-semibold">
                <i class="ri-guide-line me-2"></i> Onboarding Status
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="onboarding-status-item mb-3">
                            <h6 class="fw-bold">Customer Onboarding</h6>
                            @if($user->customer_onboarding_completed_at)
                                <span class="badge bg-success">
                                    <i class="ri-check-line"></i> Completed
                                </span>
                                <small class="text-muted d-block">
                                    Completed: {{ $user->customer_onboarding_completed_at->format('M d, Y H:i') }}
                                </small>
                            @else
                                <span class="badge bg-warning">
                                    <i class="ri-time-line"></i> Not Completed
                                </span>
                                <small class="text-muted d-block">User has not completed the customer tour yet</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="onboarding-status-item mb-3">
                            <h6 class="fw-bold">Professional Onboarding</h6>
                            @if($user->professional_onboarding_completed_at)
                                <span class="badge bg-success">
                                    <i class="ri-check-line"></i> Completed
                                </span>
                                <small class="text-muted d-block">
                                    Completed: {{ $user->professional_onboarding_completed_at->format('M d, Y H:i') }}
                                </small>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="ri-time-line"></i> Not Completed
                                </span>
                                <small class="text-muted d-block">User has not completed the professional tour yet</small>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <form action="{{ route('admin.manage-customer.reset-onboarding', $user->id) }}" method="POST" style="display: inline;" 
                              onsubmit="return confirm('Are you sure you want to reset this user\'s onboarding status? They will see the tours again on next login.')">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-outline-warning btn-sm">
                                <i class="ri-refresh-line"></i> Reset Onboarding Status
                            </button>
                        </form>
                        <small class="text-muted d-block mt-2">
                            Reset onboarding status to make the user see tutorial tours again on next dashboard visit.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>
@endsection


@section('scripts')
@endsection
