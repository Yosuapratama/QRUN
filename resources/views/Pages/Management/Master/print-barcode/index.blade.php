@extends('TemplateLayout.NormalLayout')

@section('content')
    @push('title')
        <title>QRUN - Print Page {{ $place->title }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: {
                                50: '#escript',
                                100: '#dbeafe',
                                500: '#3b82f6',
                                600: '#2563eb',
                                700: '#1d4ed8',
                                900: '#1e3a8a'
                            }
                        }
                    }
                }
            }
        </script>
        <style>
            .collapse {
                visibility: visible !important;
            }
        </style>
    @endpush

    <div class="min-h-screen bg-gray-50 py-8 print:bg-white print:py-4">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8 print:mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2 print:text-2xl">
                    {{ $place->title }}
                </h1>
                <div class="h-1 w-20 bg-blue-600 rounded print:hidden"></div>
            </div>

            <!-- Main Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden print:shadow-none print:border print:border-gray-300">
                <!-- Card Header -->
                <div
                    class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 print:bg-white print:border-b print:border-gray-200">
                    <h2 class="text-xl font-semibold text-white mb-1 print:text-gray-900">
                        {{ $place->title }}
                    </h2>
                    @if ($place->description)
                        <p class="text-blue-100 text-sm print:text-gray-600">
                            {{ $place->description }}
                        </p>
                    @endif
                </div>

                <!-- QR Code Section -->
                <div class="px-6 py-12 print:py-8">
                    <div class="flex flex-col items-center justify-center space-y-6 print:space-y-4">
                        <!-- QR Code Container -->
                        <div
                            class="bg-white p-8 rounded-xl shadow-sm border-2 border-gray-100 print:border-gray-300 print:shadow-none">
                            <div class="flex justify-center">
                                {{ QrCode::size(300)->generate($printUrl) }}
                            </div>
                        </div>

                        <!-- Instructions -->
                        <div class="text-center max-w-md print:max-w-none">
                            <h3 class="text-lg font-medium text-gray-900 mb-2 print:text-base">
                                Scan QR Code
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed print:text-xs">
                                Use your smartphone camera or QR code scanner app to scan this code and access the location
                                information.
                            </p>
                        </div>

                        <!-- URL Display (for print) -->
                        <div class="hidden print:block text-center mt-4">
                            <p class="text-xs text-gray-500 break-all">
                                {{ $printUrl }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Footer Info -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 print:bg-white">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Generated:</span>
                            {{ now()->format('M d, Y \a\t g:i A') }}
                        </div>
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">QRUN System</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Print Instructions (hidden on print) -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4 print:hidden">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Print Instructions</h3>
                        <div class="mt-1 text-sm text-blue-700">
                            <p>This page will automatically print when loaded. For best results:</p>
                            <ul class="list-disc list-inside mt-1 space-y-1">
                                <li>Use portrait orientation</li>
                                <li>Ensure QR code prints clearly</li>
                                <li>Test scan before distributing</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            // Auto-print with a small delay to ensure page is fully loaded
            window.addEventListener('load', function() {
                setTimeout(function() {
                    window.print();
                }, 500);
            });

            // Optional: Close window after printing (uncomment if needed)
            // window.addEventListener('afterprint', function() {
            //     window.close();
            // });
        </script>
    @endpush
@endsection
