@extends('TemplateLayout.AdminLayout')

@section('content')
    @php
        $isEdit = isset($Place);
    @endphp

    @push('title')
        <title>Detail Place Admin - QRUN Website</title>
    @endpush


    <div class="container-fluid py-4">

        {{-- Page Heading --}}
        <div class="page-header-wrapper mb-3">
            <div>
                <h1 class="page-title mb-2">
                    <i class="fas fa-map-pin text-primary mr-3"></i>Detail Place
                </h1>
                <p class="page-subtitle mb-0">
                    View the details of the selected place.
                </p>
            </div>
        </div>

        {{-- Success Alert --}}
        @if (session()->has('success'))
            <div class="alert alert-success alert-success-custom shadow-sm border-0 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    <div>
                        <strong>Success!</strong>
                        <span class="d-block">{{ session()->get('success') }}</span>
                    </div>
                </div>
            </div>
        @endif

        {{-- Error Alert --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-danger-custom shadow-sm border-0 mb-4" role="alert">
                <div class="d-flex align-items-start">
                    <i class="fas fa-exclamation-circle mr-3 mt-1"></i>
                    <div>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2 pl-3">
                            @foreach ($errors->all() as $error)
                                <li class="mb-1">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Main Form Card --}}

        <div>
            <div class="card form-card shadow-lg border-0">
                <div class="card-header bg-white py-4 border-bottom border-light">
                    <div class="d-flex align-items-center flex-wrap w-100">
                        <h5 class="m-0 font-weight-bold text-dark d-flex align-items-center">
                            <span class="badge badge-primary-light badge-icon mr-3">1</span>
                            <div>
                                <div>Basic Information</div>
                                <small class="section-description">
                                    Enter the name and description of the place
                                </small>
                            </div>
                        </h5>

                        <div class="d-flex align-items-center ml-auto mt-3 mt-md-0">
                            <a href="{{ route('place.detail', $Place->place_code) }}" target="_blank"
                                class="btn btn-outline-primary btn-sm mr-2">
                                <i class="fas fa-external-link-alt mr-1"></i>
                                Live Preview
                            </a>

                            <a href="{{ route('place.print', $Place->place_code) }}" target="_blank"
                                class="btn btn-primary btn-sm">
                                <i class="fas fa-qrcode mr-1"></i>
                                Print QR Code
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    {{-- Basic Information --}}
                    <div class="form-section">

                        <div class="row">

                            <div class="col-md-6 mb-4">
                                <label class="form-label">
                                    Title <span class="text-danger">*</span>
                                </label>

                                <input disabled required class="form-control" name="title" type="text"
                                    value="{{ old('title', $Place->title ?? '') }}" placeholder="Enter place title...">

                                @error('title')
                                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">
                                    Contact Person
                                </label>

                                <input disabled class="form-control" name="phone_num" type="number"
                                    value="{{ old('phone_num', $Place->phone_num ?? '') }}"
                                    placeholder="Enter contact phone number...">

                                @error('phone_num')
                                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label">
                                    Description <span class="text-danger">*</span>
                                </label>

                                <textarea disabled required class="form-control" rows="3" name="description"
                                    placeholder="Short description about this place...">{{ old('description', $Place->description ?? '') }}</textarea>

                                @error('description')
                                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="card form-card shadow-lg border-0">

                <div class="card-header bg-white py-4 border-bottom border-light">
                    <h5 class="m-0 font-weight-bold text-dark d-flex align-items-center">
                        <span class="badge badge-primary-light badge-icon mr-3">2</span>
                        <div>
                            <div>Location Information</div>
                            <small class="section-description">Select the province, city, district, and village where
                                the place is located</small>
                        </div>
                    </h5>
                </div>

                <div class="card-body p-4">
                    {{-- Location --}}
                    <div class="card-body p-0">
                        <div class="location-wrapper mb-0">

                            <div class="row">

                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        Province
                                    </label>

                                    <select disabled id="provinceDataSelect" name="reg_province"
                                        class="form-control select2">
                                        <option value="">Select Province</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        City / Regency
                                    </label>

                                    <select disabled id="regencyDataSelect" name="reg_regency" class="form-control select2">
                                        <option value="">Select Regency</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        District
                                    </label>

                                    <select disabled id="districtDataSelect" name="reg_district"
                                        class="form-control select2">
                                        <option value="">Select District</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        Village
                                    </label>

                                    <select disabled id="villagesDataSelect" name="reg_village"
                                        class="form-control select2">
                                        <option value="">Select Village</option>
                                    </select>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card form-card shadow-lg border-0">
                <div class="card-header bg-white py-4 border-bottom border-light">
                    <h5 class="m-0 font-weight-bold text-dark d-flex align-items-center">
                        <span class="badge badge-primary-light badge-icon mr-3">3</span>
                        <div>
                            <div>Content Editor</div>
                            <small class="section-description">Write detailed content about the place including text,
                                images, and formatting</small>
                        </div>
                    </h5>
                </div>

                <div class="card-body p-4">
                    {{-- Content --}}
                    <div class="card-body p-0">
                        <div class="mb-4">

                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-edit text-primary mr-2"></i>
                                <h5 class="mb-0 font-weight-bold">
                                    Content Editor
                                </h5>
                            </div>

                            <textarea class="form-control" name="content" id="summernote">{{ old('content', $Place->content ?? '') }}</textarea>

                            @error('content')
                                <small class="text-danger d-block mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card form-card shadow-lg border-0">
                <div class="card-header bg-white py-4 border-bottom border-light">
                    <h5 class="m-0 font-weight-bold text-dark d-flex align-items-center">
                        <span class="badge badge-primary-light badge-icon mr-3">4</span>
                        <div>
                            <div>Settings</div>
                            <small class="section-description">Configure options for how visitors can interact with this
                                place</small>
                        </div>
                    </h5>
                </div>

                <div class="card-body p-4">
                    <div class="comment-toggle">

                        <div>
                            <h6 class="font-weight-bold mb-2">
                                <i class="fas fa-comments text-primary mr-2"></i>Enable Comments
                            </h6>

                            <small class="text-muted d-block">
                                Allow visitors to leave comments and engage with this place.
                            </small>
                        </div>

                        <label class="switch mb-0">
                            <input type="checkbox" name="AllowComment"
                                {{ old('AllowComment', $Place->is_comment ?? true) ? 'checked' : '' }}>
                            <span class="slider-custom"></span>
                        </label>

                    </div>
                    {{-- Submit Section --}}
                    <div
                        class="card-footer bg-white p-4 d-flex justify-content-between align-items-center border-top border-light">
                        <small class="text-muted">
                            <i class="fas fa-asterisk text-danger mr-1"></i> Required fields
                        </small>
                        <div class="d-flex gap-3">
                            <a type="button" href="{{ route('place') }}" class="btn btn-secondary btn-md back-btn">
                                <i class="fas fa-arrow-left mr-2"></i>Back
                            </a>
                            {{-- <button type="submit" class="btn btn-primary submit-btn shadow-sm">
                                <i class="fas fa-save mr-2"></i>{{ $isEdit ? 'Update Place' : 'Create Place' }}
                            </button> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card form-card shadow-lg border-0 mt-4">
                <div class="card-header bg-white py-4 border-bottom border-light">

                    <div class="d-flex align-items-center w-100">

                        <div>
                            <h5 class="m-0 font-weight-bold text-dark d-flex align-items-center">
                                <span class="badge badge-primary-light badge-icon mr-3">5</span>

                                <div>
                                    <div>Place Events</div>

                                    <small class="section-description">
                                        Manage schedules and events related to this place
                                    </small>
                                </div>
                            </h5>
                        </div>

                        {{-- RIGHT SIDE BUTTON --}}
                        <div class="ml-auto">
                            <button type="button" class="btn btn-primary shadow-sm rounded-pill px-4"
                                data-toggle="modal" data-target="#addEventModalAdminNew">

                                <i class="fas fa-plus mr-2"></i>
                                Add Event
                            </button>
                        </div>

                    </div>

                </div>
                <div class="card-body p-4">

                    <div class="event-summary-card mb-4">
                        <div class="d-flex align-items-center">
                            <div class="event-icon-box mr-3">
                                <i class="fas fa-calendar-alt"></i>
                            </div>

                            <div>
                                <h6 class="font-weight-bold mb-1">
                                    Event Schedule
                                </h6>
                                <small class="text-muted">
                                    Create, update, and organize events for this place.
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered" id="dataTablePlaceEvent"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Schedule</th>
                                    <th>Status</th>
                                    <th width="170" class="text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>

    @push('css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        @include('Pages.Management.Master.place.components.style')
        <style>
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
        </style>
    @endpush

    @push('script')
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <script>
            let selectedProvince = "{{ old('reg_province', $Place->province_id ?? ($Place->reg_province ?? '')) }}";
            let selectedRegency = "{{ old('reg_regency', $Place->regency_id ?? ($Place->reg_regency ?? '')) }}";
            let selectedDistrict = "{{ old('reg_district', $Place->district_id ?? ($Place->reg_district ?? '')) }}";
            let selectedVillage = "{{ old('reg_village', $Place->village_id ?? ($Place->reg_village ?? '')) }}";

            $(document).ready(async function() {

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
                        .text(checked ? 'Active' : 'Inactive')
                        .removeClass('badge-success badge-secondary')
                        .addClass(checked ? 'badge-success' : 'badge-secondary');
                }

                function updateEditEventStatusLabel() {

                    const checked = $('#editEventIsActive').is(':checked');

                    $('#editEventStatusText')
                        .text(checked ? 'Active' : 'Inactive')
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
                // =========================
                // IMAGE MANAGER
                // =========================

                let addFiles = [];
                let editFiles = [];

                let cropper = null;
                let currentCropIndex = null;
                let currentCropMode = null;
                let croppedExistingImages = [];

                function renderEmptyImageState(
                    containerId
                ) {

                    const container = $(
                        containerId
                    );

                    container.html(`
        <div class="col-12">
            <div class="empty-image-state">
               
                <div class="font-weight-bold text-muted mt-2">
                    No Images
                </div>

                <small class="text-muted">
                    No event images available
                </small>
            </div>
        </div>
    `);
                }

                // render preview
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

                        const reader =
                            new FileReader();

                        reader.onload = function(e) {

                            $(previewEl).append(`
                <div class="col-md-3 col-6 mb-3">

                    <div
                        class="card shadow-sm border-0 image-card"
                        data-index="${index}"
                        data-mode="${mode}"
                        style="cursor:pointer;"
                    >

                        <img
                            src="${e.target.result}"
                            class="img-fluid rounded"
                            style="
                                height:180px;
                                width:100%;
                                object-fit:cover;
                            "
                        >

                        <div class="card-body p-2">

                            <button
                                type="button"
                                class="btn btn-danger btn-sm btn-block removeImageBtn"
                                data-index="${index}"
                                data-mode="${mode}"
                            >
                                Remove
                            </button>

                        </div>

                    </div>

                </div>
            `);
                        };

                        reader.readAsDataURL(file);
                    });
                }

                function renderExistingEditImages() {

                    const preview =
                        $('#eventImagesPreviewEdit');

                    preview.html('');

                    // kosong semua
                    if (
                        existingEditImages.length === 0 &&
                        editFiles.length === 0
                    ) {

                        renderEmptyImageState(
                            '#eventImagesPreviewEdit'
                        );

                        return;
                    }

                    // =========================
                    // EXISTING IMAGE
                    // =========================
                    existingEditImages.forEach(
                        (img, index) => {

                            preview.append(`
                <div class="col-md-3 col-6 mb-3">

                    <div
                        class="card shadow-sm border-0 existing-image-card"
                        data-index="${index}"
                        style="cursor:pointer;"
                    >

                        <img
                            src="${img.image_url}"
                            class="img-fluid rounded"
                            style="
                                height:180px;
                                width:100%;
                                object-fit:cover;
                            "
                        >

                        <div class="card-body p-2">

                            <button
                                type="button"
                                class="btn btn-danger btn-sm btn-block removeExistingImageBtn"
                                data-index="${index}"
                            >
                                Remove
                            </button>

                        </div>

                    </div>

                </div>
            `);
                        }
                    );

                    // =========================
                    // NEW IMAGE
                    // =========================
                    renderImages(
                        editFiles,
                        '#eventImagesPreviewEdit',
                        'edit',
                        true
                    );
                }

                // append file (tidak replace)
                function appendFiles(
                    input,
                    targetArray,
                    previewSelector,
                    mode
                ) {

                    Array.from(input.files)
                        .forEach(file => {

                            if (
                                !file.type.startsWith(
                                    'image/'
                                )
                            ) return;

                            targetArray.push(file);
                        });

                    // =========================
                    // EDIT MODE
                    // =========================
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

                        // IMPORTANT:
                        // rerender gabungan existing + new
                        renderExistingEditImages();
                    }
                });

                // =========================
                // CLICK PREVIEW => CROP
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
                                checkOrientation: false,

                                ready() {

                                    cropper.resize();
                                }
                            }
                        );

                        // naikkan z-index
                        $('#cropImageModal')
                            .addClass('crop-modal-active');

                        $('.modal-backdrop')
                            .last()
                            .addClass('crop-backdrop-active');

                        // force fix overflow width
                        setTimeout(() => {

                            cropper.resize();
                            cropper.reset();

                        }, 100);
                    }
                );

                $(document).on(
                    'click',
                    '.cropModalCloseBtn',
                    function() {

                        $('#cropImageModal')
                            .modal('hide');
                    }
                );

                $('#cropImageModal').on(
                    'hidden.bs.modal',
                    function() {

                        if (cropper) {
                            cropper.destroy();
                            cropper = null;
                        }

                        $('#cropperImage')
                            .attr('src', '');

                        // reset z-index
                        $('#cropImageModal')
                            .removeClass('crop-modal-active');

                        $('.modal-backdrop')
                            .removeClass(
                                'crop-backdrop-active'
                            );
                    }
                );

                // save crop
                $('#saveCropBtn').on('click', function() {

                    if (!cropper) return;

                    cropper
                        .getCroppedCanvas()
                        .toBlob(blob => {

                            // =========================
                            // EXISTING IMAGE (DB)
                            // =========================
                            if (currentCropMode === 'existing-edit') {

                                cropper
                                    .getCroppedCanvas()
                                    .toBlob(blob => {

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

                                        // simpan untuk update
                                        croppedExistingImages.push({
                                            id: oldImage.id,
                                            file: croppedFile
                                        });

                                        // preview langsung berubah
                                        oldImage.image_url =
                                            URL.createObjectURL(
                                                croppedFile
                                            );

                                        renderExistingEditImages();

                                        $('#cropImageModal')
                                            .modal('hide');

                                    }, 'image/jpeg');

                                return;
                            }
                            // =========================
                            // NEW FILE (ADD/EDIT)
                            // =========================
                            let targetFiles =
                                currentCropMode ===
                                'edit' ?
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

                            // =========================
                            // RE-RENDER
                            // =========================
                            if (
                                currentCropMode ===
                                'edit'
                            ) {

                                // IMPORTANT:
                                // rerender existing + new image
                                renderExistingEditImages();

                            } else {

                                // add mode biasa
                                if (
                                    addFiles.length === 0
                                ) {

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
                            }

                            $('#cropImageModal')
                                .modal('hide');

                        }, 'image/jpeg');
                });
                $(document).on('click', '.closeEditModal, .cancelEditModal', function() {

                    $('#editEventModalAdminNew').modal('hide');

                    $('body').removeClass('modal-open');

                    $('.modal-backdrop').remove();

                    $('#editEventModalAdminNew')
                        .removeClass('show')
                        .css('display', 'none')
                        .attr('aria-hidden', 'true');
                });
                $(document).on('click', '.deleteEventButtonNew', function(e) {
                    e.preventDefault();
                    var id = $(this).attr('id');

                    Swal.fire({
                        customClass: {
                            confirmButton: "btn btn-success",
                            cancelButton: "btn btn-danger"
                        },
                        title: "Are you sure?",
                        text: "Delete this Event",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel!",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "/management/master/my-event/delete/" + id,
                                dataType: "json",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
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
                                        $('#dataTablePlaceEvent').DataTable().ajax
                                            .reload();
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

                // =========================
                // ADD EVENT SUBMIT AJAX
                // =========================

                $('#addEventFormAdmin').on('submit', function(e) {

                    e.preventDefault();

                    let form = $(this);
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
                        beforeSend: function() {

                            $('#addEventFormAdmin button[type="submit"]')
                                .prop('disabled', true)
                                .html(`
                    <span class="spinner-border spinner-border-sm mr-2"></span>
                    Saving...
                `);
                        },
                        success: function(response) {

                            // reset form
                            $('#addEventFormAdmin')[0].reset();
                            $('#eventImages').val('');
                            $('#eventImagesPreview').html('');

                            addFiles = [];

                            $('#eventImagesPreview').html('');
                            $('#eventImages').val('');

                            $('#eventDateRange').val('');
                            $('#eventStartDate').val('');
                            $('#eventEndDate').val('');

                            // close modal properly
                            $('#addEventModalAdminNew').modal('hide');

                            // cleanup bootstrap modal leftover
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();

                            $('#addEventModalAdminNew')
                                .removeClass('show')
                                .css('display', 'none')
                                .attr('aria-hidden', 'true');

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message ?? 'Event created successfully',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            // reload datatable
                            $('#dataTablePlaceEvent')
                                .DataTable()
                                .ajax
                                .reload(null, false);
                        },
                        error: function(xhr) {

                            let message = 'Something went wrong';

                            // validation error laravel
                            if (xhr.status === 422 && xhr.responseJSON?.errors) {

                                message = Object.values(xhr.responseJSON.errors)
                                    .flat()
                                    .join('<br>');

                            }
                            // custom backend message
                            else if (xhr.responseJSON?.message) {

                                message = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                html: message
                            });
                        },

                        complete: function() {

                            $('#addEventFormAdmin button[type="submit"]')
                                .prop('disabled', false)
                                .html(`
                    <i class="fas fa-save mr-2"></i>
                    Save Event
                `);
                        }
                    });
                });

                // =========================
                // EDIT EVENT SUBMIT AJAX
                // =========================

                $('#editEventFormAdmin').on('submit', function(e) {

                    e.preventDefault();

                    let form = $(this);
                    let formData = new FormData(this);

                    // existing image yg tetap dipakai
                    existingEditImages.forEach(img => {

                        formData.append(
                            'existing_images[]',
                            img.id
                        );
                    });

                    // crop existing image
                    croppedExistingImages.forEach(
                        item => {

                            formData.append(
                                `cropped_images[${item.id}]`,
                                item.file
                            );
                        }
                    );

                    // image baru
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

                        beforeSend: function() {

                            $('#editEventFormAdmin button[type="submit"]')
                                .prop('disabled', true)
                                .html(`
                    <span class="spinner-border spinner-border-sm mr-2"></span>
                    Updating...
                `);
                        },

                        success: function(response) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Updated',
                                text: response.message ?? 'Event updated successfully'
                            });

                            // CLOSE MODAL CLEAN
                            $('#editEventModalAdminNew').modal('hide');
                            $('#eventImagesEdit').val('');
                            $('#eventImagesPreviewEdit').html('');
                            editFiles = [];

                            $('#eventImagesPreviewEdit').html('');
                            $('#eventImagesEdit').val('');


                            $('#dataTablePlaceEvent')
                                .DataTable()
                                .ajax
                                .reload(null, false);
                        },

                        error: function(xhr) {

                            let message = 'Something went wrong';

                            // Laravel validation error
                            if (xhr.status === 422 && xhr.responseJSON?.errors) {

                                let errors = xhr.responseJSON.errors;

                                message = Object.values(errors)
                                    .flat()
                                    .join('<br>');

                            }
                            // Custom message
                            else if (xhr.responseJSON?.message) {

                                message = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                html: message
                            });
                        },

                        complete: function() {

                            $('#editEventFormAdmin button[type="submit"]')
                                .prop('disabled', false)
                                .html(`
                    <i class="fas fa-save mr-2"></i>
                    Update Event
                `);
                        }
                    });
                });

                // =========================
                // ADD EVENT DATERANGE
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

                $('#eventDateRange').on(
                    'cancel.daterangepicker',
                    function() {

                        $(this).val('');

                        $('#eventStartDate').val('');
                        $('#eventEndDate').val('');
                    }
                );

                $(document).on('click', '.editEventBtn', function() {

                    let id = $(this).attr('id');

                    $.ajax({
                        type: "GET",
                        url: "/management/master/my-event/get-data/" + id,

                        success: function(response) {

                            let data = response.data;

                            $('#eventIdEdit').val(data.id);
                            $('#titleEventEdit').val(data.title);
                            $('#descriptionEventEdit').val(data.description);
                            // set active
                            $('#editEventIsActive').prop(
                                'checked',
                                data.is_active == 1
                            );

                            updateEditEventStatusLabel();

                            existingEditImages =
                                data.images ?? [];

                            editFiles = [];

                            // reset preview
                            const preview =
                                $('#eventImagesPreviewEdit');

                            preview.empty();

                            // empty state
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

                            // hidden values
                            $('#dateEventEdit').val(data.date);
                            $('#endDateEventEdit').val(data.end_date);

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

                $(document).on(
                    'click',
                    '.removeExistingImageBtn',
                    function(e) {

                        e.stopPropagation();

                        const index =
                            $(this).data('index');

                        existingEditImages.splice(
                            index,
                            1
                        );

                        renderExistingEditImages();
                    }
                );

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
                $('form').on('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        return false;
                    }
                });

                // Prevent submit if no explicit submit button clicked

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
                // PLACE EVENT DATATABLE
                // =========================

                let placeId = "{{ $Place->id ?? '' }}";

                $('#dataTablePlaceEvent').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: false,
                    pageLength: 5, // set default 5 per page
                    lengthMenu: [
                        [5, 10, 25, 50, 100],
                        [5, 10, 25, 50, 100]
                    ],
                    order: [],
                    dom: '<"top"<"dataTables_length"l><"dataTables_filter"f>><"table-responsive-wrapper"rt><"bottom"<"dataTables_info"i><"dataTables_paginate"p>>',
                    ajax: {
                        url: "{{ route('event') }}",
                        data: function(d) {
                            d.place_id = placeId;
                        }
                    },

                    columns: [{
                            data: null,
                            name: 'title',
                            render: function(data) {

                                return `
                    <div class="event-info">
                        <div class="font-weight-bold text-dark mb-1">
                            ${data.title}
                        </div>

                        <div class="text-muted small event-description">
                            ${data.description ?? '-'}
                        </div>
                    </div>
                `;
                            }
                        },

                        {
                            data: 'date',
                            name: 'date'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        }
                    ]
                });

                $('form').on('reset', function() {

                    setTimeout(async () => {

                        // =========================
                        // TEXT INPUT / TEXTAREA
                        // =========================
                        $(this).find('input[type="text"], input[type="number"], textarea')
                            .val('');

                        // =========================
                        // SUMMERNOTE RESET
                        // =========================
                        $('#summernote').summernote('reset');
                        $('#summernote').summernote('code', '');

                        // =========================
                        // SELECT2 RESET
                        // =========================
                        $('#provinceDataSelect').val(null).trigger('change');
                        $('#regencyDataSelect').empty()
                            .append('<option value="">Select Regency</option>')
                            .trigger('change');

                        $('#districtDataSelect').empty()
                            .append('<option value="">Select District</option>')
                            .trigger('change');

                        $('#villagesDataSelect').empty()
                            .append('<option value="">Select Village</option>')
                            .trigger('change');

                        // =========================
                        // CHECKBOX RESET
                        // =========================
                        $('input[name="AllowComment"]').prop('checked', true);

                        // =========================
                        // RELOAD PROVINCE
                        // =========================
                        let initialData = await fetchLocation();

                        fillSelect(
                            '#provinceDataSelect',
                            initialData.province,
                            'Select Province'
                        );

                        initSelect2(
                            '#provinceDataSelect',
                            'Select Province'
                        );

                    }, 10);
                });

                // =========================
                // SUMMERNOTE
                // =========================
                $('#summernote').summernote({

                    placeholder: 'Write detailed information about this place...',
                    height: 500,

                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'italic', 'clear']],
                        ['fontname', ['fontname']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['table', ['table']],
                        ['custom', ['pdfButton']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ],

                    popover: {
                        image: [
                            ['resize', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                            ['float', ['floatLeft', 'floatRight', 'floatNone']],
                            ['remove', ['removeMedia']]
                        ]
                    },

                    callbacks: {

                        onInit: function() {

                            $('.note-editable').css({
                                'text-align': 'left',
                                'min-height': '320px'
                            });

                            $('.note-editor').addClass('shadow-sm');
                        }
                    },

                    buttons: {

                        pdfButton: function(context) {

                            let ui = $.summernote.ui;

                            let button = ui.button({

                                contents: `
                    <i class="fas fa-file-pdf text-danger"></i>
                    <span class="ml-1 font-weight-bold">PDF</span>
                `,

                                tooltip: 'Insert PDF',

                                click: function() {

                                    let input = $(
                                        '<input type="file" accept="application/pdf">');

                                    input.on('change', function(e) {

                                        let file = e.target.files[0];

                                        if (file && file.type ===
                                            'application/pdf') {

                                            let formData = new FormData();

                                            formData.append('pdf', file);

                                            Swal.fire({
                                                title: 'Uploading...',
                                                text: 'Please wait...',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                didOpen: () => {
                                                    Swal.showLoading();
                                                }
                                            });

                                            $.ajax({

                                                url: "{{ route('file.upload') }}",

                                                type: 'POST',

                                                headers: {
                                                    'X-CSRF-TOKEN': $(
                                                        'meta[name="csrf-token"]'
                                                    ).attr('content')
                                                },

                                                data: formData,

                                                contentType: false,
                                                processData: false,

                                                success: function(
                                                    response) {

                                                    if (response.url) {

                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Upload Complete',
                                                            text: 'PDF uploaded successfully.'
                                                        });

                                                        let iframe =
                                                            document
                                                            .createElement(
                                                                'iframe'
                                                            );

                                                        iframe.src =
                                                            response
                                                            .url;
                                                        iframe.width =
                                                            '100%';
                                                        iframe.height =
                                                            '500px';

                                                        iframe.style
                                                            .border =
                                                            'none';
                                                        iframe.style
                                                            .borderRadius =
                                                            '12px';

                                                        $('#summernote')
                                                            .summernote(
                                                                'editor.insertNode',
                                                                iframe
                                                            );

                                                    } else {

                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Upload Failed',
                                                            text: response
                                                                .error ||
                                                                'Unknown error'
                                                        });
                                                    }
                                                },

                                                error: function() {

                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Upload Failed',
                                                        text: 'Server error.'
                                                    });
                                                }
                                            });

                                        } else {

                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Invalid File',
                                                text: 'Please upload a valid PDF.'
                                            });
                                        }
                                    });

                                    input.trigger('click');
                                }
                            });

                            return button.render();
                        }
                    }
                });

                let isInitedProvince = false;
                let isAutoSelecting = true;

                async function fetchLocation(
                    province_id = null,
                    regency_id = null,
                    district_id = null
                ) {

                    return $.ajax({
                        url: "{{ route('getLocation') }}",
                        method: 'GET',
                        data: {
                            province_id: province_id,
                            regency_id: regency_id,
                            district_id: district_id
                        }
                    });
                }

                function initSelect2(el, placeholder) {

                    if ($(el).hasClass("select2-hidden-accessible")) {
                        $(el).select2('destroy');
                    }

                    $(el).select2({
                        placeholder: placeholder,
                        allowClear: true,
                        width: '100%'
                    });
                }

                function fillSelect(el, data, placeholder) {

                    $(el).empty();

                    $(el).append(
                        `<option value="">${placeholder}</option>`
                    );

                    data.forEach(function(item) {

                        $(el).append(
                            $('<option>', {
                                value: item.id,
                                text: item.name
                            })
                        );
                    });
                }

                // =========================
                // INITIAL LOAD
                // =========================

                let initialData = await fetchLocation();

                // province
                fillSelect(
                    '#provinceDataSelect',
                    initialData.province,
                    'Select Province'
                );

                initSelect2(
                    '#provinceDataSelect',
                    'Select Province'
                );

                // auto province
                if (selectedProvince) {

                    $('#provinceDataSelect')
                        .val(selectedProvince)
                        .trigger('change.select2');

                    // load regency
                    let regencyData = await fetchLocation(
                        selectedProvince
                    );

                    fillSelect(
                        '#regencyDataSelect',
                        regencyData.regency,
                        'Select Regency'
                    );

                    initSelect2(
                        '#regencyDataSelect',
                        'Select Regency'
                    );

                    if (selectedRegency) {

                        $('#regencyDataSelect')
                            .val(selectedRegency)
                            .trigger('change.select2');

                        // load district
                        let districtData = await fetchLocation(
                            selectedProvince,
                            selectedRegency
                        );

                        fillSelect(
                            '#districtDataSelect',
                            districtData.districts,
                            'Select District'
                        );

                        initSelect2(
                            '#districtDataSelect',
                            'Select District'
                        );

                        if (selectedDistrict) {

                            $('#districtDataSelect')
                                .val(selectedDistrict)
                                .trigger('change.select2');

                            // load village
                            let villageData = await fetchLocation(
                                selectedProvince,
                                selectedRegency,
                                selectedDistrict
                            );

                            fillSelect(
                                '#villagesDataSelect',
                                villageData.villages,
                                'Select Village'
                            );

                            initSelect2(
                                '#villagesDataSelect',
                                'Select Village'
                            );

                            if (selectedVillage) {

                                $('#villagesDataSelect')
                                    .val(selectedVillage)
                                    .trigger('change.select2');
                            }
                        }
                    }
                }

                isAutoSelecting = false;

                // =========================
                // PROVINCE CHANGE
                // =========================

                $('#provinceDataSelect').on('change', async function() {

                    if (isAutoSelecting) return;

                    let provinceId = $(this).val();

                    fillSelect('#regencyDataSelect', [], 'Select Regency');
                    fillSelect('#districtDataSelect', [], 'Select District');
                    fillSelect('#villagesDataSelect', [], 'Select Village');

                    if (!provinceId) return;

                    let data = await fetchLocation(provinceId);

                    fillSelect(
                        '#regencyDataSelect',
                        data.regency,
                        'Select Regency'
                    );

                    initSelect2(
                        '#regencyDataSelect',
                        'Select Regency'
                    );
                });

                // =========================
                // REGENCY CHANGE
                // =========================

                $('#regencyDataSelect').on('change', async function() {

                    if (isAutoSelecting) return;

                    let provinceId = $('#provinceDataSelect').val();
                    let regencyId = $(this).val();

                    fillSelect('#districtDataSelect', [], 'Select District');
                    fillSelect('#villagesDataSelect', [], 'Select Village');

                    if (!regencyId) return;

                    let data = await fetchLocation(
                        provinceId,
                        regencyId
                    );

                    fillSelect(
                        '#districtDataSelect',
                        data.districts,
                        'Select District'
                    );

                    initSelect2(
                        '#districtDataSelect',
                        'Select District'
                    );
                });

                // =========================
                // DISTRICT CHANGE
                // =========================

                $('#districtDataSelect').on('change', async function() {

                    if (isAutoSelecting) return;

                    let provinceId = $('#provinceDataSelect').val();
                    let regencyId = $('#regencyDataSelect').val();
                    let districtId = $(this).val();

                    fillSelect('#villagesDataSelect', [], 'Select Village');

                    if (!districtId) return;

                    let data = await fetchLocation(
                        provinceId,
                        regencyId,
                        districtId
                    );

                    fillSelect(
                        '#villagesDataSelect',
                        data.villages,
                        'Select Village'
                    );

                    initSelect2(
                        '#villagesDataSelect',
                        'Select Village'
                    );
                });

                function setReadonlyMode() {
                    console.log('Setting readonly mode...');
                    // Disable select2
                    $('#provinceDataSelect').prop('disabled', true).trigger('change.select2');
                    $('#regencyDataSelect').prop('disabled', true).trigger('change.select2');
                    $('#districtDataSelect').prop('disabled', true).trigger('change.select2');
                    $('#villagesDataSelect').prop('disabled', true).trigger('change.select2');

                    // Disable summernote
                    $('#summernote').summernote('disable');

                    // Disable checkbox
                    $('input[name="AllowComment"]').prop('disabled', true);
                }

                // run after all initialized
                setTimeout(() => {
                    setReadonlyMode();
                }, 300);
            });
        </script>
    @endpush
@endsection
