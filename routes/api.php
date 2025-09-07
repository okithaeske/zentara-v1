<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\SellerProductController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\Api\UserController as ApiUserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/contacts', [ContactMessageController::class, 'index']);
        Route::post('/contacts', [ContactMessageController::class, 'store']);
        Route::get('/contacts/{contactMessage}', [ContactMessageController::class, 'show']);
    });



// Public endpoint for products (with seller info)
Route::get('/products', [ApiProductController::class, 'index']);

// Public user endpoints
Route::get('/users', [ApiUserController::class, 'index']);


    
