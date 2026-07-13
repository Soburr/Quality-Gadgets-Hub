<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');

Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product.show');

// Stub — replace with a real CartController@add once you have a Cart model.
Route::post('/cart/add/{product}', function ($product) {
    return back()->with('status', "Added product #{$product} to cart.");
})->name('cart.add');