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

        $products = Product::inRandomOrder(date('Ymd'))->paginate(24);
        $flashProducts = Product::onFlashSale()->latest()->take(10)->get();
        $newArrivals   = Product::newArrivals()->latest()->take(10)->get();
        $bestSellers   = Product::orderByDesc('rating')->take(8)->get();
        $heroProduct = $flashProducts->first() ?? $bestSellers->first() ?? $products->first();
    
        $flashEndsAt = $flashProducts->pluck('flash_sale_ends_at')->filter()->sort()->first() ?? now()->addDay();

        return view('home', compact(
            'categories', 'products', 'flashProducts', 'newArrivals',
            'bestSellers', 'flashEndsAt', 'brands', 'heroProduct'
        ));
    }
}