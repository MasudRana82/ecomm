@extends('layouts.app')

@section('content')
<!-- Banner Section -->
<section class="mb-12">
    <div class="bg-yellow-200 rounded-lg overflow-hidden h-48 md:h-64 lg:h-80 flex items-center justify-center">
        <img src="https://placehold.co/1200x320/FBBF24/333333?text=Organic+%26+Fresh+Products" alt="Promotional Banner" class="w-full h-full object-cover">
    </div>
</section>

<!-- Product Listing Section -->
<section>
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">ALL PRODUCTS</h2>
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Filters Sidebar -->
        <aside class="hidden md:block md:w-1/4 lg:w-1/5 bg-white p-6 rounded-lg shadow-sm h-fit">
            <div id="filter-accordion">
                <!-- Category Filter -->
                <div>
                    <h3 class="text-lg font-semibold mb-3 flex justify-between items-center cursor-pointer">
                        <span>Categories</span>
                        <i class="fas fa-chevron-down text-sm"></i>
                    </h3>
                    <div id="category-filters" class="space-y-2 text-gray-700">
                        <div class="flex items-center">
                            <input type="checkbox" id="cat-all" name="category" value="" class="custom-checkbox h-4 w-4 rounded border-gray-300 text-orange-500 focus:ring-orange-200" @if(!request('category')) checked @endif>
                            <label for="cat-all" class="ml-2 text-sm text-gray-600">All Categories</label>
                        </div>
                        
                        @foreach($categories as $category)
                        <div class="flex items-center">
                            <input type="checkbox" id="cat-{{ $category->id }}" name="category" value="{{ $category->id }}" class="custom-checkbox category-checkbox h-4 w-4 rounded border-gray-300 text-orange-500 focus:ring-orange-200" @if(request('category') == $category->slug) checked @endif>
                            <label for="cat-{{ $category->id }}" class="ml-2 text-sm text-gray-600">{{ $category->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Price Filter -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-3 flex justify-between items-center cursor-pointer">
                        <span>Price Range</span>
                        <i class="fas fa-chevron-down text-sm"></i>
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label for="min-price" class="block text-sm font-medium text-gray-700 mb-1">Min Price</label>
                            <input type="number" id="min-price" min="0" placeholder="0" class="w-full border border-gray-300 rounded-md p-2 text-sm" value="{{ request('min_price', '') }}">
                        </div>
                        <div>
                            <label for="max-price" class="block text-sm font-medium text-gray-700 mb-1">Max Price</label>
                            <input type="number" id="max-price" min="0" placeholder="5000" class="w-full border border-gray-300 rounded-md p-2 text-sm" value="{{ request('max_price', '') }}">
                        </div>
                        <button id="apply-price-filter" class="w-full bg-custom-orange text-white py-2 rounded-md hover:bg-custom-orange-dark transition-colors duration-300">
                            Apply Filter
                        </button>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Products Grid -->
        <div class="w-full md:w-3/4 lg:w-4/5">
            <!-- Sorting Dropdown -->
            <div class="hidden sm:flex flex-col sm:flex-row justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-sm">
                <p class="text-sm text-gray-600 mb-2 sm:mb-0">Showing <strong id="product-count" class="custom-orange">{{ $products->total() }}</strong> of {{ $products->total() }} products</p>
                <div class="flex items-center gap-2">
                    <label for="sort-by" class="text-sm font-medium text-gray-700">Sort by:</label>
                    <select id="sort-by" class="border border-gray-300 rounded-md p-2 text-sm focus:ring-orange-300 focus:border-orange-300">
                        <option value="latest" @if(request('sort') === null || request('sort') === 'latest') selected @endif>Latest</option>
                        <option value="price-asc" @if(request('sort') === 'price-asc') selected @endif>Price: Low to High</option>
                        <option value="price-desc" @if(request('sort') === 'price-desc') selected @endif>Price: High to Low</option>
                        <option value="name-asc" @if(request('sort') === 'name-asc') selected @endif>Name: A to Z</option>
                        <option value="name-desc" @if(request('sort') === 'name-desc') selected @endif>Name: Z to A</option>
                    </select>
                </div>
            </div>
            
            <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @forelse($products as $product)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden group text-center relative flex flex-col justify-between">
                    <div>
                        @if($product->discount_percentage > 0)
                        <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded-full">
                            -{{ $product->discount_percentage }}%
                        </span>
                        @endif
                        
                        <a href="{{ route('products.show', $product->slug) }}" class="block">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-40 md:h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <img src="https://placehold.co/300x300/FFF7ED/F58220?text={{ urlencode($product->name) }}" alt="{{ $product->name }}" class="w-full h-40 md:h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            @endif
                        </a>
                        
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 truncate h-6">{{ $product->name }}</h3>
                            
                            @if($product->compare_price > $product->price)
                                <p class="text-lg font-bold custom-orange">
                                    ৳{{ number_format($product->price, 2) }} 
                                    <span class="text-sm font-normal text-gray-500 line-through">৳{{ number_format($product->compare_price, 2) }}</span>
                                </p>
                            @else
                                <p class="text-lg font-bold custom-orange">৳{{ number_format($product->price, 2) }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-4 pt-0">
                        <button class="w-full bg-custom-orange text-white py-2 rounded-md hover:bg-custom-orange-dark transition-colors duration-300 add-to-cart" 
                                data-product-id="{{ $product->id }}" 
                                data-product-name="{{ $product->name }}">
                            Add to Cart
                        </button>
                        <button
                            class="mt-2 w-full bg-gray-900 text-white py-2 rounded-md hover:bg-gray-800 transition-colors duration-300 buy-now-btn"
                            data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}">
                            Buy Now
                        </button>
                    </div>


                </div>
                @empty
                <div class="col-span-full text-center text-gray-500 py-10">
                    <p>No products found matching your criteria.</p>
                </div>
                @endforelse
            </div>
            
            @if($products->hasPages())
            <div class="mt-8">
                {{ $products->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</section>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            function addToCart(productId, productName, isBuyNow = false) {
                fetch('{{ route('cart.add') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: 1
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update cart count
                            const cartCountEl = document.getElementById('cart-count');
                            if (cartCountEl) cartCountEl.textContent = data.cart_count;

                            if (isBuyNow) {
                                window.location.href = "{{ route('checkout') }}";
                            } else {
                                // Show success message
                                alert(`${productName} added to cart successfully!`);
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
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const productName = this.getAttribute('data-product-name');
                    addToCart(productId, productName, false);
                });
            });

            // Buy Now functionality
            document.querySelectorAll('.buy-now-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const productName = this.getAttribute('data-product-name');
                    addToCart(productId, productName, true);
                });
            });
        });
    </script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Accordion for filters
    document.querySelectorAll('#filter-accordion h3').forEach(header => {
        header.addEventListener('click', () => {
            const content = header.nextElementSibling;
            const icon = header.querySelector('i');
            content.classList.toggle('hidden');
            icon.classList.toggle('fa-chevron-down');
            icon.classList.toggle('fa-chevron-up');
        });
    });
    
    // Initially hide filter content except first one
    const filterContents = document.querySelectorAll('#filter-accordion > div > div:nth-child(2)');
    filterContents.forEach((content, index) => {
        if (index !== 0) {
            content.classList.add('hidden');
        }
    });
    
    // Category filter handling
    document.querySelectorAll('.category-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const categoryValue = this.value;
            if (this.checked) {
                // Uncheck "All" checkbox when selecting a specific category
                document.getElementById('cat-all').checked = false;
            }
            applyFilters();
        });
    });
    
    // "All" checkbox handling
    document.getElementById('cat-all').addEventListener('change', function() {
        if (this.checked) {
            // Uncheck all other categories
            document.querySelectorAll('.category-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
        }
        applyFilters();
    });
    
    // Sort by handling
    document.getElementById('sort-by').addEventListener('change', function() {
        applyFilters();
    });
    
    // Apply price filter
    document.getElementById('apply-price-filter').addEventListener('click', function() {
        applyFilters();
    });
    
    // Also trigger filter on Enter key in price inputs
    document.getElementById('min-price').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            applyFilters();
        }
    });
    
    document.getElementById('max-price').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            applyFilters();
        }
    });
    
    function applyFilters() {
        const selectedCategories = Array.from(document.querySelectorAll('.category-checkbox:checked')).map(cb => cb.value);
        const allChecked = document.getElementById('cat-all').checked;
        const sortBy = document.getElementById('sort-by').value;
        const minPrice = document.getElementById('min-price').value;
        const maxPrice = document.getElementById('max-price').value;
        
        // Build URL with filters
        let url = new URL(window.location.href);
        url.searchParams.delete('category');
        url.searchParams.delete('sort');
        url.searchParams.delete('min_price');
        url.searchParams.delete('max_price');
        
        if (!allChecked && selectedCategories.length > 0) {
            url.searchParams.set('category', selectedCategories[0]); // Using first selected category
        }
        
        if (sortBy && sortBy !== 'latest') {
            url.searchParams.set('sort', sortBy);
        }
        
        if (minPrice) {
            url.searchParams.set('min_price', minPrice);
        }
        
        if (maxPrice) {
            url.searchParams.set('max_price', maxPrice);
        }
        
        window.location.href = url.toString();
    }
    
    // Add to cart functionality
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const productName = this.getAttribute('data-product-name');
            
            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart count
                    document.getElementById('cart-count').textContent = data.cart_count;
                    // Show success message
                    alert(`${productName} added to cart successfully!`);
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
});
</script>
@endsection