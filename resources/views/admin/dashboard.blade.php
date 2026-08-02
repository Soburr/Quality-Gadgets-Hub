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

    <div class="admin-panel" style="margin-bottom:24px;">
        <h3>Sales — last 30 days</h3>
        <div class="admin-chart-wrap">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <div class="admin-panels" style="margin-bottom:24px;">
        <div class="admin-panel">
            <h3>Top selling products</h3>
            @forelse($topProducts as $product)
                <div class="admin-panel-row admin-panel-row--products">
                    <span>{{ $product->product_name }}</span>
                    <span>{{ $product->total_qty }} sold</span>
                    <span class="mono">&#8358;{{ number_format($product->total_revenue) }}</span>
                </div>
            @empty
                <p class="admin-empty">No sales yet.</p>
            @endforelse
        </div>

        <div class="admin-panel">
            <h3>Orders by status</h3>
            @foreach($statusBreakdown as $row)
                <div class="admin-panel-row admin-panel-row--status">
                    <span class="admin-badge admin-badge--{{ $row['status'] }}">{{ ucfirst($row['status']) }}</span>
                    <span>{{ $row['count'] }} {{ \Illuminate\Support\Str::plural('order', $row['count']) }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="admin-panels">
        <div class="admin-panel">
            <h3>Recent orders</h3>
            @forelse($recentOrders as $order)
                <a href="{{ route('admin.orders.show', $order) }}" class="admin-panel-row admin-panel-row--orders">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var salesData = @json($salesChart);

    var ctx = document.getElementById('salesChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: salesData.map(function (d) { return d.label; }),
            datasets: [{
                label: 'Sales (₦)',
                data: salesData.map(function (d) { return d.total; }),
                borderColor: '#8C0027',
                backgroundColor: 'rgba(140, 0, 39, 0.08)',
                fill: true,
                tension: 0.3,
                pointRadius: 0,
                borderWidth: 2,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return '₦' + context.parsed.y.toLocaleString('en-NG');
                        },
                    },
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return '₦' + value.toLocaleString('en-NG');
                        },
                    },
                    grid: { color: '#F0DDE2' },
                },
                x: {
                    grid: { display: false },
                },
            },
        },
    });
});
</script>
@endpush