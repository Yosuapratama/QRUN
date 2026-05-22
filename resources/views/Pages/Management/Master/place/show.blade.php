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

        <form action="{{ $isEdit ? route('place.update') : route('place.store') }}" method="POST">
            @csrf
            @if ($isEdit)
                <input type="hidden" name="id" value="{{ $Place->id }}">
            @endif

            <div class="card form-card shadow-lg border-0">
                <div class="card-header bg-white py-4 border-bottom border-light">
                    <h5 class="m-0 font-weight-bold text-dark d-flex align-items-center">
                        <span class="badge badge-primary-light badge-icon mr-3">1</span>
                        <div>
                            <div>Basic Information</div>
                            <small class="section-description">Enter the name and description of the place</small>
                        </div>
                    </h5>
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
                            <a type="button" href="{{route('place')}}"
                                class="btn btn-secondary btn-md back-btn">
                                <i class="fas fa-arrow-left mr-2"></i>Back
                            </a>
                            {{-- <button type="submit" class="btn btn-primary submit-btn shadow-sm">
                                <i class="fas fa-save mr-2"></i>{{ $isEdit ? 'Update Place' : 'Create Place' }}
                            </button> --}}
                        </div>
                    </div>
                </div>
            </div>

        </form>

    </div>

    @push('css')
        @include('Pages.Management.Master.place.components.style')
        <style>
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
        </style>
    @endpush

    @push('script')
        <script>
            let selectedProvince = "{{ old('reg_province', $Place->province_id ?? ($Place->reg_province ?? '')) }}";
            let selectedRegency = "{{ old('reg_regency', $Place->regency_id ?? ($Place->reg_regency ?? '')) }}";
            let selectedDistrict = "{{ old('reg_district', $Place->district_id ?? ($Place->reg_district ?? '')) }}";
            let selectedVillage = "{{ old('reg_village', $Place->village_id ?? ($Place->reg_village ?? '')) }}";

            $(document).ready(async function() {

                $(document).on('click', '.note-modal .close', function() {
                    $(this).closest('.note-modal').modal('hide');
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

                    // Disable buttons
                    // $('.submit-btn').hide();
                    // $('.reset-btn').hide();

                    // Disable all inputs + textarea
                    $('input, textarea').prop('readonly', true);

                }

                // run after all initialized
                setTimeout(() => {
                    setReadonlyMode();
                }, 300);
            });
        </script>
    @endpush
@endsection
