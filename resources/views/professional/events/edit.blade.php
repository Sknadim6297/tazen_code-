@extends('professional.layout.layout')

@section('styles')
<style>
    .form-container {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-top: 20px;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .form-col {
        flex: 1;
        padding-right: 15px;
    }

    .form-col:last-child {
        padding-right: 0;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 2px solid #e1e5e9;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #0d67c7;
        box-shadow: 0 0 0 3px rgba(13, 103, 199, 0.1);
    }

    .btn-submit {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
        display: inline-block;
        margin-bottom: 20px;
    }

    .status-pending { background: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
    .status-approved { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .status-rejected { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

    @media (max-width: 768px) {
        .form-col {
            flex: 100%;
            padding-right: 0;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="page-title">
            <h3>Edit Event</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li><a href="{{ route('professional.events.index') }}">Events</a></li>
            <li class="active">Edit Event</li>
        </ul>
    </div>

    <div class="form-container">
        <!-- Event Status -->
        <div class="status-badge status-{{ $event->status }}">
            Status: {{ ucfirst($event->status) }}
            @if($event->status === 'rejected' && $event->admin_notes)
                <br><small>Note: {{ $event->admin_notes }}</small>
            @endif
        </div>

        @if($event->status === 'approved')
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <strong>Note:</strong> This event has been approved and cannot be edited. Contact admin if changes are needed.
            </div>
        @else
            <form id="eventForm" action="{{ route('professional.events.update', $event) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="card_image">Event Image</label>
                            <input type="file" name="card_image" id="card_image" class="form-control" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image. Upload new image (JPEG, PNG, JPG, GIF, max 2MB)</small>
                            @if($event->card_image)
                                <div style="margin-top: 10px;">
                                    <img src="{{ asset('storage/' . $event->card_image) }}" alt="Current Image" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="date">Event Date *</label>
                            <input type="date" name="date" id="date" class="form-control" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ $event->date }}">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="mini_heading">Event Type *</label>
                            <input type="text" name="mini_heading" id="mini_heading" class="form-control" required maxlength="100" placeholder="e.g., Workshop, Seminar, Training" value="{{ $event->mini_heading }}">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="starting_fees">Starting Fees (₹) *</label>
                            <input type="number" name="starting_fees" id="starting_fees" class="form-control" required min="0" step="0.01" placeholder="0.00" value="{{ $event->starting_fees }}">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col" style="flex: 100%;">
                        <div class="form-group">
                            <label for="heading">Event Name *</label>
                            <input type="text" name="heading" id="heading" class="form-control" required maxlength="150" placeholder="Enter event name" value="{{ $event->heading }}">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col" style="flex: 100%;">
                        <div class="form-group">
                            <label for="short_description">Event Description *</label>
                            <textarea name="short_description" id="short_description" class="form-control" rows="6" required maxlength="1000" placeholder="Describe your event in detail...">{{ $event->short_description }}</textarea>
                            <small class="text-muted">Maximum 1000 characters</small>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col" style="flex: 100%; text-align: center;">
                        <button type="submit" class="btn-submit">
                            Update Event
                        </button>
                        <a href="{{ route('professional.events.index') }}" 
                           style="background-color: #6c757d; color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; margin-left: 15px; display: inline-block;">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>

<script>
document.getElementById('eventForm')?.addEventListener('submit', function(e) {
    const submitBtn = document.querySelector('.btn-submit');
    submitBtn.textContent = 'Updating...';
    submitBtn.disabled = true;
});

// Character counter for description
document.getElementById('short_description')?.addEventListener('input', function() {
    const maxLength = 1000;
    const currentLength = this.value.length;
    
    let counter = document.getElementById('char-counter');
    if (!counter) {
        counter = document.createElement('small');
        counter.id = 'char-counter';
        counter.className = 'text-muted';
        this.parentNode.appendChild(counter);
    }
    
    counter.textContent = `${currentLength}/${maxLength} characters`;
    
    if (maxLength - currentLength < 50) {
        counter.style.color = '#dc3545';
    } else {
        counter.style.color = '#6c757d';
    }
});
</script>
@endsection
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Edit Event</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('professional.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('professional.events.index') }}">Events</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('professional.events.show', $event->id) }}">{{ $event->heading }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Edit Event Form -->
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="ri-edit-line me-2"></i>Edit Event Details
                        </div>
                        <div>
                            @if($event->status === 'approved')
                                <span class="badge bg-success-transparent">
                                    <i class="ri-check-line me-1"></i>Approved
                                </span>
                            @elseif($event->status === 'pending')
                                <span class="badge bg-warning-transparent">
                                    <i class="ri-time-line me-1"></i>Pending
                                </span>
                            @elseif($event->status === 'rejected')
                                <span class="badge bg-danger-transparent">
                                    <i class="ri-close-line me-1"></i>Rejected
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Status Information -->
                        @if($event->status === 'approved')
                            <div class="alert alert-warning" role="alert">
                                <h6 class="alert-heading"><i class="ri-alert-line me-2"></i>Important Notice</h6>
                                <p class="mb-0">This event has been approved. Editing will change its status back to pending and require re-approval.</p>
                            </div>
                        @elseif($event->status === 'rejected')
                            <div class="alert alert-info" role="alert">
                                <h6 class="alert-heading"><i class="ri-information-line me-2"></i>Revision Opportunity</h6>
                                <p class="mb-2">Your event was rejected. Please review the admin notes and make necessary changes:</p>
                                @if($event->admin_notes)
                                    <div class="bg-light rounded p-2 mt-2">
                                        <small><strong>Admin Notes:</strong> {{ $event->admin_notes }}</small>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="alert alert-info" role="alert">
                                <h6 class="alert-heading"><i class="ri-information-line me-2"></i>Edit Information</h6>
                                <ul class="mb-0">
                                    <li>You can edit your event while it's pending approval</li>
                                    <li>Changes will be saved and reviewed by the admin</li>
                                    <li>Event date must be today or in the future</li>
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('professional.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row gy-4">
                                <!-- Current Event Image -->
                                <div class="col-xl-12">
                                    <label class="form-label">Current Event Image</label>
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $event->card_image) }}" 
                                             alt="Current Event Image" 
                                             class="img-thumbnail" 
                                             style="max-width: 200px;">
                                    </div>
                                </div>

                                <!-- Event Image -->
                                <div class="col-xl-12">
                                    <label for="card_image" class="form-label">Update Event Image</label>
                                    <input type="file" class="form-control @error('card_image') is-invalid @enderror" 
                                           id="card_image" name="card_image" accept="image/*">
                                    <div class="form-text">Leave empty to keep current image. Upload a high-quality image (JPEG, PNG, JPG, GIF). Max size: 2MB</div>
                                    @error('card_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="mt-3" style="display: none;">
                                        <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                </div>

                                <!-- Event Date -->
                                <div class="col-xl-6">
                                    <label for="date" class="form-label">Event Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                           id="date" name="date" min="{{ date('Y-m-d') }}" 
                                           value="{{ old('date', $event->date) }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Starting Fees -->
                                <div class="col-xl-6">
                                    <label for="starting_fees" class="form-label">Starting Fees (₹) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('starting_fees') is-invalid @enderror" 
                                           id="starting_fees" name="starting_fees" placeholder="Enter Starting Fees" 
                                           min="0" step="0.01" value="{{ old('starting_fees', $event->starting_fees) }}" required>
                                    @error('starting_fees')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Event Type -->
                                <div class="col-xl-12">
                                    <label for="mini_heading" class="form-label">Event Type <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('mini_heading') is-invalid @enderror" 
                                           id="mini_heading" name="mini_heading" placeholder="e.g., Workshop, Seminar, Consultation" 
                                           maxlength="100" value="{{ old('mini_heading', $event->mini_heading) }}" required>
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
                                           maxlength="150" value="{{ old('heading', $event->heading) }}" required>
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
                                              maxlength="1000" required>{{ old('short_description', $event->short_description) }}</textarea>
                                    <div class="form-text">
                                        <span id="charCount">{{ strlen($event->short_description) }}</span>/1000 characters
                                    </div>
                                    @error('short_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="mt-4 d-flex justify-content-between">
                                <a href="{{ route('professional.events.show', $event->id) }}" class="btn btn-light">
                                    <i class="ri-arrow-left-line me-1"></i>Back to Event
                                </a>
                                <div>
                                    <a href="{{ route('professional.events.index') }}" class="btn btn-outline-secondary me-2">
                                        <i class="ri-close-line me-1"></i>Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-save-line me-1"></i>
                                        @if($event->status === 'rejected')
                                            Resubmit for Approval
                                        @else
                                            Update Event
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

    // Confirmation for approved events
    @if($event->status === 'approved')
    form.addEventListener('submit', function(e) {
        if (!confirm('This event is already approved. Editing will change its status back to pending and require re-approval. Are you sure you want to continue?')) {
            e.preventDefault();
        }
    });
    @endif
});
</script>
@endsection