<x-email-layout>

<p style="margin:0 0 16px;font-size:16px;color:#20141A;">Hi {{ $order->shipping_name }},</p>

<p style="margin:0 0 20px;font-size:14px;line-height:1.6;color:#20141A;">
Thanks for your order! We've received <strong>{{ $order->order_number }}</strong> and it's being processed.
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #F0DDE2;border-radius:10px;overflow:hidden;margin-bottom:20px;">
@foreach($order->items as $item)
<tr>
<td style="padding:12px 16px;border-bottom:1px solid #F0DDE2;font-size:13px;color:#20141A;">
{{ $item->product_name }} @if($item->color) ({{ $item->color }}) @endif &times; {{ $item->quantity }}
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

<p style="margin:0 0 4px;font-size:13px;font-weight:bold;color:#20141A;">Delivering to:</p>
<p style="margin:0 0 20px;font-size:13px;line-height:1.6;color:#6b5860;">
{{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_state }}<br>
{{ $order->shipping_phone }}
</p>

<table role="presentation" cellpadding="0" cellspacing="0">
<tr>
<td style="background-color:#C40356;border-radius:10px;">
<a href="{{ route('order.show', $order) }}" style="display:inline-block;padding:14px 28px;font-size:14px;font-weight:bold;color:#FFFFFF;text-decoration:none;">
View Order
</a>
</td>
</tr>
</table>

</x-email-layout>