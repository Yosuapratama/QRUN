@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Detail Activities - QRUN Website</title>
    @endpush
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 text-gray-800 font-weight-bold m-2">Activity Log</h1>
        {{-- <button class="btn btn-success m-2" data-bs-toggle="modal" data-bs-target="#addEventModal">@lang('messages.my-event.add_event')</button> --}}
        {{-- <button class="btn btn-success m-2" data-bs-toggle="modal" data-bs-target="#addUserModal">Add Place</button> --}}
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Filter Table</h6>
            </div>
            <div class="card-body">

                <form id="form-filter">
                    <div class="row">
                        <div class="form-group col-md-5 col-12 mb-3">
                            <label class="form-label" for="select2classes">Type<span class="text-danger"
                                    style="font-size: 12px">*</span></label>
                            <select name="marketing_group_id" class="select2 form-control" id="select2classes">
                                <option value="">All</option>
                                <option value="LOGIN">Login</option>
                                <option value="LOGIN_GOOGLE">Login Google</option>
                                <option value="REGISTER">Register</option>
                                <option value="LOGOUT">Logout</option>
                                <option value="CREATE_COMMENT">Create comment</option>
                                <option value="UPDATE_COMMENT">Update comment</option>
                                <option value="DELETE_COMMENT">Delete comment</option>
                                <option value="CREATE_EVENT">Create event</option>
                                <option value="UPDATE_EVENT">Update event</option>
                                <option value="DELETE_EVENT">Delete event</option>
                                <option value="CREATE_PLACE">Create place</option>
                                <option value="UPDATE_PLACE">Update place</option>
                                <option value="DELETE_PLACE">Delete place</option>
                                <option value="CREATE_PLACE_LIMIT">Create place limit</option>
                                <option value="UPDATE_PLACE_LIMIT">Update place limit</option>
                                <option value="DELETE_PLACE_LIMIT">Delete place limit</option>
                                <option value="UPDATE_SETTINGS">Update settings</option>
                                <option value="CREATE_USER">Create user</option>
                                <option value="UPDATE_USER">Update user</option>
                                <option value="DELETE_USER">Delete user</option>
                                <option value="RESTORE_USER">Restore user</option>
                                <option value="UPDATE_PROFILE_USER">Update profile user</option>
                                <option value="APPROVE_USER">Approve user</option>
                                <option value="UNAPPROVE_USER">Unapprove user</option>
                                <option value="VERIFY_USER">Verify user</option>
                                <option value="CREATE_USER_LIMIT">Create user limit</option>
                                <option value="UPDATE_USER_LIMIT">Update user limit</option>
                                <option value="DELETE_USER_LIMIT">Delete user limit</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="startDate">Start Date:</label>
                            <input type="date" id="startDate" class="form-control" name="startDate"
                                placeholder="Select Start Date">

                        </div>
                        <div class="form-group ml-2">
                            <label for="endDate">End Date:</label>
                            <input type="date" id="endDate" class="form-control" name="endDate"
                                placeholder="Select End Date">

                        </div>
                        {{-- <div class="form-group col-md-5 col-12 mb-3">
                            <label class="form-label" for="select2-section">Section<span class="text-danger"
                                    style="font-size: 12px">*</span></label>
                            <select name="section_filter" class="select2 form-control" id="select2-section">
                                <option value="">All</option>
                                {{-- @foreach ($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->section }}</option>
                                @endforeach --}}


                        {{-- </select>  --}}
                        {{-- </div> --}}

                    </div>
                    <div class="d-flex flex-wrap justify-content-end gap-3 mt-3">
                        <button type="submit" class="btn btn-success waves-effect waves-light mr-2">Filter</button>
                        <button type="reset" class="btn btn-outline-danger waves-effect waves-light ">Reset</button>
                    </div>
                </form>

            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Log Table</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTableEvent" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Ip</th>
                                <th>User Agent</th>
                                <th>Email</th>
                                <th>Activities</th>
                                <th>type</th>
                                {{-- <th class="text-center">Action</th> --}}
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
                var selectedTypeValue = "";

                $("#select2classes").select2();

                $("#select2classes").on('change', function() {
                    selectedTypeValue = $(this).val();
                });

                var today = new Date();

                // Get the first day of the current month
                var firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);

                // Format the date as YYYY-MM-DD
                var formattedDate = firstDayOfMonth.toISOString().split('T')[0];

                // Set the value of the startDate input field
                $('#startDate').val(formattedDate);




                $("#form-filter").on('reset', function(e) {
                    window.location.reload();
                    var selectedTypeValue = '';
                })

                $("#form-filter").submit(function(e) {
                    e.preventDefault();
                    $('#dataTableEvent').DataTable().ajax.reload();
                });

                $('#dataTableEvent').DataTable({
                    'createdRow': function(row, data, dataIndex) {
                        $('td:eq(0)', row).css('min-width', '200px');
                        $('td:eq(1)', row).css('min-width', '150px');
                        $('td:eq(2)', row).css('min-width', '200px');
                    },
                    filter: true,
                    processing: true,
                    serverSide: false,
                    // ajax: "{{ route('settings.log-activity') }}",
                    ajax: {
                        url: "{{ route('settings.log-activity') }}",
                        data: function(d) {
                            d.type = selectedTypeValue,
                                d.startDate = $("#startDate").val(),
                                d.endDate = $("#endDate").val()
                        }
                    },
                    columns: [{
                            data: 'ip_address',
                            name: 'ip_address',
                            orderable: true
                        }, {
                            name: 'user_agent',
                            data: 'user_agent'
                        },

                        {
                            data: 'email',
                            name: 'email',
                            "defaultContent": "-"
                        },
                        {
                            data: 'activities',
                            name: 'activities',
                            orderable: false
                        },
                        {
                            data: 'type',
                            name: 'type',
                            orderable: true
                        }
                    ],
                });
            });
        </script>
    @endpush
    <!-- End of Main Content -->
@endsection
