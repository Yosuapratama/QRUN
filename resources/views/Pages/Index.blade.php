<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage | Qrun Website</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="description"
        content="QRUN aims to display detailed information when QR codes placed in various locations are scanned.">
    <meta name="keywords"
        content="qrun,qrun online, login qrun, login qrun online, sign in qrun, sign in qrun online, register qrun online,register qrun">
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
    @include('Components.Navbar')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-50 to-indigo-100 py-12 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col-reverse lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                <div class="mb-8 lg:mb-0">
                    <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6 mt-4 lg:mt-0 md:mt-1">
                        Ciptakan tempat pertama mu disini!
                    </h1>
                    <p class="text-lg text-gray-600 mb-8">
                        Bergabunglah dengan komunitas kami dan mulai berbagi cerita Anda dengan dunia. Platform yang
                        mudah digunakan untuk semua kalangan.
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
                    <iframe width="100%" height="400px"
                        src="https://www.youtube.com/embed/W5IUwH-tk8g?si=_2OtIl56GzFtULGh" title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
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

                    <div class="text-3xl lg:text-4xl font-bold text-white mb-2" id="totalEventSemua">{{ $eventCount }}
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
