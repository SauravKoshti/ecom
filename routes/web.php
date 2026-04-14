<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', fn () => redirect()->route('admin.dashboard'));
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'postLogin'])->name('admin.login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('admin.registration');
Route::post('registration', [AuthController::class, 'postRegistration'])->name('admin.registration.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('brands', BrandController::class)->except('show');
    Route::resource('properties', PropertyController::class)->except('show');
    Route::resource('products', ProductController::class)->except('show');
    Route::resource('users', UserController::class)->except('show');
});
