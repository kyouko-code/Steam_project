<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">My Orders</h1>
            <a href="{{ route('games.index') }}" class="text-blue-400 hover:text-blue-300 text-sm transition">Browse Store &rarr;</a>
        </div>

        @if($orders->isEmpty())
            <div class="text-center py-16 bg-gray-800 rounded-lg">
                <p class="text-gray-400 text-lg mb-4">You haven't placed any orders yet</p>
                <a href="{{ route('games.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 rounded-md text-sm font-semibold text-white hover:bg-blue-500 transition">
                    Start Shopping
                </a>
            </div>
        @else
            <div class="bg-gray-800 rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Order #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Items</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Payment</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach($orders as $order)
                            <tr class="hover:bg-gray-700/50 transition">
                                <td class="px-6 py-4">
                                    <a href="{{ route('orders.show', $order) }}" class="text-blue-400 hover:text-blue-300 transition font-medium">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $order->items_count ?? $order->items->count() }} games</td>
                                <td class="px-6 py-4 text-sm text-white font-semibold">${{ number_format($order->total_amount, 2) }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-green-900 text-green-400">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-app-layout>