{{-- Navbar --}}
<nav class="bg-white shadow-sm sticky top-0 z-50" id="mainNav">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- Logo --}}
            <a href="{{ route('homes') }}" class="flex-shrink-0 flex items-center">
                <picture>
                    <source srcset="{{ asset('qrun-logo-fullwidth.webp') }}" type="image/webp">
                    <img src="{{ asset('qrun-logo-fullwidth.png') }}" alt="QRUN Logo" width="121" height="36"
                        fetchpriority="high" class="h-8 w-auto">
                </picture>
            </a>

            {{-- Desktop links --}}
            <div class="hidden md:flex items-center gap-1">
                @foreach ([
                    ['route' => 'homes',   'label' => __('messages.navbar.home'),    'active' => Route::currentRouteName() == 'homes'],
                    ['route' => 'blog',    'label' => __('messages.navbar.blog'),    'active' => request()->is('blog*')],
                    ['route' => 'contact', 'label' => __('messages.navbar.contact'), 'active' => Route::currentRouteName() == 'contact'],
                ] as $item)
                    <a href="{{ route($item['route']) }}"
                        class="relative px-4 py-2 text-sm font-medium rounded-lg transition-colors
                               {{ $item['active']
                                   ? 'text-blue-600'
                                   : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        {{ $item['label'] }}
                        @if ($item['active'])
                            <span class="absolute bottom-0.5 left-1/2 -translate-x-1/2 w-4 h-0.5 bg-blue-600 rounded-full"></span>
                        @endif
                    </a>
                @endforeach
            </div>

            {{-- Right side --}}
            <div class="flex items-center gap-3">
                {{-- Desktop CTA --}}
                <a href="{{ route('login') }}{{ Route::currentRouteName() == 'place.detail' ? '?redirect_back=true' : '' }}"
                    class="hidden md:inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-all shadow-sm hover:shadow-md">
                    <i class="fas fa-sign-in-alt text-xs"></i>
                    {{ __('messages.navbar.login_register') }}
                </a>

                {{-- Hamburger button --}}
                <button type="button" id="navHamburger"
                    class="md:hidden mobile-menu-button w-9 h-9 flex flex-col items-center justify-center gap-[5.5px] rounded-xl hover:bg-gray-100 active:bg-gray-200 transition-colors"
                    aria-label="Toggle menu" aria-expanded="false">
                    <span class="ham-line w-5 h-[1.5px] bg-gray-700 rounded-full transition-all duration-300 ease-in-out origin-center"></span>
                    <span class="ham-line w-5 h-[1.5px] bg-gray-700 rounded-full transition-all duration-300 ease-in-out"></span>
                    <span class="ham-line w-5 h-[1.5px] bg-gray-700 rounded-full transition-all duration-300 ease-in-out origin-center"></span>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu (slide-down) --}}
    <div id="navMobileMenu"
        class="md:hidden overflow-hidden transition-[max-height] duration-300 ease-in-out"
        style="max-height: 0;">
        <div class="px-4 pt-2 pb-5 border-t border-gray-100 space-y-1">

            <a href="{{ route('homes') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors
                       {{ Route::currentRouteName() == 'homes'
                           ? 'bg-blue-50 text-blue-600'
                           : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-home text-xs text-current w-4 text-center"></i>
                {{ __('messages.navbar.home') }}
            </a>

            <a href="{{ route('blog') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors
                       {{ request()->is('blog*')
                           ? 'bg-blue-50 text-blue-600'
                           : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-newspaper text-xs text-current w-4 text-center"></i>
                {{ __('messages.navbar.blog') }}
            </a>

            <a href="{{ route('contact') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors
                       {{ Route::currentRouteName() == 'contact'
                           ? 'bg-blue-50 text-blue-600'
                           : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-envelope text-xs text-current w-4 text-center"></i>
                {{ __('messages.navbar.contact') }}
            </a>

            <div class="pt-2 mt-1 border-t border-gray-100">
                <a href="{{ route('login') }}{{ Route::currentRouteName() == 'place.detail' ? '?redirect_back=true' : '' }}"
                    class="flex items-center justify-center gap-2 w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-xl text-sm font-semibold transition-colors">
                    <i class="fas fa-sign-in-alt text-xs"></i>
                    {{ __('messages.navbar.login_register') }}
                </a>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Hamburger → X animation */
    #navHamburger.is-open .ham-line:nth-child(1) {
        transform: translateY(7px) rotate(45deg);
    }
    #navHamburger.is-open .ham-line:nth-child(2) {
        opacity: 0;
        transform: scaleX(0);
    }
    #navHamburger.is-open .ham-line:nth-child(3) {
        transform: translateY(-7px) rotate(-45deg);
    }
</style>

<script>
    (function () {
        const btn  = document.getElementById('navHamburger');
        const menu = document.getElementById('navMobileMenu');
        let open   = false;

        function toggleMenu(force) {
            open = (force !== undefined) ? force : !open;
            btn.classList.toggle('is-open', open);
            btn.setAttribute('aria-expanded', open);
            menu.style.maxHeight = open ? menu.scrollHeight + 'px' : '0';
        }

        btn.addEventListener('click', () => toggleMenu());

        // Close on outside click
        document.addEventListener('click', function (e) {
            if (open && !btn.contains(e.target) && !menu.contains(e.target)) {
                toggleMenu(false);
            }
        });

        // Close on ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && open) toggleMenu(false);
        });
    })();
</script>
