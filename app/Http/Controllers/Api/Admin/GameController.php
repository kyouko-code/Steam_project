<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Genre;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GameController extends Controller
{
    public function index(): JsonResponse
    {
        $games = Game::with('genres')->latest()->paginate(15);

        $games->getCollection()->transform(fn($game) => [
            'id' => $game->id,
            'title' => $game->title,
            'slug' => $game->slug,
            'price' => (float) $game->price,
            'discount_price' => $game->discount_price ? (float) $game->discount_price : null,
            'featured' => $game->featured,
            'status' => $game->status,
            'developer' => $game->developer,
            'genres' => $game->genres->map(fn($g) => ['id' => $g->id, 'name' => $g->name]),
            'created_at' => $game->created_at,
        ]);

        return response()->json($games);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'cover_image' => 'nullable|url|max:500',
            'publisher' => 'required|string|max:255',
            'developer' => 'required|string|max:255',
            'release_date' => 'required|date',
            'featured' => 'sometimes|boolean',
            'status' => 'required|in:active,inactive',
            'genre_ids' => 'nullable|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        $game = Game::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . uniqid(),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'discount_price' => $validated['discount_price'] ?? null,
            'cover_image' => $validated['cover_image'] ?? null,
            'publisher' => $validated['publisher'],
            'developer' => $validated['developer'],
            'release_date' => $validated['release_date'],
            'featured' => $request->boolean('featured'),
            'status' => $validated['status'],
        ]);

        if (isset($validated['genre_ids'])) {
            $game->genres()->sync($validated['genre_ids']);
        }

        return response()->json([
            'message' => 'Game created.',
            'game' => $this->gameArray($game->load('genres')),
        ], 201);
    }

    public function update(Request $request, Game $game): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'cover_image' => 'nullable|url|max:500',
            'publisher' => 'required|string|max:255',
            'developer' => 'required|string|max:255',
            'release_date' => 'required|date',
            'featured' => 'sometimes|boolean',
            'status' => 'required|in:active,inactive',
            'genre_ids' => 'nullable|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        $game->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'discount_price' => $validated['discount_price'] ?? null,
            'cover_image' => $validated['cover_image'] ?? null,
            'publisher' => $validated['publisher'],
            'developer' => $validated['developer'],
            'release_date' => $validated['release_date'],
            'featured' => $request->boolean('featured'),
            'status' => $validated['status'],
        ]);

        if (isset($validated['genre_ids'])) {
            $game->genres()->sync($validated['genre_ids']);
        }

        return response()->json([
            'message' => 'Game updated.',
            'game' => $this->gameArray($game->load('genres')),
        ]);
    }

    public function destroy(Game $game): JsonResponse
    {
        $game->delete();

        return response()->json(['message' => 'Game deleted.']);
    }

    public function allOrders(): JsonResponse
    {
        $orders = Order::with('user', 'items.game')->latest()->paginate(15);

        $orders->getCollection()->transform(fn($order) => [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'total_amount' => (float) $order->total_amount,
            'status' => $order->status,
            'payment_method' => $order->payment_method,
            'user' => ['id' => $order->user->id, 'name' => $order->user->name],
            'items' => $order->items->map(fn($item) => [
                'game_title' => $item->game->title,
                'price' => (float) $item->price,
            ]),
            'created_at' => $order->created_at,
        ]);

        return response()->json($orders);
    }

    private function gameArray(Game $game): array
    {
        return [
            'id' => $game->id,
            'title' => $game->title,
            'slug' => $game->slug,
            'description' => $game->description,
            'price' => (float) $game->price,
            'discount_price' => $game->discount_price ? (float) $game->discount_price : null,
            'cover_image' => $game->cover_image,
            'publisher' => $game->publisher,
            'developer' => $game->developer,
            'release_date' => $game->release_date->format('Y-m-d'),
            'featured' => $game->featured,
            'status' => $game->status,
            'genres' => $game->genres->map(fn($g) => ['id' => $g->id, 'name' => $g->name]),
            'created_at' => $game->created_at,
        ];
    }
}