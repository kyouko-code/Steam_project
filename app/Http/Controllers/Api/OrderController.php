<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->with('items.game')
            ->latest()
            ->paginate(10);

        $orders->getCollection()->transform(fn($order) => [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'total_amount' => (float) $order->total_amount,
            'status' => $order->status,
            'payment_method' => $order->payment_method,
            'items_count' => $order->items->count(),
            'items' => $order->items->map(fn($item) => [
                'id' => $item->id,
                'game' => [
                    'id' => $item->game->id,
                    'title' => $item->game->title,
                    'slug' => $item->game->slug,
                    'cover_image' => $item->game->cover_image,
                ],
                'price' => (float) $item->price,
            ]),
            'created_at' => $order->created_at,
        ]);

        return response()->json($orders);
    }

    public function show(Request $request, Order $order): JsonResponse
    {
        if ($order->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        $order->load('items.game');

        return response()->json([
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'total_amount' => (float) $order->total_amount,
                'status' => $order->status,
                'payment_method' => $order->payment_method,
                'items' => $order->items->map(fn($item) => [
                    'id' => $item->id,
                    'game' => [
                        'id' => $item->game->id,
                        'title' => $item->game->title,
                        'slug' => $item->game->slug,
                        'cover_image' => $item->game->cover_image,
                        'developer' => $item->game->developer,
                    ],
                    'price' => (float) $item->price,
                ]),
                'created_at' => $order->created_at,
            ],
        ]);
    }

    public function checkout(Request $request): JsonResponse
    {
        $cartItems = CartItem::where('user_id', $request->user()->id)
            ->with('game')
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty.'], 422);
        }

        $subtotal = $cartItems->sum(fn($item) => $item->game->effective_price);

        return response()->json([
            'items' => $cartItems->map(fn($item) => [
                'game_id' => $item->game_id,
                'title' => $item->game->title,
                'price' => (float) $item->game->effective_price,
            ]),
            'subtotal' => (float) $subtotal,
        ]);
    }

    public function process(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:credit_card,paypal,wallet',
        ]);

        $cartItems = CartItem::where('user_id', $request->user()->id)
            ->with('game')
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty.'], 422);
        }

        DB::beginTransaction();

        try {
            $total = $cartItems->sum(fn($item) => $item->game->effective_price);

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $request->user()->id,
                'total_amount' => $total,
                'status' => 'completed',
                'payment_method' => $validated['payment_method'],
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'game_id' => $item->game_id,
                    'price' => $item->game->effective_price,
                ]);
            }

            CartItem::where('user_id', $request->user()->id)->delete();

            DB::commit();

            $order->load('items.game');

            return response()->json([
                'message' => 'Order placed successfully!',
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'total_amount' => (float) $order->total_amount,
                    'status' => $order->status,
                    'payment_method' => $order->payment_method,
                    'items' => $order->items->map(fn($item) => [
                        'game_title' => $item->game->title,
                        'price' => (float) $item->price,
                    ]),
                    'created_at' => $order->created_at,
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to process order.'], 500);
        }
    }
}