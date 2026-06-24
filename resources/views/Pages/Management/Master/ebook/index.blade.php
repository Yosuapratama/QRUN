@extends('TemplateLayout.AdminLayout')

@push('css')
    <style>
        .dropdown-menu {
            border: none;
            border-radius: 14px;
            padding: 14px;
            min-width: 220px;
            box-shadow:
                0 10px 25px rgba(0, 0, 0, .08),
                0 4px 10px rgba(0, 0, 0, .04);
            animation: dropdownFade .18s ease;
        }

        .dropdown-item {
            border-radius: 10px;
        }

        .custom-control {
            border-radius: 10px;
            transition: .15s ease;
        }

        .custom-control:hover {
            background: #f8f9fc;
        }

        @keyframes dropdownFade {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        #sort-order {
            border-radius: 4px;
            border: 1px solid #dee2e6;
            padding: 0.375rem 2.5rem 0.375rem 0.75rem;
            background-size: 18px;
            appearance: none;
            color: #495057;
            font-size: 0.875rem;
            height: calc(1.5em + 0.75rem + 2px);
        }

        .form-control-sm {
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }

        .form-control-sm:focus,
        #sort-order:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
        }

        .table-responsive {
            border-radius: 4px;
            overflow: hidden;
        }

        #dataTableEbook thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
            padding: 12px;
        }

        #dataTableEbook tbody tr:hover {
            background-color: #f8f9ff;
        }

        #dataTableEbook td {
            padding: 12px;
            vertical-align: middle;
        }
    </style>
@endpush

