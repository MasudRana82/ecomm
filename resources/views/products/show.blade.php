@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="text-sm mb-6">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-custom-orange">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-custom-orange">Products</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">{{ $product->name }}</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Product Images -->
            <div class="lg:w-1/2">
                <div class="bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center h-96">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
                    @else
                        <img src="https://placehold.co/600x600/FFF7ED/F58220?text={{ urlencode($product->name) }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
                    @endif
                </div>
                
                <!-- Additional Images if any -->
                @if($product->images && count($product->images) > 1)
                <div class="grid grid-cols-4 gap-4 mt-4">
                    @foreach($product->images as $image)
                    <div class="bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center h-24">
                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            
            <!-- Product Info -->
            <div class="lg:w-1/2">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                
                <!-- Category -->
                <div class="mb-4">
                    <span class="text-sm text-gray-500">Category:</span>
                    <a href="{{ route('category.show', $product->category->slug) }}" class="text-sm text-custom-orange hover:underline">{{ $product->category->name }}</a>
                </div>
                
                <!-- Price -->
                <div class="mb-6">
                    @if($product->compare_price > $product->price)
                        <p class="text-3xl font-bold custom-orange">
                            ৳{{ number_format($product->price, 2) }}
                            <span class="text-xl font-normal text-gray-500 line-through ml-2">৳{{ number_format($product->compare_price, 2) }}</span>
                        </p>
                        <p class="text-sm text-red-500 font-semibold mt-1">Save {{ $product->discount_percentage }}%</p>
                    @else
                        <p class="text-3xl font-bold custom-orange">৳{{ number_format($product->price, 2) }}</p>
                    @endif
                </div>
                
                <!-- Description -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                    <p class="text-gray-700">{{ $product->description }}</p>
                </div>
                
                <!-- Additional Info -->
                <div class="mb-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">SKU</p>
                            <p class="text-gray-900">{{ $product->sku ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Availability</p>
                            <p class="text-gray-900">
                                @if($product->quantity > 0)
                                    <span class="text-green-600">In Stock ({{ $product->quantity }} available)</span>
                                @else
                                    <span class="text-red-600">Out of Stock</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Quantity and Add to Cart -->
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <label for="quantity" class="mr-4 text-gray-700">Quantity:</label>
                        <div class="flex items-center">
                            <button type="button" id="decrease-qty" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-l-md bg-gray-100">-</button>
                            <input type="number" id="quantity" min="1" value="1" max="{{ $product->quantity }}" class="w-16 h-10 text-center border-y border-gray-300">
                            <button type="button" id="increase-qty" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-r-md bg-gray-100">+</button>
                        </div>
                    </div>
                    
                    <button id="add-to-cart" class="w-full bg-custom-orange text-white py-3 rounded-md hover:bg-custom-orange-dark transition-colors duration-300" 
                            data-product-id="{{ $product->id }}" 
                            data-product-name="{{ $product->name }}"
                            @if($product->quantity <= 0) disabled @endif>
                        @if($product->quantity > 0)
                            Add to Cart
                        @else
                            Out of Stock
                        @endif
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const decreaseBtn = document.getElementById('decrease-qty');
    const increaseBtn = document.getElementById('increase-qty');
    const maxQty = parseInt(quantityInput.max);
    
    // Quantity handling
    decreaseBtn.addEventListener('click', function() {
        let currentQty = parseInt(quantityInput.value);
        if (currentQty > 1) {
            quantityInput.value = currentQty - 1;
        }
    });
    
    increaseBtn.addEventListener('click', function() {
        let currentQty = parseInt(quantityInput.value);
        if (currentQty < maxQty) {
            quantityInput.value = currentQty + 1;
        }
    });
    
    quantityInput.addEventListener('change', function() {
        let currentQty = parseInt(quantityInput.value);
        if (currentQty < 1) {
            quantityInput.value = 1;
        } else if (currentQty > maxQty) {
            quantityInput.value = maxQty;
        }
    });
    
    // Add to cart functionality
    document.getElementById('add-to-cart').addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        const productName = this.getAttribute('data-product-name');
        const quantity = parseInt(quantityInput.value);
        
        if(quantity > maxQty) {
            alert(`Only ${maxQty} items available in stock.`);
            quantityInput.value = maxQty;
            return;
        }
        
        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update cart count
                document.getElementById('cart-count').textContent = data.cart_count;
                // Show success message
                alert(`${quantity} ${productName} ${quantity > 1 ? 'items' : 'item'} added to cart successfully!`);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding to cart');
        });
    });
});
</script>
@endsection