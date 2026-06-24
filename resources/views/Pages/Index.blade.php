<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Qrun Online - Platform QR Code Sejarah & Informasi Tempat</title>

    <meta name="description"
        content="Qrun Online adalah platform prasasti digital berbasis QR Code yang memungkinkan pengunjung mengakses sejarah, budaya, dokumentasi, dan informasi tempat secara interaktif hanya dengan sekali scan.">
    <meta name="keywords"
        content="qrun, qrun online, login qrun, register qrun, sign in qrun, qr code sejarah, prasasti digital, digital heritage, smart tourism">

    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="author" content="Qrun Online">
    <link rel="canonical" href="https://qrun.online">
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
    <meta property="og:url" content="https://qrun.online">
    <meta property="og:image" content="https://qrun.online/home.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Qrun Online - Platform QR Code Sejarah dan Informasi Tempat">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Qrun Online | Scan QR Code untuk Mengakses Sejarah dan Informasi Tempat">
    <meta name="twitter:description"
        content="Platform prasasti digital berbasis QR Code untuk mengakses sejarah, budaya, dokumentasi, dan informasi tempat secara interaktif.">
    <meta name="twitter:image" content="https://qrun.online/home.jpg">

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "Organization",
          "@id": "https://qrun.online/#organization",
          "name": "Qrun Online",
          "url": "https://qrun.online",
          "logo": {
            "@type": "ImageObject",
            "url": "https://qrun.online/transparent-logo.png"
          }
        },
        {
          "@type": "WebSite",
          "@id": "https://qrun.online/#website",
          "url": "https://qrun.online",
          "name": "Qrun Online",
          "description": "Platform prasasti digital berbasis QR Code untuk mengakses sejarah, budaya, dokumentasi, dan informasi tempat secara interaktif.",
          "publisher": {
            "@id": "https://qrun.online/#organization"
          },
          "inLanguage": "id-ID"
        }
      ]
    }
    </script>

    {{-- Preconnect only to the two highest-impact origins (fonts + asset CDN);
         keep the rest as cheaper dns-prefetch to stay under the 4-preconnect budget --}}
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://cdn.tailwindcss.com">

    {{-- Preload the LCP hero image so the browser fetches it early --}}
    <link rel="preload" as="image" href="{{ asset('home.webp') }}" type="image/webp" fetchpriority="high">

    {{-- Google Fonts loaded non-render-blocking (display=swap keeps text visible) --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"></noscript>

    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome (loaded non-render-blocking, swapped in once ready) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"></noscript>

    {{-- TOASTR CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"></noscript>

    {{-- JQUERY (deferred — DOM-ready handlers below wait for it) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" defer></script>

    {{-- TOASTR JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" defer></script>

    <style>
        * { font-family: 'Inter', sans-serif; }

        .toast-success { background-color: #28a745 !important; }
        .toast-error   { background-color: #dc3545 !important; }
        .toast-info    { background-color: #17a2b8 !important; }
        .toast-warning { background-color: #ffc107 !important; color: #000 !important; }
        .toast         { opacity: 1 !important; }

        /* Scroll reveal */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.65s ease, transform 0.65s ease;
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* Hero dot grid */
        .hero-grid {
            background-image: radial-gradient(circle, rgba(255,255,255,0.12) 1px, transparent 1px);
            background-size: 36px 36px;
        }

        /* Gradient text */
        .text-gradient {
            background: linear-gradient(135deg, #93c5fd, #c4b5fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Glass card */
        .glass {
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.15);
        }

        /* Smooth scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 99px; }

        /* Feature card lift */
        .lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .lift:hover { transform: translateY(-5px); box-shadow: 0 20px 48px rgba(0,0,0,0.10); }

        /* Blog card */
        .blog-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .blog-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,0.10); }

        /* Gallery hover overlay */
        .gallery-item .g-overlay { opacity: 0; transition: opacity 0.3s ease; }
        .gallery-item:hover .g-overlay { opacity: 1; }
        .gallery-item img { transition: transform 0.5s ease; }
        .gallery-item:hover img { transform: scale(1.08); }

        /* Section divider wave */
        .wave-bottom { position: absolute; bottom: -1px; left: 0; right: 0; line-height: 0; }

        /* Line clamp */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Counter font */
        .counter-num { font-variant-numeric: tabular-nums; }
    </style>
</head>

@php
    $placeCount       = \App\Helpers\SidebarHelper::getPlaceCount();
    $eventCount       = \App\Helpers\SidebarHelper::getEventCount();
    $eventActiveCount = \App\Helpers\SidebarHelper::getEventActiveCount();
    $activeUser       = \App\Helpers\SidebarHelper::getActiveUser();
    $endedEvent       = \App\Helpers\SidebarHelper::getEndedEvent();
@endphp

<body class="bg-white antialiased">
    @include('Components.Navbar')

    {{-- Toast notifications --}}
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @foreach ($errors->all() as $error)
                    toastr.error(@json($error), 'Error');
                @endforeach
            });
        </script>
    @endif
    @if (session()->has('status'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                toastr.success(@json(session('status')), 'Success');
            });
        </script>
    @endif
    @if (session()->has('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                toastr.success(@json(session('success')), 'Success');
            });
        </script>
    @endif

    <main>
    {{-- ═══════════════════════════════════════ HERO ═══════════════════════════════════════ --}}
    <section class="relative min-h-[92vh] flex items-center overflow-hidden bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-900">
        <div class="absolute inset-0 hero-grid"></div>

        {{-- Ambient blobs --}}
        <div class="absolute top-24 right-16 w-80 h-80 bg-blue-500 rounded-full opacity-[0.08] blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-24 left-16 w-96 h-96 bg-violet-500 rounded-full opacity-[0.08] blur-3xl pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 w-full">
            <div class="grid lg:grid-cols-2 gap-14 items-center">

                {{-- Left --}}
                <div>
                    <div class="inline-flex items-center gap-2 bg-blue-500/20 border border-blue-400/30 text-blue-300 text-sm font-medium px-4 py-2 rounded-full mb-7">
                        <span class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></span>
                        Platform QR Code Digital Heritage
                    </div>

                    <h1 class="text-4xl lg:text-[3.5rem] font-extrabold text-white leading-[1.15] mb-6 tracking-tight">
                        {{ __('messages.home.hero_title') }}
                    </h1>

                    <p class="text-lg text-slate-300 leading-relaxed mb-9 max-w-lg">
                        {{ __('messages.home.hero_subtitle') }}
                    </p>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-400 text-white font-semibold px-7 py-3.5 rounded-xl transition-all shadow-lg shadow-blue-700/40 hover:shadow-blue-500/50 hover:-translate-y-0.5 active:translate-y-0">
                            <i class="fas fa-qrcode"></i>
                            {{ __('messages.home.hero_start') }}
                        </a>
                        <a href="{{ route('blog') }}"
                            class="inline-flex items-center gap-2 glass text-white font-semibold px-7 py-3.5 rounded-xl hover:bg-white/15 transition-all">
                            <i class="fas fa-newspaper text-sm"></i>
                            {{ __('messages.home.hero_blog') }}
                        </a>
                    </div>

                    {{-- Quick stats bar --}}
                    <div class="flex flex-wrap items-center gap-7 mt-10 pt-8 border-t border-white/10">
                        <div>
                            <p class="text-2xl font-bold text-white counter-num">{{ $placeCount }}+</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ __('messages.home.stats_total_places') }}</p>
                        </div>
                        <div class="w-px h-8 bg-white/10"></div>
                        <div>
                            <p class="text-2xl font-bold text-white counter-num">{{ $activeUser }}+</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ __('messages.home.stats_total_users') }}</p>
                        </div>
                        <div class="w-px h-8 bg-white/10"></div>
                        <div>
                            <p class="text-2xl font-bold text-white counter-num">{{ $eventCount }}+</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ __('messages.home.stats_total_events') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Right: hero image --}}
                <div class="relative flex justify-center lg:justify-end">
                    <div class="relative w-full max-w-md">
                        <picture>
                            <source srcset="{{ asset('home.webp') }}" type="image/webp">
                            <img src="{{ asset('home.webp') }}" alt="Qrun Platform" width="901" height="663"
                                fetchpriority="high" decoding="async"
                                class="w-full rounded-2xl shadow-2xl shadow-black/40 ring-1 ring-white/10 object-cover">
                        </picture>

                        {{-- Floating badge --}}
                        <div class="absolute -bottom-5 -left-5 glass text-white text-sm font-semibold px-4 py-3 rounded-2xl shadow-xl flex items-center gap-2.5">
                            <span class="w-2.5 h-2.5 bg-emerald-400 rounded-full shrink-0"></span>
                            Scan QR → Akses Informasi
                        </div>

                        {{-- Floating badge top right --}}
                        <div class="absolute -top-4 -right-4 glass text-white text-xs font-medium px-3 py-2 rounded-xl shadow-lg flex items-center gap-2">
                            <i class="fas fa-shield-alt text-blue-300"></i>
                            Digital Heritage
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Wave --}}
        <div class="wave-bottom">
            <svg viewBox="0 0 1440 56" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0,56 C480,0 960,0 1440,56 L1440,56 L0,56 Z" fill="white"/>
            </svg>
        </div>
    </section>

    {{-- ═══════════════════════════════════════ FEATURES ═══════════════════════════════════════ --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14 reveal">
                <span class="inline-block text-blue-600 text-sm font-semibold uppercase tracking-widest mb-3">Keunggulan</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    {{ __('messages.home.why_us_title') }}
                </h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">
                    {{ __('messages.home.why_us_subtitle') }}
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ([
                    ['icon' => 'fa-qrcode',         'bg' => 'bg-blue-50',    'icon_bg' => 'bg-blue-100',    'icon_c' => 'text-blue-600',    'key' => '1', 'delay' => '0ms'],
                    ['icon' => 'fa-landmark',        'bg' => 'bg-violet-50',  'icon_bg' => 'bg-violet-100',  'icon_c' => 'text-violet-600',  'key' => '2', 'delay' => '100ms'],
                    ['icon' => 'fa-mobile-alt',      'bg' => 'bg-emerald-50', 'icon_bg' => 'bg-emerald-100', 'icon_c' => 'text-emerald-600', 'key' => '3', 'delay' => '200ms'],
                    ['icon' => 'fa-users',           'bg' => 'bg-orange-50',  'icon_bg' => 'bg-orange-100',  'icon_c' => 'text-orange-600',  'key' => '4', 'delay' => '300ms'],
                ] as $feat)
                    <div class="lift {{ $feat['bg'] }} rounded-2xl p-7 border border-gray-100 reveal" style="transition-delay: {{ $feat['delay'] }}">
                        <div class="{{ $feat['icon_bg'] }} {{ $feat['icon_c'] }} w-12 h-12 rounded-xl flex items-center justify-center mb-5">
                            <i class="fas {{ $feat['icon'] }} text-xl"></i>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-2">
                            {{ __('messages.home.feature_' . $feat['key'] . '_title') }}
                        </h3>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            {{ __('messages.home.feature_' . $feat['key'] . '_desc') }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════ HOW IT WORKS ═══════════════════════════════════════ --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14 reveal">
                <span class="inline-block text-blue-600 text-sm font-semibold uppercase tracking-widest mb-3">Cara Kerja</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    {{ __('messages.home.how_to_title') }}
                </h2>
                <p class="text-gray-500 max-w-xl mx-auto">
                    {{ __('messages.home.how_to_subtitle') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-14">
                @foreach ([
                    ['step' => '01', 'icon' => 'fa-map-marker-alt', 'title' => 'Kunjungi Tempat',   'desc' => 'Temukan tempat bersejarah yang dilengkapi QR Code Qrun.',             'delay' => '0ms'],
                    ['step' => '02', 'icon' => 'fa-qrcode',          'title' => 'Scan QR Code',       'desc' => 'Scan QR Code menggunakan kamera HP — tidak perlu unduh aplikasi.',   'delay' => '150ms'],
                    ['step' => '03', 'icon' => 'fa-book-open',       'title' => 'Akses Informasi',    'desc' => 'Nikmati sejarah, galeri, dan informasi lengkap tentang tempat itu.',  'delay' => '300ms'],
                ] as $step)
                    <div class="text-center reveal" style="transition-delay: {{ $step['delay'] }}">
                        <div class="relative inline-flex items-center justify-center mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200">
                                <i class="fas {{ $step['icon'] }} text-white text-xl"></i>
                            </div>
                            <span class="absolute -top-2.5 -right-2.5 w-6 h-6 bg-white border-2 border-blue-500 text-blue-600 text-xs font-bold rounded-full flex items-center justify-center shadow-sm">
                                {{ $step['step'][1] }}
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $step['title'] }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed max-w-xs mx-auto">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>

            {{-- How-to video --}}
            <div class="reveal">
                <div class="rounded-2xl overflow-hidden shadow-2xl bg-gray-900 ring-1 ring-black/10">
                    <iframe width="100%" height="420" loading="lazy"
                        src="https://www.youtube-nocookie.com/embed/W5IUwH-tk8g?si=_2OtIl56GzFtULGh"
                        title="Cara Pakai Qrun" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen class="block"></iframe>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════ STATS ═══════════════════════════════════════ --}}
    <section class="py-16 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 reveal">
                <h2 class="text-3xl lg:text-4xl font-bold text-white mb-3">
                    {{ __('messages.home.stats_title') }}
                </h2>
                <p class="text-blue-200 text-lg">{{ __('messages.home.stats_subtitle') }}</p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 reveal">
                @foreach ([
                    ['id' => 'statPlaces',       'val' => $placeCount,        'icon' => 'fa-map-marker-alt', 'label' => __('messages.home.stats_total_places'),        'sub' => null],
                    ['id' => 'statEventsAll',    'val' => $eventCount,        'icon' => 'fa-calendar-alt',   'label' => __('messages.home.stats_total_events'),        'sub' => null],
                    ['id' => 'statEventsActive', 'val' => $eventActiveCount,  'icon' => 'fa-play-circle',    'label' => __('messages.home.stats_active_events'),       'sub' => __('messages.home.stats_active_events_status')],
                    ['id' => 'statEventsEnded',  'val' => $endedEvent,        'icon' => 'fa-check-circle',   'label' => __('messages.home.stats_ended_events'),        'sub' => __('messages.home.stats_ended_events_status')],
                    ['id' => 'statUsers',        'val' => $activeUser,        'icon' => 'fa-users',          'label' => __('messages.home.stats_total_users'),         'sub' => null],
                ] as $stat)
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-5 text-center border border-white/10">
                        <div class="w-9 h-9 bg-white/15 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <i class="fas {{ $stat['icon'] }} text-white text-sm"></i>
                        </div>
                        <div class="counter-num text-3xl font-extrabold text-white mb-1" id="{{ $stat['id'] }}">{{ $stat['val'] }}</div>
                        <div class="text-blue-200 text-sm font-medium leading-tight">{{ $stat['label'] }}</div>
                        @if ($stat['sub'])
                            <div class="text-blue-300 text-xs mt-1 leading-tight">{{ $stat['sub'] }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════ VISION / MISSION ═══════════════════════════════════════ --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-14 reveal">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 text-blue-600 text-sm font-semibold mb-4">
                    <i class="fas fa-landmark text-xs"></i>
                    {{ __('messages.home.about_label') }}
                </span>
                <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 mb-4">
                    {{ __('messages.home.about_title') }}
                </h2>
                <p class="text-gray-500 text-lg max-w-3xl mx-auto">
                    {{ __('messages.home.about_subtitle') }}
                </p>
            </div>

            {{-- Vision banner --}}
            <div class="relative bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-8 lg:p-12 shadow-xl mb-6 text-white overflow-hidden reveal">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>
                <div class="relative flex flex-col sm:flex-row items-start gap-6">
                    <div class="bg-white/20 p-4 rounded-2xl shrink-0">
                        <i class="fas fa-eye text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold mb-3">{{ __('messages.home.vision_title') }}</h3>
                        <p class="text-blue-100 text-lg leading-relaxed">{{ __('messages.home.vision_text') }}</p>
                    </div>
                </div>
            </div>

            {{-- Mission + Values --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100 reveal">
                    <div class="flex items-center mb-6">
                        <div class="bg-blue-100 text-blue-600 p-3 rounded-xl mr-4">
                            <i class="fas fa-bullseye text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">{{ __('messages.home.mission_title') }}</h3>
                    </div>
                    <div class="space-y-3">
                        @foreach (range(1, 5) as $i)
                            <div class="flex items-start gap-3">
                                <span class="w-7 h-7 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">{{ $i }}</span>
                                <p class="text-gray-600 text-sm leading-relaxed">{{ __('messages.home.mission_' . $i) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100 reveal">
                    <div class="flex items-center mb-6">
                        <div class="bg-emerald-100 text-emerald-600 p-3 rounded-xl mr-4">
                            <i class="fas fa-gem text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">{{ __('messages.home.values_title') }}</h3>
                    </div>
                    <div class="space-y-3">
                        @foreach ([
                            ['quality',       'fa-star',      'bg-yellow-100 text-yellow-600'],
                            ['innovation',    'fa-lightbulb', 'bg-blue-100 text-blue-600'],
                            ['preservation',  'fa-monument',  'bg-violet-100 text-violet-600'],
                            ['collaboration', 'fa-handshake', 'bg-emerald-100 text-emerald-600'],
                        ] as [$key, $icon, $cls])
                            <div class="flex items-start gap-3 bg-white rounded-2xl p-4 border border-gray-100">
                                <div class="{{ $cls }} w-8 h-8 rounded-lg flex items-center justify-center shrink-0">
                                    <i class="fas {{ $icon }} text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 text-sm">{{ __('messages.home.value_' . $key . '_title') }}</h4>
                                    <p class="text-gray-500 text-xs mt-0.5 leading-relaxed">{{ __('messages.home.value_' . $key . '_desc') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════ VIDEO INTRO ═══════════════════════════════════════ --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="reveal mb-10">
                <span class="inline-block text-blue-600 text-sm font-semibold uppercase tracking-widest mb-3">Video</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Kenali Qrun Lebih Dekat</h2>
                <p class="text-gray-500 max-w-lg mx-auto">
                    Tonton video perkenalan platform Qrun dan bagaimana kami melestarikan warisan budaya secara digital.
                </p>
            </div>
            <div class="reveal rounded-2xl overflow-hidden shadow-2xl bg-gray-900 ring-1 ring-gray-200">
                <iframe width="100%" height="440" loading="lazy"
                    src="https://www.youtube-nocookie.com/embed/cwQX8Ov0A_M?si=RdtQLg3E1EPhuCf9"
                    title="Qrun Online" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen class="block"></iframe>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════ GALLERY ═══════════════════════════════════════ --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 reveal">
                <span class="inline-block text-blue-600 text-sm font-semibold uppercase tracking-widest mb-3">Galeri</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    {{ __('messages.home.gallery_title') }}
                </h2>
                <p class="text-gray-500 max-w-xl mx-auto">
                    {{ __('messages.home.gallery_subtitle') }}
                </p>
            </div>

            <div id="gallery-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"></div>

            <div class="flex justify-center mt-10">
                <button id="load-more"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold rounded-xl transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5">
                    <i class="fas fa-plus-circle text-sm"></i>
                    {{ __('messages.home.gallery_load_more') }}
                </button>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════ BLOG ═══════════════════════════════════════ --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-12 gap-4">
                <div class="reveal">
                    <span class="inline-block text-blue-600 text-sm font-semibold uppercase tracking-widest mb-3">Blog</span>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">
                        {{ __('messages.home.blog_title') }}
                    </h2>
                    <p class="text-gray-500">{{ __('messages.home.blog_subtitle') }}</p>
                </div>
                <a href="{{ route('blog') }}"
                    class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold text-sm shrink-0 reveal transition-colors">
                    {{ __('messages.home.blog_view_all') }} <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                @forelse ($blogs as $blog)
                    <article class="blog-card bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm reveal">
                        <div class="relative overflow-hidden h-52">
                            <img src="{{ asset($blog->image_url) }}" alt="{{ $blog->title }}"
                                width="400" height="208" loading="lazy" decoding="async"
                                class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-3 text-xs text-gray-400 mb-3">
                                <span class="inline-flex items-center gap-1.5">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ \Carbon\Carbon::parse($blog->created_at)->format('d M Y') }}
                                </span>
                                <span>·</span>
                                <span class="inline-flex items-center gap-1.5">
                                    <i class="fas fa-eye"></i>
                                    @php
                                        $v = $blog->views;
                                        echo $v < 1000 ? $v : number_format($v / 1000, 1) . 'K';
                                    @endphp
                                </span>
                            </div>
                            <h3 class="text-base font-bold text-gray-900 mb-2 line-clamp-2 hover:text-blue-600 transition-colors">
                                <a href="/blog/{{ $blog->slug }}">{{ $blog->title }}</a>
                            </h3>
                            <p class="text-gray-500 text-sm leading-relaxed line-clamp-2 mb-4">{{ $blog->description }}</p>
                            <a href="/blog/{{ $blog->slug }}"
                                class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-700 text-sm font-semibold transition-colors">
                                {{ __('messages.home.blog_read_more') }} <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-20">
                        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fas fa-newspaper text-2xl text-gray-300"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ __('messages.home.blog_no_articles_title') }}</h3>
                        <p class="text-gray-400 text-sm">{{ __('messages.home.blog_no_articles_desc') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════ CTA ═══════════════════════════════════════ --}}
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-br from-slate-900 to-blue-900 rounded-3xl p-10 lg:p-16 text-center overflow-hidden reveal">
                <div class="absolute top-0 right-0 w-72 h-72 bg-blue-500/10 rounded-full -translate-y-1/2 translate-x-1/3 pointer-events-none blur-2xl"></div>
                <div class="absolute bottom-0 left-0 w-72 h-72 bg-violet-500/10 rounded-full translate-y-1/2 -translate-x-1/3 pointer-events-none blur-2xl"></div>
                <div class="relative">
                    <span class="inline-flex items-center gap-2 bg-blue-500/20 border border-blue-400/30 text-blue-300 text-sm font-medium px-4 py-2 rounded-full mb-6">
                        <i class="fas fa-rocket text-xs"></i>
                        Bergabung Sekarang
                    </span>
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-white mb-4">
                        {{ __('messages.home.cta_title') }}
                    </h2>
                    <p class="text-gray-300 text-lg max-w-2xl mx-auto mb-9 leading-relaxed">
                        {{ __('messages.home.cta_subtitle') }}
                    </p>
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 bg-white text-gray-900 font-bold px-9 py-4 rounded-xl hover:bg-gray-50 transition-all shadow-xl hover:-translate-y-0.5 active:translate-y-0">
                        {{ __('messages.home.cta_btn') }}
                        <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Image modal --}}
    <div id="imageModal"
        class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="relative max-w-4xl w-full">
            <button id="closeModal"
                class="absolute -top-12 right-0 text-white/70 hover:text-white text-2xl transition-colors">
                <i class="fas fa-times"></i>
            </button>
            <img id="modalImage" alt="" loading="lazy"
                class="w-full max-h-[80vh] object-contain rounded-2xl shadow-2xl">
            <div class="text-center mt-5">
                <h3 id="modalTitle" class="text-white text-lg font-semibold"></h3>
            </div>
        </div>
    </div>

    </main>

    {{-- Footer --}}
    @include('Components.FooterHome')

    <script>
        const i18n = {
            loadMore:          @json(__('messages.home.gallery_load_more')),
            loading:           @json(__('messages.global_loading')),
            galleryEmptyTitle: @json(__('messages.home.gallery_empty_title')),
            galleryEmptyDesc:  @json(__('messages.home.gallery_empty_desc')),
        };

        // Mobile menu
        const mobileMenuBtn = document.querySelector('.mobile-menu-button');
        const mobileMenu    = document.querySelector('.mobile-menu');
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
        }

        // Scroll reveal via IntersectionObserver
        const io = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08 });
        document.querySelectorAll('.reveal').forEach(el => io.observe(el));

        // Counter animation
        function animateCounter(id, target, duration = 1800) {
            const el = document.getElementById(id);
            if (!el || target === 0) return;
            const step = target / (duration / 16);
            let cur = 0;
            const t = setInterval(() => {
                cur += step;
                if (cur >= target) { el.textContent = Math.floor(target); clearInterval(t); }
                else { el.textContent = Math.floor(cur); }
            }, 16);
        }

        // Trigger counters when stats section is visible
        const statsSection = document.querySelector('#statPlaces')?.closest('section');
        if (statsSection) {
            const statsObserver = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    animateCounter('statPlaces',       {{ $placeCount }});
                    animateCounter('statEventsAll',    {{ $eventCount }});
                    animateCounter('statEventsActive', {{ $eventActiveCount }});
                    animateCounter('statEventsEnded',  {{ $endedEvent }});
                    animateCounter('statUsers',        {{ $activeUser }});
                    statsObserver.disconnect();
                }
            }, { threshold: 0.2 });
            statsObserver.observe(statsSection);
        }

        // Gallery modal
        const modal         = document.getElementById('imageModal');
        const modalImage    = document.getElementById('modalImage');
        const modalTitle    = document.getElementById('modalTitle');
        const closeModalBtn = document.getElementById('closeModal');

        document.addEventListener('click', function(e) {
            const item = e.target.closest('.gallery-item');
            if (item) {
                modalImage.src = item.dataset.image;
                modalImage.alt = item.dataset.title;
                modalTitle.textContent = item.dataset.title;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        });

        function closeModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        closeModalBtn.addEventListener('click', closeModal);
        // Close when clicking anywhere outside the image itself (backdrop,
        // the wrapper around the image, or the title area).
        modal.addEventListener('click', e => { if (!e.target.closest('#modalImage')) closeModal(); });
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
        });

        // Gallery lazy-load
        let page    = 1;
        let loading = false;

        function renderGalleryItem(item) {
            return `
                <div class="gallery-item relative group rounded-2xl overflow-hidden cursor-pointer aspect-square bg-gray-100"
                    data-image="${item.image_url}" data-title="${item.title}">
                    <img src="${item.image_url}" alt="${item.title}"
                        class="w-full h-full object-cover" loading="lazy">
                    <div class="g-overlay absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent flex items-end p-3">
                        <p class="text-white text-xs font-medium line-clamp-2 leading-tight">${item.title}</p>
                    </div>
                    <div class="g-overlay absolute inset-0 flex items-center justify-center">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                            <i class="fas fa-expand-alt text-white text-sm"></i>
                        </div>
                    </div>
                </div>
            `;
        }

        function loadGallery() {
            if (loading) return;
            loading = true;
            $('#load-more').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2 text-sm"></i>' + i18n.loading);

            $.get("{{ route('gallery.ajax-list') }}", { page }, function(res) {
                if (res.data && res.data.length > 0) {
                    res.data.forEach(item => $('#gallery-grid').append(renderGalleryItem(item)));
                    if (res.next_page) {
                        page = res.next_page;
                        $('#load-more').show().prop('disabled', false)
                            .html('<i class="fas fa-plus-circle text-sm mr-2"></i>' + i18n.loadMore);
                    } else {
                        $('#load-more').hide();
                    }
                } else if (page === 1) {
                    $('#gallery-grid').html(`
                        <div class="col-span-full flex flex-col items-center justify-center py-16">
                            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                                <i class="fas fa-images text-2xl text-gray-300"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">${i18n.galleryEmptyTitle}</h3>
                            <p class="text-gray-400 text-sm">${i18n.galleryEmptyDesc}</p>
                        </div>
                    `);
                    $('#load-more').hide();
                }
                loading = false;
            });
        }

        {{-- jQuery is deferred, so it is ready by DOMContentLoaded --}}
        window.addEventListener('DOMContentLoaded', function() {
            loadGallery();
            $('#load-more').on('click', function() { loadGallery(); });
        });
    </script>
</body>

</html>
