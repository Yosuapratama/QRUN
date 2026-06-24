@extends('TemplateLayout.UserLayout')

@push('title')
    <title>Create New Password | QRUN Online</title>

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

        .requirement-item {
            transition: all .25s ease;
            font-size: 14px;
        }

        .requirement-valid {
            color: #198754 !important;
            transform: translateX(3px);
        }

        .requirement-valid i {
            color: #198754;
        }
    </style>
@endpush

@push('script')
    <script>
        const confirmPasswordInput =
            document.getElementById('password_confirmation');

        const passwordMatchStatus =
            document.getElementById('passwordMatchStatus');

        function validatePasswordMatch() {

            const password =
                passwordInput.value;

            const confirmPassword =
                confirmPasswordInput.value;

            if (confirmPassword.length === 0) {

                passwordMatchStatus.style.display = 'none';

                return;
            }

            passwordMatchStatus.style.display = 'block';

            if (password === confirmPassword) {

                passwordMatchStatus.innerHTML = `
                <span style="color:#198754;">
                    <i class="fas fa-check-circle mr-1"></i>
                    Passwords match
                </span>
            `;

            } else {

                passwordMatchStatus.innerHTML = `
                <span style="color:#dc3545;">
                    <i class="fas fa-times-circle mr-1"></i>
                    Passwords do not match
                </span>
            `;
            }

            validateSubmitButton();
        }

        confirmPasswordInput.addEventListener(
            'input',
            validatePasswordMatch
        );

        const passwordInput =
            document.getElementById('password');

        const submitBtn =
            document.getElementById('submitBtn');

        const requirementsBox =
            document.getElementById('passwordRequirements');

        const lengthRule =
            document.getElementById('lengthRule');

        const letterRule =
            document.getElementById('letterRule');

        const numberRule =
            document.getElementById('numberRule');

        passwordInput.addEventListener('focus', function() {

            requirementsBox.style.display = 'block';

        });

        passwordInput.addEventListener('input', function() {

            const value = this.value;

            // VALIDATIONS
            const hasMinLength = value.length >= 8;
            const hasLetter = /[A-Za-z]/.test(value);
            const hasNumber = /[0-9]/.test(value);

            // LENGTH
            updateRule(
                lengthRule,
                hasMinLength,
                'Minimum 8 characters'
            );

            // LETTER
            updateRule(
                letterRule,
                hasLetter,
                'Contains at least one letter'
            );

            // NUMBER
            updateRule(
                numberRule,
                hasNumber,
                'Contains at least one number'
            );

            validateSubmitButton();
        });

        function updateRule(element, isValid, text) {

            if (isValid) {

                element.classList.add('requirement-valid');

                element.innerHTML = `
                <i class="fas fa-check-circle mr-2"></i>
                ${text}
            `;

            } else {

                element.classList.remove('requirement-valid');

                element.innerHTML = `
                <i class="fas fa-circle mr-2"></i>
                ${text}
            `;
            }

        }

        toastr.options = {
            closeButton: true,
            progressBar: true,
            newestOnTop: true,
            positionClass: "toast-top-right",
            preventDuplicates: true,
            timeOut: "7000",
            extendedTimeOut: "7000",
        };

        // PASSWORD TOGGLE
        function togglePassword(id, button) {

            const input = document.getElementById(id);

            const type = input.type === 'password' ?
                'text' :
                'password';

            input.type = type;

            button.innerHTML = type === 'password' ?
                '<i class="fas fa-eye"></i>' :
                '<i class="fas fa-eye-slash"></i>';
        }

        function validateSubmitButton() {

            const value = passwordInput.value;

            const hasMinLength =
                value.length >= 8;

            const hasLetter =
                /[A-Za-z]/.test(value);

            const hasNumber =
                /[0-9]/.test(value);

            const passwordsMatch =
                passwordInput.value ===
                confirmPasswordInput.value;

            if (
                hasMinLength &&
                hasLetter &&
                hasNumber &&
                passwordsMatch
            ) {

                submitBtn.disabled = false;

                submitBtn.style.opacity = '1';

                submitBtn.style.cursor = 'pointer';

            } else {

                submitBtn.disabled = true;

                submitBtn.style.opacity = '.65';

                submitBtn.style.cursor = 'not-allowed';
            }

        }
        // LOADING BUTTON
        $('form').on('submit', function() {

            $('button[type="submit"]')
                .prop('disabled', true)
                .html(`
                    <span class="spinner-border spinner-border-sm mr-2"></span>
                    Saving Password...
                `);

        });
    </script>
