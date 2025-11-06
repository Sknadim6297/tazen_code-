@extends('professional.layout.layout')

@section('styles')
<style>
    .custom-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .custom-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 35px rgba(0, 0, 0, 0.12);
    }
    
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 12px 16px;
        transition: all 0.3s ease;
        font-size: 14px;
    }
    
    .form-control:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        outline: none;
    }
    
    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        font-size: 14px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(76, 175, 80, 0.3);
    }
    
    .page-title {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 0;
    }
    
    .breadcrumb-item a {
        color: #4CAF50;
        text-decoration: none;
    }
    
    .breadcrumb-item.active {
        color: #6c757d;
    }
    
    .alert {
        border: none;
        border-radius: 12px;
        padding: 16px 20px;
    }
    
    .form-text {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
    }
    
    #imagePreview {
        display: none;
        margin-top: 15px;
    }
    
    #imagePreview img {
        max-width: 200px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Create New Event</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('professional.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('professional.events.index') }}">Events</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Create Event Form -->
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="ri-add-line me-2"></i>Create New Event
                        </div>
                        <div>
                            <span class="badge bg-info-transparent">
                                <i class="ri-draft-line me-1"></i>Draft
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Information Alert -->
                        <div class="alert alert-info" role="alert">
                            <h6 class="alert-heading"><i class="ri-information-line me-2"></i>Event Creation Guidelines</h6>
                            <ul class="mb-0">
                                <li>Your event will be reviewed by admin before going live</li>
                                <li>Ensure all information is accurate and complete</li>
                                <li>Event date must be today or in the future</li>
                                <li>Upload a high-quality event image for better visibility</li>
                            </ul>
                        </div>
                        <form action="{{ route('professional.events.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row gy-4">
                                <!-- Event Image -->
                                <div class="col-xl-12">
                                    <label for="card_image" class="form-label">Event Image <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('card_image') is-invalid @enderror" 
                                           id="card_image" name="card_image" accept="image/*" required>
                                    <div class="form-text">Upload a high-quality image (JPEG, PNG, JPG, GIF). Max size: 2MB</div>
                                    @error('card_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="mt-3">
                                        <img id="previewImg" src="" alt="Preview" class="img-thumbnail">
                                    </div>
                                </div>

                                <!-- Event Date -->
                                <div class="col-xl-6">
                                    <label for="date" class="form-label">Event Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                           id="date" name="date" min="{{ date('Y-m-d') }}" 
                                           value="{{ old('date') }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Starting Fees -->
                                <div class="col-xl-6">
                                    <label for="starting_fees" class="form-label">Event Fees (₹) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('starting_fees') is-invalid @enderror" 
                                           id="starting_fees" name="starting_fees" placeholder="Enter event Fees" 
                                           min="0" step="0.01" value="{{ old('starting_fees') }}" required>
                                    @error('starting_fees')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Event Type -->
                                <div class="col-xl-12">
                                    <label for="mini_heading" class="form-label">Event Type <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('mini_heading') is-invalid @enderror" 
                                           id="mini_heading" name="mini_heading" placeholder="e.g., Workshop, Seminar, Consultation" 
                                           maxlength="100" value="{{ old('mini_heading') }}" required>
                                    <div class="form-text">Brief category or type of event (max 100 characters)</div>
                                    @error('mini_heading')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Event Name -->
                                <div class="col-xl-12">
                                    <label for="heading" class="form-label">Event Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('heading') is-invalid @enderror" 
                                           id="heading" name="heading" placeholder="Enter Main Event Title" 
                                           maxlength="150" value="{{ old('heading') }}" required>
                                    <div class="form-text">Main title of your event (max 150 characters)</div>
                                    @error('heading')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Short Description -->
                                <div class="col-xl-12">
                                    <label for="short_description" class="form-label">Event Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                              id="short_description" name="short_description" rows="6" 
                                              placeholder="Provide a detailed description of your event, including what participants will learn, duration, agenda, etc." 
                                              maxlength="1000" required>{{ old('short_description') }}</textarea>
                                    <div class="form-text">
                                        <span id="charCount">0</span>/1000 characters
                                    </div>
                                    @error('short_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="mt-4 d-flex justify-content-between">
                                <a href="{{ route('professional.events.index') }}" class="btn btn-light">
                                    <i class="ri-arrow-left-line me-1"></i>Back to Events
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-send-plane-line me-1"></i>Submit for Approval
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview functionality
    const imageInput = document.getElementById('card_image');
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });

    // Character count for description
    const textarea = document.getElementById('short_description');
    const charCount = document.getElementById('charCount');

    function updateCharCount() {
        const count = textarea.value.length;
        charCount.textContent = count;
        
        if (count > 800) {
            charCount.className = 'text-warning';
        } else if (count > 950) {
            charCount.className = 'text-danger';
        } else {
            charCount.className = '';
        }
    }

    textarea.addEventListener('input', updateCharCount);
    updateCharCount(); // Initial count

    // Form validation enhancement
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });
});
</script>
@endsection