 <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-xl font-bold mb-4">Qrun Online</h3>
                    <p class="text-gray-400 mb-4">
                        Platform terbaik untuk berbagi informasi baik sejarah ataupun lainnya dan membangun komunitas. 
                        Mulai perjalanan Anda bersama kami.
                    </p>
                    {{-- <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div> --}}
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Menu</h4>
                    <ul class="space-y-2">
                        <li><a href="{{route('homes')}}" class="text-gray-400 hover:text-white">Beranda</a></li>
                        <li><a href="{{route('blog')}}" class="text-gray-400 hover:text-white">Blog</a></li>
                        {{-- <li><a href="#" class="text-gray-400 hover:text-white">Tentang</a></li> --}}
                        <li><a href="{{route('contact')}}" class="text-gray-400 hover:text-white">Kontak</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Akun</h4>
                    <ul class="space-y-2">
                        <li><a href="{{route('login')}}" class="text-gray-400 hover:text-white">Login</a></li>
                        <li><a href="{{route('register')}}" class="text-gray-400 hover:text-white">Register</a></li>
                        <li><a href="{{route('termsOfService')}}" class="text-gray-400 hover:text-white">Terms of Service</a></li>
                        <li><a href="{{route('privacyPolicy')}}" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">
                    &copy; {{ date('Y')}} Qrun onlne. All rights reserved.
                </p>
            </div>
        </div>
    </footer>