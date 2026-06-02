@extends('Layout.App')

@push('mainTitle')
    @stack('title')
@endpush

@push('css')
    <link href="{{ asset('AdminBS2/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('transparent-logo.png') }}">

    <style>
        img {
            max-width: 100%;
        }
    </style>
@endpush

@push('scriptApp')
    @yield('content');

      <!-- Insert Jquery Min Js -->
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
  
      {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}
      
    @stack('script')
@endpush
