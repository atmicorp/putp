<?php

use Illuminate\Support\Facades\Route;
use Modules\Machine\Http\Controllers\MachineController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('machines', MachineController::class)->names('machine');
});
