<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/{id}/related', [ProductController::class, 'related']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::get('/categories/{id}/products', [CategoryController::class, 'products']);
