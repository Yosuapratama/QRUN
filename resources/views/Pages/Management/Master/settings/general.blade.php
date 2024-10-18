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
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Settings</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-primary">
                    <p>This feature func is to clear cache in this server, if the website lag/not found routing, admin can do this function</p>
                    <a href="{{route('artisan.optimize')}}" class="btn btn-primary">Clear Server Cache (Optimize)</a>
                </div>
              
            </div>
        </div>

    </div>
    <!-- End of Main Content -->
@endsection
