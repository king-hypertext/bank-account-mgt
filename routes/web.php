<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'login'])->name('login'); 
Route::post('login', [AuthController::class, 'authenticate'])->name('authenticate');

Route::middleware(['auth'])->group(function () {
    Route::permanentRedirect('/', 'accounts');
    Route::get('l', [AppController::class, 'index'])->name('l.list');
    Route::get('l/create', [AppController::class, 'createLocation'])->name('l.create');
    Route::get('l/store', [AppController::class, 'storeLocation'])->name('l.store');
    Route::prefix('l/{location}')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('account.home');
        Route::get('entries', [AccountController::class, 'index'])->name('account.entries');
        Route::get('transfers', [AccountController::class, 'index'])->name('account.transfers');
    });
});
