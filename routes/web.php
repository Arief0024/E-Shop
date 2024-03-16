<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardProductController;
use App\Http\Controllers\DashboardTransactionController;
use App\Http\Controllers\DashboardSettingController;
use App\Http\Controllers\CheckoutController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get ('/',  [HomeController::class, 'index'])->name('home');

Route::get ('/categories',  [CategoryController::class, 'index'])->name('categories');
Route::get ('/categories/{id}',  [CategoryController::class, 'detail'])->name('categories-detail');

Route::get('/details/{id}',  [DetailController::class, 'index'])->name('detail');
Route::post('/details/{id}',  [DetailController::class, 'add'])->name('detail-add');

Route::get('/success',  [CartController::class, 'success'])->name('success');

Route::get('/checkout/callback',  [CheckoutController::class, 'callback'])->name('midtrans-callback');

Route::get('/register/success',  [RegisterController::class, 'success'])->name('register-success');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/cart',  [CartController::class, 'index'])->name('cart');
    Route::delete('/cart/{id}',  [CartController::class, 'delete'])->name('cart-delete');

    Route::post('/checkout',  [CheckoutController::class, 'process'])->name('checkout');

    Route::get('/dashboard',  [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/product',  [DashboardProductController::class, 'index'])
        ->name('dashboard-product');
    Route::get('/dashboard/product/create',  [DashboardProductController::class, 'create'])
        ->name('dashboard-product-create');

    Route::POST('/dashboard/product',  [DashboardProductController::class, 'store'])
        ->name('dashboard-product-store');

    Route::get('/dashboard/product/{id}',  [DashboardProductController::class, 'detail'])
        ->name('dashboard-product-detail');
    Route::post('/dashboard/transaction/{id}',  [DashboardTransactionController::class, 'update'])
    ->name('dashboard-transaction-update');

    Route::get('/dashboard/transaction',  [DashboardTransactionController::class, 'index'])
        ->name('dashboard-transaction');
    Route::get('/dashboard/transaction/{id}',  [DashboardTransactionController::class, 'detail'])
        ->name('dashboard-transaction-detail');
    Route::post('/dashboard/product/{id}',  [DashboardProductController::class, 'update'])
        ->name('dashboard-product-update');

    Route::post('/dashboard/product/gallery/upload',  [DashboardProductController::class, 'uploadGallery'])
        ->name('dashboard-product-gallery-upload');
    Route::get('/dashboard/product/gallery/delete/{id}',  [DashboardProductController::class, 'deleteGallery'])
        ->name('dashboard-product-gallery-delete');

    Route::get('/dashboard/setting',  [DashboardSettingController::class, 'store'])
        ->name('dashboard-setting-store');
    Route::get('/dashboard/account',  [DashboardSettingController::class, 'account'])
        ->name('dashboard-setting-account');
    Route::post('/dashboard/account/{redirect}',  [DashboardSettingController::class, 'update'])
        ->name('dashboard-setting-redirect');
});

Route::prefix('admin')
    // ->middleware(['auth','admin'])
    ->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin-dashboard');
        Route::resource('category', App\Http\Controllers\Admin\CategoryControllers::class);
        Route::resource('user', App\Http\Controllers\Admin\UserController::class);
        Route::resource('product', App\Http\Controllers\Admin\ProductController::class);
        Route::resource('product-gallery', App\Http\Controllers\Admin\ProductGalleryController::class);
    });

Auth::routes();