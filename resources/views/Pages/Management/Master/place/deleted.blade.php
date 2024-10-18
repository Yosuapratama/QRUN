@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Deleted Place Admin - QRUN Website</title>
    @endpush
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 text-gray-800 font-weight-bold m-2">Deleted Place/Object</h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Deleted Place Table</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTablePlaceDeleted" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Created_By</th>
                                <th>Updated_at</th>
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
                $('#dataTablePlaceDeleted').DataTable({
                    'createdRow': function(row, data, dataIndex) {
                        $('td:eq(0)', row).css('min-width', '200px');
                        $('td:eq(1)', row).css('min-width', '200px');
                        $('td:eq(5)', row).css('min-width', '120px');
                    },
                    filter: true,
                    processing: true,
                    serverSide: false,
                    ajax: "{{ route('place.getDeleted') }}",
                    columns: [{
                            data: 'title',
                            name: 'title',
                            orderable: true
                        }, {
                            data: 'description',
                            name: 'description'
                        },
                        {
                            data: 'creator_id.email',
                            name: 'creator_id.email',
                            "defaultContent":"-"
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at',
                            "defaultContent":"-"
                        }
                    ],
                });
            });
        </script>
    @endpush
    <!-- End of Main Content -->
@endsection
