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
            background-color: #4e73df;
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
            background-color: #4e73df;
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

        .select2-container .select2-selection--single {
            height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 35px !important;
        }

        .dataTables_filter {
            display: flex;
            justify-content: end;
            align-items: center;
        }

        .dataTables_length {
            height: 100%;
            display: flex;
            justify-content: start;
            align-items: center;
            margin-right: 10px;
        }

        /* DataTables Processing Spinner */
        .dataTables_processing {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: auto;
            margin-left: 0;
            padding: 30px 40px;
            background: rgba(255, 255, 255, 0.98);
            border: 2px solid #4e73df;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            z-index: 1050 !important;
            color: #4e73df;
            font-weight: 600;
            font-size: 1rem;
            display: flex !important;
            align-items: center;
            justify-content: center;
            gap: 15px;
            padding: 20px;
        }

        .dataTables_processing.show {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .dataTables_processing::after {
            content: '';
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #4e73df;
            border-radius: 50%;
            flex-shrink: 0;
            animation: processingSpinner 1s linear infinite;
        }

        @keyframes processingSpinner {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Pagination Styling */
        .dataTables_paginate {
            padding-top: 1rem;
            text-align: left;
        }

        .dataTables_paginate .pagination {
            margin: 0;
            padding: 0;
        }

        .dataTables_paginate .pagination .page-item {
            margin: 0 3px;
        }

        .dataTables_paginate .pagination .page-link {
            border-radius: 4px;
            padding: 6px 12px;
            border: 1px solid #dee2e6;
            color: #4e73df;
            transition: all 0.3s ease;
        }

        .dataTables_paginate .pagination .page-link:hover {
            background-color: #4e73df;
            color: white;
            border-color: #4e73df;
        }

        .dataTables_paginate .pagination .page-item.active .page-link {
            background-color: #4e73df;
            border-color: #4e73df;
            color: white;
        }

        .dataTables_paginate .pagination .page-item.disabled .page-link {
            color: #ccc;
            border-color: #dee2e6;
        }

        /* Show Entries Select Styling */
        .dataTables_length select {
            border-radius: 4px;
            border: 1px solid #dee2e6;
            padding: 6px 30px 6px 12px;
            background: white url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%224e73df%22%3e%3cpath d=%22M7 10l5 5 5-5z%22/%3e%3c/svg%3e') no-repeat right 8px center;
            background-size: 20px;
            appearance: none;
            color: #495057;
            font-size: 0.875rem;
            cursor: pointer;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .dataTables_length select:hover {
            border-color: #4e73df;
        }

        .dataTables_length select:focus {
            outline: none;
            border-color: #4e73df;
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
        }

        /* Select2 Custom Styling */
        .select2-container--default .select2-selection--single {
            border-radius: 4px;
            border: 1px solid #dee2e6;
            box-shadow: none;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #4e73df;
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
        }

        .select2-dropdown {
            border-color: #4e73df;
            border-radius: 4px;
        }

        .select2-results__option--highlighted {
            background-color: #4e73df;
        }
    </style>
@endpush

@push('css')
    <style>
        #dataTablePlace_filter {
            display: flex;
            justify-content: right;
            align-items: center;

        }

        #dataTablePlace_filter>label {
            justify-content: center;
            gap: 10px;
            display: flex;
            align-items: center;

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
    <!--<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">-->
    <!--<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>-->
    <link href="{{ asset('summernote-0.9.0-dist/summernote-bs4.css') }}" rel="stylesheet">
    <script src="{{ asset('summernote-0.9.0-dist/summernote-bs4.js') }}"></script>

    {{-- Import SweetAlert Notification --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


    @stack('script')
    <script>
        $(document).ready(function() {
            function handleSidebarMobile() {
                if ($(window).width() <= 768) {
                    $('body').addClass('sidebar-toggled');
                    $('.sidebar').addClass('toggled');
                } else {
                    $('body').removeClass('sidebar-toggled');
                    $('.sidebar').removeClass('toggled');
                }
            }

            // Run on first load
            handleSidebarMobile();

            // Run on resize
            $(window).on('resize', function() {
                handleSidebarMobile();
            });

            // Global DataTables processing handler
            $(document).on('processing.dt', function(e, settings, processing) {
                const tableId = settings.nTable.id;

                if (!tableId) return;

                const processingElement = $('#' + tableId + '_processing');

                if (processing) {
                    processingElement
                        .addClass('show')
                        .css({
                            'display': 'flex',
                            'visibility': 'visible',
                            'opacity': '1'
                        });
                } else {
                    processingElement
                        .removeClass('show')
                        .css({
                            'display': 'none',
                            'visibility': 'hidden',
                            'opacity': '0'
                        });
                }
            });

        });
    </script>
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
