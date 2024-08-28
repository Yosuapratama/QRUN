@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Management Event Admin - QRUN Website</title>
    @endpush
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 text-gray-800 font-weight-bold m-2">Management All Event</h1>
        <button class="btn btn-success m-2" data-bs-toggle="modal" data-bs-target="#addEventModalAdmin">Add Event</button>
        {{-- <button class="btn btn-success m-2" data-bs-toggle="modal" data-bs-target="#addUserModal">Add Place</button> --}}
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Event Table</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTableEvent" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Place Code</th>
                                <th>Date</th>
                                <th>Status</th>
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
                $('#dataTableEvent').DataTable({
                    'createdRow': function(row, data, dataIndex) {
                        $('td:eq(0)', row).css('min-width', '200px');
                        $('td:eq(1)', row).css('min-width', '150px');
                        $('td:eq(2)', row).css('min-width', '200px');
                    },
                    filter: true,
                    processing: true,
                    serverSide: false,
                    ajax: "{{ route('event') }}",
                    columns: [{
                            data: 'title',
                            name: 'title',
                            orderable: true
                        }, {
                            name: 'description',
                            data: 'description'
                        },
                        {
                            name: 'place_id.place_code',
                            data: 'place_id.place_code'
                        },

                        {
                            data: 'date',
                            name: 'date',
                            "defaultContent": "-"
                        },
                        {
                            data: 'is_deleted',
                            name: 'is_deleted'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
                        }
                    ],
                });

                //Submit New Event
                $(document).on('submit', '#addEventForm', function(e) {
                    e.preventDefault();

                    $.ajax({
                        type: "POST",
                        url: "{{ route('event.adminStore') }}",
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
                                $('#addEventModalAdmin').modal('hide');
                                $("#addEventForm")[0].reset();
                                $('#dataTableEvent').DataTable().ajax.reload();
                            }else if(response.errors){
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
                })

                $(document).on('click', '.deleteEventButtonNew', function(e) {
                    e.preventDefault();
                    var id = $(this).attr('id');

                    Swal.fire({
                        customClass: {
                            confirmButton: "btn btn-success",
                            cancelButton: "btn btn-danger"
                        },
                        title: "Are you sure?",
                        text: "Delete this Event",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel!",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "/management/master/my-event/delete/" + id,
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
                                        $('#dataTableEvent').DataTable().ajax.reload();
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

                
                $(document).on('click', '.editEventBtn', function(e) {
                    e.preventDefault();

                    var id = $(this).attr('id');
                    $('#editEventModalAdmin').modal('show');

                    $.ajax({
                        type: "GET",
                        url: "/management/master/my-event/get-data/" + id,
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.errors) {
                                Swal.fire({
                                    title: response.errors,
                                    text: response.errors,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }

                            $('#detailTitleEventEdit').val(response.data.title);
                            $('#descriptionEventEdit').val(response.data.description);
                            $('#EventId').val(response.data.id);
                            $('#datetimeEventEdit').val(response.date);
                            

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

                // Setup Submitted Edit
                $(document).on('submit', '#editEventForm', function(e) {
                    e.preventDefault();

                    $.ajax({
                        type: "POST",
                        url: "{{ route('myevent.update') }}",
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
                                $('#editEventModalAdmin').modal('hide');
                                $("#editEventForm")[0].reset();
                                $('#dataTableEvent').DataTable().ajax.reload();
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
