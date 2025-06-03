 @forelse($blogs as $blog)
     <article class="bg-white rounded-lg shadow-lg overflow-hidden">
         <img src="{{ asset($blog->image_url) }}?height=300&width=600" alt="Featured Post"
             class="w-full h-64 object-cover">
         <div class="p-6">
             <div class="flex items-center text-sm text-gray-500 mb-3">
                 <i class="fas fa-calendar-alt mr-2"></i>
                 <span>{{ Carbon\Carbon::parse($blog->created_at)->locale('id')->diffForHumans() }}</span>
                 <span class="mx-2">•</span>
                 <i class="fas fa-user mr-2"></i>
                 <span>Admin</span>
             </div>
             <h2 class="text-2xl font-bold text-gray-900 mb-3 hover:text-blue-600">
                 <a href="/blog/{{ $blog->slug }}">{{ $blog->title }}</a>
             </h2>
             <p class="text-gray-600 mb-4">{{ $blog->description }}</p>
             <div class="flex items-center justify-between">
                 <div class="flex items-center space-x-4 text-sm text-gray-500">
                     <span><i class="fas fa-eye mr-1"></i>
                         {{ $blog->views < 1000 ? $blog->views : number_format($blog->views / 1000, 1) . 'K' }}
                     </span>
                 </div>
                 <a href="/blog/{{ $blog->slug }}" class="text-blue-600 hover:text-blue-700 font-medium">
                     Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                 </a>
             </div>
         </div>
     </article>

 @empty
     <div class="col-span-full flex flex-col items-center justify-center py-12 px-4">
         <div class="text-center">
             <i class="fas fa-newspaper text-4xl text-gray-300 mb-4"></i>
             <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak Ada Artikel Terkait</h3>
             <p class="text-gray-500">Belum ada artikel lain yang tersedia saat ini.</p>
         </div>
     </div>
 @endforelse
