<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Genre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Game::active()->with('genres');

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('developer', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%");
            });
        }

        if ($request->has('genre') && $request->genre !== '') {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('slug', $request->genre);
            });
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low': $query->orderBy('price'); break;
                case 'price_high': $query->orderByDesc('price'); break;
                case 'name': $query->orderBy('title'); break;
                case 'newest': $query->orderByDesc('release_date'); break;
                case 'rating':
                    $query->withCount('reviews')
                          ->withAvg('reviews', 'rating')
                          ->orderByDesc('reviews_avg_rating');
                    break;
                default: $query->latest();
            }
        } else {
            $query->latest();
        }

        $games = $query->paginate($request->input('per_page', 20));

        return response()->json($games);
    }

    public function show(string $slug): JsonResponse
    {
        $game = Game::active()
            ->where('slug', $slug)
            ->with(['genres', 'reviews.user'])
            ->firstOrFail();

        return response()->json([
            'game' => $this->gameArray($game),
            'related' => Game::active()
                ->where('id', '!=', $game->id)
                ->whereHas('genres', fn($q) => $q->whereIn('genres.id', $game->genres->pluck('id')))
                ->with('genres')
                ->take(4)
                ->get()
                ->map(fn($g) => $this->gameArray($g)),
        ]);
    }

    public function newReleases(): JsonResponse
    {
        $games = Game::active()->with('genres')->orderByDesc('release_date')->paginate(20);
        return response()->json($games);
    }

    public function deals(): JsonResponse
    {
        $games = Game::active()->with('genres')
            ->whereNotNull('discount_price')
            ->whereColumn('discount_price', '<', 'price')
            ->orderByDesc('discount_price')
            ->paginate(20);
        return response()->json($games);
    }

    public function genres(): JsonResponse
    {
        $genres = Genre::withCount('games')->orderBy('name')->get();
        return response()->json(['genres' => $genres]);
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
            'effective_price' => (float) $game->effective_price,
            'is_discounted' => $game->is_discounted,
            'discount_percent' => $game->discount_percent,
            'cover_image' => $game->cover_image,
            'publisher' => $game->publisher,
            'developer' => $game->developer,
            'release_date' => $game->release_date->format('Y-m-d'),
            'featured' => $game->featured,
            'status' => $game->status,
            'average_rating' => $game->average_rating,
            'reviews_count' => $game->reviews_count ?? $game->reviews()->count(),
            'genres' => $game->genres->map(fn($g) => [
                'id' => $g->id,
                'name' => $g->name,
                'slug' => $g->slug,
            ]),
            'reviews' => $game->reviews->map(fn($r) => [
                'id' => $r->id,
                'rating' => $r->rating,
                'comment' => $r->comment,
                'user' => ['id' => $r->user->id, 'name' => $r->user->name],
                'created_at' => $r->created_at,
            ]),
            'created_at' => $game->created_at,
            'updated_at' => $game->updated_at,
        ];
    }
}