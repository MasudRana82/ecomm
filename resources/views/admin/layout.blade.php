<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
   
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="flex min-h-screen relative">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-30 w-64 bg-slate-900 text-white transition-transform duration-300 ease-in-out transform -translate-x-full lg:translate-x-0 lg:static lg:inset-0"
            id="sidebar">
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-center h-16 bg-slate-950 px-4 shadow-md">
                    <h2 class="text-xl font-bold tracking-wider uppercase text-blue-400">Admin Panel</h2>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fas fa-tachometer-alt w-6"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.products.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fas fa-box w-6"></i>
                        <span class="font-medium">Products</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fas fa-tags w-6"></i>
                        <span class="font-medium">Categories</span>
                    </a>

                    <a href="{{ route('admin.orders.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.orders.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fas fa-shopping-cart w-6"></i>
                        <span class="font-medium">Orders</span>
                    </a>
                </nav>

                <div class="p-4 border-t border-slate-800">
                    <a href="{{ route('home') }}"
                        class="flex items-center px-4 py-2 text-sm text-slate-400 hover:text-white transition-colors duration-200">
                        <i class="fas fa-sign-out-alt w-6"></i>
                        <span>Exit to Store</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Mobile overlay -->
        <div class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity duration-300 opacity-0 pointer-events-none lg:hidden"
            id="overlay"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 bg-gray-100 lg:ml-0 transition-all duration-300">
            <!-- Admin Header -->
            <header class="bg-white shadow-sm sticky top-0 z-10">
                <div class="px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <button id="sidebar-toggle"
                            class="lg:hidden text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 mr-4">
                            <span class="sr-only">Open sidebar</span>
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-800">
                            {{ $title ?? 'Dashboard' }}
                        </h1>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- User Profile Dropdown or Info could go here -->
                        <div class="flex items-center text-sm font-medium text-gray-700">
                            <span class="hidden sm:inline-block mr-2">Admin</span>
                            <div
                                class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @if (session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-md shadow-sm">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-md shadow-sm">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            let isSidebarOpen = false;

            function toggleSidebar() {
                isSidebarOpen = !isSidebarOpen;
                if (isSidebarOpen) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('opacity-0', 'pointer-events-none');
                    document.body.style.overflow = 'hidden'; // Prevent scrolling when menu is open
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('opacity-0', 'pointer-events-none');
                    document.body.style.overflow = '';
                }
            }

            sidebarToggle.addEventListener('click', function(e) {
                e.preventDefault();
                toggleSidebar();
            });

            overlay.addEventListener('click', toggleSidebar);
        });
    </script>

    @stack('scripts')
</body>

</html>
