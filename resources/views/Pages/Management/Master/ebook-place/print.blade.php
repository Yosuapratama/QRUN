@extends('TemplateLayout.NormalLayout')

@section('content')
    @push('title')
        <title>QRUN - Ebook QR {{ $ebookPlace->name }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            .collapse { visibility: visible !important; }
        </style>
    @endpush

    <div class="min-h-screen bg-gray-50 py-8 print:bg-white print:py-4">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8 print:mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2 print:text-2xl">{{ $ebookPlace->name }}</h1>
                <div class="h-1 w-20 bg-blue-600 rounded print:hidden"></div>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden print:shadow-none print:border print:border-gray-300">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 print:bg-white print:border-b print:border-gray-200">
                    <h2 class="text-xl font-semibold text-white mb-1 print:text-gray-900">{{ $ebookPlace->name }}</h2>
                    @if ($ebookPlace->description)
                        <p class="text-blue-100 text-sm print:text-gray-600">{{ $ebookPlace->description }}</p>
                    @endif
                </div>

                <div class="px-6 py-12 print:py-8">
                    <div class="flex flex-col items-center justify-center space-y-6 print:space-y-4">
                        <div class="bg-white p-8 rounded-xl shadow-sm border-2 border-gray-100 print:border-gray-300 print:shadow-none">
                            <div class="flex justify-center">
                                {!! QrCode::size(300)->generate($printUrl) !!}
                            </div>
                        </div>

                        <div class="text-center max-w-md print:max-w-none">
                            <h3 class="text-lg font-medium text-gray-900 mb-2 print:text-base">Scan to Read E-Books</h3>
                            <p class="text-gray-600 text-sm leading-relaxed print:text-xs">
                                Use your smartphone camera to scan this code and browse the e-books available at this location.
                            </p>
                        </div>

                        <div class="hidden print:block text-center mt-4">
                            <p class="text-xs text-gray-500 break-all">{{ $printUrl }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 print:bg-white">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Code:</span> {{ $ebookPlace->code }}
                        </div>
                        <div class="text-sm text-gray-600"><span class="font-medium">QRUN System</span></div>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4 print:hidden">
                <h3 class="text-sm font-medium text-blue-800 mb-1">Print Instructions</h3>
                <ul class="list-disc list-inside text-sm text-blue-700 space-y-1">
                    <li>Use portrait orientation</li>
                    <li>Ensure the QR code prints clearly</li>
                    <li>Test scan before placing it at the location</li>
                </ul>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            window.addEventListener('load', function () {
                setTimeout(function () { window.print(); }, 500);
            });
        </script>
    @endpush
@endsection
