<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\POSController;





// Route::prefix('pos')->middleware(['auth'])->group(function () {
//     Route::get('/', [POSController::class, 'index'])->name('pos.index'); // POS page
//     Route::post('/order', [POSController::class, 'placeOrder'])->name('pos.order.place'); // Place order
//     Route::get('/orders', [POSController::class, 'orderList'])->name('pos.orders.list'); // Order list

//     Route::post('/pos/cart/add', [POSController::class, 'addToCart'])->name('pos.cart.add');
//     Route::post('/pos/cart/update', [POSController::class, 'updateCart'])->name('pos.cart.update');
//     Route::post('/pos/cart/remove', [POSController::class, 'removeFromCart'])->name('pos.cart.remove');


// });


Route::prefix('pos')->middleware(['auth'])->group(function () {
    Route::get('/', [POSController::class, 'index'])->name('pos.index'); // POS page
    Route::post('/cart/add', [POSController::class, 'addToCart'])->name('pos.cart.add'); // Add to Cart
    Route::post('/cart/update', [POSController::class, 'updateCart'])->name('pos.cart.update'); // Update Cart
    Route::post('/cart/remove', [POSController::class, 'removeFromCart'])->name('pos.cart.remove'); // Remove from Cart
    Route::post('/order', [POSController::class, 'placeOrder'])->name('pos.order.place'); // Place Order
    Route::get('/orders', [POSController::class, 'orderList'])->name('pos.orders.list'); // Order List

    Route::post('/cart/update-quantity', [POSController::class, 'updateCartQuantity'])->name('pos.cart.updateQuantity');
    Route::post('/cart/remove', [POSController::class, 'removeCartItem'])->name('pos.cart.remove');

    Route::post('/order/create', [POSController::class, 'createOrder'])->name('pos.order.create');
    Route::get('/order/confirmation', [POSController::class, 'orderConfirmation'])->name('pos.order.confirmation');
    // Route::get('/orders', [OrderController::class, 'orderList'])->name('pos.order.list');





});
