<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Vastraavillaa') }}</title>

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js for dropdowns -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Additional styles -->
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
        .hover\\:bg-custom-orange-dark:hover {
            background-color: #e07015;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Header Section -->
        <header class="bg-white shadow-sm sticky top-0 z-50">
            <!-- Top orange bar -->
            <div class="bg-custom-orange text-white">
                <div class="container mx-auto px-4 py-1 text-center text-sm">
                    Special offer: Free shipping on orders over tk 2000!
                </div>
            </div>

            <!-- Main Header -->
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <!-- Logo -->
                <div class="text-2xl font-bold custom-orange">
                    <a href="{{ route('home') }}">বস্ত্র ভিলা</a>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex w-1/2 lg:w-1/3 relative">
                    <input type="text" id="search-input" placeholder="Search for products..." class="w-full py-2 px-4 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-orange-300">
                    <button id="search-button" class="absolute right-0 top-0 mt-1 mr-1 bg-custom-orange text-white p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>

                <!-- Header Icons -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('orders.index') }}" class="text-gray-600 hover:text-custom-orange">
                            <i class="fas fa-history"></i>
                        </a>
                        <!-- User dropdown menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="text-gray-600 hover:text-custom-orange focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </button>
                            
                            <!-- Dropdown menu -->
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md py-1 z-50" style="display: none;">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Your Profile
                                </a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Admin Dashboard
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-custom-orange">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </a>
                    @endauth
                    <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-custom-orange relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        <span id="cart-count" class="absolute -top-2 -right-2 bg-custom-orange text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                    </a>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="container mx-auto px-4 py-2 bg-gray-100">
                <ul class="flex space-x-6 overflow-x-auto">
                    <li><a href="{{ route('home') }}" class="text-gray-700 hover:text-custom-orange font-medium">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-gray-700 hover:text-custom-orange font-medium">All Products</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-700 hover:text-custom-orange font-medium">About</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-700 hover:text-custom-orange font-medium">Contact</a></li>
                </ul>
            </nav>
        </header>

        <!-- Page Content -->
        <main class="container mx-auto px-4 py-6">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white mt-12">
            <div class="container mx-auto px-4 py-10">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-bold custom-orange mb-4">Vastraavillaa</h3>
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
                            <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">Home</a></li>
                            <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white">All Products</a></li>
                            <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white">About Us</a></li>
                            <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white">Contact Us</a></li>
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
                            <li class="flex items-start"><i class="fas fa-map-marker-alt mt-1 mr-2 custom-orange"></i> বস্ত্র ভিলা - Vastra Villa, Rangamati, Bangladesh</li>
                            <li class="flex items-center"><i class="fas fa-phone-alt mr-2 custom-orange"></i> +8801617-512307</li>
                            <li class="flex items-center"><i class="fas fa-envelope mr-2 custom-orange"></i> shop@vastraavillaa.com</li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-500">
                    &copy; {{ date('Y') }} Vastraavillaa. All Rights Reserved. Developed by Bitesoftsolution.
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script>
        // Update cart count dynamically
        document.addEventListener('DOMContentLoaded', function() {
            fetchCartData();
            
            // Refresh cart count every 5 seconds
            setInterval(fetchCartData, 5000);
            
            // Search functionality
            const searchButton = document.getElementById('search-button');
            const searchInput = document.getElementById('search-input');
            
            searchButton.addEventListener('click', function() {
                const query = searchInput.value.trim();
                if (query) {
                    window.location.href = '{{ route("products.index") }}?search=' + encodeURIComponent(query);
                }
            });
            
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const query = searchInput.value.trim();
                    if (query) {
                        window.location.href = '{{ route("products.index") }}?search=' + encodeURIComponent(query);
                    }
                }
            });
        });
        
        function fetchCartData() {
            fetch('{{ route("cart.data") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').textContent = data.count;
                })
                .catch(error => {
                    console.error('Error fetching cart data:', error);
                });
        }
    </script>
    
    @stack('scripts')
</body>
</html>
