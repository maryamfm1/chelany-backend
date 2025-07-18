<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

// Payment success and cancel routes (web.php me hone chahiye)
Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');

Route::get('/payment-cancel', function () {
    return response()->json(['message' => 'Payment cancelled']);
})->name('payment.cancel');

// Test email route
Route::get('/test-email', function () {
    Mail::raw('This is a test email from Chelany Mitte Restaurant backend.', function ($message) {
        $message->to('maryamwaraich498@gmail.com') // apna email yahan lagao
                ->subject('Test Email');
    });

    return 'Test email sent!';
});
