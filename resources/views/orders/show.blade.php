<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Order {{ $order->order_number }}</h1>
            <a href="{{ route('orders.index') }}" class="text-blue-400 hover:text-blue-300 text-sm transition">&larr; Back to Orders</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-gray-800 rounded-lg p-6">
                    <h2 class="text-lg font-bold text-white mb-4">Items Purchased</h2>
                    @if($order->items->isEmpty())
                        <p class="text-gray-400">This order has no items.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex items-center justify-between p-4 bg-gray-700/50 rounded-lg">
                                    <div class="flex items-center">
                                        @if($item->game->cover_image)
                                            <img src="{{ $item->game->cover_image }}" alt="{{ $item->game->title }}" class="w-24 aspect-video object-cover rounded mr-4">
                                        @endif
                                        <div>
                                            <a href="{{ route('games.show', $item->game->slug) }}" class="text-white font-semibold hover:text-blue-400 transition">
                                                {{ $item->game->title }}
                                            </a>
                                            <p class="text-gray-400 text-sm">by {{ $item->game->developer }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-white font-bold">${{ number_format($item->price, 2) }}</div>
                                        <a href="{{ route('games.show', $item->game->slug) }}" class="text-blue-400 hover:text-blue-300 text-xs transition">View Game</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-gray-800 rounded-lg p-6 h-fit sticky top-4">
                <h2 class="text-lg font-bold text-white mb-4">Order Details</h2>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-300">Order Number</dt>
                        <dd class="text-white">{{ $order->order_number }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-300">Date Placed</dt>
                        <dd class="text-white">{{ $order->created_at->format('M d, Y g:i A') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-300">Status</dt>
                        <dd class="text-green-400 font-semibold">{{ ucfirst($order->status) }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-300">Payment Method</dt>
                        <dd class="text-white">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</dd>
                    </div>
                    <div class="border-t border-gray-700 pt-3 flex justify-between">
                        <dt class="text-gray-300 font-semibold">Total</dt>
                        <dd class="text-white font-bold text-lg">${{ number_format($order->total_amount, 2) }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>