<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        $order->load('items.product');

        $reviewedProductIds = Review::where('user_id', Auth::id())
            ->whereIn('product_id', $order->items->pluck('product_id')->filter())
            ->pluck('product_id')
            ->all();

        return view('order', compact('order', 'reviewedProductIds'));
    }
}