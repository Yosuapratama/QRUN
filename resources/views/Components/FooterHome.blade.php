<footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <h3 class="text-xl font-bold mb-4">Qrun Online</h3>
                <p class="text-gray-400 mb-4">
                    {{ __('messages.footer.tagline') }}
                </p>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">{{ __('messages.footer.menu') }}</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('homes') }}" class="text-gray-400 hover:text-white">{{ __('messages.footer.home') }}</a></li>
                    <li><a href="{{ route('blog') }}" class="text-gray-400 hover:text-white">{{ __('messages.footer.blog') }}</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white">{{ __('messages.footer.contact') }}</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">{{ __('messages.footer.account') }}</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white">{{ __('messages.footer.login') }}</a></li>
                    <li><a href="{{ route('register') }}" class="text-gray-400 hover:text-white">{{ __('messages.footer.register') }}</a></li>
                    <li><a href="{{ route('termsOfService') }}" class="text-gray-400 hover:text-white">{{ __('messages.footer.terms_of_service') }}</a></li>
                    <li><a href="{{ route('privacyPolicy') }}" class="text-gray-400 hover:text-white">{{ __('messages.footer.privacy_policy') }}</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-8 pt-8 text-center">
            <p class="text-gray-400">
                &copy; {{ date('Y') }} {{ __('messages.footer.copyright') }}
            </p>
        </div>
    </div>
</footer>
