@extends('TemplateLayout.AdminLayout')

@section('content')
    @push('title')
        <title>My Profile Admin - QRUN Website</title>
    @endpush

    <div class="container-fluid py-2">
        {{-- Header --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-1 text-gray-800 font-weight-bold">My Profile</h1>
                <p class="text-muted mb-0">
                    Manage your account information and security settings.
                </p>
            </div>
        </div>

        @push('script')
            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    // Success Toast
                    @if (session()->has('success'))
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: @json(session()->get('success')),
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    @endif

                    // Error Toast
                    @if ($errors->any())
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Error',
                            html: `{!! implode('<br>', $errors->all()) !!}`,
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true
                        });
                    @endif

                });
            </script>
        @endpush

        <div class="row">
            {{-- Left Profile Card --}}
            <div class="col-lg-4 mb-4">
                <div class="card shadow border-0 h-100">
                    <div class="card-body p-0">

                        {{-- Top Banner --}}
                        <div class="profile-banner text-center">
                            <div class="profile-avatar mx-auto py-4">
                                <img class="img-profile rounded-circle" src="{{ asset('AdminBS2/img/undraw_profile.svg') }}"
                                    alt="User Avatar" width="80px">
                            </div>

                            <h4 class="font-weight-bold text-black mt-3 mb-1">
                                {{ $User->name }}
                            </h4>

                            <p class="text-black-50 mb-3">
                                {{ $User->email }}
                            </p>

                            @if ($User->email_verified_at)
                                <span class="badge badge-light px-3 py-2">
                                    <i class="fas fa-check-circle text-success mr-1"></i>
                                    Verified Account
                                </span>
                            @else
                                <span class="badge badge-light px-3 py-2">
                                    <i class="fas fa-exclamation-triangle text-warning mr-1"></i>
                                    Email Not Verified
                                </span>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="p-4">

                            {{-- Quick Info --}}
                            <div class="mb-4">
                                <h6 class="font-weight-bold text-dark mb-3">
                                    Personal Information
                                </h6>

                                <div class="profile-info-card">
                                    <div class="profile-info-icon bg-primary-light">
                                        <i class="fas fa-phone-alt text-primary"></i>
                                    </div>

                                    <div>
                                        <small class="text-muted d-block">Phone Number</small>
                                        <strong>{{ $User->phone ?: '-' }}</strong>
                                    </div>
                                </div>

                                <div class="profile-info-card">
                                    <div class="profile-info-icon bg-danger-light">
                                        <i class="fas fa-map-marker-alt text-danger"></i>
                                    </div>

                                    <div>
                                        <small class="text-muted d-block">Address</small>
                                        <strong>{{ $User->address ?: '-' }}</strong>
                                    </div>
                                </div>
                            </div>

                            {{-- Account Status --}}
                            <div class="mb-4">
                                <h6 class="font-weight-bold text-dark mb-3">
                                    Account Status
                                </h6>

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <div class="mini-stat-card">
                                            <h5 class="font-weight-bold text-primary mb-1">
                                                Active
                                            </h5>

                                            <small class="text-muted">
                                                Account Status
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-6 mb-3">
                                        <div class="mini-stat-card">
                                            <h5 class="font-weight-bold text-success mb-1">
                                                {{ $User->email_verified_at ? 'Yes' : 'No' }}
                                            </h5>

                                            <small class="text-muted">
                                                Verified
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Additional Info --}}
                            <div>
                                <h6 class="font-weight-bold text-dark mb-3">
                                    Security
                                </h6>

                                <div class="security-box">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-shield-alt text-success mr-3"></i>

                                        <div>
                                            <strong class="d-block">
                                                Your account is protected
                                            </strong>

                                            <small class="text-muted">
                                                Keep your password secure and never share it.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Form --}}
            <div class="col-lg-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            Account Settings
                        </h5>
                    </div>

                    <div class="card-body p-4">

                        {{-- Email Verification --}}
                        @if (!$User->email_verified_at)
                            <div class="alert alert-warning shadow-sm border-left-warning">
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <div class="mb-2 mb-md-0">
                                        <strong>Email verification required.</strong><br>
                                        Please verify your account before creating a new place.
                                    </div>

                                    <form action="{{ route('verification.send') }}" method="POST">
                                        @csrf
                                        <button class="btn btn-warning btn-sm px-3">
                                            <i class="fas fa-paper-plane mr-1"></i>
                                            Resend Verification
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf

                            {{-- Personal Information --}}
                            <div class="mb-4">
                                <h6 class="font-weight-bold text-dark mb-3">
                                    Personal Information
                                </h6>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-semibold">
                                                Full Name <span class="text-danger">*</span>
                                            </label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-0">
                                                        <i class="fas fa-user text-primary"></i>
                                                    </span>
                                                </div>

                                                <input type="text" name="name" value="{{ old('name', $User->name) }}"
                                                    class="form-control custom-input" placeholder="Enter your name">
                                            </div>

                                            @error('name')
                                                <small class="text-danger d-block mt-2">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-semibold">
                                                Phone Number  <span class="text-danger">*</span>
                                            </label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-0">
                                                        <i class="fas fa-phone text-success"></i>
                                                    </span>
                                                </div>

                                                <input type="text" name="phone"
                                                    value="{{ old('phone', $User->phone) }}"
                                                    class="form-control custom-input" placeholder="Ex: 0812xxxx">
                                            </div>

                                            @error('phone')
                                                <small class="text-danger d-block mt-2">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-semibold">
                                        Address  <span class="text-danger">*</span>
                                    </label>

                                    <textarea name="address" rows="4" class="form-control custom-input" placeholder="Enter your address">{{ old('address', $User->address) }}</textarea>

                                    @error('address')
                                        <small class="text-danger d-block mt-2">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-semibold">
                                        Email Address  <span class="text-danger">*</span>
                                    </label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-0">
                                                <i class="fas fa-envelope text-info"></i>
                                            </span>
                                        </div>

                                        <input type="email" value="{{ $User->email }}" disabled
                                            class="form-control custom-input bg-light">
                                    </div>
                                </div>
                            </div>

                            {{-- Password Section --}}
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-3">
                                    <h6 class="font-weight-bold text-dark mb-0">
                                        Change Password
                                    </h6>

                                    <span class="badge badge-light ml-2">
                                        Optional
                                    </span>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="font-weight-semibold">
                                                Current Password
                                            </label>

                                            <input type="password" name="currpassword" class="form-control custom-input"
                                                placeholder="Enter current password">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-semibold">
                                                New Password
                                            </label>

                                            <input type="password" name="password" class="form-control custom-input"
                                                placeholder="New password">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-semibold">
                                                Confirm Password
                                            </label>

                                            <input type="password" name="password2" class="form-control custom-input"
                                                placeholder="Confirm password">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm">
                                    <i class="fas fa-save mr-2"></i>
                                    Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Custom Style --}}
    @push('style')
        <style>
            .profile-avatar {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                background: linear-gradient(135deg, #4e73df, #224abe);
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 36px;
                font-weight: 700;
                box-shadow: 0 10px 25px rgba(78, 115, 223, .25);
            }

            .custom-input {
                border-radius: 10px;
                border: 1px solid #e3e6f0;
                min-height: 48px;
                transition: .2s ease;
            }

            .custom-input:focus {
                border-color: #4e73df;
                box-shadow: 0 0 0 .15rem rgba(78, 115, 223, .15);
            }

            textarea.custom-input {
                min-height: 120px;
                resize: vertical;
            }

            .input-group-text {
                border-radius: 10px 0 0 10px;
                min-width: 50px;
                justify-content: center;
            }

            .profile-info-item {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 14px;
                font-size: 14px;
                color: #5a5c69;
            }

            .card {
                border-radius: 18px;
                overflow: hidden;
            }

            .btn {
                border-radius: 10px;
                font-weight: 600;
            }

            .badge {
                border-radius: 8px;
                font-size: 12px;
            }

            .border-left-success {
                border-left: 4px solid #1cc88a;
            }

            .border-left-danger {
                border-left: 4px solid #e74a3b;
            }

            .border-left-warning {
                border-left: 4px solid #f6c23e;
            }

            .profile-banner {
                background: linear-gradient(135deg, #4e73df, #224abe);
                padding: 40px 20px 30px;
                border-radius: 18px 18px 0 0;
                position: relative;
            }

            .profile-avatar {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                background: rgba(255, 255, 255, .2);
                backdrop-filter: blur(10px);
                border: 4px solid rgba(255, 255, 255, .3);
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 38px;
                font-weight: 700;
            }

            .profile-info-card {
                display: flex;
                align-items: center;
                gap: 15px;
                padding: 14px;
                border-radius: 14px;
                background: #f8f9fc;
                margin-bottom: 14px;
            }

            .profile-info-icon {
                width: 48px;
                height: 48px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 18px;
            }

            .bg-primary-light {
                background: rgba(78, 115, 223, .12);
            }

            .bg-danger-light {
                background: rgba(231, 74, 59, .12);
            }

            .mini-stat-card {
                background: #f8f9fc;
                border-radius: 14px;
                padding: 18px;
                text-align: center;
                height: 100%;
            }

            .security-box {
                background: #f8f9fc;
                border-radius: 14px;
                padding: 18px;
            }

            @media (max-width: 768px) {
                .text-right {
                    text-align: left !important;
                }

                .btn-primary {
                    width: 100%;
                }
            }
        </style>
    @endpush
@endsection
