@extends('admin.layout')

@section('title', 'Order Details - ' . $order->order_number)

@section('content')
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Order Details #{{ $order->order_number }}</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-custom-orange hover:text-orange-700">
                <i class="fas fa-arrow-left mr-2"></i>Back to Orders
            </a>
        </div>

        <div class="p-6">
            <!-- Order Summary -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Customer Information</h3>
                    <p><strong>Name:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                    <p><strong>Phone:</strong> {{ $order->user->phone ?? 'N/A' }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Order Information</h3>
                    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                    <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                    <p><strong>Status:</strong>
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        @switch($order->status)
                            @case('pending')
                                bg-yellow-100 text-yellow-800
                                @break
                            @case('processing')
                                bg-blue-100 text-blue-800
                                @break
                            @case('shipped')
                                bg-indigo-100 text-indigo-800
                                @break
                            @case('delivered')
                                bg-green-100 text-green-800
                                @break
                            @case('cancelled')
                                bg-red-100 text-red-800
                                @break
                            @default
                                bg-gray-100 text-gray-800
                        @endswitch">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    <p><strong>Payment Status:</strong>
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        @switch($order->payment_status)
                            @case('pending')
                                bg-yellow-100 text-yellow-800
                                @break
                            @case('paid')
                                bg-green-100 text-green-800
                                @break
                            @case('failed')
                                bg-red-100 text-red-800
                                @break
                            @case('refunded')
                                bg-purple-100 text-purple-800
                                @break
                            @default
                                bg-gray-100 text-gray-800
                        @endswitch">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Shipping & Billing Addresses -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Shipping Address</h3>
                    @if ($order->shipping_address)
                        <p>{{ $order->shipping_address['name'] ?? trim(($order->shipping_address['first_name'] ?? '') . ' ' . ($order->shipping_address['last_name'] ?? '')) }}
                        </p>
                        <p>{{ $order->shipping_address['address'] ?? '' }}</p>
                        <p>{{ $order->shipping_address['city'] ?? '' }}</p>
                        <p>{{ $order->shipping_address['country'] ?? '' }}</p>
                        <p>Phone: {{ $order->shipping_address['phone'] ?? '' }}</p>
                    @else
                        <p>No shipping address available.</p>
                    @endif
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Billing Address</h3>
                    @if ($order->billing_address)
                        <p>{{ $order->billing_address['name'] ?? trim(($order->billing_address['first_name'] ?? '') . ' ' . ($order->billing_address['last_name'] ?? '')) }}
                        </p>
                        <p>{{ $order->billing_address['address'] ?? '' }}</p>
                        <p>{{ $order->billing_address['city'] ?? '' }}</p>
                        <p>{{ $order->billing_address['country'] ?? '' }}</p>
                        <p>Phone: {{ $order->billing_address['phone'] ?? '' }}</p>
                    @else
                        <p>No billing address available.</p>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Order Items</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($order->orderItems as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->product->name ?? 'N/A' }}
                                        </div>
                                        @if ($item->color)
                                            <div class="text-xs text-gray-500">Color: {{ $item->color }}</div>
                                        @endif
                                        @if ($item->size)
                                            <div class="text-xs text-gray-500">Size: {{ $item->size }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        ৳{{ number_format($item->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        ৳{{ number_format($item->total, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        No items in this order.
                                    </td>
                                </tr>
                            @endforelse
                            <tr class="bg-gray-50 font-semibold">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" colspan="3">Subtotal</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ৳{{ number_format($order->subtotal, 2) }}</td>
                            </tr>
                            <tr class="bg-gray-50 font-semibold">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" colspan="3">Tax</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ৳{{ number_format($order->tax, 2) }}</td>
                            </tr>
                            <tr class="bg-gray-50 font-semibold">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" colspan="3">Shipping</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ৳{{ number_format($order->shipping, 2) }}</td>
                            </tr>
                            <tr class="bg-gray-100 font-bold text-lg">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" colspan="3">Total</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ৳{{ number_format($order->total, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Update Order Status -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Update Order Status</h3>
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Order Status</label>
                            <select name="status" id="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>
                                    Processing</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped
                                </option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered
                                </option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                            </select>
                        </div>

                        <div>
                            <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">Payment
                                Status</label>
                            <select name="payment_status" id="payment_status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>
                                    Pending</option>
                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid
                                </option>
                                <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed
                                </option>
                                <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>
                                    Refunded</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="shipped_at" class="block text-sm font-medium text-gray-700 mb-1">Shipped At</label>
                            <input type="datetime-local" name="shipped_at" id="shipped_at"
                                value="{{ $order->shipped_at ? $order->shipped_at->format('Y-m-d\\TH:i') : '' }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label for="delivered_at" class="block text-sm font-medium text-gray-700 mb-1">Delivered
                                At</label>
                            <input type="datetime-local" name="delivered_at" id="delivered_at"
                                value="{{ $order->delivered_at ? $order->delivered_at->format('Y-m-d\\TH:i') : '' }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>Update Order
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
