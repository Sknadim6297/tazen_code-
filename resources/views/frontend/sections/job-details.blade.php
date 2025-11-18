@extends('layouts.layout')

@section('styles')
<style>
    .job-details-hero {
        text-align: left;
        height: 400px;
        background: url('{{ asset('frontend/assets/img/professionals_photos/Job ,Career and Business.jpg') }}') center center/cover no-repeat #ededed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
    }
    
    .job-details-content {
        padding: 40px 0 80px;
        background: #ffffff;
    }
    
    .job-overview-section {
        padding: 30px 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    .job-overview-items {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        align-items: center;
    }
    
    .job-overview-item {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #2d3436;
        font-size: 16px;
    }
    
    .job-overview-item i {
        color: #6c5ce7;
        font-size: 18px;
    }
    
    .job-actions-section {
        padding: 40px 0;
        text-align: center;
    }
    
    .job-actions-wrapper {
        max-width: 400px;
        margin: 0 auto;
    }
    
    .apply-btn-primary {
        background: #6c5ce7;
        color: white;
        padding: 14px 40px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: block;
        width: 100%;
        margin-bottom: 15px;
    }
    
    .apply-btn-primary:hover {
        background: #5a4fcf;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 92, 231, 0.3);
    }
    
    .share-job-btn {
        background: white;
        color: #6c5ce7;
        padding: 14px 40px;
        border: 1px solid #6c5ce7;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: block;
        width: 100%;
    }
    
    .share-job-btn:hover {
        background: #6c5ce7;
        color: white;
        border-color: #6c5ce7;
    }
    
    .share-dropdown {
        position: absolute;
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        padding: 10px 0;
        min-width: 200px;
        z-index: 1000;
        display: none;
        margin-top: 5px;
    }
    
    .share-dropdown.show {
        display: block;
    }
    
    .share-dropdown a {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: #2d3436;
        text-decoration: none;
        transition: all 0.2s;
        gap: 12px;
    }
    
    .share-dropdown a:hover {
        background: #f8f9fa;
        color: #6c5ce7;
    }
    
    .share-dropdown a i {
        width: 20px;
        text-align: center;
        font-size: 18px;
    }
    
    .share-dropdown a .fa-facebook { color: #1877f2; }
    .share-dropdown a .fa-twitter { color: #1da1f2; }
    .share-dropdown a .fa-linkedin { color: #0077b5; }
    .share-dropdown a .fa-whatsapp { color: #25d366; }
    .share-dropdown a .fa-envelope { color: #636e72; }
    .share-dropdown a .fa-link { color: #636e72; }
    
    .share-actions-wrapper {
        position: relative;
    }
    
    .job-nav-tabs {
        display: flex;
        gap: 0;
        border-bottom: 2px solid #e9ecef;
        margin-bottom: 40px;
    }
    
    .job-nav-tab {
        padding: 15px 30px;
        background: transparent;
        border: none;
        border-bottom: 3px solid transparent;
        color: #636e72;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }
    
    .job-nav-tab.active {
        color: #2d3436;
        border-bottom-color: #6c5ce7;
    }
    
    .job-nav-tab:hover {
        color: #2d3436;
    }
    
    .job-nav-apply-btn {
        margin-left: auto;
        background: #6c5ce7;
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }
    
    .job-nav-apply-btn:hover {
        background: #5a4fcf;
        color: white;
    }
    
    .job-description-heading {
        font-size: 32px;
        font-weight: 700;
        color: #6c5ce7;
        margin-bottom: 30px;
    }
    
    .job-content-section {
        margin-bottom: 40px;
    }
    
    .job-content-section h4 {
        font-size: 20px;
        font-weight: 700;
        color: #2d3436;
        margin-bottom: 15px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }
    
    .section-icon {
        color: #ef4444;
        font-size: 20px;
        margin-top: 2px;
    }
    
    .job-content-section p {
        color: #2d3436;
        font-size: 16px;
        line-height: 1.8;
        margin-bottom: 20px;
    }
    
    .job-content-html {
        color: #2d3436;
        font-size: 16px;
        line-height: 1.8;
    }
    
    .job-content-html p {
        margin-bottom: 15px;
    }
    
    .job-content-html ul,
    .job-content-html ol {
        margin: 15px 0;
        padding-left: 30px;
    }
    
    .job-content-html li {
        margin-bottom: 8px;
    }
    
    .job-content-html h1,
    .job-content-html h2,
    .job-content-html h3,
    .job-content-html h4,
    .job-content-html h5,
    .job-content-html h6 {
        margin: 20px 0 15px;
        color: #2d3436;
        font-weight: 700;
    }
    
    .job-content-html a {
        color: #6c5ce7;
        text-decoration: none;
    }
    
    .job-content-html a:hover {
        text-decoration: underline;
    }
    
    .job-content-html table {
        width: 100%;
        border-collapse: collapse;
        margin: 15px 0;
    }
    
    .job-content-html table td,
    .job-content-html table th {
        padding: 10px;
        border: 1px solid #e9ecef;
    }
    
    .upload-box {
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .upload-box:hover {
        background: #f0f0f0 !important;
        border-color: #6c5ce7 !important;
    }
    
    .nav-tabs {
        gap: 15px;
    }
    
    .nav-tabs .nav-item {
        margin-right: 15px;
    }
    
    .nav-tabs .nav-item:last-child {
        margin-right: 0;
    }
    
    .nav-tabs .nav-link {
        color: #636e72;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 10px 0;
    }
    
    .nav-tabs .nav-link.active {
        color: #6c5ce7;
        border-bottom-color: #6c5ce7;
        background: transparent;
    }
    
    .nav-tabs .nav-link:hover {
        color: #6c5ce7;
        border-color: transparent;
        border-bottom-color: #6c5ce7;
    }
    
    .modal-header {
        border-bottom: 1px solid #e9ecef;
    }
    
    .modal-title {
        color: #6c5ce7;
        font-weight: 700;
    }
    
    .job-content-section ul {
        list-style: none;
        padding: 0;
        margin: 20px 0;
    }
    
    .job-content-section ul li {
        padding: 10px 0 10px 30px;
        color: #2d3436;
        font-size: 16px;
        line-height: 1.8;
        position: relative;
    }
    
    .job-content-section ul li::before {
        content: "•";
        position: absolute;
        left: 0;
        color: #6c5ce7;
        font-weight: bold;
        font-size: 24px;
        line-height: 1;
    }
    
    @media (max-width: 768px) {
        .job-overview-items {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .job-nav-tabs {
            flex-wrap: wrap;
        }
        
        .job-nav-apply-btn {
            margin-left: 0;
            margin-top: 10px;
            width: 100%;
        }
        
        .job-description-heading {
            font-size: 24px;
        }
        
        .modal-dialog {
            margin: 10px;
        }
    }
</style>
@endsection

@section('content')

<main>
    <!-- Hero Banner -->
    <div class="hero_single job-details-hero">
        <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.4)">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-10">
                        <h1>{{ $career->title }}</h1>
                        <p>Join our team and build your career with us</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Details Content -->
    <section class="job-details-content">
        <div class="container">
            <!-- Job Overview -->
            <div class="job-overview-section">
                <div class="job-overview-items">
                    @if($career->job_type)
                    <div class="job-overview-item">
                        <i class="fas fa-home"></i>
                        <span>{{ $career->job_type }}</span>
                    </div>
                    @endif
                    @if($career->location)
                    <div class="job-overview-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $career->location }}</span>
                    </div>
                    @endif
                    @if($career->department)
                    <div class="job-overview-item">
                        <i class="fas fa-users"></i>
                        <span>{{ $career->department }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Navigation Tabs -->
            <div class="job-nav-tabs">
                <a href="#job-details" class="job-nav-tab active">Job details</a>
                <a href="#apply" class="job-nav-apply-btn">Apply</a>
            </div>

            <!-- Job Description Content -->
            <div class="job-content-wrapper">
                <h2 class="job-description-heading">Job description</h2>

                @if($career->description)
                <!-- Description -->
                <div class="job-content-section">
                    <div class="job-content-html">{!! $career->description !!}</div>
                </div>
                @endif

                @if($career->who_are_we)
                <!-- Who are we? -->
                <div class="job-content-section">
                    <h4>
                        <i class="fas fa-rocket section-icon"></i>
                        <span>Who are we?</span>
                    </h4>
                    <div class="job-content-html">{!! $career->who_are_we !!}</div>
                </div>
                @endif

                @if($career->expectation_of_role)
                <!-- Expectation of the role -->
                <div class="job-content-section">
                    <h4>
                        <i class="fas fa-rocket section-icon"></i>
                        <span>Expectation of the role</span>
                    </h4>
                    <div class="job-content-html">{!! $career->expectation_of_role !!}</div>
                </div>
                @endif

                @if($career->accounts_payable_payroll)
                <!-- Accounts Payable & Payroll -->
                <div class="job-content-section">
                    <h4>
                        <i class="fas fa-rocket section-icon"></i>
                        <span>Accounts Payable & Payroll</span>
                    </h4>
                    <div class="job-content-html">{!! $career->accounts_payable_payroll !!}</div>
                </div>
                @endif

                @if($career->accounts_receivable)
                <!-- Accounts Receivable -->
                <div class="job-content-section">
                    <h4>
                        <i class="fas fa-rocket section-icon"></i>
                        <span>Accounts Receivable</span>
                    </h4>
                    <div class="job-content-html">{!! $career->accounts_receivable !!}</div>
                </div>
                @endif

                @if($career->financial_reporting)
                <!-- Financial Reporting -->
                <div class="job-content-section">
                    <h4>
                        <i class="fas fa-rocket section-icon"></i>
                        <span>Financial Reporting</span>
                    </h4>
                    <div class="job-content-html">{!! $career->financial_reporting !!}</div>
                </div>
                @endif

                @if($career->requirements)
                <!-- Requirements -->
                <div class="job-content-section">
                    <h4>
                        <i class="fas fa-rocket section-icon"></i>
                        <span>Requirements</span>
                    </h4>
                    <div class="job-content-html">{!! $career->requirements !!}</div>
                </div>
                @endif

                @if($career->what_we_offer)
                <!-- What We Offer -->
                <div class="job-content-section">
                    <h4>
                        <i class="fas fa-rocket section-icon"></i>
                        <span>What We Offer</span>
                    </h4>
                    <div class="job-content-html">{!! $career->what_we_offer !!}</div>
                </div>
                @endif
            </div>

            <!-- Job Actions -->
            <div class="job-actions-section">
                <div class="job-actions-wrapper">
                    <button type="button" class="apply-btn-primary" data-bs-toggle="modal" data-bs-target="#jobApplicationModal" style="border: none; width: 100%;">Apply</button>
                    <div class="share-actions-wrapper" style="width: 100%; margin-top: 15px;">
                        <button type="button" class="share-job-btn" id="shareJobBtn" style="border: 1px solid #6c5ce7; width: 100%;">Share job</button>
                        <div class="share-dropdown" id="shareDropdown">
                            <a href="#" class="share-link" data-platform="facebook" target="_blank">
                                <i class="fab fa-facebook"></i>
                                <span>Facebook</span>
                            </a>
                            <a href="#" class="share-link" data-platform="twitter" target="_blank">
                                <i class="fab fa-twitter"></i>
                                <span>Twitter</span>
                            </a>
                            <a href="#" class="share-link" data-platform="linkedin" target="_blank">
                                <i class="fab fa-linkedin"></i>
                                <span>LinkedIn</span>
                            </a>
                            <a href="#" class="share-link" data-platform="whatsapp" target="_blank">
                                <i class="fab fa-whatsapp"></i>
                                <span>WhatsApp</span>
                            </a>
                            <a href="#" class="share-link" data-platform="email" target="_blank">
                                <i class="fas fa-envelope"></i>
                                <span>Email</span>
                            </a>
                            <a href="#" class="share-link" data-platform="copy" id="copyLinkBtn">
                                <i class="fas fa-link"></i>
                                <span>Copy Link</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Job Application Modal -->
<div class="modal fade" id="jobApplicationModal" tabindex="-1" aria-labelledby="jobApplicationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jobApplicationModalLabel">Apply for {{ $career->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="jobApplicationForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="career_id" value="{{ $career->id }}">
                <div class="modal-body">
                    <!-- Navigation Tabs -->
                    <ul class="nav nav-tabs mb-4" id="applicationTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">My information</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="questions-tab" data-bs-toggle="tab" data-bs-target="#questions" type="button" role="tab">Questions</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab">Documents</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="applicationTabContent">
                        <!-- My Information Tab -->
                        <div class="tab-pane fade show active" id="info" role="tabpanel">
                            <h6 class="mb-3" style="color: #6c5ce7; font-size: 20px; font-weight: 700;">My information</h6>
                            <p class="mb-4" style="color: #636e72;">Fill out the information below</p>

                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="full_name" name="full_name" required placeholder="Full name">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="Your email address">
                            </div>

                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone number <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-4">
                                        <select class="form-control" id="phone_country" name="phone_country">
                                            <option value="44" selected>🇬🇧 +44</option>
                                            <option value="91">🇮🇳 +91</option>
                                            <option value="1">🇺🇸 +1</option>
                                            <option value="86">🇨🇳 +86</option>
                                        </select>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="phone_number" name="phone_number" required placeholder="Phone number">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Questions Tab -->
                        <div class="tab-pane fade" id="questions" role="tabpanel">
                            <h6 class="mb-3" style="color: #6c5ce7; font-size: 20px; font-weight: 700;">Questions</h6>
                            <p class="mb-4" style="color: #636e72;">Please fill in additional questions</p>

                            <div class="mb-3">
                                <label for="compensation_expectation" class="form-label" style="color: #6c5ce7;">What is your compensation expectation for this role? (GBP/gross) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="compensation_expectation" name="compensation_expectation" required placeholder="e.g., £30,000 - £40,000">
                            </div>

                            <div class="mb-3">
                                <label for="why_perfect_fit" class="form-label" style="color: #6c5ce7;">What makes you the perfect fit for this role? <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="why_perfect_fit" name="why_perfect_fit" rows="5" required placeholder="Tell us why you're the perfect fit..."></textarea>
                            </div>

                            <p class="text-muted small">All fields marked with * are required.</p>
                        </div>

                        <!-- Documents Tab -->
                        <div class="tab-pane fade" id="documents" role="tabpanel">
                            <h6 class="mb-3" style="color: #6c5ce7; font-size: 20px; font-weight: 700;">Documents</h6>

                            <div class="mb-4">
                                <label for="cv_resume" class="form-label" style="color: #6c5ce7;">CV or resume <span class="text-danger">*</span></label>
                                <p class="small text-muted mb-2">Upload your CV or resume file</p>
                                <div class="upload-box border rounded p-4 text-center" style="border-color: #e9ecef; background: #f8f9fa; cursor: pointer;" onclick="document.getElementById('cv_resume').click();">
                                    <input type="file" class="form-control d-none" id="cv_resume" name="cv_resume" accept=".pdf,.doc,.docx,.jpeg,.jpg,.png" required>
                                    <span style="color: #6c5ce7; text-decoration: underline; cursor: pointer;">Upload a file</span> or drag and drop here
                                    <p class="small text-muted mt-2 mb-0">Accepted files: PDF, DOC, DOCX, JPEG and PNG</p>
                                    <p class="small text-muted">up to 50MB.</p>
                                    <div id="cv_file_name" class="mt-2 text-success"></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="cover_letter_file" class="form-label" style="color: #6c5ce7;">Cover letter</label>
                                <p class="small text-muted mb-2">Upload your cover letter</p>
                                <div class="upload-box border rounded p-4 text-center" style="border-color: #e9ecef; background: #f8f9fa; cursor: pointer;" onclick="document.getElementById('cover_letter_file').click();">
                                    <input type="file" class="form-control d-none" id="cover_letter_file" name="cover_letter_file" accept=".pdf,.doc,.docx,.jpeg,.jpg,.png">
                                    <span style="color: #6c5ce7; text-decoration: underline; cursor: pointer;">Upload a file</span> or drag and drop here
                                    <p class="small text-muted mt-2 mb-0">Accepted files: PDF, DOC, DOCX, JPEG and PNG</p>
                                    <p class="small text-muted">up to 50MB.</p>
                                    <div id="cover_file_name" class="mt-2 text-success"></div>
                                </div>
                                <a href="#" class="text-decoration-none" style="color: #6c5ce7;" id="writeCoverLetterToggle">
                                    <i class="fas fa-edit"></i> Write it here instead
                                </a>
                            </div>

                            <div class="mb-3" id="coverLetterTextArea" style="display: none;">
                                <label for="cover_letter_text" class="form-label" style="color: #6c5ce7;">Cover Letter Text</label>
                                <textarea class="form-control" id="cover_letter_text" name="cover_letter_text" rows="6" placeholder="Write your cover letter here..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div id="formError" class="alert alert-danger" style="display: none;"></div>
                    <div id="formSuccess" class="alert alert-success" style="display: none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #6c5ce7; border-color: #6c5ce7;">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('jobApplicationForm');
    if (!form) return;
    
    const cvInput = document.getElementById('cv_resume');
    const coverInput = document.getElementById('cover_letter_file');
    const coverTextArea = document.getElementById('coverLetterTextArea');
    const writeCoverToggle = document.getElementById('writeCoverLetterToggle');

    if (!cvInput || !coverInput || !coverTextArea || !writeCoverToggle) return;

    // File name display
    cvInput.addEventListener('change', function(e) {
        e.stopPropagation();
        if (e.target.files.length > 0) {
            document.getElementById('cv_file_name').textContent = 'Selected: ' + e.target.files[0].name;
        }
    });

    coverInput.addEventListener('change', function(e) {
        e.stopPropagation();
        if (e.target.files.length > 0) {
            document.getElementById('cover_file_name').textContent = 'Selected: ' + e.target.files[0].name;
        }
    });
    
    // Prevent file input click from triggering parent click
    cvInput.addEventListener('click', function(e) {
        e.stopPropagation();
    });
    
    coverInput.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Toggle cover letter text area
    writeCoverToggle.addEventListener('click', function(e) {
        e.preventDefault();
        coverTextArea.style.display = coverTextArea.style.display === 'none' ? 'block' : 'none';
        if (coverTextArea.style.display === 'block') {
            coverInput.removeAttribute('required');
        }
    });

    // Share job functionality
    const shareJobBtn = document.getElementById('shareJobBtn');
    const shareDropdown = document.getElementById('shareDropdown');
    const shareLinks = document.querySelectorAll('.share-link');
    
    if (shareJobBtn && shareDropdown) {
        const jobUrl = window.location.href;
        const jobTitle = {!! json_encode($career->title) !!};
        @php
            $shareContent = [];
            $shareContent[] = 'Job Title: ' . $career->title;
            
            if ($career->location) {
                $shareContent[] = 'Location: ' . $career->location;
            }
            if ($career->job_type) {
                $shareContent[] = 'Job Type: ' . $career->job_type;
            }
            if ($career->department) {
                $shareContent[] = 'Department: ' . $career->department;
            }
            
            $shareContent[] = '';
            $shareContent[] = 'DESCRIPTION:';
            if ($career->description) {
                $shareContent[] = strip_tags($career->description);
            }
            
            if ($career->who_are_we) {
                $shareContent[] = '';
                $shareContent[] = 'WHO ARE WE:';
                $shareContent[] = strip_tags($career->who_are_we);
            }
            
            if ($career->expectation_of_role) {
                $shareContent[] = '';
                $shareContent[] = 'EXPECTATION OF THE ROLE:';
                $shareContent[] = strip_tags($career->expectation_of_role);
            }
            
            if ($career->accounts_payable_payroll) {
                $shareContent[] = '';
                $shareContent[] = 'ACCOUNTS PAYABLE & PAYROLL:';
                $shareContent[] = strip_tags($career->accounts_payable_payroll);
            }
            
            if ($career->accounts_receivable) {
                $shareContent[] = '';
                $shareContent[] = 'ACCOUNTS RECEIVABLE:';
                $shareContent[] = strip_tags($career->accounts_receivable);
            }
            
            if ($career->financial_reporting) {
                $shareContent[] = '';
                $shareContent[] = 'FINANCIAL REPORTING:';
                $shareContent[] = strip_tags($career->financial_reporting);
            }
            
            if ($career->requirements) {
                $shareContent[] = '';
                $shareContent[] = 'REQUIREMENTS:';
                $shareContent[] = strip_tags($career->requirements);
            }
            
            if ($career->what_we_offer) {
                $shareContent[] = '';
                $shareContent[] = 'WHAT WE OFFER:';
                $shareContent[] = strip_tags($career->what_we_offer);
            }
            
            $shareContent[] = '';
            $shareContent[] = 'View full details and apply: ' . url()->current();
            
            $fullShareText = implode("\n", $shareContent);
            $fullShareText = json_encode($fullShareText);
        @endphp
        const fullShareText = {!! $fullShareText !!};
        const shortShareText = jobTitle + '\n\n' + {!! json_encode(Str::limit(strip_tags($career->description ?? ""), 150)) !!} + '...\n\nView full details: ' + jobUrl;
        
        // Toggle dropdown
        shareJobBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            shareDropdown.classList.toggle('show');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!shareJobBtn.contains(e.target) && !shareDropdown.contains(e.target)) {
                shareDropdown.classList.remove('show');
            }
        });
        
        // Set up share links
        shareLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const platform = this.getAttribute('data-platform');
                let shareUrl = '';
                
                switch(platform) {
                    case 'facebook':
                        shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(jobUrl)}&quote=${encodeURIComponent(shortShareText)}`;
                        break;
                    case 'twitter':
                        const twitterText = jobTitle + '\n\n' + {!! json_encode(Str::limit(strip_tags($career->description ?? ""), 100)) !!} + '...\n\n' + jobUrl;
                        shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(jobUrl)}&text=${encodeURIComponent(twitterText)}`;
                        break;
                    case 'linkedin':
                        shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(jobUrl)}`;
                        break;
                    case 'whatsapp':
                        shareUrl = `https://wa.me/?text=${encodeURIComponent(fullShareText)}`;
                        break;
                    case 'email':
                        shareUrl = `mailto:?subject=${encodeURIComponent('Job Opportunity: ' + jobTitle)}&body=${encodeURIComponent(fullShareText)}`;
                        break;
                    case 'copy':
                        e.preventDefault();
                        navigator.clipboard.writeText(fullShareText).then(function() {
                            const originalText = this.querySelector('span').textContent;
                            this.querySelector('span').textContent = 'Copied!';
                            setTimeout(() => {
                                this.querySelector('span').textContent = originalText;
                            }, 2000);
                        }.bind(this));
                        shareDropdown.classList.remove('show');
                        return;
                }
                
                if (shareUrl) {
                    window.open(shareUrl, '_blank', 'width=600,height=400');
                    shareDropdown.classList.remove('show');
                }
            });
        });
    }

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Disable submit button to prevent double submission
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';
        }
        
        const formData = new FormData(form);
        const errorDiv = document.getElementById('formError');
        const successDiv = document.getElementById('formSuccess');
        
        if (errorDiv) errorDiv.style.display = 'none';
        if (successDiv) successDiv.style.display = 'none';

        fetch('{{ route("job.application.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(async response => {
            const contentType = response.headers.get("content-type");
            if (contentType && contentType.includes("application/json")) {
                const data = await response.json();
                if (!response.ok) {
                    throw data;
                }
                return data;
            } else {
                // If response is not JSON, it's likely an HTML error page
                const text = await response.text();
                throw {
                    success: false,
                    message: 'Server returned an unexpected response. Please try again.',
                    errors: {}
                };
            }
        })
        .then(data => {
            if (data.success) {
                if (successDiv) {
                    successDiv.textContent = data.message;
                    successDiv.style.display = 'block';
                }
                form.reset();
                const cvFileName = document.getElementById('cv_file_name');
                const coverFileName = document.getElementById('cover_file_name');
                if (cvFileName) cvFileName.textContent = '';
                if (coverFileName) coverFileName.textContent = '';
                if (coverTextArea) coverTextArea.style.display = 'none';
                
                // Reset tabs to first tab
                const firstTab = document.getElementById('info-tab');
                const firstTabPane = document.getElementById('info');
                if (firstTab && firstTabPane) {
                    document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
                    document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));
                    firstTab.classList.add('active');
                    firstTabPane.classList.add('show', 'active');
                }
                
                setTimeout(function() {
                    const modalElement = document.getElementById('jobApplicationModal');
                    if (modalElement && typeof bootstrap !== 'undefined') {
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        if (modal) {
                            modal.hide();
                        }
                    }
                    if (successDiv) successDiv.style.display = 'none';
                }, 2000);
            } else {
                throw new Error(data.message || 'An error occurred');
            }
        })
        .catch(error => {
            console.error('Form submission error:', error);
            
            let errorMessage = 'Failed to submit application. Please try again.';
            let errorList = '';
            
            if (error.message) {
                errorMessage = error.message;
            }
            
            if (error.errors && typeof error.errors === 'object') {
                const errorArray = [];
                for (const key in error.errors) {
                    if (error.errors.hasOwnProperty(key)) {
                        errorArray.push(...error.errors[key]);
                    }
                }
                if (errorArray.length > 0) {
                    errorList = '<ul style="margin: 10px 0; padding-left: 20px;">' + 
                                errorArray.map(err => '<li>' + err + '</li>').join('') + 
                                '</ul>';
                }
            }
            
            if (errorDiv) {
                errorDiv.innerHTML = errorMessage + errorList;
                errorDiv.style.display = 'block';
                // Scroll to error
                errorDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } else {
                alert(errorMessage);
            }
        })
        .finally(() => {
            // Re-enable submit button
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Send';
            }
        });
    });
});
</script>
@endsection
