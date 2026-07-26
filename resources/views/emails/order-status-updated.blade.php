<x-email-layout>

<p style="margin:0 0 16px;font-size:16px;color:#20141A;">Hi {{ $order->shipping_name }},</p>

<p style="margin:0 0 20px;font-size:14px;line-height:1.6;color:#20141A;">
Your order <strong>{{ $order->order_number }}</strong> has been updated to:
</p>

<table role="presentation" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
<tr>
<td style="background-color:#FCE6EC;border-radius:999px;padding:10px 20px;">
<span style="font-size:14px;font-weight:bold;color:#8C0027;text-transform:uppercase;letter-spacing:0.05em;">{{ $order->status }}</span>
</td>
</tr>
</table>

@if($order->status === 'shipped')
<p style="margin:0 0 20px;font-size:14px;line-height:1.6;color:#20141A;">Your order is on its way to {{ $order->shipping_city }}, {{ $order->shipping_state }}.</p>
@elseif($order->status === 'delivered')
<p style="margin:0 0 20px;font-size:14px;line-height:1.6;color:#20141A;">Your order has been delivered. We'd love to hear what you think — leave a review on the products you bought!</p>
@elseif($order->status === 'cancelled')
<p style="margin:0 0 20px;font-size:14px;line-height:1.6;color:#20141A;">This order has been cancelled. If this wasn't expected, please reach out to our support team.</p>
@endif

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