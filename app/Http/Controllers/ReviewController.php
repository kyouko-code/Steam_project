<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, string $gameId): RedirectResponse
    {
        $game = Game::findOrFail($gameId);

        if (!$this->hasPurchased($request->user()->id, $game->id)) {
            return redirect()->route('games.show', $game->slug)
                ->with('error', 'You need to purchase this game before leaving a review.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:2000',
        ]);

        Review::updateOrCreate(
            ['user_id' => $request->user()->id, 'game_id' => $game->id],
            ['rating' => $validated['rating'], 'comment' => $validated['comment']]
        );

        return redirect()->route('games.show', $game->slug)
            ->with('success', 'Your review has been submitted!');
    }

    public function destroy(Request $request, Review $review): RedirectResponse
    {
        if ($review->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            abort(403);
        }

        $gameSlug = $review->game->slug;
        $review->delete();

        return redirect()->route('games.show', $gameSlug)
            ->with('success', 'Review deleted successfully.');
    }

    private function hasPurchased(int $userId, int $gameId): bool
    {
        return Order::where('user_id', $userId)
            ->whereHas('items', function ($q) use ($gameId) {
                $q->where('game_id', $gameId);
            })
            ->exists();
    }
}