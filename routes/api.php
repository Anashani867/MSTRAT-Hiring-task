<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);



Route::post('/customers', [CustomerController::class, 'store']);

Route::get('/customers', [CustomerController::class, 'index']);

Route::patch('/customers/{id}/status', [CustomerController::class, 'updateStatus']);
Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);


Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::apiResource('orders', OrderController::class);
Route::delete('orders', [OrderController::class, 'destroy']);


Route::get('/export/products', function () {
    return Excel::download(new ProductsExport, 'products.xlsx');
});


Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});
