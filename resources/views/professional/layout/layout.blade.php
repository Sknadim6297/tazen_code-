<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServicePro Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link rel="stylesheet" href="{{ asset('professional/assets/css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    <!-- jQuery and Toastr libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @yield('scripts')

    <script>
        // Toggle sidebar on mobile
        document.querySelector('.toggle-sidebar').addEventListener('click', function () {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // Close sidebar on mobile
        document.querySelector('.close-sidebar').addEventListener('click', function () {
            document.querySelector('.sidebar').classList.remove('active');
        });

        // Tab functionality
    </script>
</body>
</html>
