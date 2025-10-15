@extends('professional.layout.layout')

@section('styles')
<style>
    .form-container { background:#fff;padding:30px;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,0.1);margin-top:20px; }
    .form-row { display:flex;flex-wrap:wrap;margin-bottom:20px; }
    .form-col { flex:1;padding-right:15px; }
    .form-col:last-child { padding-right:0; }
    .form-group { margin-bottom:20px; }
    .form-group label { display:block;margin-bottom:8px;font-weight:600;color:#333; }
    .form-control { width:100%;padding:12px;border:2px solid #e1e5e9;border-radius:8px;font-size:14px; }
    .form-control:focus { outline:none;border-color:#0d67c7;box-shadow:0 0 0 3px rgba(13,103,199,0.1); }
    .btn-submit { background:linear-gradient(135deg,#0d67c7 0%,#1a73e8 100%);color:#fff;padding:12px 30px;border:none;border-radius:8px;font-weight:600; }
    @media (max-width:768px) { .form-col{flex:100%;padding-right:0;} }
    #imagePreview{display:none;margin-bottom:10px;} #imagePreview img{max-width:240px;border-radius:8px}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="page-title"><h3>Create Event</h3></div>
        <ul class="breadcrumb"><li>Home</li><li><a href="{{ route('professional.events.index') }}">Events</a></li><li class="active">Create Event</li></ul>
    </div>

    <div class="form-container">
        <form id="eventForm" action="{{ route('professional.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="card_image">Event Image *</label>
                        <input type="file" name="card_image" id="card_image" class="form-control" required accept="image/*">
                        <small class="text-muted">Upload an image for your event (JPEG, PNG, JPG, GIF, max 2MB)</small>
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label for="date">Event Date *</label>
                        <input type="date" name="date" id="date" class="form-control" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('date') }}">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="mini_heading">Event Type *</label>
                        <input type="text" name="mini_heading" id="mini_heading" class="form-control" required maxlength="100" placeholder="e.g., Workshop, Seminar, Training" value="{{ old('mini_heading') }}">
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label for="starting_fees">Starting Fees (₹) *</label>
                        <input type="number" name="starting_fees" id="starting_fees" class="form-control" required min="0" step="0.01" placeholder="0.00" value="{{ old('starting_fees') }}">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col" style="flex:100%;">
                    <div class="form-group">
                        <label for="heading">Event Name *</label>
                        <input type="text" name="heading" id="heading" class="form-control" required maxlength="150" placeholder="Enter event name" value="{{ old('heading') }}">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col" style="flex:100%;">
                    <div class="form-group">
                        <label for="short_description">Event Description *</label>
                        <textarea name="short_description" id="short_description" class="form-control" rows="6" required maxlength="1000" placeholder="Describe your event in detail...">{{ old('short_description') }}</textarea>
                        <div class="form-text"><span id="charCount">0</span>/1000 characters</div>
                        @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col" style="flex:100%;text-align:center;">
                    <button type="submit" class="btn-submit">Create Event</button>
                    <a href="{{ route('professional.events.index') }}" style="background-color:#6c757d;color:#fff;padding:12px 30px;border-radius:8px;text-decoration:none;margin-left:15px;display:inline-block;">Cancel</a>
                </div>
            </div>
        </form>

        <div id="imagePreview"><img id="previewImg" src="" alt="Preview"></div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Submit button UX
    document.getElementById('eventForm').addEventListener('submit', function() {
        const submitBtn = document.querySelector('.btn-submit');
        submitBtn.textContent = 'Creating...';
        submitBtn.disabled = true;
    });

    // Character counter
    const textarea = document.getElementById('short_description');
    const charCount = document.getElementById('charCount');
    function updateCharCount() {
        const count = textarea.value.length; charCount.textContent = count;
        if (count > 950) { charCount.className = 'text-danger'; }
        else if (count > 800) { charCount.className = 'text-warning'; }
        else { charCount.className = ''; }
    }
    textarea.addEventListener('input', updateCharCount); updateCharCount();

    // Image preview
    const imageInput = document.getElementById('card_image');
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) { const reader = new FileReader(); reader.onload = function(ev){ previewImg.src = ev.target.result; preview.style.display = 'block'; }; reader.readAsDataURL(file); }
        else { preview.style.display = 'none'; }
    });

    // Simple client-side required validation
    const form = document.getElementById('eventForm');
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]'); let isValid = true;
        requiredFields.forEach(field => { if (!field.value || !String(field.value).trim()) { isValid = false; field.classList.add('is-invalid'); } else { field.classList.remove('is-invalid'); } });
        if (!isValid) { e.preventDefault(); alert('Please fill in all required fields.'); }
    });
});
</script>
@endsection

