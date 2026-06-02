@extends('TemplateLayout.AdminLayout')

@section('content')
    @php
        $isEdit = isset($Place);
    @endphp

    @push('title')
        <title>{{ $isEdit ? 'Edit' : 'Create' }} Place Admin - QRUN Website</title>
    @endpush


    <div class="container-fluid py-4">

        {{-- Page Heading --}}
        <div class="page-header-wrapper mb-3">
            <div>
                <h1 class="page-title mb-2">
                    <i class="fas fa-map-pin text-primary mr-3"></i>{{ $isEdit ? 'Update Place' : 'Create Place' }} / Object
                </h1>
                <p class="page-subtitle mb-0">
                    Add a new location to the directory with detailed information, location details, and content editor.
                </p>
            </div>
        </div>

        {{-- Success Alert --}}
        @if (session()->has('success'))
            <div class="alert alert-success alert-success-custom shadow-sm border-0 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    <div>
                        <strong>Success!</strong>
                        <span class="d-block">{{ session()->get('success') }}</span>
                    </div>
                </div>
            </div>
        @endif

        {{-- Error Alert --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-danger-custom shadow-sm border-0 mb-4" role="alert">
                <div class="d-flex align-items-start">
                    <i class="fas fa-exclamation-circle mr-3 mt-1"></i>
                    <div>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2 pl-3">
                            @foreach ($errors->all() as $error)
                                <li class="mb-1">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Main Form Card --}}

        <form action="{{ $isEdit ? route('place.update') : route('place.store') }}" method="POST">
            @csrf
            @if ($isEdit)
                <input type="hidden" name="id" value="{{ $Place->id }}">
            @endif

            <div class="card form-card shadow-lg border-0" data-intro="Fill in the basic information of the place."
                data-title="Basic Information">
                {{-- <div class="card-header bg-white py-4 border-bottom border-light">
                    <h5 class="m-0 font-weight-bold text-dark d-flex align-items-center">
                        <span class="badge badge-primary-light badge-icon mr-3">1</span>
                        <div>
                            <div>Basic Information</div>
                            <small class="section-description">Enter the name and description of the place</small>
                        </div>
                    </h5>
                </div> --}}
                <div class="card-header bg-white py-4 border-bottom border-light">
                    <div class="d-flex align-items-center flex-wrap w-100">
                        <h5 class="m-0 font-weight-bold text-dark d-flex align-items-center">
                            <span class="badge badge-primary-light badge-icon mr-3">1</span>
                            <div>
                                <div>Basic Information</div>
                                <small class="section-description">
                                    Enter the name and description of the place
                                </small>
                            </div>
                        </h5>

                        @if (isset($Place))
                            <div class="d-flex align-items-center ml-auto mt-3 mt-md-0">
                                <a href="{{ route('place.detailGlobal', $Place->place_code) }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm mr-2">
                                    <i class="fas fa-external-link-alt mr-1"></i>
                                    Live Preview
                                </a>

                                <a href="{{ route('place.print', $Place->place_code) }}" target="_blank"
                                    class="btn btn-primary btn-sm">
                                    <i class="fas fa-qrcode mr-1"></i>
                                    Print QR Code
                                </a>
                            </div>
                        @endcan
                </div>
            </div>
            <div class="card-body p-4">
                {{-- Basic Information --}}
                <div class="form-section">

                    <div class="row">

                        <div class="col-md-6 mb-4">
                            <label class="form-label">
                                Title <span class="text-danger">*</span>
                            </label>

                            <input required class="form-control" id="placeTitle" name="title" type="text"
                                value="{{ old('title', $Place->title ?? '') }}" placeholder="Enter place title..."
                                data-intro="Enter the place or object name. Use a clear and recognizable title."
                                data-title="Place Title">

                            @error('title')
                                <small class="text-danger d-block mt-2">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">
                                Contact Person
                            </label>

                            <input class="form-control" name="phone_num" type="number"
                                value="{{ old('phone_num', $Place->phone_num ?? '') }}"
                                placeholder="Enter contact phone number..."
                                data-intro="Optional. Add a phone number so visitors can contact the manager or person in charge."
                                data-title="Contact Person">

                            @error('phone_num')
                                <small class="text-danger d-block mt-2">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label">
                                Description <span class="text-danger">*</span>
                            </label>

                            <textarea id="descriptionArea" required class="form-control" rows="3" name="description"
                                placeholder="Short description about this place..." data-intro="Provide a brief description of the place."
                                data-title="Place Description">{{ old('description', $Place->description ?? '') }}</textarea>

                            @error('description')
                                <small class="text-danger d-block mt-2">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="card form-card shadow-lg border-0" data-intro="Fill in the location information of the place."
            data-title="Location Information">

            <div class="card-header bg-white py-4 border-bottom border-light">
                <h5 class="m-0 font-weight-bold text-dark d-flex align-items-center">
                    <span class="badge badge-primary-light badge-icon mr-3">2</span>
                    <div>
                        <div>Location Information</div>
                        <small class="section-description">Select the province, city, district, and village where
                            the place is located</small>
                    </div>
                </h5>
            </div>

            <div class="card-body p-4">
                {{-- Location --}}
                <div class="card-body p-0">
                    <div class="location-wrapper mb-0">

                        <div class="row">

                            <div class="col-md-6 mb-4">
                                <label class="form-label">
                                    Province <span class="text-danger">*</span>
                                </label>

                                <select id="provinceDataSelect" name="reg_province" class="form-control select2"
                                    required data-intro="Select the province where the place is located."
                                    data-title="Province">
                                    <option value="">Select Province</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">
                                    City / Regency <span class="text-danger">*</span>
                                </label>

                                <select id="regencyDataSelect" name="reg_regency" class="form-control select2" required
                                    data-intro="Select the city or regency where the place is located."
                                    data-title="City / Regency">
                                    <option value="">Select Regency</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">
                                    District <span class="text-danger">*</span>
                                </label>

                                <select id="districtDataSelect" name="reg_district" class="form-control select2"
                                    required data-intro="Select the district where the place is located."
                                    data-title="District">
                                    <option value="">Select District</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">
                                    Village <span class="text-danger">*</span>
                                </label>

                                <select id="villagesDataSelect" name="reg_village" class="form-control select2"
                                    required data-intro="Select the village where the place is located."
                                    data-title="Village">
                                    <option value="">Select Village</option>
                                </select>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="card form-card shadow-lg border-0" data-intro="Fill in the content for the place."
            data-title="Content Editor">
            <div class="card-header bg-white py-4 border-bottom border-light">
                <h5 class="m-0 font-weight-bold text-dark d-flex align-items-center">
                    <span class="badge badge-primary-light badge-icon mr-3">3</span>
                    <div>
                        <div>Content Editor</div>
                        <small class="section-description">Write detailed content about the place including text,
                            images, and formatting</small>
                    </div>
                </h5>
            </div>

            <div class="card-body p-4">
                {{-- Content --}}
                <div class="card-body p-0">
                    <div class="mb-4">

                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-edit text-primary mr-2"></i>
                            <h5 class="mb-0 font-weight-bold">
                                Content Editor
                            </h5>
                        </div>

                        <textarea class="form-control" name="content" id="summernote"
                            data-intro="Write detailed content about the place including text, images, and formatting." data-title="Content">{{ old('content', $Place->content ?? '') }}</textarea>

                        @error('content')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card form-card shadow-lg border-0" data-intro="Configure the settings for the place."
            data-title="Settings">
            <div class="card-header bg-white py-4 border-bottom border-light">
                <h5 class="m-0 font-weight-bold text-dark d-flex align-items-center">
                    <span class="badge badge-primary-light badge-icon mr-3">4</span>
                    <div>
                        <div>Settings</div>
                        <small class="section-description">Configure options for how visitors can interact with this
                            place</small>
                    </div>
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="comment-toggle">

                    <div>
                        <h6 class="font-weight-bold mb-2">
                            <i class="fas fa-comments text-primary mr-2"></i>Enable Comments
                        </h6>

                        <small class="text-muted d-block">
                            Allow visitors to leave comments and engage with this place.
                        </small>
                    </div>

                    <label class="switch mb-0">
                        <input type="checkbox" name="AllowComment"
                            {{ old('AllowComment', $Place->is_comment ?? true) ? 'checked' : '' }}
                            data-intro="Enable or disable comments for this place." data-title="Enable Comments">
                        <span class="slider-custom"></span>
                    </label>

                </div>
                {{-- Submit Section --}}
                <div
                    class="card-footer bg-white p-4 d-flex justify-content-between align-items-center border-top border-light">
                    <small class="text-muted">
                        <i class="fas fa-asterisk text-danger mr-1"></i> Required fields
                    </small>
                    <div class="d-flex gap-3">
                        <button type="reset" class="btn btn-secondary btn-sm reset-btn">
                            <i class="fas fa-redo mr-2"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-primary submit-btn shadow-sm">
                            <i class="fas fa-save mr-2"></i>{{ $isEdit ? 'Update Place' : 'Create Place' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>

</div>

@push('css')
    @include('Pages.Management.Master.place.components.style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intro.js/minified/introjs.min.css">

    <style>
        /* Background blur */
        .introjs-overlay {
            backdrop-filter: blur(6px);
            background: rgba(0, 0, 0, 0.35) !important;
        }

        /* Tooltip */
        .custom-intro-tooltip {
            border-radius: 18px !important;
            box-shadow:
                0 20px 50px rgba(0, 0, 0, .15) !important;
            padding: 20px !important;
        }

        /* Highlight element */
        .introjs-helperLayer {
            border-radius: 18px !important;
            box-shadow:
                0 0 0 9999px rgba(0, 0, 0, .15);
        }

        /* Buttons */
        .introjs-button {
            border-radius: 10px !important;
        }

        /* Tombol X */
        .introjs-skipbutton {
            position: absolute !important;
            top: 10px !important;
            right: 10px !important;

            width: 32px;
            height: 32px;

            display: flex !important;
            align-items: center;
            justify-content: center;

            border-radius: 50% !important;

            background: #f8f9fc !important;
            border: 1px solid #e3e6f0 !important;

            color: #6c757d !important;
            font-size: 18px !important;
            font-weight: 700 !important;
            text-decoration: none !important;

            transition: all .2s ease;
        }

        .introjs-skipbutton:hover {
            background: #eaecf4 !important;
            color: #dc3545 !important;
            transform: rotate(90deg);
            text-decoration: none !important;
        }

        .introjs-skipbutton:focus {
            outline: none !important;
            box-shadow: 0 0 0 3px rgba(78, 115, 223, .2);
        }
    </style>
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/intro.js/minified/intro.min.js"></script>
    <script>
        let selectedProvince = "{{ old('reg_province', $Place->province_id ?? ($Place->reg_province ?? '')) }}";
        let selectedRegency = "{{ old('reg_regency', $Place->regency_id ?? ($Place->reg_regency ?? '')) }}";
        let selectedDistrict = "{{ old('reg_district', $Place->district_id ?? ($Place->reg_district ?? '')) }}";
        let selectedVillage = "{{ old('reg_village', $Place->village_id ?? ($Place->reg_village ?? '')) }}";
        let summernoteReady = false;

        $(document).ready(async function() {

            $(document).on('click', '.note-modal .close', function() {
                $(this).closest('.note-modal').modal('hide');
            });


            // =========================
            // TUTORIAL CHECK
            // =========================

            function bindSummernoteTutorialClasses() {

                $('button[aria-label^="Bold"]')
                    .addClass('tour-bold');

                $('button[aria-label^="Italic"]')
                    .addClass('tour-italic');

                $('button[aria-label^="Underline"]')
                    .addClass('tour-underline');

                $('button[aria-label="Insert PDF"]')
                    .addClass('tour-pdf');

                $('button[aria-label="Style"]')
                    .addClass('tour-style');

                $('button[aria-label="Font Family"]')
                    .addClass('tour-font-family');

                $('button[aria-label="Font Size"]')
                    .addClass('tour-font-size');

                $('button[aria-label="Recent Color"]')
                    .addClass('tour-color');

                $('button[aria-label="Full Screen"]')
                    .addClass('tour-fullscreen');
                $('.note-btn').each(function() {

                    const label = ($(this).attr('aria-label') || '').toLowerCase();

                    if (label.startsWith('unordered')) {
                        $(this).addClass('tour-ul');
                    } else if (label.startsWith('ordered')) {
                        $(this).addClass('tour-ol');
                    }
                    if (label.includes('link'))
                        $(this).addClass('tour-link');

                    if (label.includes('picture'))
                        $(this).addClass('tour-image');

                    if (label.includes('video'))
                        $(this).addClass('tour-video');
                });

                $('.note-btn[data-name="pdfButton"]')
                    .addClass('tour-pdf');

            }

            function startPlaceTutorial(lang = 'en') {

                const tutorials = {

                    id: {

                        nextLabel: 'Lanjut',
                        prevLabel: 'Kembali',
                        doneLabel: 'Selesai',
                        skipLabel: 'X',

                        steps: [

                            {
                                title: 'Selamat Datang 👋',
                                intro: `
                        <div class="text-left">
                            <h5 class="mb-3">Tutorial Place Management</h5>

                            <p>
                                Tutorial ini akan membantu Anda memahami seluruh fitur
                                pada halaman Create / Edit Place.
                            </p>

                            <ul>
                                <li>Mengisi informasi dasar</li>
                                <li>Mengatur lokasi</li>
                                <li>Menggunakan editor konten</li>
                                <li>Mengelola komentar</li>
                            </ul>

                            <p class="mb-0">
                                Estimasi waktu: ±1 menit
                            </p>
                        </div>
                    `
                            },

                            {
                                element: document.getElementById('placeTitle'),
                                title: 'Judul Place',
                                intro: 'Masukkan nama tempat, objek wisata, bangunan, atau lokasi yang ingin ditampilkan.'
                            },

                            {
                                element: document.querySelector('[name="phone_num"]'),
                                title: 'Nomor Kontak',
                                intro: 'Nomor yang dapat dihubungi oleh pengunjung apabila diperlukan.'
                            },

                            {
                                element: document.getElementById('descriptionArea'),
                                title: 'Deskripsi Singkat',
                                intro: 'Tuliskan ringkasan singkat mengenai tempat ini.'
                            },

                            {
                                element: document.getElementById('provinceDataSelect'),
                                title: 'Lokasi',
                                intro: `
                        Pilih lokasi secara berurutan:

                        <br><br>

                        • Provinsi<br>
                        • Kabupaten / Kota<br>
                        • Kecamatan<br>
                        • Desa / Kelurahan
                    `
                            },

                            {
                                element: document.querySelector('.note-toolbar'),
                                title: 'Toolbar Editor',
                                intro: `
                        Toolbar ini digunakan untuk memformat konten
                        yang akan dibaca oleh pengunjung.
                    `
                            },
                            {
                                element: document.querySelector('.tour-style'),
                                title: 'Heading & Style',
                                intro: `
        Gunakan menu ini untuk membuat judul dan subjudul.

        <br><br>

        Contoh:
        <br>
        • Heading 1 → Judul utama
        <br>
        • Heading 2 → Subjudul
        <br>
        • Paragraph → Teks biasa
    `
                            },

                            {
                                element: document.querySelector('.tour-font-family'),
                                title: 'Jenis Font',
                                intro: `
        Mengubah jenis huruf yang digunakan
        pada konten.
    `
                            },

                            {
                                element: document.querySelector('.tour-font-size'),
                                title: 'Ukuran Font',
                                intro: `
        Mengatur besar kecilnya teks
        agar lebih nyaman dibaca.
    `
                            },

                            {
                                element: document.querySelector('.tour-color'),
                                title: 'Warna Teks',
                                intro: `
        Memberikan warna pada teks
        untuk menyoroti informasi penting.
    `
                            },

                            {
                                element: document.querySelector('.tour-bold'),
                                title: 'Bold',
                                intro: 'Membuat teks menjadi tebal.'
                            },

                            {
                                element: document.querySelector('.tour-italic'),
                                title: 'Italic',
                                intro: 'Membuat teks menjadi miring.'
                            },

                            {
                                element: document.querySelector('.tour-underline'),
                                title: 'Underline',
                                intro: 'Menambahkan garis bawah pada teks.'
                            },

                            {
                                element: document.querySelector('.tour-ul'),
                                title: 'Bullet List',
                                intro: 'Membuat daftar poin.'
                            },

                            {
                                element: document.querySelector('.tour-ol'),
                                title: 'Number List',
                                intro: 'Membuat daftar bernomor.'
                            },

                            {
                                element: document.querySelector('.tour-link'),
                                title: 'Insert Link',
                                intro: 'Menambahkan tautan website atau sumber referensi.'
                            },

                            {
                                element: document.querySelector('.tour-image'),
                                title: 'Insert Image',
                                intro: 'Upload gambar untuk memperkaya konten.'
                            },

                            {
                                element: document.querySelector('.tour-video'),
                                title: 'Insert Video',
                                intro: 'Tambahkan video YouTube menggunakan URL video.'
                            },

                            {
                                element: document.querySelector('.tour-pdf'),
                                title: 'Insert PDF',
                                intro: 'Upload dokumen PDF agar dapat dibaca langsung oleh pengunjung.'
                            },
                            {
                                element: document.querySelector('.tour-fullscreen'),
                                title: 'Mode Layar Penuh',
                                intro: `
        Memperbesar editor ke layar penuh.

        <br><br>

        Sangat berguna saat menulis
        artikel atau informasi yang panjang.
    `
                            },

                            {
                                element: document.querySelector('.note-editable'),
                                title: 'Area Konten',
                                intro: `
                        Ini adalah bagian terpenting.

                        <br><br>

                        Anda dapat menambahkan:

                        <br><br>

                        ✅ Sejarah tempat<br>
                        ✅ Informasi objek<br>
                        ✅ Gambar<br>
                        ✅ Video YouTube<br>
                        ✅ PDF<br>
                        ✅ Tabel<br>
                        ✅ Format teks

                        <br><br>

                        Konten ini akan muncul saat QR Code dipindai pengunjung.
                    `
                            },

                            {
                                element: document.querySelector('.comment-toggle'),
                                title: 'Komentar',
                                intro: `
                        Aktifkan fitur komentar jika ingin
                        pengunjung dapat memberikan tanggapan.
                    `
                            },

                            {
                                element: document.querySelector('.submit-btn'),
                                title: 'Simpan Data',
                                intro: `
                        Setelah semua informasi selesai diisi,
                        klik tombol ini untuk menyimpan Place.
                    `
                            }
                        ]
                    },

                    en: {

                        nextLabel: 'Next',
                        prevLabel: 'Back',
                        doneLabel: 'Finish',
                        skipLabel: 'X',

                        steps: [

                            {
                                title: 'Welcome 👋',
                                intro: `
                        <div class="text-left">
                            <h5 class="mb-3">Place Management Tutorial</h5>

                            <p>
                                This tutorial will guide you through all major features
                                of the Place Management page.
                            </p>

                            <ul>
                                <li>Basic information</li>
                                <li>Location setup</li>
                                <li>Content editor</li>
                                <li>Comment settings</li>
                            </ul>

                            <p class="mb-0">
                                Estimated duration: 1 minute
                            </p>
                        </div>
                    `
                            },

                            {
                                element: document.getElementById('placeTitle'),
                                title: 'Place Title',
                                intro: 'Enter the place or object name.'
                            },

                            {
                                element: document.querySelector('[name="phone_num"]'),
                                title: 'Contact Number',
                                intro: 'Phone number visitors may contact.'
                            },

                            {
                                element: document.getElementById('descriptionArea'),
                                title: 'Short Description',
                                intro: 'Provide a short summary about this place.'
                            },

                            {
                                element: document.getElementById('provinceDataSelect'),
                                title: 'Location',
                                intro: `
                        Select location sequentially:

                        <br><br>

                        • Province<br>
                        • Regency / City<br>
                        • District<br>
                        • Village
                    `
                            },

                            {
                                element: document.querySelector('.note-toolbar'),
                                title: 'Editor Toolbar',
                                intro: 'Use this toolbar to format your content.'
                            },

                            {
                                element: document.querySelector('.tour-style'),
                                title: 'Heading & Style',
                                intro: `
        Use headings to organize content.

        <br><br>

        • Heading 1 → Main title
        <br>
        • Heading 2 → Subtitle
        <br>
        • Paragraph → Regular text
    `
                            },

                            {
                                element: document.querySelector('.tour-font-family'),
                                title: 'Font Family',
                                intro: 'Change the font type used in the content.'
                            },

                            {
                                element: document.querySelector('.tour-font-size'),
                                title: 'Font Size',
                                intro: 'Adjust text size for better readability.'
                            },

                            {
                                element: document.querySelector('.tour-color'),
                                title: 'Text Color',
                                intro: 'Highlight important information using colors.'
                            },


                            {
                                element: document.querySelector('.tour-bold'),
                                title: 'Bold',
                                intro: 'Make text bold.'
                            },

                            {
                                element: document.querySelector('.tour-italic'),
                                title: 'Italic',
                                intro: 'Make text italic.'
                            },

                            {
                                element: document.querySelector('.tour-underline'),
                                title: 'Underline',
                                intro: 'Underline selected text.'
                            },

                            {
                                element: document.querySelector('.tour-ul'),
                                title: 'Bullet List',
                                intro: 'Create unordered lists.'
                            },

                            {
                                element: document.querySelector('.tour-ol'),
                                title: 'Number List',
                                intro: 'Create ordered lists.'
                            },

                            {
                                element: document.querySelector('.tour-link'),
                                title: 'Insert Link',
                                intro: 'Insert website URLs or references.'
                            },

                            {
                                element: document.querySelector('.tour-image'),
                                title: 'Insert Image',
                                intro: 'Upload images to enrich content.'
                            },

                            {
                                element: document.querySelector('.tour-video'),
                                title: 'Insert Video',
                                intro: 'Embed YouTube videos using video URLs.'
                            },

                            {
                                element: document.querySelector('.tour-pdf'),
                                title: 'Insert PDF',
                                intro: 'Upload PDF documents for visitors.'
                            },

                            {
                                element: document.querySelector('.tour-fullscreen'),
                                title: 'Fullscreen Mode',
                                intro: `
        Expand the editor to fullscreen.

        <br><br>

        Useful when writing long articles
        or detailed information.
    `
                            },
                            {
                                element: document.querySelector('.note-editable'),
                                title: 'Content Area',
                                intro: `
                        This is the most important section.

                        <br><br>

                        You can add:

                        <br><br>

                        ✅ Place history<br>
                        ✅ Object descriptions<br>
                        ✅ Images<br>
                        ✅ YouTube videos<br>
                        ✅ PDF documents<br>
                        ✅ Tables<br>
                        ✅ Rich text formatting

                        <br><br>

                        Visitors will see this content after scanning the QR Code.
                    `
                            },

                            {
                                element: document.querySelector('.comment-toggle'),
                                title: 'Comments',
                                intro: 'Enable or disable visitor comments.'
                            },

                            {
                                element: document.querySelector('.submit-btn'),
                                title: 'Save',
                                intro: 'Click here to save the place.'
                            }
                        ]
                    }
                };


                const config = tutorials[lang] || tutorials.en;

                const steps = config.steps.filter(step => {
                    return !step.element || $(step.element).length > 0;
                });

                $('.note-toolbar button').each(function() {
                    console.log({
                        text: $(this).text().trim(),
                        aria: $(this).attr('aria-label'),
                        title: $(this).attr('title'),
                        class: $(this).attr('class')
                    });

                });
                introJs()
                    .setOptions({

                        steps: steps,

                        nextLabel: config.nextLabel,
                        prevLabel: config.prevLabel,
                        doneLabel: config.doneLabel,
                        skipLabel: config.skipLabel,

                        showBullets: true,
                        showProgress: true,

                        exitOnOverlayClick: false,
                        disableInteraction: false,

                        scrollToElement: true,
                        scrollTo: 'element',

                        tooltipClass: 'custom-intro-tooltip'
                    })

                    .oncomplete(function() {

                        localStorage.setItem(
                            'place_tutorial_seen',
                            'true'
                        );

                    })

                    .onexit(function() {

                        localStorage.setItem(
                            'place_tutorial_seen',
                            'true'
                        );

                    })

                    .start();
            }

            function showTutorialLanguageModal() {

                Swal.fire({

                    title: '👋 Welcome',
                    html: `

                        <p class="text-muted mb-4">
                            Please choose your preferred tutorial language
                            or skip the tutorial.
                        </p>

                        <div class="row">

                            <div class="col-6 mb-3">
                                <button
                                    id="tutorial-lang-id"
                                    class="btn btn-primary btn-block py-3">

                                    🇮🇩<br>
                                    <strong>Bahasa Indonesia</strong>

                                </button>
                            </div>

                            <div class="col-6 mb-3">
                                <button
                                    id="tutorial-lang-en"
                                    class="btn btn-outline-primary btn-block py-3">

                                    🇺🇸<br>
                                    <strong>English</strong>

                                </button>
                            </div>

                        </div>

                        <hr>

                        <button
                            id="tutorial-skip"
                            class="btn btn-link text-muted">

                            Skip Tutorial

                        </button>

                    `,

                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,

                    didOpen: () => {

                        $('#tutorial-lang-id').on('click', function() {

                            localStorage.setItem(
                                'place_tutorial_lang',
                                'id'
                            );

                            Swal.close();

                            waitSummernoteReady(() => {

                                startPlaceTutorial('id');

                            });

                        });
                        $('#tutorial-lang-en').on('click', function() {

                            localStorage.setItem(
                                'place_tutorial_lang',
                                'en'
                            );

                            Swal.close();

                            waitSummernoteReady(() => {

                                startPlaceTutorial('en');

                            });

                        });

                        $('#tutorial-skip').on('click', function() {

                            localStorage.setItem(
                                'place_tutorial_seen',
                                'true'
                            );

                            Swal.close();

                        });

                    }

                });

            }

            function waitSummernoteReady(callback) {

                let interval = setInterval(() => {

                    console.log(
                        'waiting...',
                        summernoteReady,
                        $('.note-editor').length,
                        $('.note-editable').length
                    );

                    const editorExists =
                        $('.note-editor').length > 0 &&
                        $('.note-editable').length > 0;

                    if (summernoteReady && editorExists) {

                        clearInterval(interval);

                        callback();
                    }

                }, 200);
            }

            const needTutorial = !localStorage.getItem('place_tutorial_seen');

            if (needTutorial) {

                setTimeout(() => {

                    $('.note-btn[data-event="bold"]').addClass('tour-bold');
                    $('.note-btn[data-event="italic"]').addClass('tour-italic');
                    $('.note-btn[data-event="underline"]').addClass('tour-underline');

                    $('.note-btn[data-event="insertUnorderedList"]').addClass('tour-ul');
                    $('.note-btn[data-event="insertOrderedList"]').addClass('tour-ol');

                    $('.note-btn[data-event="showLinkDialog"]').addClass('tour-link');
                    $('.note-btn[data-event="showImageDialog"]').addClass('tour-image');
                    $('.note-btn[data-event="showVideoDialog"]').addClass('tour-video');

                    $('.note-btn[data-name="pdfButton"]').addClass('tour-pdf');

                }, 500);

                setTimeout(() => {

                    showTutorialLanguageModal();

                }, 1200);
            }

            $('form').on('reset', function() {

                setTimeout(async () => {

                    // =========================
                    // TEXT INPUT / TEXTAREA
                    // =========================
                    $(this).find('input[type="text"], input[type="number"], textarea')
                        .val('');

                    // =========================
                    // SUMMERNOTE RESET
                    // =========================
                    $('#summernote').summernote('reset');
                    $('#summernote').summernote('code', '');

                    // =========================
                    // SELECT2 RESET
                    // =========================
                    $('#provinceDataSelect').val(null).trigger('change');
                    $('#regencyDataSelect').empty()
                        .append('<option value="">Select Regency</option>')
                        .trigger('change');

                    $('#districtDataSelect').empty()
                        .append('<option value="">Select District</option>')
                        .trigger('change');

                    $('#villagesDataSelect').empty()
                        .append('<option value="">Select Village</option>')
                        .trigger('change');

                    // =========================
                    // CHECKBOX RESET
                    // =========================
                    $('input[name="AllowComment"]').prop('checked', true);

                    // =========================
                    // RELOAD PROVINCE
                    // =========================
                    let initialData = await fetchLocation();

                    fillSelect(
                        '#provinceDataSelect',
                        initialData.province,
                        'Select Province'
                    );

                    initSelect2(
                        '#provinceDataSelect',
                        'Select Province'
                    );

                }, 10);
            });

            function makeIframeResponsive() {

                $('.note-editable iframe').each(function() {

                    $(this).css({
                        width: '100%',
                        maxWidth: '100%',
                        height: 'auto',
                        minHeight: '220px',
                        border: '0',
                        borderRadius: '12px',
                        display: 'block'
                    });

                    // remove fixed size bawaan youtube embed
                    $(this).removeAttr('width');
                    $(this).removeAttr('height');

                    // ratio 16:9
                    this.style.aspectRatio = '16 / 9';
                });
            }
            // =========================
            // SUMMERNOTE
            // =========================

            function sanitizePastedContent(html) {

                let wrapper = $('<div>').html(html);

                // remove style/class/id
                wrapper.find('*').each(function() {

                    $(this)
                        .removeAttr('style')
                        .removeAttr('class')
                        .removeAttr('id')
                        .removeAttr('width')
                        .removeAttr('height');

                    // convert h1-h6 ke p
                    if (/^h[1-6]$/i.test(this.tagName)) {
                        $(this).replaceWith(
                            `<p>${$(this).html()}</p>`
                        );
                    }

                    // buang empty paragraph
                    if ($(this).html()?.trim() === '&nbsp;') {
                        $(this).remove();
                    }
                });

                // normalize break
                wrapper.find('br + br').remove();

                return wrapper.html();
            }

            $('#summernote').summernote({

                placeholder: 'Write detailed information about this place...',
                height: 500,

                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'italic', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['custom', ['pdfButton']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],

                popover: {
                    image: [
                        ['resize', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                        ['float', ['floatLeft', 'floatRight', 'floatNone']],
                        ['remove', ['removeMedia']]
                    ]
                },

                callbacks: {
                    onMediaDelete: function() {
                        makeIframeResponsive();
                    },

                    onPaste: function(e) {

                        e.preventDefault();

                        let clipboardData =
                            (e.originalEvent || e).clipboardData ||
                            window.clipboardData;

                        let text = clipboardData.getData('text/html');

                        // fallback kalau bukan html
                        if (!text) {
                            text = clipboardData.getData('text/plain');
                            document.execCommand('insertText', false, text);
                            return;
                        }

                        // sanitize html
                        let cleanHtml = sanitizePastedContent(text);

                        $('#summernote').summernote(
                            'pasteHTML',
                            cleanHtml
                        );
                    },
                    onInit: function() {

                        summernoteReady = true;

                        bindSummernoteTutorialClasses();

                        $('.note-editable').css({
                            textAlign: 'left',
                            minHeight: '320px'
                        });

                        $('.note-editor').addClass('shadow-sm');

                        makeIframeResponsive();

                        $('.note-btn[data-event="bold"]').addClass('tour-bold');
                        $('.note-btn[data-event="italic"]').addClass('tour-italic');
                        $('.note-btn[data-event="underline"]').addClass('tour-underline');

                        $('.note-btn[data-event="insertUnorderedList"]').addClass('tour-ul');
                        $('.note-btn[data-event="insertOrderedList"]').addClass('tour-ol');

                        $('.note-btn[data-event="showLinkDialog"]').addClass('tour-link');
                        $('.note-btn[data-event="showImageDialog"]').addClass('tour-image');
                        $('.note-btn[data-event="showVideoDialog"]').addClass('tour-video');

                        $('.note-btn[data-name="pdfButton"]').addClass('tour-pdf');
                    }
                },

                buttons: {

                    pdfButton: function(context) {

                        let ui = $.summernote.ui;

                        let button = ui.button({

                            contents: `
                    <i class="fas fa-file-pdf text-danger"></i>
                    <span class="ml-1 font-weight-bold">PDF</span>
                `,

                            tooltip: 'Insert PDF',

                            click: function() {

                                let input = $(
                                    '<input type="file" accept="application/pdf">');

                                input.on('change', function(e) {

                                    let file = e.target.files[0];

                                    if (file && file.type ===
                                        'application/pdf') {

                                        let formData = new FormData();

                                        formData.append('pdf', file);

                                        Swal.fire({
                                            title: 'Uploading...',
                                            text: 'Please wait...',
                                            showConfirmButton: false,
                                            allowOutsideClick: false,
                                            didOpen: () => {
                                                Swal.showLoading();
                                            }
                                        });

                                        $.ajax({

                                            url: "{{ route('file.upload') }}",

                                            type: 'POST',

                                            headers: {
                                                'X-CSRF-TOKEN': $(
                                                    'meta[name="csrf-token"]'
                                                ).attr('content')
                                            },

                                            data: formData,

                                            contentType: false,
                                            processData: false,

                                            success: function(
                                                response) {

                                                if (response.url) {

                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Upload Complete',
                                                        text: 'PDF uploaded successfully.'
                                                    });

                                                    let iframe =
                                                        document
                                                        .createElement(
                                                            'iframe'
                                                        );

                                                    iframe.src =
                                                        response
                                                        .url;
                                                    iframe.width =
                                                        '100%';
                                                    iframe.height =
                                                        '500px';

                                                    iframe.style
                                                        .border =
                                                        'none';
                                                    iframe.style
                                                        .borderRadius =
                                                        '12px';

                                                    $('#summernote')
                                                        .summernote(
                                                            'editor.insertNode',
                                                            iframe
                                                        );

                                                } else {

                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Upload Failed',
                                                        text: response
                                                            .error ||
                                                            'Unknown error'
                                                    });
                                                }
                                            },

                                            error: function() {

                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Upload Failed',
                                                    text: 'Server error.'
                                                });
                                            }
                                        });

                                    } else {

                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Invalid File',
                                            text: 'Please upload a valid PDF.'
                                        });
                                    }
                                });

                                input.trigger('click');
                            }
                        });

                        return button.render();
                    }
                }
            });

            let isInitedProvince = false;
            let isAutoSelecting = true;

            async function fetchLocation(
                province_id = null,
                regency_id = null,
                district_id = null
            ) {

                return $.ajax({
                    url: "{{ route('getLocation') }}",
                    method: 'GET',
                    data: {
                        province_id: province_id,
                        regency_id: regency_id,
                        district_id: district_id
                    }
                });
            }

            function initSelect2(el, placeholder) {

                if ($(el).hasClass("select2-hidden-accessible")) {
                    $(el).select2('destroy');
                }

                $(el).select2({
                    placeholder: placeholder,
                    allowClear: true,
                    width: '100%'
                });
            }

            function fillSelect(el, data, placeholder) {

                $(el).empty();

                $(el).append(
                    `<option value="">${placeholder}</option>`
                );

                data.forEach(function(item) {

                    $(el).append(
                        $('<option>', {
                            value: item.id,
                            text: item.name
                        })
                    );
                });
            }

            // =========================
            // INITIAL LOAD
            // =========================

            let initialData = await fetchLocation();

            // province
            fillSelect(
                '#provinceDataSelect',
                initialData.province,
                'Select Province'
            );

            initSelect2(
                '#provinceDataSelect',
                'Select Province'
            );

            // auto province
            if (selectedProvince) {

                $('#provinceDataSelect')
                    .val(selectedProvince)
                    .trigger('change.select2');

                // load regency
                let regencyData = await fetchLocation(
                    selectedProvince
                );

                fillSelect(
                    '#regencyDataSelect',
                    regencyData.regency,
                    'Select Regency'
                );

                initSelect2(
                    '#regencyDataSelect',
                    'Select Regency'
                );

                if (selectedRegency) {

                    $('#regencyDataSelect')
                        .val(selectedRegency)
                        .trigger('change.select2');

                    // load district
                    let districtData = await fetchLocation(
                        selectedProvince,
                        selectedRegency
                    );

                    fillSelect(
                        '#districtDataSelect',
                        districtData.districts,
                        'Select District'
                    );

                    initSelect2(
                        '#districtDataSelect',
                        'Select District'
                    );

                    if (selectedDistrict) {

                        $('#districtDataSelect')
                            .val(selectedDistrict)
                            .trigger('change.select2');

                        // load village
                        let villageData = await fetchLocation(
                            selectedProvince,
                            selectedRegency,
                            selectedDistrict
                        );

                        fillSelect(
                            '#villagesDataSelect',
                            villageData.villages,
                            'Select Village'
                        );

                        initSelect2(
                            '#villagesDataSelect',
                            'Select Village'
                        );

                        if (selectedVillage) {

                            $('#villagesDataSelect')
                                .val(selectedVillage)
                                .trigger('change.select2');
                        }
                    }
                }
            }

            isAutoSelecting = false;

            // =========================
            // PROVINCE CHANGE
            // =========================

            $('#provinceDataSelect').on('change', async function() {

                if (isAutoSelecting) return;

                let provinceId = $(this).val();

                fillSelect('#regencyDataSelect', [], 'Select Regency');
                fillSelect('#districtDataSelect', [], 'Select District');
                fillSelect('#villagesDataSelect', [], 'Select Village');

                if (!provinceId) return;

                let data = await fetchLocation(provinceId);

                fillSelect(
                    '#regencyDataSelect',
                    data.regency,
                    'Select Regency'
                );

                initSelect2(
                    '#regencyDataSelect',
                    'Select Regency'
                );
            });

            // =========================
            // REGENCY CHANGE
            // =========================

            $('#regencyDataSelect').on('change', async function() {

                if (isAutoSelecting) return;

                let provinceId = $('#provinceDataSelect').val();
                let regencyId = $(this).val();

                fillSelect('#districtDataSelect', [], 'Select District');
                fillSelect('#villagesDataSelect', [], 'Select Village');

                if (!regencyId) return;

                let data = await fetchLocation(
                    provinceId,
                    regencyId
                );

                fillSelect(
                    '#districtDataSelect',
                    data.districts,
                    'Select District'
                );

                initSelect2(
                    '#districtDataSelect',
                    'Select District'
                );
            });

            // =========================
            // DISTRICT CHANGE
            // =========================

            $('#districtDataSelect').on('change', async function() {

                if (isAutoSelecting) return;

                let provinceId = $('#provinceDataSelect').val();
                let regencyId = $('#regencyDataSelect').val();
                let districtId = $(this).val();

                fillSelect('#villagesDataSelect', [], 'Select Village');

                if (!districtId) return;

                let data = await fetchLocation(
                    provinceId,
                    regencyId,
                    districtId
                );

                fillSelect(
                    '#villagesDataSelect',
                    data.villages,
                    'Select Village'
                );

                initSelect2(
                    '#villagesDataSelect',
                    'Select Village'
                );
            });

        });
    </script>
@endpush
@endsection
