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
// Admin xem hàng
Route::get('/shipping', [HomeController::class, 'shipping'])->name('shipping');
//
Route::get('/shipped', [HomeController::class, 'shipped'])->name('shipped');
// Sản phẩm
    Route::resource('/product', ProductController::class)->except('update', 'destroy');
    //Sửa
    Route::post('/product/{product}', [ProductController::class, 'update'])->name('product.update');
    // Xóa
    Route::get('/product/{product}/delete', [ProductController::class, 'destroy'])->name('product.delete');
    // Tăng giảm số lượng
    Route::post('/product/{product}/number', [ProductController::class, 'number'])->name('product.number');
    //  Mua hàng
    Route::post('/product/{user}/shop', [ProductController::class, 'shop'])->name('product.shop');
    // Xem hàng đã mua
    Route::get('/bought', [ProductController::class, 'bought'])->name('product.bought');



