@extends('TemplateLayout.NormalLayout')

@section('content')
@push('title')
    <title>QRUN - Print Page {{$place->title}} </title>
@endpush
<div class="container-fluid overflow-x-hidden">
    <!-- Page Heading -->
    <h1 class="h3 text-gray-900 font-weight-bold m-2">Title : {{ $place->title }}</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Title : {{ $place->title }}</h6>
            <small class="font-weight-bold text-gray-900">{{ $place->description }}</small>
        </div>
        <div class="card-body m-2 d-flex justify-content-center">
            {{ QrCode::size(700)->generate('ABCD') }}
        </div>
    </div>

</div>
@push('script')
<script>
    window.print();
</script>
@endpush

    
@endsection