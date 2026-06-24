<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ebook Qrun Online | Perpustakaan Digital Sejarah, Budaya & Wisata</title>

    <meta name="description"
        content="Jelajahi koleksi ebook Qrun Online seputar sejarah, budaya, wisata, dan teknologi QR digital. Baca online secara gratis.">
    <meta name="keywords"
        content="ebook qrun online, perpustakaan digital, buku sejarah, budaya indonesia, wisata, digital heritage">
    <meta name="author" content="Qrun Online">
    <meta name="robots" content="noindex, nofollow">
    <link rel="canonical" href="https://qrun.online/ebook">
    <meta name="theme-color" content="#2d4373">
    <link rel="icon" type="image/png" href="{{ asset('transparent-logo.png') }}">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Qrun Online">
    <meta property="og:title" content="Ebook Qrun Online | Perpustakaan Digital">
    <meta property="og:description" content="Koleksi ebook sejarah, budaya, wisata, dan teknologi QR digital dari Qrun Online.">
    <meta property="og:url" content="https://qrun.online/ebook">
    <meta property="og:image" content="https://qrun.online/home.jpg">

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "CollectionPage",
        "name": "Qrun Online Ebook Library",
        "url": "https://qrun.online/ebook",
        "description": "Perpustakaan digital Qrun Online berisi ebook sejarah, budaya, wisata, dan teknologi QR.",
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

        .book-card { transition: transform 0.25s ease, box-shadow 0.25s ease; }
        .book-card:hover { transform: translateY(-4px); }
        .book-cover { transition: box-shadow 0.25s ease; box-shadow: 0 6px 16px rgba(0,0,0,0.12); }
        .book-card:hover .book-cover { box-shadow: 0 14px 30px rgba(0,0,0,0.20); }

        .line-clamp-2 {
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }

        #search:focus { outline: none; box-shadow: 0 0 0 3px rgba(59,130,246,0.25); }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 99px; }
    </style>
</head>

<body class="bg-gray-50 antialiased">
    @include('Components.Navbar')

    {{-- ═══════════ HEADER ═══════════ --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-900 py-16">
        <div class="absolute top-0 right-0 w-72 h-72 bg-blue-500 rounded-full opacity-[0.07] blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-violet-500 rounded-full opacity-[0.07] blur-3xl pointer-events-none"></div>

        <div class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 bg-blue-500/20 border border-blue-400/30 text-blue-300 text-sm font-medium px-4 py-2 rounded-full mb-6">
                <i class="fas fa-book-open text-xs"></i>
                Perpustakaan Digital
            </div>
            <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-4 leading-tight">
                Jelajahi Koleksi Ebook
            </h1>
            <p class="text-blue-200 text-lg mb-8">
                Baca ebook sejarah, budaya, wisata, dan teknologi QR digital secara gratis.
            </p>

            <div class="relative max-w-lg mx-auto">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                <input type="text" id="search"
                    placeholder="Cari judul, penulis, atau kategori..."
                    class="w-full bg-white text-gray-900 placeholder-gray-400 text-sm font-medium pl-11 pr-4 py-3.5 rounded-xl border-0 shadow-lg">
            </div>
        </div>
    </section>

    {{-- ═══════════ CATALOG ═══════════ --}}
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-8">
                <h2 class="text-xl font-bold text-gray-900">
                    Semua Ebook
                    <span class="text-sm font-medium text-gray-400">({{ count($ebooks) }})</span>
                </h2>
            </div>

            <div id="ebook-grid"
                class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-x-6 gap-y-10">

                @forelse ($ebooks as $ebook)
                    <a href="/ebook/{{ $ebook->slug }}"
                        class="book-card group block"
                        data-search="{{ Str::lower($ebook->title . ' ' . $ebook->author . ' ' . $ebook->category) }}">

                        <div class="book-cover relative rounded-lg overflow-hidden bg-gray-100 aspect-[3/4] mb-3">
                            <img src="{{ asset($ebook->image_url) }}" alt="{{ $ebook->title }}"
                                class="w-full h-full object-cover" loading="lazy">

                            @if ($ebook->category)
                                <span class="absolute top-2 left-2 bg-white/90 backdrop-blur text-[11px] font-semibold text-blue-700 px-2 py-0.5 rounded-full">
                                    {{ $ebook->category }}
                                </span>
                            @endif
                        </div>

                        <h3 class="text-sm font-bold text-gray-900 leading-snug line-clamp-2 group-hover:text-blue-600 transition-colors">
                            {{ $ebook->title }}
                        </h3>

                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-user-pen text-[10px] mr-1"></i>
                            {{ $ebook->author ?: 'Qrun Online' }}
                        </p>
                    </a>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fas fa-book text-2xl text-gray-300"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Belum Ada Ebook</h3>
                        <p class="text-sm text-gray-400 mt-1">Koleksi ebook akan segera hadir.</p>
                    </div>
                @endforelse

            </div>

            {{-- Empty search result --}}
            <div id="no-result" class="hidden flex-col items-center justify-center py-20 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fas fa-magnifying-glass text-2xl text-gray-300"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Tidak Ditemukan</h3>
                <p class="text-sm text-gray-400 mt-1">Coba kata kunci lain.</p>
            </div>

        </div>
    </section>

    @include('Components.FooterHome')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // Client-side filter over the rendered catalog
        $('#search').on('input', function () {
            const q = $(this).val().trim().toLowerCase();
            let visible = 0;

            $('#ebook-grid .book-card').each(function () {
                const match = $(this).data('search').toString().includes(q);
                $(this).toggle(match);
                if (match) visible++;
            });

            $('#no-result').toggleClass('hidden', visible !== 0).toggleClass('flex', visible === 0);
        });
    </script>
</body>

</html>
