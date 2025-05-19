<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tazen - Professional Login</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/account.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/custom.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url("https://images.pexels.com/photos/1595385/pexels-photo-1595385.jpeg?cs=srgb&dl=pexels-hillaryfox-1595385.jpg&fm=jpg");
background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;


        }
        .toast-top-center {
    top: 40px !important;
    left: 50% !important;
    transform: translateX(-50%) !important;
    z-index: 9999 !important;
}
    </style>
</head>

<body>
    <div id="login">
        	<figure>
				<a href="{{ route('home') }}"><img src="{{ asset('customer-css/assets/images/tazen_logo.png') }}" width="100" height="100" alt="" class="logo_sticky"></a>
			</figure>
        <aside style="display:flex; flex-direction:column; gap:50px;">
            <h2 class="text-center">Professional Login</h2>
            <form id="loginForm">
                @csrf

                <div class="form-group">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                    <i class="icon_mail_alt"></i>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                    <i class="icon_lock_alt"></i>
                </div>

                <div class="clearfix add_bottom_30">
                    <div class="checkboxes float-start">
                        <label class="container_check">Remember me
                            <input type="checkbox" name="remember">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                  <div class="float-end">
    <a id="forgot" href="{{ route('professional.forgot.form') }}">Forgot Password?</a>
</div>
                </div>

                <button type="submit" class="btn_1 full-width">Login to Tazen</button>

                <div class="text-center add_top_10">
                    New to Tazen? <strong><a href="{{ route('professional.register') }}">Sign up!</a></strong>
                </div>
            </form>
            <div class="copy text-center">© Tazen</div>
        </aside>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('frontend/assets/js/common_scripts.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/common_func.js') }}"></script>
    <script src="{{ asset('frontend/assets/validate.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $('#loginForm').submit(function (e) {
            e.preventDefault();

            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');
            $submitBtn.prop('disabled', true);

            $.ajax({
                url: "{{ route('professional.store') }}",
                method: "POST",
                data: $form.serialize(),
                headers: {
                    "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
                },
                success: function (response) {
					if (response.status === 'rejected') {
        toastr.warning(response.message || "Your account has been rejected.");
    } 

    if (response.redirect_url) {
        setTimeout(() => window.location.href = response.redirect_url, 1500);
    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        $.each(xhr.responseJSON.errors, (key, value) => toastr.error(value[0]));
                    } else {
                        toastr.error(xhr.responseJSON.message || "An error occurred. Please try again.");
                    }
                },
                complete: function () {
                    $submitBtn.prop('disabled', false);
                }
            });
        });
    </script>
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
</body>

</html>
