<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Qrun Online - Platform QR Code Sejarah & Informasi Tempat</title>

    <meta name="description"
        content="Qrun Online adalah platform prasasti digital berbasis QR Code yang memungkinkan pengunjung mengakses sejarah, budaya, dokumentasi, dan informasi tempat secara interaktif hanya dengan sekali scan.">
    <meta name="keywords"
        content="
        qrun,
        qrun online,
        login qrun,
        register qrun,
        sign in qrun,
        qr code sejarah,
        prasasti digital,
        digital heritage,
        smart tourism
        ">

    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <meta name="author" content="Qrun Online">

    <link rel="canonical" href="https://www.qrun.online">

    <meta name="theme-color" content="#2d4373">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('transparent-logo.png') }}">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">

    <meta property="og:site_name" content="Qrun Online">

    <meta property="og:title" content="Qrun Online | Scan QR Code untuk Mengakses Sejarah dan Informasi Tempat">

    <meta property="og:description"
        content="Platform prasasti digital berbasis QR Code untuk mengakses sejarah, budaya, dokumentasi, dan informasi tempat secara interaktif.">

    <meta property="og:url" content="https://www.qrun.online">

    <meta property="og:image" content="https://www.qrun.online/home.jpg">

    <meta property="og:image:width" content="1200">

    <meta property="og:image:height" content="630">

    <meta property="og:image:alt" content="Qrun Online - Platform QR Code Sejarah dan Informasi Tempat">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">

    <meta name="twitter:title" content="Qrun Online | Scan QR Code untuk Mengakses Sejarah dan Informasi Tempat">

    <meta name="twitter:description"
        content="Platform prasasti digital berbasis QR Code untuk mengakses sejarah, budaya, dokumentasi, dan informasi tempat secara interaktif.">

    <meta name="twitter:image" content="https://www.qrun.online/home.jpg">

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "Organization",
          "@id": "https://www.qrun.online/#organization",
          "name": "Qrun Online",
          "url": "https://www.qrun.online",
          "logo": {
            "@type": "ImageObject",
            "url": "https://www.qrun.online/transparent-logo.png"
          }
        },
        {
          "@type": "WebSite",
          "@id": "https://www.qrun.online/#website",
          "url": "https://www.qrun.online",
          "name": "Qrun Online",
          "description": "Platform prasasti digital berbasis QR Code untuk mengakses sejarah, budaya, dokumentasi, dan informasi tempat secara interaktif.",
          "publisher": {
            "@id": "https://www.qrun.online/#organization"
          },
          "inLanguage": "id-ID"
        }
      ]
    }
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


    {{-- TOASTR CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    {{-- JQUERY --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    {{-- TOASTR JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <style>
        .toast-success {
            background-color: #28a745 !important;
        }

        .toast-error {
            background-color: #dc3545 !important;
        }

        .toast-info {
            background-color: #17a2b8 !important;
        }

        .toast-warning {
            background-color: #ffc107 !important;
            color: #000 !important;
        }

        .toast {
            opacity: 1 !important;
        }

        .carousel-container {
            overflow: hidden;
        }

        .carousel-track {
            display: flex;
            transition: transform 0.3s ease;
        }

        .carousel-item {
            min-width: 100%;
        }

        @media (min-width: 640px) {
            .carousel-item {
                min-width: 50%;
            }
        }

        @media (min-width: 1024px) {
            .carousel-item {
                min-width: 25%;
            }
        }
    </style>
</head>

<body class="bg-gray-50">
    @include('Components.Navbar')


    {{-- VALIDATION ERRORS --}}
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                @foreach ($errors->all() as $error)
                    toastr.error(@json($error), 'Error');
                @endforeach

            });
        </script>
    @endif

    {{-- STATUS SUCCESS --}}
    @if (session()->has('status'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                toastr.success(@json(session('status')), 'Success');

            });
        </script>
    @endif

    {{-- SUCCESS --}}
    @if (session()->has('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                toastr.success(@json(session('success')), 'Success');

            });
        </script>
    @endif
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-50 to-indigo-100 py-12 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col-reverse lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                <div class="mb-8 lg:mb-0">
                    <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6 mt-4 lg:mt-0 md:mt-1">
                        Melestarikan Warisan Budaya
                        Lewat Teknologi QR Code
                    </h1>
                    <p class="text-lg text-gray-600 mb-8">
                        Qrun membantu pengunjung memahami sejarah tempat dengan pengalaman digital yang modern dan
                        interaktif.
                    </p>
                    <div class="space-x-4">
                        <a href="{{ route('login') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium inline-block">Mulai
                            Sekarang</a>
                        <a href="{{ route('blog') }}"
                            class="border border-gray-300 hover:border-gray-400 text-gray-700 px-6 py-3 rounded-lg font-medium inline-block">Lihat
                            Blog</a>
                    </div>
                </div>
                <div class="lg:text-right">
                    <img src="{{ asset('home.jpg') }}" alt="Hero Image"
                        class="w-full max-w-md mx-auto lg:max-w-lg rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </section>
    <!-- Video Section -->
    <section class="py-8 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="relative bg-gray-900 rounded-lg overflow-hidden shadow-xl">
                <div class="aspect-w-16 aspect-h-9">
                    {{-- <iframe width="100%" height="400px"
                        src="https://www.youtube.com/embed/W5IUwH-tk8g?si=_2OtIl56GzFtULGh" title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> --}}

                    <iframe width="100%" height="400px"
                        src="https://www.youtube.com/embed/cwQX8Ov0A_M?si=RdtQLg3E1EPhuCf9" title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision Mission Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="text-center mb-14">
                <span
                    class="inline-flex items-center px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold mb-4">
                    <i class="fas fa-landmark mr-2"></i>
                    Tentang Qrun Online
                </span>

                <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 mb-4">
                    Melestarikan Sejarah dan Budaya dengan Teknologi
                </h2>

                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Qrun Online hadir untuk membantu masyarakat mengakses informasi sejarah,
                    budaya, dan warisan Indonesia secara lebih interaktif melalui teknologi
                    QR Code.
                </p>
            </div>

            <!-- Vision -->
            <div
                class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-8 lg:p-12 shadow-xl mb-10 text-white">
                <div class="flex items-start gap-4">
                    <div class="bg-white/20 p-4 rounded-2xl">
                        <i class="fas fa-eye text-3xl"></i>
                    </div>

                    <div>
                        <h3 class="text-2xl font-bold mb-4">
                            Visi Kami
                        </h3>

                        <p class="text-lg text-blue-100 leading-relaxed">
                            Menjadi sumber informasi terpercaya dan interaktif tentang sejarah
                            pura dan candi di Indonesia, sehingga meningkatkan kesadaran
                            dan apresiasi masyarakat terhadap warisan budaya.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Mission -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">

                <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100">
                    <div class="flex items-center mb-6">
                        <div class="bg-blue-100 text-blue-600 p-3 rounded-xl mr-4">
                            <i class="fas fa-bullseye text-xl"></i>
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900">
                            Misi Kami
                        </h3>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <span
                                class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-bold mr-3 shrink-0">1</span>
                            <p class="text-gray-600">
                                Menyediakan informasi akurat dan menarik tentang sejarah pura dan candi melalui QR Code.
                            </p>
                        </div>

                        <div class="flex items-start">
                            <span
                                class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-bold mr-3 shrink-0">2</span>
                            <p class="text-gray-600">
                                Meningkatkan kesadaran masyarakat terhadap warisan budaya Indonesia.
                            </p>
                        </div>

                        <div class="flex items-start">
                            <span
                                class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-bold mr-3 shrink-0">3</span>
                            <p class="text-gray-600">
                                Membuat pengalaman belajar sejarah menjadi interaktif dan menyenangkan.
                            </p>
                        </div>

                        <div class="flex items-start">
                            <span
                                class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-bold mr-3 shrink-0">4</span>
                            <p class="text-gray-600">
                                Membangun komunitas yang peduli terhadap warisan budaya Indonesia.
                            </p>
                        </div>

                        <div class="flex items-start">
                            <span
                                class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-bold mr-3 shrink-0">5</span>
                            <p class="text-gray-600">
                                Menjalin kerja sama dengan instansi terkait untuk meningkatkan kualitas layanan.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Core Values -->
                <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100">
                    <div class="flex items-center mb-6">
                        <div class="bg-green-100 text-green-600 p-3 rounded-xl mr-4">
                            <i class="fas fa-gem text-xl"></i>
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900">
                            Nilai Inti
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 gap-4">

                        <div class="bg-white p-4 rounded-2xl border">
                            <h4 class="font-semibold text-gray-900 mb-1">
                                Informasi Berkualitas
                            </h4>
                            <p class="text-sm text-gray-600">
                                Menyajikan informasi sejarah yang akurat dan menarik.
                            </p>
                        </div>

                        <div class="bg-white p-4 rounded-2xl border">
                            <h4 class="font-semibold text-gray-900 mb-1">
                                Inovasi Digital
                            </h4>
                            <p class="text-sm text-gray-600">
                                Menggunakan teknologi untuk pengalaman belajar yang modern.
                            </p>
                        </div>

                        <div class="bg-white p-4 rounded-2xl border">
                            <h4 class="font-semibold text-gray-900 mb-1">
                                Pelestarian Budaya
                            </h4>
                            <p class="text-sm text-gray-600">
                                Mendukung pelestarian warisan budaya Indonesia.
                            </p>
                        </div>

                        <div class="bg-white p-4 rounded-2xl border">
                            <h4 class="font-semibold text-gray-900 mb-1">
                                Kolaborasi
                            </h4>
                            <p class="text-sm text-gray-600">
                                Bekerja sama dengan komunitas dan instansi terkait.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="rounded-3xl bg-gradient-to-r from-gray-900 to-gray-800 p-10 text-center text-white shadow-xl">
                <h3 class="text-2xl lg:text-3xl font-bold mb-4">
                    Bersama Melestarikan Warisan Budaya Indonesia
                </h3>

                <p class="text-gray-300 max-w-2xl mx-auto mb-6">
                    Jadilah bagian dari transformasi digital sejarah dan budaya Indonesia
                    melalui teknologi QR Code yang interaktif.
                </p>

                <a href="{{ route('login') }}"
                    class="inline-flex items-center bg-white text-gray-900 px-8 py-4 rounded-xl font-semibold hover:shadow-lg transition">
                    Mulai Sekarang
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

        </div>
    </section>

    <!-- Carousel Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Mengapa harus menggunakan kami?
                </h2>
                <p class="text-lg text-gray-600">
                    Temukan alasan mengapa ratusan pengguna memilih platform kami
                </p>
            </div>

            <div class="carousel-container relative">
                <div class="carousel-track" id="carouselTrack">
                    <!-- Card 1 -->
                    <div class="carousel-item px-3">
                        <div class="bg-white rounded-lg shadow-lg p-6 h-full">
                            <img src="{{ asset('home.jpg') }}" alt="Feature 1"
                                class="w-full h-48 object-cover rounded-lg mb-4">
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Digunakan Di Banyak Tempat</h3>
                            <p class="text-gray-600">Dengan ini, banyak tempat bisa dipermudah untuk mengenal sejarah
                                atau informasinya.</p>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="carousel-item px-3">
                        <div class="bg-white rounded-lg shadow-lg p-6 h-full">
                            <img src="{{ asset('sample-image1.jpg') }}" alt="Feature 1"
                                class="w-full h-48 object-cover rounded-lg mb-4">
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">100+ Pengguna</h3>
                            <p class="text-gray-600">Bergabung dengan komunitas yang aktif dan saling mendukung untuk
                                berkembang bersama.</p>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="carousel-item px-3">
                        <div class="bg-white rounded-lg shadow-lg p-6 h-full">
                            <img src="{{ asset('sample-image2.png') }}" alt="Feature 3"
                                class="w-full h-48 object-cover rounded-lg mb-4">
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Sudah Terpasang di banyak tempat</h3>
                            <p class="text-gray-600">Beberapa tempat sudah dipasang QR secara langsung dan sudah mulai
                                digunakan dan diakses masyarakat.</p>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="carousel-item px-3">
                        <div class="bg-white rounded-lg shadow-lg p-6 h-full">
                            <img src="{{ asset('sample-image3.png') }}" alt="Feature 4"
                                class="w-full h-48 object-cover rounded-lg mb-4">
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Keamanan Terjamin</h3>
                            <p class="text-gray-600">Data dan konten Anda aman dengan sistem keamanan yang mumpuni dan
                                backup otomatis.</p>
                        </div>
                    </div>

                </div>

                <!-- Carousel Controls -->
                <button
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white shadow-lg rounded-full p-2 hover:bg-gray-50"
                    id="prevBtn">
                    <i class="fas fa-chevron-left text-gray-600"></i>
                </button>
                <button
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white shadow-lg rounded-full p-2 hover:bg-gray-50"
                    id="nextBtn">
                    <i class="fas fa-chevron-right text-gray-600"></i>
                </button>
            </div>
        </div>
    </section>


    <!-- Video Section -->
    <section class="py-10 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                Cara Penggunaan Website
            </h2>
            <p class="text-lg text-gray-600 mb-8">
                Pelajari bagaimana menggunakan platform kami dalam video tutorial singkat ini
            </p>
            <div class="relative bg-gray-900 rounded-lg overflow-hidden shadow-xl">
                <div class="aspect-w-16 aspect-h-9">
                    <iframe width="100%" height="400px"
                        src="https://www.youtube.com/embed/W5IUwH-tk8g?si=_2OtIl56GzFtULGh"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Analytics Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-purple-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">
                    Statistik Platform
                </h2>
                <p class="text-lg text-blue-100">
                    Lihat pencapaian dan aktivitas terkini di platform kami
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Tempat -->
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-lg p-6 text-center">
                    @php
                        $placeCount = \App\Helpers\SidebarHelper::getPlaceCount();
                    @endphp
                    <div class="text-3xl lg:text-4xl font-bold text-white mb-2" id="totalTempat">{{ $placeCount }}
                    </div>
                    <div class="text-blue-100 font-medium">Total Tempat</div>
                </div>

                <!-- Total Event Semua -->
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-lg p-6 text-center">
                    @php
                        $eventCount = \App\Helpers\SidebarHelper::getEventCount();
                    @endphp

                    <div class="text-3xl lg:text-4xl font-bold text-white mb-2" id="totalEventSemua">
                        {{ $eventCount }}
                    </div>
                    <div class="text-blue-100 font-medium">Total Event</div>
                </div>

                <!-- Event Berjalan -->
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-lg p-6 text-center">
                    @php
                        $eventActiveCount = \App\Helpers\SidebarHelper::getEventActiveCount();
                    @endphp

                    <div class="text-3xl lg:text-4xl font-bold text-white mb-2" id="eventBerjalan">
                        {{ $eventActiveCount }}</div>
                    <div class="text-blue-100 font-medium">Event Berjalan</div>
                    <div class="text-xs text-blue-200 mt-1">Sedang Aktif</div>
                </div>

                <!-- Total Users -->
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-lg p-6 text-center">
                    @php
                        $activeUser = \App\Helpers\SidebarHelper::getActiveUser();
                    @endphp

                    <div class="text-3xl lg:text-4xl font-bold text-white mb-2">{{ $activeUser }}</div>
                    <div class="text-blue-100 font-medium">Total Users</div>
                </div>
            </div>

            <!-- Event Status Detail -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-1 gap-6">
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-lg p-6 text-center">
                    @php
                        $endedEvent = \App\Helpers\SidebarHelper::getEndedEvent();
                    @endphp

                    <div class="text-2xl lg:text-3xl font-bold text-green-300 mb-2" id="eventBerakhir">
                        {{ $endedEvent }}</div>
                    <div class="text-blue-100 font-medium">Event Berakhir</div>
                    <div class="text-xs text-blue-200 mt-1">Sudah Selesai</div>
                </div>

            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Galeri Kami
                </h2>
                <p class="text-lg text-gray-600">
                    Jelajahi koleksi gallery kami.
                </p>
            </div>

            <div id="gallery-grid" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            </div>
            <div class="flex justify-center mt-4">
                <button id="load-more" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Load
                    More</button>
            </div>

        </div>
    </section>

    <!-- Recent Blog Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Blog Terbaru
                </h2>
                <p class="text-lg text-gray-600">
                    Baca artikel terbaru dari komunitas Admin kami
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Blog Post 1 -->
                @forelse ($blogs as $blog)
                    <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <img src="{{ asset($blog->image_url) }}" alt="Blog Post 1" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <span>
                                    {{-- format this date --}}
                                    {{ $blog->created_at }}
                                </span>
                                <span class="mx-2">•</span>
                                <i class="fas fa-user mr-2"></i>
                                <span>Admin</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3 hover:text-blue-600">
                                <a href="/blog/{{ $blog->slug }}">{{ $blog->title }}</a>
                            </h3>
                            <p class="text-gray-600 mb-4">
                                {{ $blog->description }}
                            </p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span><i class="fas fa-eye mr-1"></i>
                                        @php
                                            $num = $blog->views;
                                            $formatted = $num < 1000 ? $num : number_format($num / 1000, 1) . 'K';
                                        @endphp
                                        {{ $formatted }}
                                    </span>
                                    {{-- <span><i class="fas fa-heart mr-1"></i> 89</span>
                                    <span><i class="fas fa-comment mr-1"></i> 23</span> --}}
                                </div>
                                <a href="/blog/{{ $blog->slug }}"
                                    class="text-blue-600 hover:text-blue-700 font-medium">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-12 px-4">
                        <div class="text-center">
                            <i class="fas fa-newspaper text-4xl text-gray-300 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak Ada Artikel Terkait</h3>
                            <p class="text-gray-500">Belum ada artikel lain yang tersedia saat ini.</p>
                        </div>
                    </div>
                @endforelse

            </div>

            <div class="text-center mt-12">
                <a href="{{ route('blog') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-medium inline-flex items-center">
                    Lihat Semua Blog <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Modal for Image Preview -->
    <div id="imageModal"
        class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <div class="relative max-w-4xl max-h-full">
            <button id="closeModal" class="absolute -top-10 right-0 text-white hover:text-gray-300 text-2xl">
                <i class="fas fa-times"></i>
            </button>
            <img id="modalImage" src="/placeholder.svg" alt=""
                class="max-w-full max-h-[80vh] object-contain rounded-lg">
            <div class="text-center mt-4">
                <h3 id="modalTitle" class="text-white text-xl font-semibold"></h3>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('Components.FooterHome')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Analytics Counter Animation
        function animateCounter(elementId, targetValue, duration = 2000) {
            const element = document.getElementById(elementId);
            const startValue = 0;
            const increment = targetValue / (duration / 16);
            let currentValue = startValue;

            const timer = setInterval(() => {
                currentValue += increment;
                if (currentValue >= targetValue) {
                    element.textContent = Math.floor(targetValue);
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(currentValue);
                }
            }, 16);
        }

        // Initialize analytics counters when page loads
        window.addEventListener('load', () => {
            animateCounter('totalTempat', {{ $placeCount }});
            animateCounter('totalEventSemua', {{ $eventCount }});
            animateCounter('eventBerjalan', {{ $eventActiveCount }});
            animateCounter('eventBerakhir', {{ $endedEvent }});
            // animateCounter('eventMendatang', 21);
        });

        // Gallery Modal Functionality
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modalTitle');
        const closeModal = document.getElementById('closeModal');
        const galleryItems = document.querySelectorAll('.gallery-item');

        // Open modal when gallery item is clicked
        document.addEventListener('click', function(e) {
            const item = e.target.closest('.gallery-item');
            if (item) {
                const imageSrc = item.getAttribute('data-image');
                const imageTitle = item.getAttribute('data-title');
                modalImage.src = imageSrc;
                modalTitle.textContent = imageTitle;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        });

        // Close modal functionality
        function closeImageModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore scrolling
        }

        closeModal.addEventListener('click', closeImageModal);

        // Close modal when clicking outside the image
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeImageModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeImageModal();
            }
        });

        // Carousel functionality
        const track = document.getElementById('carouselTrack');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let currentIndex = 0;

        function getItemsPerView() {
            if (window.innerWidth >= 1024) return 4; // Desktop
            if (window.innerWidth >= 640) return 2; // Tablet
            return 1; // Mobile
        }

        function updateCarousel() {
            const itemsPerView = getItemsPerView();
            const totalItems = track.children.length;
            const maxIndex = Math.max(0, totalItems - itemsPerView);

            if (currentIndex > maxIndex) {
                currentIndex = maxIndex;
            }

            const translateX = -(currentIndex * (100 / itemsPerView));
            track.style.transform = `translateX(${translateX}%)`;
        }

        prevBtn.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateCarousel();
            }
        });

        nextBtn.addEventListener('click', () => {
            const itemsPerView = getItemsPerView();
            const totalItems = track.children.length;
            const maxIndex = Math.max(0, totalItems - itemsPerView);

            if (currentIndex < maxIndex) {
                currentIndex++;
                updateCarousel();
            }
        });

        // Update carousel on window resize
        window.addEventListener('resize', updateCarousel);

        // Initialize carousel
        updateCarousel();

        let page = 1;
        let loading = false;

        function renderGalleryItem(item) {
            return `
        <div class="bg-gray-100 rounded-lg p-4 hover:shadow-lg transition-shadow cursor-pointer gallery-item"
            data-image="${item.image_url}" data-title="${item.title}">
            <img src="${item.image_url}" alt="${item.title}" class="w-full h-16 object-contain mx-auto">
            <p class="text-xs text-gray-600 mt-2 text-center">${item.title}</p>
        </div>
    `;
        }

        function loadGallery() {
            if (loading) return;
            loading = true;
            $('#load-more').prop('disabled', true).text('Loading...');

            $.get("{{ route('gallery.ajax-list') }}", {
                page: page
            }, function(res) {
                if (res.data && res.data.length > 0) {
                    res.data.forEach(item => {
                        $('#gallery-grid').append(renderGalleryItem(item));
                    });
                    if (res.next_page) {
                        page = res.next_page;
                        $('#load-more').show().prop('disabled', false).text('Load More');
                    } else {
                        $('#load-more').hide();
                    }
                } else if (page === 1) {
                    // Show empty state if no data on first load
                    $('#gallery-grid').html(`
                <div class="col-span-full flex flex-col items-center justify-center py-12 px-4">
                    <div class="text-center">
                        <i class="fas fa-images text-4xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak Ada Gallery</h3>
                        <p class="text-gray-500">Belum ada gallery yang tersedia saat ini.</p>
                    </div>
                </div>
            `);
                    $('#load-more').hide();
                }
                loading = false;
            });
        }

        $(document).ready(function() {
            loadGallery();
            $('#load-more').on('click', function() {
                loadGallery();
            });
        });
    </script>
</body>

</html>
