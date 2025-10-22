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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 transition duration-300 ease-in-out transform -translate-x-full lg:translate-x-0 lg:static lg:z-auto lg:w-64 lg:block fixed lg:relative lg:inset-y-0 lg:block z-30" id="sidebar">
            <div class="p-4 h-full">
                <h2 class="text-xl font-bold mb-6 text-white">Admin Panel</h2>
                <nav>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" 
                               class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600' : '' }}">
                                <i class="fas fa-tachometer-alt mr-3"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.products.index') }}" 
                               class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 {{ request()->routeIs('admin.products.*') ? 'bg-blue-600' : '' }}">
                                <i class="fas fa-box mr-3"></i>
                                <span>Products</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.categories.index') }}" 
                               class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600' : '' }}">
                                <i class="fas fa-tags mr-3"></i>
                                <span>Categories</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.orders.index') }}" 
                               class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 {{ request()->routeIs('admin.orders.*') ? 'bg-blue-600' : '' }}">
                                <i class="fas fa-shopping-cart mr-3"></i>
                                <span>Orders</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Mobile overlay -->
        <div class="fixed inset-0 z-20 bg-black bg-opacity-50 hidden lg:hidden" id="overlay"></div>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-0">
            <!-- Admin Header -->
            <header class="bg-white shadow-sm sticky top-0 z-10">
                <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <div class="flex items-center">
                        <button id="sidebar-toggle" class="lg:hidden text-gray-500 hover:text-gray-700 mr-4">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                        <h1 class="text-xl font-bold text-gray-900">
                            {{ $title ?? 'Admin Dashboard' }}
                        </h1>
                    </div>
                    <div>
                        <a href="{{ route('home') }}" class="text-custom-orange hover:text-orange-700 flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Store
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
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
            
            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
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