<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;

class PaystackService
{

    public function initialize(Order $order): string
    {
        $response = Http::WithToken(config('services.paystack.secret_key'))
            ->post(config('services.paystack.payment_url') . '/transaction/initialize', [
                'email' => $order->user->email,
                'amount' => $order->total * 100,
                'reference' => $order->order_number,
                'callback_url' => route('paystack.callback'),
            ]);

        if (!$response->successful() || !$response->json('status')) {
            throw new \RuntimeException('Paystack initialize failed: ' . $response->json('message', 'Unknown error'));
        }
        return $response->json('data.authorization_url');
    }

    public function verify(string $reference): array
    {
        $response = Http::withToken(config('services.paystack.secret_key'))
            ->get(config('services.paystack.payment_url') . "/transaction/verify/{$reference}");

        return $response->json('data', []);
    }
}
