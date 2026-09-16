<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Admin\GameController as AdminGameController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/games', [GameController::class, 'index']);
Route::get('/games/new-releases', [GameController::class, 'newReleases']);
Route::get('/games/deals', [GameController::class, 'deals']);
Route::get('/genres', [GameController::class, 'genres']);
Route::get('/games/{slug}', [GameController::class, 'show']);

// Authenticated user routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);

    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add/{gameId}', [CartController::class, 'add']);
    Route::delete('/cart/remove/{cartItemId}', [CartController::class, 'remove']);
    Route::delete('/cart', [CartController::class, 'clear']);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/checkout', [OrderController::class, 'checkout']);
    Route::post('/orders/checkout', [OrderController::class, 'process']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);

    Route::post('/reviews/{gameId}', [ReviewController::class, 'store']);
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);
});

// Admin routes
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->name('api.admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/games', [AdminGameController::class, 'index']);
    Route::post('/games', [AdminGameController::class, 'store']);
    Route::put('/games/{game}', [AdminGameController::class, 'update']);
    Route::delete('/games/{game}', [AdminGameController::class, 'destroy']);
    Route::get('/orders', [AdminGameController::class, 'allOrders']);
});
