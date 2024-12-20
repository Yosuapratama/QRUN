@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Management Users Limit Admin - QRUN Website</title>
    @endpush
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 text-gray-800 font-weight-bold m-2">Management Users Limit</h1>
        {{-- <button class="btn btn-success m-2" data-bs-toggle="modal" data-bs-target="">Add Users</button> --}}
        <button class="btn btn-success m-2" data-bs-toggle="modal" data-bs-target="#addUserhasLimitModal">Add Place</button>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Users has limit Table</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="datatable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Place Limit</th>
                                <th>Updated at</th>
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
                function fetchData() {
                    $("#find-user").select2({
                        dropdownParent: $("#addUserhasLimitModal")
                    });
                    $("#find_place_limit").select2({
                        dropdownParent: $("#addUserhasLimitModal")
                    });

                    $('#find_place_limit').empty();
                    $('#find-user').empty();
                    $('#find_place_limit').append('<option value="">Select place Limit</option>');
                    $('#find-user').append('<option value="">Select User Email</option>');

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
                                title: 'Failed to Fetch Place',
                                text: response.errors,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });

                }

                function fetchEditData(id) {
                    console.log(id);
                    $("#find-user-edit").select2({
                        dropdownParent: $("#editUserhasLimitModal")
                    });
                    $("#find_place_limit_edit").select2({
                        dropdownParent: $("#editUserhasLimitModal")
                    });

                    $('#find_place_limit_edit').empty();
                    $('#find-user-edit').empty();
                    $('#find_place_limit_edit').append('<option value="">Select place Limit</option>');
                    $('#find-user-edit').append('<option value="">Select User Email</option>');
                    $('#editUserHasLimitiD').val('');

                    $.ajax({
                        url: "{{ route('users-limit.getData', ':id') }}".replace(':id', id),
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
                                    `<option value="${item.id}" ${item.id == place_limit_id ? 'selected' : ''}>${item.name}</option>`
                                );
                            });

                            $('#find-user-edit').append(
                                `<option value="${user_email}" selected>${user_email}</option>`
                            );
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Failed to Fetch Place',
                                text: response.errors,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }

                fetchData();

                $('#datatable').DataTable({
                    'createdRow': function(row, data, dataIndex) {
                        $('td:eq(0)', row).css('min-width', '200px');
                        $('td:eq(1)', row).css('min-width', '150px');
                        $('td:eq(2)', row).css('min-width', '200px');
                    },
                    filter: true,
                    processing: true,
                    serverSide: false,
                    ajax: "{{ route('users-limit.index') }}",
                    columns: [{
                            data: 'user.email',
                            name: 'user.email',
                            orderable: true
                        },
                        {
                            data: 'place_name',
                            name: 'place_name',
                            "defaultContent": "-"
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
                    ],
                });

                //Submit New Event
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
                            console.log(response.message);
                            if (response.success) {
                                Swal.fire({
                                    title: response.success,
                                    text: response.success,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                $('#addUserhasLimitModal').modal('hide');
                                $("#addUserHasPlaceLimit")[0].reset();
                                $('#datatable').DataTable().ajax.reload();
                                fetchData();
                            } else if (response) {
                                Swal.fire({
                                    title: response.errors,
                                    text: response.errors,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });

                                console.log(response);
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
                })

                $(document).on('click', '.delete', function(e) {
                    e.preventDefault();
                    var id = $(this).attr('id');

                    Swal.fire({
                        customClass: {
                            confirmButton: "btn btn-success",
                            cancelButton: "btn btn-danger"
                        },
                        title: "Are you sure?",
                        text: "Delete this Limit will affect to user place !",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel!",
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
                                    console.log(response.message);
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

                                    fetchData();

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


                $(document).on('click', '.edit', function(e) {
                    e.preventDefault();

                    var id = $(this).attr('id');
                    fetchEditData(id);
                    $('#editUserhasLimitModal').modal('show');
                });

                // // Setup Submitted Edit
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
                            console.log(response.message);
                            if (response.success) {
                                Swal.fire({
                                    title: response.success,
                                    text: response.success,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                $('#editUserhasLimitModal').modal('hide');
                                $("#editUserHasPlaceLimit")[0].reset();
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
                            // Swal.fire({
                            //     title: 'User Not Found !',
                            //     icon: 'error',
                            //     confirmButtonText: 'OK'
                            // });
                            console.log(err);
                        }
                    });

                });
            });
        </script>
    @endpush
    <!-- End of Main Content -->
@endsection
