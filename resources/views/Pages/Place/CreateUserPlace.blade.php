@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Create My Place Admin - QRUN Website</title>
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
        @if ($Place)
            <a href="{{ $url }}" target="_blank" class="btn btn-primary m-2">Visit Your Live Preview</a>
            <a href="{{$printUrl}}" target="_blank" class="btn btn-success m-2">Print Barcode</a>
        @endif

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Create My Place</h6>
            </div>
            <div class="card-body">
                {{-- Create Place Form --}}
                @if ($Place)
                    <form method="POST" action="{{ route('place.update') }}">
                    @else
                        <form action="{{ route('place.store') }}" method="POST">
                @endif
                @csrf
                <input type="hidden" value="{{ $Place ? $Place->id : '' }}">
                <div class="mb-3">
                    <label class="form-label" for="title">Title</label>
                    <input class="form-control" value="{{ $Place ? $Place->title : '' }}" name="title" type="text"
                        id="title" placeholder="Place Title...">
                    @error('title')
                        <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="description">Description</label>
                    <input value="{{ $Place ? $Place->description : '' }}" class="form-control" name="description"
                        type="text" id="description" placeholder="Place Description...">
                    @error('description')
                        <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <textarea class="form-control" name="content" id="summernote">{{ $Place ? $Place->content : '' }}</textarea>
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
                $('#summernote').summernote({
                    tabsize: 2,
                    height: 300
                });
            });
        </script>
    @endpush
    <!-- End of Main Content -->
@endsection
