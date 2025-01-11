@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Form Advertise - QRUN Website</title>
    @endpush

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 text-gray-800 font-weight-bold m-2">Advertise Form</h1>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            </div>
        @endif
        <!-- DataTales Example -->
        <a href="{{ route('advertise.index') }}" class="btn btn-primary m-2">Back</a>

        <form action="{{ route('advertise.storeOrUpdate') }}" method="POST" class="card" id="formDropzone"
            enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ads Settings</h6>
                </div>
                <input type="hidden" name="id" value="{{ $adsSettings->id ?? '' }}">
                <div class="card-body">
                    <div class="slider-container mb-3">
                        <label for="running-text-info" class="slider-label">Turn on Ads ?</label>
                        <input class="slider" name="is_active" id="running-text-info" type="checkbox"
                            @if ($adsSettings) {{ $adsSettings->is_active ? 'checked' : '' }} @endif>
                    </div>
                    <div class="form-group">
                        <label for="place_id" class="slider-label">Add Place (Can Multiple)<span class="text-danger">*</span></label>
                        <select class="form-control" id="place_id" name="places[]" multiple>
                            {{-- <option value="">Select Place...</option> --}}
                            @foreach ($placeId as $place)
                                <option value="{{ $place->id }}" @if ($adsSettings && in_array($place->id, $adsSettings->places->pluck('id')->toArray())) selected @endif>
                                    {{ $place->place_code }} | {{ $place->title }} | {{ $place->creator_id }}
                                </option>
                            @endforeach
                        </select>
                        @error('places')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Ads Title<span class="text-danger">*</span></label>
                        <input required type="text" name="title" value="{{ $adsSettings->title ?? '' }}"
                            class="form-control" placeholder="Enter Title...">
                        @error('title')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror
                    </div>

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
                        @error('image_url')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <input type="hidden" id="image_url" name="image_url">

                    <div class="form-group">
                        <label class="form-label">Time<span class="text-danger">*</span></label>
                        <input required type="number" name="time" value="{{ $adsSettings->time ?? '' }}"
                            class="form-control" placeholder="Enter Time...">

                        @error('time')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Dropzone Form -->
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">Save Data</button>
                </div>
            </div>

        </form>

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
            $(document).ready(function() {
                $('#place_id').select2();
            });
        </script>
        <script>
            Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone('#formDropzone', {
                url: "{{ route('upload.place.ads') }}", // Ensure the URL is correct
                previewTemplate: $('#dzPreviewContainer').html(),
                addRemoveLinks: true,
                autoProcessQueue: true, // Prevent auto-upload, we will trigger it manually
                uploadMultiple: false,
                parallelUploads: 1,
                maxFiles: 1,
                acceptedFiles: '.jpeg, .jpg, .png, .gif',
                thumbnailWidth: 900,
                thumbnailHeight: 600,
                previewsContainer: "#previews",
                timeout: 5000, // Set timeout to 0 to prevent timeout issues
                init: function() {
                    // window.location.reload();
                    var dz = this;
                    console.log("success go to inited");
                    var existingImage;

                    @if ($adsSettings)
                        existingImage = "{{ asset($adsSettings->image_url) ?? '' }}";
                        $('#image_url').val(existingImage); // Set the URL in the hidden input
                    @endif

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

                    this.on('sending', function(file, xhr, formData) {
                        var token = $('meta[name="csrf-token"]').attr('content');
                        formData.append('_token', token);
                        console.log("hei");
                    });

                    // When file is added to Dropzone
                    this.on('addedfile', function(file) {
                        // Check if thumb exists before trying to remove it
                        if (thumb) {
                            dz.removeFile(thumb);
                        }
                        // Remove invalid class and hide error message if any
                        $('.dropzone-drag-area').removeClass('is-invalid').next('.invalid-feedback').hide();
                    });


                    // Handle file upload success
                    this.on('success', function(file, response) {
                        // Assuming the response contains the URL of the uploaded file
                        var imageUrl = response.image_url; // Adjust this according to your API response
                        $('#image_url').val(imageUrl); // Set the URL in the hidden input

                        // dz.removeAllFiles(); // Optional: Remove files after success

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

            // $("#formDropzone").on('submit', function(e) {
            //     myDropzone.processQueue();
            // });
        </script>
    @endpush



    <!-- End of Main Content -->
@endsection
