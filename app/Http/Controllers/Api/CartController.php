<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Game;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $items = CartItem::where('user_id', $request->user()->id)
            ->with('game.genres')
            ->get();

        $subtotal = $items->sum(fn($item) => $item->game->effective_price);

        return response()->json([
            'items' => $items->map(fn($item) => [
                'id' => $item->id,
                'game_id' => $item->game_id,
                'game' => [
                    'id' => $item->game->id,
                    'title' => $item->game->title,
                    'slug' => $item->game->slug,
                    'price' => (float) $item->game->price,
                    'discount_price' => $item->game->discount_price ? (float) $item->game->discount_price : null,
                    'effective_price' => (float) $item->game->effective_price,
                    'cover_image' => $item->game->cover_image,
                    'developer' => $item->game->developer,
                ],
                'added_at' => $item->created_at,
            ]),
            'count' => $items->count(),
            'subtotal' => (float) $subtotal,
        ]);
    }

    public function add(Request $request, string $gameId): JsonResponse
    {
        $game = Game::active()->findOrFail($gameId);

        $cartItem = CartItem::firstOrCreate([
            'user_id' => $request->user()->id,
            'game_id' => $game->id,
        ]);

        $isNew = $cartItem->wasRecentlyCreated;

        return response()->json([
            'message' => $isNew ? "'{$game->title}' added to cart." : "'{$game->title}' is already in your cart.",
            'item' => [
                'id' => $cartItem->id,
                'game_id' => $cartItem->game_id,
            ],
        ]);
    }

    public function remove(Request $request, string $cartItemId): JsonResponse
    {
        $cartItem = CartItem::where('user_id', $request->user()->id)
            ->with('game')
            ->findOrFail($cartItemId);

        $cartItem->delete();

        return response()->json(['message' => "'{$cartItem->game->title}' removed from cart."]);
    }

    public function clear(Request $request): JsonResponse
    {
        CartItem::where('user_id', $request->user()->id)->delete();

        return response()->json(['message' => 'Cart cleared.']);
    }
}