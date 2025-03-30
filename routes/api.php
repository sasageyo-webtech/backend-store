<?php

use App\Http\Controllers\API\AddressCustomerController;
use App\Http\Controllers\API\Auth\AuthenticateController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ImageProductController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\UserController;
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
    Route::get('products/categories/{category}', [ProductController::class, 'getProductByCategoryId'])->name('products.category');
    Route::get('products/brands/{brand}', [ProductController::class, 'getProductByBrandId'])->name('products.brand');

    //category
    Route::get('categories', [CategoryController::class, 'index']);
    Route::post('categories', [CategoryController::class, 'store']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);
    Route::put('categories/{category}', [CategoryController::class, 'update']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

    //brands
    Route::get('brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('brands/{brand}', [BrandController::class, 'show'])->name('brands.show');
    Route::post('brands', [BrandController::class, 'store'])->name('brands.store');
    Route::put('brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');


    //<------------------ Must Auth ------------------>//

    //users
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/{user}', [UserController::class, 'show'])->name('user.show');
    Route::put('users/{user}/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::delete('users/revoke', [AuthenticateController::class, 'revoke'])->name('user.revoke');

    //products
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::put('products/{product}', [ProductController::class, 'update']);
    Route::delete('products/{product}', [ProductController::class, 'destroy']);
    Route::patch('products/{product}/add-stock', [ProductController::class, 'addStock'])->name('products.add.stock');
    Route::post('products/images', [ImageProductController::class, 'store'])->name('products.images.store');
    Route::delete('products/images/{image_product_id}', [ImageProductController::class, 'destroy'])->name('products.images.destroy');

    //carts
    Route::get('carts', [CartController::class, 'index'])->name('carts.index');
    Route::post('carts', [CartController::class, 'store']); // เพิ่มสินค้าลงในตะกร้า
    Route::delete('carts/{cart}', [CartController::class, 'destroy']); // ลบสินค้าจากตะกร้า

    //address_customers
    Route::get('address-customers', [AddressCustomerController::class, 'index'])->name('address-customers.index');
    Route::get('address-customers/{addressCustomer}', [AddressCustomerController::class, 'show'])->name('address-customer.show'); // แสดงที่อยู่
    Route::post('address-customers', [AddressCustomerController::class, 'store'])->name('address-customer.store'); // สร้างที่อยู่ใหม่
    Route::put('address-customers/{addressCustomer}', [AddressCustomerController::class, 'update'])->name('address-customer.update'); // อัปเดตที่อยู่
    Route::delete('address-customers/{addressCustomer}', [AddressCustomerController::class, 'destroy'])->name('address-customer.delete'); // ลบที่อยู่

    //orders
    Route::get('staffs/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('customers/orders/{customer}', [OrderController::class, 'getOrderCustomer'])->name('orders.getOrderCustomer');
    Route::post('customers/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
});

Route::middleware(["throttle:api", "auth:sanctum"])->as('api.')->group(function() {

});


