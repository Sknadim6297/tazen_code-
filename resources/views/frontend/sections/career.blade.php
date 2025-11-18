@extends('layouts.layout')
@section('styles')
<style>
    .careers-content-section {
        padding: 80px 0;
        background: #f8f9fa;
    }
    
    .location-tab:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    
    .job-item:hover {
        background-color: #f8f9fa !important;
        padding-left: 10px !important;
    }
    
    .job-listings-box::-webkit-scrollbar {
        width: 8px;
    }
    
    .job-listings-box::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .job-listings-box::-webkit-scrollbar-thumb {
        background: #6c5ce7;
        border-radius: 10px;
    }
    
    .job-listings-box::-webkit-scrollbar-thumb:hover {
        background: #5a4fcf;
    }
    
    @media (max-width: 768px) {
        .careers-content-section {
            padding: 40px 0;
        }
        
        .offices-section h2 {
            font-size: 36px !important;
        }
        
        .location-tabs {
            flex-direction: column;
        }
        
        .location-tab {
            width: 100%;
        }
        
        .job-listings-box {
            max-height: 500px;
            margin-top: 30px;
        }
    }
</style>
@endsection
@section('content')

<main>
    <div class="hero_single career" style="text-align: left; height: 650px; background: url('{{ asset('frontend/assets/img/professionals_photos/Job ,Career and Business.jpg') }}') center center/cover no-repeat #ededed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;">
        <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.4)">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-10">
                        <h1>Find Career for your business near you</h1>
                        <p>Book a Consultation by Appointment, Chat or Video call</p>
                    </div>
                </div>
                <!-- /row -->
            </div>
        </div>
    </div>

    <!-- Our Offices & Job Listings Section -->
    <section class="careers-content-section" style="padding: 80px 0; background: #f8f9fa;">
        <div class="container">
            <div class="row">
                <!-- Left Section - Our Offices -->
                <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                    <div class="offices-section">
                        <p style="color: #6c5ce7; font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">Our offices</p>
                        <h2 style="font-size: 48px; font-weight: 700; color: #2d3436; margin-bottom: 30px; line-height: 1.2;">We're global</h2>
                        
                        <!-- Location Tabs -->
                        <div class="location-tabs" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 30px;">
                            <button class="location-tab active" style="background: #00b894; color: white; border: none; padding: 12px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s;">London, UK (HQ)</button>
                            <button class="location-tab" style="background: #00b894; color: white; border: none; padding: 12px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s;">Europe</button>
                            <button class="location-tab" style="background: #00b894; color: white; border: none; padding: 12px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s;">Middle east</button>
                            <button class="location-tab" style="background: #00b894; color: white; border: none; padding: 12px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s;">United states</button>
                            <button class="location-tab" style="background: #00b894; color: white; border: none; padding: 12px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s;">Asia</button>
                        </div>

                        <!-- Address -->
                        <div class="office-info" style="margin-bottom: 20px;">
                            <p style="color: #636e72; font-size: 16px; margin-bottom: 8px; display: flex; align-items: flex-start;">
                                <i class="fas fa-map-marker-alt" style="color: #6c5ce7; margin-right: 10px; margin-top: 4px;"></i>
                                <span>Mindspace, 9 Appold St EC2A 2AP, London United Kingdom</span>
                            </p>
                        </div>

                        <!-- Email -->
                        <div class="office-info" style="margin-bottom: 40px;">
                            <p style="color: #636e72; font-size: 16px; margin-bottom: 8px; display: flex; align-items: center;">
                                <i class="fas fa-envelope" style="color: #6c5ce7; margin-right: 10px;"></i>
                                <a href="mailto:hello@tazen.in" style="color: #636e72; text-decoration: none;">hello@tazen.in</a>
                            </p>
                        </div>

                        <!-- Social Media -->
                        <div class="social-connect">
                            <h3 style="font-size: 18px; font-weight: 600; color: #2d3436; margin-bottom: 15px;">Connect with us</h3>
                            <div class="social-icons" style="display: flex; gap: 15px;">
                                <a href="#" style="color: #6c5ce7; font-size: 24px; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                                <a href="#" style="color: #6c5ce7; font-size: 24px; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                                    <i class="fab fa-facebook"></i>
                                </a>
                                <a href="#" style="color: #6c5ce7; font-size: 24px; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" style="color: #6c5ce7; font-size: 24px; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Section - Job Listings -->
                <div class="col-lg-7 col-md-6">
                    <div class="job-listings-box" style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); max-height: 600px; overflow-y: auto;">
                        <h3 style="font-size: 24px; font-weight: 700; color: #2d3436; margin-bottom: 25px;">Open Positions</h3>
                        
                        <div class="job-list" style="display: flex; flex-direction: column; gap: 20px;">
                            @forelse($careers as $career)
                                <a href="{{ route('job.details', $career->id) }}" style="text-decoration: none; color: inherit;">
                                    <div class="job-item" style="padding-bottom: 20px; border-bottom: 1px solid #e9ecef; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#f8f9fa'; this.style.paddingLeft='10px';" onmouseout="this.style.backgroundColor='transparent'; this.style.paddingLeft='0';">
                                        <h4 style="font-size: 18px; font-weight: 600; color: #2d3436; margin-bottom: 5px;">{{ $career->title }}</h4>
                                        <p style="font-size: 14px; color: #636e72; margin: 0;">{{ $career->job_type ?? 'Remote job' }}</p>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-4">
                                    <p style="color: #636e72;">No job openings available at the moment.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection