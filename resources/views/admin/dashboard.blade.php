@extends('admin.layout')

@section('title', 'Dashboard — Admin')

@section('content')
    <div class="admin-header">
        <h1>Dashboard</h1>
    </div>

    <div class="admin-stat-grid">
        <div class="admin-stat-card">
            <span class="admin-stat-label">Products</span>
            <span class="admin-stat-number">{{ $stats['products'] }}</span>
        </div>
        <div class="admin-stat-card">
            <span class="admin-stat-label">Orders</span>
            <span class="admin-stat-number">{{ $stats['orders'] }}</span>
        </div>
        <div class="admin-stat-card">
            <span class="admin-stat-label">Revenue</span>
            <span class="admin-stat-number mono">&#8358;{{ number_format($stats['revenue']) }}</span>
        </div>
        <div class="admin-stat-card">
            <span class="admin-stat-label">Customers</span>
            <span class="admin-stat-number">{{ $stats['customers'] }}</span>
        </div>
    </div>

    <div class="admin-panels">
        <div class="admin-panel">
            <h3>Recent orders</h3>
            @forelse($recentOrders as $order)
                <a href="{{ route('admin.orders.show', $order) }}" class="admin-panel-row">
                    <span>{{ $order->order_number }}</span>
                    <span>{{ $order->user->name }}</span>
                    <span class="mono">&#8358;{{ number_format($order->total) }}</span>
                    <span class="admin-badge admin-badge--{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                </a>
            @empty
                <p class="admin-empty">No orders yet.</p>
            @endforelse
        </div>

        <div class="admin-panel">
            <h3>Low stock</h3>
            @forelse($lowStock as $product)
                <a href="{{ route('admin.products.edit', $product) }}" class="admin-panel-row">
                    <span>{{ $product->name }}</span>
                    <span class="admin-badge admin-badge--low">{{ $product->stock }} left</span>
                </a>
            @empty
                <p class="admin-empty">Nothing low on stock.</p>
            @endforelse
        </div>
    </div>
@endsection