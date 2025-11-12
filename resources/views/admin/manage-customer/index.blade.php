@extends('admin.layouts.layout')

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" />
<style>
    .export-buttons .dropdown-toggle {
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .export-buttons .dropdown-menu {
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border: 1px solid #e3e6f0;
    }
    .export-buttons .dropdown-item {
        padding: 10px 16px;
        transition: all 0.3s ease;
    }
    .export-buttons .dropdown-item:hover {
        background-color: #f8f9fc;
        transform: translateX(3px);
    }
    .export-buttons .dropdown-item i {
        margin-right: 8px;
        width: 16px;
    }
    
    /* Onboarding status styling */
    .onboarding-status .badge {
        font-size: 0.7rem;
        padding: 4px 8px;
        margin: 1px;
    }
    
    .onboarding-status {
        line-height: 1.2;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">All Customers</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Customer</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Customers</li>
                        </ol>
                    </nav>
                </div>
            </div>
         <form id="customer-filter-form" action="{{ route('admin.manage-customer.index') }}" method="GET" class="d-flex gap-2">
           <div class="col-xl-6">
        <div class="card-body">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-text text-muted"><i class="ri-calendar-line"></i></div>
                    <input type="date" class="form-control"  placeholder="Choose Start Date" name="start_date" id="start_date">
                    <span class="input-group-text">to</span>
                    <input type="date" class="form-control"  placeholder="Choose End Date" name="end_date" id="end_date">
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card custom-card">
            <input type="search" name="search" class="form-control" id="autoComplete" placeholder="Search">
        </div>
    </div>
    <div class="col-xl-2">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>
</div>
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Total Customers
                        </div>
                        <div class="export-buttons">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-download-line"></i> Export
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="exportData('excel')">
                                            <i class="ri-file-excel-line text-success"></i> Export to Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="exportData('pdf')">
                                            <i class="ri-file-pdf-line text-danger"></i> Export to PDF
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Onboarding</th>
                                        <th scope="col">Send Email</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="customer-table-body">
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone ?? 'N/A' }}</td>
                                            <td>
                                                <div class="onboarding-status">
                                                    @if($user->customer_onboarding_completed_at)
                                                        <span class="badge bg-success-transparent text-success mb-1" title="Customer tour completed">
                                                            <i class="ri-check-line"></i> Customer
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning-transparent text-warning mb-1" title="Customer tour not completed">
                                                            <i class="ri-time-line"></i> Customer
                                                        </span>
                                                    @endif
                                                    <br>
                                                    @if($user->professional_onboarding_completed_at)
                                                        <span class="badge bg-success-transparent text-success" title="Professional tour completed">
                                                            <i class="ri-check-line"></i> Professional
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary-transparent text-secondary" title="Professional tour not completed">
                                                            <i class="ri-time-line"></i> Professional
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info send-email-btn" 
                                                    data-email="{{ $user->email }}" 
                                                    data-name="{{ $user->name }}"
                                                    data-type="customer"
                                                    title="Send Email">
                                                    <i class="ri-mail-send-line"></i> Email
                                                </button>
                                            </td>
                                            <td>{{ $user->created_at->format('d M, Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.manage-customer.show', $user->id) }}" class="btn btn-success-light btn-icon btn-sm" data-bs-toggle="tooltip" title="View">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <button type="button" class="btn btn-info-light btn-icon btn-sm ms-1 customer-chat-btn" 
                                                        data-customer-id="{{ $user->id }}" 
                                                        data-customer-name="{{ $user->name }}"
                                                        data-bs-toggle="tooltip" 
                                                        title="Chat with Customer">
                                                    <i class="ri-message-3-line"></i>
                                                </button>
                                                <form method="POST" action="{{ route('admin.manage-customer.destroy', $user->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger-light btn-icon btn-sm ms-1" data-bs-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure?')">
                                                        <i class="ri-delete-bin-5-line"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="emailModalLabel">
                    <i class="ri-mail-send-line me-2"></i>Send Email to Customer
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="emailForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipientName" class="form-label">Recipient Name</label>
                        <input type="text" class="form-control" id="recipientName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="recipientEmail" class="form-label">Recipient Email</label>
                        <input type="email" class="form-control" id="recipientEmail" name="recipient_email" readonly>
                    </div>
                    <input type="hidden" id="recipientType" name="recipient_type">
                    <div class="mb-3">
                        <label for="emailSubject" class="form-label">Subject <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="emailSubject" name="subject" required placeholder="Enter email subject">
                    </div>
                    <div class="mb-3">
                        <label for="emailMessage" class="form-label">Message <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="emailMessage" name="message" rows="8" required placeholder="Enter your message here..."></textarea>
                    </div>
                    <div class="alert alert-info">
                        <i class="ri-information-line me-2"></i>
                        <strong>Note:</strong> This email will be sent from the admin email address configured in your system.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ri-close-line me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="sendEmailBtn">
                        <i class="ri-send-plane-fill me-1"></i>Send Email
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Customer Chat Modal -->
<div class="modal fade" id="customerChatModal" tabindex="-1" aria-labelledby="customerChatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customerChatModalLabel">
                    <i class="ri-message-3-line me-2"></i>Chat with <span id="customerName"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="customerChatMessages" class="chat-messages mb-3" style="height: 400px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 0.5rem; padding: 1rem;">
                    <div class="text-center text-muted">
                        <i class="ri-message-3-line fs-3"></i>
                        <p>Start your conversation with this customer</p>
                    </div>
                </div>
                <form id="customerChatForm" enctype="multipart/form-data">
                    <div class="input-group">
                        <input type="hidden" id="customerChatId" name="chat_id">
                        <input type="text" class="form-control" id="customerChatMessage" name="message" placeholder="Type your message..." required>
                        <input type="file" class="d-none" id="customerChatAttachment" name="attachments[]" multiple accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt,.zip">
                        <button type="button" class="btn btn-outline-secondary" id="customerAttachmentBtn" title="Attach files">
                            <i class="ri-attachment-2"></i>
                        </button>
                        <button type="submit" class="btn btn-primary" id="customerSendBtn">
                            <i class="ri-send-plane-line"></i>
                        </button>
                    </div>
                    <div id="customerSelectedFiles" class="mt-2"></div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    let currentCustomerChatId = null;
    $(document).ready(function() {
        // Handle Send Email button click
        $(document).on('click', '.send-email-btn', function() {
            const email = $(this).data('email');
            const name = $(this).data('name');
            const type = $(this).data('type');
            
            // Populate modal fields
            $('#recipientName').val(name);
            $('#recipientEmail').val(email);
            $('#recipientType').val(type);
            
            // Clear previous form data
            $('#emailSubject').val('');
            $('#emailMessage').val('');
            
            // Show modal
            $('#emailModal').modal('show');
        });

        // Handle Email Form Submission
        $('#emailForm').on('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = $('#sendEmailBtn');
            const originalBtnText = submitBtn.html();
            
            // Get form data
            const formData = {
                recipient_email: $('#recipientEmail').val(),
                recipient_type: $('#recipientType').val(),
                subject: $('#emailSubject').val(),
                message: $('#emailMessage').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };
            
            // Disable button and show loading state
            submitBtn.prop('disabled', true).html('<i class="ri-loader-4-line fa-spin me-1"></i>Sending...');
            
            $.ajax({
                url: '{{ route("admin.send-email") }}',
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message || 'Email sent successfully!');
                        $('#emailModal').modal('hide');
                        $('#emailForm')[0].reset();
                    } else {
                        toastr.error(response.message || 'Failed to send email.');
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Failed to send email. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        errorMsg = Object.values(errors).flat().join(', ');
                    }
                    toastr.error(errorMsg);
                },
                complete: function() {
                    // Restore button state
                    submitBtn.prop('disabled', false).html(originalBtnText);
                }
            });
        });

        // Customer Chat Functionality
        $(document).on('click', '.customer-chat-btn', function() {
            const customerId = $(this).data('customer-id');
            const customerName = $(this).data('customer-name');
            
            // Set customer name in modal
            $('#customerName').text(customerName);
            
            // Initialize or get chat
            $.ajax({
                url: '{{ route("admin.customer-chat.get-or-create") }}',
                method: 'POST',
                data: {
                    customer_id: customerId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        currentCustomerChatId = response.chat.id;
                        $('#customerChatId').val(response.chat.id);
                        loadCustomerChatMessages();
                        $('#customerChatModal').modal('show');
                    } else {
                        toastr.error('Failed to open chat');
                    }
                },
                error: function() {
                    toastr.error('Failed to open chat');
                }
            });
        });

        // Load customer chat messages
        function loadCustomerChatMessages() {
            if (!currentCustomerChatId) return;
            
            $.ajax({
                url: '{{ route("admin.customer-chat.messages", ":chatId") }}'.replace(':chatId', currentCustomerChatId),
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        displayCustomerMessages(response.messages);
                    }
                },
                error: function() {
                    toastr.error('Failed to load messages');
                }
            });
        }

        // Display customer messages
        function displayCustomerMessages(messages) {
            const container = $('#customerChatMessages');
            container.empty();
            
            if (messages.length === 0) {
                container.html(`
                    <div class="text-center text-muted">
                        <i class="ri-message-3-line fs-3"></i>
                        <p>Start your conversation with this customer</p>
                    </div>
                `);
                return;
            }
            
            messages.forEach(function(message) {
                const isAdmin = message.sender_type === 'App\\Models\\Admin';
                const messageClass = isAdmin ? 'text-end' : 'text-start';
                const bubbleClass = isAdmin ? 'bg-primary text-white' : 'bg-light';
                const alignmentClass = isAdmin ? 'ms-auto' : 'me-auto';
                
                let messageHtml = `
                    <div class="mb-3 ${messageClass}">
                        <div class="d-inline-block p-2 rounded ${bubbleClass} ${alignmentClass}" style="max-width: 70%;">
                            <div>${escapeHtml(message.message)}</div>
                `;
                
                // Add attachments if any
                if (message.attachments && message.attachments.length > 0) {
                    messageHtml += '<div class="mt-2">';
                    message.attachments.forEach(function(attachment) {
                        const downloadUrl = '{{ route("admin.customer-chat.attachment.download", ":id") }}'.replace(':id', attachment.id);
                        messageHtml += `
                            <a href="${downloadUrl}" class="text-decoration-none d-block">
                                <i class="${attachment.file_icon}"></i>
                                ${escapeHtml(attachment.filename)}
                                <small class="text-muted">(${attachment.human_file_size})</small>
                            </a>
                        `;
                    });
                    messageHtml += '</div>';
                }
                
                messageHtml += `
                            <div class="mt-1">
                                <small class="text-muted">${formatDateTime(message.created_at)}</small>
                            </div>
                        </div>
                    </div>
                `;
                
                container.append(messageHtml);
            });
            
            // Scroll to bottom
            container.scrollTop(container[0].scrollHeight);
        }

        // Handle customer chat form submission
        $('#customerChatForm').on('submit', function(e) {
            e.preventDefault();
            
            const message = $('#customerChatMessage').val().trim();
            if (!message) return;
            
            const formData = new FormData();
            formData.append('chat_id', $('#customerChatId').val());
            formData.append('message', message);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            
            // Add attachments only if files are selected
            const fileInput = $('#customerChatAttachment')[0];
            if (fileInput && fileInput.files && fileInput.files.length > 0) {
                for (let i = 0; i < fileInput.files.length; i++) {
                    formData.append('attachments[]', fileInput.files[i]);
                }
            }
            
            $.ajax({
                url: '{{ route("admin.customer-chat.send-message") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $('#customerChatMessage').val('');
                        $('#customerChatAttachment').val('');
                        $('#customerSelectedFiles').empty();
                        loadCustomerChatMessages();
                    } else {
                        toastr.error('Failed to send message');
                    }
                },
                error: function() {
                    toastr.error('Failed to send message');
                }
            });
        });

        // Handle customer attachment button
        $('#customerAttachmentBtn').on('click', function() {
            $('#customerChatAttachment').click();
        });

        // Handle customer file selection
        $('#customerChatAttachment').on('change', function() {
            const files = this.files;
            const container = $('#customerSelectedFiles');
            container.empty();
            
            if (files.length > 0) {
                container.append('<div class="small text-muted">Selected files:</div>');
                for (let i = 0; i < files.length; i++) {
                    container.append(`<div class="small"><i class="ri-file-line me-1"></i>${files[i].name}</div>`);
                }
            }
        });

        // Handle Enter key in customer chat input
        $('#customerChatMessage').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#customerChatForm').submit();
            }
        });
    });

    // Export function
    function exportData(format) {
        try {
            // Get current form data (search filters)
            const form = document.getElementById('customer-filter-form');
            const formData = new FormData(form);
            
            // Convert FormData to URL parameters
            const params = new URLSearchParams();
            for (let [key, value] of formData) {
                if (value) {
                    params.append(key, value);
                }
            }
            
            // Construct export URL
            let exportUrl;
            if (format === 'excel') {
                exportUrl = '{{ route("admin.manage-customer.export.excel") }}';
            } else if (format === 'pdf') {
                exportUrl = '{{ route("admin.manage-customer.export.pdf") }}';
            }
            
            // Add parameters if any
            const queryString = params.toString();
            if (queryString) {
                exportUrl += '?' + queryString;
            }
            
            // Show loading message
            toastr.info('Preparing export... Please wait.');
            
            // Create a hidden link and trigger download
            const downloadLink = document.createElement('a');
            downloadLink.href = exportUrl;
            downloadLink.style.display = 'none';
            downloadLink.setAttribute('target', '_blank');
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
            
            // Show success message after a delay
            setTimeout(() => {
                if (format === 'excel') {
                    toastr.success('Excel file download started. If the file doesn\'t open, try right-clicking the downloaded file and selecting "Open with Microsoft Excel".');
                } else {
                    toastr.success('PDF export completed.');
                }
            }, 2000);
            
        } catch (error) {
            console.error('Export error:', error);
            toastr.error('Export failed. Please try again.');
        }
    }

    // Utility functions for chat
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function formatDateTime(dateTimeString) {
        const date = new Date(dateTimeString);
        const now = new Date();
        const diff = now - date;
        const diffDays = Math.floor(diff / (1000 * 60 * 60 * 24));
        
        if (diffDays === 0) {
            return date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        } else if (diffDays === 1) {
            return 'Yesterday ' + date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        } else {
            return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        }
    }

    // Auto-open customer chat from notification
    function checkForAutoOpenChat() {
        const chatData = sessionStorage.getItem('openCustomerChat');
        if (chatData) {
            try {
                const data = JSON.parse(chatData);
                const customerId = data.customerId;
                const chatId = data.chatId;
                const timestamp = data.timestamp;
                
                // Clear the stored data
                sessionStorage.removeItem('openCustomerChat');
                
                // Check if the data is recent (within 30 seconds)
                if (Date.now() - timestamp < 30000) {
                    // Find the customer in the current page
                    const customerChatBtn = document.querySelector(`[data-customer-id="${customerId}"]`);
                    if (customerChatBtn) {
                        // Simulate clicking the chat button
                        setTimeout(() => {
                            customerChatBtn.click();
                        }, 500);
                    } else {
                        // Customer not on current page, might be on another page
                        toastr.info('Looking for customer chat...');
                        // We could add pagination search here if needed
                    }
                }
            } catch (error) {
                console.error('Error parsing chat data:', error);
                sessionStorage.removeItem('openCustomerChat');
            }
        }
    }

    // Check for auto-open chat when page loads
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(checkForAutoOpenChat, 1000);
    });
</script>
@endsection
