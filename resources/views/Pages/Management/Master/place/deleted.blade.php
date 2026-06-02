@extends('TemplateLayout.AdminLayout')

@section('content')
    @push('title')
        <title>Deleted Place Admin - QRUN Website</title>
    @endpush

    @push('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

        <style>
            #sort-order {
                border-radius: 4px;
                border: 1px solid #dee2e6;
                padding: 0.375rem 2.5rem 0.375rem 0.75rem;
                background: #fff;
                appearance: none;
                color: #495057;
                font-size: .875rem;
                cursor: pointer;
            }

            #sort-order:hover {
                border-color: #4e73df;
                background-color: #f8f9ff;
            }

            .form-control-sm {
                border-radius: 4px;
                border: 1px solid #dee2e6;
            }

            .form-control-sm:focus {
                border-color: #4e73df;
                box-shadow: 0 0 0 3px rgba(78, 115, 223, .1);
            }

            #clear-filters:hover {
                background-color: #4e73df;
                color: #fff;
                border-color: #4e73df;
            }

            #dataTablePlaceDeleted thead th {
                background-color: #f8f9fa;
                border-bottom: 2px solid #dee2e6;
                font-weight: 600;
            }

            #dataTablePlaceDeleted tbody tr:hover {
                background-color: #f8f9ff;
            }

            .dataTables_processing {
                color: #4e73df;
                font-weight: 600;
            }
        </style>
    @endpush

    <div class="container-fluid">

        <h1 class="h3 text-gray-800 font-weight-bold m-2">
            Deleted Place
        </h1>

        {{-- FILTERS --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h6 class="m-0 font-weight-bold text-primary">
                        Filters
                    </h6>

                    <small class="text-secondary">
                        Refine deleted place list by title, place code,
                        creator, location, and deleted date.
                    </small>
                </div>

                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2 mt-3 mt-md-0">
                    <select class="form-control form-control-sm" id="sort-order" style="min-width: 220px;">
                        <option value="">Sort by</option>
                        <option value="views">Views</option>
                        <option value="name">Name</option>
                        <option value="place_code">Place Code</option>
                    </select>
                    <button class="btn btn-outline-secondary btn-sm" id="clear-filters"
                        style="height: calc(1.5em + 0.75rem + 2px); min-width: 140px;">Clear Filters</button>
                </div>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold text-dark">
                            Title
                        </label>

                        <input type="text" class="form-control form-control-sm" id="filter-title"
                            placeholder="Search title">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold text-dark">
                            Place Code
                        </label>

                        <input type="text" class="form-control form-control-sm" id="filter-place-code"
                            placeholder="Search place code">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold text-dark">
                            Description
                        </label>

                        <input type="text" class="form-control form-control-sm" id="filter-description"
                            placeholder="Search description">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold text-dark">
                            Created By
                        </label>

                        <input type="text" class="form-control form-control-sm" id="filter-creator"
                            placeholder="Search creator">
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-3 mb-3">
                        <label>Province</label>
                        <select class="form-control form-control-sm select2-location" id="filter-province"></select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Regency</label>
                        <select class="form-control form-control-sm select2-location" id="filter-regency" disabled></select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>District</label>
                        <select class="form-control form-control-sm select2-location" id="filter-district"
                            disabled></select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Village</label>
                        <select class="form-control form-control-sm select2-location" id="filter-village" disabled></select>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold text-dark">
                            Deleted Date Range
                        </label>

                        <input type="text" class="form-control form-control-sm" id="filter-deleted-range"
                            placeholder="Select date range">
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Deleted Place Table
                </h6>

                <small class="text-secondary">
                    View deleted places and restore them.
                </small>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="dataTablePlaceDeleted" width="100%">

                        <thead class="thead-light">
                            <tr>
                                <th>Title</th>
                                <th>Place Code</th>
                                <th>Views</th>
                                <th>Description</th>
                                <th>Created By</th>
                                <th>Deleted At</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <script>
            $(document).ready(function() {

                let deletedAtStart = '';
                let deletedAtEnd = '';

                $('#filter-deleted-range').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear',
                        format: 'YYYY-MM-DD'
                    }
                });

                $('#filter-deleted-range').on('apply.daterangepicker',
                    function(ev, picker) {

                        deletedAtStart = picker.startDate.format('YYYY-MM-DD');
                        deletedAtEnd = picker.endDate.format('YYYY-MM-DD');

                        $(this).val(
                            deletedAtStart + ' - ' + deletedAtEnd
                        );

                        dataTable.ajax.reload();
                    });

                $('#filter-deleted-range').on('cancel.daterangepicker',
                    function() {

                        $(this).val('');
                        deletedAtStart = '';
                        deletedAtEnd = '';

                        dataTable.ajax.reload();
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

                // Initialize Select2 for provinces
                $('#filter-province').select2({
                    allowClear: true,
                    width: '100%',
                    placeholder: 'Search province...',
                    ajax: {
                        url: "{{ route('place.search.provinces') }}",
                        dataType: 'json',
                        delay: 300,
                        data: function(params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.results
                            };
                        }
                    }
                });

                // Initialize Select2 for regencies
                $('#filter-regency').select2({
                    allowClear: true,
                    width: '100%',
                    placeholder: 'Search regency...',
                    ajax: {
                        url: "{{ route('place.search.regencies') }}",
                        dataType: 'json',
                        delay: 300,
                        data: function(params) {
                            return {
                                q: params.term,
                                province_id: $('#filter-province').val()
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.results
                            };
                        }
                    }
                });

                // Initialize Select2 for districts
                $('#filter-district').select2({
                    allowClear: true,
                    width: '100%',
                    placeholder: 'Search district...',
                    ajax: {
                        url: "{{ route('place.search.districts') }}",
                        dataType: 'json',
                        delay: 300,
                        data: function(params) {
                            return {
                                q: params.term,
                                regency_id: $('#filter-regency').val()
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.results
                            };
                        }
                    }
                });

                // Initialize Select2 for villages
                $('#filter-village').select2({
                    allowClear: true,
                    width: '100%',
                    placeholder: 'Search village...',
                    ajax: {
                        url: "{{ route('place.search.villages') }}",
                        dataType: 'json',
                        delay: 300,
                        data: function(params) {
                            return {
                                q: params.term,
                                district_id: $('#filter-district').val()
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.results
                            };
                        }
                    }
                });


                let isClearingFilters = false;
                let isUpdatingCascade = false;

                $('#filter-province').on('change', function() {

                    isUpdatingCascade = true;

                    $('#filter-regency')
                        .val(null)
                        .trigger('change.select2')
                        .prop('disabled', !this.value);

                    $('#filter-district')
                        .val(null)
                        .trigger('change.select2')
                        .prop('disabled', true);

                    $('#filter-village')
                        .val(null)
                        .trigger('change.select2')
                        .prop('disabled', true);

                    isUpdatingCascade = false;

                    if (!isClearingFilters) {
                        dataTable.ajax.reload();
                    }
                });

                $('#filter-regency').on('change', function() {

                    if (isUpdatingCascade) return;

                    isUpdatingCascade = true;

                    $('#filter-district')
                        .val(null)
                        .trigger('change.select2')
                        .prop('disabled', !this.value);

                    $('#filter-village')
                        .val(null)
                        .trigger('change.select2')
                        .prop('disabled', true);

                    isUpdatingCascade = false;

                    if (!isClearingFilters) {
                        dataTable.ajax.reload();
                    }
                });

                $('#filter-district').on('change', function() {

                    if (isUpdatingCascade) return;

                    isUpdatingCascade = true;

                    $('#filter-village')
                        .val(null)
                        .trigger('change.select2')
                        .prop('disabled', !this.value);

                    isUpdatingCascade = false;

                    if (!isClearingFilters) {
                        dataTable.ajax.reload();
                    }
                });

                $('#filter-village').on('change', function() {

                    if (isUpdatingCascade) return;

                    if (!isClearingFilters) {
                        dataTable.ajax.reload();
                    }
                });
                $(document).on('click', '.copy-place-code', async function(e) {
                    e.preventDefault();

                    const placeCode = $(this).data('code');

                    try {
                        await navigator.clipboard.writeText(placeCode);

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Place code copied',
                            text: placeCode,
                            showConfirmButton: false,
                            timer: 1800,
                            timerProgressBar: true
                        });

                    } catch (err) {

                        // fallback old browser
                        const tempInput = document.createElement('input');
                        tempInput.value = placeCode;
                        document.body.appendChild(tempInput);

                        tempInput.select();
                        document.execCommand('copy');

                        document.body.removeChild(tempInput);

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Place code copied',
                            text: placeCode,
                            showConfirmButton: false,
                            timer: 1800,
                            timerProgressBar: true
                        });
                    }
                });


                const reloadTableDebounced = debounce(function() {
                    dataTable.ajax.reload();
                }, 500);

                $('#filter-title, #filter-place-code, #filter-description, #filter-creator')
                    .on('keyup', reloadTableDebounced);

                var dataTable = $('#dataTablePlaceDeleted').DataTable({

                    processing: true,
                    serverSide: true,
                    order: [],
                    dom: '<"top"<"dataTables_length"l><"dataTables_filter"f>><"table-responsive-wrapper"rt><"bottom"<"dataTables_info"i><"dataTables_paginate"p>>',
                    createdRow: function(row, data, dataIndex) {
                        $('td:eq(0)', row).css('min-width', '220px'); // title
                        $('td:eq(1)', row).css('min-width', '170px'); // place code
                        $('td:eq(2)', row).css('min-width', '120px'); // views
                        $('td:eq(3)', row).css('min-width', '220px'); // description
                        $('td:eq(4)', row).css('min-width', '180px'); // creator
                        $('td:eq(5)', row).css('min-width', '180px'); // deleted at
                        $('td:eq(6)', row).css('min-width', '150px'); // action
                    },
                    ajax: {
                        url: "{{ route('place.getDeleted') }}",
                        data: function(d) {
                            d.title = $('#filter-title').val();
                            d.place_code = $('#filter-place-code').val();
                            d.description = $('#filter-description').val();
                            d.creator = $('#filter-creator').val();

                            d.province = $('#filter-province').val();
                            d.regency = $('#filter-regency').val();
                            d.district = $('#filter-district').val();
                            d.village = $('#filter-village').val();

                            d.deleted_at_start = deletedAtStart;
                            d.deleted_at_end = deletedAtEnd;

                            d.sort_by = $('#sort-order').val();
                        }
                    },

                    columns: [{
                            data: 'title',
                            name: 'title'
                        },
                        {
                            data: 'place_code',
                            name: 'place_code',
                            render: function(data, type, row) {

                                if (type === 'display') {
                                    return `
                                        <button
                                            type="button"
                                            class="btn btn-link btn-sm p-0 copy-place-code"
                                            data-code="${data}"
                                            title="Click to copy"
                                            style="font-weight:600; text-decoration:none;"
                                        >
                                            ${data}
                                        </button>
                                    `;
                                }

                                return data;
                            }
                        },
                        {
                            data: 'views',
                            name: 'views',
                            defaultContent: '-'
                        },
                        {
                            data: 'description',
                            name: 'description'
                        },
                        {
                            data: 'creator_email',
                            name: 'users.email',
                            defaultContent: '-'
                        },
                        {
                            data: 'deleted_at',
                            name: 'deleted_at'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            searchable: false,
                            orderable: false
                        }
                    ]
                });

                $('#sort-order').on('change', function() {

                    let value = $(this).val();

                    if (value === 'views') {
                        dataTable.order([2, 'desc']).draw();
                    } else if (value === 'name') {
                        dataTable.order([0, 'asc']).draw();
                    } else if (value === 'place_code') {
                        dataTable.order([1, 'asc']).draw();
                    } else {
                        dataTable.order([]).draw();
                    }
                });

                $('#clear-filters').click(function() {

                    isClearingFilters = true;
                    isUpdatingCascade = true;

                    $('#filter-title').val('');
                    $('#filter-place-code').val('');
                    $('#filter-description').val('');
                    $('#filter-creator').val('');

                    $('#filter-province').val(null).trigger('change');
                    $('#filter-regency').val(null).trigger('change');
                    $('#filter-district').val(null).trigger('change');
                    $('#filter-village').val(null).trigger('change');

                    $('#filter-deleted-range').val('');

                    deletedAtStart = '';
                    deletedAtEnd = '';

                    $('#sort-order').val('');


                    isClearingFilters = false;
                    isUpdatingCascade = false;
                    dataTable.ajax.reload();
                });

                $(document).on('click', '.restore', function() {

                    let id = $(this).data('id');

                    Swal.fire({
                        title: 'Restore Place?',
                        text: 'This place will be restored.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes'
                    }).then((result) => {

                        if (result.isConfirmed) {

                            $.ajax({
                                type: 'POST',
                                url: '/management/master/place/' + id + '/restore',
                                headers: {
                                    'X-CSRF-TOKEN': $(
                                        'meta[name="csrf-token"]'
                                    ).attr('content')
                                },

                                success: function(response) {

                                    Swal.fire(
                                        'Success',
                                        response.message ??
                                        'Place restored successfully',
                                        'success'
                                    );

                                    dataTable.ajax.reload();
                                }
                            });
                        }
                    });
                });

            });
        </script>
    @endpush
@endsection
