@extends('admin.layouts.layout')

@section('styles')
    <style>
        /* Styling for Profile Header */
        .profile-header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .profile-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .profile-header a {
            font-size: 16px;
            background-color: #007bff;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
        }
        .profile-header a:hover {
            background-color: #0056b3;
            text-decoration: none;
        }

        /* Profile Image Section */
        .profile-photo {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }
        .profile-photo img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Profile Information Section */
        .profile-info {
            padding-left: 20px;
        }
        .profile-info h4 {
            font-size: 1.5rem;
            color: #343a40;
            margin-bottom: 15px;
        }
        .profile-info p {
            font-size: 1rem;
            margin-bottom: 8px;
            color: #495057;
        }
        .profile-info p strong {
            font-weight: bold;
        }

        /* Responsive design tweaks */
        .profile-details .row {
            margin-top: 20px;
        }
        @media (max-width: 767px) {
            .profile-info h4 {
                font-size: 1.2rem;
            }
            .profile-info p {
                font-size: 0.9rem;
            }
        }

        /* Card Style for Profile Details */
        .card {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            background-color: white;
        }

        .card-header {
            background-color: #f1f1f1;
            border-bottom: 2px solid #e1e1e1;
            font-weight: bold;
            padding: 10px;
        }

        .card-body {
            padding: 15px;
        }
    </style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="profile-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="profile-title">Customer Profile</h3>
            <a href="{{ route('admin.manage-customer.index') }}" class="btn btn-primary">
                <i class="ri-arrow-left-line"></i> Back to Customers
            </a>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            Profile Details
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Profile Photo Section -->
                <div class="col-md-4 col-lg-3">
                    <div class="profile-photo">
                        @if($customer_profile && $customer_profile->profile_image)
                            <img src="{{ asset($customer_profile->profile_image) }}" alt="Profile Photo" class="img-fluid">
                        @else
                            <img src="{{ asset('default-avatar.png') }}" alt="Default Profile" class="img-fluid">
                        @endif
                    </div>
                </div>

                <!-- Profile Info Section -->
                <div class="col-md-8 col-lg-9">
                    <div class="profile-info">
                        <h4>{{ $customer_profile->name ?? 'N/A' }}</h4>
                        <p><strong>Email:</strong> {{ $customer_profile->email ?? 'N/A' }}</p>
                        <p><strong>Phone:</strong> {{ $customer_profile->phone ?? 'N/A' }}</p>
                        <p><strong>Address:</strong> {{ $customer_profile->address ?? 'N/A' }}</p>
                        <p><strong>City:</strong> {{ $customer_profile->city ?? 'N/A' }}</p>
                        <p><strong>State:</strong> {{ $customer_profile->state ?? 'N/A' }}</p>
                        <p><strong>Zip Code:</strong> {{ $customer_profile->zip_code ?? 'N/A' }}</p>
                        <p><strong>Notes:</strong> {{ $customer_profile->notes ?? 'No notes available' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
