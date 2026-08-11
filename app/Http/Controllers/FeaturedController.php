<?php

namespace App\Http\Controllers;

use App\Models\Product;

class FeaturedController extends Controller
{
    public function index()
    {
        $products = Product::featured()->inRandomOrder(date('Ymd'))->paginate(20);

        return view('featured', compact('products'));
    }
}