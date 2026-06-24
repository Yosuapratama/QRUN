@extends('TemplateLayout.AdminLayout')

@push('css')
    <style>
        .dropdown-menu {
            border: none;
            border-radius: 14px;
            padding: 14px;
            min-width: 220px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08), 0 4px 10px rgba(0, 0, 0, .04);
            animation: dropdownFade .18s ease;
        }

        .dropdown-item { border-radius: 10px; }
        .custom-control { border-radius: 10px; transition: .15s ease; }
        .custom-control:hover { background: #f8f9fc; }

        @keyframes dropdownFade {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        #sort-order {
            border-radius: 4px;
            border: 1px solid #dee2e6;
            padding: 0.375rem 2.5rem 0.375rem 0.75rem;
            appearance: none;
            color: #495057;
            font-size: 0.875rem;
            height: calc(1.5em + 0.75rem + 2px);
        }

        .form-control-sm { border-radius: 4px; border: 1px solid #dee2e6; }
        .form-control-sm:focus, #sort-order:focus { border-color: #4e73df; box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1); }
        .table-responsive { border-radius: 4px; overflow: hidden; }

        #dataTableEbookPlace thead th { background-color: #f8f9fa; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057; padding: 12px; }
        #dataTableEbookPlace tbody tr:hover { background-color: #f8f9ff; }
        #dataTableEbookPlace td { padding: 12px; vertical-align: middle; }
        .code-pill { font-family: monospace; background:#eef2ff; color:#3b50c0; padding:2px 8px; border-radius:6px; font-size:12px; }
    </style>
@endpush

@section('content')
    @push('title')
        <title>Ebook Locations - QRUN Website</title>
    @endpush

    <div class="container-fluid">

        <h1 class="h3 text-gray-800 font-weight-bold m-2">Ebook Locations</h1>

        {{-- FILTER CARD --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h6 class="m-0 font-weight-bold text-primary">Filters</h6>
                    <small class="text-secondary">Search and sort ebook locations</small>
                </div>

                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2 mt-3 mt-md-0">
                    <select class="form-control form-control-sm mr-2" id="sort-order" style="min-width:220px;">
                        <option value="">Sort by</option>
                        <option value="name">Name</option>
                        <option value="code">Code</option>
                    </select>
                    <button class="btn btn-outline-secondary btn-sm" id="clear-filters"
                        style="height: calc(1.5em + 0.75rem + 2px); min-width: 140px;">
                        Clear Filters
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="small font-weight-bold text-dark">Name</label>
                        <input type="text" class="form-control form-control-sm" id="filter-name" placeholder="Search...">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small font-weight-bold text-dark">Code</label>
                        <input type="text" class="form-control form-control-sm" id="filter-code" placeholder="Search...">
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap" style="gap:8px;">
                <div>
                    <h6 class="m-0 font-weight-bold text-primary">Location List</h6>
                    <small class="text-secondary">Each location has a unique QR code</small>
                </div>

                <div class="d-flex align-items-center" style="gap:8px;">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                            id="columnVisibilityDropdown" data-toggle="dropdown">
                            <i class="fas fa-columns mr-1"></i> Columns
                        </button>
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-name" data-column="0" checked>
                                <label class="custom-control-label" for="toggle-name">Name</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-code" data-column="1" checked>
                                <label class="custom-control-label" for="toggle-code">Code</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-ebooks" data-column="2" checked>
                                <label class="custom-control-label" for="toggle-ebooks">Ebooks</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-status" data-column="3" checked>
                                <label class="custom-control-label" for="toggle-status">Status</label>
                            </div>
                        </div>
                    </div>

                    <a class="btn btn-success btn-sm shadow-sm" href="{{ route('ebook-place.create') }}">
                        <i class="fas fa-plus mr-1"></i> Add Location
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="dataTableEbookPlace" width="100%">
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th class="text-center">Ebooks</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    @push('script')
        <script>
            $(document).ready(function () {
                $('.dropdown-menu').on('click', function (e) { e.stopPropagation(); });

                const STORAGE_KEY = 'ebook_place_table_column_visibility';

                const table = $('#dataTableEbookPlace').DataTable({
                    filter: true,
                    processing: true,
                    serverSide: true,
                    order: [],
                    dom: '<"top"<"dataTables_length"l><"dataTables_filter"f>>rt<"bottom"<"dataTables_info"i><"dataTables_paginate"p>>',

                    ajax: {
                        url: "{{ route('ebook-place.index') }}",
                        dataSrc: function (json) {
                            let data = json.data || json;

                            let name = $('#filter-name').val().toLowerCase();
                            let code = $('#filter-code').val().toLowerCase();

                            if (name) {
                                data = data.filter(item => (item.name || '').toLowerCase().includes(name));
                            }
                            if (code) {
                                data = data.filter(item => (item.code || '').toLowerCase().includes(code));
                            }
                            return data;
                        }
                    },

                    columns: [
                        { data: 'name', name: 'name' },
                        { data: 'code', name: 'code', render: d => `<span class="code-pill">${d}</span>` },
                        { data: 'ebooks_count', name: 'ebooks_count', className: 'text-center' },
                        { data: 'is_active', name: 'is_active', className: 'text-center' },
                        { data: 'action', name: 'action', orderable: false, className: 'text-center' }
                    ]
                });

                // ── FILTER ──
                function debounce(func, delay) {
                    let timer;
                    return function (...args) {
                        clearTimeout(timer);
                        timer = setTimeout(() => func.apply(this, args), delay);
                    };
                }
                const reloadDebounced = debounce(() => table.ajax.reload(), 400);

                $('#filter-name').on('keyup', reloadDebounced);
                $('#filter-code').on('keyup', reloadDebounced);

                // ── SORT ──
                $('#sort-order').on('change', function () {
                    let v = $(this).val();
                    if (v === 'name') table.order([0, 'asc']).draw();
                    else if (v === 'code') table.order([1, 'asc']).draw();
                    else table.order([]).draw();
                });

                // ── CLEAR ──
                $('#clear-filters').on('click', function () {
                    $('#filter-name').val('');
                    $('#filter-code').val('');
                    $('#sort-order').val('');
                    table.ajax.reload();
                });

                // ── COLUMN VISIBILITY ──
                function saveColumnState() {
                    let state = {};
                    $('.toggle-column').each(function () { state[$(this).data('column')] = $(this).is(':checked'); });
                    localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
                }
                function applySavedColumnState() {
                    const saved = JSON.parse(localStorage.getItem(STORAGE_KEY)) || {};
                    $('.toggle-column').each(function () {
                        const i = $(this).data('column');
                        const visible = saved[i] ?? true;
                        $(this).prop('checked', visible);
                        table.column(i).visible(visible, false);
                    });
                    table.columns.adjust().draw(false);
                }
                $('.toggle-column').on('change', function (e) {
                    e.stopPropagation();
                    if ($('.toggle-column:checked').length === 0) {
                        $(this).prop('checked', true);
                        Swal.fire({ toast: true, position: 'top-end', icon: 'warning', title: 'At least one column must stay visible.', showConfirmButton: false, timer: 1800 });
                        return;
                    }
                    table.column($(this).data('column')).visible($(this).is(':checked'));
                    saveColumnState();
                });
                applySavedColumnState();

                // ── DELETE ──
                $(document).on('click', '.delete', function (e) {
                    e.preventDefault();
                    const id = $(this).attr('id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This location and its QR assignments will be deleted.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'DELETE',
                                url: '/management/master/ebook-place/' + id + '/delete',
                                dataType: 'json',
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                success: function (response) {
                                    if (response.success) {
                                        Swal.fire({ icon: 'success', title: response.success, timer: 1400, showConfirmButton: false });
                                        table.ajax.reload();
                                    } else if (response.errors) {
                                        Swal.fire({ icon: 'error', title: response.errors });
                                    }
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
