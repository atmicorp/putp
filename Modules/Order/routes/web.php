<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\Admin\OrderController as AdminOrderController;
use Modules\Order\Http\Controllers\Guest\OrderController as GuestOrderController;

Route::middleware(['web', 'auth'])->prefix('admin')->group(function () {
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/create', [AdminOrderController::class, 'create'])->name('admin.orders.create');
    Route::post('/orders', [AdminOrderController::class, 'store'])->name('admin.orders.store');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::post('/orders/{order}/send-offer', [AdminOrderController::class, 'sendOffer'])->name('admin.orders.sendOffer');
});

// Guest route (tanpa login)
Route::middleware(['web', 'throttle:30,1'])->group(function () {
    Route::get('/orders/{slug}/{token}',
        [GuestOrderController::class, 'show'])->name('orders.guest.show');

    Route::post('/orders/{slug}/{token}/approve',
        [GuestOrderController::class, 'approve'])->name('orders.guest.approve');

    Route::post('/orders/{slug}/{token}/reject',
        [GuestOrderController::class, 'reject'])->name('orders.guest.reject');
});
