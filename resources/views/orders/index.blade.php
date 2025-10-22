@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-8">My Orders</h1>
        
        @if($orders->count() > 0)
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @foreach($orders as $order)
                <li>
                    <div class="block hover:bg-gray-50">
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="min-w-0 flex-1 flex items-center">
                                <div class="min-w-0 flex-1 md:grid md:grid-cols-2 md:gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-custom-orange truncate">
                                            Order #{{ $order->order_number }}
                                        </p>
                                        <p class="mt-2 flex items-center text-sm text-gray-500">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $order->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <div class="hidden md:block">
                                        <div class="flex items-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                                @elseif($order->status === 'shipped') bg-indigo-100 text-indigo-800
                                                @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                                @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                            <p class="ml-4 text-sm text-gray-900">Total: ৳{{ number_format($order->total, 2) }}</p>
                                        </div>
                                        <div class="mt-2 flex">
                                            <p class="text-sm text-gray-500">
                                                Items: {{ $order->orderItems->sum('quantity') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('orders.show', $order->order_number) }}" class="block">
                </li>
                @endforeach
            </ul>
        </div>
        
        @if($orders->hasPages())
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
        @endif
        @else
        <div class="text-center py-12">
            <i class="fas fa-boxes text-5xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No orders yet</h3>
            <p class="text-gray-500 mb-6">You haven't placed any orders yet.</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-custom-orange border border-transparent rounded-md py-2 px-6 text-base font-medium text-white hover:bg-custom-orange-dark">
                Start Shopping
            </a>
        </div>
        @endif
    </div>
</div>
@endsection