@extends('TemplateLayout.AdminLayout')

@push('css')
    <style>
        .detail-card { border:none; border-radius:18px; overflow:hidden;
            box-shadow:0 10px 25px rgba(0,0,0,.05), 0 4px 10px rgba(0,0,0,.03); }
        .detail-card .card-header { background:#fff; border-bottom:1px solid #eef1f7; padding:1.2rem 1.5rem; }
        .meta-row { display:flex; gap:8px; padding:10px 0; border-bottom:1px solid #f1f3f9; }
        .meta-row:last-child { border-bottom:none; }
        .meta-label { width:140px; color:#858796; font-size:13px; flex:0 0 auto; }
        .meta-value { font-weight:600; color:#2f3640; font-size:14px; word-break:break-word; }
        .code-pill { font-family:monospace; background:#eef2ff; color:#3b50c0; padding:3px 10px; border-radius:6px; }
        .ebk-wrap { background:#f6f8fc; border:1px solid #eef1f7; border-radius:14px; padding:16px; }
        .ebk-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(150px, 1fr)); gap:16px; }
        .ebk-item { border:1px solid #dde3ee; border-radius:14px; overflow:hidden; background:#fff;
            box-shadow:0 2px 8px rgba(31,45,80,.07); transition:.18s ease; }
        .ebk-item:hover { box-shadow:0 12px 24px rgba(31,45,80,.14); transform:translateY(-3px); border-color:#c5d0e3; }
        .ebk-item .cover { height:120px; background:#eef1f7; border-bottom:1px solid #eef1f7; }
        .ebk-item .cover img { width:100%; height:100%; object-fit:cover; }
        .ebk-item .body { padding:10px 12px; }
        .ebk-item .body h6 { font-size:13px; font-weight:700; color:#2f3640; margin:0 0 2px;
            display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
        .ebk-item .body small { color:#858796; font-size:11px; }

        .pager-detail { display:flex; align-items:center; gap:6px; flex-wrap:wrap; }
        .pager-detail button { min-width:34px; height:34px; border-radius:8px; border:1px solid #e3e6f0; background:#fff;
            color:#5a6275; font-weight:600; font-size:13px; transition:.15s ease; }
        .pager-detail button:hover:not(:disabled) { border-color:#4e73df; color:#4e73df; }
        .pager-detail button.active { background:#4e73df; border-color:#4e73df; color:#fff; }
        .pager-detail button:disabled { opacity:.4; cursor:not-allowed; }

        /* Review answers */
        .rv-table { table-layout:fixed; width:100%; }
        .rv-table td, .rv-table th { vertical-align:top; }
        .rv-table td { white-space:normal; overflow-wrap:anywhere; word-break:break-word; }
        .rv-stars { white-space:nowrap; letter-spacing:1px; }
        .rv-answers { display:flex; flex-direction:column; gap:8px; }
        .rv-ans { display:flex; flex-direction:column; gap:2px; }
        .rv-ans-q { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.3px; color:#9aa1b1; }
        .rv-ans-v { font-size:13.5px; color:#2f3640; line-height:1.45; overflow-wrap:anywhere; word-break:break-word; }
        .rv-chip { display:inline-block; background:#eef3ff; color:#3b50c0; font-weight:600; font-size:12px;
            padding:2px 10px; border-radius:999px; margin:0 4px 4px 0; }
        .rv-empty { color:#b6bccb; font-style:italic; }
        .rv-search-wrap { position:relative; max-width:320px; }
        .rv-search-wrap i { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#9aa1b1; font-size:13px; }

        /* Mobile: turn the review table into stacked cards so long answers
           don't squeeze the columns and blow up row height. */
        @media (max-width: 767.98px) {
            .rv-table { table-layout:auto; }
            .rv-table thead { display:none; }
            .rv-table, .rv-table tbody, .rv-table tr, .rv-table td { display:block; width:100%; }
            .rv-table tbody tr { border:1px solid #e7ebf3; border-radius:12px; padding:6px 12px; margin-bottom:12px; background:#fff; }
            .rv-table td { border:none !important; padding:7px 0; }
            .rv-table td + td { border-top:1px solid #f1f3f9 !important; }
            .rv-table td::before { content:attr(data-label); display:block; font-size:11px; font-weight:700;
                text-transform:uppercase; letter-spacing:.3px; color:#9aa1b1; margin-bottom:3px; }
            .rv-table td[data-label="Tanggal"] br { display:none; }
        }

        /* Export column config */
        .export-col-item { display:flex; align-items:center; gap:8px; background:#fff; border:1px solid #e7ebf3;
            border-radius:10px; padding:8px 10px; margin-bottom:8px; }
        .export-col-item.col-hidden { opacity:.5; }
        .export-col-item .col-label { font-size:13px; font-weight:600; color:#2f3640;
            white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .export-col-move { display:flex; gap:4px; flex:0 0 auto; }
        .btn-xs { padding:2px 7px; font-size:11px; line-height:1.2; border-radius:7px; border:1px solid #e3e6f0; }
    </style>
@endpush

@push('script')
    <script>
        // ── Connected ebooks: AJAX infinite scroll ──
        $(document).ready(function () {
            const grid = document.getElementById('ebkGrid');
            if (!grid) return;

            const url = @json($ebookPlace->ebooks_count > 0 ? route('ebook-place.connected', $ebookPlace->id) : '');
            const $grid = $('#ebkGrid');
            const $loadingEl = $('#ebkLoading');
            const $empty = $('#ebkNoResult');
            const $info = $('#ebkInfo');
            const scrollEl = document.getElementById('ebkScroll');

            let page = 1, q = '', hasMore = false, loading = false, total = 0, timer;

            function esc(s) { return $('<span>').text(s == null ? '' : s).html(); }

            function cardHtml(it) {
                const draft = it.is_published ? '' : '<span class="badge badge-secondary mt-1 d-inline-block">Draft</span>';
                return '<a href="' + it.edit_url + '" class="ebk-item text-decoration-none" target="_blank">' +
                    '<div class="cover"><img src="' + it.image_url + '" alt="" loading="lazy"></div>' +
                    '<div class="body"><h6>' + esc(it.title) + '</h6>' +
                        '<small>' + esc(it.author) + '</small>' + draft + '</div></a>';
            }

            function load(reset) {
                if (loading || !url) return;
                loading = true;
                const nextPage = reset ? 1 : page + 1;
                $loadingEl.removeClass('d-none');

                $.get(url, { page: nextPage, q: q })
                    .done(function (res) {
                        if (reset) { $grid.empty(); page = 1; }
                        res.items.forEach(function (it) { $grid.append(cardHtml(it)); });
                        page = res.page;
                        hasMore = res.hasMore;
                        total = res.total;
                        $empty.toggleClass('d-none', total !== 0);
                        $info.text(total ? 'Menampilkan ' + $grid.children().length + ' dari ' + total : '');
                    })
                    .always(function () {
                        loading = false;
                        $loadingEl.addClass('d-none');
                        setTimeout(checkScroll, 80);
                    });
            }

            function checkScroll() {
                if (loading || !hasMore || !scrollEl) return;
                if (scrollEl.scrollTop + scrollEl.clientHeight >= scrollEl.scrollHeight - 60) {
                    load(false);
                }
            }
            $('#ebkScroll').on('scroll', checkScroll);

            $('#ebkSearch').on('input', function () {
                q = this.value.trim();
                clearTimeout(timer);
                timer = setTimeout(function () { load(true); }, 250);
            });

            load(true);
        });

        // ── Export review modal: columns reorder / hide + live preview ──
        $(document).ready(function () {
            const $list = $('#exportColList');
            if ($list.length === 0) return;

            const previewBase = @json($ebookPlace->reviews_count > 0 ? route('ebook-place.reviews.preview', $ebookPlace->id) : '');
            const exportBase = @json($ebookPlace->reviews_count > 0 ? route('ebook-place.reviews.export', $ebookPlace->id) : '');
            const $frame = $('#exportPreviewFrame');
            let timer;

            // Ordered keys of currently *visible* columns.
            function selectedKeys() {
                const keys = [];
                $list.find('.export-col-item').each(function () {
                    if ($(this).find('.col-visible').is(':checked')) keys.push($(this).data('key'));
                });
                return keys;
            }

            function colsParam() { return encodeURIComponent(selectedKeys().join(',')); }

            function loadPreview() {
                $frame.attr('src', previewBase + '?cols=' + colsParam());
            }

            function refreshPreview() {
                clearTimeout(timer);
                timer = setTimeout(loadPreview, 200);
            }

            // Reorder
            $list.on('click', '.col-up', function () {
                const $item = $(this).closest('.export-col-item');
                const $prev = $item.prev('.export-col-item');
                if ($prev.length) { $item.insertBefore($prev); refreshPreview(); }
            });
            $list.on('click', '.col-down', function () {
                const $item = $(this).closest('.export-col-item');
                const $next = $item.next('.export-col-item');
                if ($next.length) { $item.insertAfter($next); refreshPreview(); }
            });

            // Hide / unhide
            $list.on('change', '.col-visible', function () {
                $(this).closest('.export-col-item').toggleClass('col-hidden', !this.checked);
                refreshPreview();
            });

            // Load preview as the modal opens (and again once fully shown,
            // so the iframe always has content even if one event is missed).
            $('#exportReviewModal').on('show.bs.modal shown.bs.modal', loadPreview);

            // Also load directly from the trigger button, as a fallback.
            $('[data-target="#exportReviewModal"]').on('click', function () {
                setTimeout(loadPreview, 50);
            });

            // Download
            $('#exportDownloadBtn').on('click', function () {
                const keys = selectedKeys();
                if (keys.length === 0) {
                    Swal.fire({ icon: 'warning', title: 'Pilih minimal 1 kolom', timer: 1600, showConfirmButton: false });
                    return;
                }
                window.location = exportBase + '?cols=' + colsParam();
            });
        });

        // ── Review search (client-side filter) ──
        $(document).ready(function () {
            const $rows = $('#rvBody .rv-row');
            if ($rows.length === 0) return;

            let t;
            $('#rvSearch').on('input', function () {
                clearTimeout(t);
                const q = this.value.trim().toLowerCase();
                t = setTimeout(function () {
                    let shown = 0;
                    $rows.each(function () {
                        const match = !q || ($(this).data('search') || '').toString().includes(q);
                        $(this).toggle(match);
                        if (match) shown++;
                    });
                    $('#rvShown').text(shown);
                    $('#rvNoResult').toggleClass('d-none', shown !== 0);
                }, 150);
            });
        });
    </script>
@endpush

@section('content')
    @push('title')
        <title>{{ $ebookPlace->name }} - Ebook Location Detail</title>
    @endpush

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap" style="gap:8px;">
            <div>
                <h1 class="h3 text-gray-800 font-weight-bold mb-0">{{ $ebookPlace->name }}</h1>
                <small class="text-secondary">Ebook location detail</small>
            </div>
            <div class="d-flex" style="gap:8px;">
                <a href="{{ route('ebook-place.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
                <a href="{{ $scanUrl }}" target="_blank" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-eye mr-1"></i> View Page
                </a>
                <a href="{{ route('ebook-place.print', $ebookPlace->code) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-qrcode mr-1"></i> Print QR
                </a>
                <a href="{{ route('ebook-place.edit', $ebookPlace->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
            </div>
        </div>

        <div class="row">

            {{-- INFO --}}
            <div class="col-lg-4 mb-4">
                <div class="card detail-card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Information</h6>
                    </div>
                    <div class="card-body">
                        @if ($ebookPlace->logo_url)
                            <div class="text-center mb-3">
                                <img src="{{ asset($ebookPlace->logo_url) }}" alt="{{ $ebookPlace->name }} logo"
                                    style="max-height:80px; max-width:100%; object-fit:contain;">
                            </div>
                        @endif
                        <div class="meta-row">
                            <span class="meta-label">Name</span>
                            <span class="meta-value">{{ $ebookPlace->name }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Code</span>
                            <span class="meta-value"><span class="code-pill">{{ $ebookPlace->code }}</span></span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Status</span>
                            <span class="meta-value">
                                @if ($ebookPlace->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Ebooks</span>
                            <span class="meta-value">{{ $ebookPlace->ebooks_count }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Description</span>
                            <span class="meta-value">{{ $ebookPlace->description ?: '-' }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Scan URL</span>
                            <span class="meta-value"><a href="{{ $scanUrl }}" target="_blank">{{ $scanUrl }}</a></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CONNECTED EBOOKS --}}
            <div class="col-lg-8 mb-4">
                <div class="card detail-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Connected Ebooks
                            <span class="badge badge-primary ml-1">{{ $ebookPlace->ebooks_count }}</span>
                        </h6>
                        <a href="{{ route('ebook-assignment.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-sliders-h mr-1"></i> Manage Assignment
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($ebookPlace->ebooks_count === 0)
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-book-open fa-2x mb-3 text-gray-300"></i>
                                <p class="mb-2">Belum ada ebook terhubung ke lokasi ini.</p>
                                <a href="{{ route('ebook-assignment.index') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus mr-1"></i> Atur Assignment
                                </a>
                            </div>
                        @else
                            <div class="mb-3 position-relative">
                                <i class="fas fa-search position-absolute text-muted" style="left:14px; top:50%; transform:translateY(-50%); font-size:13px;"></i>
                                <input type="text" id="ebkSearch" class="form-control form-control-sm"
                                    style="padding-left:34px; border-radius:10px;" placeholder="Cari judul atau penulis...">
                            </div>

                            {{-- Scrollable container with AJAX infinite scroll --}}
                            <div class="ebk-wrap" id="ebkScroll" style="max-height:460px; overflow-y:auto;">
                                <div class="ebk-grid" id="ebkGrid"></div>

                                <div id="ebkLoading" class="text-center text-muted py-3 d-none">
                                    <i class="fas fa-spinner fa-spin mr-1"></i> Memuat...
                                </div>
                                <div id="ebkNoResult" class="text-center text-muted py-4 d-none">
                                    <i class="fas fa-search mr-1"></i> Tidak ada hasil.
                                </div>
                            </div>

                            <div class="mt-3">
                                <small class="text-muted" id="ebkInfo">&nbsp;</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- SCAN VISITORS --}}
        <div class="card detail-card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap" style="gap:8px;">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-qrcode text-info mr-1"></i> Pengunjung Scan
                    <span class="badge badge-primary ml-1">{{ $ebookPlace->checkpoints_count }}</span>
                </h6>
            </div>
            <div class="card-body">
                @if ($ebookPlace->checkpoints_count === 0)
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-qrcode fa-2x mb-3 text-gray-300"></i>
                        <p class="mb-0">Belum ada yang scan lokasi ini.</p>
                    </div>
                @else
                    {{-- Breakdown --}}
                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <div class="font-weight-bold small text-muted mb-2">Per Perangkat</div>
                            <div class="d-flex flex-wrap" style="gap:6px;">
                                @forelse ($scanByDevice as $device => $total)
                                    <span class="badge badge-pill badge-light border" style="font-size:12.5px; padding:7px 12px;">
                                        <i class="fas fa-{{ $device === 'mobile' ? 'mobile-alt' : ($device === 'tablet' ? 'tablet-alt' : 'desktop') }} mr-1 text-info"></i>
                                        {{ ucfirst($device ?: 'Unknown') }}: <b>{{ $total }}</b>
                                    </span>
                                @empty
                                    <span class="text-muted small">-</span>
                                @endforelse
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="font-weight-bold small text-muted mb-2">Per Platform</div>
                            <div class="d-flex flex-wrap" style="gap:6px;">
                                @forelse ($scanByPlatform as $platform => $total)
                                    <span class="badge badge-pill badge-light border" style="font-size:12.5px; padding:7px 12px;">
                                        {{ $platform ?: 'Unknown' }}: <b>{{ $total }}</b>
                                    </span>
                                @empty
                                    <span class="text-muted small">-</span>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- Recent scans --}}
                    <div class="font-weight-bold small text-muted mb-2">Scan Terbaru</div>
                    <div class="table-responsive">
                        <table class="table table-sm rv-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width:150px;">Waktu</th>
                                    <th>Perangkat</th>
                                    <th>Platform</th>
                                    <th>Browser</th>
                                    <th style="width:120px;">IP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($scanCheckpoints as $cp)
                                    <tr>
                                        <td class="small text-muted" data-label="Waktu">
                                            {{ \Carbon\Carbon::parse($cp->checked_at)->format('d M Y') }}<br>
                                            <span style="font-size:11px;">{{ \Carbon\Carbon::parse($cp->checked_at)->format('H:i') }}</span>
                                        </td>
                                        <td class="small" data-label="Perangkat">
                                            <i class="fas fa-{{ $cp->device_type === 'mobile' ? 'mobile-alt' : ($cp->device_type === 'tablet' ? 'tablet-alt' : 'desktop') }} mr-1 text-muted"></i>
                                            {{ ucfirst($cp->device_type ?: '-') }}
                                            @if ($cp->device_name)<span class="text-muted">({{ $cp->device_name }})</span>@endif
                                        </td>
                                        <td class="small" data-label="Platform">{{ $cp->platform ?: '-' }}</td>
                                        <td class="small" data-label="Browser">{{ $cp->browser_name ?: '-' }}{{ $cp->browser_version ? ' ' . $cp->browser_version : '' }}</td>
                                        <td class="small text-muted" data-label="IP" style="word-break:break-all;">{{ $cp->ip_address ?: '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($ebookPlace->checkpoints_count > $scanCheckpoints->count())
                        <small class="text-muted d-block mt-2">Menampilkan {{ $scanCheckpoints->count() }} scan terbaru dari {{ $ebookPlace->checkpoints_count }}.</small>
                    @endif
                @endif
            </div>
        </div>

        {{-- REVIEWS --}}
        <div class="card detail-card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap" style="gap:8px;">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-star text-warning mr-1"></i> Review Pengunjung
                    <span class="badge badge-primary ml-1">{{ $ebookPlace->reviews_count }}</span>
                </h6>
                <div class="d-flex align-items-center" style="gap:8px;">
                    @if ($avgRating)
                        <span class="badge badge-warning" style="font-size:13px;">
                            <i class="fas fa-star mr-1"></i> {{ $avgRating }} / 5 rata-rata
                        </span>
                    @endif
                    @if ($ebookPlace->reviews_count > 0)
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exportReviewModal">
                            <i class="fas fa-file-excel mr-1"></i> Export Excel
                        </button>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if ($reviews->isEmpty())
                    <div class="text-center text-muted py-5">
                        <i class="far fa-comment-dots fa-2x mb-3 text-gray-300"></i>
                        <p class="mb-0">Belum ada review masuk dari pengunjung.</p>
                    </div>
                @else
                    <div class="rv-search-wrap mb-3">
                        <i class="fas fa-search"></i>
                        <input type="text" id="rvSearch" class="form-control form-control-sm"
                            style="padding-left:32px; border-radius:10px;" placeholder="Cari jawaban, rating, ebook...">
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm rv-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width:130px;">Tanggal</th>
                                    <th style="width:120px;">Rating</th>
                                    <th>Jawaban</th>
                                    <th style="width:130px;">Ebook</th>
                                </tr>
                            </thead>
                            <tbody id="rvBody">
                                @foreach ($reviews as $rv)
                                    @php
                                        $searchBits = [
                                            $rv->ebook_slug,
                                            $rv->rating ? $rv->rating . ' bintang' : '',
                                            \Carbon\Carbon::parse($rv->created_at)->format('d M Y'),
                                        ];
                                        foreach (($rv->answers ?? []) as $a) {
                                            $searchBits[] = $a['question'] ?? '';
                                            $searchBits[] = is_array($a['answer'] ?? null) ? implode(' ', $a['answer']) : ($a['answer'] ?? '');
                                        }
                                    @endphp
                                    <tr class="rv-row" data-search="{{ Str::lower(implode(' ', array_filter($searchBits))) }}">
                                        <td class="small text-muted" data-label="Tanggal">{{ \Carbon\Carbon::parse($rv->created_at)->format('d M Y') }}<br>
                                            <span style="font-size:11px;">{{ \Carbon\Carbon::parse($rv->created_at)->format('H:i') }}</span></td>
                                        <td data-label="Rating">
                                            @if ($rv->rating)
                                                <span class="rv-stars text-warning">
                                                    @for ($i = 1; $i <= 5; $i++)<i class="fa{{ $i <= $rv->rating ? 's' : 'r' }} fa-star"></i>@endfor
                                                </span>
                                                <div class="small text-muted mt-1">{{ $rv->rating }}/5</div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td data-label="Jawaban">
                                            @php
                                                $textAnswers = collect($rv->answers ?? [])
                                                    ->filter(fn ($a) => ($a['type'] ?? '') !== 'rating' && !empty($a['answer']));
                                            @endphp
                                            @if ($textAnswers->isEmpty())
                                                <span class="rv-empty">Tidak ada jawaban teks</span>
                                            @else
                                                <div class="rv-answers">
                                                    @foreach ($textAnswers as $a)
                                                        <div class="rv-ans">
                                                            <span class="rv-ans-q">{{ $a['question'] ?? '—' }}</span>
                                                            <span class="rv-ans-v">
                                                                @if (($a['type'] ?? '') === 'choice')
                                                                    @foreach ((is_array($a['answer']) ? $a['answer'] : [$a['answer']]) as $opt)
                                                                        <span class="rv-chip">{{ $opt }}</span>
                                                                    @endforeach
                                                                @else
                                                                    {{ is_array($a['answer']) ? implode(', ', $a['answer']) : $a['answer'] }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </td>
                                        <td class="small text-muted" style="word-break:break-all;" data-label="Ebook">{{ $rv->ebook_slug ?: '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div id="rvNoResult" class="text-center text-muted py-4 d-none">
                        <i class="fas fa-search mr-1"></i> Tidak ada review yang cocok.
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap" style="gap:8px;">
                        <small class="text-muted">
                            Menampilkan <span id="rvShown">{{ $reviews->count() }}</span> review
                            @if ($ebookPlace->reviews_count > $reviews->count())
                                terbaru dari {{ $ebookPlace->reviews_count }}
                            @endif
                        </small>
                    </div>
                @endif
            </div>
        </div>

        {{-- EXPORT REVIEW MODAL --}}
        @if ($ebookPlace->reviews_count > 0)
            <div class="modal fade" id="exportReviewModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="border:none; border-radius:16px; overflow:hidden;">
                        <div class="modal-header" style="background:#1F4E78;">
                            <h6 class="modal-title text-white font-weight-bold m-0">
                                <i class="fas fa-file-excel mr-1"></i> Export Review ke Excel
                            </h6>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity:.9;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body p-0">
                            <div class="row no-gutters">
                                {{-- Column config --}}
                                <div class="col-lg-4 border-right" style="background:#f8fafc;">
                                    <div class="p-3">
                                        <div class="font-weight-bold text-dark mb-1">Kolom</div>
                                        <small class="text-muted d-block mb-3">Centang untuk tampil, geser urutan dengan panah.</small>
                                        <ul id="exportColList" class="list-unstyled mb-0">
                                            @foreach ($exportColumns as $col)
                                                <li class="export-col-item" data-key="{{ $col['key'] }}">
                                                    <label class="m-0 d-flex align-items-center" style="gap:8px; cursor:pointer; flex:1; min-width:0;">
                                                        <input type="checkbox" class="col-visible" checked>
                                                        <span class="col-label" title="{{ $col['label'] }}">{{ $col['label'] }}</span>
                                                    </label>
                                                    <span class="export-col-move">
                                                        <button type="button" class="btn btn-light btn-xs col-up" title="Naik"><i class="fas fa-chevron-up"></i></button>
                                                        <button type="button" class="btn btn-light btn-xs col-down" title="Turun"><i class="fas fa-chevron-down"></i></button>
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                {{-- Live preview iframe --}}
                                <div class="col-lg-8">
                                    <div class="p-2" style="height:60vh;">
                                        <iframe id="exportPreviewFrame" src="about:blank"
                                            style="width:100%; height:100%; border:1px solid #eef1f7; border-radius:10px; background:#fff;"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <small class="text-muted mr-auto">Semua baris akan diekspor (preview hanya sebagian).</small>
                            <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                            <button type="button" id="exportDownloadBtn" class="btn btn-success">
                                <i class="fas fa-download mr-1"></i> Download Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
