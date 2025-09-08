<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/img/sporta.svg') }}" type="image/x-icon">
    <title>Email Verification - App Sporta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <h4 class="fw-bold text-center mb-4">{{ __('Verify Your Email Address') }}</h4>

                        @if (session('resent'))
                            <div class="alert alert-success text-center" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        <p class="mb-3 text-center">
                            {{ __('Before proceeding, please check your email for a verification link.') }}
                        </p>
                        <p class="text-center">
                            {{ __('If you did not receive the email') }},
                        </p>

                        <form class="d-flex justify-content-center" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary rounded-3">
                                {{ __('Click here to request another') }}
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                ← {{ __('Back to Login') }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
