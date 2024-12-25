<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\indexcontroller;
use App\Http\Controllers\fromcontroller;


Route::get('/', [indexcontroller::class, 'index']);
Route::get('/frompelanggan', [fromcontroller::class, 'frompelanggan']);

