@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Create Blog Admin - QRUN Website</title>
    @endpush
    <!-- Begin Page Content -->

    <div class="container-fluid">

        {{-- PAGE HEADER --}}
        <div class="page-header">

            <div>
                <h1 class="page-title">
                    {{ $blog ? 'Update Blog' : 'Create Blog' }}
                </h1>

                <div class="page-subtitle">
                    Manage blog content, thumbnail, and publish settings.
                </div>
            </div>

            <a href="{{ route('blog.index') }}" class="btn btn-outline-secondary btn-modern">
                <i class="fas fa-arrow-left mr-2"></i>
                Back
            </a>

        </div>

        {{-- ALERT --}}
        @if (session()->has('success'))
            <div class="alert alert-success shadow-sm">
                {{ session()->get('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger shadow-sm">
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card modern-card mb-4">

            <div class="card-header">

                <div class="section-title">
                    Blog Form
                </div>

                <div class="section-subtitle">
                    Fill in the information below carefully.
                </div>

            </div>

            <div class="card-body">

                @if ($blog)
                    <form method="POST" action="{{ route('blog.update') }}" id="formDropzone">
                    @else
                        <form action="{{ route('blog.store') }}" method="POST" id="formDropzone">
                @endif

                @csrf

                <input type="hidden" name="id" value="{{ $blog ? $blog->id : '' }}">

                {{-- TITLE --}}
                <div class="form-group-modern">

                    <label class="form-label-modern">
                        Blog Title
                        <span class="text-danger">*</span>
                    </label>

                    <input required class="form-control" value="{{ old('title', $blog ? $blog->title : '') }}"
                        name="title" type="text" id="title" placeholder="Enter blog title...">

                    @error('title')
                        <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                    @enderror

                </div>

                {{-- SLUG --}}
                <div class="form-group-modern">

                    <label class="form-label-modern">
                        Slug
                        <span class="text-danger">*</span>
                    </label>

                    <input required class="form-control" value="{{ old('slug', $blog ? $blog->slug : '') }}" name="slug"
                        type="text" id="slug" placeholder="example-blog-slug">

                    @error('slug')
                        <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                    @enderror

                </div>

                {{-- DESCRIPTION --}}
                <div class="form-group-modern">

                    <label class="form-label-modern">
                        Short Description
                        <span class="text-danger">*</span>
                    </label>

                    <textarea required class="form-control" rows="3" name="description" id="description"
                        placeholder="Short description about this blog...">{{ old('description', $blog ? $blog->description : '') }}</textarea>

                    @error('description')
                        <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                    @enderror

                </div>

                {{-- CONTENT --}}
                <div class="form-group-modern">

                    <label class="form-label-modern">
                        Blog Content
                    </label>

                    <textarea class="form-control" name="content" id="summernote">
{{ old('content', $blog ? $blog->content : '') }}
                </textarea>

                    @error('content')
                        <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                    @enderror

                </div>

                {{-- COVER --}}
                <div class="form-group-modern">

                    <label class="form-label-modern">
                        Blog Cover
                        <span class="text-danger">*</span>
                    </label>

                    <div class="dropzone-drag-area" id="previews">

                        <div class="dz-message" data-dz-message>

                            <i class="fas fa-cloud-upload-alt"></i>

                            <div class="font-weight-bold">
                                Drag & Drop image here
                            </div>

                            <small>
                                PNG, JPG, JPEG up to 5MB
                            </small>

                        </div>

                        <div class="d-none" id="dzPreviewContainer">

                            <div class="dz-preview dz-file-preview">

                                <div class="dz-photo">
                                    <img class="dz-thumbnail" data-dz-thumbnail>
                                </div>

                                <button class="dz-delete" type="button" data-dz-remove>

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">

                                        <path fill="#FFFFFF"
                                            d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z">
                                        </path>

                                    </svg>

                                </button>

                            </div>

                        </div>

                    </div>

                    <input type="hidden" id="image_url" name="image_url">

                    @error('image_url')
                        <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                    @enderror

                </div>

                {{-- PUBLISH --}}
                <div class="publish-card mb-4">

                    <div class="publish-wrapper">

                        <div>

                            <div class="publish-title">
                                Publish Blog
                            </div>

                            <div class="publish-subtitle">
                                Enable this if you want the blog visible publicly.
                            </div>

                        </div>

                        <label class="switch">

                            <input type="checkbox" name="is_published" @if (isset($blog->is_publish) && $blog->is_publish) checked @endif>

                            <span class="slider-switch"></span>

                        </label>

                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="d-flex justify-content-end">

                    @if ($blog)
                        <button type="submit" class="btn btn-primary btn-modern">
                            <i class="fas fa-save mr-2"></i>
                            Update Blog
                        </button>
                    @else
                        <button type="submit" class="btn btn-success btn-modern">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Publish Blog
                        </button>
                    @endif

                </div>

                </form>

            </div>

        </div>

    </div>

    @push('css')
        <style>
            .page-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 16px;
                flex-wrap: wrap;
                margin-bottom: 1.5rem;
            }

            .page-title {
                font-size: 1.8rem;
                font-weight: 700;
                color: #2e384d;
                margin: 0;
            }

            .page-subtitle {
                color: #858796;
                margin-top: 4px;
                font-size: 14px;
            }

            .modern-card {
                border: none;
                border-radius: 18px;
                overflow: hidden;
                box-shadow:
                    0 10px 25px rgba(0, 0, 0, .05),
                    0 4px 10px rgba(0, 0, 0, .03);
            }

            .modern-card .card-header {
                background: #fff;
                border-bottom: 1px solid #eef1f7;
                padding: 1.2rem 1.5rem;
            }

            .modern-card .card-body {
                padding: 1.5rem;
            }

            .section-title {
                font-size: 1rem;
                font-weight: 700;
                color: #4e73df;
                margin-bottom: 4px;
            }

            .section-subtitle {
                color: #858796;
                font-size: 13px;
            }

            .form-group-modern {
                margin-bottom: 1.5rem;
            }

            .form-label-modern {
                font-size: 14px;
                font-weight: 700;
                color: #2f3640;
                margin-bottom: 8px;
                display: block;
            }

            .form-control {
                border-radius: 12px !important;
                min-height: 48px;
                border: 1px solid #e3e6f0;
                padding: 12px 16px;
                font-size: 14px;
                transition: .2s ease;
            }

            .form-control:focus {
                border-color: #4e73df;
                box-shadow: 0 0 0 4px rgba(78, 115, 223, .10);
            }

            .note-editor.note-frame {
                border-radius: 14px !important;
                border: 1px solid #e3e6f0 !important;
                overflow: hidden;
            }

            .note-toolbar {
                background: #f8f9fc !important;
                border-bottom: 1px solid #eef1f7 !important;
            }

            .note-editing-area {
                min-height: 350px;
            }

            .dropzone-drag-area {
                height: 320px;
                border-radius: 16px;
                border: 2px dashed #d9deea;
                background: #fafbff;
                transition: .2s ease;
                position: relative;
                overflow: hidden;
            }

            .dropzone-drag-area:hover {
                border-color: #4e73df;
                background: #f5f7ff;
            }

            .dz-message {
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                gap: 12px;
                color: #858796;
            }

            .dz-message i {
                font-size: 42px;
                color: #4e73df;
            }

            .dz-preview {
                width: 100%;
                height: 100%;
                margin: 0 !important;
                position: absolute !important;
                inset: 0;
                padding: 18px;
            }

            .dz-photo {
                width: 100%;
                height: 100%;
                border-radius: 16px;
                overflow: hidden;
                background: #f2f4f9;
            }

            .dz-thumbnail {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .dz-delete {
                width: 42px;
                height: 42px;
                border-radius: 50%;
                border: none;
                background: rgba(0, 0, 0, .65);
                position: absolute;
                top: 28px;
                right: 28px;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: .2s ease;
            }

            .dz-preview:hover .dz-delete {
                opacity: 1;
            }

            .dz-delete svg {
                width: 18px;
                height: 18px;
            }

            .publish-card {
                background: linear-gradient(135deg, #f8f9ff 0%, #eef3ff 100%);
                border: 1px solid #dfe7ff;
                border-radius: 16px;
                padding: 18px 20px;
            }

            .publish-wrapper {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 20px;
            }

            .publish-title {
                font-weight: 700;
                color: #2f3640;
                margin-bottom: 4px;
            }

            .publish-subtitle {
                font-size: 13px;
                color: #858796;
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
                inset: 0;
                cursor: pointer;
                background-color: #d6d9e6;
                transition: .3s;
                border-radius: 999px;
            }

            .slider-switch:before {
                position: absolute;
                content: "";
                width: 24px;
                height: 24px;
                left: 3px;
                top: 3px;
                background-color: white;
                transition: .3s;
                border-radius: 50%;
                box-shadow: 0 2px 8px rgba(0, 0, 0, .12);
            }

            .switch input:checked+.slider-switch {
                background-color: #4e73df;
            }

            .switch input:checked+.slider-switch:before {
                transform: translateX(28px);
            }

            .btn-modern {
                border-radius: 12px;
                padding: 12px 22px;
                font-weight: 600;
                font-size: 14px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, .06);
            }

            .alert {
                border: none;
                border-radius: 14px;
            }

            @media(max-width:768px) {
                .publish-wrapper {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .page-title {
                    font-size: 1.5rem;
                }
            }
        </style>
    @endpush

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
                timeout: 0, // Set timeout to 0 to prevent timeout issues
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
