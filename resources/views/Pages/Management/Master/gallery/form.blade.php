@extends('TemplateLayout.AdminLayout')

@section('content')
    @push('title')
        <title>Form Gallery - QRUN Website</title>

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

    <div class="container-fluid py-4">

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap mb-4">

            <div>
                <h1 class="page-title mb-1">
                    {{ isset($gallery) ? 'Edit Gallery' : 'Create Gallery' }}
                </h1>

                <p class="text-muted mb-0">
                    Manage gallery image and information
                </p>
            </div>

            <a href="{{ route('gallery.index') }}" class="btn btn-light btn-back shadow-sm">
                <i class="fas fa-arrow-left mr-2"></i>
                Back
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

        {{-- Form --}}
        <form action="{{ route('gallery.storeOrUpdate') }}" method="POST" class="custom-card" id="formDropzone"
            enctype="multipart/form-data" novalidate>

            @csrf

            <input type="hidden" name="id" value="{{ $gallery->id ?? '' }}">

            <input type="hidden" id="image_url" name="image_url" value="{{ $gallery->image_url ?? '' }}">

            {{-- Card Header --}}
            <div class="card-header">

                <div class="d-flex align-items-center">
                    <div class="header-icon">
                        <i class="fas fa-images"></i>
                    </div>

                    <div>
                        <h5 class="section-title mb-1">
                            Gallery Information
                        </h5>

                        <p class="text-muted small mb-0">
                            Upload and manage gallery image
                        </p>
                    </div>
                </div>

            </div>

            {{-- Card Body --}}
            <div class="card-body">

                {{-- Title --}}
                <div class="form-group mb-4">

                    <label class="form-label">
                        Title
                        <span class="text-danger">*</span>
                    </label>

                    <input required type="text" name="title" value="{{ old('title', $gallery->title ?? '') }}"
                        class="form-control" placeholder="Enter gallery title..." required>

                    @error('title')
                        <p class="text-danger small mt-2 mb-0">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Image Upload --}}
                <div class="form-group">

                    <label class="form-label">
                        Gallery Image
                        <span class="text-danger">*</span>
                    </label>

                    <div class="dropzone-drag-area" id="previews">

                        {{-- Upload Message --}}
                        <div class="dz-message" data-dz-message>

                            <div class="upload-icon-wrapper">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>

                            <div class="text-center">
                                <h5 class="font-weight-bold mb-1">
                                    Drag & Drop Image
                                </h5>

                                <p class="text-muted mb-0">
                                    or click to browse file
                                </p>
                            </div>

                        </div>

                        {{-- Preview Template --}}
                        <div class="d-none" id="dzPreviewContainer">

                            <div class="dz-preview dz-file-preview">

                                <div class="dz-photo">
                                    <img class="dz-thumbnail" data-dz-thumbnail>
                                </div>

                                <button class="dz-delete border-0 p-0" type="button" data-dz-remove>

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path fill="#FFFFFF"
                                            d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z" />
                                    </svg>

                                </button>

                            </div>

                        </div>

                    </div>

                    <small class="text-muted d-block mt-3">
                        Supported format: JPG, PNG, GIF
                    </small>

                    @error('image_url')
                        <p class="text-danger small mt-2 mb-0">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

            {{-- Card Footer --}}
            <div class="card-footer text-right">

                <button type="submit" class="btn btn-save btn-primary shadow-sm">

                    <i class="fas fa-save mr-2"></i>
                    Save Gallery

                </button>

            </div>

        </form>

    </div>

    @push('css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <style>
            body {
                background: #f5f7fb;
            }

            .page-title {
                font-size: 30px;
                font-weight: 700;
                color: #111827;
            }

            .custom-card {
                border: none;
                border-radius: 24px;
                overflow: hidden;
                background: #fff;
                box-shadow:
                    0 10px 40px rgba(15, 23, 42, 0.06);
            }

            .custom-card .card-header {
                border-bottom: 1px solid #eef2f7;
                background: white;
                padding: 28px 32px;
            }

            .custom-card .card-body {
                padding: 32px;
            }

            .custom-card .card-footer {
                background: white;
                border-top: 1px solid #eef2f7;
                padding: 24px 32px;
            }

            .header-icon {
                width: 52px;
                height: 52px;
                border-radius: 16px;
                background: rgba(79, 70, 229, 0.1);
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 16px;
            }

            .header-icon i {
                font-size: 20px;
                color: #4f46e5;
            }

            .section-title {
                font-size: 20px;
                font-weight: 700;
                color: #111827;
            }

            .form-label {
                font-weight: 600;
                color: #374151;
                margin-bottom: 10px;
            }

            .form-control {
                height: 52px;
                border-radius: 14px;
                border: 1px solid #dbe3ef;
                padding: 12px 18px;
                font-size: 15px;
                transition: .25s ease;
                box-shadow: none !important;
            }

            .form-control:focus {
                border-color: #4f46e5;
                box-shadow:
                    0 0 0 4px rgba(79, 70, 229, 0.12) !important;
            }

            .dropzone-drag-area {
                position: relative;
                height: 340px;
                border-radius: 24px;
                border: 2px dashed #d4dbe7;
                background: linear-gradient(to bottom,
                        #f8fafc,
                        #f1f5f9);
                overflow: hidden;
                transition: .25s ease;
            }

            .dropzone-drag-area:hover {
                border-color: #4f46e5;
                transform: translateY(-2px);
            }

            .dz-message {
                height: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                margin: 0 !important;
                gap: 20px;
                color: #64748b;
            }

            .upload-icon-wrapper {
                width: 90px;
                height: 90px;
                border-radius: 24px;
                background: rgba(79, 70, 229, 0.08);
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .upload-icon-wrapper i {
                font-size: 42px;
                color: #4f46e5;
            }

            .dz-preview {
                width: 100%;
                height: 100%;
                margin: 0 !important;
                position: absolute !important;
                top: 0;
                left: 0;
                padding: 16px;
            }

            .dz-photo {
                width: 100%;
                height: 100%;
                overflow: hidden;
                border-radius: 20px;
                background: #e5e7eb;
            }

            .dz-thumbnail {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .dz-delete {
                width: 44px;
                height: 44px;
                position: absolute;
                top: 28px;
                right: 28px;
                border-radius: 50%;
                background: rgba(15, 23, 42, 0.7);
                backdrop-filter: blur(8px);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: .2s ease;
                z-index: 999;
            }

            .dz-delete svg {
                width: 18px;
                height: 18px;
            }

            .dz-preview:hover .dz-delete {
                opacity: 1;
            }

            .btn-back {
                border-radius: 14px;
                padding: 11px 18px;
                font-weight: 600;
            }

            .btn-save {
                border: none;
                border-radius: 14px;
                padding: 13px 24px;
                font-weight: 600;
                background: #4f46e5;
                color: white;
                transition: .2s ease;
            }

            .btn-save:hover {
                background: #4338ca;
                transform: translateY(-1px);
            }

            @media (max-width: 768px) {

                .custom-card .card-header,
                .custom-card .card-body,
                .custom-card .card-footer {
                    padding: 20px;
                }

                .dropzone-drag-area {
                    height: 260px;
                }

                .page-title {
                    font-size: 24px;
                }
            }
        </style>
    @endpush

    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>

        <script>
            Dropzone.autoDiscover = false;

            let existingThumb = null;

            const myDropzone = new Dropzone("#formDropzone", {

                url: "{{ route('upload.gallery') }}",

                previewTemplate: $('#dzPreviewContainer').html(),

                previewsContainer: "#previews",

                clickable: ".dropzone-drag-area",

                uploadMultiple: false,

                parallelUploads: 1,

                maxFiles: 1,

                autoProcessQueue: true,

                acceptedFiles: ".jpeg,.jpg,.png,.gif",

                thumbnailWidth: 1200,

                thumbnailHeight: 800,

                addRemoveLinks: false,

                timeout: 0,

                init: function() {

                    const dz = this;

                    @if ($gallery && $gallery->image_url)

                        let existingImage =
                            "{{ asset($gallery->image_url) }}";

                        existingThumb = {
                            name: existingImage,
                            size: 12345,
                            dataURL: existingImage
                        };

                        dz.emit("addedfile", existingThumb);

                        dz.emit("thumbnail",
                            existingThumb,
                            existingImage);

                        dz.emit("complete", existingThumb);

                        dz.files.push(existingThumb);
                    @endif

                    this.on("sending", function(file, xhr, formData) {

                        formData.append(
                            "_token",
                            $('meta[name="csrf-token"]').attr('content')
                        );

                        Swal.fire({
                            title: 'Uploading...',
                            text: 'Please wait while uploading image.',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                    });

                    this.on("addedfile", function(file) {

                        if (existingThumb && file !== existingThumb) {
                            dz.removeFile(existingThumb);
                            existingThumb = null;
                        }

                    });

                    this.on("success", function(file, response) {

                        $('#image_url').val(response.image_url);

                        Swal.fire({
                            icon: 'success',
                            title: 'Upload Success',
                            text: 'Image uploaded successfully.',
                            timer: 1500,
                            showConfirmButton: false
                        });

                    });

                    this.on("removedfile", function(file) {

                        $('#image_url').val('');

                    });

                    this.on("error", function(file, errorMessage) {

                        Swal.fire({
                            icon: 'error',
                            title: 'Upload Failed',
                            text: errorMessage
                        });

                        this.removeFile(file);

                    });

                }

            });
        </script>
    @endpush
@endsection
