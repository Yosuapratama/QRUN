<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tips Memulai Blog untuk Pemula - TEST PROJECT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    @include('Components.Navbar')

    <!-- Breadcrumb -->
    <nav class="bg-white border-b py-4">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-2 text-sm text-gray-600">
                <a href="index.html" class="hover:text-blue-600">Beranda</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="blog.html" class="hover:text-blue-600">Blog</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-gray-900">Tips Memulai Blog untuk Pemula</span>
            </div>
        </div>
    </nav>

    <!-- Article Content -->
    <article class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Article Header -->
            <header class="mb-8">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                    Tips Memulai Blog untuk Pemula: Panduan Lengkap dari Nol hingga Sukses
                </h1>
                
                <div class="flex items-center justify-between flex-wrap gap-4 mb-6">
                    <div class="flex items-center space-x-4 text-gray-600">
                        <div class="flex items-center">
                            <img src="/placeholder.svg?height=40&width=40" alt="Author" class="w-10 h-10 rounded-full mr-3">
                            <div>
                                <p class="font-medium text-gray-900">Admin</p>
                                <p class="text-sm">Content Creator</p>
                            </div>
                        </div>
                        <span>•</span>
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <span>15 Januari 2024</span>
                        </div>
                        <span>•</span>
                        <div class="flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            <span>8 min read</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-3 text-sm text-gray-600">
                            <span><i class="fas fa-eye mr-1"></i> 1.2k</span>
                            <button class="flex items-center hover:text-red-600">
                                <i class="fas fa-heart mr-1"></i> 89
                            </button>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="p-2 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button class="p-2 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200">
                                <i class="fab fa-twitter"></i>
                            </button>
                            <button class="p-2 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200">
                                <i class="fab fa-linkedin-in"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <img src="/placeholder.svg?height=400&width=800" alt="Featured Image" class="w-full h-64 lg:h-96 object-cover rounded-lg shadow-lg">
            </header>

            <!-- Article Body -->
            <div class="prose prose-lg max-w-none">
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    Memulai blog bisa terasa menakutkan bagi pemula, tapi dengan panduan yang tepat, 
                    siapa pun bisa menjadi blogger sukses. Artikel ini akan membahas langkah demi langkah 
                    untuk memulai perjalanan blogging Anda.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">1. Tentukan Niche Blog Anda</h2>
                <p class="text-gray-700 mb-6">
                    Langkah pertama yang paling penting adalah menentukan niche atau topik utama blog Anda. 
                    Pilih topik yang Anda kuasai dan passionate. Beberapa niche populer antara lain:
                </p>
                <ul class="list-disc pl-6 mb-6 text-gray-700">
                    <li>Teknologi dan gadget</li>
                    <li>Lifestyle dan fashion</li>
                    <li>Kuliner dan resep</li>
                    <li>Travel dan adventure</li>
                    <li>Bisnis dan keuangan</li>
                    <li>Kesehatan dan fitness</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">2. Pilih Platform Blogging</h2>
                <p class="text-gray-700 mb-6">
                    Ada banyak platform blogging yang bisa Anda pilih. Masing-masing memiliki kelebihan dan kekurangan:
                </p>
                
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Platform Populer:</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-lg">
                            <h4 class="font-medium text-gray-900">WordPress</h4>
                            <p class="text-sm text-gray-600">Fleksibel dan powerful, cocok untuk semua level</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg">
                            <h4 class="font-medium text-gray-900">Blogger</h4>
                            <p class="text-sm text-gray-600">Gratis dan mudah digunakan untuk pemula</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg">
                            <h4 class="font-medium text-gray-900">Medium</h4>
                            <p class="text-sm text-gray-600">Fokus pada konten, built-in audience</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg">
                            <h4 class="font-medium text-gray-900">Ghost</h4>
                            <p class="text-sm text-gray-600">Modern dan cepat, cocok untuk publisher</p>
                        </div>
                    </div>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">3. Buat Konten Berkualitas</h2>
                <p class="text-gray-700 mb-6">
                    Konten adalah raja dalam dunia blogging. Berikut tips untuk membuat konten yang menarik:
                </p>

                <blockquote class="border-l-4 border-blue-500 pl-6 py-4 bg-blue-50 rounded-r-lg mb-6">
                    <p class="text-gray-700 italic">
                        "Konten yang baik bukan hanya informatif, tapi juga engaging dan memberikan value 
                        kepada pembaca. Fokus pada solving problems dan answering questions."
                    </p>
                </blockquote>

                <h3 class="text-xl font-semibold text-gray-900 mb-3">Tips Menulis Konten:</h3>
                <ol class="list-decimal pl-6 mb-6 text-gray-700 space-y-2">
                    <li>Riset keyword untuk SEO</li>
                    <li>Buat outline sebelum menulis</li>
                    <li>Gunakan heading dan subheading</li>
                    <li>Tambahkan gambar dan media</li>
                    <li>Edit dan proofread sebelum publish</li>
                </ol>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">4. Optimasi SEO</h2>
                <p class="text-gray-700 mb-6">
                    SEO (Search Engine Optimization) sangat penting untuk meningkatkan visibility blog Anda 
                    di mesin pencari. Beberapa teknik dasar SEO:
                </p>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-yellow-800 mb-3">
                        <i class="fas fa-lightbulb mr-2"></i>
                        SEO Tips untuk Pemula
                    </h3>
                    <ul class="text-yellow-700 space-y-1">
                        <li>• Gunakan keyword di title dan meta description</li>
                        <li>• Optimasi gambar dengan alt text</li>
                        <li>• Buat internal linking antar artikel</li>
                        <li>• Pastikan loading speed yang cepat</li>
                        <li>• Mobile-friendly design</li>
                    </ul>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">5. Promosi dan Marketing</h2>
                <p class="text-gray-700 mb-6">
                    Setelah konten siap, saatnya mempromosikan blog Anda. Gunakan berbagai channel:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white border rounded-lg p-6 text-center">
                        <i class="fas fa-share-alt text-3xl text-blue-600 mb-3"></i>
                        <h3 class="font-semibold text-gray-900 mb-2">Social Media</h3>
                        <p class="text-sm text-gray-600">Share di Facebook, Twitter, Instagram, LinkedIn</p>
                    </div>
                    <div class="bg-white border rounded-lg p-6 text-center">
                        <i class="fas fa-envelope text-3xl text-green-600 mb-3"></i>
                        <h3 class="font-semibold text-gray-900 mb-2">Email Marketing</h3>
                        <p class="text-sm text-gray-600">Build email list dan kirim newsletter</p>
                    </div>
                    <div class="bg-white border rounded-lg p-6 text-center">
                        <i class="fas fa-users text-3xl text-purple-600 mb-3"></i>
                        <h3 class="font-semibold text-gray-900 mb-2">Community</h3>
                        <p class="text-sm text-gray-600">Join grup dan forum yang relevan</p>
                    </div>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">Kesimpulan</h2>
                <p class="text-gray-700 mb-6">
                    Memulai blog memang membutuhkan dedikasi dan konsistensi, tapi dengan mengikuti 
                    langkah-langkah di atas, Anda sudah berada di jalur yang tepat. Ingat, kesuksesan 
                    blogging tidak terjadi dalam semalam - butuh waktu, effort, dan pembelajaran terus-menerus.
                </p>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold text-blue-900 mb-3">
                        <i class="fas fa-rocket mr-2"></i>
                        Siap Memulai?
                    </h3>
                    <p class="text-blue-800 mb-4">
                        Jangan tunggu lagi! Mulai blog Anda hari ini dan bergabung dengan komunitas blogger kami.
                    </p>
                    <a href="index.html" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium inline-block">
                        Mulai Sekarang
                    </a>
                </div>
            </div>

            <!-- Tags -->
            <div class="border-t pt-6 mt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Tags:</h3>
                <div class="flex flex-wrap gap-2">
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">#blogging</span>
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">#pemula</span>
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">#tips</span>
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">#tutorial</span>
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">#seo</span>
                </div>
            </div>

            <!-- Author Bio -->
            <div class="bg-gray-50 rounded-lg p-6 mt-8">
                <div class="flex items-start space-x-4">
                    <img src="/placeholder.svg?height=80&width=80" alt="Author" class="w-20 h-20 rounded-full">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Admin</h3>
                        <p class="text-gray-600 mb-3">
                            Content Creator dan Digital Marketing Specialist dengan pengalaman 5+ tahun 
                            di industri blogging. Passionate tentang sharing knowledge dan membantu 
                            blogger pemula mencapai kesuksesan.
                        </p>
                        <div class="flex space-x-3">
                            <a href="#" class="text-blue-600 hover:text-blue-700">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-blue-600 hover:text-blue-700">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="text-blue-600 hover:text-blue-700">
                                <i class="fas fa-globe"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Posts -->
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Artikel Terkait</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <article class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="/placeholder.svg?height=200&width=400" alt="Related Post" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2 hover:text-blue-600">
                                <a href="#">Strategi SEO untuk Blog di 2024</a>
                            </h4>
                            <p class="text-gray-600 text-sm mb-3">
                                Pelajari teknik SEO terbaru yang akan membantu blog Anda mendapat ranking tinggi...
                            </p>
                            <div class="flex items-center text-xs text-gray-500">
                                <span>12 Januari 2024</span>
                                <span class="mx-2">•</span>
                                <span>5 min read</span>
                            </div>
                        </div>
                    </article>

                    <article class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="/placeholder.svg?height=200&width=400" alt="Related Post" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2 hover:text-blue-600">
                                <a href="#">Monetisasi Blog: Cara Menghasilkan Uang</a>
                            </h4>
                            <p class="text-gray-600 text-sm mb-3">
                                Berbagai cara untuk menghasilkan income dari blog Anda. Mulai dari affiliate marketing...
                            </p>
                            <div class="flex items-center text-xs text-gray-500">
                                <span>10 Januari 2024</span>
                                <span class="mx-2">•</span>
                                <span>7 min read</span>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </article>

    <!-- Footer -->
    @include('Components.FooterHome')

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');
        
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
