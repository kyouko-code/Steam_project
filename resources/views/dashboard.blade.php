<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-white mb-6">Your Library</h1>

        @php
            $libraryGames = \App\Models\Game::whereHas('orderItems', function ($q) {
                $q->whereHas('order', function ($orderQ) {
                    $orderQ->where('user_id', auth()->id())->where('status', 'completed');
                });
            })->get();
        @endphp

        <div class="rounded-lg bg-gray-800 p-4 mb-6 text-sm">
            <span class="text-gray-300">Welcome back, <span class="font-semibold text-white">{{ auth()->user()->name }}</span>! You own <span class="font-semibold text-blue-400">{{ $libraryGames->count() }}</span> game(s).</span>
        </div>

        @if($libraryGames->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($libraryGames as $game)
                    @include('games._card', ['game' => $game])
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-gray-800 rounded-lg">
                <p class="text-gray-300 text-lg mb-4">Your library is empty</p>
                <a href="{{ route('games.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 rounded-md text-sm font-semibold text-white hover:bg-blue-500 transition">
                    Browse Games
                </a>
            </div>
        @endif
    </div>
</x-app-layout>