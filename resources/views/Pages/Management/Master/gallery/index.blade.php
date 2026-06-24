@extends('TemplateLayout.AdminLayout')

@push('css')
    <style>
        .dropdown-menu {
            border: none;
            border-radius: 14px;
            padding: 14px;
            min-width: 220px;

            box-shadow:
                0 10px 25px rgba(0, 0, 0, .08),
                0 4px 10px rgba(0, 0, 0, .04);

            animation: dropdownFade .18s ease;
        }

        .dropdown-item {
            border-radius: 10px;
        }

        .custom-control {
            border-radius: 10px;
            transition: .15s ease;
        }

        .custom-control:hover {
            background: #f8f9fc;
        }

        @keyframes dropdownFade {
            from {
                opacity: 0;
                transform: translateY(6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Switch container */
        .switch {
            position: relative;
            display: inline-block;
            width: 36px;
            /* lebih kecil */
            height: 20px;
            /* lebih kecil */
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* Slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 20px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 14px;
            /* lebih kecil */
            width: 14px;
            /* lebih kecil */
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        /* Checked state */
        input:checked+.slider {
            background-color: #007bff;
            /* biru primary */
        }

        input:checked+.slider:before {
            transform: translateX(16px);
            /* sesuaikan dengan lebar baru */
        }

        /* Rounded slider */
        .slider.round {
            border-radius: 20px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        #sort-order {
            border-radius: 4px;
            border: 1px solid #dee2e6;
            padding: 0.375rem 2.5rem 0.375rem 0.75rem;
            background-size: 18px;
            appearance: none;
            color: #495057;
            font-size: 0.875rem;
            height: calc(1.5em + 0.75rem + 2px);
        }

        .form-control-sm {
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }

        .form-control-sm:focus,
        #sort-order:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
        }

        .table-responsive {
            border-radius: 4px;
            overflow: hidden;
        }

        #datatable thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
            padding: 12px;
        }

        #datatable tbody tr:hover {
            background-color: #f8f9ff;
        }

        #datatable td {
            padding: 12px;
            vertical-align: middle;
        }

        .dropdown-menu {
            border-radius: 10px;
        }
    </style>
