<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderItem;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get basic analytics data
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::count();
        
        // Get revenue data (sum of completed orders)
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        
        // Get recent orders for the dashboard
        $recentOrders = Order::with('user')->orderBy('created_at', 'desc')->take(5)->get();
        
        // Get top selling products based on quantity sold
        $topProducts = OrderItem::select('products.id', 'products.name', 'products.price', 'products.is_active', \DB::raw('SUM(order_items.quantity) as total_sold'))
                               ->join('products', 'order_items.product_id', '=', 'products.id')
                               ->join('orders', 'order_items.order_id', '=', 'orders.id')
                               ->where('orders.status', 'completed')
                               ->groupBy('order_items.product_id', 'products.id', 'products.name', 'products.price', 'products.is_active')
                               ->orderBy('total_sold', 'desc')
                               ->take(5)
                               ->get();
        
        return view('admin.dashboard', compact('totalOrders', 'totalProducts', 'totalUsers', 'totalRevenue', 'recentOrders', 'topProducts'));
    }
}