@section('content')
    @push('title')
        <title>Management Ebook Admin - QRUN Website</title>
    @endpush

    <div class="container-fluid">

        <h1 class="h3 text-gray-800 font-weight-bold m-2">
            Manage Ebook
        </h1>

        {{-- FILTER CARD --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">

                <div>
                    <h6 class="m-0 font-weight-bold text-primary">Filters</h6>
                    <small class="text-secondary">Search and sort the ebook catalog</small>
                </div>

                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2 mt-3 mt-md-0">

                    <select class="form-control form-control-sm mr-2" id="sort-order" style="min-width:220px;">
                        <option value="">Sort by</option>
                        <option value="title">Title</option>
                        <option value="slug">Slug</option>
                    </select>

                    <button class="btn btn-outline-secondary btn-sm" id="clear-filters"
                        style="height: calc(1.5em + 0.75rem + 2px); min-width: 140px;">
                        Clear Filters
                    </button>

                </div>

            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="small font-weight-bold text-dark">Title</label>
                        <input type="text" class="form-control form-control-sm" id="filter-title" placeholder="Search...">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="small font-weight-bold text-dark">Author</label>
                        <input type="text" class="form-control form-control-sm" id="filter-author" placeholder="Search...">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="small font-weight-bold text-dark">Slug</label>
                        <input type="text" class="form-control form-control-sm" id="filter-slug" placeholder="Search...">
                    </div>
                </div>
            </div>

        </div>

        {{-- TABLE CARD --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap" style="gap:8px;">

                <div>
                    <h6 class="m-0 font-weight-bold text-primary">Ebook List</h6>
                    <small class="text-secondary">All ebooks in the catalog</small>
                </div>

                <div class="d-flex align-items-center" style="gap:8px;">

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                            id="columnVisibilityDropdown" data-toggle="dropdown">
                            <i class="fas fa-columns mr-1"></i> Columns
                        </button>

                        <div class="dropdown-menu dropdown-menu-right p-3 shadow">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-title" data-column="0" checked>
                                <label class="custom-control-label" for="toggle-title">Title</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-author" data-column="1" checked>
                                <label class="custom-control-label" for="toggle-author">Author</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-description" data-column="2" checked>
                                <label class="custom-control-label" for="toggle-description">Description</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-slug" data-column="3" checked>
                                <label class="custom-control-label" for="toggle-slug">Slug</label>
                            </div>
                        </div>
                    </div>

                    <a class="btn btn-primary btn-sm shadow-sm" href="{{ route('ebook.create') }}">
                        <i class="fas fa-plus mr-1"></i> Add Ebook
                    </a>

                </div>

            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="dataTableEbook" width="100%">
                        <thead class="thead-light">
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Description</th>
                                <th>Slug</th>
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
            const i18nEbook = {
                swalTitle:   'Are you sure?',
                swalText:    'This ebook will be deleted permanently.',
                swalConfirm: 'Yes, delete it!',
                swalCancel:  'No, cancel',
                minColumn:   'At least one column must remain visible.',
            };

            $(document).ready(function() {

                $('.dropdown-menu').on('click', function(e) {
                    e.stopPropagation();
                });

                const STORAGE_KEY = 'ebook_table_column_visibility';

                const table = $('#dataTableEbook').DataTable({

                    createdRow: function(row, data, dataIndex) {
                        $('td:eq(0)', row).css('min-width', '220px');
                        $('td:eq(1)', row).css('min-width', '160px');
                        $('td:eq(2)', row).css('min-width', '250px');
                        $('td:eq(3)', row).css('min-width', '200px');
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
                    dom: '<"top"<"dataTables_length"l><"dataTables_filter"f>>rt<"bottom"<"dataTables_info"i><"dataTables_paginate"p>>',

                    ajax: {
                        url: "{{ route('ebook.index') }}",
                        dataSrc: function(json) {
                            let data = json.data || json;

                            let title = $('#filter-title').val().toLowerCase();
                            let author = $('#filter-author').val().toLowerCase();
                            let slug = $('#filter-slug').val().toLowerCase();

                            if (title) {
                                data = data.filter(item => item.title?.toLowerCase().includes(title));
                            }
                            if (author) {
                                data = data.filter(item => (item.author || '').toLowerCase().includes(author));
                            }
                            if (slug) {
                                data = data.filter(item => item.slug?.toLowerCase().includes(slug));
                            }

                            return data;
                        }
                    },

                    columns: [
                        { data: 'title', name: 'title' },
                        { data: 'author', name: 'author', defaultContent: '-' },
                        { data: 'description', name: 'description' },
                        { data: 'slug', name: 'slug', defaultContent: '-' },
                        { data: 'action', name: 'action', orderable: false }
                    ]
                });

                function debounce(func, delay) {
                    let timer;
                    return function(...args) {
                        clearTimeout(timer);
                        timer = setTimeout(() => { func.apply(this, args); }, delay);
                    };
                }

                const reloadTableDebounced = debounce(function() {
                    table.ajax.reload();
                }, 400);

                $('#filter-title').on('keyup', reloadTableDebounced);
                $('#filter-author').on('keyup', reloadTableDebounced);
                $('#filter-slug').on('keyup', reloadTableDebounced);

                $('#sort-order').on('change', function() {
                    let value = $(this).val();
                    if (value === 'title') {
                        table.order([0, 'asc']).draw();
                    } else if (value === 'slug') {
                        table.order([3, 'asc']).draw();
                    } else {
                        table.order([]).draw();
                    }
                });

                $('#clear-filters').on('click', function() {
                    $('#filter-title').val('');
                    $('#filter-author').val('');
                    $('#filter-slug').val('');
                    $('#sort-order').val('');
                    table.ajax.reload();
                });

                function saveColumnState() {
                    let state = {};
                    $('.toggle-column').each(function() {
                        const columnIndex = $(this).data('column');
                        state[columnIndex] = $(this).is(':checked');
                    });
                    localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
                }

                function applySavedColumnState() {
                    const saved = JSON.parse(localStorage.getItem(STORAGE_KEY)) || {};
                    $('.toggle-column').each(function() {
                        const columnIndex = $(this).data('column');
                        const isVisible = saved[columnIndex] ?? true;
                        $(this).prop('checked', isVisible);
                        table.column(columnIndex).visible(isVisible, false);
                    });
                    table.columns.adjust().draw(false);
                }

                $('.toggle-column').on('change', function(e) {
                    e.stopPropagation();
                    const checkedColumns = $('.toggle-column:checked').length;
                    if (checkedColumns === 0) {
                        $(this).prop('checked', true);
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'warning',
                            title: i18nEbook.minColumn,
                            showConfirmButton: false,
                            timer: 1800
                        });
                        return;
                    }
                    const columnIndex = $(this).data('column');
                    const isVisible = $(this).is(':checked');
                    table.column(columnIndex).visible(isVisible);
                    saveColumnState();
                });

                applySavedColumnState();

                $(document).on('click', '.delete', function(e) {
                    e.preventDefault();
                    var id = $(this).attr('id');

                    Swal.fire({
                        customClass: {
                            confirmButton: "btn btn-success",
                            cancelButton: "btn btn-danger"
                        },
                        title: i18nEbook.swalTitle,
                        text: i18nEbook.swalText,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: i18nEbook.swalConfirm,
                        cancelButtonText: i18nEbook.swalCancel,
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "DELETE",
                                url: "/management/master/ebook/" + id + "/delete",
                                dataType: "json",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            title: response.success,
                                            text: response.success,
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        });
                                        table.ajax.reload();
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
                                    console.log(err);
                                }
                            });
                        }
                    });
                });

            });
        </script>
    @endpush
@endsection
