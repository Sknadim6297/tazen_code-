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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
        .invalid-feedback {
            display: none;
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div id="login">
        <figure>
            <a href="{{ route('home') }}"><img src="{{ asset('customer-css/assets/images/tazen_logo.png') }}" width="auto" height="100" alt="" class="logo_sticky"></a>
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

                <!-- Add Terms and Conditions checkbox -->
                <div class="form-group mb-3">
                    <label class="container_check">I accept the <a href="{{ route('professional.terms') }}" target="_blank">Terms and Conditions</a>
                        <input type="checkbox" name="terms_accepted" id="terms_accepted">
                        <span class="checkmark"></span>
                    </label>
                    <div class="invalid-feedback" id="terms-error">
                        You must accept the Terms and Conditions to continue.
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

    <!-- Add this modal for deactivated accounts -->
    <div class="modal fade" id="deactivatedModal" tabindex="-1" aria-labelledby="deactivatedModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deactivatedModalLabel">Account Deactivated</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 48px;"></i>
                    </div>
                    <p>Your account has been deactivated by the administrator.</p>
                    <p>Please contact support for assistance.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="mailto:support@tazen.com" class="btn btn-primary">
                        <i class="fas fa-envelope me-2"></i>Contact Support
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
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

            // Check if terms checkbox is checked
            if (!$('#terms_accepted').is(':checked')) {
                $('#terms-error').show();
                toastr.error('You must accept the Terms and Conditions to continue.');
                return false;
            }

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
                    } else {
                        toastr.success(response.message || "Login successful!");
                    }

                    if (response.redirect_url) {
                        setTimeout(() => window.location.href = response.redirect_url, 1500);
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 403 && xhr.responseJSON.status === 'deactivated') {
                        // Show deactivated account modal
                        $('#deactivatedModal').modal('show');
                    } else if (xhr.status === 422) {
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

        $(document).ready(function() {
            // Hide error message when checkbox is checked
            $('#terms_accepted').change(function() {
                if($(this).is(':checked')) {
                    $('#terms-error').hide();
                }
            });
            
            // Initially hide the error message
            $('#terms-error').hide();
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
