<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactFormController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\Api\UserController as ApiUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public contact form submission endpoint for mobile and third-party clients
Route::post('/contact', [ContactFormController::class, 'store']);

// Public endpoint for products (with seller info)
Route::get('/products', [ApiProductController::class, 'index']);

// Auth endpoints
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');
Route::post('/register', [AuthController::class, 'register']);
