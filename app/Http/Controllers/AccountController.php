<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function show()
    {
        return view('account.show', ['user' => Auth::user()]);
    }

    public function orders()
    {
        // Stub — replace with Order::where('user_id', Auth::id())->get() once orders exist.
        return view('account.orders');
    }
}