@extends('professional.layout.layout')

@section('styles')
<style>
    :root {
        --primary: #4f46e5;
        --page-bg: #f4f6fb;
        --card-bg: #ffffff;
        --text-dark: #0f172a;
        --text-muted: #64748b;
    }

    body,
    .app-content {
        background: var(--page-bg);
    }

    .purchase-page {
        width: 100%;
        padding: 2.6rem 1.35rem 3.5rem;
    }

    .purchase-shell {
        max-width: 900px;
        margin: 0 auto;
    }

    .purchase-header {
        padding: 2rem 2.4rem;
        border-radius: 28px;
        border: 1px solid rgba(79, 70, 229, 0.18);
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(14, 165, 233, 0.16));
        box-shadow: 0 24px 54px rgba(79, 70, 229, 0.16);
        margin-bottom: 2rem;
    }

    .purchase-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }

    .purchase-card {
        background: var(--card-bg);
        border: 1px solid rgba(148, 163, 184, 0.22);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
    }

    .detail-section {
        margin-bottom: 2rem;
    }

    .detail-table {
        width: 100%;
        border-collapse: collapse;
    }

    .detail-table tr {
        border-bottom: 1px solid rgba(148, 163, 184, 0.15);
    }

    .detail-table tr:last-child {
        border-bottom: none;
    }

    .detail-table td {
        padding: 1rem;
    }

    .detail-table td:first-child {
        font-weight: 600;
        color: var(--text-dark);
        width: 40%;
    }

    .detail-table td:last-child {
        color: var(--text-muted);
    }

    .feature-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .feature-list li {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 0;
        color: var(--text-dark);
    }

    .feature-list i {
        color: #22c55e;
        font-size: 1.1rem;
    }

    .payment-options {
        background: rgba(79, 70, 229, 0.05);
        border: 1px solid rgba(79, 70, 229, 0.15);
        border-radius: 16px;
        padding: 1.5rem;
        margin: 2rem 0;
    }

    .payment-option {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border: 2px solid rgba(148, 163, 184, 0.2);
        border-radius: 12px;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-option:last-child {
        margin-bottom: 0;
    }

    .payment-option:hover {
        border-color: var(--primary);
        background: rgba(79, 70, 229, 0.05);
    }

    .payment-option input[type="radio"]:checked + label {
        color: var(--primary);
        font-weight: 600;
    }

    .info-alert {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #2563eb;
        margin: 2rem 0;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }

    .btn-action.primary {
        background: linear-gradient(135deg, var(--primary), #4338ca);
        color: white;
    }

    .btn-action.secondary {
        background: #e2e8f0;
        color: var(--text-dark);
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    @media (max-width: 768px) {
        .purchase-page {
            padding: 1.5rem 1rem;
        }

        .purchase-header h1 {
            font-size: 1.5rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }
    }

    /* Custom Modal Styles */
    .custom-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 99998;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .custom-modal-overlay.active {
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 1;
    }

    .custom-modal {
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        transform: scale(0.9);
        transition: transform 0.3s ease;
        z-index: 99999;
    }

    .custom-modal-overlay.active .custom-modal {
        transform: scale(1);
    }

    .custom-modal-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.15);
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(14, 165, 233, 0.1));
        border-radius: 16px 16px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .custom-modal-header h5 {
        margin: 0;
        font-weight: 700;
        color: var(--text-dark);
        font-size: 1.25rem;
    }

    .custom-modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: var(--text-muted);
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.2s;
    }

    .custom-modal-close:hover {
        background: rgba(0, 0, 0, 0.05);
        color: var(--text-dark);
    }

    .custom-modal-body {
        padding: 2rem;
    }

    .custom-modal-footer {
        padding: 1rem 2rem;
        border-top: 1px solid rgba(148, 163, 184, 0.15);
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .modal-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    .modal-btn-secondary {
        background: #e2e8f0;
        color: var(--text-dark);
    }

    .modal-btn-secondary:hover {
        background: #cbd5e1;
    }

    .modal-btn-primary {
        background: linear-gradient(135deg, var(--primary), #4338ca);
        color: white;
    }

    .modal-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    .alert-info-custom {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        color: #2563eb;
    }

    .form-group-custom {
        margin-bottom: 1.5rem;
    }

    .form-group-custom label {
        display: block;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .form-group-custom input[type="file"] {
        width: 100%;
        padding: 1rem;
        border: 2px dashed rgba(148, 163, 184, 0.3);
        border-radius: 12px;
        cursor: pointer;
    }

    .form-group-custom small {
        display: block;
        margin-top: 0.5rem;
        color: var(--text-muted);
        font-size: 0.875rem;
    }

    .image-preview-custom {
        display: none;
        margin-top: 1rem;
    }

    .image-preview-custom label {
        display: block;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .image-preview-custom img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        border: 1px solid rgba(148, 163, 184, 0.2);
    }
</style>
@endsection

@section('content')
<div class="content-wrapper purchase-page">
    <div class="purchase-shell">
        <!-- Page Header -->
        <div class="purchase-header">
            <h1><i class="fas fa-shopping-cart"></i> Purchase Confirmation</h1>
        </div>

        <div class="purchase-card">
            <div class="row">
                <!-- Plan Details -->
                <div class="col-md-6 detail-section">
                    <h5 style="font-weight: 700; color: var(--text-dark); margin-bottom: 1rem;">Plan Details</h5>
                    <table class="detail-table">
                        <tr>
                            <td><strong>Plan Name:</strong></td>
                            <td>{{ $plan->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Price:</strong></td>
                            <td><h4 style="color: var(--primary); margin: 0;">{{ $plan->formatted_price }}</h4></td>
                        </tr>
                        <tr>
                            <td><strong>Lead Limit:</strong></td>
                            <td>{{ $plan->lead_limit }} leads</td>
                        </tr>
                        @if($plan->validity_days)
                            <tr>
                                <td><strong>Validity:</strong></td>
                                <td>{{ $plan->validity_days }} days</td>
                            </tr>
                        @endif
                    </table>
                </div>

                <!-- Features -->
                <div class="col-md-6 detail-section">
                    <h5 style="font-weight: 700; color: var(--text-dark); margin-bottom: 1rem;">Features Included:</h5>
                    <ul class="feature-list">
                        @if($plan->features && is_array($plan->features))
                            @foreach($plan->features as $feature)
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>

            <hr style="border-top: 1px solid rgba(148, 163, 184, 0.2); margin: 2rem 0;">

            <!-- Error Messages -->
            @if($errors->any())
                <div class="alert alert-danger" style="border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; background: #fee; border: 1px solid #fcc; color: #c00;">
                    <strong><i class="fas fa-exclamation-circle"></i> Error!</strong>
                    <ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" style="border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; background: #fee; border: 1px solid #fcc; color: #c00;">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <!-- Payment Form -->
            <form action="{{ route('professional.plans.process-purchase', $plan->id) }}" method="POST" enctype="multipart/form-data" id="purchaseForm">
                @csrf
                <div class="payment-options">
                    <h5 style="font-weight: 700; color: var(--text-dark); margin-bottom: 1rem;">Select Payment Method:</h5>
                    
                    <label class="payment-option">
                        <input class="form-check-input" type="radio" name="payment_method" id="razorpay" value="razorpay" checked required>
                        <div>
                            <i class="fas fa-credit-card" style="color: var(--primary); font-size: 1.5rem;"></i>
                        </div>
                        <label class="form-check-label" for="razorpay" style="cursor: pointer; flex: 1; margin: 0;">
                            <strong>Razorpay</strong><br>
                            <small style="color: var(--text-muted);">Pay with Cards, UPI, or Net Banking</small>
                        </label>
                    </label>
                    
                    <label class="payment-option">
                        <input class="form-check-input" type="radio" name="payment_method" id="manual" value="manual" required>
                        <div>
                            <i class="fas fa-money-bill" style="color: #22c55e; font-size: 1.5rem;"></i>
                        </div>
                        <label class="form-check-label" for="manual" style="cursor: pointer; flex: 1; margin: 0;">
                            <strong>Manual Payment</strong><br>
                            <small style="color: var(--text-muted);">Admin approval required</small>
                        </label>
                    </label>
                </div>

                <!-- Hidden file input - will be populated from modal -->
                <input type="file" name="payment_screenshot" id="payment_screenshot_hidden" style="display: none;" accept="image/*">

                <div class="info-alert">
                    <i class="fas fa-info-circle"></i>
                    <span>By clicking "Proceed to Payment", you agree to purchase this plan.</span>
                </div>

                <div class="action-buttons">
                    <button type="button" class="btn-action primary" id="proceedBtn">
                        <i class="fas fa-lock"></i>
                        Proceed to Payment
                    </button>
                    <a href="{{ route('professional.plans.index') }}" class="btn-action secondary">
                        <i class="fas fa-arrow-left"></i>
                        Back to Plans
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Custom Modal for Screenshot Upload -->
<div class="custom-modal-overlay" id="screenshotModal">
    <div class="custom-modal">
        <div class="custom-modal-header">
            <h5>
                <i class="fas fa-file-upload"></i> Upload Payment Screenshot
            </h5>
            <button type="button" class="custom-modal-close" id="closeModal">
                <span>&times;</span>
            </button>
        </div>
        <div class="custom-modal-body">
            <div class="alert-info-custom">
                <i class="fas fa-info-circle"></i> Please upload a screenshot or photo of your payment transaction for verification.
            </div>
            
            <div class="form-group-custom">
                <label for="payment_screenshot">
                    Payment Screenshot <span style="color: #ef4444;">*</span>
                </label>
                <input type="file" id="payment_screenshot" accept="image/*" required>
                <small>Accepted formats: JPG, PNG, JPEG (Max: 5MB)</small>
            </div>

            <div id="imagePreview" class="image-preview-custom">
                <label>Preview:</label>
                <img id="previewImage" src="" alt="Preview">
            </div>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="modal-btn modal-btn-secondary" id="cancelModal">Cancel</button>
            <button type="button" class="modal-btn modal-btn-primary" id="submitWithScreenshot">
                <i class="fas fa-check"></i> Submit
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    const form = $('#purchaseForm');
    const proceedBtn = $('#proceedBtn');
    const manualRadio = $('#manual');
    const razorpayRadio = $('#razorpay');
    const modal = $('#screenshotModal');
    const screenshotInput = $('#payment_screenshot');
    const hiddenScreenshotInput = $('#payment_screenshot_hidden');
    const previewImage = $('#previewImage');
    const imagePreview = $('#imagePreview');
    const closeModalBtn = $('#closeModal');
    const cancelModalBtn = $('#cancelModal');
    const submitBtn = $('#submitWithScreenshot');

    // Open modal function
    function openModal() {
        modal.addClass('active');
        $('body').css('overflow', 'hidden');
    }

    // Close modal function
    function closeModal() {
        modal.removeClass('active');
        $('body').css('overflow', '');
        // Reset modal
        screenshotInput.val('');
        imagePreview.hide();
        previewImage.attr('src', '');
    }

    // Preview image when selected in modal
    screenshotInput.on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.attr('src', e.target.result);
                imagePreview.show();
            };
            reader.readAsDataURL(file);
        }
    });

    // Handle proceed button click
    proceedBtn.on('click', function() {
        if (manualRadio.is(':checked')) {
            console.log('Manual payment selected - opening modal');
            openModal();
        } else {
            console.log('Razorpay payment selected - submitting form');
            form.submit();
        }
    });

    // Close modal events
    closeModalBtn.on('click', closeModal);
    cancelModalBtn.on('click', closeModal);
    
    // Close on overlay click
    modal.on('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    // Close on Escape key
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && modal.hasClass('active')) {
            closeModal();
        }
    });

    // Handle submit with screenshot
    submitBtn.on('click', function() {
        const files = screenshotInput[0].files;
        
        if (files.length === 0) {
            alert('Please upload a payment screenshot');
            return;
        }

        // Validate file size (5MB max)
        const maxSize = 5 * 1024 * 1024; // 5MB in bytes
        if (files[0].size > maxSize) {
            alert('File size must be less than 5MB');
            return;
        }

        // Validate file type
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!validTypes.includes(files[0].type)) {
            alert('Please upload a valid image file (JPG, JPEG, or PNG)');
            return;
        }

        // Close modal
        closeModal();
        
        // Add a loading state to prevent double submission
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');
        proceedBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');
        
        console.log('Preparing to submit manual payment with screenshot');
        
        // Always use FormData for reliable file upload
        const formData = new FormData(form[0]);
        // Replace or add the screenshot file
        formData.set('payment_screenshot', files[0]);
        
        // Log form data for debugging
        console.log('Form data prepared with file:', files[0].name);
        console.log('Payment method:', formData.get('payment_method'));
        console.log('CSRF Token:', formData.get('_token'));
        
        // Submit using AJAX
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('Form submitted successfully', response);
                // Redirect to success page
                if (response.redirect) {
                    window.location.href = response.redirect;
                } else if (response.success) {
                    // For non-AJAX responses, reload or redirect
                    window.location.href = '{{ route("professional.plans.index") }}';
                }
            },
            error: function(xhr) {
                console.error('Form submission error:', xhr);
                submitBtn.prop('disabled', false).html('<i class="fas fa-check"></i> Submit');
                proceedBtn.prop('disabled', false).html('<i class="fas fa-lock"></i> Proceed to Payment');
                
                let errorMessage = 'Error submitting form. Please try again.';
                
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors).flat().join('\n');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 419) {
                    errorMessage = 'Your session has expired. Please refresh the page and try again.';
                }
                
                alert(errorMessage);
            }
        });
    });
});
</script>
@endsection
