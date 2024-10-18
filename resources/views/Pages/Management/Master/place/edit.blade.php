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
                        <label class="form-label" for="title">Title</label>
                        <input name="title" class="form-control" value="{{ $Place->title }}" type="text" id="title"
                            placeholder="Place Title...">
                        @error('title')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <input name="description" value="{{ $Place->description }}" class="form-control" type="text"
                            id="description" placeholder="Place Description...">
                        @error('description')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" name="content" id="summernote">{{ $Place->content }}</textarea>
                        @error('content')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror
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

    @push('script')
        <script>
            //Setup SummerNote (Content Textarea Box)
            $(document).ready(function() {
                $("#summernote").summernote({
                    placeholder: 'enter directions here...',
                    height: 300,
                    callbacks: {
                        onImageUpload: function(files, editor, welEditable) {

                            for (var i = files.length - 1; i >= 0; i--) {
                                sendFile(files[i], this);
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
    <!-- End of Main Content -->
@endsection
