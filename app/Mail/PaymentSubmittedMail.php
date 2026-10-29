<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
        $this->order->loadMissing('items', 'user');
    }

    public function paymentSubmitted()
    {
        $order = Order::with('items')->latest()->first();

        abort_unless($order, 404, 'No orders exist yet to preview this with.');

        return new PaymentSubmittedMail($order);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order '.$this->order->order_number.' placed — payment verification in progress',
        );
    }

    public function content(): Content
    {
        $number = Setting::get('whatsapp_number', '');
        $message = 'Hi Quality Gadgets Hub, I just paid ₦'.number_format($this->order->total)
            .' for order '.$this->order->order_number.'. Please confirm.';

        return new Content(
            view: 'emails.payment-submitted',
            with: [
                'whatsappUrl' => $number ? "https://wa.me/{$number}?text=".urlencode($message) : null,
            ],
        );
    }
}