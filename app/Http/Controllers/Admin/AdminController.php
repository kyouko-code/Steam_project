<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Order;
use App\Models\User;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $gameCount = Game::count();
        $orderCount = Order::count();
        $userCount = User::count();
        $revenue = Order::where('status', 'completed')->sum('total_amount');

        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $recentGames = Game::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'gameCount',
            'orderCount',
            'userCount',
            'revenue',
            'recentOrders',
            'recentGames'
        ));
    }
}