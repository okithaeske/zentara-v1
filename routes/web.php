<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Seller\InventoryController as SellerInventoryController;
use App\Http\Controllers\Seller\PayoutController as SellerPayoutController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SellerController as AdminSellerController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\ProductController as PublicProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;

Route::view('/', 'welcome')->name('welcome');
Route::view('/home', 'pages.home')->name('home');

// Public pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');

// Public products
Route::get('/products', [PublicProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [PublicProductController::class, 'show'])->name('products.show');

// Cart (session-based) - disallow admins
Route::get('/cart', [CartController::class, 'index'])->middleware('disallow-admin-shopping')->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->middleware('disallow-admin-shopping')->name('cart.add');
Route::patch('/cart/update/{product}', [CartController::class, 'update'])->middleware('disallow-admin-shopping')->name('cart.update');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->middleware('disallow-admin-shopping')->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->middleware('disallow-admin-shopping')->name('cart.clear');

// Checkout
Route::middleware(['auth','disallow-admin-shopping'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
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

        // Allow both sellers and admins to access seller area (useful for admin support)
        Route::middleware('role:seller,admin')->group(function () {
            Route::get('/seller/dashboard', [SellerDashboardController::class, 'index'])->name('seller.dashboard');

            // Seller routes
            Route::get('/seller/orders', [SellerOrderController::class, 'index'])->name('seller.orders.index');
            Route::get('/seller/orders/{order}', [SellerOrderController::class, 'show'])->name('seller.orders.show');
            Route::resource('/seller/products', SellerProductController::class)->names('seller.products');
            Route::get('/seller/inventory', [SellerInventoryController::class, 'index'])->name('seller.inventory.index');
            Route::get('/seller/payouts', [SellerPayoutController::class, 'index'])->name('seller.payouts.index');
            Route::view('/seller/settings', 'seller.settings.index')->name('seller.settings');
        });

        Route::middleware('role:admin')->group(function () {
            Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
            Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
            Route::patch('/admin/users/{user}/toggle-ban', [AdminUserController::class, 'toggleBan'])->name('admin.users.toggle-ban');
            Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

            // Sellers listing and their products
            Route::get('/admin/sellers', [AdminSellerController::class, 'index'])->name('admin.sellers.index');
            Route::get('/admin/sellers/{seller}/products', [AdminSellerController::class, 'products'])->name('admin.sellers.products');

            // Admin product moderation
            Route::patch('/admin/products/{product}/status', [AdminProductController::class, 'updateStatus'])->name('admin.products.update-status');
            Route::delete('/admin/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
        });
    });
