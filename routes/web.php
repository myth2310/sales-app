<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;



Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/customer', [DashboardController::class, 'customer'])->name('dashboard.customer');
Route::get('/sales-order', [DashboardController::class, 'salesOrder'])->name('dashboard.sales-order');
Route::get('/product', [DashboardController::class, 'product'])->name('dashboard.product');
Route::get('/form-product', [DashboardController::class, 'formProduct'])->name('dashboard.form-product');
Route::get('/form-seles-order', [DashboardController::class, 'formPelanggan'])->name('dashboard.form-seles-order');


// Login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


