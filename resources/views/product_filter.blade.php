<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ghorer Bazar - E-commerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .custom-orange {
            color: #f58220;
        }
        .bg-custom-orange {
            background-color: #f58220;
        }
        .border-custom-orange {
            border-color: #f58220;
        }
        .hover\:bg-custom-orange-dark:hover {
            background-color: #e07015;
        }
        /* Custom checkbox style */
        .custom-checkbox {
            accent-color: #f58220;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Header Section -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <!-- Top orange bar -->
        <div class="bg-custom-orange text-white">
            <div class="container mx-auto px-4 py-1 text-center text-sm">
                <!-- This is a placeholder for the text in the orange bar. It's difficult to read from the image. -->
                 Special offer: Free shipping on orders over $50!
            </div>
        </div>

        <!-- Main Header -->
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <!-- Logo -->
            <div class="text-2xl font-bold custom-orange">
                GhorerBazar
            </div>

            <!-- Search Bar -->
            <div class="hidden md:flex w-1/2 lg:w-1/3 relative">
                <input type="text" placeholder="Search for products..." class="w-full py-2 px-4 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-orange-300">
                <button class="absolute right-0 top-0 mt-1 mr-1 bg-custom-orange text-white p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>

            <!-- Header Icons -->
            <div class="flex items-center space-x-4">
                <a href="#" class="text-gray-600 hover:text-custom-orange">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </a>
                <a href="#" class="text-gray-600 hover:text-custom-orange relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    <span class="absolute -top-2 -right-2 bg-custom-orange text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                </a>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <!-- Banner Section -->
        <section class="mb-12">
            <div class="bg-yellow-200 rounded-lg overflow-hidden h-48 md:h-64 lg:h-80 flex items-center justify-center">
                <!-- Using a placeholder image that mimics the style -->
                <img src="https://placehold.co/1200x320/FBBF24/333333?text=Organic+%26+Fresh+Products" alt="Promotional Banner" class="w-full h-full object-cover">
            </div>
        </section>

        <!-- Product Listing Section -->
        <section>
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">ALL PRODUCTS</h2>
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Filters Sidebar -->
                <aside class="w-full md:w-1/4 lg:w-1/5 bg-white p-6 rounded-lg shadow-sm h-fit">
                    <div id="filter-accordion">
                        <!-- Category Filter -->
                        <div>
                            <h3 class="text-lg font-semibold mb-3 flex justify-between items-center cursor-pointer">
                                <span>Categories</span>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </h3>
                            <div id="category-filters" class="space-y-2 text-gray-700">
                                <!-- Categories will be injected by JS -->
                            </div>
                        </div>
                         <!-- Price Filter (Placeholder) -->
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold mb-3 flex justify-between items-center cursor-pointer">
                                <span>Price Range</span>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </h3>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-500">Price filtering coming soon.</p>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Products Grid -->
                <div class="w-full md:w-3/4 lg:w-4/5">
                    <!-- Sorting Dropdown -->
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-sm">
                         <p class="text-sm text-gray-600 mb-2 sm:mb-0">Showing <strong id="product-count" class="custom-orange"></strong> products</p>
                         <div class="flex items-center gap-2">
                            <label for="sort-by" class="text-sm font-medium text-gray-700">Sort by:</label>
                            <select id="sort-by" class="border border-gray-300 rounded-md p-2 text-sm focus:ring-orange-300 focus:border-orange-300">
                                 <option value="default">Default</option>
                                 <option value="price-asc">Price: Low to High</option>
                                 <option value="price-desc">Price: High to Low</option>
                                 <option value="name-asc">Name: A to Z</option>
                             </select>
                         </div>
                    </div>
                    <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                        <!-- Product cards will be injected here by JavaScript -->
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto px-4 py-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-bold custom-orange mb-4">GhorerBazar</h3>
                    <p class="text-gray-400">Authentic and fresh products delivered to your doorstep.</p>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Home</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">All Products</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Contact Us</a></li>
                    </ul>
                </div>
                 <div>
                    <h3 class="font-semibold text-lg mb-4">Help</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Shipping Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Return Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-4">Contact Info</h3>
                     <ul class="space-y-2 text-gray-400">
                        <li class="flex items-start"><i class="fas fa-map-marker-alt mt-1 mr-2 custom-orange"></i> 123 Main Street, Dhaka, Bangladesh</li>
                        <li class="flex items-center"><i class="fas fa-phone-alt mr-2 custom-orange"></i> +880 123 456 7890</li>
                        <li class="flex items-center"><i class="fas fa-envelope mr-2 custom-orange"></i> support@ghorerbazar.com</li>
                     </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-500">
                &copy; 2024 GhorerBazar. All Rights Reserved.
            </div>
        </div>
    </footer>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const allProducts = [
                { name: 'Pure Honey', price: 250, image: 'https://placehold.co/300x300/FFF7ED/F58220?text=Honey', category: 'Honey' },
                { name: 'Organic Ghee', price: 450, originalPrice: 500, image: 'https://placehold.co/300x300/FFF7ED/F58220?text=Ghee', category: 'Ghee & Butters' },
                { name: 'Mustard Oil', price: 180, image: 'https://placehold.co/300x300/FFF7ED/F58220?text=Oil', category: 'Oils' },
                { name: 'Black Seed Oil', price: 320, image: 'https://placehold.co/300x300/FFF7ED/F58220?text=Black+Seed+Oil', category: 'Oils' },
                { name: 'Mixed Nuts', price: 600, originalPrice: 650, image: 'https://placehold.co/300x300/FFF7ED/F58220?text=Nuts', category: 'Nuts & Seeds' },
                { name: 'Dried Figs', price: 550, image: 'https://placehold.co/300x300/FFF7ED/F58220?text=Figs', category: 'Dry Fruits' },
                { name: 'Saffron', price: 900, image: 'https://placehold.co/300x300/FFF7ED/F58220?text=Saffron', category: 'Spices' },
                { name: 'Turmeric Powder', price: 80, originalPrice: 90, image: 'https://placehold.co/300x300/FFF7ED/F58220?text=Turmeric', category: 'Spices' },
                { name: 'Chilli Powder', price: 70, image: 'https://placehold.co/300x300/FFF7ED/F58220?text=Chilli', category: 'Spices' },
                { name: 'Brown Sugar', price: 120, image: 'https://placehold.co/300x300/FFF7ED/F58220?text=Sugar', category: 'Sweeteners' },
                { name: 'Cashew Nuts', price: 750, image: 'https://placehold.co/300x300/FFF7ED/F58220?text=Cashew', category: 'Nuts & Seeds' },
                { name: 'Almonds', price: 800, image: 'https://placehold.co/300x300/FFF7ED/F58220?text=Almonds', category: 'Nuts & Seeds' },
                { name: 'Premium Dates', price: 400, originalPrice: 450, image: 'https://placehold.co/300x300/FFF7ED/F58220?text=Dates', category: 'Dry Fruits' },
                { name: 'Olive Oil', price: 1200, image: 'https://placehold.co/300x300/FFF7ED/F58220?text=Olive+Oil', category: 'Oils' },
                { name: 'Coconut Oil', price: 280, image: 'https://placehold.co/300x300/FFF7ED/F58220?text=Coconut+Oil', category: 'Oils' },
                { name: 'Cinnamon Sticks', price: 150, image: 'https://placehold.co/300x300/FFF7ED/F58220?text=Cinnamon', category: 'Spices' },
                { name: 'Black Litchi Honey', price: 350, originalPrice: 400, image: 'https://placehold.co/300x300/FFF7ED/F58220?text=Litchi+Honey', category: 'Honey' },
                { name: 'Pistachios', price: 950, image: 'https://placehold.co/300x300/FFF7ED/F58220?text=Pistachios', category: 'Nuts & Seeds' },
            ];

            const productGrid = document.getElementById('product-grid');
            const categoryFiltersContainer = document.getElementById('category-filters');
            const sortBySelect = document.getElementById('sort-by');
            const productCountSpan = document.getElementById('product-count');

            function renderProducts(productsToRender) {
                productGrid.innerHTML = '';
                productCountSpan.textContent = productsToRender.length;

                if (productsToRender.length === 0) {
                    productGrid.innerHTML = `<p class="col-span-full text-center text-gray-500 py-10">No products found matching your criteria.</p>`;
                    return;
                }

                productsToRender.forEach(product => {
                    const discountHTML = product.originalPrice ?
                        `<span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded-full">- ${Math.round(((product.originalPrice - product.price) / product.originalPrice) * 100)}%</span>` : '';

                    const priceHTML = product.originalPrice ?
                        `<p class="text-lg font-bold custom-orange">৳${product.price} <span class="text-sm font-normal text-gray-500 line-through">৳${product.originalPrice}</span></p>` :
                        `<p class="text-lg font-bold custom-orange">৳${product.price}</p>`;

                    const productCard = `
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden group text-center relative flex flex-col justify-between">
                            <div>
                                ${discountHTML}
                                <a href="#" class="block">
                                    <img src="${product.image}" alt="${product.name}" class="w-full h-40 md:h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                </a>
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-800 truncate h-6">${product.name}</h3>
                                    ${priceHTML}
                                </div>
                            </div>
                            <div class="p-4 pt-0">
                                <button class="w-full bg-custom-orange text-white py-2 rounded-md hover:bg-custom-orange-dark transition-colors duration-300">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    `;
                    productGrid.innerHTML += productCard;
                });
            }

            function populateFilters() {
                const categories = [...new Set(allProducts.map(p => p.category))].sort();
                categoryFiltersContainer.innerHTML = '';
                categories.forEach(category => {
                    const filterHtml = `
                        <div class="flex items-center">
                            <input type="checkbox" id="cat-${category.replace(/ & /g, '-')}" name="category" value="${category}" class="custom-checkbox category-checkbox h-4 w-4 rounded border-gray-300 text-orange-500 focus:ring-orange-200">
                            <label for="cat-${category.replace(/ & /g, '-')}" class="ml-2 text-sm text-gray-600">${category}</label>
                        </div>
                    `;
                    categoryFiltersContainer.innerHTML += filterHtml;
                });
            }

            function applyFiltersAndSorting() {
                let filteredProducts = [...allProducts];

                // Category filtering
                const selectedCategories = Array.from(document.querySelectorAll('.category-checkbox:checked')).map(cb => cb.value);
                if (selectedCategories.length > 0) {
                    filteredProducts = filteredProducts.filter(p => selectedCategories.includes(p.category));
                }

                // Sorting
                const sortBy = sortBySelect.value;
                if (sortBy === 'price-asc') {
                    filteredProducts.sort((a, b) => a.price - b.price);
                } else if (sortBy === 'price-desc') {
                    filteredProducts.sort((a, b) => b.price - a.price);
                } else if (sortBy === 'name-asc') {
                    filteredProducts.sort((a, b) => a.name.localeCompare(b.name));
                } else {
                     // Default sort can be added here if needed, e.g., by name
                }

                renderProducts(filteredProducts);
            }
            
            // Event Listeners
            sortBySelect.addEventListener('change', applyFiltersAndSorting);
            categoryFiltersContainer.addEventListener('change', (event) => {
                if (event.target.classList.contains('category-checkbox')) {
                    applyFiltersAndSorting();
                }
            });

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

            // Initial setup
            populateFilters();
            applyFiltersAndSorting();
        });
    </script>
</body>
</html>

