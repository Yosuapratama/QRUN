<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Qrun Website</title>
    <meta name="description"
        content="Baca artikel terbaru dari QRUN tentang teknologi QR code, penerapan inovatif, tips, dan pembaruan platform di blog kami.">
    <meta name="keywords"
        content="QRUN blog, artikel QR code, teknologi QR code, qrun.online, blog QRUN, update QRUN, info QR code">
    <meta name="author" content="QRUN Team">
    <meta name="robots" content="index, follow">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <!-- Navbar -->
    @include('Components.Navbar')

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-600 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">
                Blog & Artikel
            </h1>
            <p class="text-xl text-blue-100 mb-8">
                Temukan inspirasi, tips, dan panduan terbaru dari blog dan artikel kami
            </p>
            <div class="max-w-md mx-auto">
                <div class="relative">
                    <input type="text" id="search" placeholder="Cari artikel..."
                        class="w-full px-4 py-3 pl-12 rounded-lg border-0 focus:ring-2 focus:ring-blue-300">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>

            </div>

        </div>
    </section>


    <!-- Blog Posts -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="space-y-8">
                        <!-- Featured Post -->
                        <!-- Blog container -->
                        <div id="blog-container" class="space-y-8">
                            @include('partials.blog-cards', ['blogs' => $blogs])
                        </div>

                        <!-- Load more button -->
                        <div class="text-center mt-8">
                            <button id="load-more"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                Load More
                            </button>
                        </div>

                        {{-- <!-- Pagination -->
                        <div class="flex justify-center mt-12">
                            <nav class="flex items-center space-x-2">
                                <button class="px-3 py-2 text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">1</button>
                                <button class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">2</button>
                                <button class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">3</button>
                                <span class="px-2 text-gray-500">...</span>
                                <button class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">10</button>
                                <button class="px-3 py-2 text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </nav>
                        </div> --}}
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="space-y-8">
                        <!-- Popular Posts -->
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Artikel Populer</h3>
                            <div class="space-y-4">
                                @forelse ($popularBlogs as $popular)
                                    <div class="flex space-x-3">
                                        <img style="width: 60px; height: 60px"
                                            src="{{ $popular->image_url }}?height=60&width=60" alt="Popular Post"
                                            class="w-15 h-15 object-cover rounded">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                                <a href="/blog/{{ $popular->slug }}">{{ $popular->title }}</a>
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">
                                                @php
                                                    $date = \Carbon\Carbon::parse($popular->created_at)->locale('id');
                                                @endphp
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $date->diffForHumans() }}
                                            </p>
                                            </p>
                                        </div>
                                    </div>

                                @empty
                                    <div class="col-span-full flex flex-col items-center justify-center py-12 px-4">
                                        <div class="text-center">
                                            <i class="fas fa-newspaper text-4xl text-gray-300 mb-4"></i>
                                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak Ada Artikel
                                                Terkait</h3>
                                            <p class="text-gray-500">Belum ada artikel lain yang tersedia saat ini.</p>
                                        </div>
                                    </div>
                                @endforelse



                            </div>
                        </div>

                        <!-- Newsletter -->
                        {{-- <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-6 text-white">
                            <h3 class="text-lg font-semibold mb-3">Newsletter</h3>
                            <p class="text-blue-100 text-sm mb-4">Dapatkan tips blogging terbaru langsung di inbox
                                Anda!</p>
                            <div class="space-y-3">
                                <input type="email" placeholder="Email Anda"
                                    class="w-full px-4 py-2 rounded-lg text-gray-900">
                                <button
                                    class="w-full bg-white text-blue-600 px-4 py-2 rounded-lg font-medium hover:bg-gray-100">
                                    Subscribe
                                </button>
                            </div>
                        </div> --}}

                        <!-- Tags -->
                        {{-- <div class="bg-white rounded-lg shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tags Populer</h3>
                            <div class="flex flex-wrap gap-2">
                                <span
                                    class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm hover:bg-gray-200 cursor-pointer">Blogging</span>
                                <span
                                    class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm hover:bg-gray-200 cursor-pointer">SEO</span>
                                <span
                                    class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm hover:bg-gray-200 cursor-pointer">Content</span>
                                <span
                                    class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm hover:bg-gray-200 cursor-pointer">Marketing</span>
                                <span
                                    class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm hover:bg-gray-200 cursor-pointer">Design</span>
                                <span
                                    class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm hover:bg-gray-200 cursor-pointer">Tutorial</span>
                                <span
                                    class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm hover:bg-gray-200 cursor-pointer">Tips</span>
                                <span
                                    class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm hover:bg-gray-200 cursor-pointer">WordPress</span>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('Components.FooterHome')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script>
        let currentPage = 1;
        let searching = false;
        let searchTimer;

        // Live Search
        $('#search').on('input', function() {
            clearTimeout(searchTimer);
            const query = $(this).val();

            searchTimer = setTimeout(() => {
                searching = true;
                currentPage = 1;

                $.ajax({
                    url: '{{ route('blog.search') }}',
                    data: {
                        query: query
                    },
                    success: function(response) {
                        $('#blog-container').html(response.html);
                        $('#load-more').toggle(response.blogs.length >= 6);
                    }
                });
            }, 300);
        });

        // Load More
        $('#load-more').on('click', function() {
            const $btn = $(this);
            $btn.prop('disabled', true).text('Loading...');

            currentPage++;

            $.ajax({
                url: '{{ route('blog.loadMore') }}',
                data: {
                    page: currentPage,
                    query: $('#search').val()
                },
                success: function(response) {
                    $('#blog-container').append(response.html);
                    $btn.prop('disabled', false).text('Load More');

                    // Hide button if no more results
                    if (!response.hasMore) {
                        $btn.hide();
                    }
                }
            });
        });

        // Mobile menu toggle
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Category filter functionality
        const categoryButtons = document.querySelectorAll('section:nth-of-type(2) button');
        categoryButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                categoryButtons.forEach(btn => {
                    btn.classList.remove('bg-blue-600', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-700');
                });

                // Add active class to clicked button
                button.classList.remove('bg-gray-200', 'text-gray-700');
                button.classList.add('bg-blue-600', 'text-white');
            });
        });
    </script>
</body>

</html>
