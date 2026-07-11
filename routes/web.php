<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Stub — replace with a real CartController@add once you have a Cart/Product model.
Route::post('/cart/add/{product}', function ($product) {
    return back()->with('status', "Added product #{$product} to cart.");
})->name('cart.add');

// Stub — replace with a real CategoryController@show once you have a Category model.
Route::get('/category/{slug}', function ($slug) {
    return "Category page for: {$slug}";
})->name('category.show');
