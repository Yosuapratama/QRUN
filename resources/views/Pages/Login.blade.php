@extends('TemplateLayout.UserLayout')

@push('title')
    <title>Login | Qrun Online</title>
    <meta name="description" content="Secure login page for accessing your account. Enter your credentials to continue.">
    <meta name="keywords"
        content="qrun online, login qrun, login qrun online, sign in qrun, sign in qrun online, register qrun online,register qrun">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Login to Your Account">
    <meta property="og:description" content="Access your account by logging in.">
    <meta property="og:url" content="https://qrun.online/auth/login">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Login to Your Account">
    <meta name="twitter:description" content="Securely log in to your account.">

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

        .login-card {
            border-radius: 20px;
            overflow: hidden;
            border: none;
            box-shadow:
                0 10px 30px rgba(0, 0, 0, .08),
                0 2px 8px rgba(0, 0, 0, .04);
        }

        .btn-user {
            transition: all .2s ease;
        }

        .btn-user:hover {
            transform: translateY(-1px);
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
    </script>
    <script>
        $('form').on('submit', function() {

            $('button[type="submit"]')
                .prop('disabled', true)
                .html(`
            <span class="spinner-border spinner-border-sm mr-2"></span>
            Logging in...
        `);

        });

        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#pw');

        togglePassword.addEventListener('click', function() {

            const type = passwordInput.getAttribute('type') === 'password' ?
                'text' :
                'password';

            passwordInput.setAttribute('type', type);

            this.innerHTML = type === 'password' ?
                '<i class="fas fa-eye"></i>' :
                '<i class="fas fa-eye-slash"></i>';

        });
    </script>
@endpush
@section('content')
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-6 col-md-9">

                <div class="card login-card  o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            {{-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> --}}
                            <div class="col-lg-12 col-xl-12">
                                <div class="p-5">
                                    <div class="text-center mb-4">
                                        <h1 style="color: #3c4043;" class="h4 font-weight-bold mb-1">
                                            Welcome to QRUN
                                        </h1>

                                        <p class="text-dark mb-0" style="opacity: .9;">
                                            Login to continue
                                        </p>
                                    </div>
                                    <form method="POST" action="{{ route('login.store') }}">
                                        @csrf

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
                                        <div class="form-group mt-2">
                                            <label for="exampleInputEmail">Email</label>
                                            <input autofocus type="email" class="form-control form-control-user"
                                                value="{{ old('email') }}" id="exampleInputEmail" name="email" required
                                                aria-describedby="emailHelp" placeholder="Enter Your Email...">
                                        </div>

                                        <div class="form-group">
                                            <label for="pw">Password</label>
                                            <div class="input-group">

                                                <input id="pw" type="password" class="form-control"
                                                    placeholder="Password" name="password" required>

                                                <button class="btn btn-outline-secondary" type="button"
                                                    id="togglePassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                            </div>
                                        </div>
                                        <div class="form-group d-flex justify-content-between align-items-center mt-3">

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="remember"
                                                    name="remember">

                                                <label class="custom-control-label" for="remember">
                                                    Remember Me
                                                </label>
                                            </div>

                                            <a class="small d-flex align-items-center"
                                                href="{{ route('password.request') }}" style="gap:6px;">

                                                <i class="fas fa-unlock-alt"></i>

                                                <span>Forgot Password?</span>

                                            </a>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-user btn-block py-2 shadow-sm"
                                            style="
        font-weight: 600;
        letter-spacing: .3px;
    ">
                                            Login
                                        </button>

                                        {{-- <hr> --}}
                                        <div class="d-flex align-items-center my-2">

                                            <hr class="flex-grow-1">

                                            <span class="mx-3 text-muted font-weight-bold small">
                                                OR
                                            </span>

                                            <hr class="flex-grow-1">

                                        </div>
                                        <a class="btn btn-light btn-user btn-block d-flex align-items-center justify-content-center shadow-sm py-2"
                                            style="
        border: 1px solid #dadce0;
        font-weight: 600;
        transition: .2s ease;
    "
                                            onmouseover="this.style.background='#f8f9fa'"
                                            onmouseout="this.style.background='#fff'" href="{{ route('authGoogle') }}">

                                            {{-- GOOGLE LOGO --}}
                                            <img src="https://developers.google.com/identity/images/g-logo.png"
                                                alt="Google Logo"
                                                style="
            width: 20px;
            height: 20px;
            margin-right: 12px;
        ">

                                            <span style="color: #3c4043;">
                                                Continue with Google
                                            </span>
                                        </a>

                                        <p class="mt-4 text-center">
                                            Don't have an account?
                                            <a href="{{ route('register') }}" class="font-weight-bold">
                                                Register here
                                            </a>
                                        </p>
                                        <div class="mt-4 p-3 rounded"
                                            style="
        background: #eef6ff;
        border: 1px solid #b9d8ff;
    ">

                                            <small
                                                style="
        color: #1f2937;
        font-size: 13px;
        line-height: 1.7;
    ">
                                                By continuing, you agree to our
                                                <a href="{{ route('termsOfService') }}"
                                                    style="
                color: #0d6efd;
                font-weight: 600;
                text-decoration: underline;
            ">
                                                    Terms of Service
                                                </a>
                                                and
                                                <a href="{{ route('privacyPolicy') }}"
                                                    style="
                color: #0d6efd;
                font-weight: 600;
                text-decoration: underline;
            ">
                                                    Privacy Policy
                                                </a>.
                                            </small>

                                        </div>


                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
