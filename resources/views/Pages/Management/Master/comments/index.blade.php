@extends('TemplateLayout.AdminLayout')

@section('content')
    @push('title')
        <title>Management Comments Admin - QRUN Website</title>
    @endpush

    <div class="container-fluid">

        {{-- PAGE TITLE --}}
        <h1 class="h3 text-gray-800 font-weight-bold m-2">
            @lang('messages.navigation_admin.manage_comments.manage_comments')
        </h1>

        {{-- FILTER CARD --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">

                <div>
                    <h6 class="m-0 font-weight-bold text-primary">
                        Filters
                    </h6>

                    <small class="text-secondary">
                        Filter comments by email, rating, place code, and date.
                    </small>
                </div>

                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2 mt-3 mt-md-0">

                    <select class="form-control form-control-sm mr-2" id="sort-order"
                        style="min-width:220px;">

                        <option value="">Sort By</option>
                        <option value="email">Email</option>
                        <option value="rating">Rating</option>
                        <option value="updated_at">Updated At</option>
                    </select>

                    <button class="btn btn-outline-secondary btn-sm" id="clear-filters" style="height: calc(1.5em + 0.75rem + 2px); min-width: 140px;">

                        Clear Filters
                    </button>
                </div>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold text-dark">
                            Email
                        </label>

                        <input type="text"
                            class="form-control form-control-sm"
                            id="filter-email"
                            placeholder="Search email">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold text-dark">
                            Place Code
                        </label>

                        <input type="text"
                            class="form-control form-control-sm"
                            id="filter-place-code"
                            placeholder="Search place code">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold text-dark">
                            Rating
                        </label>

                        <select class="form-control form-control-sm" id="filter-rating">

                            <option value="">All Rating</option>

                            <option value="5">5 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="2">2 Stars</option>
                            <option value="1">1 Star</option>
                            <option value="0">No Rating</option>

                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold text-dark">
                            Updated Date
                        </label>

                        <input type="date"
                            class="form-control form-control-sm"
                            id="filter-date">
                    </div>

                </div>

            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap" style="gap:6px;">

                <div>

                    <h6 class="m-0 font-weight-bold text-primary">
                        Comments Table
                    </h6>

                    <small class="text-secondary">
                        Manage all comments and moderation actions here.
                    </small>

                </div>

                <div class="dropdown mr-2">

                    <button class="btn btn-outline-primary btn-sm dropdown-toggle"
                        type="button"
                        id="columnVisibilityDropdown"
                        data-toggle="dropdown">

                        <i class="fas fa-columns mr-1"></i>
                        Columns
                    </button>

                    <div class="dropdown-menu dropdown-menu-right p-3 shadow">

                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox"
                                class="custom-control-input toggle-column"
                                id="toggle-email"
                                data-column="0"
                                checked>

                            <label class="custom-control-label" for="toggle-email">
                                Email
                            </label>
                        </div>

                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox"
                                class="custom-control-input toggle-column"
                                id="toggle-rating"
                                data-column="1"
                                checked>

                            <label class="custom-control-label" for="toggle-rating">
                                Rating
                            </label>
                        </div>

                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox"
                                class="custom-control-input toggle-column"
                                id="toggle-comment"
                                data-column="2"
                                checked>

                            <label class="custom-control-label" for="toggle-comment">
                                Comment
                            </label>
                        </div>

                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox"
                                class="custom-control-input toggle-column"
                                id="toggle-place-code"
                                data-column="3"
                                checked>

                            <label class="custom-control-label" for="toggle-place-code">
                                Place Code
                            </label>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox"
                                class="custom-control-input toggle-column"
                                id="toggle-updated"
                                data-column="4"
                                checked>

                            <label class="custom-control-label" for="toggle-updated">
                                Updated At
                            </label>
                        </div>

                    </div>

                </div>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-striped table-hover table-bordered"
                        id="datatable"
                        width="100%">

                        <thead class="thead-light">

                            <tr>
                                <th>Email</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Place Code</th>
                                <th>Updated At</th>
                                <th class="text-center">Action</th>
                            </tr>

                        </thead>

                        <tbody></tbody>

                    </table>

                </div>

            </div>
        </div>

    </div>

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

            #clear-filters {
                border-radius: 4px;
                font-weight: 500;
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

            .toggle-column:disabled+.custom-control-label {
                opacity: 0.5;
                cursor: not-allowed;
            }
        </style>
    @endpush

    @push('script')
        <script>
            $(document).ready(function() {

                // =========================
                // KEEP DROPDOWN OPEN
                // =========================

                $('#columnVisibilityDropdown')
                    .siblings('.dropdown-menu')
                    .on('click', function(e) {
                        e.stopPropagation();
                    });

                $(document).on(
                    'click',
                    '.dropdown-menu .toggle-column, .dropdown-menu .custom-control-label',
                    function(e) {
                        e.stopPropagation();
                    }
                );

                // =========================
                // DATATABLE
                // =========================

                let commentTable = $('#datatable').DataTable({

                    createdRow: function(row, data, dataIndex) {

                        $('td:eq(0)', row).css('min-width', '220px');
                        $('td:eq(1)', row).css('min-width', '120px');
                        $('td:eq(2)', row).css('min-width', '300px');
                        $('td:eq(3)', row).css('min-width', '180px');
                        $('td:eq(4)', row).css('min-width', '180px');

                        $('td:last', row).css({
                            'text-align': 'center',
                            'vertical-align': 'middle',
                            'min-width': '120px'
                        });
                    },

                    filter: true,
                    processing: true,
                    serverSide: true,
                    order: [],

                    dom: '<"top"<"dataTables_length"l><"dataTables_filter"f>>rt<"bottom"<"dataTables_info"i><"dataTables_paginate"p>>',

                    ajax: {
                        url: "{{ route('comments.admin') }}",

                        data: function(d) {

                            d.email = $('#filter-email').val();
                            d.place_code = $('#filter-place-code').val();
                            d.rating = $('#filter-rating').val();
                            d.date = $('#filter-date').val();
                            d.sort_by = $('#sort-order').val();
                        }
                    },

                    columns: [{
                            data: 'email',
                            name: 'email',
                            orderable: true
                        },
                        {
                            data: 'rating',
                            name: 'rating'
                        },
                        {
                            data: 'comment',
                            name: 'comment'
                        },
                        {
                            data: 'place_code',
                            name: 'place_code',
                            defaultContent: '-'
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at',
                            defaultContent: '-'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
                        }
                    ],
                });

                // =========================
                // DEBOUNCE
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

                    commentTable.ajax.reload();

                }, 500);

                $('#filter-email, #filter-place-code')
                    .on('keyup', function() {
                        reloadTableDebounced();
                    });

                $('#filter-rating, #filter-date')
                    .on('change', function() {
                        commentTable.ajax.reload();
                    });

                // =========================
                // SORT
                // =========================

                $('#sort-order').on('change', function() {

                    let value = $(this).val();

                    if (value === 'email') {

                        commentTable.order([0, 'asc']).draw();

                    } else if (value === 'rating') {

                        commentTable.order([1, 'desc']).draw();

                    } else if (value === 'updated_at') {

                        commentTable.order([4, 'desc']).draw();

                    } else {

                        commentTable.order([]).draw();
                    }

                    commentTable.ajax.reload();
                });

                // =========================
                // CLEAR FILTER
                // =========================

                $('#clear-filters').on('click', function() {

                    $('#filter-email').val('');
                    $('#filter-place-code').val('');
                    $('#filter-rating').val('');
                    $('#filter-date').val('');
                    $('#sort-order').val('');

                    commentTable.ajax.reload();
                });

                // =========================
                // COLUMN VISIBILITY
                // =========================

                const STORAGE_KEY = 'comments_table_column_visibility';

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

                        commentTable
                            .column(columnIndex)
                            .visible(
                                isVisible,
                                false
                            );
                    });

                    commentTable
                        .columns
                        .adjust()
                        .draw(false);
                }

                $('.toggle-column').on(
                    'change',
                    function(e) {

                        e.stopPropagation();

                        const checkedColumns =
                            $('.toggle-column:checked')
                            .length;

                        if (
                            checkedColumns === 0
                        ) {

                            $(this).prop(
                                'checked',
                                true
                            );

                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'warning',
                                title: 'Minimum 1 column must remain visible',
                                showConfirmButton: false,
                                timer: 1800
                            });

                            return;
                        }

                        const columnIndex =
                            $(this).data('column');

                        const isVisible =
                            $(this).is(':checked');

                        commentTable
                            .column(columnIndex)
                            .visible(isVisible);

                        saveColumnState();
                    }
                );

                applySavedColumnState();

                // =========================
                // DELETE COMMENT
                // =========================

                $(document).on('click', '.delete', function(e) {

                    e.preventDefault();

                    var id = $(this).attr('id');

                    Swal.fire({

                        customClass: {
                            confirmButton: "btn btn-success",
                            cancelButton: "btn btn-danger"
                        },

                        title: "Are you sure?",
                        text: "Delete this comment",
                        icon: "warning",

                        showCancelButton: true,

                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel!",

                        reverseButtons: true

                    }).then((result) => {

                        if (result.isConfirmed) {

                            $.ajax({

                                type: "DELETE",

                                url: "/management/master/comments/" + id + "/delete",

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

                                        $('#datatable')
                                            .DataTable()
                                            .ajax
                                            .reload();

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
@endsection