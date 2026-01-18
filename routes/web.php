<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductAdminController;
use App\Http\Controllers\CategoryAdminController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Add this to routes/web.php
Route::get('/link-storage', function () {
    $targetFolder = storage_path('app/public');
    $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';

    if (!file_exists($linkFolder)) {
        symlink($targetFolder, $linkFolder);
        return 'Symlink created successfully.';
    } else {
        return 'Symlink already exists.';
    }
});

// Home route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Profile routes
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('auth');

// Dashboard route
Route::get('/dashboard', function () {
    return redirect()->route('profile.edit');
})->name('dashboard');

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/filter', [ProductController::class, 'filterProducts'])->name('products.filter');

// API route for product details (for modal)
Route::get('/api/products/{id}', [ProductController::class, 'getProductDetails'])->name('api.products.show');


// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/data', [CartController::class, 'getCartData'])->name('cart.data');

// Checkout routes
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index')->middleware('auth');
Route::get('/orders/{orderNumber}', [OrderController::class, 'show'])->name('orders.show');

// Admin routes for product and category management
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Admin dashboard
    Route::get('/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('products', ProductAdminController::class)->names([
        'index' => 'admin.products.index',
        'show' => 'admin.products.show',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);
    Route::resource('categories', CategoryAdminController::class)->names([
        'index' => 'admin.categories.index',
        'show' => 'admin.categories.show',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);
    Route::resource('orders', OrderAdminController::class)->names([
        'index' => 'admin.orders.index',
        'show' => 'admin.orders.show',
        'create' => 'admin.orders.create',
        'store' => 'admin.orders.store',
        'edit' => 'admin.orders.edit',
        'update' => 'admin.orders.update',
        'destroy' => 'admin.orders.destroy',
    ]);

    // Invoice route
    Route::get('orders/{id}/invoice', [OrderAdminController::class, 'invoice'])->name('admin.orders.invoice');

    // Payment Gateway Management Routes
    Route::get('payment-gateways', [App\Http\Controllers\PaymentGatewayController::class, 'index'])->name('admin.payment-gateways.index');
    Route::get('payment-gateways/{id}/edit', [App\Http\Controllers\PaymentGatewayController::class, 'edit'])->name('admin.payment-gateways.edit');
    Route::put('payment-gateways/{id}', [App\Http\Controllers\PaymentGatewayController::class, 'update'])->name('admin.payment-gateways.update');
    Route::patch('payment-gateways/{id}/toggle', [App\Http\Controllers\PaymentGatewayController::class, 'toggle'])->name('admin.payment-gateways.toggle');

    // Site Settings Routes
    Route::get('settings', [App\Http\Controllers\SiteSettingController::class, 'index'])->name('admin.settings.index');
    Route::put('settings/logo', [App\Http\Controllers\SiteSettingController::class, 'updateLogo'])->name('admin.settings.update-logo');
});

// Payment routes
Route::post('/payment/process/{orderNumber}', [PaymentController::class, 'processPayment'])->name('payment.process');
Route::get('/payment/success/{orderNumber}', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/failure/{orderNumber}', [PaymentController::class, 'paymentFailure'])->name('payment.failure');
Route::get('/payment/cancel/{orderNumber}', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');

// Include Breeze authentication routes
require __DIR__ . '/auth.php';

// Category routes
Route::get('/category/{slug}', [App\Http\Controllers\CategoryController::class, 'show'])->name('category.show');

// Additional routes for static pages
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');
