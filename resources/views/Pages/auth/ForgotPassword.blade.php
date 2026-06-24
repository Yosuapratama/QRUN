@extends('TemplateLayout.UserLayout')

@push('title')
    <title>QRUN Website - Forgot Password</title>

    {{-- SEO META --}}
    <meta name="description"
        content="Forgot your password? Reset your Qrun Online account password securely and regain access to your account.">

    <meta name="keywords"
        content="forgot password qrun, reset password qrun, qrun online password reset, recover qrun account, qrun login help">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- OPEN GRAPH --}}
    <meta property="og:title" content="Forgot Password | Qrun Online">
    <meta property="og:description"
        content="Reset your Qrun Online account password securely and regain access to your account.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://qrun.online/forgot-password">

    {{-- TWITTER --}}
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Forgot Password | Qrun Online">
    <meta name="twitter:description"
        content="Reset your password and recover access to your Qrun Online account.">

    {{-- TOASTR CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    {{-- JQUERY --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    {{-- TOASTR JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <style>
        .toast-success {
            background-color: #28a745 !important;
        }

        .toast-error {
            background-color: #dc3545 !important;
        }

        .toast-info {
            background-color: #17a2b8 !important;
        }

        .toast-warning {
            background-color: #ffc107 !important;
            color: #000 !important;
        }

        .toast {
            opacity: 1 !important;
        }
    </style>
@endpush

@push('script')
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            newestOnTop: true,
            positionClass: "toast-top-right",

            timeOut: 8000,
            extendedTimeOut: 8000,

            showDuration: 300,
            hideDuration: 300,

            preventDuplicates: true,
        };

        let isSubmitting = false;

        $('form').on('submit', function() {

            if (isSubmitting) return false;

            isSubmitting = true;

            const btn = $('#submitBtn');

            btn.prop('disabled', true);

            btn.html(`
        <span class="spinner-border spinner-border-sm mr-2"></span>
        Sending Link...
    `);

        });
    </script>
@endpush
@section('content')
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="card login-card border-0 shadow-lg my-5">

                <div class="card-body p-0">

                    {{-- VALIDATION ERRORS --}}
                    @if ($errors->any())
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {

                                @foreach ($errors->all() as $error)
                                    toastr.error(@json($error), 'Error');
                                @endforeach

                            });
                        </script>
                    @endif

                    {{-- STATUS SUCCESS --}}
                    @if (session()->has('status'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {

                                toastr.success(@json(session('status')), 'Success');

                            });
                        </script>
                    @endif

                    {{-- SUCCESS --}}
                    @if (session()->has('success'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {

                                toastr.success(@json(session('success')), 'Success');

                            });
                        </script>
                    @endif

                    <div class="p-5">

                        {{-- ICON --}}
                        <div class="text-center mb-4">

                            <div class="mb-3">
                                <div
                                    style="
                        width: 80px;
                        height: 80px;
                        background: #eef6ff;
                        border-radius: 50%;
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                    ">

                                    <i class="fas fa-key"
                                        style="
                                font-size: 32px;
                                color: #4e73df;
                            ">
                                    </i>

                                </div>
                            </div>

                            <h1 class="h4 font-weight-bold text-gray-900 mb-2">
                                Forgot Your Password?
                            </h1>

                            <p class="text-muted mb-0"
                                style="
                        max-width: 320px;
                        margin: auto;
                        line-height: 1.6;
                    ">

                                Enter your email address and we'll send you a link to reset your password.

                            </p>

                        </div>

                        <form action="{{ route('password.email') }}" method="POST">

                            @csrf

                            {{-- EMAIL --}}
                            <div class="form-group mt-4">

                                <label for="emails">
                                    Email Address
                                </label>

                                <input id="emails" autofocus type="email" class="form-control form-control-user"
                                    name="email" value="{{ old('email') }}" required placeholder="Enter your email">

                            </div>

                            {{-- BUTTON --}}
                            <button type="submit" id="submitBtn" class="btn btn-success btn-user btn-block py-2 shadow-sm"
                                style="
                        font-weight: 600;
                        letter-spacing: .3px;
                    ">

                                <i class="fas fa-paper-plane mr-2"></i>

                                Send Reset Link

                            </button>

                            {{-- BACK --}}
                            <div class="text-center mt-4">

                                <a href="{{ route('login') }}" class="font-weight-bold"
                                    style="
                            text-decoration: none;
                        ">

                                    <i class="fas fa-arrow-left mr-1"></i>

                                    Back to Login

                                </a>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
