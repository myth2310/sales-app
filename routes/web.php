<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\OrderModel;

// Login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Customer Routes
    Route::get('/customer', [DashboardController::class, 'customer'])->name('dashboard.customer');

    // Product Routes
    Route::get('/product', [DashboardController::class, 'product'])->name('dashboard.product');
    Route::get('/form-product', [DashboardController::class, 'formProduct'])->name('dashboard.form-product');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/search-product', [ProductController::class, 'search'])->name('search.product');
    Route::get('/get-product/{id}', [ProductController::class, 'getProduct'])->name('get.product');
    Route::get('/get-product-detail/{id}', [ProductController::class, 'getProductDetail'])->name('get.product.detail');
    Route::get('/product/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');


    // Sales Order Routes
    Route::get('/form-seles-order', [DashboardController::class, 'formPelanggan'])->name('dashboard.form-seles-order');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/sales-order', [OrderController::class, 'index'])->name('sales.order');
    Route::post('/sales-order/filter', [OrderController::class, 'filterOrders'])->name('sales-order.filter');
    Route::get('/orders/{kodePembayaran}', [OrderController::class, 'getOrderDetail'])->name('order.detail');
    Route::post('/status-update', [OrderController::class, 'updateStatus'])->name('sales-order.updateStatus');
    Route::delete('/orders/delete/{kode_pembayaran}', [OrderController::class, 'destroy'])->name('orders.destroy');

});
