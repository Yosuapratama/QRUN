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
      

        <form action="{{route('settings.store')}}" method="POST" class="card">
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
                        $textColors = ['red', 'green', 'blue','cornflowerblue', 'yellow', 'purple', 'black', 'white', 'crimson'];
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
                        <label class="form-label">Disabled After</label>
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
                    <h6 class="m-0 font-weight-bold text-primary">Ads Settings</h6>
                </div>
                <div class="card-body">
                    <div class="slider-container mb-3">
                        <label for="running-text-info" class="slider-label">Turn on Ads ?</label>
                        <input class="slider" name="ads_active" id="running-text-info" type="checkbox" {{$adsSettings->is_active ? 'checked' : ''}}>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ads Title<span class="text-danger">*</span></label>
                        <input required type="text" name="title_ads" value="{{ $adsSettings->title ?? '' }}"
                            class="form-control" placeholder="Enter Title...">
                    </div>
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

        <div class="card mt-3">
            {{-- <form method="POST" enctype="multipart/form-data" id="image-upload" class="dropzone">
                @csrf
                <div class="dz-message">
                    <h3>Click or drag images here to upload</h3>
                </div>
            </form> --}}
        </div>
    </div>

    @push('script')
        <!-- Load Dropzone.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>

        {{-- <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                var myDropzone = new Dropzone("#image-upload", {
                    url: "/your-upload-url", // Your actual upload URL here
                    maxFiles: 1, // Limit to one file
                    maxFilesize: 1, // Max file size in MB
                    acceptedFiles: ".jpeg,.jpg,.png,.gif", // Allowed file types

                    init: function() {
                        // Ensure only one file is uploaded
                        this.on("addedfile", function(file) {
                            if (this.files.length > 1) {
                                this.removeFile(this.files[
                                    0]); // Remove the first file (if more than 1)
                            }
                        });
                        this.on("success", function(file, response) {
                            console.log("File uploaded successfully", file);
                            // Optionally, disable Dropzone once the first file is uploaded
                            myDropzone.disable();
                        });
                        this.on("error", function(file, response) {
                            console.log("Error uploading file", file);
                        });
                    }
                });
            });
        </script> --}}
    @endpush
    <!-- End of Main Content -->
@endsection
