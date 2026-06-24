@foreach ($ebooks as $ebook)
    <a href="/ebook/{{ $ebook->slug }}?ref={{ $ebookPlace->code }}" class="book-card reveal group">
        <div class="book-cover relative bg-gray-100 aspect-[3/4]">
            <img src="{{ asset($ebook->image_url) }}" alt="{{ $ebook->title }}"
                class="w-full h-full object-cover" loading="lazy">
            @if ($ebook->category)
                <span class="cat-badge absolute top-3 left-3 bg-white/95 backdrop-blur text-blue-700 px-2.5 py-1 rounded-full shadow">
                    {{ $ebook->category }}
                </span>
            @endif
        </div>

        <div class="book-meta p-3.5 flex-1 flex flex-col">
            <h3 class="book-title line-clamp-2 group-hover:text-blue-600 transition-colors">
                {{ $ebook->title }}
            </h3>
            <p class="book-author mt-auto pt-2 flex items-center gap-1.5">
                <i class="fas fa-user-pen text-xs text-gray-400"></i>
                <span class="truncate">{{ $ebook->author ?: 'Qrun Online' }}</span>
            </p>
        </div>
    </a>
@endforeach
