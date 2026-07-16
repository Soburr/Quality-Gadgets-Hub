<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'orders' => Order::count(),
            'revenue' => Order::sum('total'),
            'customers' => User::where('is_admin', false)->count(),
        ];

        $recentOrders = Order::with('user')->latest()->take(6)->get();
        $lowStock = Product::where('stock', '<', 5)->orderBy('stock')->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStock'));
    }
}