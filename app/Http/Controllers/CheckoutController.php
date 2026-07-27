<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use App\Services\PaystackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Setting;

class CheckoutController extends Controller
{
    public function show(CartService $cart)
    {
        $items = $cart->items();

        if ($items->isEmpty()) {
            return redirect()->route('cart.show')->with('status', 'Your cart is empty — add something before checking out.');
        }

        return view('checkout', [
            'items' => $items,
            'subtotal' => $cart->subtotal(),
            'user' => Auth::user(),
            'doorFee' => (int) Setting::get('delivery_fee_door', 1550),
            'pickupFee' => (int) Setting::get('delivery_fee_pickup', 750),
        ]);
    }

    public function store(Request $request, CartService $cart, PaystackService $paystack)
    {
        $items = $cart->items();

        if ($items->isEmpty()) {
            return redirect()->route('cart.show')->with('status', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:255',
            'shipping_state' => 'required|string|max:255',
            'delivery_method' => 'required|in:door,pickup',
            'payment_method' => 'required|in:pod,pay_now',
        ]);

        $subtotal = $cart->subtotal();
        $doorFee = (int) Setting::get('delivery_fee_door', 1550);
        $pickupFee = (int) Setting::get('delivery_fee_pickup', 750);
        $deliveryFee = $validated['delivery_method'] === 'door' ? $doorFee : $pickupFee;

        $order = DB::transaction(function () use ($validated, $items, $subtotal, $deliveryFee) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'unpaid',
                'delivery_method' => $validated['delivery_method'],
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $subtotal + $deliveryFee,
                'shipping_name' => $validated['shipping_name'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_state' => $validated['shipping_state'],
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'color' => $item->color,
                    'subtotal' => $item->subtotal,
                ]);
            }

            return $order;
        });

        $cart->clear();

        if ($validated['payment_method'] === 'pay_now') {
            try {
                $authorizationUrl = $paystack->initialize($order);
            } catch (\Throwable $e) {
                report($e);
                return redirect()->route('order.show', $order)
                    ->with('status', "We couldn't start the payment — you can retry from this page.");
            }

            return redirect($authorizationUrl);
        }

        Mail::to($order->user)->queue(new OrderConfirmationMail($order));

        return redirect()->route('order.show', $order)->with('status', 'Order placed successfully!');
    }
}