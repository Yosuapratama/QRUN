@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Management Place Admin - QRUN Website</title>
    @endpush

    @push('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <style>
            /* Sort Select Styling */
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

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 text-gray-800 font-weight-bold m-2">Management Place</h1>
        {{-- <button class="btn btn-success m-2" data-bs-toggle="modal" data-bs-target="#addUserModal">Add Place</button> --}}
        <!-- Filters Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h6 class="m-0 font-weight-bold text-primary">Filters</h6>
                    <small class="text-secondary">Refine the list by title, place code, views, description, creator,
                        province, regency, district, village, and update date.</small>
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
                        <label for="filter-title" class="small font-weight-bold text-dark">Title</label>
                        <input type="text" class="form-control form-control-sm" id="filter-title"
                            placeholder="Search title">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="filter-place-code" class="small font-weight-bold text-dark">Place Code</label>
                        <input type="text" class="form-control form-control-sm" id="filter-place-code"
                            placeholder="Search place code">
                    </div>
                    {{-- <div class="col-md-3 mb-3">
                        <label for="filter-views" class="small font-weight-bold text-dark">Views</label>
                        <input type="text" class="form-control form-control-sm" id="filter-views"
                            placeholder="Search views">
                    </div> --}}
                    <div class="col-md-3 mb-3">
                        <label for="filter-description" class="small font-weight-bold text-dark">Description</label>
                        <input type="text" class="form-control form-control-sm" id="filter-description"
                            placeholder="Search description">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="filter-creator" class="small font-weight-bold text-dark">Created By</label>
                        <input type="text" class="form-control form-control-sm" id="filter-creator"
                            placeholder="Search created by">
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-3 mb-3">
                        <label for="filter-province" class="small font-weight-bold text-dark">Province</label>
                        <select class="form-control form-control-sm select2-location" id="filter-province"
                            placeholder="Search province"></select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="filter-regency" class="small font-weight-bold text-dark">Regency</label>
                        <select class="form-control form-control-sm select2-location" id="filter-regency"
                            placeholder="Search regency" disabled></select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="filter-district" class="small font-weight-bold text-dark">District</label>
                        <select class="form-control form-control-sm select2-location" id="filter-district"
                            placeholder="Search district" disabled></select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="filter-village" class="small font-weight-bold text-dark">Village</label>
                        <select class="form-control form-control-sm select2-location" id="filter-village"
                            placeholder="Search village" disabled></select>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-3 mb-3">
                        <label for="filter-updated-range" class="small font-weight-bold text-dark">
                            Updated Date Range
                        </label>

                        <input type="text" class="form-control form-control-sm" id="filter-updated-range"
                            placeholder="Select date range" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
        <!-- Data Table Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h6 class="m-0 font-weight-bold text-primary">Place Table</h6>
                    <small class="text-secondary">
                        Tap any action on the right to manage or view more details.
                    </small>
                </div>

                <div class="mt-3 mt-md-0">
                    {{-- <a href="{{ route('place.create') }}"
                        class="btn btn-primary btn-sm shadow-sm {{ Route::is('place.create') ? 'active' : '' }}">
                        <i class="fas fa-plus mr-1"></i>
                        @lang('messages.navigation_admin.manage_place.create_place')
                    </a> --}}
                    <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">

                        {{-- Download Excel --}}
                        <button id="download-excel-place" class="btn btn-success btn-sm shadow-sm mr-2">
                            <i class="fas fa-file-excel mr-1"></i>
                            Download Excel
                        </button>
                        {{-- Column Visibility --}}
                        <div class="dropdown">
                            <button class="mr-2 btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                                id="columnVisibilityDropdown" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa-columns mr-1"></i>
                                Columns
                            </button>

                            <div class="dropdown-menu dropdown-menu-right p-3 shadow"
                                aria-labelledby="columnVisibilityDropdown" style="min-width: 230px;">

                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input toggle-column" id="toggle-title"
                                        data-column="0" checked>
                                    <label class="custom-control-label" for="toggle-title">
                                        Title
                                    </label>
                                </div>

                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input toggle-column"
                                        id="toggle-place-code" data-column="1" checked>
                                    <label class="custom-control-label" for="toggle-place-code">
                                        Place Code
                                    </label>
                                </div>

                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input toggle-column" id="toggle-views"
                                        data-column="2" checked>
                                    <label class="custom-control-label" for="toggle-views">
                                        Views
                                    </label>
                                </div>

                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input toggle-column"
                                        id="toggle-description" data-column="3" checked>
                                    <label class="custom-control-label" for="toggle-description">
                                        Description
                                    </label>
                                </div>

                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input toggle-column"
                                        id="toggle-created-by" data-column="4" checked>
                                    <label class="custom-control-label" for="toggle-created-by">
                                        Created By
                                    </label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input toggle-column"
                                        id="toggle-updated-at" data-column="5" checked>
                                    <label class="custom-control-label" for="toggle-updated-at">
                                        Updated At
                                    </label>
                                </div>

                            </div>
                        </div>

                        <a href="{{ route('place.create') }}"
                            class="btn btn-primary btn-sm shadow-sm {{ Route::is('place.create') ? 'active' : '' }}">
                            <i class="fas fa-plus mr-1"></i>
                            @lang('messages.navigation_admin.manage_place.create_place')
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="dataTablePlace" width="100%"
                        cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>Title</th>
                                <th>Place Code</th>
                                <th>Views</th>
                                <th>Description</th>
                                <th>Created By</th>
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
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script>
            $(document).ready(function() {
                let updatedAtStart = '';
                let updatedAtEnd = '';

                // Keep "Columns" dropdown open
                $('#columnVisibilityDropdown')
                    .siblings('.dropdown-menu')
                    .on('click', function(e) {
                        e.stopPropagation();
                    });
                $('#filter-updated-range').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear',
                        format: 'YYYY-MM-DD'
                    }
                });

                $('#filter-updated-range').on('apply.daterangepicker', function(ev, picker) {

                    updatedAtStart = picker.startDate.format('YYYY-MM-DD');
                    updatedAtEnd = picker.endDate.format('YYYY-MM-DD');

                    $(this).val(
                        updatedAtStart + ' - ' + updatedAtEnd
                    );

                    dataTablePlace.ajax.reload();
                });

                $('#filter-updated-range').on('cancel.daterangepicker', function() {

                    $(this).val('');

                    updatedAtStart = '';
                    updatedAtEnd = '';

                    dataTablePlace.ajax.reload();
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
                        dataTablePlace.ajax.reload();
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
                        dataTablePlace.ajax.reload();
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
                        dataTablePlace.ajax.reload();
                    }
                });

                $('#filter-village').on('change', function() {

                    if (isUpdatingCascade) return;

                    if (!isClearingFilters) {
                        dataTablePlace.ajax.reload();
                    }
                });
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
                var dataTablePlace = $('#dataTablePlace').DataTable({
                    'createdRow': function(row, data, dataIndex) {
                        $('td:eq(0)', row).css('min-width', '200px');
                        $('td:eq(1)', row).css('min-width', '150px');
                        $('td:eq(2)', row).css('min-width', '200px');
                        $('td:eq(3)', row).css('min-width', '200px');
                        $('td:eq(4)', row).css('min-width', '200px');
                        $('td:eq(5)', row).css('min-width', '180px');

                        // last column (Action)
                        $('td:last', row).css({
                            'text-align': 'center',
                            'vertical-align': 'middle',
                            'min-width': '140px'
                        });
                    },
                    filter: true,
                    processing: true,
                    serverSide: true,
                    order: [],
                    dom: '<"top"<"dataTables_length"l><"dataTables_filter"f>><"table-responsive-wrapper"rt><"bottom"<"dataTables_info"i><"dataTables_paginate"p>>',
                    ajax: {
                        url: "{{ route('place') }}",
                        data: function(d) {
                            d.title = $('#filter-title').val();
                            d.place_code = $('#filter-place-code').val();
                            // d.views = $('#filter-views').val();
                            d.description = $('#filter-description').val();
                            d.creator = $('#filter-creator').val();
                            d.province = $('#filter-province').val();
                            d.regency = $('#filter-regency').val();
                            d.district = $('#filter-district').val();
                            d.village = $('#filter-village').val();
                            d.updated_at_start = updatedAtStart;
                            d.updated_at_end = updatedAtEnd;
                            d.sort_by = $('#sort-order').val();
                        }
                    },
                    columns: [{
                            data: 'title',
                            name: 'title',
                            orderable: true
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
                            name: 'views'
                        },
                        {
                            data: 'description',
                            name: 'description'
                        },
                        {
                            data: 'creator_email',
                            name: 'users.email',
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

                // ===============================
                // COLUMN VISIBILITY TOGGLE
                // ===============================

                // ===============================
                // COLUMN VISIBILITY TOGGLE
                // ===============================

                const STORAGE_KEY = 'place_table_column_visibility';

                // default semua visible
                const defaultColumns = {
                    0: true, // Title
                    1: true, // Place Code
                    2: true, // Views
                    3: true, // Description
                    4: true, // Created By
                    5: true // Updated At
                };

                // ambil state dari localStorage
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

                // save state ke localStorage
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

                // minimal 1 column visible
                function updateColumnCheckboxState() {

                    const checkedCount = $('.toggle-column:checked').length;

                    $('.toggle-column').prop('disabled', false);

                    if (checkedCount <= 1) {
                        $('.toggle-column:checked')
                            .prop('disabled', true);
                    }
                }

                // apply saved state
                function applySavedColumnState() {

                    const savedState = getSavedColumnState();

                    $('.toggle-column').each(function() {

                        const columnIndex = $(this).data('column');
                        const isVisible = savedState[columnIndex] ?? true;

                        $(this).prop('checked', isVisible);

                        dataTablePlace
                            .column(columnIndex)
                            .visible(isVisible, false);
                    });

                    dataTablePlace.columns.adjust().draw(false);

                    updateColumnCheckboxState();
                }

                // toggle visibility
                $('.toggle-column').on('change', function() {

                    const columnIndex = $(this).data('column');
                    const isVisible = $(this).is(':checked');

                    dataTablePlace
                        .column(columnIndex)
                        .visible(isVisible);

                    saveColumnState();

                    updateColumnCheckboxState();
                });

                // initial load from localStorage
                applySavedColumnState();
                // Custom processing handler for better UX
                $(document).on('processing.dt', function(e, settings, processing) {
                    if (processing) {
                        $('.dataTables_processing').addClass('show');
                    } else {
                        $('.dataTables_processing').removeClass('show');
                    }
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

                // Filter event listeners for text inputs and date
                const reloadTableDebounced = debounce(function() {
                    dataTablePlace.ajax.reload();
                }, 500);

                $('#filter-title, #filter-place-code, #filter-description, #filter-creator')
                    .on('keyup', function() {
                        reloadTableDebounced();
                    });

                $('#filter-updated-at-start, #filter-updated-at-end')
                    .on('change', function() {
                        dataTablePlace.ajax.reload();
                    });

                $('#sort-order').on('change', function() {
                    var value = $(this).val();
                    if (value === 'views') {
                        dataTablePlace.order([2, 'desc']).draw();
                    } else if (value === 'name') {
                        dataTablePlace.order([0, 'asc']).draw();
                    } else if (value === 'place_code') {
                        dataTablePlace.order([1, 'asc']).draw();
                    } else {
                        dataTablePlace.order([]).draw();
                    }
                    dataTablePlace.ajax.reload();
                });

                $('#download-excel-place').on('click', function() {

                    const params = new URLSearchParams({
                        title: $('#filter-title').val() || '',
                        place_code: $('#filter-place-code').val() || '',
                        description: $('#filter-description').val() || '',
                        creator: $('#filter-creator').val() || '',
                        province: $('#filter-province').val() || '',
                        regency: $('#filter-regency').val() || '',
                        district: $('#filter-district').val() || '',
                        village: $('#filter-village').val() || '',
                        updated_at_start: updatedAtStart || '',
                        updated_at_end: updatedAtEnd || '',
                        sort_by: $('#sort-order').val() || ''
                    });

                    window.location.href =
                        "{{ route('report.excel.place') }}?" +
                        params.toString();
                });

                $('#clear-filters').on('click', function() {
                    isClearingFilters = true;
                    isUpdatingCascade = true;

                    $('#filter-title').val('');
                    $('#filter-place-code').val('');
                    // $('#filter-views').val('');
                    $('#filter-description').val('');
                    $('#filter-creator').val('');
                    $('#filter-province').val(null).trigger('change');
                    $('#filter-regency').val(null).trigger('change');
                    $('#filter-district').val(null).trigger('change');
                    $('#filter-village').val(null).trigger('change');
                    $('#filter-updated-range').val('');
                    updatedAtStart = '';
                    updatedAtEnd = '';
                    $('#sort-order').val('');

                    isClearingFilters = false;
                    isUpdatingCascade = false;
                    $('#dataTablePlace').DataTable().ajax.reload();
                });

                $(document).on('click', '.detailPlaceButton', function(e) {
                    e.preventDefault();
                    var id = $(this).attr('id');
                    $.ajax({
                        type: "GET",
                        url: "/management/master/get-detail-data/" + id,
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#detailTitle').val(response.data.title);
                            $('#description').val(response.data.description);
                            $('#created_by').val(response.data.creator_id?.email ?? '-');
                            $('#updated_at').val(response.data.updated_at);
                            $('#detailPhoneNumber').val(response.data.phone_num ?? '-');
                            $('#created_at').val(response.data.created_at);
                            $('#total_event').val(response.total_event);

                            console.log(response.data);
                            $('#detailPlaceModal').modal('show');

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
