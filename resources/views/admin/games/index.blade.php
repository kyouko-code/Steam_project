<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Game Management</h1>
            <a href="{{ route('admin.games.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 rounded-md text-sm font-semibold text-white hover:bg-blue-500 transition">
                + Add Game
            </a>
        </div>

        <div class="bg-gray-800 rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Genres</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Featured</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($games as $game)
                        <tr class="hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4">
                                <div class="text-white font-medium">{{ $game->title }}</div>
                                <div class="text-gray-400 text-xs">{{ $game->developer }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($game->genres->take(2) as $genre)
                                        <span class="px-2 py-0.5 bg-gray-700 rounded-full text-xs text-gray-300">{{ $genre->name }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($game->is_discounted)
                                    <div class="text-sm">
                                        <span class="text-gray-400 line-through">${{ number_format($game->price, 2) }}</span>
                                        <span class="text-green-400 font-semibold ml-1">${{ number_format($game->discount_price, 2) }}</span>
                                    </div>
                                @else
                                    <span class="text-white text-sm">${{ number_format($game->price, 2) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($game->featured)
                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-900 text-yellow-400">Featured</span>
                                @else
                                    <span class="text-gray-400 text-xs">No</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($game->status === 'active')
                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-green-900 text-green-400">Active</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-red-900 text-red-400">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('admin.games.edit', $game) }}" class="inline-flex items-center px-3 py-1.5 bg-gray-700 hover:bg-gray-600 rounded-md text-xs font-medium text-white transition">Edit</a>
                                <form method="POST" action="{{ route('admin.games.destroy', $game) }}" class="inline" onsubmit="return confirm('Delete this game permanently?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-900 hover:bg-red-800 rounded-md text-xs font-medium text-red-200 transition">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-300">No games yet. <a href="{{ route('admin.games.create') }}" class="text-blue-400 hover:text-blue-300">Add your first game</a></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $games->links() }}
        </div>
    </div>
</x-app-layout>