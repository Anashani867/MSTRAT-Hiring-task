<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;



Route::get('/', function () {
    return view('dashboard');
});

Route::get('/customers', [CustomerController::class, 'indexView'])->name('customers.index');
Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
Route::delete('/customers', [CustomerController::class, 'destroy']);
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');

Route::get('/products', function () {
    return view('products.index');
});

Route::get('/products/create', function () {
    return view('products.create');
});
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

Route::get('/orders', function() {
    return view('orders.index');
});

