<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\WishlistItem;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $breadcrumbChain = array_merge($product->category->ancestors(), [$product->category]);

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        $reviews = $product->reviews()->latest()->get();
        $ratingBreakdown = $product->ratingBreakdown();

        $inWishlist = Auth::check()
            && WishlistItem::where('user_id', Auth::id())->where('product_id', $product->id)->exists();

        return view('product', compact(
            'product', 'breadcrumbChain', 'related', 'reviews', 'ratingBreakdown', 'inWishlist'
        ));
    }
}