@endpush

@section('content')
    <div class="container">

        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-6 col-md-9">

                <div class="card login-card border-0 shadow-lg my-5">

                    <div class="card-body p-0">

                        <div class="p-5">

                            {{-- ICON --}}
                            <div class="text-center mb-4">

                                <div class="mb-3">
                                    <div
                                        style="
                                    width: 85px;
                                    height: 85px;
                                    background: #eef6ff;
                                    border-radius: 50%;
                                    display: inline-flex;
                                    align-items: center;
                                    justify-content: center;
                                ">

                                        <i class="fas fa-lock"
                                            style="
                                            font-size: 34px;
                                            color: #4e73df;
                                        ">
                                        </i>

                                    </div>
                                </div>

                                <h1 class="h4 font-weight-bold text-gray-900 mb-2">
                                    Create New Password
                                </h1>

                                <p class="text-muted mb-0"
                                    style="
                                    max-width: 320px;
                                    margin: auto;
                                    line-height: 1.6;
                                ">

                                    Your new password must be different from your previous password.

                                </p>

                            </div>

                            <form action="{{ route('password.update') }}" method="POST">

                                @csrf

                                {{-- TOAST ERRORS --}}
                                @if ($errors->any())
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {

                                            @foreach ($errors->all() as $error)
                                                toastr.error(@json($error), 'Error');
                                            @endforeach

                                        });
                                    </script>
                                @endif

                                {{-- SUCCESS --}}
                                @if (session()->has('status'))
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {

                                            toastr.success(@json(session('status')), 'Success');

                                        });
                                    </script>
                                @endif

                                <input type="hidden" name="token" value="{{ request()->token }}">

                                <input type="hidden" name="email" value="{{ request()->email }}">

                                {{-- NEW PASSWORD --}}
                                {{-- PASSWORD --}}
                                <div class="form-group mt-4">

                                    <label for="password">
                                        New Password
                                    </label>

                                    <div class="input-group">

                                        <input id="password" type="password" class="form-control" name="password" required
                                            placeholder="Enter your new password">

                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('password', this)">

                                            <i class="fas fa-eye"></i>

                                        </button>

                                    </div>

                                    {{-- PASSWORD RULES --}}
                                    <div id="passwordRequirements" class="mt-3 p-3 rounded"
                                        style="
            background: #f8f9fc;
            border: 1px solid #e3e6f0;
            display: none;
        ">

                                        <small class="d-block mb-2 font-weight-bold text-dark">
                                            Password Requirements
                                        </small>

                                        <div id="lengthRule" class="requirement-item text-muted mb-2">

                                            <i class="fas fa-circle mr-2"></i>

                                            Minimum 8 characters

                                        </div>

                                        <div id="letterRule" class="requirement-item text-muted mb-2">

                                            <i class="fas fa-circle mr-2"></i>

                                            Contains at least one letter

                                        </div>

                                        <div id="numberRule" class="requirement-item text-muted">

                                            <i class="fas fa-circle mr-2"></i>

                                            Contains at least one number

                                        </div>

                                    </div>

                                </div>

                                {{-- CONFIRM PASSWORD --}}
                                <div class="form-group mt-3">

                                    <label for="password_confirmation">
                                        Confirm Password
                                    </label>

                                    <div class="input-group">

                                        <input id="password_confirmation" type="password" class="form-control"
                                            name="password_confirmation" required placeholder="Confirm your new password">

                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('password_confirmation', this)">

                                            <i class="fas fa-eye"></i>

                                        </button>

                                    </div>

                                    <div id="passwordMatchStatus" class="mt-2 small"
                                        style="
            display:none;
            transition:.2s ease;
        ">
                                    </div>

                                </div>

                                {{-- SAVE BUTTON --}}
                                <button type="submit" id="submitBtn" disabled
                                    class="btn btn-success btn-user btn-block py-2 shadow-sm mt-4"
                                    style="
        font-weight: 600;
        letter-spacing: .3px;
        opacity: .65;
        cursor: not-allowed;
    ">

                                    <i class="fas fa-save mr-2"></i>

                                    Save Password

                                </button>
                                {{-- BACK --}}
                                <div class="text-center mt-4">

                                    <a href="{{ route('login') }}" class="font-weight-bold" style="text-decoration:none;">

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

    </div>
@endsection
