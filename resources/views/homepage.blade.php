@extends('layouts.app')

@section('content')
    <!-- Banner Section -->
    <section class="mb-12">
        <div class="bg-yellow-200 rounded-lg overflow-hidden h-48 md:h-64 lg:h-80 flex items-center justify-center">
            <img src="https://ghorerbazar.com/cdn/shop/files/web-Banner.jpg?v=1756728692" alt="Promotional Banner"
                class="w-full h-full object-cover">
        </div>
    </section>

    <!-- Collection Section -->
    <!-- <section class="mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">COLLECTION</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @forelse($categories as $category)
                    <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                        <a href="{{ route('category.show', $category->slug) }}">
                            @if ($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                    class="mx-auto h-24 mb-2 object-cover">
                            @else
                                <img src="https://placehold.co/200x150/FEF3C7/8B5CF6?text={{ urlencode($category->name) }}"
                                    class="mx-auto h-24 mb-2">
                            @endif
                            <h3 class="font-semibold">{{ $category->name }}</h3>
                        </a>
                    </div>
                @empty
                    <div class="col-span-4 text-center text-gray-500">
                        <p>No categories available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </section> -->

    <!-- All Products Section -->
    <section>
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">ALL PRODUCTS</h2>
        <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6">
            @forelse($products as $product)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden group text-center relative">
                    @if ($product->discount_percentage > 0)
                        <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded-full">
                            -{{ $product->discount_percentage }}%
                        </span>
                    @endif

                    <a href="{{ route('products.show', $product->slug) }}" class="block">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-40 md:h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <img src="https://placehold.co/300x300/FFF7ED/F58220?text={{ urlencode($product->name) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-40 md:h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        @endif
                    </a>

                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 truncate" style="font-family: 'Hind Siliguri', sans-serif;">{{ $product->name }}</h3>

                        @if ($product->compare_price > $product->price)
                            <p class="text-lg font-bold custom-orange">
                                ৳{{ number_format($product->price, 2) }}
                                <span
                                    class="text-sm font-normal text-gray-500 line-through">৳{{ number_format($product->compare_price, 2) }}</span>
                            </p>
                        @else
                            <p class="text-lg font-bold custom-orange">৳{{ number_format($product->price, 2) }}</p>
                        @endif

                        <button
                            class="mt-3 w-full bg-custom-orange text-white py-2 rounded-md hover:bg-custom-orange-dark transition-colors duration-300 add-to-cart"
                            data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}">
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
                <div class="col-span-full text-center text-gray-500">
                    <p>No products available at the moment.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination is not shown on homepage as we're displaying limited featured products -->
    </section>

    <!-- Include the Product Options Modal -->
    @include('components.product-options-modal')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Add to cart functionality - now opens modal
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function () {
                    const productId = this.getAttribute('data-product-id');
                    const productName = this.getAttribute('data-product-name');
                    openProductModal(productId, productName, false);
                });
            });

            // Buy Now functionality - now opens modal
            document.querySelectorAll('.buy-now-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const productId = this.getAttribute('data-product-id');
                    const productName = this.getAttribute('data-product-name');
                    openProductModal(productId, productName, true);
                });
            });
        });
    </script>
@endsection