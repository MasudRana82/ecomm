@extends('layouts.app')

@section('content')
    <div class="bg-white">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-8">Your Shopping Cart</h1>

            @if ($cartItems->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2">
                        <div class="bg-white shadow overflow-hidden sm:rounded-md">
                            <ul class="divide-y divide-gray-200">
                                @foreach ($cartItems as $item)
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
                                                    <p class="mt-1 text-sm text-gray-500">
                                                        {{ $item->product->category->name }}</p>
                                                    @if ($item->color)
                                                        <p class="mt-1 text-sm text-gray-500">Color: {{ $item->color }}</p>
                                                    @endif
                                                    @if ($item->size)
                                                        <p class="mt-1 text-sm text-gray-500">Size: {{ $item->size }}</p>
                                                    @endif
                                                </div>

                                                <div class="flex-1 flex items-end justify-between text-sm">
                                                    <!-- Quantity -->
                                                    <div class="flex items-center">
                                                        <span class="mr-2">Qty:</span>
                                                        <div class="flex items-center">
                                                            <button type="button" data-item-id="{{ $item->id }}"
                                                                class="decrease-qty w-8 h-8 flex items-center justify-center border border-gray-300 rounded-l-md bg-gray-100">-</button>
                                                            <input type="number" data-item-id="{{ $item->id }}"
                                                                value="{{ $item->quantity }}" min="1"
                                                                max="{{ $item->product->quantity }}"
                                                                class="w-12 h-8 text-center border-y border-gray-300 qty-input">
                                                            <button type="button" data-item-id="{{ $item->id }}"
                                                                class="increase-qty w-8 h-8 flex items-center justify-center border border-gray-300 rounded-r-md bg-gray-100">+</button>
                                                        </div>
                                                    </div>

                                                    <!-- Remove Button -->
                                                    <div class="flex">
                                                        <button type="button" data-item-id="{{ $item->id }}"
                                                            class="remove-item text-red-600 hover:text-red-800 ml-4">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="border-t border-gray-200 pt-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>

                        <div class="flow-root">
                            <ul class="divide-y divide-gray-200">
                                <li class="flex items-center justify-between py-2">
                                    <dt class="text-sm text-gray-600">Subtotal</dt>
                                    <dd class="text-sm font-medium text-gray-900">৳<span
                                            id="subtotal-amount">{{ number_format($cartItems->sum(function ($item) {return $item->quantity * $item->price;}),2) }}</span>
                                    </dd>
                                </li>
                                <li class="flex items-center justify-between py-2">
                                    <dt class="text-sm text-gray-600">Delivery Charge</dt>
                                    <dd class="text-sm font-medium text-gray-900">৳<span id="shipping-amount">100.00</span>
                                    </dd>
                                </li>
                                <li class="flex items-center justify-between py-2 border-t border-gray-200">
                                    <dt class="text-base font-medium text-gray-900">Total</dt>
                                    <dd class="text-base font-medium text-gray-900">৳<span
                                            id="total-amount">{{ number_format($cartItems->sum(function ($item) {return $item->quantity * $item->price;}) + 100,2) }}</span>
                                    </dd>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('checkout') }}"
                                class="w-full bg-custom-orange border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-custom-orange-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-orange">
                                Proceed to Checkout
                            </a>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('products.index') }}"
                                class="w-full bg-white border border-gray-300 rounded-md shadow-sm py-3 px-4 text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-orange">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-shopping-cart text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Your cart is empty</h3>
                    <p class="text-gray-500 mb-6">Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{ route('products.index') }}"
                        class="inline-block bg-custom-orange border border-transparent rounded-md py-2 px-6 text-base font-medium text-white hover:bg-custom-orange-dark">
                        Shop Now
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update cart item quantity
            document.querySelectorAll('.qty-input').forEach(input => {
                input.addEventListener('change', function() {
                    const itemId = this.getAttribute('data-item-id');
                    const newQuantity = parseInt(this.value);

                    updateCartItem(itemId, newQuantity);
                });
            });

            // Increase quantity
            document.querySelectorAll('.increase-qty').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-item-id');
                    const input = document.querySelector(`input[data-item-id="${itemId}"]`);
                    let currentQty = parseInt(input.value);
                    const maxQty = parseInt(input.max);

                    if (currentQty < maxQty) {
                        input.value = currentQty + 1;
                        updateCartItem(itemId, currentQty + 1);
                    }
                });
            });

            // Decrease quantity
            document.querySelectorAll('.decrease-qty').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-item-id');
                    const input = document.querySelector(`input[data-item-id="${itemId}"]`);
                    let currentQty = parseInt(input.value);

                    if (currentQty > 1) {
                        input.value = currentQty - 1;
                        updateCartItem(itemId, currentQty - 1);
                    }
                });
            });

            // Remove item from cart
            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-item-id');

                    if (confirm('Are you sure you want to remove this item from your cart?')) {
                        removeFromCart(itemId);
                    }
                });
            });

            function updateCartItem(itemId, quantity) {
                fetch('{{ route('cart.update') }}', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            cart_id: itemId,
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update cart count
                            document.getElementById('cart-count').textContent = data.cart_count;
                            // Reload page to update totals
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                            // Reload to reset quantity to original value
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while updating cart');
                        location.reload();
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
                            document.getElementById('cart-count').textContent = data.cart_count;
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
        });
    </script>
@endsection
