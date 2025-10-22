@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="px-4 py-8">
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="text-gray-600 mt-2">Welcome back! Here's what's happening with your store today.</p>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
        <!-- Total Orders -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Total Orders</p>
                    <p class="text-2xl md:text-3xl font-bold">{{ $totalOrders }}</p>
                </div>
                <div class="p-3 rounded-full bg-blue-400 bg-opacity-30">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Total Products -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Total Products</p>
                    <p class="text-2xl md:text-3xl font-bold">{{ $totalProducts }}</p>
                </div>
                <div class="p-3 rounded-full bg-green-400 bg-opacity-30">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Total Users -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Total Users</p>
                    <p class="text-2xl md:text-3xl font-bold">{{ $totalUsers }}</p>
                </div>
                <div class="p-3 rounded-full bg-purple-400 bg-opacity-30">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Total Revenue -->
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Total Revenue</p>
                    <p class="text-2xl md:text-3xl font-bold">${{ number_format($totalRevenue, 2) }}</p>
                </div>
                <div class="p-3 rounded-full bg-yellow-400 bg-opacity-30">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow-lg p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg md:text-xl font-bold text-gray-800">Recent Orders</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    View All
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentOrders as $order)
                        <tr>
                            <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-blue-600">
                                <a href="{{ route('admin.orders.show', $order->id) }}">{{ $order->order_number }}</a>
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('M d') }}
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($order->status == 'completed') bg-green-100 text-green-800
                                    @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status == 'shipped') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">
                                ${{ number_format($order->total, 2) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-3 py-4 text-center text-sm text-gray-500">
                                No recent orders found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Top Selling Products -->
        <div class="bg-white rounded-xl shadow-lg p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg md:text-xl font-bold text-gray-800">Top Selling Products</h2>
                <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    View All
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($topProducts as $product)
                        <tr>
                            <td class="px-3 py-3 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 truncate max-w-xs">{{ $product->name }}</div>
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->total_sold ?? 0 }}
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">
                                ${{ number_format($product->price, 2) }}
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($product->is_active) bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-3 py-4 text-center text-sm text-gray-500">
                                No top selling products found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection