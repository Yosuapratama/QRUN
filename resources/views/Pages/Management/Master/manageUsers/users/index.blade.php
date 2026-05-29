@extends('TemplateLayout.AdminLayout')

@section('content')
    @push('title')
        <title>Users Admin - QRUN Website</title>
    @endpush

    @push('css')
        <style>
            .custom-switch {
                padding-left: 3rem;
            }

            .custom-switch .custom-control-label {
                cursor: pointer;
                font-weight: 600;
            }

            .custom-switch .custom-control-label::before {
                width: 2.5rem;
                height: 1.35rem;
                border-radius: 50px;
                top: 0.15rem;
                left: -3rem;
                background-color: #d1d5db;
                border: none;
                transition: all .25s ease;
            }

            .custom-switch .custom-control-label::after {
                width: 1rem;
                height: 1rem;
                border-radius: 50%;
                top: calc(0.15rem + 2px);
                left: calc(-3rem + 2px);
                background: white;
                transition: all .25s ease;
                box-shadow: 0 2px 6px rgba(0, 0, 0, .15);
            }

            .custom-control-label::after {
                left: -2.6rem !important;
            }

            .custom-control-input:checked~.custom-control-label::before {
                background-color: #4e73df;
            }

            .custom-control-input:checked~.custom-control-label::after {
                transform: translateX(1.15rem);
            }

            .custom-control-input:focus~.custom-control-label::before {
                box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, .15);
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

            #sort-order {
                border-radius: 4px;
                border: 1px solid #dee2e6;
                padding: 0.375rem 2.5rem 0.375rem 0.75rem;
                background: #fff url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%234e73df%22%3e%3cpath d=%22M7 10l5 5 5-5z%22/%3e%3c/svg%3e') no-repeat right 10px center;
                background-size: 18px;
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;

                color: #495057;
                font-size: 0.875rem;
                line-height: 1.5;
                height: calc(1.5em + 0.75rem + 2px);

                cursor: pointer;
                transition: all 0.3s ease;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            #sort-order:hover {
                border-color: #4e73df;
                background-color: #f8f9ff;
            }

            #sort-order:focus {
                outline: none;
                border-color: #4e73df;
                box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
            }

            /* Filter Input Styling */
            .form-control-sm {
                border-radius: 4px;
                border: 1px solid #dee2e6;
                transition: all 0.3s ease;
            }

            .form-control-sm:focus {
                border-color: #4e73df;
                box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
            }

            /* Clear Filters Button Styling */
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

            /* Table Responsive Wrapper */
            .table-responsive {
                border-radius: 4px;
                overflow: hidden;
            }

            /* DataTable Styling */
            #dataTablePlace {
                border-collapse: collapse;
                width: 100%;
            }

            #dataTablePlace thead th {
                background-color: #f8f9fa;
                border-bottom: 2px solid #dee2e6;
                font-weight: 600;
                color: #495057;
                padding: 12px;
            }

            #dataTablePlace tbody tr {
                border-bottom: 1px solid #dee2e6;
            }

            #dataTablePlace tbody tr:hover {
                background-color: #f8f9ff;
            }

            #dataTablePlace td {
                padding: 12px;
                vertical-align: middle;
            }

            /* Processing Indicator Text */
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

            /* Info Text */
            .dataTables_info {
                padding-top: 1rem;
                color: #858796;
                font-size: 0.875rem;
            }

            /* Table Wrapper */
            .dataTables_wrapper {
                padding: 0;
            }

            .dataTables_wrapper .row {
                margin: 0 -5px;
            }

            .dataTables_wrapper .row>div {
                padding: 0 5px;
            }

            .filter-card label {
                font-size: 12px;
                font-weight: 600;
            }

            .badge-soft-success {
                background: #e6f7ee;
                color: #1b7f4b;
                padding: 4px 8px;
                border-radius: 6px;
                font-size: 12px
            }

            .badge-soft-warning {
                background: #fff7e6;
                color: #b54708;
                padding: 4px 8px;
                border-radius: 6px;
                font-size: 12px
            }

            .badge-soft-danger {
                background: #fde8e8;
                color: #b42318;
                padding: 4px 8px;
                border-radius: 6px;
                font-size: 12px
            }

            .table td {
                vertical-align: middle;
            }

            .action-btns button {
                margin-right: 5px;
            }
        </style>
    @endpush

    <div class="container-fluid">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 text-gray-800 font-weight-bold">Management Users</h1>
                <small class="text-muted">Manage users, verification, approval, and access control</small>
            </div>
        </div>

        <!-- FILTER CARD -->
        <div class="card shadow mb-3 filter-card">
            <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                @php
                    $pendingUser = \App\Helpers\SidebarHelper::getPendingApprovedUser() ?? 0;
                @endphp

                <div>
                    <h6 class="m-0 font-weight-bold text-primary">
                        Filters
                        <small class="ml-1">
                            (
                            <span class="text-warning font-weight-bold">
                                Pending Approvals: {{ $pendingUser }}
                            </span>
                            )
                        </small>
                    </h6>

                    <small class="text-secondary">
                        Refine the list by name, email, phone, status, and block status.
                    </small>
                </div>
                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2 mt-3 mt-md-0">
                    <select class="form-control form-control-sm" id="sort-order" style="min-width: 220px;">
                        <option value="">Sort by</option>
                        <option value="name">Name</option>
                        <option value="phone">Phone</option>
                        <option value="email">Email</option>
                    </select>
                    <button class="btn btn-outline-secondary btn-sm" id="clear-filters"
                        style="height: calc(1.5em + 0.75rem + 2px); min-width: 140px;">Clear Filters</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label class="small font-weight-bold text-dark">Name</label>
                        <input type="text" id="filter_name" class="form-control form-control-sm"
                            placeholder="Search Name">
                    </div>
                    <div class="col-md-3">
                        <label class="small font-weight-bold text-dark">Email</label>
                        <input type="text" id="filter_email" class="form-control form-control-sm"
                            placeholder="Search Email">
                    </div>
                    <div class="col-md-3">
                        <label class="small font-weight-bold text-dark">Phone</label>
                        <input type="text" id="filter_phone" class="form-control form-control-sm"
                            placeholder="Search Phone">
                    </div>
                    <div class="col-md-3">
                        <label class="small font-weight-bold text-dark">Status Approval</label>
                        <select id="filter_status" class="form-control form-control-sm">
                            <option value="">All</option>
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-3">
                        <label>Blocked</label>
                        <select id="filter_block" class="form-control form-control-sm">
                            <option value="">All</option>
                            <option value="blocked">Blocked</option>
                            <option value="active">Active</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h6 class="m-0 font-weight-bold text-primary">Users Table <small>*(Verified Only)</small></h6>
                    <small class="text-secondary">
                        Tap any action on the right to manage or view more details.
                    </small>
                </div>
                <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">

                    {{-- Column Visibility --}}
                    <div class="dropdown">
                        <button class="mr-2 btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                            id="columnVisibilityDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            <i class="fas fa-columns mr-1"></i>
                            Columns
                        </button>

                        <div class="dropdown-menu dropdown-menu-right p-3 shadow" aria-labelledby="columnVisibilityDropdown"
                            style="min-width:230px;">

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

                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-verified"
                                    data-column="4" checked>
                                <label class="custom-control-label" for="toggle-verified">
                                    Verified
                                </label>
                            </div>

                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-approved"
                                    data-column="5" checked>
                                <label class="custom-control-label" for="toggle-approved">
                                    Approved
                                </label>
                            </div>

                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-blocked"
                                    data-column="6" checked>
                                <label class="custom-control-label" for="toggle-blocked">
                                    Blocked
                                </label>
                            </div>

                        </div>
                    </div>

                    <button class="btn btn-primary btn-sm shadow-sm" id="btnAddUser">
                        <i class="fas fa-plus mr-1"></i>
                        Add User
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="dataTableUser">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Verified</th>
                                <th>Approved</th>
                                <th>Blocked</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <!-- REUSABLE MODAL -->
        <div class="modal fade" id="userModal">
            <div class="modal-dialog modal-lg">
                <form id="userForm">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 id="modalTitle">User</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">

                            <input type="hidden" id="user_id">

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Name <small class='text-danger'>*</small></label>
                                    <input type="text" id="name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Email <small class='text-danger'>*</small></label>
                                    <input type="email" id="email" class="form-control" required>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label>Phone <small class='text-danger'>*</small></label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text font-weight-bold">
                                                +62
                                            </span>
                                        </div>

                                        <input type="text" id="phone" class="form-control" placeholder="85959959"
                                            inputmode="numeric" autocomplete="off">
                                    </div>

                                    <small class="text-muted">
                                        Example: 85959959 (without leading 0)
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <label>Address <small class='text-danger'>*</small></label>
                                    <input type="text" id="address" class="form-control">
                                </div>
                            </div>

                            <div class="row mt-2">

                                <div class="col-md-6" id="passwordBox">
                                    <label id="passwordLabel">
                                        Password <small class="text-danger">*</small>
                                    </label>

                                    <input type="password" id="password" class="form-control"
                                        autocomplete="new-password">

                                    <small id="passwordHint" class="text-muted d-none">
                                        Leave blank if you don't want to change password
                                    </small>
                                </div>

                                <div class="col-md-6" id="confirmPasswordBox">
                                    <label>
                                        Confirm Password <small class="text-danger">*</small>
                                    </label>

                                    <input type="password" id="confirm_password" class="form-control"
                                        autocomplete="new-password">
                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="auto_verified">

                                        <label class="custom-control-label font-weight-semibold" for="auto_verified">
                                            Auto Verified
                                        </label>

                                        <small class="d-block text-muted">
                                            Automatically mark email as verified
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="auto_approved">

                                        <label class="custom-control-label font-weight-semibold" for="auto_approved">
                                            Auto Approved
                                        </label>

                                        <small class="d-block text-muted">
                                            Automatically approve user access
                                        </small>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>

    @push('script')
        <script>
            $(function() {

                let mode = 'create';

                $(document).on('input', '#phone', function() {

                    let value = $(this).val();

                    // only numbers
                    value = value.replace(/\D/g, '');

                    // remove leading zero
                    value = value.replace(/^0+/, '');

                    // max 15 digits
                    value = value.substring(0, 15);

                    $(this).val(value);
                });
                const table = $('#dataTableUser').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [],
                    ajax: {
                        url: "{{ route('users') }}",
                        data: function(d) {
                            d.name = $('#filter_name').val();
                            d.email = $('#filter_email').val();
                            d.phone = $('#filter_phone').val();
                            d.status = $('#filter_status').val();
                            d.block = $('#filter_block').val();
                        }
                    },
                    createdRow: function(row) {
                        $('td:eq(0)', row).css('min-width', '300px');
                        $('td:eq(1)', row).css('min-width', '150px');
                        $('td:eq(2)', row).css('min-width', '200px');
                        $('td:eq(3)', row).css('min-width', '200px');
                        $('td:eq(4)', row).css('min-width', '160px');
                        $('td:eq(5)', row).css('min-width', '160px');
                        $('td:eq(6)', row).css('min-width', '160px');

                        $('td:last', row).css({
                            textAlign: 'center',
                            verticalAlign: 'middle',
                            minWidth: '300px'
                        });
                    },
                    columns: [{
                            data: 'name'
                        },
                        {
                            data: 'phone',
                            defaultContent: '-'
                        },
                        {
                            data: 'email'
                        },
                        {
                            data: 'address',
                            defaultContent: '-'
                        },
                        {
                            data: 'email_verified_at',
                            render: d =>
                                d ?
                                '<span class="badge-soft-success">Verified</span>' :
                                '<span class="badge-soft-warning">Unverified</span>'
                        },
                        {
                            data: 'approved_at',
                            render: d =>
                                d ?
                                '<span class="badge-soft-success">Approved</span>' :
                                '<span class="badge-soft-warning">Pending</span>'
                        },
                        {
                            data: 'deleted_at',
                            render: d =>
                                d ?
                                '<span class="badge-soft-danger">Blocked</span>' :
                                '<span class="badge-soft-success">Active</span>'
                        },
                        {
                            data: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

                $(document).on('click', '#userModal .close', function() {
                    $('#userModal').modal('hide');
                });
                /* ------------------------------
                   COLUMN VISIBILITY
                ------------------------------ */

                $('#columnVisibilityDropdown')
                    .siblings('.dropdown-menu')
                    .on('click', function(e) {
                        e.stopPropagation();
                    });

                const STORAGE_KEY = 'users_table_column_visibility';

                const defaultColumns = {
                    0: true, // Name
                    1: true, // Phone
                    2: true, // Email
                    3: true, // Address
                    4: true, // Verified
                    5: true, // Approved
                    6: true, // Blocked
                    7: true // Action
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

                    const state = {};

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

                    const checkedCount =
                        $('.toggle-column:checked').length;

                    $('.toggle-column')
                        .prop('disabled', false);

                    // prevent hide all columns
                    if (checkedCount <= 1) {
                        $('.toggle-column:checked')
                            .prop('disabled', true);
                    }
                }

                function applySavedColumnState() {

                    const savedState =
                        getSavedColumnState();

                    $('.toggle-column').each(function() {

                        const columnIndex =
                            $(this).data('column');

                        const isVisible =
                            savedState[columnIndex] ?? true;

                        $(this)
                            .prop('checked', isVisible);

                        table
                            .column(columnIndex)
                            .visible(isVisible, false);
                    });

                    // table.columns.adjust().draw(false);

                    updateColumnCheckboxState();
                }

                $('.toggle-column').on('change', function() {

                    const columnIndex =
                        $(this).data('column');

                    const isVisible =
                        $(this).is(':checked');

                    table
                        .column(columnIndex)
                        .visible(isVisible, false);

                    saveColumnState();

                    updateColumnCheckboxState();

                    // table.columns.adjust().draw(false);
                });

                applySavedColumnState();
                /* ------------------------------
                   HELPERS
                ------------------------------ */

                function reloadTable() {
                    table.ajax.reload(null, false);
                }

                function resetForm() {

                    $('#userForm')[0].reset();

                    $('#user_id').val('');

                    // enable form fields
                    $('#name, #email, #phone, #address, #password, #confirm_password')
                        .prop('readonly', false)
                        .prop('disabled', false);

                    // enable switches
                    $('#auto_verified, #auto_approved')
                        .prop('disabled', false)
                        .prop('checked', false);

                    $('#password, #confirm_password').val('');
                    $('#saveBtn').show();
                }

                function showSuccess(response) {
                    Swal.fire({
                        title: response.message ?? 'Success',
                        text: response.status ?? '',
                        icon: 'success'
                    });
                }

                function showError(message = 'Something went wrong') {
                    Swal.fire({
                        title: 'Error',
                        text: message,
                        icon: 'error'
                    });
                }

                function confirmAction({
                    title,
                    text,
                    confirmText,
                    url
                }) {
                    Swal.fire({
                        title,
                        text,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: confirmText,
                        cancelButtonText: "Cancel",
                        reverseButtons: true,
                        customClass: {
                            confirmButton: "btn btn-success",
                            cancelButton: "btn btn-danger"
                        }
                    }).then((result) => {

                        if (!result.isConfirmed) return;

                        $.ajax({
                            url,
                            type: "PUT",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                showSuccess(response);
                                reloadTable();
                            },
                            error: function() {
                                showError('User not found');
                            }
                        });
                    });
                }

                /* ------------------------------
                   MODAL
                ------------------------------ */

                function openModal(type, id = null) {

                    mode = type;

                    resetForm();

                    $('#userModal').modal('show');

                    // reset default state
                    $('#passwordBox').hide();
                    $('#confirmPasswordBox').hide();
                    $('#passwordHint').addClass('d-none');

                    $('#password')
                        .prop('required', false)
                        .val('');

                    $('#confirm_password')
                        .prop('required', false)
                        .val('');

                    // CREATE MODE
                    if (type === 'create') {

                        $('#modalTitle').text('Add User');

                        $('#passwordBox').show();
                        $('#confirmPasswordBox').show();

                        $('#password').prop('required', true);
                        $('#confirm_password').prop('required', true);

                        return;
                    }

                    // EDIT MODE
                    if (type === 'edit') {

                        $('#modalTitle').text('Edit User');

                        $('#passwordBox').show();

                        $('#passwordHint')
                            .removeClass('d-none');

                    } else {

                        // DETAIL MODE
                        $('#modalTitle').text('User Detail');
                    }

                    $.ajax({
                        url: "/management/master/users/detail/" + id,
                        type: "GET",
                        success: function(res) {

                            const d = res.data;
                            const $modal = $('#userModal');

                            $('#user_id').val(d.id);

                            $modal.find('#name')
                                .val(d.name ?? '');

                            $modal.find('#email')
                                .val(d.email ?? '');

                            let phoneNumber = d.phone ?? '';

                            phoneNumber = phoneNumber
                                .replace(/^62/, '')
                                .replace(/^0/, '');

                            $modal.find('#phone')
                                .val(phoneNumber);

                            $modal.find('#address')
                                .val(d.address ?? '');

                            $('#auto_verified')
                                .prop('checked', !!d.email_verified_at);

                            $('#auto_approved')
                                .prop('checked', !!d.approved_at);

                            if (type === 'detail') {

                                $modal.find('input')
                                    .prop('readonly', true);

                                $('#auto_verified, #auto_approved')
                                    .prop('disabled', true);

                                $('#saveBtn').hide();
                            }
                        },
                        error: function() {
                            showError('User not found');
                        }
                    });
                }

                $('#btnAddUser').click(() => openModal('create'));

                $(document).on('click', '.editUser', function() {
                    openModal('edit', $(this).attr('id'));
                });

                $(document).on('click', '.detailUser', function() {
                    openModal('detail', $(this).attr('id'));
                });

                $('#userModal').on('hidden.bs.modal', resetForm);

                /* ------------------------------
                   SAVE USER
                ------------------------------ */

                $('#userForm').submit(function(e) {

                    e.preventDefault();
                    const $form = $('#userForm');

                    const password = $form.find('#password').val();
                    const confirmPassword = $form.find('#confirm_password').val();

                    if (mode === 'create') {

                        if (!password) {
                            return showError('Password is required');
                        }

                        if (!confirmPassword) {
                            return showError('Confirm password is required');
                        }

                        if (password !== confirmPassword) {
                            return showError('Password confirmation does not match');
                        }
                    }

                    if (mode === 'edit') {

                        // only validate if password filled
                        if (password && password.length < 8) {
                            return showError('Password must be at least 8 characters');
                        }
                    }

                    const url = mode === 'create' ?
                        "{{ route('users.store') }}" :
                        "/management/master/users/update";

                    const method = mode === 'create' ?
                        'POST' :
                        'PUT';

                    $.ajax({
                        url,
                        method,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            id: $form.find('#user_id').val(),
                            name: $form.find('#name').val(),
                            email: $form.find('#email').val(),
                            phone: $form.find('#phone').val(),
                            address: $form.find('#address').val(),
                            password: password ? password : null,
                            password2: $form.find('#confirm_password').val(),
                            auto_verified: $form.find('#auto_verified').is(':checked') ? 1 : 0,
                            auto_approved: $form.find('#auto_approved').is(':checked') ? 1 : 0,
                        },
                        success: function(response) {

                            if (response.errors) {

                                const firstError =
                                    response.detail ?
                                    Object.values(response.detail)[0] :
                                    response.errors;

                                return showError(firstError);
                            }

                            $('#userModal').modal('hide');

                            showSuccess(response);

                            reloadTable();
                        },

                        error: function(xhr) {

                            let message = 'Something went wrong';

                            // response json
                            const response = xhr.responseJSON;

                            if (response) {

                                // Laravel validation error
                                if (response.errors) {

                                    // ambil first validation message
                                    const firstErrorKey = Object.keys(response.errors)[0];

                                    if (
                                        firstErrorKey &&
                                        response.errors[firstErrorKey]?.length
                                    ) {
                                        message =
                                            response.errors[firstErrorKey][0];
                                    } else {
                                        message = 'Validation failed';
                                    }
                                }

                                // custom detail object
                                else if (response.detail) {

                                    const firstDetailKey =
                                        Object.keys(response.detail)[0];

                                    message =
                                        response.detail[firstDetailKey] ??
                                        response.message ??
                                        message;
                                }

                                // normal message
                                else if (response.message) {
                                    message = response.message;
                                }
                            }

                            showError(message);
                        }
                    });
                });

                /* ------------------------------
                   FILTER
                ------------------------------ */

                function debounce(fn, delay) {
                    let t;
                    return function() {
                        clearTimeout(t);
                        t = setTimeout(() => fn.apply(this, arguments), delay);
                    }
                }

                $('#filter_name,#filter_email,#filter_phone')
                    .on('keyup',
                        debounce(() => reloadTable(), 500)
                    );

                $('#filter_status,#filter_block')
                    .on('change', reloadTable);

                $('#clear-filters').click(function() {

                    $('#filter_name').val('');
                    $('#filter_email').val('');
                    $('#filter_phone').val('');
                    $('#filter_status').val('');
                    $('#filter_block').val('');
                    $('#sort-order').val('');

                    reloadTable();
                });

                $('#sort-order').on('change', function() {

                    const value = $(this).val();

                    const map = {
                        name: 0,
                        phone: 1,
                        email: 2
                    };

                    if (value) {
                        table.order([
                            [map[value], 'asc']
                        ]).draw();
                    } else {
                        table.order([]).draw();
                    }
                });

                /* ------------------------------
                   APPROVE / UNAPPROVE
                ------------------------------ */

                $(document).on('click', '.approve', function() {

                    const id = $(this).attr('id');

                    confirmAction({
                        title: 'Are you sure?',
                        text: 'Approve to local admin',
                        confirmText: 'Yes, Approve it!',
                        url: `/management/master/users/${id}/approve`
                    });
                });

                $(document).on('click', '.unapprove', function() {

                    const id = $(this).attr('id');

                    confirmAction({
                        title: 'Are you sure?',
                        text: 'UnApprove to User',
                        confirmText: 'Yes, UnApprove it!',
                        url: `/management/master/users/${id}/unapprove`
                    });
                });

                /* ------------------------------
                   BLOCK / UNBLOCK
                ------------------------------ */

                $(document).on('click', '.blockUser', function() {

                    const id = $(this).attr('id');

                    confirmAction({
                        title: 'Are you sure?',
                        text: 'Block User',
                        confirmText: 'Yes, Block User!',
                        url: `/management/master/users/${id}/block`
                    });
                });

                $(document).on('click', '.unBlockUser', function() {

                    const id = $(this).attr('id');

                    confirmAction({
                        title: 'Are you sure?',
                        text: 'Unblock User',
                        confirmText: 'Yes, Unblock User!',
                        url: `/management/master/users/${id}/unblock`
                    });
                });
            });
        </script>
    @endpush
@endsection
