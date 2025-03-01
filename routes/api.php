<?php

use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware("throttle:api")->group(function() {
    //start api
    Route::get('/', function () {
        return [
            'success' => true,
            'version' => '1.0.0',
        ];
    })->name('root');

    //products
    Route::apiResource('products', ProductController::class);
});

