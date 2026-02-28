<?php

use Illuminate\Support\Facades\Route;
use Modules\Machine\Http\Controllers\MachineController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('machines', MachineController::class)->names('machine');
});
