<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-type" content="admin">
    <meta name="user-id" content="{{ Auth::guard('admin')->id() }}">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Codeigniter Bootstrap Responsive Admin Web Dashboard Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="admin panel template, bootstrap, bootstrap admin template, bootstrap codeigniter, bootstrap dashboard, bootstrap framework, bootstrap template, codeigniter, codeigniter admin, codeigniter dashboard, codeigniter template, codeigniter ui, dashboard bootstrap, framework codeigniter, template codeigniter, template dashboard codeigniter.">
    
    <title>Tazen-Admin </title>

    <link rel="icon" href="{{ asset('admin/assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">

    <!-- Styles -->
    <script src="{{ asset('admin/assets/js/asset-path-fix.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/main.js') }}"></script>

    <link id="style" href="{{ asset('admin/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/libs/node-waves/waves.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/assets/libs/@simonwep/pickr/themes/nano.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/libs/choices.js/public/assets/styles/choices.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/libs/@tarekraafat/autocomplete.js/css/autoComplete.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <!-- Replace CDN SweetAlert2 with local version if available, or use alternative CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @yield('styles')
</head>    
    
<body>
    <div class="page">
        @include('admin.sections.header')
        @include('admin.sections.sidebar')

        @yield('content')

        <div class="modal fade" id="header-responsive-search" tabindex="-1" aria-labelledby="header-responsive-search" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="input-group">
                            <input type="text" class="form-control border-end-0" placeholder="Search Anything ..." aria-label="Search Anything ..." aria-describedby="button-addon2">
                            <button class="btn btn-primary" type="button" id="button-addon2"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        {{-- @include('admin.sections.footer') --}}

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    
        <script src="{{ asset('admin/assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>
        <script src="{{ asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('admin/assets/js/defaultmenu.js') }}"></script>
        <script src="{{ asset('admin/assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('admin/assets/js/sticky.js') }}"></script>
        <script src="{{ asset('admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('admin/assets/js/simplebar.js') }}"></script>
        <script src="{{ asset('admin/assets/libs/@tarekraafat/autocomplete.js/autoComplete.min.js') }}"></script>
        <script src="{{ asset('admin/assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>
        <script src="{{ asset('admin/assets/libs/flatpickr/flatpickr.min.js') }}"></script>
        <script src="{{ asset('admin/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('admin/assets/js/analytics-dashboard.js') }}"></script>
        <script src="{{ asset('admin/assets/js/custom-switcher.js') }}"></script>
        <script src="{{ asset('admin/assets/js/custom.js') }}"></script>
        <script src="{{ asset('admin/assets/js/date&time_pickers.js') }}"></script>

        <script>
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

            // Admin notification functions
            function markAdminNotificationAsRead(notificationId) {
                fetch('/admin/notifications/' + notificationId + '/mark-as-read', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the notification from the dropdown
                        location.reload(); // Refresh to update the notification count
                    }
                })
                .catch(error => {
                    console.error('Error marking notification as read:', error);
                });
            }

            function markAllAdminNotificationsAsRead() {
                fetch('/admin/notifications/mark-all-as-read', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Refresh to update the notification count
                    }
                })
                .catch(error => {
                    console.error('Error marking all notifications as read:', error);
                });
            }
        </script>
        
        <!-- Chat System -->
        @include('components.chat-modal')
        <script src="{{ asset('js/chat-system.js') }}"></script>
        
        @yield('scripts')
</body>

</html>
