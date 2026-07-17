@extends('layouts.app')

@section('title', 'Order ' . $order->order_number . ' — Quality Gadgets Hub')

@section('content')

    <section class="section" style="padding-bottom:0;">
        <div class="wrap">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="sep">/</span>
                <a href="{{ route('account.orders') }}">My Orders</a>
                <span class="sep">/</span>
                <span class="current">{{ $order->order_number }}</span>
            </nav>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            @if(session('status'))
                <div class="order-success">
                    <x-icon name="check" :size="22" />
                    <div>
                        <strong>Order placed successfully!</strong>
                        <p>We'll send updates to your account as it's processed.</p>
                    </div>
                </div>
            @endif

            <div class="section-head section-head--banner">
                <div>
                    <h2>Order {{ $order->order_number }}</h2>
                    <div class="sub">Placed on {{ $order->created_at->format('d M Y, h:ia') }}</div>
                </div>
                <span class="count-badge">{{ ucfirst($order->status) }}</span>
            </div>

            <div class="cart-layout">
                <div class="cart-items">
                    @foreach($order->items as $item)
                        <div class="cart-row" style="grid-template-columns:1fr auto;">
                            <div class="cart-row-info">
                                <span class="cart-row-title">{{ $item->product_name }}</span>
                                @if($item->color)
                                    <div class="cart-row-color">Color: {{ $item->color }}</div>
                                @endif
                                <div class="cart-row-price mono">&#8358;{{ number_format($item->price) }} &times; {{ $item->quantity }}</div>

                                @if($order->status === 'delivered' && $item->product)
                                    @if(in_array($item->product_id, $reviewedProductIds))
                                        <span class="order-reviewed-tag">&#10003; Reviewed</span>
                                    @else
                                        <a href="{{ route('product.show', $item->product) }}#write-review" class="order-review-link">Leave a review</a>
                                    @endif
                                @endif
                            </div>
                            <div class="cart-row-subtotal mono">&#8358;{{ number_format($item->subtotal) }}</div>
                        </div>
                    @endforeach
                </div>

                <aside class="cart-summary">
                    <h3>Delivery to</h3>
                    <p style="font-size:13.5px;color:var(--ink-soft);line-height:1.6;margin:0 0 18px;">
                        {{ $order->shipping_name }}<br>
                        {{ $order->shipping_phone }}<br>
                        {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_state }}
                    </p>

                    <div class="cart-summary-row"><span>Subtotal</span><span class="mono">&#8358;{{ number_format($order->subtotal) }}</span></div>
                    <div class="cart-summary-row"><span>Delivery ({{ $order->delivery_method === 'door' ? 'Door' : 'Pickup' }})</span><span class="mono">&#8358;{{ number_format($order->delivery_fee) }}</span></div>
                    <div class="cart-summary-row cart-summary-total"><span>Total</span><span class="mono">&#8358;{{ number_format($order->total) }}</span></div>

                    <p style="font-size:12.5px;color:var(--ink-soft);margin-top:16px;">
                        Payment: <strong>{{ match($order->payment_method) { 'pod' => 'Pay on Delivery', 'bank_transfer' => 'Bank Transfer', 'card' => 'Card', 'ussd' => 'USSD' } }}</strong>
                    </p>

                    <a href="{{ route('home') }}#grid" class="cart-continue-link" style="margin-top:16px;">&larr; Continue shopping</a>
                </aside>
            </div>
        </div>
    </section>

@endsection