@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Edit Place Admin - QRUN Website</title>
    @endpush
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 text-gray-800 font-weight-bold m-2">Edit Place/Object</h1>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Place</h6>
            </div>
            <div class="card-body">
                {{-- Create Place Form --}}
                <form method="POST" action="{{ route('place.update') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $Place->id }}">
                    <div class="mb-3">
                        <label class="form-label" for="title">Title<span class="text-danger">*</span></label>
                        <input required name="title" class="form-control" value="{{ $Place->title }}" type="text"
                            id="title" placeholder="Place Title...">
                        @error('title')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">Description<span class="text-danger">*</span></label>
                        <input required name="description" value="{{ $Place->description }}" class="form-control"
                            type="text" id="description" placeholder="Place Description...">
                        @error('description')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="phoneNum">Contact Person</label>
                        <input class="form-control" value="{{ $Place->phone_num }}" name="phone_num" type="number"
                            id="phoneNum" placeholder="Phone Number References...">
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
                        <textarea required class="form-control" name="content" id="summernote">{{ $Place->content }}</textarea>
                        @error('content')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="slider-container mb-3">
                        <label for="yesno-slider" class="slider-label">Turn on comment ? No / Yes</label>
                        <input name="AllowComment"
                            @if (isset($Place->is_comment)) @if ($Place->is_comment) checked @endif @endif type="checkbox" id="yesno-slider" class="slider">
                    </div>
                    @if ($Place)
                        <button type="submit" class="btn btn-primary btn-md">Update Place</button>
                    @else
                        <button type="submit" class="btn btn-success btn-md">Save Place</button>
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

    @push('script')
        <script>
            // $(document).ready(function() {
            //     $('#summernote').summernote();
            // });

            $(document).ready(function() {
                var isInitedProvince = false;
                var isInitialLoad = true;

                let selectedProvince = "{{ $Place->province_id }}";
                let selectedRegency = "{{ $Place->regency_id }}";
                let selectedDistrict = "{{ $Place->district_id }}";
                let selectedVillage = "{{ $Place->village_id }}";

                console.log("Selected Province: ", selectedProvince);
                console.log("Selected Regency: ", selectedRegency);
                console.log("Selected District: ", selectedDistrict);
                console.log("Selected Village: ", selectedVillage);

                function fetchLocation(
                    province_id = null,
                    regency_id = null,
                    district_id = null,
                    isFromRegency = false,
                    isFromDistrict = false,
                    isFromVillage = false
                ) {
                    $.ajax({
                        url: "{{ route('getLocation') }}",
                        data: {
                            province_id: province_id != null ? province_id : selectedProvince ,
                            regency_id: regency_id != null ? regency_id : selectedRegency ,
                            district_id: district_id != null ? district_id : selectedDistrict ,
                        },
                        method: 'GET',
                        success: function(data) {

                            // Province
                            if (!isInitedProvince) {
                                let provinceSelect = $('#provinceDataSelect');
                                provinceSelect.empty().append('<option value="">Select Province</option>');

                                data.province.forEach(function(province) {
                                    provinceSelect.append(
                                        $('<option>', {
                                            value: province.id,
                                            text: province.name
                                        })
                                    );
                                });

                                provinceSelect.select2({
                                    placeholder: "Select a province",
                                    allowClear: true,
                                });

                                isInitedProvince = true;
                            }

                            // Regency
                            if (!isFromRegency) {
                                let regencySelect = $('#regencyDataSelect');
                                regencySelect.empty().append('<option value="">Select Regency</option>');

                                data.regency.forEach(function(regency) {
                                    regencySelect.append(
                                        $('<option>', {
                                            value: regency.id,
                                            text: regency.name
                                        })
                                    );
                                });

                                regencySelect.select2({
                                    placeholder: "Select a regency",
                                    allowClear: true,
                                });
                            }

                            // District
                            if (!isFromDistrict) {
                                let districtSelect = $('#districtDataSelect');
                                districtSelect.empty().append('<option value="">Select District</option>');

                                data.districts.forEach(function(district) {
                                    districtSelect.append(
                                        $('<option>', {
                                            value: district.id,
                                            text: district.name
                                        })
                                    );
                                });

                                districtSelect.select2({
                                    placeholder: "Select a district",
                                    allowClear: true,
                                });
                            }

                            // Village
                            if (!isFromVillage) {
                                let villageSelect = $('#villagesDataSelect');
                                villageSelect.empty().append('<option value="">Select Village</option>');

                                data.villages.forEach(function(village) {
                                    villageSelect.append(
                                        $('<option>', {
                                            value: village.id,
                                            text: village.name
                                        })
                                    );
                                });

                                villageSelect.select2({
                                    placeholder: "Select a village",
                                    allowClear: true,
                                });
                            }

                            let isInitialLoadStep = 0; // 0: province, 1: regency, 2: district, 3: village

                            // Auto-select default values on edit
                            if (isInitialLoad) {
                                if (selectedProvince) {
                                    $('#provinceDataSelect').val(selectedProvince).trigger('change');
                                }
                                if (selectedRegency) {
                                    $('#regencyDataSelect').val(selectedRegency).trigger('change');
                                }
                                if (selectedDistrict) {
                                    $('#districtDataSelect').val(selectedDistrict).trigger('change');
                                }
                                if (selectedVillage) {
                                    $('#villagesDataSelect').val(selectedVillage).trigger('change');
                                }

                                isInitialLoad = false; // prevent loop
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', error);
                        }
                    });
                }

                // Initial load
                fetchLocation();

                // Province change
                $("#provinceDataSelect").change(function() {
                    if (!isInitialLoad) {
                        console.log("Province changed, fetching regencies...");
                        // isInitialLoad = true; // Reset initial load to prevent loop
                        let provinceId = $(this).val();
                        fetchLocation(provinceId);
                    }
                });

                // Regency change
                $("#regencyDataSelect").change(function() {
                    if (!isInitialLoad) {
                        let provinceId = $("#provinceDataSelect").val();
                        let regencyId = $(this).val();

                        console.log({regId: regencyId, provId: provinceId});
                        fetchLocation(provinceId, regencyId, null, true);
                    }
                });

                // District change
                $("#districtDataSelect").change(function() {
                    if (!isInitialLoad) {
                        let provinceId = $("#provinceDataSelect").val();
                        let regencyId = $("#regencyDataSelect").val();
                        let districtId = $(this).val();
                        fetchLocation(provinceId, regencyId, districtId, true, true);
                    }
                });

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
