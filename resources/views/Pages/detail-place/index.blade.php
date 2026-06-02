@extends('TemplateLayout.NormalLayout')

@push('title')
    <title>{{ $place->title }} | Qrun Website</title>
    <meta name="description" content="{{ $place->title }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@endpush

@push('css')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#64748B',
                    }
                }
            }
        }
    </script>
    <style>
        /*#translatable-content p img,  #translatable-content h1 img,  #translatable-content h2 img,  #translatable-content h3 img,  #translatable-content h4 img,  #translatable-content h5 img,  #translatable-content h6 img {*/
        /*  display: block;*/
        /*  margin-left: auto;*/
        /*  margin-right: auto;*/
        /*}*/
        #translatable-content audio,
        #translatable-content canvas,
        #translatable-content embed,
        #translatable-content iframe,
        #translatable-content img,
        #translatable-content object,
        #translatable-content svg,
        #translatable-content video {
            display: revert !important;
        }

        .goog-te-gadget img {
            display: inline-flex !important;
            vertical-align: middle !important;
            margin-right: 6px !important;
            height: 20px !important;
            width: 20px !important;
        }

        #translatable-content h1,
        #translatable-content h2,
        #translatable-content h3,
        #translatable-content h4,
        #translatable-content h5,
        #translatable-content h6,
        #translatable-content p,
        #translatable-content a {
            font-size: revert;
            line-height: revert;
            margin-top: 1em;
            margin-bottom: .5em;
            color: revert;
        }

        #translatable-content h1,
        #translatable-content h2,
        #translatable-content h3,
        #translatable-content h4,
        #translatable-content h5,
        #translatable-content h6 {
            font-weight: normal !important;
        }

        .star {
            transition: all 0.2s ease;
        }

        .star:hover {
            transform: scale(1.1);
        }

        .toc-sidebar {
            transition: transform 0.3s ease;
        }

        .toc-sidebar.closed {
            transform: translateX(70%);
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .reply-level-1 {
            margin-left: 1rem;
        }

        .reply-level-2 {
            margin-left: 2rem;
        }

        .reply-level-3 {
            margin-left: 3rem;
        }

        .reply-level-4 {
            margin-left: 4rem;
        }

        @media (max-width: 640px) {
            .reply-level-1 {
                margin-left: 0.5rem;
            }

            .reply-level-2 {
                margin-left: 1rem;
            }

            .reply-level-3 {
                margin-left: 1.5rem;
            }

            .reply-level-4 {
                margin-left: 2rem;
            }

            .toc-sidebar {
                width: 280px !important;
            }
        }

        #google_translate_element {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: nowrap;
        }

        /* Styling internal iframe dari Google Translate */
        .goog-te-gadget {
            display: flex !important;
            align-items: center;
            gap: 6px;
            font-family: inherit;
        }

        .goog-te-gadget img {
            margin-right: 4px;
        }

        iframe[src*="youtube.com"],
        iframe[src*="youtu.be"] {
            max-width: 90vw;
            width: 100%;
            aspect-ratio: 16 / 9;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .hidden {
            display: none;
        }

        .eventSwiper {
            padding-bottom: 6px;
        }

        .eventSwiper .swiper-slide {
            height: auto;
        }


        .eventSwiper {
            overflow: hidden;
        }

        .eventSwiper .swiper-slide {
            height: auto;
        }

        .swiper-button-disabled {
            opacity: .3;
            pointer-events: none;
        }

        #translatable-content {
            color: #000;
            line-height: 1.7;
        }

        /* Normalisasi text editor */
        #translatable-content h1,
        #translatable-content h2,
        #translatable-content h3,
        #translatable-content h4,
        #translatable-content h5,
        #translatable-content h6,
        #translatable-content p,
        #translatable-content span,
        #translatable-content div,
        #translatable-content a,
        #translatable-content li,
        #translatable-content blockquote {
            color: inherit !important;
        }

        /* Supaya black editor tetap black */
        #translatable-content font[color="#000000"],
        #translatable-content [style*="color: rgb(0, 0, 0)"],
        #translatable-content [style*="color:#000"],
        #translatable-content [style*="color: #000"] {
            color: #000 !important;
        }

        /* Heading normal browser default */
        #translatable-content h1 {
            font-size: 2em;
            font-weight: bold;
        }

        #translatable-content h2 {
            font-size: 1.5em;
            font-weight: bold;
        }

        #translatable-content h3 {
            font-size: 1.17em;
            font-weight: bold;
        }

        #translatable-content h4 {
            font-size: 1em;
            font-weight: bold;
        }

        #translatable-content h5 {
            font-size: .83em;
            font-weight: bold;
        }

        #translatable-content h6 {
            font-size: .67em;
            font-weight: bold;
        }

        /* Link editor */
        #translatable-content a {
            text-decoration: underline;
        }

        /* Image */
        #translatable-content img {
            max-width: 100%;
            height: auto;
        }

        /* iframe responsive */
        #translatable-content iframe {
            width: 100%;
            max-width: 100%;
            aspect-ratio: 16 / 9;
            min-height: 220px;
            border-radius: 12px;
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div id="app" class="relative">
            <!-- Table of Contents Sidebar -->
            <div id="toc-sidebar"
                class="toc-sidebar fixed top-1/2 right-0 transform -translate-y-1/2 z-50 bg-white rounded-l-xl shadow-2xl border border-gray-200 p-4 w-64 max-h-96 overflow-y-auto hidden md:block">
                <div class="flex items-center justify-between mb-4">
                    <!-- Tombol KEMBALI (hanya muncul saat sidebar tertutup) -->
                    <button id="toc-restore" class="p-2 hover:bg-gray-100 rounded-full transition-colors hidden">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M12.707 14.707a1 1 0 01-1.414 0L7.293 10.707a1 1 0 010-1.414l4-4a1 1 0 111.414 1.414L10.414 10l2.293 2.293a1 1 0 010 1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <h3 class="font-bold text-gray-800 text-sm">Navigation</h3>

                    <!-- Tombol TUTUP -->
                    <button id="toc-toggle" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                        <svg class="w-4 h-4 transform transition-transform" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>


                </div>

                <div class="space-y-2">
                    <a href="#contents"
                        class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Content
                    </a>
                    @if (isset($event) && $event->isEmpty() === false)
                        <a href="#events"
                            class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Events
                        </a>
                    @endif
                    <a href="#comments"
                        class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Comments
                    </a>
                </div>

                <ul id="toc-list" class="mt-4 space-y-1 text-sm"></ul>
            </div>

            <!-- Mobile TOC Button -->
            <button id="mobile-toc-btn"
                class="fixed bottom-4 right-4 z-50 bg-blue-600 text-white rounded-full p-3 shadow-lg md:hidden">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M3 5h14a1 1 0 100-2H3a1 1 0 100 2zm14 4H3a1 1 0 000 2h14a1 1 0 100-2zm0 6H3a1 1 0 000 2h14a1 1 0 100-2z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>

            <!-- Mobile TOC Modal -->
            <div id="mobile-toc-modal" class="fixed inset-0 z-50 hidden md:hidden">
                <div class="fixed inset-0 bg-black bg-opacity-50" id="mobile-toc-overlay"></div>
                <div class="fixed bottom-0 left-0 right-0 bg-white rounded-t-xl p-6 max-h-96 overflow-y-auto">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-800 text-lg">Navigation</h3>
                        <button id="close-mobile-toc" class="p-2 hover:bg-gray-100 rounded-full">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-3">
                        <a href="#contents"
                            class="flex items-center px-4 py-3 text-gray-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors mobile-nav-link">
                            <svg class="w-5 h-5 mr-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Content
                        </a>
                        @if (isset($event) && $event->isEmpty() === false)
                            <a href="#events"
                                class="flex items-center px-4 py-3 text-gray-700 bg-green-50 hover:bg-green-100 rounded-lg transition-colors mobile-nav-link">
                                <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Events
                            </a>
                        @endif
                        <a href="#comments"
                            class="flex items-center px-4 py-3 text-gray-700 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors mobile-nav-link">
                            <svg class="w-5 h-5 mr-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Comments
                        </a>
                    </div>
                </div>
            </div>

            <!-- Running Text Banner -->
            @if ($customSettingRunningText->is_active === 1)
                <div v-if="disabledAfter > 0 || disabledAfter === '0'"
                    class="fixed top-0 left-0 right-0 z-40 bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2 overflow-hidden">
                    <div class="animate-pulse">
                        <marquee direction="left" scrollamount="5" class="text-sm font-medium">
                            {{ $customSettingRunningText->title }}
                        </marquee>
                    </div>
                </div>
            @endif

            @if ($modalAds)
                <!-- Ads Modal -->
                <div v-if="showAdsModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
                    role="dialog" aria-modal="true">
                    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <!-- Background overlay (static, cannot close by clicking) -->
                        <div style="opacity: .7" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                            aria-hidden="true"></div>

                        <!-- Modal panel -->
                        <div
                            class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full mx-4">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="w-full mt-3 text-center sm:mt-0 sm:text-left">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                            {{ $modalAds->title }}
                                        </h3>
                                        {{-- <div class="mt-2 flex justify-center">
                                            <img @if ($ads) src="{{ asset($ads->image_url) }}" @else src="{{ asset($customSettingAds?->image_url) }}" @endif
                                                class="max-w-full h-auto rounded-lg" alt="Advertisement">
                                        </div> --}}
                                        <div class="mt-4">

                                            @if ($modalAdsImages->count())
                                                <div class="relative rounded-2xl overflow-hidden bg-black">

                                                    {{-- SLIDER --}}
                                                    <div class="flex transition-all duration-500 ease-in-out"
                                                        :style="{
                                                            transform: `translateX(-${currentAdsImage * 100}%)`
                                                        }">

                                                        @foreach ($modalAdsImages as $image)
                                                            <div class="min-w-full">
                                                                <div class="w-full h-[420px]">
                                                                    <img src="{{ asset($image['image_url']) }}"
                                                                        class="w-full h-full object-cover"
                                                                        alt="Advertisement">
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </div>

                                                    {{-- LEFT --}}
                                                    <button type="button" @click="prevAdsImage"
                                                        class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/50 text-white flex items-center justify-center backdrop-blur hover:bg-black/70 transition">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </button>

                                                    {{-- RIGHT --}}
                                                    <button type="button" @click="nextAdsImage"
                                                        class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/50 text-white flex items-center justify-center backdrop-blur hover:bg-black/70 transition">
                                                        <i class="fas fa-chevron-right"></i>
                                                    </button>

                                                    {{-- PLAY / PAUSE --}}
                                                    <button type="button" @click="toggleAdsSlider"
                                                        class="absolute top-3 right-3 z-20 px-3 py-2 rounded-xl bg-black/50 text-white text-sm backdrop-blur hover:bg-black/70 transition">

                                                        <span v-if="adsPaused">
                                                            <i class="fas fa-play mr-1"></i>
                                                            Play
                                                        </span>

                                                        <span v-else>
                                                            <i class="fas fa-pause mr-1"></i>
                                                            Pause
                                                        </span>

                                                    </button>

                                                    {{-- INDICATOR --}}
                                                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">

                                                        @foreach ($modalAdsImages as $index => $image)
                                                            <button type="button"
                                                                @click="goToAdsImage({{ $index }})"
                                                                class="w-3 h-3 rounded-full transition-all duration-300"
                                                                :class="currentAdsImage === {{ $index }} ?
                                                                    'bg-white w-8' :
                                                                    'bg-white/50'">
                                                            </button>
                                                        @endforeach

                                                    </div>

                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                @php
                                    $isBlockedAds = $modalAds?->is_block ? 'true' : 'false';
                                @endphp
                                <button type="button" @click="closeAdsModal"
                                    :disabled="{{ $isBlockedAds }} ? isLoadingAds : false"
                                    class="w-full inline-flex justify-center items-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-300"
                                    :class="{{ $isBlockedAds }} && isLoadingAds ?
                                        'bg-gray-400 cursor-not-allowed opacity-70' :
                                        'bg-gray-600 hover:bg-gray-700 focus:ring-gray-500'">

                                    <div v-if="
                                        {{ $modalAds?->is_block ? 'isLoadingAds' : 'false' }}
                    "
                                        class="flex items-center">

                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>

                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>

                                        @{{ timeAds }}s

                                    </div>

                                    <span v-else>

                                        Close

                                    </span>

                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Content -->
            <div class="container mx-auto px-4 py-8" :class="{ 'pt-16': disabledAfter > 0 }">
                <!-- Header -->
                <div id="headerContainerRunningText"
                    class="rounded-[14px] overflow-hidden mb-8 fade-in {{ $customSettingRunningText->is_active == 1 ? 'mt-4' : '' }}">
                    {{-- Hero --}}
                    <div class="bg-gradient-to-br from-blue-600 via-purple-600/80 to-purple-600 relative">
                        <div class="absolute inset-0 pointer-events-none"
                            style="background: radial-gradient(ellipse 300px 200px at 90% 20%, rgba(255,255,255,0.08), transparent),
                                radial-gradient(ellipse 200px 300px at 10% 80%, rgba(0,0,0,0.12), transparent)">
                        </div>
                        <div class="relative z-10 px-5 pt-7 pb-5 sm:px-6 flex items-center gap-3.5">

                            <div
                                class="w-[38px] h-[38px] rounded-[10px] bg-white/[0.13] backdrop-blur flex items-center justify-center shrink-0">

                                <svg class="w-[18px] h-[18px] text-white/90" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />

                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>

                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="text-[13.5px] font-medium text-white/[0.55] tracking-wide mb-1">
                                    Place
                                </p>

                                <h1 class="text-3xl font-bold text-white leading-tight -tracking-[0.01em]">
                                    {{ $place->title }}
                                </h1>
                            </div>

                        </div>
                    </div>

                    {{-- Translate bar (gray) --}}
                    {{-- Translate bar --}}
                    <div class="bg-white border-t border-gray-100 px-5 py-3 sm:px-6 flex items-center gap-3">

                        <div
                            class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-50 to-purple-50 border border-gray-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 0 1 6.5 9l2.5 5m-1.5 0h5m5.5 5 2-5h-5l2.5 5M18 19l-2-5" />
                            </svg>
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="text-[13px] font-medium text-gray-700 leading-none">
                                Translate Page
                            </p>
                            <p class="text-[11px] text-gray-400 mt-1 hidden sm:block">
                                Change language using Google Translate
                            </p>
                        </div>

                        <div id="google_translate_element" class="flex-1 sm:flex-none sm:max-w-[190px]">
                        </div>

                        <button @click="closeTranslate"
                            class="w-9 h-9 rounded-xl border border-gray-200 bg-white text-gray-400 hover:bg-gray-50 hover:text-gray-600 hover:border-gray-300 flex items-center justify-center shrink-0 transition-all duration-200 shadow-sm"
                            aria-label="Reset language">

                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Place Details Card -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8 fade-in" id="contents">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4 sm:p-6">
                        <h2 class="text-lg sm:text-xl font-bold mb-2">{{ $place->title }}</h2>
                        <div class="flex flex-wrap items-center gap-2 sm:gap-4 text-xs sm:text-sm opacity-90">
                            <span class="break-words">{{ $place->description }}</span>
                            <span class="hidden sm:inline">•</span>
                            <span>{{ \Carbon\Carbon::parse($place->created_at)->translatedFormat('M d, Y') }}</span>
                            <span class="hidden sm:inline">•</span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ number_format($place->views) }}
                            </span>
                            @if (isset($place->phone_num))
                                <span class="hidden sm:inline">•</span>
                                <a href="tel:{{ $place->phone_num }}" class="flex items-center gap-1 hover:text-white">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                                        </path>
                                    </svg>
                                    {{ $place->phone_num }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Location Info -->
                    <div class="bg-gray-50 p-4 border-b">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                            <div class="flex flex-col sm:flex-row sm:items-center text-gray-600">
                                <div class="flex items-center mb-2 sm:mb-0 sm:mr-2">
                                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="font-semibold">Location:</span>
                                </div>
                                <span class="text-sm break-words">
                                    {{ $place->province?->name ? ucfirst(strtolower($place->province->name)) : '-' }},
                                    {{ $place->regency?->name ? ucfirst(strtolower($place->regency->name)) : '-' }},
                                    {{ $place->district?->name ? ucfirst(strtolower($place->district->name)) : '-' }},
                                    {{ $place->village?->name ? ucfirst(strtolower($place->village->name)) : '-' }}
                                </span>
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="mr-1">Area Code:</span>
                                <span
                                    class="font-mono bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $place->village?->id ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-4 sm:p-6 max-w-none" id="translatable-content" style="overflow-x:scroll">
                        {!! $place->content !!}
                    </div>
                </div>

                <!-- Events Section -->
                @if ($event && count($event))
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8 fade-in" id="events">
                        <div class="bg-gradient-to-r from-green-600 to-teal-600 text-white p-5 sm:p-6">
                            <h2 class="text-xl sm:text-2xl font-bold mb-1">
                                Upcoming Events
                            </h2>
                            <p class="opacity-90 text-sm sm:text-base">
                                Don't miss these exciting events
                            </p>
                        </div>

                        <div class="p-4 sm:p-6">
                            {{-- Navigation --}}
                            <div
                                class="event-swiper-prev hidden sm:flex absolute left-0 top-1/2 -translate-y-1/2 z-20 bg-white shadow-lg rounded-full w-10 h-10 items-center justify-center cursor-pointer">

                                < </div>

                                    <div
                                        class="event-swiper-next hidden sm:flex absolute right-0 top-1/2 -translate-y-1/2 z-20 bg-white shadow-lg rounded-full w-10 h-10 items-center justify-center cursor-pointer">

                                        ›
                                    </div>


                                    <div class="swiper eventSwiper pb-2 overflow-hidden">
                                        <div class="swiper-wrapper">

                                            @foreach ($event as $evnt)
                                                <div class="swiper-slide !w-[260px] sm:!w-[300px]">

                                                    <div onclick="openEventDetail({{ $evnt->id }})"
                                                        class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col h-full cursor-pointer active:scale-[0.98]">

                                                        {{-- Image --}}
                                                        <div class="relative">

                                                            @if ($evnt->images->count())
                                                                <img src="{{ asset($evnt->images->first()->image_url) }}"
                                                                    class="w-full h-40 sm:h-48 object-cover"
                                                                    loading='lazy' alt="{{ $evnt->title }}">
                                                            @else
                                                                <div
                                                                    class="w-full h-40 sm:h-48 bg-gray-100 flex items-center justify-center">

                                                                    <div class="text-center text-gray-400">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="w-10 h-10 mx-auto mb-1" fill="none"
                                                                            viewBox="0 0 24 24" stroke="currentColor">

                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="1.5"
                                                                                d="M3 16l4-4a3 3 0 014 0l5 5m-1-1l1-1a3 3 0 014 0l1 1M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                                                                        </svg>

                                                                        <p class="text-[11px]">
                                                                            No Image
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            {{-- Badge --}}
                                                            <div
                                                                class="absolute top-2 left-2 bg-green-600 text-white text-[10px] px-2 py-1 rounded-lg shadow">

                                                                @if ($evnt->end_date)
                                                                    @if ($evnt->date->format('M Y') == $evnt->end_date->format('M Y'))
                                                                        {{ $evnt->date->format('d') }}
                                                                        -
                                                                        {{ $evnt->end_date->format('d M Y') }}
                                                                    @else
                                                                        {{ $evnt->date->format('d M') }}
                                                                        -
                                                                        {{ $evnt->end_date->format('d M Y') }}
                                                                    @endif
                                                                @else
                                                                    {{ $evnt->date->format('d M Y') }}
                                                                @endif

                                                            </div>

                                                        </div>

                                                        {{-- Content --}}
                                                        <div class="p-3 flex flex-col flex-1">

                                                            <h3
                                                                class="font-semibold text-sm text-gray-900 line-clamp-2 min-h-[42px]">
                                                                {{ $evnt->title }}
                                                            </h3>

                                                            <p class="text-xs text-gray-600 mt-3 line-clamp-3">
                                                                {{ $evnt->description }}
                                                            </p>

                                                        </div>

                                                    </div>

                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                            </div>
                        </div>
                @endif
                <!-- Comments Section -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden fade-in" id="comments">
                    <div class="bg-gradient-to-r from-yellow-600 to-orange-600 text-white p-4 sm:p-6">
                        <h2 class="text-lg sm:text-xl font-bold mb-2">Comments & Reviews</h2>
                        <p class="opacity-90">Share your thoughts and experiences</p>
                        <div class="mt-4 p-3 bg-yellow-100 text-yellow-800 rounded-lg text-xs sm:text-sm">
                            <p>By using our services, you agree to our
                                <a href="{{ route('termsOfService') }}" class="underline font-medium">Terms of
                                    Service</a>
                                and <a href="{{ route('privacyPolicy') }}" class="underline font-medium">Privacy
                                    Policy</a>
                            </p>
                        </div>
                    </div>

                    <div class="p-4 sm:p-6">
                        @if ($place->is_comment)
                            @if (Auth::check())
                                <!-- Comment Form -->
                                <form v-if="!editUserId" @submit.prevent="addComment" class="mb-8">
                                    <!-- Star Rating -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Rate your
                                            experience:</label>
                                        <div class="flex gap-1">
                                            <span v-for="n in 5" :key="n"
                                                :class="['star cursor-pointer text-xl sm:text-2xl', {
                                                    'text-yellow-400': n <=
                                                        selectedRating,
                                                    'text-gray-300': n > selectedRating
                                                }]"
                                                @click="setRating(n)" @mouseover="hoverRating(n)"
                                                @mouseleave="resetHover">
                                                ★
                                            </span>
                                        </div>
                                        <p v-if="selectedRating > 0" class="text-xs sm:text-sm text-gray-600 mt-1">
                                            You selected @{{ selectedRating }} out of 5 stars
                                        </p>
                                    </div>

                                    <!-- Reply/Edit Indicators -->
                                    <div v-if="isReplying" class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                                        <p class="text-xs sm:text-sm text-blue-800">
                                            Replying to <span class="font-medium">@{{ userReplying.name }}</span>
                                            <button @click="cancelReply"
                                                class="ml-2 text-blue-600 hover:text-blue-800 underline">Cancel</button>
                                        </p>
                                    </div>

                                    <!-- Comment Input -->
                                    <div class="flex flex-col sm:flex-row gap-3">
                                        <input ref="inputField" v-model="currentComment" type="text"
                                            placeholder="Share your thoughts..."
                                            class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                        <button type="submit"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm">
                                            Post
                                        </button>
                                    </div>
                                </form>

                                <!-- Edit Form -->
                                <form v-if="editUserId" @submit.prevent="updateComment" class="mb-8">
                                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 mb-4">
                                        <p class="text-xs sm:text-sm text-amber-800">
                                            Editing your comment
                                            <button @click="cancelEdit"
                                                class="ml-2 text-amber-600 hover:text-amber-800 underline">Cancel</button>
                                        </p>
                                    </div>
                                    <div class="flex flex-col sm:flex-row gap-3">
                                        <input ref="inputField" v-model="currentComment" type="text"
                                            class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                        <input type="hidden" v-model="currEditId">
                                        <button type="submit"
                                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm">
                                            Update
                                        </button>
                                    </div>
                                </form>
                            @else
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-6 text-center mb-8">
                                    <svg class="w-10 h-10 sm:w-12 sm:h-12 text-blue-600 mx-auto mb-4" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="text-blue-800 font-medium mb-4 text-sm sm:text-base">Please login to post
                                        comments and reviews</p>
                                    <a href="{{ route('login') }}?redirect_back=true"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 sm:px-6 py-2 rounded-lg font-medium transition-colors text-sm">
                                        Login Now
                                    </a>
                                </div>
                            @endif

                            <!-- Comments List -->
                            <div v-if="isLoadingComment" class="flex justify-center py-8">
                                <svg class="animate-spin h-6 w-6 sm:h-8 sm:w-8 text-blue-600"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>

                            <div v-if="comments.length < 1 && !isLoadingComment" class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 sm:w-16 sm:h-16 mx-auto mb-4 text-gray-300" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <p class="text-base sm:text-lg font-medium">No comments yet</p>
                                <p class="text-sm sm:text-base">Be the first to share your thoughts!</p>
                            </div>

                            <!-- Comments with 4-level nested replies -->
                            <div v-if="comments.length > 0 && !isLoadingComment" class="space-y-4 sm:space-y-6">
                                <!-- Level 1: Main Comments -->
                                <div v-for="comment in comments" :key="comment.id"
                                    class="bg-gray-50 rounded-lg p-3 sm:p-4 border border-gray-200">
                                    <!-- Rating Stars -->
                                    <div class="flex items-center mb-2">
                                        <span v-for="n in comment.rating" :key="n"
                                            class="text-yellow-400 text-base sm:text-lg">★</span>
                                        <span v-for="n in (5 - comment.rating)" :key="n + comment.rating"
                                            class="text-gray-300 text-base sm:text-lg">★</span>
                                    </div>

                                    <!-- Comment Content -->
                                    <p class="text-gray-800 mb-3 text-sm sm:text-base break-words">@{{ comment.comment }}
                                    </p>

                                    <!-- Comment Actions -->
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                        <span class="text-xs sm:text-sm text-gray-500">@{{ comment.user?.name }}</span>
                                        @if (Auth::check())
                                            <div class="flex flex-wrap gap-2">
                                                <button @click="setReplyComment(comment.id, comment.user)"
                                                    class="text-blue-600 hover:text-blue-800 text-xs sm:text-sm font-medium">Reply</button>
                                                <button v-if="userId == comment.user.id"
                                                    @click="editComments(comment.id, comment.comment, comment.user)"
                                                    class="text-amber-600 hover:text-amber-800 text-xs sm:text-sm font-medium">Edit</button>
                                                <button v-if="userId == comment.user.id"
                                                    @click="deleteComments(comment.id)"
                                                    class="text-red-600 hover:text-red-800 text-xs sm:text-sm font-medium">Delete</button>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Level 2: First Level Replies -->
                                    <div v-if="comment.replies && comment.replies.length > 0"
                                        class="reply-level-1 mt-4 space-y-3">
                                        <div v-for="reply1 in comment.replies" :key="reply1.id"
                                            class="bg-white rounded-lg p-3 border border-gray-200">
                                            <p class="text-gray-800 mb-2 text-sm break-words">@{{ reply1.comment }}</p>
                                            <div
                                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                                <span class="text-xs text-gray-500">@{{ reply1.user?.name }}</span>
                                                @if (Auth::check())
                                                    <div class="flex flex-wrap gap-2">
                                                        <button @click="setReplyComment(reply1.id, reply1.user)"
                                                            class="text-blue-600 hover:text-blue-800 text-xs font-medium">Reply</button>
                                                        <button v-if="userId == reply1.user.id"
                                                            @click="editComments(reply1.id, reply1.comment, reply1.user)"
                                                            class="text-amber-600 hover:text-amber-800 text-xs font-medium">Edit</button>
                                                        <button v-if="userId == reply1.user.id"
                                                            @click="deleteComments(reply1.id)"
                                                            class="text-red-600 hover:text-red-800 text-xs font-medium">Delete</button>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Level 3: Second Level Replies -->
                                            <div v-if="reply1.replies && reply1.replies.length > 0"
                                                class="reply-level-2 mt-3 space-y-3">
                                                <div v-for="reply2 in reply1.replies" :key="reply2.id"
                                                    class="bg-blue-50 rounded-lg p-3 border border-blue-200">
                                                    <p class="text-gray-800 mb-2 text-sm break-words">
                                                        @{{ reply2.comment }}</p>
                                                    <div
                                                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                                        <span class="text-xs text-gray-500">@{{ reply2.user?.name }}</span>
                                                        @if (Auth::check())
                                                            <div class="flex flex-wrap gap-2">
                                                                <button @click="setReplyComment(reply2.id, reply2.user)"
                                                                    class="text-blue-600 hover:text-blue-800 text-xs font-medium">Reply</button>
                                                                <button v-if="userId == reply2.user.id"
                                                                    @click="editComments(reply2.id, reply2.comment, reply2.user)"
                                                                    class="text-amber-600 hover:text-amber-800 text-xs font-medium">Edit</button>
                                                                <button v-if="userId == reply2.user.id"
                                                                    @click="deleteComments(reply2.id)"
                                                                    class="text-red-600 hover:text-red-800 text-xs font-medium">Delete</button>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Level 4: Third Level Replies -->
                                                    <div v-if="reply2.replies && reply2.replies.length > 0"
                                                        class="reply-level-3 mt-3 space-y-3">
                                                        <div v-for="reply3 in reply2.replies" :key="reply3.id"
                                                            class="bg-green-50 rounded-lg p-3 border border-green-200">
                                                            <p class="text-gray-800 mb-2 text-sm break-words">
                                                                @{{ reply3.comment }}</p>
                                                            <div
                                                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                                                <span
                                                                    class="text-xs text-gray-500">@{{ reply3.user?.name }}</span>
                                                                @if (Auth::check())
                                                                    <div class="flex flex-wrap gap-2">
                                                                        <button
                                                                            @click="setReplyComment(reply3.id, reply3.user)"
                                                                            class="text-blue-600 hover:text-blue-800 text-xs font-medium">Reply</button>
                                                                        <button v-if="userId == reply3.user.id"
                                                                            @click="editComments(reply3.id, reply3.comment, reply3.user)"
                                                                            class="text-amber-600 hover:text-amber-800 text-xs font-medium">Edit</button>
                                                                        <button v-if="userId == reply3.user.id"
                                                                            @click="deleteComments(reply3.id)"
                                                                            class="text-red-600 hover:text-red-800 text-xs font-medium">Delete</button>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            <!-- Level 5: Fourth Level Replies (Maximum) -->
                                                            <div v-if="reply3.replies && reply3.replies.length > 0"
                                                                class="reply-level-4 mt-3 space-y-2">
                                                                <div v-for="reply4 in reply3.replies"
                                                                    :key="reply4.id"
                                                                    class="bg-yellow-50 rounded-lg p-2 border border-yellow-200">
                                                                    <p class="text-gray-800 mb-2 text-xs break-words">
                                                                        @{{ reply4.comment }}</p>
                                                                    <div
                                                                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                                                                        <span
                                                                            class="text-xs text-gray-500">@{{ reply4.user?.name }}</span>
                                                                        @if (Auth::check())
                                                                            <div class="flex flex-wrap gap-1">
                                                                                <button v-if="userId == reply4.user.id"
                                                                                    @click="editComments(reply4.id, reply4.comment, reply4.user)"
                                                                                    class="text-amber-600 hover:text-amber-800 text-xs font-medium">Edit</button>
                                                                                <button v-if="userId == reply4.user.id"
                                                                                    @click="deleteComments(reply4.id)"
                                                                                    class="text-red-600 hover:text-red-800 text-xs font-medium">Delete</button>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <div v-if="!isLoadingComment && (currentPage > 1 || currentPage != last_page)"
                                class="flex flex-col sm:flex-row justify-center gap-4 mt-8">
                                <button v-if="currentPage > 1" @click="fetchNewDecrementData"
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm">
                                    Previous
                                </button>
                                <button v-if="currentPage != last_page" @click="fetchNewData"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm">
                                    Next
                                </button>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 sm:w-16 sm:h-16 mx-auto mb-4 text-gray-300" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <p class="text-base sm:text-lg font-medium text-gray-600">Comments Disabled</p>
                                <p class="text-sm sm:text-base text-gray-500">The author has disabled comments for this
                                    post</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Gallery Modal --}}
    <div class="modal fade" id="eventGalleryModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-black border-0">

                <div class="modal-body p-0 relative">

                    {{-- Close --}}
                    <button type="button"
                        class="absolute top-4 right-4 z-50 text-white bg-black/50 rounded-full w-10 h-10"
                        data-bs-dismiss="modal">
                        ✕
                    </button>

                    <div id="eventGalleryCarousel" class="carousel slide h-full" data-bs-touch="true">

                        <div class="carousel-inner h-screen" id="eventGalleryContent">
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#eventGalleryCarousel"
                            data-bs-slide="prev">

                            <span class="carousel-control-prev-icon"></span>
                        </button>

                        <button class="carousel-control-next" type="button" data-bs-target="#eventGalleryCarousel"
                            data-bs-slide="next">

                            <span class="carousel-control-next-icon"></span>
                        </button>

                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Event Detail Modal --}}
    <div class="modal fade" id="eventDetailModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content border-0 rounded-3xl overflow-hidden">

                {{-- Close --}}
                <button type="button" class="absolute top-3 right-3 z-50 bg-black/50 text-white rounded-full w-9 h-9"
                    data-bs-dismiss="modal">

                    ✕
                </button>

                {{-- Content --}}
                <div id="eventDetailContent">
                </div>

            </div>

        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <script>
        // Swiper Events
        document.addEventListener("DOMContentLoaded", function() {

            new Swiper(".eventSwiper", {

                slidesPerView: "auto",
                spaceBetween: 16,

                grabCursor: true,
                simulateTouch: true,
                allowTouchMove: true,

                centeredSlides: false,

                navigation: {
                    nextEl: ".event-swiper-next",
                    prevEl: ".event-swiper-prev",
                },

                breakpoints: {
                    640: {
                        slidesPerView: 2.2,
                    },
                    1024: {
                        slidesPerView: 3,
                    }
                }

            });

        });

        // Event Data
        const eventsData = {
            @foreach ($event as $evnt)
                {{ $evnt->id }}: {
                    title: @json($evnt->title),
                    description: @json($evnt->description),
                    date: @json($evnt->date->format('d M Y | H:i')),
                    end_date: @json($evnt->end_date ? $evnt->end_date->format('d M Y | H:i') : null),
                    images: [
                        @foreach ($evnt->images as $image)
                            "{{ asset($image->image_url) }}",
                        @endforeach
                    ]
                },
            @endforeach
        };

        function openEventDetail(eventId) {

            const ev = eventsData[eventId];

            let carouselItems = '';

            if (ev.images.length) {

                ev.images.forEach((img, index) => {

                    carouselItems += `
                    <div class="carousel-item ${index === 0 ? 'active' : ''}">
                        <img src="${img}"
                            class="w-full h-[220px] sm:h-[400px] object-cover">
                    </div>
                `;
                });

            } else {

                carouselItems = `
                <div class="w-full h-[220px] sm:h-[400px] bg-gray-100 flex items-center justify-center text-gray-400">
                    No Image
                </div>
            `;
            }

            document.getElementById('eventDetailContent').innerHTML = `

            <div>

                <div id="eventDetailCarousel"
                    class="carousel slide"
                    data-bs-touch="true">

                    <div class="carousel-inner">
                        ${carouselItems}
                    </div>

                    ${ev.images.length > 1 ? `
                                                                                                                                                                                                                <button class="carousel-control-prev"
                                                                                                                                                                                                                    type="button"
                                                                                                                                                                                                                    data-bs-target="#eventDetailCarousel"
                                                                                                                                                                                                                    data-bs-slide="prev">

                                                                                                                                                                                                                    <span class="carousel-control-prev-icon"></span>
                                                                                                                                                                                                                </button>

                                                                                                                                                                                                                <button class="carousel-control-next"
                                                                                                                                                                                                                    type="button"
                                                                                                                                                                                                                    data-bs-target="#eventDetailCarousel"
                                                                                                                                                                                                                    data-bs-slide="next">

                                                                                                                                                                                                                    <span class="carousel-control-next-icon"></span>
                                                                                                                                                                                                                </button>
                                                                                                                                                                                                            ` : ''}

                </div>

                <div class="p-4 sm:p-5">

                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                        ${ev.title}
                    </h2>

                    <div class="mt-3 text-sm text-gray-600">

                        <div>
                            <span class="font-semibold">
                                Start:
                            </span>

                            ${ev.date} WITA
                        </div>

                        ${ev.end_date ? `
                                                                                                                                                                                                                <div class="mt-1">
                                                                                                                                                                                                                    <span class="font-semibold">
                                                                                                                                                                                                                        Until:
                                                                                                                                                                                                                    </span>

                                                                                                                                                                                                                    ${ev.end_date} WITA
                                                                                                                                                                                                                </div>
                                                                                                                                                                                                            ` : ''}

                    </div>

                    <div class="mt-4 text-sm sm:text-base text-gray-700 leading-relaxed whitespace-pre-line">
                        ${ev.description}
                    </div>

                </div>

            </div>
        `;

            const modal = new bootstrap.Modal(document.getElementById(
                'eventDetailModal'));

            modal.show();
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Mobile TOC functionality
            const mobileTocBtn = document.getElementById('mobile-toc-btn');
            const mobileTocModal = document.getElementById('mobile-toc-modal');
            const closeMobileToc = document.getElementById('close-mobile-toc');
            const mobileTocOverlay = document.getElementById('mobile-toc-overlay');

            mobileTocBtn.addEventListener('click', function() {
                mobileTocModal.classList.remove('hidden');
            });

            closeMobileToc.addEventListener('click', function() {
                mobileTocModal.classList.add('hidden');
            });

            mobileTocOverlay.addEventListener('click', function() {
                mobileTocModal.classList.add('hidden');
            });

            // Mobile navigation links
            document.querySelectorAll('.mobile-nav-link').forEach(function(link) {
                link.addEventListener('click', function() {
                    mobileTocModal.classList.add('hidden');
                });
            });

            // Table of Contents Generation
            const content = document.querySelector('.prose');
            if (content) {
                const headings = content.querySelectorAll('h2, h3, h4');
                const tocList = document.getElementById('toc-list');
                tocList.innerHTML = '';

                headings.forEach((heading, idx) => {
                    if (!heading.id) heading.id = 'toc-heading-' + idx;
                    const li = document.createElement('li');
                    li.className = 'py-1';
                    li.style.marginLeft = (parseInt(heading.tagName[1]) - 2) * 16 + 'px';

                    const a = document.createElement('a');
                    a.href = '#' + heading.id;
                    a.textContent = heading.textContent;
                    a.className = 'text-sm text-gray-600 hover:text-blue-600 transition-colors';
                    a.onclick = function(e) {
                        e.preventDefault();
                        document.getElementById(heading.id).scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    };
                    li.appendChild(a);
                    tocList.appendChild(li);
                });
            }

            // TOC Sidebar Toggle (Desktop)
            // const sidebar = document.getElementById('toc-sidebar');
            // const toggleBtn = document.getElementById('toc-toggle');

            // if (toggleBtn) {
            //     toggleBtn.onclick = function() {
            //         sidebar.classList.toggle('closed');
            //     };
            // }
            const sidebar = document.getElementById('toc-sidebar');
            const toggleBtn = document.getElementById('toc-toggle');
            const restoreBtn = document.getElementById('toc-restore');

            if (toggleBtn && restoreBtn && sidebar) {
                toggleBtn.onclick = function() {
                    sidebar.classList.add('closed');
                    toggleBtn.classList.add('hidden');
                    restoreBtn.classList.remove('hidden');
                };

                restoreBtn.onclick = function() {
                    sidebar.classList.remove('closed');
                    restoreBtn.classList.add('hidden');
                    toggleBtn.classList.remove('hidden');
                };
            }

            // Smooth scroll for navigation links
            document.querySelectorAll('a[href^="#"]').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').replace('#', '');
                    const target = document.getElementById(targetId);
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });

        // Vue.js Application
        var app = new Vue({
            el: '#app',
            data() {
                return {
                    comments: [],
                    currentAdsImage: 0,
                    isBlockedAds: "{{ $modalAds?->is_block ? 'true' : 'false' }}",
                    adsImagesCount: "{{ $modalAdsImages->count() }}",
                    adsInterval: null,
                    adsPaused: false,
                    selectedRating: 0,
                    hoveredRating: 0,
                    isLoadingComment: true,
                    currentPage: 1,
                    currentComment: '',
                    last_page: 0,
                    isReplying: null,
                    userReplying: null,
                    userId: null,
                    editUserId: null,
                    currEditId: null,
                    isLoadingAds: true,
                    timeAds: "{!! $modalAds?->time ?? 0 !!}",
                    isAdsActive: "{!! $modalAds?->is_active ?? 0 !!}",
                    disabledAfter: "{!! $customSettingRunningText->disabled_after !!}",
                    showAdsModal: false
                }
            },
            methods: {
                closeAdsModal() {
                    this.showAdsModal = false;
                },
                setCountDownModal() {
                    const intervalId = setInterval(() => {
                        this.timeAds--;
                        if (this.timeAds <= 0) {
                            this.isLoadingAds = false;
                            clearInterval(intervalId);
                        }
                    }, 1000);
                },
                setCountdownRunningText() {
                    const intervalId = setInterval(() => {
                        this.disabledAfter--;

                        if (this.disabledAfter <= 0) {
                            clearInterval(intervalId);

                            const header = document.getElementById('headerContainerRunningText');

                            if (header) {
                                header.classList.remove('mt-4');
                            }
                        }
                    }, 1000);
                },
                startAdsSlider() {

                    this.stopAdsSlider();

                    this.adsInterval = setInterval(() => {

                        if (!this.adsPaused) {
                            this.nextAdsImage();
                        }

                    }, 3000);

                },

                stopAdsSlider() {

                    if (this.adsInterval) {
                        clearInterval(this.adsInterval);
                    }

                },

                nextAdsImage() {

                    this.currentAdsImage++;

                    if (this.currentAdsImage >= this.adsImagesCount) {
                        this.currentAdsImage = 0;
                    }

                },

                prevAdsImage() {

                    this.currentAdsImage--;

                    if (this.currentAdsImage < 0) {
                        this.currentAdsImage = this.adsImagesCount - 1;
                    }

                },

                goToAdsImage(index) {

                    this.currentAdsImage = index;

                },

                toggleAdsSlider() {

                    this.adsPaused = !this.adsPaused;

                },
                // closeTranslate() {
                //     document.cookie = "googtrans=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT;";
                //     window.location.reload();
                // },
                closeTranslate() {

                    // clear google translate cookie
                    document.cookie =
                        "googtrans=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT";

                    document.cookie =
                        "googtrans=; domain=" + location.hostname +
                        "; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT";

                    // reset select jika ada
                    const select = document.querySelector('.goog-te-combo');

                    if (select) {
                        select.value = 'id';
                        select.dispatchEvent(new Event('change'));
                    }

                    setTimeout(() => {
                        window.location.reload();
                    }, 300);
                },
                setRating(rating) {
                    this.selectedRating = rating;
                },
                hoverRating(rating) {
                    this.hoveredRating = rating;
                },
                resetHover() {
                    this.hoveredRating = 0;
                },
                fetchNewDecrementData() {
                    this.currentPage--;
                    this.getCommentData();
                },
                fetchNewData() {
                    this.currentPage++;
                    this.getCommentData();
                },
                async getCommentData() {
                    this.isLoadingComment = true;
                    const baseUrl = window.location.href.split('#')[0];

                    try {
                        const response = await fetch(`${baseUrl}/comments?type=api&page=${this.currentPage}`);
                        const data = await response.json();
                        this.comments = data.data.data;
                        this.last_page = data.data.last_page;
                        this.userId = data.uid;
                    } catch (error) {
                        console.error('Error fetching comments:', error);
                    } finally {
                        this.isLoadingComment = false;
                    }
                },
                async addComment() {
                    this.isLoadingComment = true;
                    // const baseUrl = window.location.href;
                    const baseUrl = window.location.href.split('#')[0];

                    const data = {
                        rating: this.selectedRating,
                        comment: this.currentComment,
                        parent_id: this.isReplying
                    };

                    try {
                        const response = await fetch(`${baseUrl}/comments/store?type=api`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify(data)
                        });

                        const result = await response.json();

                        if (result.errors) {
                            swal("Error!", "Invalid Fields!", "error");
                        } else {
                            swal("Added!", "Your comment has been added.", "success");
                            this.currentComment = '';
                            this.selectedRating = 0;
                            this.cancelReply();
                        }
                    } catch (error) {
                        swal("Error!", "Server failed to add comment!", "error");
                    } finally {
                        this.isLoadingComment = false;
                        this.getCommentData();
                    }
                },
                async updateComment() {
                    const data = {
                        comment_id: this.currEditId,
                        comment: this.currentComment,
                        userId: this.userId
                    };

                    try {
                        const response = await fetch(`${window.location.href}/comments/update`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify(data)
                        });

                        const result = await response.json();

                        if (result.errors) {
                            swal("Error!", "Invalid Fields!", "error");
                        } else {
                            swal("Updated!", "Your comment has been updated.", "success");
                            this.cancelEdit();
                        }
                    } catch (error) {
                        swal("Error!", "Server failed to update comment!", "error");
                    } finally {
                        this.getCommentData();
                    }
                },
                setReplyComment(id, user) {
                    this.cancelEdit();
                    this.$refs.inputField.focus();
                    this.isReplying = id;
                    this.userReplying = user;
                },
                editComments(idComment, comment, userId) {
                    this.cancelReply();
                    this.currEditId = idComment;
                    this.currentComment = comment;
                    this.editUserId = userId;
                    this.$refs.inputField.focus();
                },
                cancelReply() {
                    this.isReplying = null;
                    this.userReplying = null;
                },
                cancelEdit() {
                    this.currentComment = '';
                    this.editUserId = null;
                    this.currEditId = null;
                },
                deleteComments(commentId) {
                    swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this comment!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then(async (willDelete) => {
                        if (willDelete) {
                            this.isLoadingComment = true;

                            try {
                                const response = await fetch(
                                    `${window.location.href}/comments/${commentId}/delete`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]').getAttribute(
                                                'content')
                                        }
                                    });

                                if (response.ok) {
                                    swal("Deleted!", "Your comment has been deleted.", "success");
                                    this.cancelReply();
                                    this.cancelEdit();
                                } else {
                                    throw new Error('Network response was not ok');
                                }
                            } catch (error) {
                                swal("Error!", "There was a problem deleting your comment.", "error");
                            } finally {
                                this.isLoadingComment = false;
                                this.getCommentData();
                            }
                        } else {
                            swal("Your comment is safe!");
                        }
                    });
                },
                showModal() {
                    this.showAdsModal = true;
                    this.startAdsSlider();
                },
                hideModal() {
                    this.showAdsModal = false;
                    if (this.adsInterval) {
                        clearInterval(this.adsInterval);
                    }
                }
            },
            async mounted() {
                await this.getCommentData();

                if (this.isAdsActive === "1") {
                    this.showModal();
                    this.setCountDownModal();
                }

                if (this.disabledAfter > 0) {
                    this.setCountdownRunningText();
                }
            }
        });
    </script>

    <!-- Google Translate -->
    <script>
        console.log('Google Translate script loaded');

        function googleTranslateElementInit() {

            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'id,en,es,fr,de,it,ja,zh-CN',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');

            setupGoogleTranslateAutoClose();
        }

        function setupGoogleTranslateAutoClose() {

            let isClosing = false;

            document.addEventListener('click', function(e) {

                const languageItem = e.target.closest(
                    '.VIpgJd-ZVi9od-vH1Gmf-ibnC6b'
                );

                if (!languageItem || isClosing) return;

                isClosing = true;

                // tunggu translate apply
                setTimeout(() => {

                    // trigger click outside popup
                    document.body.dispatchEvent(
                        new MouseEvent('mousedown', {
                            bubbles: true
                        })
                    );

                    document.body.dispatchEvent(
                        new MouseEvent('click', {
                            bubbles: true
                        })
                    );

                    // remove focus
                    if (document.activeElement) {
                        document.activeElement.blur();
                    }

                    // reset lock supaya next click bisa lagi
                    setTimeout(() => {
                        isClosing = false;
                    }, 1000);

                }, 300);

            }, true);
        }

        googleTranslateElementInit();
    </script>
@endpush
