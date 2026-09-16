<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, string $gameId): JsonResponse
    {
        $game = Game::findOrFail($gameId);

        if (!$this->hasPurchased($request->user()->id, $game->id)) {
            return response()->json([
                'message' => 'You need to purchase this game before leaving a review.',
            ], 403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:2000',
        ]);

        $review = Review::updateOrCreate(
            ['user_id' => $request->user()->id, 'game_id' => $game->id],
            ['rating' => $validated['rating'], 'comment' => $validated['comment']]
        );

        return response()->json([
            'message' => 'Review submitted.',
            'review' => [
                'id' => $review->id,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'user' => ['id' => $review->user->id, 'name' => $review->user->name],
                'created_at' => $review->created_at,
            ],
        ]);
    }

    public function destroy(Request $request, Review $review): JsonResponse
    {
        if ($review->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted.']);
    }

    private function hasPurchased(int $userId, int $gameId): bool
    {
        return Order::where('user_id', $userId)
            ->whereHas('items', fn($q) => $q->where('game_id', $gameId))
            ->exists();
    }
}