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

            /* ===== TUTORIAL FAB ===== */
            .dashboard-tutorial-fab {
                position: fixed; bottom: 72px; right: 20px; z-index: 9999;
                width: 44px; height: 44px; border-radius: 50%;
                background: linear-gradient(135deg, #2563eb, #3b82f6);
                color: #fff; border: none;
                box-shadow: 0 6px 20px rgba(37,99,235,.35);
                font-size: 16px; cursor: pointer;
                display: flex; align-items: center; justify-content: center;
                transition: .2s ease;
            }
            .dashboard-tutorial-fab:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(37,99,235,.45); }
            @media (max-width:768px) {
                .dashboard-tutorial-fab { width:40px; height:40px; bottom:68px; right:14px; font-size:14px; }
            }
            .introjs-overlay { backdrop-filter: blur(6px); background: rgba(0,0,0,.35) !important; }
            .introjs-helperLayer { border-radius: 14px !important; box-shadow: 0 0 0 9999px rgba(0,0,0,.15); }
            .introjs-button { border-radius: 10px !important; }
            .introjs-skipbutton {
                position: absolute !important; top: 10px !important; right: 10px !important;
                width: 32px; height: 32px;
                display: flex !important; align-items: center; justify-content: center;
                border-radius: 50% !important;
                background: #f8f9fc !important; border: 1px solid #e3e6f0 !important;
                color: #6c757d !important; font-size: 18px !important; font-weight: 700 !important;
                text-decoration: none !important; transition: all .2s ease;
            }
            .introjs-skipbutton:hover { background: #eaecf4 !important; color: #dc3545 !important; transform: rotate(90deg); }
            .introjs-skipbutton:focus { outline: none !important; box-shadow: 0 0 0 3px rgba(78,115,223,.2); }
        </style>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intro.js/minified/introjs.min.css">
    @endpush

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 text-gray-800 font-weight-bold m-2">{{ __('messages.management.place.title') }}</h1>
        <!-- Filters Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('messages.management.common.filters') }}</h6>
                    <small class="text-secondary">{{ __('messages.management.place.filter_subtitle') }}</small>
                </div>
                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2 mt-3 mt-md-0">
                    <select class="form-control form-control-sm" id="sort-order" style="min-width: 220px;">
                        <option value="">{{ __('messages.management.common.sort_by') }}</option>
                        <option value="views">{{ __('messages.management.place.sort_views') }}</option>
                        <option value="name">{{ __('messages.management.place.sort_name') }}</option>
                        <option value="place_code">{{ __('messages.management.place.sort_place_code') }}</option>
                    </select>
                    <button class="btn btn-outline-secondary btn-sm" id="clear-filters"
                        style="height: calc(1.5em + 0.75rem + 2px); min-width: 140px;">{{ __('messages.management.common.clear_filters') }}</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="filter-title" class="small font-weight-bold text-dark">{{ __('messages.management.place.filter_title') }}</label>
                        <input type="text" class="form-control form-control-sm" id="filter-title"
                            placeholder="{{ __('messages.management.common.search') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="filter-place-code" class="small font-weight-bold text-dark">{{ __('messages.management.place.filter_place_code') }}</label>
                        <input type="text" class="form-control form-control-sm" id="filter-place-code"
                            placeholder="{{ __('messages.management.common.search') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="filter-description" class="small font-weight-bold text-dark">{{ __('messages.management.place.filter_description') }}</label>
                        <input type="text" class="form-control form-control-sm" id="filter-description"
                            placeholder="{{ __('messages.management.common.search') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="filter-creator" class="small font-weight-bold text-dark">{{ __('messages.management.place.filter_created_by') }}</label>
                        <input type="text" class="form-control form-control-sm" id="filter-creator"
                            placeholder="{{ __('messages.management.common.search') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="filter-province" class="small font-weight-bold text-dark">{{ __('messages.management.place.filter_province') }}</label>
                        <select class="form-control form-control-sm select2-location" id="filter-province"
                            placeholder="{{ __('messages.management.place.filter_province') }}"></select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="filter-regency" class="small font-weight-bold text-dark">{{ __('messages.management.place.filter_regency') }}</label>
                        <select class="form-control form-control-sm select2-location" id="filter-regency"
                            placeholder="{{ __('messages.management.place.filter_regency') }}" disabled></select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="filter-district" class="small font-weight-bold text-dark">{{ __('messages.management.place.filter_district') }}</label>
                        <select class="form-control form-control-sm select2-location" id="filter-district"
                            placeholder="{{ __('messages.management.place.filter_district') }}" disabled></select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="filter-village" class="small font-weight-bold text-dark">{{ __('messages.management.place.filter_village') }}</label>
                        <select class="form-control form-control-sm select2-location" id="filter-village"
                            placeholder="{{ __('messages.management.place.filter_village') }}" disabled></select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="filter-updated-range" class="small font-weight-bold text-dark">
                            {{ __('messages.management.place.filter_updated_range') }}
                        </label>
                        <input type="text" class="form-control form-control-sm" id="filter-updated-range"
                            placeholder="{{ __('messages.management.common.search') }}" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
        <!-- Data Table Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('messages.management.place.table_title') }}</h6>
                    <small class="text-secondary">
                        {{ __('messages.management.common.tap_action_hint') }}
                    </small>
                </div>

                <div class="mt-3 mt-md-0">
                    <div class="d-flex align-items-center gap-2 mt-3 mt-md-0 flex-wrap" style="gap:2px">

                        {{-- Download Excel --}}
                        <button id="download-excel-place" class="btn btn-success btn-sm shadow-sm mr-2">
                            <i class="fas fa-file-excel mr-1"></i>
                            {{ __('messages.management.common.download_excel') }}
                        </button>
                        {{-- Column Visibility --}}
                        <div class="dropdown">
                            <button class="mr-2 btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                                id="columnVisibilityDropdown" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa-columns mr-1"></i>
                                {{ __('messages.management.common.columns') }}
                            </button>

                            <div class="dropdown-menu dropdown-menu-right p-3 shadow"
                                aria-labelledby="columnVisibilityDropdown" style="min-width: 230px;">

                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input toggle-column" id="toggle-title"
                                        data-column="0" checked>
                                    <label class="custom-control-label" for="toggle-title">
                                        {{ __('messages.management.place.toggle_title') }}
                                    </label>
                                </div>

                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input toggle-column"
                                        id="toggle-place-code" data-column="1" checked>
                                    <label class="custom-control-label" for="toggle-place-code">
                                        {{ __('messages.management.place.toggle_place_code') }}
                                    </label>
                                </div>

                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input toggle-column" id="toggle-views"
                                        data-column="2" checked>
                                    <label class="custom-control-label" for="toggle-views">
                                        {{ __('messages.management.place.toggle_views') }}
                                    </label>
                                </div>

                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input toggle-column"
                                        id="toggle-description" data-column="3" checked>
                                    <label class="custom-control-label" for="toggle-description">
                                        {{ __('messages.management.place.toggle_description') }}
                                    </label>
                                </div>

                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input toggle-column"
                                        id="toggle-created-by" data-column="4" checked>
                                    <label class="custom-control-label" for="toggle-created-by">
                                        {{ __('messages.management.place.toggle_created_by') }}
                                    </label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input toggle-column"
                                        id="toggle-updated-at" data-column="5" checked>
                                    <label class="custom-control-label" for="toggle-updated-at">
                                        {{ __('messages.management.place.toggle_updated_at') }}
                                    </label>
                                </div>

                            </div>
                        </div>

                        <a href="{{ route('place.create') }}" id="createPlaceBtn"
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
                                <th>{{ __('messages.management.place.col_title') }}</th>
                                <th>{{ __('messages.management.place.col_place_code') }}</th>
                                <th>{{ __('messages.management.place.col_views') }}</th>
                                <th>{{ __('messages.management.place.col_description') }}</th>
                                <th>{{ __('messages.management.place.col_created_by') }}</th>
                                <th>{{ __('messages.management.place.col_updated_at') }}</th>
                                <th class="text-center">{{ __('messages.management.common.action') }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    <button id="placeListTutorialBtn" class="dashboard-tutorial-fab" title="Tutorial">
        <i class="fas fa-question"></i>
    </button>

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/intro.js/minified/intro.min.js"></script>
        <script>
            $(document).on('click', '#placeListTutorialBtn', function() {
                showPlaceListTutorialModal();
            });

            // Auto-show tutorial on first visit (if not seen before)
            $(document).ready(function() {
                if (!localStorage.getItem('placelist_tutorial_seen')) {
                    setTimeout(function() {
                        showPlaceListTutorialModal();
                    }, 600);
                }
            });

            function showPlaceListTutorialModal() {

                Swal.fire({

                    title: '👋 Welcome',
                    html: `

                        <p class="text-muted mb-4">
                            Please choose your preferred tutorial language
                            or skip the tutorial.
                        </p>

                        <div class="row">

                            <div class="col-6 mb-3">
                                <button
                                    id="placelist-tutorial-lang-id"
                                    class="btn btn-primary btn-block py-3">

                                    🇮🇩<br>
                                    <strong>Bahasa Indonesia</strong>

                                </button>
                            </div>

                            <div class="col-6 mb-3">
                                <button
                                    id="placelist-tutorial-lang-en"
                                    class="btn btn-outline-primary btn-block py-3">

                                    🇺🇸<br>
                                    <strong>English</strong>

                                </button>
                            </div>

                        </div>

                        <hr>

                        <button
                            id="placelist-tutorial-skip"
                            class="btn btn-link text-muted">

                            Skip Tutorial

                        </button>

                    `,

                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,

                    didOpen: () => {

                        $('#placelist-tutorial-lang-id').on('click', function() {
                            localStorage.setItem('placelist_tutorial_lang', 'id');
                            Swal.close();
                            startPlaceListTutorial('id');
                        });

                        $('#placelist-tutorial-lang-en').on('click', function() {
                            localStorage.setItem('placelist_tutorial_lang', 'en');
                            Swal.close();
                            startPlaceListTutorial('en');
                        });

                        $('#placelist-tutorial-skip').on('click', function() {
                            localStorage.setItem('placelist_tutorial_seen', 'true');
                            Swal.close();
                        });

                    }

                });

            }

            function startPlaceListTutorial(lang) {

                const tutorials = {
                    id: {
                        nextLabel: 'Lanjut', prevLabel: 'Kembali', doneLabel: 'Selesai', skipLabel: 'X',
                        steps: [
                            {
                                title: 'Selamat Datang 👋',
                                intro: `
                        <div class="text-left">
                            <h5 class="mb-3">Tutorial Manage Place</h5>
                            <p>
                                Tutorial ini menjelaskan fitur pada halaman daftar tempat:
                            </p>
                            <ul>
                                <li>Mencari & memfilter tempat</li>
                                <li>Mengurutkan & mengatur kolom</li>
                                <li>Ekspor data & menambah tempat baru</li>
                            </ul>
                            <p class="mb-0">Estimasi waktu: ±1 menit</p>
                        </div>
                    `
                            },
                            { element: document.getElementById('sort-order'), title: 'Urutkan', intro: 'Urutkan daftar tempat berdasarkan jumlah views, nama, atau kode tempat.' },
                            { element: document.getElementById('filter-title'), title: 'Pencarian', intro: 'Cari tempat berdasarkan judul, kode, deskripsi, atau pembuat.' },
                            { element: document.getElementById('filter-province'), title: 'Filter Lokasi', intro: 'Saring tempat berdasarkan Provinsi → Kabupaten → Kecamatan → Desa secara berurutan.' },
                            { element: document.getElementById('filter-updated-range'), title: 'Filter Tanggal', intro: 'Tampilkan tempat berdasarkan rentang tanggal pembaruan terakhir.' },
                            { element: document.getElementById('clear-filters'), title: 'Reset Filter', intro: 'Kosongkan semua filter dan urutan dengan satu klik.' },
                            { element: document.getElementById('download-excel-place'), title: 'Ekspor Excel', intro: 'Unduh data tempat (sesuai filter aktif) ke file Excel.' },
                            { element: document.getElementById('columnVisibilityDropdown'), title: 'Atur Kolom', intro: 'Pilih kolom mana yang ingin ditampilkan atau disembunyikan pada tabel.' },
                            { element: document.getElementById('createPlaceBtn'), title: 'Tambah Tempat', intro: 'Buat tempat / objek baru beserta QR Code-nya.' },
                            { title: 'Daftar Tempat', intro: 'Semua tempat ditampilkan di sini. Gunakan tombol aksi pada tiap baris untuk melihat detail, mengubah, atau menghapus.' }
                        ]
                    },
                    en: {
                        nextLabel: 'Next', prevLabel: 'Back', doneLabel: 'Finish', skipLabel: 'X',
                        steps: [
                            {
                                title: 'Welcome 👋',
                                intro: `
                        <div class="text-left">
                            <h5 class="mb-3">Manage Place Tutorial</h5>
                            <p>
                                This tutorial covers the place list page features:
                            </p>
                            <ul>
                                <li>Searching & filtering places</li>
                                <li>Sorting & arranging columns</li>
                                <li>Exporting data & adding new places</li>
                            </ul>
                            <p class="mb-0">Estimated duration: 1 minute</p>
                        </div>
                    `
                            },
                            { element: document.getElementById('sort-order'), title: 'Sort', intro: 'Sort the place list by views, name, or place code.' },
                            { element: document.getElementById('filter-title'), title: 'Search', intro: 'Search places by title, code, description, or creator.' },
                            { element: document.getElementById('filter-province'), title: 'Location Filter', intro: 'Filter places by Province → Regency → District → Village in sequence.' },
                            { element: document.getElementById('filter-updated-range'), title: 'Date Filter', intro: 'Show places based on their last updated date range.' },
                            { element: document.getElementById('clear-filters'), title: 'Reset Filters', intro: 'Clear all filters and sorting with a single click.' },
                            { element: document.getElementById('download-excel-place'), title: 'Export Excel', intro: 'Download place data (matching active filters) to an Excel file.' },
                            { element: document.getElementById('columnVisibilityDropdown'), title: 'Manage Columns', intro: 'Choose which columns to show or hide in the table.' },
                            { element: document.getElementById('createPlaceBtn'), title: 'Add Place', intro: 'Create a new place / object along with its QR Code.' },
                            { title: 'Place List', intro: 'All places appear here. Use the action buttons on each row to view details, edit, or delete.' }
                        ]
                    }
                };

                const config = tutorials[lang] || tutorials.en;
                const validSteps = config.steps.filter(function(s) {
                    if (!s.element) return true;
                    return s.element.offsetParent !== null;
                });

                introJs().setOptions({
                    steps: validSteps,
                    nextLabel: config.nextLabel,
                    prevLabel: config.prevLabel,
                    doneLabel: config.doneLabel,
                    skipLabel: config.skipLabel,
                    showBullets: true,
                    showProgress: true,
                    exitOnOverlayClick: false,
                    scrollToElement: true,
                    scrollTo: 'element',
                    tooltipClass: 'custom-intro-tooltip',
                }).onbeforechange(function(el) {
                    if (el) setTimeout(function() {
                        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 50);
                }).oncomplete(function() {
                    localStorage.setItem('placelist_tutorial_seen', 'true');
                }).onexit(function() {
                    localStorage.setItem('placelist_tutorial_seen', 'true');
                }).start();
            }
        </script>
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script>
            const i18nPlace = {
                codeCopied:    @json(__('messages.management.place.code_copied')),
                swalTitle:     @json(__('messages.management.common.swal_are_you_sure')),
                swalText:      @json(__('messages.management.place.swal_delete_text')),
                swalConfirm:   @json(__('messages.management.place.swal_delete_confirm')),
                swalCancel:    @json(__('messages.management.common.swal_no_cancel')),
                minColumn:     @json(__('messages.management.common.min_column_warning')),
            };

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
                            title: i18nPlace.codeCopied,
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
                            title: i18nPlace.codeCopied,
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
                        title: i18nPlace.swalTitle,
                        text: i18nPlace.swalText,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: i18nPlace.swalConfirm,
                        cancelButtonText: i18nPlace.swalCancel,
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
