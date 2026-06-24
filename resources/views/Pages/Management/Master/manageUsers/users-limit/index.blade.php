@extends('TemplateLayout.AdminLayout')

@section('content')
    @push('title')
        <title>Management Users Limit Admin - QRUN Website</title>
    @endpush

    @push('css')
        <style>
            #sort-order {
                border-radius: 4px;
                border: 1px solid #dee2e6;
                padding: 0.375rem 2.5rem 0.375rem 0.75rem;
                background: #fff url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%234e73df%22%3e%3cpath d=%22M7 10l5 5 5-5z%22/%3e%3c/svg%3e') no-repeat right 10px center;
                background-size: 18px;
                appearance: none;
                color: #495057;
                font-size: 0.875rem;
                height: calc(1.5em + 0.75rem + 2px);
                transition: all 0.3s ease;
            }

            #sort-order:hover {
                border-color: #4e73df;
                background-color: #f8f9ff;
            }

            #sort-order:focus,
            .form-control-sm:focus,
            .select2-container--default .select2-selection--single:focus {
                outline: none;
                border-color: #4e73df;
                box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
            }

            .form-control-sm {
                border-radius: 4px;
                border: 1px solid #dee2e6;
                transition: all 0.3s ease;
            }

            #clear-filters {
                border-radius: 4px;
                border: 1px solid #dee2e6;
                transition: all 0.3s ease;
                font-weight: 500;
            }

            #clear-filters:hover {
                background-color: #4e73df;
                color: white;
                border-color: #4e73df;
            }

            .table-responsive {
                border-radius: 4px;
                overflow: hidden;
            }

            #datatable {
                border-collapse: collapse;
                width: 100%;
            }

            #datatable thead th {
                background-color: #f8f9fa;
                border-bottom: 2px solid #dee2e6;
                font-weight: 600;
                color: #495057;
                padding: 12px;
            }

            #datatable tbody tr {
                border-bottom: 1px solid #dee2e6;
            }

            #datatable tbody tr:hover {
                background-color: #f8f9ff;
            }

            #datatable td {
                padding: 12px;
                vertical-align: middle;
            }

            .dataTables_processing {
                color: #4e73df;
                font-weight: 600;
                font-size: 1rem;
                position: relative;
                display: flex !important;
                align-items: center;
                justify-content: center;
                gap: 15px;
                padding: 20px;
            }

            .dataTables_info {
                padding-top: 1rem;
                color: #858796;
                font-size: 0.875rem;
            }

            .dropdown-menu .custom-control-label {
                cursor: pointer;
                user-select: none;
            }

            .dropdown-menu {
                border-radius: 10px;
            }

            .toggle-column:disabled+.custom-control-label {
                opacity: 0.5;
                cursor: not-allowed;
            }

            .btn-action {
                width: 36px;
                height: 36px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 10px;
                transition: all 0.2s ease;
            }

            .btn-action:hover {
                transform: translateY(-1px);
            }

            .select2-container .select2-selection--single {
                height: calc(1.5em + 0.75rem + 2px) !important;
                border: 1px solid #dee2e6 !important;
                border-radius: 4px !important;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 36px !important;
                font-size: 0.875rem;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 34px !important;
            }
        </style>
    @endpush

    <div class="container-fluid">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
            <div>
                <h1 class="h3 text-gray-800 font-weight-bold mb-1">
                    {{ __('messages.management.users_limit.title') }}
                </h1>

                <p class="text-muted mb-0 small">
                    {{ __('messages.management.users_limit.subtitle') }}
                </p>
            </div>
        </div>

        {{-- FILTER CARD --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">

                <div>
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{ __('messages.management.common.filters') }}
                    </h6>

                    <small class="text-secondary">
                        {{ __('messages.management.users_limit.filter_subtitle') }}
                    </small>
                </div>

                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2 mt-3 mt-md-0">

                    <select class="form-control form-control-sm" id="sort-order" style="min-width: 220px;">

                        <option value="">{{ __('messages.management.common.sort_by') }}</option>
                        <option value="email">{{ __('messages.management.users_limit.sort_email') }}</option>
                        <option value="place">{{ __('messages.management.users_limit.sort_place') }}</option>
                        <option value="updated_at">{{ __('messages.management.users_limit.sort_updated_at') }}</option>
                    </select>

                    <button class="btn btn-outline-secondary btn-sm" id="clear-filters"
                        style="height: calc(1.5em + 0.75rem + 2px); min-width: 140px;">

                        {{ __('messages.management.common.clear_filters') }}
                    </button>
                </div>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="small font-weight-bold text-dark">
                            {{ __('messages.management.users_limit.filter_email') }}
                        </label>

                        <input type="text" class="form-control form-control-sm" id="filter-email"
                            placeholder="{{ __('messages.management.common.search') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="small font-weight-bold text-dark">
                            {{ __('messages.management.users_limit.filter_place') }}
                        </label>

                        <input type="text" class="form-control form-control-sm" id="filter-place"
                            placeholder="{{ __('messages.management.common.search') }}">
                    </div>

                </div>

            </div>

        </div>

        {{-- TABLE CARD --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">

                <div>
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{ __('messages.management.users_limit.table_title') }}
                    </h6>

                    <small class="text-secondary">
                        {{ __('messages.management.users_limit.table_subtitle') }}
                    </small>
                </div>

                <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
                    {{-- COLUMN VISIBILITY --}}
                    <div class="dropdown">

                        <button class="mr-2 btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                            id="columnVisibilityDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            <i class="fas fa-columns mr-1"></i>
                            {{ __('messages.management.common.columns') }}
                        </button>

                        <div class="dropdown-menu dropdown-menu-right p-3 shadow" aria-labelledby="columnVisibilityDropdown"
                            style="min-width: 230px;">

                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-email"
                                    data-column="0" checked>

                                <label class="custom-control-label" for="toggle-email">
                                    {{ __('messages.management.users_limit.col_email') }}
                                </label>
                            </div>

                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-place"
                                    data-column="1" checked>

                                <label class="custom-control-label" for="toggle-place">
                                    {{ __('messages.management.users_limit.col_place') }}
                                </label>
                            </div>

                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-updated"
                                    data-column="2" checked>

                                <label class="custom-control-label" for="toggle-updated">
                                    {{ __('messages.management.users_limit.col_updated_at') }}
                                </label>
                            </div>

                            {{-- <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-action"
                                    data-column="3" checked>

                                <label class="custom-control-label" for="toggle-action">
                                    Action
                                </label>
                            </div> --}}

                        </div>

                    </div>
                    {{-- ADD BUTTON --}}
                    <button class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="modal"
                        data-bs-target="#addUserhasLimitModal">

                        <i class="fas fa-plus-circle mr-1"></i>
                        {{ __('messages.management.users_limit.add_btn') }}
                    </button>

                </div>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-striped table-hover table-bordered" id="datatable" width="100%"
                        cellspacing="0">

                        <thead class="thead-light">
                            <tr>
                                <th>{{ __('messages.management.users_limit.col_email') }}</th>
                                <th>{{ __('messages.management.users_limit.col_place') }}</th>
                                <th>{{ __('messages.management.users_limit.col_updated_at') }}</th>
                                <th class="text-center">{{ __('messages.management.common.action') }}</th>
                            </tr>
                        </thead>

                        <tbody></tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    @push('script')
        <script>
            const i18nUsersLimit = {
                swalTitle:   @json(__('messages.management.common.swal_are_you_sure')),
                swalConfirm: @json(__('messages.management.common.swal_yes_delete')),
                swalCancel:  @json(__('messages.management.common.swal_no_cancel')),
                deleteText:  @json(__('messages.management.users_limit.swal_delete_text')),
                minColumn:   @json(__('messages.management.common.min_column_warning')),
            };

            $(document).ready(function() {

                $('#columnVisibilityDropdown')
                    .siblings('.dropdown-menu')
                    .on('click', function(e) {
                        e.stopPropagation();
                    });

                function debounce(func, delay) {
                    let timer;

                    return function(...args) {
                        clearTimeout(timer);

                        timer = setTimeout(() => {
                            func.apply(this, args);
                        }, delay);
                    };
                }

                function initSelect2() {

                    $("#find-user").select2({
                        dropdownParent: $("#addUserhasLimitModal")
                    });

                    $("#find_place_limit").select2({
                        dropdownParent: $("#addUserhasLimitModal")
                    });

                    $("#find-user-edit").select2({
                        dropdownParent: $("#editUserhasLimitModal")
                    });

                    $("#find_place_limit_edit").select2({
                        dropdownParent: $("#editUserhasLimitModal")
                    });
                }

                function fetchData() {

                    $('#find_place_limit').empty();
                    $('#find-user').empty();

                    $('#find_place_limit').append(
                        '<option value="">Select place limit</option>'
                    );

                    $('#find-user').append(
                        '<option value="">Select user email</option>'
                    );

                    $.ajax({
                        url: "{{ route('users-limit.fetch') }}",
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },

                        success: function(response) {

                            response.place_limit.map((item) => {

                                $('#find_place_limit').append(
                                    `<option value="${item.id}">${item.name}</option>`
                                );
                            });

                            response.users.map((item) => {

                                $('#find-user').append(
                                    `<option value="${item.email}">${item.email}</option>`
                                );
                            });
                        },

                        error: function(xhr, status, error) {

                            Swal.fire({
                                title: 'Failed to Fetch Data',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }

                function fetchEditData(id) {

                    $('#find_place_limit_edit').empty();
                    $('#find-user-edit').empty();

                    $('#find_place_limit_edit').append(
                        '<option value="">Select place limit</option>'
                    );

                    $('#find-user-edit').append(
                        '<option value="">Select user email</option>'
                    );

                    $('#editUserHasLimitiD').val('');

                    $.ajax({
                        url: "{{ route('users-limit.getData', ':id') }}"
                            .replace(':id', id),

                        method: 'GET',

                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },

                        success: function(response) {

                            let place_limit_id = response.data.place_limit_id;
                            let user_email = response.data.user.email;

                            $('#editUserHasLimitiD').val(response.data.id);

                            response.place_limit.map((item) => {

                                $('#find_place_limit_edit').append(
                                    `
                                        <option value="${item.id}"
                                            ${item.id == place_limit_id ? 'selected' : ''}>
                                            ${item.name}
                                        </option>
                                    `
                                );
                            });

                            $('#find-user-edit').append(
                                `
                                    <option value="${user_email}" selected>
                                        ${user_email}
                                    </option>
                                `
                            );
                        },

                        error: function(xhr, status, error) {

                            Swal.fire({
                                title: 'Failed to Fetch Data',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }

                initSelect2();
                fetchData();

                let datatable = $('#datatable').DataTable({

                    createdRow: function(row, data, dataIndex) {

                        $('td:eq(0)', row).css('min-width', '260px');
                        $('td:eq(1)', row).css('min-width', '220px');
                        $('td:eq(2)', row).css('min-width', '180px');

                          // last column (Action)
                        $('td:last', row).css({
                            'text-align': 'center',
                            'vertical-align': 'middle',
                            'min-width': '140px'
                        });
                    },

                    filter: true,
                    processing: true,
                    serverSide: true,
                    order: [],

                    dom: '<"top"<"dataTables_length"l><"dataTables_filter"f>><"table-responsive-wrapper"rt><"bottom"<"dataTables_info"i><"dataTables_paginate"p>>',

                    ajax: {
                        url: "{{ route('users-limit.index') }}",

                        data: function(d) {

                            d.email = $('#filter-email').val();
                            d.place = $('#filter-place').val();
                            d.sort_by = $('#sort-order').val();
                        }
                    },

                    columns: [{
                            data: 'user.email',
                            name: 'user.email',
                            orderable: true
                        },
                        {
                            data: 'place_name',
                            name: 'place_name',
                            defaultContent: '-'
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
                        }
                    ]
                });

                // =========================
                // FILTERS
                // =========================

                const reloadTableDebounced = debounce(function() {
                    datatable.ajax.reload();
                }, 500);

                $('#filter-email, #filter-place')
                    .on('keyup', function() {
                        reloadTableDebounced();
                    });

                $('#sort-order').on('change', function() {

                    let value = $(this).val();

                    if (value === 'email') {

                        datatable.order([0, 'asc']).draw();

                    } else if (value === 'place') {

                        datatable.order([1, 'asc']).draw();

                    } else if (value === 'updated_at') {

                        datatable.order([2, 'desc']).draw();

                    } else {

                        datatable.order([]).draw();
                    }

                    datatable.ajax.reload();
                });

                $('#clear-filters').on('click', function() {

                    $('#filter-email').val('');
                    $('#filter-place').val('');
                    $('#sort-order').val('');

                    datatable.ajax.reload();
                });

                // =========================
                // COLUMN VISIBILITY
                // =========================

                const STORAGE_KEY = 'users_limit_column_visibility';

                const defaultColumns = {
                    0: true,
                    1: true,
                    2: true,
                    3: true
                };

                function getSavedColumnState() {

                    const saved = localStorage.getItem(STORAGE_KEY);

                    if (!saved) {
                        return defaultColumns;
                    }

                    try {

                        return {
                            ...defaultColumns,
                            ...JSON.parse(saved)
                        };

                    } catch (e) {

                        return defaultColumns;
                    }
                }

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

                function updateColumnCheckboxState() {

                    const checkedCount = $('.toggle-column:checked').length;

                    $('.toggle-column').prop('disabled', false);

                    if (checkedCount <= 1) {

                        $('.toggle-column:checked')
                            .prop('disabled', true);
                    }
                }

                function applySavedColumnState() {

                    const savedState = getSavedColumnState();

                    $('.toggle-column').each(function() {

                        const columnIndex = $(this).data('column');
                        const isVisible = savedState[columnIndex] ?? true;

                        $(this).prop('checked', isVisible);

                        datatable
                            .column(columnIndex)
                            .visible(isVisible, false);
                    });

                    datatable.columns.adjust().draw(false);

                    updateColumnCheckboxState();
                }

                $('.toggle-column').on('change', function() {

                    const columnIndex = $(this).data('column');
                    const isVisible = $(this).is(':checked');

                    datatable
                        .column(columnIndex)
                        .visible(isVisible);

                    saveColumnState();

                    updateColumnCheckboxState();
                });

                applySavedColumnState();

                // =========================
                // PROCESSING STATE
                // =========================

                $(document).on('processing.dt', function(e, settings, processing) {

                    if (processing) {

                        $('.dataTables_processing').addClass('show');

                    } else {

                        $('.dataTables_processing').removeClass('show');
                    }
                });

                // =========================
                // CREATE
                // =========================

                $(document).on('submit', '#addUserHasPlaceLimit', function(e) {

                    e.preventDefault();

                    $.ajax({
                        type: "POST",
                        url: "{{ route('users-limit.store') }}",
                        data: $(this).serialize(),
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

                                $('#addUserhasLimitModal').modal('hide');

                                $("#addUserHasPlaceLimit")[0].reset();

                                datatable.ajax.reload();

                                fetchData();

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
                });

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

                        title: i18nUsersLimit.swalTitle,
                        text: i18nUsersLimit.deleteText,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: i18nUsersLimit.swalConfirm,
                        cancelButtonText: i18nUsersLimit.swalCancel,
                        reverseButtons: true

                    }).then((result) => {

                        if (result.isConfirmed) {

                            $.ajax({
                                type: "POST",
                                url: "/management/master/users-limit/" + id + "/delete",
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

                                        datatable.ajax.reload();

                                    } else if (response.errors) {

                                        Swal.fire({
                                            title: response.errors,
                                            text: response.errors,
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    }

                                    fetchData();
                                },

                                error: function(err) {
                                    console.log(err);
                                }
                            });
                        }
                    });
                });

                // =========================
                // EDIT
                // =========================

                $(document).on('click', '.edit', function(e) {

                    e.preventDefault();

                    var id = $(this).attr('id');

                    fetchEditData(id);

                    $('#editUserhasLimitModal').modal('show');
                });

                $(document).on('submit', '#editUserHasPlaceLimit', function(e) {

                    e.preventDefault();

                    $.ajax({
                        type: "POST",
                        url: "{{ route('users-limit.update') }}",
                        data: $(this).serialize(),
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

                                $('#editUserhasLimitModal').modal('hide');

                                $("#editUserHasPlaceLimit")[0].reset();

                                datatable.ajax.reload();

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
                });

            });
        </script>
    @endpush
@endsection
