<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactMessageController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/contacts', [ContactMessageController::class, 'index']);
        Route::post('/contacts', [ContactMessageController::class, 'store']);
        Route::get('/contacts/{contactMessage}', [ContactMessageController::class, 'show']);
    });

    