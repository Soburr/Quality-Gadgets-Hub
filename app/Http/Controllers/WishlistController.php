<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\WishlistItem;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $items = WishlistItem::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->get();

        return view('wishlist', compact('items'));
    }

    public function toggle(Product $product)
    {
        $existing = WishlistItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $message = $product->name.' removed from wishlist.';
        } else {
            WishlistItem::create(['user_id' => Auth::id(), 'product_id' => $product->id]);
            $message = $product->name.' added to wishlist.';
        }

        return back()->with('status', $message);
    }
}