@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Management Place Limit Admin - QRUN Website</title>
    @endpush
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 text-gray-800 font-weight-bold m-2">Management Place Limit</h1>
        <a class="btn btn-success m-2" href="{{route('place-limit.create')}}">Add Place Limit</a>
        @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
         @endif
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Table</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTablePlace" width="100%" cellspacing="0">
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
                $('#dataTablePlace').DataTable({
                    // 'createdRow': function(row, data, dataIndex) {
                    //     $('td:eq(0)', row).css('min-width', '200px');
                    //     $('td:eq(1)', row).css('min-width', '150px');
                    //     $('td:eq(2)', row).css('min-width', '200px');
                    //     $('td:eq(3)', row).css('min-width', '200px');
                    //     $('td:eq(4)', row).css('min-width', '200px');
                    //     $('td:eq(5)', row).css('min-width', '120px');
                    // },
                    filter: true,
                    processing: true,
                    serverSide: false,
                    ajax: "{{ route('place-limit.index') }}",
                    columns: [{
                            data: 'name',
                            name: 'name',
                            orderable: true
                        },
                        {
                            data: 'total_limit',
                            name: 'total_limit'
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
