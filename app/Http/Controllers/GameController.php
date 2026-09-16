<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GameController extends Controller
{
    public function index(Request $request): View
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
                case 'price_low':
                    $query->orderBy('price');
                    break;
                case 'price_high':
                    $query->orderByDesc('price');
                    break;
                case 'name':
                    $query->orderBy('title');
                    break;
                case 'rating':
                    $query->withCount('reviews')
                          ->withAvg('reviews', 'rating')
                          ->orderByDesc('reviews_avg_rating');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $games = $query->paginate(12)->withQueryString();
        $genres = Genre::all();
        $currentGenre = $request->genre ?? null;

        return view('games.index', compact('games', 'genres', 'currentGenre'));
    }

    public function newReleases(Request $request): View
    {
        $games = Game::active()
            ->with('genres')
            ->orderByDesc('release_date')
            ->paginate(12)
            ->withQueryString();

        $genres = Genre::all();
        $currentGenre = null;

        return view('games.index', compact('games', 'genres', 'currentGenre'));
    }

    public function deals(Request $request): View
    {
        $games = Game::active()
            ->with('genres')
            ->whereNotNull('discount_price')
            ->whereColumn('discount_price', '<', 'price')
            ->orderByDesc('discount_price')
            ->paginate(12)
            ->withQueryString();

        $genres = Genre::all();
        $currentGenre = null;

        return view('games.index', compact('games', 'genres', 'currentGenre'));
    }

    public function genres(): View
    {
        $genres = Genre::withCount('games')->orderBy('name')->get();

        return view('genres.index', compact('genres'));
    }

    public function show(string $slug): View
    {
        $game = Game::active()
            ->where('slug', $slug)
            ->with(['genres', 'reviews.user'])
            ->firstOrFail();

        $relatedGames = Game::active()
            ->where('id', '!=', $game->id)
            ->whereHas('genres', function ($q) use ($game) {
                $q->whereIn('genres.id', $game->genres->pluck('id'));
            })
            ->with('genres')
            ->take(4)
            ->get();

        return view('games.show', compact('game', 'relatedGames'));
    }
}