<?php

namespace App\Http\Controllers;

use App\Models\EmailSubscriber;

class UnsubscribeController extends Controller
{
    public function show(EmailSubscriber $subscriber)
    {
        return view('unsubscribe', ['subscriber' => $subscriber, 'done' => (bool) $subscriber->unsubscribed_at]);
    }

    public function confirm(EmailSubscriber $subscriber)
    {
        if (! $subscriber->unsubscribed_at) {
            $subscriber->update(['unsubscribed_at' => now()]);
        }

        return view('unsubscribe', ['subscriber' => $subscriber, 'done' => true]);
    }
}