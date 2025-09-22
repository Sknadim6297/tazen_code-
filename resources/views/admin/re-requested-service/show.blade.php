@extends('admin.layouts.layout')

@section('title', 'View Re-requested Service')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Re-requested Service Details</h5>
                    <a href="{{ route('admin.re-requested-service.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6>Service Information</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Service ID:</strong></td>
                                            <td>#{{ $reRequestedService->id }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Service Name:</strong></td>
                                            <td>{{ $reRequestedService->service_name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Original Booking:</strong></td>
                                            <td>
                                                @if($reRequestedService->originalBooking)
                                                    #{{ $reRequestedService->originalBooking->id }}
                                                @else
                                                    No specific booking
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>{!! $reRequestedService->status_badge !!}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Payment Status:</strong></td>
                                            <td>{!! $reRequestedService->payment_status_badge !!}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6>Pricing Details</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Original Price:</strong></td>
                                            <td>₹{{ number_format($reRequestedService->original_price, 2) }}</td>
                                        </tr>
                                        @if($reRequestedService->admin_modified_price)
                                        <tr>
                                            <td><strong>Admin Modified Price:</strong></td>
                                            <td>₹{{ number_format($reRequestedService->admin_modified_price, 2) }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td><strong>Final Price:</strong></td>
                                            <td>₹{{ number_format($reRequestedService->final_price, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>GST (18%):</strong></td>
                                            <td>₹{{ number_format($reRequestedService->gst_amount, 2) }}</td>
                                        </tr>
                                        <tr class="table-active">
                                            <td><strong>Total Amount:</strong></td>
                                            <td><strong>₹{{ number_format($reRequestedService->total_amount, 2) }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6>Professional Details</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td>{{ $reRequestedService->professional->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>{{ $reRequestedService->professional->email }}</td>
                                        </tr>
                                        @if($reRequestedService->professional->phone)
                                        <tr>
                                            <td><strong>Phone:</strong></td>
                                            <td>{{ $reRequestedService->professional->phone }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6>Customer Details</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td>{{ $reRequestedService->customer->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>{{ $reRequestedService->customer->email }}</td>
                                        </tr>
                                        @if($reRequestedService->customer->phone)
                                        <tr>
                                            <td><strong>Phone:</strong></td>
                                            <td>{{ $reRequestedService->customer->phone }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6>Request Details</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Professional's Reason:</strong>
                                        <p class="mt-2">{{ $reRequestedService->reason }}</p>
                                    </div>
                                    
                                    @if($reRequestedService->admin_notes)
                                    <div class="mb-3">
                                        <strong>Admin Notes:</strong>
                                        <p class="mt-2">{{ $reRequestedService->admin_notes }}</p>
                                    </div>
                                    @endif

                                    @if($reRequestedService->customer_notes)
                                    <div class="mb-3">
                                        <strong>Customer Notes:</strong>
                                        <p class="mt-2">{{ $reRequestedService->customer_notes }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Timeline</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="timeline">
                                        <li class="timeline-item">
                                            <div class="timeline-marker bg-info"></div>
                                            <div class="timeline-content">
                                                <h6>Request Submitted</h6>
                                                <p>{{ $reRequestedService->requested_at->format('d M Y, h:i A') }}</p>
                                            </div>
                                        </li>
                                        
                                        @if($reRequestedService->admin_approved_at)
                                        <li class="timeline-item">
                                            <div class="timeline-marker bg-success"></div>
                                            <div class="timeline-content">
                                                <h6>Admin Approved</h6>
                                                <p>{{ $reRequestedService->admin_approved_at->format('d M Y, h:i A') }}</p>
                                            </div>
                                        </li>
                                        @endif
                                        
                                        @if($reRequestedService->payment_completed_at)
                                        <li class="timeline-item">
                                            <div class="timeline-marker bg-primary"></div>
                                            <div class="timeline-content">
                                                <h6>Payment Completed</h6>
                                                <p>{{ $reRequestedService->payment_completed_at->format('d M Y, h:i A') }}</p>
                                            </div>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    @if($reRequestedService->status === 'pending')
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.re-requested-service.edit', $reRequestedService->id) }}" 
                                   class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Price
                                </a>
                                
                                <button type="button" 
                                        class="btn btn-success approve-btn" 
                                        data-id="{{ $reRequestedService->id }}">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                                
                                <button type="button" 
                                        class="btn btn-danger reject-btn" 
                                        data-id="{{ $reRequestedService->id }}">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                                
                                <button type="button" 
                                        class="btn btn-primary email-btn" 
                                        data-id="{{ $reRequestedService->id }}">
                                    <i class="fas fa-envelope"></i> Send Email
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include modals from index page -->
<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Re-requested Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="approve-form" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="approve_notes" class="form-label">Admin Notes (Optional)</label>
                        <textarea name="admin_notes" id="approve_notes" class="form-control" rows="3" placeholder="Add any notes for the customer and professional"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Approve & Send Notifications</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Re-requested Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="reject-form" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reject_notes" class="form-label">Reason for Rejection <span class="text-danger">*</span></label>
                        <textarea name="admin_notes" id="reject_notes" class="form-control" rows="3" placeholder="Explain why this request is being rejected" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject & Send Notifications</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="email-form" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient" class="form-label">Send To <span class="text-danger">*</span></label>
                        <select name="recipient" id="recipient" class="form-select" required>
                            <option value="">Choose Recipient</option>
                            <option value="customer">Customer Only</option>
                            <option value="professional">Professional Only</option>
                            <option value="both">Both Customer & Professional</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email_subject" class="form-label">Subject <span class="text-danger">*</span></label>
                        <input type="text" name="subject" id="email_subject" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email_message" class="form-label">Message <span class="text-danger">*</span></label>
                        <textarea name="message" id="email_message" class="form-control" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Email</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    list-style: none;
    padding: 0;
    position: relative;
}

.timeline:before {
    content: '';
    position: absolute;
    top: 0;
    left: 25px;
    height: 100%;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
    padding-left: 60px;
}

.timeline-marker {
    position: absolute;
    left: 18px;
    top: 0;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content h6 {
    margin-bottom: 5px;
    font-weight: 600;
}

.timeline-content p {
    margin: 0;
    color: #6c757d;
    font-size: 0.875rem;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin re-requested service show page loaded');

    // Function to show modal with fallback
    function showModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) {
            console.error('Modal not found:', modalId);
            return;
        }

        try {
            // Try Bootstrap 5 first
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                console.log('Using Bootstrap 5 modal for', modalId);
                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
                return;
            }

            // Try jQuery Bootstrap
            if (typeof $ !== 'undefined' && $.fn.modal) {
                console.log('Using jQuery modal for', modalId);
                $('#' + modalId).modal('show');
                return;
            }

            // Fallback: manual modal display
            console.log('Using fallback modal display for', modalId);
            modal.style.display = 'block';
            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');

            // Add backdrop
            let backdrop = document.querySelector('.modal-backdrop');
            if (!backdrop) {
                backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                document.body.appendChild(backdrop);
            }

            // Close modal when clicking backdrop or close button
            backdrop.addEventListener('click', () => hideModal(modalId));
            modal.querySelectorAll('[data-bs-dismiss="modal"], .btn-close').forEach(btn => {
                btn.addEventListener('click', () => hideModal(modalId));
            });

        } catch (error) {
            console.error('Error showing modal:', error);
        }
    }

    // Function to hide modal
    function hideModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        try {
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                const bsModal = bootstrap.Modal.getInstance(modal);
                if (bsModal) bsModal.hide();
                return;
            }

            if (typeof $ !== 'undefined' && $.fn.modal) {
                $('#' + modalId).modal('hide');
                return;
            }

            // Fallback hide
            modal.style.display = 'none';
            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');

            // Remove backdrop
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
        } catch (error) {
            console.error('Error hiding modal:', error);
        }
    }

    // Approve button click
    document.querySelectorAll('.approve-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Approve button clicked');
            const serviceId = this.getAttribute('data-id');
            console.log('Service ID:', serviceId);

            if (!serviceId) {
                console.error('No service ID found');
                return;
            }

            const form = document.getElementById('approve-form');
            if (!form) {
                console.error('Approve form not found');
                return;
            }

            form.action = `{{ url('/admin/re-requested-service') }}/${serviceId}/approve`;
            console.log('Form action set to:', form.action);

            showModal('approveModal');
        });
    });

    // Reject button click
    document.querySelectorAll('.reject-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Reject button clicked');
            const serviceId = this.getAttribute('data-id');

            if (!serviceId) {
                console.error('No service ID found');
                return;
            }

            const form = document.getElementById('reject-form');
            if (!form) {
                console.error('Reject form not found');
                return;
            }

            form.action = `{{ url('/admin/re-requested-service') }}/${serviceId}/reject`;
            console.log('Form action set to:', form.action);

            showModal('rejectModal');
        });
    });

    // Email button click
    document.querySelectorAll('.email-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Email button clicked');
            const serviceId = this.getAttribute('data-id');

            if (!serviceId) {
                console.error('No service ID found');
                return;
            }

            const form = document.getElementById('email-form');
            if (!form) {
                console.error('Email form not found');
                return;
            }

            form.action = `{{ url('/admin/re-requested-service') }}/${serviceId}/send-email`;
            console.log('Form action set to:', form.action);

            showModal('emailModal');
        });
    });

    // Log button counts
    console.log('Found approve buttons:', document.querySelectorAll('.approve-btn').length);
    console.log('Found reject buttons:', document.querySelectorAll('.reject-btn').length);
    console.log('Found email buttons:', document.querySelectorAll('.email-btn').length);

    // Check if forms exist
    console.log('Approve form exists:', !!document.getElementById('approve-form'));
    console.log('Reject form exists:', !!document.getElementById('reject-form'));
    console.log('Email form exists:', !!document.getElementById('email-form'));
});
</script>
@endpush
