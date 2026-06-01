@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Management Place Limit Admin - QRUN Website</title>
    @endpush

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

            #sort-order {
                border-radius: 4px;
                border: 1px solid #dee2e6;
                padding: 0.375rem 2.5rem 0.375rem 0.75rem;
                appearance: none;
                color: #495057;
                font-size: 0.875rem;
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

            #dataTablePlace thead th {
                background-color: #f8f9fa;
                border-bottom: 2px solid #dee2e6;
                font-weight: 600;
                color: #495057;
                padding: 12px;
            }

            #dataTablePlace tbody tr:hover {
                background-color: #f8f9ff;
            }

            #dataTablePlace td {
                padding: 12px;
                vertical-align: middle;
            }
        </style>
    @endpush

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <h1 class="h3 text-gray-800 font-weight-bold m-2">
            Management Place Limit
        </h1>

        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        {{-- FILTER CARD --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">

                <div>
                    <h6 class="m-0 font-weight-bold text-primary">
                        Filters
                    </h6>

                    <small class="text-secondary">
                        Filter place limit data.
                    </small>
                </div>

                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2 mt-3 mt-md-0">

                    <select class="form-control form-control-sm mr-2" id="sort-order" style="min-width:220px;">

                        <option value="">
                            Sort By
                        </option>

                        <option value="name">
                            Name
                        </option>

                        <option value="limit">
                            Total Limit
                        </option>

                        <option value="updated">
                            Updated At
                        </option>

                    </select>

                    <button class="btn btn-outline-secondary btn-sm" id="clear-filters"
                        style="height: calc(1.5em + 0.75rem + 2px); min-width:140px;">

                        Clear Filters

                    </button>

                </div>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-12">

                        <label class="small font-weight-bold text-dark">
                            Name
                        </label>

                        <input type="text" class="form-control form-control-sm" id="filter-name"
                            placeholder="Search name">

                    </div>

                </div>

            </div>

        </div>

        {{-- TABLE CARD --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">

                <div>
                    <h6 class="m-0 font-weight-bold text-primary">
                        Place Limit Table
                    </h6>

                    <small class="text-secondary">
                        Manage all place limit data here.
                    </small>
                </div>

                <div class="dropdown">

                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">

                        <i class="fas fa-columns mr-1"></i>
                        Columns

                    </button>

                    <a href="{{ route('place-limit.create') }}" class="btn btn-success btn-sm shadow-sm">

                        <i class="fas fa-plus mr-1"></i>
                        Add Place Limit

                    </a>

                    <div class="dropdown-menu dropdown-menu-right p-3 shadow">

                        <div class="custom-control custom-checkbox mb-2">

                            <input type="checkbox" class="custom-control-input toggle-column" id="toggle-name"
                                data-column="0" checked>

                            <label class="custom-control-label" for="toggle-name">
                                Name
                            </label>

                        </div>

                        <div class="custom-control custom-checkbox mb-2">

                            <input type="checkbox" class="custom-control-input toggle-column" id="toggle-limit"
                                data-column="1" checked>

                            <label class="custom-control-label" for="toggle-limit">
                                Total Limit
                            </label>

                        </div>

                        <div class="custom-control custom-checkbox">

                            <input type="checkbox" class="custom-control-input toggle-column" id="toggle-updated"
                                data-column="2" checked>

                            <label class="custom-control-label" for="toggle-updated">
                                Updated At
                            </label>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-striped table-hover table-bordered" id="dataTablePlace" width="100%">

                        <thead>

                            <tr>

                                <th>Name</th>
                                <th>Total Limit</th>
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
    <!-- /.container-fluid -->

    @push('script')
        <script>
            $(document).ready(function() {
                const STORAGE_KEY = 'place_limit_column_visibility';

                const table = $('#dataTablePlace').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [],
                    ajax: {
                        url: "{{ route('place-limit.index') }}",

                        dataSrc: function(json) {

                            let data = json.data || json;

                            let name = $('#filter-name').val().toLowerCase();

                            if (name) {

                                data = data.filter(item =>
                                    item.name?.toLowerCase().includes(name)
                                );

                            }

                            return data;
                        }
                    },

                    columns: [{
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'total_limit',
                            name: 'total_limit'
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
                    ]
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

                const reloadTableDebounced = debounce(function() {
                    table.ajax.reload();
                }, 400);

                $('#filter-name').on('keyup', function() {
                    reloadTableDebounced();
                });

                $('#sort-order').on('change', function() {

                    const value = $(this).val();

                    if (value === 'name') {

                        table.order([0, 'asc']).draw();

                    } else if (value === 'limit') {

                        table.order([1, 'asc']).draw();

                    } else if (value === 'updated') {

                        table.order([2, 'desc']).draw();

                    } else {

                        table.order([]).draw();
                    }
                });

                $('#clear-filters').on('click', function() {

                    $('#filter-name').val('');
                    $('#sort-order').val('');

                    table.ajax.reload();
                });

                $('.dropdown-menu').on('click', function(e) {
                    e.stopPropagation();
                });

                function saveColumnState() {

                    let state = {};

                    $('.toggle-column').each(function() {

                        state[$(this).data('column')] =
                            $(this).is(':checked');
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

                        const columnIndex = $(this).data('column');

                        const isVisible =
                            saved[columnIndex] ?? true;

                        $(this).prop('checked', isVisible);

                        table.column(columnIndex)
                            .visible(isVisible, false);
                    });

                    table.columns.adjust().draw(false);
                }

                $('.toggle-column').on('change', function() {

                    const checkedColumns =
                        $('.toggle-column:checked').length;

                    if (checkedColumns === 0) {

                        $(this).prop('checked', true);

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

                    table.column(columnIndex)
                        .visible($(this).is(':checked'));

                    saveColumnState();
                });

                applySavedColumnState();

                $(document).on('click', '.delete', function(e) {
                    e.preventDefault();
                    var id = $(this).attr('id');

                    Swal.fire({
                        customClass: {
                            confirmButton: "btn btn-success",
                            cancelButton: "btn btn-danger"
                        },
                        title: "Are you sure?",
                        text: "Delete this limit will removed all user connected with this",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel!",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "DELETE",
                                url: "/management/master/place-limit/" + id + "/delete",
                                dataType: "json",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    console.log(response.message);
                                    if (response.success) {
                                        Swal.fire({
                                            title: response.success,
                                            text: response.success,
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        });
                                        $('#dataTablePlace').DataTable().ajax.reload();
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
                                    // Swal.fire({
                                    //     title: 'User Not Found !',
                                    //     icon: 'error',
                                    //     confirmButtonText: 'OK'
                                    // });
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
