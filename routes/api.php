<?php

use App\Http\Controllers\API\Auth\AuthenticateController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware(["throttle:api"])->as('api.')->group(function() {
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
    Route::get('products/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('products/{product}', [ProductController::class, 'show']);

    //category
    Route::get('categories', [CategoryController::class, 'index']);
    Route::post('categories', [CategoryController::class, 'store']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);
    Route::put('categories/{category}', [CategoryController::class, 'update']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);


    //<------------------ Must Auth ------------------>//

    //users
    Route::delete('revoke', [AuthenticateController::class, 'revoke'])->name('user.revoke');

    //products
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::put('products/{product}', [ProductController::class, 'update']);
    Route::delete('products/{product}', [ProductController::class, 'destroy']);

    //carts
    Route::get('carts', [CartController::class, 'index'])->name('carts.index'); // แสดงรายการสินค้าในตะกร้า
    Route::post('carts', [CartController::class, 'store']); // เพิ่มสินค้าลงในตะกร้า
    Route::delete('carts/{id}', [CartController::class, 'destroy']); // ลบสินค้าจากตะกร้า
    Route::post('carts/confirm', [CartController::class, 'confirmOrder']); // ยืนยันการสั่งซื้อ
});

Route::middleware(["throttle:api", "auth:sanctum"])->as('api.')->group(function() {

});


