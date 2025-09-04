<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
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
        // Quick test route to verify email sending (logs in dev)
        Route::get('/test-email', function () {
            $user = auth()->user();
            Mail::raw('This is a test email from ' . config('app.name'), function ($m) use ($user) {
                $m->to($user->email, $user->name)->subject('Test Email');
            });

            return 'Test email dispatched. Check your mail delivery or storage/logs/laravel.log if MAIL_MAILER=log (default).';
        })->name('test-email');

        // user default: send to public home instead of a user dashboard
        Route::get('/dashboard', fn() => redirect()->route('home'))->name('dashboard');

        Route::middleware(RoleMiddleware::class . ':seller')->group(function () {
            Route::get('/seller/dashboard', fn() => view('dashboards.seller'))->name('seller.dashboard');

            // Seller placeholder routes
            Route::view('/seller/orders', 'seller.orders.index')->name('seller.orders.index');
            Route::view('/seller/products', 'seller.products.index')->name('seller.products.index');
            Route::view('/seller/products/create', 'seller.products.create')->name('seller.products.create');
            Route::view('/seller/inventory', 'seller.inventory.index')->name('seller.inventory.index');
            Route::view('/seller/payouts', 'seller.payouts.index')->name('seller.payouts.index');
            Route::view('/seller/settings', 'seller.settings.index')->name('seller.settings');
        });

        Route::middleware(RoleMiddleware::class . ':admin')->group(function () {
            Route::get('/admin/dashboard', fn() => view('dashboards.admin'))->name('admin.dashboard');
        });
    });
