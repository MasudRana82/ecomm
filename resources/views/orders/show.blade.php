@extends('layouts.app')

@section('content')
    <div class="bg-white">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-8">Order Details</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Order Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Order #{{ $order->order_number }}</h3>
                            <p class="mt-1 text-sm text-gray-500">Order placed on
                                {{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>

                        <ul class="divide-y divide-gray-200">
                            @foreach ($order->orderItems as $item)
                                <li class="py-6 px-4">
                                    <div class="flex items-center">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0 w-24 h-24 bg-gray-200 rounded-md overflow-hidden">
                                            @if ($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                                    alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <img src="https://placehold.co/100x100/FFF7ED/F58220?text={{ urlencode($item->product->name) }}"
                                                    alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>

                                        <!-- Product Info -->
                                        <div class="ml-4 flex-1 flex flex-col">
                                            <div>
                                                <div class="flex justify-between text-base font-medium text-gray-900">
                                                    <h3>{{ $item->product->name }}</h3>
                                                    <p class="ml-4">৳{{ number_format($item->price, 2) }}</p>
                                                </div>
                                                <p class="mt-1 text-sm text-gray-500">{{ $item->product->category->name }}
                                                </p>
                                                @if ($item->color)
                                                    <p class="mt-1 text-sm text-gray-500">Color: {{ $item->color }}</p>
                                                @endif
                                                @if ($item->size)
                                                    <p class="mt-1 text-sm text-gray-500">Size: {{ $item->size }}</p>
                                                @endif
                                            </div>

                                            <div class="flex-1 flex items-end justify-between text-sm">
                                                <p class="text-gray-500">Qty: {{ $item->quantity }}</p>
                                                <p class="text-gray-900 font-medium">৳{{ number_format($item->total, 2) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Order Summary -->
                <div>
                    <div class="bg-gray-50 p-6 rounded-md">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <p class="text-sm text-gray-600">Subtotal</p>
                                <p class="text-sm font-medium text-gray-900">৳{{ number_format($order->subtotal, 2) }}</p>
                            </div>

                            <div class="flex justify-between">
                                <p class="text-sm text-gray-600">Delivery Charge</p>
                                <p class="text-sm font-medium text-gray-900">৳{{ number_format($order->shipping, 2) }}</p>
                            </div>

                            <div class="flex justify-between pt-4 border-t border-gray-200">
                                <p class="text-base font-medium text-gray-900">Total</p>
                                <p class="text-base font-medium text-gray-900">৳{{ number_format($order->total, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Status -->
                    <div class="mt-6 bg-gray-50 p-6 rounded-md">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Order Status</h2>

                        <div class="flex items-center">
                            <span
                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if ($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                            @elseif($order->status === 'shipped') bg-indigo-100 text-indigo-800
                            @elseif($order->status === 'delivered') bg-green-100 text-green-800
                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                        <p class="mt-2 text-sm text-gray-500">
                            @if ($order->status === 'pending')
                                Your order is being processed.
                            @elseif($order->status === 'processing')
                                Your order is being prepared for shipment.
                            @elseif($order->status === 'shipped')
                                Your order has been shipped.
                            @elseif($order->status === 'delivered')
                                Your order has been delivered.
                            @elseif($order->status === 'cancelled')
                                This order has been cancelled.
                            @endif
                        </p>
                    </div>

                    <!-- Payment Information -->
                    <div class="mt-6 bg-gray-50 p-6 rounded-md">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Payment Information</h2>

                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <p class="text-sm text-gray-600">Payment Method</p>
                                <p class="text-sm font-medium text-gray-900">
                                    {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                            </div>

                            <div class="flex justify-between">
                                <p class="text-sm text-gray-600">Payment Status</p>
                                <p class="text-sm font-medium text-gray-900">{{ ucfirst($order->payment_status) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="mt-6 bg-gray-50 p-6 rounded-md">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Shipping Address</h2>

                        <div class="text-sm text-gray-700 space-y-1">
                            <p>{{ $order->shipping_address['name'] ?? ($order->shipping_address['first_name'] ?? '') . ' ' . ($order->shipping_address['last_name'] ?? '') }}
                            </p>
                            <p>{{ $order->shipping_address['address'] }}</p>
                            <p>{{ $order->shipping_address['city'] }}</p>
                            <p>{{ $order->shipping_address['phone'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
