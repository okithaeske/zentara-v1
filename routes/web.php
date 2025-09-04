<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use Illuminate\Http\Request;

Route::view('/', 'welcome')->name('welcome');
Route::view('/home', 'pages.home')->name('home');

// Public pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');

// Contact form submission
use App\Http\Controllers\ContactController;
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');

// routes/web.php
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), ])
    ->group(function () {
        // Quick test route to verify email sending (logs in dev)
        Route::get('/test-email', function (Request $request) {
            $user = $request->user();
            Mail::raw('This is a test email from ' . config('app.name'), function ($m) use ($user) {
                $m->to($user->email, $user->name)->subject('Test Email');
            });

            return 'Test email dispatched. Check your mail delivery or storage/logs/laravel.log if MAIL_MAILER=log (default).';
        })->name('test-email');

        // Role-aware dashboard redirect
        Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
            $user = $request->user();
            if (!$user) {
                return redirect()->route('welcome');
            }
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'seller' => redirect()->route('seller.dashboard'),
                default => redirect()->route('home'),
            };
        })->name('dashboard');

        Route::middleware(RoleMiddleware::class . ':seller')->group(function () {
            Route::get('/seller/dashboard', fn() => view('dashboards.seller'))->name('seller.dashboard');

            // Seller routes
            Route::view('/seller/orders', 'seller.orders.index')->name('seller.orders.index');
            Route::resource('/seller/products', SellerProductController::class)->names('seller.products');
            Route::view('/seller/inventory', 'seller.inventory.index')->name('seller.inventory.index');
            Route::view('/seller/payouts', 'seller.payouts.index')->name('seller.payouts.index');
            Route::view('/seller/settings', 'seller.settings.index')->name('seller.settings');
        });

        Route::middleware(RoleMiddleware::class . ':admin')->group(function () {
            Route::get('/admin/dashboard', fn() => view('dashboards.admin'))->name('admin.dashboard');
        });
    });
