<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\GameController as AdminGameController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::get('/games/new-releases', [GameController::class, 'newReleases'])->name('games.new-releases');
Route::get('/games/deals', [GameController::class, 'deals'])->name('games.deals');
Route::get('/genres', [GameController::class, 'genres'])->name('games.genres');
Route::get('/games/{slug}', [GameController::class, 'show'])->name('games.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->count();
        return view('dashboard', compact('cartCount'));
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{gameId}', [CartController::class, 'add'])->name('add');
        Route::delete('/remove/{cartItem}', [CartController::class, 'remove'])->name('remove');
    });

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
        Route::post('/process', [OrderController::class, 'process'])->name('process');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    });

    Route::post('/reviews/{gameId}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::resource('games', AdminGameController::class)->except(['show']);
    });
});

require __DIR__.'/auth.php';
