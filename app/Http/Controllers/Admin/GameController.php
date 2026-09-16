<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Genre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GameController extends Controller
{
    public function index(): View
    {
        $games = Game::with('genres')->latest()->paginate(15);

        return view('admin.games.index', compact('games'));
    }

    public function create(): View
    {
        $genres = Genre::all();

        return view('admin.games.create', compact('genres'));
    }

    public function store(Request $request): RedirectResponse
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
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
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

        if (isset($validated['genres'])) {
            $game->genres()->sync($validated['genres']);
        }

        return redirect()->route('admin.games.index')
            ->with('success', 'Game "' . $game->title . '" created successfully.');
    }

    public function edit(Game $game): View
    {
        $genres = Genre::all();

        return view('admin.games.edit', compact('game', 'genres'));
    }

    public function update(Request $request, Game $game): RedirectResponse
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
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
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

        if (isset($validated['genres'])) {
            $game->genres()->sync($validated['genres']);
        } else {
            $game->genres()->detach();
        }

        return redirect()->route('admin.games.index')
            ->with('success', 'Game "' . $game->title . '" updated successfully.');
    }

    public function destroy(Game $game): RedirectResponse
    {
        $game->delete();

        return redirect()->route('admin.games.index')
            ->with('success', 'Game deleted successfully.');
    }
}