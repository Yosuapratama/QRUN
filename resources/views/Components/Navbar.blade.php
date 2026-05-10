<!-- Navbar -->
<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('homes') }}" class="text-xl font-bold text-gray-800">Qrun Online</a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4">
                    <a href="{{ route('homes') }}"
                        class="{{ Route::currentRouteName() == 'homes' ? 'text-blue-600 hover:text-blue-700' : 'text-gray-600 hover:text-gray-900' }} px-3 py-2 rounded-md text-sm font-medium">
                        Beranda
                    </a>

                    <a href="{{ route('blog') }}"
                        class="{{ request()->is('blog') ? 'text-blue-600 hover:text-blue-700' : 'text-gray-600 hover:text-gray-900' }} px-3 py-2 rounded-md text-sm font-medium">
                        Blog
                    </a>

                    <a href="{{ route('contact') }}"
                        class="{{ Route::currentRouteName() == 'contact' ? 'text-blue-600 hover:text-blue-700' : 'text-gray-600 hover:text-gray-900' }} px-3 py-2 rounded-md text-sm font-medium">
                        Kontak
                    </a>

                </div>
            </div>

            <!-- Login/Register Buttons -->
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6 space-x-3">
                    <a href="{{ route('login') }}{{ Route::currentRouteName() == 'place.detail' ? '?redirect_back=true' : '' }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">Login/Register</a>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button"
                    class="mobile-menu-button bg-gray-200 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu hidden md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t">
            <a href="{{ route('homes') }}"
                class="{{ Route::currentRouteName() == 'homes' ? 'text-blue-600 hover:text-blue-700' : 'text-gray-600 hover:text-gray-900' }} block px-3 py-2 rounded-md text-base font-medium">
                Beranda
            </a>

            <a href="{{ route('blog') }}"
                class="{{ Route::currentRouteName() == 'blog' ? 'text-blue-600 hover:text-blue-700' : 'text-gray-600 hover:text-gray-900' }} block px-3 py-2 rounded-md text-base font-medium">
                Blog
            </a>

            <a href="{{ route('contact') }}"
                class="{{ Route::currentRouteName() == 'contact' ? 'text-blue-600 hover:text-blue-700' : 'text-gray-600 hover:text-gray-900' }} block px-3 py-2 rounded-md text-base font-medium">
                Kontak
            </a>

            <div class="border-t pt-3 mt-3">
                <a href="{{ route('login') }}{{ Route::currentRouteName() == 'place.detail' ? '?redirect_back=true' : '' }}"
                    class="{{ Route::currentRouteName() == 'login' ? 'bg-blue-700' : 'bg-blue-600 hover:bg-blue-700' }} text-white block px-3 py-2 rounded-md text-base font-medium">
                    Login/Register
                </a>
            </div>
        </div>
    </div>

</nav>
