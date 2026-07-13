<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $categoryIds = $category->allDescendantIds();

        $products = Product::whereIn('category_id', $categoryIds)
            ->latest()
            ->paginate(20);

        return view('category', [
            'category'      => $category,
            'subcategories' => $category->children,
            'ancestors'     => $category->ancestors(),
            'products'      => $products,
        ]);
    }
}