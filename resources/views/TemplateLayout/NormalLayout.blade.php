@extends('Layout.App')

@push('mainTitle')
    @stack('title')
@endpush

@push('css')
    <link href="{{ asset('AdminBS2/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style>
        img {
            max-width: 100%;
        }
    </style>
@endpush

@push('scriptApp')
    @yield('content');

    @stack('script')
@endpush
