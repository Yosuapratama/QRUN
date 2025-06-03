<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data->title }} - Qrun Website</title>
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
                <a href="{{ route('homes') }}" class="hover:text-blue-600">Beranda</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('blog') }}" class="hover:text-blue-600">Blog</a>
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
                    {{ $data->title }}
                </h1>

                <div class="flex items-center justify-between flex-wrap gap-4 mb-6">
                    <div class="flex items-center space-x-4 text-gray-600">
                        <div class="flex items-center">
                            {{-- <img src="/placeholder.svg?height=40&width=40" alt="Author"
                                class="w-10 h-10 rounded-full mr-3"> --}}
                            <div>
                                <p class="font-medium text-gray-900">Admin</p>
                                <p class="text-sm">Content Creator</p>
                            </div>
                        </div>
                        <span>•</span>
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <span> {{ $data->created_at }}
                            </span>
                        </div>
                        <span>•</span>
                        {{-- <div class="flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            <span>8 min read</span>
                        </div> --}}
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-3 text-sm text-gray-600">
                            <span><i class="fas fa-eye mr-1"></i>

                                @php
                                    $num = $data->views;
                                    $formatted = $num < 1000 ? $num : number_format($num / 1000, 1) . 'K';
                                @endphp
                                {{ $formatted }}
                            </span>
                            {{-- <button class="flex items-center hover:text-red-600">
                                <i class="fas fa-heart mr-1"></i> 89
                            </button> --}}
                        </div>
                        {{-- <div class="flex items-center space-x-2">
                            <button class="p-2 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button class="p-2 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200">
                                <i class="fab fa-twitter"></i>
                            </button>
                            <button class="p-2 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200">
                                <i class="fab fa-linkedin-in"></i>
                            </button>
                        </div> --}}
                    </div>
                </div>

                <img src="{{ asset($data->image_url) }}" alt="Featured Image"
                    class="w-full h-64 lg:h-96 object-cover rounded-lg shadow-lg">
            </header>

            <!-- Article Body -->
            <div class="prose prose-lg max-w-none">
                {!! $data->content !!}
            </div>

            <!-- Tags -->
            {{-- <div class="border-t pt-6 mt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Tags:</h3>
                <div class="flex flex-wrap gap-2">
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">#blogging</span>
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">#pemula</span>
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">#tips</span>
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">#tutorial</span>
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">#seo</span>
                </div>
            </div> --}}

            <!-- Author Bio -->
            {{-- <div class="bg-gray-50 rounded-lg p-6 mt-8">
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
            </div> --}}

            <!-- Related Posts -->
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Artikel Lainnya</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    @forelse ($blogs as $blog)
                        <article
                            class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
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
