@extends('TemplateLayout.AdminLayout')

@section('content')
    @push('title')
        <title>Pending Users Verify Admin - QRUN Website</title>
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
            .form-control-sm:focus {
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

            #dataTableUserBlocked {
                border-collapse: collapse;
                width: 100%;
            }

            #dataTableUserBlocked thead th {
                background-color: #f8f9fa;
                border-bottom: 2px solid #dee2e6;
                font-weight: 600;
                color: #495057;
                padding: 12px;
            }

            #dataTableUserBlocked tbody tr {
                border-bottom: 1px solid #dee2e6;
            }

            #dataTableUserBlocked tbody tr:hover {
                background-color: #f8f9ff;
            }

            #dataTableUserBlocked td {
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
        </style>
    @endpush

    <div class="container-fluid">

        <h1 class="h3 text-gray-800 font-weight-bold m-2">
            Management Pending Users Verify
        </h1>

        {{-- FILTER CARD --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h6 class="m-0 font-weight-bold text-primary">
                        Filters
                    </h6>

                    <small class="text-secondary">
                        Refine pending verify users by name, email, address, and phone.
                    </small>
                </div>

                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2 mt-3 mt-md-0">
                    <select class="form-control form-control-sm" id="sort-order" style="min-width: 220px;">
                        <option value="">Sort by</option>
                        <option value="name">Name</option>
                        <option value="email">Email</option>
                        <option value="address">Address</option>
                        <option value="phone">Phone</option>
                    </select>

                    <button class="btn btn-outline-secondary btn-sm" id="clear-filters"
                        style="height: calc(1.5em + 0.75rem + 2px); min-width: 140px;">
                        Clear Filters
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="small font-weight-bold text-dark">
                            Name
                        </label>

                        <input type="text" class="form-control form-control-sm" id="filter-name"
                            placeholder="Search name">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="small font-weight-bold text-dark">
                            Email
                        </label>

                        <input type="text" class="form-control form-control-sm" id="filter-email"
                            placeholder="Search email">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="small font-weight-bold text-dark">
                            Phone
                        </label>

                        <input type="text" class="form-control form-control-sm" id="filter-phone"
                            placeholder="Search phone">
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="small font-weight-bold text-dark">
                            Address
                        </label>

                        <input type="text" class="form-control form-control-sm" id="filter-address"
                            placeholder="Search address">
                    </div>

                </div>

            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">

                <div>
                    <h6 class="m-0 font-weight-bold text-primary">
                        Pending Users Verify Table
                    </h6>

                    <small class="text-secondary">
                        Manage user verification and account actions.
                    </small>
                </div>

                <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">

                    {{-- COLUMN VISIBILITY --}}
                    <div class="dropdown">
                        <button class="mr-2 btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                            id="columnVisibilityDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            <i class="fas fa-columns mr-1"></i>
                            Columns
                        </button>

                        <div class="dropdown-menu dropdown-menu-right p-3 shadow" aria-labelledby="columnVisibilityDropdown"
                            style="min-width: 230px;">

                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-name"
                                    data-column="0" checked>

                                <label class="custom-control-label" for="toggle-name">
                                    Name
                                </label>
                            </div>

                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-phone"
                                    data-column="1" checked>

                                <label class="custom-control-label" for="toggle-phone">
                                    Phone
                                </label>
                            </div>

                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-email"
                                    data-column="2" checked>

                                <label class="custom-control-label" for="toggle-email">
                                    Email
                                </label>
                            </div>

                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-address"
                                    data-column="3" checked>

                                <label class="custom-control-label" for="toggle-address">
                                    Address
                                </label>
                            </div>

                            {{-- <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-status"
                                    data-column="4" checked>

                                <label class="custom-control-label" for="toggle-status">
                                    Status
                                </label>
                            </div> --}}

                            {{-- <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-blocked"
                                    data-column="5" checked>

                                <label class="custom-control-label" for="toggle-blocked">
                                    Blocked
                                </label>
                            </div> --}}

                        </div>
                    </div>

                </div>

            </div>

            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-striped table-hover table-bordered" id="dataTableUserBlocked" width="100%"
                        cellspacing="0">

                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                {{-- <th>Status</th> --}}
                                {{-- <th>Blocked</th> --}}
                                <th class="text-center">Action</th>
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

                let dataTableUserBlocked = $('#dataTableUserBlocked').DataTable({

                    createdRow: function(row, data, dataIndex) {

                        $('td:eq(0)', row).css('min-width', '220px');
                        $('td:eq(1)', row).css('min-width', '160px');
                        $('td:eq(2)', row).css('min-width', '220px');
                        $('td:eq(3)', row).css('min-width', '250px');
                        $('td:eq(4)', row).css('min-width', '120px');
                        $('td:eq(5)', row).css('min-width', '120px');

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

                    dom: '<"top"<"dataTables_length"l><"dataTables_filter"f>><"table-responsive-wrapper"rt><"bottom"<"dataTables_info"i><"dataTables_paginate"p>>',

                    ajax: {
                        url: "{{ route('pending-verify.index') }}",
                        data: function(d) {
                            d.name = $('#filter-name').val();
                            d.email = $('#filter-email').val();
                            d.phone = $('#filter-phone').val();
                            d.address = $('#filter-address').val();
                            // d.status = $('#filter-status').val();
                            d.sort_by = $('#sort-order').val();
                        }
                    },

                    columns: [{
                            data: 'name',
                            name: 'name',
                            orderable: true
                        },
                        {
                            data: 'phone',
                            name: 'phone',
                            defaultContent: '-'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'address',
                            name: 'address',
                            defaultContent: '-'
                        },
                        // {
                        //     data: 'status',
                        //     name: 'status'
                        // },
                        // {
                        //     data: 'status_acc',
                        //     name: 'status_acc'
                        // },
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

                $(document).on('click', '.deleteUser', function() {
                    let id = $(this).attr('id');

                    Swal.fire({
                        title: 'Delete User?',
                        text: "This action cannot be undone.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {

                        if (result.isConfirmed) {

                            $.ajax({
                                url: `/management/master/users/${id}/block`,
                                type: 'PUT',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },

                                success: function(response) {

                                    Swal.fire(
                                        'Deleted!',
                                        response.message,
                                        'success'
                                    );

                                    dataTableUserBlocked.ajax.reload();
                                },

                                error: function() {
                                    Swal.fire(
                                        'Error!',
                                        'Failed to delete user.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                });

                const reloadTableDebounced = debounce(function() {
                    dataTableUserBlocked.ajax.reload();
                }, 500);

                $('#filter-name, #filter-email, #filter-phone, #filter-address')
                    .on('keyup', function() {
                        reloadTableDebounced();
                    });

                $('#filter-status')
                    .on('change', function() {
                        dataTableUserBlocked.ajax.reload();
                    });

                $('#sort-order').on('change', function() {

                    let value = $(this).val();

                    if (value === 'name') {
                        dataTableUserBlocked.order([0, 'asc']).draw();
                    } else if (value === 'email') {
                        dataTableUserBlocked.order([2, 'asc']).draw();
                    } else if (value === 'address') {
                        dataTableUserBlocked.order([3, 'asc']).draw();
                    } else if (value === 'phone') {
                        dataTableUserBlocked.order([1, 'asc']).draw();
                    } else {
                        dataTableUserBlocked.order([]).draw();
                    }

                    dataTableUserBlocked.ajax.reload();
                });

                $('#clear-filters').on('click', function() {

                    $('#filter-name').val('');
                    $('#filter-email').val('');
                    $('#filter-phone').val('');
                    $('#filter-address').val('');
                    // $('#filter-status').val('');
                    // $('#filter-blocked').val('');
                    $('#sort-order').val('');

                    dataTableUserBlocked.ajax.reload();
                });

                // =========================
                // COLUMN VISIBILITY
                // =========================

                const STORAGE_KEY = 'pending_verify_column_visibility';

                const defaultColumns = {
                    0: true,
                    1: true,
                    2: true,
                    3: true,
                    4: true,
                    5: true
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

                        dataTableUserBlocked
                            .column(columnIndex)
                            .visible(isVisible, false);
                    });

                    dataTableUserBlocked.columns.adjust().draw(false);

                    updateColumnCheckboxState();
                }

                $('.toggle-column').on('change', function() {

                    const columnIndex = $(this).data('column');
                    const isVisible = $(this).is(':checked');

                    dataTableUserBlocked
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
                // EXISTING ACTIONS
                // =========================

                // lanjutkan semua handler verifyUser,
                // blockUser,
                // editUser,
                // detailUser,
                // unapprove,
                // unblock,
                // dll
                // dari kode lama di bawah sini tanpa diubah
            });

            $(document).on('click', '.verifyUser', function(e) {
                var id = $(this).attr('id');

                Swal.fire({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    title: "Are you sure?",
                    text: "Verify this account",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Verify it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "/management/master/pending-verify/" + id + "/verify",
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                console.log(response.message);
                                Swal.fire({
                                    title: response.message,
                                    text: response.status,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                $('#dataTableUserBlocked').DataTable().ajax.reload();
                                // if (response.status == 404) {
                                //     $('#success_message').addClass('alert alert-success');
                                //     $('#success_message').text(response.message);
                                //     $('.delete_student').text('Yes Delete');
                                // } else {
                                //     $('#success_message').html("");
                                //     $('#success_message').addClass('alert alert-success');
                                //     $('#success_message').text(response.message);
                                //     $('.delete_student').text('Yes Delete');
                                //     $('#DeleteModal').modal('hide');
                                //     fetchstudent();
                                // }
                            },
                            error: function(err) {
                                Swal.fire({
                                    title: 'User Not Found !',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                })
                            }

                        });
                    }
                });

            });

            // UnAproved Ajax
            $(document).on('click', '.unapprove', function(e) {
                var id = $(this).attr('id');

                Swal.fire({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    title: "Are you sure?",
                    text: "UnApprove to User",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, UnApprove it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "PUT",
                            url: "/management/master/users/" + id + "/unapprove",
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                console.log(response.message);
                                Swal.fire({
                                    title: response.message,
                                    text: response.status,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                $('#dataTableUserBlocked').DataTable().ajax.reload();
                                // if (response.status == 404) {
                                //     $('#success_message').addClass('alert alert-success');
                                //     $('#success_message').text(response.message);
                                //     $('.delete_student').text('Yes Delete');
                                // } else {
                                //     $('#success_message').html("");
                                //     $('#success_message').addClass('alert alert-success');
                                //     $('#success_message').text(response.message);
                                //     $('.delete_student').text('Yes Delete');
                                //     $('#DeleteModal').modal('hide');
                                //     fetchstudent();
                                // }
                            },
                            error: function(err) {
                                Swal.fire({
                                    title: 'User Not Found !',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                })
                            }

                        });
                    }
                });

            });

            // Show Modal Detail
            $(document).on('click', '.detailUser', function() {
                $('#detailUserModal').modal('show');
                var id = $(this).attr('id');

                $('#detailName').val('');
                $('#detailPhone').val('');
                $('#detailEmail').val('');
                $('#detailAddress').val('');

                $.ajax({
                    type: "GET",
                    url: "/management/master/users/detail/" + id,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#detailName').val(response.data.name);
                        $('#detailPhone').val(response.data.phone);
                        $('#detailEmail').val(response.data.email);
                        $('#detailAddress').val(response.data.address);
                    },
                    error: function(err) {
                        Swal.fire({
                            title: 'User Not Found !',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }

                });
            });

            // Show Modal Edit
            $(document).on('click', '.editUser', function() {
                $('#editUserModal').modal('show');
                var id = $(this).attr('id');

                $('#idUser').val('');
                $('#editName').val('');
                $('#editPhone').val('');
                $('#editAddress').val('');
                $('#editEmail').val('');

                $.ajax({
                    type: "GET",
                    url: "/management/master/users/detail/" + id,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#idUser').val(response.data.id);
                        $('#editName').val(response.data.name);
                        $('#editPhone').val(response.data.phone);
                        $('#editAddress').val(response.data.address);
                        $('#editEmail').val(response.data.email);
                    },
                    error: function(err) {
                        Swal.fire({
                            title: 'User Not Found !',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }

                });
            });

            // Block An User
            $(document).on('click', '.blockUser', function() {
                var id = $(this).attr('id');

                Swal.fire({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    title: "Are you sure?",
                    text: "Block User",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Block This User!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "PUT",
                            url: "/management/master/users/" + id + '/block',
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                console.log(response.message);
                                Swal.fire({
                                    title: response.message,
                                    text: response.status,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                $('#dataTableUserBlocked').DataTable().ajax.reload();

                            },
                            error: function(err) {
                                Swal.fire({
                                    title: 'User Not Found !',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                })
                            }
                        });
                    }
                });

            });

            // UnBlock An User
            $(document).on('click', '.unBlockUser', function() {
                var id = $(this).attr('id');

                Swal.fire({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    title: "Are you sure?",
                    text: "UnBlock User",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, UnBlock This User!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "PUT",
                            url: "/management/master/users/" + id + '/unblock',
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                console.log(response.message);
                                Swal.fire({
                                    title: response.message,
                                    text: response.status,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                $('#dataTableUserBlocked').DataTable().ajax.reload();

                            },
                            error: function(err) {
                                Swal.fire({
                                    title: 'User Not Found !',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                })
                            }
                        });
                    }
                });

            });

            $(document).on('submit', '#editUserForm', function(e) {
                e.preventDefault();

                $.ajax({
                    type: "PUT",
                    url: "/management/master/users/update",
                    data: $(this).serialize(),
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response.message);
                        Swal.fire({
                            title: response.message,
                            text: response.status,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        $('#dataTableUserBlocked').DataTable().ajax.reload();

                    },
                    error: function(err) {
                        Swal.fire({
                            title: 'User Not Found !',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        console.log(err);
                    }
                });
            });

            $(document).on('submit', '#createUserForm', function(e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "{{ route('users.store') }}",
                    data: $(this).serialize(),
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.errors) {
                            Swal.fire({
                                title: response.errors,
                                text: response.status,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: response.message,
                                text: response.status,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            $('#addUserModal').modal('hide');
                            $('#dataTableUserBlocked').DataTable().ajax.reload();
                        }
                        if (response.detail?.email) {
                            Swal.fire({
                                title: response.detail.email,
                                text: response.detail.email,
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
        </script>
    @endpush
    <!-- End of Main Content -->
@endsection
