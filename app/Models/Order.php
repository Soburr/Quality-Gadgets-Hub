<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'status', 'payment_method', 'delivery_method',
        'subtotal', 'delivery_fee', 'total',
        'shipping_name', 'shipping_phone', 'shipping_address', 'shipping_city', 'shipping_state',
    ];

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            $order->order_number ??= 'QGH-'.strtoupper(Str::random(8));
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}