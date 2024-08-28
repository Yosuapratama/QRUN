@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Users Admin - QRUN Website</title>
    @endpush
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 text-gray-800 font-weight-bold m-2">Management Users</h1>
        <button class="btn btn-success m-2" data-bs-toggle="modal" data-bs-target="#addUserModal">Add Users</button>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Users Table</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTableUser" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Blocked</th>
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
                $('#dataTableUser').DataTable({
                    'createdRow': function(row, data, dataIndex) {
                        $('td:eq(0)', row).css('min-width', '200px');
                        $('td:eq(3)', row).css('min-width', '250px');
                        $('td:eq(5)', row).css('min-width', '120px');
                    },
                    filter: true,
                    processing: true,
                    serverSide: false,
                    ajax: "{{ route('users') }}",
                    columns: [{
                            data: 'name',
                            name: 'name',
                            orderable: true
                        }, {
                            data: 'phone',
                            name: 'phone'
                        }, {
                            data: 'email',
                            name: 'email'
                        }, {
                            data: 'address',
                            name: 'address'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'status_acc',
                            name: 'status_acc',
                            searchable: true
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
                        }
                    ],
                });

                $(document).on('click', '.approve', function(e) {
                    var id = $(this).attr('id');

                    Swal.fire({
                        customClass: {
                            confirmButton: "btn btn-success",
                            cancelButton: "btn btn-danger"
                        },
                        title: "Are you sure?",
                        text: "Approve to local admin",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, Approve it!",
                        cancelButtonText: "No, cancel!",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "PUT",
                                url: "/management/master/users/" + id + "/approve",
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
                                    $('#dataTableUser').DataTable().ajax.reload();
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
                                    $('#dataTableUser').DataTable().ajax.reload();
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
                                    $('#dataTableUser').DataTable().ajax.reload();

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
                                    $('#dataTableUser').DataTable().ajax.reload();

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
                            $('#dataTableUser').DataTable().ajax.reload();

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

                                if (response.detail?.email) {
                                    Swal.fire({
                                        title: response.detail.email,
                                        text: response.detail.email,
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                } else if (response.detail?.password) {
                                    Swal.fire({
                                        title: response.detail.password,
                                        text: response.detail.password,
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                } else {
                                    Swal.fire({
                                        title: response.errors,
                                        text: response.status,
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }

                            } else {
                                Swal.fire({
                                    title: response.message,
                                    text: response.status,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                $("#createUserForm")[0].reset();
                                $('#addUserModal').modal('hide');
                                $('#dataTableUser').DataTable().ajax.reload();
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
    <!-- End of Main Content -->
@endsection
