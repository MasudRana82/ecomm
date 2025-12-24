@extends('layouts.app')

@section('content')
    <div class="bg-white">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-8">Checkout</h1>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Order Summary -->
                <div>
                    <h2 class="text-lg font-medium text-gray-900 mb-6">Order Summary</h2>

                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <ul class="divide-y divide-gray-200">
                            @foreach ($cartItems as $item)
                                <li class="py-6 px-4">
                                    <div class="flex items-center">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded-md overflow-hidden">
                                            @if ($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                                    alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <img src="https://placehold.co/100x100/FFF7ED/F58220?text={{ urlencode($item->product->name) }}"
                                                    alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>

                                        <!-- Product Info -->
                                        <div class="ml-4 flex-1">
                                            <div class="flex justify-between">
                                                <div>
                                                    <h3 class="text-base font-medium text-gray-900">
                                                        {{ $item->product->name }}</h3>
                                                    <p class="mt-1 text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                                    @if ($item->color)
                                                        <p class="text-sm text-gray-500">Color: {{ $item->color }}</p>
                                                    @endif
                                                    @if ($item->size)
                                                        <p class="text-sm text-gray-500">Size: {{ $item->size }}</p>
                                                    @endif
                                                </div>
                                                <div class="flex flex-col items-end">
                                                    <p class="text-base font-medium text-gray-900">
                                                        ৳{{ number_format($item->price * $item->quantity, 2) }}</p>
                                                    <button type="button" data-item-id="{{ $item->id }}"
                                                        class="remove-item mt-2 text-red-600 hover:text-red-800 text-sm">
                                                        <i class="fas fa-trash mr-1"></i>Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-6 bg-gray-50 p-4 rounded-md">
                        <div class="flex justify-between text-base font-medium text-gray-900 mb-2">
                            <p>Subtotal</p>
                            <p>৳{{ number_format($subtotal, 2) }}</p>
                        </div>
                        <div class="flex justify-between text-base font-medium text-gray-900 mb-2">
                            <p>Delivery Charge</p>
                            <p>৳{{ number_format($shipping, 2) }}</p>
                        </div>
                        <div
                            class="flex justify-between text-xl font-bold text-gray-900 mt-4 pt-4 border-t border-gray-200">
                            <p>Total</p>
                            <p>৳{{ number_format($total, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Checkout Form -->
                <div>
                    <h2 class="text-lg font-medium text-gray-900 mb-6">Shipping Information</h2>

                    <form id="checkout-form" method="POST" action="{{ route('orders.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 gap-y-6">
                            <!-- Shipping Address -->
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-md font-medium text-gray-900 mb-4">Shipping Address</h3>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="sm:col-span-2">
                                        <label for="shipping_name"
                                            class="block text-sm font-medium text-gray-700">Name</label>
                                        <input type="text" name="shipping_address[name]" id="shipping_name" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="shipping_address"
                                            class="block text-sm font-medium text-gray-700">Address</label>
                                        <input type="text" name="shipping_address[address]" id="shipping_address"
                                            required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                    </div>

                                    <div>
                                        <label for="shipping_city"
                                            class="block text-sm font-medium text-gray-700">City</label>
                                        <input type="text" name="shipping_address[city]" id="shipping_city" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                    </div>

                                    <div>
                                        <label for="shipping_phone" class="block text-sm font-medium text-gray-700">Phone
                                            Number</label>
                                        <input type="tel" name="shipping_address[phone]" id="shipping_phone" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                    </div>
                                </div>
                            </div>

                            <!-- Billing Address -->
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-md font-medium text-gray-900 mb-4">Billing Address</h3>
                                <div class="flex items-center mb-4">
                                    <input id="use-shipping-same" name="use_shipping_same" type="checkbox" checked
                                        class="h-4 w-4 text-custom-orange focus:ring-custom-orange border-gray-300 rounded">
                                    <label for="use-shipping-same" class="ml-2 block text-sm text-gray-900">Same as shipping
                                        address</label>
                                </div>

                                <div id="billing-fields" class="hidden">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="sm:col-span-2">
                                            <label for="billing_name"
                                                class="block text-sm font-medium text-gray-700">Name</label>
                                            <input type="text" name="billing_address[name]" id="billing_name"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label for="billing_address"
                                                class="block text-sm font-medium text-gray-700">Address</label>
                                            <input type="text" name="billing_address[address]" id="billing_address"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                        </div>

                                        <div>
                                            <label for="billing_city"
                                                class="block text-sm font-medium text-gray-700">City</label>
                                            <input type="text" name="billing_address[city]" id="billing_city"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                        </div>

                                        <div>
                                            <label for="billing_phone" class="block text-sm font-medium text-gray-700">Phone
                                                Number</label>
                                            <input type="tel" name="billing_address[phone]" id="billing_phone"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="pb-6">
                                <h3 class="text-md font-medium text-gray-900 mb-4">Payment Method</h3>

                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input id="payment_method_cash" name="payment_method" type="radio"
                                            value="cash_on_delivery" required checked
                                            class="h-4 w-4 text-custom-orange focus:ring-custom-orange border-gray-300">
                                        <label for="payment_method_cash"
                                            class="ml-3 block text-sm font-medium text-gray-700">Cash on Delivery</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Place Order Button -->
                            <div>
                                <button type="submit" id="place-order-btn"
                                    class="w-full bg-custom-orange border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-custom-orange-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-orange">
                                    Place Order
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const useShippingSameCheckbox = document.getElementById('use-shipping-same');
            const billingFields = document.getElementById('billing-fields');

            // Toggle billing fields visibility
            useShippingSameCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    billingFields.classList.add('hidden');
                } else {
                    billingFields.classList.remove('hidden');
                }
            });

            // Copy shipping to billing if checkbox is checked
            function copyShippingToBilling() {
                if (useShippingSameCheckbox.checked) {
                    document.getElementById('billing_name').value = document.getElementById('shipping_name').value;
                    document.getElementById('billing_address').value = document.getElementById('shipping_address')
                        .value;
                    document.getElementById('billing_city').value = document.getElementById('shipping_city').value;
                    document.getElementById('billing_phone').value = document.getElementById('shipping_phone')
                        .value;
                }
            }

            // Add event listeners to shipping fields to copy to billing
            document.getElementById('shipping_name').addEventListener('input', copyShippingToBilling);
            document.getElementById('shipping_address').addEventListener('input', copyShippingToBilling);
            document.getElementById('shipping_city').addEventListener('input', copyShippingToBilling);
            document.getElementById('shipping_phone').addEventListener('input', copyShippingToBilling);

            // Remove item from cart
            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-item-id');

                    if (confirm('Are you sure you want to remove this item from your cart?')) {
                        removeFromCart(itemId);
                    }
                });
            });

            function removeFromCart(itemId) {
                fetch(`{{ route('cart.remove', '') }}/${itemId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update cart count
                            const cartCountEl = document.getElementById('cart-count');
                            if (cartCountEl) cartCountEl.textContent = data.cart_count;

                            // Reload page to update cart items
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while removing item from cart');
                    });
            }

            // Form submission
            document.getElementById('checkout-form').addEventListener('submit', function(e) {
                e.preventDefault();

                // Disable the button to prevent multiple submissions
                const placeOrderBtn = document.getElementById('place-order-btn');
                placeOrderBtn.disabled = true;
                placeOrderBtn.textContent = 'Processing...';

                // Submit the form via AJAX
                const formData = new FormData(this);

                fetch(this.getAttribute('action'), {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (data.redirect) {
                                // Redirect to payment processing
                                window.location.href = data.redirect;
                            } else {
                                // Redirect to order confirmation page
                                alert(data.message || 'Order placed successfully!');
                                window.location.href = '{{ route('orders.show', ':orderNumber') }}'
                                    .replace(':orderNumber', data.order_number);
                            }
                        } else {
                            alert('Error: ' + data.message);
                            placeOrderBtn.disabled = false;
                            placeOrderBtn.textContent = 'Place Order';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while placing your order');
                        placeOrderBtn.disabled = false;
                        placeOrderBtn.textContent = 'Place Order';
                    });
            });
        });
    </script>
@endsection
