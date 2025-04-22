<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServicePro Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/adminindex.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
</head>
<body>
    <div class="app-container">
      @include('admin.sections.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
        @include('admin.sections.header')

            @yield('content')
           
        </div>
    </div>

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
    <script src="{{ asset('admin/assets/js/script.js') }}"></script>
</body>

</html>