@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Management Place Admin - QRUN Website</title>
    @endpush
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 text-gray-800 font-weight-bold m-2">Management Place/Object</h1>
        {{-- <button class="btn btn-success m-2" data-bs-toggle="modal" data-bs-target="#addUserModal">Add Place</button> --}}
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Place Table</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTablePlace" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Place Code</th>
                                <th>Views</th>
                                <th>Description</th>
                                <th>Created_By</th>
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
                $('#dataTablePlace').DataTable({
                    'createdRow': function(row, data, dataIndex) {
                        $('td:eq(0)', row).css('min-width', '200px');
                        $('td:eq(1)', row).css('min-width', '150px');
                        $('td:eq(2)', row).css('min-width', '200px');
                        $('td:eq(3)', row).css('min-width', '200px');
                        $('td:eq(4)', row).css('min-width', '200px');
                        $('td:eq(5)', row).css('min-width', '120px');
                    },
                    filter: true,
                    processing: true,
                    serverSide: false,
                    ajax: "{{ route('place') }}",
                    columns: [{
                            data: 'title',
                            name: 'title',
                            orderable: true
                        },
                        {
                            data: 'place_code',
                            name: 'place_code'
                        },
                        {
                            data: 'views',
                            name: 'views'
                        },
                        {
                            data: 'description',
                            name: 'description'
                        },
                        {
                            data: 'creator_id.email',
                            name: 'creator_id.email',
                            "defaultContent": "-"
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at',
                            "defaultContent": "-"
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
                        }
                    ],
                });

                $(document).on('click', '.detailPlaceButton', function(e) {
                    e.preventDefault();
                    $('#detailPlaceModal').modal('show');
                    var id = $(this).attr('id');
                    $.ajax({
                        type: "GET",
                        url: "/management/master/get-detail-data/" + id,
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response);
                            $('#detailTitle').val(response.data.title);
                            $('#description').val(response.data.description);
                            $('#created_by').val(response.data.creator_id.email);
                            $('#updated_at').val(response.data.updated_at);
                            $('#created_at').val(response.data.created_at);
                            $('#total_event').val(response.total_event);

                        },
                        error: function(err) {
                           console.log(err);
                        }

                    });
                });

                /* Delete Function */
                $(document).on('click', '.delete', function(e) {
                    e.preventDefault();
                    var id = $(this).attr('id');
                    Swal.fire({
                        customClass: {
                            confirmButton: "btn btn-success",
                            cancelButton: "btn btn-danger"
                        },
                        title: "Are you sure?",
                        text: "Permanently delete data",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, Delete It!",
                        cancelButtonText: "No, cancel!",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "DELETE",
                                url: "/management/master/place/" + id + "/delete",
                                dataType: "json",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    console.log(response);
                                    if (response.success) {
                                        Swal.fire({
                                            title: response.success,
                                            text: response.success,
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        });
                                        $('#dataTablePlace').DataTable().ajax.reload();
                                    }
                                    if (response.errors) {
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
                                    // Swal.fire({
                                    //     title: 'User Not Found !',
                                    //     icon: 'error',
                                    //     confirmButtonText: 'OK'
                                    // })
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
