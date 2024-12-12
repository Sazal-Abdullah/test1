<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\POSController;




// Route::get('/', function () {
//     return view('welcome');
// });





Route::get('/', [HomeController::class, 'index'])->name('home');


// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin dashboard
// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
// });



Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    // routes/web.php


    Route::resource('products', ProductController::class);

    // Route::prefix('pos')->group(function () {
    //     Route::get('/', [POSController::class, 'index'])->name('pos.index'); // POS page
    //     Route::post('/cart', [POSController::class, 'addToCart'])->name('pos.cart.add'); // Add to cart
    //     Route::post('/order', [POSController::class, 'placeOrder'])->name('pos.order.place'); // Place order
    //     Route::get('/orders', [POSController::class, 'orderList'])->name('pos.orders.list'); // Order list
    // });


});




