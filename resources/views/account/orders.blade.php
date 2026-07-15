@extends('layouts.app')

@section('title', 'My Orders — Quality Gadgets Hub')

@section('content')
<section class="section">
    <div class="wrap">
        <div class="section-head">
            <div><h2>My Orders</h2><div class="sub">Track and review your past purchases</div></div>
        </div>

        @if($orders->isEmpty())
            <div class="empty-state">
                <p>You haven't placed any orders yet.</p>
                <a href="{{ route('home') }}#grid" class="btn btn-primary" style="margin-top:16px;display:inline-flex;">Start shopping</a>
            </div>
        @else
            <div class="order-list">
                @foreach($orders as $order)
                    <a href="{{ route('order.show', $order) }}" class="order-list-row">
                        <div>
                            <strong>{{ $order->order_number }}</strong>
                            <span class="order-list-date">{{ $order->created_at->format('d M Y') }}</span>
                        </div>
                        <span class="order-list-status">{{ ucfirst($order->status) }}</span>
                        <span class="mono">&#8358;{{ number_format($order->total) }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection