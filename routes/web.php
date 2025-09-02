<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

Route::view('/', 'welcome')->name('welcome');
Route::view('/home', 'pages.home')->name('home');

// Public pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');

// Contact form submission
use App\Http\Controllers\ContactController;
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');

// routes/web.php
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->group(function () {

        // user default: send to public home instead of a user dashboard
        Route::get('/dashboard', fn() => redirect()->route('home'))->name('dashboard');

        Route::middleware(RoleMiddleware::class . ':seller')->group(function () {
            Route::get('/seller/dashboard', fn() => view('dashboards.seller'))->name('seller.dashboard');
        });

        Route::middleware(RoleMiddleware::class . ':admin')->group(function () {
            Route::get('/admin/dashboard', fn() => view('dashboards.admin'))->name('admin.dashboard');
        });
    });
