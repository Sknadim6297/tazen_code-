<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-type" content="professional">
    <meta name="user-id" content="{{ Auth::guard('professional')->id() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tazen- Professional Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('professional/assets/css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
   <style>
.toast-top-center {
    top: 40px !important;
    left: 50% !important;
    transform: translateX(-50%) !important;
    z-index: 9999 !important;
}

/* WhatsApp Floating Button Styles */
.whatsapp-float {
    position: fixed;
    width: 60px;
    height: 60px;
    bottom: 90px; /* Moved up to avoid toTop button */
    right: 25px;
    background-color: #25d366;
    color: #FFF;
    border-radius: 50px;
    text-align: center;
    font-size: 28px;
    box-shadow: 2px 2px 3px #999;
    z-index: 999; /* Lower z-index than toTop button */
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}

.whatsapp-float:hover {
    background-color: #20ba5a;
    transform: scale(1.1);
    color: #FFF;
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
}

.whatsapp-float i {
    margin-top: 0;
}

/* Pulse animation */
.whatsapp-float::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 50%;
    border: 2px solid #25d366;
    animation: pulse 2s infinite;
    opacity: 0.7;
}

@keyframes pulse {
    0% {
        transform: scale(1);
        opacity: 0.7;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.4;
    }
    100% {
        transform: scale(1.2);
        opacity: 0;
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .whatsapp-float {
        width: 50px;
        height: 50px;
        bottom: 80px; /* Adjusted for mobile */
        right: 20px;
        font-size: 24px;
    }
}

/* Tooltip */
.whatsapp-float .tooltip-text {
    visibility: hidden;
    width: 140px;
    background-color: #333;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 8px;
    position: absolute;
    z-index: 1;
    bottom: 70px;
    right: 0;
    font-size: 12px;
    opacity: 0;
    transition: opacity 0.3s;
}

.whatsapp-float .tooltip-text::after {
    content: "";
    position: absolute;
    top: 100%;
    right: 20px;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #333 transparent transparent transparent;
}

.whatsapp-float:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
}
</style>
    @yield('styles')

</head>
<body>
    <div class="app-container">
        @include('professional.sections.sidebar')
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            @include('professional.sections.header')

            <!-- Content Wrapper -->
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/+919147421560?text=Hello%20Tazen!%20I%20need%20assistance%20with%20your%20services." target="_blank" class="whatsapp-float">
        <i class="fab fa-whatsapp"></i>
        <span class="tooltip-text">Chat with us on WhatsApp</span>
    </a>

    <!-- jQuery and Toastr libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Chat System -->
    @include('components.chat-modal')
    <script src="{{ asset('js/chat-system.js') }}"></script>

    @yield('scripts')
    <script>
toastr.options = {
    "positionClass": "toast-top-center",
    "timeOut": "3000",
    "closeButton": true,
    "progressBar": true
};

@if (session('success'))
    toastr.success("{{ session('success') }}");
@endif

@if (session('error'))
    toastr.error("{{ session('error') }}");
@endif

@if (session('warning'))
    toastr.warning("{{ session('warning') }}");
@endif

@if (session('info'))
    toastr.info("{{ session('info') }}");
@endif
</script>
    <script>
        $(document).ready(function() {
            // Toggle sidebar on mobile
            $('.toggle-sidebar').on('click', function() {
                $('.sidebar').toggleClass('active');
            });
    
            // Close sidebar on mobile
            $('.close-sidebar').on('click', function() {
                $('.sidebar').removeClass('active');
            });
    
            // Delete item with SweetAlert confirmation
            $('body').on('click', '.delete-item', function(e) {
                e.preventDefault();
                const deleteUrl = $(this).data('url');
    
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#28a745",
                    cancelButtonColor: "#dc3545",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: deleteUrl,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire('Deleted!', response.message, 'success').then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Oops!', 'Something went wrong.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
    
</body>
</html>
