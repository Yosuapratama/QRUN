@extends('Layout.App')

@push('mainTitle')
    @stack('title')
@endpush

@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Custom fonts for this template-->
    <link href="{{ asset('AdminBS2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('AdminBS2/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
  
    {{-- <link rel="stylesheet" href="//cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css"> --}}

    <style>
        .sorting {
            position: relative;
        }

        .sorting::before {
            position: absolute;
            content: '';
            right: 10px;
            width: 10px;
            height: 10px;
            bottom: 25px;
            clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
            background-color: rgba(0, 0, 0, 0.331);
        }

        .sorting::after {
            position: absolute;
            right: 10px;
            width: 10px;
            bottom: 10px;
            clip-path: polygon(50% 100%, 0 0, 100% 0);
            height: 10px;
            content: '';
            background-color: rgba(0, 0, 0, 0.331);
        }

        .sorting_desc {
            position: relative;
        }

        .sorting_desc::after {
            position: absolute;
            right: 10px;
            width: 10px;
            bottom: 10px;
            clip-path: polygon(50% 100%, 0 0, 100% 0);
            height: 10px;
            content: '';
            background-color: red;
        }

        .sorting_desc::before {
            position: absolute;
            content: '';
            right: 10px;
            width: 10px;
            height: 10px;
            bottom: 25px;
            clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
            background-color: rgba(0, 0, 0, 0.331);
        }

        .sorting_asc {
            position: relative;
        }

        .sorting_asc::after {
            position: absolute;
            right: 10px;
            width: 10px;
            bottom: 25px;
            clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
            height: 10px;
            content: '';
            background-color: red;
        }

        .sorting_asc::before {
            position: absolute;
            right: 10px;
            width: 10px;
            bottom: 10px;
            clip-path: polygon(50% 100%, 0 0, 100% 0);
            height: 10px;
            content: '';
            background-color: rgba(0, 0, 0, 0.331);
        }

        .note-editor.note-airframe .note-editing-area .note-editable,
        .note-editor.note-frame .note-editing-area .note-editable {
            background-color: white !important;
        }
    </style>
@endpush

@push('scriptApp')
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

    <!-- Jquery Datatable Imports -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

    {{-- SummerNote Import --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet"> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script> --}}

    {{-- <link src="{{asset('summernote-0.9.0-dist/summernote.min.css')}}"> --}}
      {{-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet"> --}}
      
      {{-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
      <script src="{{asset('summernote-0.9.0-dist/summernote.js')}}"></script> --}}

    {{-- <link href="{{asset('summernote-0.9.0-dist/summernote-bs5.css')}}" rel="stylesheet"> --}}
    <script src="{{asset('summernote-0.9.0-dist/summernote-bs5.js')}}"></script>

      {{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script> --}}

    {{-- Import SweetAlert Notification --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


    @stack('script')
@endpush

@section('contentApp')
    <!-- Page Wrapper -->
    <div id="page-top">
        <div id="wrapper">
            @include('Components.Modal')
            @include('Components.Sidebar')
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    @include('Components.TopBar')
                    @yield('content')
                </div>
                @include('Components.Footer')
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="">Logout</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
