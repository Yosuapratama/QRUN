@extends('TemplateLayout.AdminLayout')

@section('content')
    @push('title')
        <title>Form Advertise - QRUN Website</title>

        {{-- TOASTR CSS --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        {{-- JQUERY --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        {{-- TOASTR JS --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <style>
            .toast-success {
                background-color: #28a745 !important;
            }

            .toast-error {
                background-color: #dc3545 !important;
            }

            .toast-info {
                background-color: #17a2b8 !important;
            }

            .toast-warning {
                background-color: #ffc107 !important;
                color: #000 !important;
            }

            .toast {
                opacity: 1 !important;
            }
        </style>

        <script>
            toastr.options = {
                closeButton: true,
                progressBar: true,
                newestOnTop: true,
                positionClass: "toast-top-right",

                timeOut: 8000,
                extendedTimeOut: 8000,

                showDuration: 300,
                hideDuration: 300,

                preventDuplicates: true,
            };
        </script>
    @endpush

    <div class="container-fluid">



        {{-- PAGE HEADER --}}
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">

            <div>
                <h2 class="font-weight-bold text-dark mb-1">
                    {{ __('messages.management.advertise.form_title') }}
                </h2>

                <p class="text-muted mb-0">
                    {{ __('messages.management.advertise.form_subtitle') }}
                </p>
            </div>

            <a href="{{ route('advertise.index') }}" class="modern-back-btn">

                <i class="fas fa-arrow-left mr-2"></i>

                {{ __('messages.management.advertise.back_btn') }}

            </a>

        </div>

        {{-- VALIDATION ERRORS --}}
        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    @foreach ($errors->all() as $error)
                        toastr.error(@json($error), 'Error');
                    @endforeach

                });
            </script>
        @endif

        {{-- STATUS SUCCESS --}}
        @if (session()->has('status'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    toastr.success(@json(session('status')), 'Success');

                });
            </script>
        @endif

        {{-- SUCCESS --}}
        @if (session()->has('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    toastr.success(@json(session('success')), 'Success');

                });
            </script>
        @endif

        {{-- FORM --}}
        <form action="{{ route('advertise.storeOrUpdate') }}" method="POST" id="advertiseForm">

            @csrf

            <input type="hidden" name="id" value="{{ $adsSettings->id ?? '' }}">

            <div class="row">

                {{-- LEFT --}}
                <div class="col-lg-8">

                    {{-- INFORMATION --}}
                    <div class="card border-0 shadow-sm rounded-xl mb-4">

                        <div class="card-header bg-white border-0 pt-4 pb-0">

                            <h4 class="font-weight-bold text-dark mb-1">
                                {{ __('messages.management.advertise.info_section_title') }}
                            </h4>

                            <p class="text-muted small mb-0">
                                {{ __('messages.management.advertise.info_section_subtitle') }}
                            </p>

                        </div>

                        <div class="card-body pt-4">

                            {{-- TITLE --}}
                            <div class="form-group mb-4">

                                <label class="form-label font-weight-semibold">
                                    {{ __('messages.management.advertise.field_title_ads') }} <span class="text-danger">*</span>
                                </label>

                                <input required type="text" class="form-control custom-input" name="title"
                                    value="{{ $adsSettings->title ?? (old('title') ?? '') }}"
                                    placeholder="Example: Summer Promo Banner">

                            </div>

                            {{-- TIME --}}
                            <div class="form-group mb-4">

                                <label class="form-label font-weight-semibold">
                                    {{ __('messages.management.advertise.field_time') }} <span class="text-danger">*</span>
                                </label>

                                <input required type="number" class="form-control custom-input" name="time"
                                    value="{{ $adsSettings->time ?? (old('time') ?? '') }}" placeholder="Example: 10">

                            </div>

                            {{-- PLACE --}}
                            <div class="form-group">

                                <label class="form-label font-weight-semibold">
                                    {{ __('messages.management.advertise.field_place') }} <span class="text-danger">*</span>
                                </label>

                                @php
                                    $selectedPlaces = old(
                                        'places',
                                        $adsSettings ? $adsSettings->places->pluck('id')->toArray() : [],
                                    );
                                @endphp
                                <select required class="form-control" id="place_id" name="places[]" multiple>
                                    @foreach ($placeId as $place)
                                        <option value="{{ $place->id }}"
                                            {{ in_array($place->id, $selectedPlaces) ? 'selected' : '' }}>
                                            {{ $place->place_code }} — {{ $place->title }}
                                        </option>
                                    @endforeach
                                </select>

                                <small class="text-muted">
                                    {{ __('messages.management.advertise.multi_hint') }}
                                </small>

                            </div>

                        </div>

                    </div>

                    {{-- IMAGE --}}
                    <div class="card border-0 shadow-sm rounded-xl mb-4">

                        <div class="card-header bg-white border-0 pt-4 pb-0">

                            <h4 class="font-weight-bold text-dark mb-1">
                                {{ __('messages.management.advertise.gallery_section_title') }} <span class="text-danger">*</span>
                            </h4>

                            <p class="text-muted small mb-0">
                                {{ __('messages.management.advertise.gallery_section_subtitle') }}
                            </p>

                        </div>

                        <div class="card-body">

                            {{-- DROPZONE --}}
                            <div id="imageDropzone" class="modern-dropzone">

                                <div class="dropzone-content">

                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>

                                    <h5 class="font-weight-bold mb-2">
                                        {{ __('messages.management.advertise.upload_title') }}
                                    </h5>

                                    <p class="text-muted mb-1">
                                        {{ __('messages.management.advertise.drag_drop') }}
                                    </p>

                                    <small class="text-muted">
                                        {{ __('messages.management.advertise.file_hint') }}
                                    </small>

                                </div>

                            </div>

                            {{-- PREVIEW --}}
                            <div class="row mt-4" id="imagePreviewWrapper"></div>

                        </div>

                    </div>

                </div>

                {{-- RIGHT --}}
                <div class="col-lg-4">

                    <div class="card border-0 shadow-sm rounded-xl sticky-top" style="top:20px;">

                        <div class="card-header bg-white border-0 pt-4">

                            <h5 class="font-weight-bold mb-0">
                                {{ __('messages.management.advertise.publish_section') }}
                            </h5>

                        </div>

                        <div class="card-body">

                            {{-- ACTIVE --}}
                            <div class="setting-box mb-3">

                                <div>

                                    <h6 class="mb-1 font-weight-bold">
                                        {{ __('messages.management.advertise.active_ads') }}
                                    </h6>

                                    <small class="text-muted">
                                        {{ __('messages.management.advertise.active_ads_desc') }}
                                    </small>

                                </div>

                                <label class="modern-switch">

                                    <input type="checkbox" name="is_active" value="1"
                                        @if ($adsSettings?->is_active) checked @endif>

                                    <span class="modern-slider"></span>

                                </label>

                            </div>

                            {{-- BLOCK --}}
                            <div class="setting-box">

                                <div>

                                    <h6 class="mb-1 font-weight-bold">
                                        {{ __('messages.management.advertise.blocking_ads') }}
                                    </h6>

                                    <small class="text-muted">
                                        {{ __('messages.management.advertise.blocking_ads_desc') }}
                                    </small>

                                </div>

                                <label class="modern-switch">

                                    <input type="checkbox" name="is_block" value="1"
                                        @if ($adsSettings?->is_block) checked @endif>

                                    <span class="modern-slider"></span>

                                </label>

                            </div>

                        </div>

                        <div class="card-footer bg-white border-0 pb-4">

                            <button class="btn btn-primary btn-block py-3 font-weight-bold rounded-lg">

                                <i class="fas fa-save mr-2"></i>

                                {{ __('messages.management.advertise.save_btn') }}

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

    @push('css')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" rel="stylesheet">

        <style>
            body {
                background: #F9FAFB;
            }

            .rounded-xl {
                border-radius: 20px;
            }

            .modern-back-btn {
                display: inline-flex;
                align-items: center;
                padding: 12px 18px;
                border-radius: 14px;
                background: #fff;
                border: 1px solid #E5E7EB;
                color: #111827;
                font-weight: 600;
                transition: .25s;
                text-decoration: none !important;
                box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
            }

            .modern-back-btn:hover {
                background: #4F46E5;
                color: white;
                border-color: #4F46E5;
                transform: translateY(-1px);
            }

            .custom-input {
                height: 55px;
                border-radius: 14px;
                border: 1px solid #E5E7EB;
                padding: 0 18px;
                font-size: 15px;
                transition: .2s;
            }

            .custom-input:focus {
                border-color: #4F46E5;
                box-shadow: none;
            }

            .modern-dropzone {
                border: 2px dashed #D1D5DB;
                border-radius: 20px;
                min-height: 260px;
                background: #FAFAFA;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: .25s;
                cursor: pointer;
                position: relative;
            }

            .modern-dropzone:hover {
                border-color: #4F46E5;
                background: #F5F3FF;
            }

            .dropzone-content {
                text-align: center;
                pointer-events: none;
            }

            .upload-icon {
                font-size: 48px;
                color: #6366F1;
                margin-bottom: 15px;
            }

            .setting-box {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 18px;
                border: 1px solid #ECECEC;
                border-radius: 16px;
            }

            .image-card {
                position: relative;
                margin-bottom: 20px;
            }

            .image-card img {
                width: 100%;
                height: 200px;
                object-fit: cover;
                border-radius: 16px;
                border: 1px solid #ECECEC;
            }

            .remove-image {
                position: absolute;
                top: 10px;
                right: 10px;
                width: 36px;
                height: 36px;
                border: none;
                border-radius: 50%;
                background: #EF4444;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.18);
            }

            .remove-image:hover {
                transform: scale(1.05);
            }

            .modern-switch {
                position: relative;
                display: inline-block;
                width: 58px;
                height: 32px;
            }

            .modern-switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }

            .modern-slider {
                position: absolute;
                cursor: pointer;
                inset: 0;
                background: #D1D5DB;
                transition: .4s;
                border-radius: 999px;
            }

            .modern-slider:before {
                position: absolute;
                content: "";
                height: 24px;
                width: 24px;
                left: 4px;
                top: 4px;
                background: white;
                transition: .4s;
                border-radius: 50%;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
            }

            .modern-switch input:checked+.modern-slider {
                background: #4F46E5;
            }

            .modern-switch input:checked+.modern-slider:before {
                transform: translateX(26px);
            }

            .select2-container .select2-selection--multiple {
                min-height: 55px !important;
                border-radius: 14px !important;
                border: 1px solid #E5E7EB !important;
                padding: 6px !important;
            }

            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background: #EEF2FF !important;
                border: none !important;
                color: #4338CA !important;
                border-radius: 10px !important;
                padding: 4px 10px !important;
            }
        </style>
    @endpush

    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>

        <script>
            $(document).ready(function() {

                $('#place_id').select2({
                    placeholder: @json(__('messages.management.advertise.select_places'))
                });

            });
        </script>

        <script>
            Dropzone.autoDiscover = false;

            let uploadedImages = [];

            /*
            |--------------------------------------------------------------------------
            | PRELOAD EXISTING IMAGES
            |--------------------------------------------------------------------------
            */

            @if ($adsSettings && $adsSettings->images->count())

                uploadedImages = [

                    @foreach ($adsSettings->images as $image)

                        "{{ $image->image_url }}",
                    @endforeach

                ];
            @endif

            renderPreview();

            /*
            |--------------------------------------------------------------------------
            | DROPZONE
            |--------------------------------------------------------------------------
            */

            let myDropzone = new Dropzone("#imageDropzone", {

                url: "{{ route('upload.place.ads') }}",

                paramName: "file",

                clickable: '#imageDropzone',

                acceptedFiles: ".jpg,.jpeg,.png",

                uploadMultiple: false,

                parallelUploads: 10,

                previewsContainer: false,

                maxFilesize: 5,

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                init: function() {

                    // prevent multiple chooser glitch
                    this.hiddenFileInput.removeAttribute('multiple');

                },

                sending: function() {

                    Swal.fire({
                        title: 'Uploading...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                },

                success: function(file, response) {

                    uploadedImages.push(response.image_url);

                    renderPreview();

                    Swal.close();

                },

                error: function() {

                    Swal.fire({
                        icon: 'error',
                        title: @json(__('messages.management.gallery_form.swal_upload_failed')),
                        text: 'Image upload failed'
                    });

                }

            });

            /*
            |--------------------------------------------------------------------------
            | PREVIEW
            |--------------------------------------------------------------------------
            */

            function renderPreview() {

                let html = '';

                uploadedImages.forEach((img, index) => {

                    html += `
                        <div class="col-md-4">

                            <div class="image-card">

                                <img src="/${img}">

                                <button type="button"
                                    class="remove-image"
                                    onclick="removeImage(${index})">

                                    <i class="fas fa-times"></i>

                                </button>

                                <input type="hidden"
                                    name="images[]"
                                    value="${img}">

                            </div>

                        </div>
                    `;

                });

                $('#imagePreviewWrapper').html(html);

            }

            /*
            |--------------------------------------------------------------------------
            | REMOVE IMAGE
            |--------------------------------------------------------------------------
            */

            function removeImage(index) {

                uploadedImages.splice(index, 1);

                renderPreview();

            }
        </script>
    @endpush
@endsection
