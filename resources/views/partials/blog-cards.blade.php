@forelse($blogs as $blog)
    <article class="blog-card group bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm flex flex-col sm:flex-row">

        {{-- Thumbnail --}}
        <div class="relative sm:w-52 sm:shrink-0 overflow-hidden bg-gray-100">
            <img src="{{ asset($blog->image_url) }}" alt="{{ $blog->title }}"
                class="card-img w-full h-52 sm:h-full object-cover">
        </div>

        {{-- Content --}}
        <div class="flex flex-col justify-between p-5 flex-1 min-w-0">
            <div>
                <div class="flex items-center gap-3 text-xs text-gray-400 mb-3">
                    <span class="flex items-center gap-1.5">
                        <i class="fas fa-clock text-[10px]"></i>
                        {{ Carbon\Carbon::parse($blog->created_at)->locale('id')->diffForHumans() }}
                    </span>
                    <span>·</span>
                    <span class="flex items-center gap-1.5">
                        <i class="fas fa-eye text-[10px]"></i>
                        {{ $blog->views < 1000 ? $blog->views : number_format($blog->views / 1000, 1) . 'K' }}
                    </span>
                    <span>·</span>
                    <span class="flex items-center gap-1.5">
                        <i class="fas fa-user text-[10px]"></i>
                        Admin
                    </span>
                </div>

                <h2 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2 leading-snug mb-2">
                    <a href="/blog/{{ $blog->slug }}">{{ $blog->title }}</a>
                </h2>

                <p class="text-gray-500 text-sm leading-relaxed line-clamp-3">{{ $blog->description }}</p>
            </div>

            <div class="mt-4 pt-4 border-t border-gray-50">
                <a href="/blog/{{ $blog->slug }}"
                    class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-700 text-sm font-semibold transition-colors">
                    Baca Selengkapnya <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

    </article>
@empty
    <div class="flex flex-col items-center justify-center py-20 text-center">
        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
            <i class="fas fa-newspaper text-2xl text-gray-300"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-1">Tidak Ada Artikel Terkait</h3>
        <p class="text-gray-400 text-sm">Belum ada artikel lain yang tersedia saat ini.</p>
    </div>
@endforelse
