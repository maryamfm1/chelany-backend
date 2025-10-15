<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Controllers
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\MenuItemController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Api\SettingController;

Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);
// Models (agar zarurat ho to)
use App\Models\Setting;
Route::delete('/orders/{order_id}', [OrderController::class, 'destroy']);

// Online Order Setting routes - ab controller use kar rahe hain
Route::post('/settings/online-order', [SettingController::class, 'updateOnlineOrderStatus']);
Route::get('/settings/online-order', [SettingController::class, 'getOnlineOrderStatus']);  // optional

// Admin login
Route::post('/admin/login', [AdminAuthController::class, 'login']);

// Orders routes (Admin ke liye)
Route::get('/orders', [OrderController::class, 'index']);                         // Sab orders fetch karne ke liye
Route::post('/orders/{order_id}/status', [OrderController::class, 'updateStatus']);  // Status update karne ke liye

// Payment API
Route::post('/create-payment', [PaymentController::class, 'createPayment'])->name('payment.create');

// Order APIs
Route::post('/orders', [OrderController::class, 'store']);                         // Order place karne ke liye
Route::get('/order-status/{order_id}', [OrderStatusController::class, 'show']);   // Order status check karne ke liye
Route::post('/cancel-order', [OrderStatusController::class, 'cancel']);           // Order cancel karne ke liye

// Reservation routes
Route::post('/reservations', [ReservationController::class, 'store']);
Route::get('/reservations', [ReservationController::class, 'index']);

// Menu route
Route::get('/menu', [MenuController::class, 'index']);

// Resource routes for categories and menu-items
Route::apiResource('categories', CategoryController::class);
Route::apiResource('menu-items', MenuItemController::class);
