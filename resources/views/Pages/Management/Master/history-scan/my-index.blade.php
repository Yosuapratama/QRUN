@extends('TemplateLayout.AdminLayout')

@section('content')
    @push('title')
        <title>History Scan - QRUN</title>
    @endpush

    @push('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <style>
            .form-control-sm { border-radius: 4px; border: 1px solid #dee2e6; transition: all .3s ease; }
            .form-control-sm:focus { border-color: #4e73df; box-shadow: 0 0 0 3px rgba(78,115,223,.1); }

            #clear-filters {
                border-radius: 4px; border: 1px solid #dee2e6;
                transition: all .3s ease; font-weight: 500;
                height: calc(1.5em + .75rem + 2px); min-width: 140px;
            }
            #clear-filters:hover { background: #4e73df; color: white; border-color: #4e73df; }

            .table-responsive { border-radius: 4px; overflow: hidden; }

            #historyScanTable { border-collapse: collapse; width: 100%; }
            #historyScanTable thead th {
                background-color: #f8f9fa;
                border-bottom: 2px solid #dee2e6;
                font-weight: 600; color: #495057; padding: 12px;
            }
            #historyScanTable tbody tr { border-bottom: 1px solid #dee2e6; }
            #historyScanTable tbody tr:hover { background-color: #f8f9ff; }
            #historyScanTable td { padding: 12px; vertical-align: middle; }

            .dataTables_info { padding-top: 1rem; color: #858796; font-size: .875rem; }
            .dataTables_wrapper { padding: 0; }
            .dataTables_wrapper .row { margin: 0 -5px; }
            .dataTables_wrapper .row > div { padding: 0 5px; }

            .dropdown-menu { border-radius: 10px; }
            .toggle-column:disabled + .custom-control-label { opacity: .5; cursor: not-allowed; }
        </style>
    @endpush

    <div class="container-fluid">

        <h1 class="h3 text-gray-800 font-weight-bold m-2">{{ __('messages.management.history_scan.page_title') }}</h1>

        {{-- FILTER CARD --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('messages.management.history_scan.filter_title') }}</h6>
                    <small class="text-secondary">{{ __('messages.management.history_scan.filter_subtitle_my') }}</small>
                </div>
                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2 mt-3 mt-md-0">
                    <button class="btn btn-outline-secondary btn-sm" id="clear-filters"
                        style="height: calc(1.5em + .75rem + 2px); min-width: 140px;">{{ __('messages.management.history_scan.reset_filter') }}</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="small font-weight-bold text-dark">{{ __('messages.management.history_scan.label_place_code') }}</label>
                        <input type="text" class="form-control form-control-sm" id="filter-place-code" placeholder="{{ __('messages.management.history_scan.ph_place_code') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="small font-weight-bold text-dark">{{ __('messages.management.history_scan.label_daterange') }}</label>
                        <input type="text" class="form-control form-control-sm" id="filter-daterange"
                            placeholder="{{ __('messages.management.history_scan.ph_daterange') }}" style="cursor:pointer; background:#fff;">
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap" style="gap: 16px;">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('messages.management.history_scan.table_title') }}</h6>
                <div class="d-flex align-items-center gap-2">
                    {{-- Column Visibility --}}
                    <div class="dropdown mr-2">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                            id="columnVisibilityDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-columns mr-1"></i> {{ __('messages.management.common.columns') }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow" style="min-width:200px;">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-place-code" data-column="1" checked>
                                <label class="custom-control-label" for="toggle-place-code">{{ __('messages.management.history_scan.col_place_code') }}</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-place-title" data-column="2" checked>
                                <label class="custom-control-label" for="toggle-place-title">{{ __('messages.management.history_scan.col_place_title') }}</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-device" data-column="3" checked>
                                <label class="custom-control-label" for="toggle-device">{{ __('messages.management.history_scan.col_device') }}</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-platform" data-column="4" checked>
                                <label class="custom-control-label" for="toggle-platform">{{ __('messages.management.history_scan.col_platform') }}</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-browser" data-column="5" checked>
                                <label class="custom-control-label" for="toggle-browser">{{ __('messages.management.history_scan.col_browser') }}</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-checked-at" data-column="6" checked>
                                <label class="custom-control-label" for="toggle-checked-at">{{ __('messages.management.history_scan.col_checked_at') }}</label>
                            </div>
                        </div>
                    </div>
                    {{-- Export --}}
                    <a href="{{ route('history-scan.my-export') }}" id="btnExport" class="btn btn-success btn-sm px-3">
                        <i class="fas fa-file-excel mr-1"></i> {{ __('messages.management.history_scan.export_excel') }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="historyScanTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('messages.management.history_scan.col_place_code') }}</th>
                                <th>{{ __('messages.management.history_scan.col_place_title') }}</th>
                                <th>{{ __('messages.management.history_scan.col_device') }}</th>
                                <th>{{ __('messages.management.history_scan.col_platform') }}</th>
                                <th>{{ __('messages.management.history_scan.col_browser') }}</th>
                                <th>{{ __('messages.management.history_scan.col_checked_at') }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/moment/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script>
            let dateStart = '', dateEnd = '';

            $('#filter-daterange').daterangepicker({
                autoUpdateInput: false,
                locale: { cancelLabel: 'Clear', format: 'DD/MM/YYYY' }
            });

            $('#filter-daterange').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                dateStart = picker.startDate.format('YYYY-MM-DD');
                dateEnd   = picker.endDate.format('YYYY-MM-DD');
                table.ajax.reload();
                syncExportUrl();
            });

            $('#filter-daterange').on('cancel.daterangepicker', function() {
                $(this).val('');
                dateStart = ''; dateEnd = '';
                table.ajax.reload();
                syncExportUrl();
            });

            const table = $('#historyScanTable').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ordering: true,
                order: [[6, 'desc']],
                responsive: true,
                pageLength: 10,
                ajax: {
                    url: '{{ route('history-scan.my') }}',
                    data: function(d) {
                        d.place_code = $('#filter-place-code').val();
                        d.date_start = dateStart;
                        d.date_end   = dateEnd;
                    }
                },
                columns: [
                    { data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'place_code',   name: 'place_code' },
                    { data: 'place_title',  name: 'place_title', orderable: false },
                    { data: 'device_type',  name: 'device_type' },
                    { data: 'platform',     name: 'platform' },
                    { data: 'browser',      name: 'browser' },
                    { data: 'checked_at',   name: 'checked_at' },
                ]
            });

            // ===========================
            // FILTERS
            // ===========================
            let filterTimeout;
            $('#filter-place-code').on('input', function() {
                clearTimeout(filterTimeout);
                filterTimeout = setTimeout(function() {
                    table.ajax.reload();
                    syncExportUrl();
                }, 400);
            });

            $('#clear-filters').on('click', function() {
                $('#filter-place-code').val('');
                $('#filter-daterange').val('');
                dateStart = ''; dateEnd = '';
                table.ajax.reload();
                syncExportUrl();
            });

            function syncExportUrl() {
                const params = new URLSearchParams({
                    place_code: $('#filter-place-code').val(),
                    date_start: dateStart,
                    date_end:   dateEnd,
                });
                $('#btnExport').attr('href', '{{ route('history-scan.my-export') }}?' + params.toString());
            }

            // ===========================
            // COLUMN VISIBILITY
            // ===========================
            const STORAGE_KEY = 'my_history_scan_column_visibility';

            const defaultColumns = {
                1: true, 2: true, 3: true,
                4: true, 5: true, 6: true
            };

            function getSavedColumnState() {
                const saved = localStorage.getItem(STORAGE_KEY);
                if (!saved) return defaultColumns;
                try { return { ...defaultColumns, ...JSON.parse(saved) }; }
                catch (e) { return defaultColumns; }
            }

            function saveColumnState() {
                let state = {};
                $('.toggle-column').each(function() {
                    state[$(this).data('column')] = $(this).is(':checked');
                });
                localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
            }

            function updateColumnCheckboxState() {
                const checkedCount = $('.toggle-column:checked').length;
                $('.toggle-column').prop('disabled', false);
                if (checkedCount <= 1) {
                    $('.toggle-column:checked').prop('disabled', true);
                }
            }

            function applySavedColumnState() {
                const savedState = getSavedColumnState();
                $('.toggle-column').each(function() {
                    const col = $(this).data('column');
                    const isVisible = savedState[col] ?? true;
                    $(this).prop('checked', isVisible);
                    table.column(col).visible(isVisible, false);
                });
                table.columns.adjust().draw(false);
                updateColumnCheckboxState();
            }

            $('.toggle-column').on('change', function() {
                table.column($(this).data('column')).visible($(this).is(':checked'));
                saveColumnState();
                updateColumnCheckboxState();
            });

            $('#columnVisibilityDropdown').closest('.dropdown')
                .find('.dropdown-menu').on('click', function(e) { e.stopPropagation(); });

            applySavedColumnState();
        </script>
    @endpush

@endsection
