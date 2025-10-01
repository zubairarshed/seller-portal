<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seller\RegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Admin\SellerApplicationController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Seller\ProductApplicationController as SellerProductApplicationController;
use App\Http\Controllers\Admin\ProductApplicationController as AdminProductApplicationController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Seller\NotificationController;
// use Illuminate\Support\Facades\App;
// use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Route::get('lang/{locale}', function ($locale) {
//     if (in_array($locale, ['en', 'zh'])) {
//         Session::put('locale', $locale);
//         App::setLocale($locale);
//     }

//     return redirect()->back();
// })->name('lang.switch');

Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead']) // ✅
     ->name('notifications.read');

Route::get('/', [HomeController::class, 'index'])->name('home');    // ✅

// Cart
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');   // ✅
    Route::post('add/{product}', [CartController::class, 'add'])->name('add');  // ✅
    Route::patch('update/{id}', [CartController::class, 'update'])->name('update'); // ✅
    Route::delete('remove/{id}', [CartController::class, 'remove'])->name('remove');    // ✅
});

// Checkout & Orders
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [OrderController::class, 'create'])->name('index'); // ✅
    Route::post('/', [OrderController::class, 'store'])->name('store'); // ✅
});
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show'); // ✅

// Auth
Route::get('/login', [AuthController::class, 'create'])->name('login'); // ✅
Route::post('/login', [AuthController::class, 'store'])->name('login.submit');  // ✅
Route::delete('/logout', [AuthController::class, 'destroy'])->name('logout'); // ✅


/*
|--------------------------------------------------------------------------
| Seller Routes
|--------------------------------------------------------------------------
*/
Route::prefix('seller')->name('seller.')->group(function () {
    // Seller Registration (public)
    Route::get('/register', [RegistrationController::class, 'create'])->name('register');   // ✅
    Route::post('/register', [RegistrationController::class, 'store'])->name('register.store'); // ✅

    // Protected Seller Routes
    Route::middleware(['auth', 'role:seller'])->group(function () {
        Route::get('dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');    // ✅

        // Product Applications
        Route::resource('products', SellerProductApplicationController::class)  // ✅
            ->names('product_applications')
            ->parameters(['products' => 'productApplication']);

        // Orders
        Route::get('orders', [SellerOrderController::class, 'index'])->name('orders.index');    // ✅

        // Payouts
        Route::get('payouts', [App\Http\Controllers\Seller\PayoutController::class, 'index'])   // ✅
            ->name('payouts.index');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard'); // ✅

    // Seller Applications
    Route::prefix('seller-applications')->name('seller_applications.')->group(function () {
        Route::get('/', [SellerApplicationController::class, 'index'])->name('index');  // ✅
        Route::post('{id}/approve', [SellerApplicationController::class, 'approve'])->name('approve');  // ✅
        Route::delete('{id}/reject', [SellerApplicationController::class, 'reject'])->name('reject');   // ✅
    });

    // Sellers
    Route::get('sellers/delete', [SellerController::class, 'deleteList'])->name('seller_delete');   // ✅
    Route::delete('seller/{seller}', [SellerController::class, 'destroy'])->name('seller_destroy'); // ✅

    // Product Applications
    Route::get('product-applications', [AdminProductApplicationController::class, 'index'])->name('product_applications.index'); // ✅
    Route::get('product-applications/{id}', [AdminProductApplicationController::class, 'show'])->name('product_applications.show'); // ✅
    Route::post('product-applications/{id}/approve', [AdminProductApplicationController::class, 'approve'])->name('product_applications.approve'); // ✅  
    Route::post('product-applications/{id}/reject', [AdminProductApplicationController::class, 'reject'])->name('product_applications.reject'); // ✅
    Route::get('product-applications/{id}/edit', [AdminProductApplicationController::class, 'edit'])->name('product_applications.edit'); // ✅
    Route::put('product-applications/{id}', [AdminProductApplicationController::class, 'update'])->name('product_applications.update'); // ✅

    // Approved Products
    Route::get('products', [ProductController::class, 'index'])->name('products.index'); // ✅

    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index'); // ✅
        Route::get('{order}', [AdminOrderController::class, 'show'])->name('show'); // ✅
        Route::patch('{order}/cancel', [AdminOrderController::class, 'cancel'])->name('cancel'); // ✅
        Route::patch('{order}/refund', [AdminOrderController::class, 'refund'])->name('refund'); // ✅
        Route::patch('{order}/complete', [AdminOrderController::class, 'complete'])->name('complete'); // ✅
    });

    // Payouts
    Route::prefix('payouts')->name('payouts.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\PayoutController::class, 'index'])->name('index'); // ✅
        Route::post('{seller}/pay', [App\Http\Controllers\Admin\PayoutController::class, 'pay'])->name('pay'); // ✅
        Route::get('export/csv', [App\Http\Controllers\Admin\PayoutController::class, 'exportCsv'])->name('export.csv'); // ✅
        Route::get('export/pdf', [App\Http\Controllers\Admin\PayoutController::class, 'exportPdf'])->name('export.pdf'); // ✅
    });
});