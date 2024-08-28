@extends('TemplateLayout.NormalLayout')

@push('title')
    <title>QRUN - {{ $place->title }}</title>
@endpush

@section('content')
    <div class="container-fluid overflow-x-hidden">
        <!-- Page Heading -->
        <h1 class="h3 text-gray-900 font-weight-bold m-2">DETAIL PLACE</h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Title : {{ $place->title }}</h6>
                <small class="font-weight-bold text-gray-900">{{ $place->description }} | Created At : {{$place->created_at}}</small>
            </div>
            <div class="card-body m-2" style="overflow-x: scroll !important;">
                {!! $place->content !!}
            </div>
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Upcoming Event</h6>
                <small class="font-weight-bold text-gray-900">Next Event</small>
            </div>
            <div class="card-body m-2">
                <div class="d-flex flex-wrap">
                    @foreach ($event as $evnt)
                        <div class="card-header p-2 m-2 rounded text-gray-900 font-weight-bold">
                            <p class="m-0 font-weight-bold text-primary">{{ $evnt->title }}</p>
                            <hr class="sidebar-divider">
                            <p class="font-weight-bold text-gray-900">{{ $evnt->date->format('Y M d | H:i') }} Wita</p>
                            <p></p>
                            <small>{{ $evnt->description }}</small>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

    </div>
@endsection
