<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seller\RegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Admin\SellerApplicationController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Seller\ProductApplicationController as SellerProductApplicationController;
use App\Http\Controllers\Admin\ProductApplicationController as AdminProductApplicationController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;


Route::get('/', [HomeController::class, 'index'])->name('home');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Seller routes
Route::prefix('seller')->name('seller.')->group(function () {
    // Registration
    Route::get('/register', [RegistrationController::class, 'create'])->name('register');
    Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');
});

// Seller routes (middleware: auth:seller)
Route::prefix('seller')->name('seller.')->middleware(['auth'])->group(function () {
    Route::get('products', [SellerProductApplicationController::class, 'index'])->name('product_applications.index');   // list seller's applications
    Route::get('products/create', [SellerProductApplicationController::class, 'create'])->name('product_applications.create'); // form
    Route::post('products', [SellerProductApplicationController::class, 'store'])->name('product_applications.store'); // save new application
    Route::get('products/{productApplication}', [SellerProductApplicationController::class, 'show'])->name('product_applications.show');
    Route::get('products/{productApplication}/edit', [SellerProductApplicationController::class, 'edit'])->name('product_applications.edit'); // edit pending/rejected
    Route::put('products/{productApplication}', [SellerProductApplicationController::class, 'update'])->name('product_applications.update');
    Route::delete('products/{productApplication}', [SellerProductApplicationController::class, 'destroy'])->name('product_applications.destroy');

    // Orders
    Route::get('orders', [Seller\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [Seller\OrderController::class, 'show'])->name('orders.show');
});

// Seller dashboard (protected route)
Route::middleware(['auth'])->group(function () {
    Route::get('seller/dashboard', function () {
        return view('seller.dashboard');
    })->name('seller.dashboard');
});
// Admin dashboard (protected route)
Route::middleware(['auth'])->group(function () {
    Route::get('admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/seller-applications', [SellerApplicationController::class, 'index'])->name('seller_applications.index');
    Route::post('/seller-applications/{id}/approve', [SellerApplicationController::class, 'approve'])->name('seller_applications.approve');
    Route::delete('/seller-applications/{id}/reject', [SellerApplicationController::class, 'reject'])->name('seller_applications.reject');
    // Show list of sellers for deletion
    Route::get('/sellers/delete', [SellerController::class, 'deleteList'])->name('seller_delete');
    // Delete a specific seller
    Route::delete('/seller/{seller}', [SellerController::class, 'destroy'])->name('seller_destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('product-applications', [AdminProductApplicationController::class, 'index'])->name('product_applications.index');
    Route::get('product-applications/{id}', [AdminProductApplicationController::class, 'show'])->name('product_applications.show');
    Route::post('product-applications/{id}/approve', [AdminProductApplicationController::class, 'approve'])->name('product_applications.approve');
    Route::post('product-applications/{id}/reject', [AdminProductApplicationController::class, 'reject'])->name('product_applications.reject');
    Route::get('product-applications/{id}/edit', [AdminProductApplicationController::class, 'edit'])->name('product_applications.edit');
    Route::put('product-applications/{id}', [AdminProductApplicationController::class, 'update'])->name('product_applications.update');

    // approved products
    Route::get('products', [ProductController::class, 'index'])->name('products.index');

    // Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/cancel', [AdminOrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('orders/{order}/refund', [AdminOrderController::class, 'refund'])->name('orders.refund');
});


Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');