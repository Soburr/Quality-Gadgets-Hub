<?php

namespace App\Http\Controllers;

use App\Models\Brand;

class BrandController extends Controller
{
    public function show(Brand $brand)
    {
        $products = $brand->products()->latest()->paginate(20);

        return view('brand', compact('brand', 'products'));
    }
}