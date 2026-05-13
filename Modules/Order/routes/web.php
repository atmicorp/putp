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

    Route::patch('orders/{order}/execution', [AdminOrderController::class, 'updateExecution'])
    ->name('orders.update-execution');

    // Hasil Uji Files
    Route::post('/orders/{order}/hasil-uji',                    [AdminOrderController::class, 'storeHasilUji'])    ->name('admin.orders.hasil-uji.store');
    Route::get('/orders/{order}/hasil-uji/{file}',              [AdminOrderController::class, 'showHasilUji'])     ->name('admin.orders.hasil-uji.show');
    Route::get('/orders/{order}/hasil-uji/{file}/download',     [AdminOrderController::class, 'downloadHasilUji']) ->name('admin.orders.hasil-uji.download');
    Route::delete('/orders/{order}/hasil-uji/{file}',           [AdminOrderController::class, 'destroyHasilUji'])  ->name('admin.orders.hasil-uji.destroy');

});

// Guest route (tanpa login)
Route::middleware(['web', 'throttle:30,1'])->group(function () {
    Route::get('/orders/{slug}/{token}/permohonan-kerjasama', [GuestOrderController::class, 'PermohonanKerjasama'])->name('orders.guest.permohonan_kerjasama');
    Route::get('/orders/{slug}/{token}/perjanjian-kerjasama', [GuestOrderController::class, 'PerjanjianKerjasama'])->name('orders.guest.perjanjian_kerjasama');
    Route::get('/orders/{slug}/{token}/kesanggupan-kerjasama', [GuestOrderController::class, 'KesanggupanKerjasama'])->name('orders.guest.kesanggupan_kerjasama');
    Route::get('/orders/{slug}/{token}/bap', [GuestOrderController::class, 'bap'])->name('orders.guest.bap');
    Route::get('/orders/{slug}/{token}/laporan-kegiatan', [GuestOrderController::class, 'LaporanKegiatanKerjasama'])->name('orders.guest.laporan_kegiatan');
    Route::get('/orders/{slug}/{token}/hasil-uji/{file}/download', [GuestOrderController::class, 'downloadHasilUji'])
    ->name('orders.guest.hasil-uji.download');

    // Taruh show SETELAH route dokumen
    Route::get('/orders/{slug}/{token}', [GuestOrderController::class, 'show'])->name('orders.guest.show');
    Route::post('/orders/{slug}/{token}/approve', [GuestOrderController::class, 'approve'])->name('orders.guest.approve');
    Route::post('/orders/{slug}/{token}/reject', [GuestOrderController::class, 'reject'])->name('orders.guest.reject');
    Route::post('/orders/{slug}/{token}/sign', [GuestOrderController::class, 'sign'])->name('orders.guest.sign');
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
