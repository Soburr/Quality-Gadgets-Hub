<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::topLevel()->orderBy('sort_order')->get();

        $products = collect([
            ['name' => 'iPhone 14 Pro Max · 256GB',              'price' => 950000, 'was_price' => 1050000, 'rating' => 4.9, 'reviews_count' => 1820, 'badge' => '-10%',     'image' => null],
            ['name' => 'iPhone 13 · 128GB (UK Used)',            'price' => 420000, 'was_price' => 480000,  'rating' => 4.6, 'reviews_count' => 1340, 'badge' => '-13%',     'image' => null],
            ['name' => 'iPhone 11 · 64GB (UK Used)',             'price' => 265000, 'was_price' => null,    'rating' => 4.3, 'reviews_count' => 980,  'badge' => 'Verified', 'image' => null],
            ['name' => 'iPhone 15 · 128GB',                      'price' => 890000, 'was_price' => null,    'rating' => 4.8, 'reviews_count' => 540,  'badge' => 'New',      'image' => null],
            ['name' => 'Samsung Galaxy S23 Ultra · 256GB',       'price' => 780000, 'was_price' => 860000,  'rating' => 4.8, 'reviews_count' => 1120, 'badge' => '-9%',      'image' => null],
            ['name' => 'Samsung Galaxy A54 5G · 128GB',          'price' => 285000, 'was_price' => 319000,  'rating' => 4.5, 'reviews_count' => 2210, 'badge' => '-11%',     'image' => null],
            ['name' => 'Samsung Galaxy A14 · 64GB',              'price' => 118000, 'was_price' => null,    'rating' => 4.2, 'reviews_count' => 760,  'badge' => 'New',      'image' => null],
            ['name' => 'Samsung Galaxy Z Flip 5 · 256GB',        'price' => 720000, 'was_price' => 799000,  'rating' => 4.7, 'reviews_count' => 410,  'badge' => '-10%',     'image' => null],
            ['name' => 'Redmi Note 13 Pro · 256GB',              'price' => 245000, 'was_price' => 279000,  'rating' => 4.6, 'reviews_count' => 1560, 'badge' => '-12%',     'image' => null],
            ['name' => 'Redmi 12C · 128GB',                      'price' => 89000,  'was_price' => 99000,   'rating' => 4.1, 'reviews_count' => 890,  'badge' => '-10%',     'image' => null],
            ['name' => 'Redmi Note 12 · 128GB',                  'price' => 165000, 'was_price' => null,    'rating' => 4.4, 'reviews_count' => 670,  'badge' => 'Verified', 'image' => null],
            ['name' => 'Tecno Camon 20 · 256GB',                 'price' => 195000, 'was_price' => 219000,  'rating' => 4.3, 'reviews_count' => 540,  'badge' => '-11%',     'image' => null],
            ['name' => 'Infinix Zero 30 5G · 256GB',             'price' => 275000, 'was_price' => null,    'rating' => 4.5, 'reviews_count' => 430,  'badge' => 'New',      'image' => null],
            ['name' => 'Apple AirPods Pro (2nd Gen)',            'price' => 165000, 'was_price' => 189000,  'rating' => 4.9, 'reviews_count' => 2040, 'badge' => '-13%',     'image' => null],
            ['name' => 'Samsung Galaxy Buds2 Pro',               'price' => 98000,  'was_price' => null,    'rating' => 4.6, 'reviews_count' => 610,  'badge' => 'Verified', 'image' => null],
            ['name' => 'JBL Flip 6 Bluetooth Speaker',           'price' => 89000,  'was_price' => 99000,   'rating' => 4.7, 'reviews_count' => 780,  'badge' => '-10%',     'image' => null],
            ['name' => 'Anker 20000mAh Power Bank',              'price' => 32000,  'was_price' => 38000,   'rating' => 4.5, 'reviews_count' => 1220, 'badge' => '-16%',     'image' => null],
            ['name' => 'MacBook Air M1 · 256GB',                 'price' => 890000, 'was_price' => 950000,  'rating' => 4.9, 'reviews_count' => 340,  'badge' => '-6%',      'image' => null],
            ['name' => 'HP Pavilion 15 · Core i5 · 512GB SSD',   'price' => 520000, 'was_price' => null,    'rating' => 4.4, 'reviews_count' => 210,  'badge' => 'New',      'image' => null],
            ['name' => 'Lenovo ThinkPad E14 · Core i7',          'price' => 610000, 'was_price' => 690000,  'rating' => 4.6, 'reviews_count' => 190,  'badge' => '-12%',     'image' => null],
        ])->map(fn ($p) => (object) $p);

        $flashProducts = $products->filter(fn ($p) => $p->was_price)->values();
        $newArrivals   = $products->filter(fn ($p) => $p->badge === 'New')->values();
        $bestSellers   = $products->sortByDesc('rating')->take(8)->values();

        // Countdown target for the flash sale ring — swap for a real column, e.g. Deal::current()->ends_at
        $flashEndsAt = now()->addHours(5)->addMinutes(42)->addSeconds(58);

        $cartCount = session('cart_count', 3);

        return view('home', compact(
            'categories', 'products', 'flashProducts', 'newArrivals',
            'bestSellers', 'flashEndsAt', 'cartCount'
        ));
    }
}