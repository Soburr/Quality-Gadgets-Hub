<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use App\Mail\OrderStatusUpdatedMail;
use Illuminate\Support\Facades\Mail;
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

    public function cancel(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);
        abort_unless($this->isCancellable($order), 400, 'This order can no longer be cancelled.');

        $order->update(['status' => 'cancelled']);

        Mail::to($order->user)->queue(new OrderStatusUpdatedMail($order));

        return back()->with('status', 'Your order has been cancelled.');
    }

    private function isCancellable(Order $order): bool
    {
        return $order->status === 'pending' && $order->payment_status !== 'paid';
    }
}