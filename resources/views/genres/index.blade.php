<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-white mb-6">Browse by Genre</h1>

        @if($genres->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($genres as $genre)
                    @php
                        $color = match($genre->slug) {
                            'action'        => ['bg' => 'bg-blue-900/50',    'hover' => 'hover:bg-blue-800',    'text' => 'text-blue-400'],
                            'adventure'     => ['bg' => 'bg-emerald-900/50', 'hover' => 'hover:bg-emerald-800', 'text' => 'text-emerald-400'],
                            'rpg'           => ['bg' => 'bg-purple-900/50',  'hover' => 'hover:bg-purple-800',  'text' => 'text-purple-400'],
                            'shooter'       => ['bg' => 'bg-red-900/50',     'hover' => 'hover:bg-red-800',     'text' => 'text-red-400'],
                            'strategy'      => ['bg' => 'bg-amber-900/50',   'hover' => 'hover:bg-amber-800',   'text' => 'text-amber-400'],
                            'simulation'    => ['bg' => 'bg-cyan-900/50',    'hover' => 'hover:bg-cyan-800',    'text' => 'text-cyan-400'],
                            'sports'        => ['bg' => 'bg-green-900/50',   'hover' => 'hover:bg-green-800',   'text' => 'text-green-400'],
                            'racing'        => ['bg' => 'bg-orange-900/50',  'hover' => 'hover:bg-orange-800',  'text' => 'text-orange-400'],
                            'fighting'      => ['bg' => 'bg-rose-900/50',    'hover' => 'hover:bg-rose-800',    'text' => 'text-rose-400'],
                            'horror'        => ['bg' => 'bg-slate-900/50',   'hover' => 'hover:bg-slate-800',   'text' => 'text-slate-400'],
                            'puzzle'        => ['bg' => 'bg-pink-900/50',    'hover' => 'hover:bg-pink-800',    'text' => 'text-pink-400'],
                            'platformer'    => ['bg' => 'bg-teal-900/50',    'hover' => 'hover:bg-teal-800',    'text' => 'text-teal-400'],
                            'indie'         => ['bg' => 'bg-violet-900/50',  'hover' => 'hover:bg-violet-800',  'text' => 'text-violet-400'],
                            'multiplayer'   => ['bg' => 'bg-yellow-900/50',  'hover' => 'hover:bg-yellow-800',  'text' => 'text-yellow-400'],
                            'open-world'    => ['bg' => 'bg-indigo-900/50',  'hover' => 'hover:bg-indigo-800',  'text' => 'text-indigo-400'],
                            default         => ['bg' => 'bg-blue-900/50',    'hover' => 'hover:bg-blue-800',    'text' => 'text-blue-400'],
                        };
                    @endphp
                    <a href="{{ route('games.index', ['genre' => $genre->slug]) }}" class="block bg-gray-800 rounded-lg p-6 hover:ring-2 hover:ring-blue-500 transition-all group">
                        <div class="h-12 w-12 rounded-lg {{ $color['bg'] }} flex items-center justify-center mb-4 {{ $color['hover'] }} transition">
                            @include('genres._icon')
                        </div>
                        <h2 class="text-white font-semibold text-lg group-hover:text-blue-400 transition">{{ $genre->name }}</h2>
                        <p class="text-gray-500 text-sm mt-1">{{ $genre->games_count }} game{{ $genre->games_count == 1 ? '' : 's' }}</p>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-gray-800 rounded-lg">
                <p class="text-gray-400 text-lg">No genres available yet.</p>
            </div>
        @endif
    </div>
</x-app-layout>