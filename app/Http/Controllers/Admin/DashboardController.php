<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'orders' => Order::count(),
            'revenue' => Order::where('status', '!=', 'cancelled')->sum('total'),
            'customers' => User::where('is_admin', false)->count(),
        ];

        $recentOrders = Order::with('user')->latest()->take(6)->get();
        $lowStock = Product::where('stock', '<', 5)->orderBy('stock')->take(6)->get();

        $salesChart = $this->salesOverLast30Days();
        $topProducts = $this->topSellingProducts();
        $statusBreakdown = $this->orderStatusBreakdown();

        return view('admin.dashboard', compact(
            'stats', 'recentOrders', 'lowStock', 'salesChart', 'topProducts', 'statusBreakdown'
        ));
    }

    private function salesOverLast30Days()
    {
        $salesByDay = Order::where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->where('status', '!=', 'cancelled')
            ->selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        return collect(range(0, 29))->map(function ($i) use ($salesByDay) {
            $date = now()->subDays(29 - $i);
            $key = $date->format('Y-m-d');

            return [
                'label' => $date->format('M j'),
                'total' => (float) ($salesByDay[$key] ?? 0),
            ];
        });
    }

    private function topSellingProducts()
    {
        return OrderItem::selectRaw('product_id, product_name, SUM(quantity) as total_qty, SUM(subtotal) as total_revenue')
            ->whereHas('order', fn ($q) => $q->where('status', '!=', 'cancelled'))
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();
    }

    private function orderStatusBreakdown()
    {
        $counts = Order::selectRaw('status, COUNT(*) as count')->groupBy('status')->pluck('count', 'status');

        return collect(['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->map(fn ($status) => [
            'status' => $status,
            'count' => (int) ($counts[$status] ?? 0),
        ]);
    }
}