<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 - Server Error</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-lg w-full bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-5 sm:p-8">
            <div class="text-center">
                <h1 class="text-9xl font-bold text-gray-200">500</h1>
                <div class="mt-4">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-amber-100 mb-4">
                        <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">Kesalahan Server</h2>
                <p class="text-gray-600 mb-6">Maaf, telah terjadi kesalahan pada server kami. Tim kami sedang bekerja untuk memperbaikinya.</p>
                <div class="flex justify-center">
                    <a href="{{ url('/') }}" class="px-5 py-2 bg-gray-800 hover:bg-gray-700 text-white font-medium rounded-md transition-colors duration-300 inline-flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
