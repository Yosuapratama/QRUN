@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Settings General - QRUN Website</title>
    @endpush

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 text-gray-800 font-weight-bold m-2">General Settings</h1>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $err)
                    {{ $err }}
                @endforeach
            </div>
        @endif
        <!-- DataTales Example -->


        <form action="{{ route('settings.store') }}" method="POST" class="card" id="formDropzone"
            enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Running Text</h6>
                </div>
                <div class="card-body">
                    <div class="slider-container mb-3">
                        <label for="running-text-info" class="slider-label">Turn on Running Text ?</label>
                        <input class="slider" name="is_active_running_text" id="running-text-info"
                            {{ $runningText->is_active ? 'checked' : '' }} type="checkbox">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Running Text Title<span class="text-danger">*</span></label>
                        <input required type="text" name="title_running_text" value="{{ $runningText->title ?? '' }}"
                            class="form-control" placeholder="Enter Running Text...">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Font Size in pixel<span class="text-danger">*</span></label>
                        <input min="0" value="{{ $runningText->font_size ?? 11 }}" required type="number"
                            value="" placeholder="Font Size..." name="font_size" class="form-control">
                    </div>

                    @php
                        $colors = ['red', 'green', 'blue', 'cornflowerblue', 'yellow', 'purple', 'black', 'crimson'];
                    @endphp

                    <div class="form-group">
                        <label class="form-label">Background Color<span class="text-danger">*</span></label>
                        <select class="form-control" name="background_color" required>
                            <option value="">Select Background Color...</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color }}"
                                    {{ $runningText->background_color == $color ? 'selected' : '' }}>
                                    {{ ucfirst($color) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @php
                        $textColors = [
                            'red',
                            'green',
                            'blue',
                            'cornflowerblue',
                            'yellow',
                            'purple',
                            'black',
                            'white',
                            'crimson',
                        ];
                    @endphp

                    <div class="form-group">
                        <label class="form-label">Text Color<span class="text-danger">*</span></label>
                        <select class="form-control" name="text_color" required>
                            <option value="">Select Text Color...</option>
                            @foreach ($textColors as $color)
                                <option value="{{ $color }}"
                                    {{ $runningText->text_color == $color ? 'selected' : '' }}>
                                    {{ ucfirst($color) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Disabled After<span class="text-danger">*</span></label>
                        <input min="0" value="{{ $runningText->disabled_after ?? 11 }}" required type="number"
                            value="" placeholder="Enter in Second..." name="disabled_after" class="form-control">
                    </div>
                    {{-- <div class="form-group">
                    <label class="form-label">Time (Second)</label>
                    <input type="number" min="0" value="{{ $runningText->field_two_value ?? '' }}"
                        class="form-control">
                </div> --}}
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Global Ads Settings</h6>
                </div>
                <div class="card-body">
                    <div class="slider-container mb-3">
                        <label for="running-text-info" class="slider-label">Turn on Ads ?</label>
                        <input class="slider" name="ads_active" id="running-text-info" type="checkbox"
                            {{ $adsSettings->is_active ? 'checked' : '' }}>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ads Title<span class="text-danger">*</span></label>
                        <input required type="text" name="title_ads" value="{{ $adsSettings->title ?? '' }}"
                            class="form-control" placeholder="Enter Title...">
                    </div>
                    {{-- <div class="alert alert-success d-none mb-4" id="successMessage">The form was submitted successfully. --}}
                    {{-- </div> --}}
                    <div class="mb-4">
                        <label class="form-label text-muted opacity-75 fw-medium" for="formImage">Image<span
                                class="text-danger">*</span></label>
                        <div class="dropzone-drag-area" id="previews">
                            <div class="dz-message text-muted opacity-50" data-dz-message>
                                <span>Drag file here to upload</span>
                            </div>
                            <div class="d-none" id="dzPreviewContainer">
                                <div class="dz-preview dz-file-preview">
                                    <div class="dz-photo">
                                        <img class="dz-thumbnail" data-dz-thumbnail>
                                    </div>
                                    <button class="dz-delete border-0 p-0" type="button" data-dz-remove>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="times">
                                            <path fill="#FFFFFF"
                                                d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="invalid-feedback fw-bold">Please upload an image.</div>
                    </div>
                    {{-- <div class="form-group mb-4">
                        <label class="form-label text-muted opacity-75 fw-medium" for="formImage">Image</label>
                        <div class="dropzone-drag-area form-control" id="previews">
                            <form action="{{ route('upload.ads') }}" method="POST" class="dropzone" id="formDropzone"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="dz-message text-muted opacity-50" data-dz-message>
                                    <span>Drag file here to upload or click to browse</span>
                                </div>
                            </form>
                            <div class="invalid-feedback fw-bold">Please upload an image.</div>
                        </div>
                        <div class="invalid-feedback fw-bold">Please upload an image.</div>
                    </div> --}}
                    {{-- <button id="uploadData">ImageData</button> --}}

                    <div class="form-group">
                        <label class="form-label">Time<span class="text-danger">*</span></label>
                        <input required type="number" name="time_ads" value="{{ $adsSettings->time ?? '' }}"
                            class="form-control" placeholder="Enter Time...">
                    </div>
                    <!-- Dropzone Form -->
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">Save Data</button>
                </div>
            </div>

        </form>

        <div class="card shadow mb-3 mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Settings</h6>
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

        {{-- <div class="card mt-3">
            <form class="dropzone overflow-visible p-0" id="formDropzone" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="form-group mb-3">
                    <label class="form-label text-muted opacity-75 fw-medium" for="formName">Name</label>
                    <input class="form-control border-2 shadow-none fw-bold p-3" id="formName" name="name" type="text" required>
                    <div class="invalid-feedback fw-bold">The name field is required.</div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label text-muted opacity-75 fw-medium" for="formEmail">Email</label>
                    <input class="form-control border-2 shadow-none fw-bold p-3" id="formEmail" name="email" type="email" required>
                    <div class="invalid-feedback fw-bold">The email field is required.</div>
                </div>
              
                <button class="btn btn-primary fw-medium py-3 px-4 mt-3" id="formSubmit" type="submit">
                    <span class="spinner-border spinner-border-sm d-none me-2" aria-hidden="true"></span>
                    Submit Form
                </button>
            </form>
        </div> --}}
    </div>
    @push('css')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" rel="stylesheet">
        <style>
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
        </style>
    @endpush

    @push('script')
        <!-- Scripts -->
        {{-- <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
        <script>
            Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone('#formDropzone', {
                url: "{{ route('upload.ads') }}", // Ensure the URL is correct
                previewTemplate: $('#dzPreviewContainer').html(),
                addRemoveLinks: true,
                autoProcessQueue: false, // Prevent auto-upload, we will trigger it manually
                uploadMultiple: false,
                parallelUploads: 1,
                maxFiles: 1,
                acceptedFiles: '.jpeg, .jpg, .png, .gif',
                thumbnailWidth: 900,
                thumbnailHeight: 600,
                previewsContainer: "#previews",
                timeout: 0, // Set timeout to 0 to prevent timeout issues
                init: function() {
                    // window.location.reload();
                    var dz = this;
                    console.log("success go to init");
                    var existingImage = "{{ asset($adsSettings->image_url) ?? '' }}";

                    if (existingImage) {
                        // Construct the full URL for the image using the `asset` helper

                        var thumb = {
                            name: existingImage,
                            size: 0,
                            dataURL: existingImage
                        };

                        dz.files.push(thumb);

                        // Call the default addedfile event handler
                        dz.emit('addedfile', thumb);

                        dz.createThumbnailFromUrl(thumb,
                            dz.options.thumbnailWidth, dz.options.thumbnailHeight,
                            dz.options.thumbnailMethod, true,
                            function(thumbnail) {
                                dz.emit('thumbnail', thumb, thumbnail);
                            });
                            

                        // Make sure that there is no progress bar, etc...
                        dz.emit('complete', thumb);

                        
                        // If you use the maxFiles option, make sure you adjust it to the
                        // correct amount:
                    

                    }



                    // this.on('sending', function(file, xhr, formData) {
                    //     var token = $('meta[name="csrf-token"]').attr('content');
                    //     formData.append('_token', token);
                    // });

                    // When file is added to Dropzone
                    this.on('addedfile', function(file) {
                        dz.removeFile(thumb);
                        $('.dropzone-drag-area').removeClass('is-invalid').next('.invalid-feedback').hide();

                    });

                    // Handle file upload success
                    this.on('success', function(file, response) {
                        // console.log('Upload successful:', response);
                        // $('#formDropzone').fadeOut(600);
                        // setTimeout(function() {
                        //     $('#successMessage').removeClass('d-none');
                        // }, 600);
                        dz.removeAllFiles();

                    });

                    // Handle file upload error
                    this.on('error', function(file, errorMessage) {
                        console.log('Upload error:', errorMessage);
                        $('.dropzone-drag-area').addClass('is-invalid').next('.invalid-feedback').show()
                            .text('File upload failed: ' + errorMessage);
                        this.removeFile(file);
                    });
                }
            });

            $("#formDropzone").on('submit', function(e) {
                // e.preventDefault();

                myDropzone.processQueue();
            });
        </script>
    @endpush



    <!-- End of Main Content -->
@endsection
