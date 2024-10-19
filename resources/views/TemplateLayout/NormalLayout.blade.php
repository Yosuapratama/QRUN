@extends('Layout.App')

@push('mainTitle')
    @stack('title')
@endpush

@push('css')
    <link href="{{ asset('AdminBS2/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
