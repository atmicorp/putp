<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeController;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('/logout', function (Logout $logout) {
    $logout();
    return redirect('/');
})->middleware('auth')->name('logout');

require __DIR__.'/auth.php';
