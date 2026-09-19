<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-white mb-6">Checkout</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-gray-800 rounded-lg p-6">
                    <h2 class="text-lg font-bold text-white mb-4">Items in Your Order</h2>
                    <div class="space-y-3">
                        @foreach($cartItems as $item)
                            <div class="flex items-center justify-between p-3 bg-gray-700/50 rounded">
                                <div class="flex items-center">
                                    <span class="text-gray-300 text-sm mr-3">{{ $item->game->title }}</span>
                                </div>
                                <span class="text-white text-sm font-semibold">${{ number_format($item->game->effective_price, 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <h2 class="text-lg font-bold text-white my-6">Payment Method</h2>
                    <form method="POST" action="{{ route('orders.process') }}" class="space-y-4">
                        @csrf

                        <div class="space-y-3">
                            <label class="flex items-center p-4 bg-gray-700/50 rounded-lg cursor-pointer hover:bg-gray-700 transition">
                                <input type="radio" name="payment_method" value="credit_card" checked class="h-4 w-4 text-blue-600 border-gray-600">
                                <span class="ml-3 text-white text-sm">Credit Card</span>
                                <span class="ml-auto text-gray-400 text-xs">Visa / Mastercard</span>
                            </label>
                            <label class="flex items-center p-4 bg-gray-700/50 rounded-lg cursor-pointer hover:bg-gray-700 transition">
                                <input type="radio" name="payment_method" value="paypal" class="h-4 w-4 text-blue-600 border-gray-600">
                                <span class="ml-3 text-white text-sm">PayPal</span>
                            </label>
                            <label class="flex items-center p-4 bg-gray-700/50 rounded-lg cursor-pointer hover:bg-gray-700 transition">
                                <input type="radio" name="payment_method" value="wallet" class="h-4 w-4 text-blue-600 border-gray-600">
                                <span class="ml-3 text-white text-sm">GameStore Wallet</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 rounded-md text-sm font-semibold text-white hover:bg-green-500 transition">
                            Place Order &middot; Pay ${{ number_format($subtotal, 2) }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-gray-800 rounded-lg p-6 h-fit sticky top-4">
                <h2 class="text-lg font-bold text-white mb-4">Order Summary</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-300">Items ({{ $cartItems->count() }})</span>
                        <span class="text-white">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-300">Tax</span>
                        <span class="text-white">$0.00</span>
                    </div>
                    <div class="border-t border-gray-700 pt-3 flex justify-between items-center">
                        <span class="text-gray-300 font-semibold">Total</span>
                        <span class="text-white font-bold text-xl">${{ number_format($subtotal, 2) }}</span>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('cart.index') }}" class="text-center block text-sm text-gray-300 hover:text-white transition">Back to Cart</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>