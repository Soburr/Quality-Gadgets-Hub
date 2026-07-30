<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::topLevel()->orderBy('sort_order')->get();
        $brands = Brand::orderBy('sort_order')->get();

        $products      = Product::latest()->paginate(24);
        $flashProducts = Product::onDeal()->latest()->take(10)->get();
        $newArrivals   = Product::newArrivals()->latest()->take(10)->get();
        $bestSellers   = Product::orderByDesc('rating')->take(8)->get();

        // Countdown target for the flash sale ring — swap for a real column, e.g. Deal::current()->ends_at
        $flashEndsAt = now()->addHours(5)->addMinutes(42)->addSeconds(58);

        return view('home', compact(
            'categories', 'products', 'flashProducts', 'newArrivals',
            'bestSellers', 'flashEndsAt', 'brands'
        ));
    }
}