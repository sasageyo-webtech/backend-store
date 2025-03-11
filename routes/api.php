<?php

use App\Http\Controllers\API\Auth\AuthenticateController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(["throttle:api", "auth:sanctum"])->as('api.')->group(function() {
    //users
    Route::delete('revoke', [AuthenticateController::class, 'revoke'])->name('user.revoke');

    //products
    Route::apiResource('products', ProductController::class);

    //category
    Route::apiResource('categories', CategoryController::class);

    //carts
    Route::get('carts', [CartController::class, 'index'])->name('carts.index'); // แสดงรายการสินค้าในตะกร้า
    Route::post('carts', [CartController::class, 'store']); // เพิ่มสินค้าลงในตะกร้า
    Route::delete('carts/{id}', [CartController::class, 'destroy']); // ลบสินค้าจากตะกร้า
    Route::post('carts/confirm', [CartController::class, 'confirmOrder']); // ยืนยันการสั่งซื้อ
});

Route::middleware("throttle:api")->as('api.')->group(function() {
    //start api
    Route::get('/', function () {
        return [
            'success' => true,
            'version' => '1.0.0',
        ];
    })->name('root');

    //users
    Route::prefix("users")->as("users.")->group(function() {
        Route::post('login', [AuthenticateController::class, 'login'])->name('user.login');
        Route::post('register', [AuthenticateController::class, 'register'])->name('user.register');
    });

    //products
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('products/search', [ProductController::class, 'products.search'])->name('products.search');


});




