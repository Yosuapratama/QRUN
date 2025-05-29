@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Create Place Admin - QRUN Website</title>
    @endpush
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 text-gray-800 font-weight-bold m-2">Create Place/Object</h1>
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
                <h6 class="m-0 font-weight-bold text-primary">Create Place Form</h6>
            </div>
            <div class="card-body">
                {{-- Create Place Form --}}
                <form action="{{ route('place.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="title">Title<span class="text-danger">*</span></label>
                        <input required class="form-control" name="title" type="text" id="title"
                            value="{{ old('title') }}" placeholder="Place Title...">
                        @error('title')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label class="form-label" for="description">Description<span class="text-danger">*</span></label>
                        <input required class="form-control" name="description" type="text" id="description"
                            value="{{ old('description') }}" placeholder="Place Description...">
                        @error('description')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="phoneNum">Contact Person</label>
                        <input class="form-control" name="phone_num" type="number" id="phoneNum"
                            placeholder="Phone Number References..." value="{{ old('phone_num') }}">
                        @error('phone_num')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="parent-container">
                        <div class="d-flex flex-column flex-md-row mb-3 align-items-start">
                            <div class="col-md-6 flex-grow-1 p-0">
                                <label for="provinceDataSelect" class="me-2">Provinsi :
                                </label>
                                <select id="provinceDataSelect" name="reg_province" class="form-control select2">
                                    <option value="">Select Province</option>
                                </select>
                            </div>
                            <div class="col-md-6 flex-grow-1 p-0">
                                <label for="regencyDataSelect" class="me-2">Kota/Kab :
                                </label>
                                <select id="regencyDataSelect" name="reg_regency" class="form-control select2">
                                    <option value="">Select Regency</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-md-row mb-3 align-items-start">
                            <div class="col-md-6 flex-grow-1 p-0">
                                <label for="districtDataSelect" class="me-2">Kecamatan :
                                </label>
                                <select id="districtDataSelect" name="reg_district" class="form-control select2">
                                    <option value="">Select District</option>
                                </select>
                            </div>
                            <div class="col-md-6 flex-grow-1 p-0">
                                <label for="villagesDataSelect" class="me-2">Desa/Kel :
                                </label>
                                <select id="villagesDataSelect" name="reg_village" class="form-control select2">
                                    <option value="">Select Village</option>
                                </select>
                            </div>
                        </div>

                    </div>


                    <div class="mb-3">
                        {{-- <textarea required class="form-control" name="content" id="summernote"></textarea>
                        @error('content')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror --}}
                        <textarea class="form-control" name="content" id="summernote">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror

                    </div>
                    <div class="slider-container mb-3">
                        <label for="yesno-slider" class="slider-label">Turn on comment ? No / Yes</label>
                        <input name="AllowComment" checked type="checkbox" id="yesno-slider" class="slider">
                    </div>
                    <button type="submit" class="btn btn-success btn-md">Create Place</button>
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

            .select2-container {
                display: block !important;
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
    @push('script')
        <script>
            // $(document).ready(function() {
            //     $('#summernote').summernote();
            // });

            $(document).ready(function() {
                var isInitedprovince = false;

                // Show CV
                function fetchLocation(province_id = null, regency_id = null, district_id = null, isFromRegency = false,
                    isFromDistrict = false, isFromVillage = false) {
                    $.ajax({
                        url: "{{ route('getLocation') }}", // URL to your Laravel route
                        data: {
                            province_id: province_id, // Pass province_id dynamically
                            regency_id: regency_id, // Pass regency_id dynamically
                            district_id: district_id // Pass district_id dynamically
                        },
                        method: 'GET', // HTTP method (GET, POST, etc.)
                        success: function(data) {
                            console.log({
                                datas: data
                            });
                            if (!isInitedprovince) {
                                var provinceSelect = $('#provinceDataSelect');

                                // Clear any existing options (if needed)
                                provinceSelect.empty();

                                // Add the default "Select Province" option
                                provinceSelect.append('<option value="">Select Province</option>');

                                // Populate the select2 dropdown with provinces data
                                data.province.forEach(function(province) {
                                    provinceSelect.append(
                                        $('<option>', {
                                            value: province
                                                .id, // Assuming each province has an 'id'
                                            text: province
                                                .name // Assuming each province has a 'name'
                                        })
                                    );
                                });

                                // Re-initialize the select2 dropdown with the newly added options
                                provinceSelect.select2({
                                    placeholder: "Select a province",
                                    allowClear: true,
                                    // width: style,
                                    // minimumResultsForSearch: Infinity, 
                                });

                                isInitedprovince = true;
                            }


                            if (!isFromRegency) {
                                var regencySelect = $('#regencyDataSelect');

                                // Clear any existing options (if needed)
                                regencySelect.empty();

                                // Add the default "Select Province" option
                                regencySelect.append('<option value="">Select Regency</option>');

                                // Populate the select2 dropdown with provinces data
                                data.regency.forEach(function(province) {
                                    regencySelect.append(
                                        $('<option>', {
                                            value: province
                                                .id, // Assuming each province has an 'id'
                                            text: province
                                                .name // Assuming each province has a 'name'
                                        })
                                    );
                                });

                                regencySelect.select2({
                                    placeholder: "Select a regency",
                                    allowClear: true,
                                });

                            }

                            if (!isFromDistrict) {
                                var districtSelect = $('#districtDataSelect');

                                // Clear any existing options (if needed)
                                districtSelect.empty();

                                // Add the default "Select Province" option
                                districtSelect.append('<option value="">Select District</option>');

                                // Populate the select2 dropdown with provinces data
                                data.districts.forEach(function(province) {
                                    districtSelect.append(
                                        $('<option>', {
                                            value: province
                                                .id, // Assuming each province has an 'id'
                                            text: province
                                                .name // Assuming each province has a 'name'
                                        })
                                    );
                                });

                                // Re-initialize the select2 dropdown with the newly added options
                                districtSelect.select2({
                                    placeholder: "Select a district",
                                    allowClear: true,
                                });
                            }
                            //  villagesDataSelect
                            if (!isFromVillage) {
                                var villagesDataSelect = $('#villagesDataSelect');

                                // Clear any existing options (if needed)
                                villagesDataSelect.empty();

                                // Add the default "Select Province" option
                                villagesDataSelect.append('<option value="">Select Village</option>');

                                // Populate the select2 dropdown with provinces data
                                data.villages.forEach(function(province) {
                                    villagesDataSelect.append(
                                        $('<option>', {
                                            value: province
                                                .id, // Assuming each province has an 'id'
                                            text: province
                                                .name // Assuming each province has a 'name'
                                        })
                                    );
                                });

                                // Re-initialize the select2 dropdown with the newly added options
                                villagesDataSelect.select2({
                                    placeholder: "Select a village",
                                    allowClear: true,
                                });
                                // Re-initialize the select2 dropdown with the newly added options

                            }

                            // 


                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:',
                                error); // Log error to console if something went wrong
                        }
                    });
                }

                fetchLocation();

                $("#provinceDataSelect").change(function() {
                    // Get the current value of both #provinceDataSelect and #regencyDataSelect
                    var provinceId = $("#provinceDataSelect").val();
                    var regencyId = $("#regencyDataSelect").val();
                    var districtSelect = $('#districtDataSelect').val();
                    var villageSelect = $('#villagesDataSelect').val();

                    // Call the fetchLocation function with both provinceId and regencyId as parameters
                    fetchLocation(provinceId, regencyId, districtSelect);

                    // $("#regencyDataSelect").val(regencyId).trigger('change');
                });
                $("#regencyDataSelect").change(function() {
                    var provinceId = $("#provinceDataSelect").val();
                    var regencyId = $("#regencyDataSelect").val();
                    var districtSelect = $('#districtDataSelect').val();
                    var villageSelect = $('#villagesDataSelect').val();

                    $('#districtDataSelect').empty().append('<option value="">Select District</option>')
                        .trigger('change');
                    $('#villagesDataSelect').empty().append('<option value="">Select Village</option>').trigger(
                        'change');


                    // Call the fetchLocation function with both provinceId and regencyId as parameters
                    fetchLocation(provinceId, regencyId, districtSelect, true);

                });

                $("#districtDataSelect").change(function() {
                    var provinceId = $("#provinceDataSelect").val();
                    var regencyId = $("#regencyDataSelect").val();
                    var districtSelect = $('#districtDataSelect').val();
                    var villageSelect = $('#villagesDataSelect').val();

                    // Call the fetchLocation function with both provinceId and regencyId as parameters
                    fetchLocation(provinceId, regencyId, districtSelect, true, true);

                });


                $(document).on('click', '.note-modal .close', function() {
                    // This will close the Summernote modal (if it's part of the Summernote plugin)
                    $('.note-modal').modal('hide');
                });


                console.log("Initializing Summernote...");

                // Initialize Summernote
                $('#summernote').summernote({
                    height: 300, // Set height of the editor
                    popover: {
                        image: [
                            ['resize', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                            ['float', ['floatLeft', 'floatRight', 'floatNone']],
                            ['remove', ['removeMedia']]
                        ]
                    },
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
