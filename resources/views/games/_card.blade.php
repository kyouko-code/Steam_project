<a href="{{ route('games.show', $game->slug) }}" class="block bg-gray-800 rounded-lg overflow-hidden hover:ring-2 hover:ring-blue-500 transition-all duration-300 group">
    <div class="aspect-video bg-gray-700 relative overflow-hidden">
        @if($game->cover_image)
            <img src="{{ $game->cover_image }}" alt="{{ $game->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        @endif
        @if($game->is_discounted)
            <span class="absolute top-2 left-2 bg-green-600 text-white text-xs font-bold px-2 py-1 rounded">
                -{{ $game->discount_percent }}%
            </span>
        @endif
    </div>
    <div class="p-4">
        <h3 class="text-white font-semibold text-sm truncate group-hover:text-blue-400 transition">{{ $game->title }}</h3>
        <p class="text-gray-400 text-xs mt-1">{{ $game->developer }}</p>
        <div class="flex items-center justify-between mt-3">
            <div>
                @if($game->is_discounted)
                    <span class="text-gray-400 line-through text-sm">${{ number_format($game->price, 2) }}</span>
                    <span class="text-green-400 font-bold ml-2">${{ number_format($game->discount_price, 2) }}</span>
                @else
                    <span class="text-white font-bold">${{ number_format($game->price, 2) }}</span>
                @endif
            </div>
            @if($game->genres->count())
                <span class="text-xs text-gray-400 bg-gray-700 px-2 py-1 rounded">{{ $game->genres->first()->name }}</span>
            @endif
        </div>
    </div>
</a>
