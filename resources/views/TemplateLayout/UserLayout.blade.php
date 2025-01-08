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
@endpush

@push('scriptApp')
    {{-- <script src="{{ asset('AdminBS2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('AdminBS2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('AdminBS2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('AdminBS2/js/sb-admin-2.min.js') }}"></script> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <div style="background-color: #24396f; min-height: 100vh;" class="d-flex justify-content-center align-items-center">
        @yield('content')
        @stack('script')
    </div>
@endpush
