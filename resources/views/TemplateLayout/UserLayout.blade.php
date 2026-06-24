@extends('Layout.App')

@push('mainTitle')
    @stack('title')
@endpush

@push('css')
    <!-- Custom fonts for this template-->
    <link href="{{ asset('AdminBS2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('AdminBS2/css/sb-admin-2.min.css') }}" rel="stylesheet">
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('transparent-logo.png') }}">

    <style>
        .login-wrapper {
            position: relative;
            min-height: 100vh;
            overflow: hidden;

            background: linear-gradient(180deg,
                    #2d4373 0%,
                    #24396f 100%);
        }

        .wave {
            position: absolute;
            bottom: 0;
            left: 0;

            width: 100%;
            height: 300px;

            background:
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23ffffff12' fill-opacity='1' d='M0,224L60,224C120,224,240,224,360,192C480,160,600,96,720,90.7C840,85,960,139,1080,149.3C1200,160,1320,128,1380,112L1440,96L1440,320L0,320Z'%3E%3C/path%3E%3C/svg%3E");

            background-size: cover;
            background-repeat: no-repeat;

            pointer-events: none;
        }

        .wave-footer {
            position: absolute;

            bottom: 20px;
            left: 50%;

            transform: translateX(-50%);

            color: rgba(255, 255, 255, .75);

            font-size: 13px;
            font-weight: 500;

            text-align: center;

            width: 100%;
        }

        .back-home-btn {
            position: fixed;
            top: 24px;
            left: 24px;
            z-index: 9999;

            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 12px 18px;

            background: rgba(255, 255, 255, .92);
            border: 1px solid rgba(0, 0, 0, .06);
            border-radius: 14px;

            color: #2d4373;
            text-decoration: none;

            font-size: 14px;
            font-weight: 700;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, .08);

            transition: all .25s ease;
        }

        .back-home-btn:hover {
            text-decoration: none;
            color: #1f3260;

            transform: translateY(-2px);

            background: #ffffff;

            box-shadow:
                0 14px 40px rgba(0, 0, 0, .12);
        }

        .back-home-btn i {
            font-size: 13px;
        }

        @media (max-width: 576px) {
            .back-home-btn {
                top: 16px;
                left: 16px;

                padding: 10px 14px;
                font-size: 13px;
                border-radius: 12px;
            }
        }

        @media (max-width: 768px) {
            .wave {
                height: 200px;
            }
        }

        @media (max-width: 576px) {
            .wave {
                height: 100px;
            }
        }
    </style>
@endpush

@push('scriptApp')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{ asset('AdminBS2/vendor/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('AdminBS2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('AdminBS2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('AdminBS2/js/sb-admin-2.min.js') }}"></script>
    <!-- Page level plugins -->
    <script src="{{ asset('AdminBS2/vendor/chart.js/Chart.min.js') }}"></script>
    <!-- Page level custom scripts -->
    <script src="{{ asset('AdminBS2/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('AdminBS2/js/demo/chart-pie-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
@endpush

@push('scriptApp')
    <div class="login-wrapper d-flex justify-content-center align-items-center">
        <!-- Back to Home Button -->
        <a href="{{ url('/') }}" class="back-home-btn">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Home
        </a>
        <div class="wave">
            <div class="wave-footer">
                © {{ date('Y') }} QRUN Online. All rights reserved.
            </div>

        </div>

        @yield('content')

    </div>

    @stack('script')
@endpush
