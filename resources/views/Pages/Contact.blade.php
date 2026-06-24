<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact Qrun Online | Hubungi Kami</title>

    <meta name="description"
        content="Hubungi Qrun Online untuk pertanyaan, dukungan, kerja sama, atau informasi tentang platform prasasti digital berbasis QR Code untuk sejarah, budaya, dan tempat wisata.">
    <meta name="keywords"
        content="kontak qrun online, hubungi qrun, support qrun, bantuan qrun, qrun bali, qr code sejarah, prasasti digital, smart tourism, digital heritage">
    <meta name="author" content="Qrun Online">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="https://qrun.online/contact">
    <meta name="theme-color" content="#2d4373">
    <link rel="icon" type="image/png" href="{{ asset('transparent-logo.png') }}">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Qrun Online">
    <meta property="og:title" content="Contact Qrun Online | Hubungi Kami">
    <meta property="og:description" content="Hubungi tim Qrun Online untuk dukungan, pertanyaan, atau kerja sama terkait platform QR Code untuk sejarah, budaya, dan informasi tempat.">
    <meta property="og:url" content="https://qrun.online/contact">
    <meta property="og:image" content="https://qrun.online/home.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Contact Qrun Online | Hubungi Kami">
    <meta name="twitter:description" content="Butuh bantuan atau ingin bekerja sama dengan Qrun Online? Hubungi tim kami di sini.">
    <meta name="twitter:image" content="https://qrun.online/home.jpg">

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ContactPage",
        "name": "Contact Qrun Online",
        "url": "https://qrun.online/contact",
        "description": "Halaman kontak resmi Qrun Online untuk dukungan dan pertanyaan.",
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

        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        .hero-grid {
            background-image: radial-gradient(circle, rgba(255,255,255,0.10) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        /* Email row hover */
        .contact-row { transition: background 0.2s ease, transform 0.2s ease; }
        .contact-row:hover { background: #f0f9ff; transform: translateX(3px); }

        /* FAQ */
        .faq-item { transition: box-shadow 0.2s ease; }
        .faq-item.open { box-shadow: 0 0 0 2px #3b82f6; }
        .faq-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
        }
        .faq-content.open { max-height: 300px; }
        .faq-icon { transition: transform 0.3s ease; }
        .faq-item.open .faq-icon { transform: rotate(180deg); }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 99px; }
    </style>
</head>

<body class="bg-gray-50 antialiased">
    @include('Components.Navbar')

    {{-- ═══════════ HERO ═══════════ --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-900 py-20">
        <div class="absolute inset-0 hero-grid"></div>
        <div class="absolute top-0 right-0 w-72 h-72 bg-blue-500 rounded-full opacity-[0.07] blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-violet-500 rounded-full opacity-[0.07] blur-3xl pointer-events-none"></div>

        <div class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 bg-blue-500/20 border border-blue-400/30 text-blue-300 text-sm font-medium px-4 py-2 rounded-full mb-6">
                <i class="fas fa-envelope text-xs"></i>
                Kontak
            </div>
            <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-4 leading-tight">
                {{ __('messages.contact_page.hero_title') }}
            </h1>
            <p class="text-blue-200 text-lg">
                {{ __('messages.contact_page.hero_subtitle') }}
            </p>
        </div>

        <div class="absolute bottom-0 left-0 right-0 leading-none">
            <svg viewBox="0 0 1440 48" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0,48 C480,0 960,0 1440,48 L1440,48 L0,48 Z" fill="#f8fafc"/>
            </svg>
        </div>
    </section>

    {{-- ═══════════ CONTACT SECTION ═══════════ --}}
    <section class="py-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Intro --}}
            <div class="text-center mb-12 reveal">
                <h2 class="text-3xl font-bold text-gray-900 mb-3">
                    {{ __('messages.contact_page.connect_title') }}
                </h2>
                <p class="text-gray-500 text-lg max-w-2xl mx-auto">
                    {{ __('messages.contact_page.connect_desc') }}
                </p>
            </div>

            {{-- Email contact cards --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 mb-8 reveal">
                <div class="flex items-center gap-4 mb-7">
                    <div class="bg-blue-100 text-blue-600 w-11 h-11 rounded-xl flex items-center justify-center shrink-0">
                        <i class="fas fa-envelope text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ __('messages.contact_page.email_title') }}</h3>
                        <p class="text-gray-500 text-sm">{{ __('messages.contact_page.email_subtitle') }}</p>
                    </div>
                </div>

                <div class="space-y-3">
                    @foreach ([
                        [
                            'label'   => __('messages.contact_page.support_label'),
                            'desc'    => __('messages.contact_page.support_desc'),
                            'icon'    => 'fa-headset',
                            'color'   => 'bg-blue-600 hover:bg-blue-700',
                            'badge'   => 'bg-blue-50 text-blue-600',
                        ],
                        [
                            'label'   => __('messages.contact_page.tech_label'),
                            'desc'    => __('messages.contact_page.tech_desc'),
                            'icon'    => 'fa-tools',
                            'color'   => 'bg-emerald-600 hover:bg-emerald-700',
                            'badge'   => 'bg-emerald-50 text-emerald-600',
                        ],
                        [
                            'label'   => __('messages.contact_page.partner_label'),
                            'desc'    => __('messages.contact_page.partner_desc'),
                            'icon'    => 'fa-handshake',
                            'color'   => 'bg-violet-600 hover:bg-violet-700',
                            'badge'   => 'bg-violet-50 text-violet-600',
                        ],
                    ] as $item)
                        <div class="contact-row flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-4 bg-gray-50 rounded-2xl">
                            <div class="flex items-start gap-3">
                                <div class="{{ $item['badge'] }} w-9 h-9 rounded-xl flex items-center justify-center shrink-0">
                                    <i class="fas {{ $item['icon'] }} text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 text-sm">{{ $item['label'] }}</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $item['desc'] }}</p>
                                </div>
                            </div>
                            <a href="mailto:qrunonline@gmail.com"
                                class="{{ $item['color'] }} text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-all shrink-0 inline-flex items-center gap-2 shadow-sm hover:shadow-md">
                                <i class="fas fa-paper-plane text-xs"></i>
                                qrunonline@gmail.com
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Tips --}}
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 reveal">
                <div class="flex items-start gap-3 mb-4">
                    <div class="bg-blue-100 text-blue-600 w-9 h-9 rounded-xl flex items-center justify-center shrink-0">
                        <i class="fas fa-lightbulb text-sm"></i>
                    </div>
                    <h3 class="font-bold text-blue-900 text-base mt-1.5">{{ __('messages.contact_page.tips_title') }}</h3>
                </div>
                <ul class="space-y-2.5 pl-12">
                    @foreach ([
                        __('messages.contact_page.tip_1'),
                        __('messages.contact_page.tip_2'),
                        __('messages.contact_page.tip_3'),
                    ] as $tip)
                        <li class="flex items-start gap-2 text-sm text-blue-800">
                            <i class="fas fa-check-circle text-blue-500 mt-0.5 shrink-0"></i>
                            {{ $tip }}
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </section>

    {{-- ═══════════ FAQ ═══════════ --}}
    <section class="py-16 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-12 reveal">
                <span class="inline-block text-blue-600 text-sm font-semibold uppercase tracking-widest mb-3">FAQ</span>
                <h2 class="text-3xl font-bold text-gray-900 mb-3">
                    {{ __('messages.contact_page.faq_title') }}
                </h2>
                <p class="text-gray-500">
                    {{ __('messages.contact_page.faq_subtitle') }}
                </p>
            </div>

            <div class="space-y-3 reveal">
                @foreach ([
                    [__('messages.contact_page.faq_1_q'), __('messages.contact_page.faq_1_a')],
                    [__('messages.contact_page.faq_2_q'), __('messages.contact_page.faq_2_a')],
                    [__('messages.contact_page.faq_3_q'), __('messages.contact_page.faq_3_a')],
                ] as $faq)
                    <div class="faq-item bg-gray-50 border border-gray-100 rounded-2xl overflow-hidden">
                        <button class="faq-btn w-full flex items-center justify-between gap-4 px-6 py-5 text-left">
                            <span class="font-semibold text-gray-900 text-sm leading-snug">{{ $faq[0] }}</span>
                            <i class="fas fa-chevron-down faq-icon text-gray-400 shrink-0 text-sm"></i>
                        </button>
                        <div class="faq-content">
                            <p class="px-6 pb-5 text-gray-600 text-sm leading-relaxed">{{ $faq[1] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ═══════════ CTA ═══════════ --}}
    <section class="py-16 bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-br from-slate-900 to-blue-900 rounded-3xl p-10 text-center overflow-hidden reveal">
                <div class="absolute top-0 right-0 w-56 h-56 bg-blue-500/10 rounded-full -translate-y-1/2 translate-x-1/3 blur-2xl pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-56 h-56 bg-violet-500/10 rounded-full translate-y-1/2 -translate-x-1/3 blur-2xl pointer-events-none"></div>
                <div class="relative">
                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-qrcode text-white text-lg"></i>
                    </div>
                    <h2 class="text-2xl font-extrabold text-white mb-3">Siap Memulai?</h2>
                    <p class="text-gray-300 mb-7 leading-relaxed">
                        Bergabunglah dengan platform prasasti digital Qrun dan lestarikan warisan budaya bersama kami.
                    </p>
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 bg-white text-gray-900 font-bold px-7 py-3.5 rounded-xl hover:bg-gray-50 transition-all shadow-lg hover:-translate-y-0.5">
                        Mulai Sekarang <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    @include('Components.FooterHome')

    <script>
        // Scroll reveal
        const io = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); }
            });
        }, { threshold: 0.08 });
        document.querySelectorAll('.reveal').forEach(el => io.observe(el));

        // FAQ accordion
        document.querySelectorAll('.faq-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const item    = btn.closest('.faq-item');
                const content = item.querySelector('.faq-content');
                const isOpen  = item.classList.contains('open');

                // Close all
                document.querySelectorAll('.faq-item').forEach(i => {
                    i.classList.remove('open');
                    i.querySelector('.faq-content').classList.remove('open');
                });

                // Open clicked (if was closed)
                if (!isOpen) {
                    item.classList.add('open');
                    content.classList.add('open');
                }
            });
        });
    </script>
</body>

</html>
