@extends('TemplateLayout.UserLayout')

@push('title')
    <title>Register | Qrun Online</title>

    <meta name="description"
        content="Daftar akun Qrun Online dan mulai membuat prasasti digital berbasis QR Code untuk tempat, lokasi wisata, pura, candi, museum, dan berbagai kebutuhan informasi digital lainnya.">

    <meta name="keywords"
        content="register qrun online, daftar qrun, buat akun qrun, qrun online, prasasti digital, qr code tempat, qr code wisata">

    <meta name="robots" content="index, follow">

    <meta name="author" content="Qrun Online">

    <link rel="canonical" href="https://qrun.online/register">

    <!-- Open Graph -->
    <meta property="og:type" content="website">

    <meta property="og:site_name" content="Qrun Online">

    <meta property="og:title" content="Register | Qrun Online">

    <meta property="og:description"
        content="Buat akun Qrun Online dan mulai membuat prasasti digital berbasis QR Code untuk lokasi Anda.">

    <meta property="og:url" content="https://qrun.online/register">

    <meta property="og:image" content="https://qrun.online/home.jpg">

    <meta property="og:image:width" content="1200">

    <meta property="og:image:height" content="630">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">

    <meta name="twitter:title" content="Register | Qrun Online">

    <meta name="twitter:description"
        content="Daftar akun Qrun Online dan mulai membuat prasasti digital berbasis QR Code untuk lokasi Anda.">

    <meta name="twitter:image" content="https://qrun.online/home.jpg">

    <meta name="theme-color" content="#2d4373">

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "Register | Qrun Online",
        "url": "https://qrun.online/register",
        "description": "Daftar akun Qrun Online dan mulai membuat prasasti digital berbasis QR Code untuk lokasi Anda.",
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
        document.addEventListener('DOMContentLoaded', function() {
            $('form').on('submit', function() {

                $('button[type="submit"]')
                    .prop('disabled', true)
                    .html(`
            <span class="spinner-border spinner-border-sm mr-2"></span>
            Logging in...
        `);

            });
            // =========================
            // PASSWORD TOGGLE
            // =========================
            function togglePassword(inputId, iconShow, iconHide) {
                const input = document.getElementById(inputId);
                const show = document.getElementById(iconShow);
                const hide = document.getElementById(iconHide);

                show.addEventListener('click', () => {
                    input.type = 'text';
                    show.style.display = 'none';
                    hide.style.display = 'block';
                });

                hide.addEventListener('click', () => {
                    input.type = 'password';
                    show.style.display = 'block';
                    hide.style.display = 'none';
                });
            }

            togglePassword('pw', 'eyeShowIcon', 'eyeShowIcon2');
            togglePassword('pw-2', 'eyeShowIconconfirm', 'eyeShowIconconfirm2');

            // =========================
            // PASSWORD STRENGTH
            // =========================
            const pw = document.getElementById('pw');
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');

            function checkStrength(val) {
                let score = 0;
                if (val.length >= 8) score++;
                if (/[A-Z]/.test(val)) score++;
                if (/[0-9]/.test(val)) score++;
                if (/[^A-Za-z0-9]/.test(val)) score++;

                return score;
            }

            pw.addEventListener('input', () => {
                const score = checkStrength(pw.value);

                const widths = ['10%', '25%', '50%', '75%', '100%'];
                const colors = ['#dc3545', '#dc3545', '#ffc107', '#0d6efd', '#198754'];
                const labels = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];

                strengthBar.style.width = widths[score];
                strengthBar.style.background = colors[score];
                strengthText.innerText = labels[score];
            });

            // =========================
            // PASSWORD MATCH
            // =========================
            const pw2 = document.getElementById('pw-2');
            const matchText = document.getElementById('matchText');

            function checkMatch() {
                if (!pw2.value) {
                    matchText.innerText = '';
                    return;
                }

                if (pw.value === pw2.value) {
                    matchText.innerText = 'Passwords match';
                    matchText.style.color = '#198754';
                } else {
                    matchText.innerText = 'Passwords do not match';
                    matchText.style.color = '#dc3545';
                }
            }

            pw.addEventListener('input', checkMatch);
            pw2.addEventListener('input', checkMatch);

            // =========================
            // CHECKBOX ENABLE BUTTON
            // =========================
            const checker = document.getElementById('agreed');
            const btn = document.getElementById('registerBtn');

            btn.disabled = true;

            checker.addEventListener('change', function() {
                btn.disabled = !this.checked;
            });

            // =========================
            // LOADING STATE
            // =========================
            document.getElementById('registerForm').addEventListener('submit', function() {
                btn.innerHTML = 'Processing...';
                btn.disabled = true;
            });

        });
    </script>
