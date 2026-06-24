@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Settings General - QRUN Website</title>

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

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 text-gray-800 font-weight-bold m-2">{{ __('messages.management.settings.title') }}</h1>
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
        <!-- DataTales Example -->


        <form action="{{ route('settings.store') }}" method="POST" class="card" id="formDropzone"
            enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('messages.management.settings.running_text_section') }}</h6>
                </div>
                <div class="card-body">
                    <div class="setting-item">

                        <div>
                            <h6 class="mb-1">{{ __('messages.management.settings.running_text_label') }}</h6>
                            <small class="text-muted">
                                {{ __('messages.management.settings.running_text_desc') }}
                            </small>
                        </div>

                        <label class="switch">
                            <input type="checkbox" name="is_active_running_text"
                                {{ $runningText->is_active ? 'checked' : '' }}>
                            <span class="slider-switch"></span>
                        </label>

                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.management.settings.running_text_title') }}<span class="text-danger">*</span></label>
                        <input required type="text" name="title_running_text" value="{{ $runningText->title ?? '' }}"
                            class="form-control" placeholder="Enter Running Text...">
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ __('messages.management.settings.disabled_after') }} <small>({{ __('messages.management.settings.disabled_after_hint') }})</small><span
                                class="text-danger">*</span></label>
                        <input min="0" value="{{ $runningText->disabled_after ?? 11 }}" required type="number"
                            value="" placeholder="Enter in Second..." name="disabled_after" class="form-control">
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('messages.management.settings.ads_section') }}</h6>
                </div>
                <div class="card-body">
                    <div class="setting-item">

                        <div>
                            <h6 class="mb-1">{{ __('messages.management.settings.ads_active') }}</h6>
                            <small class="text-muted">
                                {{ __('messages.management.settings.ads_active_desc') }}
                            </small>
                        </div>

                        <label class="switch">
                            <input type="checkbox" name="ads_active" {{ $adsSettings->is_active ? 'checked' : '' }}>
                            <span class="slider-switch"></span>
                        </label>

                    </div>
                    <div class="setting-item">

                        <div>
                            <h6 class="mb-1">{{ __('messages.management.settings.merge_advertise') }}</h6>
                            <small class="text-muted">
                                {{ __('messages.management.settings.merge_advertise_desc') }}
                            </small>
                        </div>

                        <label class="switch">
                            <input type="checkbox" name="merge_with_advertise_users"
                                {{ $adsSettings->merge_with_advertise_users ? 'checked' : '' }}>
                            <span class="slider-switch"></span>
                        </label>

                    </div>
                    <div class="setting-item">

                        <div>
                            <h6 class="mb-1">{{ __('messages.management.settings.blocking_ads') }}</h6>
                            <small class="text-muted">
                                {{ __('messages.management.settings.blocking_ads_desc') }}
                            </small>
                        </div>

                        <label class="switch">
                            <input type="checkbox" name="is_blocking" {{ $adsSettings->is_blocking ? 'checked' : '' }}>
                            <span class="slider-switch"></span>
                        </label>

                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.management.settings.ads_title') }}<span class="text-danger">*</span></label>
                        <input required type="text" name="title_ads" value="{{ $adsSettings->title ?? '' }}"
                            class="form-control" placeholder="Enter Title...">
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">{{ __('messages.management.settings.ads_images_section') }}</h6>
                        </div>

                        <div class="card-body">

                            <!-- ========== UPLOAD SECTION ========== -->
                            <div class="mb-4">
                                <label class="form-label fw-bold text-muted">{{ __('messages.management.settings.upload_images') }}</label>

                                <div class="dropzone-drag-area d-flex align-items-center justify-content-center flex-column text-center"
                                    id="uploadZone"
                                    style="min-height: 220px; border:2px dashed #d1d5db; border-radius:16px; background:#f9fafb; cursor:pointer; transition:.3s;">

                                    <div class="flex-column dz-message text-muted m-0">

                                        <div class="mb-3">
                                            <i class="fas fa-cloud-upload-alt" style="font-size:48px; color:#6b7280;"></i>
                                        </div>

                                        <h5 class="font-weight-bold mb-2 text-dark">
                                            {{ __('messages.management.settings.upload_images') }}
                                        </h5>

                                        <p class="mb-1 text-muted">
                                            {{ __('messages.management.settings.drag_drop') }}
                                        </p>

                                        <small class="text-secondary">
                                            {{ __('messages.management.settings.click_browse') }}
                                        </small>

                                    </div>
                                </div>
                            </div>

                            <!-- ========== PREVIEW SECTION ========== -->
                            <div class="mb-2">
                                <label class="form-label fw-bold text-muted">{{ __('messages.management.settings.existing_images') }}</label>

                                <div id="imagePreviewGrid" class="image-grid"></div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.management.settings.ads_time') }}<span class="text-danger">*</span></label>
                        <input required type="number" name="time_ads" value="{{ $adsSettings->time ?? '' }}"
                            class="form-control" placeholder="Enter Time...">
                    </div>
                    <!-- Dropzone Form -->
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning" id="submitBtn">
                        <span class="submit-text">{{ __('messages.management.settings.save_data') }}</span>

                        <span class="submit-loading d-none">
                            <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
                            {{ __('messages.management.settings.saving') }}
                        </span>
                    </button>
                </div>
            </div>
            <div id="hiddenInputsContainer"></div>
        </form>

        <div class="card shadow mb-3 mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('messages.management.settings.title') }}</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-primary">
                    <p>This feature func is to clear cache in this server, if the website lag/not found routing, admin can
                        do this function</p>
                    <a href="{{ route('artisan.optimize') }}" class="btn btn-primary">Clear Server Cache (Optimize)</a>
                    <a href="{{ route('artisan.queue') }}" class="btn btn-primary">Restart QUEUE</a>
                </div>
            </div>
        </div>
    </div>
    @push('css')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" rel="stylesheet">
        <style>
            .image-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                gap: 12px;
            }

            /* card */
            .image-card {
                position: relative;
                width: 100%;
                padding-top: 100%;
                border-radius: 14px;
                overflow: hidden;
                background: #f3f4f6;
            }

            /* image */
            .image-card img {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: .25s;
            }

            .image-card:hover img {
                transform: scale(1.05);
            }

            /* delete button */
            .image-delete {
                position: absolute;
                top: 8px;
                right: 8px;
                width: 28px;
                height: 28px;
                border-radius: 50%;
                background: rgba(0, 0, 0, 0.6);
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                opacity: 0;
                transition: .2s;
            }

            .image-card:hover .image-delete {
                opacity: 1;
            }

            .switch {
                position: relative;
                display: inline-block;
                width: 58px;
                height: 30px;
            }

            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }

            .slider-switch {
                position: absolute;
                cursor: pointer;
                inset: 0;
                background: #d1d5db;
                transition: .3s;
                border-radius: 999px;
            }

            .slider-switch:before {
                position: absolute;
                content: "";
                height: 24px;
                width: 24px;
                left: 3px;
                bottom: 3px;
                background: white;
                transition: .3s;
                border-radius: 50%;
                box-shadow: 0 2px 6px rgba(0, 0, 0, .2);
            }

            .switch input:checked+.slider-switch {
                background: #4f46e5;
            }

            .switch input:checked+.slider-switch:before {
                transform: translateX(28px);
            }

            .h1 {
                letter-spacing: -0.02em;
            }

            .dropzone {
                overflow-y: auto;
                border: 0;
                background: transparent;
            }

            .dz-preview {
                width: 100%;
                margin: 0 !important;
                height: 100%;
                padding: 15px;
                position: absolute !important;
                top: 0;
            }

            .dz-photo {
                height: 100%;
                width: 100%;
                overflow: hidden;
                border-radius: 12px;
                background: #eae7e2;
            }

            .dz-drag-hover .dropzone-drag-area {
                border-style: solid;
                border-color: #86b7fe;
                ;
            }

            .dz-thumbnail {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .dz-image {
                width: 90px !important;
                height: 90px !important;
                border-radius: 6px !important;
            }

            .dz-remove {
                display: none !important;
            }

            .dz-delete {
                width: 24px;
                height: 24px;
                background: rgba(0, 0, 0, 0.57);
                position: absolute;
                opacity: 0;
                transition: all 0.2s ease;
                top: 30px;
                right: 30px;
                border-radius: 100px;
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .dz-delete>svg {
                transform: scale(0.75);
                cursor: pointer;
            }

            .dz-preview:hover .dz-delete,
            .dz-preview:hover .dz-remove-image {
                opacity: 1;
            }

            .dz-message {
                height: 100%;
                margin: 0 !important;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .dropzone-drag-area {
                height: 300px;
                position: relative;
                padding: 0 !important;
                border-radius: 10px;
                border: 3px dashed #dbdeea;
            }

            .was-validated .form-control:valid {
                border-color: #dee2e6 !important;
                background-image: none;
            }

            .card {
                border: 0;
                border-radius: 18px;
                overflow: hidden;
            }

            .card-header {
                background: white;
                border-bottom: 1px solid #edf2f7;
            }

            .setting-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 18px 0;
                border-bottom: 1px solid #f1f5f9;
            }

            .setting-item:last-child {
                border-bottom: 0;
            }

            .form-control {
                border-radius: 12px;
                min-height: 48px;
            }

            .btn-warning {
                border-radius: 12px;
                padding: 12px 24px;
                font-weight: 600;
            }

            #previews {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
            }

            #previews {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 12px;
            }

            /* card image */
            .dz-preview {
                position: relative !important;
                width: 100% !important;
                padding-top: 100%;
                /* square */
                margin: 0 !important;
                border-radius: 14px;
                overflow: hidden;
                background: #f3f4f6;
            }

            /* image inside */
            .dz-photo {
                position: absolute;
                inset: 0;
            }

            .dz-thumbnail {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: .25s ease;
            }

            /* hover zoom */
            .dz-preview:hover .dz-thumbnail {
                transform: scale(1.05);
            }

            /* delete button */
            .dz-delete {
                position: absolute;
                top: 8px;
                right: 8px;
                width: 30px;
                height: 30px;
                border-radius: 50%;
                background: rgba(0, 0, 0, 0.6);
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                z-index: 10;
                opacity: 0;
                transition: .2s;
            }

            .dz-preview:hover .dz-delete {
                opacity: 1;
            }

            /* drag zone */
            .dropzone-drag-area {
                border: 2px dashed #d1d5db;
                border-radius: 14px;
                padding: 16px;
                background: #fafafa;
            }
        </style>
    @endpush

    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
        <script>
            Dropzone.autoDiscover = false;

            Dropzone.autoDiscover = false;

            let uploadZone = new Dropzone("#uploadZone", {
                url: "{{ route('upload.ads.bulk') }}",
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 10,
                maxFiles: 10,
                acceptedFiles: ".jpg,.jpeg,.png,.gif",
                previewsContainer: false,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },

                init: function() {
                    let dz = this;

                    dz.on("addedfile", function(file) {
                        renderNewImage(file);
                    });

                    dz.on("successmultiple", function(files, response) {

                        console.log("bulk upload finished");

                        HTMLFormElement.prototype.submit.call(
                            document.getElementById("formDropzone")
                        );
                    });

                    dz.on("errormultiple", function(files, response) {

                        const submitBtn = $("#submitBtn");

                        submitBtn.prop("disabled", false);

                        submitBtn.find(".submit-loading")
                            .addClass("d-none");

                        submitBtn.find(".submit-text")
                            .removeClass("d-none");

                        toastr.error("Failed upload image");
                    });
                }
            });

            uploadZone.on("successmultiple", function(files, response) {

                // kalau upload selesai → submit form utama
                HTMLFormElement.prototype.submit.call(
                    document.getElementById("formDropzone")
                );
            });
            let existingImages = @json($adsSettings->images ?? []);
            let grid = document.getElementById("imagePreviewGrid");
            let hiddenContainer = document.getElementById("hiddenInputsContainer");

            existingImages.forEach(img => {

                // keep existing image by default
                appendHiddenInput(
                    "existing_images[]",
                    img.id,
                    "existing-image-" + img.id
                );

                let card = document.createElement("div");
                card.className = "image-card";
                card.dataset.id = img.id;

                card.innerHTML = `
        <img src="/${img.image_url}" />

        <div class="image-delete">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="white">
                <path d="M18.3 5.71L12 12l6.3 6.29-1.41 1.42L10.59 13.41 4.29 19.71 2.88 18.3 9.17 12 2.88 5.71 4.29 4.29l6.3 6.3 6.29-6.3z"/>
            </svg>
        </div>
    `;

                card.querySelector(".image-delete")
                    .addEventListener("click", function() {

                        // remove keep input
                        $("#existing-image-" + img.id).remove();

                        // send deleted id
                        appendHiddenInput(
                            "deleted_images[]",
                            img.id
                        );

                        card.remove();
                    });

                grid.appendChild(card);
            });

            function appendHiddenInput(name, value, id = null) {

                let input = document.createElement("input");

                input.type = "hidden";
                input.name = name;
                input.value = value;

                if (id) {
                    input.id = id;
                }

                hiddenContainer.appendChild(input);
            }

            function renderNewImage(file) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    let grid = document.getElementById("imagePreviewGrid");

                    let card = document.createElement("div");
                    card.className = "image-card";

                    card.innerHTML = `
            <img src="${e.target.result}" />

            <div class="image-delete">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="white">
                    <path d="M18.3 5.71L12 12l6.3 6.29-1.41 1.42L10.59 13.41 4.29 19.71 2.88 18.3 9.17 12 2.88 5.71 4.29 4.29l6.3 6.3 6.29-6.3z"/>
                </svg>
            </div>
        `;

                    card.querySelector(".image-delete")
                        .addEventListener("click", function() {

                            uploadZone.removeFile(file);

                            card.remove();
                        });
                    grid.appendChild(card);
                };

                reader.readAsDataURL(file);
            }


            function addDeleteButton(file, dz) {
                let btn = document.createElement("div");

                btn.className = "dz-delete";
                btn.innerHTML = `
        <svg width="14" height="14" viewBox="0 0 24 24" fill="white">
            <path d="M18.3 5.71L12 12l6.3 6.29-1.41 1.42L10.59 13.41 4.29 19.71 2.88 18.3 9.17 12 2.88 5.71 4.29 4.29l6.3 6.3 6.29-6.3z"/>
        </svg>
    `;

                btn.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dz.removeFile(file);
                });

                file.previewElement.appendChild(btn);
            }

            $("#formDropzone").on("submit", function(e) {

                e.preventDefault();

                const submitBtn = $("#submitBtn");

                if (submitBtn.prop("disabled")) {
                    return;
                }

                submitBtn.prop("disabled", true);

                submitBtn.find(".submit-text")
                    .addClass("d-none");

                submitBtn.find(".submit-loading")
                    .removeClass("d-none");

                if (uploadZone.getAcceptedFiles().length > 0) {

                    uploadZone.processQueue();

                } else {

                    HTMLFormElement.prototype.submit.call(this);
                }
            });

            uploadZone.on("error", function() {

                const submitBtn = $("#submitBtn");

                submitBtn.prop("disabled", false);

                $("#formDropzone")
                    .find("input, textarea, select, button")
                    .prop("disabled", false);

                submitBtn.find(".submit-loading")
                    .addClass("d-none");

                submitBtn.find(".submit-text")
                    .removeClass("d-none");
            });
        </script>
    @endpush
@endsection