@endpush
@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Management Gallery Admin - QRUN Website</title>
    @endpush
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <h1 class="h3 text-gray-800 font-weight-bold m-2">
            {{ __('messages.management.gallery.title') }}
        </h1>

        {{-- FILTER CARD --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">

                <div>
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{ __('messages.management.common.filters') }}
                    </h6>

                    <small class="text-secondary">
                        {{ __('messages.management.gallery.filter_subtitle') }}
                    </small>
                </div>

                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2 mt-3 mt-md-0">

                    <select class="form-control form-control-sm mr-2" id="sort-order" style="min-width:220px;">

                        <option value="">{{ __('messages.management.common.sort_by') }}</option>
                        <option value="title">{{ __('messages.management.gallery.sort_title') }}</option>
                        <option value="status">{{ __('messages.management.gallery.sort_status') }}</option>
                    </select>

                    <button class="btn btn-outline-secondary btn-sm" id="clear-filters" style="height: calc(1.5em + 0.75rem + 2px); min-width: 140px;">
                        {{ __('messages.management.common.clear_filters') }}
                    </button>
                </div>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="small font-weight-bold text-dark">
                            {{ __('messages.management.gallery.filter_title') }}
                        </label>

                        <input type="text" class="form-control form-control-sm" id="filter-title"
                            placeholder="{{ __('messages.management.common.search') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="small font-weight-bold text-dark">
                            {{ __('messages.management.gallery.filter_status') }}
                        </label>

                        <select class="form-control form-control-sm" id="filter-status">

                            <option value="">{{ __('messages.management.gallery.all_status') }}</option>
                            <option value="active">{{ __('messages.management.common.active') }}</option>
                            <option value="inactive">{{ __('messages.management.common.inactive') }}</option>

                        </select>
                    </div>

                </div>

            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap" style="gap:8px;">

                <div>
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{ __('messages.management.gallery.table_title') }}
                    </h6>

                    <small class="text-secondary">
                        {{ __('messages.management.gallery.table_subtitle') }}
                    </small>
                </div>

                <div class="dropdown">

                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                        id="columnVisibilityDropdown" data-toggle="dropdown">

                        <i class="fas fa-columns mr-1"></i>
                        {{ __('messages.management.common.columns') }}
                    </button>

                    <a class="btn btn-success btn-sm shadow-sm" href="{{ route('gallery.create') }}">

                        <i class="fas fa-plus mr-1"></i>
                        {{ __('messages.management.gallery.add_gallery') }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right p-3 shadow">

                        <div class="custom-control custom-checkbox mb-2">

                            <input type="checkbox" class="custom-control-input toggle-column" id="toggle-title"
                                data-column="0" checked>

                            <label class="custom-control-label" for="toggle-title">
                                {{ __('messages.management.gallery.toggle_title') }}
                            </label>
                        </div>

                        <div class="custom-control custom-checkbox mb-2">

                            <input type="checkbox" class="custom-control-input toggle-column" id="toggle-image"
                                data-column="1" checked>

                            <label class="custom-control-label" for="toggle-image">
                                {{ __('messages.management.gallery.toggle_image') }}
                            </label>
                        </div>

                        <div class="custom-control custom-checkbox mb-2">

                            <input type="checkbox" class="custom-control-input toggle-column" id="toggle-status"
                                data-column="2" checked>

                            <label class="custom-control-label" for="toggle-status">
                                {{ __('messages.management.gallery.toggle_status') }}
                            </label>
                        </div>

                    </div>
                </div>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-striped table-hover table-bordered" id="datatable" width="100%">

                        <thead class="thead-light">

                            <tr>
                                <th>{{ __('messages.management.gallery.col_title') }}</th>
                                <th>{{ __('messages.management.gallery.col_image') }}</th>
                                <th>{{ __('messages.management.gallery.col_status') }}</th>
                                <th class="text-center">{{ __('messages.management.common.action') }}</th>
                            </tr>

                        </thead>

                        <tbody></tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
    <!-- /.container-fluid -->

    @push('script')
        <script>
            const i18nGallery = {
                swalTitle:   @json(__('messages.management.common.swal_are_you_sure')),
                swalText:    @json(__('messages.management.gallery.swal_delete_text')),
                swalConfirm: @json(__('messages.management.common.swal_yes_delete')),
                swalCancel:  @json(__('messages.management.common.swal_no_cancel')),
                minColumn:   @json(__('messages.management.common.min_column_warning')),
            };

            function toggleStatus(id) {
                $.ajax({
                    type: "POST",
                    url: "/management/master/gallery/" + id + "/toggle-status",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: response.success,
                                text: response.success,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            $('#datatable').DataTable().ajax.reload();
                        } else if (response.errors) {
                            Swal.fire({
                                title: response.errors,
                                text: response.errors,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }

            $(document).ready(function() {

                // Prevent dropdown close when clicking inside
                $('.dropdown-menu').on('click', function(e) {
                    e.stopPropagation();
                });

                const STORAGE_KEY = 'gallery_table_column_visibility';

                const table = $('#datatable').DataTable({

                    createdRow: function(row, data, dataIndex) {

                        $('td:eq(0)', row).css('min-width', '220px');
                        $('td:eq(1)', row).css('min-width', '180px');
                        $('td:eq(2)', row).css('min-width', '140px');

                        $('td:last', row).css({
                            'text-align': 'center',
                            'vertical-align': 'middle',
                            'min-width': '180px'
                        });
                    },

                    filter: true,
                    processing: true,
                    serverSide: true,
                    order: [],
                    dom: '<"top"<"dataTables_length"l><"dataTables_filter"f>>rt<"bottom"<"dataTables_info"i><"dataTables_paginate"p>>',

                    ajax: {
                        url: "{{ route('gallery.index') }}",
                        dataSrc: function(json) {

                            let data = json.data || json;

                            let title = $('#filter-title').val().toLowerCase();
                            let status = $('#filter-status').val();

                            if (title) {
                                data = data.filter(item =>
                                    item.title?.toLowerCase().includes(title)
                                );
                            }

                            if (status) {

                                data = data.filter(item => {

                                    if (status === 'active') {
                                        return item.status?.includes('checked');
                                    }

                                    if (status === 'inactive') {
                                        return !item.status?.includes('checked');
                                    }

                                    return true;
                                });
                            }

                            return data;
                        }
                    },

                    columns: [{
                            data: 'title',
                            name: 'title'
                        },
                        {
                            data: 'image_url',
                            name: 'image_url',
                            defaultContent: '-'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
                        }
                    ]
                });

                // =========================
                // FILTER
                // =========================

                function debounce(func, delay) {

                    let timer;

                    return function(...args) {

                        clearTimeout(timer);

                        timer = setTimeout(() => {
                            func.apply(this, args);
                        }, delay);
                    };
                }

                const reloadTableDebounced = debounce(function() {
                    table.ajax.reload();
                }, 400);

                $('#filter-title').on('keyup', function() {
                    reloadTableDebounced();
                });

                $('#filter-status').on('change', function() {
                    table.ajax.reload();
                });

                // =========================
                // SORT
                // =========================

                $('#sort-order').on('change', function() {

                    let value = $(this).val();

                    if (value === 'title') {

                        table.order([0, 'asc']).draw();

                    } else if (value === 'status') {

                        table.order([2, 'asc']).draw();

                    } else {

                        table.order([]).draw();
                    }
                });

                // =========================
                // CLEAR FILTER
                // =========================

                $('#clear-filters').on('click', function() {

                    $('#filter-title').val('');
                    $('#filter-status').val('');
                    $('#sort-order').val('');

                    table.ajax.reload();
                });

                // =========================
                // COLUMN VISIBILITY
                // =========================

                function saveColumnState() {

                    let state = {};

                    $('.toggle-column').each(function() {

                        const columnIndex = $(this).data('column');

                        state[columnIndex] = $(this).is(':checked');
                    });

                    localStorage.setItem(
                        STORAGE_KEY,
                        JSON.stringify(state)
                    );
                }

                function applySavedColumnState() {

                    const saved =
                        JSON.parse(
                            localStorage.getItem(STORAGE_KEY)
                        ) || {};

                    $('.toggle-column').each(function() {

                        const columnIndex =
                            $(this).data('column');

                        const isVisible =
                            saved[columnIndex] ?? true;

                        $(this).prop(
                            'checked',
                            isVisible
                        );

                        table
                            .column(columnIndex)
                            .visible(
                                isVisible,
                                false
                            );
                    });

                    table.columns.adjust().draw(false);
                }

                $('.toggle-column').on(
                    'change',
                    function(e) {

                        e.stopPropagation();

                        const checkedColumns =
                            $('.toggle-column:checked').length;

                        if (checkedColumns === 0) {

                            $(this).prop(
                                'checked',
                                true
                            );

                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'warning',
                                title: i18nGallery.minColumn,
                                showConfirmButton: false,
                                timer: 1800
                            });

                            return;
                        }

                        const columnIndex =
                            $(this).data('column');

                        const isVisible =
                            $(this).is(':checked');

                        table
                            .column(columnIndex)
                            .visible(isVisible);

                        saveColumnState();
                    }
                );

                applySavedColumnState();

                // =========================
                // DELETE
                // =========================

                $(document).on('click', '.delete', function(e) {

                    e.preventDefault();

                    var id = $(this).attr('id');

                    Swal.fire({
                        customClass: {
                            confirmButton: "btn btn-success",
                            cancelButton: "btn btn-danger"
                        },
                        title: i18nGallery.swalTitle,
                        text: i18nGallery.swalText,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: i18nGallery.swalConfirm,
                        cancelButtonText: i18nGallery.swalCancel,
                        reverseButtons: true
                    }).then((result) => {

                        if (result.isConfirmed) {

                            $.ajax({

                                type: "DELETE",

                                url: "/management/master/gallery/" + id + "/delete",

                                dataType: "json",

                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },

                                success: function(response) {

                                    if (response.success) {

                                        Swal.fire({
                                            title: response.success,
                                            text: response.success,
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        });

                                        table.ajax.reload();

                                    } else if (response.errors) {

                                        Swal.fire({
                                            title: response.errors,
                                            text: response.errors,
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                },

                                error: function(err) {
                                    console.log(err);
                                }
                            });
                        }
                    });
                });

            });
        </script>
    @endpush
    <!-- End of Main Content -->
@endsection
