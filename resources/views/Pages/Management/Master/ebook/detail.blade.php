@extends('TemplateLayout.AdminLayout')

@push('css')
    <style>
        .detail-card { border:none; border-radius:18px; overflow:hidden;
            box-shadow:0 10px 25px rgba(0,0,0,.05), 0 4px 10px rgba(0,0,0,.03); }
        .detail-card .card-header { background:#fff; border-bottom:1px solid #eef1f7; padding:1.2rem 1.5rem; }
        .meta-row { display:flex; gap:8px; padding:10px 0; border-bottom:1px solid #f1f3f9; }
        .meta-row:last-child { border-bottom:none; }
        .meta-label { width:120px; color:#858796; font-size:13px; flex:0 0 auto; }
        .meta-value { font-weight:600; color:#2f3640; font-size:14px; word-break:break-word; }

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

        @media (max-width: 767.98px) {
            .rv-table { table-layout:auto; }
            .rv-table thead { display:none; }
            .rv-table, .rv-table tbody, .rv-table tr, .rv-table td { display:block; width:100%; }
            .rv-table tbody tr { border:1px solid #e7ebf3; border-radius:12px; padding:6px 12px; margin-bottom:12px; background:#fff; }
            .rv-table td { border:none !important; padding:7px 0; }
            .rv-table td + td { border-top:1px solid #f1f3f9 !important; }
            .rv-table td::before { content:attr(data-label); display:block; font-size:11px; font-weight:700;
                text-transform:uppercase; letter-spacing:.3px; color:#9aa1b1; margin-bottom:3px; }
        }

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
        // Export modal: columns reorder / hide + live preview
        $(document).ready(function () {
            const $list = $('#exportColList');
            if ($list.length) {
                const previewBase = @json($ebook->reviews_count > 0 ? route('ebook.reviews.preview', $ebook->id) : '');
                const exportBase = @json($ebook->reviews_count > 0 ? route('ebook.reviews.export', $ebook->id) : '');
                const $frame = $('#exportPreviewFrame');
                let timer;

                function selectedKeys() {
                    const keys = [];
                    $list.find('.export-col-item').each(function () {
                        if ($(this).find('.col-visible').is(':checked')) keys.push($(this).data('key'));
                    });
                    return keys;
                }
                function colsParam() { return encodeURIComponent(selectedKeys().join(',')); }
                function loadPreview() { $frame.attr('src', previewBase + '?cols=' + colsParam()); }
                function refreshPreview() { clearTimeout(timer); timer = setTimeout(loadPreview, 200); }

                $list.on('click', '.col-up', function () {
                    const $i = $(this).closest('.export-col-item'); const $p = $i.prev('.export-col-item');
                    if ($p.length) { $i.insertBefore($p); refreshPreview(); }
                });
                $list.on('click', '.col-down', function () {
                    const $i = $(this).closest('.export-col-item'); const $n = $i.next('.export-col-item');
                    if ($n.length) { $i.insertAfter($n); refreshPreview(); }
                });
                $list.on('change', '.col-visible', function () {
                    $(this).closest('.export-col-item').toggleClass('col-hidden', !this.checked);
                    refreshPreview();
                });
                $('#exportReviewModal').on('show.bs.modal shown.bs.modal', loadPreview);
                $('[data-target="#exportReviewModal"]').on('click', function () { setTimeout(loadPreview, 50); });
                $('#exportDownloadBtn').on('click', function () {
                    if (selectedKeys().length === 0) {
                        Swal.fire({ icon: 'warning', title: 'Pilih minimal 1 kolom', timer: 1600, showConfirmButton: false });
                        return;
                    }
                    window.location = exportBase + '?cols=' + colsParam();
                });
            }

            // Review search
            const $rows = $('#rvBody .rv-row');
            if ($rows.length) {
                let t;
                $('#rvSearch').on('input', function () {
                    clearTimeout(t);
                    const q = this.value.trim().toLowerCase();
                    t = setTimeout(function () {
                        let shown = 0;
                        $rows.each(function () {
                            const match = !q || ($(this).data('search') || '').toString().includes(q);
                            $(this).toggle(match); if (match) shown++;
                        });
                        $('#rvShown').text(shown);
                        $('#rvNoResult').toggleClass('d-none', shown !== 0);
                    }, 150);
                });
            }
        });
    </script>
@endpush

@section('content')
    @push('title')
        <title>{{ $ebook->title }} - Ebook Detail</title>
    @endpush

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap" style="gap:8px;">
            <div>
                <h1 class="h3 text-gray-800 font-weight-bold mb-0">{{ $ebook->title }}</h1>
                <small class="text-secondary">Ebook detail &amp; review</small>
            </div>
            <div class="d-flex" style="gap:8px;">
                <a href="{{ route('ebook.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
                <a href="{{ route('ebook.edit', $ebook->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
            </div>
        </div>

        <div class="row">
            {{-- INFO --}}
            <div class="col-lg-4 mb-4">
                <div class="card detail-card">
                    <div class="card-header"><h6 class="m-0 font-weight-bold text-primary">Informasi</h6></div>
                    <div class="card-body">
                        @if ($ebook->image_url)
                            <div class="text-center mb-3">
                                <img src="{{ asset($ebook->image_url) }}" alt="{{ $ebook->title }}"
                                    style="max-height:180px; max-width:100%; object-fit:contain; border-radius:10px;">
                            </div>
                        @endif
                        <div class="meta-row"><span class="meta-label">Judul</span><span class="meta-value">{{ $ebook->title }}</span></div>
                        <div class="meta-row"><span class="meta-label">Penulis</span><span class="meta-value">{{ $ebook->author ?: 'Qrun Online' }}</span></div>
                        <div class="meta-row"><span class="meta-label">Kategori</span><span class="meta-value">{{ $ebook->category ?: '-' }}</span></div>
                        <div class="meta-row"><span class="meta-label">Status</span>
                            <span class="meta-value">
                                @if ($ebook->is_published)<span class="badge badge-success">Published</span>
                                @else<span class="badge badge-secondary">Draft</span>@endif
                            </span>
                        </div>
                        <div class="meta-row"><span class="meta-label">Total Review</span><span class="meta-value">{{ $ebook->reviews_count }}</span></div>
                        @if ($avgRating)
                            <div class="meta-row"><span class="meta-label">Rata-rata</span>
                                <span class="meta-value"><i class="fas fa-star text-warning"></i> {{ $avgRating }} / 5</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- REVIEWS --}}
            <div class="col-lg-8 mb-4">
                <div class="card detail-card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap" style="gap:8px;">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-star text-warning mr-1"></i> Review Pembaca
                            <span class="badge badge-primary ml-1">{{ $ebook->reviews_count }}</span>
                        </h6>
                        @if ($ebook->reviews_count > 0)
                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exportReviewModal">
                                <i class="fas fa-file-excel mr-1"></i> Export Excel
                            </button>
                        @endif
                    </div>
                    <div class="card-body">
                        @if ($ebook->reviews_count === 0)
                            <div class="text-center text-muted py-5">
                                <i class="far fa-comment-dots fa-2x mb-3 text-gray-300"></i>
                                <p class="mb-0">Belum ada review untuk e-book ini.</p>
                            </div>
                        @else
                            <div class="rv-search-wrap mb-3">
                                <i class="fas fa-search"></i>
                                <input type="text" id="rvSearch" class="form-control form-control-sm"
                                    style="padding-left:32px; border-radius:10px;" placeholder="Cari jawaban, rating, lokasi...">
                            </div>

                            <div class="table-responsive">
                                <table class="table table-sm rv-table mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width:130px;">Tanggal</th>
                                            <th style="width:120px;">Rating</th>
                                            <th>Jawaban</th>
                                            <th style="width:130px;">Lokasi</th>
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
                                                <td class="small text-muted" data-label="Lokasi" style="word-break:break-all;">{{ $rv->ebook_slug ?: '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div id="rvNoResult" class="text-center text-muted py-4 d-none">
                                <i class="fas fa-search mr-1"></i> Tidak ada review yang cocok.
                            </div>

                            <div class="mt-3">
                                <small class="text-muted">
                                    Menampilkan <span id="rvShown">{{ $reviews->count() }}</span> review
                                    @if ($ebook->reviews_count > $reviews->count())
                                        terbaru dari {{ $ebook->reviews_count }}
                                    @endif
                                </small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- EXPORT MODAL --}}
        @if ($ebook->reviews_count > 0)
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
