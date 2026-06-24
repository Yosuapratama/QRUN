<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $data->title }} | Ebook Qrun Online</title>

    <meta name="description" content="{{ Str::limit(strip_tags($data->description ?? $data->title), 160) }}">
    <meta name="keywords"
        content="{{ $data->title }}, {{ $data->category }}, ebook qrun online, perpustakaan digital, sejarah, budaya, wisata">
    <meta name="author" content="{{ $data->author ?: 'Qrun Online' }}">
    <meta name="robots" content="noindex, nofollow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph -->
    <meta property="og:type" content="book">
    <meta property="og:site_name" content="Qrun Online">
    <meta property="og:title" content="{{ $data->title }} | Ebook Qrun Online">
    <meta property="og:description" content="{{ Str::limit(strip_tags($data->description ?? $data->title), 200) }}">
    <meta property="og:image" content="{{ asset($data->image_url ?? 'home.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Structured Data (SEO Book) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Book",
        "name": @json($data->title),
        "description": @json(strip_tags($data->description ?? $data->title)),
        "image": "{{ asset($data->image_url ?? 'home.jpg') }}",
        "author": {
            "@type": "Person",
            "name": @json($data->author ?: 'Qrun Online')
        },
        "publisher": {
            "@type": "Organization",
            "name": "Qrun Online",
            "logo": {
                "@type": "ImageObject",
                "url": "{{ asset('transparent-logo.png') }}"
            }
        },
        "datePublished": "{{ !empty($data->created_at) ? \Carbon\Carbon::parse($data->created_at)->toIso8601String() : '' }}",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "{{ url()->current() }}"
        }
    }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        * { font-family: 'Inter', sans-serif; }
        .prose img { border-radius: 0.5rem; margin: 1.5rem auto; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</head>

<body class="bg-gray-50">
    @include('Components.Navbar')

    @php
        // If the visitor came from a location scan page (?ref=CODE), back goes there;
        // otherwise fall back to the global ebook catalog.
        $ref = request('ref');
        $backUrl = $ref ? url('/ebook-place/' . $ref) : route('homes');
        $backLabel = $ref ? 'Kembali ke Daftar' : 'Kembali ke Beranda';
    @endphp

    {{-- Back navigation --}}
    <nav class="bg-white border-b">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between gap-3">
            <a href="{{ $backUrl }}"
                class="group inline-flex items-center gap-2.5 text-gray-700 hover:text-blue-600 font-semibold text-sm transition-colors">
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-100 group-hover:bg-blue-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                {{ $backLabel }}
            </a>

            <div class="hidden sm:flex items-center space-x-2 text-sm text-gray-500">
                <a href="{{ route('homes') }}" class="hover:text-blue-600">Beranda</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ $backUrl }}" class="hover:text-blue-600">{{ $ref ? 'Perpustakaan' : 'Ebook' }}</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-gray-900 line-clamp-1" style="max-width:240px;">{{ $data->title }}</span>
            </div>
        </div>
    </nav>

    {{-- ═══════════ BOOK HEADER ═══════════ --}}
    <section class="bg-white border-b">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-[260px_1fr] gap-8 lg:gap-12">

                {{-- Cover --}}
                <div>
                    <div class="md:sticky md:top-8">
                        <img src="{{ asset($data->image_url) }}" alt="{{ $data->title }}"
                            class="w-48 md:w-full mx-auto rounded-lg shadow-2xl aspect-[3/4] object-cover">

                        <a href="#read"
                            class="mt-5 hidden md:flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-3 rounded-xl transition-colors w-full">
                            <i class="fas fa-book-open"></i> Baca Sekarang
                        </a>
                    </div>
                </div>

                {{-- Metadata --}}
                <div>
                    @if ($data->category)
                        <span class="inline-block bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full mb-4">
                            {{ $data->category }}
                        </span>
                    @endif

                    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 leading-tight mb-3">
                        {{ $data->title }}
                    </h1>

                    <p class="text-lg text-gray-600 mb-6">
                        oleh <span class="font-semibold text-gray-900">{{ $data->author ?: 'Qrun Online' }}</span>
                    </p>

                    {{-- Meta row --}}
                    <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-gray-500 border-y border-gray-100 py-4 mb-6">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-calendar-alt text-gray-400"></i>
                            {{ \Carbon\Carbon::parse($data->created_at)->locale(app()->getLocale())->isoFormat('D MMMM Y') }}
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-eye text-gray-400"></i>
                            @php
                                $num = $data->views;
                                $formatted = $num < 1000 ? $num : number_format($num / 1000, 1) . 'K';
                            @endphp
                            {{ $formatted }} kali dibaca
                        </span>
                    </div>

                    <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-2">Tentang Ebook Ini</h2>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $data->description }}
                    </p>

                    @if (!empty($data->file_url) && !$locked)
                        <div class="flex flex-wrap gap-3 mt-6">
                            <a href="{{ asset($data->file_url) }}" target="_blank"
                                class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-3 rounded-xl transition-colors">
                                <i class="fas fa-file-pdf"></i> Baca PDF
                            </a>
                            <a href="{{ asset($data->file_url) }}" download
                                class="inline-flex items-center justify-center gap-2 bg-white border border-blue-200 text-blue-700 hover:bg-blue-50 font-semibold text-sm px-5 py-3 rounded-xl transition-colors">
                                <i class="fas fa-download"></i> Unduh
                            </a>
                        </div>
                    @endif

                    <a href="#read"
                        class="mt-6 inline-flex md:hidden items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-3 rounded-xl transition-colors w-full">
                        <i class="fas fa-book-open"></i> Baca Sekarang
                    </a>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══════════ CONTENT ═══════════ --}}
    @if (!$locked)
        <article id="read" class="py-12">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

                @if (!empty($data->file_url))
                    <div class="mb-10 rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                        <iframe src="{{ asset($data->file_url) }}" class="w-full" style="height:80vh;" title="{{ $data->title }}"></iframe>
                    </div>
                @endif

                <div class="prose prose-lg max-w-none">
                    {!! $data->content !!}
                </div>
            </div>
        </article>
    @else
        {{-- ═══════════ LOCKED (read limit reached) ═══════════ --}}
        @php
            $unlockTimed = $unlockAds->firstWhere('type', 'timed');
            $unlockReview = $unlockAds->firstWhere('type', 'review');
            $showTimed = in_array($gate['unlock_method'], ['timed', 'both']);
            $showReview = in_array($gate['unlock_method'], ['review', 'both']);
            $timedDuration = $unlockTimed && $unlockTimed->duration_seconds
                ? $unlockTimed->duration_seconds
                : $gate['unlock_duration'];
        @endphp

        <article id="read" class="py-12">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Teaser: a faded preview the reader cannot finish --}}
                <div class="relative rounded-xl overflow-hidden border border-gray-200 shadow-sm bg-white">
                    <div class="prose prose-lg max-w-none p-6 sm:p-10 max-h-[320px] overflow-hidden"
                        style="-webkit-mask-image:linear-gradient(to bottom, #000 35%, transparent 100%); mask-image:linear-gradient(to bottom, #000 35%, transparent 100%);">
                        {!! Str::limit(strip_tags($data->description ?? ''), 320) !!}
                    </div>
                </div>

                {{-- Unlock card --}}
                <div id="lockCard" class="mt-8 rounded-2xl border border-gray-200 bg-white shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-br from-slate-900 to-blue-900 px-6 py-7 text-center">
                        <span class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-white/10 text-white text-2xl mb-3">
                            <i class="fas fa-lock"></i>
                        </span>
                        <h2 class="text-xl font-extrabold text-white">Batas baca tercapai</h2>
                        <p class="text-blue-200 text-sm mt-1.5 max-w-md mx-auto">
                            Anda sudah membaca {{ $gate['read_limit'] }} e-book gratis di lokasi ini.
                            Buka kunci untuk lanjut membaca yang ini.
                        </p>
                    </div>

                    <div class="p-6 space-y-4">
                        {{-- Timed unlock --}}
                        @if ($showTimed)
                            <div class="unlock-option rounded-xl border border-gray-200 p-4" data-method="timed">
                                @if ($unlockTimed)
                                    <img src="{{ asset($unlockTimed->image_url) }}" alt="{{ $unlockTimed->title ?: 'Iklan' }}"
                                        class="w-full h-40 object-cover rounded-lg mb-3">
                                @endif
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <p class="font-bold text-gray-900"><i class="fas fa-clock text-blue-600 mr-1.5"></i> Tonton iklan</p>
                                        <p class="text-sm text-gray-500">Tunggu <span class="font-semibold">{{ $timedDuration }} detik</span> untuk membuka.</p>
                                    </div>
                                    <button type="button" id="btnTimed"
                                        class="shrink-0 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition-colors">
                                        <span class="label">Mulai</span>
                                    </button>
                                </div>
                            </div>
                        @endif

                        {{-- Divider when both methods are available --}}
                        @if ($showTimed && $showReview)
                            <div class="flex items-center gap-3 text-xs text-gray-400 font-semibold uppercase tracking-wide">
                                <span class="flex-1 h-px bg-gray-200"></span> atau <span class="flex-1 h-px bg-gray-200"></span>
                            </div>
                        @endif

                        {{-- Review unlock (custom questions, saved to our site) --}}
                        @if ($showReview)
                            <div class="unlock-option rounded-xl border border-gray-200 p-4" data-method="review">
                                @if ($unlockReview)
                                    <img src="{{ asset($unlockReview->image_url) }}" alt="{{ $unlockReview->title ?: 'Review' }}"
                                        class="w-full h-40 object-cover rounded-lg mb-3">
                                @endif
                                <p class="font-bold text-gray-900 mb-1"><i class="fas fa-star text-amber-500 mr-1.5"></i> Beri ulasan untuk membuka</p>
                                <p class="text-sm text-gray-500 mb-4">Jawab pertanyaan berikut, lalu kunci akan terbuka.</p>

                                <form id="reviewForm" class="space-y-4">
                                    @forelse ($reviewQuestions as $q)
                                        <div class="review-q" data-qid="{{ $q->id }}" data-required="{{ $q->is_required ? 1 : 0 }}">
                                            <label class="block text-sm font-semibold text-gray-800 mb-1.5">
                                                {{ $q->question }}
                                                @if ($q->is_required)<span class="text-red-500">*</span>@endif
                                            </label>

                                            @if ($q->type === 'rating')
                                                <div class="rating-stars inline-flex gap-1 text-2xl text-gray-300" data-value="0">
                                                    @for ($s = 1; $s <= 5; $s++)
                                                        <button type="button" class="star hover:text-amber-400" data-star="{{ $s }}"><i class="fas fa-star"></i></button>
                                                    @endfor
                                                    <input type="hidden" class="q-input" value="">
                                                </div>
                                            @elseif ($q->type === 'textarea')
                                                <textarea class="q-input w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-400 focus:ring-0" rows="3" placeholder="Tulis jawaban..."></textarea>
                                            @elseif ($q->type === 'choice' && is_array($q->options))
                                                <select class="q-input w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-400 focus:ring-0">
                                                    <option value="">— Pilih —</option>
                                                    @foreach ($q->options as $opt)
                                                        <option value="{{ $opt }}">{{ $opt }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input type="text" class="q-input w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-400 focus:ring-0" placeholder="Tulis jawaban...">
                                            @endif
                                        </div>
                                    @empty
                                        {{-- Fallback: a single rating + comment when admin set no questions --}}
                                        <div class="review-q" data-qid="0" data-required="1">
                                            <label class="block text-sm font-semibold text-gray-800 mb-1.5">Beri rating <span class="text-red-500">*</span></label>
                                            <div class="rating-stars inline-flex gap-1 text-2xl text-gray-300" data-value="0">
                                                @for ($s = 1; $s <= 5; $s++)
                                                    <button type="button" class="star hover:text-amber-400" data-star="{{ $s }}"><i class="fas fa-star"></i></button>
                                                @endfor
                                                <input type="hidden" class="q-input" value="">
                                            </div>
                                        </div>
                                    @endforelse

                                    <button type="submit" id="btnReviewSubmit"
                                        class="w-full inline-flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition-colors">
                                        <i class="fas fa-unlock"></i> Kirim &amp; Buka Kunci
                                    </button>
                                </form>
                            </div>
                        @endif

                        <p id="unlockError" class="hidden text-sm text-red-600 text-center"></p>
                    </div>
                </div>
            </div>
        </article>

        {{-- Timed-ad overlay (countdown enforced by the server) --}}
        <div id="adOverlay" class="fixed inset-0 z-[60] hidden items-center justify-center p-4" style="background:rgba(15,23,42,.85);">
            <div class="w-full max-w-lg bg-white rounded-2xl overflow-hidden shadow-2xl">
                @if ($unlockTimed)
                    <a id="adClickThrough" href="{{ $unlockTimed->target_url ?: '#' }}"
                        @if($unlockTimed->target_url) target="_blank" rel="noopener" @endif class="block">
                        <img src="{{ asset($unlockTimed->image_url) }}" alt="{{ $unlockTimed->title ?: 'Iklan' }}" class="w-full h-72 object-cover">
                    </a>
                @else
                    <div class="w-full h-72 bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-white text-5xl">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                @endif
                <div class="p-6 text-center">
                    <p class="text-gray-700 font-semibold mb-2">Iklan sedang diputar…</p>
                    <p class="text-sm text-gray-500 mb-4">Buka kunci dalam <span id="adCountdown" class="font-bold text-blue-600">{{ $timedDuration }}</span> detik</p>
                    <button type="button" id="adUnlockBtn" disabled
                        class="w-full inline-flex items-center justify-center gap-2 bg-gray-300 text-white font-semibold text-sm px-5 py-3 rounded-xl cursor-not-allowed transition-colors">
                        <i class="fas fa-lock"></i> <span class="label">Tunggu…</span>
                    </button>
                </div>
            </div>
        </div>

        <script>
            (function () {
                const code = @json($gate['code']);
                const slug = @json($gate['slug']);
                const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const startUrl = @json(route('ebook-place.unlock.start', $gate['code']));
                const completeUrl = @json(route('ebook-place.unlock.complete', $gate['code']));

                const errBox = document.getElementById('unlockError');
                function showError(msg) {
                    errBox.textContent = msg || 'Terjadi kesalahan, coba lagi.';
                    errBox.classList.remove('hidden');
                }

                function post(url, body) {
                    return fetch(url, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                        body: JSON.stringify(body),
                    }).then(async function (r) {
                        const data = await r.json().catch(function () { return {}; });
                        if (!r.ok) throw new Error(data.errors || 'error');
                        return data;
                    });
                }

                let currentNonce = null;

                function complete() {
                    if (!currentNonce) return;
                    post(completeUrl, { slug: slug, nonce: currentNonce })
                        .then(function () { window.location.reload(); })
                        .catch(function (e) { showError(e.message); });
                }

                // ── Timed unlock ──────────────────────────────────────────
                const btnTimed = document.getElementById('btnTimed');
                const overlay = document.getElementById('adOverlay');
                const countdownEl = document.getElementById('adCountdown');
                const adBtn = document.getElementById('adUnlockBtn');

                if (btnTimed) {
                    btnTimed.addEventListener('click', function () {
                        btnTimed.disabled = true;
                        post(startUrl, { slug: slug, method: 'timed' })
                            .then(function (res) {
                                currentNonce = res.nonce;
                                runCountdown(res.duration);
                            })
                            .catch(function (e) { btnTimed.disabled = false; showError(e.message); });
                    });
                }

                function runCountdown(seconds) {
                    let remaining = seconds;
                    overlay.classList.remove('hidden');
                    overlay.classList.add('flex');
                    document.body.style.overflow = 'hidden';
                    countdownEl.textContent = remaining;

                    const timer = setInterval(function () {
                        remaining -= 1;
                        if (remaining <= 0) {
                            clearInterval(timer);
                            countdownEl.textContent = 0;
                            adBtn.disabled = false;
                            adBtn.classList.remove('bg-gray-300', 'cursor-not-allowed');
                            adBtn.classList.add('bg-green-600', 'hover:bg-green-700');
                            adBtn.querySelector('.label').textContent = 'Buka kunci sekarang';
                            adBtn.querySelector('i').className = 'fas fa-unlock';
                        } else {
                            countdownEl.textContent = remaining;
                        }
                    }, 1000);
                }

                if (adBtn) adBtn.addEventListener('click', function () { if (!adBtn.disabled) complete(); });

                // ── Review unlock (custom questions saved to our site) ────
                const reviewForm = document.getElementById('reviewForm');
                const reviewUrl = @json(route('ebook-place.unlock.review', $gate['code']));

                if (reviewForm) {
                    // Star rating widgets.
                    reviewForm.querySelectorAll('.rating-stars').forEach(function (widget) {
                        const input = widget.querySelector('.q-input');
                        widget.querySelectorAll('.star').forEach(function (btn) {
                            btn.addEventListener('click', function () {
                                const v = parseInt(btn.getAttribute('data-star'), 10);
                                input.value = v;
                                widget.querySelectorAll('.star').forEach(function (s) {
                                    const sv = parseInt(s.getAttribute('data-star'), 10);
                                    s.classList.toggle('text-amber-400', sv <= v);
                                    s.classList.toggle('text-gray-300', sv > v);
                                });
                            });
                        });
                    });

                    // Obtain a server token as soon as the review form is shown
                    // (server enforces a small minimum time before accepting).
                    post(startUrl, { slug: slug, method: 'review' })
                        .then(function (res) { currentNonce = res.nonce; })
                        .catch(function (e) { showError(e.message); });

                    reviewForm.addEventListener('submit', function (e) {
                        e.preventDefault();
                        errBox.classList.add('hidden');

                        const answers = {};
                        let missing = false;
                        reviewForm.querySelectorAll('.review-q').forEach(function (row) {
                            const qid = row.getAttribute('data-qid');
                            const required = row.getAttribute('data-required') === '1';
                            const input = row.querySelector('.q-input');
                            const val = input ? (input.value || '').toString().trim() : '';
                            if (required && !val) missing = true;
                            answers[qid] = val;
                        });

                        if (missing) { showError('Mohon jawab semua pertanyaan wajib.'); return; }
                        if (!currentNonce) { showError('Mohon tunggu sebentar lalu coba lagi.'); return; }

                        const btn = document.getElementById('btnReviewSubmit');
                        btn.disabled = true;
                        post(reviewUrl, { slug: slug, nonce: currentNonce, answers: answers })
                            .then(function () { window.location.reload(); })
                            .catch(function (e) { btn.disabled = false; showError(e.message); });
                    });
                }
            })();
        </script>
    @endif

    {{-- ═══════════ MORE EBOOKS ═══════════ --}}
    <section class="py-12 bg-white border-t">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Ebook Lainnya</h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-x-6 gap-y-10">
                @forelse ($ebooks as $ebook)
                    <a href="/ebook/{{ $ebook->slug }}{{ $ref ? '?ref=' . $ref : '' }}" class="group block">
                        <div class="relative rounded-lg overflow-hidden bg-gray-100 aspect-[3/4] mb-3 shadow-md group-hover:shadow-xl transition-shadow">
                            <img src="{{ asset($ebook->image_url) }}" alt="{{ $ebook->title }}"
                                class="w-full h-full object-cover" loading="lazy">
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 leading-snug line-clamp-2 group-hover:text-blue-600 transition-colors">
                            {{ $ebook->title }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">{{ $ebook->author ?: 'Qrun Online' }}</p>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="fas fa-book text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Belum ada ebook lain yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    @include('Components.FooterHome')
</body>

</html>
