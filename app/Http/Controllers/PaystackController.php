<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use App\Services\PaystackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PaystackController extends Controller
{
    public function retry(Order $order, PaystackService $paystack)
    {
        abort_unless($order->user_id === Auth::id(), 403);
        abort_unless($order->payment_method === 'pay_now', 400);

        try {
            $authorizationUrl = $paystack->initialize($order);
        } catch (\Throwable $e) {
            report($e);
            return back()->with('status', 'We couldn\'t start the payment — please try again shortly.');
        }

        return redirect($authorizationUrl);
    }

    public function callback(Request $request, PaystackService $paystack)
    {
        $reference = $request->query('reference') ?? $request->query('trxref');

        if (! $reference) {
            return redirect()->route('cart.show')->with('status', 'Payment reference missing.');
        }

        $order = Order::where('order_number', $reference)->firstOrFail();

        abort_unless($order->user_id === Auth::id(), 403);

        $data = $paystack->verify($reference);

        if (($data['status'] ?? null) === 'success') {
            $wasAlreadyPaid = $order->payment_status === 'paid';

            $order->update([
                'payment_status' => 'paid',
                'payment_reference' => $data['reference'] ?? $reference,
                'status' => 'processing',
            ]);

            if (! $wasAlreadyPaid) {
                Mail::to($order->user)->queue(new OrderConfirmationMail($order));
            }

            return redirect()->route('order.show', $order)->with('status', 'Payment successful! Your order is confirmed.');
        }

        $order->update(['payment_status' => 'failed']);

        return redirect()->route('order.show', $order)->with('status', 'Payment was not successful. You can retry payment below.');
    }
}