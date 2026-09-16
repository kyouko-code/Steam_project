<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-white mb-6">Store</h1>

        <div class="mb-6 rounded-lg p-4 bg-gray-800">
            <form method="GET" action="{{ route('games.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search games, developers, publishers..."
                               class="block w-full rounded-md border-gray-700 bg-gray-900 text-white focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <select name="genre" class="block w-full rounded-md border-gray-700 bg-gray-900 text-white focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <option value="">All Genres</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->slug }}" @selected($currentGenre == $genre->slug)>{{ $genre->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="sort" class="block w-full rounded-md border-gray-700 bg-gray-900 text-white focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <option value="latest" @selected(request('sort') == 'latest')>Newest</option>
                            <option value="price_low" @selected(request('sort') == 'price_low')>Price: Low to High</option>
                            <option value="price_high" @selected(request('sort') == 'price_high')>Price: High to Low</option>
                            <option value="name" @selected(request('sort') == 'name')>Name A-Z</option>
                            <option value="rating" @selected(request('sort') == 'rating')>Top Rated</option>
                        </select>
                    </div>
                </div>
                <div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 rounded-md text-sm font-semibold text-white hover:bg-blue-500 transition">
                        Search
                    </button>
                    @if(request()->hasAny(['search', 'genre', 'sort']))
                        <a href="{{ route('games.index') }}" class="text-sm text-gray-400 hover:text-white ml-3 transition">Clear Filters</a>
                    @endif
                </div>
            </form>
        </div>

        @if($games->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($games as $game)
                    @include('games._card', ['game' => $game])
                @endforeach
            </div>

            <div class="mt-8">
                {{ $games->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <p class="text-gray-400 text-lg mb-4">No games found</p>
                <a href="{{ route('games.index') }}" class="text-blue-400 hover:text-blue-300">Clear search filters</a>
            </div>
        @endif
    </div>
</x-app-layout>