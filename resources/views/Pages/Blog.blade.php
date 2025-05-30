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
                Temukan inspirasi, tips, dan panduan terbaru dari komunitas blogger kami
            </p>
            <div class="max-w-md mx-auto">
                <div class="relative">
                    <input type="text" placeholder="Cari artikel..."
                        class="w-full px-4 py-3 pl-12 rounded-lg border-0 focus:ring-2 focus:ring-blue-300">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="py-8 bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-center gap-4">
                <button class="bg-blue-600 text-white px-6 py-2 rounded-full font-medium">Semua</button>
                <button class="bg-gray-200 text-gray-700 hover:bg-gray-300 px-6 py-2 rounded-full font-medium">Tips
                    Blogging</button>
                <button
                    class="bg-gray-200 text-gray-700 hover:bg-gray-300 px-6 py-2 rounded-full font-medium">SEO</button>
                <button
                    class="bg-gray-200 text-gray-700 hover:bg-gray-300 px-6 py-2 rounded-full font-medium">Monetisasi</button>
                <button
                    class="bg-gray-200 text-gray-700 hover:bg-gray-300 px-6 py-2 rounded-full font-medium">Design</button>
                <button
                    class="bg-gray-200 text-gray-700 hover:bg-gray-300 px-6 py-2 rounded-full font-medium">Tutorial</button>
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
                        <article class="bg-white rounded-lg shadow-lg overflow-hidden">
                            <img src="/placeholder.svg?height=300&width=600" alt="Featured Post"
                                class="w-full h-64 object-cover">
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <span
                                        class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium mr-3">Featured</span>
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    <span>15 Januari 2024</span>
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-user mr-2"></i>
                                    <span>Admin</span>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-3 hover:text-blue-600">
                                    <a href="blog-detail.html">Panduan Lengkap Memulai Blog dari Nol hingga Sukses</a>
                                </h2>
                                <p class="text-gray-600 mb-4">
                                    Dalam era digital ini, blogging telah menjadi salah satu cara paling efektif untuk
                                    berbagi pengetahuan, membangun personal branding, dan bahkan menghasilkan income.
                                    Artikel ini akan membahas langkah demi langkah untuk memulai blog yang sukses...
                                </p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span><i class="fas fa-eye mr-1"></i> 5.2k</span>
                                        <span><i class="fas fa-heart mr-1"></i> 234</span>
                                        <span><i class="fas fa-comment mr-1"></i> 67</span>
                                    </div>
                                    <a href="blog-detail.html" class="text-blue-600 hover:text-blue-700 font-medium">
                                        Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </article>

                        <!-- Regular Posts -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Post 1 -->
                            <article
                                class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                                <img src="/placeholder.svg?height=200&width=400" alt="Blog Post"
                                    class="w-full h-48 object-cover">
                                <div class="p-6">
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        <span>12 Januari 2024</span>
                                        <span class="mx-2">•</span>
                                        <span>Sarah</span>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3 hover:text-blue-600">
                                        <a href="blog-detail.html">10 Tools SEO Gratis untuk Blogger</a>
                                    </h3>
                                    <p class="text-gray-600 mb-4 text-sm">
                                        Temukan tools SEO gratis terbaik yang akan membantu meningkatkan ranking blog
                                        Anda di mesin pencari...
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3 text-xs text-gray-500">
                                            <span><i class="fas fa-eye mr-1"></i> 2.1k</span>
                                            <span><i class="fas fa-heart mr-1"></i> 156</span>
                                        </div>
                                        <a href="blog-detail.html"
                                            class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                            Baca <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>

                            <!-- Post 2 -->
                            <article
                                class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                                <img src="/placeholder.svg?height=200&width=400" alt="Blog Post"
                                    class="w-full h-48 object-cover">
                                <div class="p-6">
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        <span>10 Januari 2024</span>
                                        <span class="mx-2">•</span>
                                        <span>Budi</span>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3 hover:text-blue-600">
                                        <a href="blog-detail.html">Cara Membuat Konten yang Viral</a>
                                    </h3>
                                    <p class="text-gray-600 mb-4 text-sm">
                                        Rahasia di balik konten yang viral dan bagaimana Anda bisa menerapkannya di blog
                                        Anda...
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3 text-xs text-gray-500">
                                            <span><i class="fas fa-eye mr-1"></i> 3.5k</span>
                                            <span><i class="fas fa-heart mr-1"></i> 289</span>
                                        </div>
                                        <a href="blog-detail.html"
                                            class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                            Baca <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>

                            <!-- Post 3 -->
                            <article
                                class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                                <img src="/placeholder.svg?height=200&width=400" alt="Blog Post"
                                    class="w-full h-48 object-cover">
                                <div class="p-6">
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        <span>8 Januari 2024</span>
                                        <span class="mx-2">•</span>
                                        <span>Maya</span>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3 hover:text-blue-600">
                                        <a href="blog-detail.html">Design Blog yang Menarik dan User-Friendly</a>
                                    </h3>
                                    <p class="text-gray-600 mb-4 text-sm">
                                        Tips dan trik untuk membuat design blog yang tidak hanya menarik tapi juga mudah
                                        digunakan...
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3 text-xs text-gray-500">
                                            <span><i class="fas fa-eye mr-1"></i> 1.8k</span>
                                            <span><i class="fas fa-heart mr-1"></i> 123</span>
                                        </div>
                                        <a href="blog-detail.html"
                                            class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                            Baca <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>

                            <!-- Post 4 -->
                            <article
                                class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                                <img src="/placeholder.svg?height=200&width=400" alt="Blog Post"
                                    class="w-full h-48 object-cover">
                                <div class="p-6">
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        <span>5 Januari 2024</span>
                                        <span class="mx-2">•</span>
                                        <span>Andi</span>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3 hover:text-blue-600">
                                        <a href="blog-detail.html">Strategi Content Marketing untuk Blog</a>
                                    </h3>
                                    <p class="text-gray-600 mb-4 text-sm">
                                        Pelajari strategi content marketing yang efektif untuk meningkatkan traffic dan
                                        engagement blog...
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3 text-xs text-gray-500">
                                            <span><i class="fas fa-eye mr-1"></i> 2.7k</span>
                                            <span><i class="fas fa-heart mr-1"></i> 198</span>
                                        </div>
                                        <a href="blog-detail.html"
                                            class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                            Baca <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </div>

                        <!-- Pagination -->
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
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="space-y-8">
                        <!-- Popular Posts -->
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Artikel Populer</h3>
                            <div class="space-y-4">
                                <div class="flex space-x-3">
                                    <img src="/placeholder.svg?height=60&width=60" alt="Popular Post"
                                        class="w-15 h-15 object-cover rounded">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                            <a href="blog-detail.html">Tips Menulis Artikel yang Engaging</a>
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-1">3 hari yang lalu</p>
                                    </div>
                                </div>
                                <div class="flex space-x-3">
                                    <img src="/placeholder.svg?height=60&width=60" alt="Popular Post"
                                        class="w-15 h-15 object-cover rounded">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                            <a href="blog-detail.html">Cara Optimasi Gambar untuk Web</a>
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-1">5 hari yang lalu</p>
                                    </div>
                                </div>
                                <div class="flex space-x-3">
                                    <img src="/placeholder.svg?height=60&width=60" alt="Popular Post"
                                        class="w-15 h-15 object-cover rounded">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                            <a href="blog-detail.html">Social Media Marketing untuk Blogger</a>
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-1">1 minggu yang lalu</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Newsletter -->
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-6 text-white">
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
                        </div>

                        <!-- Tags -->
                        <div class="bg-white rounded-lg shadow-lg p-6">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('Components.FooterHome')

    <script>
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
