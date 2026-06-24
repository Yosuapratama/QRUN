@extends('TemplateLayout.AdminLayout')

@push('css')
    <style>
        .modern-card { border:none; border-radius:18px; overflow:hidden;
            box-shadow:0 10px 25px rgba(0,0,0,.05), 0 4px 10px rgba(0,0,0,.03); }
        .modern-card .card-header { background:#fff; border-bottom:1px solid #eef1f7; padding:1.2rem 1.5rem; }
        .form-label-modern { font-size:14px; font-weight:700; color:#2f3640; margin-bottom:8px; display:block; }
        .form-control { border-radius:12px !important; border:1px solid #e3e6f0; padding:12px 16px; font-size:14px; }
        .location-grid { display:flex; flex-wrap:wrap; gap:10px; }
        .location-chip { display:inline-flex; align-items:center; gap:8px; margin:0; padding:8px 14px;
            border:1px solid #e3e6f0; border-radius:999px; cursor:pointer; font-size:13px; font-weight:600;
            color:#4e5d78; background:#fff; transition:.15s ease; }
        .location-chip:hover { border-color:#4e73df; background:#f5f7ff; }
        .location-chip:has(input:checked) { border-color:#4e73df; background:#eef3ff; color:#2e50b8; }
        .switch { position:relative; display:inline-block; width:58px; height:30px; flex:0 0 58px; }
        .switch input { opacity:0; width:0; height:0; }
        .slider-switch { position:absolute; inset:0; cursor:pointer; background:#d6d9e6; transition:.3s; border-radius:999px; }
        .slider-switch:before { position:absolute; content:""; width:24px; height:24px; left:3px; top:3px; background:#fff; transition:.3s; border-radius:50%; box-shadow:0 2px 8px rgba(0,0,0,.12); }
        .switch input:checked + .slider-switch { background:#4e73df; }
        .switch input:checked + .slider-switch:before { transform:translateX(28px); }
        .connected-list { display:flex; flex-direction:column; gap:8px; max-height:320px; overflow-y:auto; padding-right:4px; }
        .connected-item { display:flex; align-items:center; gap:12px; padding:8px 12px; border:1px solid #e3e6f0; border-radius:12px; background:#fff; }
        .connected-cover { width:38px; height:50px; object-fit:cover; border-radius:6px; flex:0 0 auto; background:#f2f4f9; }
        .connected-meta { flex:1; min-width:0; }
        .connected-title { font-size:13px; font-weight:700; color:#2f3640;
            white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }

        /* Ads / promo */
        .ads-existing-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(150px, 1fr)); gap:14px; }
        .ad-existing-card { border:1px solid #e3e6f0; border-radius:14px; padding:10px; background:#fff; transition:.15s ease; }
        .ad-existing-card.to-remove { border-color:#f1aeb5; background:#fff5f6; opacity:.65; }
        .ad-thumb { height:110px; border-radius:10px; overflow:hidden; background:#f2f4f9; }
        .ad-thumb img { width:100%; height:100%; object-fit:cover; }
        .ad-remove-toggle { display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:600; color:#d9534f; cursor:pointer; }
        .ad-remove-toggle input { margin:0; }

        .new-ad-row { display:flex; gap:12px; align-items:flex-start; border:1px dashed #c9d2e3;
            border-radius:14px; padding:12px; background:#fbfcff; margin-bottom:12px; }
        .new-ad-row .nad-thumb { width:90px; height:90px; flex:0 0 auto; border-radius:10px; overflow:hidden;
            background:#eef1f7; display:flex; align-items:center; justify-content:center; color:#aab2c5; }
        .new-ad-row .nad-thumb img { width:100%; height:100%; object-fit:cover; }
        .new-ad-row .nad-fields { flex:1; min-width:0; }

        /* Section grouping so the form reads top-to-bottom clearly */
        .form-section { border:1px solid #eef1f7; border-radius:16px; padding:18px 20px; margin-bottom:22px; background:#fff; }
        .form-section-head { display:flex; align-items:center; gap:10px; margin-bottom:4px; }
        .form-section-head .ico { width:34px; height:34px; border-radius:10px; display:flex; align-items:center; justify-content:center;
            background:#eef3ff; color:#4e73df; flex:0 0 auto; }
        .form-section-head h5 { font-size:15px; font-weight:800; color:#2f3640; margin:0; }
        .form-section-sub { color:#858796; font-size:12.5px; margin:0 0 16px 44px; }
        @media (max-width:576px){ .form-section-sub { margin-left:0; } }

        /* Review question editor rows */
        .rq-row { display:flex; gap:10px; align-items:flex-start; border:1px dashed #c9d2e3; border-radius:14px;
            padding:12px; background:#fbfcff; margin-bottom:10px; }
        .rq-row .rq-fields { flex:1; min-width:0; }
        .rq-drag { color:#aab2c5; cursor:default; padding-top:8px; }
    </style>
@endpush

@section('content')
    @push('title')
        <title>{{ $ebookPlace ? 'Edit' : 'Create' }} Ebook Location - QRUN Website</title>
    @endpush

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h1 class="h3 text-gray-800 font-weight-bold mb-0">
                {{ $ebookPlace ? 'Edit Location' : 'Create Location' }}
            </h1>
            <a href="{{ route('ebook-place.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
        @if (session()->has('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({ icon: 'success', title: 'Success', text: @json(session('success')), timer: 1800, showConfirmButton: false });
                });
            </script>
        @endif

        <div class="card modern-card mb-4">
            <div class="card-body p-4">

                @if ($ebookPlace)
                    <form action="{{ route('ebook-place.update') }}" method="POST" enctype="multipart/form-data">
                @else
                    <form action="{{ route('ebook-place.store') }}" method="POST" enctype="multipart/form-data">
                @endif
                @csrf
                <input type="hidden" name="id" value="{{ $ebookPlace ? $ebookPlace->id : '' }}">

                {{-- ══ SECTION: Location info ══ --}}
                <div class="form-section-head">
                    <span class="ico"><i class="fas fa-location-dot"></i></span>
                    <h5>Informasi Lokasi</h5>
                </div>
                <p class="form-section-sub">Nama, deskripsi, dan logo yang tampil di halaman scan.</p>

                @if ($ebookPlace)
                    <div class="form-group mb-4">
                        <label class="form-label-modern">Location Code</label>
                        <input class="form-control" value="{{ $ebookPlace->code }}" disabled
                            style="font-family:monospace; background:#f8f9fc;">
                        <small class="text-muted">Auto-generated. Used in the QR / scan URL.</small>
                    </div>
                @endif

                <div class="form-group mb-4">
                    <label class="form-label-modern">Name <span class="text-danger">*</span></label>
                    <input required class="form-control" name="name" type="text"
                        value="{{ old('name', $ebookPlace ? $ebookPlace->name : '') }}"
                        placeholder="e.g. Cafe Bali, Room 101, Lobby Hotel">
                </div>

                <div class="form-group mb-4">
                    <label class="form-label-modern">Description</label>
                    <textarea class="form-control" name="description" rows="2"
                        placeholder="Optional short note about this location...">{{ old('description', $ebookPlace ? $ebookPlace->description : '') }}</textarea>
                </div>

                {{-- LOGO (optional) --}}
                <div class="form-group mb-4">
                    <label class="form-label-modern">Logo <span class="text-muted small">(optional)</span></label>

                    <div class="d-flex align-items-center" style="gap:14px;">
                        @if ($ebookPlace && $ebookPlace->logo_url)
                            <img id="logoPreview" src="{{ asset($ebookPlace->logo_url) }}" alt="Logo"
                                style="width:64px; height:64px; object-fit:contain; border:1px solid #e3e6f0; border-radius:12px; background:#fff; padding:4px;">
                        @else
                            <img id="logoPreview" src="" alt="Logo preview"
                                style="width:64px; height:64px; object-fit:contain; border:1px solid #e3e6f0; border-radius:12px; background:#fff; padding:4px; display:none;">
                        @endif

                        <div class="flex-grow-1">
                            <input type="file" name="logo" id="logoInput" accept="image/png,image/jpeg,image/webp,image/svg+xml"
                                class="form-control" style="padding:10px 14px;">
                            <small class="text-muted d-block mt-1">PNG, JPG, WEBP, or SVG. Max 2MB. Tampil di halaman scan lokasi.</small>

                            @if ($ebookPlace && $ebookPlace->logo_url)
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="checkbox" class="custom-control-input" id="remove_logo" name="remove_logo" value="1">
                                    <label class="custom-control-label small text-danger" for="remove_logo">Remove current logo</label>
                                </div>
                            @endif
                        </div>
                    </div>

                    @error('logo')
                        <p class="text-danger small mt-2 mb-0">{{ $message }}</p>
                    @enderror
                </div>

                <div class="alert alert-light border d-flex align-items-center" style="border-radius:14px;">
                    <i class="fas fa-info-circle text-primary mr-2"></i>
                    <span class="small text-muted mb-0">
                        Atur ebook mana yang tampil di lokasi ini lewat menu
                        <a href="{{ route('ebook-assignment.index') }}" class="font-weight-bold">Assignment</a>.
                    </span>
                </div>

                @if ($ebookPlace)
                    <div class="form-group mb-4">
                        <label class="form-label-modern d-flex align-items-center justify-content-between">
                            <span>Connected Ebooks <span class="badge badge-primary">{{ $ebookPlace->ebooks_count }}</span></span>
                        </label>

                        @if ($ebookPlace->ebooks_count === 0)
                            <p class="text-muted small mb-0">
                                Belum ada ebook terhubung. Tambahkan lewat menu
                                <a href="{{ route('ebook-assignment.index') }}">Assignment</a>.
                            </p>
                        @else
                            <div class="position-relative mb-2">
                                <i class="fas fa-search position-absolute text-muted"
                                    style="left:14px; top:50%; transform:translateY(-50%); font-size:13px;"></i>
                                <input type="text" id="connSearch" class="form-control"
                                    style="padding-left:36px;" placeholder="Cari judul atau penulis...">
                            </div>

                            <div class="connected-list" id="connList"></div>

                            <div id="connLoading" class="text-muted small text-center py-2 d-none">
                                <i class="fas fa-spinner fa-spin mr-1"></i> Memuat...
                            </div>

                            <div id="connEmpty" class="text-muted small text-center py-3 d-none">
                                <i class="fas fa-search mr-1"></i> Tidak ada hasil.
                            </div>

                            <div class="mt-2">
                                <small class="text-muted" id="connInfo">&nbsp;</small>
                            </div>
                            <small class="text-muted d-block mt-1">
                                Kelola daftar ini lewat menu
                                <a href="{{ route('ebook-assignment.index') }}">Assignment</a>.
                            </small>
                        @endif
                    </div>
                @endif

                <hr class="my-4">

                {{-- ══ SECTION: Contact & social ══ --}}
                <div class="form-section-head">
                    <span class="ico"><i class="fas fa-share-nodes"></i></span>
                    <h5>Kontak &amp; Sosial</h5>
                </div>
                <p class="form-section-sub">Ikon yang muncul di halaman scan. WhatsApp &amp; Reservation juga jadi tombol mengambang.</p>

                {{-- CONTACT & SOCIAL (optional) --}}
                <div class="form-group mb-4">
                    <label class="form-label-modern">Contact &amp; Social <span class="text-muted small">(optional)</span></label>
                    <div class="row">
                        @php
                            $contacts = [
                                ['name' => 'instagram',   'icon' => 'fab fa-instagram',      'label' => 'Instagram',   'ph' => 'https://instagram.com/akun'],
                                ['name' => 'tiktok',       'icon' => 'fab fa-tiktok',         'label' => 'TikTok',      'ph' => 'https://tiktok.com/@akun'],
                                ['name' => 'youtube',      'icon' => 'fab fa-youtube',        'label' => 'YouTube',     'ph' => 'https://youtube.com/@channel'],
                                ['name' => 'linkedin',     'icon' => 'fab fa-linkedin',       'label' => 'LinkedIn',    'ph' => 'https://linkedin.com/in/...'],
                                ['name' => 'whatsapp',     'icon' => 'fab fa-whatsapp',       'label' => 'WhatsApp',    'ph' => '628123456789 atau link wa.me'],
                                ['name' => 'email',        'icon' => 'fas fa-envelope',       'label' => 'Email',       'ph' => 'nama@email.com'],
                                ['name' => 'website',      'icon' => 'fas fa-globe',          'label' => 'Website',     'ph' => 'https://situs.com'],
                                ['name' => 'reservation',  'icon' => 'fas fa-calendar-check', 'label' => 'Reservation', 'ph' => 'Link reservasi / pemesanan'],
                            ];
                        @endphp

                        @foreach ($contacts as $c)
                            <div class="col-md-6 mb-3">
                                <label class="small font-weight-bold text-dark">
                                    <i class="{{ $c['icon'] }} mr-1 text-primary"></i> {{ $c['label'] }}
                                </label>
                                <input name="{{ $c['name'] }}" type="text" class="form-control"
                                    value="{{ old($c['name'], $ebookPlace->{$c['name']} ?? '') }}"
                                    placeholder="{{ $c['ph'] }}">
                            </div>
                        @endforeach
                    </div>
                    <small class="text-muted d-block">Yang diisi akan muncul sebagai ikon di halaman scan. WhatsApp &amp; Reservation juga jadi tombol mengambang.</small>
                </div>

                <hr class="my-4">

                {{-- ══ SECTION: Ads / promo ══ --}}
                <div class="form-section-head">
                    <span class="ico"><i class="fas fa-bullhorn"></i></span>
                    <h5>Iklan &amp; Promo</h5>
                </div>
                <p class="form-section-sub">Gambar iklan. Tipe menentukan kapan iklan tampil.</p>

                {{-- ADS / PROMO (optional) --}}
                <div class="form-group mb-4">
                    <div class="alert alert-light border mb-3" style="border-radius:12px;">
                        <div class="small text-muted">Ada 3 tipe iklan:</div>
                        <ul class="small text-muted mb-0 pl-3 mt-1">
                            <li><b>Promo</b> — slider otomatis (modal) saat halaman scan dibuka.</li>
                            <li><b>Unlock — Iklan Waktu</b> — banner yang ditonton beberapa detik untuk buka kunci baca.</li>
                            <li><b>Unlock — Review</b> — banner di atas form review (pertanyaan diatur di bagian Kunci Baca).</li>
                        </ul>
                    </div>

                    {{-- Existing ads (edit) --}}
                    @if ($ebookPlace && $ebookPlace->ads->count())
                        <div class="ads-existing-grid mb-3">
                            @foreach ($ebookPlace->ads as $ad)
                                <div class="ad-existing-card" data-ad="{{ $ad->id }}">
                                    <div class="ad-thumb">
                                        <img src="{{ asset($ad->image_url) }}" alt="Ad">
                                    </div>
                                    <input type="text" class="form-control form-control-sm mt-2"
                                        name="ad_title[{{ $ad->id }}]" value="{{ $ad->title }}"
                                        placeholder="Judul (opsional)">

                                    <select class="form-control form-control-sm mt-2 ad-type-select" name="ad_type[{{ $ad->id }}]">
                                        <option value="promo" @selected($ad->type === 'promo')>Promo (modal scan)</option>
                                        <option value="timed" @selected($ad->type === 'timed')>Unlock — Iklan Waktu</option>
                                        <option value="review" @selected($ad->type === 'review')>Unlock — Review</option>
                                    </select>

                                    <input type="number" min="3" max="600" class="form-control form-control-sm mt-2 ad-field-timed"
                                        name="ad_duration[{{ $ad->id }}]" value="{{ $ad->duration_seconds }}"
                                        placeholder="Durasi detik (opsional)">
                                    <input type="text" class="form-control form-control-sm mt-2 ad-field-target"
                                        name="ad_target_url[{{ $ad->id }}]" value="{{ $ad->target_url }}"
                                        placeholder="Link tujuan (opsional)">

                                    <div class="custom-control custom-checkbox mt-2">
                                        <input type="checkbox" class="custom-control-input" id="ad_active_{{ $ad->id }}"
                                            name="ad_active[{{ $ad->id }}]" value="1" @checked($ad->is_active)>
                                        <label class="custom-control-label small" for="ad_active_{{ $ad->id }}">Aktif</label>
                                    </div>

                                    <label class="ad-remove-toggle mt-2 mb-0">
                                        <input type="checkbox" class="ad-remove-check" name="ad_delete[]" value="{{ $ad->id }}">
                                        <span><i class="fas fa-trash-alt mr-1"></i> Hapus</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- New ads (dynamic rows) --}}
                    <div id="newAdsWrap"></div>

                    <button type="button" id="addAdBtn" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i> Tambah Gambar Ads
                    </button>
                    @error('new_ad_images.*')
                        <p class="text-danger small mt-2 mb-0">{{ $message }}</p>
                    @enderror

                    {{-- Display behaviour --}}
                    <div class="d-flex align-items-center justify-content-between mt-3"
                        style="background:#faf7ff; border:1px solid #e8defb; border-radius:14px; padding:14px 16px;">
                        <div class="pr-3">
                            <div class="font-weight-bold text-dark">Tampilkan setiap reload</div>
                            <small class="text-muted">
                                Aktif: modal muncul tiap kali halaman dibuka. Nonaktif: hanya sekali per sesi pengunjung.
                            </small>
                        </div>
                        <label class="switch mb-0">
                            <input type="checkbox" name="ads_always_show"
                                @checked(old('ads_always_show', $ebookPlace ? $ebookPlace->ads_always_show : false))>
                            <span class="slider-switch"></span>
                        </label>
                    </div>
                </div>

                <hr class="my-4">

                {{-- ══ SECTION: Read gating / lock ══ --}}
                <div class="form-section-head">
                    <span class="ico"><i class="fas fa-lock"></i></span>
                    <h5>Kunci Baca &amp; Buka Kunci</h5>
                </div>
                <p class="form-section-sub">Batasi jumlah baca gratis, dan tentukan cara pengunjung membuka kunci.</p>

                {{-- READ-GATING / LOCK --}}
                <div class="form-group mb-4" style="background:#fff8f1; border:1px solid #ffe0c2; border-radius:14px; padding:16px 18px;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="pr-3">
                            <div class="font-weight-bold text-dark"><i class="fas fa-lock text-warning mr-1"></i> Kunci Baca (Read Limit)</div>
                            <small class="text-muted">
                                Batasi jumlah e-book yang bisa dibaca gratis. Setelah limit, pengunjung harus buka kunci
                                (tonton iklan / beri review) untuk lanjut. Hitungan disimpan di server (anti-modifikasi).
                            </small>
                        </div>
                        <label class="switch mb-0">
                            <input type="checkbox" id="lockEnabled" name="lock_enabled"
                                @checked(old('lock_enabled', $ebookPlace ? $ebookPlace->lock_enabled : false))>
                            <span class="slider-switch"></span>
                        </label>
                    </div>

                    <div id="lockSettings" class="row mt-3">
                        <div class="col-md-4 mb-2">
                            <label class="small font-weight-bold text-dark">Limit baca gratis</label>
                            <input type="number" min="0" max="999" class="form-control" name="read_limit"
                                value="{{ old('read_limit', $ebookPlace->read_limit ?? 2) }}">
                            <small class="text-muted">Jumlah e-book gratis sebelum terkunci.</small>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="small font-weight-bold text-dark">Metode buka kunci</label>
                            <select class="form-control" name="unlock_method">
                                @php $um = old('unlock_method', $ebookPlace->unlock_method ?? 'timed'); @endphp
                                <option value="timed" @selected($um === 'timed')>Iklan Waktu</option>
                                <option value="review" @selected($um === 'review')>Review</option>
                                <option value="both" @selected($um === 'both')>Keduanya</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="small font-weight-bold text-dark">Durasi iklan (detik)</label>
                            <input type="number" min="3" max="600" class="form-control" name="unlock_duration"
                                value="{{ old('unlock_duration', $ebookPlace->unlock_duration ?? 15) }}">
                            <small class="text-muted">Default jika iklan waktu tak punya durasi sendiri.</small>
                        </div>
                    </div>
                    <small class="text-muted d-block mt-1">
                        Banner iklan untuk buka kunci diatur di bagian <b>Iklan &amp; Promo</b> di atas — pilih tipe
                        <b>Unlock — Iklan Waktu</b> atau <b>Unlock — Review</b>.
                    </small>

                    {{-- Review questions editor (only matters for review/both) --}}
                    <div id="reviewQuestionsBlock" class="mt-4 pt-3" style="border-top:1px dashed #ffd9b0;">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <div class="font-weight-bold text-dark"><i class="fas fa-clipboard-question text-warning mr-1"></i> Pertanyaan Review</div>
                        </div>
                        <small class="text-muted d-block mb-2">
                            Pertanyaan yang harus dijawab pengunjung untuk membuka kunci (jawaban tersimpan di website kita).
                            Kosongkan untuk pakai default (rating bintang 1–5).
                        </small>

                        <div id="rqWrap">
                            @php $existingQuestions = $ebookPlace?->reviewQuestions ?? collect(); @endphp
                            @foreach ($existingQuestions as $q)
                                <div class="rq-row">
                                    <span class="rq-drag"><i class="fas fa-grip-vertical"></i></span>
                                    <div class="rq-fields">
                                        <input type="text" name="rq_text[]" class="form-control form-control-sm" value="{{ $q->question }}" placeholder="Tulis pertanyaan...">
                                        <div class="row mt-2">
                                            <div class="col-sm-4 mb-2">
                                                <select name="rq_type[]" class="form-control form-control-sm rq-type">
                                                    <option value="rating" @selected($q->type === 'rating')>Rating (bintang)</option>
                                                    <option value="text" @selected($q->type === 'text')>Teks singkat</option>
                                                    <option value="textarea" @selected($q->type === 'textarea')>Teks panjang</option>
                                                    <option value="choice" @selected($q->type === 'choice')>Pilihan</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-5 mb-2">
                                                <input type="text" name="rq_options[]" class="form-control form-control-sm rq-options"
                                                    value="{{ is_array($q->options) ? implode(', ', $q->options) : '' }}"
                                                    placeholder="Pilihan, pisah koma" style="{{ $q->type === 'choice' ? '' : 'display:none;' }}">
                                            </div>
                                            <div class="col-sm-3 mb-2">
                                                <select name="rq_required[]" class="form-control form-control-sm">
                                                    <option value="1" @selected($q->is_required)>Wajib</option>
                                                    <option value="0" @selected(!$q->is_required)>Opsional</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light text-danger rq-remove" title="Hapus"><i class="fas fa-times"></i></button>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" id="addRqBtn" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-plus mr-1"></i> Tambah Pertanyaan
                        </button>
                    </div>
                </div>

                <div class="form-group mb-4 d-flex align-items-center justify-content-between"
                    style="background:#f8f9ff; border:1px solid #dfe7ff; border-radius:14px; padding:16px 18px;">
                    <div>
                        <div class="font-weight-bold text-dark">Active</div>
                        <small class="text-muted">Inactive locations show a 404 when scanned.</small>
                    </div>
                    <label class="switch mb-0">
                        <input type="checkbox" name="is_active"
                            @checked(old('is_active', $ebookPlace ? $ebookPlace->is_active : true))>
                        <span class="slider-switch"></span>
                    </label>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn {{ $ebookPlace ? 'btn-primary' : 'btn-success' }}">
                        <i class="fas {{ $ebookPlace ? 'fa-save' : 'fa-paper-plane' }} mr-2"></i>
                        {{ $ebookPlace ? 'Update' : 'Create' }}
                    </button>
                </div>

                </form>
            </div>
        </div>

    </div>

    @push('script')
        <script>
            document.getElementById('logoInput').addEventListener('change', function () {
                const file = this.files[0];
                const preview = document.getElementById('logoPreview');
                if (file) {
                    preview.src = URL.createObjectURL(file);
                    preview.style.display = '';
                    const removeBox = document.getElementById('remove_logo');
                    if (removeBox) removeBox.checked = false;
                }
            });

            // ── Existing ads: visually mark cards flagged for removal ──
            document.querySelectorAll('.ad-remove-check').forEach(function (cb) {
                cb.addEventListener('change', function () {
                    this.closest('.ad-existing-card').classList.toggle('to-remove', this.checked);
                });
            });

            // ── New ads: dynamic add / remove rows with live preview ──
            (function () {
                const wrap = document.getElementById('newAdsWrap');
                const addBtn = document.getElementById('addAdBtn');

                function buildRow() {
                    const row = document.createElement('div');
                    row.className = 'new-ad-row';
                    row.innerHTML =
                        '<div class="nad-thumb"><i class="fas fa-image"></i></div>' +
                        '<div class="nad-fields">' +
                            '<input type="file" name="new_ad_images[]" accept="image/png,image/jpeg,image/webp" class="form-control form-control-sm nad-file">' +
                            '<input type="text" name="new_ad_titles[]" class="form-control form-control-sm mt-2" placeholder="Judul (opsional)">' +
                            '<select name="new_ad_types[]" class="form-control form-control-sm mt-2 ad-type-select">' +
                                '<option value="promo">Promo (modal scan)</option>' +
                                '<option value="timed">Unlock — Iklan Waktu</option>' +
                                '<option value="review">Unlock — Review</option>' +
                            '</select>' +
                            '<input type="number" min="3" max="600" name="new_ad_durations[]" class="form-control form-control-sm mt-2 ad-field-timed" placeholder="Durasi detik (opsional)">' +
                            '<input type="text" name="new_ad_target_urls[]" class="form-control form-control-sm mt-2 ad-field-target" placeholder="Link tujuan (opsional)">' +
                        '</div>' +
                        '<button type="button" class="btn btn-sm btn-light text-danger nad-remove" title="Remove"><i class="fas fa-times"></i></button>';

                    row.querySelector('.nad-file').addEventListener('change', function () {
                        const file = this.files[0];
                        const thumb = row.querySelector('.nad-thumb');
                        if (file) {
                            thumb.innerHTML = '<img src="' + URL.createObjectURL(file) + '" alt="preview">';
                        } else {
                            thumb.innerHTML = '<i class="fas fa-image"></i>';
                        }
                    });

                    row.querySelector('.nad-remove').addEventListener('click', function () {
                        row.remove();
                    });

                    const sel = row.querySelector('.ad-type-select');
                    sel.addEventListener('change', function () { applyAdTypeToggle(sel); });
                    applyAdTypeToggle(sel);

                    return row;
                }

                addBtn.addEventListener('click', function () {
                    wrap.appendChild(buildRow());
                });
            })();

            // ── Ad type: show only the fields relevant to the chosen role ──
            function applyAdTypeToggle(select) {
                const scope = select.closest('.ad-existing-card') || select.closest('.new-ad-row');
                if (!scope) return;
                const type = select.value;
                const timed = scope.querySelector('.ad-field-timed');
                const target = scope.querySelector('.ad-field-target');
                if (timed) timed.style.display = (type === 'timed') ? '' : 'none';
                if (target) target.style.display = (type === 'timed' || type === 'promo') ? '' : 'none';
            }

            document.querySelectorAll('.ad-existing-card .ad-type-select').forEach(function (sel) {
                sel.addEventListener('change', function () { applyAdTypeToggle(sel); });
                applyAdTypeToggle(sel);
            });

            // ── Lock settings: collapse when the gate is off ──
            (function () {
                const toggle = document.getElementById('lockEnabled');
                const panel = document.getElementById('lockSettings');
                const methodSel = document.querySelector('select[name="unlock_method"]');
                const rqBlock = document.getElementById('reviewQuestionsBlock');
                if (!toggle || !panel) return;

                function syncMethod() {
                    if (!rqBlock || !methodSel) return;
                    const m = methodSel.value;
                    rqBlock.style.display = (m === 'review' || m === 'both') ? '' : 'none';
                }
                function sync() {
                    panel.style.display = toggle.checked ? '' : 'none';
                    if (rqBlock) rqBlock.style.display = toggle.checked ? rqBlock.style.display : 'none';
                    if (toggle.checked) syncMethod();
                }
                toggle.addEventListener('change', sync);
                if (methodSel) methodSel.addEventListener('change', syncMethod);
                sync();
            })();

            // ── Review questions: add / remove rows, options toggle ──
            (function () {
                const wrap = document.getElementById('rqWrap');
                const addBtn = document.getElementById('addRqBtn');
                if (!wrap || !addBtn) return;

                function bindRow(row) {
                    const typeSel = row.querySelector('.rq-type');
                    const opts = row.querySelector('.rq-options');
                    function syncOpts() { if (opts) opts.style.display = typeSel.value === 'choice' ? '' : 'none'; }
                    if (typeSel) { typeSel.addEventListener('change', syncOpts); syncOpts(); }
                    const rm = row.querySelector('.rq-remove');
                    if (rm) rm.addEventListener('click', function () { row.remove(); });
                }

                function buildRow() {
                    const row = document.createElement('div');
                    row.className = 'rq-row';
                    row.innerHTML =
                        '<span class="rq-drag"><i class="fas fa-grip-vertical"></i></span>' +
                        '<div class="rq-fields">' +
                            '<input type="text" name="rq_text[]" class="form-control form-control-sm" placeholder="Tulis pertanyaan...">' +
                            '<div class="row mt-2">' +
                                '<div class="col-sm-4 mb-2"><select name="rq_type[]" class="form-control form-control-sm rq-type">' +
                                    '<option value="rating">Rating (bintang)</option>' +
                                    '<option value="text">Teks singkat</option>' +
                                    '<option value="textarea">Teks panjang</option>' +
                                    '<option value="choice">Pilihan</option>' +
                                '</select></div>' +
                                '<div class="col-sm-5 mb-2"><input type="text" name="rq_options[]" class="form-control form-control-sm rq-options" placeholder="Pilihan, pisah koma" style="display:none;"></div>' +
                                '<div class="col-sm-3 mb-2"><select name="rq_required[]" class="form-control form-control-sm">' +
                                    '<option value="1">Wajib</option><option value="0">Opsional</option>' +
                                '</select></div>' +
                            '</div>' +
                        '</div>' +
                        '<button type="button" class="btn btn-sm btn-light text-danger rq-remove" title="Hapus"><i class="fas fa-times"></i></button>';
                    bindRow(row);
                    return row;
                }

                wrap.querySelectorAll('.rq-row').forEach(bindRow);
                addBtn.addEventListener('click', function () { wrap.appendChild(buildRow()); });
            })();

            @if ($ebookPlace && $ebookPlace->ebooks_count > 0)
            // ── Connected ebooks: lazy AJAX load + search + load more ──
            (function () {
                const url = @json(route('ebook-place.connected', $ebookPlace->id));
                const $list = $('#connList');
                const $info = $('#connInfo');
                const $loadingEl = $('#connLoading');
                const $empty = $('#connEmpty');
                const $search = $('#connSearch');
                const listEl = $list.get(0);

                let page = 1, q = '', hasMore = false, loading = false, total = 0;
                let timer;

                function rowHtml(it) {
                    const draft = it.is_published ? '' : '<span class="badge badge-secondary">Draft</span>';
                    const sub = it.author + (it.category ? ' • ' + it.category : '');
                    return '<a href="' + it.edit_url + '" class="connected-item text-decoration-none" target="_blank">' +
                        '<img src="' + it.image_url + '" class="connected-cover" loading="lazy">' +
                        '<div class="connected-meta">' +
                            '<div class="connected-title">' + $('<span>').text(it.title).html() + '</div>' +
                            '<small class="text-muted">' + $('<span>').text(sub).html() + '</small>' +
                        '</div>' + draft + '</a>';
                }

                function load(reset) {
                    if (loading) return;
                    loading = true;
                    const nextPage = reset ? 1 : page + 1;
                    $loadingEl.toggleClass('d-none', !hasMore && !reset);

                    $.get(url, { page: nextPage, q: q })
                        .done(function (res) {
                            if (reset) { $list.empty(); page = 1; }
                            res.items.forEach(function (it) { $list.append(rowHtml(it)); });
                            page = res.page;
                            hasMore = res.hasMore;
                            total = res.total;
                            $empty.toggleClass('d-none', total !== 0);
                            $info.text(total ? 'Menampilkan ' + $list.children().length + ' dari ' + total : '');
                        })
                        .always(function () {
                            loading = false;
                            $loadingEl.addClass('d-none');
                            // Keep filling while the list isn't scrollable yet.
                            setTimeout(checkScroll, 80);
                        });
                }

                // Infinite scroll inside the list container.
                function checkScroll() {
                    if (loading || !hasMore || !listEl) return;
                    if (listEl.scrollTop + listEl.clientHeight >= listEl.scrollHeight - 60) {
                        load(false);
                    }
                }
                $list.on('scroll', checkScroll);

                $search.on('input', function () {
                    q = this.value.trim();
                    clearTimeout(timer);
                    timer = setTimeout(function () { load(true); }, 250);
                });

                load(true);
            })();
            @endif
        </script>
    @endpush
@endsection
