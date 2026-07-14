<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(CartService $cart)
    {
        return view('cart', [
            'items' => $cart->items(),
            'subtotal' => $cart->subtotal(),
        ]);
    }

    public function add(Request $request, Product $product, CartService $cart)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1',
            'color' => 'nullable|string',
        ]);

        $cart->add($product, (int) $request->input('quantity', 1), $request->input('color'));

        return back()->with('status', "{$product->name} added to cart.");
    }

    public function buyNow(Request $request, Product $product, CartService $cart)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1',
            'color' => 'nullable|string',
        ]);

        $cart->add($product, (int) $request->input('quantity', 1), $request->input('color'));

        return redirect()->route('cart.show')->with('status', 'Added to cart — continue below to checkout.');
    }

    public function update(Request $request, string $itemKey, CartService $cart)
    {
        $request->validate(['quantity' => 'required|integer|min:0']);

        $cart->updateQuantity($itemKey, (int) $request->input('quantity'));

        return back()->with('status', 'Cart updated.');
    }

    public function remove(string $itemKey, CartService $cart)
    {
        $cart->remove($itemKey);

        return back()->with('status', 'Item removed from cart.');
    }
}