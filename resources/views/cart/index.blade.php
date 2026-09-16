<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-white mb-6">Your Cart</h1>

        @if($cartItems->isEmpty())
            <div class="text-center py-16 bg-gray-800 rounded-lg">
                <p class="text-gray-400 text-lg mb-4">Your cart is empty</p>
                <a href="{{ route('games.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 rounded-md text-sm font-semibold text-white hover:bg-blue-500 transition">
                    Browse Games
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="flex items-center bg-gray-800 rounded-lg p-4">
                            <a href="{{ route('games.show', $item->game->slug) }}" class="shrink-0">
                                @if($item->game->cover_image)
                                    <img src="{{ $item->game->cover_image }}" alt="{{ $item->game->title }}" class="w-40 aspect-video object-cover rounded">
                                @else
                                    <div class="w-40 aspect-video bg-gray-700 rounded flex items-center justify-center">
                                        <svg class="h-8 w-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                @endif
                            </a>
                            <div class="flex-1 ml-4">
                                <h3 class="text-white font-semibold">
                                    <a href="{{ route('games.show', $item->game->slug) }}" class="hover:text-blue-400 transition">{{ $item->game->title }}</a>
                                </h3>
                                <p class="text-gray-500 text-sm mt-1">{{ $item->game->developer }}</p>
                                <div class="flex justify-between items-center mt-3">
                                    <div class="flex items-center">
                                        @if($item->game->is_discounted)
                                            <span class="text-gray-500 line-through text-sm">${{ number_format($item->game->price, 2) }}</span>
                                            <span class="text-green-400 font-bold ml-2">${{ number_format($item->game->effective_price, 2) }}</span>
                                        @else
                                            <span class="text-white font-bold">${{ number_format($item->game->price, 2) }}</span>
                                        @endif
                                    </div>
                                    <form method="POST" action="{{ route('cart.remove', $item) }}" onsubmit="return confirm('Remove this game from cart?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-500 hover:text-red-400 text-sm transition">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="bg-gray-800 rounded-lg p-6 h-fit sticky top-4">
                    <h2 class="text-lg font-bold text-white mb-4">Order Summary</h2>
                    <div class="flex justify-between mb-2 text-sm">
                        <span class="text-gray-400">Items</span>
                        <span class="text-white">{{ $cartItems->count() }}</span>
                    </div>
                    <div class="flex justify-between mb-4 text-sm">
                        <span class="text-gray-400">Subtotal</span>
                        <span class="text-white font-semibold">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <a href="{{ route('orders.checkout') }}" class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 rounded-md text-sm font-semibold text-white hover:bg-blue-500 transition">
                        Proceed to Checkout
                    </a>
                    <div class="mt-4">
                        <a href="{{ route('games.index') }}" class="text-center block text-sm text-gray-400 hover:text-white transition">Continue Shopping</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>