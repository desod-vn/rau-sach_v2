<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CommentController;

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

// Thông tin
Route::get('/about', [CommentController::class, 'index'])->name('about');

    // Bình luận
    Route::post('/about', [CommentController::class, 'store'])->name('about.comment');

    // Xóa bình luận
    Route::get('/about/{comment}', [CommentController::class, 'destroy'])->name('about.delete');

// User xem các đơn hàng
Route::get('/bought', [ProductController::class, 'bought'])->name('bought');

// Admin xem các đơn hàng
Route::get('/shipping', [HomeController::class, 'shipping'])->name('shipping');
    // Giao hàng thành công
    Route::get('/shipped', [HomeController::class, 'shipped'])->name('shipped');



// Sản phẩm
    Route::resource('/product', ProductController::class)->except('update', 'destroy');
    // Sửa
    Route::post('/product/{product}', [ProductController::class, 'update'])->name('product.update');
    // Xóa
    Route::get('/product/{product}/delete', [ProductController::class, 'destroy'])->name('product.delete');
    // Tăng giảm số lượng
    Route::post('/product/{product}/number', [ProductController::class, 'number'])->name('product.number');
    // Mua hàng
    Route::post('/product/{user}/shop', [ProductController::class, 'shop'])->name('product.shop');



