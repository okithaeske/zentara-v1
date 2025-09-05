<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\ProductController as PublicProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Http\Request;

Route::view('/', 'welcome')->name('welcome');
Route::view('/home', 'pages.home')->name('home');

// Public pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');

// Public products
Route::get('/products', [PublicProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [PublicProductController::class, 'show'])->name('products.show');

// Cart (session-based)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
});

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
        Route::get('/dashboard', function (Request $request) {
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
