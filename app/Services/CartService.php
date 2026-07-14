<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected string $sessionKey = 'cart';

    public function add(Product $product, int $quantity = 1, ?string $color = null): void
    {
        $cart = $this->raw();
        $key = $this->makeKey($product->id, $color);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'color' => $color,
            ];
        }

        Session::put($this->sessionKey, $cart);
    }

    public function updateQuantity(string $itemKey, int $quantity): void
    {
        $cart = $this->raw();

        if (!isset($cart[$itemKey])) {
            return;
        }

        if ($quantity < 1) {
            unset($cart[$itemKey]);
        } else {
            $cart[$itemKey]['quantity'] = $quantity;
        }

        Session::put($this->sessionKey, $cart);
    }

    public function remove(string $itemKey): void
    {
        $cart = $this->raw();
        unset($cart[$itemKey]);
        Session::put($this->sessionKey, $cart);
    }

    public function raw(): array
    {
        return Session::get($this->sessionKey, []);
    }

    public function items(): Collection
    {
        $cart = $this->raw();

        if (empty($cart)) {
            return collect();
        }

        $productIds = collect($cart)->pluck('product_id')->unique();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        return collect($cart)
            ->map(function ($row, $key) use ($products) {
                $product = $products->get($row['product_id']);

                if (!$product) {
                    return null;
                }

                return (object) [
                    'key' => $key,
                    'product' => $product,
                    'quantity' => $row['quantity'],
                    'color' => $row['color'],
                    'subtotal' => $product->price * $row['quantity'],
                ];
            })
            ->filter()
            ->values();
    }

    public function count(): int
    {
        return collect($this->raw())->sum('quantity');
    }

    public function subtotal(): int
    {
        return $this->items()->sum('subtotal');
    }

    public function clear(): void
    {
        Session::forget($this->sessionKey);
    }

    private function makeKey(int $productId, ?string $color): string
    {
        return md5($productId . '|' . ($color ?? ''));
    }
}