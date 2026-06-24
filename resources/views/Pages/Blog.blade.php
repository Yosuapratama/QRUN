<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Blog Qrun Online | Artikel Sejarah, Budaya, Wisata & QR Digital</title>

    <meta name="description"
        content="Jelajahi artikel terbaru dari Qrun Online tentang sejarah, budaya, wisata, teknologi QR Code, digital heritage, dan informasi tempat secara interaktif.">
    <meta name="keywords"
        content="blog qrun online, artikel sejarah, budaya indonesia, wisata bali, qr code sejarah, prasasti digital, digital heritage, smart tourism, qr code wisata, informasi tempat, sejarah pura, sejarah candi, teknologi qr code">
    <meta name="author" content="Qrun Online">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="https://qrun.online/blog">
    <meta name="theme-color" content="#2d4373">
    <link rel="icon" type="image/png" href="{{ asset('transparent-logo.png') }}">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Qrun Online">
    <meta property="og:title" content="Blog Qrun Online | Artikel Sejarah, Budaya, Wisata & QR Digital">
    <meta property="og:description" content="Baca artikel tentang sejarah, budaya, wisata, teknologi QR Code, dan informasi tempat dari Qrun Online.">
    <meta property="og:url" content="https://qrun.online/blog">
    <meta property="og:image" content="https://qrun.online/home.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Blog Qrun Online | Artikel Sejarah, Budaya, Wisata & QR Digital">
    <meta name="twitter:description" content="Temukan artikel sejarah, budaya, wisata, dan teknologi QR Code dari Qrun Online.">
    <meta name="twitter:image" content="https://qrun.online/home.jpg">

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Blog",
        "name": "Qrun Online Blog",
        "url": "https://qrun.online/blog",
        "description": "Blog resmi Qrun Online tentang sejarah, budaya, wisata, teknologi QR Code, dan digital heritage.",
        "publisher": {
            "@type": "Organization",
            "name": "Qrun Online",
            "url": "https://qrun.online"
        }
    }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        * { font-family: 'Inter', sans-serif; }

        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        .hero-grid {
            background-image: radial-gradient(circle, rgba(255,255,255,0.10) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        #search:focus { outline: none; box-shadow: 0 0 0 3px rgba(59,130,246,0.25); }

        .blog-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .blog-card:hover { transform: translateY(-3px); box-shadow: 0 16px 36px rgba(0,0,0,0.09); }
        .blog-card .card-img { transition: transform 0.5s ease; }
        .blog-card:hover .card-img { transform: scale(1.06); }

        .popular-item { transition: background 0.2s ease; }
        .popular-item:hover { background: #f8fafc; }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 99px; }
    </style>
</head>

<body class="bg-gray-50 antialiased">
    @include('Components.Navbar')

    {{-- ═══════════ HERO ═══════════ --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-900 py-20">
        <div class="absolute inset-0 hero-grid"></div>
        <div class="absolute top-0 right-0 w-72 h-72 bg-blue-500 rounded-full opacity-[0.07] blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-violet-500 rounded-full opacity-[0.07] blur-3xl pointer-events-none"></div>

        <div class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 bg-blue-500/20 border border-blue-400/30 text-blue-300 text-sm font-medium px-4 py-2 rounded-full mb-6">
                <i class="fas fa-newspaper text-xs"></i>
                Blog & Artikel
            </div>
            <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-4 leading-tight">
                {{ __('messages.blog_page.hero_title') }}
            </h1>
            <p class="text-blue-200 text-lg mb-10">
                {{ __('messages.blog_page.hero_subtitle') }}
            </p>

            <div class="relative max-w-lg mx-auto">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                <input type="text" id="search"
                    placeholder="{{ __('messages.blog_page.search_placeholder') }}"
                    class="w-full bg-white text-gray-900 placeholder-gray-400 text-sm font-medium pl-11 pr-4 py-3.5 rounded-xl border-0 shadow-lg">
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0 leading-none">
            <svg viewBox="0 0 1440 48" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0,48 C480,0 960,0 1440,48 L1440,48 L0,48 Z" fill="#f8fafc"/>
            </svg>
        </div>
    </section>

    {{-- ═══════════ CONTENT ═══════════ --}}
    <section class="py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                {{-- Blog list --}}
                <div class="lg:col-span-2">
                    <div id="blog-container" class="space-y-5">
                        @include('partials.blog-cards', ['blogs' => $blogs])
                    </div>

                    <div class="text-center mt-10" id="load-more-wrapper">
                        <button id="load-more"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold text-sm rounded-xl transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5">
                            <i class="fas fa-plus-circle text-xs"></i>
                            {{ __('messages.blog_page.load_more') }}
                        </button>
                    </div>
                </div>

                {{-- Sidebar --}}
                <aside class="lg:col-span-1 space-y-6">

                    {{-- Popular posts --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 reveal">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="bg-orange-100 text-orange-500 w-8 h-8 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fas fa-fire text-sm"></i>
                            </div>
                            <h3 class="text-base font-bold text-gray-900">{{ __('messages.blog_page.popular_posts') }}</h3>
                        </div>

                        <div class="space-y-1">
                            @forelse ($popularBlogs as $i => $popular)
                                <a href="/blog/{{ $popular->slug }}"
                                    class="popular-item flex items-start gap-3 p-3 rounded-xl -mx-1 group">
                                    <div class="relative shrink-0 w-14 h-14 rounded-xl overflow-hidden bg-gray-100">
                                        <img src="{{ $popular->image_url }}" alt="{{ $popular->title }}"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-semibold text-gray-800 group-hover:text-blue-600 transition-colors line-clamp-2 leading-snug">
                                            {{ $popular->title }}
                                        </h4>
                                        @php
                                            $pDate = \Carbon\Carbon::parse($popular->created_at)->locale(app()->getLocale());
                                        @endphp
                                        <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                            <i class="fas fa-clock text-[10px]"></i>
                                            {{ $pDate->diffForHumans() }}
                                        </p>
                                    </div>
                                    <span class="shrink-0 text-xs font-bold text-gray-200 self-start mt-1">
                                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </a>
                            @empty
                                <div class="flex flex-col items-center py-8 text-center">
                                    <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mb-3">
                                        <i class="fas fa-newspaper text-xl text-gray-300"></i>
                                    </div>
                                    <p class="text-sm font-medium text-gray-700">{{ __('messages.blog_page.no_articles_title') }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ __('messages.blog_page.no_articles_desc') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- CTA widget --}}
                    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white reveal">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mb-4">
                            <i class="fas fa-qrcode text-white"></i>
                        </div>
                        <h3 class="font-bold text-lg mb-2 leading-snug">Mulai Gunakan Qrun</h3>
                        <p class="text-blue-100 text-sm leading-relaxed mb-4">
                            Daftarkan tempat Anda dan buat QR Code prasasti digital sekarang.
                        </p>
                        <a href="{{ route('login') }}"
                            class="flex items-center justify-center gap-2 bg-white text-blue-700 font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-blue-50 transition-colors w-full">
                            Daftar Sekarang <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                </aside>
            </div>
        </div>
    </section>

    @include('Components.FooterHome')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        const loadMoreText = @json(__('messages.blog_page.load_more'));
        const loadingText  = @json(__('messages.global_loading'));

        // Scroll reveal
        const io = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); }
            });
        }, { threshold: 0.08 });
        document.querySelectorAll('.reveal').forEach(el => io.observe(el));

        let currentPage = 1;
        let searchTimer;

        // Live search
        $('#search').on('input', function () {
            clearTimeout(searchTimer);
            const query = $(this).val().trim();
            searchTimer = setTimeout(() => {
                currentPage = 1;
                $.ajax({
                    url: '{{ route('blog.search') }}',
                    data: { query },
                    success: function (res) {
                        $('#blog-container').html(res.html);
                        $('#load-more-wrapper').toggle(res.blogs.length >= 6);
                    }
                });
            }, 300);
        });

        // Load more
        $('#load-more').on('click', function () {
            const $btn = $(this);
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin text-xs mr-2"></i>' + loadingText);
            currentPage++;

            $.ajax({
                url: '{{ route('blog.loadMore') }}',
                data: { page: currentPage, query: $('#search').val() },
                success: function (res) {
                    $('#blog-container').append(res.html);
                    $btn.prop('disabled', false).html('<i class="fas fa-plus-circle text-xs mr-2"></i>' + loadMoreText);
                    if (!res.hasMore) $('#load-more-wrapper').hide();
                }
            });
        });
    </script>
</body>

</html>
