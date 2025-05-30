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
                    <form method="POST" action="{{ route('blog.update') }}">
                    @else
                        <form action="{{ route('blog.store') }}" method="POST">
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
        <script>
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
