<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    public function dashboard(): JsonResponse
    {
        return response()->json([
            'stats' => [
                'total_games' => Game::count(),
                'total_orders' => Order::count(),
                'total_users' => User::count(),
                'total_revenue' => (float) Order::where('status', 'completed')->sum('total_amount'),
            ],
            'recent_orders' => Order::with('user')->latest()->take(5)->get()->map(fn($o) => [
                'id' => $o->id,
                'order_number' => $o->order_number,
                'total_amount' => (float) $o->total_amount,
                'user' => ['name' => $o->user->name],
                'created_at' => $o->created_at,
            ]),
            'recent_games' => Game::latest()->take(5)->get()->map(fn($g) => [
                'id' => $g->id,
                'title' => $g->title,
                'developer' => $g->developer,
                'featured' => $g->featured,
            ]),
        ]);
    }
}