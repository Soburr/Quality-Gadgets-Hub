<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        return view('order', ['order' => $order->load('items')]);
    }
}