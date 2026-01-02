<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'বস্ত্র ভিলা') }}</title>

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js for dropdowns -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Additional styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Hind Siliguri', sans-serif;
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

    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1157339239554606');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=1157339239554606&ev=PageView&noscript=1" />
    </noscript>
    <!-- End Meta Pixel Code -->
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Header Section -->
        <header class="bg-white shadow-sm top-0 z-50"> 
            <!-- Top orange bar -->
            <div class="bg-custom-orange text-white">
                <div class="container mx-auto px-4 py-1 text-center text-sm">
                  রাংগামাটির তৈরি পিনন,থামি,গুজরাটি ব্যাগ এবং তাতের থ্রিপিস ও অলংকার পুর্ন কাপড়ের বিশ্বস্থ প্রতিষ্ঠান।
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
                    <input type="text" id="search-input" placeholder="Search for products..."
                        class="w-full py-2 px-4 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-orange-300">
                    <button id="search-button"
                        class="absolute right-0 top-0 mt-1 mr-1 bg-custom-orange text-white p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md py-1 z-50"
                                style="display: none;">
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Your Profile
                                </a>
                                @if (auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Admin Dashboard
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-custom-orange">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </a>
                    @endauth
                    <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-custom-orange relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span id="cart-count"
                            class="absolute -top-2 -right-2 bg-custom-orange text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                    </a>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="container mx-auto px-4 py-2 bg-gray-100">
                <ul class="flex space-x-6 overflow-x-auto">
                    <li><a href="{{ route('home') }}"
                            class="text-gray-700 hover:text-custom-orange font-medium">Home</a></li>
                    <li><a href="{{ route('products.index') }}"
                            class="text-gray-700 hover:text-custom-orange font-medium">All Products</a></li>
                    <li><a href="{{ route('about') }}"
                            class="text-gray-700 hover:text-custom-orange font-medium">About</a></li>
                    <li><a href="{{ route('contact') }}"
                            class="text-gray-700 hover:text-custom-orange font-medium">Contact</a></li>
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
                        <h3 class="text-lg font-bold custom-orange mb-4">বস্ত্র ভিলা</h3>
                        <p class="text-gray-400">রাংগামাটির তৈরি পিনন,থামি,গুজরাটি ব্যাগ এবং তাতের থ্রিপিস ও অলংকার পুর্ন কাপড়ের বিশ্বস্থ প্রতিষ্ঠান।</p>
                        <div class="flex space-x-4 mt-4">
                            <a href="https://www.facebook.com/vastraavillaaa" class="text-gray-400 hover:text-white"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a href="https://www.instagram.com/vastraavillaaa" class="text-gray-400 hover:text-white"><i
                                    class="fab fa-instagram"></i></a>
                            <a href="https://www.youtube.com/@Vastraavilla" class="text-gray-400 hover:text-white"><i
                                    class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                    <!-- <div>
                        <h3 class="font-semibold text-lg mb-4">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">Home</a></li>
                            <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white">All
                                    Products</a></li>
                            <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white">About Us</a>
                            </li>
                            <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white">Contact
                                    Us</a></li>
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
                    </div> -->
                    <div>
                        <h3 class="font-semibold text-lg mb-4">Contact Info</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li class="flex items-start"><i class="fas fa-map-marker-alt mt-1 mr-2 custom-orange"></i>
                                বস্ত্র ভিলা - Vastra Villa, Rangamati, Bangladesh</li>
                            <li class="flex items-center"><i class="fas fa-phone-alt mr-2 custom-orange"></i>
                                +8801617-512307</li>
                            <li class="flex items-center"><i class="fas fa-envelope mr-2 custom-orange"></i>
                                shop@vastraavillaa.com</li>
                            <li class="flex items-center"><i class="fas fa-clock mr-2 custom-orange"></i>
                               Return Policy</li>
                                
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
                    window.location.href = '{{ route('products.index') }}?search=' + encodeURIComponent(
                        query);
                }
            });

            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const query = searchInput.value.trim();
                    if (query) {
                        window.location.href = '{{ route('products.index') }}?search=' +
                            encodeURIComponent(query);
                    }
                }
            });
        });

        function fetchCartData() {
            fetch('{{ route('cart.data') }}')
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
    <!-- WhatsApp Chat Button Generated by Tool -->
<a href="https://wa.me/8801617512307" class="wapp-chat-btn" target="_blank">
    <svg class="wapp-chat-icon" fill="currentColor" viewBox="0 0 16 16"><path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/></svg>
    <span></span>
</a>

<style>
.wapp-chat-btn {
    position: fixed;
    bottom: 1.5em; right: 1.5em;
    background-color: #25d366;
    color: #ffffff;
    font-family: sans-serif;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.6em 1.2em;
    border-radius: 8px;
    min-height: 44px;
    text-decoration: none;
    box-shadow: 0 0.3em 0.6em rgba(0, 0, 0, 0.2);
    z-index: 1000;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.wapp-chat-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5em 1em rgba(0, 0, 0, 0.25);
}
.wapp-chat-icon {
    width: 24px;
    height: 24px;
    margin-right: 0;
}
</style>
</body>

</html>
