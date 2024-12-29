<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/customer', [DashboardController::class, 'customer'])->name('dashboard.customer');
Route::get('/sales-order', [DashboardController::class, 'salesOrder'])->name('dashboard.sales-order');
Route::get('/product', [DashboardController::class, 'product'])->name('dashboard.product');
Route::get('/form-product', [DashboardController::class, 'formProduct'])->name('dashboard.form-product');
Route::get('/form-pelanggan', [DashboardController::class, 'formPelanggan'])->name('dashboard.form-pelanggan');

