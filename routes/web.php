<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminAuthController;

Route::get('/_cookie-check', function () {
    return response('ok')->header('Set-Cookie', 'laundry_probe=ready; Path=/');
});

Route::get('/order/create', function () {
    return redirect()->route('order.create');
});
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/order', [HomeController::class, 'create'])->name('order.create');
Route::post('/order', [HomeController::class, 'store'])->name('order.store');
Route::get('/order/{order}/success', [HomeController::class, 'success'])->name('order.success');
Route::get('/track', [HomeController::class, 'trackForm'])->name('order.track');
Route::post('/track', [HomeController::class, 'trackSearch'])->name('order.track.search');

// Halaman Admin
Route::name('admin.')->prefix('admin')->group(function () {
    // Rute Guest (Tanpa Login)
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Rute Terproteksi (Wajib Login)
    Route::middleware(['admin.auth'])->group(function () {
        Route::get('/dashboard', [OrderController::class, 'index'])->name('dashboard');
        Route::resource('orders', OrderController::class)->except(['create', 'store']);
        Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
        Route::get('orders/{order}/payment-proof', [PaymentController::class, 'showProof'])->name('orders.payment-proof');
    });
});

