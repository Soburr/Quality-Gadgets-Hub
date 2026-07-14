<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');

Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.show');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{itemKey}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{itemKey}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/checkout/buy-now/{product}', [CartController::class, 'buyNow'])->name('checkout.buyNow');

// Stub — replace with a real CheckoutController once payment/shipping is wired up.
Route::get('/checkout', function () {
    return 'Checkout page not built yet.';
})->name('checkout.show');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');
    Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
});