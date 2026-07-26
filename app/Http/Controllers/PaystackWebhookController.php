<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaystackWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Confirms this request genuinely came from Paystack — without this
        // check, anyone could POST a fake "payment successful" event and
        // mark any order as paid for free.
        $signature = $request->header('x-paystack-signature');
        $expected = hash_hmac('sha512', $request->getContent(), config('services.paystack.secret_key'));

        if (! $signature || ! hash_equals($expected, $signature)) {
            Log::warning('Paystack webhook: invalid signature.');
            return response()->json(['status' => 'invalid signature'], 401);
        }

        $payload = $request->input();
        $event = $payload['event'] ?? null;

        if ($event === 'charge.success') {
            $this->handleChargeSuccess($payload['data'] ?? []);
        }

        // Paystack just needs a 200 to know we received it — it doesn't
        // care about the response body.
        return response()->json(['status' => 'received']);
    }

    private function handleChargeSuccess(array $data): void
    {
        $reference = $data['reference'] ?? null;

        if (! $reference) {
            return;
        }

        $order = Order::where('order_number', $reference)->first();

        if (! $order) {
            Log::warning("Paystack webhook: no order found for reference {$reference}.");
            return;
        }

        // Idempotency guard — Paystack can send the same webhook more than
        // once (retries on their end, or if this arrives around the same
        // time as the browser callback). Without this check, a duplicate
        // event would re-send the confirmation email.
        if ($order->payment_status === 'paid') {
            return;
        }

        $order->update([
            'payment_status' => 'paid',
            'payment_reference' => $reference,
            'status' => 'processing',
        ]);

        Mail::to($order->user)->send(new OrderConfirmationMail($order));
    }
}