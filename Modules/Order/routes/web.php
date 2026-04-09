<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\Admin\OrderController as AdminOrderController;
use Modules\Order\Http\Controllers\Guest\OrderController as GuestOrderController;

Route::middleware(['web', 'auth'])->prefix('admin')->group(function () {
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/create', [AdminOrderController::class, 'create'])->name('admin.orders.create');
    Route::post('/orders', [AdminOrderController::class, 'store'])->name('admin.orders.store');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::get('/orders/{order}/edit', [AdminOrderController::class, 'edit'])->name('admin.orders.edit');
    Route::put('/orders/{order}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
    Route::post('/orders/{order}/notify-internal', [AdminOrderController::class, 'notifyInternal'])->name('admin.orders.notifyInternal');
    Route::post('/orders/{order}/send-offer', [AdminOrderController::class, 'sendOffer'])->name('admin.orders.sendOffer');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
     ->name('admin.orders.updateStatus');
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

Route::post('companies/quick-create', [AdminOrderController::class, 'quickCreateCompany'])->name('admin.companies.quick-create');
Route::post('contacts/quick-create',  [AdminOrderController::class, 'quickCreateContact']) ->name('admin.contacts.quick-create');


/*
|--------------------------------------------------------------------------
| Guest Order Routes (tidak perlu login)
|--------------------------------------------------------------------------
*/
Route::prefix('order')->name('orders.guest.')->group(function () {
 
    // Halaman keranjang utama
    Route::get('/keranjang', [GuestOrderController::class, 'index'])
        ->name('cart');
 
    // API: validasi token & ambil data order
    Route::post('/keranjang/validate-token', [GuestOrderController::class, 'validateToken'])
        ->name('validate-token');
 
    // API: submit pilihan package
    Route::post('/keranjang/submit', [GuestOrderController::class, 'submit'])
        ->name('submit');
 
    // Halaman status order (lihat progres)
    Route::get('/status', [GuestOrderController::class, 'statusForm'])
        ->name('status.form');

    Route::post('/status/lookup', [GuestOrderController::class, 'statusLookup'])
        ->name('status.lookup');
 
});
