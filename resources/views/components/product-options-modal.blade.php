<!-- Product Options Modal -->
<div id="product-options-modal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto transform transition-all">
        <!-- Modal Header -->
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900" id="modal-product-name">Select Options</h3>
            <button onclick="closeProductModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <!-- Product Image and Info -->
            <div class="flex gap-4 mb-6">
                <div class="w-24 h-24 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                    <img id="modal-product-image" src="" alt="" class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-900 mb-1" id="modal-product-title"></h4>
                    <p class="text-2xl font-bold custom-orange" id="modal-product-price"></p>
                </div>
            </div>

            <!-- Color Selection -->
            <div id="modal-color-section" class="mb-6 hidden">
                <h4 class="text-sm font-medium text-gray-900 mb-3">Select Color <span class="text-red-500">*</span></h4>
                <div id="modal-color-options" class="flex flex-wrap gap-2">
                    <!-- Color options will be populated here -->
                </div>
                <p id="color-error" class="text-red-500 text-sm mt-1 hidden">Please select a color</p>
            </div>

            <!-- Size Selection -->
            <div id="modal-size-section" class="mb-6 hidden">
                <h4 class="text-sm font-medium text-gray-900 mb-3">Select Size <span class="text-red-500">*</span></h4>
                <div id="modal-size-options" class="flex flex-wrap gap-2">
                    <!-- Size options will be populated here -->
                </div>
                <p id="size-error" class="text-red-500 text-sm mt-1 hidden">Please select a size</p>
            </div>

            <!-- Quantity -->
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-900 mb-3">Quantity</h4>
                <div class="flex items-center">
                    <button type="button" onclick="decreaseModalQty()"
                        class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-l-md bg-gray-100 hover:bg-gray-200 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </button>
                    <input type="number" id="modal-quantity" min="1" value="1"
                        class="w-20 h-10 text-center border-y border-gray-300 focus:outline-none focus:ring-2 focus:ring-custom-orange">
                    <button type="button" onclick="increaseModalQty()"
                        class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-r-md bg-gray-100 hover:bg-gray-200 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                    </button>
                    <span class="ml-4 text-sm text-gray-500">
                        <span id="modal-stock-info"></span>
                    </span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <button id="modal-add-to-cart-btn"
                    class="flex-1 bg-custom-orange text-white py-3 px-6 rounded-md hover:bg-custom-orange-dark transition-colors duration-300 font-semibold">
                    Add to Cart
                </button>
                <button id="modal-buy-now-btn"
                    class="flex-1 bg-gray-900 text-white py-3 px-6 rounded-md hover:bg-gray-800 transition-colors duration-300 font-semibold">
                    Buy Now
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let modalProductData = {
        id: null,
        name: null,
        price: null,
        image: null,
        colors: [],
        sizes: [],
        maxQuantity: 1,
        isBuyNow: false
    };

    function openProductModal(productId, productName, isBuyNow = false) {
        modalProductData.isBuyNow = isBuyNow;

        // Fetch product details
        fetch(`/api/products/${productId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const product = data.product;

                    // Store product data
                    modalProductData.id = product.id;
                    modalProductData.name = product.name;
                    modalProductData.price = product.price;
                    modalProductData.image = product.image;
                    modalProductData.colors = product.colors || [];
                    modalProductData.sizes = product.sizes || [];
                    modalProductData.maxQuantity = product.quantity || 1;

                    // Populate modal
                    document.getElementById('modal-product-name').textContent = product.name;
                    document.getElementById('modal-product-title').textContent = product.name;
                    document.getElementById('modal-product-price').textContent = `৳${parseFloat(product.price).toFixed(2)}`;
                    document.getElementById('modal-product-image').src = product.image_url;
                    document.getElementById('modal-product-image').alt = product.name;
                    document.getElementById('modal-stock-info').textContent = `${product.quantity} available`;
                    document.getElementById('modal-quantity').max = product.quantity;

                    // Show/hide and populate color options
                    const colorSection = document.getElementById('modal-color-section');
                    const colorOptions = document.getElementById('modal-color-options');

                    if (product.colors && product.colors.length > 0) {
                        colorSection.classList.remove('hidden');
                        colorOptions.innerHTML = '';
                        product.colors.forEach((color, index) => {
                            const colorHtml = `
                                <label class="cursor-pointer">
                                    <input type="radio" name="modal-color" value="${color}" 
                                        class="peer sr-only modal-color-selector" 
                                        ${index === 0 ? 'checked' : ''}>
                                    <div class="px-4 py-2 border-2 border-gray-300 rounded-md peer-checked:border-custom-orange peer-checked:bg-orange-50 peer-checked:text-custom-orange hover:border-gray-400 transition-all font-medium">
                                        ${color}
                                    </div>
                                </label>
                            `;
                            colorOptions.innerHTML += colorHtml;
                        });
                    } else {
                        colorSection.classList.add('hidden');
                    }

                    // Show/hide and populate size options
                    const sizeSection = document.getElementById('modal-size-section');
                    const sizeOptions = document.getElementById('modal-size-options');

                    if (product.sizes && product.sizes.length > 0) {
                        sizeSection.classList.remove('hidden');
                        sizeOptions.innerHTML = '';
                        product.sizes.forEach((size, index) => {
                            const sizeHtml = `
                                <label class="cursor-pointer">
                                    <input type="radio" name="modal-size" value="${size}" 
                                        class="peer sr-only modal-size-selector"
                                        ${index === 0 ? 'checked' : ''}>
                                    <div class="px-4 py-2 border-2 border-gray-300 rounded-md peer-checked:border-custom-orange peer-checked:bg-orange-50 peer-checked:text-custom-orange hover:border-gray-400 transition-all font-medium">
                                        ${size}
                                    </div>
                                </label>
                            `;
                            sizeOptions.innerHTML += sizeHtml;
                        });
                    } else {
                        sizeSection.classList.add('hidden');
                    }

                    // Reset quantity
                    document.getElementById('modal-quantity').value = 1;

                    // Hide error messages
                    document.getElementById('color-error').classList.add('hidden');
                    document.getElementById('size-error').classList.add('hidden');

                    // Show modal
                    document.getElementById('product-options-modal').classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                } else {
                    alert('Error loading product details');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while loading product details');
            });
    }

    function closeProductModal() {
        document.getElementById('product-options-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function decreaseModalQty() {
        const input = document.getElementById('modal-quantity');
        const currentQty = parseInt(input.value);
        if (currentQty > 1) {
            input.value = currentQty - 1;
        }
    }

    function increaseModalQty() {
        const input = document.getElementById('modal-quantity');
        const currentQty = parseInt(input.value);
        const maxQty = parseInt(input.max);
        if (currentQty < maxQty) {
            input.value = currentQty + 1;
        }
    }

    function validateModalSelections() {
        let isValid = true;

        // Check color selection if colors exist
        if (modalProductData.colors && modalProductData.colors.length > 0) {
            const colorSelected = document.querySelector('input[name="modal-color"]:checked');
            if (!colorSelected) {
                document.getElementById('color-error').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('color-error').classList.add('hidden');
            }
        }

        // Check size selection if sizes exist
        if (modalProductData.sizes && modalProductData.sizes.length > 0) {
            const sizeSelected = document.querySelector('input[name="modal-size"]:checked');
            if (!sizeSelected) {
                document.getElementById('size-error').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('size-error').classList.add('hidden');
            }
        }

        return isValid;
    }

    function addToCartFromModal(isBuyNow) {
        if (!validateModalSelections()) {
            return;
        }

        const quantity = parseInt(document.getElementById('modal-quantity').value);
        const maxQty = modalProductData.maxQuantity;

        if (quantity > maxQty) {
            alert(`Only ${maxQty} items available in stock.`);
            document.getElementById('modal-quantity').value = maxQty;
            return;
        }

        // Get selected options
        let color = null;
        const colorInput = document.querySelector('input[name="modal-color"]:checked');
        if (colorInput) color = colorInput.value;

        let size = null;
        const sizeInput = document.querySelector('input[name="modal-size"]:checked');
        if (sizeInput) size = sizeInput.value;

        // Add to cart
        fetch('{{ route('cart.add') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_id: modalProductData.id,
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

                    closeProductModal();

                    if (isBuyNow) {
                        window.location.href = "{{ route('checkout') }}";
                    } else {
                        alert(`${modalProductData.name} added to cart successfully!`);
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

    // Event listeners for modal buttons
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('modal-add-to-cart-btn').addEventListener('click', function () {
            addToCartFromModal(false);
        });

        document.getElementById('modal-buy-now-btn').addEventListener('click', function () {
            addToCartFromModal(true);
        });

        // Close modal on outside click
        document.getElementById('product-options-modal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeProductModal();
            }
        });

        // Close modal on ESC key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeProductModal();
            }
        });
    });
</script>

<style>
    .custom-orange {
        color: #f58220;
    }

    .bg-custom-orange {
        background-color: #f58220;
    }

    .bg-custom-orange-dark {
        background-color: #d9720f;
    }

    .border-custom-orange {
        border-color: #f58220;
    }

    .peer-checked\:border-custom-orange:checked~* {
        border-color: #f58220;
    }
</style>