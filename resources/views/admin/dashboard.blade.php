<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Admin Dashboard</h1>
            <a href="{{ route('admin.games.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 rounded-md text-sm font-semibold text-white hover:bg-blue-500 transition">
                + Add Game
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gray-800 rounded-lg p-6">
                <div class="text-3xl font-bold text-white">{{ $gameCount }}</div>
                <div class="text-sm text-gray-300 mt-1">Total Games</div>
            </div>
            <div class="bg-gray-800 rounded-lg p-6">
                <div class="text-3xl font-bold text-white">{{ $orderCount }}</div>
                <div class="text-sm text-gray-300 mt-1">Total Orders</div>
            </div>
            <div class="bg-gray-800 rounded-lg p-6">
                <div class="text-3xl font-bold text-white">{{ $userCount }}</div>
                <div class="text-sm text-gray-300 mt-1">Registered Users</div>
            </div>
            <div class="bg-gray-800 rounded-lg p-6">
                <div class="text-3xl font-bold text-green-400">${{ number_format($revenue, 2) }}</div>
                <div class="text-sm text-gray-300 mt-1">Total Revenue</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-gray-800 rounded-lg p-6">
                <h2 class="text-lg font-bold text-white mb-4">Recent Orders</h2>
                @if($recentOrders->count())
                    <div class="space-y-3">
                        @foreach($recentOrders as $order)
                            <div class="flex justify-between items-center p-3 bg-gray-700/50 rounded">
                                <div>
                                    <div class="text-white text-sm font-medium">{{ $order->order_number }}</div>
                                    <div class="text-gray-400 text-xs">{{ $order->user->name }} &middot; {{ $order->created_at->format('M d, Y') }}</div>
                                </div>
                                <span class="text-white font-semibold">${{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 text-sm">No orders yet.</p>
                @endif
            </div>

            <div class="bg-gray-800 rounded-lg p-6">
                <h2 class="text-lg font-bold text-white mb-4">Recent Games</h2>
                @if($recentGames->count())
                    <div class="space-y-3">
                        @foreach($recentGames as $game)
                            <div class="flex justify-between items-center p-3 bg-gray-700/50 rounded">
                                <div>
                                    <div class="text-white text-sm font-medium">{{ $game->title }}</div>
                                    <div class="text-gray-400 text-xs">{{ $game->developer }}</div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-yellow-400 text-xs font-semibold">
                                        @if($game->featured) FEATURED @endif
                                    </span>
                                    <a href="{{ route('admin.games.edit', $game) }}" class="text-blue-400 hover:text-blue-300 text-xs transition">Edit</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 text-sm">No games yet.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>