<x-app-layout>
    <div class="bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-white mb-4">Welcome to GameStore</h1>
                <p class="text-gray-400 text-lg mb-6">Discover and buy the latest games at the best prices</p>
                <a href="{{ route('games.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-500 transition">
                    Browse Store
                </a>
            </div>
        </div>

        @if($featuredGames->count())
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
                <h2 class="text-2xl font-bold text-white mb-6">Featured Games</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($featuredGames as $game)
                        @include('games._card', ['game' => $game])
                    @endforeach
                </div>
            </div>
        @endif

        @if($recentGames->count())
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-white">New Releases</h2>
                    <a href="{{ route('games.index') }}" class="text-blue-400 hover:text-blue-300 text-sm">View All &rarr;</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($recentGames as $game)
                        @include('games._card', ['game' => $game])
                    @endforeach
                </div>
            </div>
        @endif

        @if($genres->count())
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
                <h2 class="text-2xl font-bold text-white mb-6">Browse by Genre</h2>
                <div class="flex flex-wrap gap-3">
                    @foreach($genres as $genre)
                        <a href="{{ route('games.index', ['genre' => $genre->slug]) }}"
                           class="px-4 py-2 bg-gray-800 hover:bg-gray-700 border border-gray-700 rounded-full text-sm text-gray-300 hover:text-white transition">
                            {{ $genre->name }}
                            <span class="text-gray-500 ml-1">({{ $genre->games_count }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
