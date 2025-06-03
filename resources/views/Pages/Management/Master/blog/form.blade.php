@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Create Blog Admin - QRUN Website</title>
    @endpush
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 text-gray-800 font-weight-bold m-2">@lang('messages.blog.title_heading')</h1>

        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@lang('messages.blog.title_heading')</h6>
            </div>
            <div class="card-body">
                {{-- Create blog Form --}}
                @if ($blog)
                    <form method="POST" action="{{ route('blog.update') }}" id="formDropzone">
                    @else
                        <form action="{{ route('blog.store') }}" method="POST" id="formDropzone">
                @endif
                @csrf
                <input type="hidden" name="id" value="{{ $blog ? $blog->id : '' }}">
                <div class="mb-3">
                    <label class="form-label" for="title">@lang('messages.my-place.title')<span class="text-danger">*</span></label>
                    <input required class="form-control" value="{{ old('title', $blog ? $blog->title : '') }}"
                        name="title" type="text" id="title" placeholder="Blog Title...">
                    @error('title')
                        <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="slug">Slug<span class="text-danger">*</span></label>
                    <input required class="form-control" value="{{ old('slug', $blog ? $blog->slug : '') }}"
                        name="slug" type="text" id="slug" placeholder="Blog slug...">
                    @error('slug')
                        <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="description">@lang('messages.my-place.description')<span class="text-danger">*</span></label>
                    <input required value="{{ old('description', $blog ? $blog->description : '') }}" class="form-control"
                        name="description" type="text" id="description" placeholder="Blog Description...">
                    @error('description')
                        <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    {{-- <textarea required class="form-control" name="content" id="summernote">{{ $blog ? $blog->content : '' }}</textarea> --}}
                    <textarea class="form-control" name="content" id="summernote">{{ old('content', $blog ? $blog->content : '') }}</textarea>
                    @error('content')
                        <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                    @enderror
                </div>

                
                <div class="mb-3">
                    <label class="form-label text-muted opacity-75 fw-medium" for="formImage">Cover<span
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
                <!-- Dropzone Form -->

                <div class="slider-container mb-3">
                    <label for="yesno-slider" class="slider-label">Publish? No / Yes</label>
                    <input name="is_published"
                        @if (isset($blog->is_publish)) @if ($blog->is_publish) checked @endif @endif type="checkbox" id="yesno-slider" class="slider">
                </div>
                @if ($blog)
                    <button type="submit" class="btn btn-primary btn-md">Update blog</button>
                @else
                    <button type="submit" class="btn btn-success btn-md">Save blog</button>
                @endif
                </form>
            </div>
        </div>

    </div>

    @push('css')
        <style>
            .slider-container {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            /* Label styling */
            .slider-label {
                font-size: 18px;
                margin-bottom: 10px;
            }

            /* Slider styling */
            .slider {
                appearance: none;
                width: 60px;
                height: 24px;
                border-radius: 50px;
                background-color: #ccc;
                outline: none;
                transition: 0.4s;
                position: relative;
            }

            /* Slider before (circle inside the slider) */
            .slider::before {
                content: "";
                position: absolute;
                top: 5px;
                left: 5px;
                width: 18px;
                height: 18px;
                border-radius: 50%;
                background-color: white;
                transition: 0.4s;
            }

            /* When the slider is checked */
            .slider:checked {
                background-color: #4e73df;
            }

            /* Move the circle when checked */
            .slider:checked::before {
                transform: translateX(26px);
            }

            /* Optional: Color the label based on the slider state */
            .slider:checked+.slider-label {
                color: #4CAF50;
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

    {{-- @push('script')
        <script>
            //Setup SummerNote (Content Textarea Box)
            $(document).ready(function() {
                $('#summernote').summernote({
                    tabsize: 2,
                    height: 300
                });
            });
        </script>
    @endpush --}}

    {{-- @push('script')
        <script>
            //Setup SummerNote (Content Textarea Box)
            $(document).ready(function() {
                $('#summernote').summernote({
                    tabsize: 2,
                    height: 300
                });
            });
        </script>
    @endpush --}}

    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
        <script>
              Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone('#formDropzone', {
                url: "{{ route('upload.blog') }}", // Ensure the URL is correct
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

                    @if ($blog)
                        existingImage = "{{ asset($blog->image_url) ?? '' }}";
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
                        Swal.fire({
                            title: 'Uploading...',
                            text: 'Please wait while we upload your file.',
                            didOpen: () => {
                                Swal.showLoading(); // Show the loading spinner
                            },
                            allowOutsideClick: false, // Prevent closing the modal by clicking outside
                            showConfirmButton: false // Hide the confirm button
                        });
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

                        Swal.close();
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


            // $(document).ready(function() {
            //     $('#summernote').summernote();
            // });

            $(document).ready(function() {

                console.log("Initializing Summernote...");
                $(document).on('click', '.note-modal .close', function() {
                    // This will close the Summernote modal (if it's part of the Summernote plugin)
                    $('.note-modal').modal('hide');
                });

                // Initialize Summernote
                $('#summernote').summernote({
                    height: 300, // Set height of the editor
                    toolbar: [
                        ['style'],
                        ['insert', ['bold', 'underline', 'eraser']],
                        // ['eraser'], 
                        ['recentColor'],
                        ['fontname'],
                        ['color'],
                        ['para', ['ul', 'ol', 'paragraph', 'height']],
                        ['pdfButton'],
                        ['table'],
                        ['insert', ['link', 'picture', 'video']],
                        ['insert', ['fullscreen', 'codeview', 'help']],
                    ],
                    buttons: {
                        eraser: function(context) {
                            return $('<button />')
                                .addClass('note-btn btn btn-light btn-sm note-btn-bold')
                                .html('<i class="note-icon-eraser"/>')
                                .click(function(event) {
                                    // Prevent default form submission or page reload
                                    event.preventDefault();

                                    // Clear formatting (remove bold, underline, etc.)
                                    context.invoke('removeFormat');
                                });
                        },
                        //     pdfButton: function(context) {
                        //         var ui = $.summernote.ui;
                        //         var button = ui.button({
                        //             contents: '<i class="fas fa-file-alt text-black" style="font-weight:bold"></i> <span style="font-weight: bold;">PDF</span>',
                        //             tooltip: 'Insert PDF',
                        //             click: function() {
                        //                 console.log("PDF button clicked...");
                        //                 // Open file input dialog when button is clicked
                        //                 var input = $(
                        //                     '<input type="file" accept="application/pdf">');
                        //                 input.on('change', function(e) {
                        //                     var file = e.target.files[0];
                        //                     if (file && file.type === 'application/pdf') {
                        //                         var reader = new FileReader();
                        //                         reader.onload = function(event) {
                        //                             var pdfDataUrl = event.target
                        //                             .result;
                        //                             console.log(
                        //                                 "PDF loaded, inserting into Summernote..."
                        //                                 );

                        //                             // Create the iframe element with the PDF data URL
                        //                             var iframe = document.createElement(
                        //                                 'iframe');
                        //                             iframe.src = pdfDataUrl;
                        //                             iframe.width = '95%';
                        //                             iframe.height = '400px';
                        //                             iframe.style.border = 'none';

                        //                             // Insert the iframe into Summernote using insertNode
                        //                             $('#summernote').summernote(
                        //                                 'editor.insertNode', iframe);

                        //                             // Force Summernote to refresh and re-render the content
                        //                             setTimeout(function() {
                        //                                 $('#summernote')
                        //                                     .summernote('code',
                        //                                         $('#summernote')
                        //                                         .summernote(
                        //                                             'code'));
                        //                                 $('#summernote')
                        //                             .focus(); // Focus the editor after insertion
                        //                             }, 100);

                        //                             // Optional: Log the inserted HTML to ensure it's being added
                        //                             console.log("Inserted iframe: ",
                        //                                 iframe);
                        //                         };
                        //                         reader.readAsDataURL(file);
                        //                     } else {
                        //                         alert('Please upload a valid PDF file');
                        //                     }
                        //                 });
                        //                 input.trigger('click');
                        //             }
                        //         });
                        //         return button.render();
                        //     }
                        pdfButton: function(context) {
                            var ui = $.summernote.ui;
                            var button = ui.button({
                                contents: '<i class="fas fa-file-alt text-black" style="font-weight:bold"></i> <span style="font-weight: bold;">PDF</span>',
                                tooltip: 'Insert PDF',
                                click: function() {
                                    console.log("PDF button clicked...");
                                    // Open file input dialog when button is clicked
                                    var input = $(
                                        '<input type="file" accept="application/pdf">');
                                    input.on('change', function(e) {
                                        var file = e.target.files[0];
                                        if (file && file.type === 'application/pdf') {
                                            var formData = new FormData();
                                            formData.append('pdf', file);
                                            Swal.fire({
                                                title: 'Uploading...',
                                                text: 'Please wait while the file is being uploaded.',
                                                showConfirmButton: false,
                                                allowOutsideClick: false, // Disable closing the alert by clicking outside
                                                didOpen: () => {
                                                    Swal
                                                        .showLoading(); // Display the loading spinner
                                                }
                                            });

                                            // Make the file upload request
                                            $.ajax({
                                                url: "{{ route('file.upload') }}", // Change this to your server-side upload URL
                                                type: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': $(
                                                        'meta[name="csrf-token"]'
                                                    ).attr('content')
                                                },
                                                data: formData,
                                                contentType: false, // Don't set contentType for FormData
                                                processData: false, // Don't process data (it's already in FormData format)
                                                success: function(response) {
                                                    var data = response;
                                                    if (data.url) {
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Upload Complete!',
                                                            text: 'The PDF was successfully uploaded.',
                                                            showConfirmButton: true
                                                        });

                                                        // Create the iframe element with the URL of the uploaded PDF
                                                        var iframe =
                                                            document
                                                            .createElement(
                                                                'iframe');
                                                        iframe.src = data
                                                            .url; // URL returned by the server
                                                        iframe.width =
                                                            '100%';
                                                        iframe.height =
                                                            '400px';
                                                        iframe.style
                                                            .border =
                                                            'none';

                                                        console.log(iframe);
                                                        // Insert the iframe into Summernote using insertNode
                                                        $('#summernote')
                                                            .summernote(
                                                                'editor.insertNode',
                                                                iframe);

                                                        // Force Summernote to refresh and re-render the content
                                                        setTimeout(
                                                            function() {
                                                                $('#summernote')
                                                                    .summernote(
                                                                        'code',
                                                                        $(
                                                                            '#summernote'
                                                                        )
                                                                        .summernote(
                                                                            'code'
                                                                        )
                                                                    );
                                                                $('#summernote')
                                                                    .focus(); // Focus the editor after insertion
                                                            }, 100);

                                                        console.log(
                                                            "Inserted iframe: ",
                                                            iframe);
                                                    } else {
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Upload Failed',
                                                            text: 'File upload failed: ' +
                                                                (response
                                                                    .error ||
                                                                    'Unknown error'
                                                                ),
                                                            showConfirmButton: true
                                                        });
                                                        // Swal.close();
                                                    }
                                                },
                                                error: function() {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Upload Failed',
                                                        text: 'File upload failed: Server is during maintenance',
                                                        showConfirmButton: true
                                                    });
                                                    // Swal.close();
                                                }
                                            });
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Upload Failed',
                                                text: 'File upload failed: Please Upload A Valid PDF',
                                                showConfirmButton: true
                                            });
                                            // Swal.close();
                                        }
                                    });
                                    input.trigger('click');
                                }
                            });
                            return button.render();
                        }

                    }

                });
            });
        </script>
    @endpush
    <!-- End of Main Content -->
@endsection
