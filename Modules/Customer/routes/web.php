<?php

use Illuminate\Support\Facades\Route;
use Modules\Customer\Http\Controllers\CustomerController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('customers', CustomerController::class)
        ->names('customer')
        ->parameters(['customers' => 'company']);
});
Route::get('/signature/{filename}', function ($filename) {
    $path = storage_path('app/private/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})
->where('filename', '.*') // ⬅️ WAJIB
->name('signature.show');