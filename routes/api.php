<?php

use App\Http\Controllers\API\Auth\AuthenticateController;
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
    Route::
});



