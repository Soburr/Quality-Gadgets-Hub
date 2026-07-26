<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmationMail;
use App\Mail\OrderStatusUpdatedMail;
use App\Mail\WelcomeMail;
use App\Models\Order;
use App\Models\User;

class MailPreviewController extends Controller
{
    public function welcome()
    {
        $user = User::first() ?? new User(['name' => 'Test User', 'email' => 'test@example.com']);

        return new WelcomeMail($user);
    }

    public function orderConfirmation()
    {
        $order = Order::with('items')->latest()->first();

        abort_unless($order, 404, 'No orders exist yet to preview this with.');

        return new OrderConfirmationMail($order);
    }

    public function orderStatusUpdated()
    {
        $order = Order::latest()->first();

        abort_unless($order, 404, 'No orders exist yet to preview this with.');

        return new OrderStatusUpdatedMail($order);
    }
}