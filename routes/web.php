<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Đăng nhập, đăng ký, đăng xuất
Auth::routes();

//Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// User xem giỏ hàng
Route::get('/bought', [ProductController::class, 'bought'])->name('bought');

// Admin xem các đơn hàng
Route::get('/order', [HomeController::class, 'orders'])->name('order');
    // Đã xác nhận
    Route::get('/confirm', [HomeController::class, 'confirm'])->name('order.confirm');
    // Đã vận chuyển
    Route::get('/ship', [HomeController::class, 'ship'])->name('order.ship');
    // Đã hủy
    Route::get('/cancel', [HomeController::class, 'cancel'])->name('order.cancel');


// Sản phẩm
    // UI SẢN PHẨM
    Route::resource('/product', ProductController::class)
        ->except('update', 'destroy');

    // Sửa
    Route::post('/product/{product}', [ProductController::class, 'update'])
        ->name('product.update');

    // Xóa
    Route::get('/product/{product}/delete', [ProductController::class, 'destroy'])
        ->name('product.delete');

    // Tăng giảm xóa số lượng
    Route::post('/product/{product}/number', [ProductController::class, 'number'])
        ->name('product.number');
    
    // Mua hàng
    Route::post('/product/{order}/shop', [ProductController::class, 'shop'])
        ->name('product.shop');

