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
                    <div class="bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center h-96 group">
                        @if ($product->image)
                            <img id="main-image" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-contain transition-opacity duration-300">
                        @else
                            <img id="main-image"
                                src="https://placehold.co/600x600/FFF7ED/F58220?text={{ urlencode($product->name) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-contain transition-opacity duration-300">
                        @endif
                    </div>

                    <!-- Additional Images if any -->
                    @if ($product->images && count($product->images) > 0)
                        <div class="grid grid-cols-5 gap-4 mt-4">
                            <!-- Main Image Thumbnail -->
                            @if ($product->image)
                                <div class="bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center h-20 cursor-pointer border-2 border-transparent hover:border-custom-orange transition-colors duration-200"
                                    onclick="changeImage('{{ asset('storage/' . $product->image) }}')">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover">
                                </div>
                            @endif

                            @foreach ($product->images as $image)
                                <div class="bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center h-20 cursor-pointer border-2 border-transparent hover:border-custom-orange transition-colors duration-200"
                                    onclick="changeImage('{{ asset('storage/' . $image) }}')">
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover">
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
                        <a href="{{ route('category.show', $product->category->slug) }}"
                            class="text-sm text-custom-orange hover:underline">{{ $product->category->name }}</a>
                    </div>

                    <!-- Price -->
                    <div class="mb-6">
                        @if ($product->compare_price > $product->price)
                            <p class="text-3xl font-bold custom-orange">
                                ৳{{ number_format($product->price, 2) }}
                                <span
                                    class="text-xl font-normal text-gray-500 line-through ml-2">৳{{ number_format($product->compare_price, 2) }}</span>
                            </p>
                            <p class="text-sm text-red-500 font-semibold mt-1">Save {{ $product->discount_percentage }}%
                            </p>
                        @else
                            <p class="text-3xl font-bold custom-orange">৳{{ number_format($product->price, 2) }}</p>
                        @endif
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
                                    @if ($product->quantity > 0)
                                        <span class="text-green-600">In Stock ({{ $product->quantity }} available)</span>
                                    @else
                                        <span class="text-red-600">Out of Stock</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Options (Color & Size) -->
                    @if ($product->colors && count($product->colors) > 0)
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-gray-900 mb-2">Select Color</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($product->colors as $index => $color)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="color" value="{{ $color }}"
                                            class="peer sr-only color-selector" data-color="{{ $color }}"
                                            data-image="{{ isset($product->color_images[$color]) ? asset('storage/' . $product->color_images[$color]) : '' }}"
                                            {{ $index === 0 ? 'checked' : '' }}>
                                        <div
                                            class="px-3 py-1 border border-gray-300 rounded-md peer-checked:border-custom-orange peer-checked:bg-orange-50 peer-checked:text-custom-orange hover:border-gray-400 transition-colors">
                                            {{ $color }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($product->sizes && count($product->sizes) > 0)
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-900 mb-2">Select Size</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($product->sizes as $size)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="size" value="{{ $size }}"
                                            class="peer sr-only">
                                        <div
                                            class="px-3 py-1 border border-gray-300 rounded-md peer-checked:border-custom-orange peer-checked:bg-orange-50 peer-checked:text-custom-orange hover:border-gray-400 transition-colors">
                                            {{ $size }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Quantity and Add to Cart -->
                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <label for="quantity" class="mr-4 text-gray-700">Quantity:</label>
                            <div class="flex items-center">
                                <button type="button" id="decrease-qty"
                                    class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-l-md bg-gray-100">-</button>
                                <input type="number" id="quantity" min="1" value="1"
                                    max="{{ $product->quantity }}" class="w-16 h-10 text-center border-y border-gray-300">
                                <button type="button" id="increase-qty"
                                    class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-r-md bg-gray-100">+</button>
                            </div>
                        </div>
                      

                        <div class="flex gap-4">
                            <button id="add-to-cart"
                                class="flex-1 bg-custom-orange text-white py-3 rounded-md hover:bg-custom-orange-dark transition-colors duration-300"
                                data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}"
                                @if ($product->quantity <= 0) disabled @endif>
                                @if ($product->quantity > 0)
                                    Add to Cart
                                @else
                                    Out of Stock
                                @endif
                            </button>

                            @if ($product->quantity > 0)
                                <button id="buy-now"
                                    class="flex-1 bg-gray-900 text-white py-3 rounded-md hover:bg-gray-800 transition-colors duration-300"
                                    data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}">
                                    Buy Now
                                </button>
                @endif
                               </div>
                               
                    </div>
                      <!-- Description -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                        <p class="text-gray-700">{{ $product->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products Section -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="bg-gray-50 py-12 mt-12">
            <div class="container mx-auto px-4">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8 text-center">Related Products</h2>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-4 md:gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden group text-center relative">
                            @if($relatedProduct->discount_percentage > 0)
                                <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded-full z-10">
                                    -{{ $relatedProduct->discount_percentage }}%
                                </span>
                            @endif
                            
                            <a href="{{ route('products.show', $relatedProduct->slug) }}" class="block">
                                @if($relatedProduct->image)
                                    <img src="{{ asset('storage/' . $relatedProduct->image) }}" alt="{{ $relatedProduct->name }}" 
                                        class="w-full h-40 md:h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <img src="https://placehold.co/300x300/FFF7ED/F58220?text={{ urlencode($relatedProduct->name) }}" 
                                        alt="{{ $relatedProduct->name }}" 
                                        class="w-full h-40 md:h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                @endif
                            </a>
                            
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 truncate mb-2">{{ $relatedProduct->name }}</h3>
                                
                                @if($relatedProduct->compare_price > $relatedProduct->price)
                                    <p class="text-lg font-bold custom-orange mb-3">
                                        ৳{{ number_format($relatedProduct->price, 2) }} 
                                        <span class="text-sm font-normal text-gray-500 line-through">৳{{ number_format($relatedProduct->compare_price, 2) }}</span>
                                    </p>
                                @else
                                    <p class="text-lg font-bold custom-orange mb-3">৳{{ number_format($relatedProduct->price, 2) }}</p>
                                @endif
                                
                                <button class="w-full bg-custom-orange text-white py-2 rounded-md hover:bg-custom-orange-dark transition-colors duration-300 related-add-to-cart mb-2" 
                                    data-product-id="{{ $relatedProduct->id }}" 
                                    data-product-name="{{ $relatedProduct->name }}">
                                    Add to Cart
                                </button>
                                
                                <button class="w-full bg-gray-900 text-white py-2 rounded-md hover:bg-gray-800 transition-colors duration-300 related-buy-now" 
                                    data-product-id="{{ $relatedProduct->id }}" 
                                    data-product-name="{{ $relatedProduct->name }}">
                                    Buy Now
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Include the Product Options Modal -->
    @include('components.product-options-modal')


    <script>
        function changeImage(src) {
            const mainImage = document.getElementById('main-image');
            mainImage.style.opacity = '0.5';
            setTimeout(() => {
                mainImage.src = src;
                mainImage.style.opacity = '1';
            }, 200);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.getElementById('quantity');
            const decreaseBtn = document.getElementById('decrease-qty');
            const increaseBtn = document.getElementById('increase-qty');
            const maxQty = parseInt(quantityInput.max);
            const mainImage = document.getElementById('main-image');
            const colorSelectors = document.querySelectorAll('.color-selector');

            // Store the default image
            const defaultImage = mainImage.src;

            // Handle color selection and image switching
            colorSelectors.forEach(selector => {
                selector.addEventListener('change', function() {
                    const colorImage = this.getAttribute('data-image');

                    if (colorImage && colorImage !== '') {
                        changeImage(colorImage);
                    } else {
                        // If no color-specific image, use default product image
                        changeImage(defaultImage);
                    }
                });
            });

            // Trigger change event on the initially checked color (if any)
            const initiallyChecked = document.querySelector('.color-selector:checked');
            if (initiallyChecked) {
                const colorImage = initiallyChecked.getAttribute('data-image');
                if (colorImage && colorImage !== '') {
                    mainImage.src = colorImage;
                }
            }

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

            function addToCart(productId, quantity, productName, isBuyNow = false) {
                if (quantity > maxQty) {
                    alert(`Only ${maxQty} items available in stock.`);
                    quantityInput.value = maxQty;
                    return;
                }

                // Get selected color and size
                let color = null;
                const colorInput = document.querySelector('input[name="color"]:checked');
                if (document.querySelector('input[name="color"]') && !colorInput) {
                    alert('Please select a color');
                    return;
                }
                if (colorInput) color = colorInput.value;

                let size = null;
                const sizeInput = document.querySelector('input[name="size"]:checked');
                if (document.querySelector('input[name="size"]') && !sizeInput) {
                    alert('Please select a size');
                    return;
                }
                if (sizeInput) size = sizeInput.value;

                fetch('{{ route('cart.add') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: quantity,
                            color: color,
                            size: size
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update cart count
                            const cartCountEl = document.getElementById('cart-count');
                            if (cartCountEl) cartCountEl.textContent = data.cart_count;

                            // Track AddToCart event with Meta Pixel
                            if (typeof fbq !== 'undefined' && data.product) {
                                fbq('track', 'AddToCart', {
                                    content_name: data.product.name,
                                    content_ids: [data.product.id],
                                    content_type: 'product',
                                    value: data.product.price * data.product.quantity,
                                    currency: 'BDT'
                                });
                            }

                            if (isBuyNow) {
                                window.location.href = "{{ route('checkout') }}";
                            } else {
                                // Show success message
                                alert(
                                    `${quantity} ${productName} ${quantity > 1 ? 'items' : 'item'} added to cart successfully!`
                                );
                            }
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while adding to cart');
                    });
            }

            // Add to cart functionality
            const addToCartBtn = document.getElementById('add-to-cart');
            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const productName = this.getAttribute('data-product-name');
                    const quantity = parseInt(quantityInput.value);
                    addToCart(productId, quantity, productName, false);
                });
            }

            // Buy Now functionality
            const buyNowBtn = document.getElementById('buy-now');
            if (buyNowBtn) {
                buyNowBtn.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const productName = this.getAttribute('data-product-name');
                    const quantity = parseInt(quantityInput.value);
                    addToCart(productId, quantity, productName, true);
                });
            }

            // Related products - Add to Cart functionality (opens modal)
            document.querySelectorAll('.related-add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const productName = this.getAttribute('data-product-name');
                    openProductModal(productId, productName, false);
                });
            });

            // Related products - Buy Now functionality (opens modal)
            document.querySelectorAll('.related-buy-now').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const productName = this.getAttribute('data-product-name');
                    openProductModal(productId, productName, true);
                });
            });
        });
    </script>

    <!-- Meta Pixel ViewContent Event -->
    <script>
        // Track product view
        if (typeof fbq !== 'undefined') {
            fbq('track', 'ViewContent', {
                content_name: '{{ $product->name }}',
                content_ids: ['{{ $product->id }}'],
                content_type: 'product',
                value: {{ $product->price }},
                currency: 'BDT'
            });
        }
    </script>
@endsection
