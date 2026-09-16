<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredGames = Game::active()->featured()->with('genres')->latest()->take(6)->get();
        $recentGames = Game::active()->with('genres')->latest()->take(8)->get();
        $genres = Genre::withCount('games')->get();

        return view('home', compact('featuredGames', 'recentGames', 'genres'));
    }
}