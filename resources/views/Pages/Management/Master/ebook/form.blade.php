@extends('TemplateLayout.AdminLayout')

@section('content')
    @push('title')
        <title>{{ $ebook ? 'Update' : 'Create' }} Ebook Admin - QRUN Website</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <style>
            .toast-success { background-color: #28a745 !important; }
            .toast-error { background-color: #dc3545 !important; }
            .toast-info { background-color: #17a2b8 !important; }
            .toast-warning { background-color: #ffc107 !important; color: #000 !important; }
            .toast { opacity: 1 !important; }
        </style>

        <script>
            toastr.options = {
                closeButton: true,
                progressBar: true,
                newestOnTop: true,
                positionClass: "toast-top-right",
                timeOut: 8000,
                extendedTimeOut: 8000,
                showDuration: 300,
                hideDuration: 300,
                preventDuplicates: true,
            };
        </script>
    @endpush

    <div class="container-fluid">

        {{-- PAGE HEADER --}}
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    {{ $ebook ? 'Update Ebook' : 'Create Ebook' }}
                </h1>
                <div class="page-subtitle">
                    Fill in the information below to publish an ebook to the catalog.
                </div>
            </div>

            <a href="{{ route('ebook.index') }}" class="btn btn-outline-secondary btn-modern">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        {{-- VALIDATION ERRORS --}}
        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    @foreach ($errors->all() as $error)
                        toastr.error(@json($error), 'Error');
                    @endforeach
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

        <div class="card modern-card mb-4">

            <div class="card-header">
                <div class="section-title">Ebook Information</div>
                <div class="section-subtitle">Title, author, cover and content of the ebook.</div>
            </div>

            <div class="card-body">

                @if ($ebook)
                    <form method="POST" action="{{ route('ebook.update') }}" id="formDropzone">
                @else
                    <form action="{{ route('ebook.store') }}" method="POST" id="formDropzone">
                @endif

                @csrf

                <input type="hidden" name="id" value="{{ $ebook ? $ebook->id : '' }}">

                {{-- TITLE --}}
                <div class="form-group-modern">
                    <label class="form-label-modern">Title <span class="text-danger">*</span></label>
                    <input required class="form-control" value="{{ old('title', $ebook ? $ebook->title : '') }}"
                        name="title" type="text" id="title" placeholder="Enter ebook title...">
                    @error('title')
                        <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                    @enderror
                </div>

                <div class="row">
                    {{-- AUTHOR --}}
                    <div class="col-md-6">
                        <div class="form-group-modern">
                            <label class="form-label-modern">Author</label>
                            <input class="form-control" value="{{ old('author', $ebook ? $ebook->author : '') }}"
                                name="author" type="text" id="author" placeholder="e.g. John Doe">
                        </div>
                    </div>
                    {{-- CATEGORY --}}
                    <div class="col-md-6">
                        <div class="form-group-modern">
                            <label class="form-label-modern">Category</label>

                            @php
                                $selectedCategory = old('category', $ebook ? $ebook->category : '');
                                $categoryNames = $categories->pluck('name')->toArray();
                                // If the ebook's current category is no longer in the master list, keep it selectable.
                                $missingCategory = $selectedCategory && !in_array($selectedCategory, $categoryNames);
                            @endphp

                            <select class="form-control select2-tags" name="category" id="category" style="width:100%;"
                                data-placeholder="Search or type a category...">
                                <option value=""></option>
                                @if ($missingCategory)
                                    <option value="{{ $selectedCategory }}" selected>{{ $selectedCategory }}</option>
                                @endif
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->name }}" @selected($selectedCategory === $cat->name)>{{ $cat->name }}</option>
                                @endforeach
                            </select>

                            <small class="text-muted d-block mt-1">
                                Type to search, or enter a new name to create a category.
                            </small>
                        </div>
                    </div>
                </div>

                {{-- SLUG --}}
                <div class="form-group-modern">
                    <label class="form-label-modern">Slug <span class="text-danger">*</span></label>
                    <input required class="form-control" value="{{ old('slug', $ebook ? $ebook->slug : '') }}" name="slug"
                        type="text" id="slug" placeholder="example-ebook-slug">
                    @error('slug')
                        <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                    @enderror
                </div>

                {{-- DESCRIPTION --}}
                <div class="form-group-modern">
                    <label class="form-label-modern">Description <span class="text-danger">*</span></label>
                    <textarea required class="form-control" rows="3" name="description" id="description"
                        placeholder="Short description about this ebook...">{{ old('description', $ebook ? $ebook->description : '') }}</textarea>
                    @error('description')
                        <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CONTENT --}}
                <div class="form-group-modern">
                    <label class="form-label-modern">Content <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="content" id="summernote">{{ old('content', $ebook ? $ebook->content : '') }}</textarea>
                    @error('content')
                        <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                    @enderror
                </div>

                {{-- COVER --}}
                <div class="form-group-modern">
                    <label class="form-label-modern">Cover <span class="text-danger">*</span></label>

                    <div class="dropzone-drag-area" id="previews">
                        <div class="dz-message" data-dz-message>
                            <i class="fas fa-cloud-upload-alt"></i>
                            <div class="font-weight-bold">Drag &amp; drop a cover image here</div>
                            <small>or click to browse (JPG, PNG, GIF — max 5MB)</small>
                        </div>

                        <div class="d-none" id="dzPreviewContainer">
                            <div class="dz-preview dz-file-preview">
                                <div class="dz-photo">
                                    <img class="dz-thumbnail" data-dz-thumbnail>
                                </div>
                                <button class="dz-delete" type="button" data-dz-remove>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path fill="#FFFFFF"
                                            d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="image_url" name="image_url">

                    @error('image_url')
                        <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                    @enderror
                </div>

                {{-- PDF FILE --}}
                <div class="form-group-modern">
                    <label class="form-label-modern">Ebook File (PDF)</label>

                    <input type="file" id="ebook_pdf" accept="application/pdf" class="form-control" style="padding:10px 16px;">
                    <input type="hidden" id="file_url" name="file_url" value="{{ old('file_url', $ebook ? $ebook->file_url : '') }}">

                    <div id="pdf-status" class="mt-2 small {{ ($ebook && $ebook->file_url) ? '' : 'd-none' }}">
                        <i class="fas fa-file-pdf text-danger mr-1"></i>
                        <a id="pdf-link" href="{{ $ebook && $ebook->file_url ? asset($ebook->file_url) : '#' }}" target="_blank">
                            Current file
                        </a>
                        <button type="button" id="pdf-remove" class="btn btn-link btn-sm text-danger p-0 ml-2">Remove</button>
                    </div>

                    <small class="text-muted d-block mt-1">Optional. PDF only, max 10MB.</small>
                </div>

                {{-- AD / LOCK OVERRIDE --}}
                <div class="publish-card mb-4" style="background:linear-gradient(135deg,#fff8f1 0%,#ffeede 100%); border-color:#ffe0c2;">
                    <div class="publish-wrapper">
                        <div>
                            <div class="publish-title"><i class="fas fa-lock text-warning mr-1"></i> Override Pengaturan Iklan / Kunci</div>
                            <div class="publish-subtitle">Aktifkan untuk memakai aturan kunci khusus e-book ini (mengabaikan setelan lokasi).</div>
                        </div>
                        <label class="switch">
                            <input type="checkbox" id="adOverrideEnabled" name="ad_override_enabled"
                                @if (isset($ebook->ad_override_enabled) && $ebook->ad_override_enabled) checked @endif>
                            <span class="slider-switch"></span>
                        </label>
                    </div>

                    <div id="adOverridePanel" class="row mt-3">
                        <div class="col-md-3 mb-2">
                            <label class="form-label-modern">Kunci baca</label>
                            <select class="form-control" name="lock_enabled">
                                @php $le = old('lock_enabled', $ebook->lock_enabled ?? 1); @endphp
                                <option value="1" @selected((int) $le === 1)>Aktif</option>
                                <option value="0" @selected((int) $le === 0)>Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label-modern">Limit gratis</label>
                            <input type="number" min="0" max="999" class="form-control" name="read_limit"
                                value="{{ old('read_limit', $ebook->read_limit ?? 2) }}">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label-modern">Metode</label>
                            <select class="form-control" name="unlock_method">
                                @php $eum = old('unlock_method', $ebook->unlock_method ?? 'timed'); @endphp
                                <option value="timed" @selected($eum === 'timed')>Iklan Waktu</option>
                                <option value="review" @selected($eum === 'review')>Review</option>
                                <option value="both" @selected($eum === 'both')>Keduanya</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label-modern">Durasi (detik)</label>
                            <input type="number" min="3" max="600" class="form-control" name="unlock_duration"
                                value="{{ old('unlock_duration', $ebook->unlock_duration ?? 15) }}">
                        </div>
                        <div class="col-12">
                            <small class="text-muted d-block mb-2">
                                Unggah gambar iklan khusus e-book ini. Jika kosong, sistem memakai iklan dari lokasi (Ebook Place).
                            </small>
                        </div>

                        {{-- Timed ad image --}}
                        <div class="col-md-6 mb-2 unlock-ad-block" data-method-block="timed">
                            <label class="form-label-modern"><i class="fas fa-clock text-warning mr-1"></i> Gambar Iklan Waktu</label>
                            <div class="ad-up" data-target="unlock_timed_image">
                                <img class="ad-up-preview {{ old('unlock_timed_image', $ebook->unlock_timed_image ?? '') ? '' : 'd-none' }}"
                                    src="{{ old('unlock_timed_image', $ebook->unlock_timed_image ?? '') ? asset(old('unlock_timed_image', $ebook->unlock_timed_image)) : '' }}" alt="preview">
                                <input type="file" accept="image/png,image/jpeg,image/webp" class="form-control ad-up-file" style="padding:8px 12px;">
                                <input type="hidden" name="unlock_timed_image" class="ad-up-input"
                                    value="{{ old('unlock_timed_image', $ebook->unlock_timed_image ?? '') }}">
                                <button type="button" class="btn btn-link btn-sm text-danger p-0 mt-1 ad-up-remove {{ old('unlock_timed_image', $ebook->unlock_timed_image ?? '') ? '' : 'd-none' }}">
                                    <i class="fas fa-times mr-1"></i> Hapus gambar
                                </button>
                            </div>
                            <input type="text" class="form-control mt-2" name="unlock_timed_target_url"
                                value="{{ old('unlock_timed_target_url', $ebook->unlock_timed_target_url ?? '') }}"
                                placeholder="Link tujuan saat banner diklik (opsional)">
                        </div>

                        {{-- Review banner image --}}
                        <div class="col-md-6 mb-2 unlock-ad-block" data-method-block="review">
                            <label class="form-label-modern"><i class="fas fa-star text-warning mr-1"></i> Banner Review</label>
                            <div class="ad-up" data-target="unlock_review_image">
                                <img class="ad-up-preview {{ old('unlock_review_image', $ebook->unlock_review_image ?? '') ? '' : 'd-none' }}"
                                    src="{{ old('unlock_review_image', $ebook->unlock_review_image ?? '') ? asset(old('unlock_review_image', $ebook->unlock_review_image)) : '' }}" alt="preview">
                                <input type="file" accept="image/png,image/jpeg,image/webp" class="form-control ad-up-file" style="padding:8px 12px;">
                                <input type="hidden" name="unlock_review_image" class="ad-up-input"
                                    value="{{ old('unlock_review_image', $ebook->unlock_review_image ?? '') }}">
                                <button type="button" class="btn btn-link btn-sm text-danger p-0 mt-1 ad-up-remove {{ old('unlock_review_image', $ebook->unlock_review_image ?? '') ? '' : 'd-none' }}">
                                    <i class="fas fa-times mr-1"></i> Hapus gambar
                                </button>
                            </div>
                            <small class="text-muted d-block mt-1">Banner tampil di atas form pertanyaan review.</small>
                        </div>

                        {{-- Review questions editor (per-ebook) --}}
                        <div class="col-12 unlock-ad-block" data-method-block="review">
                            <div class="mt-2 pt-3" style="border-top:1px dashed #ffd9b0;">
                                <div class="font-weight-bold text-dark mb-1"><i class="fas fa-clipboard-question text-warning mr-1"></i> Pertanyaan Review</div>
                                <small class="text-muted d-block mb-2">
                                    Pertanyaan yang harus dijawab pembaca untuk membuka kunci e-book ini (jawaban tersimpan di website kita).
                                    Kosongkan untuk pakai default (rating bintang 1–5).
                                </small>

                                <div id="rqWrap">
                                    @php $existingQuestions = $ebook?->reviewQuestions ?? collect(); @endphp
                                    @foreach ($existingQuestions as $q)
                                        <div class="rq-row">
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
                    </div>
                </div>

                {{-- PUBLISH --}}
                <div class="publish-card mb-4">
                    <div class="publish-wrapper">
                        <div>
                            <div class="publish-title">Publish</div>
                            <div class="publish-subtitle">Make this ebook visible on the public catalog.</div>
                        </div>
                        <label class="switch">
                            <input type="checkbox" name="is_published" @if (isset($ebook->is_published) && $ebook->is_published) checked @endif>
                            <span class="slider-switch"></span>
                        </label>
                    </div>
                </div>

                {{-- ACTION BAR --}}
                <div class="form-actions">
                    <a href="{{ route('ebook.index') }}" class="btn btn-light btn-action order-2 order-sm-1">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary btn-action order-1 order-sm-2">
                        <i class="fas {{ $ebook ? 'fa-save' : 'fa-paper-plane' }} mr-2"></i>
                        {{ $ebook ? 'Save Changes' : 'Publish Ebook' }}
                    </button>
                </div>

                </form>

            </div>

        </div>

    </div>

    @push('css')
        <style>
            .page-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 16px;
                flex-wrap: wrap;
                margin-bottom: 1.5rem;
            }

            .page-title { font-size: 1.8rem; font-weight: 700; color: #2e384d; margin: 0; }
            .page-subtitle { color: #858796; margin-top: 4px; font-size: 14px; }

            .modern-card {
                border: none;
                border-radius: 18px;
                overflow: hidden;
                box-shadow: 0 10px 25px rgba(0, 0, 0, .05), 0 4px 10px rgba(0, 0, 0, .03);
            }

            .modern-card .card-header { background: #fff; border-bottom: 1px solid #eef1f7; padding: 1.2rem 1.5rem; }
            .modern-card .card-body { padding: 1.5rem; }

            .section-title { font-size: 1rem; font-weight: 700; color: #4e73df; margin-bottom: 4px; }
            .section-subtitle { color: #858796; font-size: 13px; }

            .form-group-modern { margin-bottom: 1.5rem; }
            .form-label-modern { font-size: 14px; font-weight: 700; color: #2f3640; margin-bottom: 8px; display: block; }

            .form-control {
                border-radius: 12px !important;
                min-height: 48px;
                border: 1px solid #e3e6f0;
                padding: 12px 16px;
                font-size: 14px;
                transition: .2s ease;
            }

            .form-control:focus { border-color: #4e73df; box-shadow: 0 0 0 4px rgba(78, 115, 223, .10); }

            .note-editor.note-frame { border-radius: 14px !important; border: 1px solid #e3e6f0 !important; overflow: hidden; }
            .note-toolbar { background: #f8f9fc !important; border-bottom: 1px solid #eef1f7 !important; }
            .note-editing-area { min-height: 350px; }

            .dropzone-drag-area {
                height: 320px;
                border-radius: 16px;
                border: 2px dashed #d9deea;
                background: #fafbff;
                transition: .2s ease;
                position: relative;
                overflow: hidden;
            }

            .dropzone-drag-area:hover { border-color: #4e73df; background: #f5f7ff; }

            .dz-message {
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                gap: 12px;
                color: #858796;
            }

            .dz-message i { font-size: 42px; color: #4e73df; }

            .dz-preview {
                width: 100%;
                height: 100%;
                margin: 0 !important;
                position: absolute !important;
                inset: 0;
                padding: 18px;
            }

            .dz-photo { width: 100%; height: 100%; border-radius: 16px; overflow: hidden; background: #f2f4f9; }
            .dz-thumbnail { width: 100%; height: 100%; object-fit: cover; }

            .dz-delete {
                width: 42px;
                height: 42px;
                border-radius: 50%;
                border: none;
                background: rgba(0, 0, 0, .65);
                position: absolute;
                top: 28px;
                right: 28px;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: .2s ease;
            }

            .dz-preview:hover .dz-delete { opacity: 1; }
            .dz-delete svg { width: 18px; height: 18px; }

            .publish-card {
                background: linear-gradient(135deg, #f8f9ff 0%, #eef3ff 100%);
                border: 1px solid #dfe7ff;
                border-radius: 16px;
                padding: 18px 20px;
            }

            .publish-wrapper { display: flex; justify-content: space-between; align-items: center; gap: 20px; }
            .publish-title { font-weight: 700; color: #2f3640; margin-bottom: 4px; }
            .publish-subtitle { font-size: 13px; color: #858796; }

            .switch { position: relative; display: inline-block; width: 58px; height: 30px; }
            .switch input { opacity: 0; width: 0; height: 0; }

            .slider-switch {
                position: absolute;
                inset: 0;
                cursor: pointer;
                background-color: #d6d9e6;
                transition: .3s;
                border-radius: 999px;
            }

            .slider-switch:before {
                position: absolute;
                content: "";
                width: 24px;
                height: 24px;
                left: 3px;
                top: 3px;
                background-color: white;
                transition: .3s;
                border-radius: 50%;
                box-shadow: 0 2px 8px rgba(0, 0, 0, .12);
            }

            .switch input:checked+.slider-switch { background-color: #4e73df; }
            .switch input:checked+.slider-switch:before { transform: translateX(28px); }

            .btn-modern {
                border-radius: 12px;
                padding: 12px 22px;
                font-weight: 600;
                font-size: 14px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, .06);
            }

            .location-grid {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }

            .location-chip {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                margin: 0;
                padding: 8px 14px;
                border: 1px solid #e3e6f0;
                border-radius: 999px;
                cursor: pointer;
                font-size: 13px;
                font-weight: 600;
                color: #4e5d78;
                background: #fff;
                transition: .15s ease;
            }

            .location-chip:hover { border-color: #4e73df; background: #f5f7ff; }

            .location-chip input { accent-color: #4e73df; }

            .location-chip:has(input:checked) {
                border-color: #4e73df;
                background: #eef3ff;
                color: #2e50b8;
            }

            /* Minimalist, clear action bar */
            .form-actions {
                display: flex;
                justify-content: flex-end;
                align-items: center;
                gap: 12px;
                padding-top: 1.25rem;
                margin-top: 0.5rem;
                border-top: 1px solid #eef1f7;
            }

            .btn-action {
                border-radius: 12px;
                padding: 11px 24px;
                font-weight: 600;
                font-size: 14px;
                min-width: 130px;
            }

            .btn-action.btn-light {
                background: #f3f5fa;
                border: 1px solid #e3e6f0;
                color: #5a6275;
            }

            .btn-action.btn-light:hover { background: #e9edf5; }

            .btn-action.btn-primary { box-shadow: 0 6px 14px rgba(78, 115, 223, .25); }

            /* Unlock ad uploads */
            .ad-up-preview { display:block; width:100%; max-height:160px; object-fit:cover;
                border-radius:10px; border:1px solid #ffe0c2; margin-bottom:8px; background:#fff; }
            .unlock-ad-block.d-none { display:none !important; }

            /* Review question editor rows */
            .rq-row { display:flex; gap:10px; align-items:flex-start; border:1px dashed #ffd9b0;
                border-radius:12px; padding:12px; background:#fffdfa; margin-bottom:10px; }
            .rq-row .rq-fields { flex:1; min-width:0; }

            /* Make Select2 match the modern inputs */
            .select2-container--default .select2-selection--single {
                height: 48px !important;
                border-radius: 12px !important;
                border: 1px solid #e3e6f0 !important;
                display: flex;
                align-items: center;
                padding: 0 8px;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 48px !important;
                padding-left: 8px;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow { height: 46px !important; }

            @media(max-width:768px) {
                .publish-wrapper { flex-direction: column; align-items: flex-start; }
                .page-title { font-size: 1.5rem; }

                .form-actions { flex-direction: column-reverse; align-items: stretch; }
                .btn-action { width: 100%; }
            }
        </style>
    @endpush

    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
        <script>
            const i18nEbookForm = {
                uploading:    'Uploading...',
                uploadWait:   'Please wait while the file is being uploaded.',
                uploadFailed: 'Upload failed.',
            };

            Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone('#formDropzone', {
                url: "{{ route('upload.ebook') }}",
                previewTemplate: $('#dzPreviewContainer').html(),
                addRemoveLinks: true,
                autoProcessQueue: true,
                uploadMultiple: false,
                parallelUploads: 1,
                maxFiles: 1,
                acceptedFiles: '.jpeg, .jpg, .png, .gif',
                thumbnailWidth: 900,
                thumbnailHeight: 600,
                previewsContainer: "#previews",
                timeout: 0,
                init: function() {
                    var dz = this;
                    var existingImage;

                    @if ($ebook)
                        existingImage = "{{ asset($ebook->image_url) ?? '' }}";
                        $('#image_url').val("{{ $ebook->image_url }}");
                    @endif

                    if (existingImage) {
                        var thumb = {
                            name: existingImage,
                            size: 0,
                            dataURL: existingImage
                        };

                        dz.files.push(thumb);
                        dz.emit('addedfile', thumb);
                        dz.createThumbnailFromUrl(thumb,
                            dz.options.thumbnailWidth, dz.options.thumbnailHeight,
                            dz.options.thumbnailMethod, true,
                            function(thumbnail) {
                                dz.emit('thumbnail', thumb, thumbnail);
                            });
                        dz.emit('complete', thumb);
                    }

                    this.on('sending', function(file, xhr, formData) {
                        var token = $('meta[name="csrf-token"]').attr('content');
                        formData.append('_token', token);
                        Swal.fire({
                            title: i18nEbookForm.uploading,
                            text: i18nEbookForm.uploadWait,
                            didOpen: () => { Swal.showLoading(); },
                            allowOutsideClick: false,
                            showConfirmButton: false
                        });
                    });

                    this.on('addedfile', function(file) {
                        if (thumb) { dz.removeFile(thumb); }
                        $('.dropzone-drag-area').removeClass('is-invalid').next('.invalid-feedback').hide();
                    });

                    this.on('success', function(file, response) {
                        var imageUrl = response.image_url;
                        $('#image_url').val(imageUrl);
                        Swal.close();
                    });

                    this.on('error', function(file, errorMessage) {
                        console.log('Upload error:', errorMessage);
                        $('.dropzone-drag-area').addClass('is-invalid').next('.invalid-feedback').show()
                            .text('File upload failed: ' + errorMessage);
                        this.removeFile(file);
                    });
                }
            });

            $(document).ready(function() {

                // ── Category: searchable Select2 with inline create (tags) ────
                $('#category').select2({
                    theme: 'default',
                    width: '100%',
                    allowClear: true,
                    placeholder: $('#category').data('placeholder'),
                    tags: true,
                    createTag: function (params) {
                        const term = $.trim(params.term);
                        if (term === '') return null;
                        return { id: term, text: term, newTag: true };
                    },
                    templateResult: function (data) {
                        return data.newTag ? $('<span><i class="fas fa-plus-circle text-primary mr-1"></i>Create "' + data.text + '"</span>') : data.text;
                    }
                });

                // ── Ebook PDF upload (reuses file.upload endpoint) ────────────
                $('#ebook_pdf').on('change', function () {
                    const file = this.files[0];
                    if (!file) return;

                    if (file.type !== 'application/pdf') {
                        Swal.fire({ icon: 'error', title: 'Invalid File', text: 'Please upload a valid PDF.' });
                        this.value = '';
                        return;
                    }

                    const formData = new FormData();
                    formData.append('pdf', file);

                    Swal.fire({
                        title: 'Uploading...',
                        text: 'Please wait while the file is being uploaded.',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => { Swal.showLoading(); }
                    });

                    $.ajax({
                        url: "{{ route('file.upload') }}",
                        type: 'POST',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.url) {
                                $('#file_url').val(response.url);
                                $('#pdf-link').attr('href', response.url).text(file.name);
                                $('#pdf-status').removeClass('d-none');
                                Swal.fire({ icon: 'success', title: 'Uploaded!', text: 'PDF uploaded successfully.', timer: 1500, showConfirmButton: false });
                            } else {
                                Swal.fire({ icon: 'error', title: 'Upload Failed', text: response.error || 'Unknown error' });
                            }
                        },
                        error: function (xhr) {
                            const msg = xhr.responseJSON?.error || 'Server error during upload.';
                            Swal.fire({ icon: 'error', title: 'Upload Failed', text: msg });
                        }
                    });
                });

                $('#pdf-remove').on('click', function () {
                    $('#file_url').val('');
                    $('#ebook_pdf').val('');
                    $('#pdf-status').addClass('d-none');
                });

                // ── Ad/lock override: collapse when disabled + method blocks ──
                (function () {
                    const toggle = document.getElementById('adOverrideEnabled');
                    const panel = document.getElementById('adOverridePanel');
                    if (!toggle || !panel) return;

                    const methodSel = panel.querySelector('select[name="unlock_method"]');
                    const blocks = panel.querySelectorAll('.unlock-ad-block');

                    function syncMethod() {
                        const m = methodSel ? methodSel.value : 'timed';
                        blocks.forEach(function (b) {
                            const type = b.getAttribute('data-method-block');
                            const show = (m === 'both') || (m === type);
                            b.classList.toggle('d-none', !show);
                        });
                    }
                    function sync() {
                        panel.style.display = toggle.checked ? '' : 'none';
                        if (toggle.checked) syncMethod();
                    }
                    toggle.addEventListener('change', sync);
                    if (methodSel) methodSel.addEventListener('change', syncMethod);
                    sync();
                })();

                // ── Unlock ad image upload (AJAX to upload.ebook) ──
                (function () {
                    const csrf = $('meta[name="csrf-token"]').attr('content');
                    document.querySelectorAll('.ad-up').forEach(function (box) {
                        const file = box.querySelector('.ad-up-file');
                        const input = box.querySelector('.ad-up-input');
                        const preview = box.querySelector('.ad-up-preview');
                        const removeBtn = box.querySelector('.ad-up-remove');

                        file.addEventListener('change', function () {
                            const f = this.files[0];
                            if (!f) return;

                            const fd = new FormData();
                            fd.append('file', f);
                            fd.append('_token', csrf);

                            Swal.fire({ title: 'Uploading...', allowOutsideClick: false, showConfirmButton: false, didOpen: () => Swal.showLoading() });

                            $.ajax({
                                url: "{{ route('upload.ebook') }}",
                                type: 'POST', data: fd, contentType: false, processData: false,
                                success: function (res) {
                                    const url = res.image_url;
                                    if (!url) { Swal.fire({ icon: 'error', title: 'Upload gagal' }); return; }
                                    input.value = url;
                                    preview.src = "{{ asset('') }}" + url;
                                    preview.classList.remove('d-none');
                                    removeBtn.classList.remove('d-none');
                                    Swal.close();
                                },
                                error: function () { Swal.fire({ icon: 'error', title: 'Upload gagal' }); }
                            });
                        });

                        if (removeBtn) removeBtn.addEventListener('click', function () {
                            input.value = '';
                            file.value = '';
                            preview.src = '';
                            preview.classList.add('d-none');
                            removeBtn.classList.add('d-none');
                        });
                    });
                })();

                // ── Review questions editor (per-ebook) ──
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

                $(document).on('click', '.note-modal .close', function() {
                    $('.note-modal').modal('hide');
                });

                $('#summernote').summernote({
                    height: 300,
                    toolbar: [
                        ['style'],
                        ['insert', ['bold', 'underline', 'eraser']],
                        ['recentColor'],
                        ['fontname'],
                        ['color'],
                        ['para', ['ul', 'ol', 'paragraph', 'height']],
                        ['table'],
                        ['custom', ['pdfButton']],
                        ['insert', ['link', 'picture', 'video']],
                        ['insert', ['fullscreen', 'codeview', 'help']],
                    ],
                    buttons: {
                        eraser: function(context) {
                            return $('<button />')
                                .addClass('note-btn btn btn-light btn-sm note-btn-bold')
                                .html('<i class="note-icon-eraser"/>')
                                .click(function(event) {
                                    event.preventDefault();
                                    context.invoke('removeFormat');
                                });
                        },

                        // Upload a PDF and embed it inline in the content (ref: place form)
                        pdfButton: function(context) {
                            const ui = $.summernote.ui;

                            const button = ui.button({
                                contents: '<i class="fas fa-file-pdf text-danger"></i> <span class="ml-1 font-weight-bold">PDF</span>',
                                tooltip: 'Insert PDF',
                                click: function() {
                                    const input = $('<input type="file" accept="application/pdf">');

                                    input.on('change', function(e) {
                                        const file = e.target.files[0];

                                        if (!file || file.type !== 'application/pdf') {
                                            Swal.fire({ icon: 'error', title: 'Invalid File', text: 'Please upload a valid PDF.' });
                                            return;
                                        }

                                        const formData = new FormData();
                                        formData.append('pdf', file);

                                        Swal.fire({
                                            title: 'Uploading...',
                                            text: 'Please wait while the file is being uploaded.',
                                            showConfirmButton: false,
                                            allowOutsideClick: false,
                                            didOpen: () => { Swal.showLoading(); }
                                        });

                                        $.ajax({
                                            url: "{{ route('file.upload') }}",
                                            type: 'POST',
                                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                            data: formData,
                                            contentType: false,
                                            processData: false,
                                            success: function(response) {
                                                if (response.url) {
                                                    const iframe = document.createElement('iframe');
                                                    iframe.src = response.url;
                                                    iframe.width = '100%';
                                                    iframe.height = '500px';
                                                    iframe.style.border = 'none';
                                                    iframe.style.borderRadius = '12px';

                                                    $('#summernote').summernote('editor.insertNode', iframe);

                                                    Swal.fire({ icon: 'success', title: 'Uploaded!', text: 'PDF inserted into content.', timer: 1500, showConfirmButton: false });
                                                } else {
                                                    Swal.fire({ icon: 'error', title: 'Upload Failed', text: response.error || 'Unknown error' });
                                                }
                                            },
                                            error: function(xhr) {
                                                const msg = xhr.responseJSON?.error || 'Server error during upload.';
                                                Swal.fire({ icon: 'error', title: 'Upload Failed', text: msg });
                                            }
                                        });
                                    });

                                    input.trigger('click');
                                }
                            });

                            return button.render();
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
