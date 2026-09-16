<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->with('games')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order): View
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        $order->load('items.game', 'games');

        return view('orders.show', compact('order'));
    }

    public function checkout(Request $request): View
    {
        $cartItems = CartItem::where('user_id', $request->user()->id)
            ->with('game')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->game->effective_price;
        });

        return view('orders.checkout', compact('cartItems', 'subtotal'));
    }

    public function process(Request $request): RedirectResponse
    {
        $request->validate([
            'payment_method' => 'required|in:credit_card,paypal,wallet',
        ]);

        $cartItems = CartItem::where('user_id', $request->user()->id)
            ->with('game')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            $total = $cartItems->sum(function ($item) {
                return $item->game->effective_price;
            });

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $request->user()->id,
                'total_amount' => $total,
                'status' => 'completed',
                'payment_method' => $request->payment_method,
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

            return redirect()->route('orders.show', $order)
                ->with('success', 'Your order has been placed successfully! Order number: ' . $order->order_number);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')
                ->with('error', 'Something went wrong. Please try again.');
        }
    }
}