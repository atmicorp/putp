<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Modules\User\Http\Controllers\UserController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('users', UserController::class);

    // Route untuk serve file tanda tangan (private)
    Route::get('/signatures/{user}', function (User $user) {
        if (!auth()->user()->isAdmin() && auth()->id() !== $user->id) {
            abort(403);
        }

        if (!$user->signature_path || !Storage::disk('private')->exists($user->signature_path)) {
            abort(404);
        }

        return response()->file(
            Storage::disk('private')->path($user->signature_path)
        );
    })->name('signature.show');
});