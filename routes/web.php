<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// routes/web.php
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->group(function () {

        // user default
        Route::get('/dashboard', fn() => view('dashboards.user'))->name('dashboard');

        Route::middleware('role:seller')->group(function () {
            Route::get('/seller/dashboard', fn() => view('dashboards.seller'))->name('seller.dashboard');
        });

        Route::middleware('role:admin')->group(function () {
            Route::get('/admin/dashboard', fn() => view('dashboards.admin'))->name('admin.dashboard');
        });
    });

