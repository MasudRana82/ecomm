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
                                                <div class="flex-1">
                                                    <h3 class="text-base font-medium text-gray-900">
                                                        {{ $item->product->name }}</h3>

                                                    <!-- Quantity Controls -->
                                                    <div class="flex items-center mt-2 mb-2">
                                                        <label class="text-sm text-gray-500 mr-2">Qty:</label>
                                                        <div class="flex items-center border border-gray-300 rounded-md">
                                                            <button type="button"
                                                                class="decrease-qty w-8 h-8 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-l-md transition-colors"
                                                                data-item-id="{{ $item->id }}"
                                                                data-current-qty="{{ $item->quantity }}">
                                                                <i class="fas fa-minus text-xs"></i>
                                                            </button>
                                                            <input type="number"
                                                                class="quantity-input w-12 h-8 text-center border-x border-gray-300 focus:outline-none"
                                                                value="{{ $item->quantity }}" min="1"
                                                                max="{{ $item->product->quantity }}"
                                                                data-item-id="{{ $item->id }}" readonly>
                                                            <button type="button"
                                                                class="increase-qty w-8 h-8 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-r-md transition-colors"
                                                                data-item-id="{{ $item->id }}"
                                                                data-current-qty="{{ $item->quantity }}"
                                                                data-max-qty="{{ $item->product->quantity }}">
                                                                <i class="fas fa-plus text-xs"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    @if ($item->color)
                                                        <p class="text-sm text-gray-500">Color: {{ $item->color }}</p>
                                                    @endif
                                                    @if ($item->size)
                                                        <p class="text-sm text-gray-500">Size: {{ $item->size }}</p>
                                                    @endif
                                                </div>
                                                <div class="flex flex-col items-end">
                                                    <p class="text-base font-medium text-gray-900 item-total"
                                                        data-item-id="{{ $item->id }}"
                                                        data-price="{{ $item->price }}">
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
                                            class="block text-sm font-medium text-gray-700">নাম</label>
                                        <input type="text" name="shipping_address[name]" id="shipping_name" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="shipping_address"
                                            class="block text-sm font-medium text-gray-700">ঠিকানা</label>
                                        <input type="text" name="shipping_address[address]" id="shipping_address"
                                            required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                    </div>

                                    <div>
                                        <label for="shipping_city"
                                            class="block text-sm font-medium text-gray-700">জেলা</label>
                                        <input type="text" name="shipping_address[city]" id="shipping_city" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                    </div>

                                    <div>
                                        <label for="shipping_phone" class="block text-sm font-medium text-gray-700">মোবাইল
                                            নম্বর</label>
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
                                            <label for="billing_phone"
                                                class="block text-sm font-medium text-gray-700">Phone
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
                                    <!-- Cash on Delivery (Always Available) -->
                                    <div
                                        class="flex items-center p-4 border border-gray-300 rounded-lg hover:border-custom-orange transition-colors">
                                        <input id="payment_method_cash" name="payment_method" type="radio"
                                            value="cash_on_delivery" required checked
                                            class="h-4 w-4 text-custom-orange focus:ring-custom-orange border-gray-300">
                                        <label for="payment_method_cash"
                                            class="ml-3 flex items-center flex-1 cursor-pointer">
                                            <i class="fas fa-money-bill-wave text-green-600 text-xl mr-3"></i>
                                            <span class="text-sm font-medium text-gray-700">Cash on Delivery</span>
                                        </label>
                                    </div>

                                    @php
                                        $enabledGateways = \App\Models\PaymentGatewaySetting::getEnabledGateways();
                                    @endphp

                                    @foreach ($enabledGateways as $gateway)
                                        @if ($gateway->gateway_name === 'stripe')
                                            <!-- Stripe Payment -->
                                            <div
                                                class="flex items-center p-4 border border-gray-300 rounded-lg hover:border-custom-orange transition-colors">
                                                <input id="payment_method_stripe" name="payment_method" type="radio"
                                                    value="stripe" required
                                                    class="h-4 w-4 text-custom-orange focus:ring-custom-orange border-gray-300">
                                                <label for="payment_method_stripe"
                                                    class="ml-3 flex items-center flex-1 cursor-pointer">
                                                    <i class="fab fa-stripe text-indigo-600 text-xl mr-3"></i>
                                                    <span class="text-sm font-medium text-gray-700">Credit/Debit Card
                                                        (Stripe)</span>
                                                </label>
                                            </div>
                                        @elseif($gateway->gateway_name === 'sslcommerz')
                                            <!-- SSLCommerz Payment -->
                                            <div
                                                class="flex items-center p-4 border border-gray-300 rounded-lg hover:border-custom-orange transition-colors">
                                                <input id="payment_method_sslcommerz" name="payment_method"
                                                    type="radio" value="sslcommerz" required
                                                    class="h-4 w-4 text-custom-orange focus:ring-custom-orange border-gray-300">
                                                <label for="payment_method_sslcommerz"
                                                    class="ml-3 flex items-center flex-1 cursor-pointer">
                                                    <i class="fas fa-shield-alt text-green-600 text-xl mr-3"></i>
                                                    <span class="text-sm font-medium text-gray-700">SSLCommerz (Card/Mobile
                                                        Banking)</span>
                                                </label>
                                            </div>
                                        @elseif($gateway->gateway_name === 'bkash')
                                            <!-- Bkash Payment -->
                                            <div
                                                class="flex items-center p-4 border border-gray-300 rounded-lg hover:border-custom-orange transition-colors">
                                                <input id="payment_method_bkash" name="payment_method" type="radio"
                                                    value="bkash" required
                                                    class="h-4 w-4 text-custom-orange focus:ring-custom-orange border-gray-300">
                                                <label for="payment_method_bkash"
                                                    class="ml-3 flex items-center flex-1 cursor-pointer">
                                                    <i class="fas fa-mobile-alt text-pink-600 text-xl mr-3"></i>
                                                    <span class="text-sm font-medium text-gray-700">Bkash</span>
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- Order Notes (Optional) -->
                            <div class="pb-6">
                                <h3 class="text-md font-medium text-gray-900 mb-4">Order Notes <span
                                        class="text-sm text-gray-500 font-normal">(Optional)</span></h3>
                                <div>
                                    <label for="order_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                        Add any special instructions or comments about your order
                                    </label>
                                    <textarea name="order_notes" id="order_notes" rows="4"
                                        placeholder="e.g., Please call before delivery, Gift wrapping needed, etc."
                                        class="w-full border border-gray-300 rounded-md shadow-sm p-3 focus:outline-none focus:ring-2 focus:ring-custom-orange focus:border-custom-orange resize-none"></textarea>
                                    <p class="mt-1 text-xs text-gray-500">Maximum 500 characters</p>
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

            // Quantity increase/decrease handlers
            document.querySelectorAll('.increase-qty').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-item-id');
                    const maxQty = parseInt(this.getAttribute('data-max-qty'));
                    const input = document.querySelector(
                        `.quantity-input[data-item-id="${itemId}"]`);
                    const currentQty = parseInt(input.value);

                    if (currentQty < maxQty) {
                        updateQuantity(itemId, currentQty + 1);
                    } else {
                        alert(`Maximum available quantity is ${maxQty}`);
                    }
                });
            });

            document.querySelectorAll('.decrease-qty').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-item-id');
                    const input = document.querySelector(
                        `.quantity-input[data-item-id="${itemId}"]`);
                    const currentQty = parseInt(input.value);

                    if (currentQty > 1) {
                        updateQuantity(itemId, currentQty - 1);
                    }
                });
            });

            function updateQuantity(itemId, newQuantity) {
                fetch('{{ route('cart.update') }}', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            cart_id: itemId,
                            quantity: newQuantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update the quantity input
                            const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
                            input.value = newQuantity;

                            // Update the item total
                            const itemTotal = document.querySelector(`.item-total[data-item-id="${itemId}"]`);
                            const price = parseFloat(itemTotal.getAttribute('data-price'));
                            itemTotal.textContent = '৳' + (price * newQuantity).toFixed(2);

                            // Update cart count in header
                            const cartCountEl = document.getElementById('cart-count');
                            if (cartCountEl) cartCountEl.textContent = data.cart_count;

                            // Reload page to update totals
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while updating quantity');
                    });
            }

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

    <!-- Meta Pixel InitiateCheckout Event -->
    <script>
        // Track checkout initiation
        if (typeof fbq !== 'undefined') {
            fbq('track', 'InitiateCheckout', {
                content_ids: [
                    @foreach ($cartItems as $item)
                        '{{ $item->product_id }}'
                        {{ !$loop->last ? ',' : '' }}
                    @endforeach
                ],
                content_type: 'product',
                value: {{ $total }},
                currency: 'BDT',
                num_items: {{ $cartItems->sum('quantity') }}
            });
        }
    </script>
@endsection
