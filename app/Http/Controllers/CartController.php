<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Game;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cartItems = CartItem::where('user_id', $request->user()->id)
            ->with('game')
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->game->effective_price;
        });

        return view('cart.index', compact('cartItems', 'subtotal'));
    }

    public function add(Request $request, string $gameId): RedirectResponse
    {
        $game = Game::active()->findOrFail($gameId);

        CartItem::firstOrCreate([
            'user_id' => $request->user()->id,
            'game_id' => $game->id,
        ]);

        return redirect()->route('cart.index')
            ->with('success', "'{$game->title}' has been added to your cart.");
    }

    public function remove(Request $request, CartItem $cartItem): RedirectResponse
    {
        if ($cartItem->user_id !== $request->user()->id) {
            abort(403);
        }

        $gameTitle = $cartItem->game->title;
        $cartItem->delete();

        return redirect()->route('cart.index')
            ->with('success', "'{$gameTitle}' has been removed from your cart.");
    }

    public function getCount(Request $request): int
    {
        return CartItem::where('user_id', $request->user()->id)->count();
    }
}