@ex<div class="content-wrapper">
    <div class="page-header">
        <div class="page-title">
            <h3>Create Event</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li><a href="{{ route('professional.events.index') }}">Events</a></li>
            <li class="active">Create Event</li>
        </ul>
    </div>al.layout.layout')

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
        background: linear-gradient(135deg, #0d67c7 0%, #1a73e8 100%);
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
        box-shadow: 0 5px 15px rgba(13, 103, 199, 0.3);
    }

    @media (max-width: 768px) {
        .form-col {
            flex: 100%;
            padding-right: 0;
        }
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
        <div class="form-container">
            <form id="eventForm" action="{{ route('professional.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="card_image">Event Image *</label>
                            <input type="file" name="card_image" id="card_image" class="form-control" required accept="image/*">
                            <small class="text-muted">Upload an image for your event (JPEG, PNG, JPG, GIF, max 2MB)</small>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="date">Event Date *</label>
                            <input type="date" name="date" id="date" class="form-control" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="mini_heading">Event Type *</label>
                            <input type="text" name="mini_heading" id="mini_heading" class="form-control" required maxlength="100" placeholder="e.g., Workshop, Seminar, Training">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="starting_fees">Starting Fees (₹) *</label>
                            <input type="number" name="starting_fees" id="starting_fees" class="form-control" required min="0" step="0.01" placeholder="0.00">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col" style="flex: 100%;">
                        <div class="form-group">
                            <label for="heading">Event Name *</label>
                            <input type="text" name="heading" id="heading" class="form-control" required maxlength="150" placeholder="Enter event name">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col" style="flex: 100%;">
                        <div class="form-group">
                            <label for="short_description">Event Description *</label>
                            <textarea name="short_description" id="short_description" class="form-control" rows="6" required maxlength="1000" placeholder="Describe your event in detail..."></textarea>
                            <small class="text-muted">Maximum 1000 characters</small>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col" style="flex: 100%; text-align: center;">
                        <button type="submit" class="btn-submit">
                            Create Event
                        </button>
                        <a href="{{ route('professional.events.index') }}" 
                           style="background-color: #6c757d; color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; margin-left: 15px; display: inline-block;">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('eventForm').addEventListener('submit', function(e) {
    const submitBtn = document.querySelector('.btn-submit');
    submitBtn.textContent = 'Creating...';
    submitBtn.disabled = true;
});

// Character counter for description
document.getElementById('short_description').addEventListener('input', function() {
    const maxLength = 1000;
    const currentLength = this.value.length;
    const remaining = maxLength - currentLength;
    
    // Find or create character counter
    let counter = document.getElementById('char-counter');
    if (!counter) {
        counter = document.createElement('small');
        counter.id = 'char-counter';
        counter.className = 'text-muted';
        this.parentNode.appendChild(counter);
    }
    
    counter.textContent = `${currentLength}/${maxLength} characters`;
    
    if (remaining < 50) {
        counter.style.color = '#dc3545';
    } else {
        counter.style.color = '#6c757d';
    }
});
</script>
@endsection 
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