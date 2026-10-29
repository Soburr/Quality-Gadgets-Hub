<x-email-layout>

@php
    $deliveryLabel = match(true) {
        $order->delivery_method === 'store_pickup' => 'Store Pickup (Free)',
        $order->delivery_method === 'courier' => 'Courier Delivery',
        $order->shipping_state === 'Lagos' => 'Doorstep Delivery (Lagos)',
        default => 'Park Pickup',
    };
@endphp

<p style="margin:0 0 16px;font-size:16px;color:#20141A;">Hi {{ $order->shipping_name }},</p>

<p style="margin:0 0 6px;font-size:18px;font-weight:bold;color:#20141A;">Your order has been placed successfully</p>
<p style="margin:0 0 20px;font-size:14px;line-height:1.6;color:#20141A;">
Thank you for shopping with Quality Gadgets Hub. Kindly hold on for a few minutes while our admins verify your payment. Once it's confirmed, your order moves to <strong>Processing</strong>.
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#FCEFD2;border:1px solid #F0D9A0;border-radius:10px;margin-bottom:24px;">
<tr>
<td style="padding:14px 16px;font-size:13px;line-height:1.6;color:#8A5F00;">
<strong>Payment verification in progress.</strong> There's nothing else you need to do. If it's taking longer than expected, use the WhatsApp button below and we'll sort it out.
</td>
</tr>
</table>

<p style="margin:0 0 8px;font-size:12px;font-weight:bold;letter-spacing:0.04em;text-transform:uppercase;color:#6b5860;">Your details</p>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #F0DDE2;border-radius:10px;margin-bottom:24px;">
<tr>
<td style="padding:10px 16px;border-bottom:1px solid #F0DDE2;font-size:13px;color:#6b5860;width:110px;">Name</td>
<td style="padding:10px 16px;border-bottom:1px solid #F0DDE2;font-size:13px;color:#20141A;">{{ $order->shipping_name }}</td>
</tr>
<tr>
<td style="padding:10px 16px;border-bottom:1px solid #F0DDE2;font-size:13px;color:#6b5860;">Email</td>
<td style="padding:10px 16px;border-bottom:1px solid #F0DDE2;font-size:13px;color:#20141A;">{{ $order->user->email }}</td>
</tr>
<tr>
<td style="padding:10px 16px;border-bottom:1px solid #F0DDE2;font-size:13px;color:#6b5860;">Phone</td>
<td style="padding:10px 16px;border-bottom:1px solid #F0DDE2;font-size:13px;color:#20141A;">{{ $order->shipping_phone }}</td>
</tr>
<tr>
<td style="padding:10px 16px;font-size:13px;color:#6b5860;vertical-align:top;">Address</td>
<td style="padding:10px 16px;font-size:13px;line-height:1.5;color:#20141A;">{{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_state }}</td>
</tr>
</table>

<p style="margin:0 0 8px;font-size:12px;font-weight:bold;letter-spacing:0.04em;text-transform:uppercase;color:#6b5860;">Order details</p>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #F0DDE2;border-radius:10px;margin-bottom:16px;">
<tr>
<td style="padding:10px 16px;border-bottom:1px solid #F0DDE2;font-size:13px;color:#6b5860;width:110px;">Order no.</td>
<td style="padding:10px 16px;border-bottom:1px solid #F0DDE2;font-size:13px;font-weight:bold;color:#20141A;">{{ $order->order_number }}</td>
</tr>
<tr>
<td style="padding:10px 16px;border-bottom:1px solid #F0DDE2;font-size:13px;color:#6b5860;">Placed</td>
<td style="padding:10px 16px;border-bottom:1px solid #F0DDE2;font-size:13px;color:#20141A;">{{ $order->created_at->format('d M Y, h:ia') }}</td>
</tr>
<tr>
<td style="padding:10px 16px;border-bottom:1px solid #F0DDE2;font-size:13px;color:#6b5860;">Delivery</td>
<td style="padding:10px 16px;border-bottom:1px solid #F0DDE2;font-size:13px;color:#20141A;">{{ $deliveryLabel }}</td>
</tr>
<tr>
<td style="padding:10px 16px;font-size:13px;color:#6b5860;">Payment</td>
<td style="padding:10px 16px;font-size:13px;color:#20141A;">Bank transfer &middot; awaiting verification</td>
</tr>
</table>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #F0DDE2;border-radius:10px;margin-bottom:24px;">
@foreach($order->items as $item)
<tr>
<td style="padding:12px 16px;border-bottom:1px solid #F0DDE2;font-size:13px;color:#20141A;">
{{ $item->product_name }}@if($item->color) ({{ $item->color }})@endif @if($item->storage)&middot; {{ $item->storage }} @endif&times; {{ $item->quantity }}
</td>
<td style="padding:12px 16px;border-bottom:1px solid #F0DDE2;font-size:13px;color:#8C0027;text-align:right;white-space:nowrap;">
&#8358;{{ number_format($item->subtotal) }}
</td>
</tr>
@endforeach
<tr>
<td style="padding:12px 16px;font-size:13px;color:#6b5860;">Subtotal</td>
<td style="padding:12px 16px;font-size:13px;color:#20141A;text-align:right;">&#8358;{{ number_format($order->subtotal) }}</td>
</tr>
<tr>
<td style="padding:12px 16px;font-size:13px;color:#6b5860;">Delivery</td>
<td style="padding:12px 16px;font-size:13px;color:#20141A;text-align:right;">&#8358;{{ number_format($order->delivery_fee) }}</td>
</tr>
<tr>
<td style="padding:12px 16px;font-size:14px;font-weight:bold;color:#20141A;background-color:#FFF8F6;">Total</td>
<td style="padding:12px 16px;font-size:14px;font-weight:bold;color:#8C0027;text-align:right;background-color:#FFF8F6;">&#8358;{{ number_format($order->total) }}</td>
</tr>
</table>

@if($order->customer_note)
<p style="margin:0 0 4px;font-size:13px;font-weight:bold;color:#20141A;">Your note:</p>
<p style="margin:0 0 24px;font-size:13px;line-height:1.6;color:#6b5860;">{!! nl2br(e($order->customer_note)) !!}</p>
@endif

@if($whatsappUrl)
<table role="presentation" cellpadding="0" cellspacing="0" style="margin-bottom:12px;">
<tr>
<td style="background-color:#1E7A4C;border-radius:10px;">
<a href="{{ $whatsappUrl }}" style="display:inline-block;padding:14px 28px;font-size:14px;font-weight:bold;color:#FFFFFF;text-decoration:none;">
Chat admin on WhatsApp
</a>
</td>
</tr>
</table>
@endif

<table role="presentation" cellpadding="0" cellspacing="0">
<tr>
<td style="border:1.5px solid #8C0027;border-radius:10px;">
<a href="{{ route('order.show', $order) }}" style="display:inline-block;padding:12px 26px;font-size:14px;font-weight:bold;color:#8C0027;text-decoration:none;">
View Order
</a>
</td>
</tr>
</table>

</x-email-layout>