@extends('admin.layout')

@section('title', $order->order_number . ' — Admin')

@section('content')
    <div class="admin-header">
        <h1>{{ $order->order_number }}</h1>
    </div>

    <div class="admin-panels">
        <div class="admin-panel">
            <h3>Items</h3>
            @foreach($order->items as $item)
                <div class="admin-panel-row">
                    <span>{{ $item->product_name }} @if($item->color) ({{ $item->color }}) @endif &times; {{ $item->quantity }}</span>
                    <span class="mono">&#8358;{{ number_format($item->subtotal) }}</span>
                </div>
            @endforeach
        </div>

        <div class="admin-panel">
            <h3>Customer &amp; shipping</h3>
            <p>{{ $order->user->name }} &middot; {{ $order->user->email }}</p>
            <p>{{ $order->shipping_name }}<br>{{ $order->shipping_phone }}<br>{{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_state }}</p>

            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="admin-status-form">
                @csrf
                @method('PATCH')
                <label for="status">Status</label>
                <select id="status" name="status">
                    @foreach(['pending','processing','shipped','delivered','cancelled'] as $status)
                        <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        </div>
    </div>
@endsection