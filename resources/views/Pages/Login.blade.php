@extends('TemplateLayout.UserLayout')

@push('title')
    <title>Login | Qrun Online</title>

    <meta name="description"
        content="Login ke Qrun Online untuk mengelola prasasti digital, QR Code, konten lokasi, event, dan informasi tempat Anda.">

    <meta name="keywords"
        content="qrun login, login qrun online, masuk qrun online, qrun account login, platform prasasti digital">

    <meta name="robots" content="index, follow">
    <meta name="author" content="Qrun Online">
    <link rel="canonical" href="https://qrun.online/login">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Qrun Online">
    <meta property="og:title" content="Login | Qrun Online">
    <meta property="og:description" content="Masuk ke akun Qrun Online untuk mengelola QR Code dan prasasti digital lokasi Anda.">
    <meta property="og:url" content="https://qrun.online/login">
    <meta property="og:image" content="https://qrun.online/home.jpg">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Login | Qrun Online">
    <meta name="twitter:description" content="Masuk ke akun Qrun Online untuk mengelola QR Code dan prasasti digital lokasi Anda.">
    <meta name="twitter:image" content="https://qrun.online/home.jpg">
    <meta name="theme-color" content="#2d4373">

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "Login | Qrun Online",
        "url": "https://qrun.online/login",
        "description": "Masuk ke akun Qrun Online untuk mengelola prasasti digital, QR Code, dan informasi lokasi Anda.",
        "isPartOf": {
            "@type": "WebSite",
            "name": "Qrun Online",
            "url": "https://qrun.online"
        }
    }
    </script>

    {{-- TOASTR CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    {{-- JQUERY --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    {{-- TOASTR JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <style>
        .toast-success { background-color: #28a745 !important; }
        .toast-error   { background-color: #dc3545 !important; }
        .toast-info    { background-color: #17a2b8 !important; }
        .toast-warning { background-color: #ffc107 !important; color: #000 !important; }
        .toast         { opacity: 1 !important; }

        .login-card {
            border-radius: 20px;
            overflow: hidden;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,.08), 0 2px 8px rgba(0,0,0,.04);
        }

        .btn-user { transition: all .2s ease; }
        .btn-user:hover { transform: translateY(-1px); }
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
                .html(`<span class="spinner-border spinner-border-sm mr-2"></span> {{ __('messages.login_page.logging_in') }}`);
        });

        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput  = document.querySelector('#pw');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password'
                ? '<i class="fas fa-eye"></i>'
                : '<i class="fas fa-eye-slash"></i>';
        });
    </script>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-9">
                <div class="card login-card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                                <div class="p-5">
                                    <div class="text-center mb-4">
                                        <h1 style="color: #3c4043;" class="h4 font-weight-bold mb-1">
                                            {{ __('messages.login_page.welcome') }}
                                        </h1>
                                        <p class="text-dark mb-0" style="opacity:.9;">
                                            {{ __('messages.login_page.subtitle') }}
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
                                            <label for="exampleInputEmail">{{ __('messages.login_page.email_label') }}</label>
                                            <input autofocus type="email" class="form-control form-control-user"
                                                value="{{ old('email') }}" id="exampleInputEmail" name="email" required
                                                aria-describedby="emailHelp"
                                                placeholder="{{ __('messages.login_page.email_placeholder') }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="pw">{{ __('messages.login_page.password_label') }}</label>
                                            <div class="input-group">
                                                <input id="pw" type="password" class="form-control"
                                                    placeholder="{{ __('messages.login_page.password_placeholder') }}"
                                                    name="password" required>
                                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group d-flex justify-content-between align-items-center mt-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                                <label class="custom-control-label" for="remember">
                                                    {{ __('messages.login_page.remember_me') }}
                                                </label>
                                            </div>
                                            <a class="small d-flex align-items-center"
                                                href="{{ route('password.request') }}" style="gap:6px;">
                                                <i class="fas fa-unlock-alt"></i>
                                                <span>{{ __('messages.login_page.forgot_password') }}</span>
                                            </a>
                                        </div>

                                        <button type="submit"
                                            class="btn btn-success btn-user btn-block py-2 shadow-sm"
                                            style="font-weight:600;letter-spacing:.3px;">
                                            {{ __('messages.login_page.login_btn') }}
                                        </button>

                                        <div class="d-flex align-items-center my-2">
                                            <hr class="flex-grow-1">
                                            <span class="mx-3 text-muted font-weight-bold small">
                                                {{ __('messages.login_page.or') }}
                                            </span>
                                            <hr class="flex-grow-1">
                                        </div>

                                        <a class="btn btn-light btn-user btn-block d-flex align-items-center justify-content-center shadow-sm py-2"
                                            style="border:1px solid #dadce0;font-weight:600;transition:.2s ease;"
                                            onmouseover="this.style.background='#f8f9fa'"
                                            onmouseout="this.style.background='#fff'"
                                            href="{{ route('authGoogle') }}">
                                            <img src="https://developers.google.com/identity/images/g-logo.png"
                                                alt="Google Logo"
                                                style="width:20px;height:20px;margin-right:12px;">
                                            <span style="color:#3c4043;">
                                                {{ __('messages.login_page.continue_google') }}
                                            </span>
                                        </a>

                                        <p class="mt-4 text-center">
                                            {{ __('messages.login_page.no_account') }}
                                            <a href="{{ route('register') }}" class="font-weight-bold">
                                                {{ __('messages.login_page.register_here') }}
                                            </a>
                                        </p>

                                        <div class="mt-4 p-3 rounded"
                                            style="background:#eef6ff;border:1px solid #b9d8ff;">
                                            <small style="color:#1f2937;font-size:13px;line-height:1.7;">
                                                {{ __('messages.login_page.agree_prefix') }}
                                                <a href="{{ route('termsOfService') }}"
                                                    style="color:#0d6efd;font-weight:600;text-decoration:underline;">
                                                    {{ __('messages.login_page.terms_of_service') }}
                                                </a>
                                                {{ __('messages.login_page.and') }}
                                                <a href="{{ route('privacyPolicy') }}"
                                                    style="color:#0d6efd;font-weight:600;text-decoration:underline;">
                                                    {{ __('messages.login_page.privacy_policy') }}
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