@endpush

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #2d4373, #24396f);
        }

        .qrun-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .trust-panel {
            color: #fff;
            padding: 40px;
        }

        .trust-title {
            font-size: 28px;
            font-weight: 700;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-success {
            border-radius: 10px;
            padding: 10px;
        }

        .password-meter {
            height: 6px;
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 6px;
        }

        .password-meter-bar {
            height: 100%;
            width: 0%;
            transition: .3s;
        }

        .tos-wrapper {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 16px;
            padding: 16px 18px;
        }

        .tos-checkbox {
            transform: scale(1.28);
            margin-left: 4px;
            margin-top: 5px;
            cursor: pointer;
        }

        .tos-label {
            margin-left: 30px;
            color: #5f6b7a;
            font-size: 14px;
            line-height: 1.7;
            cursor: pointer;
        }

        .tos-label a {
            color: #2d4373;
            font-weight: 600;
            text-decoration: none;
        }

        .tos-label a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .tos-checkbox {
                transform: scale(1.4);
            }

            .tos-label {
                font-size: 13.8px;
                line-height: 1.8;
            }
        }
    </style>

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

    <div class="container py-5">

        <div class="row justify-content-center align-items-center">

            <!-- LEFT TRUST PANEL -->
            <div class="col-lg-5 d-none d-lg-block">
                <div class="trust-panel">
                    <h2 class="trust-title">Create Your Digital Heritage Experience</h2>

                    <p>
                        Transform physical locations into interactive digital experiences using QR Codes, multimedia
                        content, and rich historical information.
                    </p>

                    <ul class="mt-4">
                        <li>✔ Generate unique QR Codes for each location</li>
                        <li>✔ Share history, photos, videos, and important information</li>
                        <li>✔ Perfect for temples, museums, landmarks, and tourist destinations</li>
                        <li>✔ Update content anytime without replacing QR Codes</li>
                    </ul>
                </div>
            </div>

            <!-- RIGHT FORM -->
            <!-- RIGHT FORM -->
            <div class="col-lg-6 col-md-9">
                <div class="card qrun-card border-0">

                    <div class="card-body p-4 p-lg-5">

                        <!-- HEADER -->
                        <div class="text-center mb-4">
                            <div
                                style="width:50px;height:50px;margin:auto;border-radius:12px;background:#24396f;display:flex;align-items:center;justify-content:center;color:#fff;">
                                <i class="fas fa-user-plus"></i>
                            </div>

                            <h4 class="mt-3 h4 font-weight-bold mb-1" style="color: #3c4043;">Create your account</h4>
                            <small class="text-muted">It only takes a few seconds</small>
                        </div>

                        <form id="registerForm" method="POST" action="{{ route('register.store') }}">
                            @csrf

                            <!-- SECTION: PERSONAL -->
                            <div class="mb-3">
                                <div class="fw-semibold mb-2 text-muted small">PERSONAL INFORMATION</div>

                                <label style="color: #3c4043;" class="font-weight-bold form-label">Full Name <span
                                        class="text-danger">*</span></label>
                                <input name="name" value="{{ old('name') }}" class="form-control form-control-lg"
                                    placeholder="John Doe" required>
                            </div>

                            <!-- PHONE -->
                            <div class="mb-3">
                                <label style="color: #3c4043;" class="font-weight-bold form-label">Phone Number <span
                                        class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light">+62</span>
                                    <input type="number" name="phone" value="{{ old('phone') }}" class="form-control"
                                        placeholder="8123456789" required>
                                </div>
                            </div>

                            <!-- EMAIL -->
                            <div class="mb-4">
                                <label style="color: #3c4043;" class="font-weight-bold form-label">Email Address <span
                                        class="text-danger">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control form-control-lg" placeholder="example@gmail.com" required>
                            </div>

                            <hr class="my-4">

                            <!-- SECTION: SECURITY -->
                            <div class="mb-2">
                                <div class="fw-semibold mb-2 text-muted small">SECURITY</div>
                            </div>

                            <!-- PASSWORD -->
                            <div class="mb-3">
                                <label style="color: #3c4043;" class="font-weight-bold form-label">Password <span
                                        class="text-danger">*</span></label>

                                <div class="input-group input-group-lg">
                                    <span class="input-group-text" id="eyeShowIcon">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                    <span class="input-group-text" id="eyeShowIcon2" style="display:none;">
                                        <i class="fas fa-eye-slash"></i>
                                    </span>

                                    <input id="pw" type="password" name="password" class="form-control"
                                        placeholder="Create strong password" required>
                                </div>

                                <!-- STRENGTH -->
                                <div class="mt-2">
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted">Strength</small>
                                        <small id="strengthText" class="fw-semibold"></small>
                                    </div>

                                    <div style="height:6px;background:#e9ecef;border-radius:10px;overflow:hidden;">
                                        <div id="strengthBar"
                                            style="height:100%;width:0%;transition:.3s;background:#dc3545;"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- CONFIRM PASSWORD -->
                            <div class="mb-3">
                                <label style="color: #3c4043;" class="font-weight-bold form-label">Confirm Password <span
                                        class="text-danger">*</span></label>

                                <div class="input-group input-group-lg">
                                    <span class="input-group-text" id="eyeShowIconconfirm">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                    <span class="input-group-text" id="eyeShowIconconfirm2" style="display:none;">
                                        <i class="fas fa-eye-slash"></i>
                                    </span>

                                    <input id="pw-2" type="password" name="password2" class="form-control"
                                        placeholder="Repeat password" required>
                                </div>

                                <small id="matchText" class="mt-1 d-block"></small>
                            </div>

                            <hr class="my-4">

                            <!-- ADDRESS -->
                            <div class="mb-3">
                                <div class="fw-semibold mb-2 text-muted small">LOCATION</div>

                                <label style="color: #3c4043;" class="font-weight-bold form-label">Address <span
                                        class="text-danger">*</span></label>
                                <textarea name="address" class="form-control" rows="3" placeholder="Your address" required>{{ old('address') }}</textarea>
                            </div>

                            <!-- TOS -->
                            <div class="form-check mb-4 p-3 rounded tos-wrapper">

                                <input class="form-check-input tos-checkbox" type="checkbox" name="agreedTOS"
                                    id="agreed">

                                <label class="form-check-label tos-label" for="agreed">
                                    I agree to
                                    <a href="{{ route('privacyPolicy') }}" target="_blank">
                                        Privacy Policy
                                    </a>
                                    and
                                    <a href="{{ route('termsOfService') }}" target="_blank">
                                        Terms of Service
                                    </a>
                                </label>

                            </div>
                            <!-- BUTTON -->
                            <button id="registerBtn" class="btn btn-success btn-lg w-100 fw-semibold">
                                Create Account
                            </button>

                            <!-- LOGIN -->
                            <div class="text-center mt-3">
                                <p class="text-muted">
                                    Already have an account?
                                    <a href="{{ route('login') }}" class="fw-semibold">Login</a>
                                </p>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
