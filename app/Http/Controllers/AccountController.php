<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function show()
    {
        return view('account.show', ['user' => Auth::user()]);
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();

        return view('account.orders', compact('orders'));
    }
}