@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Create Place Limit Admin - QRUN Website</title>
    @endpush
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 text-gray-800 font-weight-bold m-2">Create Place Limit</h1>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Create Place Limit Form</h6>
            </div>
            <div class="card-body">
                {{-- Create Place Form --}}
                @if(isset($data))
                    <form action="{{ route('place-limit.update', $data->id) }}" method="POST">
                @else
                    <form action="{{ route('place-limit.store') }}" method="POST">
                @endif
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="title">Title/Name</label>
                        <input class="form-control" value="{{$data->name ?? ''}}" name="name" type="text" id="title"
                            placeholder="Place Title...">
                        @error('name')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label class="form-label" for="total_limit">Total Limit</label>
                        <input class="form-control" value="{{$data->total_limit ?? ''}}" name="total_limit" type="number" id="total_limit"
                            placeholder="Place Description...">
                        @error('total_limit')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror
                    </div>
                  
                    @if(isset($data))
                        <button type="submit" class="btn btn-success btn-md">Update data</button>
                    @else
                        <button type="submit" class="btn btn-success btn-md">Create Place Limit</button>
                    @endif
                </form>
            </div>
        </div>

    </div>
    <!-- End of Main Content -->
@endsection
