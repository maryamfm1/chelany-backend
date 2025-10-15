<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\MenuItemController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\PaymentController;
 use config\createOrder;


// Payment create API route (api.php me hi rahega)
Route::post('/create-payment', [PaymentController::class, 'createPayment'])->name('payment.create');
//Route::post('/create-order', [create-order::class, 'createOrder'])->name('order.create');

// Order related routes
Route::post('/orders', [OrderController::class, 'store']);              // Order place karne ke liye
Route::get('/order-status/{order_id}', [OrderStatusController::class, 'show']);   // Order status check karne ke liye
Route::post('/cancel-order', [OrderStatusController::class, 'cancel']);            // Order cancel karne ke liye

// Reservation route
Route::post('/reservations', [ReservationController::class, 'store']);

// Menu routes
Route::get('/menu', [MenuController::class, 'index']);

// Resource routes
Route::apiResource('categories', CategoryController::class);
Route::apiResource('menu-items', MenuItemController::class);
