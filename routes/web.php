<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BoardingHouseController;
use App\Http\Controllers\BookingController; // <--- SAYA TAMBAHKAN INI
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// 1. Redirect Home ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. DASHBOARD & FITUR UTAMA
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.show');
    Route::get('/city/{slug}', [HomeController::class, 'city'])->name('city.show');
    Route::get('/details/{slug}', [BoardingHouseController::class, 'show'])->name('kos.show');

    Route::get('/my-favorites', [HomeController::class, 'favorites'])->name('my-favorites');
    Route::get('/my-orders', [DashboardController::class, 'orders'])->name('my-orders');

    // Route Toggle Wishlist
    Route::post('/kos/{slug}/toggle-wishlist', [BoardingHouseController::class, 'toggleWishlist'])->name('boarding-house.toggle-wishlist');

    // Route Booking
    Route::get('/booking/{slug}', [HomeController::class, 'check_booking'])->name('booking.check');
    Route::post('/check-booking/{slug}', [HomeController::class, 'check_booking_store'])->name('check-booking.show');
    
    Route::get('/booking/information/{slug}', [HomeController::class, 'booking_information'])->name('booking.information');
    Route::post('/booking/information/{slug}', [HomeController::class, 'booking_information_store'])->name('booking.information.store');
    
    Route::get('/checkout/{slug}', [HomeController::class, 'checkout'])->name('checkout');

    // 🔥🔥 INI PERBAIKANNYA 🔥🔥
    // Sekarang tombol Pay Now akan masuk ke BookingController::payment (yang kodenya sudah benar)
    Route::post('/checkout/{slug}', [HomeController::class, 'checkout_store'])->name('checkout.store');
    
    Route::get('/payment/success', [HomeController::class, 'payment_success'])->name('payment.success');
});

// 3. PROFILE ROUTES
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 4. PAYMENT & CALLBACK
Route::middleware(['auth'])->group(function () {
    Route::get('/payment/{transaction}', [PaymentController::class, 'pay'])->name('payment.pay');
    Route::get('/payment/success/{transaction}', [PaymentController::class, 'success'])->name('payment.success');
});

Route::post('/midtrans/callback', [PaymentController::class, 'notification']);

require __DIR__.'/auth.php';