@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Management Event Admin - QRUN Website</title>
    @endpush
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <h1 class="h3 text-gray-800 font-weight-bold m-2" id="eventPageTitle">
            {{ __('messages.management.event.title') }}
        </h1>

        <!-- FILTER CARD -->
        <div class="card shadow mb-4" id="eventFilterCard">
            <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{ __('messages.management.common.filters') }}
                    </h6>

                    <small class="text-secondary">
                        {{ __('messages.management.event.filter_subtitle') }}
                    </small>
                </div>

                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2 mt-3 mt-md-0">
                    <select class="form-control form-control-sm mr-2" id="sort-order" style="min-width:220px;">
                        <option value="">{{ __('messages.management.common.sort_by') }}</option>
                        <option value="title">{{ __('messages.management.event.sort_title') }}</option>
                        <option value="date">{{ __('messages.management.event.sort_date') }}</option>
                        <option value="status">{{ __('messages.management.event.sort_status') }}</option>
                    </select>

                    <button class="btn btn-outline-secondary btn-sm" id="clear-filters" style="height: calc(1.5em + 0.75rem + 2px); min-width: 140px;">
                        {{ __('messages.management.common.clear_filters') }}
                    </button>
                </div>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold text-dark">
                            {{ __('messages.management.event.filter_title') }}
                        </label>

                        <input type="text" class="form-control form-control-sm" id="filter-title"
                            placeholder="{{ __('messages.management.common.search') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold text-dark">
                            {{ __('messages.management.event.filter_place_code') }}
                        </label>

                        <input type="text" class="form-control form-control-sm" id="filter-place-code"
                            placeholder="{{ __('messages.management.common.search') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold text-dark">
                            {{ __('messages.management.event.filter_status') }}
                        </label>

                        <select class="form-control form-control-sm" id="filter-status">
                            <option value="">{{ __('messages.management.event.all_status') }}</option>
                            <option value="active">{{ __('messages.management.common.active') }}</option>
                            <option value="inactive">{{ __('messages.management.common.inactive') }}</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold text-dark">
                            {{ __('messages.management.event.filter_start_date') }}
                        </label>

                        <input type="date" class="form-control form-control-sm" id="filter-date">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold text-dark">
                            {{ __('messages.management.event.filter_end_date') }}
                        </label>

                        <input type="date" class="form-control form-control-sm" id="filter-end-date">
                    </div>

                </div>

            </div>
        </div>

        <!-- TABLE CARD -->
        <div class="card shadow mb-4" id="eventTableCard">

            <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap" style="gap:6px;">

                <div>
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{ __('messages.management.event.table_title') }}
                    </h6>

                    <small class="text-secondary">
                        {{ __('messages.management.event.table_subtitle') }}
                    </small>
                </div>

                <div class="d-flex align-items-center">

                    <div class="dropdown mr-2">

                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                            id="columnVisibilityDropdown" data-toggle="dropdown">

                            <i class="fas fa-columns mr-1"></i>
                            {{ __('messages.management.common.columns') }}
                        </button>

                        <div class="dropdown-menu dropdown-menu-right p-3 shadow">

                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-title"
                                    data-column="0" checked>

                                <label class="custom-control-label" for="toggle-title">
                                    {{ __('messages.management.event.col_title') }}
                                </label>
                            </div>

                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-description"
                                    data-column="1" checked>

                                <label class="custom-control-label" for="toggle-description">
                                    {{ __('messages.management.event.col_description') }}
                                </label>
                            </div>

                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-place-code"
                                    data-column="2" checked>

                                <label class="custom-control-label" for="toggle-place-code">
                                    {{ __('messages.management.event.col_place_code') }}
                                </label>
                            </div>

                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-date"
                                    data-column="3" checked>

                                <label class="custom-control-label" for="toggle-date">
                                    {{ __('messages.management.event.col_date') }}
                                </label>
                            </div>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input toggle-column" id="toggle-status"
                                    data-column="4" checked>

                                <label class="custom-control-label" for="toggle-status">
                                    {{ __('messages.management.event.col_status') }}
                                </label>
                            </div>

                        </div>
                    </div>

                    <button class="btn btn-success btn-sm" id="btnAddEvent" data-bs-toggle="modal" data-bs-target="#addEventModalAdminNew">

                        <i class="fas fa-plus mr-1"></i>
                        {{ __('messages.management.event.add_event') }}
                    </button>
                </div>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-striped table-hover table-bordered" id="dataTableEvent" width="100%">

                        <thead class="thead-light">
                            <tr>
                                <th>{{ __('messages.management.event.col_title') }}</th>
                                <th>{{ __('messages.management.event.col_description') }}</th>
                                <th>{{ __('messages.management.event.col_place_code') }}</th>
                                <th>{{ __('messages.management.event.col_date') }}</th>
                                <th>{{ __('messages.management.event.col_status') }}</th>
                                <th class="text-center">{{ __('messages.management.common.action') }}</th>
                            </tr>
                        </thead>

                        <tbody></tbody>

                    </table>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

        @push('css')
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intro.js@7.2.0/minified/introjs.min.css">

            <style>
                #sort-order {
                    border-radius: 4px;
                    border: 1px solid #dee2e6;
                    padding: 0.375rem 2.5rem 0.375rem 0.75rem;
                    background: #fff url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%234e73df%22%3e%3cpath d=%22M7 10l5 5 5-5z%22/%3e%3c/svg%3e') no-repeat right 10px center;
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

                #clear-filters {
                    border-radius: 4px;
                    font-weight: 500;
                }

                .table-responsive {
                    border-radius: 4px;
                    overflow: hidden;
                }

                #dataTableEvent thead th {
                    background-color: #f8f9fa;
                    border-bottom: 2px solid #dee2e6;
                    font-weight: 600;
                    color: #495057;
                    padding: 12px;
                }

                #dataTableEvent tbody tr:hover {
                    background-color: #f8f9ff;
                }

                #dataTableEvent td {
                    padding: 12px;
                    vertical-align: middle;
                }

                .dropdown-menu {
                    border-radius: 10px;
                }

                .toggle-column:disabled+.custom-control-label {
                    opacity: 0.5;
                    cursor: not-allowed;
                }

                .event-summary-card {
                    background: #f8f9fc;
                    border-radius: 18px;
                    padding: 18px;
                    border: 1px solid #e3e6f0;
                }

                .event-icon-box {
                    width: 52px;
                    height: 52px;
                    border-radius: 16px;
                    background: rgba(78, 115, 223, .1);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #4e73df;
                    font-size: 18px;
                }

                .event-table-wrapper {
                    border: 1px solid #edf2f7;
                    border-radius: 18px;
                    overflow: hidden;
                }

                #dataTablePlaceEvent thead th {
                    background: #f8f9fc;
                    border-bottom: none !important;
                    font-size: 13px;
                    font-weight: 700;
                    color: #5a5c69;
                    padding: 18px;
                }

                #dataTablePlaceEvent tbody td {
                    vertical-align: middle;
                    padding: 18px;
                }

                .event-description {
                    display: -webkit-box;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    max-width: 400px;
                    line-height: 1.6;
                }

                .schedule-box {
                    min-width: 220px;
                    background: #f8f9fc;
                    border-radius: 14px;
                    padding: 12px 16px;
                }

                /* =========================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   DISABLED FORM STYLE
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ========================= */

                input[readonly],
                textarea[readonly],
                select:disabled {
                    background-color: #f8f9fc !important;
                    color: #6c757d !important;
                    cursor: not-allowed !important;
                    opacity: 1 !important;
                }

                /* Select2 Disabled */
                .select2-container--disabled .select2-selection {
                    background-color: #f8f9fc !important;
                    border-color: #d1d3e2 !important;
                    cursor: not-allowed !important;
                    opacity: 1 !important;
                }

                .select2-container--disabled .select2-selection__rendered {
                    color: #6c757d !important;
                }

                /* Summernote Disabled */
                .note-editor.note-frame .note-editing-area .note-editable[contenteditable="false"] {
                    background-color: #f8f9fc !important;
                    color: #6c757d !important;
                    cursor: not-allowed !important;
                }

                /* Summernote Toolbar Disabled */
                .note-toolbar {
                    background-color: #f8f9fc !important;
                    opacity: 0.7;
                    pointer-events: none;
                }

                /* Checkbox Disabled */
                input[type="checkbox"]:disabled {
                    cursor: not-allowed;
                    opacity: 0.6;
                }

                /* default crop modal */
                #cropImageModal {
                    z-index: 1060;
                }

                /* active state */
                .crop-modal-active {
                    z-index: 1085 !important;
                }

                .crop-backdrop-active {
                    z-index: 1080 !important;
                }

                /* =========================
                                                                                                                           EVENT IMAGE PREVIEW
                                                                                                                        ========================= */

                #eventImagesPreview,
                #eventImagesPreviewEdit {
                    max-height: 400px;
                    overflow-y: auto;
                    overflow-x: hidden;
                    border: 1px solid #e3e6f0;
                    border-radius: 14px;
                    padding: 12px;
                    background: #f8f9fc;
                }

                /* scrollbar */
                #eventImagesPreview::-webkit-scrollbar,
                #eventImagesPreviewEdit::-webkit-scrollbar {
                    width: 8px;
                }

                #eventImagesPreview::-webkit-scrollbar-thumb,
                #eventImagesPreviewEdit::-webkit-scrollbar-thumb {
                    background: rgba(0, 0, 0, .18);
                    border-radius: 20px;
                }

                #eventImagesPreview::-webkit-scrollbar-track,
                #eventImagesPreviewEdit::-webkit-scrollbar-track {
                    background: transparent;
                }

                /* preview image card biar rapih */
                #eventImagesPreview .card,
                #eventImagesPreviewEdit .card {
                    border-radius: 14px;
                    overflow: hidden;
                }

                /* image size */
                #eventImagesPreview img,
                #eventImagesPreviewEdit img {
                    height: 140px;
                    width: 100%;
                    object-fit: cover;
                }

                /* ====================================
                                                                                                                   FORCE EVENT MODAL SCROLL
                                                                                                                ==================================== */

                #addEventModalAdminNew,
                #editEventModalAdminNew {
                    overflow-y: auto !important;
                }

                #addEventModalAdminNew .modal-dialog,
                #editEventModalAdminNew .modal-dialog {
                    height: auto;
                    max-height: calc(100vh - 40px);
                }

                #addEventModalAdminNew .modal-content,
                #editEventModalAdminNew .modal-content {
                    max-height: calc(100vh - 40px);
                    overflow: hidden;
                }

                #addEventModalAdminNew .modal-body,
                #editEventModalAdminNew .modal-body {
                    overflow-y: auto !important;
                    max-height: calc(100vh - 220px);
                }

                /* .cropper-container {
                                                                                                                max-width: 100%;
                                                                                                            } */

                #cropImageModal .modal-dialog {
                    max-width: 850px;
                }

                #cropImageModal .modal-content {
                    overflow: hidden;
                }

                #cropImageModal .modal-body {
                    overflow-x: hidden;
                    overflow-y: auto;
                }

                #cropImageModal .cropper-container {
                    max-width: 100% !important;
                }

                #cropperImage {
                    display: block;
                    max-width: 100%;
                }

                .empty-image-state {
                    min-height: 180px;
                    border: 2px dashed #dbe3f0;
                    border-radius: 18px;
                    background: #f8f9fc;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    padding: 20px;
                }

                .empty-image-icon {
                    width: 70px;
                    opacity: .65;
                }

                /* Tutorial FAB */
                .event-tutorial-fab {
                    position: fixed;
                    bottom: 72px;
                    right: 20px;
                    z-index: 9999;
                    width: 44px;
                    height: 44px;
                    border-radius: 50%;
                    background: linear-gradient(135deg, #4e73df, #3a5abf);
                    color: #fff;
                    border: none;
                    box-shadow: 0 6px 20px rgba(78,115,223,.4);
                    font-size: 16px;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    transition: .2s ease;
                }
                .event-tutorial-fab:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 10px 28px rgba(78,115,223,.5);
                }
                @media(max-width:768px) {
                    .event-tutorial-fab { width: 40px; height: 40px; bottom: 68px; right: 14px; font-size: 14px; }
                }
            </style>
        @endpush

        @push('script')
            <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

            <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
            <script>
                const i18nEvent = {
                    swalTitle:    @json(__('messages.management.common.swal_are_you_sure')),
                    swalConfirm:  @json(__('messages.management.common.swal_yes_delete')),
                    swalCancel:   @json(__('messages.management.common.swal_no_cancel')),
                    deleteText:   @json(__('messages.management.event.swal_delete_text')),
                    minColumn:    @json(__('messages.management.common.min_column_warning')),
                    statusActive: @json(__('messages.management.event.status_active')),
                    statusInactive: @json(__('messages.management.event.status_inactive')),
                    noImages:     @json(__('messages.management.event.no_images')),
                    noImagesDesc: @json(__('messages.management.event.no_images_desc')),
                    removeImage:  @json(__('messages.management.event.remove_image')),
                    swalSuccess:  @json(__('messages.management.common.swal_success')),
                    swalFailed:   @json(__('messages.management.dashboard.swal_failed')),
                };

                $(document).ready(function() {
                    if ($.fn.modal.Constructor.prototype.enforceFocus) {
                        $.fn.modal.Constructor.prototype.enforceFocus =
                            function() {};
                    }

                    if ($.fn.modal.Constructor.prototype._enforceFocus) {
                        $.fn.modal.Constructor.prototype._enforceFocus =
                            function() {};
                    }

                    // ==================================
                    // ACTIVE SWITCH LABEL
                    // ==================================

                    function updateAddEventStatusLabel() {

                        const checked = $('#addEventIsActive').is(':checked');

                        $('#addEventStatusText')
                            .text(checked ? i18nEvent.statusActive : i18nEvent.statusInactive)
                            .removeClass('badge-success badge-secondary')
                            .addClass(checked ? 'badge-success' : 'badge-secondary');
                    }

                    function updateEditEventStatusLabel() {

                        const checked = $('#editEventIsActive').is(':checked');

                        $('#editEventStatusText')
                            .text(checked ? i18nEvent.statusActive : i18nEvent.statusInactive)
                            .removeClass('badge-success badge-secondary')
                            .addClass(checked ? 'badge-success' : 'badge-secondary');
                    }

                    // add modal
                    $(document).on('change', '#addEventIsActive', function() {

                        updateAddEventStatusLabel();
                    });

                    // edit modal
                    $(document).on('change', '#editEventIsActive', function() {

                        updateEditEventStatusLabel();
                    });

                    // init
                    updateAddEventStatusLabel();
                    updateEditEventStatusLabel();

                    $(document).on('click', '.closeEditModal, .cancelEditModal', function() {

                        $('#editEventModalAdminNew').modal('hide');

                        $('body').removeClass('modal-open');

                        $('.modal-backdrop').remove();

                        $('#editEventModalAdminNew')
                            .removeClass('show')
                            .css('display', 'none')
                            .attr('aria-hidden', 'true');
                    });

                    $(document).on('click', '.closeAddModal', function() {
                        $('#addEventModalAdminNew').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('#addEventModalAdminNew')
                            .removeClass('show')
                            .css('display', 'none')
                            .attr('aria-hidden', 'true');
                    });
                    // =========================
                    // IMAGE MANAGER
                    // =========================

                    let addFiles = [];
                    let editFiles = [];

                    let cropper = null;
                    let currentCropIndex = null;
                    let currentCropMode = null;

                    let existingEditImages = [];
                    let croppedExistingImages = [];

                    // =========================
                    // EMPTY STATE
                    // =========================

                    function renderEmptyImageState(containerId) {

                        $(containerId).html(`
        <div class="col-12">
            <div class="empty-image-state">

                <div class="font-weight-bold text-muted mt-2">
                    ${i18nEvent.noImages}
                </div>

                <small class="text-muted">
                    ${i18nEvent.noImagesDesc}
                </small>

            </div>
        </div>
    `);
                    }

                    // =========================
                    // RENDER IMAGES
                    // =========================

                    function renderImages(
                        files,
                        previewEl,
                        mode = 'add',
                        append = false
                    ) {

                        if (!append) {
                            $(previewEl).html('');
                        }

                        files.forEach((file, index) => {

                            const reader = new FileReader();

                            reader.onload = function(e) {

                                $(previewEl).append(`
                <div class="col-md-3 col-6 mb-3">

                    <div class="card shadow-sm border-0 image-card"
                        data-index="${index}"
                        data-mode="${mode}"
                        style="cursor:pointer;">

                        <img src="${e.target.result}"
                            class="img-fluid rounded"
                            style="
                                height:180px;
                                width:100%;
                                object-fit:cover;
                            ">

                        <div class="card-body p-2">

                            <button type="button"
                                class="btn btn-danger btn-sm btn-block removeImageBtn"
                                data-index="${index}"
                                data-mode="${mode}">

                                ${i18nEvent.removeImage}
                            </button>

                        </div>

                    </div>

                </div>
            `);
                            };

                            reader.readAsDataURL(file);
                        });
                    }

                    // =========================
                    // EXISTING EDIT IMAGES
                    // =========================

                    function renderExistingEditImages() {

                        const preview = $('#eventImagesPreviewEdit');

                        preview.html('');

                        if (
                            existingEditImages.length === 0 &&
                            editFiles.length === 0
                        ) {

                            renderEmptyImageState(
                                '#eventImagesPreviewEdit'
                            );

                            return;
                        }

                        existingEditImages.forEach((img, index) => {

                            preview.append(`
            <div class="col-md-3 col-6 mb-3">

                <div class="card shadow-sm border-0 existing-image-card"
                    data-index="${index}"
                    style="cursor:pointer;">

                    <img src="${img.image_url}"
                        class="img-fluid rounded"
                        style="
                            height:180px;
                            width:100%;
                            object-fit:cover;
                        ">

                    <div class="card-body p-2">

                        <button type="button"
                            class="btn btn-danger btn-sm btn-block removeExistingImageBtn"
                            data-index="${index}">

                            ${i18nEvent.removeImage}
                        </button>

                    </div>

                </div>

            </div>
        `);
                        });

                        renderImages(
                            editFiles,
                            '#eventImagesPreviewEdit',
                            'edit',
                            true
                        );
                    }

                    // =========================
                    // APPEND FILES
                    // =========================

                    function appendFiles(
                        input,
                        targetArray,
                        previewSelector,
                        mode
                    ) {

                        Array.from(input.files).forEach(file => {

                            if (!file.type.startsWith('image/')) return;

                            targetArray.push(file);
                        });

                        if (mode === 'edit') {

                            renderExistingEditImages();

                        } else {

                            renderImages(
                                targetArray,
                                previewSelector,
                                mode
                            );
                        }

                        input.value = '';
                    }

                    // =========================
                    // ADD INPUT
                    // =========================

                    $('#eventImages').on('change', function() {

                        appendFiles(
                            this,
                            addFiles,
                            '#eventImagesPreview',
                            'add'
                        );
                    });

                    // =========================
                    // EDIT INPUT
                    // =========================

                    $('#eventImagesEdit').on('change', function() {

                        appendFiles(
                            this,
                            editFiles,
                            '#eventImagesPreviewEdit',
                            'edit'
                        );
                    });

                    // =========================
                    // REMOVE IMAGE
                    // =========================

                    $(document).on('click', '.removeImageBtn', function(e) {

                        e.stopPropagation();

                        const index = $(this).data('index');
                        const mode = $(this).data('mode');

                        if (mode === 'add') {

                            addFiles.splice(index, 1);

                            if (addFiles.length === 0) {

                                renderEmptyImageState(
                                    '#eventImagesPreview'
                                );

                            } else {

                                renderImages(
                                    addFiles,
                                    '#eventImagesPreview',
                                    'add'
                                );
                            }

                        } else {

                            editFiles.splice(index, 1);

                            renderExistingEditImages();
                        }
                    });

                    // =========================
                    // EXISTING REMOVE
                    // =========================

                    $(document).on(
                        'click',
                        '.removeExistingImageBtn',
                        function(e) {

                            e.stopPropagation();

                            const index = $(this).data('index');

                            existingEditImages.splice(index, 1);

                            renderExistingEditImages();
                        }
                    );

                    // =========================
                    // CLICK IMAGE => CROP
                    // =========================

                    $(document).on('click', '.image-card', function() {

                        currentCropIndex = $(this).data('index');
                        currentCropMode = $(this).data('mode');

                        let files =
                            currentCropMode === 'add' ?
                            addFiles :
                            editFiles;

                        const file = files[currentCropIndex];

                        const reader = new FileReader();

                        reader.onload = function(e) {

                            $('#cropperImage')
                                .attr('src', e.target.result);

                            $('#cropImageModal')
                                .modal('show');
                        };

                        reader.readAsDataURL(file);
                    });

                    // =========================
                    // EXISTING IMAGE CLICK
                    // =========================

                    $(document).on(
                        'click',
                        '.existing-image-card',
                        function() {

                            currentCropIndex =
                                $(this).data('index');

                            currentCropMode =
                                'existing-edit';

                            const image =
                                existingEditImages[
                                    currentCropIndex
                                ];

                            $('#cropperImage')
                                .attr(
                                    'src',
                                    image.image_url
                                );

                            $('#cropImageModal')
                                .modal('show');
                        }
                    );

                    // =========================
                    // INIT CROPPER
                    // =========================

                    $('#cropImageModal').on(
                        'shown.bs.modal',
                        function() {

                            const image =
                                document.getElementById(
                                    'cropperImage'
                                );

                            if (cropper) {
                                cropper.destroy();
                            }

                            cropper = new Cropper(
                                image, {
                                    viewMode: 1,
                                    responsive: true,
                                    restore: false,
                                    autoCropArea: 1,
                                    checkOrientation: false
                                }
                            );
                        }
                    );

                    // =========================
                    // DESTROY CROPPER
                    // =========================

                    $('#cropImageModal').on(
                        'hidden.bs.modal',
                        function() {

                            if (cropper) {
                                cropper.destroy();
                                cropper = null;
                            }

                            $('#cropperImage')
                                .attr('src', '');
                        }
                    );

                    // =========================
                    // CLOSE CROPPER
                    // =========================

                    $(document).on(
                        'click',
                        '.cropModalCloseBtn',
                        function() {

                            $('#cropImageModal')
                                .modal('hide');
                        }
                    );

                    // =========================
                    // SAVE CROP
                    // =========================

                    $('#saveCropBtn').on('click', function() {

                        if (!cropper) return;

                        cropper
                            .getCroppedCanvas()
                            .toBlob(blob => {

                                // EXISTING IMAGE
                                if (currentCropMode === 'existing-edit') {

                                    const oldImage =
                                        existingEditImages[
                                            currentCropIndex
                                        ];

                                    const fileName =
                                        oldImage.image
                                        .split('/')
                                        .pop();

                                    const croppedFile =
                                        new File(
                                            [blob],
                                            fileName, {
                                                type: 'image/jpeg'
                                            }
                                        );

                                    croppedExistingImages.push({
                                        id: oldImage.id,
                                        file: croppedFile
                                    });

                                    oldImage.image_url =
                                        URL.createObjectURL(
                                            croppedFile
                                        );

                                    renderExistingEditImages();

                                    $('#cropImageModal')
                                        .modal('hide');

                                    return;
                                }

                                // NEW FILE
                                let targetFiles =
                                    currentCropMode === 'edit' ?
                                    editFiles :
                                    addFiles;

                                const oldFile =
                                    targetFiles[
                                        currentCropIndex
                                    ];

                                const croppedFile =
                                    new File(
                                        [blob],
                                        oldFile.name, {
                                            type: 'image/jpeg'
                                        }
                                    );

                                targetFiles[
                                    currentCropIndex
                                ] = croppedFile;

                                if (
                                    currentCropMode ===
                                    'edit'
                                ) {

                                    renderExistingEditImages();

                                } else {

                                    renderImages(
                                        addFiles,
                                        '#eventImagesPreview',
                                        'add'
                                    );
                                }

                                $('#cropImageModal')
                                    .modal('hide');

                            }, 'image/jpeg');
                    });

                    // =========================
                    // DATERANGE ADD
                    // =========================

                    $('#eventDateRange').daterangepicker({
                        autoUpdateInput: false,
                        timePicker: true,
                        timePicker24Hour: true,
                        timePickerIncrement: 15,
                        locale: {
                            format: 'DD MMM YYYY HH:mm',
                            cancelLabel: 'Clear'
                        }
                    });

                    $('#eventDateRange').on(
                        'apply.daterangepicker',
                        function(ev, picker) {

                            $(this).val(
                                picker.startDate.format(
                                    'DD MMM YYYY HH:mm'
                                ) +
                                ' - ' +
                                picker.endDate.format(
                                    'DD MMM YYYY HH:mm'
                                )
                            );

                            $('#eventStartDate').val(
                                picker.startDate.format(
                                    'YYYY-MM-DD HH:mm:ss'
                                )
                            );

                            $('#eventEndDate').val(
                                picker.endDate.format(
                                    'YYYY-MM-DD HH:mm:ss'
                                )
                            );
                        }
                    );

                    // =========================
                    // DATERANGE EDIT
                    // =========================

                    $('#eventDateRangeEdit').daterangepicker({
                        autoUpdateInput: false,
                        timePicker: true,
                        timePicker24Hour: true,
                        timePickerIncrement: 15,
                        locale: {
                            format: 'DD MMM YYYY HH:mm'
                        }
                    });

                    $('#eventDateRangeEdit').on(
                        'apply.daterangepicker',
                        function(ev, picker) {

                            $(this).val(
                                picker.startDate.format(
                                    'DD MMM YYYY HH:mm'
                                ) +
                                ' - ' +
                                picker.endDate.format(
                                    'DD MMM YYYY HH:mm'
                                )
                            );

                            $('#dateEventEdit').val(
                                picker.startDate.format(
                                    'YYYY-MM-DD HH:mm:ss'
                                )
                            );

                            $('#endDateEventEdit').val(
                                picker.endDate.format(
                                    'YYYY-MM-DD HH:mm:ss'
                                )
                            );
                        }
                    );

                    // =========================
                    // ADD EVENT AJAX
                    // =========================

                    $('#addEventFormAdmin').on('submit', function(e) {

                        e.preventDefault();

                        let formData = new FormData(this);

                        addFiles.forEach(file => {

                            formData.append(
                                'images[]',
                                file
                            );
                        });

                        $.ajax({

                            url: "{{ route('event.adminStore') }}",
                            method: "POST",

                            data: formData,

                            processData: false,
                            contentType: false,

                            success: function(response) {

                                $('#addEventModalAdminNew')
                                    .modal('hide');

                                $('#addEventFormAdmin')[0]
                                    .reset();

                                // reset select2 place
                                $('#placeSelectCode')
                                    .val(null)
                                    .trigger('change');

                                // reset active switch
                                $('#addEventIsActive')
                                    .prop('checked', true);

                                updateAddEventStatusLabel();

                                addFiles = [];

                                renderEmptyImageState(
                                    '#eventImagesPreview'
                                );

                                $('#dataTableEvent')
                                    .DataTable()
                                    .ajax
                                    .reload();

                                Swal.fire({
                                    icon: 'success',
                                    title: i18nEvent.swalSuccess,
                                    text: response.message
                                });
                            },

                            error: function(xhr) {

                                Swal.fire({
                                    icon: 'error',
                                    title: i18nEvent.swalFailed,
                                    text: xhr.responseJSON?.message ??
                                        'Something went wrong'
                                });
                            }
                        });
                    });

                    // =========================
                    // EDIT OPEN
                    // =========================

                    $(document).on('click', '.editEventBtn', function() {

                        let id = $(this).attr('id');

                        $.ajax({
                            type: "GET",
                            url: "/management/master/my-event/get-data/" + id,

                            success: function(response) {

                                let data = response.data;

                                $('#eventIdEdit').val(data.id);

                                $('#titleEventEdit')
                                    .val(data.title);

                                $('#descriptionEventEdit')
                                    .val(data.description);

                                // set active
                                $('#editEventIsActive').prop(
                                    'checked',
                                    data.is_active == 1
                                );

                                updateEditEventStatusLabel();

                                existingEditImages =
                                    data.images ?? [];

                                editFiles = [];

                                const preview =
                                    $('#eventImagesPreviewEdit');

                                preview.empty();

                                if (
                                    !existingEditImages ||
                                    existingEditImages.length === 0
                                ) {

                                    renderEmptyImageState(
                                        '#eventImagesPreviewEdit'
                                    );

                                } else {

                                    renderExistingEditImages();
                                }

                                $('#dateEventEdit')
                                    .val(data.date);

                                $('#endDateEventEdit')
                                    .val(data.end_date);

                                let start = moment(data.date);

                                let end = data.end_date ?
                                    moment(data.end_date) :
                                    moment(data.date);

                                $('#eventDateRangeEdit')
                                    .data('daterangepicker')
                                    .setStartDate(start);

                                $('#eventDateRangeEdit')
                                    .data('daterangepicker')
                                    .setEndDate(end);

                                $('#eventDateRangeEdit').val(
                                    start.format('DD MMM YYYY HH:mm') +
                                    ' - ' +
                                    end.format('DD MMM YYYY HH:mm')
                                );

                                $('#editEventModalAdminNew')
                                    .modal('show');
                            }
                        });
                    });

                    // =========================
                    // EDIT SUBMIT
                    // =========================

                    $('#editEventFormAdmin').on('submit', function(e) {

                        e.preventDefault();

                        let formData = new FormData(this);

                        existingEditImages.forEach(img => {

                            formData.append(
                                'existing_images[]',
                                img.id
                            );
                        });

                        croppedExistingImages.forEach(item => {

                            formData.append(
                                `cropped_images[${item.id}]`,
                                item.file
                            );
                        });

                        editFiles.forEach(file => {

                            formData.append(
                                'images[]',
                                file
                            );
                        });

                        $.ajax({

                            url: "{{ route('myevent.update') }}",
                            method: "POST",

                            data: formData,

                            processData: false,
                            contentType: false,

                            success: function(response) {

                                $('#editEventModalAdminNew')
                                    .modal('hide');

                                $('#editEventFormAdmin')[0]
                                    .reset();

                                editFiles = [];
                                existingEditImages = [];

                                renderEmptyImageState(
                                    '#eventImagesPreviewEdit'
                                );

                                $('#dataTableEvent')
                                    .DataTable()
                                    .ajax
                                    .reload();

                                Swal.fire({
                                    icon: 'success',
                                    title: i18nEvent.swalSuccess,
                                    text: response.message ?? response.success
                                });
                            },

                            error: function(xhr) {

                                Swal.fire({
                                    icon: 'error',
                                    title: i18nEvent.swalFailed,
                                    text: xhr.responseJSON?.message ??
                                        'Something went wrong'
                                });
                            }
                        });
                    });

                    // $('#placeSelectCode').select2();

                    // ==================================
                    // KEEP COLUMN DROPDOWN OPEN
                    // ==================================
                    $('#columnVisibilityDropdown')
                        .siblings('.dropdown-menu')
                        .on('click', function(e) {
                            e.stopPropagation();
                        });

                    // prevent checkbox click closing dropdown
                    $(document).on(
                        'click',
                        '.dropdown-menu .toggle-column, .dropdown-menu .custom-control-label',
                        function(e) {
                            e.stopPropagation();
                        }
                    );
                    $("#placeSelectCode").select2({
                        placeholder: 'Select Place',
                        allowClear: true,
                        width: '100%',
                        dropdownParent: $("#addEventModalAdminNew")
                    });

                    // ==================================
                    // FETCH PLACE SELECT
                    // ==================================

                    $('#placeSelectCode').empty();
                    $('#placeSelectCode').append(
                        '<option value="">Select a place</option>'
                    );

                    $.ajax({
                        url: "{{ route('place.getAll') }}",
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },

                        success: function(response) {

                            if (response.data && response.data.length > 0) {

                                // show wrapper
                                $('#placeSelectWrapper').show();

                                response.data.map((item) => {

                                    $('#placeSelectCode').append(`
                    <option value="${item.place_code}">
                        ${item.title} | ${item.place_code}
                    </option>
                `);
                                });

                                $('#placeSelectCode').trigger('change');
                            }
                        },

                        error: function(xhr) {

                            console.log(xhr);

                            $('#placeSelectWrapper').hide();

                            Swal.fire({
                                icon: 'error',
                                title: i18nEvent.swalFailed,
                                text: 'Failed to fetch places'
                            });
                        }
                    });

                    var dataTableEvent = $('#dataTableEvent').DataTable({
                        createdRow: function(row, data, dataIndex) {

                            $('td:eq(0)', row).css('min-width', '220px');
                            $('td:eq(1)', row).css('min-width', '250px');
                            $('td:eq(2)', row).css('min-width', '180px');
                            $('td:eq(3)', row).css('min-width', '180px');
                            $('td:eq(4)', row).css('min-width', '120px');

                            $('td:last', row).css({
                                'text-align': 'center',
                                'vertical-align': 'middle',
                                'min-width': '140px'
                            });
                        },

                        processing: true,
                        serverSide: true,
                        order: [],

                        dom: '<"top"<"dataTables_length"l><"dataTables_filter"f>>rt<"bottom"<"dataTables_info"i><"dataTables_paginate"p>>',

                        ajax: {
                            url: "{{ route('event') }}",

                            data: function(d) {

                                d.title = $('#filter-title').val();
                                d.place_code = $('#filter-place-code').val();
                                d.status = $('#filter-status').val();
                                d.date = $('#filter-date').val();
                                d.end_date = $('#filter-end-date').val();
                                d.sort_by = $('#sort-order').val();
                            }
                        },

                        columns: [{
                                data: 'title',
                                name: 'title'
                            },
                            {
                                data: 'description',
                                name: 'description'
                            },
                            {
                                data: 'place_code',
                                name: 'place_code'
                            },
                            {
                                data: 'date',
                                name: 'date',
                                defaultContent: '-'
                            },
                            {
                                data: 'status',
                                name: 'status'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false
                            }
                        ]
                    });


                    // =========================
                    // DEBOUNCE
                    // =========================

                    function debounce(func, delay) {

                        let timer;

                        return function(...args) {

                            clearTimeout(timer);

                            timer = setTimeout(() => {
                                func.apply(this, args);
                            }, delay);
                        };
                    }

                    const reloadTableDebounced = debounce(function() {
                        dataTableEvent.ajax.reload();
                    }, 500);

                    $('#filter-title, #filter-place-code')
                        .on('keyup', function() {
                            reloadTableDebounced();
                        });

                    $('#filter-status, #filter-date, #filter-end-date')
                        .on('change', function() {
                            dataTableEvent.ajax.reload();
                        });

                    // =========================
                    // SORT
                    // =========================

                    $('#sort-order').on('change', function() {

                        let value = $(this).val();

                        if (value === 'title') {
                            dataTableEvent.order([0, 'asc']).draw();
                        } else if (value === 'date') {
                            dataTableEvent.order([3, 'desc']).draw();
                        } else if (value === 'status') {
                            dataTableEvent.order([4, 'asc']).draw();
                        } else {
                            dataTableEvent.order([]).draw();
                        }

                        dataTableEvent.ajax.reload();
                    });

                    // =========================
                    // CLEAR FILTER
                    // =========================

                    $('#clear-filters').on('click', function() {

                        $('#filter-title').val('');
                        $('#filter-place-code').val('');
                        $('#filter-status').val('');
                        $('#filter-date').val('');
                        $('#filter-end-date').val('');
                        $('#sort-order').val('');

                        dataTableEvent.ajax.reload();
                    });

                    // =========================
                    // COLUMN VISIBILITY
                    // =========================

                    // ==================================
                    // COLUMN VISIBILITY
                    // ==================================

                    const STORAGE_KEY = 'event_table_column_visibility';

                    // keep dropdown open
                    $('#columnVisibilityDropdown')
                        .siblings('.dropdown-menu')
                        .on('click', function(e) {
                            e.stopPropagation();
                        });

                    // prevent checkbox/label click close dropdown
                    $(document).on(
                        'click',
                        '.dropdown-menu .toggle-column, .dropdown-menu .custom-control-label',
                        function(e) {
                            e.stopPropagation();
                        }
                    );

                    // save state
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

                    // apply saved state
                    function applySavedColumnState() {

                        const saved =
                            JSON.parse(
                                localStorage.getItem(STORAGE_KEY)
                            ) || {};

                        $('.toggle-column').each(function() {

                            const columnIndex =
                                $(this).data('column');

                            const isVisible =
                                saved[columnIndex] ?? true;

                            $(this).prop(
                                'checked',
                                isVisible
                            );

                            dataTableEvent
                                .column(columnIndex)
                                .visible(
                                    isVisible,
                                    false
                                );
                        });

                        dataTableEvent
                            .columns
                            .adjust()
                            .draw(false);
                    }

                    // toggle visibility
                    $('.toggle-column').on(
                        'change',
                        function(e) {

                            e.stopPropagation();

                            const checkedColumns =
                                $('.toggle-column:checked')
                                .length;

                            // prevent last visible column hidden
                            if (
                                checkedColumns === 0
                            ) {

                                $(this).prop(
                                    'checked',
                                    true
                                );

                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'warning',
                                    title: i18nEvent.minColumn,
                                    showConfirmButton: false,
                                    timer: 1800
                                });

                                return;
                            }

                            const columnIndex =
                                $(this).data('column');

                            const isVisible =
                                $(this).is(':checked');

                            dataTableEvent
                                .column(columnIndex)
                                .visible(isVisible);

                            saveColumnState();
                        }
                    );

                    // init
                    applySavedColumnState();

                    //Submit New Event
                    $(document).on('submit', '#addEventForm', function(e) {
                        e.preventDefault();

                        $.ajax({
                            type: "POST",
                            url: "{{ route('event.adminStore') }}",
                            data: $(this).serialize(),
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
                                    $('#addEventModalAdmin').modal('hide');
                                    $("#addEventForm")[0].reset();
                                    $('#dataTableEvent').DataTable().ajax.reload();
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
                    })

                    $(document).on('click', '.deleteEventButtonNew', function(e) {
                        e.preventDefault();
                        var id = $(this).attr('id');

                        Swal.fire({
                            customClass: {
                                confirmButton: "btn btn-success",
                                cancelButton: "btn btn-danger"
                            },
                            title: i18nEvent.swalTitle,
                            text: i18nEvent.deleteText,
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: i18nEvent.swalConfirm,
                            cancelButtonText: i18nEvent.swalCancel,
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "POST",
                                    url: "/management/master/my-event/delete/" + id,
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
                                            $('#dataTableEvent').DataTable().ajax.reload();
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




                    // Setup Submitted Edit
                    $(document).on('submit', '#editEventForm', function(e) {
                        e.preventDefault();

                        $.ajax({
                            type: "POST",
                            url: "{{ route('myevent.update') }}",
                            data: $(this).serialize(),
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
                                    $('#editEventModalAdmin').modal('hide');
                                    $("#editEventForm")[0].reset();
                                    $('#dataTableEvent').DataTable().ajax.reload();
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

                    });
                });
            </script>
        @endpush
        <!-- End of Main Content -->
    </div>

    {{-- TUTORIAL FAB --}}
    <button class="event-tutorial-fab" title="Tutorial" onclick="showEventTutorialModal()">
        <i class="fas fa-question"></i>
    </button>

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/intro.js@7.2.0/minified/intro.min.js"></script>
        <script>
            const eventTutorialSteps = {
                id: [
                    {
                        element: '#eventPageTitle',
                        intro: '<strong>Selamat Datang di Manajemen Event!</strong><br>Halaman ini memungkinkan Anda mengelola semua event yang terhubung ke tempat Anda — tambah, edit, hapus, dan filter dengan mudah.',
                        position: 'bottom'
                    },
                    {
                        element: '#eventFilterCard',
                        intro: '<strong>Panel Filter</strong><br>Gunakan panel ini untuk menyaring event berdasarkan judul, kode tempat, status aktif/nonaktif, dan rentang tanggal.',
                        position: 'bottom'
                    },
                    {
                        element: '#filter-title',
                        intro: '<strong>Cari Berdasarkan Judul</strong><br>Ketik kata kunci judul event untuk memfilter tabel secara real-time.',
                        position: 'right'
                    },
                    {
                        element: '#filter-status',
                        intro: '<strong>Filter Status</strong><br>Pilih <em>Active</em> untuk menampilkan event yang sedang berjalan, atau <em>Inactive</em> untuk yang sudah tidak aktif.',
                        position: 'right'
                    },
                    {
                        element: '#filter-date',
                        intro: '<strong>Filter Tanggal Mulai & Selesai</strong><br>Gunakan kedua kolom ini untuk menyaring event berdasarkan rentang tanggal tertentu.',
                        position: 'top'
                    },
                    {
                        element: '#sort-order',
                        intro: '<strong>Urutkan Data</strong><br>Pilih cara pengurutan: berdasarkan judul (A–Z), tanggal terbaru, atau status aktif.',
                        position: 'bottom'
                    },
                    {
                        element: '#clear-filters',
                        intro: '<strong>Reset Filter</strong><br>Klik tombol ini untuk menghapus semua filter aktif dan kembali ke tampilan penuh.',
                        position: 'bottom'
                    },
                    {
                        element: '#eventTableCard',
                        intro: '<strong>Tabel Event</strong><br>Daftar semua event ditampilkan di sini dengan pagination otomatis. Klik tombol aksi di baris untuk mengedit atau menghapus event.',
                        position: 'top'
                    },
                    {
                        element: '#columnVisibilityDropdown',
                        intro: '<strong>Visibilitas Kolom</strong><br>Klik tombol ini untuk menampilkan atau menyembunyikan kolom tertentu. Preferensi Anda akan tersimpan otomatis di browser.',
                        position: 'bottom'
                    },
                    {
                        element: '#btnAddEvent',
                        intro: '<strong>Tambah Event Baru</strong><br>Klik tombol ini untuk membuka form tambah event. Kita akan melihat form-nya sekarang!',
                        position: 'left'
                    },
                    {
                        element: '#addEventDateGroup',
                        intro: '<strong>Jadwal Event</strong><br>Pilih tanggal dan waktu mulai serta selesai event menggunakan date-range picker. Pastikan rentang waktu sudah benar.',
                        position: 'bottom'
                    },
                    {
                        element: '#placeSelectWrapper',
                        intro: '<strong>Pilih Tempat</strong><br>Hubungkan event ini ke salah satu tempat yang Anda miliki. Dropdown akan menampilkan semua tempat yang terdaftar.',
                        position: 'bottom'
                    },
                    {
                        element: '#addEventTitleGroup',
                        intro: '<strong>Judul Event</strong><br>Masukkan nama event yang jelas dan mudah dikenali oleh pengunjung. Judul ini akan tampil di halaman publik.',
                        position: 'bottom'
                    },
                    {
                        element: '#addEventDescGroup',
                        intro: '<strong>Deskripsi Event</strong><br>Tuliskan informasi detail tentang event — kegiatan, lokasi spesifik, persyaratan, dan hal-hal penting lainnya.',
                        position: 'top'
                    },
                    {
                        element: '#addEventStatusGroup',
                        intro: '<strong>Status Aktif</strong><br>Toggle ini menentukan apakah event langsung terlihat oleh publik. Nonaktifkan jika event masih dalam persiapan.',
                        position: 'top'
                    },
                    {
                        element: '#addEventImagesGroup',
                        intro: '<strong>Foto Event</strong><br>Upload satu atau beberapa foto untuk event. Klik foto yang sudah diupload untuk memotong/crop gambar sesuai kebutuhan.',
                        position: 'top'
                    },
                    {
                        element: '#addEventFooter',
                        intro: '<strong>Simpan atau Batal</strong><br>Klik <strong>Save Event</strong> untuk menyimpan, atau klik <strong>Cancel</strong> / tombol ✕ untuk menutup modal tanpa menyimpan.',
                        position: 'top'
                    },
                ],
                en: [
                    {
                        element: '#eventPageTitle',
                        intro: '<strong>Welcome to Event Management!</strong><br>This page lets you manage all events linked to your places — add, edit, delete, and filter with ease.',
                        position: 'bottom'
                    },
                    {
                        element: '#eventFilterCard',
                        intro: '<strong>Filter Panel</strong><br>Use this panel to filter events by title, place code, active/inactive status, and date range.',
                        position: 'bottom'
                    },
                    {
                        element: '#filter-title',
                        intro: '<strong>Search by Title</strong><br>Type a keyword to filter the event table in real-time.',
                        position: 'right'
                    },
                    {
                        element: '#filter-status',
                        intro: '<strong>Filter by Status</strong><br>Choose <em>Active</em> to show ongoing events or <em>Inactive</em> for deactivated ones.',
                        position: 'right'
                    },
                    {
                        element: '#filter-date',
                        intro: '<strong>Start & End Date Filter</strong><br>Use both date fields to filter events within a specific date range.',
                        position: 'top'
                    },
                    {
                        element: '#sort-order',
                        intro: '<strong>Sort Data</strong><br>Choose a sort order: by title (A–Z), newest date, or status.',
                        position: 'bottom'
                    },
                    {
                        element: '#clear-filters',
                        intro: '<strong>Reset Filters</strong><br>Click this to clear all active filters and return to the full list.',
                        position: 'bottom'
                    },
                    {
                        element: '#eventTableCard',
                        intro: '<strong>Event Table</strong><br>All events are listed here with automatic pagination. Use the action buttons in each row to edit or delete an event.',
                        position: 'top'
                    },
                    {
                        element: '#columnVisibilityDropdown',
                        intro: '<strong>Column Visibility</strong><br>Click here to show or hide specific table columns. Your preferences are saved automatically in the browser.',
                        position: 'bottom'
                    },
                    {
                        element: '#btnAddEvent',
                        intro: '<strong>Add New Event</strong><br>Click this button to open the add event form. We\'ll walk through it now!',
                        position: 'left'
                    },
                    {
                        element: '#addEventDateGroup',
                        intro: '<strong>Event Schedule</strong><br>Select the start and end date/time using the date-range picker. Make sure the time range is correct.',
                        position: 'bottom'
                    },
                    {
                        element: '#placeSelectWrapper',
                        intro: '<strong>Select Place</strong><br>Link this event to one of your registered places. The dropdown lists all your available places.',
                        position: 'bottom'
                    },
                    {
                        element: '#addEventTitleGroup',
                        intro: '<strong>Event Title</strong><br>Enter a clear and recognizable event name. This title will appear on the public page.',
                        position: 'bottom'
                    },
                    {
                        element: '#addEventDescGroup',
                        intro: '<strong>Event Description</strong><br>Provide detailed information — activities, specific location, requirements, and other key details.',
                        position: 'top'
                    },
                    {
                        element: '#addEventStatusGroup',
                        intro: '<strong>Active Status</strong><br>This toggle controls whether the event is visible to the public. Disable it if the event is still being prepared.',
                        position: 'top'
                    },
                    {
                        element: '#addEventImagesGroup',
                        intro: '<strong>Event Photos</strong><br>Upload one or more photos for the event. Click an uploaded photo to crop it as needed.',
                        position: 'top'
                    },
                    {
                        element: '#addEventFooter',
                        intro: '<strong>Save or Cancel</strong><br>Click <strong>Save Event</strong> to save, or click <strong>Cancel</strong> / the ✕ button to close the modal without saving.',
                        position: 'top'
                    },
                ]
            };

            // Steps that require the modal to be open
            const MODAL_STEP_IDS = [
                '#addEventDateGroup', '#placeSelectWrapper', '#addEventTitleGroup',
                '#addEventDescGroup', '#addEventStatusGroup', '#addEventImagesGroup', '#addEventFooter'
            ];

            function startEventTutorial(lang) {
                const steps = eventTutorialSteps[lang] ?? eventTutorialSteps['en'];

                const validSteps = steps.filter(function(step) {
                    const el = document.querySelector(step.element);
                    if (!el) return false;
                    // Skip steps for elements that are hidden (e.g. placeSelectWrapper when only 1 place)
                    return el.offsetParent !== null || getComputedStyle(el).display !== 'none';
                });

                let modalOpened = false;

                introJs()
                    .setOptions({
                        steps: validSteps,
                        nextLabel: lang === 'id' ? 'Lanjut ›' : 'Next ›',
                        prevLabel: lang === 'id' ? '‹ Kembali' : '‹ Back',
                        doneLabel: lang === 'id' ? 'Selesai' : 'Done',
                        showBullets: true,
                        showProgress: true,
                        exitOnOverlayClick: false,
                        scrollToElement: false,
                        overlayOpacity: 0.45
                    })
                    .onbeforechange(function(el) {
                        if (!el) return;

                        const isModalStep = MODAL_STEP_IDS.some(sel => el.matches?.(sel));

                        if (isModalStep && !modalOpened) {
                            // Return a Promise — intro.js waits for it before rendering the tooltip
                            return new Promise(function(resolve) {
                                modalOpened = true;
                                $('#addEventModalAdminNew')
                                    .one('shown.bs.modal', function() {
                                        // Modal fully visible — now safe to center and resolve
                                        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                        setTimeout(resolve, 80);
                                    })
                                    .modal('show');
                            });
                        }

                        if (!isModalStep && modalOpened) {
                            modalOpened = false;
                            $('#addEventModalAdminNew').modal('hide');
                        }

                        // Center every non-modal element in the viewport
                        if (!isModalStep) {
                            setTimeout(function() {
                                el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }, 50);
                        } else {
                            // Already in modal — just scroll within it
                            setTimeout(function() {
                                el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                            }, 80);
                        }
                    })
                    .oncomplete(function() {
                        if (modalOpened) { modalOpened = false; $('#addEventModalAdminNew').modal('hide'); }
                        localStorage.setItem('event_tutorial_seen', '1');
                    })
                    .onexit(function() {
                        if (modalOpened) { modalOpened = false; $('#addEventModalAdminNew').modal('hide'); }
                        localStorage.setItem('event_tutorial_seen', '1');
                    })
                    .start();
            }

            function showEventTutorialModal() {
                Swal.fire({
                    title: '👋 Welcome',
                    html: `
                        <p class="text-muted mb-4">Please choose your preferred tutorial language or skip the tutorial.</p>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <button id="event-lang-id" class="btn btn-primary btn-block py-3">
                                    🇮🇩<br><strong>Bahasa Indonesia</strong>
                                </button>
                            </div>
                            <div class="col-6 mb-3">
                                <button id="event-lang-en" class="btn btn-outline-primary btn-block py-3">
                                    🇺🇸<br><strong>English</strong>
                                </button>
                            </div>
                        </div>
                        <hr>
                        <button id="event-skip" class="btn btn-link text-muted">Skip Tutorial</button>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: function() {
                        document.getElementById('event-lang-id').addEventListener('click', function() {
                            localStorage.setItem('event_tutorial_lang', 'id');
                            Swal.close();
                            startEventTutorial('id');
                        });
                        document.getElementById('event-lang-en').addEventListener('click', function() {
                            localStorage.setItem('event_tutorial_lang', 'en');
                            Swal.close();
                            startEventTutorial('en');
                        });
                        document.getElementById('event-skip').addEventListener('click', function() {
                            localStorage.setItem('event_tutorial_seen', '1');
                            Swal.close();
                        });
                    }
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                if (!localStorage.getItem('event_tutorial_seen')) {
                    setTimeout(showEventTutorialModal, 900);
                }
            });
        </script>
    @endpush

    @endsection
