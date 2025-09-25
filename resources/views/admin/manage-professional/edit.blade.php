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
                        <label for="experience" class="form-label">Experience (Years)</label>
                        <input type="number" class="form-control" id="experience" name="experience" 
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
                        <input type="text" class="form-control" id="gst_number" name="gst_number" 
                               value="{{ old('gst_number', optional($professional->profile)->gst_number) }}">
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
    return confirm("Are you sure you want to edit this professional's details?");
}
</script>
@endsection