<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage | Qrun Website</title>
        <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="description" content="QRUN aims to display detailed information when QR codes placed in various locations are scanned.">
    <meta name="keywords" content="qrun,qrun online, login qrun, login qrun online, sign in qrun, sign in qrun online, register qrun online,register qrun">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <style>
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
    <!-- Navbar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{route('homes')}}" class="text-xl font-bold text-gray-800">Qrun Online</a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="index.html" class="text-blue-600 hover:text-blue-700 px-3 py-2 rounded-md text-sm font-medium">Beranda</a>
                        <a href="blog.html" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Blog</a>
                        {{-- <a href="#" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Tentang</a> --}}
                        <a href="contact.html" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Kontak</a>
                    </div>
                </div>
                
                <!-- Login/Register Buttons -->
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6 space-x-3">
                        <a href="#" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">Register</a>
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="mobile-menu-button bg-gray-200 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div class="mobile-menu hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t">
                <a href="index.html" class="text-blue-600 hover:text-blue-700 block px-3 py-2 rounded-md text-base font-medium">Beranda</a>
                <a href="blog.html" class="text-gray-600 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Blog</a>
                {{-- <a href="#" class="text-gray-600 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Tentang</a> --}}
                <a href="contact.html" class="text-gray-600 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Kontak</a>
                <div class="border-t pt-3 mt-3">
                    <a href="#" class="text-gray-600 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Login</a>
                    <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white block px-3 py-2 rounded-md text-base font-medium">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-50 to-indigo-100 py-12 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col-reverse lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                <div class="mb-8 lg:mb-0">
                    <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">
                        Ciptakan tempat pertama mu disini!
                    </h1>
                    <p class="text-lg text-gray-600 mb-8">
                        Bergabunglah dengan komunitas kami dan mulai berbagi cerita Anda dengan dunia. Platform yang mudah digunakan untuk semua kalangan.
                    </p>
                    <div class="space-x-4">
                        <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium inline-block">Mulai Sekarang</a>
                        <a href="blog.html" class="border border-gray-300 hover:border-gray-400 text-gray-700 px-6 py-3 rounded-lg font-medium inline-block">Lihat Blog</a>
                    </div>
                </div>
                <div class="lg:text-right">
                    <img src="{{asset('home.jpg')}}" alt="Hero Image" class="w-full max-w-md mx-auto lg:max-w-lg rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Video Section -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                Cara Penggunaan Website
            </h2>
            <p class="text-lg text-gray-600 mb-8">
                Pelajari bagaimana menggunakan platform kami dalam video tutorial singkat ini
            </p>
            <div class="relative bg-gray-900 rounded-lg overflow-hidden shadow-xl">
                <div class="aspect-w-16 aspect-h-9">
                    <video class="w-full h-64 lg:h-96 object-cover" controls poster="/placeholder.svg?height=400&width=700">
                        <source src="#" type="video/mp4">
                        Browser Anda tidak mendukung video HTML5.
                    </video>
                </div>
                <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
                    <button class="bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full p-4 transition-all">
                        <i class="fas fa-play text-white text-2xl ml-1"></i>
                    </button>
                </div>
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
                            <img src="{{asset('home.jpg')}}" alt="Feature 1" class="w-full h-48 object-cover rounded-lg mb-4">
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Digunakan Di Banyak Tempat</h3>
                            <p class="text-gray-600">Dengan ini, banyak tempat bisa dipermudah untuk mengenal sejarah atau informasinya.</p>
                        </div>
                    </div>
                    
                    <!-- Card 2 -->
                    <div class="carousel-item px-3">
                        <div class="bg-white rounded-lg shadow-lg p-6 h-full">
                            <img src="{{asset('sample-image1.jpg')}}" alt="Feature 1" class="w-full h-48 object-cover rounded-lg mb-4">
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">100+ Pengguna</h3>
                            <p class="text-gray-600">Bergabung dengan komunitas yang aktif dan saling mendukung untuk berkembang bersama.</p>
                        </div>
                    </div>
                    
                    <!-- Card 3 -->
                    <div class="carousel-item px-3">
                        <div class="bg-white rounded-lg shadow-lg p-6 h-full">
                            <img src="{{asset('sample-image2.png')}}" alt="Feature 3" class="w-full h-48 object-cover rounded-lg mb-4">
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Sudah Terpasang di banyak tempat</h3>
                            <p class="text-gray-600">Beberapa tempat sudah dipasang QR secara langsung dan sudah mulai digunakan dan diakses masyarakat.</p>
                        </div>
                    </div>
                    
                    <!-- Card 4 -->
                    <div class="carousel-item px-3">
                        <div class="bg-white rounded-lg shadow-lg p-6 h-full">
                            <img src="{{asset('sample-image3.png')}}" alt="Feature 4" class="w-full h-48 object-cover rounded-lg mb-4">
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Keamanan Terjamin</h3>
                            <p class="text-gray-600">Data dan konten Anda aman dengan sistem keamanan yang mumpuni dan backup otomatis.</p>
                        </div>
                    </div>
                    
                </div>
                
                <!-- Carousel Controls -->
                <button class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white shadow-lg rounded-full p-2 hover:bg-gray-50" id="prevBtn">
                    <i class="fas fa-chevron-left text-gray-600"></i>
                </button>
                <button class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white shadow-lg rounded-full p-2 hover:bg-gray-50" id="nextBtn">
                    <i class="fas fa-chevron-right text-gray-600"></i>
                </button>
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
                    <div class="text-3xl lg:text-4xl font-bold text-white mb-2" id="totalTempat">{{$placeCount}}</div>
                    <div class="text-blue-100 font-medium">Total Tempat</div>
                </div>
                
                <!-- Total Event Semua -->
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-lg p-6 text-center">
                    @php
                        $eventCount = \App\Helpers\SidebarHelper::getEventCount();    
                    @endphp

                    <div class="text-3xl lg:text-4xl font-bold text-white mb-2" id="totalEventSemua">{{$eventCount}}</div>
                    <div class="text-blue-100 font-medium">Total Event</div>
                </div>
                
                <!-- Event Berjalan -->
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-lg p-6 text-center">
                    @php
                        $eventActiveCount = \App\Helpers\SidebarHelper::getEventActiveCount();    
                    @endphp

                    <div class="text-3xl lg:text-4xl font-bold text-white mb-2" id="eventBerjalan">{{$eventActiveCount}}</div>
                    <div class="text-blue-100 font-medium">Event Berjalan</div>
                    <div class="text-xs text-blue-200 mt-1">Sedang Aktif</div>
                </div>
                
                <!-- Total Users -->
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-lg p-6 text-center">
                    @php
                        $activeUser = \App\Helpers\SidebarHelper::getActiveUser();    
                    @endphp

                    <div class="text-3xl lg:text-4xl font-bold text-white mb-2">{{$activeUser}}</div>
                    <div class="text-blue-100 font-medium">Total Users</div>
                </div>
            </div>
            
            <!-- Event Status Detail -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-1 gap-6">
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-lg p-6 text-center">
                    @php
                        $endedEvent = \App\Helpers\SidebarHelper::getEndedEvent();    
                    @endphp

                    <div class="text-2xl lg:text-3xl font-bold text-green-300 mb-2" id="eventBerakhir">{{$endedEvent}}</div>
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
                    Galeri Inspirasi
                </h2>
                <p class="text-lg text-gray-600">
                    Lihat berbagai template dan desain yang tersedia
                </p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <div class="bg-gray-100 rounded-lg p-4 hover:shadow-lg transition-shadow cursor-pointer gallery-item" data-image="/placeholder.svg?height=400&width=400" data-title="Template Modern">
                    <img src="/placeholder.svg?height=80&width=80" alt="Template Modern" class="w-full h-16 object-contain mx-auto">
                    <p class="text-xs text-gray-600 mt-2 text-center">Template Modern</p>
                </div>
                <div class="bg-gray-100 rounded-lg p-4 hover:shadow-lg transition-shadow cursor-pointer gallery-item" data-image="/placeholder.svg?height=400&width=400" data-title="Design Minimalis">
                    <img src="/placeholder.svg?height=80&width=80" alt="Design Minimalis" class="w-full h-16 object-contain mx-auto">
                    <p class="text-xs text-gray-600 mt-2 text-center">Design Minimalis</p>
                </div>
                <div class="bg-gray-100 rounded-lg p-4 hover:shadow-lg transition-shadow cursor-pointer gallery-item" data-image="/placeholder.svg?height=400&width=400" data-title="Layout Kreatif">
                    <img src="/placeholder.svg?height=80&width=80" alt="Layout Kreatif" class="w-full h-16 object-contain mx-auto">
                    <p class="text-xs text-gray-600 mt-2 text-center">Layout Kreatif</p>
                </div>
                <div class="bg-gray-100 rounded-lg p-4 hover:shadow-lg transition-shadow cursor-pointer gallery-item" data-image="/placeholder.svg?height=400&width=400" data-title="Style Elegant">
                    <img src="/placeholder.svg?height=80&width=80" alt="Style Elegant" class="w-full h-16 object-contain mx-auto">
                    <p class="text-xs text-gray-600 mt-2 text-center">Style Elegant</p>
                </div>
                <div class="bg-gray-100 rounded-lg p-4 hover:shadow-lg transition-shadow cursor-pointer gallery-item" data-image="/placeholder.svg?height=400&width=400" data-title="Theme Professional">
                    <img src="/placeholder.svg?height=80&width=80" alt="Theme Professional" class="w-full h-16 object-contain mx-auto">
                    <p class="text-xs text-gray-600 mt-2 text-center">Theme Professional</p>
                </div>
                <div class="bg-gray-100 rounded-lg p-4 hover:shadow-lg transition-shadow cursor-pointer gallery-item" data-image="/placeholder.svg?height=400&width=400" data-title="Design Colorful">
                    <img src="/placeholder.svg?height=80&width=80" alt="Design Colorful" class="w-full h-16 object-contain mx-auto">
                    <p class="text-xs text-gray-600 mt-2 text-center">Design Colorful</p>
                </div>
                <div class="bg-gray-100 rounded-lg p-4 hover:shadow-lg transition-shadow cursor-pointer gallery-item" data-image="/placeholder.svg?height=400&width=400" data-title="Layout Responsive">
                    <img src="/placeholder.svg?height=80&width=80" alt="Layout Responsive" class="w-full h-16 object-contain mx-auto">
                    <p class="text-xs text-gray-600 mt-2 text-center">Layout Responsive</p>
                </div>
                <div class="bg-gray-100 rounded-lg p-4 hover:shadow-lg transition-shadow cursor-pointer gallery-item" data-image="/placeholder.svg?height=400&width=400" data-title="Style Corporate">
                    <img src="/placeholder.svg?height=80&width=80" alt="Style Corporate" class="w-full h-16 object-contain mx-auto">
                    <p class="text-xs text-gray-600 mt-2 text-center">Style Corporate</p>
                </div>
                <div class="bg-gray-100 rounded-lg p-4 hover:shadow-lg transition-shadow cursor-pointer gallery-item" data-image="/placeholder.svg?height=400&width=400" data-title="Design Creative">
                    <img src="/placeholder.svg?height=80&width=80" alt="Design Creative" class="w-full h-16 object-contain mx-auto">
                    <p class="text-xs text-gray-600 mt-2 text-center">Design Creative</p>
                </div>
                <div class="bg-gray-100 rounded-lg p-4 hover:shadow-lg transition-shadow cursor-pointer gallery-item" data-image="/placeholder.svg?height=400&width=400" data-title="Template Clean">
                    <img src="/placeholder.svg?height=80&width=80" alt="Template Clean" class="w-full h-16 object-contain mx-auto">
                    <p class="text-xs text-gray-600 mt-2 text-center">Template Clean</p>
                </div>
                <div class="bg-gray-100 rounded-lg p-4 hover:shadow-lg transition-shadow cursor-pointer gallery-item" data-image="/placeholder.svg?height=400&width=400" data-title="Style Artistic">
                    <img src="/placeholder.svg?height=80&width=80" alt="Style Artistic" class="w-full h-16 object-contain mx-auto">
                    <p class="text-xs text-gray-600 mt-2 text-center">Style Artistic</p>
                </div>
                <div class="bg-gray-100 rounded-lg p-4 hover:shadow-lg transition-shadow cursor-pointer gallery-item" data-image="/placeholder.svg?height=400&width=400" data-title="Design Premium">
                    <img src="/placeholder.svg?height=80&width=80" alt="Design Premium" class="w-full h-16 object-contain mx-auto">
                    <p class="text-xs text-gray-600 mt-2 text-center">Design Premium</p>
                </div>
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
                <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <img src="/placeholder.svg?height=200&width=400" alt="Blog Post 1" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <span>15 Januari 2024</span>
                            <span class="mx-2">•</span>
                            <i class="fas fa-user mr-2"></i>
                            <span>Admin</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3 hover:text-blue-600">
                            <a href="blog-detail.html">Tips Memulai Blog untuk Pemula</a>
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Panduan lengkap untuk memulai perjalanan blogging Anda. Dari memilih niche hingga menulis konten yang menarik...
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span><i class="fas fa-eye mr-1"></i> 1.2k</span>
                                <span><i class="fas fa-heart mr-1"></i> 89</span>
                                <span><i class="fas fa-comment mr-1"></i> 23</span>
                            </div>
                            <a href="blog-detail.html" class="text-blue-600 hover:text-blue-700 font-medium">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </article>

                <!-- Blog Post 2 -->
                <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <img src="/placeholder.svg?height=200&width=400" alt="Blog Post 2" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <span>12 Januari 2024</span>
                            <span class="mx-2">•</span>
                            <i class="fas fa-user mr-2"></i>
                            <span>Sarah</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3 hover:text-blue-600">
                            <a href="blog-detail.html">Strategi SEO untuk Blog di 2024</a>
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Pelajari teknik SEO terbaru yang akan membantu blog Anda mendapat ranking tinggi di mesin pencari...
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span><i class="fas fa-eye mr-1"></i> 2.1k</span>
                                <span><i class="fas fa-heart mr-1"></i> 156</span>
                                <span><i class="fas fa-comment mr-1"></i> 45</span>
                            </div>
                            <a href="blog-detail.html" class="text-blue-600 hover:text-blue-700 font-medium">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </article>

                <!-- Blog Post 3 -->
                <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <img src="/placeholder.svg?height=200&width=400" alt="Blog Post 3" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <span>10 Januari 2024</span>
                            <span class="mx-2">•</span>
                            <i class="fas fa-user mr-2"></i>
                            <span>Budi</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3 hover:text-blue-600">
                            <a href="blog-detail.html">Monetisasi Blog: Cara Menghasilkan Uang</a>
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Berbagai cara untuk menghasilkan income dari blog Anda. Mulai dari affiliate marketing hingga sponsored content...
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span><i class="fas fa-eye mr-1"></i> 3.5k</span>
                                <span><i class="fas fa-heart mr-1"></i> 234</span>
                                <span><i class="fas fa-comment mr-1"></i> 67</span>
                            </div>
                            <a href="blog-detail.html" class="text-blue-600 hover:text-blue-700 font-medium">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>

            <div class="text-center mt-12">
                <a href="blog.html" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-medium inline-flex items-center">
                    Lihat Semua Blog <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Modal for Image Preview -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <div class="relative max-w-4xl max-h-full">
            <button id="closeModal" class="absolute -top-10 right-0 text-white hover:text-gray-300 text-2xl">
                <i class="fas fa-times"></i>
            </button>
            <img id="modalImage" src="/placeholder.svg" alt="" class="max-w-full max-h-[80vh] object-contain rounded-lg">
            <div class="text-center mt-4">
                <h3 id="modalTitle" class="text-white text-xl font-semibold"></h3>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-xl font-bold mb-4">Qrun Online</h3>
                    <p class="text-gray-400 mb-4">
                        Platform blogging terbaik untuk berbagi cerita dan membangun komunitas. 
                        Mulai perjalanan blogging Anda bersama kami.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Menu</h4>
                    <ul class="space-y-2">
                        <li><a href="index.html" class="text-gray-400 hover:text-white">Beranda</a></li>
                        <li><a href="blog.html" class="text-gray-400 hover:text-white">Blog</a></li>
                        {{-- <li><a href="#" class="text-gray-400 hover:text-white">Tentang</a></li> --}}
                        <li><a href="contact.html" class="text-gray-400 hover:text-white">Kontak</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Akun</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Login</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Register</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">
                    &copy; {{ date('Y')}} Qrun onlne. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

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
            animateCounter('eventBerjalan', {{$eventActiveCount}});
            animateCounter('eventBerakhir', {{$endedEvent}});
            // animateCounter('eventMendatang', 21);
        });

        // Gallery Modal Functionality
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modalTitle');
        const closeModal = document.getElementById('closeModal');
        const galleryItems = document.querySelectorAll('.gallery-item');

        // Open modal when gallery item is clicked
        galleryItems.forEach(item => {
            item.addEventListener('click', () => {
                const imageSrc = item.getAttribute('data-image');
                const imageTitle = item.getAttribute('data-title');
                
                modalImage.src = imageSrc;
                modalTitle.textContent = imageTitle;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            });
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
            if (window.innerWidth >= 640) return 2;  // Tablet
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
    </script>
</body>
</html>
