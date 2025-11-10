@extends('admin.layouts.layout')

@section('styles')
<style>
    .form-section {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: #4f46e5;
        color: white;
    }

    .btn-primary:hover {
        background: #4338ca;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .file-upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        background: #f9fafb;
        transition: border-color 0.2s ease;
    }

    .file-upload-area:hover {
        border-color: #4f46e5;
    }

    .current-image {
        max-width: 150px;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e5e7eb;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid mt-4">
        <h2 class="mb-4">Edit Professional Details</h2>

        <!-- Display Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5><i class="fas fa-exclamation-triangle"></i> There were some errors with your submission:</h5>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('admin.manage-professional.update', $professional->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return confirmUpdate()">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-user"></i>
                    Basic Information
                </h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="{{ old('name', $professional->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ old('email', $professional->email) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" 
                               value="{{ old('phone', optional($professional->profile)->phone) }}">
                    </div>

                    <div class="form-group">
                        <label for="specialization" class="form-label">Specialization</label>
                        <input type="text" class="form-control" id="specialization" name="specialization" 
                               value="{{ old('specialization', optional($professional->profile)->specialization) }}">
                    </div>

                    <div class="form-group">
                        <label for="experience" class="form-label">Experience</label>
                        <input type="text" class="form-control" id="experience" name="experience" 
                               placeholder="e.g., 5 years, Beginner, Expert, etc."
                               value="{{ old('experience', optional($professional->profile)->experience) }}">
                    </div>

                    <div class="form-group">
                        <label for="starting_price" class="form-label">Starting Price (₹)</label>
                        <input type="number" class="form-control" id="starting_price" name="starting_price" 
                               value="{{ old('starting_price', optional($professional->profile)->starting_price) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', optional($professional->profile)->address) }}</textarea>
                </div>
            </div>

            <!-- Profile Photo -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-camera"></i>
                    Profile Photo
                </h3>
                
                @if(optional($professional->profile)->photo)
                    <div class="mb-3">
                        <label class="form-label">Current Photo</label><br>
                        <img src="{{ asset('storage/'.optional($professional->profile)->photo) }}" class="current-image" alt="Current Photo">
                    </div>
                @endif

                <div class="form-group">
                    <label for="photo" class="form-label">Upload New Photo (Optional)</label>
                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                    <small class="text-muted">Leave empty to keep current photo</small>
                </div>
            </div>

            <!-- GST Information -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-file-invoice-dollar"></i>
                    GST Information
                </h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="gst_number" class="form-label">GST Number</label>
                        <input type="text" class="form-control @error('gst_number') is-invalid @enderror" id="gst_number" name="gst_number" 
                               value="{{ old('gst_number', optional($professional->profile)->gst_number) }}">
                        @error('gst_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="state_code" class="form-label">State Code</label>
                        <input type="text" class="form-control" id="state_code" name="state_code" 
                               value="{{ old('state_code', optional($professional->profile)->state_code) }}">
                    </div>

                    <div class="form-group">
                        <label for="state_name" class="form-label">State Name</label>
                        <input type="text" class="form-control" id="state_name" name="state_name" 
                               value="{{ old('state_name', optional($professional->profile)->state_name) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="gst_address" class="form-label">GST Address</label>
                    <textarea class="form-control" id="gst_address" name="gst_address" rows="3">{{ old('gst_address', optional($professional->profile)->gst_address) }}</textarea>
                </div>
            </div>

            <!-- Bank Account Details -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-university"></i>
                    Bank Account Details
                </h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="account_holder_name" class="form-label">Account Holder Name</label>
                        <input type="text" class="form-control" id="account_holder_name" name="account_holder_name" 
                               value="{{ old('account_holder_name', optional($professional->profile)->account_holder_name) }}">
                    </div>

                    <div class="form-group">
                        <label for="bank_name" class="form-label">Bank Name</label>
                        <input type="text" class="form-control" id="bank_name" name="bank_name" 
                               value="{{ old('bank_name', optional($professional->profile)->bank_name) }}">
                    </div>

                    <div class="form-group">
                        <label for="account_number" class="form-label">Account Number</label>
                        <input type="text" class="form-control" id="account_number" name="account_number" 
                               value="{{ old('account_number', optional($professional->profile)->account_number) }}">
                    </div>

                    <div class="form-group">
                        <label for="ifsc_code" class="form-label">IFSC Code</label>
                        <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" 
                               value="{{ old('ifsc_code', optional($professional->profile)->ifsc_code) }}">
                    </div>

                    <div class="form-group">
                        <label for="account_type" class="form-label">Account Type</label>
                        <select class="form-control" id="account_type" name="account_type">
                            <option value="">Select Account Type</option>
                            <option value="savings" {{ old('account_type', optional($professional->profile)->account_type) == 'savings' ? 'selected' : '' }}>Savings</option>
                            <option value="current" {{ old('account_type', optional($professional->profile)->account_type) == 'current' ? 'selected' : '' }}>Current</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="bank_branch" class="form-label">Bank Branch</label>
                        <input type="text" class="form-control" id="bank_branch" name="bank_branch" 
                               value="{{ old('bank_branch', optional($professional->profile)->bank_branch) }}">
                    </div>
                </div>
            </div>

            <!-- Document Uploads -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-file-alt"></i>
                    Documents
                </h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="qualification_document" class="form-label">Qualification Certificate</label>
                        @if(optional($professional->profile)->qualification_document)
                            <div class="mb-2">
                                <a href="{{ asset('storage/'.optional($professional->profile)->qualification_document) }}" target="_blank" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-eye"></i> View Current
                                </a>
                            </div>
                        @endif
                        <input type="file" class="form-control" id="qualification_document" name="qualification_document" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Leave empty to keep current document</small>
                    </div>

                    <div class="form-group">
                        <label for="id_proof_document" class="form-label">ID Proof Document</label>
                        @if(optional($professional->profile)->id_proof_document)
                            <div class="mb-2">
                                <a href="{{ asset('storage/'.optional($professional->profile)->id_proof_document) }}" target="_blank" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-eye"></i> View Current
                                </a>
                            </div>
                        @endif
                        <input type="file" class="form-control" id="id_proof_document" name="id_proof_document" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Leave empty to keep current document</small>
                    </div>

                    <div class="form-group">
                        <label for="gst_certificate" class="form-label">GST Certificate</label>
                        @if(optional($professional->profile)->gst_certificate)
                            <div class="mb-2">
                                <a href="{{ asset('storage/'.optional($professional->profile)->gst_certificate) }}" target="_blank" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-eye"></i> View Current
                                </a>
                            </div>
                        @endif
                        <input type="file" class="form-control" id="gst_certificate" name="gst_certificate" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Leave empty to keep current document</small>
                    </div>

                    <div class="form-group">
                        <label for="bank_document" class="form-label">Bank Account Proof</label>
                        @if(optional($professional->profile)->bank_document)
                            <div class="mb-2">
                                <a href="{{ asset('storage/'.optional($professional->profile)->bank_document) }}" target="_blank" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-eye"></i> View Current
                                </a>
                            </div>
                        @endif
                        <input type="file" class="form-control" id="bank_document" name="bank_document" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Leave empty to keep current document</small>
                    </div>
                </div>
            </div>

            <!-- Gallery Images -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-images"></i>
                    Gallery Images
                </h3>
                
                <!-- Current Gallery Images -->
                @if(optional($professional->profile)->gallery_array && count(optional($professional->profile)->gallery_array) > 0)
                    <div class="mb-4">
                        <label class="form-label">Current Gallery Images</label>
                        <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1rem;">
                            @foreach(optional($professional->profile)->gallery_array as $index => $image)
                                <div class="gallery-item" style="position: relative; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
                                    @php
                                        // Handle different image path formats
                                        if (str_starts_with($image, 'gallery/')) {
                                            $imagePath = asset('storage/'.$image);
                                        } elseif (str_starts_with($image, 'uploads/')) {
                                            $imagePath = asset($image);
                                        } elseif (str_starts_with($image, 'storage/')) {
                                            $imagePath = asset($image);
                                        } else {
                                            // Default fallback - try both possibilities
                                            if (file_exists(public_path('uploads/professionals/gallery/'.$image))) {
                                                $imagePath = asset('uploads/professionals/gallery/'.$image);
                                            } elseif (file_exists(public_path('storage/gallery/'.$image))) {
                                                $imagePath = asset('storage/gallery/'.$image);
                                            } else {
                                                $imagePath = asset('uploads/professionals/gallery/'.$image);
                                            }
                                        }
                                    @endphp
                                    <img src="{{ $imagePath }}" 
                                         style="width: 100%; height: 150px; object-fit: cover;" 
                                         alt="Gallery Image {{ $index + 1 }}">
                                    <div style="position: absolute; top: 5px; right: 5px;">
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="removeGalleryImage('{{ $image }}', this)" 
                                                style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div style="padding: 0.5rem; background: #f9fafb; font-size: 0.75rem; color: #6b7280;">
                                        Image {{ $index + 1 }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="mb-4">
                        <div style="text-align: center; padding: 2rem; background: #f9fafb; border-radius: 8px; color: #6b7280;">
                            <i class="fas fa-images" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                            <p style="margin: 0; font-size: 1.1rem;">No gallery images have been uploaded yet.</p>
                        </div>
                    </div>
                @endif

                <!-- Upload New Gallery Images -->
                <div class="form-group">
                    <label for="gallery_images" class="form-label">Upload New Gallery Images</label>
                    <input type="file" class="form-control" id="gallery_images" name="gallery_images[]" 
                           accept="image/*" multiple>
                    <small class="text-muted">
                        You can select multiple images. Supported formats: JPG, JPEG, PNG. Max 5 images at once.
                    </small>
                </div>

                <!-- Hidden field for removed images -->
                <input type="hidden" id="removed_images" name="removed_images" value="">
            </div>

            <!-- Form Actions -->
            <div class="actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Update Professional Details
                </button>
                <a href="{{ route('admin.manage-professional.show', $professional->id) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function confirmUpdate() {
    console.log('Form submission - Removed images:', removedImages);
    console.log('Form data being submitted');
    return confirm("Are you sure you want to edit this professional's details?");
}

// Gallery image removal functionality
let removedImages = [];
console.log('Gallery management script loaded');

function removeGalleryImage(imagePath, button) {
    if (confirm('Are you sure you want to remove this image?')) {
        // Add to removed images list
        removedImages.push(imagePath);
        document.getElementById('removed_images').value = JSON.stringify(removedImages);
        
        // Remove the gallery item from DOM
        button.closest('.gallery-item').remove();
        
        // Show message if no images left
        const galleryGrid = document.querySelector('.gallery-grid');
        if (galleryGrid && galleryGrid.children.length === 0) {
            galleryGrid.parentElement.innerHTML = `
                <div style="text-align: center; padding: 2rem; background: #f9fafb; border-radius: 8px; color: #6b7280;">
                    <i class="fas fa-images" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                    <p style="margin: 0; font-size: 1.1rem;">No gallery images have been uploaded yet.</p>
                </div>
            `;
        }
    }
}

// File upload preview (optional enhancement)
document.getElementById('gallery_images').addEventListener('change', function(e) {
    const files = e.target.files;
    if (files.length > 5) {
        alert('You can upload maximum 5 images at once.');
        e.target.value = '';
        return;
    }
    
    // Optional: Show preview of selected files
    console.log(`Selected ${files.length} images for upload`);
});
</script>
@endsection