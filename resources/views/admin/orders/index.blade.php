@extends('admin.layout')

@section('title', 'Orders — Admin')

@section('content')
    <div class="admin-header">
        <h1>Orders</h1>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Placed</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td class="mono">&#8358;{{ number_format($order->total) }}</td>
                        <td><span class="admin-badge admin-badge--{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td class="admin-table-actions">
                            <a href="{{ route('admin.orders.show', $order) }}">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="admin-empty">No orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div class="pager">
            @if($orders->previousPageUrl())
                <a href="{{ $orders->previousPageUrl() }}" class="pager-btn">&larr; Prev</a>
            @endif
            <span class="pager-info">Page {{ $orders->currentPage() }} of {{ $orders->lastPage() }}</span>
            @if($orders->nextPageUrl())
                <a href="{{ $orders->nextPageUrl() }}" class="pager-btn">Next &rarr;</a>
            @endif
        </div>
    @endif
@endsection