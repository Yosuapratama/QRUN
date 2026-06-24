<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $ebookPlace->name }} | E-Book Digital Qrun</title>
    <meta name="description" content="Koleksi e-book yang tersedia di {{ $ebookPlace->name }}. Scan, pilih, dan baca gratis.">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="{{ asset('transparent-logo.png') }}">
    <meta name="theme-color" content="#2d4373">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        * { font-family: 'Inter', sans-serif; }
        html { scroll-behavior: smooth; }
        body { font-size: 17px; color:#1f2937; }

        /* Card */
        .book-card {
            background:#fff; border:1px solid #f0f2f6; border-radius:16px; overflow:hidden;
            box-shadow:0 1px 2px rgba(16,24,40,.04), 0 10px 22px rgba(16,24,40,.05);
            transition: transform .28s ease, box-shadow .28s ease;
            height:100%; display:flex; flex-direction:column;
        }
        .book-card:hover { transform: translateY(-6px); box-shadow:0 2px 4px rgba(16,24,40,.05), 0 22px 40px rgba(37,99,235,.16); }
        .book-cover { overflow:hidden; position:relative; }
        .book-cover::after { content:""; position:absolute; inset:0;
            background:linear-gradient(to top, rgba(16,24,40,.16), rgba(16,24,40,0) 38%); opacity:0; transition:opacity .28s ease; }
        .book-card:hover .book-cover::after { opacity:1; }
        .book-cover img { transition: transform .5s ease; }
        .book-card:hover .book-cover img { transform: scale(1.05); }

        /* Readable text */
        .book-title { font-size:1.05rem; line-height:1.45; font-weight:700; color:#111827; }
        .book-author { font-size:.9rem; color:#4b5563; }
        .cat-badge { font-size:.8rem; font-weight:600; }

        .line-clamp-2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }

        /* Search + chips */
        #search:focus { outline:none; box-shadow:0 0 0 4px rgba(59,130,246,0.30); }
        .cat-chip {
            white-space:nowrap; flex:0 0 auto; cursor:pointer;
            font-size:.95rem; font-weight:600; line-height:1;
            padding:.55rem 1.05rem; border-radius:999px;
            border:1px solid #e5e7eb; background:#fff; color:#4b5563;
            transition: background .2s ease, color .2s ease, border-color .2s ease, transform .15s ease, box-shadow .2s ease;
        }
        .cat-chip:hover { transform: translateY(-1px); border-color:#cbd5e1; color:#1f2937; }
        .cat-chip.active { background:#2563eb; color:#fff; border-color:#2563eb; box-shadow:0 4px 12px rgba(37,99,235,.30); }

        /* Horizontal chips: hide scrollbar + soft fade on the right */
        .chips-scroll { display:flex; align-items:center; gap:.55rem; overflow-x:auto; scrollbar-width:none; -ms-overflow-style:none; padding-bottom:2px; }
        .chips-scroll::-webkit-scrollbar { display:none; }
        .chips-fade { position:absolute; top:0; right:0; bottom:0; width:46px; pointer-events:none;
            display:flex; align-items:center; justify-content:flex-end; padding-right:3px;
            background:linear-gradient(to right, rgba(255,255,255,0), rgba(255,255,255,.96));
            transition:opacity .3s ease; }
        .chips-fade.hide { opacity:0; }
        .chips-chevron { color:#2563eb; font-size:.82rem; animation: nudgeX 1.2s ease-in-out infinite; }
        @keyframes nudgeX { 0%,100%{ transform:translateX(0);} 50%{ transform:translateX(4px);} }

        /* Scroll-down cue (hides after scrolling) */
        .scroll-cue { position:fixed; left:50%; bottom:16px; transform:translateX(-50%); z-index:45;
            display:inline-flex; align-items:center; gap:.4rem; color:#fff; font-size:.72rem; font-weight:600;
            background:rgba(15,23,42,.6); padding:.4rem .85rem; border-radius:9999px;
            -webkit-backdrop-filter:blur(5px); backdrop-filter:blur(5px); box-shadow:0 6px 18px rgba(0,0,0,.2);
            transition:opacity .4s ease, transform .4s ease; pointer-events:none; }
        .scroll-cue i { animation: bounceY 1.3s ease-in-out infinite; }
        @keyframes bounceY { 0%,100%{ transform:translateY(0);} 50%{ transform:translateY(3px);} }
        .scroll-cue.hide { opacity:0; transform:translateX(-50%) translateY(8px); }

        /* View toggle */
        .view-toggle .vt-btn { width:40px; height:34px; border:none; background:transparent; border-radius:9px;
            color:#6b7280; display:flex; align-items:center; justify-content:center; transition:.15s ease; }
        .view-toggle .vt-btn:hover { color:#2563eb; }
        .view-toggle .vt-btn.active { background:#2563eb; color:#fff; box-shadow:0 4px 10px rgba(37,99,235,.25); }

        /* Layouts */
        .layout-grid { display:grid; grid-template-columns:repeat(2, minmax(0,1fr)); gap:1.25rem; }
        @media (min-width:640px){ .layout-grid{ grid-template-columns:repeat(3, minmax(0,1fr)); gap:1.75rem; } }
        @media (min-width:1024px){ .layout-grid{ grid-template-columns:repeat(4, minmax(0,1fr)); } }

        .layout-list { display:flex; flex-direction:column; gap:.85rem; }
        .layout-list .book-card { flex-direction:row; align-items:stretch; }
        .layout-list .book-cover { width:90px; flex:0 0 auto; }
        .layout-list .book-cover::after { display:none; }
        .layout-list .cat-badge { display:none; }
        .layout-list .book-meta { justify-content:center; padding:.85rem 1rem; }
        .layout-list .book-card:hover { transform:translateY(-3px); }

        /* Social icons (hero) — grouped frosted bar */
        .social-bar { display:inline-flex; flex-wrap:wrap; gap:.3rem; padding:.4rem;
            background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.16); border-radius:16px;
            -webkit-backdrop-filter:blur(6px); backdrop-filter:blur(6px); }
        .social-btn { width:40px; height:40px; border-radius:9999px; display:inline-flex; align-items:center; justify-content:center;
            background:transparent; color:#fff; font-size:1.05rem; transition: background .2s ease, transform .15s ease; }
        .social-btn:hover { background:rgba(255,255,255,.20); transform:translateY(-1px); }

        /* Floating action buttons */
        .fab-wrap { position:fixed; right:18px; bottom:18px; z-index:50; display:flex; flex-direction:column; align-items:flex-end; gap:12px; }
        .fab { width:56px; height:56px; border-radius:50%; display:flex; align-items:center; justify-content:center;
            color:#fff; font-size:26px; box-shadow:0 10px 24px rgba(0,0,0,.25); transition:transform .2s ease, box-shadow .2s ease; }
        .fab:hover { transform:translateY(-3px) scale(1.04); box-shadow:0 14px 30px rgba(0,0,0,.30); }
        .fab-wa { background:#25D366; }
        .fab-res { background:#2563eb; }
        @media (prefers-reduced-motion: reduce) { .fab:hover, .social-btn:hover { transform:none; } }

        /* Subtle entrance animation (once) */
        .reveal { opacity:0; transform: translateY(18px); }
        .reveal.in { opacity:1; transform:none; transition: opacity .5s ease, transform .5s ease; }

        .fab {
            box-shadow:none;
        }
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior:auto; }
            .book-card, .book-cover img, .reveal, .reveal.in, .cat-chip { transition:none !important; transform:none !important; }
            .reveal { opacity:1 !important; }
            .chips-chevron, .scroll-cue i { animation:none !important; }
        }

        ::-webkit-scrollbar { width:6px; }
        ::-webkit-scrollbar-thumb { background:#3b82f6; border-radius:99px; }

        /* ── Ads / promo modal player ───────────────────────────────── */
        .ads-modal { position:fixed; inset:0; z-index:60; display:none; align-items:center; justify-content:center; padding:16px; }
        .ads-modal.open { display:flex; }
        .ads-overlay { position:absolute; inset:0; background:rgba(15,23,42,.72);
            -webkit-backdrop-filter:blur(3px); backdrop-filter:blur(3px); animation:adsFade .25s ease; }
        .ads-panel { position:relative; width:100%; max-width:520px; background:#0b1120; border-radius:20px; overflow:hidden;
            box-shadow:0 30px 70px rgba(0,0,0,.5); animation:adsPop .3s cubic-bezier(.2,.9,.3,1.2); }
        @keyframes adsFade { from{ opacity:0; } to{ opacity:1; } }
        @keyframes adsPop { from{ opacity:0; transform:translateY(14px) scale(.97); } to{ opacity:1; transform:none; } }

        .ads-x { position:absolute; top:12px; left:12px; z-index:20; width:38px; height:38px; border-radius:9999px;
            background:rgba(0,0,0,.5); color:#fff; display:flex; align-items:center; justify-content:center; font-size:1rem;
            -webkit-backdrop-filter:blur(4px); backdrop-filter:blur(4px); transition:background .2s ease; }
        .ads-x:hover { background:rgba(0,0,0,.75); }

        .ads-stage { position:relative; overflow:hidden; }
        .ads-track { display:flex; transition:transform .5s ease; }
        .ads-slide { min-width:100%; position:relative; }
        .ads-slide img { width:100%; height:440px; object-fit:cover; display:block; background:#0b1120; }
        @media (max-width:640px){ .ads-slide img { height:360px; } }
        .ads-caption { position:absolute; left:0; right:0; bottom:0; padding:34px 18px 16px;
            color:#fff; font-size:1.02rem; font-weight:700; line-height:1.4;
            background:linear-gradient(to top, rgba(0,0,0,.82), rgba(0,0,0,0)); }

        .ads-nav { position:absolute; top:50%; transform:translateY(-50%); z-index:15; width:42px; height:42px; border-radius:9999px;
            background:rgba(0,0,0,.5); color:#fff; display:flex; align-items:center; justify-content:center;
            -webkit-backdrop-filter:blur(4px); backdrop-filter:blur(4px); transition:background .2s ease; }
        .ads-nav:hover { background:rgba(0,0,0,.75); }
        .ads-prev { left:12px; } .ads-next { right:12px; }
        .ads-play { position:absolute; top:12px; right:12px; z-index:15; padding:.5rem .9rem; border-radius:12px;
            background:rgba(0,0,0,.5); color:#fff; font-size:.82rem; -webkit-backdrop-filter:blur(4px); backdrop-filter:blur(4px);
            transition:background .2s ease; }
        .ads-play:hover { background:rgba(0,0,0,.75); }
        .ads-dots { position:absolute; bottom:14px; left:50%; transform:translateX(-50%); z-index:15; display:flex; gap:8px; }
        .ads-dot { width:9px; height:9px; border-radius:9999px; background:rgba(255,255,255,.5); transition:all .3s ease; }
        .ads-dot.active { width:24px; background:#fff; }

        .ads-reopen { position:fixed; left:18px; bottom:18px; z-index:50; width:52px; height:52px; border-radius:9999px;
            background:#7c3aed; color:#fff; font-size:20px; display:flex; align-items:center; justify-content:center;
            box-shadow:0 10px 24px rgba(124,58,237,.4); transition:transform .2s ease; }
        .ads-reopen:hover { transform:translateY(-3px) scale(1.05); }

        @media (prefers-reduced-motion: reduce) {
            .ads-track { transition:none !important; }
            .ads-overlay, .ads-panel { animation:none !important; }
            .ads-reopen:hover { transform:none; }
        }
    </style>
</head>

<body class="bg-gray-50 antialiased">

    {{-- HEADER (compact on mobile) --}}
    <header class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-900 pt-6 pb-5 sm:py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-3 mb-4 sm:mb-5">
                <div class="flex items-center gap-2.5">
                    <img src="{{ asset('transparent-logo.png') }}" alt="Qrun" class="h-7 sm:h-9 w-auto">
                    <span class="text-white/70 text-xs sm:text-sm font-medium">E-Book</span>
                </div>
                @if ($ebookPlace->logo_url)
                    <div class="bg-white rounded-xl p-1.5 sm:p-2.5 shadow-lg shrink-0">
                        <img src="{{ asset($ebookPlace->logo_url) }}" alt="{{ $ebookPlace->name }} logo"
                            class="h-9 sm:h-12 w-auto max-w-[110px] sm:max-w-[160px] object-contain">
                    </div>
                @endif
            </div>

            <div class="inline-flex items-center gap-2 bg-blue-500/20 border border-blue-400/30 text-blue-100 text-xs sm:text-sm font-medium px-3 py-1.5 sm:px-4 sm:py-2 rounded-full mb-2 sm:mb-3">
                <i class="fas fa-location-dot text-[10px] sm:text-xs"></i> {{ $ebookPlace->name }}
            </div>
            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight">
                E-Book di {{ $ebookPlace->name }}
            </h1>
            @if ($ebookPlace->description)
                <div class="mt-3 max-w-2xl">
                    <p id="placeDesc" data-expanded="false"
                        class="text-blue-200 text-xs sm:text-sm leading-relaxed line-clamp-2">{{ $ebookPlace->description }}</p>
                    <button type="button" id="descToggle"
                        class="hidden mt-1.5 inline-flex items-center gap-1 text-blue-300 hover:text-white text-sm font-semibold transition-colors">
                        <span class="label">Selengkapnya</span>
                        <i class="fas fa-chevron-down text-[10px]"></i>
                    </button>
                </div>
            @endif

            @php
                $norm = fn ($v) => $v ? (\Illuminate\Support\Str::startsWith($v, ['http://', 'https://']) ? $v : 'https://' . ltrim($v, '/')) : null;
                $waUrl = $ebookPlace->whatsapp
                    ? (\Illuminate\Support\Str::startsWith($ebookPlace->whatsapp, ['http://', 'https://'])
                        ? $ebookPlace->whatsapp
                        : 'https://wa.me/' . preg_replace('/[^0-9]/', '', $ebookPlace->whatsapp))
                    : null;
                $resUrl = $norm($ebookPlace->reservation);
                $socials = array_values(array_filter([
                    ['url' => $norm($ebookPlace->instagram), 'icon' => 'fab fa-instagram',  'label' => 'Instagram'],
                    ['url' => $norm($ebookPlace->tiktok),    'icon' => 'fab fa-tiktok',     'label' => 'TikTok'],
                    ['url' => $norm($ebookPlace->youtube),   'icon' => 'fab fa-youtube',    'label' => 'YouTube'],
                    ['url' => $norm($ebookPlace->linkedin),  'icon' => 'fab fa-linkedin-in','label' => 'LinkedIn'],
                    ['url' => $ebookPlace->email ? 'mailto:' . $ebookPlace->email : null, 'icon' => 'fas fa-envelope', 'label' => 'Email'],
                    ['url' => $waUrl, 'icon' => 'fab fa-whatsapp', 'label' => 'WhatsApp'],
                    ['url' => $norm($ebookPlace->website), 'icon' => 'fas fa-globe', 'label' => 'Website'],
                    ['url' => $resUrl, 'icon' => 'fas fa-calendar-check', 'label' => 'Reservasi'],
                ], fn ($s) => !empty($s['url'])));
            @endphp

            @if (count($socials))
                <div class="mt-5">
                    <div class="social-bar">
                        @foreach ($socials as $s)
                            <a href="{{ $s['url'] }}" target="_blank" rel="noopener" aria-label="{{ $s['label'] }}" title="{{ $s['label'] }}"
                                class="social-btn">
                                <i class="{{ $s['icon'] }}"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </header>

    {{-- STICKY TOOLBAR: search + categories (floats on scroll) --}}
    <div class="bg-white/95 backdrop-blur border-b sticky top-0 z-20 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-3 space-y-3">

            {{-- Search --}}
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                <input type="text" id="search" autocomplete="off" placeholder="Ketik judul disini..."
                    class="w-full bg-gray-100 focus:bg-white text-gray-900 placeholder-gray-500 text-base pl-11 pr-11 py-3 rounded-xl border border-gray-200 focus:border-blue-300 focus:ring-0 transition-colors">
                <button type="button" id="searchClear"
                    class="hidden absolute right-3 top-1/2 -translate-y-1/2 w-7 h-7 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-600 items-center justify-center transition-colors">
                    <i class="fas fa-xmark text-sm"></i>
                </button>
            </div>

            {{-- Categories --}}
            @if ($categories->isNotEmpty())
                <div class="relative">
                    <div class="chips-scroll">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide pr-1 shrink-0">Kategori</span>
                        <button class="cat-chip active" data-cat="">Semua</button>
                        @foreach ($categories as $cat)
                            <button class="cat-chip" data-cat="{{ $cat }}">{{ $cat }}</button>
                        @endforeach
                    </div>
                    <span class="chips-fade"><i class="fas fa-chevron-right chips-chevron"></i></span>
                </div>
            @endif
        </div>
    </div>

    {{-- CATALOG --}}
    <section class="pt-6 pb-12 sm:py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Result count + view toggle --}}
            <div class="flex items-center justify-between mb-5">
                <p class="text-sm text-gray-500"><span id="resultCount">{{ $total }}</span> e-book</p>
                <div class="inline-flex items-center bg-white border border-gray-200 rounded-xl p-1 view-toggle shadow-sm">
                    <button type="button" id="viewGrid" class="vt-btn active" aria-label="Grid view"><i class="fas fa-th-large"></i></button>
                    <button type="button" id="viewList" class="vt-btn" aria-label="List view"><i class="fas fa-list"></i></button>
                </div>
            </div>

            <div id="ebook-grid" class="layout-grid">
                @include('partials.ebook-scan-cards', ['ebooks' => $ebooks, 'ebookPlace' => $ebookPlace])
            </div>

            {{-- Loading skeleton --}}
            <div id="ebkLoading" class="hidden justify-center py-10">
                <i class="fas fa-spinner fa-spin text-2xl text-blue-500"></i>
            </div>

            {{-- Infinite scroll: loader + sentinel (no button) --}}
            <div id="infiniteLoader" class="hidden justify-center mt-9">
                <i class="fas fa-spinner fa-spin text-2xl text-blue-500"></i>
            </div>
            <div id="scrollSentinel" aria-hidden="true" style="height:1px;"></div>

            <div id="no-result" class="hidden flex-col items-center justify-center py-20 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fas fa-magnifying-glass text-2xl text-gray-300"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Tidak Ditemukan</h3>
                <p class="text-sm text-gray-400 mt-1">Coba kata kunci atau kategori lain.</p>
            </div>
        </div>
    </section>

    <footer class="border-t border-gray-100 bg-white">
        <div class="max-w-6xl mx-auto px-4 py-9 flex flex-col items-center text-center gap-3">
            <img src="{{ asset('transparent-logo.png') }}" alt="Qrun" class="h-8 w-auto opacity-90">
            <p class="text-base font-semibold text-gray-700">{{ $ebookPlace->name }}</p>
            <p class="text-xs text-gray-400">
                E-Book · Powered by
                <a href="https://qrun.online" class="text-blue-600 font-semibold hover:underline">Qrun Online</a>
            </p>
        </div>
    </footer>

    {{-- Floating: WhatsApp + Reservation --}}
    @if ($waUrl || $resUrl)
        <div class="fab-wrap">
            @if ($resUrl)
                <a href="{{ $resUrl }}" target="_blank" rel="noopener" class="fab fab-res" aria-label="Reservasi" title="Reservasi / Pesan">
                    <i class="fas fa-calendar-check"></i>
                </a>
            @endif
            @if ($waUrl)
                <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="fab fab-wa" aria-label="WhatsApp" title="Chat WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>
            @endif
        </div>
    @endif

    {{-- Scroll-down hint (disappears after scrolling) --}}
    <div id="scrollCue" class="scroll-cue">
        <span>Geser ke bawah</span>
        <i class="fas fa-chevron-down"></i>
    </div>

    {{-- ADS / PROMO modal player --}}
    @if ($ads->count())
        <div id="adsModal" class="ads-modal" role="dialog" aria-modal="true" aria-label="Promo">
            <div class="ads-overlay"></div>
            <div class="ads-panel">
                <button type="button" id="adsClose" class="ads-x" aria-label="Tutup">
                    <i class="fas fa-xmark"></i>
                </button>

                <div class="ads-stage">
                    <div class="ads-track" id="adsTrack">
                        @foreach ($ads as $ad)
                            <div class="ads-slide">
                                <img src="{{ asset($ad->image_url) }}" alt="{{ $ad->title ?: 'Promo' }}" loading="lazy">
                                @if ($ad->title)
                                    <div class="ads-caption">{{ $ad->title }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    @if ($ads->count() > 1)
                        <button type="button" id="adsPrev" class="ads-nav ads-prev" aria-label="Sebelumnya">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" id="adsNext" class="ads-nav ads-next" aria-label="Berikutnya">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <button type="button" id="adsPlay" class="ads-play" aria-label="Play/Pause">
                            <i class="fas fa-pause"></i>
                        </button>
                        <div class="ads-dots" id="adsDots">
                            @foreach ($ads as $i => $ad)
                                <button type="button" class="ads-dot {{ $i === 0 ? 'active' : '' }}" data-i="{{ $i }}"
                                    aria-label="Slide {{ $i + 1 }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Floating reopen button --}}
        <button type="button" id="adsReopen" class="ads-reopen" aria-label="Lihat promo" title="Lihat promo">
            <i class="fas fa-bullhorn"></i>
        </button>
    @endif

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // ── AJAX catalog (server-side pagination) ─────────────────────
        const dataUrl = @json(route('ebook-place.scan.data', $ebookPlace->code));
        const $grid = $('#ebook-grid');
        const $infLoader = $('#infiniteLoader');
        const $loading = $('#ebkLoading');

        let page = 1;
        let q = '';
        let category = '';
        let hasMore = @json($hasMore);
        let loading = false;
        let searchTimer;

        function revealCards($els) {
            $els.each(function (i, el) {
                setTimeout(function () { el.classList.add('in'); }, Math.min(i, 12) * 35);
            });
        }

        function updateLoader() {
            // Append spinner only shows while there is more to load.
            $infLoader.toggleClass('hidden', !hasMore).toggleClass('flex', hasMore);
        }

        function fetchPage(reset) {
            if (loading) return;
            loading = true;

            const nextPage = reset ? 1 : page + 1;

            if (reset) { $grid.css('opacity', .4); $loading.removeClass('hidden').addClass('flex'); }

            $.get(dataUrl, { page: nextPage, q: q, category: category })
                .done(function (res) {
                    if (reset) { $grid.html(res.html); page = 1; }
                    else { $grid.append(res.html); page = nextPage; }

                    hasMore = res.hasMore;
                    $('#resultCount').text(res.total);
                    $('#no-result').toggleClass('hidden', res.total !== 0).toggleClass('flex', res.total === 0);
                    revealCards($grid.find('.book-card.reveal:not(.in)'));
                    updateLoader();
                })
                .always(function () {
                    loading = false;
                    $grid.css('opacity', 1);
                    $loading.addClass('hidden').removeClass('flex');
                    // If the sentinel is still visible (short result set), keep loading.
                    setTimeout(checkSentinel, 120);
                });
        }

        // ── Infinite scroll via IntersectionObserver ──────────────────
        const sentinel = document.getElementById('scrollSentinel');

        function checkSentinel() {
            if (!sentinel || !hasMore || loading) return;
            const rect = sentinel.getBoundingClientRect();
            if (rect.top <= (window.innerHeight || document.documentElement.clientHeight) + 300) {
                fetchPage(false);
            }
        }

        if ('IntersectionObserver' in window && sentinel) {
            const io = new IntersectionObserver(function (entries) {
                if (entries[0].isIntersecting) fetchPage(false);
            }, { rootMargin: '300px 0px' });
            io.observe(sentinel);
        } else {
            // Fallback for very old browsers
            window.addEventListener('scroll', checkSentinel, { passive: true });
        }

        // Initial state — first page is already rendered server-side
        revealCards($grid.find('.book-card.reveal'));
        updateLoader();
        $('#no-result').toggleClass('hidden', {{ $total }} !== 0).toggleClass('flex', {{ $total }} === 0);

        // View toggle (grid / list)
        function setView(mode) {
            const grid = document.getElementById('ebook-grid');
            const list = mode === 'list';
            grid.classList.toggle('layout-list', list);
            grid.classList.toggle('layout-grid', !list);
            $('#viewList').toggleClass('active', list);
            $('#viewGrid').toggleClass('active', !list);
            try { localStorage.setItem('ebookScanView', mode); } catch (e) {}
        }
        $('#viewGrid').on('click', function () { setView('grid'); });
        $('#viewList').on('click', function () { setView('list'); });
        (function () {
            let saved = 'grid';
            try { saved = localStorage.getItem('ebookScanView') || 'grid'; } catch (e) {}
            setView(saved);
        })();

        // Search (server-side, debounced)
        $('#search').on('input', function () {
            $('#searchClear').toggleClass('hidden', this.value.length === 0).toggleClass('flex', this.value.length > 0);
            q = this.value.trim();
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function () { fetchPage(true); }, 350);
        });
        $('#searchClear').on('click', function () { $('#search').val('').trigger('input').focus(); });

        // Category filter (server-side)
        $('.cat-chip').on('click', function () {
            $('.cat-chip').removeClass('active');
            $(this).addClass('active');
            category = $(this).attr('data-cat') || '';
            fetchPage(true);
        });

        // ── Category horizontal scroll cue ────────────────────────────
        const chipsScroll = document.querySelector('.chips-scroll');
        const chipsFade = document.querySelector('.chips-fade');
        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        function updateChipsCue() {
            if (!chipsScroll || !chipsFade) return;
            const overflowing = chipsScroll.scrollWidth > chipsScroll.clientWidth + 4;
            const atEnd = chipsScroll.scrollLeft + chipsScroll.clientWidth >= chipsScroll.scrollWidth - 4;
            chipsFade.classList.toggle('hide', !overflowing || atEnd);
        }

        if (chipsScroll) {
            chipsScroll.addEventListener('scroll', updateChipsCue, { passive: true });
            window.addEventListener('resize', updateChipsCue);
            updateChipsCue();

            // one-time nudge so users notice the row scrolls sideways
            if (!reducedMotion && chipsScroll.scrollWidth > chipsScroll.clientWidth + 4) {
                setTimeout(function () {
                    chipsScroll.scrollTo({ left: 30, behavior: 'smooth' });
                    setTimeout(function () { chipsScroll.scrollTo({ left: 0, behavior: 'smooth' }); }, 550);
                }, 650);
            }
        }

        // ── Scroll-down cue (hide once scrolled) ──────────────────────
        const scrollCue = document.getElementById('scrollCue');
        let cueDismissed = false;
        function updateScrollCue() {
            if (!scrollCue || cueDismissed) return;
            if (window.scrollY > 60) { scrollCue.classList.add('hide'); cueDismissed = true; }
        }
        window.addEventListener('scroll', updateScrollCue, { passive: true });
        updateScrollCue();

        // ── Description read more / less ──────────────────────────────
        (function () {
            const desc = document.getElementById('placeDesc');
            const toggle = document.getElementById('descToggle');
            if (!desc || !toggle) return;

            // Only show the toggle when the text is actually clamped
            if (desc.scrollHeight - desc.clientHeight > 2) {
                toggle.classList.remove('hidden');
            }

            toggle.addEventListener('click', function () {
                const expanded = desc.getAttribute('data-expanded') === 'true';
                desc.classList.toggle('line-clamp-2', expanded);
                desc.setAttribute('data-expanded', expanded ? 'false' : 'true');
                toggle.querySelector('.label').textContent = expanded ? 'Selengkapnya' : 'Tutup';
                toggle.querySelector('i').classList.toggle('fa-chevron-down', expanded);
                toggle.querySelector('i').classList.toggle('fa-chevron-up', !expanded);
            });
        })();

        // ── Ads / promo modal player ──────────────────────────────────
        (function () {
            const modal = document.getElementById('adsModal');
            if (!modal) return;

            const track = document.getElementById('adsTrack');
            const slides = track.children.length;
            const dots = Array.prototype.slice.call(document.querySelectorAll('.ads-dot'));
            const playBtn = document.getElementById('adsPlay');
            const reopen = document.getElementById('adsReopen');
            const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const KEY = 'ebookAdsSeen:' + @json($ebookPlace->code);

            let current = 0;
            let playing = true;
            let timer = null;

            function go(i) {
                current = (i + slides) % slides;
                track.style.transform = 'translateX(-' + (current * 100) + '%)';
                dots.forEach(function (d, idx) { d.classList.toggle('active', idx === current); });
            }
            function next() { go(current + 1); }
            function prev() { go(current - 1); }

            function startAuto() {
                if (slides <= 1 || reduced) return;
                stopAuto();
                playing = true;
                if (playBtn) playBtn.innerHTML = '<i class="fas fa-pause"></i>';
                timer = setInterval(next, 3500);
            }
            function stopAuto() {
                playing = false;
                if (playBtn) playBtn.innerHTML = '<i class="fas fa-play"></i>';
                if (timer) { clearInterval(timer); timer = null; }
            }

            function open() { modal.classList.add('open'); document.body.style.overflow = 'hidden'; startAuto(); }
            function close() {
                modal.classList.remove('open');
                document.body.style.overflow = '';
                stopAuto();
                try { sessionStorage.setItem(KEY, '1'); } catch (e) {}
            }

            document.getElementById('adsClose').addEventListener('click', close);
            modal.querySelector('.ads-overlay').addEventListener('click', close);
            if (reopen) reopen.addEventListener('click', open);

            const nextBtn = document.getElementById('adsNext');
            const prevBtn = document.getElementById('adsPrev');
            if (nextBtn) nextBtn.addEventListener('click', function () { next(); startAuto(); });
            if (prevBtn) prevBtn.addEventListener('click', function () { prev(); startAuto(); });
            dots.forEach(function (d) {
                d.addEventListener('click', function () { go(parseInt(this.getAttribute('data-i'), 10)); startAuto(); });
            });
            if (playBtn) playBtn.addEventListener('click', function () { playing ? stopAuto() : startAuto(); });

            document.addEventListener('keydown', function (e) {
                if (!modal.classList.contains('open')) return;
                if (e.key === 'Escape') close();
                else if (e.key === 'ArrowRight') { next(); startAuto(); }
                else if (e.key === 'ArrowLeft') { prev(); startAuto(); }
            });

            // Auto-open behaviour: every reload, or once per browser session.
            const alwaysShow = @json((bool) $ebookPlace->ads_always_show);
            let seen = false;
            try { seen = sessionStorage.getItem(KEY) === '1'; } catch (e) {}
            if (alwaysShow || !seen) setTimeout(open, 600);
        })();
    </script>
</body>

</html>
