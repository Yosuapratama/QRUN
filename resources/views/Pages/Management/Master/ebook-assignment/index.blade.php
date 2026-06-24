@extends('TemplateLayout.AdminLayout')

@push('css')
    <style>
        .assign-card { border:none; border-radius:18px; overflow:hidden;
            box-shadow:0 10px 25px rgba(0,0,0,.05), 0 4px 10px rgba(0,0,0,.03); }
        .assign-card .card-header { background:#fff; border-bottom:1px solid #eef1f7; padding:1.2rem 1.5rem; }

        /* ── Item (shared) ───────────────────────────── */
        .ebook-pick {
            position:relative; border:1px solid #e3e6f0; border-radius:14px; overflow:hidden;
            cursor:pointer; background:#fff; transition:.15s ease; margin:0;
        }
        .ebook-pick:hover { border-color:#4e73df; box-shadow:0 6px 16px rgba(78,115,223,.12); }
        .ebook-pick input { position:absolute; opacity:0; pointer-events:none; }
        .ebook-pick .cover { background:#f2f4f9; }
        .ebook-pick .cover img { width:100%; height:100%; object-fit:cover; }
        .ebook-pick .meta h6 { font-size:13px; font-weight:700; color:#2f3640; margin:0 0 2px;
            display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
        .ebook-pick .meta small { color:#858796; font-size:11px; }
        .ebook-pick .check {
            width:26px; height:26px; border-radius:50%;
            background:rgba(255,255,255,.95); border:1px solid #e3e6f0; display:flex; align-items:center;
            justify-content:center; color:transparent; transition:.15s ease; flex:0 0 auto;
        }
        .ebook-pick input:checked ~ .check { background:#4e73df; border-color:#4e73df; color:#fff; }
        .ebook-pick:has(input:checked) { border-color:#4e73df; box-shadow:0 0 0 2px rgba(78,115,223,.25); }

        /* ── Grid view ───────────────────────────────── */
        .view-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(150px, 1fr)); gap:16px; }
        .view-grid .ebook-pick .cover { height:120px; aspect-ratio:auto; }
        .view-grid .ebook-pick .meta { padding:10px 12px; }
        .view-grid .ebook-pick .check { position:absolute; top:10px; right:10px; }

        /* ── List view ───────────────────────────────── */
        .view-list { display:block; }
        .view-list .ebook-pick { display:flex; align-items:center; gap:12px; padding:8px 12px; margin-bottom:8px; }
        .view-list .ebook-pick .cover { order:1; width:42px; height:56px; border-radius:8px; overflow:hidden; flex:0 0 auto; }
        .view-list .ebook-pick .meta { order:2; flex:1; padding:0; min-width:0; }
        .view-list .ebook-pick .meta h6 { -webkit-line-clamp:1; }
        .view-list .ebook-pick .check { order:3; margin-left:auto; }

        /* ── Toolbar / view toggle ───────────────────── */
        .view-toggle .btn { border-radius:8px; }
        .view-toggle .btn.active { background:#4e73df; border-color:#4e73df; color:#fff; }

        /* ── Pager ───────────────────────────────────── */
        .pager { display:flex; align-items:center; justify-content:flex-end; gap:6px; flex-wrap:wrap; }
        .pager button {
            min-width:36px; height:36px; border-radius:8px; border:1px solid #e3e6f0; background:#fff;
            color:#5a6275; font-weight:600; font-size:13px; transition:.15s ease;
        }
        .pager button:hover:not(:disabled) { border-color:#4e73df; color:#4e73df; }
        .pager button.active { background:#4e73df; border-color:#4e73df; color:#fff; }
        .pager button:disabled { opacity:.4; cursor:not-allowed; }

        .sticky-bar { position:sticky; bottom:0; background:#fff; border-top:1px solid #eef1f7;
            padding:14px 18px; display:flex; justify-content:space-between; align-items:center;
            border-radius:0 0 18px 18px; gap:8px; flex-wrap:wrap; }
    </style>
@endpush

@section('content')
    @push('title')
        <title>Ebook Assignment - QRUN Website</title>
    @endpush

    <div class="container-fluid">

        <div class="m-2 mb-4">
            <h1 class="h3 text-gray-800 font-weight-bold mb-0">Ebook Assignment</h1>
            <small class="text-secondary">Pilih lokasi, lalu centang ebook yang tampil saat QR lokasi itu di-scan.</small>
        </div>

        <div class="card assign-card mb-4">
            <div class="card-header">
                <div class="row align-items-end">
                    <div class="col-md-4 mb-2 mb-md-0">
                        <label class="small font-weight-bold text-dark">Location</label>
                        <div class="d-flex align-items-center" style="gap:8px;">
                            <div style="flex:1; min-width:0;">
                                <select id="locationSelect" class="form-control" style="width:100%;">
                                    <option></option>
                                    @foreach ($locations as $loc)
                                        <option value="{{ $loc->id }}" data-code="{{ $loc->code }}">{{ $loc->name }} ({{ $loc->code }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <a id="previewLink" href="#" target="_blank" tabindex="-1"
                                class="btn btn-outline-secondary disabled" title="Preview halaman lokasi"
                                style="pointer-events:none;">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0">
                        <label class="small font-weight-bold text-dark">Search ebook</label>
                        <input type="text" id="ebookSearch" class="form-control" placeholder="Title or author..." disabled>
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0">
                        <label class="small font-weight-bold text-dark">Sort by</label>
                        <select id="sortSelect" class="form-control">
                            <option value="selected">Dipilih dulu</option>
                            <option value="name">Nama (A–Z)</option>
                            <option value="created">Terbaru</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="small font-weight-bold text-dark d-block">View</label>
                        <div class="btn-group view-toggle w-100" role="group">
                            <button type="button" class="btn btn-outline-secondary active" id="viewGridBtn" title="Grid">
                                <i class="fas fa-th-large"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary" id="viewListBtn" title="List">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div id="emptyState" class="text-center text-muted py-5">
                    <i class="fas fa-hand-pointer fa-2x mb-3 text-gray-300"></i>
                    <p class="mb-0">Pilih lokasi dulu untuk mengatur ebook-nya.</p>
                </div>

                <form id="assignForm" action="{{ route('ebook-assignment.store') }}" method="POST" class="d-none">
                    @csrf
                    <input type="hidden" name="ebook_place_id" id="ebook_place_id">

                    @if ($ebooks->isEmpty())
                        <p class="text-muted">Belum ada ebook. Buat dulu di <a href="{{ route('ebook.index') }}">Manage Ebook</a>.</p>
                    @else
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3" style="gap:10px;">
                            <small class="text-muted">
                                Menampilkan <span id="rangeInfo">0</span>
                                <span id="noResult" class="d-none text-danger">· Tidak ada hasil</span>
                            </small>
                            <div class="d-flex align-items-center flex-wrap" style="gap:8px;">
                                <button type="button" class="btn btn-sm btn-outline-primary" id="selectAllBtn">
                                    <i class="fas fa-check-double mr-1"></i> Select All
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAllBtn">
                                    <i class="fas fa-times mr-1"></i> Deselect All
                                </button>
                                <div class="d-flex align-items-center" style="gap:6px;">
                                    <small class="text-muted">Per page</small>
                                    <select id="pageSizeSelect" class="form-control form-control-sm" style="width:auto;">
                                        <option value="10">10</option>
                                        <option value="15">15</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="view-grid" id="ebookGrid">
                            @foreach ($ebooks as $eb)
                                <label class="ebook-pick"
                                    data-search="{{ Str::lower($eb->title . ' ' . $eb->author) }}"
                                    data-title="{{ Str::lower($eb->title) }}"
                                    data-created="{{ $eb->created_at ? \Carbon\Carbon::parse($eb->created_at)->timestamp : 0 }}">
                                    <input type="checkbox" name="ebooks[]" value="{{ $eb->id }}">
                                    <div class="cover">
                                        <img src="{{ asset($eb->image_url) }}" alt="{{ $eb->title }}" loading="lazy">
                                    </div>
                                    <div class="check"><i class="fas fa-check" style="font-size:12px;"></i></div>
                                    <div class="meta">
                                        <h6>{{ $eb->title }}</h6>
                                        <small>{{ $eb->author ?: 'Qrun Online' }}</small>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <div class="pager mt-4" id="pager"></div>
                    @endif
                </form>
            </div>

            <div class="sticky-bar d-none" id="stickyBar">
                <span class="small text-muted"><span id="selectedCount">0</span> ebook dipilih</span>
                <div>
                    <button type="button" class="btn btn-sm btn-outline-secondary mr-2" id="clearBtn">Clear</button>
                    <button type="submit" form="assignForm" class="btn btn-sm btn-primary">
                        <i class="fas fa-save mr-1"></i> Save Assignment
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            $(document).ready(function () {
                let pageSize = 10;

                const $grid = $('#ebookGrid');
                const $form = $('#assignForm');
                const $empty = $('#emptyState');
                const $bar = $('#stickyBar');
                const $items = $grid.find('.ebook-pick');

                let allItems = $items.toArray();
                let filtered = allItems.slice();
                let page = 1;

                $('#locationSelect').select2({
                    theme: 'default',
                    width: '100%',
                    allowClear: true,
                    placeholder: 'Search & select a location...'
                });

                function updateCount() {
                    $('#selectedCount').text($grid.find('input:checked').length);
                }

                function computeFiltered() {
                    const q = $('#ebookSearch').val().trim().toLowerCase();
                    filtered = allItems.filter(function (el) {
                        return $(el).data('search').toString().includes(q);
                    });
                }

                function applySort(mode) {
                    allItems.sort(function (a, b) {
                        if (mode === 'name') {
                            return $(a).data('title').toString().localeCompare($(b).data('title').toString());
                        }
                        if (mode === 'created') {
                            return (Number($(b).data('created')) || 0) - (Number($(a).data('created')) || 0);
                        }
                        // 'selected': checked first, then by title
                        const ca = a.querySelector('input').checked ? 0 : 1;
                        const cb = b.querySelector('input').checked ? 0 : 1;
                        if (ca !== cb) return ca - cb;
                        return $(a).data('title').toString().localeCompare($(b).data('title').toString());
                    });
                    // Reflect the new order in the DOM so pagination shows them sorted.
                    allItems.forEach(function (el) { $grid.append(el); });
                }

                function refresh() {
                    applySort($('#sortSelect').val());
                    computeFiltered();
                    renderPage();
                }

                function renderPage() {
                    const total = filtered.length;
                    const pages = Math.max(1, Math.ceil(total / pageSize));
                    if (page > pages) page = pages;
                    if (page < 1) page = 1;

                    const start = (page - 1) * pageSize;
                    const end = start + pageSize;

                    $items.css('display', 'none');
                    filtered.slice(start, end).forEach(function (el) { el.style.display = ''; });

                    $('#rangeInfo').text(total ? (start + 1) + '–' + Math.min(end, total) + ' dari ' + total : '0');
                    $('#noResult').toggleClass('d-none', total !== 0);

                    buildPager(pages);
                }

                function buildPager(pages) {
                    const $pager = $('#pager').empty();
                    if (pages <= 1) return;

                    function pageBtn(label, target, opts) {
                        opts = opts || {};
                        const $b = $('<button type="button"></button>').html(label);
                        if (opts.active) $b.addClass('active');
                        if (opts.disabled) $b.prop('disabled', true);
                        if (!opts.disabled && !opts.active) $b.on('click', function () { page = target; renderPage(); });
                        return $b;
                    }

                    $pager.append(pageBtn('<i class="fas fa-chevron-left"></i>', page - 1, { disabled: page === 1 }));

                    // windowed page numbers (max 5 around current)
                    let from = Math.max(1, page - 2);
                    let to = Math.min(pages, from + 4);
                    from = Math.max(1, to - 4);

                    if (from > 1) {
                        $pager.append(pageBtn('1', 1, { active: page === 1 }));
                        if (from > 2) $pager.append($('<span class="px-1 text-muted">…</span>'));
                    }
                    for (let p = from; p <= to; p++) {
                        $pager.append(pageBtn(String(p), p, { active: p === page }));
                    }
                    if (to < pages) {
                        if (to < pages - 1) $pager.append($('<span class="px-1 text-muted">…</span>'));
                        $pager.append(pageBtn(String(pages), pages, { active: page === pages }));
                    }

                    $pager.append(pageBtn('<i class="fas fa-chevron-right"></i>', page + 1, { disabled: page === pages }));
                }

                function loadLocation(id) {
                    if (!id) {
                        $form.addClass('d-none');
                        $bar.addClass('d-none');
                        $empty.removeClass('d-none');
                        $('#ebookSearch').prop('disabled', true).val('');
                        return;
                    }

                    $('#ebook_place_id').val(id);
                    $grid.find('input').prop('checked', false);

                    $.get('/management/master/ebook-assignment/' + id + '/ebooks', function (res) {
                        (res.ebook_ids || []).forEach(function (eid) {
                            $grid.find('input[value="' + eid + '"]').prop('checked', true);
                        });
                        updateCount();
                        // Re-apply sort now that selections are known (matters for "Dipilih dulu").
                        page = 1;
                        refresh();
                    });

                    $empty.addClass('d-none');
                    $form.removeClass('d-none');
                    $bar.removeClass('d-none');
                    $('#ebookSearch').prop('disabled', false).val('');

                    page = 1;
                    refresh();
                }

                $('#locationSelect').on('change', function () {
                    const id = $(this).val();
                    const code = $(this).find(':selected').data('code');
                    const $eye = $('#previewLink');
                    if (id && code) {
                        $eye.attr('href', '/ebook-place/' + code).removeClass('disabled').css('pointer-events', '');
                    } else {
                        $eye.attr('href', '#').addClass('disabled').css('pointer-events', 'none');
                    }
                    loadLocation(id);
                });

                $grid.on('change', 'input', updateCount);

                $('#clearBtn').on('click', function () {
                    $grid.find('input').prop('checked', false);
                    updateCount();
                    if ($('#sortSelect').val() === 'selected') refresh();
                });

                $('#sortSelect').on('change', function () {
                    page = 1;
                    refresh();
                });

                $('#pageSizeSelect').on('change', function () {
                    pageSize = parseInt($(this).val(), 10) || 10;
                    page = 1;
                    renderPage();
                });

                $('#selectAllBtn').on('click', function () {
                    $grid.find('input[type=checkbox]').prop('checked', true);
                    updateCount();
                    if ($('#sortSelect').val() === 'selected') refresh();
                });

                $('#deselectAllBtn').on('click', function () {
                    $grid.find('input[type=checkbox]').prop('checked', false);
                    updateCount();
                    if ($('#sortSelect').val() === 'selected') refresh();
                });

                // ── Save assignment via AJAX (no reload, keep selection) ──────
                $form.on('submit', function (e) {
                    e.preventDefault();

                    if (!$('#ebook_place_id').val()) return;

                    const $btn = $('button[form="assignForm"]');
                    const original = $btn.html();
                    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');

                    $.ajax({
                        url: $form.attr('action'),
                        type: 'POST',
                        data: $form.serialize(),
                        success: function (res) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: res.success || 'Assignment saved!',
                                showConfirmButton: false,
                                timer: 2200,
                                timerProgressBar: true
                            });
                            // Re-sort so "Dipilih dulu" reflects the saved state.
                            if ($('#sortSelect').val() === 'selected') refresh();
                        },
                        error: function (xhr) {
                            const msg = xhr.responseJSON?.message || 'Failed to save assignment.';
                            Swal.fire({ icon: 'error', title: 'Error', text: msg });
                        },
                        complete: function () {
                            $btn.prop('disabled', false).html(original);
                        }
                    });
                });

                let searchTimer;
                $('#ebookSearch').on('input', function () {
                    clearTimeout(searchTimer);
                    searchTimer = setTimeout(function () {
                        page = 1;
                        computeFiltered();
                        renderPage();
                    }, 200);
                });

                // View toggle
                $('#viewGridBtn').on('click', function () {
                    $grid.removeClass('view-list').addClass('view-grid');
                    $(this).addClass('active');
                    $('#viewListBtn').removeClass('active');
                });
                $('#viewListBtn').on('click', function () {
                    $grid.removeClass('view-grid').addClass('view-list');
                    $(this).addClass('active');
                    $('#viewGridBtn').removeClass('active');
                });
            });
        </script>
    @endpush
@endsection
